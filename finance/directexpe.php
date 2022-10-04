<?php
session_start();  
 
if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
    $level=$_SESSION['jmsacc'];
    
    $id=$_SESSION['dept_id'];
//die($id);
    $userid = $_SESSION['acctusrid'];
    if($level>999){
  
        header("location: ../index.php"); 
        
    }
    else{
   
include 'operations/Mumin.php';

$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE userid = '$userid' AND deptid = '$id' LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);

if($priviledges[0]['directexp']!=1){
   
header("location: index.php");

}
if($priviledges[0]['readonly']==1){
    $passdirectexp = '';
     $searchdrctexp = '';
}else if($priviledges[0]['readonly']!=1){
    $passdirectexp = '<button id="passdirectexp" class="formbuttons" >Create</button>';
    $searchdrctexp = '<input type="submit" class="buttons" value="search" name="searchdrctexp"/>';
   }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head>
<title>Direct Expense</title>
    
 
<?php
date_default_timezone_set('Africa/Nairobi');
include '../partials/stylesLinks.php';  

 
include 'links.php';


?>
<link rel='stylesheet' type='text/css' href='properties/js/print.css' media="print" />
    <script>
    $(function() {
        
     var costcentrs=[];
    	var clsingdate = $("#clsingdate" ).val();
      $("#jvdate2" ).datepicker({ dateFormat: 'dd-mm-yy',minDate: parseInt(clsingdate)+parseInt(1)} );
        
  $("#ckdte2" ).datepicker({ dateFormat: 'yy-mm-dd'} );
    
 
$( "#directstartdate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#directenddate" ).datepicker( "option", "minDate", selectedDate );
}
});
$( "#directenddate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#directstartdate" ).datepicker( "option", "maxDate", selectedDate );
}
}); 




  
   $("#printjv").button({
            icons: {
                primary: "ui-icon-print"
                
            }
        });
        
         $("#newjv").button({
            icons: {
                primary: "ui-icon-document"
                 
            }
        });
    
     $("#passjv").button({
            icons: {
                primary: "ui-icon-document"
                 
            }
        });
         
        $("#jvlist").button({
            icons: {
                primary: "ui-icon-bookmark"
                
            }
        });
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
      
     $.getJSON("../finance/redirect.php?action=costc", function(data) {
   
    $.each(data, function(i,item) {
       
    costcentrs.push({label: item.centrename,value: item.cntrid});  
        
      
  
       $("#cstcenter" ).autocomplete({
            source: costcentrs,
         //   minLength: 1,
            focus: function(event, ui ) {
             event.preventDefault();
            $(this).val(ui.item.label);
        },
            select: function(event, ui) {
	event.preventDefault();
	$(this).val(ui.item.label);
         $("#cstcntreid").val(ui.item.value);
				}
        
     
  });
     }); 
      });
    });
 
</script>
<link rel='stylesheet' type='text/css' href='properties/js/print.css' media="print" />
<link rel="stylesheet" href="../assets/css/jquery-ui.css" />
 <!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />-->
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
         
        height: 35px;
        background: transparent;
        
        color: black;
        font-size: 12px;
         
        text-align: left;
        vertical-align: middle;
        line-height: 35px;
       
        
        
    }
     #div_fromAccount{
        
        height: 35px;
        background:  transparent;
        z-index: 10;
        text-align: left;
        vertical-align: middle;
        line-height: 35px;
        color: black;
        font-size: 12px;
         
         
        
        
    }
      
    </style>
    
</head>
   
