<?php
session_set_cookie_params(0);  //makes sure user is logged out on browser close
session_start();

if(!isset($_SESSION['jmsloggedIn'])) {
header("location:../index.php"); 
exit();
} 

date_default_timezone_set('Africa/Nairobi');
$idletime = 3600; //after 60 minutes of idle time, the user gets auto-matically logged out

if((time()-$_SESSION['timestamp']) > $idletime){

// $cdate = date("Y-m-d-H-i-s");
// $id = $_SESSION['loggedin_num'];

// Updating data in system_log when user logs out
/*
$query="UPDATE session_users SET logout_time = '$cdate', status = '0', rmks = 'session logout' WHERE auto_number = '$id' LIMIT 1";		
@mysql_query($query);
*/

//Destroy all the sessions stored 
$_SESSION = array();
session_destroy(); 
header("Location:session_logout.php");
exit();
}

else 
{  
$_SESSION['timestamp'] = time();  // renew the timestamp session
}
?>

