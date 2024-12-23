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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mencari user di database
    $sql = "SELECT * FROM user WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verifikasi password tanpa hashing
        if ($password === $user['password']) {
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect berdasarkan role
            if ($user['role'] == 'user') {
                header("Location: beranda.php");
            } elseif ($user['role'] == 'administrator') {
                header("Location: kelola_user.php");
            }
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GeoEarth Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }

    .center {
      display: flex;
      justify-content: center;
      align-items: center;
    }
  </style>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-blue-800 flex flex-col justify-between h-screen">
  <div class="bg-blue-900 p-8 rounded-lg shadow-lg max-w-4xl w-full mx-auto my-auto">
    <div class="center mb-6">
      <img src="asset/worldwide_477702.png" alt="GeoEarth Logo" class="w-20 h-20 mr-4">
      <div>
        <h1 class="text-white text-2xl font-bold mb-2">GeoEarth</h1>
        <p class="text-white">Selamat Datang di <span class="text-[#FFFF00]">GeoEarth</span></p>
      </div>
    </div>
    <div>
      <form method="POST" action="">
        <div class="mb-4">
          <label for="username" class="block text-white mb-2">Username</label>
          <input type="text" name="username" id="username" placeholder="Masukkan Username" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
        </div>
        <div class="mb-4">
          <label for="password" class="block text-white mb-2">Password</label>
          <input type="password" name="password" id="password" placeholder="Masukkan Password" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
        </div>
        <button type="submit" class="w-full bg-[#FFFF00] text-black font-bold py-2 rounded-lg hover:bg-white">Login</button>
      </form>
      <?php if (isset($error)): ?>
        <p class="text-red-500 text-center mt-4"><?php echo $error; ?></p>
      <?php endif; ?>
    </div>
  </div>
  <footer class="text-center text-white text-xs py-4">
    <p>Copyright &copy; 2024 Kelompok 7 Sistem Informasi Geografis</p>
  </footer>
</body>
</html>