<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'DKM AL-IKLAS - PT Aisin Indonesia')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            background: white;
            border-radius: 8px;
            padding: 24px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        .btn-success {
            background: #10b981;
            color: white;
        }

        .btn-success:hover {
            background: #059669;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .btn-info {
            background: #0ea5e9;
            color: white;
        }

        .btn-info:hover {
            background: #0284c7;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
        }

        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .table th {
            background: #f9fafb;
            font-weight: 600;
            color: #374151;
        }

        .table tbody tr:hover {
            background: #f9fafb;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-approved {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-secondary {
            background: #f3f4f6;
            color: #4b5563;
        }

        .header {
            background: white;
            padding: 16px 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
        }

        .select2-container .select2-selection--single {
            height: 42px !important;
            border: 1px solid #d1d5db !important;
            border-radius: 6px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }

        .text-error {
            color: #dc2626;
            font-size: 12px;
            margin-top: 4px;
        }

        /* Print Styles */
        @media print {

            .header,
            .btn,
            button,
            a.btn {
                display: none !important;
            }

            body {
                background: white;
            }

            .card {
                box-shadow: none;
                border: 1px solid #000;
            }

            .container {
                max-width: 100%;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="header">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1>DKM AL-IKLAS - PT Aisin Indonesia</h1>
                <p style="color: #6b7280; margin-top: 4px;">Sistem Pencatatan Bukti Pengeluaran Kas Kecil</p>
            </div>
            @auth
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="text-align: right;">
                        <div style="font-weight: 600; color: #1f2937;">{{ Auth::user()->name }}</div>
                        <div style="font-size: 12px; color: #6b7280;">
                            @if (Auth::user()->isDeptPic())
                                Dept PIC
                            @elseif(Auth::user()->isBendahara())
                                Bendahara
                            @elseif(Auth::user()->isSekretaris())
                                Sekretaris
                            @elseif(Auth::user()->isKetua())
                                Ketua
                            @endif
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn btn-secondary" style="padding: 8px 16px; font-size: 14px;">
                            Logout
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>

    @auth
        <div style="background-color: white; border-bottom: 1px solid #e5e7eb; margin-bottom: 20px;">
            <div class="container">
                <nav style="display: flex; gap: 24px; padding: 12px 0;">
                    <a href="{{ route('cash-expenses.index') }}"
                        style="text-decoration: none; color: {{ request()->routeIs('cash-expenses.*') ? '#3b82f6' : '#6b7280' }}; font-weight: 500; padding: 8px 0; border-bottom: 2px solid {{ request()->routeIs('cash-expenses.*') ? '#3b82f6' : 'transparent' }};">
                        💰 Pengeluaran Kas
                    </a>
                    <a href="{{ route('master-codes.index') }}"
                        style="text-decoration: none; color: {{ request()->routeIs('master-codes.*') ? '#3b82f6' : '#6b7280' }}; font-weight: 500; padding: 8px 0; border-bottom: 2px solid {{ request()->routeIs('master-codes.*') ? '#3b82f6' : 'transparent' }};">
                        � Master Section
                    </a>
                    <a href="{{ route('barcodes.index') }}"
                        style="text-decoration: none; color: {{ request()->routeIs('barcodes.*') ? '#3b82f6' : '#6b7280' }}; font-weight: 500; padding: 8px 0; border-bottom: 2px solid {{ request()->routeIs('barcodes.*') ? '#3b82f6' : 'transparent' }};">
                        📦 Budget
                    </a>
                </nav>
            </div>
        </div>
    @endauth

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @stack('scripts')
</body>

</html>
