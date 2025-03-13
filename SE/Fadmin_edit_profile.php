<?php
require 'config.php';
include("FApage_login.php");
 
$fadmin_id = $_SESSION['fadmin_id'];  
?>
<!DOCTYPE html>
<html>
<head>
<title>Profile</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" 
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,800&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />

<style>

span
{
	padding:5px;
}

body
{
	font-family: 'Poppins', sans-serif;
	margin: 0;
}

.title
{
	text-align:center;
	margin-top:1rem;
}

.main
{
  max-width:70vw;
  margin: auto;
  padding: 10px;
}

    th
	{
		font-size:20px;
		width:30%;
	}
	tr
	{
		width:70%;
	}
	#submit
	{
		float:right;
	}

</style>
</head>
<body>
<?php include 'FAtopbar.php' ;?>

<div class="main">
                        <div class="title">
                            <h1>Admin Profile</h1>
                        </div>
                        
                            <?php
                                require 'config.php';
        
                                $info = $conn->query("SELECT * FROM fadmin WHERE fadmin_id = '$fadmin_id'");
                                 $row = $info->fetch_assoc();
                         
						 ?>
						  <form name="updateprofile" method="post" enctype="multipart/form-data">
                                        <table class="table tableInfo">
                                            <div class="mb-3">
                                               <tr><th>Username</th><td><input type="text" value="<?php echo $row["fadmin_name"];?>" class="form-control" name="newName"></td></tr>
											   <tr><th>Password </th><td><input type="password" value="<?php echo $row["pass"];?>" id="id_password" class="form-control" name="newPass"><i class="far fa-eye" id="togglePassword" style="margin-left: 50rem; cursor: pointer;"></i></td></tr>
                                            </div>
                                        </table>
                                        <div class="mb-3 submit">
                                            <button type="submit" name="updateProfile" id="submit" class="btn btn-primary">Update</button>
                                        </div>
						 </form> 
                    </div>

</body>
</html>
	<script>
	 const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#id_password');
 
  togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye slash icon
    this.classList.toggle('fa-eye-slash');
});
	</script>

<?php
 if(isset($_POST["updateProfile"])){
	 
        require 'config.php';
		
       
		$newName = $_POST["newName"];
		$newPass = $_POST["newPass"];
    
		
       	$sql = "UPDATE admin SET admin_name='$newName',pass='$newPass'";
		mysqli_query($conn, $sql);

		echo"
		  <script>
		  
		  window.location.href='Fadmin_edit_profile.php';
		  
		  </script>
		";
 }
?>