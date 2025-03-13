<?php
session_start(); // Start the session

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection configuration here
    require 'config.php';

    // Get user input from the form
    $email = mysqli_real_escape_string($conn, $_POST['email']); // Prevent SQL injection
    $pass = mysqli_real_escape_string($conn, $_POST['mpass']); // Prevent SQL injection


    // Query to check user credentials
    $check_user = "SELECT * FROM member WHERE email='$email' AND pass='$pass'";

    $run = mysqli_query($conn, $check_user);

    if ($run && mysqli_num_rows($run) > 0) {
        // User is authenticated, retrieve member_id
        $member = mysqli_fetch_assoc($run);
        $member_id = $member['member_id']; // Assuming 'member_id' is the column name in the 'member' table

        // Store user information in session
        $_SESSION['member_id'] = $member_id;
        $_SESSION['email'] = $email;

        // Redirect to the desired page after successful login
        header("Location: index.php");
        exit();
    } else {
        $error = "Error! Invalid credentials";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Add this in the head section of your HTML file -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .custom-input {
            width: 46%;
            /* Adjust the width as per your requirement */
            margin: 0 auto;
            /* This centers the input field */
            padding: 12px 15px;
        }

        .custom-button {
            width: 46%;
            padding: 12px 15px;
            border-radius: 10px;
        }
    </style>
    <title>Join Now</title>
</head>

<body>
    <!-- navbar -->
    <?php include 'navbar.php'; ?>
    <div class="container py-5 my-5">
        <h1 class="text-center" style="font-family: Verdana, sans-serif; font-weight: bold; margin-bottom: 80px;">Login</h1>
        <div class="container">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                 <div class="form-group text-center mb-5">
				   <?php if (isset($error)) : ?>
					<span style="color: red;"><?php echo $error; ?></span>
			<?php endif; ?>
			         <div class="d-flex align-items-center">
                    <input type="email" class="form-control form-control-lg custom-input" name="email"  placeholder="Email address">
					</div>
                </div>
                <div class="form-group mb-5">
                    <input type="password" class="form-control form-control-lg custom-input" name="mpass" id="password" placeholder="Password">
                </div>
            
                <div class="py-5 my-5">
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-secondary btn-lg btn-dark custom-button">Sign In</button>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <a href="sign_up.php" class="btn btn-light btn-lg custom-button">Create an Account</a>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <?php include 'footer.php'; ?>

    <!-- Include jQuery, Popper.js, and Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>