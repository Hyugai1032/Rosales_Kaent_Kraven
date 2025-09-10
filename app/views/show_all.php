<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Show_all</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">

  <div class="max-w-6xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-center text-indigo-600">Welcome to Show All View</h1>

    <div class="overflow-x-auto shadow-lg rounded-lg bg-white">
      <table class="min-w-full table-auto border-collapse">
        <thead class="bg-indigo-500 text-white">
          <tr>
            <th class="px-4 py-3 text-left">ID</th>
            <th class="px-4 py-3 text-left">First Name</th>
            <th class="px-4 py-3 text-left">Last Name</th>
            <th class="px-4 py-3 text-left">Email</th>
            <th class="px-4 py-3 text-left">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <?php foreach($users as $user): ?>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-2"> <?= html_escape($user['id']) ?></td>
            <td class="px-4 py-2"> <?= html_escape($user['first_name']) ?></td>
            <td class="px-4 py-2"> <?= html_escape($user['last_name']) ?></td>
            <td class="px-4 py-2"> <?= html_escape($user['email']) ?></td>
            <td class="px-4 py-2">
              <a href="<?= site_url('/update_record/'.$user['id'])?>" class="text-blue-600 hover:underline">Update</a> |
              <a href="<?= site_url('/delete_record/'.$user['id'])?>" class="text-red-600 hover:underline">Delete</a>
            </td>
          </tr>
          <?php endforeach;?>
        </tbody>
      </table>
    </div>

    <div class="mt-6 text-center">
      <a href="<?= site_url('/add_record')?>">
        <button class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded shadow">
          Add Records
        </button>
      </a>
    </div>
  </div>

</body>
</html>