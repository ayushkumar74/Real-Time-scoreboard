<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $pass = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    if (password_verify($pass, $user['password'])) {
      $_SESSION['username'] = $user['username'];
      header("Location: index.php");
      exit();
    } else {
      echo "<script>alert('Invalid password');</script>";
    }
  } else {
    echo "<script>alert('Invalid email');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
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

    .login-container {
      display: flex;
      justify-content: center;
      /* color: #00ffcc; */
      align-items: center;
      padding: 40px;
      margin-top:100px;
      /* padding-bottom:140px ; */
    }

    form {
      background-color: #1F2937;
      padding: 40px;
      border-radius: 15px;
      width: 400px;
      padding-bottom: 150px;
      /* box-shadow: 0px 0px 20px rgba(255, 255, 255, 0.2); */
    }

    form h2 {
      text-align: center;
      font-size: 40px;
      margin-bottom: 30px;
    }

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

    .signup-link {
      text-align: center;
      margin-top: 20px;
    }

    .signup-link a {
      color: #00ffff;
      text-decoration: none;
      font-weight: bold;
    }

    .signup-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<!-- <h1>⚽ Login</h1> -->

<div class="login-container">
  <form method="post">
    <h2>⚽ Login</h2>
    <input name="email" type="email" placeholder="Email" required>
    <input name="password" type="password" placeholder="Password" required>
    <button type="submit">Login</button>

    <div class="signup-link">
      Don't have an account? <a href="signup.php">Sign up here</a>
    </div>
  </form>
</div>

</body>
</html>
