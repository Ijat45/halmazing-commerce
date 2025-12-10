<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Merchant Dashboard') - Halmazing</title>

    <!-- Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <!-- Keep original design or simplified version of admin.blade.php -->
    <style>
        :root {
            --primary-green: #3e6529;
            --sidebar-width: 250px;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .merchant-sidebar {
            width: var(--sidebar-width);
            background: #fff;
            border-right: 1px solid #dee2e6;
            flex-shrink: 0;
        }

        .brand {
            padding: 1.5rem;
            font-size: 1.25rem;
            color: var(--primary-green);
            font-weight: bold;
        }

        .nav-link {
            color: #495057;
            padding: 0.8rem 1.5rem;
            display: flex;
            gap: 10px;
            align-items: center;
            text-decoration: none;
        }

        .nav-link.active {
            background: #e8f5e9;
            color: var(--primary-green);
            border-right: 3px solid var(--primary-green);
        }

        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .top-bar {
            background: #fff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
        }

        .content-area {
            padding: 2rem;
        }
    </style>
</head>

<body>
    <aside class="merchant-sidebar">
        <div class="brand">
            <i class="bi bi-shop"></i> Vendor Portal
        </div>
        <nav class="nav flex-column">
            <a href="{{ route('merchant.dashboard') }}"
                class="nav-link {{ request()->routeIs('merchant.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('merchant.products.index') }}"
                class="nav-link {{ request()->routeIs('merchant.products.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i> Products
            </a>
            <a href="{{ route('merchant.branches.index') }}"
                class="nav-link {{ request()->routeIs('merchant.branches.*') ? 'active' : '' }}">
                <i class="bi bi-geo-alt"></i> Branches
            </a>
            <a href="{{ route('merchant.halal-certifications.index') }}"
                class="nav-link {{ request()->routeIs('merchant.halal-certifications.*') ? 'active' : '' }}">
                <i class="bi bi-patch-check"></i> Halal Certs
            </a>
        </nav>
    </aside>

    <div class="main-content">
        <header class="top-bar">
            <strong>{{ auth()->user()->merchant_info['business_name'] ?? 'My Shop' }}</strong>
            <div class="d-flex align-items-center gap-3">
                <span>{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-link text-danger text-decoration-none">Logout</button>
                </form>
            </div>
        </header>

        <main class="content-area">
            @yield('content')
        </main>
    </div>
</body>

</html>