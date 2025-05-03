<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit;
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        @keyframes slideIn {
            0% { transform: translateY(20px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        .animate-card { animation: slideIn 0.6s ease-out forwards; }
        .hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body class="bg-gradient-to-br from-pink-50 to-pink-100 min-h-screen flex flex-col">

    <!-- Page Content Wrapper -->
    <div class="flex-grow">
        <nav class="bg-white shadow px-4 sm:px-6 py-4 flex flex-wrap items-center justify-between gap-4">
        <!-- Logo + Title -->
    <div class="flex items-center space-x-3 sm:space-x-4">
        <img src="assets/images/cupcake-removebg-preview.png" alt="Logo" 
            class="w-14 h-14 sm:w-16 sm:h-16 drop-shadow-md animate-bounce">
        <h1 class="text-xl sm:text-2xl font-extrabold text-pink-600">Customer Dashboard</h1>
    </div>

            <!-- User Info -->
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <span class="text-gray-700 truncate text-sm sm:text-base">
                    Hi, <?= htmlspecialchars($_SESSION['user_name']) ?>
                </span>
                <a href="logout.php" 
                    class="bg-red-500 text-white px-3 py-1 sm:px-4 sm:py-2 rounded hover:bg-red-600 transition-transform transform hover:scale-105 text-sm sm:text-base">
                    Logout
                </a>
            </div>
        </nav>

        <main class="p-4 sm:p-6 lg:p-8">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <!-- Order Card -->
                <a href="order_entry.php" 
                    class="animate-card opacity-0 bg-white p-5 sm:p-6 rounded-xl shadow-md hover-lift border border-pink-100">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="bg-pink-100 p-2 rounded-lg">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <h2 class="font-bold text-pink-700 text-lg sm:text-xl">Place New Order</h2>
                    </div>
                    <p class="text-gray-600 text-sm sm:text-base">Create custom cupcake orders with your favorite combinations</p>
                </a>

                <!-- Deliveries Card -->
                <a href="pending_deliveries.php" 
                    class="animate-card opacity-0 bg-white p-5 sm:p-6 rounded-xl shadow-md hover-lift border border-pink-100 animation-delay-100">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="bg-pink-100 p-2 rounded-lg">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                        </div>
                        <h2 class="font-bold text-pink-700 text-lg sm:text-xl">Track Deliveries</h2>
                    </div>
                    <p class="text-gray-600 text-sm sm:text-base">Monitor your order status and delivery progress</p>
                </a>
            </div>
        </main>

        <!-- Floating Decorations -->
        <div class="fixed -left-20 top-1/3 opacity-10 animate-float hidden sm:block">
            <img src="assets/images/cupcake-removebg-preview.png" class="w-32 h-32">
        </div>
        <div class="fixed -right-20 bottom-1/4 opacity-10 animate-float animation-delay-200 hidden sm:block">
            <img src="assets/images/cupcake-removebg-preview.png" class="w-32 h-32">
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-pink-600 text-white text-center py-4 animate-fade-in">
        <p class="text-sm sm:text-base">&copy; <?= date('Y') ?> Sarah's Shortcakes. All rights reserved.</p>
    </footer>

    <script>
        // Add staggered animations for cards
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.animate-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                }, index * 150);
            });
        });
    </script>
</body>
</html>