<body style="overflow-x: hidden;"> 
 
 <div id="div_pagecontainer">
    <div id="div_pageheader">
  	<div id="div_orglogo"><img src="../assets/images/smallhomegoldlogo.png" width="80" height="84" alt="Mombasa Jamaat Home"/></div>
    <div id="div_orgname">
    	<h1 class="titletext"> </h1>
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
      	
        <div id="div_formcontainer">
            
        <div id="tabs2">
    
    <?php
        
        $action=$_GET['action'];
        
        if($action=="new"){
            
            ?>
          <fieldset style="border: 1px ghostwhite solid;margin: 10px;color: black;font-size: 15px;font-weight: bold"> 
            <legend>New Direct Expense</legend>
            <table  class="ordinal">
            
           
                <tr><td>Date :</td><td><?php
                                 
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
		<input id="jvdate2" value="<?php echo date('d-m-Y')?>" name="jvdate"  class="formfield" readonly="true"></input></td><td></td></tr>
                        
                   <!--  <tr><td></td><td><div id="div_fromAccount"></div></td><td></td></tr>-->
              <tr><td>From:</td><td id="crdtexp" style="display:block">
                                      <select name="jvto"  id="jvto" class="formfield">
                        <option value="">-- Bank Acct --</option>
                        <?php
                                
                                $q="SELECT bacc,acname,acno FROM bankaccounts WHERE deptid LIKE '$id' ";
                                 
                                $data9=$mumin->getdbContent($q);
                                
                                 for($k=0;$k<=count($data9)-1;$k++){ 
                      
                                     echo "<option value=".$data9[$k]['bacc'].">".$data9[$k]['acname'].": ".$data9[$k]['acno']."</option>";
                                     
                                     
                                   }
                            
                            ?>       
                    </select>
                  </td><td id="datelabel2" hidden>Cheque Date:&nbsp;</td><td id="dateinpt2" hidden><input id="ckdte2" type="text" class="formfield" readonly></input></td></tr>
                <tr id="typebank2" hidden><td>Cheque No:&nbsp;*</td><td><input id="chkno2" type="text" class="formfield"></input></td>
                    <td>Cheque details:&nbsp;*</td><td><input id="chkdetails2" type="text" class="formfield"></input></td></tr>

                <tr><td>To :</td><td id="dbtexp" style="display:block">
                                    <select name="jvfrom" id="jvfrom" class="formfield">
                    <option value="">-- Expense Account --</option>
                <?php
                                $inqry="SELECT expnseaccs.id,expnseaccs.accname FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id AND expenseactmgnt.deptid = '$id' GROUP BY expnseaccs.id";
                                
                                $data2=$mumin->getdbContent($inqry);
                                
                                 for($h=0;$h<=count($data2)-1;$h++){
                      
                                     echo "<option value=".$data2[$h]['id'].">".$data2[$h]['accname']."</option>";
                                   } 
                            
                            ?>
                
                </select>
                    
                    </td>
                       <td hidden="true"><input id="mysector" value=""></input></td>
                    </tr>
            <!--<tr><td></td><td><div id="div_toAccount"></div></td><td></td></tr>-->
             <tr><td>Cost Center :</td><td><input id="cstcenter" value=""  name="cstcenter"  class="formfield"></input></td><td><input  type="hidden" readonly="readonly" id="cstcntreid"/></td></tr>

                <tr><td>Amount :</td><td><input id="dxamount" value=""  name="jvamount"  class="amount"></input></td><td></td></tr>
          
            <tr><td>Remarks :</td><td><textarea id="dxrmks" name="jvrmks" class="formfield"></textarea></td><td></td></tr>
            <tr><td></td><td><?php echo $passdirectexp; ?></td><td></td></tr>
            
            
        </table>
     <!--  </form>!-->
          </fieldset>
        <?php
        }
        
        ?>
        <?php
        
        if($action=="modify"){
            
            ?><fieldset style="border: 1px blueviolet solid;margin: 10px;color: black;font-size: 15px;font-weight: bold"> 
                 <legend>Direct Expense Reversal</legend>
        <form method="post" action="">
        <table class="ordinal">  
            <tr><td>Direct Expense No :</td><td><input name="expenseno" class="formfield"></input></td><td><?php echo $searchdrctexp; ?></td></tr>
            
            
        </table>
        </form></fieldset>
        <?php
        }
        ?>
        
          <?php
        
        if($action=="print"){
            
            ?>
          <fieldset style="border: 1px ghostwhite solid;margin: 10px;color:black;font-size: 15px;font-weight: bold"> 
            <legend>Print Direct Expense Voucher </legend>
              <form method="post" action="">
        <table class="ordinal" style="width: 500px;float: left">  
            <tr><td>Direct Expense No :</td><td><input name="getdrctv" class="formfield"></input></td><td><input type="submit" value="Search" class="formbuttons" name="searchingdrctv"></input></td></tr>
           
        </table>
           </form>
          </fieldset>
             
        <?php
        }
        ?>
       <?php
        
        if($action=="list"){
            ?>
           
              <fieldset style="border: 1px ghostwhite solid;margin: 1px;color: black;padding-left: 5px;font-size: 15px;font-weight: bold"><legend>Direct Expense List</legend><form  action="" method="post"> 
               
           <table style="width: 650px;float: left" class="ordinal"> 
                   
                   
                   
               <tr><td>From Date :</td><td><input id="directstartdate" name="directstartdate"  value="<?php echo date('d-m-Y'); ?>" class="formfield"/></td>
               <td>To Date :</td><td><input  id="directenddate" name="directstartdate" value="<?php echo date('d-m-Y'); ?>"   class="formfield"/></td></tr>
                   <tr>
                       <td>Expense Account :</td><td>
                           <select id="drctxpnse" class="formfield">
                              <option value="ALL">-- ALL --</option>
                <?php
                      
                      $qry="SELECT expnseaccs.id,expnseaccs.accname FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id  AND expenseactmgnt.deptid = '$id' GROUP BY expnseaccs.id";
                      
                      $data11=$mumin->getdbContent($qry);
                      
                      for($k=0;$k<=count($data11)-1;$k++){
                          
                          echo "<option value='".$data11[$k]['id']."'>".$data11[$k]['accname']."</option>";
                      }
                      ?> 
                           </select>
                       </td>
                   </tr>
                       
                   <tr><td></td><td><input name="viewjvlist" type="submit" id="dexpenselist" value="View list"></input></td><td></td><td></td></tr></table></form></fieldset>
    
       
          
        <?php
        }
        ?>
        
   <?php
  
  if(isset($_POST['searchdrctexp'])){ // Receipt Reversal
      if (empty($_POST['expenseno'])) {
    echo "<script> 
                    
                   $.modaldialog.warning('<br></br><b>Empty Field not allowed</b>', {
             timeout: 3,
             width:500,
             showClose: true,
             title:'Warning'
            });
 
            </script>";
  }else{
      $dirctpno=trim($_POST['expenseno']);
      
      $est_id=$_SESSION['dept_id'];
      $timeStamp= date('Y-m-d H:i:s');
      $currntdte = date('Y-m-d');
      $us = $_SESSION['jname'];
       $localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
      $rs=$mumin->insertdbContent("INSERT INTO directexpense (SELECT '' as jid,'R$dirctpno' as dexpno ,(current_date()) as dexpdate,rmks,cacc,dacc,amount,chqdate,chqno,chqdet,'1' as revsd, '$timeStamp' as ts, '$us' as us, '$localIP' as sector,estate_id,costcentrid,recon FROM directexpense WHERE dexpno = '$dirctpno' AND estate_id = '$est_id' AND revsd = '0' AND recon = '0')");
     if ($rs){
     $dataString1=$mumin->updatedbContent("UPDATE directexpense SET revsd=(revsd+1) WHERE dexpno = '$dirctpno' AND estate_id = '$est_id' AND revsd = '0' AND recon = '0'");
        }
            
           
      If ($rs){
        
          echo "<script> 
                    
                   $.modaldialog.success('<br></br><b>Direct Expense Reversal Succesfull</b>', {
             timeout: 3,
             width:500,
             showClose: false,
             title:'Complete'
            });
                $('#recpnorev').val('');
            </script>
          <font color='green'>Direct Expense Reversal Succesfull </font>"; 
            }
          else{
              echo "<script> 
                    
                   $.modaldialog.warning('<br></br><b>Direct Expense could not be Reversed - Contact Admin</b>', {
             timeout: 3,
             width:500,
             showClose: false,
             title:'Warning'
            });
                $('#recpnorev').val('');
            </script>";
        
          }
  
          }
            
       // }
  }
  
  ?>
                    
          
  <?php
                  
          
          
         if(isset($_POST['searchingdrctv'])){
            
             $drjv=$_POST['getdrctv'];
             if($drjv==''){
                 echo "<script>
                  $.modaldialog.error('<b>Please input a J.V Number</b>', {
          title: 'Error occured',
          showClose: true
          });
                    </script>";
             }else {
               
               $q="SELECT * FROM directexpense WHERE dexpno = '$drjv' AND estate_id = '$id' AND revsd = '0' LIMIT 1";  
               
               $data=$mumin->getdbContent($q);
               
               if($data){
              
              echo"<script>window.location.href='directexpreview.php?dexpdate=".$data[0]['dexpdate']."&expensacc=".$data[0]['dacc']."&crdtacc=".$data[0]['cacc']."&dxamount=".$data[0]['amount']."&remks=".$data[0]['rmks']."&dexpvno=".$drjv."&ckdte=".$data[0]['chqdate']."&chkno=".$data[0]['chqno']."&chkdetails=".$data[0]['chqdet']."&cstcntreid=".$data[0]['costcentrid']."';</script>";
                 }
               else{  
                                 echo "<script>
                  $.modaldialog.error('<b>J.V Number not found </b>', {
          title: 'Error occured',
          showClose: true
          });
                    </script>";
               }
           }}
            ?>

      
      
      
      
      
      
  
  </div>
    
        </div>
          </div>
    </div>
  </div>
      <?php include 'footer.php' ?>
   <div id="d_progress" style="display: none;background: transparent;border: none;text-align: center;vertical-align:middle; line-height: 50px;padding-top: 10px">
     <img align="center" src="../assets/images/icon_animated_prog_dkgy_42wx42h.gif"></img>
 </div> 
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