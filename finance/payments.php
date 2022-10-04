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

if($priviledges[0]['payments']!=1){
   
header("location: index.php");
}
if($priviledges[0]['readonly']==1){
    $cshpay = '';
     $ckpay = '';
     $searchpvr = '';
}else if($priviledges[0]['readonly']!=1){
    $cshpay = '<button id="cshpay300"><b>Complete</b></button>';
    $ckpay = '<button class="formfield" id="ckpay300"><b>Complete</b></button>';
    $searchpvr = '<input type="submit"  value="Search" name="searchpvr" class="formbuttons"></input>';
   }
}

date_default_timezone_set('Africa/Nairobi');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head>
<title>Payments</title>
    
 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';

?>

<script>
 $(function() {
    var costcentrs=[];
   var clsingdate = $("#clsingdate" ).val();
   $("#tabs").tabs();
   
   
   
   
$( "#paymentssdate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#paymentsedate" ).datepicker( "option", "minDate", selectedDate );
}
});
$( "#paymentsedate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#paymentssdate" ).datepicker( "option", "maxDate", selectedDate );
}
});

      $("#oc").datepicker({dateFormat:'yy-mm-dd'} );
     
      $("#invoicepaymentdt100").datepicker({dateFormat:'dd-mm-yy'} );
      
       $("#pettybilldate" ).datepicker({dateFormat:'yy-mm-dd'} );
     $("#ckdate100").datepicker({dateFormat:'yy-mm-dd'} );
     
      $("#cshpaymentdt100" ).datepicker({dateFormat: 'dd-mm-yy',minDate: parseInt(clsingdate)+parseInt(1)} );
     $("#invoicechqdate").datepicker({dateFormat:'dd-mm-yy'});
  
   $("#invprint201").button({
            icons: {
                primary: "ui-icon-check",
                secondary: "ui-icon-print" 
            }
        });
        
        
          $("#viewpaymentslist").button({
            icons: {
                
                secondary: "ui-icon-document" 
            }
        });
        $("#viewpaymntslist").button({
            icons: {
                
                secondary: "ui-icon-document" 
            }
        });
    
     $("#ckpay300").button({
            icons: {
                primary: "ui-icon-check",
                //secondary: "ui-icon-cart" 
            }
        });
   
     $("#cshpay300").button({ 
            icons: {
                primary: "ui-icon-check",
                //secondary: "ui-icon-cart" 
            }
        });
    
    $("#rcptprint").button({
            icons: {
                primary: "ui-icon-check",
                secondary: "ui-icon-print" 
            }
        });
        
        $("#choosesuppliergo").button({
            icons: {
                primary: "ui-icon-check",
                secondary: "ui-icon-search" 
            }
        });
    
           $("#reprintpv").button({
            icons: {
                primary: "ui-icon-check",
                secondary: "ui-icon-search" 
            }
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
    });
     });
   
  
    });
 
</script>
    <style>
      
    .ui-combobox {
        position: relative;
        display: inline-block;
         
        
    }
    .ui-combobox-toggle {
        position: absolute;
        top: 0;
        bottom: 0;
        margin-left: -1px;
        padding: 0;
        /* adjust styles for IE 6/7 */
        *height: 1.7em;
        *top: 0.1em;
    }
    .ui-combobox-input {
        margin: 0;
        padding: 0.3em;
        width: 170px;
        height: 30px;
         
    }
    .ui-effects-wrapper{overflow-x: visible !important; width: 2px !important; height: 2px !important }
      
    </style>
    
