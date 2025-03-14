<?php
include 'page_login.php';

// Your PHP code for handling form submission
$errors = []; // Initialize an array to store validation errors

if (isset($_POST['submit'])) {
    require 'config.php';

    // Assuming you've set the 'member_id' in the session
    $mid = $_SESSION['member_id'];

    // Fetch member information based on 'member_id'
    $memberQuery = "SELECT * FROM member WHERE member_id = '$mid'";
    $memberResult = mysqli_query($conn, $memberQuery);

    if ($memberResult && $memberRow = mysqli_fetch_assoc($memberResult)) {
        $mname = $memberRow['member_name'];

        // Retrieve other member information as needed
    } else {
        echo "Error retrieving member information.";
        exit; // Stop execution if member info is not retrieved
    }

    // Get the package information based on 'package_id'
    $packageId = $_GET['package_id'];
    $packageQuery = "SELECT * FROM fitness_package WHERE package_id = '$packageId'";
    $packageResult = mysqli_query($conn, $packageQuery);

    if ($packageResult && $packageRow = mysqli_fetch_assoc($packageResult)) {
        $packageName = $packageRow['package_name'];
        $packagePrice = $packageRow['price'];
        $duration_month = $packageRow['duration_month'];

        // Formulate the new package name
        $formattedPackageName = "$packageName $duration_month Month Plan RM$packagePrice";

        // Retrieve other package information as needed
    } else {
        echo "Error retrieving package information.";
        exit; // Stop execution if package info is not retrieved
    }

    $cname = mysqli_real_escape_string($conn, $_POST['cname']);
    $cnum = mysqli_real_escape_string($conn, $_POST['cnum']);
    $exdate = $_POST['exdate'];
    $cvv = $_POST['cvv'];
	 $method = "credit card";

    // Get the current date
    $currentDate = date('Y-m-d');

    // Calculate the package expiration date
    $expirationDate = date('Y-m-d', strtotime("+$duration_month months", strtotime($currentDate)));

    // Validate inputs
    if (empty($mname)) {
        $errors[] = 'Member name is required.';
    }

    // Perform additional validation for other fields as needed

    // Check if there are any errors
    if (empty($errors)) {
        $insertQuery = "INSERT INTO payment (member_id, date,method, member_name, card_name, card_num, expiration_date, cvv, package_name, package_exdate) VALUES 
		('$mid', '$currentDate','$method', '$mname', '$cname', '$cnum', '$exdate', '$cvv', '$formattedPackageName', '$expirationDate')";

        if (mysqli_query($conn, $insertQuery)) {
            echo "
                <script>
                    window.location.href = 'tqPage.php';
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


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payment</title>
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
			margin-top: 20px;
            padding: 10px;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
		
		.package {
            max-width: 30vw;
            margin: auto;
			margin-top: 20px;
            padding: 10px;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
		
        th {
            font-size: 20px;
            width: 30%;
            text-align: center;
        }

        tr {
            width: 70%;
            text-align: center;
        }

        #btn {
            float: right;
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
  <?php include 'navbar.php'; ?>
<div class="main">
    <div class="title">
        <h2>Checkout Page</h2>
    </div>
    <div class="package">
	    <?php
        // Assuming you have already connected to the database

        if (isset($_GET['package_id'])) {
            $packageId = $_GET['package_id'];

            // Query to retrieve details of the selected package
            $query = "SELECT * FROM fitness_package WHERE package_id = '$packageId'";
            $result = mysqli_query($conn, $query);

            // Check if the query was successful
            if ($result && $row = mysqli_fetch_assoc($result)) {
                // Now you can use $row to access the details of the selected package
                $packageName = $row['package_name'];
                $packagePrice = $row['price'];
				$duration_month = $row['duration_month'];
                // Add more fields as needed

                // Display the selected package information (replace with your HTML structure)
				echo '<div class="container px-5">';
				echo '<p><strong>Selected Package: </strong></p>';
				echo "<p>{$packageName} ({$duration_month} month package)</p>";
				echo "<p><strong>Price: RM {$packagePrice}</strong></p>";
				echo '</div>';

                // Add more HTML for displaying other details
            } else {
                // Handle error or redirect to an error page
                echo "Error retrieving package details.";
            }
        } else {
            // Handle the case where the package_id parameter is not set
            echo "Package ID not provided.";
        }
        ?>
    </div>
    <div class="title">
        <h3>Payment Details</h3>
    </div>
    <form name="booking_frm" method="post">
        <table class="table tableInfo">
            <tr>
                <th>Name on Card</th>
                <td><input type="text" class="form-control" name="cname" id="pname" placeholder="" required></td>
            </tr>
            <tr>
                <th>Card Number</th>
                <td>
                    <input type="text" class="form-control" name="cnum" id="cardNumber" maxlength="19"
                           placeholder="1234 5678 1234 5678" oninput="formatCardNumber(this)" required>
                </td>
            </tr>

            <tr>
                <th>Expired Date</th>
 
					<td><input type="text" class="form-control" id="expiration_month" name="exdate" placeholder="MM/YYYY" pattern="(0[1-9]|1[0-2])\/20[2-9][0-9]"></td>
                      
        
            </tr>

            <tr>
                <th>CVV</th>
                <td>
                    <input type="text" class="form-control" name="cvv" id="cvv" maxlength="3"  placeholder="123" required>
                </td>
            </tr>

        </table>
        <div class="mb-3 submit d-flex justify-content-between">
                <a href="package.php" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary" name="submit">Purchase Now</button>


        </div>
    </form>
</div>

</body>
  <?php include 'footer.php'; ?>
  
  <script>
    function formatCardNumber(input) {
        // Remove non-numeric characters from input value
        let cardNumber = input.value.replace(/\D/g, '');

        // Format the card number with spaces after every 4 digits
        cardNumber = cardNumber.replace(/(\d{4})(?=\d)/g, '$1 ');

        // Update the input value with the formatted card number
        input.value = cardNumber;

        // Validate the card number format
        const cardNumberRegex = /^\d{4} \d{4} \d{4} \d{4}$/;
        const isValidFormat = cardNumberRegex.test(cardNumber);

        // Display or remove error message
        displayErrorMessage(isValidFormat);
    }

    function displayErrorMessage(isValidFormat) {
        const cardNumberInput = document.getElementById('cardNumber');
        const errorMessageId = 'cardNumberErrorMessage';

        // Remove existing error message
        const existingErrorMessage = document.getElementById(errorMessageId);
        if (existingErrorMessage) {
            existingErrorMessage.remove();
        }

        // If format is invalid, display error message
        if (!isValidFormat) {
            const errorMessage = document.createElement('p');
            errorMessage.id = errorMessageId;
            errorMessage.style.color = 'red';
            errorMessage.textContent = 'Invalid card number format. Please use the format: xxxx xxxx xxxx xxxx';
            cardNumberInput.parentNode.appendChild(errorMessage);
        }
    }
	
	function validateForm() {
    // Validate Name on Card
    const pnameInput = document.getElementById('pname');
    const pname = pnameInput.value.trim();
    if (pname === '') {
        alert('Please enter the name on the card.');
        return false;
    }

    // Validate Card Number
    const cardNumberInput = document.getElementById('cardNumber');
    const cardNumber = cardNumberInput.value.replace(/\D/g, ''); // Remove non-numeric characters
    if (cardNumber.length !== 16 || !/^\d+$/.test(cardNumber)) {
        alert('Please enter a valid 16-digit card number.');
        return false;
    }

    // Validate Expiry Date
    const cmonthInput = document.getElementById('cmonth');
    const cyearInput = document.getElementById('cyear');
    const cmonth = cmonthInput.value;
    const cyear = cyearInput.value;

    const currentDate = new Date();
    const currentYear = currentDate.getFullYear() % 100;
    const currentMonth = currentDate.getMonth() + 1; // Months are zero-based

    if (cyear < currentYear || (cyear === currentYear && cmonth < currentMonth)) {
        alert('Please enter a valid expiry date.');
        return false;
    }

    // Validate CVV
    const cvvInput = document.getElementById('cvv');
    const cvv = cvvInput.value;
    if (cvv.length !== 3 || !/^\d+$/.test(cvv)) {
        alert('Please enter a valid 3-digit CVV.');
        return false;
    }
    
     return true;
}


</script>
</html>
