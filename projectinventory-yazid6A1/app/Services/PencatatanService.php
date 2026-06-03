<?php

namespace App\Services;

use App\Models\Shoe;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class PencatatanService
{
    public function createShoe(array $data): Shoe
    {
        return Shoe::create($data);
    }

    public function updateShoe(Shoe $shoe, array $data): Shoe
    {
        $shoe->update($data);

        return $shoe->refresh();
    }

    public function recordMovement(Shoe $shoe, string $type, int $quantity, array $meta = []): StockMovement
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException('Jumlah stok harus lebih dari 0.');
        }

        return DB::transaction(function () use ($shoe, $type, $quantity, $meta): StockMovement {
            $shoe->refresh();
            $before = $shoe->stock;
            $after = match ($type) {
                'in' => $before + $quantity,
                'out', 'adjustment' => $before - $quantity,
                default => throw new InvalidArgumentException('Tipe mutasi stok tidak valid.'),
            };

            if ($after < 0) {
                throw new InvalidArgumentException('Stok tidak boleh kurang dari 0.');
            }

            $shoe->update(['stock' => $after]);

            return StockMovement::create([
                'shoe_id' => $shoe->id,
                'type' => $type,
                'quantity' => $quantity,
                'stock_before' => $before,
                'stock_after' => $after,
                'reference' => $meta['reference'] ?? null,
                'notes' => $meta['notes'] ?? null,
                'created_by' => $meta['created_by'] ?? null,
            ]);
        });
    }
}
