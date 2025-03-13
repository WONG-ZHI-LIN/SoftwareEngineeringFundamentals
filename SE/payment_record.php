<?php
require 'config.php';

// Update payment details
if (isset($_POST['update'])) {
    $paymentId = $_POST['payment_id'];
    $mid = $_POST['mid'];
    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    $cname = mysqli_real_escape_string($conn, $_POST['cname']);
    $cnum = mysqli_real_escape_string($conn, $_POST['cnum']);
    $package = mysqli_real_escape_string($conn, $_POST['package']);
    $exdate = $_POST['exdate'];
    $cvv = $_POST['cvv'];
    $payment_method = $_POST['payment_method'];
    $date = $_POST['date'];

    // Extract duration month using regular expression
    preg_match('/(\d+) Month/', $package, $matches);
    $duration_month = $matches[1];

    // Get the current date
    $currentDate = date('Y-m-d');

    // Calculate the new expiration date
    $newExpirationDate = date('Y-m-d', strtotime("+$duration_month months", strtotime($currentDate)));

    $updateQuery = "UPDATE payment SET member_id='$mid', date='$date', member_name='$mname', card_name='$cname', card_num='$cnum',
    expiration_date='$exdate', cvv='$cvv', package_name='$package', method='$payment_method', package_exdate='$newExpirationDate' WHERE payment_id='$paymentId'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        echo "<script>alert('Payment details updated successfully');</script>";
        echo "<script>window.location.href='payment_record.php';</script>";
    } else {
        echo "Error: " . $updateQuery . "<br>" . mysqli_error($conn);
    }
}


