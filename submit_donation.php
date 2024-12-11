<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect data from the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $amount = $_POST['amount'];
    $remarks = $_POST['remarks'];

    // Handle uploaded proof
    $proof = $_FILES['proof'];
    $proofName = $proof['name'];
    $proofTmpName = $proof['tmp_name'];
    $proofDestination = "uploads/" . basename($proofName);

    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true); // Create directory if not exists
    }
    if (move_uploaded_file($proofTmpName, $proofDestination)) {
        $proofPath = file_get_contents($proofDestination);
    } else {
        $proofPath = null;
    }

    // Check if user is logged in and fetch `user_id`
    $user_id = null; // Assume the user is not logged in by default
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id']; // Replace with your session handling logic
    }

    // Insert data into the cash_in table
    $sql = "INSERT INTO cash_in (user_id, name, phone, email, amount, payment_method, date_received, remarks, proof) 
            VALUES (?, ?, ?, ?, ?, 'Bank Transfer', NOW(), ?, ?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("isssdsb", $user_id, $name, $phone, $email, $amount, $remarks, $proofPath);

    if ($stmt->execute()) {
        header("Location: index.html?status=success");
        exit();
    } else {
        header("Location: donate.php?status=error");
        exit();
    }
}
?>
