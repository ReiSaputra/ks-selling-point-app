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

            <!-- Preview -->
            @if (isset($preview) && count($preview) > 0)
                <div class="card mt-4">
                    <div class="card-header">Preview Data CSV</div>

                    <div class="card-body table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Invoice number</th>
                                    <th>Marketplace invoice number</th>
                                    <th>Channel</th>
                                    <th>Subtotal</th>
                                    <th>Discount</th>
                                    <th>Shipping cost</th>
                                    <th>Order status</th>
                                    <th>Expedition</th>
                                    <th>Shipping receipt</th>
                                    <th>Note</th>
                                    <th>Coupon</th>
                                    <th>Admin fee</th>
                                    <th>Vat</th>
                                    <th>Total</th>
                                    <th>Payment type</th>
                                    <th>User Id</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($preview as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        @foreach ($row as $val)
                                            <td>{{ $val }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <form method="POST" class="p-4">
                        @csrf
                        <input type="hidden" name="data" value="{{ json_encode($preview) }}">

                        <button type="submit" class="btn btn-success">Save to Database</button>
                        <a href="{{ route('order-list') }}" class="btn btn-danger">Cancel</a>
                    </form>
                </div>
            @endif

        </div>
    </div>
@endsection
