<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoEarth - Peta Fasilitas Kesehatan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <div class="flex">
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
        <div class="ml-[16.6667%] w-5/6 p-8">
            <div class="flex-1">
                <h1 class="text-4xl font-bold text-blue-800 mb-4">Peta Fasilitas Kesehatan</h1>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Peta Rumah Sakit -->
                    <div class="bg-white rounded-lg shadow-lg p-6 transform transition duration-300 hover:scale-105">
                        <div class="flex items-center mb-4">
                            <i class="fa-solid fa-hospital text-blue-800 text-3xl mr-3"></i>
                            <h2 class="text-xl font-bold text-blue-800">Peta Rumah Sakit</h2>
                        </div>
                        <img src="asset/rumah_sakit_map.png" alt="Peta Rumah Sakit" class="rounded-md mb-4 h-48 w-full object-cover">
                        <p class="text-gray-600 mb-4">Peta sebaran Rumah Sakit di Bandar Lampung</p>
                        <a href="map_rumah_sakit.php">
                            <button class="w-full bg-blue-800 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-300">
                                Lihat Peta Rumah Sakit
                            </button>
                        </a>
                    </div>

                    <!-- Peta Puskesmas -->
                    <div class="bg-white rounded-lg shadow-lg p-6 transform transition duration-300 hover:scale-105">
                        <div class="flex items-center mb-4">
                            <i class="fa-solid fa-briefcase-medical text-green-600 text-3xl mr-3"></i>
                            <h2 class="text-xl font-bold text-green-600">Peta Puskesmas</h2>
                        </div>
                        <img src="asset/puskesmas_map.png" alt="Peta Puskesmas" class="rounded-md mb-4 h-48 w-full object-cover">
                        <p class="text-gray-600 mb-4">Peta sebaran Puskesmas di Bandar Lampung</p>
                        <a href="map_puskesmas.php">
                            <button class="w-full bg-green-600 text-white py-2 px-4 rounded hover:bg-green-500 transition duration-300">
                                Lihat Peta Puskesmas
                            </button>
                        </a>
                    </div>

                    <!-- Peta Klinik -->
                    <div class="bg-white rounded-lg shadow-lg p-6 transform transition duration-300 hover:scale-105">
                        <div class="flex items-center mb-4">
                            <i class="fa-solid fa-stethoscope text-purple-600 text-3xl mr-3"></i>
                            <h2 class="text-xl font-bold text-purple-600">Peta Klinik</h2>
                        </div>
                        <img src="asset/klinik_map.png" alt="Peta Klinik" class="rounded-md mb-4 h-48 w-full object-cover">
                        <p class="text-gray-600 mb-4">Peta sebaran Klinik di Bandar Lampung</p>
                        <a href="map_klinik.php">
                            <button class="w-full bg-purple-600 text-white py-2 px-4  rounded hover:bg-purple-500 transition duration-300">
                                Lihat Peta Klinik
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <footer class="text-center bg-blue-800 text-white p-4 mt-8">
                Copyright &copy; 2024 Kelompok 7 Sistem Informasi Geografis
            </footer>
        </div>
    </div>
</body>
</html>