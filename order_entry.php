<?php
session_start();
require 'includes/db.php';

// Check if the logged-in user is a customer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit;
}

$customer_id = $_SESSION['user_id']; // Auto-fill from logged-in user
$customer_name = $_SESSION['user_name'] ?? 'Customer';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity    = $_POST['quantity'];
    $method      = $_POST['method'];
    $address     = $method === 'delivery' ? $_POST['address'] : null;
    $date        = $_POST['date'];
    $time        = $_POST['time'];

    $flavor      = $_POST['flavor'];
    $icing       = $_POST['icing'];
    $color       = $_POST['color'];
    $decoration  = $_POST['decoration'];


    try {
        $pdo->beginTransaction();

        $insertOrder = $pdo->prepare("INSERT INTO orderss (user_id, order_date, pickup_or_delivery, delivery_address, required_time) VALUES (?, ?, ?, ?, ?)");
        $insertOrder->execute([$customer_id, $date, $method, $address, $time]);
        $order_id = $pdo->lastInsertId();

        $insertItem = $pdo->prepare("INSERT INTO order_items (order_id, flavor, icing, color, decoration, quantity) VALUES (?, ?, ?, ?, ?, ?)");
        $insertItem->execute([$order_id, $flavor, $icing, $color, $decoration, $quantity]);

        $pdo->commit();
        $success = "Order successfully placed!";
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Failed to place order: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Place Order</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleAddress() {
            const method = document.getElementById('method').value;
            document.getElementById('addressSection').classList.toggle('hidden', method === 'pickup');
        }

        function showModal() {
            document.getElementById("confirmationModal").classList.remove("hidden");
        }
    </script>
</head>
<body class="bg-pink-50 min-h-screen flex items-center justify-center p-4 sm:p-6">
    <div class="bg-white p-6 sm:p-8 rounded-xl shadow-lg w-full max-w-2xl">
        <h2 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6 text-center text-pink-700">Place Your Cupcake Order</h2>

        <?php if ($success): ?>
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-sm sm:text-base"><?= $success ?></div>
        <?php elseif ($error): ?>
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4 text-sm sm:text-base"><?= $error ?></div>
        <?php endif; ?>

        <p class="mb-4 text-gray-600 text-sm sm:text-base">
            <strong>Ordering as:</strong> <?= htmlspecialchars($customer_name) ?>
        </p>

        <form method="POST" onsubmit="showModal()">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 mb-4">
                <div class="space-y-1">
                    <label class="block font-medium text-gray-700 text-sm sm:text-base">Flavor</label>
                    <select name="flavor" required class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border rounded-lg">
                        <option>Vanilla</option>
                        <option>Chocolate</option>
                        <option>Red Velvet</option>
                        <option>Lemon</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="block font-medium text-gray-700 text-sm sm:text-base">Icing</label>
                    <select name="icing" required class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border rounded-lg">
                        <option>Buttercream</option>
                        <option>Whipped Cream</option>
                        <option>Cream Cheese</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="block font-medium text-gray-700 text-sm sm:text-base">Color</label>
                    <select name="color" required class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border rounded-lg">
                        <option>Pink</option>
                        <option>Blue</option>
                        <option>Yellow</option>
                        <option>White</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="block font-medium text-gray-700 text-sm sm:text-base">Decoration</label>
                    <select name="decoration" required class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border rounded-lg">
                        <option>Sprinkles</option>
                        <option>Cherries</option>
                        <option>Hearts</option>
                        <option>Stars</option>
                    </select>
                </div>
            </div>

            <div class="space-y-3 sm:space-y-4">
                <div class="space-y-1">
                    <label class="block font-medium text-gray-700 text-sm sm:text-base">Quantity</label>
                    <input type="number" name="quantity" value="1" min="1" required 
                           class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border rounded-lg">
                </div>

                <div class="space-y-1">
                    <label class="block font-medium text-gray-700 text-sm sm:text-base">Order Method</label>
                    <select name="method" id="method" onchange="toggleAddress()" required 
                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border rounded-lg">
                        <option value="pickup">Pickup</option>
                        <option value="delivery">Delivery</option>
                    </select>
                </div>

                <div id="addressSection" class="hidden space-y-1">
                    <label class="block font-medium text-gray-700 text-sm sm:text-base">Delivery Address</label>
                    <textarea name="address" rows="2" 
                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border rounded-lg"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                    <div class="space-y-1">
                        <label class="block font-medium text-gray-700 text-sm sm:text-base">Date</label>
                        <input type="date" name="date" required 
                               class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border rounded-lg">
                    </div>
                    <div class="space-y-1">
                        <label class="block font-medium text-gray-700 text-sm sm:text-base">Time</label>
                        <input type="time" name="time" required 
                               class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border rounded-lg">
                    </div>
                </div>
            </div>

            <button type="submit" 
                    class="mt-4 sm:mt-6 w-full bg-pink-600 text-white py-2 sm:py-3 rounded-lg hover:bg-pink-700 transition text-sm sm:text-base">
                Submit Order
            </button>
        </form>
    </div>

    <!-- Confirmation modal -->
    <div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-xl p-6 shadow-xl w-full max-w-xs sm:max-w-sm">
            <h3 class="text-lg sm:text-xl font-semibold text-green-700 mb-3 sm:mb-4">✅ Order Submitted</h3>
            <button onclick="location.reload()" 
                    class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm sm:text-base">
                Place Another
            </button>
        </div>
    </div>
</body>
</html>