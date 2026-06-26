<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Partner; // Tambahkan ini agar variabel $partners tidak error
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('category')->latest();

        // Logika filter kategori jika ada parameter di URL
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $events = $query->get();
        $categories = Category::all();
        $partners = Partner::all(); // Pastikan data partner diambil

        return view('welcome', compact('events', 'categories', 'partners'));
    }
}