<link rel="stylesheet" href="./css/smoothness.css" />
      
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
          <div id="div_pagecontent" style="min-height: 300px;height: auto">
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
   
   $action=$_GET['action'];
   
   if($action=="new")
   {
     
        
        ?>   
       
         
                    <fieldset style="border: 2px ghostwhite solid;color: black;font-size: 12px;font-weight: bold"> <legend>New Payment</legend>  
        <table class="ordinal" style="width: 100%;float: left">  
          <tr><td>Select Supplier (*):</td><td><select id="chooseSupplier" class="formfield" >
               <?php
                      
                      $qrs="SELECT * FROM suppliers WHERE estId LIKE '$id' ORDER BY suppName ";
                      
                      $datas=$mumin->getdbContent($qrs);
                      
                      for($k=0;$k<=count($datas)-1;$k++){
                          
                          echo "<option value='".$datas[$k]['supplier']."'>".$datas[$k]['suppName']."</option>";
                      }
                      ?>        
                      
                  </select></td><td>
                      
                     
                  </td><td><button id="choosesuppliergo" class="formbuttons">Go</button></td></tr>         
        </table>
        
                    </fieldset>
           <div id="_outstanding_invoiceslist" style="width: 770px;min-height:10px;max-height: 160px;overflow-y: auto; border:none;line-height: 10px ;vertical-align: middle;background: transparent; margin: 2px auto 2px auto;padding: 0 10px 0px 10px;">
                  
               <table id="billstable1" class="ordinal" style="width: 100%"></table> 
           
                 
           </div>
     
    
    
  
        
            
     <div id="tabs" style="display: none;width: 770px;height: auto;">
    <ul>
       
    <li><a href="#CHQ" >CHEQUE</a></li>
    <li><a href="#CSH">CASH</a></li>
        
         
    </ul>
         <div id="CHQ"> 
    
        
        
        <table class="ordinal"> <!--if cheque !-->
          <tr><td> Date:&nbsp;</td><td><?php
                                 
                                $qrtr1="SELECT deptid as estate_id,cdate as date FROM closing_period WHERE deptid = '$id' ORDER BY id DESC LIMIT 1 "; 
                                
                                $datatr1=$mumin->getdbContent($qrtr1);
                                
                                 for($m=0;$m<=count($datatr1)-1;$m++){
                                   $qru=  "SELECT DATEDIFF('".$datatr1[$m]['date']."','".date('Y-m-d')."') AS DiffDate";
                                    $datau=$mumin->getdbContent($qru);
                                    for($n=0;$n<=count($datau)-1;$n++){
                                     echo "<input hidden='true' type='text' id='clsingdate'  class='formfield' value='".$datau[$n]['DiffDate']."'>";
                                   //  echo "<option value=".$data[$h]['date'].">".$data[$h]['date']."</option>";
                                   } }
                            
                            ?>
                
		<input type="text" id="invoicepaymentdt100"  class="formfield"  value="<?php echo date('d-m-Y');?>"/></td></tr>            
                  <tr><td>Bank Account:</td>
                        <td>
        <select id="invoicebankaccount" readonly="readonly"  class="formfield">
                           <?php
                                
                                $q1="SELECT bacc,acname,acno FROM bankaccounts WHERE deptid LIKE '$id' AND type = 'B' ";
                                 
                                $data9=$mumin->getdbContent($q1);
                                
                                 for($b=0;$b<=count($data9)-1;$b++){ 
                      
                                     echo "<option value=".$data9[$b]['bacc'].">".$data9[$b]['acname'].": ".$data9[$b]['acno']."</option>";
                                     
                                     
                                   }
                            
                            ?>            
                  
        </select>
                        
                        </td>
                      <td>
                          
                          <select  class="formfield" id="expnseaccounts" disabled> <option value="">--Expense account--</option> 
                                <?php
                                $inqry="SELECT expnseaccs.id,expnseaccs.accname FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id AND expenseactmgnt.deptid = '$id'";
                                
                                $data2=$mumin->getdbContent($inqry);
                                
                                 for($v=0;$v<=count($data2)-1;$v++){
                      
                                     echo "<option value=".$data2[$v]['id'].">".$data2[$v]['accname']."</option>";
                                   } 
                            
                            ?>
                        </select>
                          <input type="hidden" id="costc" />
                        </td>
                    </tr>
                    
           <tr><td>Cheque No:</td><td><input id="invoicechqno"    type="text"  class="formfield"/>
                     
                    </td></tr>  
          
           <tr><td>Cheque Date:</td><td><input id="invoicechqdate"   value="<?php echo date('d-m-Y') ?>" type="text"  class="formfield"/>
                     
                    </td></tr>
                    
          <tr><td>Amount:</td><td><input id="investamont"  value="0.00" readonly="" onkeypress="return isNumberKey(event);" type="text"  class="formfield"/>
                     
                    </td></tr>  
                    
                    
                    <tr><td>Brief Remarks :</td><td><textarea  class="formfield" id="invoiceckrmks100" ></textarea></td></tr> 
                    
                    <tr><td></td><td><?php echo $ckpay; ?></td></tr>   
                </table>  
                    
    </div>
        
         <div id="CSH">
             
             
           
        
        <table class="ordinal"> 
            <tr><td>Entry Date:&nbsp;</td><td><?php
                                 
                                $qrtr="SELECT deptid as estate_id,cdate as date FROM closing_period WHERE deptid = '$id' ORDER BY id DESC LIMIT 1 "; 
                                
                                $datatr=$mumin->getdbContent($qrtr);
                                
                                 for($h=0;$h<=count($datatr)-1;$h++){
                                   $qru6=  "SELECT DATEDIFF('".$datatr[$h]['date']."','".date('Y-m-d')."') AS DiffDate";
                                    $datau6=$mumin->getdbContent($qru6);
                                    for($c=0;$c<=count($datau6)-1;$c++){
                                     echo "<input hidden='true' type='text' id='clsingdate'  class='formfield' value='".$datau6[$c]['DiffDate']."'>";
                                   //  echo "<option value=".$data[$h]['date'].">".$data[$h]['date']."</option>";
                                   } }
                            
                            ?>
	<input readonly="true" type="text" id="cshpaymentdt100"  class="formfield" value="<?php echo date('d-m-Y');?>"></input></td></tr>            
                    <tr><td>Bank Account:</td>
                        <td>
        <select id="cshbankaccount"  readonly="readonly" class="formfield">
                                                         <?php
                                 
                                $q8="SELECT bacc,acname,acno FROM bankaccounts WHERE deptid LIKE '$id' ";
                                
                                  
                                $data0=$mumin->getdbContent($q8);
                                
                                 for($x=0;$x<=count($data0)-1;$x++){ 
                      
                                     echo "<option value=".$data0[$x]['bacc'].">".$data0[$x]['acname'].": ".$data0[$x]['acno']."</option>";
                                     
                                     
                                   }
                            
                            ?>       
                  
        </select>
                        
                        </td>
                    </tr>
                    
            
                     
          <tr><td>Amount:</td><td><input id="amountt100"  value="0.00" readonly="readonly" type="text" class="formfield"></input>
                     
                    </td></tr>  
                    
                    
                    <tr><td>Brief Remarks :</td><td><textarea  class="formfield" id="cshrmks100"></textarea></td></tr> 
                    
                    <tr><td></td><td><?php echo $cshpay;  ?></td></tr>   
                </table>    
             
             
         </div>
        
          
         
     </div>
   
        
             
 <!--<div id="d_progress" style="display: none;background: transparent;border: none;text-align: center;vertical-align:middle; line-height: 50px;padding-top: 10px">
 <img align="center" src="../assets/images/icon_animated_prog_dkgy_42wx42h.gif"></img>
 </div> !-->
           
     <?php
     }
         
     else if($action=="printvoucher"){ // on click supplier.js

         ?>
         <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">Reprint Voucher</legend>
       
        <table class="ordinal">  
        <tr><td>Payment Voucher (*):</td><td><input name="payvno" id="payvno"  class="formfield"></input></td><td><button name="reprintpv" id="reprintpv" class="formbuttons">Reprint</button></td></tr>
        </table>
             
          </fieldset>
  <?php
  
     }
         else if($action=="voucherreversal"){
 ?>
     
            <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">Payment Voucher Reversal</legend>
            <form method="post" action="">
        <table class="ordinal">  
            <tr><td>Payment Voucher No (*):</td><td><input name="vouchrno"  class="formfield" id="vouchrno"></input></td><td><?php echo $searchpvr; ?></td></tr>
        </table>
            </form>
                <div id="pymnt" style="display:none">
                    <form method="post" action="">
                    <table class="borders">
                        <tr><td> <input name="paymntnorv"  class="formfield" id="paymntnorv" type="hidden"></input><b>Payment.V No:</b></td><td id="paymntnoid"></td><td><b>Date:</b></td><td id="datepaymntid" style="width: 250px"></td></tr>
                        <tr><td colspan="1"><b>Supplier Name:</b></td><td colspan="1" id="namepaymntid" style="width: 250px"></td></tr>
                        <tr><td><b>Account</b></td><td id="incmepaymntid"></td><td><b>Amount:</b></td><td id="amntpaymntid"></td></tr>
                        <tr><td><b>Remarks</b></td><td colspan="2" style="height: 50px"><textarea style="width: 100%; height: 80%; border: none" id="rmkspymntid" name="rmkspymntid">
    </textarea></td><td><input type="submit"  value="Reverse" name="reversepvr" class="formbuttons" id="reversepvr"></input></td></tr>
                    </table></form>
                </div>
         
  <?php
  
     }else if($action=="editpayment"){
         if($priviledges[0]['admin']==1){
       ?>
                
            <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">Edit Payment Voucher</legend>
            <form method="post" action="">
        <table class="ordinal">  
            <tr><td>Payment Voucher No (*):</td><td><input name="editvouchrno"  class="formfield" id="editvouchrno"></input></td><td><input type="submit"  value="Search" name="searchpvr" class="formbuttons"></input></td></tr>
        </table>
            </form>
                <div id="suplrpymnt" style="display:none">
                    <form method="post" action="">
                    <table class="borders">
                        <tr><td> <input name="paymntnorv"  class="formfield" id="paymntnorv" type="hidden"></input><b>Payment.V No:</b></td><td id="paymntnoid"></td><td><b>Date:</b></td><td id="datepaymntid" style="width: 250px"></td></tr>
                        <tr><td colspan="1"><b>Supplier Name:</b></td><td colspan="1" id="namepaymntid" style="width: 250px"></td></tr>
                        <tr><td><b>Account</b></td><td id="incmepaymntid"></td><td><b>Amount:</b></td><td id="amntpaymntid"></td></tr>
                        <tr><td><b>Remarks</b></td><td colspan="2" style="height: 50px"><textarea style="width: 100%; height: 80%; border: none" id="rmkspymntid" name="rmkspymntid">
    </textarea></td><td><input type="submit"  value="Update" name="reve" class="formbuttons" id="reve"></input></td></tr>
                    </table></form>
                </div>
         
  <?php  
     }}
     else if($action=="paymentlist"){
     
     ?>
           
          <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">Payment Voucher List</legend> 
       <table  class="ordinal"> 
                   
                   
                   
                   <tr><td>From Date </td><td><input id="paymentssdate" name="paymentssdate"  value="<?php echo date('d-m-Y'); ?>" class="formfield"/></td><td>Supplier</td><td><select id="paymentsupplier"  class="formfield" name="paymentsupplier">
                               
                               
                           <?php
                      
                      $qrs2="SELECT * FROM suppliers WHERE estId LIKE '$id'";
                      
                      $datas2=$mumin->getdbContent($qrs2);
                      
                      
                       echo "<option value='ALL'>ALL</option>";
                    
                      
                      for($k=0;$k<=count($datas2)-1;$k++){
                          
                        
                          echo "<option value=".$datas2[$k]['supplier'].">".$datas2[$k]['suppName']."</option>";
                          
                          
                               
                      }
                      ?>                        
                               
                           </select></td></tr>
                 
           
           
           <tr><td>To Date </td><td><input  id="paymentsedate" name="paymentsedate" value="<?php echo date('d-m-Y'); ?>"   class="formfield"/></td>
                <td>Bank Acct:</td><td><select id="bnkacctyp" name="paymentsedate" value="<?php echo date('d-m-Y'); ?>"   class="formfield">
                            <?php
                                  echo "<option value='ALL'>ALL</option>";
                                $q="SELECT bacc,acname FROM bankaccounts WHERE deptid LIKE '$id'";
                                
                                $data=$mumin->getdbContent($q);
                                
                                 for($k=0;$k<=count($data)-1;$k++){ 
                      
                                     echo "<option value=".$data[$k]['bacc'].">".$data[$k]['acname']."</option>";
                                     
                                     
                                   }
                            
                            ?>        
                    </select></td></tr><tr><td></td><td><button id="viewpaymentslist" name="viewlist">View List</button></td><td></td><td></td></tr></table>
          
          </fieldset>
           <?php
           
     }
