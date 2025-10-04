<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin | Add Record</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<!-- app/Views/add_record.php -->

<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-black text-gray-100 min-h-screen flex flex-col">
  <header class="bg-gray-800 shadow-lg">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
      <a href="<?= site_url('auth/dashboard')?>"> <h1 class="text-xl font-bold text-green-400">🐍Snake Game Admin</h1> </a>
      <?php $this->call->view('/nav'); ?>
    </div>
  </header>
  <div class="max-w-md mx-auto my-auto mt-10 p-6 bg-gray-800 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-center text-indigo-400 mb-6">Add New User</h1>

    <form action="<?= site_url('add_record/submit') ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
      
      <!-- Username -->
      <div>
        <label for="username" class="block text-sm font-medium text-gray-300">Username:</label>
        <input type="text" name="username" id="username" required
               class="mt-1 block w-full px-4 py-2 border border-gray-700 rounded-md shadow-sm bg-gray-700 text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
      </div>

      <!-- Email -->
      <div>
        <label for="email" class="block text-sm font-medium text-gray-300">Email:</label>
        <input type="email" name="email" id="email" required
               class="mt-1 block w-full px-4 py-2 border border-gray-700 rounded-md shadow-sm bg-gray-700 text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
      </div>

      <!-- Password -->
      <div>
        <label for="password" class="block text-sm font-medium text-gray-300">Password:</label>
        <input type="password" name="password" id="password" required
               class="mt-1 block w-full px-4 py-2 border border-gray-700 rounded-md shadow-sm bg-gray-700 text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
      </div>

      <!-- Role -->
      <div>
        <label for="role" class="block text-sm font-medium text-gray-300">Role:</label>
        <select name="role" id="role" required
                class="mt-1 block w-full px-4 py-2 border border-gray-700 rounded-md shadow-sm bg-gray-700 text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
          <option value="player">Player</option>
          <option value="admin">Admin</option>
        </select>
      </div>

      <!-- Submit -->
      <div class="text-center">
        <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded shadow">
          Add User
        </button>
      </div>
    </form>
  </div>
  <?php $this->call->view('footer') ?>
</body>

</html>