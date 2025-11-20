<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderListController extends Controller
{
    public function show(Request $request)
    {
        $search = $request->query('search');
        $channel = $request->query('channel');
        $status = $request->query('status');
        $dateFrom = $request->query('from');
        $dateTo = $request->query('to');

        $orders = Order::query()
            ->when($search, function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%$search%");
            })
            ->when($channel, function ($q) use ($channel) {
                $q->where('channel', $channel);
            })
            ->when($status, function ($q) use ($status) {
                $q->where('order_status', $status);
            })
            ->when($dateFrom, function ($q) use ($dateFrom) {
                $q->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function ($q) use ($dateTo) {
                $q->whereDate('created_at', '<=', $dateTo);
            })
            ->orderBy('id', 'desc')
            ->paginate(100)
            ->appends($request->query());

        return view("page.order_list", [
            "data" => $orders
        ]);
    }
}

?>