<?php
session_start();
include "db_connection.php";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['user'] = $username;
        header("Location: userdashboard.php");
        exit();
    } else {
        $error = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ProsperTech Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #87CEEB, orange, black);
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border: 2px solid skyblue;
            border-radius: 20px;
            padding: 35px 25px;
            width: 100%;
            max-width: 350px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            text-align: center;
        }

        .login-card img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 3px solid orange;
            margin-bottom: 20px;
        }

        .login-card h2 {
            color: white;
            margin-bottom: 20px;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group input {
            width: 100%;
            padding: 12px 40px 12px 35px;
            border: 2px solid lightgreen;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            font-size: 15px;
        }

        .input-group i {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: orange;
            font-size: 16px;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: orange;
            border: none;
            border-radius: 30px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .login-btn:hover {
            background: #ff7f00;
        }

        .error, .logout-msg {
            margin-bottom: 15px;
            font-weight: bold;
        }

        .error {
            color: yellow;
        }

        .logout-msg {
            color: lightgreen;
        }

        i.fas, i.far, i.fab {
            color: white !important;
        }

        @media (max-width: 400px) {
            .login-card {
                margin: 0 10px;
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

<div class="login-card">
    <img src="img/admin.jpg" alt="User Image">
    <h2>ProsperTech Login</h2>

    <?php
    if (isset($error)) {
        echo "<div class='error'>$error</div>";
    } elseif (isset($_GET['message']) && $_GET['message'] === 'loggedout') {
        echo "<div class='logout-msg'>You have successfully logged out!</div>";
    }
    ?>

    <form method="post" action="">
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Username" required>
        </div>

        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <button type="submit" name="login" class="login-btn">
            <i class="fas fa-sign-in-alt"></i> Login
        </button>
    </form>
</div>

</body>
</html>
