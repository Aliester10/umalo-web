<?php

namespace App\Http\Controllers\Admin\Quotation;

use App\Http\Controllers\Controller;
use App\Models\QuotationNegotiation;
use Illuminate\Http\Request;

class AdminQuotationNegotiationController extends Controller
{
    public function show($negotiationId)
    {
        // Retrieve the negotiation with its associated quotation details
        $negotiation = QuotationNegotiation::with('quotation')
            ->findOrFail($negotiationId);
    
        // Update 'is_viewed_admin' only if it's not already "close"
        if (!$negotiation->is_viewed_admin) {
            $negotiation->update([
                'is_viewed_admin' => true,
            ]);
    
            // Update status to 'read' only if it's not "close"
            if ($negotiation->status !== 'close') {
                $negotiation->update([
                    'status' => 'read',
                ]);
            }
        }
    
        return view('admin.quotation.negotiations.show', compact('negotiation'));
    }
    
    

    public function update(Request $request, $negotiationId)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:1000',
        ]);
    
        $negotiation = QuotationNegotiation::findOrFail($negotiationId);
    
        // Periksa apakah status sudah "close"
        if ($negotiation->status === 'close') {
            return redirect()->route('admin.quotations.index')->with('error', 'Negosiasi sudah selesai dan tidak dapat diubah.');
        }
    
        // Lanjutkan pembaruan jika status bukan "close"
        $negotiation->update([
            'admin_notes' => $request->input('admin_notes'),
            'status' => 'sending',
            'is_viewed_admin' => true,
            'is_viewed_distributor' => false,
        ]);
    
        return redirect()->route('admin.quotations.index')->with('success', 'Catatan admin berhasil disimpan.');
    }
    

    public function complete($negotiationId)
    {
        $negotiation = QuotationNegotiation::findOrFail($negotiationId);

        $negotiation->update([
            'status' => 'close',
            'is_viewed_admin' => true,
            'is_viewed_distributor' => false,
        ]);

        return redirect()->route('admin.quotations.index')->with('success', 'Status negosiasi berhasil diubah menjadi selesai.');
    }

    
}
