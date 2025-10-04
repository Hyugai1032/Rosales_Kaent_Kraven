<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-black text-gray-100 min-h-screen flex flex-col">
    <!-- Navbar -->
    <header class="bg-gray-800 shadow-lg">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-green-400"><a href="<?= site_url('/auth/dashboard') ?>">🐍 Snake Game</a></h1>
        <?php $this->call->view('/nav'); ?>
        </div>
    </header>
    <main class="flex-1 max-w-3xl mx-auto px-6 py-10 text-gray-200">
        <h2 class="text-2xl font-bold mb-6 text-green-400">Manage Profile</h2>

        <?php if (!empty($error)): ?>
            <div class="bg-red-500 text-white p-3 rounded mb-4">
            <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data" class="space-y-6 bg-gray-800 p-6 rounded-lg shadow-lg">

            <div>
            <label class="block mb-2">Username</label>
            <input type="text" name="username" value="<?= html_escape($user['username']) ?>"
                    class="w-full p-2 rounded bg-gray-900 text-white border border-gray-700">
            </div>

            <div>
            <label class="block mb-2">Email</label>
            <input type="email" name="email" value="<?= html_escape($user['email']) ?>"
                    class="w-full p-2 rounded bg-gray-900 text-white border border-gray-700">
            </div>

            <div>
            <label class="block mb-2">New Password (leave blank if unchanged)</label>
            <input type="password" name="password"
                    class="w-full p-2 rounded bg-gray-900 text-white border border-gray-700">
            </div>

            <div>
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded shadow">
                Save Changes
            </button>
            </div>
        </form>
    </main>

</body>
</html>