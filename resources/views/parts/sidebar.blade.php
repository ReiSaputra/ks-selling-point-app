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
                        <i class="nav-icon bi bi-card-list"></i>
                        <p>Order List</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('upload-csv') }}" class="nav-link">
                        <i class="nav-icon bi bi-file-earmark-arrow-up"></i>
                        <p>Upload CSV</p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-bar-chart"></i>
                        <p>
                            Report
                            <i class="end bi bi-chevron-right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('report.channel') }}" class="nav-link">
                                <i class="nav-icon bi bi-diagram-3"></i>
                                <p>Report per Channel</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('report.product') }}" class="nav-link">
                                <i class="nav-icon bi bi-box-seam"></i>
                                <p>Report per Product</p>
                            </a>
                        </li>

                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</aside>
