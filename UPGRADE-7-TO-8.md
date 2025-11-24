# UPGRADE-7-TO-8.md

# Upgrade Laravel 7 → Laravel 8 — Change Log

Dokumen ini berisi catatan seluruh perubahan yang dilakukan dalam proses upgrade proyek dari Laravel 7.x ke Laravel 8.x, termasuk update dependensi, perbaikan struktur model, migrasi factory baru, perubahan namespace routing, dan perintah yang perlu dijalankan setelah upgrade.

## 1. Update Framework & Dependencies

### composer.json

1.1. Perubahan yang dilakukan: - `"laravel/framework"` → `^8.0` - `"php"` → `^7.3`

1.2. Tambah Library baru: - `"fakerphp/faker": "^1.9.1"`

1.3. Hapus Library: - `fzaninotto/faker`

1.4. Update versi Library agar kompatibel: - `"guzzlehttp/guzzle": "^7.0.1"` - `"nunomaduro/collision": "^5.0"` - `"phpunit/phpunit": "^9.0"`

1.5. Setelah update, jalankan:

    ```````````````````````````````````
    composer update
    composer install
    ```````````````````````````````````

## 2. Pemindahan Model ke Folder Baru (app/Models)

# Laravel 8 memperkenalkan folder default untuk model.

2.1. Perubahan dilakukan:

-   Membuat folder `app/Models/`
-   Memindahkan model:

    -   `Order.php`
    -   `OrderDetail.php`
    -   `User.php`

    2.2. Mengubah namespace:
    dari:

```
namespace App;
```

menjadi:

```
namespace App\Models;
```

2.3. Perubahan import di controller, factory, dan seeder:

Contoh:

```
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
```

## 3. Perubahan Route Syntax (Breaking Change Laravel 8)

# Laravel 8 menghapus route namespace otomatis.

3.1. Perubahan dilakukan:

Laravel 7 (string-based controller):

```
Route::get('/order-list', 'OrderListController@show');
```

Laravel 8 (array + class reference):

```
use App\Http\Controllers\OrderListController;
Route::get('/order-list', [OrderListController::class, 'show']);
```

3.2. Semua route dalam `web.php` sudah diperbarui ke format Laravel 8.

## 4. Migrasi Factory Lama → Factory Baru (Class-Based)

# Laravel 8 mengganti sistem factory lama.

### Factory lama (Dihapus)

-   `database/factories/OrderFactory.php`
-   `database/factories/OrderDetailFactory.php`
-   `database/factories/UserFactory.php`

### Factory baru (Dibuat)

-   `database/factories/OrderFactory.php`
-   `database/factories/OrderDetailFactory.php`
-   `database/factories/UserFactory.php`

    4.1. Menggunakan struktur:

```
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [ ... ];
    }
}
```

4.2. Model wajib ditambahkan trait:

    ```````````````````````````````````````````````````````
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    ```````````````````````````````````````````````````````

## 5. Update Seeder ke Format Baru

# Seeder lama menggunakan `factory()` sudah tidak berlaku.

Laravel 7:

    `````````````````````````````````````````
    factory(App\Order::class, 100)->create();
    `````````````````````````````````````````

Laravel 8:

    ```````````````````````````````````````
    Order::factory()->count(100)->create();
    ```````````````````````````````````````

5.1. Seeder yang diperbarui:

    - `OrdersTableSeeder.php`
    - `DatabaseSeeder.php`

## 6. Update Relationship Model

# Karena namespace berubah, relasi disesuaikan:

### Order.php

```
public function details()
{
    return $this->hasMany(OrderDetail::class);
}
```

### OrderDetail.php

    ``````````````````````````````````````````
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    ``````````````````````````````````````````

## 7. Update Auth Model Path

7.1. Karena User pindah ke `app/Models/User.php`, maka:

    `config/auth.php`:

    ````````````````````````````````
    'model' => App\Models\User::class,
    ````````````````````````````````

## 8. Perintah Setelah Upgrade

8.1. Setelah upgrade, jalankan perintah berikut:

    ````````````````````````````````
    composer dump-autoload
    php artisan migrate
    php artisan db:seed
    php artisan config:clear
    php artisan route:clear
    php artisan cache:clear
    ````````````````````````````````

8.2. Jika database ingin fresh:

    ````````````````````````````````
    php artisan migrate:fresh --seed
    ````````````````````````````````

## 9. Git Workflow (Branch Upgrade)

9.1. Buat branch baru:

    ````````````````````````````````````
    git checkout -b upgrade-laravel-7-to-8
    ````````````````````````````````````

9.2. Setelah update selesai:

    ````````````````````````````````
    git add .
    git commit -m "Upgrade Laravel 7 to Laravel 8: model restructure, route namespace fix, new factories, seeder update, composer update"
    git push origin upgrade-laravel-7-to-8
    ````````````````````````````````

# 10. Upgrade Completed

# Proyek telah resmi kompatibel dengan Laravel 8, termasuk pembaruan besar seperti:

    - Route middleware syntax baru
    - Model folder
    - Factory system modern
    - Seeder modern
    - Dependency upgrade

    Dokumen ini dibuat untuk memudahkan developer lain memahami perubahan.
