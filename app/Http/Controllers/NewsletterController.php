<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterSubscription;

class NewsletterController extends Controller
{
    //subscribe
    public function subscribe(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please provide a valid email address.'
            ], 422);
        }

        $email = $request->input('email');

        $existingSubscriber = NewsletterSubscriber::where('email', $email)->first();

        if ($existingSubscriber) {
            if ($existingSubscriber->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'This email is already subscribed to our newsletter.'
                ], 409);
            } else {
                
                $existingSubscriber->update([
                    'is_active' => true,
                    'unsubscribed_at' => null
                ]);
                
                Mail::to($email)->send(new NewsletterSubscription($email, 'reactivated'));
                
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully resubscribed to our newsletter!'
                ]);
            }
        }

        $subscriber = NewsletterSubscriber::create([
            'email' => $email,
            'subscription_token' => \Str::random(32),
            'subscribed_at' => now(),
            'is_active' => true
        ]);

        Mail::to($email)->send(new NewsletterSubscription($email, 'new'));

        return response()->json([
            'success' => true,
            'message' => 'Thank you for subscribing to our newsletter!'
        ]);
    }

    //unsubscribe
    public function unsubscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email address.'
            ], 422);
        }

        $email = $request->input('email');
        $subscriber = NewsletterSubscriber::where('email', $email)->first();

        if (!$subscriber) {
            return response()->json([
                'success' => false,
                'message' => 'Email not found in our subscription list.'
            ], 404);
        }

        if (!$subscriber->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'This email is already unsubscribed.'
            ], 409);
        }

        // Deactivate subscription
        $subscriber->update([
            'is_active' => false,
            'unsubscribed_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully unsubscribed from our newsletter.'
        ]);
    }
}