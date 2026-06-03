<?php

namespace App\Http\Controllers;

use App\Services\CetakLaporanService;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(CetakLaporanService $reports): View
    {
        return view('dashboard', [
            'summary' => $reports->inventorySummary(),
            'lowStock' => $reports->lowStock(),
            'movements' => $reports->latestMovements(10),
            'serviceRole' => env('SERVICE_ROLE', 'all'),
        ]);
    }
}
