<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $trainer_name = $_POST['trainer_name'];
    $new_password = $_POST['new_password'];

    // Validate input
    if (empty($trainer_name) || empty($new_password)) {
        header("Location: forgot_password.php?error=All fields are required");
        exit();
    }

    // Check if trainer name exists in the database
    $query = "SELECT * FROM trainer WHERE trainer_name = '$trainer_name'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 0) {
        header("Location: forgot_password.php?error=Trainer name not found");
        exit();
    }

    // Update password in the database
    $update_query = "UPDATE trainer SET pass = '$new_password' WHERE trainer_name = '$trainer_name'";
    $update_result = mysqli_query($conn, $update_query);

    if (!$update_result) {
        header("Location: forgot_password.php?error=Failed to reset password. Please try again.");
        exit();
    }

    // Password reset successful
    header("Location: trainer_login.php");
    exit();
}
?>
