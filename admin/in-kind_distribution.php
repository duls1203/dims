<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $purpose = $_POST['purpose'];
    $affiliation = $_POST['affiliation'];
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $unit = $_POST['unit'];
    $expiry_date = $_POST['expiry_date'];
    $date_received = $_POST['date_received'];
    $remarks = $_POST['remarks'];

    // Handle uploaded proof
    $proof = $_FILES['proof'];
    $proofName = $proof['name'];
    $proofTmpName = $proof['tmp_name'];
    $proofDestination = "uploads/" . basename($proofName);

    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true);
    }
    if (move_uploaded_file($proofTmpName, $proofDestination)) {
        $proofPath = $proofDestination;
    } else {
        $proofPath = null;
    }

    // Insert data into in_kind_distribution table
    $sql = "INSERT INTO in_kind_distribution (name, phone_number, email, address, purpose, affiliation, item_id, item_name, category, description, quantity, unit, expiry_date, date_received, proof, remarks) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssisdsdsssbs", $name, $phone_number, $email, $address, $purpose, $affiliation, $item_id, $item_name, $category, $description, $quantity, $unit, $expiry_date, $date_received, $proofPath, $remarks);

    if ($stmt->execute()) {
        $status = "In-kind distribution successfully added!";
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
    <title>In-kind Distribution</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="in-kind_distribution.css">
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
            <h1>Add In-kind Distribution</h1>
            <?php if (isset($status)): ?>
                <p class="status"><?php echo $status; ?></p>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Recipient Name:</label>
                    <input type="text" name="name" id="name" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number:</label>
                    <input type="text" name="phone_number" id="phone_number" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea name="address" id="address" required></textarea>
                </div>
                <div class="form-group">
                    <label for="purpose">Purpose:</label>
                    <input type="text" name="purpose" id="purpose" required>
                </div>
                <div class="form-group">
                    <label for="affiliation">Affiliation:</label>
                    <input type="text" name="affiliation" id="affiliation">
                </div>
                <div class="form-group">
                    <label for="item_id">Item ID:</label>
                    <input type="text" name="item_id" id="item_id" required>
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
                    <textarea name="description" id="description"></textarea>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" required>
                </div>
                <div class="form-group">
                    <label for="unit">Unit:</label>
                    <input type="text" name="unit" id="unit">
                </div>
                <div class="form-group">
                    <label for="expiry_date">Expiry Date:</label>
                    <input type="date" name="expiry_date" id="expiry_date">
                </div>
                <div class="form-group">
                    <label for="date_received">Date Distributed:</label>
                    <input type="date" name="date_received" id="date_received" required>
                </div>
                <div class="form-group">
                    <label for="proof">Proof of Distribution:</label>
                    <input type="file" name="proof" id="proof">
                </div>
                <div class="form-group">
                    <label for="remarks">Remarks:</label>
                    <textarea name="remarks" id="remarks"></textarea>
                </div>
                <button type="submit">Add Distribution</button>
            </form>
        </div>
    </div>
</body>
</html>