// Delete payment
if (isset($_GET['delete'])) {
    $paymentId = $_GET['delete'];
    $deleteQuery = "DELETE FROM payment WHERE payment_id = '$paymentId'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        echo "<script>alert('payment deleted successfully');</script>";
        echo "<script>window.location.href='payment_record.php';</script>";
    } else {
        echo "<script>alert('Failed to delete payment');</script>";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Payment Record List</title>
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

    // Delete payments
    if (isset($_POST['delete_payments'])) {
        $selectedpayments = $_POST['selected_payments'];
        $paymentIds = implode(",", $selectedpayments);

        $deleteQuery = "DELETE FROM payment WHERE payment_id IN ($paymentIds)";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        if ($deleteResult) {
            echo "<script>alert('Payments deleted successfully');</script>";
            echo "<script>window.location.href='payment_record.php';</script>";
        } else {
            echo "<script>alert('Failed to delete payments');</script>";
        }
    }
    ?>

    <h1>Payment Record List</h1>
   <div class="search-container">
    <input id="search" type="text" placeholder="Search..." class="form-control">
    <button type="text" class="btn btn-primary " id="btn"><a href="add_new_payment.php">Add New Payment Record</a></button>
	</div>

    <br><br>
	
	<?php

if (isset($_GET['edit'])) {
    $paymentId = $_GET['edit'];
    $editQuery = "SELECT * FROM payment WHERE payment_id = '$paymentId'";
    $editResult = mysqli_query($conn, $editQuery);
    $row = mysqli_fetch_assoc($editResult);
    $mid = $row['member_id'];
    $mname = mysqli_real_escape_string($conn, $row['member_name']);
    $cname = mysqli_real_escape_string($conn, $row['card_name']);
    $package = mysqli_real_escape_string($conn, $row['package_name']);
    $exdate = $row['expiration_date'];
    $cvv = $row['cvv'];
    $method = $row['method'];
    $cnum = $row['card_num'];
	$date=$row['date'];

    // Default values if fields are empty
    $mid = !empty($mid) ? $mid : '-';
    $mname = !empty($mname) ? $mname : '-';
    $cname = !empty($cname) ? $cname : '-';
    $package = !empty($package) ? $package : '-';
    $exdate = !empty($exdate) ? $exdate : '-';
    $cvv = !empty($cvv) ? $cvv : '-';
    $method = !empty($method) ? $method : '-';
    $cnum = !empty($cnum) ? $cnum : '-';
	
	
	


    // Display the edit form
echo '
<div class="edit-payment-form">
    <h2>Edit Payment Details</h2>
    <form action="" method="post">
        <input type="hidden" class="form-control" name="payment_id" value="' . $paymentId . '">
        <label for="date">Purchase Date:</label>
        <input type="date" class="form-control" name="date" value="' . $date . '" required><br>
        <label for="member_name">Member ID:</label>
        <input type="text" class="form-control" name="mid" value="' . $mid . '" required><br>
        <label for="member_name">Member Name:</label>
        <input type="text" class="form-control" name="mname" value="' . $mname . '" required><br>
        <label for="payment_method">Payment Method:</label>
        <select class="form-control" name="payment_method" required>
            <option value="Debit Card" ' . ($method === 'Debit Card' ? 'selected' : '') . '>Debit Card</option>
            <option value="Credit Card" ' . ($method === 'Credit Card' ? 'selected' : '') . '>Credit Card</option>
            <option value="Cash" ' . ($method === 'Cash' ? 'selected' : '') . '>Cash</option>
        </select><br>
        <label for="card_name">Card Name:</label>
        <input type="text" class="form-control" name="cname" value="' . $cname . '" required><br>
        <label for="id">Card Number:</label>
        <input type="text" class="form-control" name="cnum" value="' . $cnum . '"  ><br>
        <label for="exdate">Expiration Date:</label>
        <input type="text" class="form-control" name="exdate" value="' . $exdate . '" ><br>
        <label for="cvv">CVV:</label>
        <input type="text" class="form-control" name="cvv" value="' . $cvv . '" ><br>';

// Fetch package data from the database
$packagesQuery = "SELECT package_name, duration_month, price FROM fitness_package ORDER BY price ASC";

$packagesResult = mysqli_query($conn, $packagesQuery);

// Check if there are any rows in the result set
if ($packagesResult && mysqli_num_rows($packagesResult) > 0) {
    echo '<label for="package">Fitness Package:</label>
          <select class="form-control" name="package" required>';

    while ($packageRow = mysqli_fetch_assoc($packagesResult)) {
		$package_name= $packageRow['package_name'];
        $optionValue = $packageRow['package_name'] . ' ' . $packageRow['duration_month'] . ' Month Plan RM' . $packageRow['price'];
        $isSelected = ($package === $optionValue) ? 'selected' : '';

        echo '<option value="' . $optionValue . '" ' . $isSelected . '>' . $optionValue . '</option>';
    }

    echo '</select><br>';
} else {
    echo '<p>No packages available</p>';
}

// Close the database connection
mysqli_close($conn);

echo '<div id="btn">
        <button type="submit" name="update" class="btn btn-primary float-right">Update</button>
        <a href="payment_record.php" class="btn btn-secondary">Back</a>
      </div>
    </form>
  </div>';

}


else {
        // Show the table
        $query = "SELECT * FROM payment";
        $result = mysqli_query($conn, $query);
        ?>
		
		<div id="noDataFoundMessage" style="display: none; text-align: center; margin-top: 10px; color: red;">
			- No data matched - 
		</div>

          <form action="" method="post">
	
	    
        <table border="2" align="center" id="myTable">
            <tr class="header">
                <th>No</th>
				<th>Purchase Date</th> 
                <th>Member Name</th>
				<th>Member ID</th>
                <th>Payment Method</th>
				<th>Fitness Package</th>	
				<th>Expired Date</th>	
                <th colspan="2">Action</th>
                <th>Select</th>
            </tr>
            <?php
            $i = 0;
            while ($row = mysqli_fetch_array($result)):
                ?>
                <tr>
                    <td><?php echo $i + 1; ?></td>
					<td><?php echo $row['date']; ?></td>
					<td><?php echo $row['member_name']; ?></td>
                    <td><?php echo $row['member_id']; ?></td>
					<td><?php echo $row['method']; ?></td>
					<td><?php echo $row['package_name']; ?></td>
					<td><?php echo $row['package_exdate']; ?></td>
                    <td class="edit"><a href="payment_record.php?edit=<?php echo $row['payment_id']; ?>"><span class="fas fa-edit"
                                                                                                        style="color:green;"></span></a>
                    </td>
                    <td class="delete"><a href="payment_record.php?delete=<?php echo $row['payment_id']; ?>"><span class="fas fa-trash"
                                                                                                            style="color:red;"></span></a>
                    </td>
                    <td>
                        <input type="checkbox" name="selected_payments[]" value="<?php echo $row['payment_id']; ?>">
                    </td>
                </tr>
                <?php
                $i++;
            endwhile;
            ?>
        </table>
        <br>
        <button type="submit" name="delete_payments" class="btn btn-danger" style="float: right; margin-top:20px; margin-bottom:20px;">Delete Selected Payments</button>

    </form>
		
        <?php
    }
    ?>

</div>
</body>
</html>





