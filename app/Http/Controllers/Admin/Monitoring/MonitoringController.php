<?php

namespace App\Http\Controllers\Admin\Monitoring;

use App\Http\Controllers\Controller;
use App\Models\Inspeksi;
use App\Models\InspeksiMaintenance;
use App\Models\Maintenance;
use App\Models\Monitoring;
use App\Models\User;
use App\Models\UserProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MonitoringController extends Controller
{
    public function index()
    {
        // Assuming role = 0 represents 'member' users
        $users = User::where('type', 0)->with('userProduk')->get();
    
        return view('admin.monitoring.index', compact('users'));
    }
    

    public function show($id)
    {
        // Get the user and their products
        $user = User::with('userProduk')->findOrFail($id);
    
        return view('admin.monitoring.show', compact('user'));
    }
    

    public function monitoringDetail($id)
    {
        $produk = UserProduk::with('user')->findOrFail($id);
        $user = $produk->user;
    
        // Fetch monitoring data
        $monitoring = $produk->monitoring()->first();
    
        // Fetch all related inspections
        $inspeksi = InspeksiMaintenance::where('user_produk_id', $id)->get();
    
        return view('admin.monitoring.detail', compact('user', 'produk', 'monitoring', 'inspeksi'));
    }
    

    public function create($userProdukId)
    {
        // Get the user product with the related product data
        $userProduk = UserProduk::with('produk')->findOrFail($userProdukId);
    
        return view('admin.monitoring.create', compact('userProduk'));
    }
    


public function store(Request $request)
{
    $validated = $request->validate([
        'user_produk_id' => 'required|exists:user_produk,id',
        'status_barang' => 'required|string|max:255',
        'kondisi_terakhir_produk' => 'required|string|max:255',
    ]);

    Monitoring::create($validated);

    return redirect()->route('admin.monitoring.index')->with('success', 'Monitoring data successfully created.');
}

public function edit($id)
{
    // Get the monitoring data to edit
    $monitoring = Monitoring::with('userProduk.produk')->findOrFail($id);
    $userProduk = $monitoring->userProduk;

    return view('admin.monitoring.edit', compact('monitoring', 'userProduk'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'status_barang' => 'required|string|max:255',
        'kondisi_terakhir_produk' => 'required|string|max:255',
    ]);

    $monitoring = Monitoring::findOrFail($id);
    $monitoring->update($validated);

    return redirect()->route('monitoring.detail', $monitoring->user_produk_id)->with('success', 'Monitoring data successfully updated.');
}

    public function inspeksiIndex($userProdukId)
    {
        $inspeksi = InspeksiMaintenance::where('user_produk_id', $userProdukId)->get();
        $userProduk = UserProduk::findOrFail($userProdukId);

        return view('admin.inspeksi.index', compact('inspeksi', 'userProduk'));
    }

    public function inspeksiShow($id)
    {
        $inspeksi = InspeksiMaintenance::with('userProduk')->findOrFail($id);

        return view('admin.inspeksi.show', compact('inspeksi'));
    }

    public function inspeksiCreate($userProdukId)
    {
        $userProduk = UserProduk::findOrFail($userProdukId);

        return view('admin.inspeksi.create', compact('userProduk'));
    }

    public function inspeksiStore(Request $request, $userProdukId)
{
    $validated = $request->validate([
        'pic' => 'required|string|max:255',
        'waktu' => 'required|date',
        'gambar' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:2048', // Allow images and PDFs
        'judul' => 'required|string|max:255',
        'deskripsi' => 'required|string|max:255',
        'status' => 'required|in:Inspeksi,Maintenance',
    ]);

    $validated['user_produk_id'] = $userProdukId;

    if ($request->hasFile('gambar')) {
        $file = $request->file('gambar');
        $slug = str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $newFileName = time() . '_' . $slug . '.' . $file->getClientOriginalExtension();

        // Handle file upload for PDF and images
        if ($file->getClientOriginalExtension() === 'pdf') {
            $file->move('uploads/inspeksi/pdf/', $newFileName);
            $validated['gambar'] = 'uploads/inspeksi/pdf/' . $newFileName;
        } else {
            $file->move('uploads/inspeksi/images/', $newFileName);
            $validated['gambar'] = 'uploads/inspeksi/images/' . $newFileName;
        }
    }

    InspeksiMaintenance::create($validated);

    return redirect()->route('monitoring.detail', $userProdukId)->with('success', 'Inspection data successfully created.');
}


    // Show form to edit an existing inspection
    public function inspeksiEdit($id)
    {
        $inspeksi = InspeksiMaintenance::findOrFail($id);

        return view('admin.inspeksi.edit', compact('inspeksi'));
    }

    // Update inspection data
    public function inspeksiUpdate(Request $request, $id)
{
    // Find the existing record
    $inspeksi = InspeksiMaintenance::findOrFail($id);

    // Extract the userProdukId from the inspection
    $userProdukId = $inspeksi->user_produk_id;

    // Validate the request
    $validated = $request->validate([
        'pic' => 'required|string|max:255',
        'waktu' => 'required|date',
        'gambar' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:2048', // Allow images and PDFs
        'judul' => 'required|string|max:255',
        'deskripsi' => 'required|string|max:255',
        'status' => 'required|in:Inspeksi,Maintenance',
    ]);

    // Handle file replacement logic
    if ($request->hasFile('gambar')) {
        // Delete the old file if it exists
        if ($inspeksi->gambar && Storage::disk('public')->exists($inspeksi->gambar)) {
            Storage::disk('public')->delete($inspeksi->gambar);
        }

        // Handle new file upload
        $file = $request->file('gambar');
        $slug = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $newFileName = time() . '_' . $slug . '.' . $file->getClientOriginalExtension();

        // Store the file based on its extension
        if ($file->getClientOriginalExtension() === 'pdf') {
            $file->move('uploads/inspeksi/pdf/', $newFileName);
            $validated['gambar'] = 'uploads/inspeksi/pdf/' . $newFileName;
        } else {
            $file->move('uploads/inspeksi/images/', $newFileName);
            $validated['gambar'] = 'uploads/inspeksi/images/' . $newFileName;
        }
    }

    // Update the inspection record
    $inspeksi->update($validated);

    // Redirect back with success message
    return redirect()->route('monitoring.detail', $userProdukId)->with('success', 'Inspection data successfully updated.');
}




    // Delete an inspection
    public function inspeksiDestroy($id)
    {
        $inspeksi = InspeksiMaintenance::findOrFail($id);
        $userProdukId = $inspeksi->user_produk_id;
        $inspeksi->delete();

        return redirect()->route('monitoring.detail', $userProdukId)->with('success', 'Inspection data successfully deleted.');
    }

    
    






    

    
    






}
