<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Add this in the head section of your HTML file -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .date .btn-dark {
            font-size: 20px;
            width: 120px;
        }
        .card {
            border:none;
            border-top: 3px solid #18A0FB;
            border-radius: 0;
        }
    </style>
    <title>Fitness Class List</title>
</head>

<body>
    <!-- navbar -->
    <?php include 'navbar.php'; ?>

    <div class="row mt-5 mb-5">
        <h1 class="container" style="font-size:40px; font-weight:bolder;">Select a Date</h1>
    </div>
<?php

// Fetch data for the buttons from the database
$buttonQuery = "SELECT DISTINCT date FROM class_session WHERE date >= CURDATE() ORDER BY date ASC";
$buttonResult = mysqli_query($conn, $buttonQuery);

// Check if the query was successful
if ($buttonResult) {
    echo '<div class="row date mb-5">
            <div class="container d-grid d-md-flex">';

    // Display the fetched dates as buttons
    while ($buttonRow = mysqli_fetch_assoc($buttonResult)) {
        // Format the date as "Mon 1/1"
    $formattedDate = date('D j/n', strtotime($buttonRow['date']));

        echo '<button type="button" class="btn btn-dark mx-auto">
                ' . $formattedDate . '<br>
              </button>';
    }

    echo '</div></div>';
} else {
    // Display an error message if the query fails
    echo '<p>Error fetching data for buttons from the database</p>';
}

?>



    <div class="row class-list mt-5 mb-5">
        <div class="container d-flex">
<?php

// Include necessary files and establish a database connection (modify as needed)
require 'config.php';

// Get the current date
$currentDate = date('Y-m-d');

// Fetch data from the database, ordering by date in ascending order
$query = "SELECT class_id,title, des, date, time, capacity, publish_date FROM class_session WHERE date >= '$currentDate' ORDER BY date ASC";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Display the fetched data
    while ($row = mysqli_fetch_assoc($result)) {
        // Separate start and end times
        list($start, $end) = explode('-', $row['time']);

        // Extract hours and minutes for both start and end times
        list($startHours, $startMinutes) = explode(':', $start);
        list($endHours, $endMinutes) = explode(':', $end);

        // Determine AM or PM for start time
        $startPeriod = ($startHours < 12) ? 'AM' : 'PM';
        // Convert 24-hour format to 12-hour format for start time
        $startHours = ($startHours > 12) ? $startHours - 12 : $startHours;

        // Determine AM or PM for end time
        $endPeriod = ($endHours < 12) ? 'AM' : 'PM';
        // Convert 24-hour format to 12-hour format for end time
        $endHours = ($endHours > 12) ? $endHours - 12 : $endHours;

     echo '<div class="col-md-4">
        <div class="card bg-light" style="width: 20rem;">
            <div class="card-body">
                <h5 class="card-title mb-4">' . $row['title'] . '</h5>
                <h5 class="card-subtitle mb-3 text-muted">' . $startHours . ':' . $startMinutes . ' ' . $startPeriod . ' - ' . $endHours . ':' . $endMinutes . ' ' . $endPeriod . '</h5>
                <h6 class="card-subtitle mb-3 text-muted">' . date('d-m-Y', strtotime($row['date'])) . '</h6>
                <h5 class="card-title mb-3">' . $row['des'] . '</h5>
                <div class="text-center">
                    <button type="button" class="btn btn-link" onclick="window.location.href=\'add_class.php?title=' . urlencode($row['title']) . '&date=' . urlencode($row['date']) . '&time=' . urlencode($row['time']) . '&class_id=' . urlencode($row['class_id']) . '\'">Add Class</button>
                </div>
            </div>
        </div>
    </div>';



    }
} else {
    // Display an error message if the query fails
    echo '<p>Error fetching data from the database</p>';
}

// Close the database connection
mysqli_close($conn);

?>




        </div>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Include jQuery, Popper.js, and Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>