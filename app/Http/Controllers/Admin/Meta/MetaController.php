<?php

namespace App\Http\Controllers\Admin\Meta;

use App\Http\Controllers\Controller;
use App\Models\Meta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MetaController extends Controller
{
    public function index()
    {
        $metas = Meta::all();
        return view('admin.meta.index', compact('metas'));
    }

    public function create()
    {
        return view('admin.meta.create');
    }

    public function show($slug)
    {
        $meta = Meta::where('slug', $slug)->firstOrFail();
        return view('admin.meta.show', compact('meta'));
    }

    public function edit($id)
    {
        $meta = Meta::findOrFail($id);
        return view('admin.meta.edit', compact('meta'));
    }

    public function destroy($id)
    {
        $meta = Meta::findOrFail($id);
        $meta->delete();
    
        return redirect()->route('admin.meta.index')->with('success', 'Meta deleted successfully.');
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'type' => 'required|in:announcement,promotion', // Validasi ENUM
        ]);
    
        $slug = Str::slug($request->title, '-');
    
        // Check if the slug already exists and append a number to make it unique
        $originalSlug = $slug;
        $count = 1;
        while (Meta::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
    
        Meta::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'type' => $request->type, // Simpan tipe
        ]);
    
        return redirect()->route('admin.meta.index');
    }
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'type' => 'required|in:announcement,promotion', // Validasi ENUM
        ]);
    
        $meta = Meta::findOrFail($id);
    
        // Check if the title is being updated and generate a new slug if needed
        if ($meta->title !== $request->title) {
            $slug = Str::slug($request->title, '-');
    
            // Check if the new slug already exists and append a number to make it unique
            $originalSlug = $slug;
            $count = 1;
            while (Meta::where('slug', $slug)->exists() && $meta->slug !== $slug) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
        } else {
            // Keep the old slug if the title hasn't changed
            $slug = $meta->slug;
        }
    
        // Check if the content is empty
        $content = $request->content ? $request->content : $meta->content;
    
        // Update the meta with the new data
        $meta->update([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $content, // Keep old content if the content is not changed
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'type' => $request->type, // Simpan tipe

        ]);
    
        return redirect()->route('admin.meta.index')->with('success', 'Meta updated successfully.');
    }

    public function uploadImage(Request $request)
{
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('public/images', $filename);

        // Mengembalikan URL gambar yang sudah diupload
        return response()->json([
            'link' => asset('storage/images/' . $filename)
        ]);
    }
    return response()->json(['error' => 'File upload failed.'], 500);
}

    
    
    


}
