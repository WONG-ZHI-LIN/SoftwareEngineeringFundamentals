<?php
include("config.php");

session_start();  
  
if(!isset($_SESSION['fadmin_id']))  
{  
    header("Location: ClassSession.php");
    exit();
}
?>
