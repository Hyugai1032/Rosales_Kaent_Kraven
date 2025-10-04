<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile View</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-black text-gray-100 font-sans min-h-screen flex flex-col">
    <!-- Navbar -->
  <header class="bg-gray-800 shadow-lg">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
      <h1 class="text-xl font-bold text-green-400"><a href="<?= site_url('/auth/dashboard') ?>">🐍 Snake Game</a></h1>
      <?php $this->call->view('/nav'); ?>
    </div>
  </header>
  <div class="max-w-3xl mx-auto p-6 w-full">
    <h1 class="text-3xl font-bold mb-6 text-center text-indigo-400">My Profile</h1>

    <div class="bg-gray-800 rounded-lg shadow-lg p-6 flex flex-col sm:flex-row items-center sm:items-start">

      <!-- Profile Info -->
      <div class="flex-1 text-center sm:text-left">
        <p class="text-xl font-semibold"><?= html_escape($user['username']) ?></p>
        <p class="text-gray-400"><?= html_escape($user['email']) ?></p>
        <p class="text-sm mt-2">
          <span class="px-2 py-1 bg-indigo-600 rounded text-white"><?= ucfirst($user['role']) ?></span>
        </p>
        <p class="mt-2 text-gray-500 text-sm">Joined: <?= date('F j, Y', strtotime($user['created_at'])) ?></p>

        <div class="mt-6">
          <a href="<?= site_url('/profile/manage') ?>" 
             class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded shadow">
            Manage Profile
          </a>
        </div>
      </div>
    </div>
  </div>
  <?php $this->call->view('footer') ?>
</body>
</html>