@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <section class="auth-panel">
        <div>
            <p class="eyebrow">Akses Terproteksi</p>
            <h2>Masuk ke Inventory Sepatu</h2>
            <p class="muted">Gunakan akun OAuth yang sudah dikonfigurasi di environment aplikasi.</p>
        </div>

        <a class="primary auth-button" href="{{ route('oauth.redirect') }}">
            Login dengan {{ ucfirst($provider) }}
        </a>
    </section>
@endsection
