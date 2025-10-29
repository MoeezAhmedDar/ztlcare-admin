<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'ZTL Care'))</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    
    <!-- SB Admin 2 CSS -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        @include('layouts.sidebar')
        
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.topbar')
                
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            
            @include('layouts.footer')
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>
    @include('layouts.logout-modal')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- CDN jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script> <!-- CDN Bootstrap -->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    
    @stack('scripts')
</body>
</html>