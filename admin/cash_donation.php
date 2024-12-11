<?php
include '../config.php'; // Include the database configuration file
session_start();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect data from the form
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $amount = $conn->real_escape_string($_POST['amount']);
    $payment_method = $conn->real_escape_string($_POST['payment_method']);
    $date_received = $conn->real_escape_string($_POST['date_received']);
    $remarks = $conn->real_escape_string($_POST['remarks']);

    // Handle uploaded proof (if provided)
    $proof = null;
    if (isset($_FILES['proof']) && $_FILES['proof']['error'] === UPLOAD_ERR_OK) {
        $proof_tmp_name = $_FILES['proof']['tmp_name'];
        $proof_name = basename($_FILES['proof']['name']);
        $proof_destination = "uploads/" . $proof_name;

        // Create the uploads directory if it doesn't exist
        if (!file_exists('uploads')) {
            mkdir('uploads', 0777, true);
        }

        // Move the uploaded file to the destination folder
        if (move_uploaded_file($proof_tmp_name, $proof_destination)) {
            $proof = $proof_destination; // Save the path for the proof
        }
    }

    // Check if user is logged in and get user_id, otherwise set to null
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Prepare and execute the SQL query to insert data into cash_in table
    $sql = "INSERT INTO cash_in (user_id, name, phone, email, amount, payment_method, date_received, remarks, proof)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "isssdssss",
        $user_id,      // User ID (or NULL if not logged in)
        $name,         // Donor Name
        $phone,        // Phone Number
        $email,        // Email Address
        $amount,       // Donation Amount
        $payment_method, // Payment Method
        $date_received, // Date Received
        $remarks,      // Remarks
        $proof         // Proof of Donation (file path or NULL)
    );

    if ($stmt->execute()) {
        $status_message = "Donation successfully recorded!";
    } else {
        $status_message = "Error recording donation: " . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Donation</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="cash_donation.css">
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
        <main class="content">
            <h1>Cash Donation</h1>

            <!-- Status Message -->
            <?php if (isset($status_message)): ?>
                <p class="status"><?php echo $status_message; ?></p>
            <?php endif; ?>

            <form method="POST" action="cash_donation.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Full Name:</label>
                    <input type="text" name="name" id="name" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number:</label>
                    <input type="text" name="phone" id="phone" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="form-group">
                    <label for="amount">Amount:</label>
                    <input type="number" step="0.01" name="amount" id="amount" required>
                </div>
                <div class="form-group">
                    <label for="payment_method">Payment Method:</label>
                    <select name="payment_method" id="payment_method" required>
                        <option value="Cash">Cash</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Online Payment">Online Payment</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date_received">Date Received:</label>
                    <input type="date" name="date_received" id="date_received" required>
                </div>
                <div class="form-group">
                    <label for="remarks">Remarks:</label>
                    <textarea name="remarks" id="remarks" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="proof">Upload Proof (optional):</label>
                    <input type="file" name="proof" id="proof" accept="image/*">
                </div>
                <button type="submit" class="btn">Submit Donation</button>
            </form>
        </main>
    </div>
</body>
</html>
