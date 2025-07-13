<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

include "db_connection.php";

$success = $error = "";

// Handle Save
if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $date = date("Y-m-d");

    // Prevent duplicates
    $check = $conn->prepare("SELECT * FROM customers WHERE phone = ?");
    $check->bind_param("s", $phone);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows > 0) {
        $error = "Customer already registered!";
    } else {
        $stmt = $conn->prepare("INSERT INTO customers (name, phone, gender, reg_date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $phone, $gender, $date);
        if ($stmt->execute()) {
            $success = "Customer registered successfully!";
        } else {
            $error = "Error saving customer!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Customer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

       body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #87CEEB, orange, black);
    color: white;
    display: flex;
    height: 100vh; /* Make body fixed */
    overflow: hidden; /* Prevent whole page scroll */
}

.main-content {
    flex: 1;
    padding: 30px;
    display: flex;
    flex-direction: column;
    align-items: center;
    overflow: hidden; /* Prevent scroll here */
    height: 100vh;
    box-sizing: border-box;
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
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow: hidden;
        }

        .form-card {
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(12px);
            border: 2px solid skyblue;
            border-radius: 20px;
            padding: 30px;
            width: 100%;
            max-width: 500px;
            margin-bottom: 20px;
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

        .table-container {
    max-height: 300px;
    overflow-y: auto;
    width: 90%;
    background: rgba(255,255,255,0.08);
    border: 2px solid skyblue;
    border-radius: 15px;
    padding: 15px;
}


        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid skyblue;
        }

        th {
            background: rgba(255, 255, 255, 0.1);
        }

        td a i {
            cursor: pointer;
            color: orange;
            margin-right: 10px;
        }

        td a i:hover {
            color: #ff7f00;
        }

        .table-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .table-heading input {
            padding: 8px 15px;
            border-radius: 20px;
            border: 1px solid lightgreen;
            background: rgba(255,255,255,0.2);
            color: white;
            outline: none;
        }

        .table-heading button {
            padding: 8px 15px;
            border-radius: 20px;
            background: orange;
            color: white;
            border: none;
            cursor: pointer;
        }

        .table-heading button:hover {
            background: #ff7f00;
        }

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

    <?php if ($success) echo "<div class='message success'>$success</div>"; ?>
    <?php if ($error) echo "<div class='message error'>$error</div>"; ?>
    <?php if (isset($_GET['message']) && $_GET['message'] === 'deleted') echo "<div class='message success'>Customer deleted successfully!</div>"; ?>

    <!-- Registration Form -->
    <div class="form-card">
        <h2><i class="fas fa-user-plus"></i> Register Customer</h2>
        <form method="post" action="">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="name" placeholder="Full Name" required>
            </div>
            <div class="input-group">
                <i class="fas fa-phone"></i>
                <input type="text" name="phone" placeholder="Phone Number" required>
            </div>
            <div class="input-group">
                <i class="fas fa-venus-mars"></i>
                <select name="gender" required>
                    <option value="" disabled selected>Select Gender</option>
                    <option>Male</option>
                    <option>Female</option>
                </select>
            </div>
            <button type="submit" name="save" class="btn-submit">
                <i class="fas fa-save"></i> Save Customer
            </button>
        </form>
    </div>

    <!-- Searchable, Scrollable Table -->
    <div class="table-container">
        <div class="table-heading">
            <h3><i class="fas fa-list"></i> Registered Customers</h3>
            <form method="get" style="display: flex; align-items: center;">
                <input type="text" name="search" placeholder="Search..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Reg Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $search = $_GET['search'] ?? '';
                if ($search) {
                    $searchQuery = "%" . $conn->real_escape_string($search) . "%";
                    $stmt = $conn->prepare("SELECT * FROM customers WHERE name LIKE ? OR phone LIKE ? ORDER BY id DESC");
                    $stmt->bind_param("ss", $searchQuery, $searchQuery);
                    $stmt->execute();
                    $result = $stmt->get_result();
                } else {
                    $result = $conn->query("SELECT * FROM customers ORDER BY id DESC");
                }

                $i = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$i}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['gender']}</td>
                        <td>{$row['reg_date']}</td>
                        <td>
                            <a href='edit_customer.php?id={$row['id']}'><i class='fas fa-edit' title='Edit'></i></a>
                            <a href='delete_customer.php?id={$row['id']}' onclick=\"return confirm('Are you sure to delete this customer?')\">
                                <i class='fas fa-trash-alt' title='Delete'></i>
                            </a>
                        </td>
                    </tr>";
                    $i++;
                }

                if ($result->num_rows === 0) {
                    echo "<tr><td colspan='6'>No customer found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
