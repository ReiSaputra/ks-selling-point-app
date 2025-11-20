<?php

namespace App\Http\Controllers;

use App\Exports\ChannelsExport;
use App\Exports\ProductsExport;
use App\Order;
use App\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function showChannel(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $channel = $request->channel;

        $reports = Order::selectRaw('DATE(created_at) as tanggal, channel, COUNT(*) as total_order, SUM(total) as total_revenue')
            ->when($start, function ($q) use ($start) {
                return $q->whereDate('created_at', '>=', $start);
            })
            ->when($end, function ($q) use ($end) {
                return $q->whereDate('created_at', '<=', $end);
            })
            ->when($channel, function ($q) use ($channel) {
                return $q->where('channel', $channel);
            })
            ->groupBy('tanggal', 'channel')
            ->orderBy('tanggal')
            ->get();

        return view('page.report-channel', compact('reports'));
    }

    public function showProduct(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        $query = OrderDetail::select(
            'order_details.product_sku',
            DB::raw('SUM(order_details.quantity) as total_qty'),
            DB::raw('SUM(order_details.subtotal) as total_revenue'),
            DB::raw('SUM(order_details.subtotal - (order_details.product_cost * order_details.quantity)) as margin')
        )
            ->join('orders', 'orders.id', '=', 'order_details.order_id')
            ->groupBy('order_details.product_sku');

        if ($start) {
            $query->where('orders.created_at', '>=', $start);
        }

        if ($end) {
            $query->where('orders.created_at', '<=', $end);
        }

        $data = $query->paginate(100)->withQueryString();

        return view('page.report-product', compact('data'));
    }

    public function exportPerChannel(Request $request)
    {
        $type = $request->type ?? 'xlsx';
        $start = $request->start;
        $end = $request->end;
        $channel = $request->channel;

        $fileName = 'laporan_harian_channel_' . now()->format('Ymd_His') . '.' . $type;

        return Excel::download(
            new ChannelsExport($start, $end, $channel),
            $fileName
        );
    }

    public function exportPerProduct(Request $request)
    {
        return Excel::download(
            new ProductsExport($request->start, $request->end),
            'report-per-product.xlsx'
        );
    }
}
