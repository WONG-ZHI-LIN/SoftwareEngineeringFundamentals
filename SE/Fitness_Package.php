<?php
require 'config.php';

include 'page_login.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Fitness Package</title>
    <style>
        .pricing-container .list-group-item {
            font-size: 25px;
            font-weight: lighter;
            background-color: transparent;
        }

        .pricing-container .card {
            border: none;
            background: rgb(198,151,241);
            background: linear-gradient(311deg, rgba(198,151,241,1) 14%, rgba(0,255,209,1) 100%);
        }

        .pricing-container .btn {
            font-weight:bold;
            background: rgb(19,112,209);
            background: linear-gradient(311deg, rgba(19,112,209,1) 14%, rgba(0,255,209,1) 100%);
            border:none;
            border-radius:20px;
        }
    </style>
</head>
<body>

<div class="row mt-5 mb-3 d-flex align-items-center justify-content-center">
    <h1 class="text-center" style="font-size:50px; font-weight:bolder;">OUR PRICING</h1>
</div>

<?php
// Assuming $conn is the database connection
$query = "SELECT * FROM fitness_package";
$result = mysqli_query($conn, $query);

// Loop through the results
while ($row = mysqli_fetch_assoc($result)) {
    ?>
    <div class="row pricing-container py-5 px-5 d-flex align-items-center" style="height:auto;">
    <div class="col-sm-3 mx-auto">
        <div class="card">
            <div class="card-body text-center">
                <h1 class="card-title"><?php echo $row['package_name']; ?></h1>
                <p class="card-text" style="font-size: 25px; font-weight:lighter;"><?php echo $row['duration_month']; ?> Month Plan</p>
                <h4>RM <?php echo $row['price']; ?></h4>
                <ul class="list-group list-group-flush custom-list-background">
                    <?php
                    // Split the 'des' field into an array based on newline
                    $desArray = explode("\n", $row['des']);

                    // Loop through the array and create individual list items
                    foreach ($desArray as $item) {
                        echo '<li class="list-group-item">' . $item . '</li>';
                    }
                    ?>
                </ul>
               <a href="payment.php?package_id=<?php echo $row['package_id']; ?>" class="btn btn-primary mt-4 btn-lg">Subscribe Now</a>

            </div>
        </div>
    </div>
</div>

    <?php
}
?>

 <a href="payment_history.php" class="btn btn-primary mt-4 btn-lg">ow</a>

</body>
</html>
