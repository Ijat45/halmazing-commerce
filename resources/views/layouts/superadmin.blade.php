<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SuperAdmin') - Halmazing Platform</title>

    <!-- Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <style>
        :root {
            /* Distinct purple theme for SuperAdmin */
            --superadmin-color: #6f42c1;
            --sidebar-width: 250px;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .admin-sidebar {
            width: var(--sidebar-width);
            background-color: #212529;
            /* Dark Sidebar for SuperAdmin */
            color: #fff;
            flex-shrink: 0;
            padding: 1rem;
        }

        .brand {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.7);
            padding: 0.75rem 1rem;
            display: block;
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #fff;
            background-color: var(--superadmin-color);
        }

        .nav-link i {
            width: 25px;
        }

        .admin-main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .admin-header {
            background: #fff;
            padding: 1rem 2rem;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-content {
            padding: 2rem;
        }
    </style>
</head>

<body>
    <aside class="admin-sidebar">
        <div class="brand">
            <i class="bi bi-shield-lock-fill text-warning"></i> SuperAdmin
        </div>
        <nav class="nav flex-column gap-1">
            <a href="{{ route('superadmin.merchants.index') }}"
                class="nav-link {{ request()->routeIs('superadmin.merchants.*') ? 'active' : '' }}">
                <i class="fa fa-users"></i> Merchants
            </a>
            <!-- Expansion: Settings, Users, etc -->
        </nav>
    </aside>

    <div class="admin-main">
        <header class="admin-header">
            <h5 class="mb-0">@yield('title')</h5>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-outline-danger">Logout</button>
            </form>
        </header>

        <main class="admin-content">
            @yield('content')
        </main>
    </div>
</body>

</html>