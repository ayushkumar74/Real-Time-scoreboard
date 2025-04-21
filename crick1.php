<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sports_scoreboard";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize game state if not already set
if (!isset($_SESSION['runs'])) {
    $_SESSION['runs'] = 0;
    $_SESSION['balls'] = 0;
    $_SESSION['wickets'] = 0;
    $_SESSION['team_name'] = '';
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Handle reset
    if (isset($_POST['reset'])) {
        $_SESSION['runs'] = 0;
        $_SESSION['balls'] = 0;
        $_SESSION['wickets'] = 0;
        $_SESSION['team_name'] = '';
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    
    // Handle score storage
    if (isset($_POST['save_score']) && !empty($_POST['team_name'])) {
        $team_name = $_POST['team_name'];
        $runs = $_SESSION['runs'];
        $wickets = $_SESSION['wickets'];
        $overs = floor($_SESSION['balls'] / 6) . '.' . ($_SESSION['balls'] % 6);
        $username = $_SESSION['username'];
        
        $sql = "INSERT INTO cricket_scores (team_name, runs, wickets, overs, username, created_at) 
                VALUES ('$team_name', $runs, $wickets, '$overs', '$username', NOW())";
        
        if ($conn->query($sql) === TRUE) {
            $_SESSION['score_saved'] = true;
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }

    // Check if game is over
    $game_over = $_SESSION['balls'] >= 60 || $_SESSION['wickets'] >= 10;

    // Only update score if game is NOT over
    if (!$game_over) {
        if (isset($_POST['1'])) {
            $_SESSION['runs'] += 1;
            $_SESSION['balls'] += 1;
        }
        if (isset($_POST['2'])) {
            $_SESSION['runs'] += 2;
            $_SESSION['balls'] += 1;
        }
        if (isset($_POST['3'])) {
            $_SESSION['runs'] += 3;
            $_SESSION['balls'] += 1;
        }
        if (isset($_POST['4'])) {
            $_SESSION['runs'] += 4;
            $_SESSION['balls'] += 1;
        }
        if (isset($_POST['6'])) {
            $_SESSION['runs'] += 6;
            $_SESSION['balls'] += 1;
        }
        if (isset($_POST['dot'])) {
            $_SESSION['balls'] += 1;
        }
        if (isset($_POST['wicket'])) {
            $_SESSION['wickets'] += 1;
            $_SESSION['balls'] += 1;
        }
        if (isset($_POST['wide']) || isset($_POST['no_ball'])) {
            $_SESSION['runs'] += 1;
        }
    }
}

// Retrieve current game state
$runs = $_SESSION['runs'];
$balls = $_SESSION['balls'];
$wickets = $_SESSION['wickets'];
$score_saved = isset($_SESSION['score_saved']) ? $_SESSION['score_saved'] : false;

$overs = floor($balls / 6);
$balls_in_over = $balls % 6;
$game_over = $balls >= 60 || $wickets >= 10;

// Clear the score saved message after showing it once
if ($score_saved) {
    unset($_SESSION['score_saved']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🏏 Cricket Scoreboard</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url("https://i.pinimg.com/736x/11/4a/87/114a87e284917ee095c31695ff8cbd4a.jpg");
            background-size: cover;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding-top: 50px;
        }

        .scoreboard-container {
            background-color: rgba(31, 41, 55 );
            padding: 30px;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            color: white;
            text-align: center;
        }

        h1 {
            color: #facc15;
            margin-bottom: 25px;
        }

        .score-box {
            background: black;
            border: 2px solid #374151;
            color: #fcd34d;
            font-size: 32px;
            margin: 10px auto;
            padding: 15px 0;
            border-radius: 8px;
            width: 60%;
        }

        .btn {
            background-color: rgb(160, 160, 160);
            color: black;
            padding: 10px 16px;
            margin: 6px;
            font-size: 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #d1d5db;
        }

        #reset {
            background-color: #ef4444;
            color: white;
        }

        #save {
            background-color: #10b981;
            color: white;
        }

        .result {
            font-size: 18px;
            margin-top: 15px;
            color: #facc15;
        }

        .save-form {
            margin-top: 20px;
            padding: 15px;
            background-color: #1f2937;
            border-radius: 8px;
        }

        .save-form input {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #4b5563;
            margin-right: 10px;
            width: 200px;
        }

        @media (max-width: 500px) {
            .btn {
                width: 45%;
                margin: 5px 2%;
            }

            .score-box {
                width: 90%;
            }
            
            .save-form input {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>

<div class="scoreboard-container">
    <h1>🏏 Cricket Scoreboard</h1>

    <div class="score-box">Score/Wickets: <?= $runs ?> / <?= $wickets ?></div>
    <div class="score-box">Overs: <?= $overs ?>.<?= $balls_in_over ?></div>
    <div class="score-box">Balls: <?= $balls ?></div>

    <?php if ($game_over): ?>
        <div class="result">🏁 Game Over! Final Score: <?= $runs ?>/<?= $wickets ?> in <?= $overs ?>.<?= $balls_in_over ?> overs.</div>
    <?php endif; ?>

    <?php if ($score_saved): ?>
        <div class="result" style="color: #10b981;">Score saved successfully!</div>
    <?php endif; ?>

    <form method="POST">
        <div>
            <button class="btn" name="1" <?= $game_over ? 'disabled' : '' ?>>1</button>
            <button class="btn" name="2" <?= $game_over ? 'disabled' : '' ?>>2</button>
            <button class="btn" name="3" <?= $game_over ? 'disabled' : '' ?>>3</button>
            <button class="btn" name="4" <?= $game_over ? 'disabled' : '' ?>>🏃‍♂️ 4</button>
            <button class="btn" name="6" <?= $game_over ? 'disabled' : '' ?>>💥 6</button>
        </div>
        <div>
            <button class="btn" name="dot" <?= $game_over ? 'disabled' : '' ?>>• Dot</button>
            <button class="btn" name="wicket" <?= $game_over ? 'disabled' : '' ?>>☠️ Wicket</button>
            <button class="btn" name="wide" <?= $game_over ? 'disabled' : '' ?>>➕ Wide</button>
            <button class="btn" name="no_ball" <?= $game_over ? 'disabled' : '' ?>>➕ No Ball</button>
        </div>
        <div>
            <button class="btn" id="reset" name="reset">🔁 Reset</button>
        </div>
    </form>

    <?php if ($game_over && !$score_saved): ?>
        <div class="save-form">
            <form method="POST">
                <input type="text" name="team_name" placeholder="Enter team name" required>
                <button class="btn" id="save" name="save_score">💾 Save Score</button>
            </form>
        </div>
    <?php endif; ?>
</div>

</body>
</html>