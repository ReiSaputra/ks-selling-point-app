# UPGRADE-8-TO-9.md

# Upgrade Laravel 8 → Laravel 9 — Change Log

Dokumen ini berisi catatan seluruh perubahan yang dilakukan dalam proses upgrade proyek dari Laravel 8.x ke Laravel 9.x, termasuk update dependensi, optimasi kueri model, dan perintah yang perlu dijalankan setelah upgrade.

## 1. Update Dependency & Framework

### composer.json

1.1. Perubahan yang dilakukan: - `"laravel/framework"` → `^9.0` - `"nunomaduro/collision"` → `^6.1` - `"php"` → `^8.0`

1.2. Tambah Library baru: - `"spatie/laravel-ignition"` → `"^1.0"`,

1.3 Library yang dihapus: - `fideloper/proxy`

## 2. Perubahan breaking changes

### TrustProxies.php

2.1 Mengubah namespace dengan memakai library Symfony

## 3. Kode yang perlu direvisi (contoh: pagination, factories, routes)

### OrdersImport.php

3.1 Optimasi Query - `Optimasi kueri sebelumnya tidak menggunakan array_chunk. Di sini semua invoice yang sudah ada dicek sekaligus sehingga tidak banyak query, dan orders serta details di-insert secara batch, bukan satu per satu. Queue diberi nama khusus agar bisa diproses paralel, dan ada validasi file agar lebih aman. Dengan cara ini, import menjadi jauh lebih cepat dari 4 menit 20 detik menjadi 2 menit 31 detik dengan data order sebanyak 10.000 dan order_detail sebanyak 30.000 dan proses lebih stabil.`
