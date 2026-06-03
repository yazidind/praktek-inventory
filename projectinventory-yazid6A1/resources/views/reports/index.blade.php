@extends('layouts.app')

@section('title', 'Cetak Laporan')

@section('content')
    <section class="toolbar">
        <button class="primary" onclick="window.print()">Cetak Laporan</button>
    </section>

    <section class="stats print-stats">
        <div><span>Total SKU</span><strong>{{ $summary['total_sku'] }}</strong></div>
        <div><span>Total Stok</span><strong>{{ $summary['total_stock'] }}</strong></div>
        <div><span>Nilai Inventory</span><strong>Rp {{ number_format($summary['inventory_value'], 0, ',', '.') }}</strong></div>
        <div><span>Stok Minimum</span><strong>{{ $summary['low_stock_count'] }}</strong></div>
    </section>

    <section class="panel">
        <h2>Daftar Stok Minimum</h2>
        @include('partials.low-stock-table', ['items' => $lowStock])
    </section>

    <section class="panel">
        <h2>Riwayat Mutasi Stok</h2>
        @include('partials.movements-table', ['movements' => $movements])
    </section>
@endsection
