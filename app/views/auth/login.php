<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-black text-white">
  <div class="bg-gray-800 rounded-2xl shadow-2xl p-8 w-full max-w-md">
    <h1 class="text-3xl font-bold text-center mb-6 text-green-400">Log In</h1>

    <form action="<?= site_url('auth/login') ?>" method="post" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-white-700">Username</label>
        <input type="text" name="username" required
               class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 focus:ring-2 focus:ring-green-400 outline-none"/>
      </div>

      <div>
        <label class="block text-sm font-medium text-white-700">Password</label>
        <input type="password" name="password" required
               class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 focus:ring-2 focus:ring-green-400 outline-none"/>
      </div>

      <button type="submit"
              class="w-full py-3 bg-green-500 hover:bg-green-600 rounded-lg text-lg font-semibold transition-colors">
        Log In
      </button>
    </form>

    <p class="text-sm text-gray-400 mt-6 text-center">
      Don’t have an account? 
      <a href="<?= site_url('auth/register') ?>" class="text-green-400 hover:underline">Register</a>
    </p>
  </div>
</body>
</html>
