<?php

namespace App\Services;

use App\Models\NotificationMessage;
use App\Models\Shoe;
use Illuminate\Support\Collection;

class NotifKomunikasiService
{
    public function queueLowStockAlerts(): Collection
    {
        return Shoe::query()
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->get()
            ->map(fn (Shoe $shoe) => $this->createInternalMessage(
                'Stok minimum tercapai',
                "SKU {$shoe->sku} - {$shoe->name} tersisa {$shoe->stock}. Minimum: {$shoe->minimum_stock}.",
                'gudang'
            ));
    }

    public function createInternalMessage(string $subject, string $message, ?string $recipient = null): NotificationMessage
    {
        return NotificationMessage::create([
            'channel' => 'internal',
            'recipient' => $recipient,
            'subject' => $subject,
            'message' => $message,
            'status' => 'queued',
        ]);
    }

    public function markSent(NotificationMessage $notification): NotificationMessage
    {
        $notification->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        return $notification->refresh();
    }
}