else if($action=="paymentslist"){
?>
              <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">All Payments</legend> 
       <table  class="ordinal"> 
                   
                   
                   
                   <tr><td>From Date </td><td><input id="paymentssdate" name="paymentssdate"  value="<?php echo date('d-m-Y'); ?>" class="formfield"/></td><td>Expense Account (*):</td><td><select id="expnacc" class="formfield">
                      <option value="all" selected="true">--All--</option>
                     <?php
                      
                      $qry="SELECT expnseaccs.id,expnseaccs.accname FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id  AND expenseactmgnt.deptid = '$id' GROUP BY expnseaccs.id ORDER BY accname asc";
                      
                      $data11=$mumin->getdbContent($qry);
                      
                      for($k=0;$k<=count($data11)-1;$k++){
                          
                          echo "<option value='".$data11[$k]['id']."'>".$data11[$k]['accname']."</option>";
                      }
                      ?> 
                      
                      
                  </select> 
              </td></tr>
                 
           
           
           <tr><td>To Date </td><td><input  id="paymentsedate" name="paymentsedate" value="<?php echo date('d-m-Y'); ?>"   class="formfield"/></td>
                <td>Cost Center :</td><td><input id="costcntre" type="text"   class="formfield"></input> 
             </td><td><input  type="hidden" readonly="readonly" id="costcntreid"/></td></tr><tr><td></td><td><button id="viewpaymntslist" name="viewlist">View List</button></td><td></td><td></td></tr></table>
          
          </fieldset>            
  <?php         
     }
    if(isset($_POST['searchpvr'])){ // Receipt Reversal
      if (empty($_POST['editvouchrno'])) {
    echo "<script> 
                    
                   $.modaldialog.warning('<br></br><b>Empty Field not allowed</b>', {
             timeout: 3,
             width:500,
             showClose: false,
             title:'Warning'
            });
 
            </script>";
  }else{
      $payvchrno=trim($_POST['editvouchrno']);
      
      $est_id=$_SESSION['dept_id'];;
      $timeStamp= date('Y-m-d H:i:s');
      $currntdte = date('Y-m-d');
   
      $rs=$mumin->getdbContent("SELECT * FROM  paytrans WHERE payno LIKE '$payvchrno' AND estId LIKE '$est_id' AND rev='0' AND recon = '0'");
     
      //$amount=intval($rs[0]['amount']);
      
     //$bankAccount=$rs[0]['bacc'];
      if($rs){
     $billsettld=$rs[0]['billsettled'];
     $billamnt=  number_format($rs[0]['amount'],2);
      $payno=$rs[0]['payno'];
      $pdate = date('d-m-Y',strtotime($rs[0]['pdate']));
	  $str = ltrim($payno, '0');
      $supplno = $rs[0]['supplier'];
      $rmks = $rs[0]['rmks'];
      $expname = $mumin->getdbContent("SELECT accname FROM expnseaccs WHERE id = '".$rs[0]['expenseacc']."' ");
              $expnsename = $expname[0]['accname'];
              $supnamee = $mumin->get_suplierName($supplno);
      echo "<script> 
                   $('#suplrpymnt').css('display','block');
                   $('#paymntnoid').html('$payvchrno');
                  $('#datepaymntid').html('$pdate');
                  $('#sablrecptid').html('$billsettld');
                  $('#amntpaymntid').html('$billamnt'); 
                  $('#incmepaymntid').html('$expnsename'); 
                  $('#namepaymntid').html('$supnamee');
                  $('#rmkspymntid').html('$rmks');
                  $('#editvouchrno').val('$payvchrno');
                  $('#paymntnorv').val('$payvchrno');
            </script>";
     
       // }
  }else{
      echo '<b>Voucher can not be Reversed</b>';
  }}}
  
  
  if(isset($_POST['reversepvr'])){ // Receipt Reversal
      
      $payvchrno=trim($_POST['paymntnorv']);
      
      $est_id=$_SESSION['dept_id'];
      $timeStamp= date('Y-m-d H:i:s');
      $currntdte = date('Y-m-d');
   
      $rs=$mumin->getdbContent("SELECT * FROM  paytrans WHERE payno LIKE '$payvchrno' AND estId LIKE '$est_id' AND rev='0' AND recon = '0'");
     
      //$amount=intval($rs[0]['amount']);
      
     //$bankAccount=$rs[0]['bacc'];
      if($rs){
     $billsettld=explode(",",$rs[0]['bills']);
     $billamnt=explode(",",$rs[0]['billamnt']);
     $paymntscenter = $rs[0]['costcentrid'];
      $payno=$rs[0]['payno']; 
	  $str = ltrim($payno, '0');
      $supplno = $rs[0]['supplier'];
      
    
$localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
          
          $q=$mumin->insertdbContent("INSERT INTO paytrans(estId, pdate, amount, pmode, payno, chqdet, chqno, rmks,supplier,tno,bacc,chequedate,ts,us,rev,billamnt,sector,expenseacc,bills,costcentrid) VALUES 
                            (".$rs[0]['estId'].",'$currntdte',"."-".$rs[0]['amount'].",'".$rs[0]['pmode']."', 'R".$rs[0]['payno']."','".$rs[0]['chqdet']."','".$rs[0]['chqno']."','".$rs[0]['rmks']."','".$rs[0]['supplier']."',' ','".$rs[0]['bacc']."',".$rs[0]['chequedate'].",'".$timeStamp."','".$rs[0]['us']."',1,'".$rs[0]['billamnt']."','$localIP','".$rs[0]['expenseacc']."','".$rs[0]['bills']."','$paymntscenter')");
            if($q){ 
          $qq=$mumin->updatedbContent("UPDATE paytrans SET rev=1 WHERE payno LIKE '$payvchrno' AND estId LIKE '$est_id'");
          //$qry5=$mumin->updatedbContent("UPDATE estate_invoice SET recpno =0, pdamount= 0 WHERE recpno LIKE '$recpno' AND estId LIKE '$est_id'");      
           for($i=0;$i<=count($billamnt)-1;$i++){
                        $qry5=$mumin->updatedbContent("UPDATE bills SET payno =0, pdamount= pdamount-$billamnt[$i] WHERE docno LIKE '$billsettld[$i]' AND estate_id LIKE '$est_id' AND supplier = '$supplno' AND costcentrid = '$paymntscenter'");

                    }
                        
      echo "<script> 
                    
                   $.modaldialog.success('<br></br><b> Payment Voucher No ".$payno." Reversal Succesfull</b>', {
             timeout: 3,
             width:500,
             showClose: false,
             title:'Complete'
            });
 
            </script>
          <font color='green'><br><b>Payment Voucher No ".$payno." Reversal Succesfull </b></font>"; 
            }
          else{
              
              echo "<font color='red'>Payment Voucher cannot be Reversed - CONTACT ADMIN</font>"; 
          }
  
          
       // }
  }else{
       echo "<script> 
                    
                   $.modaldialog.warning('<br></br><b> Voucher no: ".$payno." can not be Reversedl</b>', {
             timeout: 3,
             width:500,
             showClose: false,
             title:'Complete'
            });
 
            </script>
          "; 
      echo '<font color="red"><b>Voucher can not be Reversed</b></font>';
  }}      
           ?>
           
           
           
       </div>    
           
  </div>
      
      
      
      
          </div> 
      
  </div>
    
    
  </div>
     <?php include 'footer.php' ?>
</div>
    <div id="d_progress" style="display: none;background: transparent;border: none;text-align: center;vertical-align:middle; line-height: 50px;padding-top: 10px">
 <img align="center" src="../assets/images/icon_animated_prog_dkgy_42wx42h.gif"></img>
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
<?php } ?>