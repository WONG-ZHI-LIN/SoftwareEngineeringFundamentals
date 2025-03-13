<?php
require 'config.php';

 include 'FApage_login.php';

// Update class details
if (isset($_POST['update'])) {
    $announceId = $_POST['announce_id'];
    $atitle = $_POST['atitle'];
    $ades = $_POST['ades'];
	$adate = $_POST['adate'];
  

    // Combine start and end time into a single string
    $ctime = $cstart . '-' . $cend;

   $updateQuery = "UPDATE announcement SET title=?, des=?, date=? WHERE announce_id=?";
$stmt = mysqli_prepare($conn, $updateQuery);

// Bind parameters
mysqli_stmt_bind_param($stmt, "sssi", $atitle, $ades, $adate, $announceId);

// Execute the statement
mysqli_stmt_execute($stmt);

// Check for success
if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo "<script>alert('Announcement updated successfully');</script>";
    echo "<script>window.location.href='Announcement.php';</script>";
} else {
    echo "<script>alert('Failed to update announcement');</script>";
}

// Close the statement
mysqli_stmt_close($stmt);

}


// Delete class
if (isset($_GET['delete'])) {
    $announceId = $_GET['delete'];
    $deleteQuery = "DELETE FROM announcement WHERE announce_id = '$announceId'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        echo "<script>alert('Announcement deleted successfully');</script>";
        echo "<script>window.location.href='Announcement.php';</script>";
    } else {
        echo "<script>alert('Failed to delete announcement');</script>";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Announcement</title>
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
    if (isset($_POST['delete_announce'])) {
        $selectedAnnounce = $_POST['selected_announce'];
        $announceIds = implode(",", $selectedAnnounce);

        $deleteQuery = "DELETE FROM announcement WHERE announce_id IN ($announceIds)";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        if ($deleteResult) {
            echo "<script>alert('Announcement deleted successfully');</script>";
            echo "<script>window.location.href='Announcement.php';</script>";
        } else {
            echo "<script>alert('Failed to delete announcement');</script>";
        }
    }
    ?>

    <h1>Announcement List</h1>
   <div class="search-container">
    <input id="search" type="text" placeholder="Search..." class="form-control">
    <button type="text" class="btn btn-primary " id="btn"><a href="addAnnouncement.php">Add New Announcement</a></button>
	</div>

    <br><br>
	
	<?php
if (isset($_GET['edit'])) {
    $announceId = $_GET['edit'];
    $editQuery = "SELECT * FROM announcement WHERE announce_id = '$announceId'";
    $editResult = mysqli_query($conn, $editQuery);
    $row = mysqli_fetch_assoc($editResult);

    $atitle = $row['title'];
    $ades = $row['des'];
	$adate = $row['date'];


    // Display the edit form
    echo '
    <div class="edit-member-form">
        <h2>Edit Announcement</h2>
        <form action="" method="post">
            <input type="hidden" class="form-control" name="announce_id" value="' . $announceId . '">
            
            <label for="atitle">Title:</label>
            <input type="text" class="form-control" name="atitle" value="' . $atitle . '" required><br>
            
            <label for="cdes">Description:</label>
            <textarea class="form-control" name="ades" required>' . $ades . '</textarea><br>
			
			 <label for="cdate">Date:</label>
            <input type="date" class="form-control" name="adate" value="' . $adate . '" required><br>
           

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
        $query = "SELECT * FROM announcement";
        $result = mysqli_query($conn, $query);
        ?>
		<div id="noDataFoundMessage" style="display: none; text-align: center; margin-top: 10px; color: red;">
			- No data matched - 
		</div>


          <form action="" method="post">
	
	
        <table border="2" align="center" id="myTable">
            <tr class="header">
                <th>No</th>
                <th>Title</th>
                <th>Description</th>
				<th>Date</th>
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
                    <td class="edit"><a href="Announcement.php?edit=<?php echo $row['announce_id']; ?>"><span class="fas fa-edit" style="color:green;"></span></a>
                    </td>
                    <td class="delete"><a href="Announcement.php?delete=<?php echo $row['announce_id']; ?>"><span class="fas fa-trash" style="color:red;"></span></a>
                    </td>
                    <td>
                        <input type="checkbox" name="selected_announce[]" value="<?php echo $row['announce_id']; ?>">
                    </td>
                </tr>
                <?php
                $i++;
            endwhile;
            ?>
        </table>
        <br>
        <button type="submit" name="delete_announce" class="btn btn-danger" style="float: right; margin-top:20px; margin-bottom:20px;">Delete Selected Announcement</button>

    </form>
		
        <?php
    }
    ?>

</div>
</body>
</html>





