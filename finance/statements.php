<?php
session_start(); 

if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  
    $level=$_SESSION['jmsacc'];
    $id=$_SESSION['dept_id'];
    $userid = $_SESSION['acctusrid'];
    if($level >999){
  
        header("location: ../index.php"); 
        
    }
    else{
   
include 'operations/Mumin.php';

$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE userid = '$userid' AND deptid = '$id' LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);

if($priviledges[0]['invoices']!=1){
   
header("location: index.php");
}
if($priviledges[0]['readonly']==1){
    $displ = 'display: none';
}else if($priviledges[0]['readonly']!=1){
    $displ = '';
}
}

date_default_timezone_set('Africa/Nairobi');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>Statements</title> 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';

?>

<script src="../assets/js/framework/jquery.localisation-min.js"></script>
<script src="../assets/js/framework/jquery.scrollTo-min.js"></script>
<script src="../assets/js/framework/ui.multiselect.js"></script>
<link  type="text/css" href="../assets/css/ui.multiselect.css" rel="stylesheet"/>   
<script>
    
    
  $(function() {
    
   var clsingdate = $("#clsingdate" ).val(); 
$( "#startdate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 2,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#enddate" ).datepicker( "option", "minDate", selectedDate );
}
});
$( "#enddate" ).datepicker({   
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 2,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#startdate" ).datepicker( "option", "maxDate", selectedDate );
}
});  
  
 
  
 $( "#startdate1" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 2,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#enddate1" ).datepicker( "option", "minDate", selectedDate );
}
});
$( "#enddate1" ).datepicker({   
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 2,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#startdate1" ).datepicker( "option", "maxDate", selectedDate );
}
});  


  
$( "#ssstart" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#ssend" ).datepicker( "option", "minDate", selectedDate );
}
});
$( "#ssend" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#ssstart" ).datepicker( "option", "maxDate", selectedDate );
} });
      
    
$( "#bssstart" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#bssend" ).datepicker( "option", "minDate", selectedDate );
}
});
$( "#bssend" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#bssstart" ).datepicker( "option", "maxDate", selectedDate );
} });
   
 $( "#debtstart" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#debtorend" ).datepicker( "option", "minDate", selectedDate );
}
});  
 
 $( "#debtorend" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#debtstart" ).datepicker( "option", "maxDate", selectedDate );
}
});  
  
  $("#tenantejno" ).autocomplete({source: ejamaatNos});  
   
 $("#invdate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
minDate: parseInt(clsingdate)+parseInt(1)
});  
 $( "#multifrmdate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#multitodate" ).datepicker( "option", "minDate", selectedDate );
}
});
  $( "#multitodate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#multifrmdate" ).datepicker( "option", "maxDate", selectedDate );
}
}); 
 $( "#batchmailfrmdate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#batchmailtodate" ).datepicker( "option", "minDate", selectedDate );
}
});
    $( "#batchmailtodate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#batchmailfrmdate" ).datepicker( "option", "maxDate", selectedDate );
}
});
  $("#stat").button({
            icons: {
                primary: "ui-icon-document" ,
                        secondary:"ui-icon-check"
            },
            text: true
             
});

  $("#trialbalanceget").button({
            icons: {
                primary: "ui-icon-document" 
                         
            },
            text: true
             
});

