<?php

namespace App\Http\Controllers\Distributor\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ProformaInvoice;
use App\Models\PurchaseOrders;
use App\Models\Quotations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardDistributorController extends Controller
{
    public function index()
    {
        $quotations = Quotations::where('user_id', auth()->id())->get();
        $purchaseOrders = PurchaseOrders::where('user_id', auth()->id())->get();
        $proformaInvoices = ProformaInvoice::whereHas('purchaseOrder', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return view('distributor.dashboard.index', compact('quotations', 'purchaseOrders', 'proformaInvoices'));

    }

    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        $user = auth()->user();
    
        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada
            if ($user->profile_photo && file_exists(public_path($user->profile_photo))) {
                unlink(public_path($user->profile_photo));
            }
    
            // Simpan file baru di folder 'public/member/profile'
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = 'distributor/profile/' . $filename;
    
            // Pindahkan file ke direktori tujuan
            $file->move(public_path('distributor/profile'), $filename);
    
            // Simpan path file ke database menggunakan query SQL
            DB::table('t_users')
                ->where('id', $user->id)
                ->update(['profile_photo' => $filePath]);
        }
    
        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
    }
}
