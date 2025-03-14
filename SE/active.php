<?php
require 'config.php';  // Ensure that you include the configuration file

$currentMemberId = isset($_SESSION['member_id']) ? $_SESSION['member_id'] : null;

function isMemberActive($conn, $customerId) {
    // Get the latest package_exdate for the given customer_id
    $query = "SELECT package_exdate FROM payment WHERE member_id = '$customerId' ORDER BY package_exdate DESC LIMIT 1";

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $latestExpirationDate = strtotime($row['package_exdate']);

        // Compare with the current date
        if ($latestExpirationDate >= time()) {
            return true; // Member is active
        }
    }

    return false; // Member is not active or no valid data found
}
?>
