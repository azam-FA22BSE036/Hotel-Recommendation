<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Show Contact Page
    public function index()
    {
        return view('contact');
    }

    // Handle Contact Form
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($request->all());

        return back()->with('success', 'Your message has been sent successfully!');
    }

    // Handle Newsletter Subscription
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ]);

        Subscriber::create(['email' => $request->email]);

        return response()->json(['message' => 'Subscribed successfully!']);
    }
}
