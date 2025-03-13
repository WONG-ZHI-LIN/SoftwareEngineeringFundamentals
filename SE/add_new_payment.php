
<!DOCTYPE html>
<html>
<head>
<title>New Payment Record</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" 
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,800&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />
<style>



span
{
	padding:5px;
}

body
{
	font-family: 'Poppins', sans-serif;
	margin: 0;
}

.title
{
	text-align:center;
	margin-top:1rem;
}

.main
{
  max-width:70vw;
  margin: auto;
  padding: 10px;
}

    th
	{
		font-size:20px;
		width:30%;
		text-align:center;
	}
	tr
	{
		width:70%;
		text-align:center;
	}
	#btn
	{
		float:right;
	}
	.password-input {
    position: relative;
	}

	.password-input i {
		position: absolute;
		top: 50%;
		right: 10px;
		transform: translateY(-50%);
		cursor: pointer;
	}

	.password-input input[type="password"] {
		padding-right: 30px;
	}

</style>
</head>
<body>
<?php include 'topbar.php' ;?>


<?php
include 'PApage_login.php';

// Your PHP code for handling form submission
$errors = []; // Initialize an array to store validation errors

if (isset($_POST['submit'])) {
    require 'config.php';

    $mid = $_POST['mid'];
    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    $cname = mysqli_real_escape_string($conn, $_POST['cname']);
    $cnum = mysqli_real_escape_string($conn, $_POST['cnum']);
    $package = mysqli_real_escape_string($conn, $_POST['package']);
    $exdate = $_POST['exdate'];
    $cvv = $_POST['cvv'];
    $payment_method = $_POST['payment_method'];

    // Extract duration month using regular expression
    preg_match('/(\d+) Month/', $package, $matches);
    $duration_month = $matches[1];

    // Get the current date
    $currentDate = date('Y-m-d');

    // Calculate the package expiration date
    $expirationDate = date('Y-m-d', strtotime("+$duration_month months", strtotime($currentDate)));

    // Validate inputs
    if (empty($mname)) {
        $errors[] = 'Trainer name is required.';
    }

    // Perform additional validation for other fields as needed

    // Check if there are any errors
    if (empty($errors)) {
        $insertQuery = "INSERT INTO payment (member_id, date, member_name, card_name, card_num, expiration_date, cvv, package_name, method, package_exdate) VALUES ('$mid', '$currentDate', '$mname', '$cname', '$cnum', '$exdate', '$cvv', '$package', '$payment_method', '$expirationDate')";

        if (mysqli_query($conn, $insertQuery)) {
            echo "
                <script>
                    // Show a success alert
                    alert('New payment record added successfully!');
                    window.location.href = 'add_new_payment.php';
                </script>
            ";
        } else {
            echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
        }
    } else {
        // Output errors or handle them in some way
        foreach ($errors as $error) {
            echo "<p>Error: $error</p>";
        }
    }

    // Close the connection
    mysqli_close($conn);
}
?>





<div class="main">


						<div class="title">
                            <h1>Add New Payment Record</h1>
                        </div>
<form name="booking frm" method="post">
    <table class="table tableInfo">
	
		<tr>
		  <th>Member ID</th>
		  <td><input type="text" class="form-control" name="mid" id="mid" >
		</tr>
	
	
        <tr>
		  <th>Member Name</th>
		  <td><input type="text" class="form-control" name="mname" id="mname" placeholder="John Doe">
		</tr>
		
		 <tr>
            <th>Payment Method</th>
            <td>
                <select class="form-control" name="payment_method" id="payment_method" onchange="toggleCardFields()">
                    <option value="none" selected disabled hidden>Select Payment Method</option>
                    <option value="Debit Card">Debit Card</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="Cash">Cash</option>
                </select>
            </td>
        </tr>

		
		 <tr>
            <th>Name on Card</th>
            <td><input type="text" class="form-control" name="cname" id="cname" placeholder="John Doe"></td>
        </tr>
        <tr>
            <th>Card Number</th>
            <td><input type="text" class="form-control" name="cnum" id="cnum" placeholder="XXXX XXXX XXXX XXXX" pattern="[0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}"></td>
        </tr>
        <tr>
            <th>Expiration Date</th>
            <td><input type="text" class="form-control" id="expiration_month" name="exdate" placeholder="MM/YYYY" pattern="(0[1-9]|1[0-2])\/20[2-9][0-9]"></td>
        </tr>
        <tr>
            <th>CVV</th>
            <td><input type="text" class="form-control" id="cvv" name="cvv" placeholder="XXX" pattern="[0-9]{3}"></td>
        </tr>
		
		<tr>
    <th>Fitness Package</th>
    <td>
        <select class="form-control" name="package" id="package">
            <?php
            // Your database connection code goes here

            // Replace 'your_table_name' with the actual name of your database table
            $query = "SELECT package_name,duration_month, price FROM fitness_package";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
               while ($row = mysqli_fetch_assoc($result)) {
				$package_name = $row['package_name'];
				$duration_month = $row['duration_month'];
				$price = $row['price'];

				$optionValue = $package_name . ' ' . $duration_month . ' Month Plan RM' . $price;

				echo '<option value="' . $optionValue . '">' . $optionValue . '</option>';
			}

            } else {
                echo '<option value="">No packages available</option>';
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
        </select>
    </td>
</tr>

		
					
    </table>

    <div class="mb-3 submit d-flex justify-content-between">
		        <a href="payment_record.php" class="btn btn-secondary">Back</a>
				<button type="submit" class="btn btn-primary" id="btn" name="submit">Done</button>
	</div>
</form>

    </div>

</body>
</html>

<script>
    function toggleCardFields() {
        var paymentMethod = document.getElementById("payment_method");
        var cardName = document.getElementById("cname");
        var cardNumber = document.getElementById("cnum");
        var expirationDate = document.getElementById("expiration_month");
        var cvv = document.getElementById("cvv");

        if (paymentMethod.value === "Cash") {
            cardName.disabled = true;
            cardNumber.disabled = true;
            expirationDate.disabled = true;
            cvv.disabled = true;
        } else {
            cardName.disabled = false;
            cardNumber.disabled = false;
            expirationDate.disabled = false;
            cvv.disabled = false;
        }
    }
</script>
