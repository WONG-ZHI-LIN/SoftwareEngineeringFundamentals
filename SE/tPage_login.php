<?php
include("config.php");

session_start();  
  
if(!isset($_SESSION['trainer_id']))  
{  
    header("Location: trainer_login.php");
    exit();
}
?>
