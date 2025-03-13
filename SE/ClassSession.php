<?php
require 'config.php';

 include 'FApage_login.php';

// Update class details
if (isset($_POST['update'])) {
    $classId = $_POST['class_id'];
    $cname = $_POST['cname'];
    $cdes = $_POST['cdes'];
    $cdate = $_POST['cdate'];
    $cstart = $_POST['cstart'];
    $cend = $_POST['cend'];
    $cmax = $_POST['cmax'];
	$tname = $_POST['tname'];

    // Combine start and end time into a single string
    $ctime = $cstart . '-' . $cend;

   $updateQuery = "UPDATE class_session SET title=?, des=?, date=?, time=?, capacity=?, tname=? WHERE class_id=?";
	$updateStmt = mysqli_prepare($conn, $updateQuery);

	// Bind parameters
	mysqli_stmt_bind_param($updateStmt, "ssssiss", $cname, $cdes, $cdate, $ctime, $cmax, $tname, $classId);

	// Execute the statement
	$updateResult = mysqli_stmt_execute($updateStmt);

	// Check for success or failure
	if ($updateResult) {
		echo "<script>alert('Class details updated successfully');</script>";
		echo "<script>window.location.href='ClassSession.php';</script>";
	} else {
		echo "<script>alert('Failed to update class details');</script>";
	}

	// Close the statement
mysqli_stmt_close($updateStmt);}



// Delete class
if (isset($_GET['delete'])) {
    $classId = $_GET['delete'];
    $deleteQuery = "DELETE FROM class_session WHERE class_id = '$classId'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        echo "<script>alert('Class Session deleted successfully');</script>";
        echo "<script>window.location.href='ClassSession.php';</script>";
    } else {
        echo "<script>alert('Failed to delete class session');</script>";
    }
}

$trainerQuery = "SELECT trainer_name FROM trainer";
$trainerResult = mysqli_query($conn, $trainerQuery);
$trainerNames = array();

while ($trainerRow = mysqli_fetch_assoc($trainerResult)) {
$trainerNames[] = $trainerRow['trainer_name'];}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Class Session</title>
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
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }

        .title {
            text-align: center;
            margin-top: 1rem;
        }

        .main {
            max-width: 95vw;
            margin: auto;
            padding: 10px;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
		.main table {
            width: 100%;
            margin-top: 20px;
        }

        h1 {
            padding: 20px;
            text-align: center;
        }

        td a {
            color: black;
        }

        a {
            text-decoration: none !important;
            color: #fff;
        }

        table th {
            text-align: center;
            background-color: #ccc;
            border: 2px solid black;
        }

        table td {
            width: 80vw;
            text-align: center;
        }

        #btn {
            float: right;
            margin: 10px;
        }

        .main a:hover {
            color: black;
        }

        .edit a:hover {
            color: blue;
        }

        .delete a:hover {
            color: red;
        }

        #search {
            width: 50%;
        }

        .show {
            display: table-row !important;
        }
		.search-container {
		display: flex;
		align-items: center;
		justify-content: space-between;
		margin-bottom: 10px;
		}

    </style>
</head>
<body>
<?php include 'FAtopbar.php'; ?>

<div class="main">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
    $(document).ready(function () {
        $("#search").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            var noDataFound = true;

            $("#myTable tr:not(.header)").filter(function () {
                var isMatch = $(this).text().toLowerCase().indexOf(value) > -1;
                $(this).toggle(isMatch);

                if (isMatch) {
                    noDataFound = false;
                }
            });

            // Show "No data found" message if no matching rows
            if (noDataFound) {
                $("#noDataFoundMessage").show();
            } else {
                $("#noDataFoundMessage").hide();
            }
        });
    });
</script>

    <?php
    require 'config.php';

    // Delete class
    if (isset($_POST['delete_classes'])) {
        $selectedClass = $_POST['selected_classes'];
        $classIds = implode(",", $selectedClass);

        $deleteQuery = "DELETE FROM class_session WHERE class_id IN ($classIds)";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        if ($deleteResult) {
            echo "<script>alert('Class session deleted successfully');</script>";
            echo "<script>window.location.href='ClassSession.php';</script>";
        } else {
            echo "<script>alert('Failed to delete class');</script>";
        }
    }
    ?>

    <h1>Class Session List</h1>
   <div class="search-container">
    <input id="search" type="text" placeholder="Search..." class="form-control">
    <button type="text" class="btn btn-primary " id="btn"><a href="addClassSession.php">Add New Class Session</a></button>
	</div>

    <br><br>
	
	<?php
