<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary:   #3b5bdb;
            --primary-dark: #2f4ac2;
            --success:   #2f9e44;
            --danger:    #e03131;
            --warning:   #f59f00;
            --bg:        #f1f3f9;
            --card:      #ffffff;
            --text:      #1e1e2e;
            --muted:     #6c757d;
            --border:    #dee2e6;
        }

        body {
            background: var(--bg);
            font-family: 'Segoe UI', system-ui, sans-serif;
            color: var(--text);
            min-height: 100vh;
        }

        /* ── Navbar ── */
        .navbar {
            background: var(--primary) !important;
            box-shadow: 0 2px 8px rgba(0,0,0,.18);
            padding: 0.7rem 1.5rem;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: #fff !important;
            letter-spacing: .5px;
        }
        .navbar-brand i { margin-right: 6px; }
        .nav-link {
            color: rgba(255,255,255,.85) !important;
            font-weight: 500;
            transition: color .2s;
        }
        .nav-link:hover,
        .nav-link.active { color: #fff !important; text-decoration: underline; }

        /* ── Cards ── */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,.07);
        }
        .card-header {
            background: var(--primary);
            color: #fff;
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
            padding: .85rem 1.25rem;
        }

        /* ── Stats strip ── */
        .stat-box {
            background: var(--card);
            border-radius: 10px;
            padding: 1rem 1.4rem;
            text-align: center;
            box-shadow: 0 1px 6px rgba(0,0,0,.07);
        }
        .stat-box .num { font-size: 1.8rem; font-weight: 700; }
        .stat-box .lbl { font-size: .78rem; color: var(--muted); text-transform: uppercase; letter-spacing: .5px; }

        /* ── Table ── */
        .table thead th {
            background: #e8eaf6;
            font-weight: 600;
            font-size: .82rem;
            text-transform: uppercase;
            letter-spacing: .4px;
            border-bottom: 2px solid var(--primary);
            padding: .7rem 1rem;
        }
        .table tbody tr { transition: background .15s; }
        .table tbody tr:hover { background: #f0f2ff; }
        .table td { vertical-align: middle; padding: .75rem 1rem; font-size: .92rem; }

        /* ── Priority badges ── */
        .badge-high   { background: #ffe3e3; color: #c92a2a; font-weight: 600; }
        .badge-medium { background: #fff3cd; color: #856404; font-weight: 600; }
        .badge-low    { background: #d3f9d8; color: #2b8a3e; font-weight: 600; }

        /* ── Status badges ── */
        .badge-pending   { background: #dbe4ff; color: #3b5bdb; font-weight: 600; }
        .badge-completed { background: #d3f9d8; color: #2b8a3e; font-weight: 600; }

        .badge { padding: .35em .7em; border-radius: 6px; font-size: .78rem; }

        /* ── Action buttons ── */
        .btn-action {
            width: 30px; height: 30px;
            border-radius: 6px;
            border: none;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: .8rem;
            cursor: pointer;
            transition: opacity .2s, transform .1s;
        }
        .btn-action:hover { opacity: .85; transform: scale(1.08); }
        .btn-toggle   { background: #74c0fc; color: #fff; }
        .btn-edit     { background: #51cf66; color: #fff; }
        .btn-delete   { background: #ff6b6b; color: #fff; }

        /* ── Form controls ── */
        .form-control, .form-select {
            border-radius: 8px;
            border: 1.5px solid var(--border);
            font-size: .9rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59,91,219,.15);
        }
        .form-label { font-weight: 600; font-size: .85rem; color: #495057; margin-bottom: 4px; }

        /* ── Add Task button ── */
        .btn-add {
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: .55rem 1.4rem;
            font-weight: 600;
            width: 100%;
            transition: background .2s;
        }
        .btn-add:hover { background: var(--primary-dark); }

        /* ── Alert ── */
        .alert { border-radius: 10px; font-size: .9rem; }

        /* ── Completed row ── */
        tr.completed-row td:nth-child(2) { text-decoration: line-through; color: var(--muted); }

        /* ── Empty state ── */
        .empty-state { text-align: center; padding: 3rem 1rem; color: var(--muted); }
        .empty-state i { font-size: 3rem; margin-bottom: 1rem; color: #adb5bd; }

        /* ── Footer ── */
        footer { text-align: center; padding: 1.5rem; font-size: .82rem; color: var(--muted); margin-top: 2rem; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('tasks.index') }}">
            <i class="fas fa-check-circle"></i> To-Do App
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tasks.index') ? 'active' : '' }}"
                       href="{{ route('tasks.index') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                       href="{{ route('about') }}">About</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Flash Messages -->
<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

<!-- Page Content -->
@yield('content')

<footer>&copy; {{ date('Y') }} To-Do App. All rights reserved.</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>