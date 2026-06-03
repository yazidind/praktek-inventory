<?php

namespace App\Http\Controllers;

use App\Services\CetakLaporanService;
use Illuminate\Contracts\View\View;

class ReportController extends Controller
{
    public function index(CetakLaporanService $service): View
    {
        return view('reports.index', [
            'summary' => $service->inventorySummary(),
            'lowStock' => $service->lowStock(),
            'movements' => $service->latestMovements(),
        ]);
    }
}
