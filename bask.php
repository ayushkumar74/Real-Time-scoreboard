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

// Initialize scores if not already set
if (!isset($_SESSION['home'])) $_SESSION['home'] = 0;
if (!isset($_SESSION['guest'])) $_SESSION['guest'] = 0;
if (!isset($_SESSION['score_saved'])) $_SESSION['score_saved'] = false;

// Update scores
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle score storage
    if (isset($_POST['save_score']) && !empty($_POST['team_name'])) {
        $team_name = $_POST['team_name'];
        $points = $_SESSION['home'];
        $opponent_points = $_SESSION['guest'];
        $username = $_SESSION['username'];
        
        $sql = "INSERT INTO basketball_scores (team_name, points, opponent_points, username, created_at) 
                VALUES ('$team_name', $points, $opponent_points, '$username', NOW())";
        
        if ($conn->query($sql) === TRUE) {
            $_SESSION['score_saved'] = true;
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }
    
    if (isset($_POST['reset'])) {
        $_SESSION['home'] = 0;
        $_SESSION['guest'] = 0;
        $_SESSION['score_saved'] = false;
    } elseif (isset($_POST['home_score'])) {
        $_SESSION['home'] += intval($_POST['home_score']);
    } elseif (isset($_POST['guest_score'])) {
        $_SESSION['guest'] += intval($_POST['guest_score']);
    }
}

$score_saved = $_SESSION['score_saved'];
if ($score_saved) {
    unset($_SESSION['score_saved']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>🏀 Basketball Scoreboard</title>
    <style>
        @font-face {
            font-family: CursedTimerULiLFont;
            src: url('CursedTimerUlil-Aznm.ttf');
        }

        body {
            background-image:url("https://media.istockphoto.com/id/1140091936/photo/old-basketball-dirty-texture-for-sport-grunge-background.jpg?s=612x612&w=0&k=20&c=NRlyYgscoDSIc4sV5wbmfhGSk6qVaSC2JktInAQU5zw=");
            background-size: cover;
            margin: 0;
            padding: 0;
            color: white;
            font-family: CursedTimerULiLFont, sans-serif;
        }

        h1 {
            background-color: black;
            color: white;
            font-size: 60px;
            padding: 20px 0;
            text-align: center;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            background-color: #1F2937;
            margin: 30px 500px;
            border-radius: 15px;
        }

        .team {
            text-align: center;
            margin: 0 30px;
        }

        .score-box {
            font-size: 60px;
            background-color: white;
            color: black;
            width: 100px;
            height: 100px;
            margin: 20px auto;
            border-radius: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn {
            display: block;
            margin: 8px auto;
            padding: 10px 15px;
            font-size: 18px;
            background-color: #e91e63;
            border: none;
            border-radius: 10px;
            color: white;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .btn:hover {
            background-color: #ff4081;
        }

        .control-buttons {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .control-buttons button {
            background-color: #3f51b5;
            border: none;
            padding: 15px 30px;
            margin: 0 10px;
            border-radius: 10px;
            font-size: 18px;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }

        .control-buttons button:hover {
            background-color: #5c6bc0;
        }

        .point-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }

        .point-buttons form {
            display: inline;
        }

        .save-form {
            margin-top: 20px;
            text-align: center;
        }

        .save-form input {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 10px;
        }

        .save-btn {
            background-color: #4CAF50 !important;
        }

        .saved-message {
            color: #4CAF50;
            font-size: 18px;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

    <h1>🏀 Basketball Scoreboard</h1>

    <div class="container">
        <!-- HOME TEAM -->
        <div class="team">
            <h2>Team-1</h2>
            <div class="score-box"><?= $_SESSION['home'] ?></div>
            <div class="point-buttons">
                <form method="post"><button class="btn" name="home_score" value="1">+1</button></form>
                <form method="post"><button class="btn" name="home_score" value="2">+2</button></form>
                <form method="post"><button class="btn" name="home_score" value="3">+3</button></form>
            </div>
        </div>

        <!-- GUEST TEAM -->
        <div class="team">
            <h2>Team-2</h2>
            <div class="score-box"><?= $_SESSION['guest'] ?></div>
            <div class="point-buttons">
                <form method="post"><button class="btn" name="guest_score" value="1">+1</button></form>
                <form method="post"><button class="btn" name="guest_score" value="2">+2</button></form>
                <form method="post"><button class="btn" name="guest_score" value="3">+3</button></form>
            </div>
        </div>
    </div>

    <div class="control-buttons">
        <form method="post">
            <button type="submit" name="reset">🔁 Restart Game</button>
        </form>
    </div>

    <?php if (!$score_saved): ?>
    <div class="save-form">
        <form method="post">
            <input type="text" name="team_name" placeholder="Enter Team-1 name" required>
            <button class="btn save-btn" name="save_score">💾 Save Score</button>
        </form>
    </div>
    <?php else: ?>
    <div class="saved-message">
        Score saved successfully!
    </div>
    <?php endif; ?>

</body>
</html>
<?php
$conn->close();
?>