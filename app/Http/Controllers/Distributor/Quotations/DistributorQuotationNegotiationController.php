<?php

namespace App\Http\Controllers\Distributor\Quotations;

use App\Http\Controllers\Controller;
use App\Models\QuotationNegotiation;
use App\Models\Quotations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DistributorQuotationNegotiationController extends Controller
{
    public function create($quotationId)
    {
        $quotation = Quotations::where('id', $quotationId)
            ->where('status', 'approved')
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('distributor.quotations.negotiations.create', compact('quotation'));
    }

    public function store(Request $request, $quotationId)
    {
        $request->validate([
            'distributor_notes' => 'required|string|max:500',
        ]);

        $quotation = Quotations::where('id', $quotationId)
            ->where('status', 'approved')
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Check if there's already a pending negotiation for the same quotation
        if (QuotationNegotiation::where('quotation_id', $quotation->id)->where('status', 'pending')->exists()) {
            return back()->with('error', 'A negotiation request is already pending for this quotation.');
        }

        // Create a new negotiation request
        QuotationNegotiation::create([
            'quotation_id' => $quotation->id,
            'status' => 'sending',
            'is_viewed_distributor' => true,
            'is_viewed_admin' => false,
            'distributor_notes' => $request->input('distributor_notes'),
        ]);

        return redirect()->route('distributor.quotations.index')->with('success', 'Negotiation request submitted successfully.');
    }

    public function show($negotiationId)
    {
        $negotiation = QuotationNegotiation::with(['quotation.products.product.images'])
            ->whereHas('quotation', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($negotiationId);
    
        // Update `is_viewed_distributor` only
        $updateData = ['is_viewed_distributor' => true];
    
        // Update `status` to 'read' only if `admin_notes` is not empty and status is not 'close'
        if (!empty($negotiation->admin_notes) && $negotiation->status !== 'close') {
            $updateData['status'] = 'read';
        }
    
        // Simpan perubahan
        $negotiation->update($updateData);
    
        return view('distributor.quotations.negotiations.show', compact('negotiation'));
    }
    
    
    public function updateDistributorNotes(Request $request, $negotiationId)
    {
        $negotiation = QuotationNegotiation::whereHas('quotation', function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($negotiationId);

        // Periksa apakah status sudah "close"
        if ($negotiation->status === 'close') {
            return redirect()->route('distributor.quotations.index', $negotiationId)
                            ->with('error', 'Negosiasi sudah selesai dan tidak dapat diubah.');
        }

        $request->validate([
            'distributor_notes' => 'nullable|string|max:5000',
        ]);

        $negotiation->update([
            'distributor_notes' => $request->input('distributor_notes'),
            'status' => 'sending',
            'is_viewed_distributor' => true,
            'is_viewed_admin' => false,
        ]);

        return redirect()->route('distributor.quotations.index', $negotiationId)
                        ->with('success', 'Catatan berhasil diperbarui.');
    }

    
}
