<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white shadow-md px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-pink-600">Admin Dashboard</h1>
        <div>
        <span class="text-gray-700 mr-4">Welcome, <?= $_SESSION['user_name'] ?></span>
            <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Logout</a>
        </div>
    </nav>

    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <a href="orders.php" class="bg-white p-6 rounded-xl shadow hover:shadow-lg border border-pink-100">
            <h2 class="text-lg font-semibold text-pink-700 mb-2">View Orders</h2>
            <p class="text-gray-600">Manage all customer orders and their statuses.</p>
        </a>

        <a href="inventory.php" class="bg-white p-6 rounded-xl shadow hover:shadow-lg border border-pink-100">
            <h2 class="text-lg font-semibold text-pink-700 mb-2">Manage Inventory</h2>
            <p class="text-gray-600">View and update ingredient stock levels.</p>
        </a>

        <a href="report.php" class="bg-white p-6 rounded-xl shadow hover:shadow-lg border border-pink-100">
            <h2 class="text-lg font-semibold text-pink-700 mb-2">Generate Reports</h2>
            <p class="text-gray-600">Generate daily order and delivery reports.</p>
        </a>
    </div>
</body>
</html>
