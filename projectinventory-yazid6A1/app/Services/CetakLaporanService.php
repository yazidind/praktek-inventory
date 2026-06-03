<?php

namespace App\Services;

use App\Models\Shoe;
use App\Models\StockMovement;
use Illuminate\Support\Collection;

class CetakLaporanService
{
    public function inventorySummary(): array
    {
        return [
            'total_sku' => Shoe::count(),
            'total_stock' => (int) Shoe::sum('stock'),
            'inventory_value' => (float) Shoe::query()->selectRaw('COALESCE(SUM(stock * purchase_price), 0) as value')->value('value'),
            'low_stock_count' => Shoe::query()->whereColumn('stock', '<=', 'minimum_stock')->count(),
        ];
    }

    public function lowStock(): Collection
    {
        return Shoe::query()
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock')
            ->get();
    }

    public function latestMovements(int $limit = 50): Collection
    {
        return StockMovement::query()
            ->with('shoe')
            ->latest()
            ->limit($limit)
            ->get();
    }
}
