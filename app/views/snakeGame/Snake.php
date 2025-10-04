<!-- FileName: Snake.php
 * Author: Pratibha Natani
 * Description: This file contains the Main game logic. Contains the php and javascript code.
 * References:
 * http://www.tizag.com/phpT/forms.php
 * http://www.w3schools.com/js/js_objects.asp
 * http://odhyan.com/blog/2010/10/snake-in-javascript/
 -->
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Snake Game</title>
		<script src="https://cdn.tailwindcss.com"></script>
		<style>
			/* Snake + Food blocks */
			.snake {
			position: absolute;
			width: 20px;
			height: 20px;
			background-color: #22c55e; /* Tailwind green-500 */
			border-radius: 4px;
			}
			.food {
			position: absolute;
			width: 20px;
			height: 20px;
			background-color: #ef4444; /* Tailwind red-500 */
			border-radius: 50%;
			}
			#Board {
			position: relative;
			margin: auto;
			background-color: #111827; /* Tailwind gray-900 */
			border: 2px solid #374151; /* Tailwind gray-700 */
			}

			#snake0 {
			width: 20px;
			height: 20px;
			position: absolute;
			/* let JS set clip-path/rotation/eyes for the head */
			}

		</style>
	</head>
 

 <body class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-black text-white">

  <!-- Title -->
  <h1 class="text-4xl font-bold text-green-400 mb-6">🐍 Snake Game</h1>

  <!-- Score -->
  <div class="flex items-center space-x-3 mb-4">
    <span class="text-lg font-semibold">Score:</span>
    <input
      type="text"
      id="scoreText"
      value="0"
      readonly
      class="w-20 text-center font-bold text-green-400 bg-gray-800 border border-gray-600 rounded-lg"
    />
  </div>

  <!-- Game Board -->
  <div id="Board" class="rounded-lg shadow-lg"></div>

  <!-- Optional Back Button -->
  <div class="mt-1">
    <a href="<?= site_url('snake')?>" class="px-5 py-2 bg-green-500 hover:bg-green-600 text-black font-semibold rounded-lg transition">
      ← Back to Menu
    </a>
  </div>
</body>

