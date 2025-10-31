<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\ContactMessage;
use App\Mail\ContactFormMail;

class ContactusController extends Controller
{
    //index
    public function index()
    {
        return view('contactus.index');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Save to database first (this will always happen)
        $contactMessage = ContactMessage::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        // Then try to send email
        try {
            Mail::to('propertylanka@gmail.com')
                ->send(new ContactFormMail(
                    $request->name,
                    $request->email,
                    $request->subject,
                    $request->message
                ));

            return back()->with('success', 'Thank you! Your message has been sent successfully.');

        } catch (\Exception $e) {
            Log::error('Contact email error: ' . $e->getMessage());
            // Still return success because message was saved to database
            return back()->with('success', 'Thank you! Your message has been received. We will get back to you soon.');
        }
    }
    public function showMessages()
{
    $messages = ContactMessage::orderBy('created_at', 'desc')->get();
    return view('superadmin.contact-messages', compact('messages'));
}
}