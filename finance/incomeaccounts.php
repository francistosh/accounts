 <?php

ob_start();

session_start();

if(!isset($_SESSION['jmsloggedIn'])){
  
    echo  "You must Login to see this page : <a href='../index.php'>Click to Login</a>";
       
}
else if(isset($_SESSION['jmsacc'])!="999" || isset($_SESSION['jmsacc'])!="10"){
     
     echo  "Access denied : <a href='../index.php'>Contact admin for assistance</a>";
}
 

else{

include '../partials/stylesLinks.php';  
 
include 'links.php';

include './operations/Mumin.php';

$mumin=new Mumin();

//$usr=$_SESSION['uname'];  
 
//$access=$_SESSION['grp'];   
$userid = $_SESSION['acctusrid'];
$qr2="SELECT * FROM priviledges WHERE userid = '$userid' ";

$priviledges=$mumin->getdbContent($qr2);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head>
<title>finance | Mombasa Jamaat  Information System</title>
    
     
    
<script>
    
    
$(function() {
    
        $("#okcancel5").button({
            icons: {
                primary: "ui-icon-check"
            }});
           $("#okdelete5").button({
            icons: {
                primary: "ui-icon-trash"
            }});
        
          $("#incomeaccountlist").button({
            icons: {
                 
                secondary: "ui-icon-print" 
            }
        });
      // DataTable configuration
  $('#sortableaccounts').dataTable( {
	"bSort": false,
	// "sPaginationType": "full_numbers",
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
	"bJQueryUI": true
  } );
  
    $(document.body).on('click', '.linkincmeacct', function() { 
      var $id=$(this).attr("id");
           
           var $incmeactid="igl"+$id.substring(2);
           var $incmactname="inl"+$id.substring(2);
          var codeval = "incgrp"+$id.substring(2);
            $("#linkincmename").val(document.getElementById($incmactname).textContent);
            $("#incmeactid").val(document.getElementById($incmeactid).textContent);
            $("#incmecode").val(document.getElementById(codeval).textContent); 
        basicLargeDialog("#linkincmeact",400,300);
      
   });
  
  $("#editlinkincme").click(function(){
       var $incmeactid= $("#incmeactid").val();
       var $linkincmename= $("#linkincmename").val();
        var incmecode = $("#incmecode").val();       
       $.getJSON("../finance/json_redirect.php?action=updateincmelink&incmeactid="+$incmeactid+"&incmecode="+incmecode+"&incmename="+$linkincmename, function(data) {
        
      
   
     if(data){
         alert('Update successful');
         window.location.reload();
         $("#linkincmeact").dialog("destroy");
      $.modaldialog.success("<br></br><b> Update successful</b>", {
             width:400,
             showClose: true,
             title:"SUCCESSFULL TRANSACTION"
            });
 
     }
        
    });   
   });
  $("#incomeaccountlist").click(function(){
     _send2Printer(document.getElementById("sortableaccounts"));
           
      
  });  
    });
 
</script>
<style>
    
    
</style>
<link rel='stylesheet' type='text/css' href='properties/js/print.css' media="print" />

 <link rel="stylesheet" href="../assets/css/jquery-ui.css" />
</head>
   
<body style="overflow-x: hidden;"> 
  
 
 
    
  <div id="div_pagecontainer">
    <div id="div_pageheader">
  	<div id="div_orglogo"><img src="../assets/images/smallhomegoldlogo.png" width="80" height="84" alt="Mombasa Jamaat Home"/></div>
    <div id="div_orgname">
    	<h1 class="titletext"></h1>
    </div>
    <div id="div_currentlocation">
    	<h2 class="titletext"></h2>
    </div>
  </div>
  <div id="div_pagecontent">
  	<div id="div_logindetails">You are logged in as: <?php $_SESSION['jname'] ?> </div>
    <!--Left Panel Starts Here-->
<?php include_once 'adminleftmenu.php'; ?>
    <!--Right Panel Starts Here-->
    <div id="div_rightpanel">
   	  <div id="div_datainput">
      	<div id="div_formtitle">
        	<h3 class="titletext">Income accounts sub-section</h3>
        </div>
        <div id="div_formcontainer">
            
        <div id="tabs2">
    <?php
           
           $action =$_GET['action'];
           
           
           if($action==""){
              
               
           }
           
           
                    
           else if($action=="new" || $action==""){
    
    ?>
    
         <fieldset style="border:1px ghostwhite ridge;color:maroon;width: 750px;font-size: 15px;font-weight: bold">    
       
            <legend>Add Income Account</legend>
            
          
          <table class="ordinal"> 
          <tr><td>Account  Name:* </td><td><input  type="text" id="acc1name" class="formfield"></input></td></tr>            
          <tr><td></td><td><font class="tooltits">e.g land rates,service charge</font></td></tr>
		<tr><td>Company:* </td><td><select class="formfield" id="estatidname">
                      <option selected="true" value="all">--ALL--</option>
                 <?php
                      
                     $jqery="SELECT deptid,deptname FROM department order by deptname ASC  "; 
                         $datay=$mumin->getdbContent($jqery);
    
       
      for($j=0;$j<=count($datay)-1;$j++){    
               
               
       echo "<option value='".$datay[$j]['deptid']."'>".$datay[$j]['deptname']."</option>";
      
             }
             ?>
                  </select></td></tr>
          <tr><td>Type:* </td><td><select class="formfield" id="incactyp">
              <?php
              $incmtype = $mumin->getdbContent("SELECT typ FROM incomeaccounts GROUP by typ");
                         for($l=0;$l<=count($incmtype)-1;$l++){    
       echo "<option value='".$incmtype[$l]['typ']."'>".$incmtype[$l]['typ']."</option>";
      
             }
              ?>   
                  </select></td></tr>
          <tr><td></td><td><font class="tooltits">D: Depreciation Account , G: Grant , I: Income , L: Loan</font></td></tr>
          <tr><td>12 Point:</td><td><input  type="text" id="codebdget" class="formfield" maxlength="5"></input></td></tr>
          <tr><td style="display: none" id="bname">Bank: </td><td><select class="formfield" id="bankidname" style="display: none">
                      
                  </select></td></tr>
          
          <tr><td></td><td><button id="savincome" class="formbuttons">Save</button>&nbsp;&nbsp;&nbsp;<button id="caclincome" class="formbuttons">Cancel</button>  
               </td></tr>
         </table>
      
     
         </fieldset>   
           
           <?php
           }
           else if($action=="edit"){
          
     
           $qer="SELECT incomeaccounts.incacc,accname,incomeactmgnt.deptid,department.deptname,if(mainincgrp = '0','-',mainincgrp) as mainincgrp FROM incomeaccounts,incomeactmgnt,department WHERE typ IN('I','G') and  incomeaccounts.incacc = incomeactmgnt.incacc AND incomeactmgnt.deptid = department.deptid"; 
      
          $data=$mumin->getdbContent($qer);
    
       echo "<fieldset style='border:1px lightgray solid;color:gray;font-size: 15px;font-weight: bold'> "; 
       
       echo "<legend>Listed Income accounts</legend>";
      
      echo "<table id='sortableaccounts' class='invview' style='margin-top:3px'>"; 
      echo '<thead>';
       echo "<tr><th style='font-size:12px;text-align: left'>SN</th><th style='font-size:12px;text-align: left'>Names</th><th style='font-size:12px;text-align: left'>Department</th><th style='font-size:12px;text-align: left'>Code</th><th style='font-size:12px;text-align: left'></th>";
      echo '</thead>';
      echo '<tbody>';
      for($j=0;$j<=count($data)-1;$j++){    
        
     echo "<tr style='font-size:13px'><td  id='igl".$j."'>".$data[$j]['incacc']."</td><td id='inl".$j."'>".$data[$j]['accname']."</td><td id='incl".$j."'>".$data[$j]['deptname']."</td><td id='incgrp$j'>".$data[$j]['mainincgrp']."</td><td><a href='#' id='in$j' class='linkincmeacct'>Edit</a></td></tr>";
             }
      echo '</tbody>';
      echo "</table>";
      echo"<button style='margin:10px 0px 2px 10px' id='incomeaccountlist'>Print</button>"; 
      echo "</fieldset>";    

           }
           else if($action=="addsubincome"){
               ?>
                    <fieldset style="border:1px ghostwhite ridge;color:maroon;width: 750px;font-size: 15px;font-weight: bold">    
       
            <legend>Add Sub Income</legend>
            
          
          <table class="ordinal"> 
          <tr><td>Company: </td><td><select class="formfield" id="compname">
                      <option selected="true" value="all">--Select--</option>
                 <?php
                      
                     $jqery="SELECT deptid,deptname FROM department order by deptname ASC  "; 
                     $datay=$mumin->getdbContent($jqery);
              for($j=0;$j<=count($datay)-1;$j++){    
       echo "<option value='".$datay[$j]['deptid']."'>".$datay[$j]['deptname']."</option>";
             }
             ?>
                  </select></td></tr>
          <tr><td>Income Account: </td><td><select class="formfield" id="incmeacount"></select></td></tr>
          <tr><td>Sub Account </td><td><input  type="text" id="incmesubacct" class="formfield"></input></td></tr>            
          <tr><td></td><td><font class="tooltits">e.g House Sabil</font></td></tr>
          <tr><td></td><td><button id="savsubincome" class="formbuttons">Save</button>&nbsp;&nbsp;&nbsp;<button id="caclincome" class="formbuttons">Cancel</button></td></tr>
         </table>
      
     
         </fieldset> 
            <?php
           }
           ?>
             
 <div id="d_progress" style="display: none;background: transparent;border: none;text-align: center;vertical-align:middle; line-height: 50px;padding-top: 10px">
 <img align="center" src="../assets/images/icon_animated_prog_dkgy_42wx42h.gif"></img>
 </div> 
      <div id="linkincmeact" style="display:none " title="Edit Income">
          <table class="ordinal">   
              <tr><td></td><td><input  type="hidden"  class="formfield" readonly="readonly" id="incmeactid"/> </td></tr>
              <tr><td>Expense Acct:</td><td><input  type="text"  class="formfield"  id="linkincmename"/> </td></tr> 
              <tr><td>Code:</td><td><input  type="text"  class="formfield"  id="incmecode"  maxlength="5"/> </td></tr> 
              <tr><td></td><td> <button id="editlinkincme" class="formbuttons">Update</button></td></tr>
         </table>
      </div>
  </div>
  </div>
     
          </div>   
    
    </div>
    </div>
       <?php include 'footer.php' ?> 
</div>
    <?php include './dropdown.php';?>
</body>
</html> 
<?php
}
ob_flush();
?>