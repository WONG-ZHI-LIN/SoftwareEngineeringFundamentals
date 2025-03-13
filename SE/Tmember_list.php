<?php
require 'config.php';

// Update member details
if (isset($_POST['update'])) {
    $memberId = $_POST['member_id'];
    $memberName = $_POST['member_name'];
    $initialWeight = $_POST['initial_weight'];
    $currentWeight = $_POST['current_weight'];
    $targetWeight = $_POST['target_weight'];
	$height = $_POST['height'];
    $muscle = $_POST['muscle'];
    $age = $_POST['age'];


    // Update member details
    $updateQuery = "UPDATE member SET 
                    member_name='$memberName', 
                    initial_weight='$initialWeight',
                    current_weight='$currentWeight',
                    target_weight='$targetWeight',
					height='$height',
                    muscle='$muscle',
                    age='$age'
                    WHERE member_id='$memberId'";
    
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Calculate BMI, remaining weight, and other values
        $bmi = number_format($currentWeight / (($height / 100) * ($height / 100)), 2);
        $totalWeightLoss = $initialWeight - $currentWeight;
        $remainingWeight = $currentWeight-$targetWeight;

        // Generate word and save to member_progress table
        $progressWord = date('m/d/Y') . " \nTotal Weight Loss: $totalWeightLoss kg\nRemaining Weight: $remainingWeight kg\nBMI: $bmi\nMuscle(%): $muscle";

        $insertProgressQuery = "INSERT INTO member_progress (member_id, progress) VALUES ('$memberId', '$progressWord')";
        $insertProgressResult = mysqli_query($conn, $insertProgressQuery);

        if ($insertProgressResult) {
            echo "<script>alert('Member details and progress updated successfully');</script>";
            echo "<script>window.location.href='member_list.php';</script>";
        } else {
            echo "<script>alert('Failed to update member details and progress');</script>";
        }
    } else {
        echo "<script>alert('Failed to update member details');</script>";
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
        h2{
            text-align:center;
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

        textarea.form-control {
            width: 100%;
            height: 100px; /* Set an appropriate height */
            resize: vertical; /* Allow vertical resizing */
        }
    </style>
</head>
<body>
<?php include 'ttopbar.php'; ?>
<h1> Member List</h1>
<div class="main">
    <?php
    if (isset($_GET['edit'])) {
        $memberId = $_GET['edit'];
        $editQuery = "SELECT * FROM member WHERE member_id = '$memberId'";
        $editResult = mysqli_query($conn, $editQuery);
        $row = mysqli_fetch_assoc($editResult);
        $memberName = $row['member_name'];
        $initialWeight = $row['initial_weight'];
        $currentWeight = $row['current_weight'];
		$targetWeight= $row['target_weight'];
		$height= $row['height'];
		$muscle= $row['muscle'];
        ?>

        <div class="edit-member-form">
            <h2>Edit Member Details</h2>
            <form action="" method="post">
    <input type="hidden" class="form-control" name="member_id" value="<?php echo $memberId; ?>">
    <label for="member_name">Member Name:</label>
    <input type="text" class="form-control" name="member_name" value="<?php echo $memberName; ?>" required><br>

    <label for="initial_weight">Initial Weight:</label>
    <input type="text" class="form-control" name="initial_weight" value="<?php echo $initialWeight; ?>"><br>

    <label for="current_weight">Current Weight:</label>
    <input type="text" class="form-control" name="current_weight" value="<?php echo $currentWeight; ?>"><br>

    <label for="target_weight">Target Weight:</label>
    <input type="text" class="form-control" name="target_weight" value="<?php echo $targetWeight; ?>"><br>
	
	 <label for="height">Height (cm) :</label>
    <input type="text" class="form-control" name="height" value="<?php echo $height; ?>"><br>

    <label for="muscle">Muscle(%):</label>
    <input type="text" class="form-control" name="muscle" value="<?php echo $muscle; ?>"><br>


    <div id="btn">
        <button type="submit" name="update" class="btn btn-primary float-right">Update</button>
        <button type="button" onclick="window.history.back()" class="btn btn-secondary float-right">Back</button>
    </div>
</form>

        </div>

        <?php
    } else {
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
                    </tr>
                    <?php
                    $i++;
                endwhile;
                ?>
            </table>
        </form>

        <?php
    }
    ?>

</div>
</body>
</html>
