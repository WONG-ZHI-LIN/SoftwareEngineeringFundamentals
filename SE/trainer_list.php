<?php
require 'config.php';

// Update trainer details
if (isset($_POST['update'])) {
    $trainerId = $_POST['trainer_id'];
    $trainerName = mysqli_real_escape_string($conn, $_POST['trainer_name']);
	$id = mysqli_real_escape_string($conn, $_POST['id']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = $_POST['phone'];
    $level = $_POST['teaching_level'];
    $pass = $_POST['password'];


    // Validate phone number format
    if (!preg_match('/^\d{3}-\d{7}$/', $phone)) {
        echo "<script>alert('Invalid phone number format.Please use XXX-XXXXXXX');</script>";
        echo "<script>window.location.href='trainer_list.php?edit=$trainerId';</script>";
        exit();
    }

   $updateQuery = "UPDATE trainer SET trainer_name='$trainerName', id='$id', phone='$phone', address='$address', `teaching level`='$level', pass='$pass' WHERE trainer_id='$trainerId'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        echo "<script>alert('Trainer details updated successfully');</script>";
        echo "<script>window.location.href='trainer_list.php';</script>";
    } else {
        echo "Error: " . $updateQuery . "<br>" . mysqli_error($conn);
    }
}

// Delete trainer
if (isset($_GET['delete'])) {
    $trainerId = $_GET['delete'];
    $deleteQuery = "DELETE FROM trainer WHERE trainer_id = '$trainerId'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        echo "<script>alert('trainer deleted successfully');</script>";
        echo "<script>window.location.href='trainer_list.php';</script>";
    } else {
        echo "<script>alert('Failed to delete trainer');</script>";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Trainer List</title>
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
<?php include 'topbar.php'; ?>

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

    // Delete trainers
    if (isset($_POST['delete_trainers'])) {
        $selectedtrainers = $_POST['selected_trainers'];
        $trainerIds = implode(",", $selectedtrainers);

        $deleteQuery = "DELETE FROM trainer WHERE trainer_id IN ($trainerIds)";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        if ($deleteResult) {
            echo "<script>alert('trainers deleted successfully');</script>";
            echo "<script>window.location.href='trainer_list.php';</script>";
        } else {
            echo "<script>alert('Failed to delete trainers');</script>";
        }
    }
    ?>

    <h1>Trainer List</h1>
   <div class="search-container">
    <input id="search" type="text" placeholder="Search..." class="form-control">
    <button type="text" class="btn btn-primary " id="btn"><a href="add_new_trainer.php">Add New Trainer</a></button>
	</div>

    <br><br>
	
	<?php

if (isset($_GET['edit'])) {
    $trainerId = $_GET['edit'];
    $editQuery = "SELECT * FROM trainer WHERE trainer_id = '$trainerId'";
    $editResult = mysqli_query($conn, $editQuery);
    $row = mysqli_fetch_assoc($editResult);
    $trainerName = mysqli_real_escape_string($conn, $row['trainer_name']);
	$id = mysqli_real_escape_string($conn, $row['id']);
    $address = mysqli_real_escape_string($conn, $row['address']);
    $phone = $row['phone'];
    $level = $row['teaching level'];
    $pass = $row['pass'];

    // Display the edit form
    echo '
    <div class="edit-trainer-form">
        <h2>Edit Trainer Details</h2>
        <form action="" method="post">
            <input type="hidden" class="form-control" name="trainer_id" value="' . $trainerId . '">
            <label for="trainer_name">Trainer Name:</label>
            <input type="text" class="form-control" name="trainer_name" value="' . $trainerName . '" required><br>
			<label for="id">Identity Number:</label>
            <input type="text" class="form-control" name="id" value="' . $id . '" required><br>
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" name="phone" value="' . $phone . '" pattern="\d{3}-\d{7}" required><br>
            <label for="address">Address:</label>
            <input type="text" class="form-control" name="address" value="' . $address . '" required><br>
           <label for="teaching_level">Teaching Level:</label>
			<select class="form-control" name="teaching_level" required>
				<option value="Junior" ' . ($level === 'Junior' ? 'selected' : '') . '>Junior</option>
				<option value="Senior" ' . ($level === 'Senior' ? 'selected' : '') . '>Senior</option>
				<option value="Probation period" ' . ($level === 'Probation period' ? 'selected' : '') . '>Probation period</option>
			</select><br>

            <label for="password">Password:</label>
            <input type="text" class="form-control" name="password" value="' . $pass . '" required>
            <div id="btn">
                <button type="submit" name="update" class="btn btn-primary float-right">Update</button>
                <a href="trainer_list.php" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
    ';
}


else {
        // Show the table
        $query = "SELECT * FROM trainer";
        $result = mysqli_query($conn, $query);
        ?>
		
		<div id="noDataFoundMessage" style="display: none; text-align: center; margin-top: 10px; color: red;">
			- No data matched - 
		</div>

          <form action="" method="post">
	
	    
        <table border="2" align="center" id="myTable">
            <tr class="header">
                <th>No</th>
                <th>Trainer Name</th>
				<th>Identity Number</th>
				<th>Address</th>
                <th>Phone Number</th>
				<th>Teaching Level</th>              
                <th colspan="2">Action</th>
                <th>Select</th>
            </tr>
            <?php
            $i = 0;
            while ($row = mysqli_fetch_array($result)):
                ?>
                <tr>
                    <td><?php echo $i + 1; ?></td>
                    <td><?php echo $row['trainer_name']; ?></td>
                    <td><?php echo $row['id']; ?></td>
					<td><?php echo $row['address']; ?></td>
					<td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['teaching level']; ?></td>
                    <td class="edit"><a href="trainer_list.php?edit=<?php echo $row['trainer_id']; ?>"><span class="fas fa-edit"
                                                                                                        style="color:green;"></span></a>
                    </td>
                    <td class="delete"><a href="trainer_list.php?delete=<?php echo $row['trainer_id']; ?>"><span class="fas fa-trash"
                                                                                                            style="color:red;"></span></a>
                    </td>
                    <td>
                        <input type="checkbox" name="selected_trainers[]" value="<?php echo $row['trainer_id']; ?>">
                    </td>
                </tr>
                <?php
                $i++;
            endwhile;
            ?>
        </table>
        <br>
        <button type="submit" name="delete_trainers" class="btn btn-danger" style="float: right; margin-top:20px; margin-bottom:20px;">Delete Selected trainers</button>

    </form>
		
        <?php
    }
    ?>

</div>
</body>
</html>





