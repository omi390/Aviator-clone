<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aviator Game</title>
  <style>
    body {
    font-family: 'Arial', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: #f0f0f0;
    margin: 0;
}

.container {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 900px;
    max-width: 90%;
}

header {
    text-align: center;
    margin-bottom: 20px;
}

h1 {
    margin: 0;
    font-size: 2em;
    color: #333;
}

main {
    display: flex;
    flex-direction: column;
    align-items: center;
}

#controls {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 20px;
    width: 100%;
}

#betAmount {
    padding: 10px;
    margin-bottom: 10px;
    font-size: 1em;
    border-radius: 5px;
    border: 1px solid #ccc;
    text-align: center;
    width: calc(100% - 22px);
}

.buttons {
    display: flex;
    justify-content: space-between;
    width: 100%;
}

button {
    background: #3498db;
    color: white;
    border: none;
    padding: 10px 20px;
    margin: 5px;
    font-size: 1em;
    cursor: pointer;
    border-radius: 5px;
    transition: background 0.3s;
    flex: 1;
}

button:hover {
    background: #2980b9;
}

#gameCanvas {
    background: #ecf0f1;
    border: 2px solid #bdc3c7;
    border-radius: 10px;
    width: 100%;
}

  </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Aviator Game</h1>
        </header>
        <main>
            <div id="controls">
                <input type="number" id="betAmount" placeholder="Enter bet amount" min="0" step="0.01">
                <div class="buttons">
                    <button id="startGame">Start Game</button>
                    <button id="cashOut">Cash Out</button>
                </div>
            </div>
            <canvas id="gameCanvas" width="800" height="400"></canvas>
        </main>
    </div>
   <script>
    const canvas = document.getElementById('gameCanvas');
const ctx = canvas.getContext('2d');
const betAmountInput = document.getElementById('betAmount');
const startGameButton = document.getElementById('startGame');
const cashOutButton = document.getElementById('cashOut');

let multiplier = 1.00;
let animationFrame;
let gameStarted = false;
let crashMultiplier;
let betAmount = 0;
let direction = 1; // 1 for up, -1 for down

// Function to generate a random crash multiplier
function generateCrashMultiplier() {
    return (Math.random() * 3 + 1).toFixed(2); // Random multiplier between 1.00 and 4.00
}

// Function to start the game
function startGame() {
    if (gameStarted) return;

    betAmount = parseFloat(betAmountInput.value);
    if (isNaN(betAmount) || betAmount <= 0) {
        alert('Please enter a valid bet amount.');
        return;
    }

    gameStarted = true;
    multiplier = 1.00;
    crashMultiplier = generateCrashMultiplier();
    direction = 1;
    animateMultiplier();
}

// Function to animate the multiplier
function animateMultiplier() {
    if (multiplier >= crashMultiplier) {
        endGame();
        return;
    }

    const change = (Math.random() * 0.02) * direction; // Slow down the change in multiplier
    multiplier += change;
    if (multiplier < 1) {
        multiplier = 1; // Ensure multiplier does not go below 1
        direction = 1; // Change direction to up
    }
    drawGraph();

    // Randomly change direction
    if (Math.random() > 0.95) {
        direction *= -1;
    }

    animationFrame = requestAnimationFrame(animateMultiplier);
}

// Function to end the game
function endGame() {
    cancelAnimationFrame(animationFrame);
    gameStarted = false;
    alert('Game Over! The multiplier crashed at ' + crashMultiplier);
}

// Function to cash out
function cashOut() {
    if (!gameStarted) return;

    const winnings = (betAmount * multiplier).toFixed(2);
    endGame();
    alert(`You cashed out at multiplier: ${multiplier.toFixed(2)}\nTotal winnings: $${winnings}`);
}

// Function to draw the graph
function drawGraph() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    ctx.beginPath();
    ctx.moveTo(0, canvas.height);

    for (let i = 0; i <= multiplier; i += 0.01) {
        const x = (i / 4) * canvas.width; // Scale the x-axis
        const y = canvas.height - (Math.log(i + 1) / Math.log(4)) * canvas.height; // Logarithmic scale for y-axis
        ctx.lineTo(x, y);
    }

    ctx.lineTo(canvas.width, canvas.height);
    ctx.closePath();
    ctx.fillStyle = 'rgba(231, 76, 60, 0.3)';
    ctx.fill();

    ctx.strokeStyle = '#e74c3c';
    ctx.lineWidth = 3;
    ctx.stroke();

    // Draw the multiplier value on the graph
    ctx.fillStyle = '#333';
    ctx.font = '20px Arial';
    ctx.fillText(multiplier.toFixed(2) + 'X', canvas.width - 100, canvas.height - (Math.log(multiplier + 1) / Math.log(4)) * canvas.height - 10);
}

// Event listeners
startGameButton.addEventListener('click', startGame);
cashOutButton.addEventListener('click', cashOut);

   </script>
</body>
</html>
