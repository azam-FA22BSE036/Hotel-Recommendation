<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('wishlist', compact('wishlists'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hotel_name' => 'required',
            'image' => 'nullable|string',
            'price' => 'nullable|numeric',
            'rating' => 'nullable|numeric',
            'location' => 'nullable|string',
            'url' => 'nullable|string',
        ]);

        // Check if already exists
        $exists = Wishlist::where('user_id', Auth::id())
            ->where('hotel_name', $request->hotel_name)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Hotel already in wishlist', 'status' => 'exists']);
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'hotel_name' => $request->hotel_name,
            'image' => $request->image,
            'price' => $request->price,
            'rating' => $request->rating,
            'location' => $request->location,
            'url' => $request->url,
        ]);

        return response()->json(['message' => 'Hotel added to wishlist', 'status' => 'success']);
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->findOrFail($id);
        $wishlist->delete();

        return redirect()->back()->with('success', 'Hotel removed from wishlist.');
    }
}
