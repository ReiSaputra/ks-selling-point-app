<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class OrderListController extends Controller
{
    public function show(Request $request)
    {
        $orders = $request->query("search") ? Order::all() : Order::all();

        return view("page.order_list", [
            "data" => $orders
        ]);
    }
}

?>