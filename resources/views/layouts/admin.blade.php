<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - Halmazing</title>

    <!-- Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <style>
        :root {
            --primary-green: #3e6529;
            --sidebar-width: 250px;
            --sidebar-mini-width: 70px;
            --transition-speed: .25s;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        /* ---------------------------
           SIDEBAR
        ---------------------------- */
        .admin-sidebar {
            width: var(--sidebar-mini-width);
            background-color: #fff;
            border-right: 1px solid #e9ecef;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-x: hidden;
            transition: width var(--transition-speed) ease;
            z-index: 1200;
        }

        /* Desktop Hover Expansion */
        @media (min-width: 768px) {
            .admin-sidebar:hover {
                width: var(--sidebar-width);
            }

            .admin-sidebar:hover .brand {
                padding: 1rem;
                flex-direction: row;
                gap: .75rem;
            }

            .admin-sidebar:hover .brand-text,
            .admin-sidebar:hover .nav-link span {
                display: inline;
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* ---------------------------
           Brand
        ---------------------------- */
        .brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .25rem;
            padding: 1rem 0;
            transition: all var(--transition-speed);
        }

        .brand-logo {
            width: 40px;
            height: 40px;
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 6px;
        }

        .brand-text {
            white-space: nowrap;
            display: none;
            opacity: 0;
            transform: translateX(-10px);
            transition: all var(--transition-speed);
        }

        /* ---------------------------
           Nav
        ---------------------------- */
        .nav-menu {
            padding: 1rem 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .75rem 1rem;
            color: #495057;
            transition: background var(--transition-speed);
        }

        .nav-link i {
            font-size: 1.2rem;
        }

        .nav-link span {
            opacity: 0;
            transform: translateX(-10px);
            transition: all var(--transition-speed);
            white-space: nowrap;
        }

        .nav-link.active {
            background-color: #f0f8e8;
            color: var(--primary-green);
            font-weight: 600;
        }

        /* ---------------------------
           MAIN CONTENT
        ---------------------------- */
        .admin-main {
            flex: 1;
            margin-left: var(--sidebar-mini-width);
            transition: margin-left var(--transition-speed);
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        /* Desktop hover main shift */
        @media (min-width: 768px) {
            .admin-sidebar:hover~.admin-main {
                margin-left: var(--sidebar-width);
            }
        }

        .admin-topbar {
            background-color: #fff;
            padding: 1rem 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1100;
        }

        .admin-content {
            flex: 1;
            padding: 2rem;
        }

        /* ---------------------------
           MOBILE BEHAVIOR
        ---------------------------- */
        @media (max-width: 768px) {
            .admin-sidebar {
                width: var(--sidebar-width);
                transform: translateX(-100%);
            }

            .admin-sidebar.expanded {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0 !important;
            }

            .brand-text,
            .nav-link span {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Mobile Backdrop */
        .admin-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .4);
            display: none;
            z-index: 1100;
        }

        .admin-backdrop.show {
            display: block;
        }
    </style>

    @stack('styles')
</head>

<body>

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="brand">
            <div class="brand-logo">
                <img src="{{ asset('halmazing-logo.png') }}" alt="Halmazing Logo">
            </div>
            <div class="brand-text fw-semibold">Halmazing</div>
        </div>

        <nav class="nav-menu">
            <a href="{{ route('merchant.products.index') }}"
                class="nav-link {{ request()->routeIs('merchant.products.*') ? 'active' : '' }}">
                <i class="fa fa-box"></i><span>Products</span>
            </a>
            <a href="#" class="nav-link">
                <i class="fa fa-receipt"></i><span>Orders</span>
            </a>
            <a href="#" class="nav-link">
                <i class="fa fa-gear"></i><span>Settings</span>
            </a>
        </nav>
    </aside>

    <!-- Mobile Backdrop -->
    <div class="admin-backdrop" id="adminBackdrop"></div>

    <!-- Main -->
    <div class="admin-main">
        <header class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-secondary d-md-none" id="mobileSidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <h5 class="mb-0">@yield('title', 'Admin Dashboard')</h5>
            </div>

            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small">{{ auth()->user()->name ?? '' }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger">Logout</button>
                </form>
            </div>
        </header>

        <main class="admin-content">
            @yield('content')
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('adminSidebar');
        const backdrop = document.getElementById('adminBackdrop');
        const toggleBtn = document.getElementById('mobileSidebarToggle');

        // Mobile Toggle Only
        toggleBtn?.addEventListener('click', () => {
            sidebar.classList.add('expanded');
            backdrop.classList.add('show');
        });

        backdrop?.addEventListener('click', () => {
            sidebar.classList.remove('expanded');
            backdrop.classList.remove('show');
        });
    </script>

    @stack('scripts')
</body>

</html>