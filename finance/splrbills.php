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

if($priviledges[0]['suppliers']!=1){
   
header("location: index.php");
}
if($priviledges[0]['readonly']==1){
    $savsupplier = '';
     $savbill = '';
     $savb = '';
}else if($priviledges[0]['readonly']!=1){
    $savsupplier = '<button id="savsupplier" class="formbuttons">Save</button>';
    $savbill = '<button id="savbill" class="formbuttons">Save</button>';
    $savb = '<button id="savb" class="formbuttons">Save</button>';
   }
}

date_default_timezone_set('Africa/Nairobi');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Suppliers </title>
 
<?php include '../partials/stylesLinks.php';   include 'links.php';
	$eid = $_SESSION['dept_id'];
 ?>
 <script>
    $(function() {
     
      var expsubacc=[];
      var costcentrs=[];
                $.getJSON("../finance/redirect.php?action=expsubacc", function(data) {
   
    $.each(data, function(i,item) {
       
    expsubacc.push(item.subacc);
    
    $("#suplrsubacc").autocomplete({
        source: expsubacc,
         focus: function(event, ui ) {
             event.preventDefault();
            $(this).val(ui.item.label);
        },
            select: function(event, ui) {
	event.preventDefault();
	$(this).val(ui.item.label);
	        }
        });
        
       });
   }); 
   
     $.getJSON("../finance/redirect.php?action=costc", function(data) {
   
    $.each(data, function(i,item) {
       
    costcentrs.push({label: item.centrename,value: item.cntrid});  
        
      
  
       $("#costcntre" ).autocomplete({
            source: costcentrs,
         //   minLength: 1,
            focus: function(event, ui ) {
             event.preventDefault();
            $(this).val(ui.item.label);
        },
            select: function(event, ui) {
	event.preventDefault();
	$(this).val(ui.item.label);
         $("#costcntreid").val(ui.item.value);
				}
        
     
  });
         $("#costcntre1" ).autocomplete({
            source: costcentrs,
         //   minLength: 1,
            focus: function(event, ui ) {
             event.preventDefault();
            $(this).val(ui.item.label);
        },
            select: function(event, ui) {
	event.preventDefault();
	$(this).val(ui.item.label);
         $("#costcntreid1").val(ui.item.value);
				}
        
     
  });
           $("#costcntre2" ).autocomplete({
            source: costcentrs,
         //   minLength: 1,
            focus: function(event, ui ) {
             event.preventDefault();
            $(this).val(ui.item.label);
        },
            select: function(event, ui) {
	event.preventDefault();
	$(this).val(ui.item.label);
         $("#costcntreid2").val(ui.item.value);
				}
        
     
  })
           $("#costcntre3" ).autocomplete({
            source: costcentrs,
         //   minLength: 1,
            focus: function(event, ui ) {
             event.preventDefault();
            $(this).val(ui.item.label);
        },
            select: function(event, ui) {
	event.preventDefault();
	$(this).val(ui.item.label);
         $("#costcntreid3").val(ui.item.value);
				}
        
     
  })
           $("#costcntre4" ).autocomplete({
            source: costcentrs,
         //   minLength: 1,
            focus: function(event, ui ) {
             event.preventDefault();
            $(this).val(ui.item.label);
        },
            select: function(event, ui) {
	event.preventDefault();
	$(this).val(ui.item.label);
         $("#costcntreid4").val(ui.item.value);
				}
        
     
  })
     }); 
      });
	var clsingdate = $("#clsingdate" ).val();
      // DataTable configuration
  $('#sortableinvoice').dataTable( {
	"bSort":false,
	// "sPaginationType": "full_numbers",
	"iDisplayLength": 25,
	"aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
	"bJQueryUI": true
  } );
  
     // DataTable configuration
  $('#sortablebills').dataTable( {
	"bSort": false,
	//"sPaginationType": "full_numbers",
	"iDisplayLength": 25,
	"aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
	"bJQueryUI": true
  } );
     
     
        // DataTable configuration
  $('#sortablebatch').dataTable( {
	"bSort":false,
	// "sPaginationType": "full_numbers",
	"iDisplayLength": 25,
	"aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
	"bJQueryUI": true
  } );
     
     
     
     
     
$("#oc" ).datepicker({ dateFormat: 'yy-mm-dd'} );

$("#creditdate" ).datepicker({ dateFormat: 'dd-mm-yy'} );
     
     
     
$( "#invoicestartdate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 2,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#invoiceenddate" ).datepicker( "option", "minDate", selectedDate );
}
});
$( "#invoiceenddate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 2,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#invoicestartdate" ).datepicker( "option", "maxDate", selectedDate );
}
}); 


    
     
$( "#billsstartdate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',  
onClose: function( selectedDate ) {
$( "#billsenddate" ).datepicker( "option", "minDate", selectedDate );
}
});

