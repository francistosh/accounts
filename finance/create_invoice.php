  <?php
session_start();  
 
if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  //Assign Sessions
    $level=$_SESSION['jmsacc'];
    
    $id=$_SESSION['dept_id'];

    $userid = $_SESSION['acctusrid'];
    if($level>999){
  
        header("location: ../index.php"); 
        
    }
    else{
   
include 'operations/Mumin.php';

$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE userid = '$userid' AND deptid = '$id' LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);
//Check availability of invoicing option on the user
if($priviledges[0]['invoices']!=1){
   
header("location: index.php");
}
//If readonly dont display any posting buttons
if($priviledges[0]['readonly']==1){
    $displ =  '';
    $crdtnote = '';
    $individualprofessionalsabil = '';
    $individualhousesabil = '';
    $batchpinvoice = '';
    $batchsablinvoice = '';
    $batchinvoicegen1 = '';
}else if($priviledges[0]['readonly']!=1){
    $displ = '<button id="gnrt" ><b>Generate Invoice</b></button>';
    $crdtnote = '<button id="creditnotegnrt"><b>Generate Credit Note</b></button>';
    $individualprofessionalsabil = '<input type="submit" name="individualpinvoice" class="formbuttons" value="Professional" id="individualpinvoice">';
    $individualhousesabil = '<input type="submit" name="individualsablinvoice" class="formbuttons" value="House" id="individualsablinvoice" style="display: none"></input>';
    $batchpinvoice = '<input type="submit" name="batchpinvoice" class="formbuttons" value="Professional" id="batchpinvoice"></input>';
    $batchsablinvoice = '<input type="submit" name="batchsablinvoice" class="formbuttons" value="House" id="batchsablinvoice" style="display: none"></input>';
    $batchinvoicegen1 = '<input type="submit" name="batchinvoicegen1" class="formbuttons" value="Generate" id="batchinvoicegen1"></input>';
}
}

date_default_timezone_set('Africa/Nairobi');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jims2 | Invoicing </title>

<?php include '../partials/stylesLinks.php';   include 'links.php';
	
 ?>
