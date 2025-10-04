<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Player</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-black text-gray-100 min-h-screen flex flex-col">
  <!-- Navbar -->
  <header class="bg-gray-800 shadow-lg">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
      <h1 class="text-xl font-bold text-green-400">🐍 Snake Game</h1>
      <nav>
        <a href="/auth/logout" class="text-red-400 hover:text-red-500">Logout</a>
      </nav>
    </div>
  </header>

  <!-- Content -->
  <main class="flex-1 max-w-6xl mx-auto px-6 py-8">
    <h2 class="text-2xl font-semibold text-green-400 mb-6">Welcome, <?= $username ?>!</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Play Game -->
      <div class="bg-gray-800 rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold mb-3">Play Snake</h3>
        <p class="text-gray-400 mb-4">Jump straight into the action and set a new high score!</p>
        <a href="/snake" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">Play Now</a>
      </div>

      <!-- My Highscores -->
      <div class="bg-gray-800 rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold mb-3">My Highscores</h3>
        <p class="text-gray-400 mb-4">Track your best scores and progress.</p>
        <a href="/my-scores" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">View Scores</a>
      </div>

      <!-- Global Leaderboards -->
      <div class="bg-gray-800 rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold mb-3">Leaderboards</h3>
        <p class="text-gray-400 mb-4">View the scores of the best players.</p>
        <a href="/leaderboard" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">View Scores</a>
      </div>

      <!-- Profile -->
      <div class="bg-gray-800 rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold mb-3">My Profile</h3>
        <p class="text-gray-400 mb-4">View and manage your profile</p>
        <a href="/profile" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">View Profile</a>
      </div>
    </div>
  </main>
    <?php $this->call->view('footer') ?>
</body>
</html>