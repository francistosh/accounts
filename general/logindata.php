<?php
/*
*
This  script would listen to all login/logout request from login.js,extract data from json string and call appropriate method on login Class
 * Geek scripts
 * 
 */
 
include 'login.php';  //Our setup file

 $action=trim($_GET['action']);
 
 $user=new login();  //Create object user of class login
  
 if($action=="login"){
     
    $usname=trim($_GET['usname']) ;
    
    $pwd=trim($_GET['pwd']) ;
    
    $response=array();
   
    
    $request=$user->userlogin($usname, $pwd); //Call user login method
     //die($_SESSION['jmsacc']);
    if($request==1){ //login was successfull
      
      $response=array('id'=>$request,'msg'=>"login successful") ;
    }
    else{  //login was unsuccessful
      
          $response=array('id'=>$request,'msg'=>"<font color='red'>Incorrect Username / Password</font>") ;
    }
    
    header('Content-type: application/json'); 
 
     echo  json_encode($response);
 
     exit();
     
 }
  
 if($action=="logout"){
     
     $user->userlogout();
 
 }
?>
