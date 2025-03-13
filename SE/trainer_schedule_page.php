<?php
require 'config.php'; // Include the file with database connection
include("tPage_login.php"); // Include the file to set session variable $trainer_id

// Ensure $trainer_id is set
if (!isset($_SESSION['trainer_id'])) {
    // Handle the case where $trainer_id is not set (redirect, display error, etc.)
    exit("Trainer ID is not set.");
}

// Get the trainer ID from session
$trainer_id = $_SESSION['trainer_id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Trainer Schedule Page</title>
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
    span {
        padding: 5px;
    }
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }

    .today {
        background-color: #f0f0f0;
    }

    .event {
        background-color: #ffcccc;
        font-weight: bold;
        cursor: pointer; /* Add cursor pointer for clickable elements */
		width:200px;
    }

    h1 {
        text-align: center;
    }

    /* Adjusted styles for table cells */
    td {
        height: 60px; /* Adjust the height as needed */
        vertical-align: top; /* Align content at the top of the cell */
    }

    .event {
        height: auto; /* Allow event div to expand vertically */
    }
</style>
</head>
<body>
<?php include 'ttopbar.php'; ?>

<h1 class="text-center mt-4">Trainer Schedule Page</h1>

<div class="container mt-4">
    <form method="get" class="mb-4">
        <div class="form-group">
            <label for="month">Select Month:</label>
            <select class="form-control" id="month" name="month">
                <?php
                // Generate options for selecting months
                for ($i = 1; $i <= 12; $i++) {
                    $monthName = date("F", mktime(0, 0, 0, $i, 1));
                    $selected = ($i == $_GET['month']) ? 'selected' : '';
                    echo "<option value='$i' $selected>$monthName</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <?php
    // Get the selected month from the form or default to the current month
    $selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('n');
    $selectedYear = date('Y');

    // Get the number of days in the selected month
    $numDays = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear);

    // Get the first day of the selected month
    $firstDay = date('N', strtotime("$selectedYear-$selectedMonth-01"));

    // Create a table for the calendar
    echo "<table class='table table-bordered'>";
    echo "<thead><tr><th colspan='7'>" . date('F Y', strtotime("$selectedYear-$selectedMonth-01")) . "</th></tr>";
    echo "<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr></thead>";
    echo "<tbody>";

    // Start the first row
    echo "<tr>";

    // Add empty cells for days before the first day of the selected month
    for ($i = 1; $i < $firstDay; $i++) {
        echo "<td></td>";
    }

    // Loop through each day of the selected month
    for ($day = 1; $day <= $numDays; $day++) {
        // Fetch the class information for this day if the trainer name matches
        $classInfo = ""; // Initialize class info string
        $query = "SELECT class_id, title, time FROM class_session WHERE date = '$selectedYear-$selectedMonth-$day' AND tid = '$trainer_id'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
           $row = $result->fetch_assoc();
		$class_id = $row['class_id'];
		$classTitle = $row['title'];
		$classTime = $row['time'];

		// Extract start and end time from the classTime string
		$timeRange = explode('-', $classTime);
		$startTime = date('h:i A', strtotime($timeRange[0]));
		$endTime = date('h:i A', strtotime($timeRange[1]));

		$classInfo = "<div>$classTitle</div><div>$startTime - $endTime</div>";
		// Make the day cell clickable and link to attendance.php with date and class_id as parameters
		echo "<td class='event' onclick='showAttendance(\"$selectedYear-$selectedMonth-$day\", \"$class_id\")'>";

        } else {
            echo "<td>";
        }
        echo "<div>$day</div>";
        if (!empty($classInfo)) {
            echo "<div class='event'>$classInfo</div>"; // Display class title and time if available
        }
        echo "</td>";

        // Move to the next row if it's the last day of the week (Saturday)
        if (($day + $firstDay - 1) % 7 == 0) {
            echo "</tr><tr>";
        }
    }

    // Fill in empty cells at the end of the selected month
    for ($i = ($numDays + $firstDay - 1) % 7 + 1; $i <= 7; $i++) {
        echo "<td></td>";
    }

    // Close the table
    echo "</tr></tbody></table>";
    ?>

</div>

<!-- JavaScript to handle attendance page display -->
<script>
    function showAttendance(date, class_id) {
        window.location.href = "attendance.php?date=" + date + "&class_id=" + class_id;
    }
</script>

</body>
</html>
