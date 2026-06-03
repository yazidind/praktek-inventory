<?php

namespace App\Http\Controllers;

use App\Models\NotificationMessage;
use App\Services\NotifKomunikasiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommunicationController extends Controller
{
    public function index(): View
    {
        return view('communications.index', [
            'messages' => NotificationMessage::query()->latest()->paginate(20),
        ]);
    }

    public function store(Request $request, NotifKomunikasiService $service): RedirectResponse
    {
        $data = $request->validate([
            'recipient' => ['nullable', 'string', 'max:120'],
            'subject' => ['required', 'string', 'max:160'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $service->createInternalMessage($data['subject'], $data['message'], $data['recipient'] ?? null);

        return back()->with('status', 'Pesan internal berhasil dibuat.');
    }

    public function lowStock(NotifKomunikasiService $service): RedirectResponse
    {
        $count = $service->queueLowStockAlerts()->count();

        return back()->with('status', "{$count} notifikasi stok minimum dibuat.");
    }

    public function sent(NotificationMessage $notification, NotifKomunikasiService $service): RedirectResponse
    {
        $service->markSent($notification);

        return back()->with('status', 'Notifikasi ditandai terkirim.');
    }
}
