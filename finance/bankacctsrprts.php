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
    
$( "#startdate3" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#enddate3" ).datepicker( "option", "minDate", selectedDate );
}
});   

    
$( "#startdate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 2,
dateFormat: 'yy-mm-dd',
onClose: function( selectedDate ) {
$( "#enddate" ).datepicker( "option", "minDate", selectedDate );
}
});
$( "#enddate" ).datepicker({   
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 2,
dateFormat: 'yy-mm-dd',
onClose: function( selectedDate ) {
$( "#startdate" ).datepicker( "option", "maxDate", selectedDate );
}
});  
  
$( "#enddate3" ).datepicker({   
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#startdate3" ).datepicker( "option", "maxDate", selectedDate );
}
});  
  
 $( "#startdate1" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 2,
dateFormat: 'yy-mm-dd',
onClose: function( selectedDate ) {
$( "#enddate1" ).datepicker( "option", "minDate", selectedDate );
}
});
$( "#enddate1" ).datepicker({   
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 2,
dateFormat: 'yy-mm-dd',
onClose: function( selectedDate ) {
$( "#startdate1" ).datepicker( "option", "maxDate", selectedDate );
}
});  


 $( "#startdate2" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#enddate2" ).datepicker( "option", "minDate", selectedDate );
}
});
$( "#enddate2" ).datepicker({   
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#startdate2" ).datepicker( "option", "maxDate", selectedDate );
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
      
  $( "#iestart" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#ieend" ).datepicker( "option", "minDate", selectedDate );
}
});  
    
 $("#ieend").datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#iestart" ).datepicker( "option", "maxDate", selectedDate );
} });
 
 
 
 
    
$( "#bssstart" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'yy-mm-dd',
onClose: function( selectedDate ) {
$( "#bssend" ).datepicker( "option", "minDate", selectedDate );
}
});
$( "#bssend" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'yy-mm-dd',
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
 
 $( "#brend" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',


});
 $( "#bankrecondate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',


});

  $("#tenantejno" ).autocomplete({source: ejamaatNos});  
   
   
  
  $("#stat").button({
            icons: {
                primary: "ui-icon-document" ,
                        secondary:"ui-icon-check"
            },
            text: true
             
});

 $("#getbankledger").button({
            icons: {
                primary: "ui-icon-carat-1-e" ,
                        secondary:"ui-icon-carat-1-w"
            },
            text: true
             
});
  $("#trialbalanceget").button({
            icons: {
                primary: "ui-icon-document" 
                         
            },
            text: true
             
});
$("#prvwreconciliation").button({
            icons: {
                primary: "ui-icon-document"
                 
            }
      });
      $("#reprintbnkrecon").button({
            icons: {
                primary: "ui-icon-document"
                 
            }
      });

