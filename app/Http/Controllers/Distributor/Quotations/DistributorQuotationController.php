<?php

namespace App\Http\Controllers\Distributor\Quotations;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\PurchaseOrders;
use App\Models\QuotationProduct;
use App\Models\Quotations;
use Illuminate\Http\Request;

class DistributorQuotationController extends Controller
{
    public function index()
    {
        $quotations = Quotations::where('user_id', auth()->id())
            ->orderByRaw("
                CASE 
                    WHEN status = 'pending' THEN 1
                    WHEN status = 'approved' THEN 2
                    WHEN status = 'rejected' THEN 3
                    ELSE 4
                END ASC
            ")
            ->orderBy('created_at', 'desc') // Data terbaru diurutkan dalam setiap kategori status
            ->paginate(10);


        PurchaseOrders::where('is_viewed_distributor', false)
            ->update(['is_viewed_distributor' => true]);
    
        return view('distributor.quotations.index', compact('quotations'));
    }
    

    public function create()
    {
        $products = Product::with('images')->get(); // Memuat gambar dengan relasi

        return view('distributor.quotations.create', compact('products'));
    }

    public function store(Request $request)
    {
        // Validasi input untuk Quotation
        $validatedData = $request->validate([
            'topic' => 'required|string|max:255',
            'products' => 'required|array|min:1', // Produk wajib diisi
            'products.*.product_id' => 'required|integer|exists:t_product,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Logika untuk menghasilkan nomor aplikasi otomatis
        $currentMonth = now()->format('m'); // Bulan sekarang
        $currentYear = now()->format('Y'); // Tahun sekarang
        $romanMonth = now()->format('n'); // Bulan dalam angka untuk konversi ke Romawi

        // Hitung jumlah quotation pada bulan dan tahun ini
        $countForMonth = Quotations::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->count();

        $newNumber = str_pad($countForMonth + 1, 3, '0', STR_PAD_LEFT); // Format nomor dengan tiga digit
        $romanMonth = $this->convertToRoman($romanMonth); // Konversi bulan ke angka Romawi
        $applicationNumber = "{$newNumber}/{$romanMonth}/{$currentYear}";

        $lastQuotation = Quotations::orderBy('quotation_number', 'desc')->first();
        $newQuotationNumber = $lastQuotation ? str_pad((int) $lastQuotation->quotation_number + 1, 4, '0', STR_PAD_LEFT) : '0001';


        // Simpan Quotation
        $quotation = Quotations::create([
            'user_id' => auth()->id(),
            'status' => 'pending', // Status default
            'application_number' => $applicationNumber, // Nomor aplikasi yang telah digenerate
            'topic' => $validatedData['topic'],
            'recipient_company' => auth()->user()->company_name, // Diambil dari data pengguna
            'recipient_contact_person' => auth()->user()->name, // Diambil dari data pengguna    
            'quotation_number' => $newQuotationNumber, // Nomor quotation unik    
            'is_viewed_distributor' => true,
            'is_viewed_admin' => false,
            'created_at' => now(),
        ]);

        // Simpan Produk
        foreach ($validatedData['products'] as $product) {
            QuotationProduct::create([
                'quotation_id' => $quotation->id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
            ]);
        }

        return redirect()->route('distributor.quotations.index')->with('success', 'Quotation berhasil diajukan.');
    }

    public function show($id)
    {
        // Ambil data quotation beserta produk terkait
        $quotation = Quotations::where('id', $id)
            ->where('user_id', auth()->id())
            ->with('products.product') // Memuat relasi produk
            ->firstOrFail();
    
        // Perbarui status is_viewed_distributor dan is_viewed_admin menjadi true
        $quotation->update([
            'is_viewed_distributor' => true,
            'is_viewed_admin' => true,
        ]);
    
        return view('distributor.quotations.show', compact('quotation'));
    }
    
    

    /**
     * Konversi angka ke angka Romawi
     */
    private function convertToRoman($month)
    {
        $romanNumbers = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        return $romanNumbers[$month];
    }


    
}
