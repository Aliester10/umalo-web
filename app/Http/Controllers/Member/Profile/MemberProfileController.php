<?php

namespace App\Http\Controllers\Member\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Restrict access based on user type
        if ($user->type !== 'member') {
            abort(403, 'Unauthorized access.');
        }

        return view('member.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:t_users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'company_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle profile photo upload
        $profilePhotoPath = $user->profile_photo; // Retain existing photo
        if ($request->hasFile('profile_photo')) {
            // Remove the old photo if it exists
            if ($profilePhotoPath && file_exists(public_path($profilePhotoPath))) {
                unlink(public_path($profilePhotoPath));
            }

            // Save the new file in the 'public/member/profile' directory
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = 'member/profile/' . $filename;

            // Move the file to the destination directory
            $file->move(public_path('member/profile'), $filename);

            // Update the file path for the profile photo
            $profilePhotoPath = $filePath;
        }

        // Prepare data for update
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'company_name' => $request->company_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'profile_photo' => $profilePhotoPath,
        ];

        // Add password if provided
        if ($request->password) {
            $updateData['password'] = Hash::make($request->password);
        }

        // Update the database
        DB::table('t_users')
            ->where('id', $user->id)
            ->update($updateData);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }


}
