<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class UploadCSVController extends Controller
{
    public function show()
    {
        return view("page.order_list");
    }

    public function preview(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        $f = fopen($path, 'r');

        $data = [];
        while (($row = fgetcsv($f, 0, ',')) !== false) {
            $data[] = $row;
        }

        return view("page.order_list", [
            "preview" => $data
        ]);
    }

    public function perform(Request $request)
    {
        $data = json_decode($request->input("data"), true);

        $columns = [
            'invoice_number',
            'marketplace_invoice',
            'channel',
            'subtotal',
            'discount',
            'shipping_cost',
            'order_status',
            'expedition',
            'shipping_receipt',
            'note',
            'coupon',
            'admin_fee',
            'vat',
            'total',
            'payment_type',
        ];

        foreach ($data as $value) {
            $mapped = array_combine($columns, $value);

            Order::create($mapped);
        }

        return redirect()->route("upload-csv")->with("success", "Data berhasil disimpan");
    }
}
