@extends('layouts.app')

@section('title', 'Pencatatan Inventory')

@section('content')
    <section class="panel">
        <h2>Tambah Sepatu</h2>
        <form class="form-grid" method="post" action="{{ route('inventory.store') }}">
            @csrf
            <label>SKU<input name="sku" value="{{ old('sku') }}" required></label>
            <label>Nama<input name="name" value="{{ old('name') }}" required></label>
            <label>Brand<input name="brand" value="{{ old('brand') }}"></label>
            <label>Kategori<input name="category" value="{{ old('category') }}"></label>
            <label>Ukuran<input name="size" value="{{ old('size') }}" required></label>
            <label>Warna<input name="color" value="{{ old('color') }}"></label>
            <label>Harga Beli<input type="number" name="purchase_price" min="0" step="0.01" value="{{ old('purchase_price', 0) }}" required></label>
            <label>Harga Jual<input type="number" name="selling_price" min="0" step="0.01" value="{{ old('selling_price', 0) }}" required></label>
            <label>Stok Awal<input type="number" name="stock" min="0" value="{{ old('stock', 0) }}" required></label>
            <label>Minimum Stok<input type="number" name="minimum_stock" min="0" value="{{ old('minimum_stock', 5) }}" required></label>
            <label>Lokasi<input name="location" value="{{ old('location') }}"></label>
            <label>Status
                <select name="status" required>
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </label>
            <button class="primary" type="submit">Simpan Sepatu</button>
        </form>
    </section>

    <section class="panel">
        <h2>Daftar Sepatu</h2>
        <table>
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Nama</th>
                    <th>Ukuran</th>
                    <th>Stok</th>
                    <th>Lokasi</th>
                    <th>Mutasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($shoes as $shoe)
                    <tr>
                        <td>{{ $shoe->sku }}</td>
                        <td>{{ $shoe->brand }} {{ $shoe->name }}</td>
                        <td>{{ $shoe->size }}</td>
                        <td>
                            <span class="badge {{ $shoe->isLowStock() ? 'danger' : '' }}">{{ $shoe->stock }}</span>
                        </td>
                        <td>{{ $shoe->location }}</td>
                        <td>
                            <form class="inline-form" method="post" action="{{ route('inventory.movement', $shoe) }}">
                                @csrf
                                <select name="type">
                                    <option value="in">Masuk</option>
                                    <option value="out">Keluar</option>
                                    <option value="adjustment">Koreksi Kurang</option>
                                </select>
                                <input type="number" name="quantity" min="1" value="1" required>
                                <input name="reference" placeholder="Referensi">
                                <button type="submit">Catat</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6">Belum ada data sepatu.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $shoes->links() }}
    </section>
@endsection
