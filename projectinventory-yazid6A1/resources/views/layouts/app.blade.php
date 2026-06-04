<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="topbar">
        <div>
            <p class="eyebrow">Inventory Sepatu</p>
            <h1>@yield('title', 'Dashboard')</h1>
        </div>
        @auth
            <nav>
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('inventory.index') }}">Pencatatan</a>
                <a href="{{ route('reports.index') }}">Cetak Laporan</a>
                <a href="{{ route('communications.index') }}">Notif & Komunikasi</a>
                <form class="logout-form" method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </nav>
        @endauth
    </header>

    <main class="container">
        @if (session('status'))
            <div class="notice">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
