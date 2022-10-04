<?php
session_start(); 

if(!(isset($_SESSION['eloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  
    $level=$_SESSION['acc'];
    
    if($level >999){
  
        header("location: ../index.php"); 
        
    }
    else{
   
include 'operations/Mumin.php';

$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE id LIKE ".$_SESSION['priviledge']." LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);

if($priviledges[0]['statements']!=1){
   
header("location: index.php");
}
}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    
<head>
    
<title>Estates</title> 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';

$usr=$_SESSION['uname'];  
 
$access=$_SESSION['grp'];   

$id=$_SESSION['est_prop'];

$moh=$_SESSION['mohalla']; 
 

?>

<script src="../assets/js/framework/jquery.localisation-min.js"></script>
<script src="../assets/js/framework/jquery.scrollTo-min.js"></script>
<script src="../assets/js/framework/ui.multiselect.js"></script>
<link  type="text/css" href="../assets/css/ui.multiselect.css" rel="stylesheet"/>   
<script>
    
    
  $(function() {
    
   
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
      
    
$("#invdate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
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
   
         window.open('debtorsummary.php?dstartdate='+$("#debtstart").val()+'&denddate='+$("#debtorend").val()+'','width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
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
    
    
    	$.localise('ui-multiselect', {path: 'js/locale/'});
			$(".multiselect").multiselect();
			 
    
    
    
    
    });
 
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
     
        <?php  
                          
                                   
                                
                                $qr11="SELECT estate_name FROM anjuman_estates WHERE est_id = '$id' LIMIT 1";
                               
                                 $data11=$mumin->getdbContent($qr11);
                                
                                 $estname=$data11[0]['estate_name'];
                                  
                                
    ?>
        
    
    
     <div id="div_pagecontainer">
    <div id="div_pageheader">
  	<div id="div_orglogo"><img src="../assets/images/smallhomegoldlogo.png" width="80" height="84" alt="Mombasa Jamaat Home"/></div>
    <div id="div_orgname">
    	<h1 class="titletext"> Mombasa Jamaat Online</h1>
    </div>
    <div id="div_currentlocation">
    	<h2 class="titletext">Estates Module</h2>
    </div>
  </div>
  <div id="div_pagecontent">
  	<div id="div_logindetails" ><div>You are logged in as: <?php echo $_SESSION['uname'];?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<span style="text-align: right; display:<?php if($_SESSION['grp']=='EXTERNAL'){ echo 'block;';} else{ echo 'none';}?>"> Sector: &nbsp<?php echo $_SESSION['sector'];?></span></div>
      <span style=" text-align: right;display:<?php if($_SESSION['grp']=='MASOOL'){ echo 'block;';} else{ echo 'none';}?>"> MASOOL</span>
      </div>
    <!--Left Panel Starts Here-->
    <div id="div_leftpanel">
   	  <div id="div_pic">
      
            <div id="div_logout" class="button" style="margin-left:10px;"> 
       	<a href="index.php">
          <button class="formbuttons" value="1">
          
              <table style="margin-left: 30px" width="116" border="0">
            <tr>
              <td width="36" height="36" style="text-align:right;"><img src="../assets/images/backward.png" width="35" height="35"/> </td>
              <td width="70" style="text-align:center;">Home</td>
            </tr>
          </table>
          
          </button>
         </a> 
        </div>
      </div>
      
        
      <div id="div_menu">
      	<div id="div_menutitle">Dash Board</div>
        <div id="div_menucontent">
       
        	<ul class="menuitems">
                    
            <li class="menuitems" ><a href="statement_1.php?type=mumin">Customer Statements</a></li>
            <li class="menuitems"> <a href="statement_1.php?type=debtorsmry">Debtor Summary</a> </li>
           <!--<li class="menuitems"><a href="statement_1.php?type=supstatement">Supplier Statements</a></li>!-->
           <!-- <li class="menuitems"><a href="statement_1.php?type=bank">Account Balances</a></li>
            <li class="menuitems"><a href="statement_1.php?type=statement">Account Statements</a></li>!--> 
            <li class="menuitems"><a href="statement_1.php?type=selectivebatch">Selective batch</a></li>  
           <!-- <li class="menuitems"><a href="statement_1.php?type=ageanalysis">Age Analysis</a></li>!-->
            <li class="menuitems" ><a href="index.php">Home</a></li> 
              
                    
                 
          <li class="menuitems"><a href="logout.php" class="menuitems"> Log Out</a> </li>
       </ul>
        </div>
      </div>
    </div>
    <!--Right Panel Starts Here-->
    <div id="div_rightpanel">
   	  <div id="div_datainput">
      	<div id="div_formtitle">
        	<h3 class="titletext">Statements </h3>
        </div>
        <div id="div_formcontainer">
            
        <div id="tabs2">
    
            <?php
            
            $type=$_GET['type'];
            
            if($type=="" || $type=="mumin")
            {
            ?>
   
        
       
       <fieldset style="border: 1px ghostwhite solid"><legend style="color: black;font-size: 13px;font-weight: bold">Choose Category</legend>
           
           
           
           <table class="ordinal" id="radiobutt"><tr><td style="width: 20px"><input class="rb" name="r1" value="sabil" id="r1" type="radio" checked="true"/></td><td style="width: 50px">Sabil</td><td style="width: 20px"><input class="rb" id="r1" name="r1" value="dbtr" type="radio"/></td><td>Debtor</td><td><select style="visibility: hidden" class="formfield" id="dbt3">
                           
                           
                           <?php
                            
                              
                                $qrt="SELECT * FROM estate_debtors WHERE estId = '$id'"; 
                                
                                $datas=$mumin->getdbContent($qrt);
                                
                                 echo "<option value=''>--select debtor--</option>"; 
                                
                                 for($h=0;$h<=count($datas)-1;$h++){
                      
                                     echo "<option value=".$datas[$h]['dno'].">".$datas[$h]['debtorname']."</option>";
                                   }
                            
                            
                              ?>
                           
                       </select></td></tr></table>
           
           <table class="ordinal" style="visibility: visible" id="tbl3" >  <tr><td style="width: 290px" ><input class="formfield" id="statsabil" style="text-transform: uppercase" placeholder="Enter Sabil No." type="text" maxlength="4"/></td><td id="statname" style="width:300px;border: none;font-weight: bold;font-size: 13px;"></td></tr> 
           
           </table>   
       </fieldset>
       
         <fieldset id="statmntfield" style="border: 1px burlywood solid;margin-top: 30px;display: none"><legend style="color: black;font-size: 13px;font-weight: bold">Additional Settings</legend>
            <table class="ordinal" id="detinfo"  >
       
                <tr><td>Start Date :</td><td style="width: 80px"><input id="ssstart" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td><td>&nbsp;End date :</td><td><input id="ssend" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td></tr>
                <tr><td></td><td><button id="stat">View Statement</button></td></tr>
       </table>
         </fieldset> 
  
    
            
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
                  
               <fieldset style="border: 1px burlywood solid;margin-top: 30px"><legend style="color: black;font-size: 13px;font-weight: bold">Selective Batching</legend>
                   <form method="post" action="selectivebatch.php">
                   <table class="ordinal" >
                  <tr><td>Sabil number :</td></tr>
                 <tr><td colspan="3"><select id="selctivesabno"  class="multiselect" multiple="multiple" name="selctivesabno[]">
                            
                              <?php
                                $qrf="SELECT DISTINCT sabilno FROM mumin  WHERE moh LIKE '$moh'"; 
                                
                                $dsab=$mumin->getdbContent($qrf);
                                
                                 for($h=0;$h<=count($dsab)-1;$h++){
                      
                                     echo "<option value=".$dsab[$h]['sabilno'].">".$dsab[$h]['sabilno']."</option>";
                                   }
                            
                            ?>
                            
                        </select></td></tr>
                
                
               
       <tr><td>Date:</td></tr>
       <tr><td style="width: 80px"><input id="invdate" name="invdate" class="formfield" value="<?php echo date('Y-m-d')?>"/></td>
           <td style="border: none">&nbsp;&nbsp;Income Account:</td>
                    <td style="border: none"><select name="incmeacc" class="formfield" id="incmeacc"> 
                                <?php
                                $qr="SELECT * FROM estate_incomeaccounts"; 
                                
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
                <tr><td><input type="submit" value="Generate Invoice"></input></td></tr>
       </table>
                   </form>
         </fieldset>  
                
                
                
               <?php   
              }
                   elseif($type=="debtorsmry"){
            ?>
           <fieldset style="border: 1px burlywood solid;margin-top: 30px"><legend style="color: black;font-size: 14px;font-weight: normal">Debtor summary</legend>
                 <table class="ordinal" >       
                     <tr><td>Start Date :</td><td style="width: 80px"><input id="debtstart" name="debtstart" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td><td>&nbsp;End date :</td><td><input id="debtorend" name="debtorend" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td></tr>
                <tr><td></td><td><button id="debtorssummary">View Summary</button></td></tr>
                     </table>
         </fieldset>
            <?php
            }
                ?>
            
            
  </div>
   
 </div>
 
</div>
      
</div>     
        
</div>
</div>
</body>
</html>