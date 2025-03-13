<?php
require 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Page</title>
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
        
    body {
    font-family: 'Poppins', sans-serif;
    margin: 0 auto; /* Center content horizontally with margin on left and right */
    max-width: 95vw; /* Limit maximum width of the content */
    margin-left: 40px;
    margin-right: 40px;
}

h2, p {
    text-align: center;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #f2f2f2;
}

.checkbox {
    margin-left: 10px;
}

.button-container {
    margin-top: 20px;
}

.button {
    display: inline-block;
    padding: 8px 12px;
    margin-right: 10px; /* Add right margin for spacing */
    background-color: red;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
}

.button2 {
    display: inline-block;
    padding: 8px 12px;
    margin-right: 10px; /* Add right margin for spacing */
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
}

.button:hover,.button2:hover {
    background-color: grey;
}

    </style>
    <script>
        function showPopup() {
            alert("Attendance saved successfully.");
        }
    </script>
</head>
<body>
<?php
require 'config.php';
include 'ttopbar.php';

// Get the class ID clicked by the trainer
$class_id = $_GET['class_id']; // assuming the class_id is passed via URL parameter

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    // Loop through submitted member IDs and update their presence status
    foreach ($_POST['member_id'] as $member_id) {
        $present = isset($_POST['present'][$member_id]) ? 1 : 0;
        // Update presence status in database
        $update_query = "UPDATE class_member SET present = $present WHERE class_id = $class_id AND member_id = $member_id";
        $conn->query($update_query);
    }
    echo "<script>showPopup();</script>";
}

// Query to get the class name, time, and capacity from the class_member and class_session tables
$sql_class_info = "SELECT cm.title, cm.time, cs.capacity
                    FROM class_member cm
                    INNER JOIN class_session cs ON cm.class_id = cs.class_id
                    WHERE cm.class_id = $class_id
                    LIMIT 1";

$result_class_info = $conn->query($sql_class_info);
$class_info = ($result_class_info->num_rows > 0) ? $result_class_info->fetch_assoc() : '';
$class_name = $class_info['title'];
$class_time = $class_info['time'];
$class_capacity = $class_info['capacity'];

// Query to get member ID and name for the specific class
$sql = "SELECT cm.member_id, cm.member_name, cm.present
        FROM class_member cm
        WHERE cm.class_id = $class_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row with checkbox for presence status
    echo "<h2>Attendance for $class_name</h2>";
    echo "<p>Time: $class_time</p>";
    echo "<p>Maximum Capacity: $class_capacity</p>"; // Displaying capacity
    echo "<form method='post'>";
    echo "<table>";
    echo "<tr><th>No.</th><th>Member ID</th><th>Member Name</th><th>Attendance</th></tr>";
    $count = 1; // Initialize member count
    while ($row = $result->fetch_assoc()) {
        $member_id = $row["member_id"];
        $member_name = $row["member_name"];
        $checked = $row["present"] == 1 ? "checked" : "";
        echo "<tr>";
        echo "<td>$count</td>"; // Display member count
        echo "<td>$member_id</td>";
        echo "<td>$member_name</td>";
        echo "<td><input type='checkbox' class='checkbox' name='present[$member_id]' value='1' $checked></td>";
        echo "<input type='hidden' name='member_id[]' value='$member_id'>";
        echo "</tr>";
        $count++; // Increment member count
    }
    echo "</table>";
    echo "<div class='button-container'>";
    echo "<input type='submit' name='save' value='Save Attendance' class='button'>";
    echo "<a href='trainer_schedule_page.php' class='button2'>Back to Schedule</a>";
    echo "</div>";
    echo "</form>";
} else {
    echo "0 results";
}

$conn->close();
?>

</body>
</html>
