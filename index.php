<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sarah's Shortcakes</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="assets/images/cupcake-removebg-preview.png">
</head>
<body class="bg-pink-50 text-gray-800">

  <!-- Header / Hero -->
  <header class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex flex-wrap items-center justify-between gap-4">
      <div class="flex items-center gap-2 sm:gap-4">
        <img src="assets/images/cupcake-removebg-preview.png" alt="Sarah's Shortcakes Logo"
             class="w-12 h-12 sm:w-20 sm:h-20 object-contain drop-shadow-lg">
        <h1 class="text-xl sm:text-3xl font-extrabold text-pink-600 tracking-tight">Sarah's Shortcakes</h1>
      </div>
      <div class="flex flex-wrap gap-2 sm:gap-4 w-full sm:w-auto">
        <a href="login.php" class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700 text-sm sm:text-base transition-colors w-full sm:w-auto text-center">
          Login
        </a>
        <a href="signup.php" class="bg-white border-2 border-pink-600 text-pink-600 px-4 py-2 rounded-lg hover:bg-pink-50 text-sm sm:text-base transition-colors w-full sm:w-auto text-center">
          Sign Up
        </a>
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="bg-gradient-to-br from-pink-100 to-pink-200 py-12 sm:py-20">
    <div class="max-w-4xl mx-auto text-center px-4">
      <h2 class="text-3xl sm:text-5xl font-extrabold text-pink-700 mb-4">Delight in Every Bite 🍰</h2>
      <p class="text-base sm:text-xl text-gray-700 mb-6">Custom cupcakes made with love and delivered fresh to your door. Perfect for parties, events, or just because.</p>
      <a href="signup.php" class="inline-block bg-pink-600 text-white px-8 py-3 rounded-lg shadow hover:bg-pink-700 transition-colors text-lg sm:text-xl">
        Get Started
      </a>
    </div>
  </section>

  <!-- Features -->
  <section class="py-12 sm:py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-8 text-center">
      <div class="bg-pink-100 p-4 sm:p-6 rounded-lg shadow hover:shadow-md transition">
        <h3 class="text-lg sm:text-xl font-semibold text-pink-700 mb-2">Custom Orders</h3>
        <p class="text-sm sm:text-base">Create your own cupcakes with your favorite flavors, toppings, and decorations.</p>
      </div>
      <div class="bg-pink-100 p-4 sm:p-6 rounded-lg shadow hover:shadow-md transition">
        <h3 class="text-lg sm:text-xl font-semibold text-pink-700 mb-2">Fast Delivery</h3>
        <p class="text-sm sm:text-base">On-time delivery so your treats arrive fresh and ready for your celebration.</p>
      </div>
      <div class="bg-pink-100 p-4 sm:p-6 rounded-lg shadow hover:shadow-md transition">
        <h3 class="text-lg sm:text-xl font-semibold text-pink-700 mb-2">Freshly Baked</h3>
        <p class="text-sm sm:text-base">We bake every order on the same day to ensure quality and deliciousness.</p>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-pink-600 text-white text-center py-6">
    <p class="text-sm sm:text-base">&copy; <?= date('Y') ?> Sarah's Shortcakes. All rights reserved.</p>
  </footer>

</body>
</html>