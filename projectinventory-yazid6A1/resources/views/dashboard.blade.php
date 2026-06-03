@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="stats">
        <div><span>Total SKU</span><strong>{{ $summary['total_sku'] }}</strong></div>
        <div><span>Total Stok</span><strong>{{ $summary['total_stock'] }}</strong></div>
        <div><span>Nilai Inventory</span><strong>Rp {{ number_format($summary['inventory_value'], 0, ',', '.') }}</strong></div>
        <div><span>Stok Minimum</span><strong>{{ $summary['low_stock_count'] }}</strong></div>
    </section>

    <section class="panel-grid">
        <article class="panel">
            <div class="panel-head">
                <h2>Stok Perlu Perhatian</h2>
                <a href="{{ route('communications.index') }}">Buat Notifikasi</a>
            </div>
            @include('partials.low-stock-table', ['items' => $lowStock])
        </article>

        <article class="panel">
            <div class="panel-head">
                <h2>Mutasi Terbaru</h2>
                <a href="{{ route('reports.index') }}">Laporan</a>
            </div>
            @include('partials.movements-table', ['movements' => $movements])
        </article>
    </section>
@endsection
