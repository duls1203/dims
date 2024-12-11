<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $user_id = $_SESSION['user_id'] ?? null; // Assume the user is logged in
    $name = $_POST['name'];
    $item_name = $_POST['item_name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $unit = $_POST['unit'];
    $expiry_date = $_POST['expiry_date'];
    $date_received = $_POST['date_received'];
    $remarks = $_POST['remarks'];

    // Insert data into in-kind donation table
    $sql = "INSERT INTO inventory (user_id, name, item_name, category, description, quantity, unit, expiry_date, date_received, remarks) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssssss", $user_id, $name, $item_name, $category, $description, $quantity, $unit, $expiry_date, $date_received, $remarks);

    if ($stmt->execute()) {
        $status = "Donation successfully added!";
    } else {
        $status = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In-kind Donation</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="in-kind_donation.css">
</head>
<body>
    <div class="container">
        <!-- Top Header -->
        <header class="header">
            <div class="logo">City College of Calamba Donation System</div>
        </header>

        <!-- Sidebar -->
        <aside class="sidebar">
            <nav>
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="add_donation.php">Add Donation</a></li>
                    <li><a href="inventory.php">Inventory</a></li>
                    <li><a href="distribution.php">Distribution</a></li>
                    <li><a href="user_management.php">User Management</a></li>
                    <li><a href="messages.php">Messages</a></li>
                    <li><a href="../index.html">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="content">
            <h1>In-kind Donation</h1>
            <?php if (isset($status)): ?>
                <p class="status"><?php echo $status; ?></p>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Donor Name:</label>
                    <input type="text" name="name" id="name" required>
                </div>
                <div class="form-group">
                    <label for="item_name">Item Name:</label>
                    <input type="text" name="item_name" id="item_name" required>
                </div>
                <div class="form-group">
                    <label for="category">Category:</label>
                    <input type="text" name="category" id="category" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" id="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" required>
                </div>
                <div class="form-group">
                    <label for="unit">Unit:</label>
                    <input type="text" name="unit" id="unit" required>
                </div>
                <div class="form-group">
                    <label for="expiry_date">Expiry Date:</label>
                    <input type="date" name="expiry_date" id="expiry_date">
                </div>
                <div class="form-group">
                    <label for="date_received">Date Received:</label>
                    <input type="date" name="date_received" id="date_received" required>
                </div>
                <div class="form-group">
                    <label for="remarks">Remarks:</label>
                    <textarea name="remarks" id="remarks"></textarea>
                </div>
                <button type="submit">Add Donation</button>
            </form>
        </div>
    </div>
</body>
</html>
