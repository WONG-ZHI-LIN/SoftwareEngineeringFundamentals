<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Add this in the head section of your HTML file -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Custom styles for larger font size in the navbar */
        .navbar-nav .nav-link {
            font-size: 18px;
            /* Adjust the font size as needed */
        }

        .card {
            border-style: solid;
            border-width: 2px;
        }
    </style>
    <title>Fitness Pro</title>
</head>

<body>
    <!-- navbar -->
    <?php include 'navbar.php'; ?>

    <div class="row mt-5 mb-5">
        <h1 class="container" style="
            font-size:30px; 
            font-weight:bolder
        ;">
            Track Your Fitness Progress Now!
        </h1>
    </div>
		  <?php
		require 'config.php';
		$memberId=$_SESSION['member_id'];
			// Assuming you have a function to calculate BMI
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
		// Fetch member details
		$memberQuery = "SELECT * FROM member WHERE member_id = '$memberId'";
		$memberResult = mysqli_query($conn, $memberQuery);

		if ($memberResult && mysqli_num_rows($memberResult) > 0) {
			$memberRow = mysqli_fetch_assoc($memberResult);

			$height = $memberRow['height'];
			$initialWeight = $memberRow['initial_weight'];
			$currentWeight = $memberRow['current_weight'];
			$targetWeight = $memberRow['target_weight'];
			$totalWeightLost = $initialWeight - $currentWeight;
			$remainingWeight = $currentWeight-$targetWeight;
			
			
			// Assuming you have a function to calculate BMI
			$bmi = calculateBMI($currentWeight, $memberRow['height']);
			// Get BMI status using the function
			$bmistatus = getBMIStatus($bmi);

			

		} else {
			// Handle case when member is not found
			echo "<script>alert('Member not found');</script>";
			echo "<script>window.location.href='member_list.php';</script>";
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
			$daysDifference = floor((strtotime($currentDate) - strtotime($latestPaymentDate)) / (60 * 60 * 24)+1);
			
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
                <div class="col">
                    <div class="card w-75 mx-auto mt-3 mb-3">
                        <div class="card-body text-center">
                            <h5 class="card-title">Initial Weight</h5>
                            <h3 class="card-text" style="font-weight: bolder;"><?php echo $initialWeight; ?>kg</h3>
                        </div>
                    </div>
                </div>
                <div class="col">
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
                        <p class="d-inline ml-2" style="font-size: 30px; font-weight:bold;"><?php echo $totalWeightLost; ?>kg</p>
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
            </div>
        </div>
    </div>
</div>


    <div class="container">
        <div class="row mt-5 mb-5">
            <h1 class="container" style="
            font-size:30px; 
            font-weight:bolder
        ;">
                Weight Tracker History
            </h1>
        </div>

        <table class="table mb-5">
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

    </div>

    <?php include 'footer.php'; ?>

    <!-- Include jQuery, Popper.js, and Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>