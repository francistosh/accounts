<?php
 session_start();
 
 include '../finance/operations/Mumin.php';
 date_default_timezone_set('Africa/Nairobi');
 $mumin=new Mumin();
  @$action=$_GET['action'];
 $sabilno="A100";
     $year=2012;
	 $acct=43;
  //   $account=$_GET['id']; 
      
  //   $estatesid=$_SESSION['dept_id'];
      
      //get linked bank account
         
    $linkedaccount=$mumin->getdbContent("SELECT sum(recptrans.amount) as ramount, sum(invoice.amount) as iamount FROM `recptrans`,invoice WHERE invoice.sabilno = '".$sabilno."' AND recptrans.incacc = invoice.incacc  AND year(recptrans.rdate) = '".$year."' AND year(invoice.idate) = '".$year."' AND invoice.incacc=".$acct." AND recptrans.incacc=".$acct."");
         
     //end gate linked  bank  account
   
   header('Content-type: application/json'); 
 
   echo  json_encode($linkedaccount);
 
   //exit();
     

 ?>