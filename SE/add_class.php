<?php
$title = urldecode($_GET['title']);
$date = urldecode($_GET['date']);
$time = urldecode($_GET['time']);
$class_id = urldecode($_GET['class_id']);
// Include necessary files and establish a database connection (modify as needed)
require 'config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $member_id = $_POST['member_id']; // Assuming you have this value available
    $member_name = getMemberName($conn, $member_id); // Call the function to get member_name
    $title = $_POST['title'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Check if the member has already added to this class
    $checkQuery = "SELECT * FROM class_member WHERE member_id = '$member_id' AND title = '$title' AND date = '$date' AND time = '$time'";
    $checkResult = mysqli_query($conn, $checkQuery);

    // Check if the class is full (capacity is zero)
    $checkCapacityQuery = "SELECT capacity FROM class_session WHERE class_id = '$class_id'";
    $checkCapacityResult = mysqli_query($conn, $checkCapacityQuery);

    if ($checkCapacityResult) {
        $rowCapacity = mysqli_fetch_assoc($checkCapacityResult);

        if ($rowCapacity['capacity'] <= 0) {
            echo '<script>alert("Sorry The class is full! Please kindly select other class session."); window.location.href = "class_list.php";</script>';
            exit; // Stop further execution
        }
    }

    if (mysqli_num_rows($checkResult) > 0) {
        echo '<script>alert("You have already added to this class!"); window.location.href = "class_list.php";</script>';
    } else {
        // Insert data into the class_member table
        $insertQuery = "INSERT INTO class_member (member_id, member_name, title, date, time, class_id) VALUES ('$member_id', '$member_name', '$title', '$date', '$time', '$class_id')";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            // Deduct the capacity in class_session
            $deductCapacityQuery = "UPDATE class_session SET capacity = capacity - 1 WHERE class_id = '$class_id'";
            $deductCapacityResult = mysqli_query($conn, $deductCapacityQuery);

            if ($deductCapacityResult) {
                echo '<script>alert("Class added successfully!"); window.location.href = "schedule.php";</script>';
            } else {
                echo '<script>alert("Error deducting capacity: ' . mysqli_error($conn) . '");</script>';
            }
        } else {
            echo '<script>alert("Error adding class: ' . mysqli_error($conn) . '");</script>';
        }
    }

    // Close the database connection
    mysqli_close($conn);
}

// Function to get member_name based on member_id
function getMemberName($conn, $member_id) {
    $query = "SELECT member_name FROM member WHERE member_id = '$member_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['member_name'];
    }

    return ""; // Return an empty string if member_name not found
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
    <?php include 'navbar.php'; ?>

    <div class="row d-flex align-items-center justify-content-center" style="border-top: 2px solid #e0e0e0;">
        <h1 class="mt-3 py-3" style="font-size:50px; font-weight:bolder;">Confirmation of Add Class</h1>
    </div>

    <div class="row d-flex align-items-center justify-content-center py-5" style="height:auto;">
        <div class="col-md-6">
			 <form method="post" action="">
				<?php if (isset($title)) : ?>
					<input type="hidden" name="member_id" value="<?php echo $_SESSION['member_id']; ?>">
					<input type="hidden" name="title" value="<?php echo $title; ?>">
					<input type="hidden" name="date" value="<?php echo $date; ?>">
					<input type="hidden" name="time" value="<?php echo $time; ?>">

					<!-- Display class details -->
					<div class="mb-3">
						<strong>Class Title:</strong> <?php echo $title; ?>
					</div>
					<div class="mb-3">
						<strong>Date:</strong> <?php echo $date; ?>
					</div>
					<div class="mb-3">
						<strong>Time:</strong> <?php echo formatTime($time); ?>
					</div>
				<?php else : ?>
					<p>No class details available.</p>
				<?php endif; ?>

				<!-- Add any additional fields or styling as needed -->

				<button type="submit" class="btn" >Yes</button>
			</form>

			<?php
			function formatTime($time)
			{
				list($start, $end) = explode('-', $time);

				list($startHours, $startMinutes) = explode(':', $start);
				list($endHours, $endMinutes) = explode(':', $end);

				$startPeriod = ($startHours < 12) ? 'AM' : 'PM';
				$endPeriod = ($endHours < 12) ? 'AM' : 'PM';

				$startHours = ($startHours > 12) ? $startHours - 12 : $startHours;
				$endHours = ($endHours > 12) ? $endHours - 12 : $endHours;

				return $startHours . ':' . $startMinutes . ' ' . $startPeriod . ' - ' . $endHours . ':' . $endMinutes . ' ' . $endPeriod;
			}
			?>


        </div>
    </div>

    <!-- Include jQuery, Popper.js, and Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

<?php include 'footer.php'; ?>

</html>
