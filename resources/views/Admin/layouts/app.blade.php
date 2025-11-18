<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin - {{ config('app.name') }}</title>

  <!-- Bootstrap 5 CSS (CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- optional icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    :root{
      --brand-cream: #e7dfb0;
      --brand-olive: #6b8c2f;
      --brand-dark: #333;
      --muted: #6b6b6b;
    }

    body { font-family: Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f6f2e7; }

    /* sidebar */
    .admin-sidebar{
      background: linear-gradient(180deg, var(--brand-cream), #e4ddb0);
      border-right: 1px solid rgba(0,0,0,0.04);
      min-height: 100vh;
    }
    .admin-sidebar .nav-link { color: var(--brand-dark); font-weight:600; }
    .admin-sidebar .nav-link.active { background: rgba(107,140,47,0.12); color:var(--brand-olive); border-radius:8px; }

    .topbar {
      background: transparent;
      border-bottom: 1px solid rgba(0,0,0,0.04);
      backdrop-filter: blur(4px);
    }

    .card-admin { border-radius:12px; box-shadow: 0 6px 20px rgba(50,50,75,0.06); }

    .badge-olive { background: var(--brand-olive); color: #fff; }

    /* responsive */
    @media (max-width: 991px){
      .admin-sidebar{ position:relative; min-height:auto; }
    }
  </style>

  @stack('styles')
</head>
<body>
  <div class="d-flex">
    <!-- SIDEBAR -->
    <aside class="admin-sidebar p-3" style="width:260px;">
      <div class="mb-4 text-center">
        <a href="{{ route('home') }}" class="d-block mb-2">
          <img src="{{ asset('images/logo.png') }}" alt="logo" style="height:36px; opacity:.9;">
        </a>
        <div class="small text-muted">Ganodetect Admin</div>
      </div>

      <nav class="nav flex-column">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
          <i class="fa fa-chart-line me-2"></i> Dashboard
        </a>
        <a class="nav-link {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}" href="{{ route('admin.articles.index') }}">
          <i class="fa fa-newspaper me-2"></i> Articles
        </a>
        <!-- tambahin menu lain sesuai usecase -->
      </nav>
    </aside>

    <!-- MAIN -->
    <div class="flex-grow-1">
      <!-- TOPBAR -->
      <header class="topbar px-4 py-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
          <button class="btn btn-sm btn-outline-secondary d-md-none" id="toggleSidebar">☰</button>
          <div class="text-muted small">Welcome, {{ auth()->user()->name ?? 'Admin' }}</div>
        </div>
        <div class="d-flex align-items-center gap-3">
          <a href="{{ url('/') }}" class="text-decoration-none text-muted">View site</a>
          <div class="dropdown">
            <a href="#" data-bs-toggle="dropdown" class="d-flex align-items-center text-decoration-none">
              <img src="{{ asset('images/avatar.jpg') }}" alt="user" class="rounded-circle" width="36" height="36">
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                  @csrf
                  <button type="submit" class="dropdown-item">Logout</button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </header>

      <!-- CONTENT -->
      <main class="p-4">
        @yield('content')
      </main>

      <!-- FOOTER -->
      <footer class="p-4 text-center text-muted small">
        &copy; {{ date('Y') }} Ganodetect. All rights reserved.
      </footer>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.getElementById('toggleSidebar')?.addEventListener('click', function(){
      document.querySelector('.admin-sidebar').classList.toggle('d-none');
    });
  </script>

  @stack('scripts')
</body>
</html>
