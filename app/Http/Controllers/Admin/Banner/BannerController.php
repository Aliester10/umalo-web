<?php

namespace App\Http\Controllers\Admin\Banner;


use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Meta;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;


class BannerController extends Controller
{
    // Display all banners
    public function index()
    {
        $banners = Banner::all();
        return view('admin.banner.index', compact('banners'));
    }

    // Show form to create a new banner
    public function create()
    {
        $activities = Activity::all(); // Retrieve all activities
        $routes = [
            // Define your predefined routes here
            'home' => route('home'),
            'about' => route('about'),
            // Add other predefined routes as needed
        ];
    
        $metas = Meta::where('start_date', '<=', today())
                     ->where('end_date', '>=', today())
                     ->get();
    
        $products = Product::all(); // Retrieve all products to use in the form
    
        return view('admin.banner.create', compact('activities', 'routes', 'metas', 'products'));
    }
    
    

    public function store(Request $request)
    {
        $request->validate([
            'image_url' => 'required|image',
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'button_text' => 'required|string|max:255',
            'button_url' => 'required|string', // Modify to dynamic URL handling
        ]);

        // Save image to public/uploads/banner
        $image = $request->file('image_url');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('uploads/banner'), $imageName);
        $imagePath = 'uploads/banner/' . $imageName;

        // Determine if the button URL comes from a predefined route, activity, meta, or product
        if ($request->filled('activity_id')) {
            $activity = Activity::find($request->activity_id);
            $buttonUrl = route('activity.show', $activity->id);
        } elseif ($request->filled('meta_slug')) {
            // Use the meta_slug to get the URL for meta data
            $meta = Meta::where('slug', $request->meta_slug)->firstOrFail();
            $buttonUrl = route('member.meta.show', $meta->slug);
        } elseif ($request->filled('product_id')) {
            // Generate URL for product detail page
            $product = Product::findOrFail($request->product_id);
            $buttonUrl = route('product.show', $product->slug);
        } else {
            $buttonUrl = $request->button_url;
        }

        Banner::create([
            'image_url' => $imagePath,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'button_url' => $buttonUrl, // Dynamic button URL
        ]);

        return redirect()->route('admin.banner.index')->with('success', 'banner created successfully.');
    }


    // Show form to edit an existing banner
    public function edit($id)
    {
        $banner = Banner::findOrFail($id); // Retrieve the banner to edit
        $activities = Activity::all(); // Retrieve all activities
        $routes = [
            // Define your predefined routes here
            'home' => route('home'),
            'about' => route('about'),
            // Add other predefined routes as needed
        ];
    
        $metas = Meta::where('start_date', '<=', today())
                     ->where('end_date', '>=', today())
                     ->get();
    
        $products = Product::all(); // Retrieve all products to use in the form
    
        return view('admin.banner.edit', compact('banner', 'activities', 'routes', 'metas', 'products'));
    }
    

    // Update banner
        public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id); // Find the banner to update

        $request->validate([
            'image_url' => 'image|nullable', // Image is optional, only if user uploads a new one
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'button_text' => 'required|string|max:255',
            'button_url' => 'required|string', // Modify to dynamic URL handling
        ]);

        // Handle image upload if a new image is provided
        if ($request->hasFile('image_url')) {
            // Delete the old image if a new one is uploaded
            if ($banner->image_url && file_exists(public_path($banner->image_url))) {
                unlink(public_path($banner->image_url));
            }

            // Upload new image
            $image = $request->file('image_url');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/banner'), $imageName);
            $imagePath = 'uploads/banner/' . $imageName;
        } else {
            // Keep the existing image if no new image is uploaded
            $imagePath = $banner->image_url;
        }

        // Determine if the button URL comes from a predefined route, activity, meta, or product
        if ($request->filled('activity_id')) {
            $activity = Activity::find($request->activity_id);
            $buttonUrl = route('activity.show', $activity->id);
        } elseif ($request->filled('meta_slug')) {
            // Use the meta_slug to get the URL for meta data
            $meta = Meta::where('slug', $request->meta_slug)->firstOrFail();
            $buttonUrl = route('member.meta.show', $meta->slug);
        } elseif ($request->filled('product_id')) {
            // Generate URL for product detail page
            $product = Product::findOrFail($request->product_id);
            $buttonUrl = route('product.show', $product->slug);
        } else {
            $buttonUrl = $request->button_url;
        }

        // Update the banner with the new data
        $banner->update([
            'image_url' => $imagePath,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'button_url' => $buttonUrl, // Dynamic button URL
        ]);

        return redirect()->route('admin.banner.index')->with('success', 'banner updated successfully.');
    }


    // Delete banner
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        // Delete the image file
        if (File::exists(public_path($banner->image_url))) {
            File::delete(public_path($banner->image_url));
        }

        $banner->delete();

        return redirect()->route('admin.banner.index')->with('success', 'banner deleted successfully.');
    }
}
