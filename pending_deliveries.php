<?php
session_start();
require 'includes/db.php';

// Check if the user is logged in and is a customer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit;
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Get the delivery orders for the logged-in user that are not marked as "completed"
$stmt = $pdo->prepare("
    SELECT o.*, u.name AS customer_name, u.email
    FROM orderss o
    JOIN userss u ON o.user_id = u.id
    WHERE o.pickup_or_delivery = 'delivery' 
    AND o.status != 'completed'
    AND o.user_id = :user_id
    ORDER BY o.order_date, o.required_time
");
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending Deliveries</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-4 md:p-6">
    <h2 class="text-xl md:text-2xl font-bold text-pink-600 mb-4">Pending Deliveries</h2>

    <div class="overflow-x-auto rounded-lg shadow">
        <table class="w-full bg-white">
            <thead class="bg-pink-100 text-pink-800">
                <tr>
                    <th class="px-3 py-2 md:px-4 md:py-2 text-left">Customer</th>
                    <th class="px-3 py-2 md:px-4 md:py-2 text-left hidden md:table-cell">Date & Time</th>
                    <th class="px-3 py-2 md:px-4 md:py-2 text-left hidden sm:table-cell">Address</th>
                    <th class="px-3 py-2 md:px-4 md:py-2 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-3 py-2 md:px-4 md:py-3">
                            <div class="font-semibold text-sm md:text-base"><?= htmlspecialchars($order['customer_name']) ?></div>
                            <div class="text-xs md:text-sm text-gray-500"><?= htmlspecialchars($order['email']) ?></div>
                        </td>
                        <td class="px-3 py-2 md:px-4 md:py-3 text-sm md:text-base hidden md:table-cell">
                            <?= $order['order_date'] ?> @ <?= $order['required_time'] ?>
                        </td>
                        <td class="px-3 py-2 md:px-4 md:py-3 text-sm md:text-base hidden sm:table-cell break-words">
                            <?= htmlspecialchars($order['delivery_address']) ?>
                        </td>
                        <td class="px-3 py-2 md:px-4 md:py-3">
                            <span class="inline-block bg-yellow-100 text-yellow-700 text-xs md:text-sm px-2 md:px-3 py-1 rounded">
                                <?= ucfirst($order['status']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>