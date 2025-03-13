
<!DOCTYPE html>
<html>
<head>
<title>New Trainer</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" 
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,800&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />
<style>



span
{
	padding:5px;
}

body
{
	font-family: 'Poppins', sans-serif;
	margin: 0;
}

.title
{
	text-align:center;
	margin-top:1rem;
}

.main
{
  max-width:70vw;
  margin: auto;
  padding: 10px;
}

    th
	{
		font-size:20px;
		width:30%;
		text-align:center;
	}
	tr
	{
		width:70%;
		text-align:center;
	}
	#btn
	{
		float:right;
	}
	.password-input {
    position: relative;
	}

	.password-input i {
		position: absolute;
		top: 50%;
		right: 10px;
		transform: translateY(-50%);
		cursor: pointer;
	}

	.password-input input[type="password"] {
		padding-right: 30px;
	}

</style>
</head>
<body>
<?php include 'topbar.php' ;?>

<?php
include 'PApage_login.php';

// Your PHP code for handling form submission
$errors = []; // Initialize an array to store validation errors

if (isset($_POST['submit'])) {
    require 'config.php';

    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    $memail = mysqli_real_escape_string($conn, $_POST['memail']);
    $maddress = mysqli_real_escape_string($conn, $_POST['maddress']);
	$mid = $_POST['mid'];
    $mphone = $_POST['mphone'];
    $mlevel = $_POST['mlevel'];
    $mpass = $_POST['mpass'];

    // Validate inputs
    if (empty($mname)) {
        $errors[] = 'Trainer name is required.';
    }

    // Perform additional validation for other fields as needed

    // Check if there are any errors
    if (empty($errors)) {
        $insertQuery = "INSERT INTO trainer (trainer_name, phone, id, pass, address, `teaching level`) VALUES ('$mname', '$mphone', '$mid', '$mpass', '$maddress', '$mlevel')";

        if (mysqli_query($conn, $insertQuery)) {
            echo "
                <script>
                    // Show a success alert
                    alert('New trainer added successfully!');
                    window.location.href = 'add_new_trainer.php';
                </script>
            ";
        } else {
            echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
        }
    } else {
        // Output errors or handle them in some way
        foreach ($errors as $error) {
            echo "<p>Error: $error</p>";
        }
    }

    // Close the connection
    mysqli_close($conn);
}
?>




<div class="main">


						<div class="title">
                            <h1>Add New Trainer</h1>
                        </div>
<form name="booking frm" method="post">
    <table class="table tableInfo">
        <tr>
		  <th>Trainer Name</th>
		  <td><input type="text" class="form-control" name="mname" id="mname" placeholder="John Doe">
		</tr>
		
		<tr>
		<th>Identity Number</th>
		<td>
			<input type="text" class="form-control" name="mid" id="mid" placeholder="XXXXXX-XX-XXXX" pattern="\d{6}-\d{2}-\d{4}">
		</td>
		</tr>

		
		<tr>
		<th>Address</th>
		<td><input type="text"class="form-control" name="maddress" placeholder="26,Jalan Melanti 2, 53000, Kuala Lumpur, Malaysia.">
		</td>
		</tr> 	
		
		
        <tr>
		  <th>Phone Number</th>
		  <td>
			<input type="text" class="form-control" name="mphone" id="mphone" placeholder="012-67225412" pattern="\d{3}-\d{7}">
		</tr>
		
		<tr>
			<th>Teaching Level</th>
			<td>
				<select class="form-control" name="mlevel" id="mlevel">
				    <option value="Junior">Junior</option>
					<option value="Senior">Senior</option>
					<option value="Probation period">Probation period</option>
				</select>
			</td>
		</tr>

		<tr>
		  <th>Password</th>
		  <td>
			<div class="password-input">
			  <input type="password" class="form-control" name="mpass" id="txtPassword" placeholder="xxxxxxxxxx">
			  <i class="fas fa-eye" id="togglePassword" onclick="togglePasswordVisibility('txtPassword', 'togglePassword')"></i>
			</div>
		  </td>
		</tr>
		
		<tr>
		  <th>Confirm Password</th>
		  <td>
			<div class="password-input">
			  <input type="password" class="form-control" name="mconpass" id="txtConfirmPassword" placeholder="xxxxxxxxxx">
			  <i class="fas fa-eye" id="toggleConfirmPassword" onclick="togglePasswordVisibility('txtConfirmPassword', 'toggleConfirmPassword')"></i>
			</div>
			<span id="password-error" style="color: red;"></span>
		  </td>
		</tr>

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
					
    </table>

    <div class="mb-3 submit d-flex justify-content-between">
		        <a href="trainer_list.php" class="btn btn-secondary">Back</a>
				<button type="submit" class="btn btn-primary" id="btn" name="submit">Done</button>
	</div>
</form>

    </div>

</body>
</html>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<script type="text/javascript">
    function togglePasswordVisibility(inputId, iconId) {
        var passwordInput = document.getElementById(inputId);
        var icon = document.getElementById(iconId);

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>
