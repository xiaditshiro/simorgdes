@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    .leaflet-container {
        background: #111827;
    }
    /* Fix for Leaflet tiles misalignment */
    .leaflet-container img {
        max-width: none !important;
        height: auto !important;
    }
</style>
@endpush

@section('content')

    <div class="max-w-3xl mx-auto space-y-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold text-white">Edit Kegiatan</h2>
                <p class="text-slate-400 mt-1">Perbarui data kegiatan organisasi.</p>
            </div>

            <a href="{{ route('activities.index') }}"
                class="inline-flex items-center justify-center rounded-xl bg-slate-700 hover:bg-slate-600 px-5 py-3 text-sm font-medium text-white transition">
                ← Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="rounded-2xl border border-rose-500/30 bg-rose-500/10 px-4 py-4 text-rose-400 shadow-lg">
                <p class="font-semibold mb-2">Terjadi kesalahan:</p>
                <ul class="list-disc ml-5 space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 shadow-lg p-6">

            <form action="{{ route('activities.update', $activity->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Organisasi</label>
                    <select name="organization_id"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                        @foreach($organizations as $org)
                            <option value="{{ $org->id }}" {{ old('organization_id', $activity->organization_id) == $org->id ? 'selected' : '' }}>
                                {{ $org->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Judul</label>
                    <input type="text" name="title" value="{{ old('title', $activity->title) }}"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Tanggal</label>
                    <input type="datetime-local" name="activity_date"
                        value="{{ old('activity_date', $activity->activity_date?->format('Y-m-d\TH:i')) }}"

                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Lokasi (Nama Tempat)</label>
                    <input type="text" name="location" value="{{ old('location', $activity->location) }}"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    <div>
                        <label class="block mb-2 text-sm text-slate-400">Latitude</label>
                        <input type="text" name="latitude" id="latitude" value="{{ old('latitude', $activity->latitude) }}"
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm text-slate-400">Longitude</label>
                        <input type="text" name="longitude" id="longitude" value="{{ old('longitude', $activity->longitude) }}"
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm text-cyan-400 font-bold uppercase tracking-tighter">Radius Absensi (Meter)</label>
                        <input type="number" name="radius_meter" id="radius_meter" value="{{ old('radius_meter', $activity->radius_meter ?? 50) }}" min="1" max="1000"
                            class="w-full rounded-xl border border-cyan-500/30 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 font-bold">
                    </div>
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Pilih Lokasi di Map</label>
                    
                    <div class="relative w-full rounded-xl overflow-hidden border border-slate-700 shadow-inner" style="height: 400px;">
                        {{-- Map Container --}}
                        <div id="map" class="absolute inset-0 z-0" style="height: 100%; width: 100%;"></div>

                        {{-- Floating Top Controls: Search --}}
                        <div class="absolute top-4 left-4 right-14 max-w-sm sm:max-w-md" style="z-index: 1000;">
                            <div class="flex gap-2 p-1.5 rounded-2xl shadow-xl" style="background-color: rgba(255, 255, 255, 0.95); backdrop-filter: blur(12px); border: none;">
                                <input type="text" id="map-search" autocomplete="off" placeholder="Cari tempat atau alamat..." 
                                    class="flex-1 w-full bg-transparent px-3 py-1.5 text-sm" 
                                    style="min-width: 0; color: #0f172a !important; border: none !important; outline: none !important; box-shadow: none !important;">
                                <button type="button" onclick="searchLocation()" id="btn-search-map"
                                    class="px-4 py-1.5 rounded-xl transition-all text-sm font-medium shadow-md" 
                                    style="background-color: #2563eb; color: white; border: none;">
                                    Cari
                                </button>
                            </div>
                            {{-- Suggestions Dropdown --}}
                            <div id="search-suggestions" class="absolute left-0 right-0 mt-2 hidden max-h-60 overflow-y-auto rounded-xl border border-slate-700 bg-[#0d1320]/95 backdrop-blur-lg shadow-2xl custom-scrollbar py-2" style="z-index: 2000;">
                            </div>
                        </div>

                        {{-- Floating Bottom Right Controls --}}
                        <div class="absolute bottom-6 right-4 flex flex-col gap-3" style="z-index: 1000;">
                            {{-- My Location Button --}}
                            <button type="button" onclick="getLocation()" title="Ambil Lokasi Saat Ini (GPS)"
                                class="flex items-center justify-center w-12 h-12 bg-[#0b1220]/80 backdrop-blur-md border border-emerald-500/30 text-emerald-400 rounded-full hover:bg-emerald-500 hover:text-white hover:border-emerald-500 shadow-[0_0_15px_rgba(16,185,129,0.3)] transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                            
                            {{-- Map Layer Toggle Button --}}
                            <button type="button" onclick="toggleMapLayer()" id="btn-layer-toggle" title="Ubah Tampilan Satelit"
                                class="flex items-center justify-center w-12 h-12 bg-[#0b1220]/80 backdrop-blur-md border border-cyan-500/30 text-cyan-400 rounded-full hover:bg-cyan-500 hover:text-white hover:border-cyan-500 shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-2">
                        <p class="text-[10px] text-slate-500 italic">* Lingkaran biru menunjukkan area jangkauan absensi.</p>
                        <span id="geo-status" class="text-xs text-slate-500 italic"></span>
                    </div>
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Deskripsi</label>
                    <textarea name="description" rows="4"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">{{ old('description', $activity->description) }}</textarea>
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Status</label>
                    <select name="status"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-3 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                        <option value="draft" {{ old('status', $activity->status) == 'draft' ? 'selected' : '' }}>Draft
                        </option>
                        <option value="scheduled" {{ old('status', $activity->status) == 'scheduled' ? 'selected' : '' }}>
                            Scheduled</option>
                        <option value="completed" {{ old('status', $activity->status) == 'completed' ? 'selected' : '' }}>
                            Completed</option>
                        <option value="cancelled" {{ old('status', $activity->status) == 'cancelled' ? 'selected' : '' }}>
                            Cancelled</option>
                    </select>
                </div>

                <div class="flex flex-wrap gap-3 pt-2">
                    <button
                        class="rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-3 text-sm font-medium text-white shadow-[0_0_25px_rgba(59,130,246,0.35)] hover:scale-[1.02] transition">
                        Update
                    </button>

                    <a href="{{ route('activities.index') }}"
                        class="rounded-xl bg-slate-700 px-5 py-3 text-sm text-white hover:bg-slate-600 transition">
                        Kembali
                    </a>
                </div>
            </form>

        </div>

    </div>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    let map, marker, radiusCircle;
    let darkLayer, satelliteLayer;
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    const radiusInput = document.getElementById('radius_meter');
    const locNameInput = document.querySelector('input[name="location"]');

    function initMap() {
        // Default Center: Indonesia
        let defaultLat = -2.5489;
        let defaultLng = 118.0149;
        let initialZoom = 5;

        // If data already exists
        if (latInput && latInput.value && lngInput.value) {
            defaultLat = parseFloat(latInput.value);
            defaultLng = parseFloat(lngInput.value);
            initialZoom = 15;
        }

        map = L.map('map', {
            zoomControl: false // move zoom control
        }).setView([defaultLat, defaultLng], initialZoom);

        L.control.zoom({ position: 'bottomleft' }).addTo(map);

        darkLayer = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap &copy; CARTO',
            subdomains: 'abcd',
            maxZoom: 20
        });

        satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri',
            maxZoom: 19
        });

        darkLayer.addTo(map);

        // Click event to place marker
        map.on('click', function(e) {
            updateLocation(e.latlng.lat, e.latlng.lng);
        });

        // Event listener for radius change
        radiusInput.addEventListener('input', function() {
            if (marker) {
                updateRadiusCircle(marker.getLatLng().lat, marker.getLatLng().lng);
            }
        });

        // Initialize marker if inputs already have values
        if (latInput.value && lngInput.value) {
            updateLocation(latInput.value, lngInput.value, false);
        }
    }

    function updateRadiusCircle(lat, lng) {
        const radius = parseInt(radiusInput.value) || 50;
        
        if (radiusCircle) {
            radiusCircle.setLatLng([lat, lng]);
            radiusCircle.setRadius(radius);
        } else {
            radiusCircle = L.circle([lat, lng], {
                color: '#06b6d4',
                fillColor: '#06b6d4',
                fillOpacity: 0.2,
                radius: radius,
                weight: 1
            }).addTo(map);
        }
    }

    let lastGeocode = "";
    function updateLocation(lat, lng, moveMap = false) {
        const fixedLat = parseFloat(lat).toFixed(6);
        const fixedLng = parseFloat(lng).toFixed(6);
        const geoKey = `${fixedLat},${fixedLng}`;

        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            marker.on('dragend', function(e) {
                const pos = marker.getLatLng();
                updateLocation(pos.lat, pos.lng);
            });
        }

        updateRadiusCircle(lat, lng);

        latInput.value = fixedLat;
        lngInput.value = fixedLng;

        if (moveMap) {
            map.setView([lat, lng], 15);
        }

        // Try to reverse geocode (get address name) - optimized
        if (lastGeocode !== geoKey) {
            lastGeocode = geoKey;
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(res => res.json())
                .then(data => {
                    if (data.display_name && !locNameInput.value) {
                        locNameInput.value = data.display_name.split(',')[0] + ', ' + (data.address.city || data.address.town || '');
                    }
                })
                .catch(e => console.log('Geocoding error', e));
        }
    }

    function toggleMapLayer() {
        if (map.hasLayer(darkLayer)) {
            map.removeLayer(darkLayer);
            satelliteLayer.addTo(map);
        } else {
            map.removeLayer(satelliteLayer);
            darkLayer.addTo(map);
        }
    }

    function getLocation() {
        const btn = event.currentTarget;
        const status = document.getElementById('geo-status');

        if (!navigator.geolocation) {
            status.textContent = 'Geolocation tidak didukung browser.';
            return;
        }

        status.textContent = 'Sedang mencari lokasi...';
        btn.disabled = true;

        navigator.geolocation.getCurrentPosition(
            (position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                updateLocation(lat, lng, true);
                status.textContent = 'Lokasi berhasil disinkronkan!';
                btn.disabled = false;
            },
            (error) => {
                status.textContent = 'Gagal mengambil lokasi: ' + error.message;
                btn.disabled = false;
            },
            { enableHighAccuracy: true }
        );
    }

    // --- Smart Autocomplete Logic ---
    let searchTimeout;
    const searchInput = document.getElementById('map-search');
    const suggestionsBox = document.getElementById('search-suggestions');

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value;

        if (query.length < 3) {
            suggestionsBox.classList.add('hidden');
            return;
        }

        searchTimeout = setTimeout(() => {
            fetchSuggestions(query);
        }, 500); // 500ms debounce
    });

    function fetchSuggestions(query) {
        // Bias results to current map view if possible
        const viewbox = map.getBounds();
        const viewboxParam = `${viewbox.getWest()},${viewbox.getNorth()},${viewbox.getEast()},${viewbox.getSouth()}`;
        
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=5&bounded=1&viewbox=${viewboxParam}`)
            .then(res => res.json())
            .then(data => {
                if (data.length > 0) {
                    renderSuggestions(data);
                } else {
                    // Try again without bounding if no results
                    return fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=5`);
                }
            })
            .then(res => res ? res.json() : null)
            .then(data => {
                if (data) renderSuggestions(data);
            })
            .catch(err => console.error('Suggestion error:', err));
    }

    function renderSuggestions(data) {
        suggestionsBox.innerHTML = '';
        data.forEach(item => {
            const div = document.createElement('div');
            div.className = 'px-4 py-3 hover:bg-cyan-500/10 cursor-pointer border-b border-slate-800/50 last:border-0 transition';
            const name = item.display_name.split(',')[0];
            const address = item.display_name.split(',').slice(1).join(',').trim();
            
            div.innerHTML = `
                <div class="text-sm font-semibold text-white">${name}</div>
                <div class="text-[11px] text-slate-400 truncate">${address}</div>
            `;
            
            div.onclick = () => {
                searchInput.value = name;
                updateLocation(item.lat, item.lon, true);
                if (!locNameInput.value) locNameInput.value = name;
                suggestionsBox.classList.add('hidden');
            };
            
            suggestionsBox.appendChild(div);
        });
        suggestionsBox.classList.remove('hidden');
    }

    // Hide suggestions on outside click
    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
            suggestionsBox.classList.add('hidden');
        }
    });

    function searchLocation() {
        const query = searchInput.value;
        const btn = document.getElementById('btn-search-map');
        
        if (!query) return;
        suggestionsBox.classList.add('hidden');

        const originalText = btn.innerHTML;
        btn.innerHTML = '<span class="inline-block animate-spin mr-1">⌛</span>';
        btn.disabled = true;

        // Use referrer-policy or email to comply with Nominatim policy
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1`)
            .then(res => {
                if (!res.ok) {
                    if (res.status === 429) throw new Error('Terlalu banyak permintaan (Throttled). Tunggu sebentar.');
                    throw new Error('Gagal menghubungi server peta.');
                }
                return res.json();
            })
            .then(data => {
                if (data.length > 0) {
                    const result = data[0];
                    // Nominatim uses 'lon', updateLocation uses 'lng'
                    updateLocation(result.lat, result.lon, true);
                    
                    if (!locNameInput.value) {
                        locNameInput.value = result.display_name.split(',')[0];
                    }
                } else {
                    alert('Lokasi tidak ditemukan. Coba gunakan nama yang lebih spesifik.');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Kesalahan: ' + err.message);
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
    }

    // Allow search on Enter
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            searchLocation();
        }
    });

    // Initialize Map
    document.addEventListener('DOMContentLoaded', () => {
        initMap();
        // Immediate invalidate to ensure proper rendering
        map.invalidateSize();
    });
</script>
@endpush