<?php
 include 'FApage_login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Add New Announcement</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <?php include 'FAtopbar.php'; ?>

    <div class="main">
        <div class="title">
            <h1>Add New Announcement</h1>
        </div>
        <form name="booking_frm" method="post">
            <table class="table tableInfo">
                <tr>
                    <th>Title</th>
                    <td><input type="text" class="form-control" name="atitle" id="atitle" placeholder=""></td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>
                        <textarea class="form-control" name="ades" id="ades" style="height: 150px;"></textarea>
                    </td>
                </tr>
				
				<tr>
                    <th>Date</th>
                    <td>
                        <input type="date" class="form-control" name="adate" id="adate">
                    </td>
                </tr>
               
            </table>
           <div class="mb-3 submit d-flex justify-content-between">
		        <a href="Announcement.php" class="btn btn-secondary">Back</a>
				<button type="submit" class="btn btn-primary" id="btn" name="submit">Done</button>
			</div>

        </form>
    </div>

  <?php
// Your PHP code for handling form submission
$errors = []; // Initialize an array to store validation errors

if (isset($_POST['submit'])) {
    require 'config.php';

    $atitle = mysqli_real_escape_string($conn, $_POST['atitle']);
    $ades = mysqli_real_escape_string($conn, $_POST['ades']);
	$adate = $_POST['adate'];

    // Check if there are any errors
    if (count($errors) === 0) {
        $insertQuery = "INSERT INTO announcement (title, des, date) VALUES ('$atitle', '$ades', '$adate')";

        if (mysqli_query($conn, $insertQuery)) {
            echo "
                <script>
                    // Show a success alert
                    alert('New announcement added successfully!');
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



</body>
</html>

