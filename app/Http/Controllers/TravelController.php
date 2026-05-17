<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Activity;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    public function index()
    {
        $activities = Activity::all();
        return view('welcome', compact('activities'));
    }

    public function recommend(Request $request)
    {
        $request->validate([
            'budget' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'activities' => 'array',
        ]);

        $budget = $request->budget;
        $startMonth = date('n', strtotime($request->start_date));
        $endMonth = date('n', strtotime($request->end_date));
        
        // Months range (simple overlap)
        $userMonths = range($startMonth, $endMonth);
        if ($endMonth < $startMonth) {
            // Hande wrap around year if needed, but for simplicity we assume months in same year or simple range
            $userMonths = array_merge(range($startMonth, 12), range(1, $endMonth));
        }

        $query = Destination::query();

        // 1. Filter by budget
        $query->where('min_budget', '<=', $budget);

        // 2. Filter by season (best_months)
        // We select destinations that have AT LEAST one month in common with user's travel dates
        $query->where(function($q) use ($userMonths) {
            foreach($userMonths as $month) {
                $q->orWhereJsonContains('best_months', (int)$month);
            }
        });

        // 3. Filter by activities if selected
        if ($request->has('activities')) {
            $query->whereHas('activities', function($q) use ($request) {
                $q->whereIn('activities.id', $request->activities);
            });
        }

        $destinations = $query->with('activities')->get();

        return view('recommendations', compact('destinations', 'budget'));
    }
}
