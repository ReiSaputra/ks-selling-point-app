# UPGRADE-9-TO-10.md
# Upgrade Laravel 9 → Laravel 10 — Change Log

Dokumen ini berisi catatan seluruh perubahan yang dilakukan dalam proses upgrade proyek dari Laravel 9.x ke Laravel 10.x, termasuk update dependency, perubahan breaking changes, revisi kode aplikasi, dan langkah-langkah testing.

## 1. Update Dependency & Framework
### composer.json

1.1. Perubahan yang dilakukan:

    - "laravel/framework" → ^10.0
    - "php" → minimal PHP 8.1 (PHP 8.3 juga kompatibel)
    - "nunomaduro/collision" → ^7.0
    - "spatie/laravel-ignition" → ^2.0
    - "phpunit/phpunit" → ^10.0 (untuk dev)

1.2. Tambah Library baru:
    - `"spatie/laravel-ignition"` → `"^2.0"`,
    (Laravel 10 sudah handle CORS via middleware bawaan).

1.3 Library yang dihapus:
    - `"fruitcake/laravel-cors"` → `"^2.0"`,

## 2. Perubahan breaking changes
# Berikut adalah perubahan signifikan dari Laravel 9 → Laravel 10.

2.1. Penghapusan $namespace di RouteServiceProvider
    Laravel 10 tidak lagi menggunakan:
        - `protected $namespace = 'App\Http\Controllers';`


2.2. Metode map() di RouteServiceProvider sudah tidak digunakan
    Kode seperti:

    public function map() {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }
    
→ dihapus dan diganti dengan struktur routes default Laravel 10.

2.3. Model factories
    Factory lama berbasis class tetap kompatibel, tetapi disarankan mengikuti pola Laravel 10.

2.4. Middleware TrustHosts & TrustProxies
    Tidak ada breaking besar, tetapi file bawaan berubah versi.

2.5 Middleware Changes (Kernel.php) — Penting
    Laravel 10 memakai Kernel yang lebih sederhana dan beberapa middleware diganti/dipindah.

    Perubahan penting pada Kernel.php

    Tidak perlu lagi:
    `````````````````````````````````````````````````
    \Fruitcake\Cors\HandleCors::class
    `````````````````````````````````````````````````

    Sekarang:
    `````````````````````````````````````````````````
    \Illuminate\Http\Middleware\HandleCors::class
    `````````````````````````````````````````````````


