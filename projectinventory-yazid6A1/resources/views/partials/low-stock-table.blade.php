<table>
    <thead>
        <tr>
            <th>SKU</th>
            <th>Nama</th>
            <th>Ukuran</th>
            <th>Stok</th>
            <th>Minimum</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($items as $shoe)
            <tr>
                <td>{{ $shoe->sku }}</td>
                <td>{{ $shoe->name }}</td>
                <td>{{ $shoe->size }}</td>
                <td><span class="badge danger">{{ $shoe->stock }}</span></td>
                <td>{{ $shoe->minimum_stock }}</td>
            </tr>
        @empty
            <tr><td colspan="5">Tidak ada stok minimum.</td></tr>
        @endforelse
    </tbody>
</table>
