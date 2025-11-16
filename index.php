<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$stmt = $pdo->query("SELECT * FROM contacts ORDER BY name ASC");
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kontak</title>
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
                    <a href="index.php" class="px-3 py-2 rounded font-semibold">Home</a>
                    <a href="logout.php" class="px-3 py-2 rounded hover:bg-green-800">Logout</a>
                </div>
            </div>
            <div id="mobile-menu" class="hidden md:hidden mt-3 space-y-2">
                <span class="block text-sm px-3 py-2">
                    Halo, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!
                </span>
                <a href="index.php" class="block px-3 py-2 rounded bg-green-800 font-semibold">Home</a>
                <a href="logout.php" class="block px-3 py-2 rounded hover:bg-green-800">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container mx-auto p-6">
        <?php
        if (isset($_SESSION['message'])) {
            echo '
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">' . htmlspecialchars($_SESSION['message']) . '</span>
            </div>
            ';
            unset($_SESSION['message']);
        }
        ?>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800 mb-3 sm:mb-0">Daftar Kontak</h2>
            <a href="tambah.php" class="px-4 py-2 rounded-md bg-green-700 text-white font-semibold hover:bg-green-800 transition duration-200">
                + Tambah Kontak Baru
            </a>
        </div>
        <div class="bg-white shadow-md rounded-lg overflow-hidden overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Telepon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($contacts)): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada kontak.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($contacts as $contact): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($contact['name']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($contact['email']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($contact['phone']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="edit.php?id=<?php echo $contact['id']; ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                    <a href="hapus.php?id=<?php echo $contact['id']; ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div> 
    <script>
        document.getElementById('hamburger-btn').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>
</html>