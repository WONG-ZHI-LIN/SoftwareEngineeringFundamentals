<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session if not started
}
?>
<head>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<style>
.icon
{
	font-size:25px;
	padding:5px;
}
.usericon
{
	font-size:30px;
}
</style>
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle d-flex align-items-center" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="usericon material-symbols-outlined">account_circle</span>Member Dashboard
</a>

<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="font-size: large;">
    <a class="dropdown-item d-flex align-items-center" href="profile.php">
        <span class="icon material-symbols-outlined">account_box</span> Edit Profile
    </a>
    <a class="dropdown-item d-flex align-items-center" href="schedule.php">
        <span class="icon material-symbols-outlined">fitness_center</span>Manage Classes
    </a>
    <a class="dropdown-item d-flex align-items-center" href="tracker.php">
       <span class="icon material-symbols-outlined">bar_chart_4_bars</span> Fitness Progress
    </a>
    <a class="dropdown-item d-flex align-items-center" href="payment_history.php">
        <span class="icon material-symbols-outlined">payments</span>Payment History
    </a>
    <a class="dropdown-item d-flex align-items-center" href="logout.php">
       <span class="icon material-symbols-outlined">logout</span> Logout
    </a>
</div>

</li>

<!-- Include jQuery, Popper.js, and Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

