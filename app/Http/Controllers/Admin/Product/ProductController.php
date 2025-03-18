<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Brosur;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVideo;
use App\Models\UserManual;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();
    
        // Tambahkan filter pencarian jika parameter `name` ada
        if ($request->has('name') && $request->name !== null) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }
    
        $products = $query->paginate(10); // Pagination dengan 10 item per halaman
        $category = Category::all();
    
        return view('admin.product.index', compact('products', 'category'));
    }
    
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::all();
        return view('admin.product.create', (compact('category')));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'usage' => 'required',
            'category_id' => 'required|exists:t_category,id',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:15000',
            'video.*' => 'nullable|file|mimes:mp4,avi,mkv|max:50000',
            'ekatalog' => 'nullable', 
            'file_usermanual.*' => 'nullable|file|mimes:pdf,doc,docx|max:20000',
            'file.*' => 'nullable|mimes:pdf,jpeg,png,jpg,gif|max:20000', // Optional for editing
    
        ]);
        
        
        // Create a new product instance and fill it with the validated data
        $product = new Product;
        $product->fill($request->all());
        $product->slug = Str::slug($product->name, '-');
        $product->save();
        

        if ($request->hasFile('file_usermanual')) {
            foreach ($request->file('file_usermanual') as $file) {
                // Membuat nama file unik
                $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        
                // Tentukan path tempat menyimpan file
                $filePath = 'uploads/product/usermanual/' . $fileName;
        
                // Pindahkan file ke direktori public path
                $file->move(public_path('uploads/product/usermanual'), $fileName);
        
                // Simpan path file di database
                UserManual::create([
                    'product_id' => $product->id,
                    'file' => $filePath, // Path yang disimpan di database
                ]);
            }
        }
        
        

        // Handle video upload
        if ($request->hasFile('video')) {
            foreach ($request->file('video') as $videoFile) {
                $slug = Str::slug(pathinfo($videoFile->getClientOriginalName(), PATHINFO_FILENAME));
                $newVideoName = time() . '_' . $slug . '.' . $videoFile->getClientOriginalExtension();
                $videoFile->move('uploads/product/videos/', $newVideoName);
    
                $productVideo = new ProductVideo;
                $productVideo->product_id = $product->id;
                $productVideo->video = 'uploads/product/videos/' . $newVideoName;
                $productVideo->save();
            }
        }
    
        // Handle images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imgproduct) {
                $slug = Str::slug(pathinfo($imgproduct->getClientOriginalName(), PATHINFO_FILENAME));
                $newImageName = time() . '_' . $slug . '.' . $imgproduct->getClientOriginalExtension();
                $imgproduct->move('uploads/product/', $newImageName);
    
                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                $productImage->images = 'uploads/product/' . $newImageName;
                $productImage->save();
            }
        }

         // Handle brosur update
         if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $type = $file->getClientOriginalExtension() === 'pdf' ? 'pdf' : 'image';
                $file->move('uploads/product/brosur/', $fileName);
        
                // Simpan brosur di database
                Brosur::create([
                    'product_id' => $product->id,
                    'file' => 'uploads/product/brosur/' . $fileName,
                    'type' => $type,
                ]);
            }
        }
        
    
        return redirect()->route('admin.product.index')->with('success', 'product created successfully.');
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $category = Category::all();
        return view('admin.product.edit', compact('product','category'));
    }

    public function show($id)
    {
        $products = Product::with('images', 'videos', 'documentCertificationsProduct', 'brosur')->findOrFail($id);
        return view('admin.product.show', compact('products'));
    }
    
    


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'brand' => 'required|string|max:255',
        'usage' => 'required',
        'category_id' => 'required|exists:t_category,id',
        'ekatalog' => 'nullable', 
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:15000',
        'video.*' => 'nullable|file|mimes:mp4,avi,mkv|max:50000',
        'file_usermanual.*' => 'nullable|file|mimes:pdf,doc,docx|max:20000',
        'file.*' => 'nullable|mimes:pdf,jpeg,png,jpg,gif|max:20000',
    ]);

    $product = Product::findOrFail($id);
    $product->fill($request->all());
    $product->slug = Str::slug($request->name, '-');
    $product->save();

    
    if ($request->has('delete_images')) {
        $deleteImageIds = $request->input('delete_images');
        foreach ($deleteImageIds as $imageId) {
            $image = ProductImage::find($imageId);
            if ($image) {
                if (file_exists(public_path($image->images))) {
                    unlink(public_path($image->images));
                }
                $image->delete();
            }
        }
    }

    if ($request->hasFile('file_usermanual')) {
        // Ambil user manuals lama terkait produk
        $existingUserManuals = UserManual::where('product_id', $product->id)->get();
    
        // Hapus file lama jika ada
        foreach ($existingUserManuals as $manual) {
            $oldFilePath = public_path($manual->file);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath); // Menghapus file fisik
            }
            $manual->delete(); // Menghapus dari database
        }
    
        // Simpan file user manual baru
        foreach ($request->file('file_usermanual') as $file) {
            $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $filePath = 'uploads/product/usermanual/' . $fileName;
            $file->move(public_path('uploads/product/usermanual'), $fileName);
    
            // Simpan data ke database
            UserManual::create([
                'product_id' => $product->id,
                'file' => $filePath,
            ]);
        }
    }
    
    


    

    // Handle video upload
    if ($request->hasFile('video')) {
        foreach ($request->file('video') as $videoFile) {
            $slug = Str::slug(pathinfo($videoFile->getClientOriginalName(), PATHINFO_FILENAME));
            $newVideoName = time() . '_' . $slug . '.' . $videoFile->getClientOriginalExtension();
            $videoFile->move('uploads/product/videos/', $newVideoName);

            $productVideo = new ProductVideo;
            $productVideo->product_id = $product->id;
            $productVideo->video = 'uploads/product/videos/' . $newVideoName;
            $productVideo->save();
        }
    }

    // Handle images upload
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $imgproduct) {
            $slug = Str::slug(pathinfo($imgproduct->getClientOriginalName(), PATHINFO_FILENAME));
            $newImageName = time() . '_' . $slug . '.' . $imgproduct->getClientOriginalExtension();
            $imgproduct->move('uploads/product/', $newImageName);

            $productImage = new ProductImage;
            $productImage->product_id = $product->id;
            $productImage->images = 'uploads/product/' . $newImageName;
            $productImage->save();
        }
    }

        // Handle brosur update
        if ($request->hasFile('file')) {
            // Ambil brosur lama terkait product
            $oldBrosur = Brosur::where('product_id', $product->id)->get();
            
            // Hapus semua file brosur lama
            foreach ($oldBrosur as $brosur) {
                if (file_exists(public_path($brosur->file))) {
                    unlink(public_path($brosur->file)); // Menghapus file fisik dari server
                }
                $brosur->delete(); // Hapus dari database
            }
        
            // Upload brosur baru
            foreach ($request->file('file') as $file) {
                $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $type = $file->getClientOriginalExtension() === 'pdf' ? 'pdf' : 'image';
                $file->move('uploads/product/brosur/', $fileName);
                
                // Simpan brosur baru di database
                Brosur::create([
                    'product_id' => $product->id,
                    'file' => 'uploads/product/brosur/' . $fileName,
                    'type' => $type
                ]);
            }
        }
        
        

    

    return redirect()->route('admin.product.index')->with('success', 'product updated successfully.');
}




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.product.index')->with('success', 'product deleted successfully.');
    }
    
}
