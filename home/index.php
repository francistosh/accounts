<?php 

ob_start();

session_start(); 

if(!(isset($_SESSION['jmsloggedIn']))) {
 
header("location:../index.php"); 
 
}
else{

    $acc_level=$_SESSION['jmsacc'];
   
    if ($acc_level=="1" || $acc_level=="3"){ // estates management  official /secretaries
 
    
     header("location:../finance/");
  
     exit ();
 }

 else if($acc_level=="p"){  //reception -mumin
     
       header("location:../muminoperations/");

       exit ();
 } 
 
 else if($acc_level=="l"){  //reception -mumin
     
       header("location:../properties/");
       
       exit ();

 }
  else if($acc_level=="m"){ 

        header("location:admin.php");
        
        exit ();
  }
}
ob_flush();
  ?>