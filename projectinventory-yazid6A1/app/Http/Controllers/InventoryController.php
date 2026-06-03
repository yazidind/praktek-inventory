<?php

namespace App\Http\Controllers;

use App\Models\Shoe;
use App\Services\PencatatanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(): View
    {
        return view('inventory.index', [
            'shoes' => Shoe::query()->latest()->paginate(15),
        ]);
    }

    public function store(Request $request, PencatatanService $service): RedirectResponse
    {
        $service->createShoe($this->validatedShoe($request));

        return back()->with('status', 'Data sepatu berhasil dicatat.');
    }

    public function movement(Request $request, Shoe $shoe, PencatatanService $service): RedirectResponse
    {
        $data = $request->validate([
            'type' => ['required', 'in:in,out,adjustment'],
            'quantity' => ['required', 'integer', 'min:1'],
            'reference' => ['nullable', 'string', 'max:120'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'created_by' => ['nullable', 'string', 'max:120'],
        ]);

        $service->recordMovement($shoe, $data['type'], (int) $data['quantity'], $data);

        return back()->with('status', 'Mutasi stok berhasil dicatat.');
    }

    private function validatedShoe(Request $request): array
    {
        return $request->validate([
            'sku' => ['required', 'string', 'max:80', 'unique:shoes,sku'],
            'name' => ['required', 'string', 'max:160'],
            'brand' => ['nullable', 'string', 'max:120'],
            'category' => ['nullable', 'string', 'max:120'],
            'size' => ['required', 'string', 'max:20'],
            'color' => ['nullable', 'string', 'max:80'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'location' => ['nullable', 'string', 'max:120'],
            'status' => ['required', 'in:active,inactive'],
        ]);
    }
}
