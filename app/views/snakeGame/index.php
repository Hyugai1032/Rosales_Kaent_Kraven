<!-- FileName: index.html
 * Author: Pratibha Natani
 * Description: This file designs the main page for the Snake Game
 * References:
 * http://www.tizag.com/phpT/forms.php
 * http://www.w3schools.com/js/js_objects.asp
 -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Snake Game</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-black text-white">
    <div class="w-full max-w-lg p-8 bg-gray-800/80 rounded-2xl shadow-lg">
      <!-- Title -->
      <h1 class="text-4xl font-bold text-center text-green-400 mb-6">
        🐍 Snake Game
      </h1>

      <!-- Game Form -->
      <form
        action="<?= site_url('snake/play') ?>"
        method="post"
        class="space-y-6 text-gray-200"
      >
        <!-- Board Size -->
        <div>
          <label for="BoardSize" class="block text-sm font-medium mb-2 text-gray-300">
            Board Size
          </label>
          <select
            name="BoardSize"
            id="BoardSize"
            class="w-full p-2.5 rounded-lg bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500"
          >
            <option <?= ($defaults['BoardSizex']==300 && $defaults['BoardSizey']==400) ? 'selected' : '' ?>>300 X 400</option>
            <option <?= ($defaults['BoardSizex']==400 && $defaults['BoardSizey']==500) ? 'selected' : '' ?>>400 X 500</option>
            <option <?= ($defaults['BoardSizex']==500 && $defaults['BoardSizey']==500) ? 'selected' : '' ?>>500 X 500</option>
            <option <?= ($defaults['BoardSizex']==500 && $defaults['BoardSizey']==600) ? 'selected' : '' ?>>500 X 600</option>
            <option <?= ($defaults['BoardSizex']==600 && $defaults['BoardSizey']==600) ? 'selected' : '' ?>>600 X 600</option>
            <option <?= ($defaults['BoardSizex']==700 && $defaults['BoardSizey']==600) ? 'selected' : '' ?>>700 X 600</option>
          </select>
        </div>

        <!-- Snake Pace -->
        <div>
          <label for="SnakePace" class="block text-sm font-medium mb-2 text-gray-300">
            Snake Pace
          </label>
          <select
            name="SnakePace"
            id="SnakePace"
            class="w-full p-2.5 rounded-lg bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500"
          >
            <option value="Slow"   <?= ($defaults['SnakePace']==300) ? 'selected' : '' ?>>Slow</option>
            <option value="Medium" <?= ($defaults['SnakePace']==250) ? 'selected' : '' ?>>Medium</option>
            <option value="Fast"   <?= ($defaults['SnakePace']==200) ? 'selected' : '' ?>>Fast</option>
          </select>
        </div>

        <!-- Goals -->
        <div>
          <label for="Goals" class="block text-sm font-medium mb-2 text-gray-300">
            Simultaneous Goals
          </label>
          <select
            name="Goals"
            id="Goals"
            class="w-full p-2.5 rounded-lg bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500"
          >
            <?php foreach ([1,2,3,4,5,10,15] as $goal): ?>
              <option value="<?= $goal ?>" <?= ($defaults['Goals']==$goal) ? 'selected' : '' ?>>
                <?= str_pad($goal, 2, "0", STR_PAD_LEFT) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Play Button -->
        <div class="flex justify-center">
          <input
            type="submit"
            value="Play"
            class="px-6 py-3 rounded-lg bg-green-500 hover:bg-green-600 text-black font-semibold cursor-pointer transition"
          />
        </div>
      </form>


      <!-- Instructions -->
      <div class="mt-10">
        <h2 class="text-xl font-semibold text-green-400 mb-3">
          Game Instructions
        </h2>
        <ul class="list-disc list-inside space-y-1 text-gray-300 text-sm">
          <li>Use <strong>Arrow Keys</strong> to control the snake.</li>
          <li>Eating food will lengthen the snake.</li>
          <li>Colliding with walls or your body/tail ends the game.</li>
          <li>The snake speeds up as you eat more food.</li>
        </ul>
      </div>

      <a href="<?= site_url('auth/dashboard')?>">
        <button class="mt-6 px-6 py-3 rounded-lg bg-green-500 hover:bg-green-600 text-black font-semibold cursor-pointer transition">
          Go Back
        </button>
      </a>

    </div>
  </body>
</html>

