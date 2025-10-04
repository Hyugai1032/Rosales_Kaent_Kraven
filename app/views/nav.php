<?php
  // Get current path (without query string)
  $current = strtok($_SERVER["REQUEST_URI"], '?');
?>

<nav class="flex items-center gap-6">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16">

      <!-- Right side -->
      <div class="flex items-center space-x-6">
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          <!-- Admin Nav -->
          <a href="<?= site_url('/admin/manage_users') ?>" 
             class="<?= ($current == '/admin/manage_users') ? 'text-green-400 font-semibold underline' : 'text-gray-300 hover:text-white' ?>">
             Manage Users
          </a>
        <?php else: ?>
          <!-- Player Nav -->
           <a href="<?= site_url('/snake') ?>" 
             class="<?= ($current == '/snake') ? 'text-green-400 font-semibold underline' : 'text-gray-300 hover:text-white' ?>">
             Play
          </a>
          <a href="<?= site_url('/my-scores') ?>" 
             class="<?= ($current == '/my-scores') ? 'text-green-400 font-semibold underline' : 'text-gray-300 hover:text-white' ?>">
             My Scores
          </a>
        <?php endif; ?>

        <!-- Always show -->
        <a href="<?= site_url('/leaderboard') ?>" 
            class="<?= ($current == '/leaderboard') ? 'text-green-400 font-semibold underline' : 'text-gray-300 hover:text-white' ?>">
             Leaderboard
        </a>
        <a href="<?= site_url('/profile') ?>" 
            class="<?= ($current == '/profile') ? 'text-green-400 font-semibold underline' : 'text-gray-300 hover:text-white' ?>">
             Profile
        </a>
        <a href="<?= site_url('auth/logout') ?>" class="text-red-400 hover:text-red-300">Logout</a>
      </div>
    </div>
  </div>
</nav>
