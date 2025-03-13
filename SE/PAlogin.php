<?php  
 session_start();//session starts here
 require 'config.php';  
  
if(isset($_POST['submit'])) {
	
    $username = $_POST['uname'];
    $pass = $_POST['password'];

    $check_user = "SELECT * FROM admin WHERE admin_name='$username' AND pass='$pass'";
    $run = mysqli_query($conn, $check_user);

    if(mysqli_num_rows($run)) {
        $adminData = mysqli_fetch_assoc($run);
        $admin_id = $adminData['admin_id'];


        $_SESSION['admin_id'] = $admin_id;
        $_SESSION['username'] = $username;

        echo "<script>
              window.location.href='member_list.php';
              </script>";
    } else {
        echo "<script>
              window.location.href='PAloginform.php?error=Incorrect Username or password';
              </script>";
    }
	
}



?>  