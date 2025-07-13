<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

include "db_connection.php";

$success = $error = "";
$id = $_GET['id'] ?? null;
$customer = null;

// Fetch customer
if ($id) {
    $stmt = $conn->prepare("SELECT * FROM customers WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 1) {
        $customer = $res->fetch_assoc();
    } else {
        $error = "Customer not found!";
    }
} else {
    $error = "No customer ID specified!";
}

// Update customer
if (isset($_POST['update']) && $customer) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];

    $stmt = $conn->prepare("UPDATE customers SET name=?, phone=?, gender=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $phone, $gender, $id);
    if ($stmt->execute()) {
        $success = "Customer updated successfully!";
        header("refresh:1; url=customer.php");
        exit();
    } else {
        $error = "Failed to update customer!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Customer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #87CEEB, orange, black);
            color: white;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 220px;
            background: rgba(0, 0, 0, 0.7);
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sidebar img {
            width: 120px;
            margin-bottom: 20px;
        }

        .sidebar a {
            color: lightgreen;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            text-decoration: none;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .main-content {
            flex: 1;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .form-card {
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(12px);
            border: 2px solid skyblue;
            border-radius: 20px;
            padding: 30px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }

        .form-card h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 12px 40px 12px 35px;
            border-radius: 30px;
            border: 2px solid lightgreen;
            background: rgba(255,255,255,0.2);
            color: white;
            font-size: 15px;
        }

        .input-group i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: orange;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background: orange;
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background: #ff7f00;
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .message.success { color: lightgreen; }
        .message.error { color: yellow; }

        i.fas { color: white !important; }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <img src="prospertech/img/log.jpg" alt="Business Logo">
    <a href="customer.php"><i class="fas fa-users"></i> <span>Customers</span></a>
    <a href="#"><i class="fas fa-box"></i> <span>Orders</span></a>
    <a href="#"><i class="fas fa-ruler-combined"></i> <span>Measurements</span></a>
    <a href="#"><i class="fas fa-money-bill-wave"></i> <span>Payments</span></a>
    <a href="#"><i class="fas fa-tags"></i> <span>Products</span></a>
    <a href="#"><i class="fas fa-shopping-cart"></i> <span>Sales</span></a>
    <a href="#"><i class="fas fa-tshirt"></i> <span>Rented Suits</span></a>
    <a href="#"><i class="fas fa-warehouse"></i> <span>Inventory</span></a>
    <a href="#"><i class="fas fa-coins"></i> <span>Income</span></a>
    <a href="#"><i class="fas fa-arrow-circle-down"></i> <span>Outgoings</span></a>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="form-card">
        <h2><i class="fas fa-edit"></i> Edit Customer</h2>

        <?php
        if ($success) echo "<div class='message success'>$success</div>";
        if ($error) echo "<div class='message error'>$error</div>";
        ?>

        <?php if ($customer): ?>
            <form method="post" action="">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" value="<?= htmlspecialchars($customer['name']) ?>" required>
                </div>

                <div class="input-group">
                    <i class="fas fa-phone"></i>
                    <input type="text" name="phone" value="<?= htmlspecialchars($customer['phone']) ?>" required>
                </div>

                <div class="input-group">
                    <i class="fas fa-venus-mars"></i>
                    <select name="gender" required>
                        <option value="Male" <?= $customer['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= $customer['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                    </select>
                </div>

                <button type="submit" name="update" class="btn-submit">
                    <i class="fas fa-save"></i> Update
                </button>
            </form>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
