<?php

namespace App\Http\Controllers;

use App\Models\MedicalCase;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the medical administration dashboard.
     */
    public function index(): View
    {
        $totalCases = MedicalCase::count();
        $planningCases = MedicalCase::where('status', MedicalCase::STATUS_PLANNING)->count();
        $inReviewCases = MedicalCase::where('status', MedicalCase::STATUS_IN_REVIEW)->count();
        $approvedCases = MedicalCase::where('status', MedicalCase::STATUS_APPROVED)->count();
        $completedCases = MedicalCase::where('status', MedicalCase::STATUS_COMPLETED)->count();

        // High priority pending attention
        $highPriorityCount = MedicalCase::where('priority', 'High')
            ->whereNotIn('status', [MedicalCase::STATUS_COMPLETED, MedicalCase::STATUS_CANCELLED])
            ->count();

        // Recent cases for the dashboard summary table
        $recentCases = MedicalCase::with('creator:id,name,email')
            ->latest('id')
            ->take(6)
            ->get();

        return view('dashboard', compact(
            'totalCases',
            'planningCases',
            'inReviewCases',
            'approvedCases',
            'completedCases',
            'highPriorityCount',
            'recentCases'
        ));
    }
}
