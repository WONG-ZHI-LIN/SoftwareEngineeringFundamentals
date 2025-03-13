<!-- navbar.php -->

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session if not started
}

?>

<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark" style="padding-right:0;">
    <a class="navbar-brand" href="index.php"><img src="img/logo.png" style="height: 50%; width:50%"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav d-flex justify-content-between w-100">
            <div class="nav-wrapper d-flex" style="display:flex; gap:30px;">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="package.php">Package</a>
                </li>
				<?php
                    // Include active.php to check if the user is active
                    include 'active.php';
                    $currentMemberId = isset($_SESSION['member_id']) ? $_SESSION['member_id'] : null;
                    
                    // Check if the user is active
                    if (isMemberActive($conn, $currentMemberId)) :
                ?>
                    <!-- Show class button only if the user is not active -->
                    <li class="nav-item">
                        <a class="nav-link" href="class_list.php">Class</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="trainer_login.php">Trainer Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="PAloginform.php">People Admin Login</a>
                </li>
				<li class="nav-item">
                    <a class="nav-link" href="Fadmin_login.php">Fitness Admin Login</a>
                </li>
				<!-- Check if member_id is not set in the session -->
				<?php if(!isset($_SESSION['member_id'])) : ?>
					<li class="nav-item">
						<a class="nav-link" href="join_now.php" 
						style="
							color:red;
							border: 2px solid white; 
							padding: 8px 16px; 
							border-radius: 20px; 
							background-color: white;
						">
							Join Now
						</a>
					</li>
				<?php endif; ?>

            </div>
		
			<?php if(isset($_SESSION['member_id'])) : 
            include 'mem_dropdown.php'; 
			endif; ?>
        </ul>

    </div>
</nav>

<!-- Include jQuery, Popper.js, and Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

