<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Banner;
use App\Models\Faq;
use App\Models\Message;
use App\Models\Product;
use App\Models\Ticketing;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function dashboard()
    {
        $ticketing = Ticketing::all();

        // Fetch daily visitor data
        $visitorData = Visitor::selectRaw('DATE(created_at) as date, COUNT(*) as total_visits')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Prepare data for the chart
        $dates = $visitorData->pluck('date')->toArray();
        $visits = $visitorData->pluck('total_visits')->toArray();


        // Fetch the number of members per month
        $memberData = User::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total_members')
        ->where('type', 'member') // Assuming 'type' identifies member users
        ->groupBy('month')
        ->orderBy('month', 'ASC')
        ->get();

        $distributorData = User::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total_distributors')
        ->where('type', 'distributor') // Assuming 'type' identifies distributor users
        ->groupBy('month')
        ->orderBy('month', 'ASC')
        ->get();

        // Combine data for consistent months
        $allMonths = $memberData->pluck('month')->merge($distributorData->pluck('month'))->unique()->sort()->values();
        $memberCounts = [];
        $distributorCounts = [];

        foreach ($allMonths as $month) {
            $memberCounts[] = $memberData->firstWhere('month', $month)?->total_members ?? 0;
            $distributorCounts[] = $distributorData->firstWhere('month', $month)?->total_distributors ?? 0;
        }


        $totalMembers = Banner::count(); // Count users with type 'member'
        $totalProducts = Product::count(); // Assuming Product model
        $totalMonitoredProducts = Faq::count(); // Assuming Monitoring model
        $totalActivities = Activity::count(); // Assuming Activity model

        $unreadMessages = Message::where('status', 0)->orderBy('created_at', 'desc')->get();
        $unreadCount = $unreadMessages->count();

        $pendingDistributors = User::where('type', 2)
        ->where('is_verified', 0)
        ->orderBy('created_at', 'desc')
        ->get();
    

        // Return the view with data
        return view('admin.dashboard.dashboard', compact(
            'dates', 'visits', 'allMonths', 'memberCounts','distributorCounts',
            'totalMembers', 'totalProducts', 'totalMonitoredProducts', 'totalActivities',
            'unreadMessages', 'unreadCount', 'ticketing','pendingDistributors'
        ));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
    
        $admin = Auth::user();
    
        // Verify the current password
        if (!Hash::check($request->current_password, $admin->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }
    
        // Update the password in the database
        DB::table('t_users')
            ->where('id', $admin->id)
            ->update(['password' => Hash::make($request->new_password)]);
    
        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }
}
