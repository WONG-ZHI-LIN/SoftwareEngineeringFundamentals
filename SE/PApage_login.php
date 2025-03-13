<?php
include("config.php");

session_start();  
  
if(!isset($_SESSION['admin_id']))  
{  
  
    header("Location:PAloginform.php");//redirect to the login page to secure the welcome page without login access.  
}?>