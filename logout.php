<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logged Out - ProsperTech</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #87CEEB, orange, black);
            height: 100vh;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .logout-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 2px solid skyblue;
            border-radius: 15px;
            padding: 30px;
            width: 350px;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }

        .logout-container i {
            font-size: 50px;
            color: orange;
            margin-bottom: 15px;
        }

        .logout-container h2 {
            margin-bottom: 10px;
        }

        .logout-container p {
            margin-bottom: 20px;
            color: lightgreen;
        }

        .back-btn {
            background: orange;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }

        .back-btn:hover {
            background: #ff7f00;
        }

        i.fas, i.far, i.fab {
            color: white !important;
        }
    </style>
</head>
<body>

<div class="logout-container">
    <i class="fas fa-sign-out-alt"></i>
    <h2>You have been logged out</h2>
    <p>Thank you for using ProsperTech. You are now logged out.</p>
    <a href="index.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Login</a>
</div>

</body>
</html>
