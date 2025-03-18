<?php

namespace App\Http\Controllers\Guest\Activity;

use App\Helpers\TranslateHelper;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityGuestController extends Controller
{
    public function activity(Request $request)
    {
        // Ambil nilai 'sort' dari query string (default adalah 'newest')
        $sort = $request->get('sort', 'newest');
    
        $locale = app()->getLocale(); 

        // Tentukan urutan berdasarkan pilihan 'newest' atau 'latest'
        if ($sort == 'latest') {
            $activities = Activity::orderBy('date', 'asc')->paginate(8); // Urutkan dari yang terlama
        } else {
            $activities = Activity::orderBy('date', 'desc')->paginate(8); // Urutkan dari yang terbaru (default)
        }

        foreach ($activities as $activ) {
            $activ->title = TranslateHelper::translate($activ->title, $locale);
            $activ->description = TranslateHelper::translate($activ->description, $locale);
        }



    
        return view('guest.activity.activity', compact('activities', 'sort'));
    }
    

    public function show(Activity $activity)
    {

        $locale = app()->getLocale(); 

        $activity->title = TranslateHelper::translate($activity->title, $locale);
        $activity->description = TranslateHelper::translate($activity->description, $locale);

        return view('guest.activity.detail-act', compact('activity'));
    }


}
