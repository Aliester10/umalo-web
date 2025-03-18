<?php

namespace App\Http\Controllers\Admin\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index()
    {
        // Fetch all visitor data
        $visitors = Visitor::all();

        // Group data by date
        $dailyVisitorData = Visitor::selectRaw('DATE(last_visited) as date, COUNT(*) as total_visits')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Prepare data for daily chart
        $dates = $dailyVisitorData->pluck('date')->toArray();
        $visits = $dailyVisitorData->pluck('total_visits')->toArray();

        // Group data by week
        $weeklyVisitorData = Visitor::selectRaw('YEAR(last_visited) as year, WEEK(last_visited) as week, COUNT(*) as total_visits')
            ->groupBy('year', 'week')
            ->orderBy('year', 'ASC')
            ->orderBy('week', 'ASC')
            ->get();

        // Prepare data for weekly chart
        $weeks = $weeklyVisitorData->map(function ($data) {
            return "Week {$data->week} of {$data->year}";
        })->toArray();
        $weeklyVisits = $weeklyVisitorData->pluck('total_visits')->toArray();

        // Pass data to view
        return view('admin.visitor.index', compact('visitors', 'dates', 'visits', 'weeks', 'weeklyVisits'));
    }
}
