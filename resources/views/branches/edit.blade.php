@php
    $title = $title ?? 'Edit Cabang';
    $action = $action ?? route('branches.update', $branch);
    $method = $method ?? 'PUT';
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <title>{{ $title }}</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f3f6fa;
            margin: 0;
            padding: 30px 16px;
            color: #1e293b;
        }

        .card {
            max-width: 650px;
            margin: 0 auto;
            background: white;
            padding: 28px;
            border-radius: 12px;
            box-shadow: 0 3px 12px #0000000a;
        }

        h2 {
            margin-top: 0;
        }

        .field {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font: inherit;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: 2px solid #bfdbfe;
            border-color: #2563eb;
        }

        small {
            display: block;
            color: #dc2626;
            margin-top: 5px;
        }

        .coordinates {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn {
            padding: 11px 18px;
            border: 0;
            border-radius: 7px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .back {
            background: #e2e8f0;
            color: #334155;
        }

        .save {
            background: #2563eb;
            color: white;
        }

        @media(max-width: 500px) {
            .coordinates {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="card">
        <h2>{{ $title }}</h2>
        <p>Lengkapi informasi lokasi cabang.</p>

        @include('branches.form', [
            'action' => $action,
            'method' => $method,
            'branch' => $branch,
        ])
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const latitudeInput = document.getElementById('latitude');
            const longitudeInput = document.getElementById('longitude');

            // Koordinat default Jakarta
            const defaultLat = -6.200000;
            const defaultLng = 106.816666;

            // Ambil koordinat dari form (termasuk ketika edit)
            const savedLat = latitudeInput.value.trim();
            const savedLng = longitudeInput.value.trim();

            const hasLocation =
                savedLat !== '' &&
                savedLng !== '' &&
                Number.isFinite(Number(savedLat)) &&
                Number.isFinite(Number(savedLng)) &&
                Number(savedLat) >= -90 &&
                Number(savedLat) <= 90 &&
                Number(savedLng) >= -180 &&
                Number(savedLng) <= 180;

            const initialLat = hasLocation ?
                Number(savedLat) : defaultLat;

            const initialLng = hasLocation ?
                Number(savedLng) : defaultLng;

            // Inisialisasi peta
            const map = L.map('map-picker').setView(
                [initialLat, initialLng],
                hasLocation ? 16 : 12
            );

            // OpenStreetMap
            L.tileLayer(
                'https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors'
                }
            ).addTo(map);

            let marker = null;

            function setLocation(lat, lng) {

                // Otomatis isi input
                latitudeInput.value = lat.toFixed(7);
                longitudeInput.value = lng.toFixed(7);

                // Buat atau pindahkan marker
                if (marker) {
                    marker.setLatLng([lat, lng]);
                } else {
                    marker = L.marker([lat, lng], {
                        draggable: true
                    }).addTo(map);

                    // Marker juga bisa digeser
                    marker.on('dragend', function(event) {
                        const position = event.target.getLatLng();

                        setLocation(position.lat, position.lng);
                    });
                }

                marker.bindPopup('Lokasi Cabang').openPopup();
            }

            // Jika edit, tampilkan marker lokasi lama
            if (hasLocation) {
                setLocation(initialLat, initialLng);
            }

            // Ketika peta diklik
            map.on('click', function(event) {
                const lat = event.latlng.lat;
                const lng = event.latlng.lng;

                setLocation(lat, lng);
            });

            // Memastikan ukuran peta benar
            setTimeout(() => {
                map.invalidateSize();
            }, 100);

        });
    </script>

</body>

</html>
