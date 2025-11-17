<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class OrderListController extends Controller
{
    public function show()
    {
        return view("layouts.app");
    }

    public function preview(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        $f = fopen($path, 'r');

        $data = [];
        while (($row = fgetcsv($f, 0, ',')) !== false) {
            $data[] = $row;
        }

        // dd($data);
        
        return view("layouts.app", [
            "preview" => $data
        ]);
    }
}

?>