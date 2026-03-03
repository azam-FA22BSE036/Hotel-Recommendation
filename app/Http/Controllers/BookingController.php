<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Show My Bookings
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('bookings.index', compact('bookings'));
    }

    // Show Checkout/Estimation Form
    public function create(Request $request)
    {
        $hotelName = $request->query('hotel_name');
        $price = $request->query('price');
        $url = $request->query('url'); // Get the external URL
        
        // Fix: If URL is missing, invalid, or generic, generate a deep link to Booking.com search
        if (empty($url) || $url === '#' || $url === 'http://booking.com') {
            // Create a search URL for the specific hotel
            $url = 'https://www.booking.com/searchresults.html?ss=' . urlencode($hotelName);
        }

        return view('bookings.create', compact('hotelName', 'price', 'url'));
    }

    // Process Booking (Optional now, but kept for history tracking if we want)
    public function store(Request $request)
    {
        // ... (Logic can remain if we want to save "intent" or just redirect)
        // For now, we will focus on the create view handling the redirect
    }
}
