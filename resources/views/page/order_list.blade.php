@extends('layouts.app')

@section('content')
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Order List</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item active">
                            <a href="{{ route('upload-csv') }}">Upload CSV</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!--begin::App Content-->
    <div class="app-content">
        <div class="container-fluid">
            <!-- FILTER BOX -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Filter</h5>
                </div>

<<<<<<< HEAD
            <!-- Upload CSV -->
            <div class="d-flex justify-content-end mb-3">
                <form method="POST" enctype="multipart/form-data" action="{{ route('upload-csv.preview') }}">
                    @csrf
                    <div class="input-group">
                        <input type="file" name="file" class="form-control" accept=".csv" required>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload"></i> Import CSV
                        </button>
                    </div>
                </form>
            </div>
=======
                <div class="card-body">
                    <form method="get" class="row g-3">
>>>>>>> 6577602c74c25c80eb4cdf246bba6fec5096ff4e

                        <!-- Search -->
                        <div class="col-md-3">
                            <label class="form-label">Search Invoice</label>
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                                placeholder="Invoice number...">
                        </div>

                        <!-- Channel -->
                        <div class="col-md-3">
                            <label class="form-label">Channel</label>
                            <select name="channel" class="form-control">
                                <option value="">All Channel</option>
                                <option value="Shopee" {{ request('channel') == 'Shopee' ? 'selected' : '' }}>Shopee
                                </option>
                                <option value="Tokopedia" {{ request('channel') == 'Tokopedia' ? 'selected' : '' }}>
                                    Tokopedia
                                </option>
                                <option value="Lazada" {{ request('channel') == 'Lazada' ? 'selected' : '' }}>Lazada
                                </option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="">All Status</option>
                                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>
                                    Shipped
                                </option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                    Cancelled
                                </option>
                                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>
                                    Delivered
                                </option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>
                                    Paid
                                </option>
                            </select>
                        </div>

                        <!-- From -->
                        <div class="col-md-3">
                            <label class="form-label">From Date</label>
                            <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                        </div>

                        <!-- To -->
                        <div class="col-md-3">
                            <label class="form-label">To Date</label>
                            <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                        </div>

                        <div class="col-12 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-filter"></i> Apply Filter
                            </button>

                            <a href="{{ route('order-list') }}" class="btn btn-secondary">
                                <i class="fa fa-refresh"></i> Reset
                            </a>
                        </div>

                    </form>
                </div>
            </div>

            <!-- DATA TABLE -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Order Data</h5>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered text-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Invoice Number</th>
                                <th>Marketplace Invoice</th>
                                <th>Channel</th>
                                <th>Subtotal</th>
                                <th>Discount</th>
                                <th>Shipping Cost</th>
                                <th>Order Status</th>
                                <th>Expedition</th>
                                <th>Shipping Receipt</th>
                                <th>Note</th>
                                <th>Coupon</th>
                                <th>Admin Fee</th>
                                <th>Vat</th>
                                <th>Total</th>
                                <th>Payment Type</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($data as $index => $item)
                                <tr>
                                    <td>{{ $data->firstItem() + $index }}</td>
                                    <td>{{ $item->invoice_number }}</td>
                                    <td>{{ $item->marketplace_invoice }}</td>
                                    <td>{{ $item->channel }}</td>
                                    <td>{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    <td>{{ number_format($item->discount, 0, ',', '.') }}</td>
                                    <td>{{ number_format($item->shipping_cost, 0, ',', '.') }}</td>
                                    <td>{{ $item->order_status }}</td>
                                    <td>{{ $item->expedition }}</td>
                                    <td>{{ $item->shipping_receipt }}</td>
                                    <td>{{ $item->note }}</td>
                                    <td>{{ implode(',', $item->coupon) }}</td>
                                    <td>{{ number_format($item->admin_fee, 0, ',', '.') }}</td>
                                    <td>{{ number_format($item->vat, 0, ',', '.') }}</td>
                                    <td>{{ number_format($item->total, 0, ',', '.') }}</td>
                                    <td>{{ $item->payment_type }}</td>
                                    <td>
                                        {{ $item->created_at ? $item->created_at->format('Y-m-d H:i') : '-' }}
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        No data found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    {{ $data->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection
