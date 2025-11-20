<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="#" class="brand-link">
            <span class="brand-text fw-light">KS Selling Point</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview">
                <li class="nav-item">
                    <a href="{{ route('order-list') }}" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Order List</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('upload-csv') }}" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Upload CSV</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('report') }}" class="nav-link">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Report</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
