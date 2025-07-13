<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - ProsperTech</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #87CEEB, orange, black);
            display: flex;
            min-height: 100vh;
            color: white;
        }

        .sidebar {
            width: 220px;
            background: rgba(0, 0, 0, 0.7);
            padding-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sidebar img {
            width: 100px;
            margin-bottom: 30px;
        }

        .sidebar a {
            color: lightgreen;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            width: 100%;
            text-decoration: none;
            gap: 10px;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar i {
            min-width: 25px;
            text-align: center;
        }

        .content {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .top-bar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 20px;
        }

        .top-bar img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid orange;
            margin-right: 10px;
        }

        .logout-btn {
            background: orange;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: #ff7f00;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid skyblue;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s;
            backdrop-filter: blur(5px);
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card i {
            font-size: 30px;
            color: white;
            margin-bottom: 10px;
        }

        .graphs {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .graph-container {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid skyblue;
            border-radius: 15px;
            padding: 15px;
            height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            backdrop-filter: blur(5px);
        }

        .graph-container h3 {
            text-align: center;
            font-size: 16px;
            margin-bottom: 10px;
        }

        canvas {
            max-height: 130px !important;
        }

        i.fas, i.far, i.fab {
            color: white !important;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <img src="prospertech/img/log.jpg" alt="Business Logo">
    <a href="customer.php"><i class="fas fa-users"></i><span>Customers</span></a>
    <a href="#"><i class="fas fa-box"></i><span>Orders</span></a>
    <a href="#"><i class="fas fa-ruler-combined"></i><span>Measurements</span></a>
    <a href="#"><i class="fas fa-money-bill-wave"></i><span>Payments</span></a>
    <a href="#"><i class="fas fa-tags"></i><span>Products</span></a>
    <a href="#"><i class="fas fa-shopping-cart"></i><span>Sales</span></a>
    <a href="#"><i class="fas fa-tshirt"></i><span>Rented Suits</span></a>
    <a href="#"><i class="fas fa-warehouse"></i><span>Inventory</span></a>
    <a href="#"><i class="fas fa-coins"></i><span>Income (Sales)</span></a>
    <a href="#"><i class="fas fa-arrow-circle-down"></i><span>Outgoings</span></a>
</div>

<!-- Main Content -->
<div class="content">
    <div class="top-bar">
        <img src="img/admin.jpg" alt="Admin">
        <a href="logout.php"><button class="logout-btn">Logout</button></a>
    </div>

    <div class="card-container">
        <div class="card"><i class="fas fa-users"></i><h3>Customers</h3></div>
        <div class="card"><i class="fas fa-box"></i><h3>Orders</h3></div>
        <div class="card"><i class="fas fa-ruler-combined"></i><h3>Measurements</h3></div>
        <div class="card"><i class="fas fa-money-bill-wave"></i><h3>Payments</h3></div>
        <div class="card"><i class="fas fa-tags"></i><h3>Products</h3></div>
        <div class="card"><i class="fas fa-shopping-cart"></i><h3>Sales</h3></div>
        <div class="card"><i class="fas fa-tshirt"></i><h3>Rented Suits</h3></div>
        <div class="card"><i class="fas fa-warehouse"></i><h3>Inventory</h3></div>
    </div>

    <div class="graphs">
        <div class="graph-container">
            <h3>Income</h3>
            <canvas id="incomeChart"></canvas>
        </div>
        <div class="graph-container">
            <h3>Outgoings</h3>
            <canvas id="outgoingsChart"></canvas>
        </div>
    </div>
</div>

<!-- Charts -->
<script>
    const incomeCtx = document.getElementById('incomeChart').getContext('2d');
    new Chart(incomeCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [{
                label: 'Income',
                data: [1200, 1900, 3000, 2500, 2200],
                backgroundColor: 'lightgreen'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true } }
        }
    });

    const outgoingsCtx = document.getElementById('outgoingsChart').getContext('2d');
    new Chart(outgoingsCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [{
                label: 'Outgoings',
                data: [800, 1200, 1500, 1100, 1000],
                backgroundColor: 'orange'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true } }
        }
    });
</script>

</body>
</html>
