<?php  
session_start();

require 'config.php';  
  
if(isset($_POST['submit']))  
{  
    $username = $_POST['uname'];  
    $pass = $_POST['password'];  
  
    $check_user = "SELECT * FROM fadmin WHERE fadmin_name='$username' AND pass='$pass'";  
  
    $run = mysqli_query($conn, $check_user);  
  
    if(mysqli_num_rows($run))  
    {  
        $trainer = mysqli_fetch_assoc($run);
        $fadmin_id = $trainer['fadmin_id'];

        $_SESSION['fadmin_id'] = $fadmin_id;

        header("Location: ClassSession.php");
        exit();
    }  
    else  
    {  
        echo "<script>
                window.location.href='Fadmin_login.php?error=Incorrect Username or password';
              </script>";
    }  
}
?>
