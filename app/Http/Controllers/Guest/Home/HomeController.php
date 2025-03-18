<?php

namespace App\Http\Controllers\Guest\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Helpers\TranslateHelper;
use App\Models\Activity;
use App\Models\Banner;
use App\Models\BrandPartner;
use App\Models\CompanyParameter;
use App\Models\Faq;
use App\Models\Kategori;
use App\Models\Message;
use App\Models\Monitoring;
use App\Models\Product;
use App\Models\User;
use App\Models\Visitor;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::take(6)->get(); 
        $sliders = Banner::all(); 
        $company = CompanyParameter::first(); 
        $activities = Activity::latest()->take(6)->get(); 
        $locale = app()->getLocale(); 

        foreach ($sliders as $slider) {
            $slider->title = $slider->title ? TranslateHelper::translate($slider->title, $locale) : null;
            if ($slider->subtitle !== 'Way To Know' && $slider->subtitle) {
                $slider->subtitle = TranslateHelper::translate($slider->subtitle, $locale);
            }
            $slider->button_text = $slider->button_text ? TranslateHelper::translate($slider->button_text, $locale) : null;
            $slider->description = $slider->description ? TranslateHelper::translate($slider->description, $locale) : null;
        }   

        if ($company) {
            $company->short_history = TranslateHelper::translate($company->short_history, $locale);
        }

        return view('guest.home.home', compact('products', 'sliders', 'company', 'activities'));
    }

    public function about()
    {
        $company = CompanyParameter::first();
        $locale = app()->getLocale(); 

        if ($company) {
            $company->short_history = TranslateHelper::translate($company->short_history, $locale);
            $company->visi = TranslateHelper::translate($company->visi, $locale);
            $company->misi = TranslateHelper::translate($company->misi, $locale);
        }

        return view('guest.about.about', compact('company'));
    }

    public function activity()
    {
        $locale = app()->getLocale(); 
    
        $activities = Activity::orderBy('date', 'desc')->take(3)->get();
    
        foreach ($activities as $activity) {
            $activity->title = TranslateHelper::translate($activity->title, $locale);
            $activity->description = TranslateHelper::translate($activity->description, $locale);
    
            $activity->images = !empty($activity->images) 
                ? asset('storage/' . $activity->images) 
                : asset('assets/img/default-image.png');
        }

        return view('guest.home.home', compact('activities'));
    }

    public function faq()
    {
        $locale = app()->getLocale(); 
        $company = CompanyParameter::first();
    
        $faqs = Faq::all();
    
        foreach ($faqs as $faq) {
            $faq->questions = TranslateHelper::translate($faq->questions, $locale);
            $faq->answers = TranslateHelper::translate($faq->answers, $locale);
        }
    
        return view('guest.faq.index', compact('faqs', 'company'));
    }

    public function contact(Request $request)
    {
        $company = CompanyParameter::first();
        return view('guest.contact.contact', compact('company'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $latestMessage = Message::where('email', $request->email)
                                ->orderBy('created_at', 'desc')
                                ->first();

        if ($latestMessage) {
            $now = now();
            $lastMessageTime = $latestMessage->created_at;
            $hoursDifference = $now->diffInHours($lastMessageTime);
            if ($hoursDifference < 5) {
                return back()->withErrors(['error' => 'You can only send a message once every 5 hours based on your email.']);
            }
        }

        if (session()->has('last_message_time')) {
            $lastMessageTimeFromSession = session('last_message_time');
            $now = now();
            $hoursDifferenceSession = $now->diffInHours($lastMessageTimeFromSession);
            if ($hoursDifferenceSession < 5) {
                return back()->withErrors(['error' => 'You can only send a message once every 5 hours.']);
            }
        }

        session(['last_message_time' => now()]);

        Message::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company' => $request->company,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Your message has been sent successfully!');
    }
}
