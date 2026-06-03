<table>
    <thead>
        <tr>
            <th>Waktu</th>
            <th>SKU</th>
            <th>Tipe</th>
            <th>Jumlah</th>
            <th>Stok</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($movements as $movement)
            <tr>
                <td>{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $movement->shoe?->sku }}</td>
                <td><span class="badge">{{ strtoupper($movement->type) }}</span></td>
                <td>{{ $movement->quantity }}</td>
                <td>{{ $movement->stock_before }} -> {{ $movement->stock_after }}</td>
            </tr>
        @empty
            <tr><td colspan="5">Belum ada mutasi stok.</td></tr>
        @endforelse
    </tbody>
</table>
