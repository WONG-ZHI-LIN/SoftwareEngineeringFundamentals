<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-eGQVRpZl+2IG5FXA8DO+BaaHiG0IO/WT1aIjZblvW4hxREfcMVO7xPQ9Wd93plR8" crossorigin="anonymous">
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
    <title>Create an Account</title>
</head>

<body>
    <!-- navbar -->
    <?php include 'navbar.php'; ?>
    <div class="container py-5 my-5">
    <h1 class="text-center" style="font-family: Verdana, sans-serif; font-weight: bold; margin-bottom: 80px;">Sign Up</h1>
    <div class="container">
        <form method="post">
            <div class="form-group mb-5">
                <input type="text" class="form-control form-control-lg custom-input" name="mname" placeholder="Username">
            </div>
            <div class="form-group mb-5">
                <input type="email" class="form-control form-control-lg custom-input" name="memail" placeholder="Email address">
            </div>
            <div class="form-group mb-5">
                <input type="text" class="form-control form-control-lg custom-input" name="mphone" placeholder="Phone Number XXX-XXXXXXX" pattern="\d{3}-\d{7}">
            </div>
            <div class="form-group mb-5">
                <select class="form-control form-control-lg custom-input" name="mgender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
         <div class="form-group text-center mb-5">
			<label for="mbirth">Birth Date:</label>
			<input type="date" class="form-control form-control-lg custom-input" name="mbirth">
		</div>
		
            <div class="form-group mb-5">
                <input type="password" class="form-control form-control-lg custom-input"  name="mpass" id="txtPassword" placeholder="Password">
            </div>
			
          <div class="form-group text-center mb-5">
			<div class="d-flex align-items-center">
				<input type="password" class="form-control form-control-lg custom-input" name="mconpass" id="txtConfirmPassword" placeholder="Comfirm password">
			</div>
			<span id="password-error" style="color: red;"></span>
		</div>
		<div class="py-5 my-5">
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-secondary btn-lg btn-dark custom-button" name="submit">Create an Account</button>
            </div>

        </form>
        
            <div class="d-flex justify-content-center mt-3">
                <a href="join_now.php" class="btn btn-secondary btn-lg btn-light custom-button">Sign In</a>
            </div>
        </div>
    </div>
</div>


<script>
  // Get the password input elements
  const passwordInput = document.getElementById('txtPassword');
  const confirmPasswordInput = document.getElementById('txtConfirmPassword');
  // Get the error message element
  const errorElement = document.getElementById('password-error');

  // Function to check if the confirm password matches the password
  function checkPasswordMatch() {
    // Get the entered password values
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;

    // Check if the confirm password matches the password
    if (password === confirmPassword) {
      // Clear the error message if the passwords match
      errorElement.textContent = '';
    } else {
      // Show an error message if the passwords do not match
      errorElement.textContent = 'Passwords do not match';
    }
  }

  // Add event listener to check the password match on input value change
  confirmPasswordInput.addEventListener('input', checkPasswordMatch);
</script>	
    <?php include 'footer.php'; ?>

    <!-- Include jQuery, Popper.js, and Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>

<?php
$errors = []; // Initialize an array to store validation errors

if (isset($_POST['submit'])) {
    require 'config.php';
    
    $mname = $_POST['mname'];
    $memail = $_POST['memail'];
	$mphone = $_POST['mphone'];
	$mgender = $_POST['mgender'];
	$mbirth = $_POST['mbirth'];
    $mpass = $_POST['mpass'];
  
			
    // Check if there are any errors
    if (count($errors) === 0) {
        mysqli_query($conn, "INSERT INTO member (member_name, phone, email, pass ,gender ,birthday) VALUES ('$mname', '$mphone', '$memail', '$mpass', '$mgender', '$mbirth')");
    
        echo "
            <script>
            alert('Sign Up successfully');
            window.location.href = 'join_now.php';
            </script>
        ";
    }
}

?>