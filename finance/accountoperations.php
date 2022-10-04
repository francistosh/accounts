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

if($priviledges[0]['statements']!=1){
   
header("location: index.php");
}
}
}
date_default_timezone_set('Africa/Nairobi');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    
<head>
    
<title>JIMS Reports</title> 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';

$usr=$_SESSION['jname'];  

?>

<script src="../assets/js/framework/jquery.localisation-min.js"></script>
<script src="../assets/js/framework/jquery.scrollTo-min.js"></script>
<script src="../assets/js/framework/ui.multiselect.js"></script>
<link  type="text/css" href="../assets/css/ui.multiselect.css" rel="stylesheet"/>   
<script>
    
    
  $(function() {
        var costcentrs=[];
    $( "#incmestart" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#inncmeend" ).datepicker( "option", "minDate", selectedDate );
}
});
$( "#inncmeend" ).datepicker({   
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#incmestart" ).datepicker( "option", "maxDate", selectedDate );
}
}); 
   $( "#centrestart" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#centrend" ).datepicker( "option", "minDate", selectedDate );
}
});
   $( "#centrend" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#centrestart" ).datepicker( "option", "maxDate", selectedDate );
}
});
   $( "#expensestart" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#expensend" ).datepicker( "option", "minDate", selectedDate );
}
});

   $( "#expensend" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#expensestart" ).datepicker( "option", "maxDate", selectedDate );
}
});

  $( "#baddebtstart" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#baddebtend" ).datepicker( "option", "minDate", selectedDate );
}
});

   $( "#baddebtend" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#baddebtstart" ).datepicker( "option", "maxDate", selectedDate );
}
});
     $.getJSON("../finance/redirect.php?action=costc", function(data) {
   
    $.each(data, function(i,item) {
       
    costcentrs.push({label: item.centrename,value: item.cntrid});  
        
      
  
       $("#cntername" ).autocomplete({
            source: costcentrs,
         //   minLength: 1,
            focus: function(event, ui ) {
             event.preventDefault();
            $(this).val(ui.item.label);
        },
            select: function(event, ui) {
	event.preventDefault();
	$(this).val(ui.item.label);
         $("#cnterid").val(ui.item.value);
				}
        
     
  });
});});


   $("#incmeestatements").click(function(){
      
         window.open('accountsumry.php?startdate='+$("#incmestart").val()+'&enddate='+$("#inncmeend").val()+'','width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
   });
          $("#cnterwise").click(function(){ 
               var centrestart = $("#centrestart").val();
           var centrend = $("#centrend").val();
           if($("#summary").is(':checked')){
               if($("#cntername").val()===""){
               $("#cnterid").val("789");
           }
           window.open('costcnterrprt.php?startdate='+centrestart+'&enddate='+centrend+'&costcenter='+$("#cnterid").val()+'&type=1','','width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');

           }else if($("#details").is(':checked')){
               if($("#cntername").val()===""){
               $("#cnterid").val("789");
           }
            window.open('costcnterrprt.php?startdate='+centrestart+'&enddate='+centrend+'&costcenter='+$("#cnterid").val()+'&type=2','','width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
           }
       });
  
            $("#expnsewise").click(function(){ 
               var expensestart = $("#expensestart").val();
           var expensend = $("#expensend").val();
           if($("#summary").is(':checked')){
               if($("#expnacc").val()===""){
               $("#expnacc").val("789");
           }
           window.open('expenserprt.php?startdate='+expensestart+'&enddate='+expensend+'&expacct='+$("#expnacc").val()+'&type=1','','width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');

           }else if($("#details").is(':checked')){
               if($("#expnacc").val()===""){
               $("#expnacc").val("789");
           }
            window.open('expenserprt.php?startdate='+expensestart+'&enddate='+expensend+'&expacct='+$("#expnacc").val()+'&type=2','','width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
           }
       });
       
                 $("#getbaddebtrprt").click(function(){ 
               var debtstart = $("#baddebtstart").val();
           var debtend = $("#baddebtend").val();

           window.open('baddebtslist.php?startdate='+debtstart+'&enddate='+debtend,'','width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');

       });
       
  });
</script>

<style>
      
     

    </style>


</head>  
    
<body style="overflow-x: hidden;"> 
     
        <?php  
                $type=$_GET['type'];          
                                   
                          
                                
    ?>
        
    
    
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
  	<div id="div_logindetails" ><div>You are logged in as: <?php echo $_SESSION['jname'];?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp</div>
          <span style="text-align: right;display:block">Department: <b><?php echo $_SESSION['dptname'];?></b></span>
      </div>
    <!--Left Panel Starts Here-->
    <div id="div_leftpanel">
<?php include_once 'leftmenu.php'; ?>
    </div>
    <!--Right Panel Starts Here-->
    <div id="div_rightpanel">
   	  <div id="div_datainput">

        <div id="div_formcontainer">
            
        <div id="tabs2">
    
            <?php
                    if($type=="" || $type=="mumin")
            {
            ?>
          <?php
            }
   

            else if($type=="incrprt"){?>
                             <fieldset style="border: 1px burlywood solid;margin-top: 30px"><legend style="color: black;font-size: 14px;font-weight: normal">Accounts Summary</legend>
                 <table class="ordinal" >
                     <tr><td>From :</td><td style="width: 80px"><input id="incmestart" name="incmestart" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td><td>&nbsp;To :</td><td><input id="inncmeend" name="inncmeend" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td></tr>
                <tr><td></td><td><button id="incmeestatements">Get Summary</button></td></tr>
                     </table>
         </fieldset>
		          <?php  }
          else if($type=="costcentrewise"){?>
                             <fieldset style="border: 2px burlywood solid; border-radius: 3px;margin-top: 15px"><legend style="color: black;font-size: 14px;font-weight: normal"><b>Cost Center Wise</b></legend>
                 <table class="ordinal" >
                     <tr><td>From :</td><td style="width: 80px"><input id="centrestart" name="centrestart" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td><td>&nbsp;To :</td><td><input id="centrend" name="centrend" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td></tr>
                     <tr><td>Cost Center:</td><td><input id="cntername" name="cntername" class="formfield"></input></td><td><input name="cnterid" id="cnterid" class="formfield" hidden="true" /></td>
                         <td><input type="radio" name="grpe" id="summary" checked="true" value="summry"/> Summary <input type="radio" name="grpe" id="details" value="detls"/> Detailed </td></tr>
                     <tr><td></td><td><button id="cnterwise">Get Summary</button></td></tr>
                     </table>
         </fieldset>
          <?php  }
            else if($type=="expenseactwse"){
                
             ?>
            <fieldset style="border: 2px burlywood solid; border-radius: 3px;margin-top: 15px"><legend style="color: black;font-size: 14px;font-weight: normal"><b>Expense Account Details</b></legend>
                 <table class="ordinal" >
                     <tr><td>From :</td><td style="width: 80px"><input id="expensestart" name="expensestart" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td><td>&nbsp;To :</td><td><input id="expensend" name="expensend" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td></tr>
                                 <tr><td>Expense Account:</td><td><select id="expnacc" class="formfield">
                         <option value="" selected>--Expense Account--</option>
                     <?php
                      
                      $qry="SELECT expnseaccs.id,expnseaccs.accname FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id  AND expenseactmgnt.deptid = '$id' and expnseaccs.type <> 'A'  GROUP BY expnseaccs.id ORDER BY accname asc";
                      
                      $data11=$mumin->getdbContent($qry);
                      
                      for($k=0;$k<=count($data11)-1;$k++){
                          
                          echo "<option value='".$data11[$k]['id']."'>".$data11[$k]['accname']."</option>";
                      }
                      ?> 
                      
                             </select></td><td></td>
                         <td><input type="radio" name="grpe" id="summary" checked="true" value="summry"/> Summary <input type="radio" name="grpe" id="details" value="detls"/> Detailed </td></tr>
                     <tr><td></td><td><button id="expnsewise">Get Summary</button></td></tr>
                     </table>
                 
       <?php
                
            }
            
                        else if($type=="badebtsrprts"){
                
             ?>
            <fieldset style="border: 2px burlywood solid; border-radius: 3px;margin-top: 15px"><legend style="color: black;font-size: 14px;font-weight: normal"><b>Bad debts Details</b></legend>
                 <table class="ordinal" >
                     <tr><td>From :</td><td style="width: 80px"><input id="baddebtstart" name="baddebtstart" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td><td>&nbsp;To :</td><td><input id="baddebtend" name="baddebtend" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td></tr>
                                                      <tr><td></td><td><button id="getbaddebtrprt">Get Summary</button></td></tr>
                     </table>
                 
       <?php
                
            }
                        else if($type=="bankledger"){
                
             ?>
            <fieldset style="border: 1px ghostwhite solid;margin: 1px;color: black;padding-left: 5px;font-size: 15px;font-weight: bold"><legend></legend> 
                
           <table style="width: 650px;float: left" class="ordinal"> 
                   
             
           <tr><td>From Date :</td><td><input id="startdate3" name="startdate3"  value="<?php echo date('d-m-Y'); ?>" class="formfield"/></td><td>To date</td><td><input id="enddate3" name="enddate3"  value="<?php echo date('d-m-Y'); ?>" class="formfield"/></td></tr>
             
           <tr><td>Account :</td><td>
                   
                   <select id="account3" class="formfield">
                 <?php
                        
                     $qer="SELECT * FROM bankaccounts  WHERE deptid LIKE '$id'"; 
                    
                        $data=$mumin->getdbContent($qer);
    
       
      for($j=0;$j<=count($data)-1;$j++){    
               
               
       echo "<option value='".$data[$j]['bacc']."'>".$data[$j]['acname']." : ".$data[$j]['acno']."</option>";
      
             }
             ?>
                 
                   
                   </select>
               </td></tr>
          
           <tr><td></td><td><button type="submit" id="getbankledger" >Submit</button></td><td></td><td></td></tr>
           </table>
                 
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
                           
                                
      $qer="SELECT *  FROM bankaccounts WHERE deptid LIKE '$id'";
      
      $data=$mumin->getdbContent($qer);
      
       
      for($i=0;$i<=count($data)-1;$i++){
          
          echo "<option value=".$data[$i]['acno'].">".$data[$i]['acname']."</option>";
      }
                         ?>  
                    </select></td></tr>
                   
                   
                   <tr><td></td><td><input name="generatestat" class="formbuttons" type="submit" id="generatestat" value="View Statement"></input></td><td></td><td></td></tr></table></fieldset>
    
     <?php
             
              }
              else if($type=="multistatement"){
               ?>   
                  
               <fieldset style="border: 1px burlywood solid;margin-top: 30px"><legend style="color: black;font-size: 13px;font-weight: bold">Mumineen Batch Statements</legend>
                   <form method="post" action="batchstatements.php">
                   <table class="ordinal" >
                  <tr><td>Sabil number :</td></tr>
                 <tr><td><select id="bsabnos"  class="multiselect" multiple="multiple" name="bsabnos[]">
                            
                              <?php
                                $qrf="SELECT DISTINCT sabilno FROM mumin  WHERE moh LIKE '$moh'"; 
                                
                                $dsab=$mumin->getdbContent($qrf);
                                
                                 for($h=0;$h<=count($dsab)-1;$h++){
                      
                                     echo "<option value=".$dsab[$h]['sabilno'].">".$dsab[$h]['sabilno']."</option>";
                                   }
                            
                            ?>
                            
                        </select></td></tr>
                
                
               
       <tr><td>Date range -Start-End :</td></tr>
       <tr><td style="width: 80px"><input id="bssstart" name="bssstart" class="formfield" value="<?php echo date('Y-m-d')?>"/>&nbsp;-&nbsp;<input name="bssend" id="bssend" class="formfield" value="<?php echo date('Y-m-d')?>"/></td><td></td></tr>
                <tr><td><input type="submit" value="Get Statements"></input></td></tr>
       </table>
                   </form>
         </fieldset>  
                
                
                
               <?php   
              }
                   elseif($type=="debtorsmry"){
            ?>
                       <?php
            }
                ?>
            
            
  </div>
   
 </div>
 
</div>
      
</div>     
    
</div><?php include 'footer.php' ?> 
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
</div>
</body>
</html>