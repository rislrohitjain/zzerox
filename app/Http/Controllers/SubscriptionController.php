<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $email = strtolower(trim($request->input('email')));

        $subscriber = Subscriber::withTrashed()->where('email', $email)->first();

        if ($subscriber) {
            if ($subscriber->trashed()) {
                $subscriber->restore();
            }
            $subscriber->update([
                'is_active' => true,
                'subscribed_at' => now(),
                'ip_address' => $request->ip(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Your subscription has been renewed successfully!',
            ]);
        }

        Subscriber::create([
            'email' => $email,
            'ip_address' => $request->ip(),
            'is_active' => true,
            'subscribed_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Thank you for subscribing to Zerox Pharmaceuticals newsletter!',
        ]);
    }
}
