<?php
include 'db.php';
session_start();

$errors = [];
$username = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username)) { $errors[] = "Username wajib diisi."; }
    if (empty($password)) { $errors[] = "Password wajib diisi."; }
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        if ($stmt->fetch()) {
            $errors[] = "Username sudah terpakai.";
        }
    }
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute(['username' => $username, 'password' => $hashed_password]);
            $_SESSION['message'] = "Registrasi berhasil! Silakan login.";
            header("Location: login.php");
            exit();
        } catch (PDOException $e) {
            $errors[] = "Gagal mendaftar: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm">
        <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Registrasi</h2>
        
        <?php if (!empty($errors)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" required>
            </div>
            <div>
                <button type="submit" class="w-full bg-green-700 text-white px-4 py-2 rounded-md font-semibold hover:bg-green-800">
                    Daftar
                </button>
            </div>
            <p class="text-center text-sm text-gray-600 mt-4">
                Sudah punya akun? <a href="login.php" class="text-green-700 hover:text-green-800">Login di sini</a>
            </p>
        </form>
    </div>
</body>
</html>