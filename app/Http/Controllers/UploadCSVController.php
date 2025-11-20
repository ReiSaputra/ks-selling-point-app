<?php

namespace App\Http\Controllers;

use App\Imports\OrdersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UploadCSVController extends Controller
{
    public function show()
    {
        return view("page.upload-csv");
    }

    public function perform(Request $request)
    {
        set_time_limit(0);
        Excel::queueImport(new OrdersImport, $request->file('file'));

        return redirect()->route("upload-csv")->with("success", "Data berhasil disimpan");
    }
}
