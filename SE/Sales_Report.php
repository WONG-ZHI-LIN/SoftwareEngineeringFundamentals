<?php
require 'config.php';
include 'FApage_login.php';

// Fetch data from the database
$query = "SELECT package_name, COUNT(*) as sales_count FROM payment GROUP BY package_name";
$result = $conn->query($query);

// Initialize arrays to store labels and data for the chart
$labels = [];
$data = [];

// Process the query result
while ($row = $result->fetch_assoc()) {
    $labels[] = $row['package_name'];
    $data[] = $row['sales_count'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Member Analytics Report</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

        canvas {
            max-width: 80vw;
            margin: auto;
        }
    </style>
</head>
<body>
    <?php include 'FAtopbar.php'; ?>

    <div class="main">
        <div class="title">
            <h1>Fitness Package Sales Report</h1>
        </div>

        <!-- Canvas element for the chart -->
        <canvas id="salesChart"></canvas>

        <!-- Chart.js initialization script -->
       <script>
    // Dynamically fetched data from the PHP variables
			var packageData = {
				labels: <?php echo json_encode($labels); ?>,
				datasets: [{
					label: 'Sales',
					data: <?php echo json_encode($data); ?>,
					backgroundColor: generateRandomColors(<?php echo count($labels); ?>), // Automatically generate colors
					borderColor: '#fff',
					borderWidth: 1
				}]
			};

			function generateRandomColors(count) {
				var colors = [];
				for (var i = 0; i < count; i++) {
					var randomColor = 'rgba(' + getRandomInt(0, 255) + ',' + getRandomInt(0, 255) + ',' + getRandomInt(0, 255) + ', 0.5)';
					colors.push(randomColor);
				}
				return colors;
			}

			function getRandomInt(min, max) {
				return Math.floor(Math.random() * (max - min + 1)) + min;
			}

			var ctx = document.getElementById('salesChart').getContext('2d');
			var salesChart = new Chart(ctx, {
				type: 'pie', // Change the chart type to 'pie'
				data: packageData,
				options: {
					tooltips: {
						callbacks: {
							label: function (tooltipItem, data) {
								var dataset = data.datasets[tooltipItem.datasetIndex];
								var total = dataset.data.reduce(function (previousValue, currentValue, currentIndex, array) {
									return previousValue + currentValue;
								});
								var currentValue = dataset.data[tooltipItem.index];
								var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
								return percentage + "%";
							}
						}
					}
				}
			});
		</script>
    </div>
</body>
</html>