if (isset($_GET['edit'])) {
    $classId = $_GET['edit'];
    $editQuery = "SELECT * FROM class_session WHERE class_id = '$classId'";
    $editResult = mysqli_query($conn, $editQuery);
    $row = mysqli_fetch_assoc($editResult);

    $cname = $row['title'];
    $cdes = $row['des'];
    $cdate = $row['date'];
    $cmax = $row['capacity'];
    $ctime = $row['time'];
	$tname = $row['tname'];

    // Splitting combined time into start and end
    list($cstart, $cend) = explode('-', $ctime);
	
	// Fetch trainer names from the database
    $trainerQuery = "SELECT trainer_name FROM trainer";
    $trainerResult = mysqli_query($conn, $trainerQuery);
    $trainerNames = array();

    while ($trainerRow = mysqli_fetch_assoc($trainerResult)) {
        $trainerNames[] = $trainerRow['trainer_name'];
    }


    // Display the edit form
    echo '
    <div class="edit-member-form">
        <h2>Edit Class Details</h2>
        <form action="" method="post">
            <input type="hidden" class="form-control" name="class_id" value="' . $classId . '">
            
            <label for="cname">Class Name:</label>
            <input type="text" class="form-control" name="cname" value="' . $cname . '" required><br>
            
            <label for="cdes">Class Description:</label>
            <textarea class="form-control" name="cdes" required>' . $cdes . '</textarea><br>
            
            <label for="cdate">Class Date:</label>
            <input type="date" class="form-control" name="cdate" value="' . $cdate . '" required><br>
            
            <label for="ctime">Time:</label>
            <div class="row">
                <div class="col">
                    <input type="time" class="form-control" name="cstart" value="' . $cstart . '" placeholder="Start Time">
                </div>
                <div class="col">
                    <span>to</span>
                </div>
                <div class="col">
                    <input type="time" class="form-control" name="cend" value="' . $cend . '" placeholder="End Time">
                </div>
            </div><br>
            
            <label for="cmax">Class Maximum Capacity:</label>
            <input type="text" class="form-control" name="cmax" value="' . $cmax . '" required><br>
			
             <label for="cmax">Trainer Name:</label>
           <select class="form-control" name="tname" required>
            ';

// Populate select box options with trainer names from the database
foreach ($trainerNames as $trainer) {
    echo '<option value="' . $trainer . '" ' . ($tname == $trainer ? 'selected' : '') . '>' . $trainer . '</option>';
}

echo '
        </select><br>

        <div id="btn">
            <button type="submit" name="update" class="btn btn-primary float-right">Update</button>
            <button type="button" onclick="window.history.back()" class="btn btn-secondary float-right">Back</button>
        </div>
        </form>
    </div>
    ';
}




else {
        // Show the table
        $query = "SELECT * FROM class_session";
        $result = mysqli_query($conn, $query);
        ?>
		<div id="noDataFoundMessage" style="display: none; text-align: center; margin-top: 10px; color: red;">
			- No data matched - 
		</div>


          <form action="" method="post">
	
	
        <table border="2" align="center" id="myTable">
            <tr class="header">
                <th>No</th>
                <th>Class Name</th>
                <th>Class Description</th>
                <th>Date</th>
                <th>Time</th>
				<th>Class Maximum Capacity</th>
				<th>Create Date</th>
				<th>Trainer Name</th>
                <th colspan="2">Action</th>
                <th>Select</th>
            </tr>
            <?php
            $i = 0;
            while ($row = mysqli_fetch_array($result)):
                ?>
                <tr>
                    <td><?php echo $i + 1; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['des']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['time']; ?></td>
					<td><?php echo $row['capacity']; ?></td>
					<td><?php echo $row['publish_date']; ?></td>
					<td><?php echo $row['tname']; ?></td>
                    <td class="edit"><a href="ClassSession.php?edit=<?php echo $row['class_id']; ?>"><span class="fas fa-edit"
                                                                                                        style="color:green;"></span></a>
                    </td>
                    <td class="delete"><a href="ClassSession.php?delete=<?php echo $row['class_id']; ?>"><span class="fas fa-trash"
                                                                                                            style="color:red;"></span></a>
                    </td>
                    <td>
                        <input type="checkbox" name="selected_classes[]" value="<?php echo $row['class_id']; ?>">
                    </td>
                </tr>
                <?php
                $i++;
            endwhile;
            ?>
        </table>
        <br>
        <button type="submit" name="delete_classes" class="btn btn-danger" style="float: right; margin-top:20px; margin-bottom:20px;">Delete Selected Class</button>

    </form>
		
        <?php
    }
    ?>

</div>
</body>
</html>





