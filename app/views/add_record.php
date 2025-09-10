<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add_record</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">

  <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-center text-indigo-600 mb-6">Welcome to Add Record View</h1>

    <form action="<?= site_url('add_record/submit') ?>" method="POST" class="space-y-4">
      <div>
        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name:</label>
        <input type="text" name="first_name" id="first_name" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
      </div>

      <div>
        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name:</label>
        <input type="text" name="last_name" id="last_name" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
      </div>

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
        <input type="email" name="email" id="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
      </div>

      <div class="text-center">
        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded shadow">
          Add Record
        </button>
      </div>
    </form>
  </div>

</body>
</html>