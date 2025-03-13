<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session if not started
}

include("config.php");

if (!isset($_SESSION['member_id'])) {
    echo "<script>
        window.location.href='join_now.php';
    </script>";
    exit(); // Stop executing the rest of the code
}
?>
