<?php

namespace App\Http\Controllers\Distributor\PurchaseOrder;

use App\Http\Controllers\Controller;
use App\Models\ProformaInvoice;
use App\Models\PurchaseOrders;
use App\Models\Quotations;
use Illuminate\Http\Request;
use Illuminate\Support\Str;




class DistributorPurchaseOrderController extends Controller
{
    public function create($id)
    {
        // Ambil data quotation berdasarkan ID
        $quotation = Quotations::with('purchaseOrders')->findOrFail($id);
    
        // Periksa apakah distributor sudah mengajukan PO
        $existingPO = $quotation->purchaseOrders->where('status', 'pending')->first()
                    ?? $quotation->purchaseOrders->where('status', 'approved')->first();
    
        if ($existingPO) {
            // Redirect dengan pesan error jika sudah ada PO pending atau approved
            return redirect()->route('distributor.quotations.index')
                ->with('error', 'Anda sudah mengajukan Purchase Order yang sedang diproses atau disetujui.');
        }
    
        return view('Distributor.purchaseorder.create', compact('quotation'));
    }
    

    public function store(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'po_number' => 'required|string|max:255', // Validasi agar po_number wajib diisi
            'file_path' => 'required|file|mimes:pdf,doc,docx|max:10048', // Validasi agar file wajib diisi
        ]);

        $filePath = null;
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');

            $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('purchase_orders'), $fileName);

            // Set path untuk disimpan di database
            $filePath = 'purchase_orders/' . $fileName;
        }

        // Buat PO
        PurchaseOrders::create([
            'quotation_id' => $id,
            'user_id' => auth()->id(),
            'file_path' => $filePath,
            'po_number' => $request->input('po_number'), 
            'is_viewed_distributor' => true,
            'is_viewed_admin' => false,
            'status' => 'pending'
        ]);

        return redirect()->route('distributor.quotations.index')->with('success', 'Purchase Order created successfully.');
    }
}
