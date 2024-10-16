<?php
session_start();
include 'db_connect.php'; // Database connection

// Handle registration
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password != $confirm_password) {
        $register_error = "Passwords do not match.";
    } else {
        // Check if username already exists
        $query = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $register_error = "Username already exists.";
        } else {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user with 'user' role into the database
            $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', 'user')";
            if (mysqli_query($conn, $query)) {
                $register_success = "Registration successful! You can now log in.";
                header("Location: index.php"); // Redirect to login page after successful registration
            } else {
                $register_error = "Registration failed. Please try again.";
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
    <title>PanchTatva Registration</title>
</head>
<body>
    <div class="container">
        <h1>PanchTatva User Registration</h1>
        <form method="post" action="register.php">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">New Password:</label>
                <input type="password" name="password" required>
            </div>
            <div class="input-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" name="confirm_password" required>
            </div>
            <button type="submit" name="register">Register</button>
            <?php 
                if (isset($register_error)) echo "<p class='error'>$register_error</p>"; 
                if (isset($register_success)) echo "<p class='success'>$register_success</p>"; 
            ?>
        </form>
    </div>
</body>
</html>
