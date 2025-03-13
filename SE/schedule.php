<?php
require 'config.php';

// Ensure the user is logged in
include 'page_login.php';

$member_id = $_SESSION['member_id'];

// Fetch data from the class_member table for the current member
$query = "SELECT class_session.date, class_session.title, class_session.time, class_member.class_id, class_member.member_name
          FROM class_member
          JOIN class_session ON class_member.class_id = class_session.class_id
          WHERE class_member.member_id = '$member_id'";
$result = mysqli_query($conn, $query);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancelClass'])) {
    $classID = $_POST['classID'];

    // Delete the record from the class_member table
    $deleteQuery = "DELETE FROM class_member WHERE member_id = '$member_id' AND class_id = '$classID'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        // Update the capacity in class_session (add 1 since the member is canceled)
        $updateCapacityQuery = "UPDATE class_session SET capacity = capacity + 1 WHERE class_id = '$classID'";
        $updateCapacityResult = mysqli_query($conn, $updateCapacityQuery);

        if ($updateCapacityResult) {
            echo '<script>alert("Class canceled successfully!"); window.location.href = "schedule.php";</script>';
        } else {
            echo '<script>alert("Error updating capacity: ' . mysqli_error($conn) . '");</script>';
        }
    } else {
        echo '<script>alert("Error canceling class: ' . mysqli_error($conn) . '");</script>';
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
        /* Custom styles for larger font size in the navbar */
        .navbar-nav .nav-link {
            font-size: 18px;
            /* Adjust the font size as needed */
        }
    </style>
    <title>Fitness Pro</title>
</head>

<body>
    <!-- navbar -->
    <?php include 'navbar.php'; ?>

    <div class="row mt-5 mb-5">
        <h1 class="container" style="font-size:40px; font-weight:bolder;">My Class Schedule</h1>
    </div>

    <div class="container">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Session Name</th>
                    <th scope="col">Time</th>
                    <th scope="col">Member Name</th>
                    <th scope="col">Class Cancellation</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are rows in the result
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>
                                <th scope="row">' . $row['date'] . '</th>
                                <td>' . $row['title'] . '</td>
                                <td>' . $row['time'] . '</td>
                                <td>' . $row['member_name'] . '</td>
								<td>
									<form method="post" action="">
										<input type="hidden" name="classID" value="' . $row['class_id'] . '">
										<button type="submit" name="cancelClass" class="btn btn-link">Cancel</button>
									</form>
								</td>
                            </tr>';
                    }
                } else {
                    echo '<tr>
                            <td colspan="5">No classes found.</td>
                        </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Include jQuery, Popper.js, and Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>
