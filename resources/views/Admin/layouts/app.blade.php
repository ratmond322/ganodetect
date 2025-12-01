<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin - {{ config('app.name') }}</title>

  <!-- Preconnect to CDN -->
  <link rel="preconnect" href="https://cdn.jsdelivr.net">
  <link rel="preconnect" href="https://cdnjs.cloudflare.com">

  <!-- Bootstrap 5 CSS (CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- optional icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    :root{
      --brand-green: #2d3a1f;
      --brand-green-light: #3a4a28;
      --brand-accent: #10b981;
      --brand-dark: #1a2312;
      --muted: #6b6b6b;
    }

    body { font-family: Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#1a2312; color: #e5e7eb; }

    /* sidebar */
    .admin-sidebar{
      background: linear-gradient(180deg, #2d3a1f, #1a2312);
      border-right: 1px solid rgba(16,185,129,0.2);
      min-height: 100vh;
    }
    .admin-sidebar .nav-link { color: #d1d5db; font-weight:600; transition: all 0.3s; }
    .admin-sidebar .nav-link.active { background: rgba(16,185,129,0.2); color:#34d399; border-radius:8px; }

    .admin-sidebar .nav-link:hover { background: rgba(16,185,129,0.1); color:#10b981; }
    
    .topbar {
      background: rgba(45,58,31,0.8);
      border-bottom: 1px solid rgba(16,185,129,0.2);
      backdrop-filter: blur(10px);
    }

    .card-admin { border-radius:12px; box-shadow: 0 6px 20px rgba(0,0,0,0.3); background: #2d3a1f; border: 1px solid rgba(16,185,129,0.1); }

    .badge-green { background: linear-gradient(135deg, #10b981, #34d399); color: #fff; }

    .dropdown-item:hover {
      background-color: rgba(16,185,129,0.2) !important;
      color: #10b981 !important;
    }

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
        <a href="{{ route('home') }}" class="d-block mb-2 text-decoration-none">
          <h4 class="mb-0 fw-bold" style="color: #10b981;">GANODETECT</h4>
        </a>
        <div class="small" style="color: #9ca3af;">Admin Panel</div>
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
          <button class="btn btn-sm btn-outline-secondary d-md-none" id="toggleSidebar" style="color: #9ca3af; border-color: #4b5563;">☰</button>
          <div class="small" style="color: #9ca3af;">Welcome, {{ auth()->user()->name ?? 'Admin' }}</div>
        </div>
        <div class="d-flex align-items-center gap-3">
          <a href="{{ url('/') }}" class="text-decoration-none" style="color: #10b981;">View site</a>
          <div class="dropdown">
            <a href="#" data-bs-toggle="dropdown" class="d-flex align-items-center text-decoration-none">
              <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: linear-gradient(135deg, #10b981, #34d399);">
                <i class="fas fa-user" style="color: white; font-size: 16px;"></i>
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" style="background: #2d3a1f; border-color: #4b5563;">
              <li><a class="dropdown-item" href="#" style="color: #e5e7eb;">Profile</a></li>
              <li><hr class="dropdown-divider" style="border-color: #4b5563;"></li>
              <li>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                  @csrf
                  <button type="submit" class="dropdown-item" style="color: #e5e7eb;">Logout</button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </header>

      <!-- CONTENT -->
      <main class="p-4">
        @if(session('status'))
        <div class="alert alert-dismissible fade show" role="alert" style="background: rgba(16,185,129,0.2); border: 1px solid #10b981; color: #34d399;">
          <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" style="filter: brightness(0) invert(1);"></button>
        </div>
        @endif
        
        @yield('content')
      </main>

      <!-- FOOTER -->
      <footer class="p-4 text-center small" style="color: #6b7280;">
        &copy; {{ date('Y') }} Ganodetect. All rights reserved.
      </footer>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const toggleBtn = document.getElementById('toggleSidebar');
      if (toggleBtn) {
        toggleBtn.addEventListener('click', function(){
          document.querySelector('.admin-sidebar').classList.toggle('d-none');
        });
      }
    });
  </script>

  @stack('scripts')
</body>
</html>
