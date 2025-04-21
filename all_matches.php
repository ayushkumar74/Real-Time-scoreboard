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

// Get all matches for the current user from all sports tables
$username = $_SESSION['username'];

// Query for cricket matches
$cricket_sql = "SELECT 'Cricket' as sport, team_name, runs, wickets, overs, created_at 
                FROM cricket_scores 
                WHERE username = '$username'";

// Query for football matches (assuming similar table structure)
$football_sql = "SELECT 'Football' as sport, team_name, goals as runs, NULL as wickets, NULL as overs, created_at 
                FROM football_scores 
                WHERE username = '$username'";

// Query for basketball matches (assuming similar table structure)
$basketball_sql = "SELECT 'Basketball' as sport, team_name, points as runs, NULL as wickets, NULL as overs, created_at 
                  FROM basketball_scores 
                  WHERE username = '$username'";

// Combine all results with UNION
$sql = "($cricket_sql) UNION ($football_sql) UNION ($basketball_sql) ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Matches</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #232526, #414345);
            color: white;
        }

        header {
            background-color: #111;
            padding: 20px 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 50px;
            color: #00ffcc;
            text-shadow: 2px 2px 4px black;
        }

        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
        }

        .match-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .match-table th, .match-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #444;
        }

        .match-table th {
            background-color: #1e1e1e;
            color: #00ffcc;
        }

        .match-table tr:hover {
            background-color: #2a2a2a;
        }

        .no-matches {
            text-align: center;
            padding: 30px;
            font-size: 18px;
            color: #aaa;
        }

        .logout {
            text-align: center;
            margin: 20px;
        }

        .logout a {
            color: #00ffcc;
            text-decoration: none;
            font-weight: bold;
        }

        .sport-icon {
            font-size: 20px;
            margin-right: 5px;
        }

        @media (max-width: 768px) {
            .match-table {
                font-size: 14px;
            }
            
            .match-table th, .match-table td {
                padding: 8px 10px;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>📊 All Matches</h1>
</header>

<div class="container">
    <?php if ($result->num_rows > 0): ?>
        <table class="match-table">
            <thead>
                <tr>
                    <th>Sport</th>
                    <th>Team Name</th>
                    <th>Score</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php 
                                $icon = '';
                                if ($row['sport'] == 'Cricket') {
                                    $icon = '🏏';
                                } elseif ($row['sport'] == 'Football') {
                                    $icon = '⚽';
                                } elseif ($row['sport'] == 'Basketball') {
                                    $icon = '🏀';
                                }
                                echo '<span class="sport-icon">'.$icon.'</span>'.htmlspecialchars($row['sport']);
                            ?>
                        </td>
                        <td><?= htmlspecialchars($row['team_name']) ?></td>
                        <td>
                            <?php 
                                if ($row['sport'] == 'Cricket') {
                                    echo $row['runs'].'/'.$row['wickets'].' ('.$row['overs'].' ov)';
                                } elseif ($row['sport'] == 'Football') {
                                    echo $row['runs'].' goals';
                                } elseif ($row['sport'] == 'Basketball') {
                                    echo $row['runs'].' points';
                                }
                            ?>
                        </td>
                        <td><?= date('M d, Y H:i', strtotime($row['created_at'])) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-matches">
            No matches found. Play some games and save your scores!
        </div>
    <?php endif; ?>
</div>

<div class="logout">
    <a href="index.php">Back to Home</a>
</div>

</body>
</html>
<?php
$conn->close();
?>