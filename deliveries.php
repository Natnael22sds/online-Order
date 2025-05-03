<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'delivery') {
    header("Location: login.php");
    exit;
}
// Update status
if (isset($_GET['id']) && isset($_GET['status'])) {
    $stmt = $pdo->prepare("UPDATE orderss SET status = ? WHERE id = ?");
    $stmt->execute([$_GET['status'], $_GET['id']]);
    header("Location: deliveries.php");
    exit;
}

// Get deliveries
$stmt = $pdo->prepare("
    SELECT o.*, u.name AS customer_name, u.email
    FROM orderss o
    JOIN userss u ON o.user_id = u.id
    WHERE o.pickup_or_delivery = 'delivery' AND o.status != 'completed'
    ORDER BY o.order_date, o.required_time
");
$stmt->execute();
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delivery Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 p-6">
    <h2 class="text-2xl font-bold text-blue-600 mb-4">Your Deliveries</h2>

    <table class="min-w-full bg-white shadow-md rounded-xl overflow-hidden">
        <thead class="bg-blue-100 text-blue-800">
            <tr>
                <th class="px-4 py-2 text-left">Customer</th>
                <th class="px-4 py-2 text-left">Address</th>
                <th class="px-4 py-2 text-left">Date & Time</th>
                <th class="px-4 py-2 text-left">Status</th>
                <th class="px-4 py-2 text-left">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <strong><?= htmlspecialchars($order['customer_name']) ?></strong><br>
                        <span class="text-sm text-gray-500"><?= $order['email'] ?></span>
                    </td>
                    <td class="px-4 py-3"><?= htmlspecialchars($order['delivery_address']) ?></td>
                    <td class="px-4 py-3"><?= $order['order_date'] ?> <?= $order['required_time'] ?></td>
                    <td class="px-4 py-3">
                        <span class="inline-block px-2 py-1 rounded text-sm 
                            <?= $order['status'] == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-indigo-100 text-indigo-700' ?>">
                            <?= ucfirst($order['status']) ?>
                        </span>
                    </td>
                    <td class="px-4 py-3 space-x-2">
                        <?php if ($order['status'] == 'pending'): ?>
                            <a href="?id=<?= $order['id'] ?>&status=in_transit" class="bg-indigo-500 text-white px-3 py-1 rounded text-sm hover:bg-indigo-600">In Transit</a>
                        <?php endif; ?>
                        <a href="?id=<?= $order['id'] ?>&status=completed" class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">Delivered</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
