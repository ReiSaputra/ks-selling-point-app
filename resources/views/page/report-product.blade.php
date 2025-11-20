@extends('layouts.app')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Report per Product</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item">
                            <a href="{{ route('report.product') }}">Report Product</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('report.product') }}" method="GET" class="row g-3 mb-4">

                        <div class="col-md-4">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start" class="form-control" value="{{ request('start') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">End Date</label>
                            <input type="date" name="end" class="form-control" value="{{ request('end') }}">
                        </div>

                        <div class="col-md-4 d-flex align-items-end">
                            <button class="btn btn-primary w-100">
                                <i class="bi bi-search me-1"></i> Filter
                            </button>
                        </div>

                    </form>

                    <a href="{{ route('report.product.export', request()->only('start', 'end')) }}"
                        class="btn btn-success mb-3">
                        <i class="bi bi-download me-1"></i> Export Report
                    </a>

                    @if (isset($data) && $data->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>SKU</th>
                                        <th>Total Qty</th>
                                        <th>Total Revenue</th>
                                        <th>Margin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $row)
                                        <tr>
                                            <td>{{ $row->product_sku }}</td>
                                            <td>{{ $row->total_qty }}</td>
                                            <td>Rp {{ number_format($row->total_revenue, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($row->margin, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer">
                            {{ $data->links() }}
                        </div>
                    @elseif(request()->start || request()->end)
                        <p class="text-muted">Tidak ada data untuk periode tersebut.</p>
                    @endif


                </div>
            </div>

        </div>
    </div>

@endsection
