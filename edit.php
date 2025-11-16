<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$name = $email = $phone = "";
$errors = [];
$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    header("Location: index.php"); exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    if (empty($name)) { $errors['name'] = "Nama wajib diisi."; }
    if (empty($email)) { $errors['email'] = "Email wajib diisi."; }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors['email'] = "Format email tidak valid."; }
    if (empty($phone)) { $errors['phone'] = "Telepon wajib diisi."; }
    if (empty($errors)) {
        try {
            $sql = "UPDATE contacts SET name = :name, email = :email, phone = :phone WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['name' => $name, 'email' => $email, 'phone' => $phone, 'id' => $id]);
            
            $_SESSION['message'] = "Kontak berhasil diperbarui.";
            header("Location: index.php");
            exit();
        } catch(PDOException $e) {
            $errors['db'] = "Gagal memperbarui data: " . $e->getMessage();
        }
    }
}

try {
    $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $contact = $stmt->fetch();
    if (!$contact) {
        $_SESSION['message'] = "Kontak tidak ditemukan.";
        header("Location: index.php"); exit();
    }
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        $name = $contact['name'];
        $email = $contact['email'];
        $phone = $contact['phone'];
    }
} catch (PDOException $e) {
    die("ERROR: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kontak</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-green-700 p-4 text-white shadow-md">
       <div class="w-[99%] mx-auto">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">KontakKuy!</h1>
                <button id="hamburger-btn" class="md:hidden p-2 rounded hover:bg-green-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
                <div class="hidden md:flex items-center space-x-4">
                    <span class="text-sm">
                        Halo, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!
                    </span>
                    <a href="index.php" class="px-3 py-2 rounded hover:bg-green-800">Home</a>
                    <a href="logout.php" class="px-3 py-2 rounded hover:bg-green-800">Logout</a>
                </div>
            </div>
            <div id="mobile-menu" class="hidden md:hidden mt-3 space-y-2">
                <span class="block text-sm px-3 py-2">
                    Halo, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!
                </span>
                <a href="index.php" class="block px-3 py-2 rounded hover:bg-green-800">Home</a>
                <a href="logout.php" class="block px-3 py-2 rounded hover:bg-green-800">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container mx-auto p-6">
        <h2 class="text-3xl font-bold mb-6 text-gray-800 text-center">Edit Kontak</h2>
        <?php if (!empty($errors['db'])): ?>
             <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 max-w-lg mx-auto">
                <?php echo $errors['db']; ?>
            </div>
        <?php endif; ?>
        <div class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto">
            <form action="edit.php?id=<?php echo $id; ?>" method="POST">
                 <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>"
                           class="mt-1 block w-full px-3 py-2 border <?php echo !empty($errors['name']) ? 'border-red-500' : 'border-gray-300'; ?> rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                    <?php if (!empty($errors['name'])): ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo $errors['name']; ?></p>
                    <?php endif; ?>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>"
                           class="mt-1 block w-full px-3 py-2 border <?php echo !empty($errors['email']) ? 'border-red-500' : 'border-gray-300'; ?> rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                    <?php if (!empty($errors['email'])): ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo $errors['email']; ?></p>
                    <?php endif; ?>
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Telepon</label>
                    <input type="tel" name="phone" id="phone" value="<?php echo htmlspecialchars($phone); ?>"
                           class="mt-1 block w-full px-3 py-2 border <?php echo !empty($errors['phone']) ? 'border-red-500' : 'border-gray-300'; ?> rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                    <?php if (!empty($errors['phone'])): ?>
                        <p class="mt-1 text-xs text-red-500"><?php echo $errors['phone']; ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <button type="submit" class="w-full bg-green-700 text-white px-4 py-2 rounded-md font-semibold hover:bg-green-800">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div> 
    <script>
        document.getElementById('hamburger-btn').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>
</html>