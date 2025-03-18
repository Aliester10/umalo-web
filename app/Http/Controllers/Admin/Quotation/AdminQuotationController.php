<?php

namespace App\Http\Controllers\Admin\Quotation;

use App\Http\Controllers\Controller;
use App\Models\CompanyParameter;
use App\Models\Product;
use App\Models\QuotationProduct;
use App\Models\Quotations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf; 


class AdminQuotationController extends Controller
{
    public function index()
    {
        $quotations = Quotations::orderByRaw("
                CASE 
                    WHEN status = 'pending' THEN 1
                    WHEN status = 'approved' THEN 2
                    WHEN status = 'rejected' THEN 3
                    ELSE 4
                END ASC
            ")
            ->orderBy('created_at', 'desc') // Data terbaru dalam setiap kategori status
            ->paginate(10);
    
        return view('admin.quotation.index', compact('quotations'));
    }
    

    public function show($id)
    {
        $quotation = Quotations::with(['user', 'negotiations', 'products'])->findOrFail($id);

        return view('admin.quotation.show', compact('quotation'));
    }

    public function edit($id)
    {
        $quotation = Quotations::with(['products', 'user'])->findOrFail($id);
        $products = Product::all(); // Semua produk yang tersedia untuk dipilih

        return view('admin.quotation.edit', compact('quotation', 'products'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'recipient_company' => 'required|string|max:255',
            'recipient_contact_person' => 'required|string|max:255',
            'quotation_date' => 'required|date',
            'discount' => 'nullable|numeric|min:0|max:100', // Diskon dalam persentase
            'ppn' => 'nullable|numeric|min:0|max:100',      // PPN dalam persentase
            'notes' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'signer_name' => 'nullable|string|max:255',
            'signer_position' => 'nullable|string|max:255',
            'authorized_person_signature' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'products.*.quantity' => 'required|integer|min:1', // Minimal 1
            'products.*.unit_price' => 'required|string',      // Unit price diformat sebagai string
            'products.*.product_id' => 'required|integer|exists:t_product,id', // Validasi produk ID
        ]);

        // Ambil quotation berdasarkan ID
        $quotation = Quotations::with('user')->findOrFail($id);

        // Generate nomor referensi
        $lastQuotationNumber = Quotations::max('id');
        $nextQuotationNumber = str_pad($lastQuotationNumber + 1, 3, '0', STR_PAD_LEFT);
        $companyName = $quotation->user->nama_perusahaan ?? 'Perusahaan';
        $companyInitials = strtoupper(implode('', array_map(fn($word) => $word[0], explode(' ', $companyName))));
        $romanDate = now()->format('j');
        $referenceNumber = sprintf("%s/SPPH/%s/%s/%s", $nextQuotationNumber, $companyInitials, $romanDate, now()->format('Y'));


        // Perhitungan subtotal
        $subtotal = 0;
        if ($request->has('products') && is_array($request->input('products'))) {
            foreach ($request->input('products') as $product) {
                $quantity = (int) $product['quantity'];
                $unitPrice = (float) str_replace('.', '', $product['unit_price']); // Hapus titik sebelum konversi ke angka
                $totalPrice = $quantity * $unitPrice; // Total harga untuk produk
                $subtotal += $totalPrice; // Tambahkan ke subtotal

                // Update atau buat baru produk terkait quotation
                QuotationProduct::updateOrCreate(
                    ['quotation_id' => $quotation->id, 'product_id' => $product['product_id']],
                    [
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'total_price' => $totalPrice,
                    ]
                );
            }
        }

        // Perhitungan total setelah diskon
        $discount = (float) $request->input('discount', 0) / 100; // Diskon dalam desimal
        $subTotalII = $subtotal - ($subtotal * $discount);

        // Perhitungan grand total setelah PPN
        $ppn = (float) $request->input('ppn', 0) / 100; // PPN dalam desimal
        $grandTotal = $subTotalII + ($subTotalII * $ppn);


        if ($request->hasFile('authorized_person_signature')) {
            $file = $request->file('authorized_person_signature');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('signatures'); // Direktori penyimpanan
            $file->move($destinationPath, $filename); // Simpan file ke direktori
            $authorized_person_signature = 'signatures/' . $filename; // Path yang akan disimpan ke database
        } else {
            $authorized_person_signature = $quotation->authorized_person_signature ?? null; // Jika tidak ada file baru
        }
        
        // Update data quotation
        $quotation->update([
            'recipient_company' => $request->input('recipient_company'),
            'recipient_contact_person' => $request->input('recipient_contact_person'),
            'quotation_date' => $request->input('created_at'),
            'status' => 'approved',
            'subtotal_price' => $subtotal,
            'discount' => $request->input('discount', 0),
            'total_after_discount' => $subTotalII,
            'ppn' => $request->input('ppn', 0),
            'grand_total' => $grandTotal,
            'notes' => $request->input('notes'),
            'terms_conditions' => $request->input('terms_conditions'),
            'authorized_person_name' => $request->input('signer_name'),
            'authorized_person_position' => $request->input('signer_position'),
            'authorized_person_signature' => $authorized_person_signature,
            'is_viewed_admin' => true,
            'is_viewed_distributor' => false,
            'updated_at' => now(),
        ]);

        // Ambil data parameter perusahaan untuk digunakan di PDF
        $companyParameter = CompanyParameter::first(); // Ambil baris pertama pada tabel t_parameter

        // Buat PDF
        $pdf = PDF::loadView('admin.quotation.pdf', [
            'quotation' => $quotation,
            'referenceNumber' => $referenceNumber,
            'companyParameter' => $companyParameter, // Kirimkan data perusahaan ke view PDF
        ]);

        // Tentukan nama file dan path
        $filename = time() . '_' . Str::slug('Quotation_' . $quotation->id) . '.pdf';
        $path = public_path('pdfs/' . $filename);

        // Pastikan folder penyimpanan ada
        if (!File::exists(public_path('pdfs'))) {
            File::makeDirectory(public_path('pdfs'), 0755, true);
        }

        // Simpan PDF ke path yang ditentukan
        $pdf->save($path);

        // Simpan path PDF relatif ke database
        $quotation->update(['pdf_path' => 'pdfs/' . $filename]);


        return redirect()->route('admin.quotations.index')->with('success', 'Quotation updated successfully.');
    }

    public function reject($id)
    {
        $quotation = Quotations::findOrFail($id);

        // Periksa apakah status sudah ditolak sebelumnya
        if ($quotation->status === 'rejected') {
            return redirect()->route('admin.quotations.index')->with('error', 'Ajuan sudah ditolak sebelumnya.');
        }

        // Update status menjadi "rejected"
        $quotation->update([
            'status' => 'rejected',
            'is_viewed_admin' => true,
            'is_viewed_distributor' => false,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.quotations.index')->with('success', 'Ajuan berhasil ditolak.');
    }


}
