<?php
session_start();
$host = 'localhost'; // Ganti dengan host database Anda
$db = 'tubes-sig-2024'; // Nama database
$user = 'root'; // Ganti dengan username database Anda
$pass = ''; // Ganti dengan password database Anda

// Koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menangani penambahan pengguna
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'user'; // Role default untuk pengguna baru

    // Menyimpan pengguna baru ke database
    $sql = "INSERT INTO user (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $password, $role);
    $stmt->execute();
}

// Mengambil data pengguna dari database
$sql = "SELECT * FROM user";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoEarth</title>
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
    <div class="flex flex-1">
        <!-- Sidebar -->
        <div class="w-1/6 bg-blue-800 text-white h-screen flex flex-col fixed">
            <div class="flex items-center space-x-4 p-4 justify-center">
                <img src="asset/worldwide_477702.png" alt="Logo" class="w-10 h-10">
                <h1 class="text-2xl font-bold">GeoEarth</h1>
            </div>
            <nav class="text-gray-300 text-base font-semibold px-4 py-2">
                <a href="kelola_user.php" class="flex items-center py-2.5 px-4 rounded hover:bg-gray-700 text-[#FFFF00]"><i class="fa-solid fa-user mr-3"></i><span class="overflow-hidden text-ellipsis whitespace-nowrap">Kelola User</span></a>
            </nav>
            <div class="absolute bottom-0 text-gray-300 text-sm font-semibold px-4 py-2">
                <a href="#" class="flex items-center py-2.5 px-4 rounded hover:bg-gray-700"><i class="fa-solid fa-circle-user mr-3"></i><span class="overflow-hidden text-ellipsis">Administrator</span></a>
                <a href="login.php" class="flex items-center py-2.5 px-4 rounded hover:bg-gray-700"><i class="fa-solid fa-arrow-right-from-bracket mr-3"></i><span class="overflow-hidden text-ellipsis whitespace-nowrap">Logout</span></a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="w-5/6 ml-auto p-8 flex flex-col">
            <div class="flex-1">
                <h1 class="text-4xl font-bold text-blue-800 mb-4">Kelola User</h1>
                <div class="bg-white shadow-md rounded p-4 mb-4">
                    <h2 class="text-xl font-semibold mb-2">Tambah Pengguna</h2>
                    <form method="POST" action="">
                        <div class="mb-4">
                            <label for="username" class="block text-gray-700">Username</label>
                            <input type="text" name="username" id="username" class="w-full px-4 py-2 border rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block text-gray-700">Password</label>
                            <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded" required>
                        </div>
                        <button type="submit" name="add_user" class="bg-blue-800 text-white py-2 px-4 rounded">Tambah Pengguna</button>
                    </form>
                </div>
                <div class="bg-white shadow-md rounded">
                    <table class="min-w-full bg-white">
                        <thead class="bg-blue-800 text-white">
                            <tr>
                                <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Username</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Password</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            <?php while ($user = $result->fetch_assoc()): ?>
                                <tr class="border-b border-gray-300">
                                    <td class="py-2 px-4"><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td class="py-2 px-4"><?php echo htmlspecialchars($user['password']); ?></td>
                                    <td class="py-2 px-4 text-center">
                                        <button class="text-gray-500 hover:text-gray-700 mx-1 border p-2 rounded-lg"><i class="fas fa-eye"></i></button>
                                        <button class="text-gray-500 hover:text-gray-700 mx-1 border p-2 rounded-lg"><i class="fas fa-pencil-alt"></i></button>
                                        <button class="text-gray-500 hover:text-gray-700 mx-1"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <footer class="text-center bg-blue-800 text-white p-4 mt-8 w-full">
                Copyright &copy; 2024 Kelompok 7 Sistem Informasi Geografis
            </footer>
        </div>
    </div>
</body>
</html>