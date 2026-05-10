<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SmartPark') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        .card {
            border-radius: 15px;
        }

        @media(max-width: 768px){
            h2 {
                font-size: 20px;
            }
        }

        /* Fix for Bootstrap form elements inheriting Tailwind text color in Dark Mode */
        .dark .form-control, .dark .form-select {
            background-color: #1e293b;
            border-color: #334155;
            color: #f8fafc;
        }
        .dark .form-control:focus, .dark .form-select:focus {
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

        /* Fix Bootstrap Modals in Dark Mode */
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
<body class="font-sans antialiased text-gray-900 bg-gray-100 dark:bg-gray-900 dark:text-gray-100">
    <div class="flex h-screen overflow-hidden bg-gray-100 dark:bg-gray-900">
        
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-hidden" style="min-width:0;">
            <!-- Top Header -->
            <header class="flex items-center justify-between px-6 py-3 bg-gray-100 border-b dark:bg-gray-800 dark:border-gray-700 shadow-sm">
                <div class="flex items-center gap-3">
                    @isset($header)
                        <h2 class="text-base font-semibold text-blue-600 dark:text-blue-400">
                            {{ $header }}
                        </h2>
                    @else
                        <h2 class="text-base font-semibold text-blue-600 dark:text-blue-400">
                            Dashboard
                        </h2>
                    @endisset
                </div>
                
                <div class="flex items-center gap-3">
                    <span class="text-sm text-blue-600 dark:text-blue-400">
                        Halo, <span class="font-semibold">{{ Auth::user()->name }}</span>
                    </span>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#f5f7fa] dark:bg-gray-900 p-5">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
