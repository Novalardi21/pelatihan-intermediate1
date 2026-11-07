<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Peta Cabang Toko Suku Cadang</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <style>
        body {
            margin: 0;
            font-family: sans-serif;
        }

        .layout {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 280px;
            padding: 16px;
            overflow-y: auto;
            background: #f8fafc;
        }

        #map {
            flex: 1;
            min-width: 0;
        }

        .cabang {
            padding: 12px;
            margin-bottom: 8px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
        }

        .cabang:hover {
            background: #e0f2fe;
        }

        button {
            padding: 10px;
            margin-bottom: 10px;
            cursor: pointer;
        }

        .pin {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 0 3px #333;
        }

        @media (max-width: 600px) {
            .sidebar {
                width: 150px;
                padding: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="layout">
        <aside class="sidebar">
            <h3>Daftar Cabang</h3>
            <button id="btn-near">Cabang Terdekat</button>
            <div id="daftar-cabang"></div>
            <p>🔵 Toko | 🔴 Bengkel</p>
        </aside>

        <div id="map"></div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const branches = @json($branches);

        console.table(branches);
        const map = L.map('map').setView([-6.2, 106.82], 12);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        const markers = [];
        const validBranches = [];
        const daftar = document.getElementById('daftar-cabang');

        // 1. Marker berbeda berdasarkan jenis lokasi

        branches.forEach(b => {

            // Ambil jenis langsung dari database
            const jenis = String(b.jenis ?? 'toko')
                .trim()
                .toLowerCase();

            // Tentukan warna berdasarkan jenis
            const warna = jenis === 'bengkel' ? 'red' : 'blue';

            const icon = L.divIcon({
                className: '',
                html: `
            <div style="
                background-color: ${warna};
                width: 16px;
                height: 16px;
                border-radius: 50%;
                border: 2px solid white;
                box-shadow: 0 0 3px #333;
            "></div>
        `,
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            });

            // Tambahkan marker
            const marker = L.marker(
                [Number(b.latitude), Number(b.longitude)], {
                    icon
                }
            ).addTo(map);

            // Popup
            const popup = document.createElement('div');
            const nama = document.createElement('strong');
            nama.textContent = b.nama;
            const jenisText = document.createElement('p');
            jenisText.textContent = jenis === 'bengkel' ?
                'Jenis: Bengkel' :
                'Jenis: Toko';
            popup.append(nama, jenisText);
            marker.bindPopup(popup);

            markers.push(marker);

            // Daftar cabang pada sidebar
            const item = document.createElement('div');
            item.className = 'cabang';

            const judul = document.createElement('strong');
            judul.textContent = b.nama;

            const keterangan = document.createElement('p');
            keterangan.textContent =
                (jenis === 'bengkel' ? '🔴 ' : '🔵 ') +
                (jenis === 'bengkel' ? 'Bengkel' : 'Toko');

            item.append(judul, keterangan);

            item.addEventListener('click', () => {
                map.setView(
                    [Number(b.latitude), Number(b.longitude)],
                    16
                );

                marker.openPopup();
            });

            document.getElementById('daftar-cabang')
                .appendChild(item);
        });


        if (markers.length) {
            map.fitBounds(
                L.featureGroup(markers).getBounds().pad(0.2)
            );
        }

        // 2. Area layanan dengan polygon
        L.polygon([
            [-6.20, 106.80],
            [-6.20, 106.85],
            [-6.15, 106.85],
            [-6.15, 106.80]
        ], {
            color: 'green',
            fillOpacity: 0.2
        }).addTo(map).bindPopup('Area layanan');

        // 4. Menampilkan polygon dari GeoJSON
        const geojson = {
            type: 'Feature',
            properties: {
                nama: 'Wilayah Layanan GeoJSON'
            },
            geometry: {
                type: 'Polygon',
                coordinates: [
                    [
                        [106.78, -6.25],
                        [106.83, -6.25],
                        [106.83, -6.21],
                        [106.78, -6.21],
                        [106.78, -6.25]
                    ]
                ]
            }
        };

        L.geoJSON(geojson, {
            style: {
                color: 'purple',
                fillOpacity: 0.2
            },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(feature.properties.nama);
            }
        }).addTo(map);

        // Fitur cabang terdekat
        function jarakKm(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const rad = d => d * Math.PI / 180;
            const dLat = rad(lat2 - lat1);
            const dLon = rad(lon2 - lon1);
            const a = Math.sin(dLat / 2) ** 2 +
                Math.cos(rad(lat1)) * Math.cos(rad(lat2)) *
                Math.sin(dLon / 2) ** 2;
            return 2 * R * Math.asin(Math.sqrt(a));
        }

        document.getElementById('btn-near')
            .addEventListener('click', () => {
                if (!validBranches.length) {
                    alert('Belum ada cabang dengan koordinat valid.');
                    return;
                }

                if (!navigator.geolocation) {
                    alert('Browser tidak mendukung geolocation.');
                    return;
                }

                navigator.geolocation.getCurrentPosition(pos => {
                    const {
                        latitude,
                        longitude
                    } = pos.coords;
                    let best = null;

                    validBranches.forEach((b, i) => {
                        const d = jarakKm(
                            latitude, longitude,
                            b.latitude, b.longitude
                        );
                        if (!best || d < best.d) best = {
                            d,
                            i
                        };
                    });

                    L.circleMarker([latitude, longitude], {
                        radius: 8,
                        color: 'green'
                    }).addTo(map).bindPopup('Lokasi Anda');

                    const b = validBranches[best.i];
                    markers[best.i].openPopup();

                    map.fitBounds(L.latLngBounds([
                        [latitude, longitude],
                        [b.latitude, b.longitude]
                    ]).pad(0.3));

                    alert('Cabang terdekat: ' + b.nama +
                        '\nJarak garis lurus: ' +
                        best.d.toFixed(2) + ' km');
                }, () => {
                    alert('Lokasi tidak dapat diakses.');
                });
            });
    </script>
</body>

</html>
