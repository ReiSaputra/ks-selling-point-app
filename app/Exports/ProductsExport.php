<?php

namespace App\Exports;

use App\OrderDetail;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings, WithChunkReading
{
    protected $start;
    protected $end;

    public function __construct($start = null, $end = null)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        $query = OrderDetail::select(
            'order_details.product_sku',
            DB::raw('SUM(order_details.quantity) as total_qty'),
            DB::raw('SUM(order_details.subtotal) as total_revenue'),
            DB::raw('SUM(order_details.subtotal - (order_details.product_cost * order_details.quantity)) as margin')
        )
            ->join('orders', 'orders.id', '=', 'order_details.order_id')
            ->groupBy('order_details.product_sku');

        if ($this->start) {
            $query->whereDate('orders.created_at', '>=', $this->start);
        }

        if ($this->end) {
            $query->whereDate('orders.created_at', '<=', $this->end);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'SKU',
            'Total Qty',
            'Total Revenue',
            'Margin',
        ];
    }

    public function chunkSize(): int
    {
        return 2000;
    }
}
