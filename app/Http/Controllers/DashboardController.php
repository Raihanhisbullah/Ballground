<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lapangan;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Get total count of football fields
        $totalFields = Lapangan::count();

        // Get count of active fields
        $activeFields = Lapangan::where('status', 'aktif')->count();

        // Calculate percentage of active fields
        $fieldPercentage = $totalFields > 0
            ? round(($activeFields / $totalFields) * 100)
            : 0;

        // Get count of active users
        $activeUsers = User::where('status', 'active')->count();

        return view('dashboard', compact(
            'totalFields',
            'fieldPercentage',
            'activeUsers'
        ));
    }
}
