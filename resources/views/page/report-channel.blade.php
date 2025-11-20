@extends('layouts.app')

@section('content')
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Report Channel</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item active">
                            <a href="{{ route('report.channel') }}">Report Channel</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!--begin::App Content-->
    <div class="app-content">
        <div class="container-fluid">

            <!-- Filters Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Filter Laporan</strong>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('report.channel') }}">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="start" class="form-label">Tanggal Mulai</label>
                                <input type="date" name="start" id="start" value="{{ request('start') }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label for="end" class="form-label">Tanggal Akhir</label>
                                <input type="date" name="end" id="end" value="{{ request('end') }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label for="channel" class="form-label">Channel</label>
                                <select name="channel" id="channel" class="form-select">
                                    <option value="">Semua</option>
                                    <option value="Shopee" {{ request('channel') == 'Shopee' ? 'selected' : '' }}>Shopee
                                    </option>
                                    <option value="Tokopedia" {{ request('channel') == 'Tokopedia' ? 'selected' : '' }}>
                                        Tokopedia</option>
                                    <option value="Lazada" {{ request('channel') == 'Lazada' ? 'selected' : '' }}>
                                        Lazada</option>
                                </select>
                            </div>

                            <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-primary w-100">Terapkan Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mb-3 d-flex gap-2">
                <a href="{{ route('report.channel.export', array_merge(request()->all(), ['type' => 'xlsx'])) }}"
                    class="btn btn-success">
                    Download XLSX
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <strong>Hasil Laporan</strong>
                </div>

                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Channel</th>
                                <th>Total Order</th>
                                <th>Total Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reports as $row)
                                <tr>
                                    <td>{{ $row->tanggal }}</td>
                                    <td>{{ $row->channel }}</td>
                                    <td>{{ $row->total_order }}</td>
                                    <td>Rp {{ number_format($row->total_revenue, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
