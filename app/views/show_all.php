<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Users</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-black text-gray-200 font-sans">
  <header class="bg-gray-800 shadow-lg">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
      <a href="<?= site_url('auth/dashboard')?>"> <h1 class="text-xl font-bold text-green-400">🐍Snake Game Admin</h1> </a>
      <?php $this->call->view('/nav'); ?>
    </div>
  </header>

  <div class="max-w-7xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-center text-indigo-400">👤 User Management</h1>

    <!-- Search form -->
    <form action="/admin/manage_users" method="get" class="flex justify-end mb-4">
      <?php $q = isset($_GET['q']) ? $_GET['q'] : ''; ?>
      <input 
        class="bg-gray-800 border border-gray-700 rounded-l px-3 py-2 
               focus:ring-2 focus:ring-indigo-500 focus:outline-none w-64 text-gray-200"
        name="q" type="text" placeholder="Search by username or email" value="<?= html_escape($q); ?>">
      <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-r shadow">
        Search
      </button>
    </form>

    <!-- Users Table -->
    <div class="overflow-x-auto shadow-xl rounded-lg bg-gray-800 border border-gray-700">
      <table class="min-w-full table-auto border-collapse">
        <thead class="bg-gray-700 text-indigo-300 uppercase text-sm">
          <tr>
            <th class="px-4 py-3 text-left">ID</th>
            <th class="px-4 py-3 text-left">Username</th>
            <th class="px-4 py-3 text-left">Email</th>
            <th class="px-4 py-3 text-center">Role</th>
            <th class="px-4 py-3 text-cneter">Created At</th>
            <th class="px-4 py-3 text-center">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-700">
          <?php foreach ($user as $u): ?>
          <tr class="hover:bg-gray-700">
            <td class="px-4 py-2"><?= html_escape($u['id']) ?></td>
            
            <td class="px-4 py-2 font-semibold text-indigo-400"><?= html_escape($u['username']) ?></td>
            <td class="px-4 py-2 text-gray-300"><?= html_escape($u['email']) ?></td>
            
            <!-- Role Badge -->
            <td class="px-4 py-2 text-center">
              <span class="px-2 py-1 rounded text-xs font-semibold tracking-wide
                <?= $u['role'] === 'admin' ? 'bg-red-900 text-red-300' : 'bg-green-900 text-green-300' ?>">
                <?= ucfirst($u['role']) ?>
              </span>
            </td>

            <td class="px-4 py-2 text-gray-400 text-center"><?= date("M d, Y", strtotime($u['created_at'])) ?></td>
            
            <td class="px-4 py-2 text-center">
              <a href="<?= site_url('/update_record/'.$u['id'])?>" 
                 class="text-blue-400 hover:text-blue-300">Update</a> |
              <a href="<?= site_url('/delete_record/'.$u['id'])?>" 
                 class="text-red-400 hover:text-red-300"
                 onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
            </td>
          </tr>
          <?php endforeach;?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
      <?= $page ?>
    </div>

    <!-- Add User Button -->
    <div class="mt-6 text-center">
      <a href="<?= site_url('/add_record')?>">
        <button class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded shadow">
          ➕ Add User
        </button>
      </a>
    </div>
  </div>
    <?php $this->call->view('footer') ?>

</body>


</html>