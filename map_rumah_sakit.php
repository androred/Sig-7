<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoEarth - Peta Klinik</title>
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
        #map { 
            height: 600px; 
            width: 100%; 
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <div class="flex flex-1">
        <!-- Sidebar -->
        <div class="w-1/6 bg-blue-800 text-white h-screen flex flex-col fixed">
            <div class="flex items-center space-x-4 p-4 justify-center">
                <img src="asset/worldwide_477702.png" alt="Logo" class="w-10 h-10">
                <h1 class="text-2xl font-bold">GeoEarth</h1>
            </div>
            <nav class="text-gray-300 text-base font-semibold px-4 py-2">
                <a href="beranda.php" class="flex items-center py-2.5 px-4 rounded hover:bg-gray-700"><i class="fa-solid fa-house mr-3"></i><span class="overflow-hidden text-ellipsis whitespace-nowrap">Beranda</span></a>
                <a href="map.php" class="flex items-center py-2.5 px-4 rounded hover:bg-gray-700 text-[#FFFF00]"><i class="fa-solid fa-map mr-3"></i><span class="overflow-hidden text-ellipsis whitespace-nowrap">Map</span></a>
                <a href="kontak_kami.html" class="flex items-center py-2.5 px-4 rounded hover:bg-gray-700"><i class="fa-solid fa-people-group mr-3"></i><span class="overflow-hidden text-ellipsis whitespace-nowrap">Kontak Kami</span></a>
            </nav>
            <div class="absolute bottom-0 text-gray-300 text-sm font-semibold px-4 py-2">
                <a href="login.php" class="flex items-center py-2.5 px-4 rounded hover:bg-gray-700"><i class="fa-solid fa-arrow-right-from-bracket mr-3"></i><span class="overflow-hidden text-ellipsis whitespace-nowrap">Logout</span></a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="w-5/6 ml-auto p-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h1 class="text-3xl font-bold text-blue-600 mb-6 flex items-center">
                    <i class="fa-solid fa-hospital text-blue-600 text-3xl mr-3"></i>
                    Peta Sebaran Rumah Sakit di Provinsi Lampung
                </h1>
                
                <!-- Filter dan Informasi -->
                <div class="mb-6 flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <select id="kecamatan-filter" class="border rounded p-2">
                            <option value="">Semua Kabupaten</option>
                            <!-- Opsi kecamatan akan diisi dinamis -->
                        </select>
                        <button id="filter-btn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                            Filter
                        </button>
                    </div>
                    <div id="total-klinik" class="text-blue-700 font-semibold">
                        Total Rumah Sakit: <span id="klinik-count">0</span>
                    </div>
                </div>

                <!-- Peta -->
                <div id="map" class="rounded-lg shadow-md"></div>
                
                <!-- Tabel Klinik -->
                <div class="mt-6">
                    <h2 class="text-2xl font-semibold mb-4 text-blue-600">Daftar Rumah Sakit</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full bg-white border" id="klinik-table">
                            <thead class="bg-blue-100">
                                <tr>
                                    <th class="p-3 text-left">No</th>
                                    <th class="p-3 text-left">Nama Rumah Sakit</th>
                                    <th class="p-3 text-left">Kabupaten</th>
                                    <th class="p-3 text-left">Jenis</th>
                                    <th class="p-3 text-left">Kelas</th>
                                    <th class="p-3 text-left">Pemilik</th>
                                    <th class="p-3 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="klinik-body">
                                <!-- Data klinik akan diisi secara dinamis -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    
    <script>
        // Inisialisasi variabel peta
        var map;

        // Fungsi untuk mengambil dan menampilkan batas provinsi
        async function fetchBatasProvinsi() {
            try {
                const response = await fetch('api_batas_provinsi.php');
                const result = await response.json();
                
                if (result.status === 'success') {
                    result.data.forEach(provinsi => {
                        // Parse GeoJSON
                        const geojsonData = JSON.parse(provinsi.geojson);
                        
                        // Tambahkan layer GeoJSON ke peta
                        L.geoJSON(geojsonData, {
                            style: function (feature) {
                                return {
                                    color: 'blue',      // Warna garis batas
                                    weight: 2,          // Ketebalan garis
                                    fillColor: 'none',  // Transparan
                                    dashArray: '5, 5'   // Garis putus-putus
                                };
                            }
                        }).addTo(map);
                    });
                } else {
                    console.error('Error:', result.message);
                }
            } catch (error) {
                console.error('Error fetching batas provinsi:', error);
            }
        }

        async function fetchJalanLingkungan() {
            try {
                const response = await fetch('api_jalan_lingkungan.php');
                const result = await response.json();
                
                if (result.status === 'success') {
                    result.data.forEach(lingkungan => {
                        // Parse GeoJSON
                        const geojsonData = JSON.parse(lingkungan.geojson);
                        
                        // Tambahkan layer GeoJSON ke peta
                        L.geoJSON(geojsonData, {
                            style: function (feature) {
                                return {
                                    color: 'yellow',      // Warna garis batas
                                    weight: 2,          // Ketebalan garis
                                    fillColor: 'none',  // Transparan
                                    // dashArray: '5, 5'   // Garis putus-putus
                                };
                            }
                        }).addTo(map);
                    });
                } else {
                    console.error('Error:', result.message);
                }
            } catch (error) {
                console.error('Error fetching batas provinsi:', error);
            }
        }
        async function fetchJalanLintasSumatera() {
            try {
                const response = await fetch('api_jalan_lintas_sumatera.php');
                const result = await response.json();
                
                if (result.status === 'success') {
                    result.data.forEach(lingkungan => {
                        // Parse GeoJSON
                        const geojsonData = JSON.parse(lingkungan.geojson);
                        
                        // Tambahkan layer GeoJSON ke peta
                        L.geoJSON(geojsonData, {
                            style: function (feature) {
                                return {
                                    color: 'red',      // Warna garis batas
                                    weight: 2,          // Ketebalan garis
                                    fillColor: 'none',  // Transparan
                                    // dashArray: '5, 5'   // Garis putus-putus
                                };
                            }
                        }).addTo(map);
                    });
                } else {
                    console.error('Error:', result.message);
                }
            } catch (error) {
                console.error('Error fetching batas provinsi:', error);
            }
        }
        async function fetchJalanNasional() {
            try {
                const response = await fetch('api_jalan_nasional.php');
                const result = await response.json();
                
                if (result.status === 'success') {
                    result.data.forEach(lingkungan => {
                        // Parse GeoJSON
                        const geojsonData = JSON.parse(lingkungan.geojson);
                        
                        // Tambahkan layer GeoJSON ke peta
                        L.geoJSON(geojsonData, {
                            style: function (feature) {
                                return {
                                    color: 'green',      // Warna garis batas
                                    weight: 2,          // Ketebalan garis
                                    fillColor: 'none',  // Transparan
                                    // dashArray: '5, 5'   // Garis putus-putus
                                };
                            }
                        }).addTo(map);
                    });
                } else {
                    console.error('Error:', result.message);
                }
            } catch (error) {
                console.error('Error fetching batas provinsi:', error);
            }
        }
        async function fetchJalanPkk() {
            try {
                const response = await fetch('api_jalan_pkk.php');
                const result = await response.json();
                
                if (result.status === 'success') {
                    result.data.forEach(lingkungan => {
                        // Parse GeoJSON
                        const geojsonData = JSON.parse(lingkungan.geojson);
                        
                        // Tambahkan layer GeoJSON ke peta
                        L.geoJSON(geojsonData, {
                            style: function (feature) {
                                return {
                                    color: 'purple',      // Warna garis batas
                                    weight: 2,          // Ketebalan garis
                                    fillColor: 'none',  // Transparan
                                    // dashArray: '5, 5'   // Garis putus-putus
                                };
                            }
                        }).addTo(map);
                    });
                } else {
                    console.error('Error:', result.message);
                }
            } catch (error) {
                console.error('Error fetching batas provinsi:', error);
            }
        }

        // Fungsi untuk mengisi tabel
        function populateTable(data) {
            const tableBody = document.getElementById('klinik-body');
            tableBody.innerHTML = ''; // Bersihkan tabel

            data.forEach((klinik, index) => {
                const row = `
                    <tr class="border-b hover:bg-gray-100">
                        <td class="p-3">${index + 1}</td>
                        <td class="p-3">${klinik.nama}</td>
                        <td class="p-3">${klinik.kabupaten}</td>
                        <td class="p-3">${klinik.jenis}</td>
                        <td class="p-3">${klinik.tipe}</td>
                        <td class="p-3">${klinik.pemilik}</td>
                        <td class="p-3">
                            <button onclick="zoomToKlinik(${klinik.latitude}, ${klinik.longitude})" 
                                    class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-purple-600">
                                Lokasi
                            </button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });

            // Update jumlah klinik
            document.getElementById('klinik-count').textContent = data.length;
        }

        // Fungsi untuk meng-zoom ke lokasi klinik
        function zoomToKlinik(lat, lng) {
            map.setView([lat, lng], 15); // Zoom in to the selected clinic
        }

        // Fungsi untuk mengisi filter kabupaten
        function populateKabupatenFilter(data) {
            const filter = document.getElementById('kecamatan-filter');
            const uniqueKabupaten = [...new Set(data.map(klinik => klinik.kabupaten))];

            // Hapus opsi sebelumnya
            filter.innerHTML = '<option value="">Semua Kabupaten</option>';

            uniqueKabupaten.forEach(kabupaten => {
                const option = document.createElement('option');
                option.value = kabupaten;
                option.textContent = kabupaten;
                filter.appendChild(option);
            });

            filter.addEventListener('change', () => {
                const selectedKabupaten = filter.value;
                const filteredData = selectedKabupaten 
                    ? data.filter(klinik => klinik.kabupaten === selectedKabupaten) 
                    : data;
                populateTable(filteredData);
                updateMapMarkers(filteredData);
            });
        }

        // Fungsi untuk memperbarui marker pada peta
        function updateMapMarkers(data) {
            // Hapus semua marker klinik
            map.eachLayer((layer) => {
                if (layer instanceof L.Marker) {
                    map.removeLayer(layer);
                }
            });

            // Tambahkan marker baru sesuai data
            data.forEach(klinik => {
                L.marker([klinik.latitude, klinik.longitude])
                .addTo(map)
                .bindPopup(`
                    <b>${klinik.nama}</b><br>
                    Kabupaten: ${klinik.kabupaten}<br>
                    Jenis: ${klinik.jenis}<br>
                    Kelas: ${klinik.tipe}<br>
                    Email: ${klinik.mail}<br>
                `);
            });
        }

        // Fungsi untuk mengambil data klinik
        async function fetchKlinikData() {
            try {
                const response = await fetch('api_rumah_sakit.php?action=all');
                const result = await response.json();
                
                if (result.status === 'success') {
                    const data = result.data;
                    
                    // Tambahkan batas provinsi
                    await fetchBatasProvinsi();
                    //await fetchJalanLingkungan();
                    await fetchJalanLintasSumatera();
                    await fetchJalanNasional();
                    await fetchJalanPkk();

                    // Tambahkan marker untuk setiap klinik
                    data.forEach(klinik => {
                        L.marker([klinik.latitude, klinik.longitude])
                        .addTo(map)
                        .bindPopup(`
                            <b>${klinik.nama}</b><br>
                            Kabupaten: ${klinik.kabupaten}<br>
                            Jenis: ${klinik.jenis}<br>
                            Kelas: ${klinik.tipe}<br>
                            Email: ${klinik.mail}<br>
                        `);
                    });

                    // Isi tabel dan filter kabupaten
                    populateTable(data);
                    populateKabupatenFilter(data);
                } else {
                    console.error('Error:', result.message);
                }
            } catch (error) {
                console.error('Error fetching klinik data:', error);
            }
        }

        // Inisialisasi peta dan memuat data saat dokumen siap
        document.addEventListener('DOMContentLoaded', () => {
            // Inisialisasi peta
            map = L.map('map').setView([-5.4213, 105.2669], 8); // Koordinat dan zoom Bandar Lampung

            // Tambahkan layer peta
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© Kelompok 7 SIG'
            }).addTo(map);

            // Ambil data klinik
            fetchKlinikData();
        });
    </script>
</body>
</html>