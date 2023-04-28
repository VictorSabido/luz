<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

@include('layouts.sections.head')

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('layouts.sections.sidebar')
            <!-- Layout container -->
            <div class="layout-page">
                @include('layouts.sections.navbar')
                <!-- Content wrapper -->
                <div class="content-wrapper">

                    @yield('content')

                    @include('layouts.sections.footer')

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <div class="buy-now">
        <a href="https://themeselection.com/products/sneat-bootstrap-html-admin-template/" target="_blank"
            class="btn btn-danger btn-buy-now">Ligth</a>
    </div>

    @include('layouts.sections.scripts')

    @stack('custom-scripts')
</body>

</html>
