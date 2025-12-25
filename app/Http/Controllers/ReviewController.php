<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        Review::create([
            'name' => $validated['name'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_approved' => false, // Reviews need admin approval
        ]);

        return response()->json([
            'success' => true,
            'message' => 'We are Glad you enjoyed your stay. Choose us Again!'
        ]);
    }
}
