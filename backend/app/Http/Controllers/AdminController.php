<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Enquiry;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function stats()
    {
        $thisMonthStart = Carbon::now()->startOfMonth();

        return response()->json([
            'total_admissions' => Admission::count(),
            'total_enquiries'  => Enquiry::count(),
            'this_month'       => Admission::where('created_at', '>=', $thisMonthStart)->count()
                                + Enquiry::where('created_at', '>=', $thisMonthStart)->count(),
            'pending'          => Admission::where('status', 'pending')->count(),
            'admissions_by_program' => Admission::selectRaw('program, count(*) as count')
                                        ->groupBy('program')->get(),
            'monthly_admissions' => Admission::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                                        ->whereYear('created_at', Carbon::now()->year)
                                        ->groupBy('month')->orderBy('month')->get(),
        ]);
    }
}
