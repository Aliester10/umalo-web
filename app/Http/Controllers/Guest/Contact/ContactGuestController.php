<?php

namespace App\Http\Controllers\Guest\Contact;

use App\Helpers\TranslateHelper;
use App\Http\Controllers\Controller;
use App\Models\CompanyParameter;
use App\Models\Contact;
use App\Models\Message;
use Illuminate\Http\Request;

class ContactGuestController extends Controller
{
    public function contact(Request $request)
    {
        $company = CompanyParameter::first();

    
        return view('guest.contact.contact',compact('company'));
    }

    public function store(Request $request)
{
    // Validate the input
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'subject' => 'required',
        'message' => 'required',
    ]);

    // Check if this guest has already sent a message in the last 5 hours based on email
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

    // Check if this guest has already sent a message in the last 5 hours based on session
    if (session()->has('last_message_time')) {
        $lastMessageTimeFromSession = session('last_message_time');
        $now = now();
        $hoursDifferenceSession = $now->diffInHours($lastMessageTimeFromSession);

        if ($hoursDifferenceSession < 5) {
            return back()->withErrors(['error' => 'You can only send a message once every 5 hours.']);
        }
    }

    // Store the current time in session after message is sent
    session(['last_message_time' => now()]);

    // Create a new message entry
    Message::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'company' => $request->company,
        'subject' => $request->subject,
        'message' => $request->message,
    ]);

    // Return success message
    return back()->with('success', 'Your message has been sent successfully!');
}

    
}
    

  