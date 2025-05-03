<?php
session_start();
require 'includes/db.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $hashed   = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT id FROM userss WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        $error = "Email already registered.";
    } else {
        $insert = $pdo->prepare("INSERT INTO userss (name, email, password, role) VALUES (?, ?, ?, 'customer')");
        if ($insert->execute([$name, $email, $hashed])) {
            // Set session and redirect
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['user_name'] = $name;
            $_SESSION['user_role'] = 'customer';

            header("Location: customer_dashboard.php");
            exit;
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - Sarah's Shortcakes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-pink-50 to-pink-100 min-h-screen flex items-center">
    <div class="max-w-2xl mx-auto px-4 w-full py-8">
        <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-10 md:p-12 transition-all duration-300 hover:shadow-2xl">
            <!-- Floating Decorations -->
            <div class="animate-float absolute -left-20 top-20 opacity-20 hidden sm:block">
                <img src="assets/images/cupcake-removebg-preview.png" class="w-32 h-32">
            </div>
            <div class="animate-float animate-delay-1 absolute -right-20 bottom-20 opacity-20 hidden sm:block">
                <img src="assets/images/cupcake-removebg-preview.png" class="w-32 h-32">
            </div>

            <!-- Logo Header -->
            <div class="flex flex-col items-center mb-8">
                <img src="assets/images/cupcake-removebg-preview.png" alt="Logo" 
                     class="w-20 h-20 sm:w-24 sm:h-24 mb-4 animate-bounce">
                <h1 class="text-3xl sm:text-4xl font-bold text-pink-600">
                    Sarah's Shortcakes
                </h1>
                <p class="mt-2 text-gray-600">Sweet moments start here</p>
            </div>

            <!-- Messages -->
            <?php if ($success): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 animate-fade-in">
                ✔️ <?= $success ?>
            </div>
            <?php elseif ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 animate-fade-in">
                ❌ <?= $error ?>
            </div>
            <?php endif; ?>

            <!-- Signup Form -->
            <form method="POST" class="space-y-6">
                <div class="animate-slide-in-left">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Full Name</label>
                    <input type="text" name="name" required
                           class="w-full px-4 py-3 rounded-lg border border-pink-200 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition duration-200">
                </div>

                <div class="animate-slide-in-left delay-100">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Email</label>
                    <input type="email" name="email" required
                           class="w-full px-4 py-3 rounded-lg border border-pink-200 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition duration-200">
                </div>

                <div class="animate-slide-in-left delay-200">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 rounded-lg border border-pink-200 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition duration-200">
                </div>

                <button type="submit" 
                        class="w-full bg-pink-600 hover:bg-pink-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105 animate-pop-in">
                    Create Account
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-6 text-center animate-fade-in">
                <p class="text-gray-600">Already have an account? 
                    <a href="login.php" class="text-pink-600 hover:text-pink-800 font-semibold transition duration-200">
                        Sign in here
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Add scroll animations for form elements
        document.addEventListener('DOMContentLoaded', () => {
            const elements = document.querySelectorAll('.animate-slide-in-left');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateX(-20px)';
                setTimeout(() => {
                    el.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                    el.style.opacity = '1';
                    el.style.transform = 'translateX(0)';
                }, index * 150);
            });
        });
    </script>
</body>
</html>