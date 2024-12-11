<?php
include 'config.php';
session_start();

// Initialize login attempts
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['lockout_time'] = null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Check if user is locked out
    if ($_SESSION['login_attempts'] >= 5) {
        $lockout_duration = 30; // Lockout duration in seconds
        $time_diff = time() - $_SESSION['lockout_time'];

        if ($time_diff < $lockout_duration) {
            $error = "Too many attempts. Please try again after " . ($lockout_duration - $time_diff) . " seconds.";
        } else {
            // Reset login attempts after lockout duration
            $_SESSION['login_attempts'] = 0;
            $_SESSION['lockout_time'] = null;
        }
    }

    if (!isset($error)) {
        // Validate login
        $sql = "SELECT * FROM user WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Successful login
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role']; // Store role in session
                $_SESSION['login_attempts'] = 0; // Reset attempts
                $_SESSION['lockout_time'] = null; // Reset lockout time

                // Redirect based on role
                if ($user['role'] === 'Admin') {
                    header("Location: admin/dashboard.php");
                } elseif ($user['role'] === 'User') {
                    header("Location: user/user.php");
                } else {
                    $error = "Unknown role. Please contact support.";
                }
                exit();
            } else {
                // Increment login attempts
                $_SESSION['login_attempts']++;
                if ($_SESSION['login_attempts'] >= 5) {
                    $_SESSION['lockout_time'] = time(); // Set lockout time
                }
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> <!-- Use the same stylesheet as the landing page -->
    <script src="script.js" defer></script>
    <title>Login</title>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form method="POST" action="login.php">
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

            <button type="submit" class="btn" <?php if (isset($error) && strpos($error, 'Please try again') !== false) echo 'disabled'; ?>>Login</button>
            <?php if (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
        </form>
        <p><a href="forgot_password.php">Forgot Password?</a></p>
        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    </div>
</body>
</html>
