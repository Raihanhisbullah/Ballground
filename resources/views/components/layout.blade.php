<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/img/logo.png" type="image/png">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
        }

        .main-header {
            background: linear-gradient(135deg, #1e88e5 0%, #1565c0 100%);
            border: none;
        }

        .main-header .navbar-nav .nav-link {
            color: #ffffff !important;
        }

        .main-sidebar {
            background-color: #343a40;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            color: #ffffff;
        }

        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active {
            background: linear-gradient(135deg, #1e88e5 0%, #1565c0 100%);
            color: #ffffff;
        }

        .content-wrapper {
            background-color: #f4f6f9;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            border: none;
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid #eee;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1e88e5 0%, #1565c0 100%);
            border: none;
            border-radius: 8px;
        }

        .small-box {
            border-radius: 15px;
            overflow: hidden;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
        }

        .modal-content {
            border-radius: 15px;
        }

        #map {
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }
    </style>

    @stack('styles')
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
    <div class="wrapper">
        <x-navbar />
        <x-sidebar />

        <div class="content-wrapper">
            {{ $slot }}
        </div>

        <x-footer />

        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/adminlte.min.js') }}"></script>
    <script src="{{ asset('js/demo.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>

</html>
