<?php

namespace App\Http\Controllers;

use App\Models\Companion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the user profile dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $companions = $user->companions()->orderBy('name', 'asc')->get();

        return view('profile', compact('user', 'companions'));
    }

    /**
     * Update the user profile and preferences.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'passport_number' => 'nullable|string|max:50',
            'birth_date' => 'nullable|date|before:today',
            'preferred_class' => 'nullable|string|in:Economy,Premium Economy,Business,First',
            'preferred_diet' => 'nullable|string|max:100',
            'preferred_bed' => 'nullable|string|max:100',
            'preferred_airport' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'passport_number' => $request->passport_number,
            'birth_date' => $request->birth_date,
            'preferences' => [
                'preferred_class' => $request->preferred_class,
                'preferred_diet' => $request->preferred_diet,
                'preferred_bed' => $request->preferred_bed,
                'preferred_airport' => $request->preferred_airport,
            ]
        ]);

        return back()->with('success', 'Your profile and travel preferences have been saved successfully!');
    }

    /**
     * Add a new family member or friend (companion).
     */
    public function storeCompanion(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'companion_name' => 'required|string|max:255',
            'companion_email' => 'nullable|email|max:255',
            'companion_passport' => 'nullable|string|max:50',
            'companion_dob' => 'nullable|date|before:today',
            'relationship' => 'required|string|max:100',
        ]);

        $user->companions()->create([
            'name' => $request->companion_name,
            'email' => $request->companion_email,
            'passport_number' => $request->companion_passport,
            'birth_date' => $request->companion_dob,
            'relationship' => $request->relationship,
        ]);

        return back()->with('success', 'Family member / friend added successfully!');
    }

    /**
     * Delete a companion record.
     */
    public function destroyCompanion(Companion $companion)
    {
        // Security check: Verify that this companion belongs to the logged-in user
        if ($companion->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $companion->delete();

        return back()->with('success', 'Companion removed successfully!');
    }
}
