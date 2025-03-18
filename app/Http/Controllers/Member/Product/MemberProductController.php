<?php

namespace App\Http\Controllers\Member\Product;

use App\Http\Controllers\Controller;
use App\Models\UserProductDocumentation;
use App\Models\UsersProduct;
use Illuminate\Http\Request;

class MemberProductController extends Controller
{
    public function index(Request $request)
    {
        // Ambil user ID yang sedang login
        $userId = auth()->id();
    
        // Query produk berdasarkan user ID
        $query = UsersProduct::with('product')->where('user_id', $userId);
    
        // Tambahkan filter pencarian jika ada parameter 'search'
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('product', function ($productQuery) use ($request) {
                $productQuery->where('name', 'like', '%' . $request->search . '%');
            });
        }
    
        // Dapatkan hasil query dengan pagination
        $userProduct = $query->paginate(10); // 10 item per halaman
    
        return view('member.product.index', compact('userProduct'));
    }
    
    
    

    public function show($id)
    {
        $userProduct = UsersProduct::with(['product.videos', 'product.brosur', 'product.userManual'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
    
        return view('member.product.show', compact('userProduct'));
    }
    
    public function listDocumentation($id)
    {
        // Ambil produk spesifik milik pengguna yang sedang login
        $usersProduct = UsersProduct::with(['product', 'documentations.files'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Return view untuk daftar dokumentasi
        return view('member.product.documentation.index', compact('usersProduct'));
    }

    public function showDocumentation($id)
    {
        // Ambil dokumentasi spesifik berdasarkan ID
        $documentation = UserProductDocumentation::with('files')
            ->whereHas('userProduct', function ($query) {
                $query->where('user_id', auth()->id()); // Pastikan dokumentasi milik user yang sedang login
            })
            ->findOrFail($id);

        // Return view untuk detail dokumentasi
        return view('member.product.documentation.show', compact('documentation'));
    }

    
}
