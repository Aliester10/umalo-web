<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::query();
    
        // Tambahkan filter pencarian jika parameter `name` ada
        if ($request->has('name') && $request->name !== null) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }
    
        $category = $query->get(); // Ambil semua hasil setelah filter
    
        return view('admin.masterdata.category.index', compact('category'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.masterdata.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        // Buat category baru
        $category = new Category;
        $category->name = $request->name;
    
        // Buat slug dari nama (spasi diubah menjadi tanda hubung)
        $category->slug = Str::slug($request->name, '-');
    
        $category->save();
    
        return redirect()->route('admin.category.index')->with('success', 'category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.masterdata.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        // Cari category yang ada
        $category = Category::findOrFail($id);
        $category->name = $request->name;
    
        // Perbarui slug berdasarkan name (spasi diubah menjadi tanda hubung)
        $category->slug = Str::slug($request->name, '-');
    
        $category->save();
    
        return redirect()->route('admin.category.index')->with('success', 'category updated successfully.');
    }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
    
        // Hapus gambar jika ada
        if ($category->gambar && file_exists(public_path($category->gambar))) {
            unlink(public_path($category->gambar));
        }
    
        // Hapus data category
        $category->delete();
    
        return redirect()->route('admin.category.index')->with('success', 'category deleted successfully.');
    }
    
}
