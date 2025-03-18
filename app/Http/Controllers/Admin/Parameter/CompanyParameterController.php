<?php

namespace App\Http\Controllers\Admin\Parameter;

use App\Http\Controllers\Controller;
use App\Models\CompanyParameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companyParameters = CompanyParameter::all();
        return view('admin.parameter.index', compact('companyParameters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check if a record already exists
        if (CompanyParameter::exists()) {
            return redirect()->route('parameter.index')->with('error', 'Data already exists. You can only edit the existing data.');
        }
    
        return view('admin.parameter.create');
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'short_history' => 'nullable|string',
            'email' => 'required|email',
            'no_telepon' => 'required|string',
            'no_wa' => 'required|string',
            'address' => 'required|string',
            'maps_url' => 'nullable|string',
            'maps_iframe' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'logo_support_2' => 'nullable|image|max:2048',
            'logo_support_3' => 'nullable|image|max:2048',
            'about_gambar' => 'nullable|image|max:2048',
            'instagram' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'ekatalog' => 'nullable|string',
            'no_acc_bank' => 'nullable|string',
            'bank' => 'nullable|string',
        ]);

        // Directory path
        $destinationPath = public_path('parameter/assets/image');

        // Ensure the directory exists
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Save logo
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);
            $validated['logo'] = 'parameter/assets/image/' . $fileName;
        }

        // Save logo_support_2
        if ($request->hasFile('logo_support_2')) {
            $file = $request->file('logo_support_2');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);
            $validated['logo_support_2'] = 'parameter/assets/image/' . $fileName;
        }

        // Save logo_support_3
        if ($request->hasFile('logo_support_3')) {
            $file = $request->file('logo_support_3');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);
            $validated['logo_support_3'] = 'parameter/assets/image/' . $fileName;
        }

        // Save about_gambar
        if ($request->hasFile('about_gambar')) {
            $file = $request->file('about_gambar');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);
            $validated['about_gambar'] = 'parameter/assets/image/' . $fileName;
        }

        CompanyParameter::create($validated);

        return redirect()->route('parameter.index')->with('success', 'Company parameter created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $companyParameter = CompanyParameter::findOrFail($id);
        return view('admin.parameter.show', compact('companyParameter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Retrieve the company parameter by ID
        $companyParameter = CompanyParameter::findOrFail($id);
        return view('admin.parameter.edit', compact('companyParameter'));
    }

    public function update(Request $request, $id)
    {
        // Find the company parameter by ID
        $company = CompanyParameter::findOrFail($id);

        // Validate the input
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'short_history' => 'nullable|string',
            'email' => 'required|email',
            'no_telepon' => 'required|string',
            'no_wa' => 'required|string',
            'address' => 'required|string',
            'maps_url' => 'nullable|string',
            'maps_iframe' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'logo_support_2' => 'nullable|image|max:2048',
            'logo_support_3' => 'nullable|image|max:2048',
            'about_gambar' => 'nullable|image|max:2048',
            'instagram' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'ekatalog' => 'nullable|string',
            'no_acc_bank' => 'nullable|string',
            'bank' => 'nullable|string',
        ]);

        $destinationPath = public_path('parameter/assets/image');

        // Ensure the directory exists
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Handle file uploads
        foreach (['logo', 'logo_support_2', 'logo_support_3', 'about_gambar'] as $field) {
            if ($request->hasFile($field)) {
                // Delete the old file if it exists
                if ($company->$field && file_exists(public_path($company->$field))) {
                    unlink(public_path($company->$field));
                }

                // Save the new file
                $file = $request->file($field);
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move($destinationPath, $fileName);
                $validated[$field] = 'parameter/assets/image/' . $fileName;
            }
        }

        // Update the company parameter record
        $company->update($validated);

        return redirect()->route('parameter.index')->with('success', 'Company parameter updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $companyParameter = CompanyParameter::findOrFail($id);

        // Delete logo if exists
        if ($companyParameter->logo) {
            Storage::delete('public/' . $companyParameter->logo);
        }

        // Delete about_gambar if exists
        if ($companyParameter->about_gambar) {
            Storage::delete('public/' . $companyParameter->about_gambar);
        }

        $companyParameter->delete();

        return redirect()->route('parameter.index')->with('success', 'Company parameter deleted successfully.');
    }
}
