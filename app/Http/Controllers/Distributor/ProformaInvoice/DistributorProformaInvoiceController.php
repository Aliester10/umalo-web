<?php

namespace App\Http\Controllers\Distributor\ProformaInvoice;

use App\Http\Controllers\Controller;
use App\Models\ProformaInvoice;
use App\Models\ProformaInvoicePaymentProof;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DistributorProformaInvoiceController extends Controller
{
    public function index($id)
    {
        // Get the logged-in distributor's ID
        $distributorId = Auth::id();

        // Fetch Proforma Invoices for the given quotation ID and distributor's Purchase Orders
        $proformaInvoices = ProformaInvoice::where('quotation_id', $id)
            ->whereHas('purchaseOrder', function ($query) use ($distributorId) {
                $query->where('user_id', $distributorId);
            })
            ->with(['purchaseOrder', 'quotation'])
            ->get();

        // Update is_viewed_admin and is_viewed_distributor to true
        ProformaInvoice::where('quotation_id', $id)
        ->whereHas('purchaseOrder', function ($query) use ($distributorId) {
            $query->where('user_id', $distributorId);
        })
        ->update([
            'is_viewed_admin' => true,
            'is_viewed_distributor' => true,
        ]);

        ProformaInvoicePaymentProof::whereHas('proformaInvoice', function ($query) use ($id, $distributorId) {
            $query->where('quotation_id', $id)
                ->whereHas('purchaseOrder', function ($query) use ($distributorId) {
                    $query->where('user_id', $distributorId);
                });
        })
        ->update(['is_viewed_distributor' => true]);
    

        // Return the view with data
        return view('distributor.proformainvoice.index', compact('proformaInvoices'));
    }

    public function submitPaymentProof(Request $request, $id)
    {
        $request->validate([
            'proof_file_path' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'payment_type' => 'required|in:dp,balance',
        ]);

        $proformaInvoice = ProformaInvoice::findOrFail($id);

        // Check if the user is authorized to submit a proof
        if ($proformaInvoice->purchaseOrder->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Determine the status and remarks based on the type of payment
        $status = 'pending';
        $remarks = $request->input('remarks');

        // Save the file in the public directory
        $file = $request->file('proof_file_path');
        $fileName = uniqid() . '_' . $file->getClientOriginalName();
        $filePath = 'payment_proofs/' . $fileName;

        $file->move(public_path('payment_proofs'), $fileName);

        // Create a new payment proof record
        $proformaInvoice->paymentProofs()->create([
            'proof_file_path' => $filePath,
            'status' => $status,
            'remarks' => $remarks,
            'payment_type' => $request->payment_type,
            'is_viewed_admin' => false,
            'is_viewed_distributor' => true,
        ]);

        return redirect()->back()->with('success', 'Payment proof submitted successfully!');
    }


}