<script type="text/javascript">
 
	var cellSize = 20; // size of snake and food blocks
	var Score = 0;
	var snakePart = 2;
	var snakeDead = false;
	var moveOne = true;

	// get board size from PHP
	var SnakePace   = <?= json_encode($gameState['SnakePace']) ?>;
    var Goals       = <?= json_encode($gameState['Goals']) ?>;
    var BoardSize1x = parseInt(<?= json_encode($gameState['BoardSizex']) ?>, 10);
    var BoardSize1y = parseInt(<?= json_encode($gameState['BoardSizey']) ?>, 10);
	const boardSize = "<?= $gameState['BoardSizex'] . 'x' . $gameState['BoardSizey'] ?>";

	document.getElementById('Board').style.height = BoardSize1y + "px";
	document.getElementById('Board').style.width = BoardSize1x + "px";

	
			//flag set to not draw the food again and again on timer
			firstDraw=false;        
			function drawFood() {			    
				
			    if(!firstDraw)
				{
				for(k=1;k<=Goals;k++)
				{
					callFood(k);
				}				
				firstDraw=true;
				}
				
			}

			function isCellOccupied(x, y) {
				// x,y are numbers (pixels, multiples of cellSize)
				var px = x + "px";
				var py = y + "px";
				for (let i = 0; i <= snakePart; i++) {
					let el = document.getElementById("snake" + i);
					if (!el) continue;
					if (el.style.left === px && el.style.top === py) return true;
				}
				return false;
			}


			function createSnakePart(id, x, y) {
				var part = document.createElement("div");
				part.className = "snake";
				part.id = "snake" + id;
				part.style.width  = cellSize + "px";
				part.style.height = cellSize + "px";
				part.style.left   = x + "px";
				part.style.top    = y + "px";
				document.getElementById("Board").appendChild(part);
			}


			createSnakePart(0, 60, 60);
			createSnakePart(1, 40, 60);
			createSnakePart(2, 20, 60);

			drawFood();

			function callFood(k) {
				var attempts = 0;
				var maxAttempts = 1000;
				var foodX, foodY;

				do {
					foodX = randomNumbergen(0, BoardSize1x - cellSize);
					foodX = foodX - (foodX % cellSize);
					foodY = randomNumbergen(0, BoardSize1y - cellSize);
					foodY = foodY - (foodY % cellSize);
					attempts++;
					if (attempts > maxAttempts) {
					console.warn("Could not find empty cell for food (board may be full).");
					break;
					}
				} while (isCellOccupied(foodX, foodY));

				var food = document.createElement("div");
				food.className = "food";
				food.id = "food" + k;
				food.style.width = cellSize + "px";
				food.style.height = cellSize + "px";
				food.style.left = foodX + "px";
				food.style.top  = foodY + "px";
				document.getElementById("Board").appendChild(food);
			}


			
			function redrawFood(k) {			    
				callFood(k);

				// update score display
				var changer = document.getElementById('scoreText');	
				changer.value = Score;

				return;		
			}


			
			//generates a random number between range x,y
			function randomNumbergen(x, y){
				return Math.floor(Math.random() * y) + x; 
		    }
			
			function Snake() {
				this.x = 60;
				this.y = 60;
				this.dir = 'R';
			}

			Snake.prototype.changeDir = function(dir) {
				this.dir = dir;
			};

			// ---- head helper: triangle + rotation + eyes ----
			function applyHeadShapeAndRotation(dir) {
				const head = document.getElementById('snake0');
				if (!head) return;

				// base style
				head.style.width = cellSize + 'px';
				head.style.height = cellSize + 'px';
				head.style.background = '#22c55e';
				head.style.clipPath = 'polygon(25% 0%, 75% 0%, 100% 100%, 0% 100%)'; // trapezoid
				head.style.borderRadius = '30%';
				head.style.position = 'absolute';
				head.style.transformOrigin = '50% 50%';
				head.style.overflow = 'visible';

				// rotation
				dir = (dir || 'right').toString().toLowerCase();
				let deg = 90; // default right
				if (dir === 'up' || dir === 'u') deg = 0;
				else if (dir === 'right' || dir === 'r') deg = 90;
				else if (dir === 'down' || dir === 'd') deg = 180;
				else if (dir === 'left' || dir === 'l') deg = 270;
				head.style.transform = 'rotate(' + deg + 'deg)';

				// add eyes once
				if (!head.querySelector('.eye')) {
					const eyeSize = Math.max(4, Math.round(cellSize / 5));
					const pupilSize = Math.max(2, Math.round(eyeSize / 2));

					const makeEye = (cls, leftPercent) => {
						const eye = document.createElement('div');
						eye.className = 'eye ' + cls;
						Object.assign(eye.style, {
							position: 'absolute',
							width: eyeSize + 'px',
							height: eyeSize + 'px',
							background: '#fff',
							borderRadius: '50%',
							left: (cellSize * leftPercent) + 'px',
							top: (cellSize * 0.18) + 'px',
							display: 'flex',
							alignItems: 'center',
							justifyContent: 'center'
						});
						// pupil
						const pupil = document.createElement('div');
						Object.assign(pupil.style, {
							width: pupilSize + 'px',
							height: pupilSize + 'px',
							background: '#000',
							borderRadius: '50%'
						});
						eye.appendChild(pupil);
						return eye;
					};

					head.appendChild(makeEye('eyeL', 0.22));
					head.appendChild(makeEye('eyeR', 0.58));
				}

				// add tongue once
				if (!head.querySelector('.tongue')) {
					const tongue = document.createElement('div');
					tongue.className = 'tongue';
					Object.assign(tongue.style, {
						position: 'absolute',
						width: Math.round(cellSize * 0.2) + 'px',
						height: Math.round(cellSize * 0.8) + 'px',
						background: 'red',
						left: (cellSize * 0.4) + 'px',
						top: (-Math.round(cellSize * 0.6)) + 'px',
						borderRadius: '2px',
						zIndex: -1,
						transformOrigin: 'center bottom',
						animation: 'flick 1s infinite'
					});

					// forked end (two prongs)
					tongue.style.clipPath = 'polygon(0 0, 40% 80%, 50% 100%, 60% 80%, 100% 0)';

					head.appendChild(tongue);

					// inject flicker animation into stylesheet
					if (!document.getElementById('tongueAnim')) {
						const style = document.createElement('style');
						style.id = 'tongueAnim';
						style.innerHTML = `
						@keyframes flick {
							0%, 100% { transform: scaleY(0.1) translateY(0); opacity: 0; }
							20% { transform: scaleY(1) translateY(-4px); opacity: 1; }
							40% { transform: scaleY(0.7) translateY(-2px); opacity: 0.8; }
							60% { transform: scaleY(1) translateY(-5px); opacity: 1; }
							80% { transform: scaleY(0.3) translateY(-1px); opacity: 0.4; }
						}
						`;
						document.head.appendChild(style);
					}
				}
			}


			Snake.prototype.draw = function() {
				if (snakeDead) return false;

				// boundary check
				if (this.x < 0 || this.x >= BoardSize1x ||
					this.y < 0 || this.y >= BoardSize1y) {
					return false;
				}

				// move tail segments forward
				for (let i = snakePart; i > 0; i--) {
					document.getElementById("snake" + i).style.left =
						document.getElementById("snake" + (i - 1)).style.left;
					document.getElementById("snake" + i).style.top =
						document.getElementById("snake" + (i - 1)).style.top;
				}

				// move head
				document.getElementById("snake0").style.left = this.x + "px";
				document.getElementById("snake0").style.top = this.y + "px";

				// update head appearance using the existing global `direction` variable
				applyHeadShapeAndRotation(direction);

				if (!moveOne) {
					// check collision with self
					for (let i = snakePart; i > 0; i--) {
						let seg = document.getElementById("snake" + i);
						if (!seg) continue;
						let sx = parseInt(seg.style.left, 10);
						let sy = parseInt(seg.style.top, 10);
						if (sx === this.x && sy === this.y) {
							snakeDead = true;
							break;
						}
					}

					// check food collision
					for (let i = 1; i <= Goals; i++) {
						// when snake eats food:
							let food = document.getElementById("food" + i);
							if (food && parseInt(food.style.left, 10) === this.x &&
									parseInt(food.style.top, 10) === this.y) {

							// get current tail position (before growing)
							var tailEl = document.getElementById("snake" + snakePart);
							var tailX = tailEl ? parseInt(tailEl.style.left, 10) : this.x;
							var tailY = tailEl ? parseInt(tailEl.style.top, 10) : this.y;

							// grow
							snakePart++;
							createSnakePart(snakePart, tailX, tailY);

							// remove eaten food and respawn
							food.remove();
							Score += 10;
							document.getElementById("scoreText").value = Score;
							callFood(i);

							// speed up
							if (Score > 0 && Score % 100 === 0) {
								SnakePace = Math.max(50, SnakePace - 10);
								clearInterval(timer);
								timer = setInterval(() => mrSnake.move(), SnakePace);
							}
						}

					}
				}

				moveOne = false;
				return true;
			};

			let direction = "right";       // Current direction
			let nextDirection = "right";   // Buffer for the next direction
			let changingDirection = false; // Prevent multiple turns in one frame

			Snake.prototype.move = function() {
				// Apply buffered direction
				if (nextDirection) {
					this.dir = nextDirection[0].toUpperCase(); // "up" → "U", etc.
					direction = nextDirection; // lock in as the current direction
				}
				changingDirection = false; // allow new input next frame

				switch (this.dir) {
					case 'L': this.x -= cellSize; break;
					case 'U': this.y -= cellSize; break;
					case 'R': this.x += cellSize; break;
					case 'D': this.y += cellSize; break;
				}

				let alive = this.draw();
				if (!alive) {
					clearInterval(timer);
					
					gameOver(Score);

					return;
				}
			};

			function gameOver(finalScore) {
				alert("Game Over! Final score: " + finalScore);

				fetch("<?= site_url('snake/save_score') ?>", {
					method: "POST",
					headers: {
						"Content-Type": "application/json",
					},
					body: JSON.stringify({
						score: finalScore,
						board_size: boardSize // 👈 now properly defined
					}),
				})
				.then(res => res.json())
				.then(data => {
					console.log("Score saved:", data);
					window.location.href = "<?= site_url('snake') ?>";
				})
				.catch(err => {
					console.error("Error saving score:", err);
					window.location.href = "<?= site_url('snake') ?>";
				});
			}

            var mrSnake = new Snake();

			document.addEventListener("keydown", (e) => {
				if (changingDirection) return; // Already queued a move for this frame

				if (e.key === "ArrowUp" && direction !== "down") {
					nextDirection = "up";
					changingDirection = true;
				} else if (e.key === "ArrowDown" && direction !== "up") {
					nextDirection = "down";
					changingDirection = true;
				} else if (e.key === "ArrowLeft" && direction !== "right") {
					nextDirection = "left";
					changingDirection = true;
				} else if (e.key === "ArrowRight" && direction !== "left") {
					nextDirection = "right";
					changingDirection = true;
				}
			});


			// start game loop
			var timer = setInterval(() => mrSnake.move(), SnakePace);

		
</script>

  
</html>
