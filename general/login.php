<?php
session_start();

include 'Configuration.php';

 Class login extends Configuration{
     
     public $passwordtable ="pword";
     
     public $accslevel;
     
     function _construct(){
    
     parent::_construct();  //Inherit all methods  of parent class Configurations
         
     }
   
     
     
  public function niyazlogin($username,$password){   //login method->Accepts username and password as parameters
		
		
        $mysqli = parent::dbConnect(); //Create an instance of db connection
        
         $userExists=0;
         
        $username=mysqli_real_escape_string($username);
        
        $password=mysqli_real_escape_string($password);
      
        $loginQ="SELECT * FROM niyazlogin WHERE  uname LIKE '$username'  AND pwd LIKE '$password' LIMIT 1 "; //Construct a valid query to extract user information from db
        
        $result=mysqli_query($mysqli,$loginQ); //Execute the query
        
        $num_rows=  mysqli_num_rows($result);
      
        if($num_rows==1)  //check true or false
       {
        
          
       while ($row = mysqli_fetch_array($result)) {  //if true create session data
       
         $_SESSION['uname'] = $row[0];
         $_SESSION['pwd'] = $row[1];
         $_SESSION['level'] = $row[2];
         $_SESSION['loggedIn'] = 1;
         $_SESSION['logintime'] = date('Y-m-d h:i:s');
        
         
      //$this->accslevel=$row[3];
         
         
       }
     
         $userExists=1;
      }
      else{
         
         $userExists=0;
         
      }
      
       parent::freedBResource(); //free our database then return values
      
       return $userExists;  //return variable for checking*/
      
 }    
     
     
     
     
     
     
     
     
     public function userlogin($username,$password){   //login method->Accepts username and password as parameters
     
        $mysqli = parent::dbConnect(); //Create an instance of db connection
         //die($mysqli);
        $userExists=0;
       
        $username=mysqli_real_escape_string($mysqli,$username);
         $password=mysqli_real_escape_string($mysqli,$password);
        
      
        $loginQ="SELECT * FROM $this->passwordtable WHERE  j_uname LIKE '$username'  AND pwd = md5('$password') LIMIT 1 "; //Construct a valid query to extract user information from db
        
        $result=mysqli_query($mysqli,$loginQ)or die(mysqli_error()); //Execute the query
       
        $num_rows=  mysqli_num_rows($result);
		//die ($num_rows);
        if($num_rows==1)  //check true or false
       {
        
          
       while ($row = mysqli_fetch_array($result,MYSQLI_NUM)) {  //if true create session data
       
         $_SESSION['jname'] = $row[0];
         $_SESSION['emoh'] = 'Badri'; 
         $_SESSION['jpwd'] = 'badri';
         $_SESSION['jmsgrp'] = $row[3];
         $_SESSION['jmsloggedIn'] = 1;
         $_SESSION['jmsacc'] =$row[4];
         $_SESSION['logintime'] = date('Y-m-d h:i:s');
         $_SESSION['acctusrid'] =$row[10];
        //$this->accslevel=$row[3];
         
         
         
       }
     
         $userExists=1;
      }
      else{
         
         $userExists=0;
         
      }
      
       parent::freedBResource(); //free our database then return values
      
       return $userExists;  //return variable for checking*/
      
 }
    
function userlogout(){
     
 $_SESSION = array();
  
 session_destroy();   
 
 header("location:../index.php");
 }
   
 }
?>