$( "#startdate1" ).datepicker({ dateFormat: 'yy-mm-dd',changeMonth:true,changeYear:true,minDate: new Date(1930,1,1,0,0,0),yearRange: '-80+0'} );


   
   $("#generatestat").live('click',function(){
       
       
       
         window.open('account_statement.php?startdate='+$("#startdate").val()+'&enddate='+$("#enddate").val()+'&accountname='+$("#accountname").val()+'','width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
   });
   
   //$("#supplierstatements").live('click',function(){
       
       
       
     //    window.open('suppstatement.php?startdate='+$("#ssstart").val()+'&enddate='+$("#ssend").val()+'&supplier='+$("#supplierId").val()+'','width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
  // });
  
 
    $("#ageanalysis").live('click',function(){
       
       
         window.open('ageanalysis.php?startdate='+$("#startdate1").val()+'&accountname='+$("#accountname1").val()+'','width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
   
});

   $("#debtorssummary").click(function(){
   
         window.open('debtorsummary.php?dstartdate='+$("#debtstart").val()+'&denddate='+$("#debtorend").val()+'&incmeacct='+$("#debtraccount").val()+'','width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
   });
$("#agetype").live('change',function(){
       
    if($(this).val()=="debtor"){
          $("#sabilrow").css("visibility","hidden");
          $("#supplierrow").css("display","none");
          $("#sabilselect").css("visibility","hidden");
          $("#debtorrow").css("display","block");   
    }
    else if($(this).val()=="supplier"){
          $("#debtorrow").css("display","none");
          $("#sabilrow").css("visibility","hidden");
          $("#sabilselect").css("visibility","hidden");
          $("#supplierrow").css("display","block");
     
    }
    else if($(this).val()=="mumineen"){
        $("#supplierrow").css("display","none");
        $("#debtorrow").css("display","none");
        $("#sabilrow").css("visibility","hidden");
        $("#sabilselect").css("visibility","visible");
        
    }
    
});
 $("#sabilselect1").live('change',function(){
   
     if($(this).val()=="custom"){
       
        $("#sabilrow").css("visibility","visible");
         
     }
     else{
          $("#sabilrow").css("visibility","hidden");
     }
    });
    
    
      $("#statsabil").keyup(function(){  //sabil no field click;
        
       if($(this).val().length>=4){
           
           getHofNames($(this).val());
       }
   else if($(this).val().length<4 || $(this).val()=="" ){
      // $("#statname").val('');
      $("#statmntfield").css("display","none");
       document.getElementById("statname").innerHTML=""; 
   }
       
       
   }); 
    	$.localise('ui-multiselect', {path: 'js/locale/'});
			$(".multiselect").multiselect();
			 
    
         $("#displaypic").click(function(){  // invoice field click listener
   
    $("#gallery").fadeIn('Slow');
      
  }); 
    
             $("#selctivebtn").click(function(){  // invoice field click listener
   $("#d_progress").show(); basicLargeDialog("#d_progress",50,150);
         $(".ui-dialog-titlebar").hide();
    
      
  }); 
    
    
    });
      function reportemail() 
{
if ($("input#batchmailfrmdate").val() == "" || $("input#batchmailtodate").val() == "" ) 
{
alert('complete all fields');
}
else {
    window.open("","myNewWin1","width=1010,height=648,left=3,menubar=yes,toolbar=0,scrollbars=yes,location=no,resizable=no,status=no"); 
 } 
};
      function statementsprvw() 
{
    window.open("","myNewWindow2","width=1010,height=648,left=3,menubar=yes,toolbar=0,scrollbars=yes,location=no,resizable=no,status=no"); 

};
 
</script>

<style>
      
     
.menuitems a:link {
	text-decoration:none;
	color:#333;
	font-size:11px;
        padding:10px 5px 10px 5px;
	}
	
 
  .menuitems li:hover {
	 background: #357918;
         color: white;
         border-radius: 3px;
         line-height: 30px;
	}
        .menuitems li a:hover{
            color: white;
        }
.menuitems a:visited {
	text-decoration:none;
	color:#333;
	
	}
	 
 
    #div_toAccount{
        width: 350px;
        height: 35px;
        background: transparent;
        z-index: 10;
        color: black;
        font-size: 20px;
        left: 610px;
        top: 390px;
        text-align: left;
        vertical-align: middle;
        line-height: 35px;
        position: absolute;
        
        
    }
     #div_fromAccount{
        width: 350px;
        height: 35px;
        background: transparent;
        z-index: 10;
        text-align: left;
        vertical-align: middle;
        line-height: 35px;
        color: black;
        font-size: 20px;
        left: 610px;
        top: 331px;
        position: absolute;
        
        
    }
      
    </style>


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
  	<div id="div_logindetails" ><div>You are logged in as: <?php echo $_SESSION['jname'];?></div>
     <span style="text-align: right;display:block">Company: <b><?php echo $_SESSION['dptname'];?></b></span>
      </div>
    <!--Left Panel Starts Here-->
    <div id="div_leftpanel">
   <?php include_once 'leftmenu.php'; ?>      

    </div>
    <!--Right Panel Starts Here-->
    <div id="div_rightpanel">
        <?php include_once 'topmenu.php'; ?>
   	  <div id="div_datainput">
      	<div id="div_formtitle">
        	<h3 class="titletext">Debtor Accounts </h3>
        </div>
        <div id="div_formcontainer">
            
        <div id="tabs2">
    
            <?php
            
            $type=$_GET['type'];
            
            if($type=="" || $type=="mumin")
            {
            ?>

        
       <div id="displaypic" style="float: right"><button class="btncls" >Mumin Search</button></div>

       <fieldset style="border: 1px ghostwhite solid"><legend style="color: black;font-size: 13px;font-weight: bold">Choose Category</legend>

           <table class="ordinal" id="radiobutt"><tr><td style="width: 20px"><input class="rb" name="r1" value="sabil" id="r1" type="radio" checked="true"/></td><td style="width: 50px">Sabil</td><td style="width: 20px"><input class="rb" id="r1" name="r1" value="dbtr" type="radio"/></td><td>Debtor</td><td><select style="visibility: hidden" class="formfield" id="dbt3">
                           
                           
                           <?php
                            
                              
                                $qrt="SELECT * FROM debtors WHERE deptid = '$id' ORDER BY debtorname asc"; 
                                
                                $datas=$mumin->getdbContent($qrt);
                                
                                 echo "<option value=''>--select debtor--</option>"; 
                                
                                 for($h=0;$h<=count($datas)-1;$h++){
                      
                                     echo "<option value=".$datas[$h]['dno'].">".$datas[$h]['debtorname']."</option>";
                                   }
                            
                            
                              ?>
                           
                       </select></td></tr></table>
           
           <table class="ordinal" style="visibility: visible" id="tbl3" >  <tr><td style="width: 290px" ><input class="formfield" id="statsabil" style="text-transform: uppercase" placeholder="Enter Sabil No." type="text" maxlength="7"/></td><td id="statname" style="width:300px;border: none;font-weight: bold;font-size: 13px;"></td></tr> 
           
           </table>   
       </fieldset>
       
         <fieldset id="statmntfield" style="border: 1px burlywood solid;margin-top: 30px;display: none"><legend style="color: black;font-size: 13px;font-weight: bold">Additional Settings</legend>
            <table class="ordinal" id="detinfo"  >
       
                <tr><td>Start Date :</td><td style="width: 80px"><input id="ssstart" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td><td>&nbsp;End date :</td><td><input id="ssend" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td></tr>
                <tr><td style="border: none">Income Acc: </td>
                    <td style="border: none"><select  class="formfield" id="stataccount" ><option value="all">ALL</option> 
                                <?php
                                $qr="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id' GROUP BY incomeaccounts.incacc ORDER BY incomeaccounts.accname"; 
                                
                                $data=$mumin->getdbContent($qr);
                                
                                 for($h=0;$h<=count($data)-1;$h++){
                      
                                     echo "<option value=".$data[$h]['incacc'].">".$data[$h]['accname']."</option>";
                                   } 
                            
                            ?>
                        </select></td><td >&nbsp;&nbsp;&nbsp;WIth P.D :</td><td><input type="checkbox" class="formfield" id="stamntwithpd"> </input></td></tr>
                <tr><td></td><td><button id="stat">View Statement</button></td></tr>
       </table>
         </fieldset> 
  
    <div id="gallery" >
   <table>
       <tr><td style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;<b>Name:</b></td><td style="width: 230px"><img src="images/cross.png" align="right" id="closegallery"></img></td></tr>
       <tr><td><input type="text" class="texinput" id="namesrch" placeholder="--- First name ---"></input></td>
           <td><input type="text" class="texinput" id="snamesrch" placeholder="---  Surname ---"></input></td></tr>
   </table>
    <div id="phts" style="width: 400px;">
        
    </div>
</div>
            
          <?php
            }
                        
           elseif($type=="badebts")
            {
            ?>

        
        <fieldset style="border: 1px ghostwhite solid"><legend style="color: black;font-size: 13px;font-weight: bold">Bad Debts Category</legend>
           
           
           
           <table class="ordinal" id="radiobutt"><tr><td style="width: 20px"><input class="rbdbts" name="debtstyp" value="sabil" id="debtstyp" type="radio" checked="true"/></td><td style="width: 50px">Sabil</td><td style="width: 20px"><input class="rbdbts" id="debtstyp" name="debtstyp" value="dbtr" type="radio"/></td><td>Debtor</td></tr></table>
           
           <table class="ordinal" style="visibility: visible" id="tbl3" >  
               <tr><td style="width: 290px" ><input class="formfield" id="debtsrowcount" placeholder="No of Rows :" type="text" maxlength="6"/></td><td id="statname" style="width:300px;border: none;font-weight: bold;font-size: 13px;"></td></tr> 
               <tr><td><input  type="submit" id="appendbtn" value="Append" class="formfield" style="width: 100px; font-weight: bold"></input></td></tr>
           </table>   
           <table class="ordinal" style="display: none" id="tbl4" >  
               <tr><td style="width: 290px" ><input class="formfield" id="debtsrwcount" placeholder="No of Rows :" type="text" maxlength="6"/></td><td id="statname" style="width:300px;border: none;font-weight: bold;font-size: 13px;"></td></tr> 
               <tr><td><input  type="submit" id="appndbtn" value="Append" class="formfield" style="width: 100px; font-weight: bold"></input></td></tr>
           </table> 
       </fieldset>
       
         <fieldset id="debttfield" style="border: 1px burlywood solid;margin-top: 30px;display: none"><legend style="color: black;font-size: 13px;font-weight: bold">Additional Settings</legend>
            <table class="ordinal" id="debttinfo"  >
       
               
       </table>
         </fieldset> 
  
    <div id="gallery" >
   <table>
       <tr><td style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;<b>Name:</b></td><td style="width: 230px"><img src="images/cross.png" align="right" id="closegallery"></img></td></tr>
       <tr><td><input type="text" class="texinput" id="namesrch" placeholder="--- First name ---"></input></td>
           <td><input type="text" class="texinput" id="snamesrch" placeholder="---  Surname ---"></input></td></tr>
   </table>
    <div id="phts" style="width: 400px;">
        
    </div>
</div>
            
          <?php
            }
            else if($type=="bank"){
            
           
            
      $qer="SELECT *  FROM estate_bankaccounts WHERE estate_id LIKE '$id'";
      
      $data=$mumin->getdbContent($qer);
      
      echo "<table class='ordinal' style='width:90%'>"; 
      
       echo "<tr><th>Account No.</th><th>Account Name</th><th>Balance</th>";
      
      for($l=0;$l<=count($data)-1;$l++){
          
          
          
          echo "<tr><td>".$data[$l]['acno']."</td><td>".$data[$l]['acname']."</td><td>".number_format($data[$l]['amount'],2)."</td></tr>";
      }
      
      echo "</table>";
            }
            
            else if($type=="ageanalysis"){ 
                ?>
            <fieldset style="border: 1px ghostwhite solid;margin: 1px;color: black;padding-left: 5px;font-size: 15px;font-weight: bold"><legend>Age Analysis Statements</legend> 
          
           <table style="width: 650px;float: left" class="ordinal"> 
                   
                   
                   
                   <tr><td>Start Date :</td><td><input id="startdate1" name="startdate1"  value="<?php echo $_POST['startdate1']; ?>" class="formfield"/></td><td>End date</td><td><input id="enddate1" name="enddate1"  value="<?php echo $_POST['enddate1']; ?>" class="formfield"/></td></tr>
                   
                      
                   <tr><td>Type :</td><td><select class="formfield" id="agetype"><option value="debtor">Debtors</option><option value="supplier">Supplier</option><option value="mumineen">Mumineen</option></select></td><td></td><td></td></tr>
                    
                   <tr><td></td><td><select style="display: none" id="supplierrow" name="accountname1" class="formfield">
                        <?php   
                           
                                
      $qer="SELECT *  FROM estate_suppliers WHERE estId LIKE '$id' ";
     
      $data=$mumin->getdbContent($qer);
      
        echo "<option value='all'>ALL</option>";
        
      for($i=0;$i<=count($data)-1;$i++){
          
          echo "<option value=".$data[$i]['supplier'].">".$data[$i]['suppName']."</option>";
      }
                         ?>  
               </select> 
                        <?php   
                           
                                
      $qer="SELECT *  FROM estate_debtors WHERE estId LIKE '$id' ";
     
      $data=$mumin->getdbContent($qer);
      echo "<select class='formfield' id='debtorrow' style='display:none'>";
        echo "<option value='all'>ALL</option>";
      
      for($i=0;$i<=count($data)-1;$i++){
          
          echo "<option value=".$data[$i]['dno'].">".$data[$i]['debtorname']."</option>";
      } echo "</select>"; 
                         ?> </td><td></td><td></td></tr>  
       <tr style="visibility: hidden" id="sabilselect"><td></td><td><select id="sabilselect1" class="formfield"><option value="all">All</option><option value="custom">Custom</option></select></td><td></td><td></td></tr>
      <tr style="visibility: hidden" id="sabilrow"><td></td><td><input  type="text" placeholder="enter sabilno" id="agesabilno" class="formfield"></input></td><td></td><td></td></tr>       
                  
     <tr><td></td><td><input name="agenalysis" class="formbuttons" type="submit" id="ageanalysis" value="View Statement"></input></td><td></td><td></td></tr>
                   
    </table></fieldset>  
    
     <?php
             
                
                
            }
                                       else if($type=="statement"){
            
           ?>
            
             <fieldset style="border: 1px ghostwhite solid;margin: 1px;color: black;padding-left: 5px;font-size: 15px;font-weight: bold"><legend>Account Statements</legend> 
          
           <table style="width: 650px;float: left" class="ordinal"> 
                   
                   
                   
                   <tr><td>From Date :</td><td><input id="startdate" name="startdate"  value="<?php echo date('Y-m-d'); ?>" class="formfield"/></td><td></td><td></td></tr>
                   <tr><td>To Date :</td><td><input  id="enddate" name="enddate" value="<?php echo date('Y-m-d'); ?>"   class="formfield"/></td></tr>
                   <tr><td>Account :</td><td><select id="accountname" name="accountname" class="formfield">
                        <?php   
                           
                                
      $qer="SELECT *  FROM estate_bankaccounts WHERE estate_id LIKE '$id'";
      
      $data=$mumin->getdbContent($qer);
      
       
      for($i=0;$i<=count($data)-1;$i++){
          
          echo "<option value=".$data[$i]['acno'].">".$data[$i]['acname']."</option>";
      }
                         ?>  
                    </select></td></tr>
                   
                   
                   <tr><td></td><td><input name="generatestat" class="formbuttons" type="submit" id="generatestat" value="View Statement"></input></td><td></td><td></td></tr></table></fieldset>
    
     <?php
             
              }

			  
              else if($type=="selectivebatch"){
               ?>   
                  
               <fieldset style="border: 1px burlywood solid;margin-top: 30px"><legend style="color: black;font-size: 13px;font-weight: bold">Selective Batch Invoicing</legend>
                   <form method="post" action="selectivebatch.php">
                   <table class="ordinal" >
                  <tr><td>Sabil number :</td></tr>
                 <tr><td colspan="3"><select id="selctivesabno"  class="multiselect" style="height: 200px;" multiple="multiple" name="selctivesabno[]">
                            
                              <?php
                                $qrf="SELECT DISTINCT sabilno FROM mumin  WHERE ejno = hofej AND status = 'A' order by sabilno "; 
                                
                                $dsab=$mumin->getdbContent($qrf);
                                
                                 for($h=0;$h<=count($dsab)-1;$h++){
                      
                                     echo "<option value=".$dsab[$h]['sabilno'].">".$dsab[$h]['sabilno']."</option>";
                                   }
                            
                            ?>
                            
                        </select></td></tr>
                
                
               
       <tr><td>Date:</td></tr>
       <tr><td style="width: 80px">
		 <?php
                                 
                                $qrtr="SELECT deptid as estate_id,cdate as date FROM closing_period WHERE deptid = '$id' ORDER BY id DESC LIMIT 1 "; 
                                
                                $datatr=$mumin->getdbContent($qrtr);
                                if(count($datatr)==0){
                                        echo "<input hidden='true' type='text' id='clsingdate'  class='formfield' value='-1'>";
                                    }else{
                                 for($h=0;$h<=count($datatr)-1;$h++){
                                   $qru=  "SELECT DATEDIFF('".$datatr[$h]['date']."','".date('Y-m-d')."') AS DiffDate";
                                    $datau=$mumin->getdbContent($qru);
                                    for($k=0;$k<=count($datau)-1;$k++){
                                     echo "<input hidden='true' type='text' id='clsingdate'  class='formfield' value='".$datau[$k]['DiffDate']."'>";
                                   //  echo "<option value=".$data[$h]['date'].">".$data[$h]['date']."</option>";
              } }}
                            
                            ?><input id="invdate" name="invdate" readonly="true" class="formfield" value="<?php echo date('d-m-Y')?>"/></td>
           <td style="border: none">&nbsp;&nbsp;Income Account:</td>
                    <td style="border: none"><select name="incmeacc" class="formfield" id="incmeacc"> 
                                <?php
                                $qr="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id' GROUP BY incomeaccounts.incacc"; 
                                
                                $data=$mumin->getdbContent($qr);
                                 echo "<option value=''>-select Account-</option>";
                                
                                 for($h=0;$h<=count($data)-1;$h++){
                      
                                     echo "<option value=".$data[$h]['incacc'].">".$data[$h]['accname']."</option>";
                                     
                                   } 
                            
                            ?>
                        </select></td><td></td></tr>
       <tr><td>Amount:</td></tr>
       <tr><td style="width: 80px"><input id="invcamount" name="invcamount" class="formfield" value="" onkeypress="return isNumberKey(event);"/></td>
       <td> &nbsp;&nbsp;Remarks:</td><td><input id="slctvremarks" name="slctvremarks" class="formfield" value=""/></td></tr>
       <tr><td style="<?php echo $displ;?>"><input type="submit" value="Generate Invoice" style="height:30px" id="selctivebtn"></input></td></tr>
       </table>
                   </form>
         </fieldset>  
                
                
                
               <?php   
              }
              elseif ($type=="multistamnt") {
                  ?>
                       <fieldset style="border: 1px burlywood solid;margin-top: 30px"><legend style="color: black;font-size: 13px;font-weight: bold">Muminee Batch Statement</legend>
                           <form method="post" action="multistatement.php" target="myNewWindow2">
                   <table class="ordinal" >
                  <tr><td>Sabil number :</td></tr>
                 <tr><td colspan="3"><select id="multiselctivesabno"  class="multiselect" style="height: 200px;" multiple="multiple" name="multiselctivesabno[]">
                            
                              <?php
                                $qrf="SELECT DISTINCT sabilno FROM mumin  WHERE ejno = hofej AND status = 'A' order by sabilno "; 
                                
                                $dsab=$mumin->getdbContent($qrf);
                                
                                 for($h=0;$h<=count($dsab)-1;$h++){
                      
                                     echo "<option value=".$dsab[$h]['sabilno'].">".$dsab[$h]['sabilno']."</option>";
                                   }
                            
                            ?>
                            
                        </select></td></tr>
                
                
               
       <tr><td>From Date:</td><td>To Date:</td></tr>
       <tr><td style="width: 80px">
	      <input id="multifrmdate" name="multifrmdate" readonly="true" class="formfield" value="<?php echo date('d-m-Y')?>"/></td>
       <td><input id="multitodate" name="multitodate" readonly="true" class="formfield" value="<?php echo date('d-m-Y')?>"/></td></tr>
           <tr><td style="border: none">&nbsp;&nbsp;Income Account:</td></tr>
                   <tr><td style="border: none"><select name="multincmeacc" class="formfield" id="multincmeacc"> 
                                <?php
                                $qr="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id' GROUP BY incomeaccounts.incacc"; 
                                
                                $data=$mumin->getdbContent($qr);
                                 echo "<option value='all'>-select Account-</option>";
                                
                                 for($h=0;$h<=count($data)-1;$h++){
                      
                                     echo "<option value=".$data[$h]['incacc'].">".$data[$h]['accname']."</option>";
                                     
                                   } 
                            
                            ?>
                        </select></td><td></td></tr>
           <tr><td style="<?php echo $displ;?>"><input type="submit" value="View Statement" style="height:30px" id="statementprvw" onclick="statementsprvw()"></input></td></tr>
       </table>
                   </form>
         </fieldset> 
                  <?php
              }
              elseif ($type=="multiemailstmnt") {
                  ?>
                              <fieldset style="border: 1px burlywood solid;margin-top: 30px"><legend style="color: black;font-size: 13px;font-weight: bold">Email Statement(s)</legend>
                   <form method="post" action="batchemail.php" target="myNewWin1">
                   <table class="ordinal" >
                  <tr><td>Sabil number :</td></tr>
                 <tr><td colspan="3"><select id="batchmailsabno"  class="multiselect" style="height: 200px;" multiple="multiple" name="batchmailsabno[]">
                            
                              <?php
                                $qrf="SELECT DISTINCT sabilno FROM mumin  WHERE ejno = hofej AND status = 'A' AND email <> '' order by sabilno  "; 
                                
                                $dsab=$mumin->getdbContent($qrf);
                                
                                 for($h=0;$h<=count($dsab)-1;$h++){
                      
                                     echo "<option value=".$dsab[$h]['sabilno'].">".$dsab[$h]['sabilno']."</option>";
                                   }
                            
                            ?>
                            
                        </select></td></tr>
                
                
               
       <tr><td>From Date:</td><td>To Date:</td></tr>
       <tr><td style="width: 80px">
	      <input id="batchmailfrmdate" name="batchmailfrmdate"  class="formfield" value="<?php echo date('d-m-Y')?>"/></td>
       <td><input id="batchmailtodate" name="batchmailtodate"  class="formfield" value="<?php echo date('d-m-Y')?>"/></td></tr>
           <tr><td style="border: none">&nbsp;&nbsp;Income Account:</td></tr>
                   <tr><td style="border: none"><select name="batchmailincmeacc" class="formfield" id="batchmailincmeacc"> 
                                <?php
                                $qr="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id' GROUP BY incomeaccounts.incacc"; 
                                
                                $data=$mumin->getdbContent($qr);
                                 echo "<option value='all'>-select Account-</option>";
                                
                                 for($h=0;$h<=count($data)-1;$h++){
                      
                                     echo "<option value=".$data[$h]['incacc'].">".$data[$h]['accname']."</option>";
                                     
                                   } 
                            
                            ?>
                        </select></td><td></td></tr>
           <tr><td style="<?php echo $displ;?>"><input type="submit" value="Email Statement" style="height:30px" id="batchmailbtn" onclick="reportemail()"></input></td></tr>
       </table>
                   </form>
         </fieldset> 
       <?php
              }
              
                   elseif($type=="debtorsmry"){
            ?>
           <fieldset style="border: 1px burlywood solid;margin-top: 30px"><legend style="color: black;font-size: 14px;font-weight: normal">Accounts summary</legend>
                 <table class="ordinal" >       
                     <tr><td>Start Date :</td><td style="width: 80px"><input id="debtstart" name="debtstart" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td><td>&nbsp;End date :</td><td><input id="debtorend" name="debtorend" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td></tr>
                <tr><td style="border: none">Income Acc: </td>
                    <td style="border: none"><select  class="formfield" id="debtraccount" ><option value="all">ALL</option> 
                                <?php
                                $qr="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id'  GROUP BY incomeaccounts.incacc"; 
                                
                                $data=$mumin->getdbContent($qr);
                                
                                 for($h=0;$h<=count($data)-1;$h++){
                      
                                     echo "<option value=".$data[$h]['incacc'].">".$data[$h]['accname']."</option>";
                                   } 
                            
                            ?>
                        </select></td></tr>
                     <tr><td></td><td><button id="debtorssummary">View Summary</button></td></tr>
                     </table>
         </fieldset>
            <?php
            }
                ?>
            
      <div id="d_progress" style="display: none;background: transparent;border: none;text-align: center;vertical-align:middle; line-height: 50px;padding-top: 10px">
     <img align="center" src="../assets/images/icon_animated_prog_dkgy_42wx42h.gif"></img>
 </div>      
  </div>
   
 </div>
 
</div>
      
</div>     
        
</div>
     <?php include 'footer.php' ?>    
</div>
             <script>
$('.arrow').addClass('collapsed');

$('#menu-primary-navigation > li > a.arrow').click(function(e) {  // select only the child link and not all links, this prevents sub links from being selected. 
    var sub_menu = $(this).next('.sub-menu'); // store the current submenu to be toggled  
    e.preventDefault();
    $('.sub-menu:visible').not(sub_menu).slideToggle('fast'); // select all visible sub menus excluding the current one that was clicked on and close them 
    sub_menu.slideToggle('fast'); // toggle the current sub menu 
	
    $("li a.arrow").addClass('collapsed');  // Add the collapse class to the clicked a	 
    $(this).removeClass('collapsed').addClass('expanded');    //Remove the collapse class from only the clicked tag
});
</script>
</body>
</html>
<?php 
}
?>