<?php
$dbHost="localhost";
  
 $pword="rtl";
 $dbname="jims";
  $username="root";
$conn= mysqli_connect($dbHost,$username,$pword,$dbname);//Connect to a database
if (!$conn){
	die("connection failded".mysqli_connect_errno());
}
  echo "connected";
?>