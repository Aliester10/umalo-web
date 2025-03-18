<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Models\BidangPerusahaan;
use App\Models\Location;
use App\Models\Product;
use App\Models\Produk;
use App\Models\User;
use App\Models\UserProductDocumentation;
use App\Models\UserProductDocumentationFile;
use App\Models\UserProduk;
use App\Models\UsersProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;



class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('type', 0); // Assuming type 0 is for members
    
        // Tambahkan filter pencarian jika parameter `name` ada
        if ($request->has('name') && $request->name !== null) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }
    
        $members = $query->paginate(10); // Pagination dengan 10 data per halaman
    
        return view('admin.members.index', compact('members'));
    }
    

    public function create()
    {
        return view('admin.members.create');
    }
    

    public function store(Request $request)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:t_users',
        'company_name' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
    ]);

    $randomPassword = Str::random(8);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($randomPassword),
        'type' => 0, // member
        'is_verified' => 1,
        'company_name' => $request->company_name,
        'phone' => $request->phone,
        'address' => $request->address,
        
    ]);

    session()->flash('password', $randomPassword);

    return redirect()->route('members.show', $user->id);
    }


    public function show($id)
    {
        $member = User::findOrFail($id);
        $password = session('password'); 
        

        return view('admin.members.show', compact('member', 'password'));
    }


    public function edit($id)
    {
        $member = User::findOrFail($id);
        return view('admin.members.edit',compact('member'));
    }

    public function update(Request $request, $id)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:t_users,email,' . $id,
        'company_name' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    $member = User::findOrFail($id);

    $member->update([
        'name' => $request->name,
        'email' => $request->email,
        'company_name' => $request->company_name,
        'phone' => $request->phone,
        'address' => $request->address,
    ]);

    if ($request->filled('password')) {
        $member->update(['password' => Hash::make($request->password)]);
    }

    return redirect()->route('members.index')->with('success', 'Member updated successfully.');
    }

    

    public function destroy($id)
    {
        $member = User::findOrFail($id);
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
    }


    public function addProducts($id)
    {
        $member = User::findOrFail($id);
        $products = Product::all(); // Mendapatkan semua produk yang tersedia
    
        return view('admin.members.add-products', compact('member', 'products'));
    }

    public function storeProducts(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'product_id' => 'required|array|min:1', 
            'product_id.*' => 'exists:t_product,id', 
            'purchase_date.*' => 'nullable|date', 
            'quantity.*' => 'required|integer|min:1', 
        ],[
            'product_id.required' => 'Please select at least one product.',
            'quantity.*.required' => 'Quantity is required for each product.',
            'quantity.*.min' => 'Quantity must be at least 1.',    
        ]);

        // Find the member
        $member = User::findOrFail($id);

        // Save the selected products and purchase dates
        foreach ($request->product_id as $product_id) {
            $purchaseDate = $request->purchase_date[$product_id] ?? null; 
            $quantity = $request->quantity[$product_id] ?? 1; 
    
            // Simpan data ke tabel t_users_product
            UsersProduct::create([
                'user_id' => $member->id,
                'product_id' => $product_id,
                'purchase_date' => $purchaseDate,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('members.show', $member->id)->with('success', 'Products added to member successfully.');
    }

    
    

    public function editProducts($id)
    {
        $member = User::with('usersProduct')->findOrFail($id);
    
        $usersProduct = $member->usersProduct;
    
        return view('admin.members.edit-products', compact('member', 'usersProduct'));
    }
    

    public function updateProducts(Request $request, $id)
    {
        // Validate input
        $request->validate([
            'product_id' => 'required|array|min:1', 
            'product_id.*' => 'exists:t_product,id', 
            'purchase_date.*' => 'nullable|date', 
            'quantity.*' => 'required|integer|min:1', 
        ], [
            'product_id.required' => 'Please select at least one product.',
            'quantity.*.required' => 'Quantity is required for each product.',
            'quantity.*.min' => 'Quantity must be at least 1.',
        ]);

        // Find the member
        $member = User::findOrFail($id);

        // Delete existing products for the member
        UsersProduct::where('user_id', $member->id)->delete();

        // Save the updated products
        foreach ($request->product_id as $product_id) {
            $purchaseDate = $request->purchase_date[$product_id] ?? null; 
            $quantity = $request->quantity[$product_id] ?? 1;

            // Create new entries in the `t_users_product` table
            UsersProduct::create([
                'user_id' => $member->id,
                'product_id' => $product_id,
                'purchase_date' => $purchaseDate,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('members.show', $member->id)->with('success', 'Products updated successfully.');
    }

    public function listDocumentation($id)
    {
        $usersProduct = UsersProduct::with(['product', 'documentations.files'])->findOrFail($id);

        return view('admin.members.list-documentation', compact('usersProduct'));
    }

    public function showDocumentation($id)
    {
        $documentation = UserProductDocumentation::with('files')->findOrFail($id);

        return view('admin.members.show-documentation', compact('documentation'));
    }

    public function addDocumentation($id)
    {
        $usersProduct = UsersProduct::with('product')->findOrFail($id);

        return view('admin.members.add-documentation', compact('usersProduct'));
    }

    public function storeDocumentation(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|max:255',
            'files.*' => 'nullable|file|mimes:jpeg,png,pdf,doc,docx|max:20000',
        ], [
            'status.required' => 'Please provide a status for the documentation.',
            'files.*.mimes' => 'Each file must be of type: jpeg, png, pdf, doc, docx.',
            'files.*.max' => 'Each file must not exceed 20 MB.',
        ]);

        $usersProduct = UsersProduct::findOrFail($id);

        // Create the documentation record
        $documentation = UserProductDocumentation::create([
            'users_product_id' => $usersProduct->id,
            'status' => $request->status,
        ]);

        // Handle file uploads
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'uploads/user-product-documentation/' . $fileName;

                $file->move(public_path('uploads/user-product-documentation'), $fileName);

                UserProductDocumentationFile::create([
                    'documentation_id' => $documentation->id,
                    'file' => $filePath,
                ]);
            }
        }

        return redirect()->route('members.show', $usersProduct->user_id)
            ->with('success', 'Documentation added successfully.');
    }

    public function editDocumentation($id)
    {
        $documentation = UserProductDocumentation::with('files')->findOrFail($id);

        return view('admin.members.edit-documentation', compact('documentation'));
    }

    public function updateDocumentation(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|max:255',
            'files.*' => 'nullable|file|mimes:jpeg,png,pdf,doc,docx|max:20000',
        ], [
            'status.required' => 'Please provide a status for the documentation.',
            'files.*.mimes' => 'Each file must be of type: jpeg, png, pdf, doc, docx.',
            'files.*.max' => 'Each file must not exceed 20 MB.',
        ]);

        $documentation = UserProductDocumentation::with('files')->findOrFail($id);

        // Update status dokumentasi
        $documentation->status = $request->status;
        $documentation->save();

        // Handle file uploads
        if ($request->hasFile('files')) {
            // Hapus file lama
            foreach ($documentation->files as $file) {
                $filePath = public_path($file->file);
                if (file_exists($filePath)) {
                    unlink($filePath); // Hapus file dari direktori
                }
                $file->delete(); // Hapus dari database
            }

            // Simpan file baru
            foreach ($request->file('files') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'uploads/user-product-documentation/' . $fileName;

                $file->move(public_path('uploads/user-product-documentation'), $fileName);

                UserProductDocumentationFile::create([
                    'documentation_id' => $documentation->id,
                    'file' => $filePath,
                ]);
            }
        }

        return redirect()->route('members.products.documentation.list', $documentation->userProduct->id)
            ->with('success', 'Documentation updated successfully.');
    }


    public function destroyDocumentation($id)
    {
        $documentation = UserProductDocumentation::with('files')->findOrFail($id);

        // Hapus file dokumentasi
        foreach ($documentation->files as $file) {
            $filePath = public_path($file->file);
            if (file_exists($filePath)) {
                unlink($filePath); // Hapus file dari direktori
            }
            $file->delete(); // Hapus file dari database
        }

        // Hapus dokumentasi
        $documentation->delete();

        return redirect()->route('members.products.documentation.list', $documentation->userProduct->id)
            ->with('success', 'Documentation deleted successfully.');
    }




    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $member = User::findOrFail($id);
        $member->password = Hash::make($request->password);
        $member->save();

        return redirect()->route('members.index')->with('success', 'Password berhasil diperbaharui.');
    }
}
