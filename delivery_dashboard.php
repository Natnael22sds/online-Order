<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'delivery') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 min-h-screen flex flex-col">
    <nav class="bg-white shadow px-4 sm:px-6 py-4">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h1 class="text-lg md:text-xl font-bold text-blue-600">Delivery Dashboard</h1>
            <div class="flex items-center gap-4">
                <span class="text-sm md:text-base text-gray-700 truncate">Hello, <?= $_SESSION['user_name'] ?></span>
                <a href="logout.php" class="bg-red-500 text-white px-3 py-1 md:px-4 rounded text-sm md:text-base">Logout</a>
            </div>
        </div>
    </nav>

    <main class="flex-1">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="max-w-4xl mx-auto">
                <a href="deliveries.php" class="block bg-white p-6 rounded-xl shadow hover:shadow-md border border-blue-100 transition-shadow">
                    <h2 class="font-bold text-blue-700 mb-2 text-lg">View Delivery List</h2>
                    <p class="text-sm text-gray-600">See scheduled orders and update delivery status.</p>
                </a>
            </div>
        </div>
    </main>

    <footer class="bg-white shadow mt-auto">
        <div class="container mx-auto px-4 sm:px-6 py-4">
            <p class="text-center text-sm text-gray-700">
                &copy; <?= date('Y') ?> Delivery Dashboard. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>