<?php

namespace App\Http\Controllers\Admin\PurchaseOrder;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrders;
use App\Models\Quotations;
use Illuminate\Http\Request;

class AdminPurchaseOrderController extends Controller
{
    public function index($id)
    {
        // Ambil Quotation berdasarkan ID dengan relasi Purchase Orders
        $quotation = Quotations::with('purchaseOrders')->findOrFail($id);

        // Cek apakah ada Purchase Orders yang 'approved'
        $approvedPurchaseOrders = Quotations::with('purchaseOrders', function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->where('status', 'approved')
        ->exists();

        // Kirimkan notifikasi jika ada Purchase Orders yang 'approved'
        if ($approvedPurchaseOrders) {
            session()->flash('notification', 'Ada Purchase Order dengan status Approved. Silakan buat Proforma Invoice.');
        }

        return view('admin.purchaseorder.index', compact('quotation'));
    }
    public function show($id)
    {
        $purchaseOrder = PurchaseOrders::with('user', 'quotation')->findOrFail($id);

        return view('admin.purchaseorder.show', compact('purchaseOrder'));
    }

    public function approve($id)
    {
        // Cari Purchase Order dan ubah status menjadi approved
        $purchaseOrder = PurchaseOrders::findOrFail($id);
        $purchaseOrder->update([
            'status' => 'approved',
            'is_viewed_admin' => true,
            'is_viewed_distributor' => false,
        ]);
    
        return redirect()->back()->with('success', 'Purchase Order berhasil diterima.');
    }
    
    public function reject($id)
    {
        // Cari Purchase Order dan ubah status menjadi rejected
        $purchaseOrder = PurchaseOrders::findOrFail($id);
        $purchaseOrder->update([
            'status' => 'rejected',
            'is_viewed_admin' => true,
            'is_viewed_distributor' => false,
        ]);
    
        return redirect()->back()->with('success', 'Purchase Order berhasil ditolak.');
    }
    
}
