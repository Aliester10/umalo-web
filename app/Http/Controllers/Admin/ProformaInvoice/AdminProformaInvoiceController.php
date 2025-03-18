<?php

namespace App\Http\Controllers\Admin\ProformaInvoice;

use App\Http\Controllers\Controller;
use App\Models\CompanyParameter;
use App\Models\ProformaInvoice;
use App\Models\ProformaInvoicePaymentProof;
use App\Models\PurchaseOrders;
use App\Models\QuotationProduct;
use App\Models\Quotations;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminProformaInvoiceController extends Controller
{

    public function index($id)
    {
        // Fetch the quotation with its associated approved purchase orders and their proforma invoices
        $quotation = Quotations::with([
            'purchaseOrders' => function ($query) {
                $query->whereIn('status', ['approved', 'close'])
                ->with('proformaInvoices.paymentProofs');
            }
        ])->findOrFail($id);
        
    
        // Fetch all payment proofs for proforma invoices belonging to this quotation
        $paymentProofs = ProformaInvoicePaymentProof::whereHas('proformaInvoice.purchaseOrder', function ($query) use ($id) {
            $query->where('quotation_id', $id);
        })->with(['proformaInvoice.purchaseOrder.user'])->get();
        
    
        return view('admin.proformainvoice.index', compact('quotation', 'paymentProofs'));
    }
    
    
    public function show($id){

        $proformaInvoice = ProformaInvoice::findOrFail($id);

        return view('admin.proformainvoice.show', compact('proformaInvoice'));
    }

    public function create($id)
    {
        $purchaseOrder = PurchaseOrders::with('quotation.products')->findOrFail($id);

        // Mengisi subtotal, ppn, dan grand_total_include_ppn berdasarkan data quotation
        $quotation = $purchaseOrder->quotation;
        $subtotal = $quotation->subtotal_price;
        $ppn = $quotation->ppn;
        $grandTotalIncludePPN = $quotation->total_after_discount + ($quotation->total_after_discount * ($ppn / 100));
        // Ambil data user terkait untuk mengisi vendor information
        $user = $purchaseOrder->user;

        // Mendapatkan daftar produk dari quotation_products
        $products = QuotationProduct::with('product')->where('quotation_id', $quotation->id)->get();


        // Kirim data ke view
        return view('admin.proformainvoice.create', compact(
            'purchaseOrder', 'subtotal', 'ppn', 'grandTotalIncludePPN', 'products', 'user'
        ));
    }

    public function store(Request $request, $purchaseOrderId)
    {
        $request->validate([
            'dp' => 'required|numeric|min:0|max:100', // Validasi DP sebagai persentase
            'vendor_name' => 'required|string',
            'vendor_address' => 'required|string',
            'vendor_phone' => 'required|string',
            'products' => 'required|array',
            'remakrs' => 'nullable|string',
        ]);

        $products = array_map(function ($product) {
            $product['unit_price'] = (float) str_replace(['Rp', '.', ','], ['', '', ''], $product['unit_price']);
            $product['total_price'] = (float) str_replace(['Rp', '.', ','], ['', '', ''], $product['total_price']);
            return $product;
        }, $request->products);
        
        
        $purchaseOrder = PurchaseOrders::with('quotation', 'user')->findOrFail($purchaseOrderId);
        $quotationId = $purchaseOrder->quotation->id; // Fetch the related Quotation ID

        // Ambil nomor terakhir dari Proforma Invoice
        $lastPiNumber = ProformaInvoice::max('id'); // Ambil ID terakhir sebagai dasar increment
        $nextPiNumber = str_pad($lastPiNumber + 1, 3, '0', STR_PAD_LEFT); // Format dengan leading zero (001, 002, ...)

        // Format PI Number untuk Database
        $piFormatted = sprintf("%s", $nextPiNumber); // Format sederhana, hanya angka increment

        // Ambil grand total dari quotation
        $grandTotalIncludePPN = $purchaseOrder->quotation->total_after_discount + ($purchaseOrder->quotation->total_after_discount * ($purchaseOrder->quotation->ppn / 100));

        // Hitung DP dalam nominal berdasarkan grand_total_include_ppn
        $dpPercent = $request->dp;
        $dpAmount = ($dpPercent / 100) * $grandTotalIncludePPN;
        // Ambil singkatan nama perusahaan dari user terkait
        $namaPerusahaan = $purchaseOrder->user->nama_perusahaan ?? 'Perusahaan';
        $singkatanNamaPerusahaan = strtoupper(implode('', array_filter(array_map(function ($kata) {
            return $kata !== 'PT' ? $kata[0] : ''; // Hindari "PT" dari singkatan
        }, explode(' ', $namaPerusahaan)))));

        // Gunakan tanggal hari ini untuk konversi angka Romawi dan tahun
        $today = now();
        $romanNumbers = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII', 'XIII', 'XIV', 'XV', 'XVI', 'XVII', 'XVIII', 'XIX', 'XX', 'XXI', 'XXII', 'XXIII', 'XXIV', 'XXV', 'XXVI', 'XXVII', 'XXVIII', 'XXIX', 'XXX', 'XXXI'];
        $tanggalRomawi = $romanNumbers[$today->day - 1];
        $tahun = $today->year;

        // Format Nomor PO dan PI dengan format yang diminta
        $poNumberFormatted = sprintf("%s/SPO/%s/%s/%s", $purchaseOrder->po_number, $singkatanNamaPerusahaan, $tanggalRomawi, $tahun);
        $piNumberFormatted = sprintf("%s/PI-UMALO-%s/%s/%s", $piFormatted, $singkatanNamaPerusahaan, $tanggalRomawi, $tahun);

        $subtotal = str_replace(['Rp', '.', ','], ['', '', ''], $request->subtotal); // Hapus format 'Rp', titik, dan koma
        $subtotal = (float) $subtotal; // Konversi ke angka desimal
        
        $ppn = str_replace('%', '', $request->ppn); // Hapus simbol '%'
        $ppn = (float) $ppn; // Konversi ke angka desimal


        $grandTotalIncludePPN = str_replace(['Rp', '.', ','], ['', '', ''], $request->grand_total_include_ppn); // Hapus format
        $grandTotalIncludePPN = (float) $grandTotalIncludePPN; // Konversi ke angka desimal
        $grandTotalAfterDP = $grandTotalIncludePPN - $dpAmount;

        // Buat Proforma Invoice
        $proformaInvoice = ProformaInvoice::create([
            'purchase_order_id' => $purchaseOrderId,
            'quotation_id' => $quotationId, // Assign the Quotation ID
            'pi_number' => $piFormatted,
            'subtotal' => $subtotal, // Gunakan nilai yang sudah dibersihkan
            'ppn' => $ppn, // Gunakan nilai yang sudah dibersihkan
            'grand_total_include_ppn' => $grandTotalIncludePPN, // Gunakan nilai yang sudah dibersihkan
            'dp' => $dpAmount, // Simpan nominal DP
            'grand_total_after_dp' => $grandTotalAfterDP,
            'status' => 'pending', // Default status
            'remarks' => $request->remarks,
            'is_viewed_admin' => true,
            'is_viewed_distributor' => false
        ]);


        

        $companyParameter = CompanyParameter::first(); // Ambil baris pertama pada tabel t_parameter

        // Generate PDF
        $pdf = PDF::loadView('admin.proformainvoice.pdf', [
            'proformaInvoice' => $proformaInvoice,
            'purchaseOrder' => $proformaInvoice->purchaseOrder,
            'vendorName' => $request->vendor_name,
            'vendorAddress' => $request->vendor_address,
            'vendorPhone' => $request->vendor_phone,
            'products' => $request->products,
            'dpPercent' => $dpPercent,  // Kirim $dpPercent ke view PDF
            'poNumberFormatted' => $poNumberFormatted,
            'piNumberFormatted' => $piNumberFormatted,
            'companyParameter' => $companyParameter, // Tambahkan ini
        ]);

        // Buat nama file PDF
        $filename = time() . '_' . Str::slug('Proforma_Invoice_' . $proformaInvoice->id) . '.pdf';
        $path = public_path('pdfs/' . $filename);

        // Pastikan folder penyimpanan ada
        if (!File::exists(public_path('pdfs'))) {
            File::makeDirectory(public_path('pdfs'), 0755, true);
        }

        // Simpan PDF ke path yang ditentukan
        $pdf->save($path);

        // Simpan path file di database
        $proformaInvoice->update(['file_path' => 'pdfs/' . $filename]);

        return redirect()->route('admin.quotations.index')
        ->with('success', 'Proforma Invoice created and PDF generated successfully.');
}


        public function update(Request $request, $id)
        {
            $request->validate([
                'status' => 'required|in:accepted,rejected',
                'admin_remarks' => 'required_if:status,rejected|max:500',
            ]);

            $proof = ProformaInvoicePaymentProof::findOrFail($id);
            $proof->status = $request->status;
            $proof->admin_remarks = $request->input('admin_remarks', null);
            $proof->is_viewed_admin = true;
            $proof->is_viewed_distributor = false;
            $proof->save();

            // If the payment proof is for "dp" and the status is "accepted"
            if ($proof->payment_type === 'dp' && $proof->status === 'accepted') {
                // Update related ProformaInvoice to "partially_paid"
                $proformaInvoice = $proof->proformaInvoice;
                $proformaInvoice->status = 'partially_paid';
                $proformaInvoice->save();
            }

            // If the payment proof is for "balance" and the status is "accepted"
            if ($proof->payment_type === 'balance' && $proof->status === 'accepted') {
                // Update related ProformaInvoice to "paid"
                $proformaInvoice = $proof->proformaInvoice;
                $proformaInvoice->status = 'paid';
                $proformaInvoice->save();

                // Update related PurchaseOrder to "close"
                $purchaseOrder = $proformaInvoice->purchaseOrder;
                $purchaseOrder->status = 'close';
                $purchaseOrder->save();

                // Check if all PurchaseOrders for the related Quotation are "close"
                $quotation = $purchaseOrder->quotation;
                if ($quotation->purchaseOrders()->where('status', '!=', 'close')->doesntExist()) {
                    $quotation->status = 'close';
                    $quotation->is_viewed_admin = false;
                    $quotation->is_viewed_distributor = false;
                    $quotation->save();
                }
            }

            return redirect()->back()->with('success', 'Status bukti pembayaran berhasil diperbarui.');
        }





}
