<?php

namespace App\Http\Controllers;

use App\Imports\OrdersImport;
use Illuminate\Http\Request;
use App\Order;
use Maatwebsite\Excel\Facades\Excel;

class UploadCSVController extends Controller
{
    public function show()
    {
        return view("page.order_list");
    }

    public function perform(Request $request)
    {
        Excel::import(new OrdersImport, $request->file('file'));

        return redirect()->route("upload-csv")->with("success", "Data berhasil disimpan");
    }
}
