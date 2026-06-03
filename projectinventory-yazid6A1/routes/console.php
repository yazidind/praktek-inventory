<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Artisan::command('inventory:summary', function (): void {
    $this->call('about');
})->purpose('Tampilkan ringkasan aplikasi inventory.');

Artisan::command('inventory:repair-schema', function (): void {
    $statements = [
        'DROP TABLE IF EXISTS stock_movements CASCADE',
        'DROP TABLE IF EXISTS notification_messages CASCADE',
        'DROP TABLE IF EXISTS shoes CASCADE',
        'DROP TABLE IF EXISTS migrations CASCADE',
        'DROP INDEX IF EXISTS shoes_sku_unique',
        'DROP SEQUENCE IF EXISTS migrations_id_seq CASCADE',
        'DROP SEQUENCE IF EXISTS shoes_id_seq CASCADE',
        'DROP SEQUENCE IF EXISTS stock_movements_id_seq CASCADE',
        'DROP SEQUENCE IF EXISTS notification_messages_id_seq CASCADE',
    ];

    foreach ($statements as $statement) {
        DB::statement($statement);
        $this->line($statement);
    }
})->purpose('Bersihkan objek schema inventory yang gagal dibuat saat migrasi paralel.');
