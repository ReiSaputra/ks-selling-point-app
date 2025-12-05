<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function handle()
    {
        // BACA CSV
        $path = storage_path('app/' . $this->path);
        $csv = array_map('str_getcsv', file($path));

        // Ambil header
        $header = array_map('trim', $csv[0]);

        // Hapus header dari data
        $rows = array_slice($csv, 1);

        // Chunking
        $chunks = array_chunk($rows, 1000);

        // Dispatch Job
        foreach ($chunks as $chunk) {
            ImportChunkJob::dispatch($header, $chunk);
        }

    }
}
