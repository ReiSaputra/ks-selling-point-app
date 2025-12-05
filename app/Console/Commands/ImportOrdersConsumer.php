<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ImportOrdersConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-orders-consumer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $group = 'orders_group';
        $consumer = 'worker_' . uniqid();

        // Buat consumer group kalau belum ada
        try {
            Redis::xgroup('CREATE', 'import_orders', $group, '0', true);
        } catch (\Exception $e) {
        }

        while (true) {

            $data = Redis::xreadgroup(
                $group,
                $consumer,
                ['import_orders' => '>'],
                500 // <-- batch size
            );

            if (!$data) {
                usleep(200000); // sleep 0.2s
                continue;
            }

            $batch = [];

            foreach ($data['import_orders'] as $id => $item) {
                $row = json_decode($item['data'], true);

                // convert row menjadi orders + detail
                $batch[] = $row;

                // Mark processed
                Redis::xack('import_orders', $group, $id);
            }

            $this->insertBatch($batch);
        }
    }

    private function insertBatch(array $rows)
    {
        // ----
        // PROSES GROUPING + BULK INSERT
        // (ambil dari code kamu sebelumnya)
        // ----

        DB::transaction(function () use ($rows) {

            $ordersToInsert = [];
            $detailsToInsert = [];

            foreach ($rows as $row) {

                $ordersToInsert[] = [
                    'invoice_number' => $row['invoice_number'],
                    'channel' => $row['channel'],
                    // dst...
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $detailsToInsert[] = [
                    'product_sku' => $row['product_sku'],
                    'quantity' => $row['quantity'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (!empty($ordersToInsert)) {
                DB::table('orders')->insert($ordersToInsert);
            }

            foreach (array_chunk($detailsToInsert, 500) as $chunk) {
                DB::table('order_details')->insert($chunk);
            }
        });
    }
}
