<?php
require 'config.php';

// Ensure the user is logged in
include 'page_login.php';

$member_id = $_SESSION['member_id'];

// Select data from the member table using the member_id
$query = "SELECT * FROM member WHERE member_id = '$member_id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Retrieve data from the form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_num = mysqli_real_escape_string($conn, $_POST['phone_num']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Update user data in the database
    $update_query = "UPDATE member SET 
                    member_name = '$username',
                    email = '$email',
                    phone = '$phone_num',
                    gender = '$gender',
                    birthday = '$birthday',
                    pass = '$password'
                    WHERE member_id = '$member_id'";

    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        // Redirect to the profile page after successful update
        header("Location: profile.php");
        exit();
    } else {
        $error = "Error updating user information";
    }
}
?>

<!-- Add your HTML content here -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Add this in the head section of your HTML file -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .custom-form {
            max-width: 800px;
            margin: 0 auto;
        }
        .custom-button {
            width: 500px;
            padding: 12px 15px;
        }
    </style>
    <title>Member Profile</title>
</head>

<body>
    <!-- navbar -->
    <?php include 'navbar.php'; ?>

    <div class="row mt-5 mb-5 ">
        <h1 class="container my-4" style="font-size:40px; font-weight:bolder;">My Profile</h1>
        <h2 class="container mb-5" style="font-size:25px; font-weight:lighter; ">Update your profile now</h2>
        <div class="container" style="border-bottom: 2px solid #e0e0e0;"></div>
    </div>

    <div class="container px-5">
         <form method="post">
            <div class="form-group py-4 custom-form">
                <label for="username" style="font-weight: bold; font-size: 20px;">Username</label>
                <input type="text" class="form-control form-control-lg custom-input" id="username" name="username" placeholder="Janice Lim" value="<?php echo $row['member_name']; ?>">
            </div>
            <div class="form-group py-4 custom-form">
                <label for="email" style="font-weight: bold; font-size: 20px;">Email</label>
                <input type="email" class="form-control form-control-lg custom-input" id="email" name="email" placeholder="janicelim101@gmail.com" value="<?php echo $row['email']; ?>">
            </div>
            <div class="form-group py-4 custom-form">
                <label for="phone_num" style="font-weight: bold; font-size: 20px;">Phone Number</label>
                <input type="text" class="form-control form-control-lg custom-input" id="phone_num" name="phone_num" placeholder="0193097621" value="<?php echo $row['phone']; ?>">
            </div>
            <div class="form-group py-4 custom-form">
                <label for="gender" style="font-weight: bold; font-size: 20px;">Gender</label>
                <select id="gender" class="form-control form-control-lg" name="gender">
                    <option <?php if ($row['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                    <option <?php if ($row['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                </select>
            </div>
            <div class="form-group py-4 custom-form">
                <label for="birthday" style="font-weight: bold; font-size: 20px;">Date of Birth</label>
                <input type="date" class="form-control form-control-lg custom-input" id="birthday" name="birthday" value="<?php echo $row['birthday']; ?>">
            </div>
            <div class="form-group py-4 custom-form">
                <label for="password" style="font-weight: bold; font-size: 20px;">Password</label>
                <input type="text" class="form-control form-control-lg custom-input" id="password" name="password"value="<?php echo $row['pass']; ?>" placeholder="Enter new password">
            </div>
            <div class="d-flex justify-content-center py-5">
                <button type="submit" class="btn btn-secondary btn-lg btn-dark custom-button" name="update">Update</button>
            </div>
        </form>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Include jQuery, Popper.js, and Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>