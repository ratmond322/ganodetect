@extends('layouts.guest')

@section('content')
<div class="min-h-screen" style="background-color: #1E201E;">
  <!-- Header -->
  <div class="border-b border-white/10" style="background-color: #151715;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-white">Dashboard Admin</h1>
          <p class="text-white/60 mt-1">Monitoring & Analytics</p>
        </div>
        <div class="flex items-center gap-4">
          <!-- User Dropdown -->
          <div class="relative">
            <button data-dropdown-toggle="userDropdown" class="flex items-center gap-3 px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg transition cursor-pointer">
              @if(Auth::user()->profile_photo)
                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" class="w-8 h-8 rounded-full object-cover border-2 border-[#7c8d34]">
              @else
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#7c8d34] to-[#6a7a2a] flex items-center justify-center border-2 border-[#7c8d34]">
                  <span class="text-sm font-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
              @endif
              <span class="text-white/80">{{ Auth::user()->name }}</span>
              <svg class="w-4 h-4 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>

            <!-- Dropdown Menu -->
            <div id="userDropdown" data-dropdown-menu class="hidden absolute right-0 mt-2 w-56 bg-[#151715] border border-white/10 rounded-lg shadow-xl overflow-hidden z-50">
              <a href="{{ route('dashboard.admin') }}" class="block px-4 py-3 text-white/80 hover:bg-white/10 transition">
                <div class="flex items-center gap-3">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                  </svg>
                  <span>Dashboard</span>
                </div>
              </a>
              <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-white/80 hover:bg-white/10 transition">
                <div class="flex items-center gap-3">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                  </svg>
                  <span>Edit Profile</span>
                </div>
              </a>
              <div class="border-t border-white/10"></div>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-3 text-red-400 hover:bg-white/10 transition">
                  <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Logout</span>
                  </div>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <!-- Card 1 -->
      <div class="bg-gradient-to-br from-[#7c8d34] to-[#6a7a2a] p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-white/80 text-sm font-medium">Total Detections</p>
            <p class="text-3xl font-bold text-white mt-2">847</p>
            <p class="text-xs text-white/60 mt-1">↑ 12% dari bulan lalu</p>
          </div>
          <div class="text-4xl opacity-20">🍄</div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="bg-gradient-to-br from-[#fbbf24] to-[#f59e0b] p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-900/80 text-sm font-medium">Active Drones</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">24</p>
            <p class="text-xs text-gray-900/60 mt-1">3 sedang survey</p>
          </div>
          <div class="text-4xl opacity-20">🚁</div>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="bg-gradient-to-br from-[#10b981] to-[#059669] p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-white/80 text-sm font-medium">Healthy Trees</p>
            <p class="text-3xl font-bold text-white mt-2">92.4%</p>
            <p class="text-xs text-white/60 mt-1">Tree Health Score</p>
          </div>
          <div class="text-4xl opacity-20">🌿</div>
        </div>
      </div>

      <!-- Card 4 -->
      <div class="bg-gradient-to-br from-[#ef4444] to-[#dc2626] p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-white/80 text-sm font-medium">High Priority</p>
            <p class="text-3xl font-bold text-white mt-2">15</p>
            <p class="text-xs text-white/60 mt-1">Requires action</p>
          </div>
          <div class="text-4xl opacity-20">⚠️</div>
        </div>
      </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
      <!-- Detection Trend Chart -->
      <div class="bg-[#151715] p-6 rounded-xl shadow-lg border border-white/5">
        <h3 class="text-xl font-semibold text-white mb-4">Tren Deteksi Ganoderma</h3>
        <div style="position: relative; height: 250px;">
          <canvas id="detectionTrendChart"></canvas>
        </div>
      </div>

      <!-- Infection Level Distribution -->
      <div class="bg-[#151715] p-6 rounded-xl shadow-lg border border-white/5">
        <h3 class="text-xl font-semibold text-white mb-4">Distribusi Tingkat Infeksi</h3>
        <div style="position: relative; height: 250px;">
          <canvas id="infectionLevelChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
      <!-- Drone Location Map -->
      <div class="bg-[#151715] p-6 rounded-xl shadow-lg border border-white/5">
        <h3 class="text-xl font-semibold text-white mb-4">Lokasi Drone Real-time</h3>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        <div id="droneMap" style="height: 350px; border-radius: 0.75rem; overflow: hidden;"></div>
      </div>

      <!-- Area Coverage -->
      <div class="bg-[#151715] p-6 rounded-xl shadow-lg border border-white/5">
        <h3 class="text-xl font-semibold text-white mb-4">Area Coverage per Blok</h3>
        <div style="position: relative; height: 250px;">
          <canvas id="areaCoverageChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Charts Row 3 -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
      <!-- Tree Health Score -->
      <div class="bg-[#151715] p-6 rounded-xl shadow-lg border border-white/5">
        <h3 class="text-xl font-semibold text-white mb-4">Tree Health Score</h3>
        <div style="position: relative; height: 250px;">
          <canvas id="healthScoreChart"></canvas>
        </div>
      </div>

      <!-- Infection Level Distribution -->
      <div class="bg-[#151715] p-6 rounded-xl shadow-lg border border-white/5">
        <h3 class="text-xl font-semibold text-white mb-4">Distribusi Tingkat Infeksi</h3>
        <div style="position: relative; height: 250px;">
          <canvas id="infectionLevelChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-[#151715] p-6 rounded-xl shadow-lg border border-white/5">
      <h3 class="text-xl font-semibold text-white mb-4">Aktivitas Terbaru</h3>
      <div class="space-y-3">
        <div class="flex items-center gap-4 p-3 bg-white/5 rounded-lg">
          <div class="w-2 h-2 bg-[#10b981] rounded-full"></div>
          <div class="flex-1">
            <p class="text-white font-medium">Drone #12 menyelesaikan survey Blok A-15</p>
            <p class="text-white/50 text-sm">2 menit yang lalu</p>
          </div>
        </div>
        <div class="flex items-center gap-4 p-3 bg-white/5 rounded-lg">
          <div class="w-2 h-2 bg-[#fbbf24] rounded-full"></div>
          <div class="flex-1">
            <p class="text-white font-medium">Ganoderma terdeteksi di Blok C-08 - Tingkat: Sedang</p>
            <p class="text-white/50 text-sm">15 menit yang lalu</p>
          </div>
        </div>
        <div class="flex items-center gap-4 p-3 bg-white/5 rounded-lg">
          <div class="w-2 h-2 bg-[#ef4444] rounded-full"></div>
          <div class="flex-1">
            <p class="text-white font-medium">Alert: Infeksi tinggi di Blok B-22 membutuhkan tindakan</p>
            <p class="text-white/50 text-sm">1 jam yang lalu</p>
          </div>
        </div>
        <div class="flex items-center gap-4 p-3 bg-white/5 rounded-lg">
          <div class="w-2 h-2 bg-[#10b981] rounded-full"></div>
          <div class="flex-1">
            <p class="text-white font-medium">Treatment berhasil di Blok D-05 - Health score naik 15%</p>
            <p class="text-white/50 text-sm">3 jam yang lalu</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(function(){
  if (!window.Chart) return;

  // Shared color palette
  const colors = {
    olive: '#7c8d34',
    yellow: '#fbbf24',
    green: '#10b981',
    red: '#ef4444',
    white: '#ffffff',
    dark: '#1E201E'
  };

  // Detection Trend Chart
  const detectionTrendCtx = document.getElementById('detectionTrendChart')?.getContext('2d');
  if (detectionTrendCtx) {
    new Chart(detectionTrendCtx, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
          label: 'Deteksi Ganoderma',
          data: [45, 52, 48, 65, 72, 68],
          borderColor: colors.olive,
          backgroundColor: colors.olive + '20',
          tension: 0.4,
          fill: true,
          pointBackgroundColor: colors.olive,
          pointBorderColor: colors.white,
          pointBorderWidth: 2
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { 
            labels: { color: colors.white }
          }
        },
        scales: {
          y: { 
            beginAtZero: true,
            ticks: { color: colors.white + 'cc' },
            grid: { color: colors.white + '10' }
          },
          x: {
            ticks: { color: colors.white + 'cc' },
            grid: { color: colors.white + '10' }
          }
        }
      }
    });
  }

  // Infection Level Chart (Doughnut)
  const infectionLevelCtx = document.getElementById('infectionLevelChart')?.getContext('2d');
  if (infectionLevelCtx) {
    new Chart(infectionLevelCtx, {
      type: 'doughnut',
      data: {
        labels: ['Rendah', 'Sedang', 'Tinggi', 'Kritis'],
        datasets: [{
          data: [45, 30, 20, 5],
          backgroundColor: [colors.green, colors.yellow, '#fb923c', colors.red],
          borderWidth: 0
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: { color: colors.white, padding: 15 }
          }
        }
      }
    });
  }

  // Area Coverage Chart
  const areaCoverageCtx = document.getElementById('areaCoverageChart')?.getContext('2d');
  if (areaCoverageCtx) {
    new Chart(areaCoverageCtx, {
      type: 'bar',
      data: {
        labels: ['Blok A', 'Blok B', 'Blok C', 'Blok D'],
        datasets: [{
          label: 'Trees Scanned',
          data: [320, 285, 310, 298],
          backgroundColor: colors.olive,
          borderRadius: 8
        }, {
          label: 'Infected Trees',
          data: [24, 38, 18, 42],
          backgroundColor: colors.red,
          borderRadius: 8
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            labels: { color: colors.white }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: { color: colors.white + 'cc' },
            grid: { color: colors.white + '10' }
          },
          x: {
            ticks: { color: colors.white + 'cc' },
            grid: { display: false }
          }
        }
      }
    });
  }

  // Health Score Chart
  const healthScoreCtx = document.getElementById('healthScoreChart')?.getContext('2d');
  if (healthScoreCtx) {
    new Chart(healthScoreCtx, {
      type: 'doughnut',
      data: {
        labels: ['Excellent', 'Good', 'Fair', 'Poor'],
        datasets: [{
          data: [65, 25, 8, 2],
          backgroundColor: [colors.green, colors.olive, colors.yellow, colors.red],
          borderWidth: 0
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: { color: colors.white, padding: 10 }
          }
        }
      }
    });
  }
})();

