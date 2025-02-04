<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;

class IndexController extends Controller
{
    public function index()
    {
        // Fetch active fields for display
        $fields = Lapangan::where('status', 'active')
            ->latest()
            ->take(6)
            ->get();

        return view('index', compact('fields'));
    }
}
