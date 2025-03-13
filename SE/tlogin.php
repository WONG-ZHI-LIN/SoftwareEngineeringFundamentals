<?php  
session_start();

require 'config.php';  
  
if(isset($_POST['submit']))  
{  
    $username = $_POST['uname'];  
    $pass = $_POST['password'];  
  
    $check_user = "SELECT * FROM trainer WHERE trainer_name='$username' AND pass='$pass'";  
  
    $run = mysqli_query($conn, $check_user);  
  
    if(mysqli_num_rows($run))  
    {  
        $trainer = mysqli_fetch_assoc($run);
        $trainer_id = $trainer['trainer_id'];

        $_SESSION['trainer_id'] = $trainer_id;

        header("Location: trainer_profile.php");
        exit();
    }  
    else  
    {  
        echo "<script>
                window.location.href='trainer_login.php?error=Incorrect Username or password';
              </script>";
    }  
}
?>