$( "#billsenddate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,  
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',   
onClose: function( selectedDate ) {
$( "#billsstartdate" ).datepicker( "option", "maxDate", selectedDate );
}
}); 
     
    
    $("#batchinvoicegen").button({
            icons: {
                primary: "ui-icon-gear",
                secondary: "ui-icon-print" 
            }
        });
        
       
        
         $("#cancl1").button({
            icons: {
                primary: "ui-icon-close"
                 
            }
        });
        
        $("#viewinvoicelist").button({
            icons: {
                primary: "ui-icon-document"
                 
            }
        });
        
        $("#viewinvoicelist1").button({
            icons: {
                primary: "ui-icon-print"
                 
            }
        });
        $("#gnrt").button({
            icons: {
                primary: "ui-icon-check",
                secondary: "ui-icon-gear" 
            }
        });
        
        $("#creditgnrt").button({
            icons: {
                primary: "ui-icon-check",
                secondary: "ui-icon-gear" 
            }
        });
        
          $("#myinvoiceprint").button({
            icons: {
                 
                secondary: "ui-icon-print" 
            }
        });
        $("#billslist1 ").button({
            icons: {
                 
                secondary: "ui-icon-print" 
            }
        });
 
   
  $("#billdate" ).datepicker({ dateFormat: 'dd-mm-yy', minDate: parseInt(clsingdate)+parseInt(1), maxDate: parseInt(0)}  );
  $("#mbilldate" ).datepicker({ dateFormat: 'dd-mm-yy', minDate: parseInt(clsingdate)+parseInt(1)} );
   $("#invsdate" ).datepicker({ dateFormat: 'dd-mm-yy'} );
      
   
    $("#invdt" ).datepicker({ dateFormat: 'dd-mm-yy'} );
    
    $("#balancedt" ).datepicker({ dateFormat: 'dd-mm-yy'} );


  $('#editsupp').dataTable( {
	"bSort": false,
	// "sPaginationType": "full_numbers",
	"iDisplayLength": 25,
	"aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
	"bJQueryUI": true
  } );
    $('#editbil').dataTable( {
	"bSort": false,
	// "sPaginationType": "full_numbers",
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
	"bJQueryUI": true
  } );
           $( "#supprint" ).button({
            icons: {
                primary: "ui-icon-print"
            }
             }).click(function(){
            
            var newWin= window.open("");
            newWin.document.write(document.getElementById("editsupp").outerHTML);
            newWin.print();
            newWin.close();
          return false; 
 
       });
       
        $("#okcancel").button({
            icons: {
                primary: "ui-icon-check"
            }});
           $("#okdelete2").button({
            icons: {
                primary: "ui-icon-trash"
            }});
         $('.amount') .keyup(function(e) {
				var e = window.event || e;
				var keyUnicode = e.charCode || e.keyCode;
				if (e !== undefined) {
					switch (keyUnicode) {
						case 16: break; // Shift
						case 17: break; // Ctrl
						case 18: break; // Alt
						case 27: this.value = ''; break; // Esc: clear entry
						case 35: break; // End
						case 36: break; // Home
						case 37: break; // cursor left
						case 38: break; // cursor up
						case 39: break; // cursor right
						case 40: break; // cursor down
						case 78: break; // N (Opera 9.63+ maps the "." from the number key section to the "N" key too!) (See: http://unixpapa.com/js/key.html search for ". Del")
						case 110: break; // . number block (Opera 9.63+ maps the "." from the number block to the "N" key (78) !!!)
						case 190: break; // .
						default: $(this).formatCurrency({ colorize: true, roundToDecimalPlace: -1, eventOnDecimalsEntered: true });
					}
				}
   });
     
           $('#multibill').click(function(){
       $("#nwbl").css("display","none");
       $("#multibl").css("display","block");
       $("#billsupplier").val("");
        $("#billno").val("");
        $("#amount").val("");
        $("#expnacc").val("");
        $("#suplrsubacc").val("");
        $("#billrmks").val("");
   });
                $('#singlebill').click(function(){
       $("#nwbl").css("display","block");
       $("#multibl").css("display","none");
              $("#billsupplier").val("");
        $("#billno").val("");
        $("#amount").val("");
        $("#expnacc").val("");
        $("#suplrsubacc").val("");
        $("#billrmks").val("");
   });
     });
    
    
    
 
</script>
 
<style type="text/css">
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
        .ui-effects-wrapper{overflow-x: visible !important; width: 2px !important; height: 2px !important }
	</style>
   
<link rel="stylesheet" href="./css/smoothness.css" />


<!--<link rel="stylesheet" href="../themes/smoothness/jquery-ui.css" />!-->

</head>

