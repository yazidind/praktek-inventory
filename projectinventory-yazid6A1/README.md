# Inventory Sepatu Laravel

Aplikasi inventory sepatu berbasis Laravel dengan PostgreSQL Neon, Docker Compose, dan Traefik.

## Service aplikasi

- `pencatatan`: pencatatan master sepatu dan mutasi stok masuk/keluar.
- `cetak-laporan`: ringkasan inventory, stok minimum, dan riwayat mutasi yang bisa dicetak.
- `notif-komunikasi`: pesan internal dan notifikasi otomatis untuk stok minimum.

## Konfigurasi Neon PostgreSQL

Salin `.env.example` ke `.env`, lalu isi koneksi Neon:

```env
DB_HOST=ep-your-neon-host.ap-southeast-1.aws.neon.tech
DB_PORT=5432
DB_DATABASE=neondb
DB_USERNAME=neondb_owner
DB_PASSWORD=password-neon
DB_SSLMODE=require
```

Untuk Docker Compose, variabel di `.env` akan dibaca otomatis.

## Menjalankan dengan Docker dan Traefik

```bash
docker compose up --build
```

Traefik dashboard:

```text
http://localhost:8080
```

URL service:

```text
http://pencatatan.localhost
http://laporan.localhost
http://komunikasi.localhost
```

Setiap container menjalankan migrasi Laravel otomatis saat start.

## Struktur penting

- `app/Services/PencatatanService.php`
- `app/Services/CetakLaporanService.php`
- `app/Services/NotifKomunikasiService.php`
- `database/migrations`
- `routes/web.php`
- `docker-compose.yml`
