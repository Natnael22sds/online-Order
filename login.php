<?php
session_start();
require 'includes/db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Check user by email
    $stmt = $pdo->prepare("SELECT * FROM userss WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Common session variables
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role']      = $user['role'];

        // Redirect based on role
        if ($user['role'] === 'admin') {
            header("Location: admin_dashboard.php");
        } elseif ($user['role'] === 'customer') {
            header("Location: customer_dashboard.php");
        } elseif ($user['role'] === 'delivery') {
            header("Location: delivery_dashboard.php");
        } else {
            $error = "Invalid user role.";
        }
        exit;
    } else {
        $error = "Invalid login credentials.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Sarah's Shortcakes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="assets/images/cupcake-removebg-preview.png">
</head>
<body class="bg-gradient-to-br from-pink-50 to-pink-100 min-h-screen flex items-center">
    <div class="max-w-2xl mx-auto px-4 w-full py-8">
        <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-10 md:p-12 transition-all duration-300 hover:shadow-2xl">
            <!-- Logo Header -->
            <div class="flex flex-col items-center mb-8">
                <img src="assets/images/cupcake-removebg-preview.png" alt="Logo" 
                     class="w-20 h-20 sm:w-24 sm:h-24 mb-4 animate-bounce">
                <h1 class="text-3xl sm:text-4xl font-bold text-pink-600">
                    Sarah's Shortcakes
                </h1>
                <p class="mt-2 text-gray-600">Sweet moments start here</p>
            </div>

            <!-- Error Message -->
            <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <?= $error ?>
            </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Email</label>
                    <input type="email" name="email" required
                           class="w-full px-4 py-3 rounded-lg border border-pink-200 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition duration-200">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 rounded-lg border border-pink-200 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition duration-200">
                </div>

                <button type="submit" 
                        class="w-full bg-pink-600 hover:bg-pink-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105">
                    Sign In
                </button>
            </form>

            <!-- Signup Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-600">Don't have an account? 
                    <a href="signup.php" class="text-pink-600 hover:text-pink-800 font-semibold transition duration-200">
                        Create one
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>