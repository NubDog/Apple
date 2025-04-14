<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Shark Car') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Styles -->
    <style>
        :root {
            --primary: #7262fd;
            --secondary: #6c757d;
            --success: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
            --info: #17a2b8;
            --light: #f8f9fa;
            --dark: #343a40;
            --sidebar-width: 240px;
            --body-bg: #f0f2f9;
            --card-bg: #ffffff;
            --card-border-radius: 12px;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: var(--body-bg);
            color: #333;
        }
        
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--card-bg);
            box-shadow: var(--card-shadow);
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 999;
            display: flex;
            flex-direction: column;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            padding: 10px 0 30px;
        }
        
        .logo-container svg {
            width: 26px;
            height: 26px;
            margin-right: 10px;
            fill: var(--primary);
        }
        
        .logo-container span {
            font-size: 18px;
            font-weight: 600;
        }
        
        .sidebar-menu {
            margin-top: 20px;
            flex-grow: 1;
        }
        
        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 8px;
            color: #666;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .menu-item i {
            margin-right: 10px;
            font-size: 16px;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .menu-item.active {
            background-color: var(--primary);
            color: white;
        }
        
        .menu-item:hover:not(.active) {
            background-color: rgba(114, 98, 253, 0.1);
            color: var(--primary);
        }
        
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 20px;
        }
        
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .page-title {
            display: flex;
            flex-direction: column;
        }
        
        .page-title h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .page-title .date {
            font-size: 14px;
            color: #666;
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .user-info .notifications {
            position: relative;
            margin-right: 20px;
        }
        
        .user-info .notifications i {
            font-size: 16px;
            cursor: pointer;
        }
        
        .user-info .notifications .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--danger);
            color: white;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            cursor: pointer;
        }
        
        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .card {
            background-color: var(--card-bg);
            border-radius: var(--card-border-radius);
            box-shadow: var(--card-shadow);
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .card-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-title .actions a {
            color: #666;
            margin-left: 10px;
        }
        
        .tab-container .tab-nav {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .tab-container .tab-btn {
            padding: 10px 20px;
            border: none;
            background: none;
            font-weight: 500;
            color: #666;
            cursor: pointer;
            position: relative;
        }
        
        .tab-container .tab-btn.active {
            color: var(--primary);
        }
        
        .tab-container .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--primary);
        }
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            background-color: var(--card-bg);
            border-radius: var(--card-border-radius);
            box-shadow: var(--card-shadow);
            padding: 20px;
            display: flex;
            flex-direction: column;
        }
        
        .stat-card .stat-title {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .stat-card .stat-value {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .stat-card .stat-change {
            font-size: 12px;
            color: var(--success);
            display: flex;
            align-items: center;
        }
        
        .stat-card .stat-change.negative {
            color: var(--danger);
        }
        
        .chart-container {
            height: 300px;
            margin-top: 20px;
        }
        
        .task-list {
            margin-top: 20px;
        }
        
        .task-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        
        .task-checkbox {
            margin-right: 10px;
        }
        
        .task-content {
            flex: 1;
        }
        
        .task-title {
            font-weight: 500;
        }
        
        .task-meta {
            font-size: 12px;
            color: #666;
            margin-top: 3px;
        }
        
        .task-actions {
            display: flex;
        }
        
        .task-actions button {
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            margin-left: 5px;
        }
        
        .calendar {
            margin-top: 20px;
        }
        
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .calendar-month {
            font-weight: 600;
        }
        
        .calendar-controls button {
            background: none;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        
        .calendar-controls button:hover {
            background-color: #eee;
        }
        
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }
        
        .calendar-day-header {
            text-align: center;
            font-weight: 500;
            font-size: 12px;
            padding: 5px;
            color: #666;
        }
        
        .calendar-day {
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .calendar-day:hover {
            background-color: #eee;
        }
        
        .calendar-day.current {
            background-color: var(--primary);
            color: white;
        }
        
        .calendar-day.other-month {
            color: #ccc;
        }
        
        .activity-item {
            position: relative;
            padding-left: 30px;
            margin-bottom: 20px;
        }
        
        .activity-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 10px;
            height: 100%;
            width: 2px;
            background-color: #eee;
        }
        
        .activity-item::after {
            content: '';
            position: absolute;
            top: 0;
            left: 6px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: var(--primary);
        }
        
        .activity-content {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
        }
        
        .activity-title {
            font-weight: 500;
            margin-bottom: 5px;
        }
        
        .activity-meta {
            font-size: 12px;
            color: #666;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        
        .pagination-item {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            margin: 0 3px;
            font-weight: 500;
            cursor: pointer;
        }
        
        .pagination-item.active {
            background-color: var(--primary);
            color: white;
        }
        
        .pagination-item:hover:not(.active) {
            background-color: #eee;
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 1000;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-menu-toggle {
                display: block;
            }
        }
        
        @media (max-width: 576px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
        }
        
        /* Fix for oversized icons */
        .bi {
            font-size: 1rem;
            width: 1em;
            height: 1em;
            display: inline-block;
            vertical-align: -0.125em;
        }
        
        /* Specific sizes for action buttons */
        .btn-action .bi {
            font-size: 0.875rem;
        }
        
        /* Status icon sizing */
        .status-icon .bi {
            font-size: 1.2rem;
            width: 1.2em;
            height: 1.2em;
            display: inline-block;
        }
        
        /* Normal icon sizing in buttons */
        .btn .bi {
            font-size: 0.875rem;
        }
        
        /* Ensure all icons have proper constraints */
        i.bi {
            line-height: 1;
            display: inline-block;
        }
        
        /* Fix for oversized SVG arrows */
        svg, path {
            max-width: 100%;
            max-height: 100%;
        }
        
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 20px;
            height: 20px;
        }
        
        .carousel-control-prev,
        .carousel-control-next {
            width: 40px;
            height: 40px;
            opacity: 0.8;
        }
        
        /* Navigation arrows */
        .nav-arrow svg,
        .nav-arrow path,
        .pagination svg,
        .pagination path {
            width: 20px !important;
            height: 20px !important;
            max-width: 20px !important;
            max-height: 20px !important;
        }
        
        /* Laravel pagination arrow constraints */
        .pagination svg {
            width: 20px !important;
            height: 20px !important;
            max-width: 20px !important;
            max-height: 20px !important;
            overflow: visible;
        }
        
        /* Enforce size on all SVG arrows */
        svg[width="24"] {
            width: 20px !important;
            height: 20px !important;
        }
        
        svg path {
            stroke-width: 2px;
            vector-effect: non-scaling-stroke;
        }
        
        /* Direct constraint for the specific pagination arrows */
        .relative.inline-flex.items-center svg,
        .relative.inline-flex.items-center path {
            width: 20px !important;
            height: 20px !important;
            max-width: 20px !important;
            max-height: 20px !important;
        }
        
        /* All SVG icons */
        svg.icon {
            width: 1em;
            height: 1em;
            vertical-align: -0.125em;
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-container">
                <svg viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                </svg>
                <span>Shark Car Admin</span>
            </div>
            
            <div class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('admin.categories.index') }}" class="menu-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="bi bi-grid"></i>
                    <span>Categories</span>
                </a>
                
                <a href="{{ route('admin.products.index') }}" class="menu-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="bi bi-car-front-fill"></i>
                    <span>Products</span>
                </a>
                
                <a href="{{ route('admin.orders.index') }}" class="menu-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="bi bi-bag"></i>
                    <span>Orders</span>
                </a>
                
                <a href="{{ route('admin.users.index') }}" class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Users</span>
                </a>
                
                <a href="{{ route('admin.sliders.index') }}" class="menu-item {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                    <i class="bi bi-sliders"></i>
                    <span>Sliders</span>
                </a>
                
                <a href="{{ route('admin.contacts.index') }}" class="menu-item {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                    <i class="bi bi-chat-dots"></i>
                    <span>Messages</span>
                </a>
                
                <a href="{{ route('admin.coupons.index') }}" class="menu-item {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                    <i class="bi bi-ticket-perforated"></i>
                    <span>Coupons</span>
                </a>
                
                <a href="{{ route('home') }}" class="menu-item">
                    <i class="bi bi-shop"></i>
                    <span>Visit Shop</span>
                </a>
            </div>
            
            <ul class="menu logout-container">
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="menu-item">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="page-title">
                    <h1>@yield('title', 'Dashboard')</h1>
                    <div class="date">{{ now()->format('jS F, Y') }}</div>
                </div>
                
                <div class="user-info">
                    <div class="notifications">
                        <i class="bi bi-bell"></i>
                        <span class="badge">3</span>
                    </div>
                    
                    <div class="user-avatar">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=7262fd&color=fff" alt="User">
                    </div>
                </div>
            </div>
            
            <!-- Main Content Area -->
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts')
</body>
</html> 