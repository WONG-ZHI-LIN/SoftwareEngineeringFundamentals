
<?php

require 'config.php';
?>
<!-- pricing_component.php -->
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
<div class="row mt-5 mb-3 d-flex align-items-center justify-content-center">
    <h1 class="text-center" style="font-size:50px; font-weight:bolder;">OUR PACKAGE</h1>
</div>
<div class="row pricing-container py-5 px-5 d-flex align-items-center" style="height:auto;">
<?php


$query = "SELECT * FROM fitness_package ORDER BY price ASC";

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $package_id = $row['package_id'];
        $package_name = $row['package_name'];
        $description = $row['des'];
        $duration_month = $row['duration_month'];
        $price = $row['price'];

        echo '<div class="col-sm-3 mx-auto">
                <div class="card">
                    <div class="card-body text-center">
                        <h1 class="card-title">' . $package_name . '</h1>
                        <p class="card-text" style="font-size: 25px; font-weight:lighter;">' . $duration_month . ' Month Plan</p>
                        <h4>RM ' . $price . '</h4>
                        <ul class="list-group list-group-flush custom-list-background">
                            <li class="list-group-item">' . $description . '</li>
                            <!-- Add additional list items as needed -->
                        </ul>';

        if ($currentMemberId) {
            // Check if the member is active
            if (isMemberActive($conn, $currentMemberId)) {
                echo '<p><strong>Your membership is currently active. Cannot subscribe to a new plan until the current one ends.</strong></p>';
            } else {
                echo '<a href="payment.php?package_id=' . $package_id . '" class="btn btn-primary mt-4 btn-lg">Subscribe Now</a>';
            }
        } else {
            echo '<a href="join_now.php" class="btn btn-primary mt-4 btn-lg">Subscribe Now</a>';
        }

        echo '</div>
                </div>
            </div>';
    }
} else {
    echo '<p>No pricing data available.</p>';
}

// Close the database connection
mysqli_close($conn);
?>




</div>
</div>