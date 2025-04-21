<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Initialize session variables
if (!isset($_SESSION['homeScore'])) {
    $_SESSION['homeScore'] = 0;
    $_SESSION['guestScore'] = 0;
    $_SESSION['period'] = 1; // Start with period 1 (first half)
    $_SESSION['isFinal'] = false;
}

// Process form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Home team scoring
    if (isset($_POST['home_goal'])) $_SESSION['homeScore'] += 1;
    if (isset($_POST['home_penalty'])) $_SESSION['homeScore'] += 1; // Penalty is worth 1
    if (isset($_POST['home_freekick'])) $_SESSION['homeScore'] += 1; // Free kick is worth 1
    
    // Guest team scoring
    if (isset($_POST['guest_goal'])) $_SESSION['guestScore'] += 1;
    if (isset($_POST['guest_penalty'])) $_SESSION['guestScore'] += 1;
    if (isset($_POST['guest_freekick'])) $_SESSION['guestScore'] += 1;
    
    // Match progression
    if (isset($_POST['end_period'])) {
        if ($_SESSION['period'] < 2) {
            $_SESSION['period'] += 1; // Move to next half
        } elseif ($_SESSION['period'] == 2) {
            $_SESSION['period'] = 3; // First extra time
        } elseif ($_SESSION['period'] == 3) {
            $_SESSION['period'] = 4; // Second extra time
        } else {
            $_SESSION['isFinal'] = true; // Match ended
        }
    }
    
    // Reset game
    if (isset($_POST['new_game'])) {
        $_SESSION['homeScore'] = 0;
        $_SESSION['guestScore'] = 0;
        $_SESSION['period'] = 1;
        $_SESSION['isFinal'] = false;
    }
}

// Determine period name
$periodName = match($_SESSION['period']) {
    1 => '1st Half',
    2 => '2nd Half',
    3 => 'ET 1st Half',
    4 => 'ET 2nd Half',
    default => 'Match Ended'
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>⚽ Football Scoreboard</title>
    <style>
        @font-face {
            font-family: 'CursedTimerULiLFont';
            src: url('CursedTimerUlil-Aznm.ttf');
        }

        body {
            background-image: url("https://i.pinimg.com/474x/5c/d1/f8/5cd1f8aef91e8f8a42fdcda56a971bd7.jpg");
            background-size: cover;
            margin: 0;
            padding: 0;
            color: white;
            font-family: 'CursedTimerULiLFont', sans-serif;
            min-height: 100vh;
        }

        h1 {
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            font-size: 3rem;
            padding: 20px 0;
            text-align: center;
            margin: 0;
            border-bottom: 3px solid #e91e63;
        }

        .container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 2rem;
            background-color: rgba(31, 41, 55, 0.9);
            margin: 2rem auto;
            max-width: 800px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            border: 2px solid #3f51b5;
        }

        .team {
            text-align: center;
            padding: 1rem;
            flex: 1;
        }

        .team h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #ff9800;
        }

        .score-box {
            font-size: 5rem;
            background-color: #111;
            color: #f44336;
            width: 150px;
            height: 150px;
            margin: 1rem auto;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 3px solid #e91e63;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            font-size: 1rem;
            background-color: #e91e63;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }

        .btn:hover {
            background-color: #ff4081;
            transform: translateY(-2px);
        }

        .period-section {
            text-align: center;
            padding: 1rem;
            min-width: 150px;
        }

        .period-section h2 {
            font-size: 1.5rem;
            color: #4caf50;
            margin-bottom: 0.5rem;
        }

        .period-box {
            font-size: 2rem;
            background-color: #111;
            color: white;
            padding: 1rem;
            border-radius: 10px;
            margin: 0 auto;
            border: 2px solid #4caf50;
        }

        .control-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
        }

        .control-btn {
            background-color: #3f51b5;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            font-size: 1rem;
            color: white;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }

        .control-btn:hover {
            background-color: #5c6bc0;
            transform: translateY(-2px);
        }

        .final-message {
            text-align: center;
            font-size: 1.5rem;
            color: #ffeb3b;
            margin-top: 1rem;
            font-weight: bold;
            text-shadow: 0 0 5px rgba(0, 0, 0, 0.8);
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                padding: 1rem;
            }
            
            .team {
                width: 100%;
                margin-bottom: 1rem;
            }
            
            .period-section {
                order: -1;
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <h1>⚽ Football Scoreboard</h1>

    <form method="POST">
        <div class="container">
            <div class="team">
                <h2>Home Team</h2>
                <div class="score-box"><?= $_SESSION['homeScore'] ?></div>
                <div class="btn-group">
                    <button class="btn" name="home_goal" <?= $_SESSION['isFinal'] ? 'disabled' : '' ?>>Goal ⚽ (+1)</button>
                    <button class="btn" name="home_penalty" <?= $_SESSION['isFinal'] ? 'disabled' : '' ?>>Penalty 🎯 (+1)</button>
                    <button class="btn" name="home_freekick" <?= $_SESSION['isFinal'] ? 'disabled' : '' ?>>Free Kick 🎯 (+1)</button>
                </div>
            </div>

            <div class="period-section">
                <h2><?= $periodName ?></h2>
                <div class="period-box">Period <?= min($_SESSION['period'], 4) ?></div>
                <?php if ($_SESSION['isFinal']): ?>
                    <div class="final-message">MATCH ENDED</div>
                <?php endif; ?>
            </div>

            <div class="team">
                <h2>Away Team</h2>
                <div class="score-box"><?= $_SESSION['guestScore'] ?></div>
                <div class="btn-group">
                    <button class="btn" name="guest_goal" <?= $_SESSION['isFinal'] ? 'disabled' : '' ?>>Goal ⚽ (+1)</button>
                    <button class="btn" name="guest_penalty" <?= $_SESSION['isFinal'] ? 'disabled' : '' ?>>Penalty 🎯 (+1)</button>
                    <button class="btn" name="guest_freekick" <?= $_SESSION['isFinal'] ? 'disabled' : '' ?>>Free Kick 🎯 (+1)</button>
                </div>
            </div>
        </div>

        <div class="control-buttons">
            <button type="submit" class="control-btn" name="new_game">🆕 New Game</button>
            <?php if (!$_SESSION['isFinal']): ?>
                <button type="submit" class="control-btn" name="end_period">
                    <?= $_SESSION['period'] < 4 ? '⏱️ Next Period' : '🏁 End Match' ?>
                </button>
            <?php endif; ?>
        </div>
    </form>
</body>
</html>