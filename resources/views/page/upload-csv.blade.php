@extends('layouts.app')

@section('content')
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Upload CSV</h3>
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
                <form method="POST" enctype="multipart/form-data" action="{{ route('upload-csv.perform') }}">
                    @csrf
                    <div class="input-group">
                        <input type="file" name="file" class="form-control" accept=".csv" required>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload"></i> Import CSV
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
