<!-- highlights component -->


<style>
    p {
        font-size: 20px;
    }
</style>
<div class="row d-flex align-items-center justify-content-center" style="border-top: 2px solid #e0e0e0;">
    <h1 class=" mt-3 py-3" style="
        font-size:50px; 
        font-weight:bolder;
    ">Announcement
    </h1>
</div>

<?php
// Your database connection code goes here
require 'config.php';

// Fetch announcements from the database in descending order by date
$query = "SELECT date, title, des FROM announcement ORDER BY date DESC LIMIT 5";
$result = mysqli_query($conn, $query);

// Check if there are any results
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Format the date
        $date = date('d-m-Y', strtotime($row['date']));
        $title = $row['title'];
        $des = $row['des'];

        // Output HTML for each announcement
        echo '<div class="row d-flex align-items-center py-5" style="height:auto;">
                <div class="card text-center mx-auto">
                    <div class="card-header">' . $date . '</div>
                    <div class="card-body" style="width: 50rem;">
                        <h3 class="card-title">' . $title . '</h5>
                        <p class="card-text">' . $des . '</p>
                    </div>
                </div>
            </div>';
    }

    // Free the result set
    mysqli_free_result($result);
} else {
    // Handle the case where the query fails
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>

