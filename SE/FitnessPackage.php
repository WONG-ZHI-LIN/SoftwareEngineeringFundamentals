<?php
require 'config.php';

 include 'FApage_login.php';

// Update class details
if (isset($_POST['update'])) {
    $packageId = $_POST['package_id'];
    $fname = $_POST['fname'];
    $fdes = $_POST['fdes'];
	$fmax = $_POST['fmax'];
    $fprice = $_POST['fprice'];
	$fduration = $_POST['fduration'];

    $updateQuery = "UPDATE fitness_package SET package_name='$fname', des='$fdes', capacity='$fmax', price='$fprice', duration_month='$fduration' WHERE package_id='$packageId'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        echo "<script>alert('Fitness Package details updated successfully');</script>";
        echo "<script>window.location.href='FitnessPackage.php';</script>";
    } else {
        echo "<script>alert('Failed to update fitness package details');</script>";
    }
}


// Delete class
if (isset($_GET['delete'])) {
    $packageId = $_GET['delete'];
    $deleteQuery = "DELETE FROM fitness_package WHERE package_id = '$packageId'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        echo "<script>alert('Fitness Package deleted successfully');</script>";
        echo "<script>window.location.href='FitnessPackage.php';</script>";
    } else {
        echo "<script>alert('Failed to delete fitness package');</script>";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Fitness Package</title>
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
    if (isset($_POST['delete_package'])) {
        $selectedPackage = $_POST['selected_package'];
        $packageId = implode(",", $selectedPackage);

        $deleteQuery = "DELETE FROM fitness_package WHERE package_id IN ($packageId)";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        if ($deleteResult) {
            echo "<script>alert('Fitness Packagae deleted successfully');</script>";
            echo "<script>window.location.href='FitnessPackage.php';</script>";
        } else {
            echo "<script>alert('Failed to delete Fitness Package');</script>";
        }
    }
    ?>

    <h1>Fitness Package List</h1>
   <div class="search-container">
    <input id="search" type="text" placeholder="Search..." class="form-control">
    <button type="text" class="btn btn-primary " id="btn"><a href="addFitnessPackage.php">Add New Fitness Package</a></button>
	</div>

    <br><br>
	
	<?php
if (isset($_GET['edit'])) {
    $packageId = $_GET['edit'];
    $editQuery = "SELECT * FROM fitness_package WHERE package_id = '$packageId'";
    $editResult = mysqli_query($conn, $editQuery);
    $row = mysqli_fetch_assoc($editResult);

    $fname = $row['package_name'];
    $fdes = $row['des'];
    $fprice = $row['price'];
    $fmax = $row['capacity'];
    $fduration = $row['duration_month'];

    // Display the edit form
    echo '
    <div class="edit-package-form">
        <h2>Edit Fitness Package Details</h2>
        <form action="" method="post">
            <input type="hidden" class="form-control" name="package_id" value="' . $packageId . '">
            
            <label for="cname">Fitness Package Name:</label>
            <input type="text" class="form-control" name="fname" value="' . $fname . '" required><br>
            
            <label for="cdes">Fitness Package Description:</label>
            <textarea class="form-control" name="fdes" required>' . $fdes . '</textarea><br>
            
            <label for="fmax">Capacity:</label>
            <textarea class="form-control" name="fmax" required>' . $fmax . '</textarea><br>
            
            <label for="fprice">Price:</label>
            <textarea class="form-control" name="fprice" required>' . $fprice . '</textarea><br>

			<label for="fduration">Duration:</label>
            <textarea class="form-control" name="fduration" required>' . $fduration . '</textarea><br>
			
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
        $query = "SELECT * FROM fitness_package";
        $result = mysqli_query($conn, $query);
        ?>
		<div id="noDataFoundMessage" style="display: none; text-align: center; margin-top: 10px; color: red;">
			- No data matched - 
		</div>


          <form action="" method="post">
	
	
        <table border="2" align="center" id="myTable">
            <tr class="header">
                <th>No</th>
                <th>Fitness Package Name</th>
                <th>Fitness Package Description</th>
                <th>Capacity</th>
                <th>Price</th>
				<th>Duration Month</th>
                <th colspan="2">Action</th>
                <th>Select</th>
            </tr>
            <?php
            $i = 0;
            while ($row = mysqli_fetch_array($result)):
                ?>
                <tr>
                    <td><?php echo $i + 1; ?></td>
                    <td><?php echo $row['package_name']; ?></td>
                    <td><?php echo $row['des']; ?></td>
                    <td><?php echo $row['capacity']; ?></td>
                    <td><?php echo $row['price']; ?></td>
					<td><?php echo $row['duration_month']; ?></td>
                    <td class="edit"><a href="FitnessPackage.php?edit=<?php echo $row['package_id']; ?>"><span class="fas fa-edit" style="color:green;"></span></a>
                    </td>
                    <td class="delete"><a href="FitnessPackage.php?delete=<?php echo $row['package_id']; ?>"><span class="fas fa-trash" style="color:red;"></span></a>
                    </td>
                    <td>
                        <input type="checkbox" name="selected_package[]" value="<?php echo $row['package_id']; ?>">
                    </td>
                </tr>
                <?php
                $i++;
            endwhile;
            ?>
        </table>
        <br>
        <button type="submit" name="delete_package" class="btn btn-danger" style="float: right; margin-top:20px; margin-bottom:20px;">Delete Selected Package</button>

    </form>
		
        <?php
    }
    ?>

</div>
</body>
</html>





