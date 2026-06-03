@extends('layouts.app')

@section('title', 'Notif & Komunikasi')

@section('content')
    <section class="panel-grid">
        <article class="panel">
            <h2>Buat Pesan Internal</h2>
            <form class="stack" method="post" action="{{ route('communications.store') }}">
                @csrf
                <label>Penerima<input name="recipient" value="{{ old('recipient') }}" placeholder="gudang, pembelian, owner"></label>
                <label>Subjek<input name="subject" value="{{ old('subject') }}" required></label>
                <label>Pesan<textarea name="message" rows="6" required>{{ old('message') }}</textarea></label>
                <button class="primary" type="submit">Simpan Pesan</button>
            </form>
        </article>

        <article class="panel">
            <h2>Notifikasi Otomatis</h2>
            <p class="muted">Buat pesan untuk semua SKU yang stoknya sudah sama dengan atau di bawah batas minimum.</p>
            <form method="post" action="{{ route('communications.low-stock') }}">
                @csrf
                <button class="primary" type="submit">Buat Notifikasi Stok Minimum</button>
            </form>
        </article>
    </section>

    <section class="panel">
        <h2>Daftar Pesan</h2>
        <table>
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Penerima</th>
                    <th>Subjek</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($messages as $message)
                    <tr>
                        <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $message->recipient ?? '-' }}</td>
                        <td>
                            <strong>{{ $message->subject }}</strong>
                            <p class="muted">{{ $message->message }}</p>
                        </td>
                        <td><span class="badge">{{ $message->status }}</span></td>
                        <td>
                            @if ($message->status !== 'sent')
                                <form method="post" action="{{ route('communications.sent', $message) }}">
                                    @csrf
                                    <button type="submit">Terkirim</button>
                                </form>
                            @else
                                {{ $message->sent_at?->format('d/m/Y H:i') }}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">Belum ada pesan.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $messages->links() }}
    </section>
@endsection
