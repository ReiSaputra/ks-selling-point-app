# UPGRADE-10-TO-11.md

# Upgrade Laravel 10 → Laravel 11 — Change Log

Dokumen ini berisi catatan seluruh perubahan yang dilakukan dalam proses upgrade proyek dari Laravel 10.x ke Laravel 11.x, termasuk update dependency, perubahan breaking changes, revisi struktur aplikasi, serta penyesuaian pada komponen framework.

---

## 1. Update Dependency & Framework

### composer.json

### 1.1 Perubahan yang dilakukan:

-   `"laravel/framework"` → `^11.0`
-   `"php"` → minimal **PHP 8.2**
-   `"nunomaduro/collision"` → `^8.1`

## 2. Breaking Changes

Tidak ada perubahan signifikan yang harus merubah struktur kode.

## 3. Kode yang perlu direvisi (contoh: pagination, factories, routes)

### OrdersImport.php

Disini ada perubahan pada bagaimana kecepatan optimasi query untuk 1.000 data, menggunakan query builder lebih sedikit cepat daripada harus menggunakan ORM.
