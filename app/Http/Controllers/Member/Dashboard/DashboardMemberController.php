<?php

namespace App\Http\Controllers\Member\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Ticketing;
use App\Models\UsersProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardMemberController extends Controller
{
    public function index()
{
    $userId = auth()->id(); // Ambil ID user yang sedang login

    // Ambil produk yang dimiliki oleh member
    $userProducts = UsersProduct::with('product')
        ->where('user_id', $userId)
        ->get();

    // Ambil semua tiket milik member
    $tickets = Ticketing::where('user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->get(); // Ambil semua tiket sebagai collection

    // Hitung jumlah tiket berdasarkan status
    $allTickets = $tickets->count();
    $openTickets = $tickets->where('status', 'Open')->count();
    $progressTickets = $tickets->where('status', 'Progress')->count();
    $closedTickets = $tickets->where('status', 'Close')->count();

    // Hitung total aktivitas (jika Anda memiliki tabel aktivitas)
    $totalActivities = Activity::count();

    return view('member.dashboard.dashboard', compact(
        'userProducts',
        'tickets',
        'openTickets',
        'progressTickets',
        'closedTickets',
        'totalActivities',
        'allTickets'
    ));
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
            $filePath = 'member/profile/' . $filename;
    
            // Pindahkan file ke direktori tujuan
            $file->move(public_path('member/profile'), $filename);
    
            // Simpan path file ke database menggunakan query SQL
            DB::table('t_users')
                ->where('id', $user->id)
                ->update(['profile_photo' => $filePath]);
        }
    
        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    
}
