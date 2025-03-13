<?php include("config.php");  
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
<title>Login Page</title>
<style>
body {font-family: Arial, Helvetica, sans-serif;}
form 
{
width:800px;
margin: 0 auto;
margin-top:8rem; }

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
  
}

button {
  background-color: #cccccc;
  color:black;
  padding: 14px 20px;
  margin: 8px 0;
  border: 2px solid black ;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

.imgcontainer {
  text-align: center;

}

img.avatar {
  width: 300px;
  border-radius: 50%;
}



span.psw {
  float: right;
  padding-top: 16px;
}
.error
{
	color:red;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 850px) {
  
  
  form
  {
	  width:350px;
	  margin-top:4rem;
  }
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 80%;
  }
}
</style>
</head>
<body>

<form action="tlogin.php "method="post">
  <div class="imgcontainer">
    <img src="img/trainer_icon.jpg" alt="Avatar" class="avatar">
  </div>
   <?php if (isset($_GET['error'])) { ?>
     	<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
  <div class="container">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" id="id_password" required><i class="far fa-eye" id="togglePassword" style="margin-left: -30px; cursor: pointer;"></i>
    <a href="forgot_password.php">Forgot Password?</a>
    
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
    <button type="submit" name="submit" >Login</button>
    
  </div>
</form>

</body>
</html>

