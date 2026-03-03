<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();
        return view('hotels.index', compact('hotels'));
    }

    public function create()
    {
        return view('hotels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'numeric',
        ]);

        Hotel::create($request->all());

        return redirect()->route('hotels.index')->with('success', 'Hotel created successfully.');
    }

    public function show(Hotel $hotel)
    {
        return view('hotels.show', compact('hotel'));
    }

    public function edit(Hotel $hotel)
    {
        return view('hotels.edit', compact('hotel'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $hotel->update($request->all());

        return redirect()->route('hotels.index')->with('success', 'Hotel updated successfully');
    }

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();

        return redirect()->route('hotels.index')->with('success', 'Hotel deleted successfully');
    }

    public function publicRooms(Request $request)
    {
        $cities = Hotel::select('city')
            ->whereNotNull('city')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        $query = Hotel::query();

        if ($request->filled('city')) {
            $query->where('city', $request->input('city'));
        }

        if ($request->filled('location')) {
            $location = $request->input('location');
            $query->where(function ($q) use ($location) {
                $q->where('address', 'LIKE', "%$location%")
                  ->orWhere('city', 'LIKE', "%$location%");
            });
        }

        $hotels = $query->inRandomOrder()->paginate(9); // Recommended rooms, different order each visit
        $hotels->appends($request->query());

        return view('rooms', compact('hotels', 'cities'));
    }

    public function publicRoomDetail(Hotel $hotel)
    {
        return view('room-detail', compact('hotel'));
    }

    public function bookingPage(Request $request)
    {
        $hotels = Hotel::paginate(9);
        return view('booking', compact('hotels'));
    }
}
