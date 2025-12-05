
# UPGRADE-11-TO-12.md
## Upgrade Laravel 11 → Laravel 12 — Change Log

Dokumen ini berisi seluruh perubahan yang dilakukan dalam proses upgrade proyek dari Laravel 11.x ke Laravel 12.x, termasuk update dependency, perubahan breaking changes, revisi struktur aplikasi, dan langkah-langkah yang perlu dilakukan setelah proses upgrade.

-------------------------------------

## 1. Update Dependency & Framework

### composer.json

### 1.1 Perubahan yang dilakukan:

    -   "php" → ^8.3
    -   "laravel/framework" → ^12.0
    -   "spatie/laravel-ignition" → ^3.0
    -   "nunomaduro/collision" → ^8.1
    -   "phpunit/phpunit" → ^11.0
    -   "laravel/tinker" → ^2.9
    -   "fakerphp/faker" → ^1.22


## 2. Breaking Changes

Laravel 12 tidak membawa perubahan besar seperti saat transisi ke Laravel 11, tetapi tetap ada beberapa hal yang harus diperhatikan.