$( "#startdate1" ).datepicker({ dateFormat: 'yy-mm-dd',changeMonth:true,changeYear:true,minDate: new Date(1930,1,1,0,0,0),yearRange: '-80+0'} );


   
   $("#generatexprprt").live('click',function(){
      
        window.open('account_statement.php?startdate='+$("#startdate").val()+'&enddate='+$("#enddate").val(),'width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
   });
   

  
     $("#getbankledger").click(function(){
   
         window.open('bankledger.php?fromdate='+$("#startdate3").val()+'&todate='+$("#enddate3").val()+'&bnkact='+$("#account3").val()+'','width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
   });
   
   $("#iestatements").click(function(){
   
         window.open('iexpnsestatmnt.php?startdate='+$("#iestart").val()+'&enddate='+$("#ieend").val()+'','width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
   });
   $("#ageanalysis").live('click',function(){
       
       
         window.open('ageanalysis.php?startdate='+$("#startdate1").val()+'&accountname='+$("#accountname1").val()+'','width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
   
});

 $("#trialbalanceget").click(function(){
       
       
         window.open('trialbalance.php?startdate1='+$("#startdate2").val()+'&enddate1='+$("#enddate2").val()+'','width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
   
});

   $("#debtorssummary").click(function(){
   
         window.open('debtorsummary.php?dstartdate='+$("#debtstart").val()+'&denddate='+$("#debtorend").val()+'','width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
   });
$("#prvwreconciliation").click(function(){
           // json_redirect.php?action=getreconstat&reconsdate="+$("#brend").val()+"&bankactid="+$("#reconbnkacct").val(), function($response) {
              var $dataString={reconsdate:$("#brend").val(),bankactid:$("#reconbnkacct").val()};
        
      var $urlString="json_redirect.php?action=getreconstat";

               $.ajax({                                                                        
                
                url: $urlString,
                
                type: "GET",
                
                dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
                data:$dataString,
                
                async:    false,
                success: function(response) {
                
              if(response.available=='1'){ 
                           //alert('Reconcilliation already done for this period');
                           $.modaldialog.prompt('<br><b>Reconcilliation already done for this period</b>', {
             timeout: 15,
             width:500,
             showClose: true,
             title:"Alert"
            });
                          }
             else{
             window.open('reconciliation.php?brend='+$("#brend").val()+'&bnktid='+$("#reconbnkacct").val()+'','','fullscreen=1,width='+screen.width+',height='+screen.height+',toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');       
            }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
                              
                  alert("Not saved-please try again later");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
             $(".ui-dialog-titlebar").hide();
              
             }
                 
              });  
            
                     });
                     

$("#reprintbnkrecon").click(function(){
           // json_redirect.php?action=getreconstat&reconsdate="+$("#brend").val()+"&bankactid="+$("#reconbnkacct").val(), function($response) {
              var $dataString={reconsdate:$("#bankrecondate").val(),bankactid:$("#bankreconacct").val()};
        
      var $urlString="json_redirect.php?action=getreconreprintstat";

               $.ajax({                                                                        
                
                url: $urlString,
                
                type: "GET",
                
                dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
                data:$dataString,
                
                async:    false,
                success: function(response) {
                
              if(response.available=='0'){ 
                           //alert('Reconcilliation already done for this period');
                           $.modaldialog.prompt('<br><b>No Reconcilliation done for this period</b>', {
             timeout: 15,
             width:500,
             showClose: true,
             title:"Alert"
            });
                          }
             else{
             window.open('reconreprint.php?brend='+$("#bankrecondate").val()+'&bnktid='+$("#bankreconacct").val()+'','','fullscreen=1,width='+screen.width+',height='+screen.height+',toolbar=0,menubar=1,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');       
            }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
                              
                  alert("Not saved-please try again later");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
             $(".ui-dialog-titlebar").hide();
              
             }
                 
              });  
            
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
	
	$("#muminiwise").click(function(){ 
     
      $("#supplranalys").css("display","none");
      $("#muminstata").css("display","block");
      $("#supstat").css("display","none");
      $("#mumnsabil").css("visibility","visible");
      $("#mumnsabil").val("");
    });
    $("#supplrwise").click(function(){ 
     
      $("#supplranalys").css("display","block");
       $("#supstat").css("display","block");
       $("#muminstata").css("display","none");
      $("#mumnsabil").css("visibility","hidden");
       $("#supplranalys").val("");
    
    });

 $("#prvwragenalysis").click(function(){
     
     if(document.getElementById('muminiwise').checked){
      
        window.open('ageanalysis.php?ageanlyze='+$("#mumnsabil").val()+'&type=sabil','','width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
     }
        else{
         window.open('ageanalysis.php?ageanlyze='+$("#supplranalys").val()+'&type=supplier','','width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');

        }
         
    });    

    
    	$.localise('ui-multiselect', {path: 'js/locale/'});
			$(".multiselect").multiselect();
			 
    function reconpreviewscreen (){
        window.open('reconciliation.php?brend='+$("#brend").val()+'&bnktid='+$("#reconbnkacct").val()+'','','fullscreen=1,width='+screen.width+',height='+screen.height+',toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');

    }
    
    
    
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
<?php include_once 'reportsleftmenu.php'; ?>
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
            
            else if($type=="bank"){
            
           
            
      $qer="SELECT *  FROM bankaccounts WHERE deptid LIKE '$id'";
      
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
          
  <table class="ordinal" >
                     <tr><td style="border: none">
                     <input type="radio" name="ageanl" value="mumini" id="muminiwise" checked="true" ><b>&nbsp&nbspMumin &nbsp&nbsp</b></input>
                     <input type="radio" name="ageanl" value="supplr" id="supplrwise"><b>&nbsp&nbspSupplier</b></input></td></tr>
                    <tr><td id="muminstata"><select id="mumnsabil" class="formfield">
                                <option selected="true" value="all">--ALL MUMINEEN--</option>
                 <?php
                       
                     $jqery="SELECT distinct(sabilno) FROM mumin  ORDER BY sabilno ASC"; 
                       
                   $datay=$mumin->getdbContent($jqery);
    
       
      for($j=0;$j<=count($datay)-1;$j++){    
               
               
       echo "<option value='".$datay[$j]['sabilno']."'>".$datay[$j]['sabilno']."</option>";
      
             }
             ?>
                 
                   
                   </select></td>
                   <td id="supstat">
                       <select id="supplranalys" class="formfield" style="display: none">
                                <option selected="true" value="all">--ALL SUPPLIERS--</option>
                 <?php
                      
                     $jqery2="SELECT supplier,suppName FROM suppliers  WHERE estId = '$id' "; 
                     $datak=$mumin->getdbContent($jqery2);
    
       
      for($j=0;$j<=count($datak)-1;$j++){    
               
               
       echo "<option value='".$datak[$j]['supplier']."'>".$datak[$j]['suppName']."</option>";
      
             }
             ?>
                 
                   
                   </select>
                    </td></tr>
                     <tr><td><button id="prvwragenalysis">Preview</button></td></tr>
                     </table>
</fieldset>  
    
     <?php
             
                
                
            }
            else if($type=="iestatmnt"){?>
                             <fieldset style="border: 1px burlywood solid;margin-top: 30px"><legend style="color: black;font-size: 14px;font-weight: normal">Income Statement</legend>
                 <table class="ordinal" >
                     <tr><td>Start Date :</td><td style="width: 80px"><input id="iestart" name="iestart" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td><td>&nbsp;End date :</td><td><input id="ieend" name="ieend" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td></tr>
                <tr><td></td><td><button id="iestatements">Statement</button></td></tr>
                     </table>
         </fieldset>
		          <?php  }
          else if($type=="bankrecon"){?>
                             <fieldset style="border: 2px burlywood solid; border-radius: 3px;margin-top: 15px"><legend style="color: black;font-size: 14px;font-weight: normal">Bank Reconciliation</legend>
                 <table class="ordinal" >
                     <tr><td>End date :</td><td><input id="brend" name="" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td></tr>
                     <tr><td>Account :</td><td>
                   
                   <select id="reconbnkacct" class="formfield">
                 <?php
                       
                     $qery="SELECT * FROM bankaccounts  WHERE deptid LIKE '$id'"; 
                       
                   $datay=$mumin->getdbContent($qery);
    
       
      for($j=0;$j<=count($datay)-1;$j++){    
               
               
       echo "<option value='".$datay[$j]['bacc']."'>".$datay[$j]['acname']." : ".$datay[$j]['acno']."</option>";
      
             }
             ?>
                 
                   
                   </select>
               </td></tr>
                     <tr><td></td><td><button id="prvwreconciliation">Preview</button></td></tr>
                     </table>
         </fieldset>
          <?php  }
          else if($type=="reprintbankrecon"){?>
                                         <fieldset style="border: 2px burlywood solid; border-radius: 3px;margin-top: 15px"><legend style="color: black;font-size: 14px;font-weight: normal">Reprint Reconciliation</legend>
                 <table class="ordinal" >
                     <tr><td>End date :</td><td><input id="bankrecondate" name="" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td></tr>
                     <tr><td>Account :</td><td>
                   
                   <select id="bankreconacct" class="formfield">
                 <?php
                       
                     $qery="SELECT * FROM bankaccounts  WHERE deptid LIKE '$id'"; 
                       
                   $datay=$mumin->getdbContent($qery);
    
       
      for($j=0;$j<=count($datay)-1;$j++){    
               
               
       echo "<option value='".$datay[$j]['bacc']."'>".$datay[$j]['acname']." : ".$datay[$j]['acno']."</option>";
      
             }
             ?>
                 
                   
                   </select>
               </td></tr>
                     <tr><td></td><td><button id="reprintbnkrecon">Reprint</button></td></tr>
                     </table>
         </fieldset>
            <?php }
          
          
            else if($type=="trialbalance"){
                
             ?>
            <fieldset style="border: 1px ghostwhite solid;margin: 1px;color: black;padding-left: 5px;font-size: 15px;font-weight: bold"><legend>Trial Balance</legend> 
                
           <table style="width: 650px;float: left" class="ordinal"> 
                   
             
           <tr><td>Start Date :</td><td><input id="startdate2" name="startdate2"  value="<?php echo date('d-m-Y'); ?>" class="formfield"/></td><td>Date</td><td><input id="enddate2" name="enddate2"  value="<?php echo date('d-m-Y'); ?>" class="formfield"/></td></tr>

           <tr><td></td><td><button   type="submit" id="trialbalanceget" >Generate</button></td><td></td><td></td></tr>
           </table>
                 
       <?php
                
            }
                        else if($type=="bankledger"){
                
             ?>
            <fieldset style="border: 1px ghostwhite solid;margin: 1px;color: black;padding-left: 5px;font-size: 12px;font-weight: bold"><legend>Bank Ledger</legend> 
                
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
              else if($type=="expenserprt"){
            
           ?>
            
             <fieldset style="border: 1px ghostwhite solid;margin: 1px;color: black;padding-left: 5px;font-size: 15px;font-weight: bold"><legend>Expense Report</legend> 
          
           <table style="width: 650px;float: left" class="ordinal"> 
                    <tr><td>From Date :</td><td><input id="startdate" name="startdate"  value="<?php echo date('Y-m-d'); ?>" class="formfield"/></td><td></td><td></td></tr>
                   <tr><td>To Date :</td><td><input  id="enddate" name="enddate" value="<?php echo date('Y-m-d'); ?>"   class="formfield"/></td></tr>
                 <tr><td></td><td><input name="generatexprprt" class="formbuttons" type="submit" id="generatexprprt" value="View Report"></input></td><td></td><td></td></tr></table></fieldset>
    
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