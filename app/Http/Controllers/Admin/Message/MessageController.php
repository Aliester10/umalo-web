<?php

namespace App\Http\Controllers\Admin\Message;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::all();
        return view('admin.messages.index', compact('messages'));
    }

    public function show($id)
    {
        // Find the message by ID
        $message = Message::findOrFail($id);
    
        // Mark the message as read
        $message->status = 1;
        $message->save();
    
        // Return the view with the message data
        return view('admin.messages.show', compact('message'));
    }
    

    public function destroy($id)
    {
        // Find the message by ID and delete it
        $message = Message::findOrFail($id);
        $message->delete();

        // Redirect back to the message index with a success message
        return redirect()->route('messages.index')->with('success', 'Message deleted successfully.');
    }

    public function markAllAsRead()
{
    Message::where('status', 0)->update(['status' => 1]);
    return redirect()->route('messages.index')->with('success', 'All messages marked as read.');
}


}
