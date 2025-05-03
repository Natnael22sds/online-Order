<?php
session_start();
require 'includes/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}


// Handle marking order as completed
if (isset($_GET['complete'])) {
    $id = $_GET['complete'];
    $stmt = $pdo->prepare("UPDATE orderss SET status = 'completed' WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: orders.php");
    exit;
}

// Fetch orders + customer info
$stmt = $pdo->query("
    SELECT o.*, u.name AS customer_name, u.email 
    FROM orderss o
    JOIN userss u ON o.user_id = u.id
    ORDER BY o.created_at DESC
");

$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="p-6">
        <h2 class="text-2xl font-bold text-pink-600 mb-6">All Orders</h2>

        <table class="min-w-full bg-white shadow-md rounded-xl overflow-hidden">
            <thead class="bg-pink-100 text-pink-800">
                <tr>
                    <th class="px-4 py-2 text-left">Customer</th>
                    <th class="px-4 py-2 text-left">Order Details</th>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Method</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <?php
                        // Get cupcake details
                        $itemsStmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
                        $itemsStmt->execute([$order['id']]);
                        $item = $itemsStmt->fetch();
                    ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <div class="font-semibold"><?= htmlspecialchars($order['customer_name']) ?></div>
                            <div class="text-sm text-gray-500"><?= htmlspecialchars($order['email']) ?></div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div><strong>Flavor:</strong> <?= $item['flavor'] ?></div>
                            <div><strong>Icing:</strong> <?= $item['icing'] ?></div>
                            <div><strong>Color:</strong> <?= $item['color'] ?></div>
                            <div><strong>Decoration:</strong> <?= $item['decoration'] ?></div>
                            <div><strong>Quantity:</strong> <?= $item['quantity'] ?></div>
                            <?php if ($order['pickup_or_delivery'] == 'delivery'): ?>
                                <div class="mt-2 text-xs text-gray-500"><strong>Address:</strong> <?= $order['delivery_address'] ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3"><?= $order['order_date'] ?> <br><span class="text-xs"><?= $order['required_time'] ?></span></td>
                        <td class="px-4 py-3"><?= ucfirst($order['pickup_or_delivery']) ?></td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded text-xs <?= $order['status'] === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' ?>">
                                <?= ucfirst($order['status']) ?>
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <?php if ($order['status'] === 'pending'): ?>
                                <a href="?complete=<?= $order['id'] ?>" class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">Mark Completed</a>
                            <?php else: ?>
                                <span class="text-gray-400 text-sm">✔ Done</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
