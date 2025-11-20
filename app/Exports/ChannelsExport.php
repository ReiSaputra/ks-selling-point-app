<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ChannelsExport implements FromCollection, WithHeadings
{
    protected $start;
    protected $end;
    protected $channel;
    
    public function __construct($start = null, $end = null, $channel = null)
    {
        $this->start = $start;
        $this->end = $end;
        $this->channel = $channel;
    }

    public function collection()
    {
        return Order::selectRaw('DATE(created_at) as tanggal, channel, COUNT(*) as total_order, SUM(total) as total_revenue')
            ->when($this->start, function ($q) {
                return $q->whereDate('created_at', '>=', $this->start);
            })
            ->when($this->end, function ($q) {
                return $q->whereDate('created_at', '<=', $this->end);
            })
            ->when($this->channel, function ($q) {
                return $q->where('channel', $this->channel);
            })
            ->groupBy('tanggal', 'channel')
            ->orderBy('tanggal')
            ->get();
    }

    public function headings(): array
    {
        return [
            'tanggal',
            'channel',
            'total_order',
            'total_revenue'
        ];
    }
}
