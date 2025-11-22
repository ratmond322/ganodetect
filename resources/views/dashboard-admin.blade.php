@extends('layouts.guest')

@section('content')
<div class="min-h-screen" style="background-color: #1E201E;">
  <!-- Header -->
  <div class="border-b border-white/10" style="background-color: #151715;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-white">Halo, Selamat Datang!👋</h1>
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

    <!-- Upload + Result (improved layout) -->
    <div class="mb-6 max-w-6xl mx-auto bg-[#151515] p-6 rounded-lg">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        <!-- left: upload + preview -->
        <div class="col-span-1 lg:col-span-1">
          <form id="detect-form" action="{{ route('detect') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-3">
            @csrf
            <input id="image-input" type="file" name="image" accept="image/*" required class="text-sm text-white/80 bg-[#0f0f0f] p-2 rounded" />
            <div class="mt-2">
              <img id="preview-img" src="" alt="preview" class="w-full max-h-48 object-contain rounded border border-white/10 hidden" />
            </div>

            <div class="flex gap-3 mt-3">
              <button id="upload-btn" type="submit" class="px-4 py-2 bg-[#7c8d34] rounded text-white disabled:opacity-60" disabled>Upload & Detect</button>
              <button id="clear-btn" type="button" class="px-4 py-2 bg-white/5 rounded text-white">Clear</button>
            </div>

            <div id="detect-message" class="mt-3"></div>
          </form>

          <!-- NOTE: Quick Stats removed as requested -->
        </div>

        <!-- middle: annotated image (smaller) -->
        <div class="col-span-1 lg:col-span-1">
          <div class="bg-[#0b0b0b] p-3 rounded">
            <h4 class="text-white font-semibold mb-2">Hasil Deteksi</h4>
            <img id="det-image" src="" alt="annotated" class="w-full max-h-64 object-contain rounded border border-white/10 bg-black" />
          </div>
        </div>

        <!-- right: descriptions / predictions -->
        <div class="col-span-1 lg:col-span-1">
          <div class="p-3 bg-[#0b0b0b] rounded">
            <h4 class="text-white font-semibold mb-2">Deskripsi Deteksi</h4>
            <div id="pred-meta" class="text-white/70 text-sm mb-3">Belum ada deteksi.</div>
            <ul id="pred-list" class="list-disc pl-5 text-white/80"></ul>
          </div>
        </div>
      </div>

      @if(session('error'))
        <div class="mt-3 p-3 bg-red-600 text-white rounded mb-2">{{ session('error') }}</div>
      @endif
    </div>

    <!-- Cards (bigger, dynamic placeholders) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div id="card-total-box" class="p-6 rounded-xl shadow-lg bg-gradient-to-br from-[#7c8d34] to-[#6a7a2a]">
        <p class="text-white/80 text-sm font-medium">Total Detections</p>
        <p id="card-total-main" class="text-3xl font-bold text-white mt-2">—</p>
        <p class="text-xs text-white/60 mt-1">Realtime</p>
      </div>

      <div id="card-drones-box" class="p-6 rounded-xl shadow-lg bg-gradient-to-br from-[#fbbf24] to-[#f59e0b]">
        <p class="text-gray-900/80 text-sm font-medium">Active Drones</p>
        <p id="card-drones-main" class="text-3xl font-bold text-gray-900 mt-2">—</p>
        <p class="text-xs text-gray-900/60 mt-1">Connected</p>
      </div>

      <div id="card-healthy-box" class="p-6 rounded-xl shadow-lg bg-gradient-to-br from-[#10b981] to-[#059669]">
        <p class="text-white/80 text-sm font-medium">Healthy Trees</p>
        <p id="card-healthy-main" class="text-3xl font-bold text-white mt-2">—</p>
        <p class="text-xs text-white/60 mt-1">Tree Health Score</p>
      </div>

      <div id="card-priority-box" class="p-6 rounded-xl shadow-lg bg-gradient-to-br from-[#ef4444] to-[#dc2626]">
        <p class="text-white/80 text-sm font-medium">High Priority</p>
        <p id="card-priority-main" class="text-3xl font-bold text-white mt-2">—</p>
        <p class="text-xs text-white/60 mt-1">Actions Needed</p>
      </div>
    </div>

    <!-- Charts & Maps (kept but will be updated by data) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
      <div class="bg-[#151715] p-6 rounded-xl shadow-lg border border-white/5">
        <h3 class="text-xl font-semibold text-white mb-4">Tren Deteksi Ganoderma</h3>
        <div style="position: relative; height: 250px;">
          <canvas id="detectionTrendChart"></canvas>
        </div>
      </div>

      <div class="bg-[#151715] p-6 rounded-xl shadow-lg border border-white/5">
        <h3 class="text-xl font-semibold text-white mb-4">Distribusi Tingkat Infeksi</h3>
        <div style="position: relative; height: 250px;">
          <canvas id="infectionLevelChart"></canvas>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
      <div class="bg-[#151715] p-6 rounded-xl shadow-lg border border-white/5">
        <h3 class="text-xl font-semibold text-white mb-4">Lokasi Drone Real-time</h3>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
        <div id="droneMap" style="height: 350px; border-radius: 0.75rem; overflow: hidden;"></div>
      </div>

      <div class="bg-[#151715] p-6 rounded-xl shadow-lg border border-white/5">
        <h3 class="text-xl font-semibold text-white mb-4">Area Coverage per Blok</h3>
        <div style="position: relative; height: 250px;">
          <canvas id="areaCoverageChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Recent Activities (dynamic) -->
    <div class="bg-[#151715] p-6 rounded-xl shadow-lg border border-white/5">
      <h3 class="text-xl font-semibold text-white mb-4">Aktivitas Terbaru</h3>
      <div id="recent-list" class="space-y-3 text-white/80">Memuat...</div>
    </div>

  </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<!-- Main page JS (enhanced) -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  // UI refs
  const form = document.getElementById('detect-form');
  const imageInput = document.getElementById('image-input');
  const previewImg = document.getElementById('preview-img');
  const uploadBtn = document.getElementById('upload-btn');
  const clearBtn = document.getElementById('clear-btn');
  const messageEl = document.getElementById('detect-message');
  const detImg = document.getElementById('det-image');
  const predList = document.getElementById('pred-list');
  const predMeta = document.getElementById('pred-meta');

  // cards
  const cardTotal = document.getElementById('card-total-main');
  const cardDrones = document.getElementById('card-drones-main');
  const cardHealthy = document.getElementById('card-healthy-main');
  const cardPriority = document.getElementById('card-priority-main');

  function showMessage(html, type='info'){
    const bg = type === 'error' ? 'bg-red-600' : 'bg-yellow-600';
    messageEl.innerHTML = `<div class="p-3 ${bg} text-white rounded">${html}</div>`;
  }

  // preview selected file
  imageInput.addEventListener('change', function(e){
    const f = this.files && this.files[0];
    if(!f){ previewImg.src=''; previewImg.classList.add('hidden'); uploadBtn.disabled = true; return; }
    const url = URL.createObjectURL(f);
    previewImg.src = url; previewImg.classList.remove('hidden'); uploadBtn.disabled = false;
  });

  clearBtn.addEventListener('click', function(){
    imageInput.value = '';
    previewImg.src = '';
    previewImg.classList.add('hidden');
    uploadBtn.disabled = true;
  });

  // draw predictions list and meta
  function renderPreds(preds){
    predList.innerHTML = '';
    if(!preds || preds.length === 0){
      predMeta.textContent = 'Tidak ada objek terdeteksi.';
      return;
    }
    predMeta.textContent = `Jumlah objek: ${preds.length}`;
    preds.forEach(p => {
      const li = document.createElement('li');
      li.className = 'mb-1';
      li.innerHTML = `<strong>${p.label}</strong> — ${(p.confidence*100).toFixed(1)}% <span class="text-white/60 text-sm">bbox: ${(p.bbox||[]).map(x=>Math.round(x)).join(',')}</span>`;
      predList.appendChild(li);
    });
  }

  // small helper to update cards (tries API, falls back to dummy)
  async function refreshCards(){
    try{
      const res = await fetch('/api/dashboard-stats');
      if(res.ok){
        const j = await res.json();
        cardTotal.textContent = j.total || '—';
        cardDrones.textContent = j.drones || '—';
        cardHealthy.textContent = j.healthy || '—';
        cardPriority.textContent = j.priority || '—';
        document.getElementById('card-total').textContent = j.total || '—';
      } else throw new Error('no api');
    }catch(e){
      // fallback dummy
      cardTotal.textContent = '847';
      cardDrones.textContent = '24';
      cardHealthy.textContent = '92.4%';
      cardPriority.textContent = '15';
      document.getElementById('card-total').textContent = '847';
    }
  }

  // recent detections
  async function refreshRecent(){
    const container = document.getElementById('recent-list');
    try{
      const res = await fetch('/api/recent-detections');
      if(res.ok){
        const j = await res.json();
        if(Array.isArray(j) && j.length){
          container.innerHTML = j.map(it=>`<div class="flex items-center gap-4 p-3 bg-white/5 rounded-lg"><div class="w-2 h-2 ${it.level==='High'?'bg-red-500':'bg-green-400'} rounded-full"></div><div class="flex-1"><p class="text-white font-medium">${it.title}</p><p class="text-white/50 text-sm">${it.time}</p></div></div>`).join('');
          return;
        }
      }
    }catch(e){/*ignore*/}
    // fallback
    container.innerHTML = `
      <div class="flex items-center gap-4 p-3 bg-white/5 rounded-lg"><div class="w-2 h-2 bg-green-400 rounded-full"></div><div class="flex-1"><p class="text-white font-medium">Drone #12 menyelesaikan survey Blok A-15</p><p class="text-white/50 text-sm">2 menit yang lalu</p></div></div>
      <div class="flex items-center gap-4 p-3 bg-white/5 rounded-lg"><div class="w-2 h-2 bg-yellow-400 rounded-full"></div><div class="flex-1"><p class="text-white font-medium">Ganoderma terdeteksi di Blok C-08 - Tingkat: Sedang</p><p class="text-white/50 text-sm">15 menit yang lalu</p></div></div>
    `;
  }

  // charts init with placeholders; update function available
  const detectionTrendCtx = document.getElementById('detectionTrendChart')?.getContext('2d');
  let detectionTrendChart = null;
  if(detectionTrendCtx){
    detectionTrendChart = new Chart(detectionTrendCtx, {type:'line', data:{labels:['Mon','Tue','Wed','Thu','Fri','Sat'], datasets:[{label:'Deteksi per hari',data:[5,8,4,12,7,9], tension:0.4, borderColor:'#7c8d34', backgroundColor:'#7c8d3420', fill:true}]}, options:{responsive:true, maintainAspectRatio:false, plugins:{legend:{labels:{color:'#fff'}}}, scales:{y:{ticks:{color:'#fff'}},x:{ticks:{color:'#fff'}}}}});
    // expose for external updates
    window._detectionTrendChart = detectionTrendChart;
  }

  const infectionLevelCtx = document.getElementById('infectionLevelChart')?.getContext('2d');
  let infectionLevelChart = null;
  if(infectionLevelCtx){
    infectionLevelChart = new Chart(infectionLevelCtx, {type:'doughnut', data:{labels:['Rendah','Sedang','Tinggi'], datasets:[{data:[60,30,10], backgroundColor:['#10b981','#fbbf24','#ef4444']}]}, options:{responsive:true, maintainAspectRatio:false, plugins:{legend:{labels:{color:'#fff'}}}}});
    window._infectionLevelChart = infectionLevelChart;
  }

  // Area coverage chart (per blok) - added so the area box won't be empty
  const areaCoverageCtx = document.getElementById('areaCoverageChart')?.getContext('2d');
  let areaCoverageChart = null;
  if (areaCoverageCtx) {
    areaCoverageChart = new Chart(areaCoverageCtx, {
      type: 'bar',
      data: {
        labels: ['Blok A','Blok B','Blok C','Blok D'],
        datasets: [
          { label: 'Trees Scanned', data: [320, 285, 310, 298], borderRadius: 8, backgroundColor: '#7c8d34' },
          { label: 'Infected Trees', data: [24, 38, 18, 42], borderRadius: 8, backgroundColor: '#ef4444' }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { labels: { color: '#fff' } } },
        scales: {
          y: { beginAtZero: true, ticks: { color: '#fff' }, grid: { color: 'rgba(255,255,255,0.06)' } },
          x: { ticks: { color: '#fff' }, grid: { display: false } }
        }
      }
    });
    window._areaCoverageChart = areaCoverageChart;
  }

  // map init (dummy markers)
  if(window.L){
    const map = L.map('droneMap').setView([-6.5588,106.7283], 10);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19, attribution:'© OpenStreetMap contributors'}).addTo(map);
    const droneIcon = L.divIcon({className:'drone-marker', html:`<div style="width:0;height:0;border-left:10px solid transparent;border-right:10px solid transparent;border-bottom:16px solid #7c8d34;transform:rotate(45deg);"></div>`, iconSize:[24,24]});
    const m1 = L.marker([-6.5588,106.7283], {icon:droneIcon}).addTo(map).bindPopup('Drone #3: Blok A-15');
    const m2 = L.marker([-6.5592,106.7280]).addTo(map).bindPopup('Infection: Blok C-08');
    // expose map instance for adding markers later
    window._ganod_mapInstance = map;
  }

  // util: add marker helper
  function addMapMarker(lat, lng, title){
    try{
      if(window._ganod_mapInstance){
        const m = L.marker([lat,lng]).addTo(window._ganod_mapInstance).bindPopup(title || 'Deteksi');
        return m;
      }
    }catch(e){console.warn('addMapMarker', e);}    
  }

  // POLL: Poll endpoint for processed result
  async function pollDetection(id, imageUrl){
    detImg.src = imageUrl;
    showMessage('Menunggu hasil deteksi...');
    const interval = setInterval(async ()=>{
      try{
        const res = await fetch(`/detection/${id}`, {credentials:'same-origin'});
        if(!res.ok) throw new Error('Status ' + res.status);
        const data = await res.json();
        // when annotated_url available or predictions non-empty, finish
        if(data.annotated_url || (Array.isArray(data.predictions) && data.predictions.length>0) || data.done){
          clearInterval(interval);
          showMessage('Deteksi selesai.');
          const annotated = data.annotated_url || imageUrl;
          detImg.src = annotated;
          renderPreds(Array.isArray(data.predictions)?data.predictions:[]);

          // --- NEW: apply UI updates across dashboard ---
          try{
            // 1) update cards: increment total by 1 and set basic values
            const todaysCount = Array.isArray(data.predictions)?data.predictions.length:0;
            // increment total displayed
            const prevTotal = parseInt(document.getElementById('card-total').textContent.replace(/[^0-9]/g,'') || 0, 10);
            document.getElementById('card-total').textContent = prevTotal + 1;
            document.getElementById('card-total-main').textContent = prevTotal + 1;

            // try to refresh real stats from API (non-blocking)
            refreshCards();

            // 2) add recent activity item at top
            const recent = document.getElementById('recent-list');
            const item = document.createElement('div');
            item.className = 'flex items-center gap-4 p-3 bg-white/5 rounded-lg';
            const colorDot = todaysCount>0 ? 'bg-yellow-400' : 'bg-green-400';
            item.innerHTML = `<div class="w-2 h-2 ${colorDot} rounded-full"></div><div class="flex-1"><p class="text-white font-medium">Deteksi #${id} - ${todaysCount} objek</p><p class="text-white/50 text-sm">baru saja</p></div>`;
            if(recent) recent.prepend(item);

            // 3) update trend chart by appending today's count
            if(window._detectionTrendChart){
              const chart = window._detectionTrendChart;
              chart.data.labels.push('Now');
              chart.data.datasets[0].data.push(todaysCount);
              chart.update();
            }

            // 4) add marker to map near center for visualization
            if(window._ganod_mapInstance){
              const c = window._ganod_mapInstance.getCenter();
              const lat = c.lat + (Math.random()-0.5)*0.02;
              const lng = c.lng + (Math.random()-0.5)*0.02;
              addMapMarker(lat,lng, `Deteksi #${id} (${todaysCount})`);
            }

            // 5) update infection distribution chart if server provides data
            if(window._infectionLevelChart && data.distribution){
              window._infectionLevelChart.data.datasets[0].data = data.distribution;
              window._infectionLevelChart.update();
            }

            // 6) update area coverage chart (simple demo update)
            if(window._areaCoverageChart){
              try{
                // demo: add todaysCount to infected count of Blok A (index 0)
                const ach = window._areaCoverageChart;
                ach.data.datasets[1].data[0] = (ach.data.datasets[1].data[0] || 0) + todaysCount;
                ach.update();
              }catch(e){ console.warn('area chart update err', e); }
            }

          }catch(e){console.warn('applyUI updates error', e);}          
          return;
        }
      }catch(err){
        clearInterval(interval);
        showMessage('Gagal memeriksa status: '+err.message, 'error');
      }
    }, 1500);
  }

  // form submit (AJAX)
  if(form){
    form.addEventListener('submit', async function(e){
      e.preventDefault();
      const fd = new FormData(form);
      showMessage('Mengunggah...');
      try{
        const resp = await fetch(form.action, {method:'POST', body:fd, credentials:'same-origin', headers:{'X-Requested-With':'XMLHttpRequest','X-CSRF-TOKEN':'{{ csrf_token() }}'}});
        const text = await resp.text();
        let json = null;
        try{ json = JSON.parse(text); } catch(er){ console.error('Non-JSON response', text); throw new Error('Server returned non-JSON.'); }
        if(json.error){ showMessage(json.error, 'error'); return; }
        // start polling
        await pollDetection(json.detection_id, json.image_url);
      }catch(err){
        console.error(err);
        showMessage('Upload gagal: '+err.message, 'error');
      }
    });
  }

  // initialize dynamic bits
  refreshCards();
  refreshRecent();

  // DROPDOWN TOGGLE: profil user dropdown (open/close) - ensure logout visible
  document.querySelectorAll('[data-dropdown-toggle]').forEach(button => {
    button.addEventListener('click', function (e) {
      e.stopPropagation();
      const targetId = this.getAttribute('data-dropdown-toggle');
      const dropdown = document.getElementById(targetId);
      if (dropdown) dropdown.classList.toggle('hidden');
    });
  });
  document.addEventListener('click', function () {
    document.querySelectorAll('[data-dropdown-menu]').forEach(menu => menu.classList.add('hidden'));
  });

});
</script>

@endsection
