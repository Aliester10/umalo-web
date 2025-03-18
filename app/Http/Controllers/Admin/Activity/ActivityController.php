<?php

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use Illuminate\Support\Str;


class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::all();
        return view('admin.activity.index', compact('activities'));
    }

    public function create()
    {
        return view('admin.activity.create');
    }

    public function store(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'images' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'date' => 'required|date',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    // Handle file upload logic
    if ($request->hasFile('images')) {
        $file = $request->file('images');
        $slug = str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $newFileName = time() . '_' . $slug . '.' . $file->getClientOriginalExtension();

        // Store the image in the 'uploads/activities/images/' folder
        $file->move(public_path('uploads/activities/images'), $newFileName);
        $imageName = 'uploads/activities/images/' . $newFileName;
    }

    // Create the activity record
    Activity::create([
        'images' => $imageName,
        'date' => $request->date,
        'title' => $request->title,
        'description' => $request->description,
    ]);

    // Redirect with success message
    return redirect()->route('admin.activity.index')->with('success', 'Activity created successfully.');
}


    public function edit(Activity $activity)
    {
        return view('admin.activity.edit', compact('activity'));
    }

    public function show(Activity $activity)
    {
        return view('admin.activity.show', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        // Validate the incoming request
        $request->validate([
            'images' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
    
        // Handle file upload if a new image is provided
        if ($request->hasFile('images')) {
            // Delete the old image if it exists
            if ($activity->image && file_exists(public_path($activity->image))) {
                unlink(public_path($activity->image));
            }
    
            // Generate a new filename with a slug
            $file = $request->file('images');
            $slug = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $newFileName = time() . '_' . $slug . '.' . $file->getClientOriginalExtension();
    
            // Store the image in the 'uploads/activities/images/' folder
            $file->move(public_path('uploads/activities/images'), $newFileName);
    
            // Set the new image path
            $activity->images= 'uploads/activities/images/' . $newFileName;
        }
    
        // Update other activity fields
        $activity->date = $request->date;
        $activity->title = $request->title;
        $activity->description = $request->description;
    
        // Save the updated activity
        $activity->save();
    
        // Redirect with success message
        return redirect()->route('admin.activity.index')->with('success', 'Activity updated successfully.');
    }
    

    public function destroy(Activity $activity)
    {
        if (file_exists(public_path($activity->images))) {
            unlink(public_path($activity->images));
        }
        $activity->delete();
        return redirect()->route('admin.activity.index')->with('success', 'Activity deleted successfully.');
    }
}
