<?php
require 'config.php';

include 'PAlogin.php';
// Update member details
if (isset($_POST['update'])) {
    $memberId = $_POST['member_id'];
    $memberName = $_POST['member_name'];
	$email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $password = $_POST['password'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format');</script>";
        echo "<script>window.location.href='member_list.php?edit=$memberId';</script>";
        exit();
    }

    // Validate phone number format
    if (!preg_match('/^\d{3}-\d{7}$/', $phone)) {
        echo "<script>alert('Invalid phone number format.Please use XXX-XXXXXXX');</script>";
        echo "<script>window.location.href='member_list.php?edit=$memberId';</script>";
        exit();
    }

    $updateQuery = "UPDATE member SET member_name='$memberName',email='$email', phone='$phone', gender='$gender', birthday='$birthday', pass='$password' WHERE member_id='$memberId'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        echo "<script>alert('Member details updated successfully');</script>";
        echo "<script>window.location.href='member_list.php';</script>";
    } else {
        echo "<script>alert('Failed to update member details');</script>";
    }
}

// Delete member
if (isset($_GET['delete'])) {
    $memberId = $_GET['delete'];
    $deleteQuery = "DELETE FROM member WHERE member_id = '$memberId'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        echo "<script>alert('Member deleted successfully');</script>";
        echo "<script>window.location.href='member_list.php';</script>";
    } else {
        echo "<script>alert('Failed to delete member');</script>";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Member List</title>
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

    // Delete members
    if (isset($_POST['delete_members'])) {
        $selectedMembers = $_POST['selected_members'];
        $memberIds = implode(",", $selectedMembers);

        $deleteQuery = "DELETE FROM member WHERE member_id IN ($memberIds)";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        if ($deleteResult) {
            echo "<script>alert('Members deleted successfully');</script>";
            echo "<script>window.location.href='member_list.php';</script>";
        } else {
            echo "<script>alert('Failed to delete members');</script>";
        }
    }
    ?>

    <h1>Member List</h1>
   <div class="search-container">
    <input id="search" type="text" placeholder="Search..." class="form-control">
    <button type="text" class="btn btn-primary " id="btn"><a href="add_new_member.php">Register New Member</a></button>
	</div>

    <br><br>
	
	<?php
   if (isset($_GET['edit'])) {
    $memberId = $_GET['edit'];
    $editQuery = "SELECT * FROM member WHERE member_id = '$memberId'";
    $editResult = mysqli_query($conn, $editQuery);
    $row = mysqli_fetch_assoc($editResult);
    $memberName = $row['member_name'];
    $email = $row['email'];
    $phone = $row['phone'];
    $gender = $row['gender'];
    $birthday = $row['birthday'];
    $password = $row['pass'];
   

    // Display the edit form
    echo '
    <div class="edit-member-form">
        <h2>Edit Member Details</h2>
        <form action="" method="post">
            <input type="hidden" class="form-control" name="member_id" value="' . $memberId . '">
            <label for="member_name">Member Name:</label>
            <input type="text" class="form-control" name="member_name" value="' . $memberName . '" required><br>
			<label for="email">Email:</label>
            <input type="email" class="form-control" name="email" value="' . $email . '" required><br>
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" name="phone" value="' . $phone . '" pattern="\d{3}-\d{7}" required><br>
            <label for="gender">Gender:</label>
            <input type="text" class="form-control" name="gender" value="' . $gender . '" required><br>
			<label for="birthday">Birthday:</label>
            <input type="date" class="form-control" name="birthday" value="' . $birthday . '" required><br>
            <label for="password">Password:</label>
            <input type="text" class="form-control" name="password" value="' . $password . '" required>
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
        $query = "SELECT * FROM member";
        $result = mysqli_query($conn, $query);
        ?>
		
		<div id="noDataFoundMessage" style="display: none; text-align: center; margin-top: 10px; color: red;">
			- No data matched - 
		</div>

          <form action="" method="post">
	
	    
        <table border="2" align="center" id="myTable">
            <tr class="header">
                <th>No</th>
                <th>Member Name</th>
				 <th>Member Email</th>
                <th>Member Phone Number</th>
                <th>Gender</th>
                <th>Birthday</th>
                <th colspan="2">Action</th>
                <th>Select</th>
            </tr>
            <?php
            $i = 0;
            while ($row = mysqli_fetch_array($result)):
                ?>
                <tr>
                    <td><?php echo $i + 1; ?></td>
                    <td><?php echo $row['member_name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
					<td><?php echo $row['birthday']; ?></td>
                    <td class="edit"><a href="member_list.php?edit=<?php echo $row['member_id']; ?>"><span class="fas fa-edit"
                                                                                                        style="color:green;"></span></a>
                    </td>
                    <td class="delete"><a href="member_list.php?delete=<?php echo $row['member_id']; ?>"><span class="fas fa-trash"
                                                                                                            style="color:red;"></span></a>
                    </td>
                    <td>
                        <input type="checkbox" name="selected_members[]" value="<?php echo $row['member_id']; ?>">
                    </td>
                </tr>
                <?php
                $i++;
            endwhile;
            ?>
        </table>
        <br>
        <button type="submit" name="delete_members" class="btn btn-danger" style="float: right; margin-top:20px; margin-bottom:20px;">Delete Selected Members</button>

    </form>
		
        <?php
    }
    ?>

</div>
</body>
</html>





