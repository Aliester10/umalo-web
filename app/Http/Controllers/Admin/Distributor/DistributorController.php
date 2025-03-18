<?php

namespace App\Http\Controllers\Admin\Distributor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DistributorController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('type', 2)->orderBy('is_verified', 'desc');
    
        // Filter berdasarkan nama jika parameter `name` ada
        if ($request->has('name') && $request->name !== null) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }
    
        $distributors = $query->paginate(10); // Pagination dengan 10 data per halaman
    
        return view('admin.distributors.index', compact('distributors'));
    }
    

    public function create()
    {
        return view('admin.distributors.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email|unique:t_users,email',
            'phone' => 'required|numeric|min:8',
            'address' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'pic_phone' => 'required|numeric|min:8',
            'deed_of_establishment' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'nib_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Tentukan direktori tujuan
        $deedDirectory = public_path('distributor/documents/akta');
        $nibDirectory = public_path('distributor/documents/nib');

        if (!file_exists($deedDirectory)) {
            mkdir($deedDirectory, 0777, true);
        }
        if (!file_exists($nibDirectory)) {
            mkdir($nibDirectory, 0777, true);
        }

        // Upload file dengan nama unik
        $deedFileName = time() . '_deed_' . $request->file('deed_of_establishment')->getClientOriginalName();
        $nibFileName = time() . '_nib_' . $request->file('nib_document')->getClientOriginalName();

        $request->file('deed_of_establishment')->move($deedDirectory, $deedFileName);
        $request->file('nib_document')->move($nibDirectory, $nibFileName);

        // Generate password acak
        $randomPassword = Str::random(8);

        // Simpan user ke database
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($randomPassword),
            'phone' => $request->phone,
            'address' => $request->address,
            'company_name' => $request->company_name,
            'name' => $request->name,
            'pic_phone' => $request->pic_phone,
            'deed_of_establishment' => 'distributor/documents/akta/' . $deedFileName,
            'nib_document' => 'distributor/documents/nib/' . $nibFileName,
            'type' => 2, 
            'is_verified' => true, 
        ]);

        // Simpan password ke session
        session()->flash('password', $randomPassword);

        // Redirect ke halaman show atau index dengan pesan sukses
        return redirect()->route('distributors.show',$user->id)
                        ->with('success', 'Akun Distributor berhasil dibuat! Password: ' . $randomPassword);
    }

    public function show($id)
    {
        $distributors = User::findOrFail($id);
        $password = session('password'); 
        

        return view('admin.distributors.show', compact('distributors', 'password'));
    }

    public function edit($id)
    {
        $distributors = User::findOrFail($id);
        return view('admin.distributors.edit',compact('distributors'));
    }



    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $distributors = User::findOrFail($id);
        $distributors->password = Hash::make($request->password);
        $distributors->save();

        return redirect()->route('distributors.index')->with('success', 'Password berhasil diperbaharui.');
    }

    public function update(Request $request, $id)
    {
        // Ambil user berdasarkan ID
        $user = User::findOrFail($id);

        // Validasi input
        $request->validate([
            'email' => 'required|email|unique:t_users,email,' . $id,
            'phone' => 'required|numeric|min:8',
            'address' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'pic_phone' => 'required|numeric|min:8',
            'deed_of_establishment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'nib_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Tentukan direktori tujuan
        $deedDirectory = public_path('distributor/documents/akta');
        $nibDirectory = public_path('distributor/documents/nib');

        // Buat direktori jika belum ada
        if (!file_exists($deedDirectory)) {
            mkdir($deedDirectory, 0777, true);
        }
        if (!file_exists($nibDirectory)) {
            mkdir($nibDirectory, 0777, true);
        }

        // Upload file deed_of_establishment jika ada file baru
        if ($request->hasFile('deed_of_establishment')) {
            // Hapus file lama jika ada
            if (file_exists(public_path($user->deed_of_establishment))) {
                unlink(public_path($user->deed_of_establishment));
            }
            $deedFileName = time() . '_deed_' . $request->file('deed_of_establishment')->getClientOriginalName();
            $request->file('deed_of_establishment')->move($deedDirectory, $deedFileName);
            $user->deed_of_establishment = 'distributor/documents/akta/' . $deedFileName;
        }

        // Upload file nib_document jika ada file baru
        if ($request->hasFile('nib_document')) {
            // Hapus file lama jika ada
            if (file_exists(public_path($user->nib_document))) {
                unlink(public_path($user->nib_document));
            }
            $nibFileName = time() . '_nib_' . $request->file('nib_document')->getClientOriginalName();
            $request->file('nib_document')->move($nibDirectory, $nibFileName);
            $user->nib_document = 'distributor/documents/nib/' . $nibFileName;
        }

        // Update data user
        $user->update([
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'company_name' => $request->company_name,
            'name' => $request->name,
            'pic_phone' => $request->pic_phone,
        ]);

        // Redirect ke halaman show dengan pesan sukses
        return redirect()->route('distributors.show', $user->id)
                        ->with('success', 'Akun Distributor berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $distributors = User::findOrFail($id);
        $distributors->delete();

        return redirect()->route('distributors.index')->with('success', 'distributors deleted successfully.');
    }

    public function verify($id)
    {
        $distributor = User::findOrFail($id);

        $distributor->is_verified = true;
        $distributor->save();

        return redirect()->route('distributors.index')->with('success', 'Distributor berhasil diverifikasi.');
    }



}
