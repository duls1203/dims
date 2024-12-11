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
    $amount_received = $_POST['amount_received'];
    $date_received = $_POST['date_received'];
    $donation_method = $_POST['donation_method'];
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

    // Insert data into cash_out table
    $sql = "INSERT INTO cash_out (name, phone_number, email, address, purpose, affiliation, amount_received, date_received, donation_method, proof, remarks) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssdsiss", $name, $phone_number, $email, $address, $purpose, $affiliation, $amount_received, $date_received, $donation_method, $proofPath, $remarks);

    if ($stmt->execute()) {
        $status = "Cash distribution successfully added!";
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
    <title>Cash Distribution</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="cash_distribution.css">
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
            <h1>Add Cash Distribution</h1>
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
                    <input type="text" name="affiliation" id="affiliation" required>
                </div>
                <div class="form-group">
                    <label for="amount_received">Amount Distributed:</label>
                    <input type="number" name="amount_received" id="amount_received" required>
                </div>
                <div class="form-group">
                    <label for="date_received">Date Distributed:</label>
                    <input type="date" name="date_received" id="date_received" required>
                </div>
                <div class="form-group">
                    <label for="donation_method">Distribution Method:</label>
                    <select name="donation_method" id="donation_method" required>
                        <option value="Cash">Cash</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Online Payment">Online Payment</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="proof">Proof of Distribution:</label>
                    <input type="file" name="proof" id="proof" required>
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
