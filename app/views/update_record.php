<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin | Update Record</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-black text-gray-100 min-h-screen flex flex-col">
  <header class="bg-gray-800 shadow-lg">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
      <a href="<?= site_url('auth/dashboard')?>"> <h1 class="text-xl font-bold text-green-400">🐍Snake Game Admin</h1> </a>
      <?php $this->call->view('/nav'); ?>
    </div>
  </header>
  <div class="bg-gray-800 rounded-2xl shadow-2xl p-8 w-full max-w-md">
    <h1 class="text-2xl font-bold text-center text-green-400 mb-6">Update User</h1>

    <form action="<?= site_url('update_record/submit') ?>" method="POST" class="space-y-4">
      <input type="hidden" name="id" value="<?= html_escape($record['id']) ?>">

      <div>
        <label for="username" class="block text-sm font-medium text-gray-200">Username:</label>
        <input type="text" name="username" id="username" 
               value="<?= html_escape($record['username']) ?>" 
               class="mt-1 block w-full px-4 py-2 border border-gray-700 rounded-md bg-gray-900 text-gray-100 focus:ring-green-400 focus:border-green-400">
      </div>

      <div>
        <label for="email" class="block text-sm font-medium text-gray-200">Email:</label>
        <input type="email" name="email" id="email" 
               value="<?= html_escape($record['email']) ?>" 
               class="mt-1 block w-full px-4 py-2 border border-gray-700 rounded-md bg-gray-900 text-gray-100 focus:ring-green-400 focus:border-green-400">
      </div>

      <div>
        <label for="role" class="block text-sm font-medium text-gray-200">Role:</label>
        <select name="role" id="role" 
                class="mt-1 block w-full px-4 py-2 border border-gray-700 rounded-md bg-gray-900 text-gray-100 focus:ring-green-400 focus:border-green-400">
          <option value="player" <?= $record['role'] === 'player' ? 'selected' : '' ?>>Player</option>
          <option value="admin" <?= $record['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>
      </div>

      <div class="text-center">
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow">
          Update User
        </button>
      </div>
    </form>
  </div>
  <?php $this->call->view('footer') ?>
</body>

</html>