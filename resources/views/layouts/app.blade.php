<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SmartPark') }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // Dark mode init
        if (
            localStorage.getItem('color-theme') === 'dark' ||
            (
                !('color-theme' in localStorage) &&
                window.matchMedia('(prefers-color-scheme: dark)').matches
            )
        ) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        body {
            font-family: sans-serif;
        }

        .layout-wrapper {
            display: flex;
            height: 100vh;
            width: 100%;
            overflow: hidden;
        }

        /* ================= SIDEBAR ================= */
        .sidebar-wrapper {
            width: 260px;
            min-width: 260px;
            height: 100vh;
            overflow-y: auto;
            background: white;
            border-right: 1px solid #e5e7eb;
        }

        .dark .sidebar-wrapper {
            background: #111827;
            border-color: #374151;
        }

        /* ================= MAIN CONTENT ================= */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            min-width: 0;
        }

        /* ================= HEADER ================= */
        .top-header {
            height: 70px;
            min-height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
        }

        .dark .top-header {
            background: #1f2937;
            border-color: #374151;
        }

        /* ================= PAGE CONTENT ================= */
        .page-content {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 24px;
            background: #f5f7fa;
        }

        .dark .page-content {
            background: #111827;
        }

        /* ================= CARD ================= */
        .card {
            border-radius: 16px;
            border: none;
        }

        /* ================= RESPONSIVE ================= */
        @media (max-width: 768px) {

            .layout-wrapper {
                flex-direction: column;
            }

            .sidebar-wrapper {
                width: 100%;
                min-width: 100%;
                height: auto;
            }

            .top-header {
                padding: 0 16px;
            }

            .page-content {
                padding: 16px;
            }

            h2 {
                font-size: 18px;
            }
        }

        /* ================= DARK MODE FIX ================= */
        .dark .form-control,
        .dark .form-select {
            background-color: #1e293b;
            border-color: #334155;
            color: #f8fafc;
        }

        .dark .form-control:focus,
        .dark .form-select:focus {
            background-color: #0f172a;
            color: #f8fafc;
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
        }

        .dark .form-control::placeholder {
            color: #64748b;
        }

        .dark .dropdown-menu {
            background-color: #1e293b;
            border-color: #334155;
        }

        .dark .dropdown-item {
            color: #cbd5e1;
        }

        .dark .dropdown-item:hover {
            background-color: #334155;
            color: #f8fafc;
        }

        .dark .modal-content {
            background-color: #1e293b;
            border-color: #334155;
            color: #f8fafc;
        }

        .dark .modal-header.bg-light {
            background-color: #0f172a !important;
            border-bottom-color: #334155;
        }

        .dark .modal-footer {
            border-top-color: #334155;
        }

        .dark .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    <div class="layout-wrapper">

        <!-- SIDEBAR -->
        <aside class="sidebar-wrapper">
            @include('layouts.sidebar')
        </aside>

        <!-- MAIN -->
        <div class="main-wrapper">

            <!-- HEADER -->
            <header class="top-header shadow-sm">

                <div class="flex items-center gap-3">
                    @isset($header)
                        <h2 class="text-lg font-bold text-blue-600 dark:text-blue-400 m-0">
                            {{ $header }}
                        </h2>
                    @else
                        <h2 class="text-lg font-bold text-blue-600 dark:text-blue-400 m-0">
                            Dashboard
                        </h2>
                    @endisset
                </div>

                <div class="flex items-center gap-3">
                    <span class="text-sm text-blue-600 dark:text-blue-400">
                        Halo,
                        <span class="font-semibold">
                            {{ Auth::user()->name }}
                        </span>
                    </span>
                </div>

            </header>

            <!-- CONTENT -->
           <main class="page-content">

    @hasSection('content')
        @yield('content')
    @else
        {{ $slot ?? '' }}
    @endif

</main>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>