<body>
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
      	
        <div id="div_formcontainer">
        	<div id="tabs2">

         <?php
         
         $acti=$_GET['idaction'];
         
         if($acti=="new"){
             
          ?>
           
  
         <?php
         }
         else if($acti=="creditnote"){
          ?>
             
          
            
                    
                    <fieldset style="border: 1px gold solid"><legend style="color: #333;font-weight: bold;font-style: italic">Customer Credit Note</legend>         
          <table id="" class="ordinal">   
              
              
               <tr><td>Date:&nbsp;</td><td><input type="text" id="creditdate"  class="formfield" value="<?php echo date('d-m-Y'); ?>"></input></td><td></td></tr>   
               <tr><td></td><td> <font class="tooltits">Select date</font></td><td></td> </tr>  
           <tr> 
                    
                    
                    <td style="border: none">Reference Invoice No:</td>
                     
                     <td style="border: none">
                             <input type="text" id="creditinvoice" class="formfield"></input></td><td></td></tr>
                   
                  <tr><td></td><td> <font class="tooltits">The erroneous invoice,you wish to correct</font></td><td></td> </tr>
          
                        
                  <tr><td>Amount:&nbsp;</td><td><input value="0.00"   onkeypress="return isNumberKey(event);" type="text" id="creditamount"  class="formfield"></input></td><td></td></tr>   
                        
                   <tr><td></td><td> <font class="tooltits">The extra amount overcharged</font></td><td></td> </tr>      
                      
                  <tr><td>Brief Remarks </td><td><textarea id="creditremarks"     class="formfield"></textarea></td><td></td></tr> 
                  <tr><td></td><td><button id="creditgnrt">Complete</button></td><td></td></tr>   
                </table>  
         
                    </fieldset>
         
                    
      
          <?php
          }
          else if($acti=="newsupp"){
    
    ?>
    
         <fieldset style="border:1px ghostwhite solid;color:black;width: 700px;font-size: 15px;font-weight: bold">    
       
            <legend>Add new supplier</legend>
            <table   class="ordinal"> 
          <tr><td>Supplier Name (*):</td><td><input  type="text" id="supname" class="formfield"></input></td></tr>            
          <tr><td></td><td><font class="tooltits">e.g  Kenchic suppliers</font></td></tr>
           <tr><td>Supplier telephone (*):</td><td><input id="supmobile" type="text" class="formfield"></input> 
               </td></tr>
          <tr><td></td><td><font class="tooltits">e.g 0710123456,0711123456,0712123456</font></td></tr> 
          
           
          
          
          <tr><td>Postal Address &amp; Zip:</td><td><input id="pzip" type="text"  class="formfield"></input> 
               </td></tr>
          <tr><td></td><td><font class="tooltits">e.g 20100-00100</font></td></tr>
          <tr><td>City (*):</td><td><input id="scity" type="text"  class="formfield"></input> 
               </td></tr>
          <tr><td></td><td><font class="tooltits">e.g Mombasa,Nakuru e.t.c</font></td></tr>
          <tr><td>Email address :</td><td><input id="semail" type="email"   class="formfield"></input> 
               </td></tr>
          <tr><td></td><td><font class="tooltits">e.g xyz@yahoo.com,xyz@gmail.com</font></td></tr>
          <tr><td>Remarks:</td><td><textarea  class="formfield" id="supprmks"  ></textarea> 
               </td></tr>
          <tr><td></td><td><font class="tooltits">Brief remarks</font></td></tr>
          <tr><td></td><td><?php echo $savsupplier; ?>&nbsp;<button id="caclsupplier" class="formbuttons">Cancel</button>  
               </td></tr>
         </table>
     
         </fieldset>   
           
           <?php
           }
                      else if($acti=="editsupp"){
           
     
           $qer="SELECT * FROM suppliers WHERE estId LIKE '$id'"; 
      
       $datasup=$mumin->getdbContent($qer);
    
       echo "<fieldset style='border:1px lightgray solid;color:gray;font-size: 15px;font-weight: bold'> "; 
       echo "<legend>Suppliers</legend>";
      
      echo "<table id='editsupp' class='invview'>"; 
      echo '<thead>';
       echo "<tr><th></th><th style='font-size:12px'>SN</th><th style='font-size:12px;'>Names</th><th style='font-size:12px'>Telephone</th><th style='font-size:12px'>Email</th><th style='font-size:12px'>Postal Addr</th><th style='font-size:12px'>City</th><th style='font-size:12px'></th>";
      echo '</thead>';
      echo '<tbody>';
      $y=1;
      for($j=0;$j<=count($datasup)-1;$j++){    
               
               
     echo "<tr><td  id='cgl".$j."'>".$datasup[$j]['supplier']."</td><td>".$y++."</td><td id='cnl".$j."' style='font-size:12px;width:200px'>".$datasup[$j]['suppName']."</td><td id='ctl".$j."' style='font-size:12px'>".$datasup[$j]['suppTelephone']."</td><td id='cml".$j."' style='font-size:12px'>".$datasup[$j]['email']."</td><td id='cpl".$j."' style='font-size:12px'>".$datasup[$j]['postal']."</td><td id='ccl".$j."' style='font-size:12px'>".$datasup[$j]['city']."</td><td style='font-size:12px'><a id='k".$j."' class='changeaction' href='#'>Edit</a>&nbsp;</td></tr>";
      //|&nbsp;<a id='v".$j."' class='changedelete3' href='#'>Delete</a>.
             }
      echo '</tbody>';
      echo "</table>";
      echo "</fieldset>";
         echo "<div id='suppliersFilterBar' style='width:100%'><button id='supprint'  style='float: right;height:20px;width:20px;margin:4px 45px 4px 0px'>Print</button></div>";  
            
           }
		                        else if($acti=="editbill"){
    // if($priviledges[0]['admin']==1){
           $qer12="SELECT bills.id,bdate,bills.docno,suppliers.suppName,suppliers.supplier,bills.rmks,expnseaccs.id as expid,expnseaccs.accname,department2.centrename,pdamount FROM `bills`,suppliers,expnseaccs,department2 WHERE bills.estate_id LIKE  '$id' AND suppliers.supplier = bills.supplier AND expnseaccs.id = bills.expenseacc AND department2.id = bills.costcentrid AND estate_id = '$id' AND bdate >= DATE_FORMAT(CURDATE(), '%Y-%m-01') - INTERVAL 2 MONTH order by suppName "; 
      
       $dataeditbill=$mumin->getdbContent($qer12);
    
      
       echo "<fieldset style='border:1px lightgray solid;color:gray;font-size: 15px;font-weight: bold'> ";
       echo "<legend>Supplier Bills</legend>";
      
      echo "<table id='editbil' class='invview' style='margin-top:3px;'>"; 
      echo '<thead>';
       echo "<tr><th style='font-size:12px;display: none'>SN</th><th style='font-size:12px'>Bill No</th><th style='font-size:12px'>Date</th><th style='font-size:12px'>Supplier</th><th style='font-size:12px'>Remarks</th><th style='font-size:12px'>Expense Acct</th><th style='font-size:12px'></th>";
      echo '</thead>';
      echo '<tbody>';
      for($n=0;$n<=count($dataeditbill)-1;$n++){    
               
                if($dataeditbill[$n]['pdamount']!== '0.00'){
      echo "<tr><td  id='cgl".$n."' style='font-size:12px;display: none '>".$dataeditbill[$n]['id']."</td><td id='biln".$n."' style='font-size:12px'>".$dataeditbill[$n]['docno']."</td><td id='bild".$n."' style='font-size:12px'>".date('d-m-Y',strtotime($dataeditbill[$n]['bdate']))."</td><td id='cml".$n."' style='font-size:12px'>".$dataeditbill[$n]['suppName']."</td><td id='rmk".$n."' style='font-size:12px'>".$dataeditbill[$n]['rmks']."</td><td id='ccl".$n."' style='font-size:12px'>".$dataeditbill[$n]['accname']."</td><td style='font-size:12px'><a id='k".$n."' class='changepdbill' href='#'> Edit </a>&nbsp;<input type='text' value='".$dataeditbill[$n]['supplier']."' id='supl".$n."' hidden='true' /><input type='text' value='".$dataeditbill[$n]['expid']."' id='exp".$n."' hidden='true' /></td></tr>";               
                }else{
      echo "<tr><td  id='cgl".$n."' style='font-size:12px;display: none '>".$dataeditbill[$n]['id']."</td><td id='biln".$n."' style='font-size:12px'>".$dataeditbill[$n]['docno']."</td><td id='bild".$n."' style='font-size:12px'>".date('d-m-Y',strtotime($dataeditbill[$n]['bdate']))."</td><td id='cml".$n."' style='font-size:12px'>".$dataeditbill[$n]['suppName']."</td><td id='rmk".$n."' style='font-size:12px'>".$dataeditbill[$n]['rmks']."</td><td id='ccl".$n."' style='font-size:12px'>".$dataeditbill[$n]['accname']."</td><td style='font-size:12px'><a id='k".$n."' class='changebill' href='#'>Edit</a>&nbsp;<input type='text' value='".$dataeditbill[$n]['supplier']."' id='supl".$n."' hidden='true' /><input type='text' value='".$dataeditbill[$n]['expid']."' id='exp".$n."' hidden='true' /></td></tr>";
	  //|&nbsp;<a id='v".$j."' class='changedelete3' href='#'>Delete</a>.
            } }
      echo '</tbody>';
      echo "</table>";
   echo "</fieldset>";    
           
    // }
           }
           else if($acti=="newbill"){
          ?>

           <div id="setupxx" style="width: 100%;height: auto;background: transparent;padding-top: 5px">
               <div style="text-shadow:0 0 3px gold ;font-size: 1.2em;font-weight: bold;">New Bill</div>
               <div><input type="radio" id="singlebill" name="billtyp" checked="true"></input><b> Single Cost Center</b>
                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="multibill" name="billtyp"></input><b> Multi Cost Center</b></div>
         <table class="ordinal" id="nwbl">
              <tr><td>Supplier (*):</td><td><select id="billsupplier" class="formfield">
                      <option value="" selected>--Select Supplier--</option>
                      <?php
                      
                      $qnwbil="SELECT * FROM suppliers WHERE estId LIKE '$id' order by suppName asc";
                      
                      $datanwbill=$mumin->getdbContent($qnwbil);
                      
                      for($k=0;$k<=count($datanwbill)-1;$k++){
                          
                          echo "<option value='".$datanwbill[$k]['supplier']."'>".$datanwbill[$k]['suppName']."</option>";
                      }
                      ?>
                      
                  </select> 
               </td><td>Doc Type:</td> <td><select id="doctype" class="formfield">
                      <option value="1">BILL</option>
                                            
                  </select></td></tr>
          <tr><td>Date (*):</td><td><?php
                                 
                                $qrtrbil="SELECT deptid as estate_id,cdate as date FROM closing_period WHERE deptid = '$id' ORDER BY id DESC LIMIT 1 "; 
                                
                                $databil=$mumin->getdbContent($qrtrbil);
                                
                                 for($v=0;$v<=count($databil)-1;$v++){
                                   $qru=  "SELECT DATEDIFF('".$databil[$v]['date']."','".date('Y-m-d')."') AS DiffDate";
                                    $datau=$mumin->getdbContent($qru);
                                    for($w=0;$w<=count($datau)-1;$w++){
                                     echo "<input hidden='true' type='text' id='clsingdate'  class='formfield' value='".$datau[$w]['DiffDate']."'>";
                                   //  echo "<option value=".$data[$h]['date'].">".$data[$h]['date']."</option>";
                                   } }
                            
                            ?>
		<input  readonly="true" type="text"  id="billdate" class="formfield" value="<?php echo date('d-m-Y');?>"></input></td>
              <td id="invnotd" hidden="true">Invoice No:</td><td><input id="crdtinvno" type="text" class="formfield" hidden="true" onchange="viewbilcrdt()"></input> </td></tr>            
          <!--<tr><td></td><td><font class="tooltits">&nbsp</font></td></tr>-->
           <tr><td>Document No (*):</td><td><input id="billno" type="text" class="formfield" style="text-transform:uppercase"></input> 
               </td>
           <td rowspan="3" style="display:none" id="taxtd"><input placeholder="Supplier Amount" id="supplamt"></input><br></br>
               <input id="addtax" placeholder="V.A.T Amount" Readonly ></input>&nbsp;&nbsp;&nbsp;<input id="ratetax"  value="0" style="width:30px"placeholder="VAT"></input>%<br></br>
                <input id="affertax" placeholder="After Tax" Readonly style="font-weight: bold"></input></td></tr>
          <!--<tr><td></td><td><font class="tooltits">e.g B1292</font></td></tr> -->
          
           <tr><td>Amount (*):</td><td><input    id="billamount" type="text"   class="amount"></input> 
               </td><td style="display: none"><button class="btncls" style="border-radius:3px;display: none" id="taxbtn" >Tax</button></td>
                    </tr>
          <!--<tr><td></td><td><font class="tooltits">Amount payable</font></td></tr>-->
          
         <tr><td>Cost Center (*):</td><td><input id="costcntre" type="text"   class="formfield"></input> 
             </td><td><input  type="hidden" readonly="readonly" id="costcntreid"/></td>
                    </tr>
          <!--<tr><td></td><td><font class="tooltits">select supplier</font></td></tr>-->
          <tr><td>Expense Account (*):</td><td><select id="expnacc" class="formfield">
                      <option value="" selected>--Expense Account--</option>
                     <?php
                      
                      $qrybil="SELECT expnseaccs.id,expnseaccs.accname FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id  AND expenseactmgnt.deptid = '$id' GROUP BY expnseaccs.id ORDER BY accname asc";
                      
                      $data11bl=$mumin->getdbContent($qrybil);
                      
                      for($u=0;$u<=count($data11bl)-1;$u++){
                          
                          echo "<option value='".$data11bl[$u]['id']."'>".$data11bl[$u]['accname']."</option>";
                      }
                      ?> 
                      
                      
                  </select> 
              </td><td>Allocation Acc:</td><td><select  class="formfield" id="suplrsubacc"></select></td></tr>
          <!--<tr><td></td><td><font class="tooltits">Choose expense account</font></td></tr>-->
          <tr><td>Remarks:</td><td><textarea  id="billrmks" class="formfield" ></textarea> 
               </td></tr>
          <tr><td></td><td><font class="tooltits">&nbsp</font></td></tr>
          <tr><td></td><td><?php echo $savbill;  ?>&nbsp;&nbsp;<button id="caclbill" class="formbuttons">Cancel</button>  
               </td></tr>
         </table>
               <table class="ordinal" id="multibl" style="display:none">
                   
              <tr><td>Supplier (*):</td><td><select id="mbillsupplier" class="formfield">
                      <option value="" selected>--Select Supplier--</option>
                      <?php
                      
                      $q="SELECT * FROM suppliers WHERE estId LIKE '$id' ORDER BY suppName";
                      
                      $data=$mumin->getdbContent($q);
                      
                      for($g=0;$g<=count($data)-1;$g++){
                          
                          echo "<option value='".$data[$g]['supplier']."'>".$data[$g]['suppName']."</option>";
                      }
                      ?>
                      
                  </select> 
               </td><td>Doc Type:</td> <td><select id="mdoctype" class="formfield">
                      <option value="1">BILL</option>
                                            
                  </select></td></tr>
          <tr><td>Date (*):</td><td><?php
                                 
                                $qrtrdt="SELECT deptid as estate_id,cdate as date FROM closing_period WHERE deptid = '$id' ORDER BY id DESC LIMIT 1 "; 
                                
                                $datatr=$mumin->getdbContent($qrtrdt);
                                
                                 for($f=0;$f<=count($datatr)-1;$f++){
                                   $qrudt=  "SELECT DATEDIFF('".$datatr[$f]['date']."','".date('Y-m-d')."') AS DiffDate";
                                    $dataudt=$mumin->getdbContent($qrudt);
                                    for($p=0;$p<=count($dataudt)-1;$p++){
                                     echo "<input hidden='true' type='text' id='clsingdate'  class='formfield' value='".$dataudt[$p]['DiffDate']."'>";
                                   //  echo "<option value=".$data[$h]['date'].">".$data[$h]['date']."</option>";
                                   } }
                            
                            ?>
		<input  readonly="true" type="text"  id="mbilldate" class="formfield" value="<?php echo date('d-m-Y');?>"></input></td>
              <td id="invnotd" hidden="true">Invoice No:</td><td><input id="crdtinvno" type="text" class="formfield" hidden="true" onchange="viewbilcrdt()"></input> </td></tr>            
          <!--<tr><td></td><td><font class="tooltits">&nbsp</font></td></tr>-->
           <tr><td>Document No (*):</td><td><input id="mbillno" type="text" class="formfield" style="text-transform:uppercase" ></input> 
               </td>
           <td rowspan="3" style="display:none" id="taxtd"><input placeholder="Supplier Amount" id="supplamt"></input><br></br>
               <input id="addtax" placeholder="V.A.T Amount" Readonly ></input>&nbsp;&nbsp;&nbsp;<input id="ratetax"  value="0" style="width:30px"placeholder="VAT"></input>%<br></br>
                <input id="affertax" placeholder="After Tax" Readonly style="font-weight: bold"></input></td></tr>
          <!--<tr><td></td><td><font class="tooltits">e.g B1292</font></td></tr> -->
          
                     <tr><td>Cost Center (*):</td><td><input id="costcntre1" type="text"   class="formfield centrids"></input><input  type="hidden" readonly="readonly" id="costcntreid1"/> 
                         </td><td>Amount (*):</td><td><input    id="billamount1" type="text"   class="amount centramnt" val="0.00" onkeyup="updatemutlibillamnt(1)"></input> 
               </td>
                       </tr>
                   <tr><td>Cost Center :</td><td><input id="costcntre2" type="text"   class="formfield centrids"></input><input  type="hidden" readonly="readonly" id="costcntreid2"/> 
             </td><td>Amount :</td><td><input    id="billamount2" type="text"   class="amount centramnt" val="0.00" onkeyup="updatemutlibillamnt(2)"></input> 
               </td>
                       </tr>
                   <tr><td>Cost Center :</td><td><input id="costcntre3" type="text"   class="formfield centrids"></input><input  type="hidden" readonly="readonly" id="costcntreid3"/> 
             </td><td>Amount :</td><td><input    id="billamount3" type="text"   class="amount centramnt" val="0.00" onkeyup="updatemutlibillamnt(3)"></input> 
               </td>
                       </tr>
                   <tr><td>Cost Center :</td><td><input id="costcntre4" type="text"   class="formfield centrids"></input><input  type="hidden" readonly="readonly" id="costcntreid4"/> 
             </td><td>Amount :</td><td><input    id="billamount4" type="text"   class="amount centramnt" val="0.00" onkeyup="updatemutlibillamnt(4)"></input> 
               </td>
                   </tr>
                   <tr><td></td><td></td><td><font class="tooltits"><b>Total Amount:</b></font></td><td><input type="text" id="multibilltotal"  class="amount" readonly="true" style="font-weight: bold"></input></td></tr>
            <!--<tr><td></td><td><font class="tooltits">select supplier</font></td></tr>-->
          <tr><td>Expense Account (*):</td><td><select id="mexpnacc" class="formfield">
                      <option value="" selected>--Expense Account--</option>
                     <?php
                      
                      $qryexp="SELECT expnseaccs.id,expnseaccs.accname FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id  AND expenseactmgnt.deptid = '$id' GROUP BY expnseaccs.id";
                      
                      $data11exp=$mumin->getdbContent($qryexp);
                      
                      for($b=0;$b<=count($data11exp)-1;$b++){
                          
                          echo "<option value='".$data11exp[$b]['id']."'>".$data11exp[$b]['accname']."</option>";
                      }
                      ?> 
                      
                      
                  </select> 
              </td><td>Allocation Acc:</td><td><select  class="formfield" id="msuplrsubacc"></select></td></tr>
          <!--<tr><td></td><td><font class="tooltits">Choose expense account</font></td></tr>-->
          <tr><td>Remarks:</td><td><textarea  id="mbillrmks" class="formfield" ></textarea> 
               </td></tr>
          <tr><td></td><td><font class="tooltits">&nbsp</font></td></tr>
          <tr><td></td><td><?php echo $savb;  ?>&nbsp;&nbsp;<button id="caclb" class="formbuttons">Cancel</button>  
               </td></tr>
         </table>
         </div>
        <?php
            }
          
            else if($acti=="newcrdtnote"){
          ?>

           <div id="setupxx" style="width: 100%;height: auto;background: transparent;padding-top: 5px">
               <div style="text-shadow:0 0 3px gold ;font-size: 1.2em;font-weight: bold;">Debit Note</div>
         <table class="ordinal" id="nwbl">
              <tr><td>Supplier (*):</td><td><select id="billsupplier" class="formfield">
                      <option value="" selected>--Select Supplier--</option>
                      <?php
                      
                      $q="SELECT * FROM suppliers WHERE estId LIKE '$id'";
                      
                      $datacrnte=$mumin->getdbContent($q);
                      
                      for($k=0;$k<=count($datacrnte)-1;$k++){
                          
                          echo "<option value='".$datacrnte[$k]['supplier']."'>".$datacrnte[$k]['suppName']."</option>";
                      }
                      ?>
                      
                  </select> 
               </td><td>Doc Type:</td> <td><select id="doctype" class="formfield">
                             <option value="0">DEBIT NOTE</option>
                      
                  </select></td></tr>
          <tr><td>Date (*):</td><td><?php
                                 
                                $qrtr="SELECT deptid as estate_id,cdate as date FROM closing_period WHERE deptid = '$id' ORDER BY id DESC LIMIT 1 "; 
                                
                                $datatr=$mumin->getdbContent($qrtr);
                                
                                 for($h=0;$h<=count($datatr)-1;$h++){
                                   $qru=  "SELECT DATEDIFF('".$datatr[$h]['date']."','".date('Y-m-d')."') AS DiffDate";
                                    $datau=$mumin->getdbContent($qru);
                                    for($k=0;$k<=count($datau)-1;$k++){
                                     echo "<input hidden='true' type='text' id='clsingdate'  class='formfield' value='".$datau[$k]['DiffDate']."'>";
                                   //  echo "<option value=".$data[$h]['date'].">".$data[$h]['date']."</option>";
                                   } }
                            
                            ?>
		<input  readonly="true" type="text"  id="billdate" class="formfield" value="<?php echo date('d-m-Y');?>"></input></td>
              <td id="invnotd">Bill No:</td><td><input id="crdtinvno" type="text" class="formfield"  onchange="viewbilcrdt()"></input> </td></tr>            
          <!--<tr><td></td><td><font class="tooltits">&nbsp</font></td></tr>-->
           <tr><td>Debit Note No (*):</td><td><input id="billno" type="text" class="formfield"></input> 
               </td>
           <td rowspan="3" style="display:none" id="taxtd"><input placeholder="Supplier Amount" id="supplamt"></input><br></br>
               <input id="addtax" placeholder="V.A.T Amount" Readonly ></input>&nbsp;&nbsp;&nbsp;<input id="ratetax"  value="0" style="width:30px"placeholder="VAT"></input>%<br></br>
                <input id="affertax" placeholder="After Tax" Readonly style="font-weight: bold"></input></td></tr>
          <!--<tr><td></td><td><font class="tooltits">e.g B1292</font></td></tr> -->
          
           <tr><td>Amount (*):</td><td><input  onkeypress="return isNumberKey(event);"  id="billamount" type="text"   class="formfield"></input> 
               </td><td style="display: none"><button class="btncls" style="border-radius:3px;display: none" id="taxbtn" >Tax</button></td>
                    </tr>
          <!--<tr><td></td><td><font class="tooltits">Amount payable</font></td></tr>-->
          <tr><td>Department (*):</td><td>
                  <select id="costcntreid" class="formfield">
                      <option value="">--Department--</option>
                      <?php 
                      $query="SELECT department2.centrename,department2.id as cntrid FROM department2,costcentrmgnt WHERE costcentrmgnt.costcentrid = department2.id AND costcentrmgnt.deptid = '$id' ";
                      $data17=$mumin->getdbContent($query);
                      
                      for($u=0;$u<=count($data17)-1;$u++){
                          
                          echo "<option value='".$data17[$u]['cntrid']."'>".$data17[$u]['centrename']."</option>";
                      }
                      ?>
                  </select>
                             </td><td></td>
                    </tr>
         
          <!--<tr><td></td><td><font class="tooltits">select supplier</font></td></tr>-->
          <tr><td>Expense Account (*):</td><td><select id="expnacc" class="formfield" disabled>
                      <option value="" selected>--Expense Account--</option>
                     <?php
                      
                      $qry="SELECT expnseaccs.id,expnseaccs.accname FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id  AND expenseactmgnt.deptid = '$id' GROUP BY expnseaccs.id";
                      
                      $data11=$mumin->getdbContent($qry);
                      
                      for($k=0;$k<=count($data11)-1;$k++){
                          
                          echo "<option value='".$data11[$k]['id']."'>".$data11[$k]['accname']."</option>";
                      }
                      ?> 
                      
                      
                  </select> 
               </td><td>Allocation Acc:</td><td><input type="text" class="formfield" id="suplrsubacc"></input></td></tr>
          <!--<tr><td></td><td><font class="tooltits">Choose expense account</font></td></tr>-->
          <tr><td>Remarks:</td><td><textarea  id="billrmks" class="formfield" ></textarea> 
               </td></tr>
          <tr><td></td><td><font class="tooltits">&nbsp</font></td></tr>
          <tr><td></td><td><?php echo $savbill;  ?>&nbsp;&nbsp;<button id="caclbill" class="formbuttons">Cancel</button>  
               </td></tr>
         </table>
         </div>
        <?php
            }
            
            
            
            
            else if($acti=="billslist"){
          ?>
          
          
                    <div style="text-shadow:0 0 3px gold ;font-size: 1.2em;font-weight: bold;">Bills List</div>
            <form  action="" method="post"> 
            
           <table   class="ordinal"> 
                   
                   
                   
               <tr><td>From Date:</td><td><input id="billsstartdate" name="billsstartdate"  value="<?php if(isset($_POST['viewbillslist'])){ echo $_POST['billsstartdate'];}  else { echo date('d-m-Y');} ?>" class="formfield"/></td>
                   <td>Category:</td><td><select id="billscat" class="formfield" name="billscat"><option value="ALL" <?php if(isset($_POST['viewbillslist'])){ if ("ALL" ===$_POST['billscat']) echo ' selected="selected"';} ?>>ALL</option><option value="PAID" <?php if(isset($_POST['viewbillslist'])){if ("PAID" ===$_POST['billscat']) echo ' selected="selected"'; }?>>PAID</option><option value="PENDING" <?php if(isset($_POST['viewbillslist'])){ if ("PENDING" ===$_POST['billscat']) echo ' selected="selected"';} ?>>PENDING</option></select></td></tr>
                   <tr><td>To Date:</td><td><input  id="billsenddate" name="billsenddate" value="<?php if(isset($_POST['viewbillslist'])){echo $_POST['billsenddate'];} else { echo date('d-m-Y');} ?>"   class="formfield"/></td> <td>Expense Account:</td><td><select id="expdpt"  class="formfield" name="expdpt" >
                               
                     <?php
                      
                      $qrs1="SELECT expnseaccs.id,expnseaccs.accname FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id  AND expenseactmgnt.deptid = '$id' GROUP BY expnseaccs.id ORDER BY accname asc";
                      
                      $datas1=$mumin->getdbContent($qrs1);
                      
                      
                      // echo "<option value='ALL' selected='selected'>ALL</option>";
                    echo '<option value="ALL"';
                    echo '>ALL</option>';
                      
                      for($t=0;$t<=count($datas1)-1;$t++){
                           //  echo '<option value="'.$datas1[$k]['id'].'">' .$datas1[$k]['accname'].'</option>'; 
                                 echo '<option value="'.$datas1[$t]['id'].'"';
                               if(isset($_POST['expdpt'])){ if($datas1[$t]['id']== $_POST['expdpt'] ){ echo 'SELECTED';}}
                              echo '>' .$datas1[$t]['accname'].'</option>'; 
                      }
                      ?>                   
                               
                               
                               
                           </select></td></tr><tr><td></td><td><input class="formbuttons" name="viewbillslist" type="submit" id="viewbillslist" value="View list"></input></td><td></td><td></td></tr></table></form>
           <?php
          
            }

          
          
      
            

             
            if(isset($_POST['viewbillslist'])){
                
                
              
                
          $sdate1=trim($_POST['billsstartdate']);
          $sdate = date('Y-m-d', strtotime($sdate1));
          $edate1=trim($_POST['billsenddate']);
          $edate = date('Y-m-d', strtotime($edate1));
          $est_id=$_SESSION['dept_id'];
          
          $category=trim($_POST['billscat']);
            
          $dpt=trim($_POST['expdpt']);
          
        if($dpt!="ALL"){
          
            
            if($category=="PAID"){
                   
                $qr="SELECT estate_id,bdate,supplier,docno,expenseacc,subacc,IF(isinvce='1',amount,-1*amount)as amount,rmks,isinvce,payno,department2.centrename FROM bills LEFT JOIN department2 ON department2.id = bills.costcentrid WHERE bdate BETWEEN '$sdate' AND '$edate' AND estate_id LIKE '$est_id' AND pdamount=amount AND expenseacc LIKE '$dpt' order by bdate,centrename ";
                        
          }
          else if($category=="PENDING"){
                   
              $qr="SELECT estate_id,bdate,supplier,docno,expenseacc,subacc,IF(isinvce='1',amount,-1*amount)as amount,rmks,isinvce,payno,department2.centrename FROM bills LEFT JOIN department2 ON department2.id = bills.costcentrid WHERE bdate BETWEEN '$sdate' AND '$edate' AND estate_id LIKE '$est_id' AND expenseacc LIKE '$dpt' AND pdamount<amount order by bdate,centrename ";
                             
          }
          else{
            
               $qr="SELECT estate_id,bdate,supplier,docno,expenseacc,subacc,IF(isinvce='1',amount,-1*amount)as amount,rmks,isinvce,payno,department2.centrename FROM bills LEFT JOIN department2 ON department2.id = bills.costcentrid WHERE bdate BETWEEN '$sdate' AND '$edate' AND estate_id LIKE '$est_id' AND expenseacc LIKE '$dpt' order by bdate,centrename";
         
          }
          }
          else{
            
              
              if($category=="PAID"){
                
                $qr="SELECT estate_id,bdate,supplier,docno,expenseacc,subacc,IF(isinvce='1',amount,-1*amount)as amount,rmks,isinvce,payno,department2.centrename FROM bills LEFT JOIN department2 ON department2.id = bills.costcentrid WHERE bdate BETWEEN '$sdate' AND '$edate' AND estate_id LIKE '$est_id' AND pdamount=amount order by bdate,centrename";
            
           
          }
          else if($category=="PENDING"){
                  
              $qr="SELECT estate_id,bdate,supplier,docno,expenseacc,subacc,IF(isinvce='1',amount,-1*amount)as amount,rmks,isinvce,payno,department2.centrename FROM bills LEFT JOIN department2 ON department2.id = bills.costcentrid WHERE bdate BETWEEN '$sdate' AND '$edate' AND estate_id LIKE '$est_id' AND pdamount<amount order by bdate,centrename";
               
              
          }
          else{
                  
               $qr="SELECT estate_id,bdate,supplier,docno,expenseacc,subacc,IF(isinvce='1',amount,-1*amount)as amount,rmks,isinvce,payno,department2.centrename FROM bills LEFT JOIN department2 ON department2.id = bills.costcentrid WHERE bdate BETWEEN '$sdate' AND '$edate' AND estate_id LIKE '$est_id' order by bdate,centrename";
                    }
              
              
          }
           
          $datainvlst=$mumin->getdbContent($qr);
          
          $numbering=1;
          
          $sum=0;
           
          echo"<table class='table table-bordered' id='sortablebills'>";
           
          echo"<thead><tr><th>SN</th><th>Date</th><th>Doc.No</th><th>Supplier</th><th>Expense Acc</th><th>Cost Centre</th><th>Remarks</th><th style='text-align:right'>Amount</th></tr></thead><tbody>";    
          
          for($i=0;$i<=count($datainvlst)-1;$i++){
              
              
                 
                  $subid=$datainvlst[$i]['supplier'];
                  
                  $supplier=$mumin->getdbContent("SELECT suppName FROM suppliers WHERE supplier = '$subid' AND estId LIKE '$est_id' LIMIT 1");
                  
                  
                  
                  $payer=$supplier[0]['suppName'];
                  
           
              
              $accid=$datainvlst[$i]['expenseacc'];
              $subacctid=$datainvlst[$i]['subacc'];
              
              $deptq=$mumin->getdbContent("SELECT accname FROM expnseaccs WHERE id  LIKE  '$accid' LIMIT 1");
              
              $dept=$deptq[0]['accname'];
              $subactnm = $mumin->getdbContent("SELECT accname FROM subexpnseaccs WHERE id = '$subacctid'");
              @$subactname = $subactnm[0]['accname'];
              $date= date('d-m-Y',  strtotime($datainvlst[$i]['bdate']));
              
              echo"<tr><td>".$numbering."</td><td>".$date."</td><td>".$datainvlst[$i]['docno']."</td><td>".$payer ."</td><td>".$dept."</td><td>".$datainvlst[$i]['centrename']."</td><td style='text-transform:uppercase'>".$datainvlst[$i]['rmks']."</td><td style='text-align:right'>".  number_format($datainvlst[$i]['amount'],2)."</td></tr>";
              
              $numbering+=1;
              
              $sum+=floatval($datainvlst[$i]['amount']);
          }
          
            echo"<tr><td></td><td><td></td></td><td></td><td></td><td></td><td>TOTALS</td><td style='text-align:right'>". number_format($sum,2)."</td></tr>";    
           
            echo"</tbody></table>";  
           
           echo"<button style='margin:10px 0px 2px 10px' id='billslist1'>print</button>";       
                
            }
     
            ?>
                 
    
                 
    <div id="succes" style="display: none">
        
    </div>
    <div id="inv_success" style="display: none" title="Transaction complete">
        
        <p>Invoice was generated successfully at <?php echo date('d-m-Y h:i:s') ;?></p>
        <p>  <button id="cancl1">OK</button></p>
    </div>
        
       
      <div id="readydebtr" style="display: none" title="Mumin Error">
        <p></p>
        <p></p>
        <p></p>
        <p> Already a Debtor. <br></br>Select him/her?</p>
        <p></p>
        <p></p>
        <p> <button id="slctdebtor">OK</button> <button id="cancelready">CANCEL</button>  </p>
    </div>

                         <div id="changeedit" style="display:none " title="Change /Edit supplier Info">
         
             
          <table class="ordinal">   
              
              <tr><td></td><td><input  type="text" hidden  class="formfield" readonly="readonly" id="cgid"/> </td></tr>
               <tr><td>Names:</td><td><input  type="text"  class="formfield"   id="cgname"/> </td></tr> 
            <tr><td>Telephone:</td><td><input  type="text"  class="formfield"    id="cgtel"/> </td></tr>
             <tr><td>Email:</td><td><input  type="text"  class="formfield"   id="cgemail"/> </td></tr>
              <tr><td>Postal Addr:</td><td><input  type="text"  class="formfield"   id="cgpostal"/> </td></tr>
           <tr><td>City:</td><td><input  type="text"  class="formfield"    id="cgcity"/> </td></tr>
              <tr><td></td><td> <button id="suppsaver" class="formbuttons">Save Changes</button>   
               </td></tr>
         </table>
      </div>
                    
	    <div id="changeeditbill" style="display:none " title="Change /Edit Bill Info">
         
             
          <table class="ordinal">   
              
              <tr><td></td><td><input  type="hidden"  class="formfield" readonly="readonly" id="cgid"/> </td></tr>
               <tr><td>Bill No:</td><td><input  type="text"  class="formfield"   id="billnum"/> </td></tr> 
            <tr><td>Date:</td><td><input  type="text"  class="formfield"    id="billdate"/> </td></tr>
             <tr><td>Supplier:</td><td><select id="billsupplier" class="formfield">
                      <option value="" selected>--Select Supplier--</option>
                      <?php
                      
                      $q="SELECT * FROM suppliers WHERE estId LIKE '$id' order by suppName asc";
                      
                      $data=$mumin->getdbContent($q);
                      
                      for($k=0;$k<=count($data)-1;$k++){
                          
                          echo "<option value='".$data[$k]['supplier']."'>".$data[$k]['suppName']."</option>";
                      }
                      ?>
                      
                  </select> 
               </td></tr>
              <tr><td>Remarks:</td><td><input  type="text"  class="formfield"   id="bilrmks"/> </td></tr>
           <tr><td>Expense Acct:</td><td><select id="expnacc" class="formfield">
                      <option value="" selected>--Expense Account--</option>
                     <?php
                      
                      $qry="SELECT expnseaccs.id,expnseaccs.accname FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id  AND expenseactmgnt.deptid = '$id' GROUP BY expnseaccs.id ORDER BY accname asc";
                      
                      $data11=$mumin->getdbContent($qry);
                      
                      for($k=0;$k<=count($data11)-1;$k++){
                          
                          echo "<option value='".$data11[$k]['id']."'>".$data11[$k]['accname']."</option>";
                      }
                      ?> 
                      
                      
                  </select> 
              </td></tr>
              <tr><td></td><td> <button id="saveditedbill" class="formbuttons">Save Changes</button>   
               </td></tr>
         </table>
      </div>
               	    <div id="changepdeditbill" style="display:none " title="Change /Edit Bill Info">
          <table class="ordinal">   
              
              <tr><td></td><td><input  type="hidden"  class="formfield" readonly="readonly" id="cgid"/> </td></tr>
               <tr><td>Bill No:</td><td><input  type="text"  class="formfield"   id="billnum"/> </td></tr> 
            <tr><td>Date:</td><td><input  type="text"  class="formfield"    id="billdate"/> </td></tr>
            <tr><td>Supplier:</td><td><select id="billsupplier" class="formfield" disabled="true">
                      <option value="" selected>--Select Supplier--</option>
                      <?php
                      
                      $q="SELECT * FROM suppliers WHERE estId LIKE '$id' order by suppName asc";
                      
                      $data=$mumin->getdbContent($q);
                      
                      for($k=0;$k<=count($data)-1;$k++){
                          
                          echo "<option value='".$data[$k]['supplier']."'>".$data[$k]['suppName']."</option>";
                      }
                      ?>
                      
                  </select> 
               </td></tr>
              <tr><td>Remarks:</td><td><input  type="text"  class="formfield"   id="bilrmks"/> </td></tr>
              <tr><td>Expense Acct:</td><td><select id="expnacc" class="formfield" disabled="true">
                      <option value="" selected>--Expense Account--</option>
                     <?php
                      
                      $qry="SELECT expnseaccs.id,expnseaccs.accname FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id  AND expenseactmgnt.deptid = '$id' GROUP BY expnseaccs.id ORDER BY accname asc";
                      
                      $data11=$mumin->getdbContent($qry);
                      
                      for($k=0;$k<=count($data11)-1;$k++){
                          
                          echo "<option value='".$data11[$k]['id']."'>".$data11[$k]['accname']."</option>";
                      }
                      ?> 
                      
                      
                  </select> 
              </td></tr>
              <tr><td></td><td> <button id="saveditedbill" class="formbuttons">Save Changes</button>   
               </td></tr>
         </table>
      </div>     

   <div id="d_progress" style="display: none;background: transparent;border: none;text-align: center;vertical-align:middle; line-height: 50px;padding-top: 10px">
     <img align="center" src="../assets/images/icon_animated_prog_dkgy_42wx42h.gif"></img>
 </div> 
    
    

            </div>
        </div>
        
      </div> 
    
    </div>
    <!--Right Panel Ends Here-->
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

                      }?>