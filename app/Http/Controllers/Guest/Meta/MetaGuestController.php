<?php

namespace App\Http\Controllers\Guest\Meta;

use App\Helpers\TranslateHelper;
use App\Http\Controllers\Controller;
use App\Models\Meta;
use Illuminate\Http\Request;

class MetaGuestController extends Controller
{
    public function showMeta()
{
    // Retrieve all active meta records based on the current date
    $metas = Meta::where('start_date', '<=', now())
                  ->where('end_date', '>=', now())
                  ->get();

    return view('guest.meta.index', compact('metas'));
}

public function showMetaBySlug($slug)
{
    $locale = app()->getLocale(); 

    // Retrieve the meta entry based on the slug
    $meta = Meta::where('slug', $slug)->firstOrFail();

    // Translate the content based on the locale
    $meta->content = TranslateHelper::translate($meta->content, $locale);
    $meta->title = TranslateHelper::translate($meta->title, $locale);

    return view('guest.meta.show', compact('meta'));
}


    public function getActiveMetas()
{
    // Mengambil semua meta yang aktif berdasarkan start_date dan end_date
    $activeMetas = Meta::where('start_date', '<=', now())
                        ->where('end_date', '>=', now())
                        ->get();

    return $activeMetas;
}

}