// Drone Map with Leaflet
(function(){
  if (!window.L) return;
  const mapEl = document.getElementById('droneMap');
  if (!mapEl) return;

  // Center map on Kebun Percobaan Cikabayan IPB University Bogor
  const map = L.map(mapEl).setView([-6.5588, 106.7283], 16);
  
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  // Custom drone icon (triangle)
  const droneIcon = L.divIcon({
    className: 'drone-marker',
    html: `<div style="
      width: 0;
      height: 0;
      border-left: 12px solid transparent;
      border-right: 12px solid transparent;
      border-bottom: 20px solid #7c8d34;
      transform: rotate(45deg);
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
    "></div>`,
    iconSize: [24, 24],
    iconAnchor: [12, 12]
  });

  // Infection marker icon
  const infectionIcon = L.divIcon({
    className: 'infection-marker',
    html: `<div style="
      width: 16px;
      height: 16px;
      background: #ef4444;
      border: 3px solid white;
      border-radius: 50%;
      box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    "></div>`,
    iconSize: [16, 16],
    iconAnchor: [8, 8]
  });

  // Dummy drone locations at Kebun Percobaan Cikabayan
  const drones = [
    { id: 'Drone #3', lat: -6.5588, lng: 106.7283, status: 'Surveying Blok A-15', battery: 78 },
    { id: 'Drone #7', lat: -6.5595, lng: 106.7275, status: 'En route to Blok B-12', battery: 92 },
    { id: 'Drone #12', lat: -6.5580, lng: 106.7290, status: 'Charging', battery: 45 }
  ];

  // Dummy infection locations
  const infections = [
    { blok: 'Blok C-08', lat: -6.5592, lng: 106.7280, level: 'Sedang' },
    { blok: 'Blok B-22', lat: -6.5585, lng: 106.7270, level: 'Tinggi' }
  ];

  // Add drone markers
  drones.forEach(drone => {
    const marker = L.marker([drone.lat, drone.lng], { icon: droneIcon }).addTo(map);
    marker.bindPopup(`
      <div style="color: #1E201E; font-weight: 600;">${drone.id}</div>
      <div style="color: #4b5563; font-size: 0.875rem; margin-top: 4px;">
        ${drone.status}<br/>
        Battery: <span style="color: ${drone.battery > 50 ? '#10b981' : '#ef4444'};">${drone.battery}%</span>
      </div>
    `);
  });

  // Add infection markers
  infections.forEach(infection => {
    const marker = L.marker([infection.lat, infection.lng], { icon: infectionIcon }).addTo(map);
    marker.bindPopup(`
      <div style="color: #1E201E; font-weight: 600;">${infection.blok}</div>
      <div style="color: #ef4444; font-size: 0.875rem; margin-top: 4px;">
        Tingkat Infeksi: ${infection.level}
      </div>
    `);
  });

  // Auto-open first drone popup
  setTimeout(() => {
    map.setView([-6.5588, 106.7283], 16);
  }, 500);
})();

// User Dropdown Fallback (if Alpine.js fails)
document.addEventListener('DOMContentLoaded', function() {
  const dropdownButtons = document.querySelectorAll('[data-dropdown-toggle]');
  
  dropdownButtons.forEach(button => {
    button.addEventListener('click', function(e) {
      e.stopPropagation();
      const dropdownId = this.getAttribute('data-dropdown-toggle');
      const dropdown = document.getElementById(dropdownId);
      
      if (dropdown) {
        dropdown.classList.toggle('hidden');
      }
    });
  });

  // Close dropdown when clicking outside
  document.addEventListener('click', function() {
    document.querySelectorAll('[data-dropdown-menu]').forEach(dropdown => {
      dropdown.classList.add('hidden');
    });
  });
});
</script>
@endsection