<!-- For JS FUNCTIONS refer to invoice.js in the JS FOLDER -->
 <script>
    $(function() {
     
       var subAcc=[];
                $.getJSON("../finance/redirect.php?action=autosubaccts", function(data) {
   
    $.each(data, function(i,item) {
       
    subAcc.push(item.subacc);
    
    $("#subacct").autocomplete({
        source: subAcc,
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
     
     var clsingdate = $("#clsingdate").val(); 
      // DataTable configuration
  $('#sortableinvoice').dataTable({
	"bSort":false,
	// "sPaginationType": "full_numbers",
	"iDisplayLength": 25,
	"aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
	"bJQueryUI": true
  } );
  
     // DataTable configuration
  $('#sortablebills').dataTable( {
	"bSort": false,
	// "sPaginationType": "full_numbers",
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
     
       $('#editsupp').dataTable( {
	"bSort": false,
	// "sPaginationType": "full_numbers",
	"iDisplayLength": 25,
	"aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
	"bJQueryUI": true
  } );
     
     
 $("#invcedate" ).datepicker({ dateFormat: 'yy-mm-dd',changeMonth: true,
	minDate: parseInt(clsingdate)+parseInt(1)} );    
$("#oc" ).datepicker({ dateFormat: 'yy-mm-dd'} );

$("#creditdate" ).datepicker({ dateFormat: 'dd-mm-yy',
   minDate: parseInt(clsingdate)+parseInt(1)} );
     
 $("#crdtstartdate" ).datepicker({ dateFormat: 'dd-mm-yy' , changeMonth: true} );    
   
 $("#dateinvcenoid" ).datepicker({ dateFormat: 'dd-mm-yy' , changeMonth: true} ); 
 $("#crdtenddate" ).datepicker({ dateFormat: 'dd-mm-yy', changeMonth: true} );  
$( "#invoicestartdate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#invoiceenddate" ).datepicker( "option", "minDate", selectedDate );
}
});
$( "#invoiceenddate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#invoicestartdate" ).datepicker( "option", "maxDate", selectedDate );
}
}); 

     
$( "#billsstartdate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 2,
dateFormat: 'yy-mm-dd',  
onClose: function( selectedDate ) {
$( "#billsenddate" ).datepicker( "option", "minDate", selectedDate );
}
});

$( "#billsenddate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,  
numberOfMonths: 2,
dateFormat: 'yy-mm-dd',   
onClose: function( selectedDate ) {
$( "#billsstartdate" ).datepicker( "option", "maxDate", selectedDate );
}
}); 

     $("#batchpinvoice").click(function(){
         $("#d_progress").show(); basicLargeDialog("#d_progress",50,150);
         $(".ui-dialog-titlebar").hide();
     });
     $("#individualpinvoice").click(function(){
         $("#d_progress").show(); basicLargeDialog("#d_progress",50,150);
         $(".ui-dialog-titlebar").hide();
     });
     
      $("#batchsablinvoice").click(function(){
         $("#d_progress").show(); basicLargeDialog("#d_progress",50,150);
         $(".ui-dialog-titlebar").hide();
     });
     $("#individualsablinvoice").click(function(){
         $("#d_progress").show(); basicLargeDialog("#d_progress",50,150);
         $(".ui-dialog-titlebar").hide();
     });
     
   $("#batchinvoicegen1").click(function(){
         $("#d_progress").show(); basicLargeDialog("#d_progress",50,150);
         $(".ui-dialog-titlebar").hide();
     });
    
       $("#updateinv").click(function(){
         $("#d_progress").show(); basicLargeDialog("#d_progress",50,150);
         $(".ui-dialog-titlebar").hide();
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
                $("#viewcrdtlist").button({
            icons: {
                primary: "ui-icon-document"
                 
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
 
   
  $("#billdate" ).datepicker({ dateFormat: 'dd-mm-yy'} );
  
   $("#invsdate" ).datepicker({ dateFormat: 'dd-mm-yy'} );
      
   
    $("#invdt" ).datepicker({ dateFormat: 'dd-mm-yy',
   	minDate: parseInt(clsingdate)+parseInt(1)
	} );
    
    $("#balancedt" ).datepicker({ dateFormat: 'dd-mm-yy'} );


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
  	 <div id="div_logindetails" ><div>You are logged in as: <?php echo $_SESSION['jname'];?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp</div>
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
        	<h3 class="titletext">Invoices / Credit Notes</h3>
                <div id="gallerydisp" style="display: block;float: right"><button class="btncls" >Mumin Search</button></div>
        </div>
        <div id="div_formcontainer">
        	<div id="tabs2">

          <?php
         
         $acti=$_GET['idaction'];
         
         if($acti=="new"){
             
          ?>
           
          <fieldset style="border: 1px gold solid"><legend style="color: #333;font-weight: bold;font-style: italic">New Invoice</legend>
                    
          <table id="" class="ordinal">    
                
           <tr> 
                    
                    
                    <td style="border: none">To:</td>
                     
                     <td style="border: none">
                     <input type="radio" name="add" value="sabil" id="muminchk" checked="true" ><b>&nbsp&nbspMumin</b></input>
                     <input type="radio" name="add" value="debtor" id="debtor" ><b>&nbsp&nbspDebtor &nbsp&nbsp</b></input></td></tr>

                                     
              <tr style="border: none"><td style="border: none"> </td><td style="border: none" colspan="2">
                      <br><input id="invsabil" type="text"   class="formfield" style="display: block;text-transform: uppercase" placeholder="sabil No"/>
                                &nbsp; <input id="ejnoinv" type="text"   class="formfield" style="display: block;text-transform: uppercase" placeholder="ITS No"></input>    
                              <div id="ppp" style="display: none">
                                  <input  type="hidden"  class="formfield" readonly="readonly" id="debtorid"/>
                                  <input type="text" id="invdebtor"  class="formfield" placeholder="Debtor Name"></input>
                                  
                                  
                                </div>
                  </td><td></td></tr>
              <tr><td id="namefld" >Name:&nbsp;</td><td><input readonly="true" type="text" id="sabilname"  class="formfield" style="display:block"></input></td><td><input hidden="true" type="text" id="sectornme"  class="formfield"></input></td></tr>   
                              
                   <tr> <td style="border: none">Income Acc: </td>
                    <td style="border: none"><select  class="formfield" id="estacc"><option value="">-select--</option> 
                                <?php
                                          
                                $qrinvce="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id' GROUP BY incomeaccounts.incacc ORDER BY accname asc"; 
                                
                                $datainvce=$mumin->getdbContent($qrinvce);
                                
                                 for($l=0;$l<=count($datainvce)-1;$l++){
                      
                                     echo "<option value=".$datainvce[$l]['incacc'].">".$datainvce[$l]['accname']."</option>";
                                   } 
                            
                            ?>
                        </select></td><td><img id="loader" style="visibility: hidden" src="../assets/images/ajax-loader.gif"></img></td>
                    
                      </tr>
                    
                              <!--<tr><td style="border: none"> Sub-Acc:</td><td style="border: none"> <select id="estaccdetails"  class="formfield" style="display: block"></select> </td><td></td></tr> -->
                  <!--<tr><td></td><td> <font class="tooltits">If sabil ,Enter sabil no and press ENTER KEY , then Fill out the form below</font></td><td></td> </tr> -->
                  <tr><td>Sub Acc:</td><td><select class="formfield" id="subacct"></select></td></tr>
    
                  <tr><td>Date:&nbsp;</td><td><?php
                                 
                                $qrtrinv="SELECT deptid as estate_id,cdate as date FROM closing_period WHERE deptid = '$id' AND allow = '0' ORDER BY id DESC LIMIT 1 "; 
                                
                                $datadate=$mumin->getdbContent($qrtrinv);
                                    if(count($datadate)==0){
                                        echo "<input hidden='true' type='text' id='clsingdate'  class='formfield' value='-1'>";
                                    }else{
                                 for($p=0;$p<=count($datadate)-1;$p++){
                                   $qrudate=  "SELECT DATEDIFF('".$datadate[$p]['date']."','".date('Y-m-d')."') AS DiffDate";
                                    $dataudate=$mumin->getdbContent($qrudate);
                                    for($y=0;$y<=count($dataudate)-1;$y++){
                                       // if($datau[$k]['DiffDate']){}
                                     echo "<input hidden='true' type='text' id='clsingdate'  class='formfield' value='".$dataudate[$y]['DiffDate']."'>";
                                   //  echo "<option value=".$data[$h]['date'].">".$data[$h]['date']."</option>";
                                    } }}
                            ?>
		<input type="text" id="invdt" readonly="true" class="formfield" value="<?php echo date('d-m-Y');?>"></input></td><td></td></tr>   
                       
                                    <tr><td>Amount:&nbsp;</td><td><input value="0"    type="text" id="invamount100"  class="amount"></input></td><td></td></tr>   
                      
                  <tr><td>Brief Remarks </td><td><textarea id="invrmks100"  class="formfield"></textarea></td><td></td></tr> 
                  <tr><td></td><td><?php echo $displ;?></td><td></td></tr>   
                </table>  
                    </fieldset>
         <?php
         }
         else if($acti==""){
             
         }
         else if($acti=="creditnote"){
          ?>
   
                    
                    <fieldset style="border: 1px gold solid"><legend style="color: #333;font-weight: bold;font-style: italic">Customer Credit Note</legend>         
                            <div id="gallerydisp" style="display: none;float: right"><button class="btncls">Mumin Search</button></div>
                        <table id="" class="ordinal">   
              
              <tr> 
                    
                    
                    <td style="border: none">To:</td>
                     
                     <td style="border: none">
                         <input type="radio" name="add" value="sabil" id="muminchk" checked="true"><b>&nbsp&nbspMumin</b></input>
                     <input type="radio" name="add" value="debtor" id="debtor"  ><b>&nbsp&nbspDebtor &nbsp&nbsp</b></input></td></tr>
                     
                                   <tr style="border: none"><td style="border: none"> </td><td style="border: none" colspan="2">
                      <br><input id="invsabil" type="text"   class="formfield" style="text-transform: uppercase;display: block; " placeholder="sabil No"/>
                                &nbsp; <input id="ejnoinv" type="text"   class="formfield" style="display: block;text-transform: uppercase" placeholder="Ejamaat No"></input>    
                              <span id="ppp" style="display: none;">
                                  <input  type="hidden"  class="formfield" readonly="readonly" id="debtorid"/>
                                  <input type="text" id="invdebtor"  class="formfield" placeholder="Debtor Name">
                                  </input>

                                </span>
                  </td><td></td></tr>
                            <tr ><td>Invoice No:</td><td><input type="text" id="crdtinvce"  onchange="viewamount()" class="formfield" placeholder="Invoice No"></input></td></tr>
                                     <tr> <td style="border: none">Income Acc:</td>
                    <td style="border: none"><select  class="formfield" id="estacc" disabled><option>-select--</option> 
                                <?php
                                $qr="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id'"; 
                                
                                $data=$mumin->getdbContent($qr);
                                
                                 for($h=0;$h<=count($data)-1;$h++){
                      
                                     echo "<option value=".$data[$h]['incacc'].">".$data[$h]['accname']."</option>";
                                   } 
                            
                            ?>
                        </select> </td><td></td><td><img id="loader" style="visibility: hidden" src="../assets/images/ajax-loader.gif"></img></td>
                    
                      </tr>
               <tr><td>Date:&nbsp;</td><td><?php
                                 
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
                            
                            ?>
		<input type="text" id="creditdate" readonly="true" class="formfield" value="<?php echo date('d-m-Y'); ?>"></input></td></tr>
				
               <tr><td id="tdname4" >Name:&nbsp;</td><td><input readonly="true" type="text" id="sabilname"  class="formfield" style="display: block;"></input></td><td><input hidden="true" type="text" id="sectornme"  class="formfield"></input></td></tr>
                        <tr><td>Amount:&nbsp;</td><td><input value="0.00"   onkeypress="return isNumberKey(event);" type="text" id="creditamount"  class="formfield"></input></td><td></td></tr>   
                      
                  <tr><td>Brief Remarks </td><td><textarea id="creditremarks"     class="formfield"></textarea></td><td></td></tr> 
                  <tr><td></td><td style="<?php echo $displ;?>"><button id="creditgnrt">complete</button></td><td></td></tr>   
                </table>  
         
                    </fieldset>
         
                    
      
          <?php
          }
                   else if($acti=="multicreditnote"){
          ?>
   
                    
                    <fieldset style="border: 1px gold solid"><legend style="color: #333;font-weight: bold;font-style: italic">Customer Credit Note</legend>         
                            <div id="gallerydisp" style="display: none;float: right"><button class="btncls">Mumin Search</button></div>
                        <table id="" class="ordinal">   
              
              <tr> 
                    
                    
                    <td style="border: none">To:</td>
                     
                     <td style="border: none">
                         <input type="radio" name="add" value="sabil" id="muminchk" checked="true"><b>&nbsp&nbspMumin</b></input>
                     <input type="radio" name="add" value="debtor" id="debtor"  ><b>&nbsp&nbspDebtor &nbsp&nbsp</b></input></td></tr>
                     
                                   <tr style="border: none"><td style="border: none"> </td><td style="border: none" colspan="3">
                      <br><input id="crdtsabil" type="text"   class="formfield" style="text-transform: uppercase;display: block; " placeholder="sabil No"/>
                                &nbsp; <input id="ejnoinv" type="text"   class="formfield" style="display: block;text-transform: uppercase" placeholder="Ejamaat No"></input>    
                              <!--<input readonly="true" type="text" id="sabilname"  class="formfield" style="display: block;"></input>-->
                                <span id="ppp" style="display: none;">
                                  <input  type="hidden"  class="formfield" readonly="readonly" id="debtorid"/>
                                  <input type="text" id="invdebtor"  class="formfield" placeholder="Debtor Name">
                                  </input>

                                </span>
                                
                  </td></tr>
                            
                                     <tr> <td style="border: none">Income Acc:</td>
                                         <td style="border: none"><select  class="formfield" id="crestacc"><option value="">-select--</option> 
                                <?php
                                $qr="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id'"; 
                                
                                $data=$mumin->getdbContent($qr);
                                
                                 for($h=0;$h<=count($data)-1;$h++){
                      
                                     echo "<option value=".$data[$h]['incacc'].">".$data[$h]['accname']."</option>";
                                   } 
                            
                            ?>
                        </select> </td><td></td><td><img id="loader" style="visibility: hidden" src="../assets/images/ajax-loader.gif"></img></td>
                    
                      </tr>
                            <tr><td>Amount:&nbsp;</td><td><input value="0.00"   onkeypress="return isNumberKey(event);" type="text" id="crdtamount"  class="formfield"></input></td><td></td></tr>   

               <tr><td>Date:&nbsp;</td><td><?php
                                 
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
                            
                            ?>
		<input type="text" id="creditdate" readonly="true" class="formfield" value="<?php echo date('d-m-Y'); ?>"></input></td></tr>
				
             <!--  <tr><td id="tdname4" >Name:&nbsp;</td><td></td><td><input hidden="true" type="text" id="sectornme"  class="formfield"></input></td></tr>
          <!-- <tr> 
                    
                    
                    <td style="border: none">Reference Invoice No:</td>
                     
                     <td style="border: none">
                             <input type="text" id="creditinvoice" class="formfield"></input></td><td></td></tr>-->
                                         
                 <!--  <tr><td></td><td> <font class="tooltits">The extra amount overcharged</font></td><td></td> </tr>    -->  
                      
                  <tr><td>Brief Remarks </td><td><textarea id="creditremarks"     class="formfield"></textarea></td><td></td></tr> 
                  <tr><td></td><td><?php echo $crdtnote; ?></td><td></td></tr>   
                </table>  
         <table id="disp_invoices" class="ordinal" style="width: 100%"></table> 
                    </fieldset>
         
                        <div id="overpayment_rqst" style="display: none" title="Data Entry Request">
        <p></p>
        <p></p>
        <p></p>
        <p> <br> Are you sure you want to make an Overpayment? <br></br> </p>
        <p> <br></br></p>
        <p></p>
        <p> <button id="mkeoverpayment">Yes</button> &nbsp;&nbsp;&nbsp; <button id="cancelovrpaymnt">No</button>  </p>
    </div> 
      
          <?php
          }
           else if($acti=="edit"){
           echo "<div id='suppliersFilterBar'><button id='supprint'  style='float: left'>Print</button></div>";
     
           $qer="SELECT * FROM debtors WHERE deptid LIKE '$id' ORDER BY sabilno,debtorname"; 
      
       $data=$mumin->getdbContent($qer);
    
        
      
      echo "<table id='editsupp' class='invview'>"; 
      echo '<thead>';
       echo "<tr><th hidden='true'></th><th>SN</th><th>Names</th><th style='font-size:10px'>Telephone</th><th style='font-size:10px'>Email</th><th style='font-size:10px'>Postal Addr</th><th style='font-size:10px'>City</th><th style='font-size:10px'></th>";
      echo '</thead>';
      echo '<tbody>';
      $t=1;
      for($j=0;$j<=count($data)-1;$j++){    
               if($data[$j]['sabilno'] ==''){
                   $snum = $t++;
               }else{
                   $snum = $data[$j]['sabilno'];
               }
               
     echo "<tr><td  id='cgl".$j."' hidden='true'>".$data[$j]['dno']."</td><td>".$snum."</td><td id='cnl".$j."'>".$data[$j]['debtorname']."</td><td id='ctl".$j."'>".$data[$j]['debTelephone']."</td><td id='cml".$j."' >".$data[$j]['email']."</td><td id='cpl".$j."'>".$data[$j]['postal']."</td><td id='ccl".$j."'>".$data[$j]['city']."</td><td><input type='text' id='hseno".$j."' style='display:none' value='".$data[$j]['hseno']."'></input><a id='k".$j."' class='changedebtoraction' href='#'>Edit</a>&nbsp;|</td></tr>";
           // <a id='v".$j."' class='changedelete5' href='#'>Delete</a>
             }
      echo '</tbody>';
      echo "</table>";
         
           
            
           }
          
          else if($acti=="opam"){
           ?>   
           
                    <table id="" class="ordinal">    
                
           <tr> 
                    
                    
                    <td style="border: none">Select :</td>
                     
                   <td style="border: none"><select  class="formfield"  id="balanceType"> 
                   <option >--Select Type--</option><option value="supplier">Supplier</option><option value="debtor">Debtor</option><option value="sabil">Mumineen</option>
                   </select></td><td></td></tr>
                   <tr> <td style="border: none">Select :</td>
                    <td style="border: none">
                        
                        <select  class="formfield" id="estplaceholder"><option>-select--</option> 
                               
                        </select>
                        
                        
                        <select  class="formfield" style="display: none" id="estsuppliers1"><option value="0">-select--</option> 
                                <?php
                               $qr="SELECT supplier,suppName FROM suppliers WHERE estId LIKE '$id'"; 
                                
                                $supp=$mumin->getdbContent($qr);
                                
                                 for($h=0;$h<=count($supp)-1;$h++){
                      
                                     echo "<option value=".$supp[$h]['supplier'].">".$supp[$h]['suppName']."</option>";
                                   } 
                            
                            ?>
                        </select>
                        
                        <select  class="formfield" style="display: none" id="estdebtors1"><option value="0">-select--</option> 
                                <?php
                                $qr="SELECT dno,debtorname FROM debtors WHERE deptid LIKE '$id'"; 
                                
                                $deb=$mumin->getdbContent($qr);
                                
                                 for($h=0;$h<=count($deb)-1;$h++){
                      
                                     echo "<option value=".$deb[$h]['id'].">".$deb[$h]['debtorname']."</option>";
                                   } 
                            
                            ?>
                        </select>
                        
                        <select  style="display: none" class="formfield" id="estmumin1"><option value="0">-select--</option> 
                                <?php
                                $moh1=$_SESSION['mohalla'] ;        
                                
                                $qr="SELECT DISTINCT sabilno FROM mumin WHERE moh LIKE '$moh1' ORDER BY sabilno ASC"; 
                                
                                $s=$mumin->getdbContent($qr);    
                                
                                 for($h=0;$h<=count($s)-1;$h++){
                      
                                     echo "<option value=".$s[$h]['sabilno'].">".$s[$h]['sabilno']."</option>";
                                   } 
                            
                            ?>
                        </select>
                    
                    
                    
                    </td><td></td><td><img id="loader11" style="visibility: hidden" src="../assets/images/ajax-loader.gif"></img></td>
                    
                      </tr>
                    
                   
                      
                  <tr><td>Date:&nbsp;</td><td><input type="text" id="balancedt"  class="formfield"></input></td><td></td></tr>   
                        
                        
                  <tr><td>Amount:&nbsp;</td><td><input value="0.00"   onkeypress="return isNumberKey(event);" type="text" id="balanceamount"  class="formfield"></input></td><td></td></tr>   
                        
                  <tr><td>Brief Remarks </td><td><textarea id="balanceremarks"  readonly="readonly"   class="formfield">OPENING BALANCE</textarea></td><td></td></tr> 
                  <tr><td></td><td><button id="gnrtbalance">complete</button></td><td></td></tr>   
                </table>  
         
                    
         <?php
          }
          else if($acti=="print"){
            
          
          ?>
                    <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">Print Invoice</legend>
           <form method="post" action="#">
            <table id="" class="ordinal">  
                
                <tr> 
                    
                    
                    <td style="border: none">Invoice Number:</td>
                     
                    <td style="border: none"><input type="text" value="<?php if(isset($_POST['invsubmit']))   {  echo $_POST['invnos']; }?>" id="invnos" name="invnos" class="formfield"> </input></td>
                    
                    
                    <td style="border: none"><input type="submit" class="formbuttons" value="Submit" name="invsubmit" ></input></td><!-- Submit on same File-->
                    <td style="border: none"> </td><td></td>

                </tr>
                 
        </table> 
        </form> 
                        </fieldset>
              
              
              
         
          <?php
          }
           else if($acti=="modify"){      
          ?> 
 <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">Invoice Modification</legend>
            <form method="post" action="">
        <table class="ordinal">  
            <tr><td>Invoice No :</td><td><input name="mdfyinvno"  class="formfield" id="mdfyinvno" value='<?php if(!isset($_POST['invsearch'])){ echo ""; }else{ echo $_POST['invsearch'];}?>'></input></td><td><button name="invsearch" id="invsearch"> Search</button></td></tr>
        </table>
            </form>
                <div id="invmod" style="display:none">
                    <form method="post" action="">
                    <table class="borders">
                        <tr><td> <input name="invcenomodfy"  class="formfield" id="invcenomodfy" type="hidden"></input><b>Invoice No:</b></td><td id="invcenoid" style="text-align: left;padding-left: 15px"></td><td><b>Date:</b></td><td  style="width: 250px"><input id="dateinvcenoid" class="formfield" name="dateinvcenoid"></input></td></tr>
                        <tr><td><b>Sabilno:</b></td><td ><input id="sabinvcenoid" class="formfield" name="sabinvcenoid"></input></td><td><b>Name:</b><input name="invceits" id="invceits" type="hidden"></input></td><td id="nameinvcenoid" style="width: 300px"></td></tr>
                        <tr><td><b>Account 
                                <select  hidden="true" class="formfield" id="origincmeacct" name="origincmeacct"><option>-select--</option> 
                                <?php
                                $qrty="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id'"; 
                                                                
                                $dataty=$mumin->getdbContent($qrty);
                                
                                 for($h=0;$h<=count($dataty)-1;$h++){
                      
                                     echo "<option value=".$dataty[$h]['incacc'].">".$dataty[$h]['accname']."</option>";
                                   } 
                            
                            ?>
                        </select>
                                </b></td><td >
                                <select  class="formfield" id="incmeinvcenoid" name="incmeinvcenoid"><option>-select--</option> 
                                <?php
                                $qr="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id'"; 
                                                                
                                $data=$mumin->getdbContent($qr);
                                
                                 for($h=0;$h<=count($data)-1;$h++){
                      
                                     echo "<option value=".$data[$h]['incacc'].">".$data[$h]['accname']."</option>";
                                   } 
                            
                            ?>
                        </select>
                            </td></tr>
                        <tr><td><b>Amount:</b></td><td><input id="amntinvcenoid" class="amount" name="amntinvcenoid"></input></td><td><b>Paid Amount:</b></td>
                            <td><input id="amntpaidid" class="amount" name="amntpaidid" readonly='true'></input></td></tr>
                        <tr><td><b>Remarks</b></td><td colspan="2" style="height: 50px"><textarea style="width: 100%; height: 80%; border: none; background-color: #83a94c" id="rmksrecptid" name="rmksrecptid">
    </textarea></td><td><input type="submit"  value="Update" name="updateinv" class="formbuttons" id="updateinv"></input></td></tr>
                    </table></form>
                </div> 
            </fieldset> 
                    
               <?php
           }
                     elseif ($acti=="overpayment") {
              ?>
                    <fieldset style="border: 1px gold solid"><legend style="color: #333;font-weight: bold;font-style: italic">Over Payment</legend>
              <form method="post" action="#">
            <table id="" class="ordinal">  
                               <tr> 
                    
                    
                    <td style="border: none">Sabil No:</td>
                     
                    <td style="border: none"><input type="text" id="ovrpymntsabilno" name="ovrpymntsabilno" class="formfield" value='<?php if(isset($_POST['ovrpymntincacc'])){ echo $_POST['ovrpymntsabilno']; }?>'> </input></td>
                    <td style="border: none">
                        <select class="formfield" id="ovrpymntincacc" onchange="this.form.submit()" name="ovrpymntincacc">
                          <option selected value = ''>--Account--</option>
                                                      <?php
                                $qr5="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id' ORDER BY accname "; 
    
                                $data5=$mumin->getdbContent($qr5);
                                                            
                                 for($h=0;$h<=count($data5)-1;$h++){
                      
                                     echo "<option value=".$data5[$h]['incacc'].">".$data5[$h]['accname']."</option>";
                                     
                                   } 
                            
                            ?>
                      </select></td> 
                    
                    <td style="border: none"> <input type="text" id="incmeid" name="incmeid" class="formfield" hidden="true" value='<?php if(isset($_POST['ovrpymntincacc']))   {  echo $_POST['ovrpymntincacc']; }?>'> </input></td><td></td>

                </tr>
                 
        </table> 
        </form> 
                        </fieldset>
              <?php
          }
          elseif ($acti=="crprnt") {
              ?>
                    <fieldset style="border: 1px gold solid"><legend style="color: #333;font-weight: bold;font-style: italic">Print Credit Note</legend>
              <form method="post" action="#">
            <table id="" class="ordinal">  
                               <tr> 
                    
                    
                    <td style="border: none">Credit Note No:</td>
                     
                    <td style="border: none"><input type="text" value="<?php if(isset($_POST['crdtsubmit']))   {  echo $_POST['crdtnos']; }?>" id="crdtnos" name="crdtnos" class="formfield"> </input></td>
                    
                    
                    <td style="border: none"><input type="submit" class="formbuttons" value="Search" name="crdtsubmit" ></input></td>
                    <td style="border: none"> </td><td></td>

                </tr>
                 
        </table> 
        </form> 
                        </fieldset>
              <?php
          }
          else if($acti=="invoicelist"){
          ?>
          
                    <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">Invoice List</legend>
         
           <table   class="ordinal"> 
                   
                                 
                   <tr><td>From Date :</td><td><input id="invoicestartdate" name="invoicestartdate"   class="formfield" value="<?php echo date('d-m-Y')?>"/></td><td>Category :</td><td><select id="invoicecat" class="formfield" name="invoicecat"><option value="ALL"  selected="selected">ALL</option><option value="PAID" >PAID</option><option value="PENDING">PENDING</option></select></td></tr>
                   <tr><td>To Date :</td><td><input  id="invoiceenddate" name="invoiceenddate" class="formfield" value="<?php echo date('d-m-Y')?>"/></td> <td>Account :</td><td><select id="invoicedpt"  class="formfield" name="invoicedept" >
                               
                     <?php
                      
                       $qrs1ist="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id' GROUP BY incomeaccounts.incacc"; 

                      
                      $datas1ist=$mumin->getdbContent($qrs1ist);
                      
                      
                       echo "<option value='ALL'>ALL</option>";
                    
                      
                      for($k=0;$k<=count($datas1ist)-1;$k++){
                          
                        
                          
                          
                          
                               echo '<option value="'.$datas1ist[$k]['incacc'].'"';
                              
                              echo '>' .$datas1ist[$k]['accname'].'</option>';   
                      }
                      ?>                   
                               
                               
                               
                           </select></td></tr><tr><td></td><td><button name="viewinvoicelist" class="formbuttons" id="viewinvoicelist">View List</button></td><td></td><td></td></tr></table>
    
                           </fieldset>
          
          <?php
          
          
          
          }
                    else if($acti=="creditlist"){
          ?>
          
                    <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">Credit Note List</legend>
         
           <table   class="ordinal"> 
                   
                                 
                   <tr><td>From Date :</td><td><input id="crdtstartdate" name="crdtstartdate"   class="formfield" value="<?php echo date('d-m-Y')?>"/></td></tr>
                   <tr><td>To Date :</td><td><input  id="crdtenddate" name="crdtenddate" class="formfield" value="<?php echo date('d-m-Y')?>"/></td> <td>Account :</td><td><select id="crdtdpt"  class="formfield" name="crdtdpt" >
                               
                     <?php
                      
                      $qrs1="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id' GROUP BY incomeaccounts.incacc"; 

                      
                      $datas1=$mumin->getdbContent($qrs1);
                      
                      
                       echo "<option value='ALL'>ALL</option>";
                    
                      
                      for($k=0;$k<=count($datas1)-1;$k++){
                          
                        
                          
                          
                          
                               echo '<option value="'.$datas1[$k]['incacc'].'"';
                              
                              echo '>' .$datas1[$k]['accname'].'</option>';   
                      }
                      ?>                   
                               
                               
                               
                           </select></td></tr><tr><td></td><td><button name="viewcrdtlist" class="formbuttons" id="viewcrdtlist">View List</button></td><td></td><td></td></tr></table>
    
                        </fieldset>
          
          <?php
          
          
          
          }
          
          else if($acti=="mody"){
          ?>
          
          
          <form method="post" action="">
            <table id="" class="ordinal">  
                
                <tr> 
                    
                    
                    <td style="border: none">Invoice Number:</td>
                     
                    <td style="border: none"><input type="text"  value="<?php if(isset($_POST['invnumbersubmit'])){echo $_POST['invnumber'];} ?>" id="invnos" name="invnumber" class="formfield"></input></td>
                    
                    
                    <td style="border: none"><input type="submit" class="formbuttons" value="submit" name="invnumbersubmit" ></input></td>
                    <td style="border: none"> </td>
                    
                    <tr style="border: none"><td style="border: none"> </td><td style="border: none"><font class="tooltits">Enter number then press SUBMIT</font></td></tr>  
                    
                       
                    
                    
                    
                </tr>
                 
        </table> 
                     </form>
             
         
          <?php
          }
          
          if($acti=="batch"){
          ?>
                    <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">Batch Invoicing</legend>
               <form method="post" action="">
            <table id="" class="ordinal">  
                
                <tr> 
                    
                    
                    <td style="border: none">Mohalla:</td>
                     
                     <td style="border: none"><select  name="mohalas" class="formfield" id="mohalas"> 
                                <option  value="">--Select Mohala--</option> 
                                
                                
                                   <?php

                                $qrt="SELECT distinct(moh) AS mohname FROM mumin WHERE status = 'A' AND moh <> '' AND moh <> 'BARZAQ' ORDER by moh ASC"; 
                                
                                $d=$mumin->getdbContent($qrt);
                                
                                 for($h=0;$h<=count($d)-1;$h++){
                      
                                     //if(strlen(strstr($d[$h]['sector'], "A.M.S"))>0){
                                     
                                         echo "<option value='".$d[$h]['mohname']."'>".$d[$h]['mohname']."</option>";
                                     //}
                                     //else{
                                         
                                     //}
                                     
                                   }
                                    
                            
                            ?>
                                
                            </select></td>
                     
                    
                    
                   <td id="sector_pane" class="formfield" style="border: none;visibility: hidden"></td><td></td><td></td></tr>
                
                
                
                 <tr>
                    
                   <td style="border: none">Date:</td>
                   <td style="border: none"><?php
                                 
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
                            
                            ?>
		<input type="text" class="formfield" name="invcedate" readonly="true" id="invcedate" value="<?php echo date('d-m-Y'); ?>" ></input></td><td></td><td></td></tr>
                      
                    
                <tr>
                    
                    
                    
                    <td style="border: none">Income Account:</td>
                    <td style="border: none"><select name="credit1" class="formfield" id="credit1"> 
                                <?php
                                $qr="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id' GROUP BY incomeaccounts.incacc"; 
    
                                $data=$mumin->getdbContent($qr);
                                 echo "<option value=''>-select Account-</option>";
                                
                                 for($h=0;$h<=count($data)-1;$h++){
                      
                                     echo "<option value=".$data[$h]['incacc'].">".$data[$h]['accname']."</option>";
                                     
                                   } 
                            
                            ?>
                        </select></td><td> <img id="loader" style="visibility: hidden" src="../assets/images/ajax-loader.gif"></img></td><td></td>
                </tr>
               <!-- <tr><td style="border: none"> SUB-ACCOUNT:</td><td  style="border: none"> <select class="formfield" name="subAc1" id="subAc1"></select></td><td></td><td></td></tr>  -->
                
                
                
                
           
             
                
                    
                     <tr> <td style="border: none">Amount Per Family:</td>  
                         <td style="border: none;"> <input type="text" class="amount" name="amountinv" id="amountinv" value="<?php  if(isset($_POST['batchinvoicegen1'])){ echo $_POST['amountinv'];} ?>" style="color: #696969;font-weight:normal;font-size: 18px"></input></td>
 
                
                      <td></td><td></td></tr> 
                      
                      
                       <tr> <td style="border: none">Remarks:</td>
                           <td style="border: none;"> <textarea class="formfield"  name="invrmks" id="invrmks" ><?php if(isset($_POST['batchinvoicegen1'])){ echo $_POST['invrmks'];} ?></textarea></td>
                       </tr><tr><td></td><td><?php echo $batchinvoicegen1;?></td><td></td></tr> 
        </table> 
                  </form> </fieldset>
              
            
          <?php
          }
           if($acti=="sabil"){
          ?>
                    <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">Mohalla Invoicing</legend>
               <form method="post" action="">
            <table id="" class="ordinal">  
                <tr><td>Type: </td><td><input type="radio" name="sabilinv" value="profession" id="psabil" checked="true" ><b>&nbsp&nbspProfessional Sabil &nbsp&nbsp</b></input>
                     <input type="radio" name="sabilinv" value="hse" id="hsesabil"><b>&nbsp&nbspHouse Sabil</b></input>
            </td></tr>
                <tr> 
                    <td style="border: none"><br>Mohalla:</td>
                     
                     <td style="border: none"><br><select  name="mohalas" class="formfield" id="mohallas"> 
                                <option  value="">--Select Mohala--</option> 
                                
                                
                                   <?php

                                $qrt="SELECT mohname FROM `mohalla`"; 
                                
                                $d=$mumin->getdbContent($qrt);
                                
                                 for($h=0;$h<=count($d)-1;$h++){
                      
                                     //if(strlen(strstr($d[$h]['sector'], "A.M.S"))>0){
                                     
                                         echo "<option value='".$d[$h]['mohname']."'>".$d[$h]['mohname']."</option>";
                                   }
                                    
                            
                            ?>
                                
                            </select></td>
                     
                    
                  <td></td><td></td></tr>
                
                <tr>
                    
                   <td style="border: none">Date:</td>
                   <td style="border: none"><?php
                                 
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
		<input type="text" class="formfield" name="sabldate" readonly="true" id="sabldate" value="<?php echo date('d-m-Y', strtotime('first day of January next year')); ?>" ></input></td><td></td><td></td></tr>

                
                                 <tr>
                    
                    
                    
                    <td style="border: none">Income Account:</td>
                    <td style="border: none"><select name="creditact" class="formfield" id="creditact"> 
                                <?php
                                $qr="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id' AND accname = 'Sabil Account' "; 
    
                                $data=$mumin->getdbContent($qr);
                                                            
                                 for($h=0;$h<=count($data)-1;$h++){
                      
                                     echo "<option value=".$data[$h]['incacc'].">".$data[$h]['accname']."</option>";
                                     
                                   } 
                            
                            ?>
                        </select></td><td> <img id="loader" style="visibility: hidden" src="../assets/images/ajax-loader.gif"></img></td><td></td>
                </tr>
               <!-- <tr><td style="border: none"> SUB-ACCOUNT:</td><td  style="border: none"> <select class="formfield" name="subAc1" id="subAc1"></select></td><td></td><td></td></tr>  -->
                     
                      
                       <tr> <td style="border: none">Remarks:</td>
                           <td style="border: none;"> <textarea class="formfield"  name="invnrmks" id="invnrmks" ></textarea></td>
                       </tr><tr><td></td><td><?php echo $batchpinvoice; echo $batchsablinvoice; ?>
                               </td><td></td></tr> 
        </table> 
                  </form> </fieldset>     
          <?php
           }
                      if($acti=="indivdlsabil"){
          ?>
                    <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">Sabil Invoicing </legend>
               <form method="post" action="">
            <table id="" class="ordinal">  
                <tr><td>Type: </td><td><input type="radio" name="sabilinv" value="profession" id="psabil" checked="true" ><b>&nbsp&nbspProfessional Sabil &nbsp&nbsp</b></input>
                     <input type="radio" name="sabilinv" value="hse" id="hsesabil"><b>&nbsp&nbspHouse Sabil</b></input>
            </td></tr>
                <tr> 
                    <td style="border: none"><br>Sabil No:</td>
                     
                     <td style="border: none"><br><select  name="indvdlsabl" class="formfield" id="indvdlsabl"> 
                                <option  value="">--Sabil No--</option> 
                                
                                
                                   <?php

                                $qrt="SELECT sabilno FROM `mumin` WHERE status = 'A' AND sabilno <> ''  GROUP BY sabilno"; 
                                
                                $d=$mumin->getdbContent($qrt);
                                
                                 for($h=0;$h<=count($d)-1;$h++){
                      
                                     //if(strlen(strstr($d[$h]['sector'], "A.M.S"))>0){
                                     
                                         echo "<option value='".$d[$h]['sabilno']."'>".$d[$h]['sabilno']."</option>";
                                   }
                                    
                            
                            ?>
                                
                            </select></td>
                     
                    
                  <td></td><td></td></tr>
                
                <tr>
                    
                   <td style="border: none">Date:</td>
                   <td style="border: none"><?php
                                 
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
		<input type="text" class="formfield" name="sabldate" readonly="true" id="sabldate" value="<?php echo date('d-m-Y', strtotime('first day of January next year')); ?>" ></input></td><td></td><td></td></tr>

                
                                 <tr>
                    
                    
                    
                    <td style="border: none">Income Account:</td>
                    <td style="border: none"><select name="creditact" class="formfield" id="creditact"> 
                                <?php
                                $qr="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id' AND accname = 'Sabil Account' "; 
    
                                $data=$mumin->getdbContent($qr);
                                                            
                                 for($h=0;$h<=count($data)-1;$h++){
                      
                                     echo "<option value=".$data[$h]['incacc'].">".$data[$h]['accname']."</option>";
                                     
                                   } 
                            
                            ?>
                        </select></td><td> <img id="loader" style="visibility: hidden" src="../assets/images/ajax-loader.gif"></img></td><td></td>
                </tr>
               <!-- <tr><td style="border: none"> SUB-ACCOUNT:</td><td  style="border: none"> <select class="formfield" name="subAc1" id="subAc1"></select></td><td></td><td></td></tr>  -->
                     
                      
                       <tr> <td style="border: none">Remarks:</td>
                           <td style="border: none;"> <textarea class="formfield"  name="invnrmks" id="invnrmks" ></textarea></td>
                       </tr><tr><td></td><td><?php echo $individualprofessionalsabil; echo $individualhousesabil; ?>
                               </td><td></td></tr> 
        </table> 
                  </form> </fieldset>     
          <?php
           }
      if(isset($_POST['batchinvoicegen1'])){
         echo "<script>$(function(){ $('#esdeb').css('display','none'); });</script>";     
     $moh=trim($_POST['mohalas']);
     $invcedate= date('Y-m-d',strtotime(trim($_POST['invcedate'])));
     $amount=floatval(str_replace( ',','', $_POST['amountinv']));
     $credit=trim($_POST['credit1']);
     $remarks=trim($_POST['invrmks']);
     //$subacc=trim($_POST['subAc1']);
      $ts=date('Y-m-d h:i:s');
      if($moh==''||$credit=='' || $amount =='' ){
          echo "<script> alert('Complete all the fields');</script>";
      }else{
  
     $n="SELECT DISTINCT hofej,fprefix,ejno,fname,sname,dadname,moh,sabilno,sector FROM mumin WHERE moh LIKE '$moh' AND hofej = ejno AND status = 'A' order by sabilno";
 
         $data=$mumin->getdbContent($n);
        
          
         $numbering=1;
          
         $sum=0;
          
         $sum1=0;
         
         $user=$_SESSION['jname'];
          
          
                 
          echo"<table class='receiptview1' id='sortablebatch'>";
          
          echo"<thead>";
           
          echo"<tr><th>Date</th><th>Doc.No</th><th>Names</th><th>Sabil No</th><th style='text-align:right'>Amount</th></tr>";    
          
          echo"</thead>";
       
          echo"<tbody>";
          
          $localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
          for($i=0;$i<=count($data)-1;$i++){
              
                $docnos=sprintf('%06d',intval($mumin->refnos("invno")));
              
               $qr="INSERT INTO invoice(estId,idate,amount,invno,rmks,hofej,sabilno,us,ts,rev,recpno,dno,sector,incacc,isinvce) 
                   VALUES ('$id','$invcedate','$amount','$docnos','$remarks','".$data[$i]['ejno']."','".$data[$i]['sabilno']."','$user','$ts',0,0,'','$localIP','$credit','1')";
               $inserted=$mumin->insertdbContent($qr);
                
               $invoicee=$mumin->get_MuminNames($data[$i]['ejno'])."&nbsp;";
              
                
     
              
              echo"<tr><td>".date('d-m-Y', strtotime($invcedate))."</td><td>".$docnos."</td><td>".$invoicee."</td><td>".$data[$i]['sabilno']."</td><td style='text-align:right'>".  number_format($amount,2)."</td></tr>";
              
              $numbering+=1;
              
              $sum+=$amount;
              
              
          }
         echo"<tr><td></td><td></td><td></td></td><td>TOTALS</td><td style='text-align:right'>". number_format($sum,2)."</td></tr>";    
          
        
        echo"</tbody>";
        echo"<table>";

              
          }}
 
  if (isset($_POST['invsearch'])){
      if (empty($_POST['mdfyinvno'])) {
           echo "<script> 
                    
                   $.modaldialog.warning('<br></br><b>Empty Field not allowed</b>', {
             timeout: 3,
             width:500,
             showClose: true,
             title:'Warning'
            });
 
            </script>";
      }
      else{
          $invno=trim($_POST['mdfyinvno']);
          $est_id=$_SESSION['dept_id'];
          $rlt=$mumin->getdbContent("SELECT * FROM  invoice WHERE invno LIKE '$invno' AND estId LIKE '$est_id'  LIMIT 1");
                    If ($rlt){
              $sabiltno = $rlt[0]['sabilno'];
              $amount = number_format($rlt[0]['amount'],2);
               $ejno = $rlt[0]['hofej'];
               $dno = $rlt[0]['dno'];
              $rmks = $rlt[0]['rmks'];
              $dbinvno = $rlt[0]['invno'];
              $idate = date('d-m-Y',strtotime($rlt[0]['idate']));
              $incacct = $rlt[0]['incacc'];
              $incmeac = $rlt[0]['incacc'];
              $pdamount = $rlt[0]['pdamount'];
              if($dno == '0'){
                 $muminme = $mumin->get_MuminNames($ejno); 
              }else{
                $muminme = $mumin->get_debtorName($dno);
              }
              
             
              echo "<script> 
                   $('#invmod').css('display','block');
                   $('#invcenomodfy').val('$invno');
                   $('#invcenoid').html('$invno');
                  $('#dateinvcenoid').val('$idate');
                  $('#sabinvcenoid').val('$sabiltno');
                  $('#amntinvcenoid').val('$amount'); 
                  $('#amntpaidid').val('$pdamount');    
                  $('#incmeinvcenoid').val('$incacct'); 
                  $('#nameinvcenoid').html('$muminme');
                  $('#rmksrecptid').html('$rmks');
                  $('#mdfyinvno').val('$invno');
                  $('#origincmeacct').val('$incmeac');
                  $('#invceits').val('$ejno');
            </script>";
          }else{
              echo "<script> 
                   
                   $.modaldialog.warning('<br></br><b>Invoice No. ".$invno." Not found</b>', {
             timeout: 3,
             width:500,
             showClose: true,
             title:'Warning'
            });
                $('#recpnorev').val('');
            </script>";
        
          }
      }
  } 
                if(isset($_POST['batchpinvoice'])){

         echo "<script>$(function(){ $('#esdeb').css('display','none'); });</script>";     
     $moh=trim($_POST['mohalas']);
     $invcedate= date('Y-m-d',strtotime($_POST['sabldate']));
      $credit=trim($_POST['creditact']);
     $remarks=trim($_POST['invnrmks']);
     //$subacc=trim($_POST['subAc1']);
      $ts=date('Y-m-d h:i:s');

      if($moh==''||$credit=='' ){
          echo "<script> alert('Complete all the fields');</script>";
         }else{
     
     $n="SELECT DISTINCT hofej,fprefix,ejno,fname,sname,dadname,moh,sabilno,sector,psabam FROM mumin WHERE moh LIKE '$moh' AND hofej = ejno AND status = 'A' AND psabam > '0' order by sabilno";
 
  
         $data=$mumin->getdbContent($n);
        
          
         $numbering=1;
          
         $sum=0;
          
         $sum1=0;
         
         $user=$_SESSION['jname'];
          
          
                 
          echo"<table class='receiptview1' id='sortablebatch'>";
          
          echo"<thead>";
           
          echo"<tr><th>Date</th><th>Doc.No</th><th>Names</th><th>Sabil No</th><th style='text-align:right'>Amount</th></tr>";    
          
          echo"</thead>";
       
          echo"<tbody>";
            
            $localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
          for($i=0;$i<=count($data)-1;$i++){
              
                $docnos=sprintf('%06d',intval($mumin->refnos("invno")));
              
               $qr="INSERT INTO invoice(estId,idate,amount,invno,rmks,hofej,sabilno,us,ts,rev,recpno,dno,sector,incacc,isinvce,subacc) 
                   VALUES ('$id','$invcedate','".$data[$i]['psabam']."','$docnos','$remarks','".$data[$i]['ejno']."','".$data[$i]['sabilno']."','$user','$ts',0,0,'','$localIP','$credit','1','2')";
               $inserted=$mumin->insertdbContent($qr);
                
               $invoicee=$mumin->get_MuminNames($data[$i]['ejno'])."&nbsp;";
              
                
     
              
              echo"<tr><td>".date('d-m-Y', strtotime($invcedate))."</td><td>".$docnos."</td><td>".$invoicee."</td><td>".$data[$i]['sabilno']."</td><td style='text-align:right'>".  number_format($data[$i]['psabam'],2)."</td></tr>";
              
              $numbering+=1;
              
              $sum+=$data[$i]['psabam'];
              
              
          }
         echo"<tr><td></td><td></td><td></td></td><td>TOTALS</td><td style='text-align:right'>". number_format($sum,2)."</td></tr>";    
          
        
        echo"</tbody>";
        echo"<table>";
       
              
          }}
                          if(isset($_POST['batchsablinvoice'])){
         echo "<script>$(function(){ $('#esdeb').css('display','none'); });</script>";     
     $moh=trim($_POST['mohalas']);
     $invcedate= trim($_POST['sabldate']);
      $credit=trim($_POST['creditact']);
     $remarks=trim($_POST['invnrmks']);
     //$subacc=trim($_POST['subAc1']);
      $ts=date('Y-m-d h:i:s');
      $idate = substr($invcedate,6,4)."-".substr($invcedate,3,2)."-".substr($invcedate,0,2);
      if($moh==''||$credit=='' ){
          echo "<script> alert('Complete all the fields');</script>";
         }else{

     $n="SELECT DISTINCT hofej,fprefix,ejno,fname,sname,dadname,moh,sabilno,sector,hsabam FROM mumin WHERE moh LIKE '$moh' AND hofej = ejno AND status = 'A' AND hsabam > '0' order by sabilno";
 
  
         $data=$mumin->getdbContent($n);
        
          
         $numbering=1;
          
         $sum=0;
          
         $sum1=0;
         
         $user=$_SESSION['jname'];
          
          
                 
          echo"<table class='receiptview1' id='sortablebatch'>";
          
          echo"<thead>";
           
          echo"<tr><th>Date</th><th>Doc.No</th><th>Names</th><th>Sabil No</th><th style='text-align:right'>Amount</th></tr>";    
          
          echo"</thead>";
       
          echo"<tbody>";
                    $localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS        
                   for($t=0;$t<=11;$t++){
    $invceedate = date('Y-m-d', strtotime("+$t month",strtotime($idate)));         
          for($i=0;$i<=count($data)-1;$i++){
              
                $docnos=sprintf('%06d',intval($mumin->refnos("invno")));
              
               $qr="INSERT INTO invoice(estId,idate,amount,invno,rmks,hofej,sabilno,us,ts,rev,recpno,dno,sector,incacc,isinvce,subacc) 
                   VALUES ('$id','$invceedate','".$data[$i]['hsabam']."','$docnos','$remarks','".$data[$i]['ejno']."','".$data[$i]['sabilno']."','$user','$ts',0,0,'','$localIP','$credit','1','1')";
               $inserted=$mumin->insertdbContent($qr);
                
               $invoicee=$mumin->get_MuminNames($data[$i]['ejno'])."&nbsp;";
              
                
     
              
              echo"<tr><td>".date('d-m-Y', strtotime($invceedate))."</td><td>".$docnos."</td><td>".$invoicee."</td><td>".$data[$i]['sabilno']."</td><td style='text-align:right'>".  number_format($data[$i]['hsabam'],2)."</td></tr>";
              
              $numbering+=1;
              
              $sum+=$data[$i]['hsabam'];
              
              
         }}
         echo"<tr><td></td><td></td><td></td></td><td>TOTALS</td><td style='text-align:right'>". number_format($sum,2)."</td></tr>";    
          
        
        echo"</tbody>";
        echo"<table>";
                   
          }}
                          if(isset($_POST['individualpinvoice'])){

         echo "<script>$(function(){ $('#esdeb').css('display','none'); });</script>";     
      $isabilno=trim($_POST['indvdlsabl']);
     $invcedate= date('Y-m-d',strtotime($_POST['sabldate']));
      $credit=trim($_POST['creditact']);
     $remarks=trim($_POST['invnrmks']);
     //$subacc=trim($_POST['subAc1']);
      $ts=date('Y-m-d h:i:s');

      if($isabilno==''||$credit=='' ){
          echo "<script> alert('Complete all the fields');</script>";
         }else{
     
     $n="SELECT DISTINCT hofej,fprefix,ejno,fname,sname,dadname,moh,sabilno,sector,psabam FROM mumin WHERE sabilno LIKE '$isabilno' AND hofej = ejno AND status = 'A' AND psabam > '0' order by sabilno";
 
  
         $data=$mumin->getdbContent($n);
        
          
         $numbering=1;
          
         $sum=0;
          
         $sum1=0;
         
         $user=$_SESSION['jname'];
          
          
                 
          echo"<table class='receiptview1' id='sortablebatch'>";
          
          echo"<thead>";
           
          echo"<tr><th>Date</th><th>Doc.No</th><th>Names</th><th>Sabil No</th><th style='text-align:right'>Amount</th></tr>";    
          
          echo"</thead>";
       
          echo"<tbody>";
            
            $localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
          for($i=0;$i<=count($data)-1;$i++){
              
                $docnos=sprintf('%06d',intval($mumin->refnos("invno")));
              
               $qr="INSERT INTO invoice(estId,idate,amount,invno,rmks,hofej,sabilno,us,ts,rev,recpno,dno,sector,incacc,isinvce,subacc) 
                   VALUES ('$id','$invcedate','".$data[$i]['psabam']."','$docnos','$remarks','".$data[$i]['ejno']."','".$data[$i]['sabilno']."','$user','$ts',0,0,'','$localIP','$credit','1','2')";
               $inserted=$mumin->insertdbContent($qr);
                
               $invoicee=$mumin->get_MuminNames($data[$i]['ejno'])."&nbsp;";
              
                
     
              
              echo"<tr><td>".date('d-m-Y', strtotime($invcedate))."</td><td>".$docnos."</td><td>".$invoicee."</td><td>".$data[$i]['sabilno']."</td><td style='text-align:right'>".  number_format($data[$i]['psabam'],2)."</td></tr>";
              
              $numbering+=1;
              
              $sum+=$data[$i]['psabam'];
              
              
          }
         echo"<tr><td></td><td></td><td></td></td><td>TOTALS</td><td style='text-align:right'>". number_format($sum,2)."</td></tr>";    
          
        
        echo"</tbody>";
        echo"<table>";
       
              
          }}
                                    if(isset($_POST['individualsablinvoice'])){
         echo "<script>$(function(){ $('#esdeb').css('display','none'); });</script>";     
     $isabilno=trim($_POST['indvdlsabl']);
     $invcedate= trim($_POST['sabldate']);
      $credit=trim($_POST['creditact']);
     $remarks=trim($_POST['invnrmks']);
     //$subacc=trim($_POST['subAc1']);
      $ts=date('Y-m-d h:i:s');
      $idate = substr($invcedate,6,4)."-".substr($invcedate,3,2)."-".substr($invcedate,0,2);
      if($isabilno==''||$credit=='' ){
          echo "<script> alert('Complete all the fields');</script>";
         }else{

     $n="SELECT DISTINCT hofej,fprefix,ejno,fname,sname,dadname,moh,sabilno,sector,hsabam FROM mumin WHERE sabilno LIKE '$isabilno' AND hofej = ejno AND status = 'A' AND hsabam > '0' order by sabilno";
 
            
         $data=$mumin->getdbContent($n);
        
          
         $numbering=1;
          
         $sum=0;
          
         $sum1=0;
         
         $user=$_SESSION['jname'];
          
          
                 
          echo"<table class='receiptview1' id='sortablebatch'>";
          
          echo"<thead>";
           
          echo"<tr><th>Date</th><th>Doc.No</th><th>Names</th><th>Sabil No</th><th style='text-align:right'>Amount</th></tr>";    
          
          echo"</thead>";
       
          echo"<tbody>";
                    $localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS        
                   for($t=0;$t<=11;$t++){
    $invceedate = date('Y-m-d', strtotime("+$t month",strtotime($idate)));         
          for($i=0;$i<=count($data)-1;$i++){
              
                $docnos=sprintf('%06d',intval($mumin->refnos("invno")));
              
               $qr="INSERT INTO invoice(estId,idate,amount,invno,rmks,hofej,sabilno,us,ts,rev,recpno,dno,sector,incacc,isinvce,subacc) 
                   VALUES ('$id','$invceedate','".$data[$i]['hsabam']."','$docnos','$remarks','".$data[$i]['ejno']."','".$data[$i]['sabilno']."','$user','$ts',0,0,'','$localIP','$credit','1','1')";
               $inserted=$mumin->insertdbContent($qr);
                
               $invoicee=$mumin->get_MuminNames($data[$i]['ejno'])."&nbsp;";
              
                
     
              
              echo"<tr><td>".date('d-m-Y', strtotime($invceedate))."</td><td>".$docnos."</td><td>".$invoicee."</td><td>".$data[$i]['sabilno']."</td><td style='text-align:right'>".  number_format($data[$i]['hsabam'],2)."</td></tr>";
              
              $numbering+=1;
              
              $sum+=$data[$i]['hsabam'];
              
              
         }}
         echo"<tr><td></td><td></td><td></td></td><td>TOTALS</td><td style='text-align:right'>". number_format($sum,2)."</td></tr>";    
          
        
        echo"</tbody>";
        echo"<table>";
                   
          }}
          if(isset($_POST['invsubmit'])){     //Print Invoice given Inv No:    
              
              $invnos=trim(strip_tags(stripslashes($_POST['invnos'])));
              if ($invnos==''){
                  echo "<span style='color:red;'><br>&nbsp&nbsp&nbspInsert invoice Number</span>";
              }
              else{
                
              $q78="SELECT * FROM  invoice WHERE invno = '$invnos' AND estId LIKE '$id' AND isinvce = '1' LIMIT 1";
              $datainv=$mumin->getdbContent($q78);
               
                              if($datainv){ // Get incme acct Name
              $qry2 = "SELECT accname FROM incomeaccounts where incacc = ".$datainv[0]['incacc']."";
              $data2=$mumin->getdbContent($qry2);
              
              if($datainv[0]['dno'] =='0'){
                  
                  $dispname=$mumin->get_MuminHofNamesFromSabilno($datainv[0]['sabilno']);
                  $debtel='';
                  $city='';
              }
              else if($datainv[0]['dno'] !=='0'){ // Get debtor Name
                 
                  $d=$mumin->getdbContent("SELECT debtorname,debTelephone,city FROM debtors WHERE dno LIKE ".$datainv[0]['dno']." AND deptid LIKE '$id'");
                  
                  $dispname=$d[0]['debtorname'];
                  $debtel = $d[0]['debTelephone'];
                  $city = $d[0]['city'];
                  
              }
              //Display Invoice on Window 
              echo "<script>window.location='invoicepreview.php?paymentdate=".$datainv[0]['idate']."&remarks=".urlencode($datainv[0]['rmks'])."&amount=".$datainv[0]['amount']."&sabilno=".$datainv[0]['sabilno']."&docno=".$datainv[0]['invno']."&debtor=".$datainv[0]['dno']."&acctname=".$data2[0]['accname']."&dispname=".$dispname."&tel=".$debtel."&sector=".$datainv[0]['sector']."&city=".$city."&subacct=".$datainv[0]['subacc']."&reprint=1';</script>";
              }
              else{
                
                  echo "<script>alert('Invoice not found')</script>";
              }
              }
          }
        
           
        else if(isset($_POST['crdtsubmit'])){         
              
              $crdtnos=trim(strip_tags(stripslashes($_POST['crdtnos'])));
              if ($crdtnos==''){
                  echo "<span style='color:red;'><br>&nbsp&nbsp&nbspInsert Credit Note Number</span>";
              }
              else{
                 
                  
                  
              $q="SELECT * FROM  invoice WHERE invno LIKE '$crdtnos' AND estId LIKE '$id' AND isinvce = '0'  LIMIT 1";
              
              $data=$mumin->getdbContent($q);
              
                 
              if($data){
              $qry2 = "SELECT accname FROM incomeaccounts where incacc = ".$data[0]['incacc']."";
              $data2=$mumin->getdbContent($qry2);
              
              if($data[0]['dno'] =='0'){
                  
                  $dispname=$mumin->get_MuminHofNamesFromSabilno($data[0]['sabilno']); 
              }
              else if($data[0]['dno'] !=='0'){
                 
                  $d=$mumin->getdbContent("SELECT debtorname,debTelephone,city FROM debtors WHERE dno = ".$data[0]['dno']." AND deptid LIKE '$id'");
                  
                  $dispname=$d[0]['debtorname'];
                  $debtel = $d[0]['debTelephone'];
                  $city = $d[0]['city'];
              }
              
              echo "<script>window.location='creditnote.php?paymentdate=".$data[0]['idate']."&remarks=".urlencode($data[0]['rmks'])."&amount=".$data[0]['amount']."&sabilno=".$data[0]['sabilno']."&docno=".$data[0]['invno']."&debtor=".$data[0]['dno']."&invoice=".$data[0]['crdtinvce']."&sector=".$data[0]['sector']."&accounts=".$data[0]['incacc']."';</script>";
              //ndow.location="../finance/creditnote.php?paymentdate="+$date+"&remarks="+$remarks+"&amount="+$amount+"&sabilno="+response.sabilno+"&docno="+response.docno+"&debtor="+response.debtor+"&invoice="+$invoice+"&accounts="+response.accounts;
              
              }
              else{
                
                  echo "<script>alert('Invoice not found')</script>";
              }
              }
          }
                 else if(isset($_POST['ovrpymntincacc'])){         
              if (empty($_POST['ovrpymntsabilno'])) {
                  
             echo "<script> 
                    
                   $.modaldialog.warning('<br></br><b>Empty Field not allowed</b>', {
             timeout: 3,
             width:500,
             showClose: true,
             title:'Warning'
            });
                    
            </script>";
             
                 }else{
                    echo "<script> 
                    $('#incmeid').val();
                    $('#ovrpymntincacc').val($('#incmeid').val());
                    
            </script>";
                    $ovrsabilno=trim($_POST['ovrpymntsabilno']);
                    $ovrincacc=trim($_POST['ovrpymntincacc']);
                    $rlt=$mumin->getdbContent("SELECT sum(amount) as amount, sum(pdamount) as pdamount FROM  invoice WHERE sabilno = '$ovrsabilno' AND incacc = '$ovrincacc' AND pdamount > amount UNION "
                                            . "  ");
                    $overpayfig = $rlt[0]['pdamount'] - $rlt[0]['amount'];
                    ?>
                    
                    <div id="overpaymntfig" style="height: 30px;display: block;width:780px;font-size: 14px;color: orangered;vertical-align: middle;line-height: 30px;padding-right: 20px;border: 1px gainsboro solid;background: ghostwhite;font-weight: bold;text-align: right">
                      Overpayment Amount:  <?php echo number_format($overpayfig,2); ?>
                    </div>
                    <?php
                    $rt=$mumin->getdbContent("SELECT idate,invno,invoice.incacc,amount,pdamount,incomeaccounts.accname FROM  invoice,incomeaccounts WHERE incomeaccounts.incacc = invoice.incacc AND sabilno = '$ovrsabilno' AND invoice.incacc = '$ovrincacc' AND pdamount < amount ");
                        if(count($rt)== '0' ){
                            echo "<script> 
                    
                   $.modaldialog.warning('<br></br><b>No pending invoice to be linked</b>', {
             timeout: 3,
             width:500,
             showClose: true,
             title:'Warning'
            });
                    
            </script>";
                            
                        }else if($overpayfig == '0'){
                        echo "<script> 
                    
                   $.modaldialog.warning('<br></br><b>No overpayment done</b>', {
             timeout: 3,
             width:500,
             showClose: true,
             title:'Warning'
            });
                    
            </script>";
                        
                        }
                        else{
                          echo  '<legend style="color: #00BFFF;font-weight: bold;font-style: italic;font-size:12px">Pending Invoices </legend>';
                   echo '<table id="invcetble"  style="width: 100%">';
              echo "<thead><tr style='font-size:10px'><th>#</th><th>Date</th><th>Doc No.</th><th>Account.</th><th style='text-align: right;padding-right:40px'>Balance</th><th>Amount</th></tr></thead>";
              $cnt = 0;           
              for($j=0;$j<=count($rt)-1;$j++){
                             $cnt++;
                           echo "<tr><td>$cnt.</td><td class='sablaffectedinvces'>".date('d-m-Y',  strtotime($rt[$j]['idate']))."</td><td id='pinvn".$j."'>".$rt[$j]['invno']."</td><td>".$rt[$j]['accname']."</td><td style='text-align: right;padding-right:40px'>".number_format($rt[$j]['amount'] - $rt[$j]['pdamount'],2)."</td><td><input class='amount' id='editedamnt$j' value='0' ></input><input type='text' hidden='true' id='otherrcpt$j' value=''/></td></tr>";

                         }         
              echo '</table>';
              
                 }
                 
                        }
                 
              }
         else if(isset($_POST['invnumbersubmit'])){
          
             $number=  $_POST['invnumber'];
             
             $qwr="SELECT * FROM invoice WHERE invno LIKE '$number' AND estId LIKE '$id' LIMIT 1"; 
             
             $data= $mumin->getdbContent($qwr);
            
            if(!$data){
                
               echo "<script>alert('Invoice not found!')</script>" ;
            }
        else{
         
         ?>
                 <form method="post" action="">
	  <table class="ordinal" >        
              <tr><td>Invoice No:</td><td><input value="<?php echo $data[0]['invno']?>" id="invsno" name="invsno" readonly="readonly"   type="text" class="formfield"></input>
                     
               </td></tr>  
          
           <tr><td>Invoice Date:</td><td><input value="<?php echo $data[0]['idate']?>" id="invsdate"   name="invsdate"  type="text" class="formfield"></input>
                     
             </td></tr>
          
              <tr><td>Amount:</td><td><input readonly="readonly" name="invsamount" type="text" value="<?php echo $data[0]['amount']?>" class="formfield"/></td></tr>  
          
          <tr><td>Credit:</td><td>
                  <select id="toaccs" class="formfield" name="toaccs">
              
              <?php
                      
                      $qrs1="SELECT * FROM incomeaccounts WHERE estateid LIKE '$id' ";
                      
                      $datas1=$mumin->getdbContent($qrs1);
                      
                      
                       echo "<option value='ALL'>ALL</option>";
                    
                      
                      for($k=0;$k<=count($datas1)-1;$k++){
                          
                        
                          
                          
                          
                               echo '<option value="'.$datas1[$k]['id'].'"';
                               if($datas1[$k]['id'] == $data[0]['incacc']) echo 'SELECTED';
                              echo '>' .$datas1[$k]['accname'].'</option>';   
                      }
                      ?>                   
              
              
                  </select></td></tr>  
          
          <tr><td></td><td><input type="submit" name="invoicechange" class="buttons" value="Update"></input></td></tr>
           
          </table></form>
               <?php
         }
         }
         
       
         ?>
                 
    <?php
          if(isset($_POST['updateinv'])){
          
               $invonumber=  $_POST['invcenomodfy'];
             
               $date=  date('Y-m-d', strtotime($_POST['dateinvcenoid']));
                
               $sabin= $_POST['sabinvcenoid'];
               $itsno = $_POST['invceits'];
               $incmeid = $_POST['incmeinvcenoid'];
               $amntid = floatval(str_replace(',', '', $_POST['amntinvcenoid']));
               $pdamnt = floatval(str_replace(',', '', $_POST['amntpaidid']));
                $rmksrecpt = $_POST['rmksrecptid'];
                $origacct = $_POST['origincmeacct'];
                   if ($origacct != $incmeid &&  $pdamnt > 0 ){
                       echo "<script> 
                   
                   $.modaldialog.warning('<br></br><b>Cannot change income account for an already paid invoice</b>', {
             timeout: 10,
             width:500,
             showClose: true,
             title:'Error'
            });
            </script>";
                   }else{
            $qwr="UPDATE invoice SET idate='$date' ,incacc= '$incmeid',sabilno='$sabin',incacc='$incmeid',amount='$amntid',rmks='$rmksrecpt',hofej = '$itsno',	pdamount = '$pdamnt'  WHERE invno = '$invonumber' AND estId LIKE '$id' "; 
             
           $update= $mumin->updatedbContent($qwr);
            
            if($update==1){
                
                echo "<script> 
                   
                   $.modaldialog.success('<br></br><b>Update Successful</b>', {
             timeout: 3,
             width:500,
             showClose: true,
             title:'Successful Update'
            });
            </script>";
            
            }
            else{
               echo "<script> 
                   
                   $.modaldialog.warning('<br></br><b>Update not Successfully</b>', {
             timeout: 3,
             width:500,
             showClose: true,
             title:'Error'
            });
            </script>"; 
           
            }
            echo "<script> 
                   
        var msg = '<p><b><u>Confirmation</u></b></p><br/>Are you sure?';
        var boxx = new Lert(msg,[ok_buttt,no_buttt],
		{
        defaultButton:ok_buttt,
        icon:'./images/dialog-information.png'
		});
        boxx.display();
            </script>";
            
          }}
            
            
    
    ?>
    <div id="succes" style="display: none">
        
    </div>
                         <div id="changeeditdebtor" style="display:none " title="Change /Edit debtor Info">
         
             
          <table class="ordinal" id="dtable" style="display:none">   
              
              <tr><td></td><td><input  type="text"  class="formfield"    id="cgid12" hidden="true"/> </td></tr>
               <tr><td>Names:</td><td><input  type="text"  class="formfield"    id="cgname"/> </td></tr> 
            <tr><td>Telephone:</td><td><input  type="text"  class="formfield"  id="cgtel"/> </td></tr>
             <tr><td>Email:</td><td><input  type="text"  class="formfield"    id="cgemail"/> </td></tr>
              <tr><td>Postal Addr:</td><td><input  type="text"  class="formfield"   id="cgpostal"/> </td></tr>
           <tr><td>City:</td><td><input  type="text"  class="formfield"   id="cgcity"/> </td></tr>
		<tr><td>Hse No:</td><td><input  type="text"  class="formfield"   id="cghseno"/> </td></tr>
              <tr><td></td><td> <button id="debsaver" class="formbuttons">Save Changes</button>   
               </td></tr>
         </table>
      </div>
    <div id="inv_success" style="display: none" title="Transaction complete">
        
        <p>Invoice was generated successfully at <?php echo date('d-m-Y h:i:s') ;?></p>
        <p>  <button id="cancl1">OK</button></p>
    </div>
        
        <div id="inv_rqst" style="display: none" title="Mumin Error">
        <p></p>
        <p></p>
        <p></p>
        <p> Not Registered as a Debtor. <br></br> Add as Debtor?</p>
        <p></p>
        <p></p>
        <p> <button id="adddebtor">OK</button> <button id="canceladd">CANCEL</button>  </p>
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
    <div id="addebt" style="display:none" title="ADD DEBTOR">
       <table class="ordinal" id="esdeb">   
              
              <tr><td></td><td><input  type="hidden"  class="formfield" readonly="readonly" id="cgid"/> </td></tr>
               <tr><td>Names:</td><td><input  type="text"  class="formfield"   id="muname"/>  * </td></tr> 
            <tr><td>Telephone:</td><td><input  type="text"  class="formfield"    id="mutel"/>  * </td></tr>
             <tr><td>Email:</td><td><input  type="text"  class="formfield"   id="muemail"/> </td></tr>
              <tr><td>Postal Addr:</td><td><input  type="text"  class="formfield"   id="mupostal"/> </td></tr>
           <tr><td>City/Mohalla:</td><td><input  type="text"  class="formfield"   id="mucity"/>  * </td></tr>
           <tr><td>Sabil No:</td><td><input  type="text"  class="formfield"   id="musabil" style="text-transform: uppercase;"/>  </td></tr>
           <tr><td>Remarks:</td><td><textarea class="formfield" id="murmks" ></textarea> 
               </td></tr>
              <tr><td></td><td> <br><button id="debtorsaver" >&nbspSave&nbsp</button>   
               </td></tr>
         </table>
        
    </div>
                    <div id="gallery" >
   <table>
       <tr><td style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;<b>Name:</b></td><td style="width: 230px"><img src="images/cross.png" align="right" id="closegallery"></img></td></tr>
       <tr><td><input type="text" class="texinput" id="namesrch" placeholder="--- First name ---"></input></td>
           <td><input type="text" class="texinput" id="snamesrch" placeholder="---  Surname ---"></input></td></tr>
   </table>
    <div id="phts" style="width: 400px;">
        
    </div>
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
}
?>