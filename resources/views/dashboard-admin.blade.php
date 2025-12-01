@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-[#1E201E]">
  <!-- Header -->
  <div class="border-b border-white/10 bg-[#151715]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-white">Halo, Selamat Datang!</h1>
          <p class="text-sm text-white/60 mt-1">Monitoring Ganoderma</p>
        </div>

        <div class="flex items-center gap-4">
          <button id="btn-reset-all" class="px-4 py-2 bg-white/5 text-white rounded hover:bg-white/10 transition">Reset Semua Deteksi</button>
          <button id="btn-backup" class="px-4 py-2 bg-white/5 text-white rounded hover:bg-white/10 transition">Export DB (dump)</button>

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
              <a href="{{ route('dashboard.admin') }}" class="block px-4 py-3 text-white/80 hover:bg-white/10 transition">Dashboard</a>
              <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-white/80 hover:bg-white/10 transition">Edit Profile</a>
              <div class="border-t border-white/10"></div>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-3 text-red-400 hover:bg-white/10 transition">Logout</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Upload / Recent / Descriptions -->
    <div class="mb-6 bg-[#151515] p-6 rounded-lg">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        <!-- Upload -->
        <div>
          <form id="detect-form" action="{{ route('detect') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-3">
            @csrf
            <label class="text-white font-medium">Pilih gambar (boleh lebih dari 1)</label>
            <input id="image-input" type="file" name="image" accept="image/*" multiple class="text-sm text-white/80 bg-[#0f0f0f] p-2 rounded" />
            <div id="preview-container" class="flex gap-3 mt-3 flex-wrap"></div>
            <div class="flex gap-3 mt-3">
              <button id="upload-btn" type="submit" class="px-4 py-2 bg-[#7c8d34] rounded text-white disabled:opacity-60" disabled>Upload & Detect</button>
              <button id="clear-btn" type="button" class="px-4 py-2 bg-white/5 rounded text-white">Clear</button>
              <button id="btn-delete-temp" type="button" class="px-4 py-2 bg-red-600 rounded text-white hidden">Hapus Percobaan</button>
            </div>
            <div id="detect-message" class="mt-3"></div>
            <p class="text-sm text-white/60 mt-3">Catatan: setiap file akan dikirim satu-per-satu dan diproses terpisah.</p>
          </form>
        </div>

        <!-- Recent -->
        <div>
          <div class="bg-[#0b0b0b] p-4 rounded">
            <div class="flex items-center justify-between mb-3">
              <h4 class="text-white font-semibold">Hasil Deteksi Terbaru</h4>
              <a id="view-all-btn" href="{{ route('detections.index') }}" class="text-sm text-white/60 hover:underline">Lihat semua</a>
            </div>
            <div id="recent-list" class="space-y-4 max-h-[56vh] overflow-auto px-2"></div>
          </div>
        </div>

        <!-- Descriptions -->
        <div>
          <div class="p-4 bg-[#0b0b0b] rounded">
            <h4 class="text-white font-semibold mb-2">Deskripsi Deteksi</h4>
            <div id="pred-meta" class="text-white/70 text-sm mb-3">Belum ada deteksi.</div>
            <ul id="pred-list" class="list-disc pl-5 text-white/80 space-y-1"></ul>
            <div class="mt-4 border-t border-white/5 pt-3">
              <p class="text-xs text-white/60">Tips: klik tombol <span class="font-semibold">Detail</span> pada hasil deteksi untuk melihat bounding box & statistik.</p>
            </div>
          </div>
        </div>
      </div>

      @if(session('error'))
        <div class="mt-3 p-3 bg-red-600 text-white rounded mb-2">{{ session('error') }}</div>
      @endif
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
      <div class="p-6 rounded-xl shadow-lg bg-gradient-to-br from-[#7c8d34] to-[#6a7a2a]">
        <p class="text-white/90 text-sm font-medium">Total Detections</p>
        <p id="card-total-main" class="text-3xl font-bold text-white mt-2">—</p>
        <p class="text-xs text-white/70 mt-1">Realtime</p>
      </div>

      <div class="p-6 rounded-xl shadow-lg bg-gradient-to-br from-[#fbbf24] to-[#f59e0b]">
        <p class="text-gray-900/90 text-sm font-medium">Active Drones</p>
        <p id="card-drones-main" class="text-3xl font-bold text-gray-900 mt-2">—</p>
        <p class="text-xs text-gray-900/70 mt-1">Connected</p>
      </div>

      <div class="p-6 rounded-xl shadow-lg bg-gradient-to-br from-[#ef4444] to-[#dc2626]">
        <p class="text-white/90 text-sm font-medium">High Priority</p>
        <p id="card-priority-main" class="text-3xl font-bold text-white mt-2">—</p>
        <p class="text-xs text-white/70 mt-1">Actions Needed</p>
      </div>
    </div>

    <!-- Charts & Map -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
      <div class="bg-[#151715] p-6 rounded-xl shadow-lg border border-white/5">
        <h3 class="text-xl font-semibold text-white mb-4">Tren Deteksi (7 hari)</h3>
        <div style="position: relative; height: 280px;">
          <canvas id="detectionTrendChart"></canvas>
        </div>
      </div>

      <div class="bg-[#151715] p-6 rounded-xl shadow-lg border border-white/5">
        <h3 class="text-xl font-semibold text-white mb-4">Distribusi Tingkat Infeksi</h3>
        <div style="position: relative; height: 280px;">
          <canvas id="infectionLevelChart"></canvas>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
      <div class="bg-[#151715] p-6 rounded-xl shadow-lg border border-white/5">
        <h3 class="text-xl font-semibold text-white mb-4">Lokasi Drone Real-time</h3>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
        <div id="droneMap" style="height: 360px; border-radius: 0.75rem; overflow: hidden;"></div>
      </div>

      <div class="bg-[#151715] p-6 rounded-xl shadow-lg border border-white/5">
        <h3 class="text-xl font-semibold text-white mb-4">Area Coverage per Blok</h3>
        <div style="position: relative; height: 280px;">
          <canvas id="areaCoverageChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Activity -->
    <div class="bg-[#151715] p-6 rounded-xl shadow-lg border border-white/5">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-semibold text-white">Aktivitas Terbaru</h3>
        <div>
          <button id="btn-clear-activity" class="px-3 py-1 bg-white/5 text-white rounded text-sm">Bersihkan tampilan</button>
        </div>
      </div>
      <div id="activity-list" class="space-y-3 text-white/80">Memuat...</div>
    </div>

  </div>
</div>

<!-- Leaflet & Chart -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  // elems
  const form = document.getElementById('detect-form');
  const imageInput = document.getElementById('image-input');
  const previewContainer = document.getElementById('preview-container');
  const uploadBtn = document.getElementById('upload-btn');
  const clearBtn = document.getElementById('clear-btn');
  const messageEl = document.getElementById('detect-message');
  const recentList = document.getElementById('recent-list');
  const predList = document.getElementById('pred-list');
  const predMeta = document.getElementById('pred-meta');
  const activityList = document.getElementById('activity-list');

  const cardTotal = document.getElementById('card-total-main');
  const cardDrones = document.getElementById('card-drones-main');
  const cardPriority = document.getElementById('card-priority-main');

  const btnResetAll = document.getElementById('btn-reset-all');
  const btnBackup = document.getElementById('btn-backup');
  const btnClearActivity = document.getElementById('btn-clear-activity');

  // state
  const state = { totalDetections:0, totalInfected:0, activeDrones:0, priorityCount:0 };

  function showMessage(html, type='info'){
    const bg = type === 'error' ? 'bg-red-600' : 'bg-yellow-600';
    messageEl.innerHTML = `<div class="p-3 ${bg} text-white rounded">${html}</div>`;
  }

  // preview
  imageInput.addEventListener('change', () => {
    previewContainer.innerHTML = '';
    const files = Array.from(imageInput.files || []);
    uploadBtn.disabled = files.length === 0;
    files.forEach(f => {
      const url = URL.createObjectURL(f);
      const el = document.createElement('div');
      el.className = 'w-28';
      el.innerHTML = `<div class="w-28 h-28 bg-black rounded border border-white/10 overflow-hidden"><img src="${url}" class="object-cover w-full h-full" /></div><div class="text-xs text-white/70 mt-1 truncate">${f.name}</div>`;
      previewContainer.appendChild(el);
    });
  });

  clearBtn.addEventListener('click', () => {
    imageInput.value = '';
    previewContainer.innerHTML = '';
    uploadBtn.disabled = true;
    recentList.innerHTML = '';
    predList.innerHTML = '';
    predMeta.textContent = 'Belum ada deteksi.';
    showMessage('Daftar hasil deteksi terbaru telah dihapus dari tampilan.', 'info');
  });

    // charts init (safer)
  (function() {
    // trend
    const trendEl = document.getElementById('detectionTrendChart');
    if (trendEl) {
      try {
        // simpan langsung ke global supaya bisa diakses dari seedInitial()
        window.trendChart = new Chart(trendEl.getContext('2d'), {
          type: 'line',
          data: {
            labels: [],
            datasets: [{
              label: 'Deteksi',
              data: [],
              tension: 0.4,
              borderColor: '#7c8d34',
              backgroundColor: '#7c8d3420',
              fill: true
            }]
          },
          options: {
            maintainAspectRatio: false,
            plugins: { legend: { labels: { color: '#fff' } } },
            scales: {
              x: { ticks: { color: '#fff' } },
              y: { ticks: { color: '#fff' }, beginAtZero:true }
            }
          }
        });
      } catch (e) { console.warn('trendChart init fail', e); window.trendChart = null; }
    } else {
      window.trendChart = null;
    }

    // doughnut
    const doughEl = document.getElementById('infectionLevelChart');
    if (doughEl) {
      try {
        window.dough = new Chart(doughEl.getContext('2d'), {
          type: 'doughnut',
          data: {
            labels: ['Rendah','Sedang','Tinggi'],
            datasets: [{ data:[0,0,0], backgroundColor:['#10b981','#fbbf24','#ef4444'] }]
          },
          options: { maintainAspectRatio:false, plugins:{ legend:{ labels:{ color:'#fff' } } } }
        });
      } catch(e){ console.warn('dough init fail', e); window.dough = null; }
    } else {
      window.dough = null;
    }

    // area/bar
    // area/bar (show ONLY infected)
    const areaEl = document.getElementById('areaCoverageChart');
    if (areaEl) {
      try {
        window.areaChart = new Chart(areaEl.getContext('2d'), {
          type: 'bar',
          data: {
            labels: ['Unknown'],
            datasets: [
              // only infected dataset (red)
              { label: 'Infected Trees', data: [0], backgroundColor: '#ef4444', borderRadius: 8 }
            ]
          },
          options: {
            maintainAspectRatio: false,
            plugins: {
              legend: { labels: { color: '#fff' } }
            },
            scales: {
              x: { ticks: { color: '#fff' } },
              y: { ticks: { color: '#fff' }, beginAtZero: true }
            }
          }
        });
      } catch (e) { console.warn('areaChart init fail', e); window.areaChart = null; }
    } else {
      window.areaChart = null;
    }


  })();

  // map
  let mapInstance = null;
  window._ganod_markers = [];
  if (window.L) {
    mapInstance = L.map('droneMap').setView([-6.2, 106.8], 6);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{ maxZoom:19, attribution:'Â© OpenStreetMap contributors' }).addTo(mapInstance);
  }

  // helpers
  function computeInfectedFromPreds(preds){
    if(!Array.isArray(preds)) return 0;
    return preds.reduce((acc,p) => {
      if (p.infected === 1 || p.is_infected === 1) return acc+1;
      const label = (p.label||'').toLowerCase();
      return acc + (label.includes('ganoderma') ? 1 : 0);
    }, 0);
  }

  function updateCards(){
    cardTotal.textContent = String(state.totalDetections || 0);
    cardDrones.textContent = String(state.activeDrones || '—');
    const pct = state.totalDetections ? Math.round(((state.totalDetections - (state.totalInfected||0)) / state.totalDetections) * 100) : 100;
    cardPriority.textContent = String(state.priorityCount || 0);
  }

  // append recent & activity (kept small)
  function addRecent(d){
    // limit recentList to 6 items on UI
    const wrapper = document.createElement('div');
    wrapper.className = 'p-4 bg-[#0f0f0f] rounded-lg flex gap-4 items-start';

    const img = document.createElement('img');
    img.src = d.thumbnail_url || d.image_url || '';
    img.className = 'w-20 h-20 object-cover rounded';
    img.alt = 'thumb';

    const meta = document.createElement('div');
    meta.className = 'flex-1';
    const total = ('total_detected' in d) ? Number(d.total_detected||0) : (Array.isArray(d.predictions)?d.predictions.length:0);
    const infected = (typeof d.infected_count !== 'undefined' && d.infected_count !== null) ? Number(d.infected_count) : computeInfectedFromPreds(d.predictions || []);
    const healthy = Math.max(0, total - infected);

    // update global state
    state.totalDetections += total;
    state.totalInfected = (state.totalInfected||0) + infected;

    updateCards();

    const title = document.createElement('div'); title.className='text-white font-semibold'; title.textContent = `Deteksi #${d.id} - ${total} objek`;
    const sub = document.createElement('div'); sub.className='text-white/60 text-sm mt-1'; sub.textContent = `${infected} terinfeksi • ${healthy} sehat • ${d.created_at_human}`;

    const btns = document.createElement('div'); btns.className='ml-2 flex flex-col gap-2';
    const detailBtn = document.createElement('button'); detailBtn.className='px-3 py-1 bg-[#111] text-white rounded text-sm'; detailBtn.textContent='Detail';
    detailBtn.onclick = () => renderPreds(d.predictions || []);
    const deleteBtn = document.createElement('button'); deleteBtn.className='px-3 py-1 bg-red-600 text-white rounded text-sm'; deleteBtn.textContent='Hapus';
    deleteBtn.onclick = () => removeDetection(d.id, wrapper);

    btns.appendChild(detailBtn); btns.appendChild(deleteBtn);
    meta.appendChild(title); meta.appendChild(sub);
    wrapper.appendChild(img); wrapper.appendChild(meta); wrapper.appendChild(btns);

    recentList.prepend(wrapper);
    // keep only 6 items
    while (recentList.children.length > 6) recentList.removeChild(recentList.lastChild);

    // activity list
    const node = document.createElement('div');
    // safer DOM build (replaces the innerHTML template)
    node.className = 'flex items-center gap-4 p-3 bg-white/5 rounded-lg';

    // status dot
    const dot = document.createElement('div');
    dot.className = 'w-2 h-2 rounded-full ' + (infected > 0 ? 'bg-yellow-400' : 'bg-green-400');

    // text container
    const content = document.createElement('div');
    content.className = 'flex-1';

    // title line
    const titleP = document.createElement('p');
    titleP.className = 'text-white font-medium';
    titleP.textContent = 'Deteksi #' + d.id + ' selesai - ' + total + ' objek (' + infected + ' terinfeksi)';

    // subtitle line
    const subP = document.createElement('p');
    subP.className = 'text-white/50 text-sm';
    subP.textContent = 'baru saja';

    // assemble
    content.appendChild(titleP);
    content.appendChild(subP);

    node.appendChild(dot);
    node.appendChild(content);

    activityList.prepend(node);


    // cap activity items
    while (activityList.children.length > 8) activityList.removeChild(activityList.lastChild);
  }

  function renderPreds(preds) {
    predList.innerHTML = '';
    if (!Array.isArray(preds) || preds.length === 0) {
      predMeta.textContent = 'Tidak ada objek terdeteksi.';
      return;
    }

    predMeta.textContent = `Jumlah objek: ${preds.length}`;
    preds.forEach(p => {
      const li = document.createElement('li');
      const conf = (p.confidence || 0) * 100;
      const bbox = (Array.isArray(p.bbox) ? p.bbox.map(x => Math.round(x)).join(',') : '');
      li.className = 'mb-1';
      li.innerHTML = `<strong>${(p.label || 'object')}</strong> — ${conf.toFixed(1)}% <span class="text-white/60 text-sm">bbox: ${bbox}</span>`;
      predList.appendChild(li);
    });
  }


  // polling single detection until completed
  async function pollDetection(id, imageUrl){
    showMessage('Menunggu hasil deteksi untuk #' + id + ' ...');
    return new Promise((resolve) => {
      const interval = setInterval(async () => {
        try {
          const res = await fetch(`/detection/${id}`, { credentials:'same-origin' });
          if(!res.ok) throw new Error('status ' + res.status);
          const data = await res.json();
          if (data.done || data.annotated_url || (Array.isArray(data.predictions) && data.predictions.length > 0)) {
            clearInterval(interval);
            showMessage('Deteksi #' + id + ' selesai.');
            const d = {
              id: data.id,
              thumbnail_url: data.annotated_url || data.image_url || imageUrl || null,
              image_url: data.image_url || imageUrl || null,
              predictions: Array.isArray(data.predictions) ? data.predictions : [],
              infected_count: data.infected_count ?? null,
              total_detected: data.total_detected ?? (Array.isArray(data.predictions) ? data.predictions.length : 0),
              lat: data.lat ?? null,
              lng: data.lng ?? null,
              block: data.block ?? null,
              created_at_human: data.detected_at ? (new Date(data.detected_at)).toLocaleString() : (data.created_at_human ?? 'baru saja')
            };
            addRecent(d);
            // quick chart nudges
            try {
              if (window.trendChart) {
                window.trendChart.data.labels.push('Now');
                window.trendChart.data.datasets[0].data.push(d.total_detected || 0);
                window.trendChart.update();
              }
              if (window.areaChart) {
                // add infected count to the infected dataset (single dataset at index 0)
                window.areaChart.data.datasets[0].data[0] = (window.areaChart.data.datasets[0].data[0] || 0) + (d.infected_count || 0);
                window.areaChart.update();
              }


              if (window.dough) {
                window.dough.data.datasets[0].data[1] = (window.dough.data.datasets[0].data[1] || 0) + (d.infected_count || 0);
                window.dough.update();
              }
            } catch (e) { console.warn('chart nudge error', e); }

            resolve(d);
          }
        } catch(err){
          clearInterval(interval);
          showMessage('Gagal memeriksa status: ' + err.message, 'error');
          resolve(null);
        }
      }, 1600);
    });
  }

  // upload handler (sequential)
  if (form){
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const files = Array.from(imageInput.files || []);
      if(files.length === 0){ showMessage('Pilih file dulu.', 'error'); return; }
      uploadBtn.disabled = true;
      showMessage(`Upload diterima; memproses ${files.length} file...`);
      for(let i=0;i<files.length;i++){
        const file = files[i];
        const fd = new FormData();
        fd.append('image', file);
        const statusRow = document.createElement('div');
        statusRow.className = 'p-3 bg-[#1a1a1a] rounded mt-2 text-white/80';
        statusRow.textContent = `(${i+1}/${files.length}) ${file.name} — uploading...`;
        messageEl.appendChild(statusRow);

        try {
          const resp = await fetch(form.action, {
            method:'POST',
            body: fd,
            credentials:'same-origin',
            headers: { 'X-Requested-With':'XMLHttpRequest', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
          });
          if(resp.ok){
            const text = await resp.text();
            let json = null;
            try { json = text ? JSON.parse(text) : null; } catch(e){ statusRow.textContent = `(${i+1}/${files.length}) ${file.name} — server error (non-JSON)`; continue; }
            if(json && json.error){ statusRow.textContent = `(${i+1}/${files.length}) ${file.name} — error: ${json.error}`; continue; }
            statusRow.textContent = `(${i+1}/${files.length}) ${file.name} — uploaded, processing...`;
            await pollDetection(json.detection_id, json.image_url);
            statusRow.textContent = `(${i+1}/${files.length}) ${file.name} — selesai`;
          } else {
            const txt = await resp.text();
            statusRow.textContent = `(${i+1}/${files.length}) ${file.name} — upload failed: ${txt.substring(0,300)}`;
          }
        } catch(err){
          statusRow.textContent = `(${i+1}/${files.length}) ${file.name} — jaringan/gagal: ${err.message}`;
        }
      }
      uploadBtn.disabled = false;
      imageInput.value = '';
      previewContainer.innerHTML = '';
    });
  }

  // remove detection (ask backend to delete)
  async function removeDetection(id, domNode){
    if(!confirm('Hapus deteksi #' + id + ' secara permanen?')) return;
    try {
      const res = await fetch(`/admin/detection/${id}`, {
        method:'DELETE',
        credentials:'same-origin',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
      });
      if(!res.ok) throw new Error('status ' + res.status);
      domNode.remove();
      showMessage('Deteksi #' + id + ' dihapus.', 'info');
    } catch(e){
      showMessage('Gagal menghapus: ' + e.message, 'error');
    }
  }

  // reset all detections (UI asks backend)
  if(btnResetAll){
    btnResetAll.addEventListener('click', async () => {
      if(!confirm('Yakin mau reset semua deteksi (menghapus semua hasil percobaan)? Tindakan ini tidak bisa dibatalkan tanpa backup.')) return;
      try {
        const res = await fetch('/admin/reset-detections', {
          method:'POST',
          credentials:'same-origin',
          headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });
        if(!res.ok) throw new Error('status ' + res.status);
        // clear UI state
        recentList.innerHTML = '';
        activityList.innerHTML = '';
        predList.innerHTML = '';
        predMeta.textContent = 'Belum ada deteksi.';
        state.totalDetections = 0; state.totalInfected = 0; state.activeDrones = 0; state.priorityCount = 0;
        updateCards();
        if (window.trendChart) {
          window.trendChart.data.labels = [];
          window.trendChart.data.datasets[0].data = [];
          window.trendChart.update();
        }
        if (window.areaChart) {
          window.areaChart.data.labels = ['Unknown'];
          window.areaChart.data.datasets[0].data = [0];
          window.areaChart.update();
        }

        if (window.dough) {
          window.dough.data.datasets[0].data = [0,0,0];
          window.dough.update();
        }

        showMessage('Semua deteksi direset (UI & backend).', 'info');
      } catch(e){
        showMessage('Reset gagal: ' + e.message, 'error');
      }
    });
  }

  // backup: tries to open server route to request DB dump (server must implement)
  if(btnBackup){
    btnBackup.addEventListener('click', async () => {
      showMessage('Mempersiapkan backup... (server harus menyediakan route /admin/backup-db)', 'info');
      try {
        const res = await fetch('/admin/backup-db', { method:'POST', credentials:'same-origin', headers:{ 'X-CSRF-TOKEN':'{{ csrf_token() }}' }});
        if(!res.ok) throw new Error('backup gagal status ' + res.status);
        const blob = await res.blob();
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'db_ganodetect_backup.sql';
        document.body.appendChild(a);
        a.click();
        a.remove();
        URL.revokeObjectURL(url);
        showMessage('Backup berhasil diunduh.', 'info');
      } catch(e){
        showMessage('Backup gagal: ' + e.message, 'error');
      }
    });
  }

  if(btnClearActivity){
    btnClearActivity.addEventListener('click', () => {
      activityList.innerHTML = '';
      showMessage('Bagian aktivitas dibersihkan (tampilan).');
    });
  }

  // initial load: recent and stats/charts
  async function safeFetchJson(url){
    const r = await fetch(url, { credentials:'same-origin', cache:'no-store' });
    if(!r.ok) throw new Error('fetch failed ' + r.status);
    return r.json();
  }

  async function seedInitial(){
    try {
      // recent detections
      const recent = await safeFetchJson('/api/recent-detections');
      if(Array.isArray(recent) && recent.length){
        // compute state from server data
        state.totalDetections = 0; state.totalInfected = 0;
        recent.forEach(item => {
          const total = item.total_detected ?? (item.predictions ? item.predictions.length : 0);
          const infected = (typeof item.infected_count !== 'undefined' && item.infected_count !== null) ? item.infected_count : computeInfectedFromPreds(item.predictions || []);
          state.totalDetections += (total||0);
          state.totalInfected += (infected||0);
          addRecent({
            id: item.id,
            thumbnail_url: item.thumbnail_url ?? null,
            image_url: item.image_url ?? null,
            predictions: item.predictions ?? [],
            infected_count: item.infected_count ?? null,
            total_detected: item.total_detected ?? total,
            lat: item.lat ?? null,
            lng: item.lng ?? null,
            created_at_human: item.time ?? item.created_at_human ?? ''
          });
        });
        updateCards();
      } else {
        // no recent: reset cards
        updateCards();
      }

      // stats
      try {
        const stats = await safeFetchJson('/api/dashboard-stats');
        state.activeDrones = stats.drones ?? state.activeDrones;
        state.priorityCount = stats.priority ?? state.priorityCount;
        if(typeof stats.infected_total !== 'undefined') state.totalInfected = stats.infected_total;
        updateCards();
      } catch(e){ console.warn('stats fail', e); }

      // charts
      try {
        const t = await safeFetchJson('/api/trend?days=7');
        if (window.trendChart && t.labels && t.values) {
          window.trendChart.data.labels = t.labels;
          window.trendChart.data.datasets[0].data = t.values;
          window.trendChart.update();
        }

      } catch(e){ console.warn('trend fail', e); }
      try {
        const d = await safeFetchJson('/api/distribution');
        if(dough && d.labels && d.values){ dough.data.labels = d.labels; dough.data.datasets[0].data = d.values; dough.update(); }
      } catch(e){}
      try {
        const ac = await safeFetchJson('/api/area-coverage');
        if (window.areaChart) {
          const labels = Array.isArray(ac.labels) && ac.labels.length ? ac.labels : ['Unknown'];
          const inf = Array.isArray(ac.infected) ? ac.infected : labels.map(()=>0);
          window.areaChart.data.labels = labels;
          // infected is now single dataset at index 0
          window.areaChart.data.datasets[0].data = inf;
          window.areaChart.update();
        }

      } catch(e){}
      try {
        const locs = await safeFetchJson('/api/drone-locations');
        if(Array.isArray(locs) && locs.length && mapInstance) {
          window._ganod_markers.forEach(m => m.remove());
          window._ganod_markers = [];
          locs.forEach(r => { if(r.lat && r.lng){ const m = L.marker([r.lat, r.lng]).addTo(mapInstance).bindPopup(`${r.block ?? ''} — ${new Date(r.time).toLocaleString()}`); window._ganod_markers.push(m); } });
        }
      } catch(e){ console.warn('drone loc fail', e); }

    } catch(e){
      console.warn('initial seed err', e);
      updateCards();
    }
  }

  seedInitial();

  // dropdowns (UI)
  document.querySelectorAll('[data-dropdown-toggle]').forEach(btn => {
    btn.addEventListener('click', (ev) => {
      ev.stopPropagation();
      const id = btn.getAttribute('data-dropdown-toggle');
      const el = document.getElementById(id);
      if(el) el.classList.toggle('hidden');
    });
  });
  document.addEventListener('click', ()=> document.querySelectorAll('[data-dropdown-menu]').forEach(m=>m.classList.add('hidden')));
});
</script>
@endsection

