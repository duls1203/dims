<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $address = $conn->real_escape_string($_POST['address']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if the email already exists
        $checkEmail = "SELECT * FROM user WHERE email = '$email'";
        $result = $conn->query($checkEmail);

        if ($result->num_rows > 0) {
            $error = "This email is already registered.";
        } else {
            // Insert new user
            $sql = "INSERT INTO user (name, email, password, address, phone_number, role) 
                    VALUES ('$name', '$email', '$hashed_password', '$address', '$phone_number', 'User')";

            if ($conn->query($sql) === TRUE) {
                $success = "Registration successful! You can now <a href='login.php'>login</a>.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script> <!-- Include the JavaScript file -->
    <title>Register</title>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form method="POST" action="register.php">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" required>
                    <span class="toggle-password" onclick="togglePassword('password')">👁️</span>
                </div>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <div class="password-wrapper">
                    <input type="password" name="confirm_password" id="confirm_password" required>
                    <span class="toggle-password" onclick="togglePassword('confirm_password')">👁️</span>
                </div>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" name="phone_number" id="phone_number" required>
            </div>
            <button type="submit" class="btn">Register</button>
            <?php if (isset($success)): ?>
                <p class="success"><?php echo $success; ?></p>
            <?php elseif (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>
