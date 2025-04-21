<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already registered');</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        if ($stmt->execute()) {
            $_SESSION["username"] = $username;
            header("Location: index.php");
        } else {
            echo "<script>alert('Error during signup.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <style>
        @font-face {
            font-family: CursedTimerULiLFont;
            src: url(CursedTimerUlil-Aznm.ttf);
        }

        body {
            background-image:url("https://i.pinimg.com/originals/64/2b/04/642b044ed99bfa429017571c524ab126.jpg");
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

        .signup-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            margin-top: 50px;
        }

        form {
            background-color: #1F2937;
            padding: 40px;
            border-radius: 15px;
            width: 400px;
            /* box-shadow: 0px 0px 20px rgba(255, 255, 255, 0.2); */
        }

        form h2 {
            text-align: center;
            font-size: 40px;
            margin-bottom: 30px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0 20px 0;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            background-color: white;
            color: black;
            font-family: sans-serif;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #e91e63;
            border: none;
            border-radius: 10px;
            font-size: 20px;
            font-weight: bold;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #ff4081;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #00ffff;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- <h1></h1> -->

<div class="signup-container">
    <form method="POST">
        <h2>🏀 Sign Up</h2>
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Sign Up</button>

        <div class="login-link">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </form>
</div>

</body>
</html>
