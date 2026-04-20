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

        <div>
            <h2 class="text-3xl font-bold text-white">Tambah Kegiatan</h2>
            <p class="text-slate-400">Buat kegiatan baru untuk organisasi.</p>
        </div>

        <div class="rounded-2xl border border-slate-700/60 bg-[#0b1220]/90 shadow-lg p-6">

            <form action="{{ route('activities.store') }}" method="POST" class="space-y-5">

                @csrf

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Organisasi</label>

                    <select name="organization_id"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">

                        @foreach($organizations as $org)
                            <option value="{{ $org->id }}">
                                {{ $org->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Judul Kegiatan</label>

                    <input type="text" name="title"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Tanggal</label>

                    <input type="datetime-local" name="activity_date"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">

                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Lokasi (Nama Tempat)</label>

                    <input type="text" name="location" placeholder="Contoh: Aula Desa"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    <div>
                        <label class="block mb-2 text-sm text-slate-400">Latitude</label>
                        <input type="text" name="latitude" id="latitude" placeholder="-6.123456"
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm text-slate-400">Longitude</label>
                        <input type="text" name="longitude" id="longitude" placeholder="106.123456"
                            class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2 text-white focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500/30">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm text-slate-400 font-bold text-cyan-400 uppercase tracking-tighter">Radius Absensi (Meter)</label>
                        <input type="number" name="radius_meter" id="radius_meter" value="50" min="1" max="1000"
                            class="w-full rounded-xl border border-cyan-500/30 bg-[#111827] px-4 py-2 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 font-bold">
                    </div>
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Pilih Lokasi di Map</label>
                    <div id="map" class="w-full rounded-xl border border-slate-700 z-0" style="height: 350px;"></div>
                    <p class="text-[10px] text-slate-500 mt-2 italic">* Lingkaran biru menunjukkan area jangkauan absensi.</p>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" onclick="getLocation()" class="flex items-center gap-2 px-4 py-2 bg-emerald-600/20 border border-emerald-600/30 text-emerald-400 rounded-xl hover:bg-emerald-600/30 transition-all text-xs font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        Ambil Lokasi Saat Ini (GPS)
                    </button>
                    <span id="geo-status" class="text-xs text-slate-500 italic"></span>
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Deskripsi</label>

                    <textarea name="description" rows="4"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30"></textarea>
                </div>

                <div>
                    <label class="block mb-2 text-sm text-slate-400">Status</label>

                    <select name="status"
                        class="w-full rounded-xl border border-slate-700 bg-[#111827] px-4 py-2 text-white focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30">

                        <option value="draft">Draft</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>

                    </select>

                </div>

                <div class="flex gap-3 pt-2">

                    <button
                        class="rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-2 text-sm font-medium text-white shadow-[0_0_25px_rgba(59,130,246,0.35)] hover:scale-[1.02] transition">
                        Simpan
                    </button>

                    <a href="{{ route('activities.index') }}"
                        class="rounded-xl bg-slate-700 px-5 py-2 text-sm text-white hover:bg-slate-600 transition">
                        Batal
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
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    const radiusInput = document.getElementById('radius_meter');
    const locNameInput = document.querySelector('input[name="location"]');

    function initMap() {
        // Default Center: Indonesia
        const defaultLat = -2.5489;
        const defaultLng = 118.0149;
        const initialZoom = 5;

        map = L.map('map').setView([defaultLat, defaultLng], initialZoom);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

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

        // Initialize marker if inputs already have values (e.g. old data)
        if (latInput.value && lngInput.value) {
            updateLocation(latInput.value, lngInput.value, true);
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

    // Initialize Map
    document.addEventListener('DOMContentLoaded', () => {
        initMap();
        // Immediate invalidate to ensure proper rendering
        map.invalidateSize();
    });
</script>
@endpush