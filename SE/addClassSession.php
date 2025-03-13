<?php
// Include the necessary files (e.g., database connection)
include 'config.php';

// Fetch trainer names from the database
$trainerQuery = "SELECT trainer_name FROM trainer";
$trainerResult = mysqli_query($conn, $trainerQuery);
$trainerNames = array();

while ($row = mysqli_fetch_assoc($trainerResult)) {
    $trainerNames[] = $row['trainer_name'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Add New Class Session</title>
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
            <h1>Add New Class Session</h1>
        </div>
        <form name="booking_frm" method="post">
            <table class="table tableInfo">
                <tr>
                    <th>Class Name</th>
                    <td><input type="text" class="form-control" name="cname" id="cname" placeholder="Yoga Class"></td>
                </tr>
                <tr>
                    <th>Class Description</th>
                    <td>
                        <textarea class="form-control" name="cdes" id="cdes" style="height: 150px;"></textarea>
                    </td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>
                        <input type="date" class="form-control" name="cdate" id="cdate">
                    </td>
                </tr>
				<tr>
				<th>Time</th>
				<td>
					<div class="row">
						<div class="col">
							<input type="time" class="form-control" name="cstart" id="cstart" placeholder="Start Time">
						</div>
						<div class="col">
							<span>to</span>
						</div>
						<div class="col">
							<input type="time" class="form-control" name="cend" id="cend" placeholder="End Time">
						</div>
					</div>
				</td>
			</tr>


                <tr>
                    <th>Class Maximum capacity</th>
                    <td>
                        <input type="text" class="form-control" name="cmax" id="cmax">
                    </td>
                </tr>
				
			<tr>
			<th>Trainer Name</th>
			<td>
				<select class="form-control" name="tname" id="tname" required>
					<?php
					foreach ($trainerNames as $trainer) {
						echo '<option value="' . $trainer . '">' . $trainer . '</option>';
					}
					?>
				</select>
			</td>
		</tr>
            </table>
           <div class="mb-3 submit d-flex justify-content-between">
		        <a href="ClassSession.php" class="btn btn-secondary">Back</a>
				<button type="submit" class="btn btn-primary" id="btn" name="submit">Done</button>
			</div>

        </form>
    </div>

  <?php
// Your PHP code for handling form submission
$errors = []; // Initialize an array to store validation errors

if (isset($_POST['submit'])) {
    require 'config.php';

    $cname = mysqli_real_escape_string($conn, $_POST['cname']);
    $cdes = mysqli_real_escape_string($conn, $_POST['cdes']);
    $cdate = $_POST['cdate'];
    $cstart = $_POST['cstart'];
    $cend = $_POST['cend'];
    $cmax = $_POST['cmax'];
	$tname = $_POST['tname'];

    // Get the current date
    $currentDate = date('Y-m-d');

    // Combine start and end time into a single string
    $ctime = $cstart . '-' . $cend;

    // Check if there are any errors
    if (count($errors) === 0) {
        $insertQuery = "INSERT INTO class_session (title, des, date, time, capacity, publish_date, tname) VALUES ('$cname', '$cdes', '$cdate', '$ctime', '$cmax', '$currentDate','$tname')";

        if (mysqli_query($conn, $insertQuery)) {
            echo "
                <script>
                    // Show a success alert
                    alert('New class session added successfully!');
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

