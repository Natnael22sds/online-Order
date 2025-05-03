<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Handle Add New Ingredient
if (isset($_POST['add'])) {
    $name = $_POST['ingredient_name'];
    $quantity = $_POST['quantity'];
    $unit = $_POST['unit'];
    $restock = $_POST['restock_level'];

    $stmt = $pdo->prepare("INSERT INTO inventory (ingredient_name, quantity, unit, restock_level) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $quantity, $unit, $restock]);
}

// Handle Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];
    $name = $_POST['ingredient_name'];
    $unit = $_POST['unit'];
    $restock = $_POST['restock_level'];

    $stmt = $pdo->prepare("UPDATE inventory SET ingredient_name = ?, quantity = ?, unit = ?, restock_level = ? WHERE id = ?");
    $stmt->execute([$name, $quantity, $unit, $restock, $id]);
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $pdo->prepare("DELETE FROM inventory WHERE id = ?")->execute([$id]);
    header("Location: inventory.php");
    exit;
}

// Fetch all inventory
$ingredients = $pdo->query("SELECT * FROM inventory ORDER BY ingredient_name ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="p-6 max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-pink-600 mb-6">Manage Inventory</h2>

        <!-- Add New Ingredient -->
        <form method="POST" class="bg-white p-4 rounded-lg shadow-md mb-8 grid grid-cols-1 sm:grid-cols-4 gap-4">
            <input type="text" name="ingredient_name" placeholder="Ingredient name" required class="border px-3 py-2 rounded">
            <input type="number" name="quantity" placeholder="Quantity" required class="border px-3 py-2 rounded">
            <input type="text" name="unit" placeholder="Unit (e.g. kg, pcs)" required class="border px-3 py-2 rounded">
            <input type="number" name="restock_level" placeholder="Restock Level" required class="border px-3 py-2 rounded">
            <button name="add" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Add Ingredient</button>
        </form>

        <!-- Inventory Table -->
        <table class="min-w-full bg-white shadow-md rounded-xl overflow-hidden">
            <thead class="bg-pink-100 text-pink-800">
                <tr>
                    <th class="px-4 py-2 text-left">Ingredient</th>
                    <th class="px-4 py-2 text-left">Quantity</th>
                    <th class="px-4 py-2 text-left">Unit</th>
                    <th class="px-4 py-2 text-left">Restock Level</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ingredients as $item): ?>
                    <tr class="border-b hover:bg-gray-50 <?= $item['quantity'] <= $item['restock_level'] ? 'bg-yellow-50' : '' ?>">
                        <form method="POST" class="contents">
                            <td class="px-4 py-3">
                                <input type="text" name="ingredient_name" value="<?= htmlspecialchars($item['ingredient_name']) ?>" class="w-full px-2 py-1 border rounded">
                            </td>
                            <td class="px-4 py-3">
                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" class="w-full px-2 py-1 border rounded text-center">
                            </td>
                            <td class="px-4 py-3">
                                <input type="text" name="unit" value="<?= $item['unit'] ?>" class="w-full px-2 py-1 border rounded text-center">
                            </td>
                            <td class="px-4 py-3">
                                <input type="number" name="restock_level" value="<?= $item['restock_level'] ?>" class="w-full px-2 py-1 border rounded text-center">
                            </td>
                            <td class="px-4 py-3 flex space-x-2">
                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                <button name="update" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">Update</button>
                                <a href="?delete=<?= $item['id'] ?>" onclick="return confirm('Delete this item?')" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">Delete</a>
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
