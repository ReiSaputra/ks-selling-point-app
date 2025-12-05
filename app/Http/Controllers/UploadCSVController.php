<?php

namespace App\Http\Controllers;

use App\Imports\OrdersImport;
use App\Jobs\ImportOrdersChunk;
use App\Jobs\ProcessCsvJob;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use SplFileObject;

class UploadCSVController extends Controller
{
    public function show()
    {
        return view("page.upload-csv");
    }

    public function perform(Request $request)
    {
        set_time_limit(0);

        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        // Simpan file CSV ke storage
        $path = $request->file('file')->store('imports');

        // Dispatch job pertama (proses CSV)
        ProcessCsvJob::dispatch($path);

        return redirect()->route("order-list")->with("success", "CSV uploaded successfully");
    }
}
