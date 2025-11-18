<footer class="app-footer">
    <div class="float-end d-none d-sm-inline">Anything you want</div>

    <strong>
        Copyright &copy; 2014-2025 
        <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
    </strong>
    All rights reserved.
</footer>
</div> <!-- end app-wrapper -->

<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('adminlte/js/adminlte.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarWrapper = document.querySelector('.sidebar-wrapper');
        if (sidebarWrapper && OverlayScrollbarsGlobal) {
            OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                scrollbars: {
                    autoHide: 'leave',
                    clickScroll: true
                }
            });
        }
    });
</script>

</body>
</html>
