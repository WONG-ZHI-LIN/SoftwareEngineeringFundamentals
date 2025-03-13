<?php
require 'config.php';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Member Analytic Report</title>
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
.header{
    text-align:center;
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

        textarea.form-control {
            width: 100%;
            height: 100px; /* Set an appropriate height */
            resize: vertical; /* Allow vertical resizing */
        }

        @media print {
        .print-hide {
            display: none;
        }
    }
    .btn-danger {
    background-color: red;
    color: white;
}

.btn-danger:hover {
    background-color: darkred;
}

@media print {

    @page {
        size: A4; /* Set paper size to A4 */
        margin: 10mm; /* Set margins for better layout on A4 paper */
    }

	.print-hide {
        display: none;
    }
    
    .col {
        width: 100%;
    }
  table {
        page-break-inside: avoid;
    }
  .containar2{
        page-break-before: always;
    }
}

    </style>
</head>
<body>
 <?php if (!isset($_GET['view'])): ?>
<?php include 'ttopbar.php'; ?>
<?php endif; ?>
<div class="header">
       
        <h2><?php echo 'Fitness Pro'; ?></h2>
        <p><?php echo'Persiaran Multimedia, ';?></p>
		<p><?php echo '63100 Cyberjaya, Selangor'; ?></p>
		<p><?php echo '0123456789'; ?></p>
    </div>
<div class="main">
    <h1>Member Analytic Report</h1>
	 <?php if (!isset($_GET['view'])): ?>
	   <div class="search-container">
			<input id="search" type="text" placeholder="Search..." class="form-control">
		</div>
	<?php endif; ?>


    <br><br>

    <?php if (isset($_GET['view'])): ?>
        <div class="view-member-details">
 <?php
	require 'config.php';

$memberId = $_GET['view'];

// Fetch member details
$memberQuery = "SELECT * FROM member WHERE member_id = '$memberId'";
$memberResult = mysqli_query($conn, $memberQuery);

if ($memberResult && mysqli_num_rows($memberResult) > 0) {
    $memberRow = mysqli_fetch_assoc($memberResult);

    function calculateBMI($weight, $height) {
        // Convert height to meters
        $heightInMeters = $height / 100;

        // Calculate BMI
        $bmi = $weight / ($heightInMeters * $heightInMeters);

        // Round to 2 decimal places
        $bmi = round($bmi, 2);

        return $bmi;
    }

    function getBMIStatus($bmi) {
        if ($bmi < 18.5) {
            return "Underweight";
        } elseif ($bmi >= 18.5 && $bmi < 24.9) {
            return "Normal";
        } elseif ($bmi >= 25 && $bmi < 29.9) {
            return "Overweight";
        } else {
            return "Obesity";
        }
    }

    function calculateBMR($weight, $height, $age, $gender) {
        if ($gender == 'Male') {
            $bmr = 88.362 + (13.397 * $weight) + (4.799 * $height) - (5.677 * $age);
        } else {
            $bmr = 447.593 + (9.247 * $weight) + (3.098 * $height) - (4.330 * $age);
        }
        return $bmr;
    }

    $height = $memberRow['height'];
    $initialWeight = $memberRow['initial_weight'];
    $currentWeight = $memberRow['current_weight'];
    $targetWeight = $memberRow['target_weight'];
    $totalWeightLost = $initialWeight - $currentWeight;
    $remainingWeight = $currentWeight - $targetWeight;
    $birthday = $memberRow['birthday'];
    $gender = $memberRow['gender'];

    // Get the current date
    $currentDate = new DateTime();

    // Convert the birthday string to a DateTime object
    $birthdayDate = new DateTime($birthday);

    // Calculate the difference between current date and birthday
    $ageInterval = $currentDate->diff($birthdayDate);

    // Get the years from the interval
    $age = $ageInterval->y;

    // Calculate BMR
    $bmr = calculateBMR($currentWeight, $height, $age, $gender);

    // Assuming you have a function to calculate BMI
    $bmi = calculateBMI($currentWeight, $height);

    // Get BMI status using the function
    $bmistatus = getBMIStatus($bmi);

} else {
    // Handle case when member is not found
    echo "<script>alert('Member not found');</script>";
    echo "<script>window.location.href='Tmember_list.php';</script>";
    exit(); // Stop further execution
}

// Fetch the latest payment date for the member
$paymentDateQuery = "SELECT MAX(date) AS latest_payment_date FROM payment WHERE member_id = '$memberId'";
$paymentDateResult = mysqli_query($conn, $paymentDateQuery);

if ($paymentDateResult && mysqli_num_rows($paymentDateResult) > 0) {
    $paymentDateRow = mysqli_fetch_assoc($paymentDateResult);
    $latestPaymentDate = $paymentDateRow['latest_payment_date'];

    // Calculate the number of days between the latest payment date and the current date
    $currentDate = date('Y-m-d');
    $daysDifference = floor((strtotime($currentDate) - strtotime($latestPaymentDate)) / (60 * 60 * 24) + 1);

    // Assign $days to the calculated difference
    $days = $daysDifference;
} else {
    // Handle the case when no payment date is found
    $days = 0;
}
		?>

		<div class="container">
    <div class="row">
        <div class="col">
            <div class="row">
			<div class="row print-hide">
                
                    <div class="card w-75 mx-auto mt-3 mb-3">
                        <div class="card-body text-center">
                            <h5 class="card-title">Initial Weight</h5>
                            <h3 class="card-text" style="font-weight: bolder;"><?php echo $initialWeight; ?>kg</h3>
                        </div>
                    
                </div>
			</div>
			<div class="row print-hide">
                
                    <div class="card w-75 mx-auto mt-3 mb-3">
                        <div class="card-body text-center">
                            <h5 class="card-title">Current Weight</h5>
                            <h3 class="card-text" style="font-weight: bolder;"><?php echo $currentWeight; ?>kg</h3>
                        </div>
                    </div>
                
            </div>
			</div>
            <div class="row">
                <div class="col">
                    <div class="card w-75 mx-auto mt-3 mb-3">
                        <div class="card-body text-center">
                            <h5 class="card-title">Target Weight</h5>
                            <h3 class="card-text" style="font-weight: bolder;"><?php echo $targetWeight; ?>kg</h3>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card w-75 mx-auto mt-3 mb-3">
                        <div class="card-body text-center">
                            <h5 class="card-title">Remaining</h5>
                            <h3 class="card-text" style="font-weight: bolder;"><?php echo $remainingWeight; ?>kg</h3>
                        </div>
                    </div>
                </div>
            </div>
			
			<div class="row">
                <div class="col">
                    <div class="card w-75 mx-auto mt-3 mb-3">
                        <div class="card-body text-center">
                            <h5 class="card-title">Height</h5>
                            <h3 class="card-text" style="font-weight: bolder;"><?php echo $height; ?>cm</h3>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card w-80 mx-auto mt-3 mb-3">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <h5 class="card-title d-inline">Total Weight Lost: </h5>
                        <h3 class="d-inline ml-2" style=" font-weight:bold;"><?php echo $totalWeightLost; ?>kg</h3>
                    </div>
			
                    <div class="progress mb-3" style="height: 30px; font-size:larger; font-weight:bold;">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo ($initialWeight - $currentWeight) / ($initialWeight - $targetWeight) * 100; ?>%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
							<?php echo round(($initialWeight - $currentWeight) / ($initialWeight - $targetWeight) * 100, 2); ?>%
						</div>

                    </div>
                    <p class="card-text" style="font-weight: light;">Days <?php echo $days; ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card w-80 mx-auto mt-3 mb-3">
                        <div class="card-body text-center">
                            <h5 class="card-title">BMI</h5>
                            <h3 class="card-text" style="font-weight: bolder;"><?php echo $bmi; ?></h3>
                            <p class="card-text" style="font-weight: light;"><?php echo $bmistatus; ?></p>
                        </div>
                    </div>
                </div>
				<div class="col">
                    <div class="card w-80 mx-auto mt-3 mb-3">
                        <div class="card-body text-center">
                            <h5 class="card-title">BMR</h5>
                            <h3 class="card-text" style="font-weight: bolder;"><?php echo number_format($bmr, 2); ?> kcal/day</h3>
                            <?php $bmr = calculateBMR($currentWeight, $height, $age, $memberRow['gender']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <div class="container">
        <div class="row mt-5 mb-5">
            <h1 class="container2" style="
            font-size:30px; 
            font-weight:bolder
        ;">
                Weight Tracker History
            </h1>
        </div>

       <table class="table mb-5" style="background-color: white;">
    <thead class="thead-light">
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Total Weight Loss</th>
            <th scope="col">Remaining Weight</th>
            <th scope="col">BMI</th>
            <th scope="col">Muscle</th>
        </tr>
    </thead>
    <tbody>
       <?php

		// Fetch member progress from member_progress table
		$memberProgressQuery = "SELECT * FROM member_progress WHERE member_id = '$memberId' ORDER BY progress_id DESC";
		$memberProgressResult = mysqli_query($conn, $memberProgressQuery);

		if ($memberProgressResult && mysqli_num_rows($memberProgressResult) > 0) {
			while ($progressRow = mysqli_fetch_assoc($memberProgressResult)) {


			// Split the progress word to extract data
			$progressData = explode("\n", $progressRow['progress']);
			

			// Extracting values
			$date = isset($progressData[0]) ? trim($progressData[0]) : '';
			$totalWeightLoss = '';
			$remainingWeight = '';
			$bmi = '';
			$muscle = '';

			if (isset($progressData[1])) {
				preg_match('/\d+(\.\d+)?/', $progressData[1], $totalWeightLossMatches);
				$totalWeightLoss = isset($totalWeightLossMatches[0]) ? $totalWeightLossMatches[0] : '';
			}

			if (isset($progressData[2])) {
				preg_match('/\d+(\.\d+)?/', $progressData[2], $remainingWeightMatches);
				$remainingWeight = isset($remainingWeightMatches[0]) ? $remainingWeightMatches[0] : '';
			}

			if (isset($progressData[3])) {
				preg_match('/\d+(\.\d+)?/', $progressData[3], $bmiMatches);
				$bmi = isset($bmiMatches[0]) ? $bmiMatches[0] : '';
			}

			if (isset($progressData[4])) {
				preg_match('/\d+(\.\d+)?/', $progressData[4], $muscleMatches);
				$muscle = isset($muscleMatches[0]) ? $muscleMatches[0] : '';
			}

			// Output the table row
			echo "<tr>
					<td>$date</td>
					<td>$totalWeightLoss kg</td>
					<td>$remainingWeight kg</td>
					<td>$bmi</td>
					<td>$muscle%</td>
				  </tr>";



			}

		} else {
			echo "<tr><td colspan='5'>No progress available.</td></tr>";
		}
		?>

    </tbody>
</table>



    <div id="btn" class="print-hide">
        <button type="button" onclick="window.history.back()" class="btn btn-secondary">Back</button>
        <button type="button" class="btn btn-danger" onclick="printInvoice()">Print Report</button>
    </div>
</form>


        </div>
    <?php else: ?>
        <!-- Show the table -->
        <form action="" method="post">
            <table border="2" align="center" id="myTable">
                <tr class="header">
                    <th>No</th>
                    <th>Member Name</th>
                    <th>Member Phone Number</th>
                    <th>Gender</th>
                    <th colspan="2">Action</th>
                </tr>
                <?php
                $query = "SELECT * FROM member";
                $result = mysqli_query($conn, $query);
                $i = 0;
                while ($row = mysqli_fetch_array($result)):
                    ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= $row['member_name'] ?></td>
                        <td><?= $row['phone'] ?></td>
                        <td><?= $row['gender'] ?></td>
                        <td class="view"><a href="member_analytic_report.php?view=<?= $row['member_id'] ?>"><span class="fas fa-file" style="color:green;"></span></a></td>
                    </tr>
                    <?php
                    $i++;
                endwhile;
                ?>
            </table>
        </form>
    <?php endif; ?>
</div>
<script>
     function printInvoice() {
            window.print();
        }
</script>
</body>
</html>
