<?php
    // Defensive defaults so the view never breaks if controller forgot to pass values
    $board_size  = $board_size  ?? '';        // string like "300x400" or empty
    $board_sizes = $board_sizes ?? [];        // array of rows or simple strings

    // Normalize $board_sizes to a simple list of strings: ['300x400','400x500', ...]
    $bs_list = [];
    foreach ($board_sizes as $bs) {
        if (is_array($bs)) {
            // DB row like ['board_size' => '300x400']
            if (isset($bs['board_size'])) $bs_list[] = $bs['board_size'];
        } else {
            // already a simple string
            $bs_list[] = (string)$bs;
        }
    }
    $board_sizes = array_values(array_unique($bs_list));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Scores</title>
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
    <main class="flex-1 max-w-4xl mx-auto px-6 py-10">
        <h2 class="text-xl font-bold mb-4 text-green-400 text-center">My Scores</h2>

        <form method="get" class="mb-4">
            <label for="board_size" class="text-white mr-2">Filter by Board Size:</label>
            <select name="board_size" id="board_size" onchange="this.form.submit()" class="bg-gray-800 text-white p-2 rounded">
                <option value="" <?= ($board_size === '') ? 'selected' : '' ?>>All</option>

                <?php if (!empty($board_sizes)): ?>
                <?php foreach ($board_sizes as $val): 
                        $label = str_replace('x', ' x ', $val); // "300x400" -> "300 x 400"
                ?>
                    <option value="<?= html_escape($val) ?>" <?= ($board_size === $val) ? 'selected' : '' ?>>
                    <?= html_escape($label) ?>
                    </option>
                <?php endforeach; ?>
                <?php else: ?>
                <!-- fallback hard-coded options -->
                <option value="300x400" <?= ($board_size === '300x400') ? 'selected' : '' ?>>300 x 400</option>
                <option value="400x500" <?= ($board_size === '400x500') ? 'selected' : '' ?>>400 x 500</option>
                <option value="500x500" <?= ($board_size === '500x500') ? 'selected' : '' ?>>500 x 500</option>
                <option value="500x600" <?= ($board_size === '500x600') ? 'selected' : '' ?>>500 x 600</option>
                <option value="600x600" <?= ($board_size === '600x600') ? 'selected' : '' ?>>600 x 600</option>
                <option value="700x600" <?= ($board_size === '700x600') ? 'selected' : '' ?>>700 x 600</option>
                <?php endif; ?>
            </select>
        </form>

        <table class="min-w-full table-auto border-collapse">
            <thead class="bg-gray-700 text-indigo-300 uppercase text-sm">
                <tr>
                    <th class="p-2">Rank</th>
                    <th class="p-2">Score</th>
                    <th class="p-2">Board Size</th>
                    <th class="p-2">Played At</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700 text-center">
                <?php foreach ($scores as $i => $row): ?>
                    <tr>
                        <td class="p-2 text-center"><?= ($start_rank ?? 0) + $i + 1 ?></td>
                        <td class="p-2 text-center"><?= $row['score'] ?></td>
                        <td class="p-2 text-center"><?= html_escape($row['board_size']) ?></td>
                        <td class="p-2 text-center"><?= $row['created_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>

        <div class="mt-6">
            <?= $page_links ?? '' ?>
        </div>
    </main>
    <?php $this->call->view('footer') ?>

</body>
</html>