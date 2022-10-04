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
if($priviledges[0]['deposits']!=1){
   
header("location: index.php");
}
if($priviledges[0]['readonly']==1){
    $displ = 'display: none';
}else if($priviledges[0]['readonly']!=1){
    $displ = '';
}
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head>
<title>Deposits | Jamaat  Information System</title>
    
 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';
 

?>
     
<script>
    
    
$(function() {
    var clsingdate = $("#clsingdate" ).val(); 
   
      // DataTable configuration
  $('#sortablereceipt').dataTable( {
	"bSort": false,
	// "sPaginationType": "full_numbers",
	"iDisplayLength": 25,
	"aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
	"bJQueryUI": true
  } );
    
 
   
 $("#tabs").tabs(); 
   
  
$( "#atdate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
});
  

     
    // $("#dt100" ).datepicker({ dateFormat: 'dd-mm-yy', minDate: parseInt(clsingdate)+parseInt(1)} );
     // $("#paymentdt100" ).datepicker({ dateFormat: 'dd-mm-yy', minDate: parseInt(clsingdate)+parseInt(1)} );
     $("#ckdate100" ).datepicker({ dateFormat: 'dd-mm-yy'} );
   $("#deporeprintdate" ).datepicker({ dateFormat: 'dd-mm-yy',changeMonth: true} );
   $("#invprint201").button({
            icons: {
                primary: "ui-icon-check",
                secondary: "ui-icon-print" 
            }
        });
    
     $("#ckreceipt").button({  
            icons: {
                primary: "ui-icon-check",
               // secondary: "ui-icon-cart" 
            }
        });
        
        $("#choosedebtorgo").button({  
            icons: {
                primary: "ui-icon-check",
                //secondary: "ui-icon-cart" 
            }
        });
   
     $("#cshreceipt").button({
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
    
   
 
  $("#muminejnos" ).autocomplete({
            source: ejamaatNos
  });
  
  
   
  
    $("#muminejno" ).autocomplete({
            source: ejamaatNos
  });
 
   $("#viewlist").button({
            icons: {
                primary: "ui-icon-document"
                 
            }
      });
      
        $("#sub-menu").css("display","block");
  
  $("#reprintdepo").click(function(){
      var depodate = $("#deporeprintdate").val();
      var incmeacct = $("#incmeacct2").val();
      var $urlString = window.open('../finance/reprintdeposit.php?sdate='+depodate+'&acct='+incmeacct,'_self','width=1300,height=800,toolbar=0,menubar=1,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');

      
      $.ajax({                                                                        
                
                url: $urlString,
                
                type: "GET",
                
                dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
                            
                success: function(response) {
                   
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              });      
      
      
      
    });
      $("#reprintdepno").click(function(){
      var depsitno = $("#depsitno").val();
      
      var $urlString = window.open('../finance/depositnoreprint.php?depsitno='+depsitno,'_self','width=1300,height=800,toolbar=0,menubar=1,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');

      
      $.ajax({                                                                        
                
                url: $urlString,
                
                type: "GET",
                
                dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
                            
                success: function(response) {
                   
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              });      
      
      
      
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
         color: #FFF;
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
	</style>
   

 
</head>
   
<body style="overflow-x: visible!important;"> 
  
    <?php
    
                              
                                
                                $id=$_SESSION['dept_id'];
                                
                                $qr11="SELECT deptname FROM department WHERE deptid LIKE '$id' LIMIT 1";
                               
                                 $data11=$mumin->getdbContent($qr11);
                                
                                 $estname=$data11[0]['deptname'];
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
  	<div id="div_logindetails" ><div>You are logged in as: <?php echo $_SESSION['jname'];?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp</span></div>
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
        	<h3 class="titletext"></h3>
                <div id="gallerydisp" style="display: none;float: right"><button class="btncls" >Mumin Search</button></div>
                                        <div id="gallery" >
   <table>
       <tr><td style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;<b>Name:</b></td><td style="width: 230px"><img src="images/cross.png" align="right" id="closegallery"></img></td></tr>
       <tr><td><input type="text" class="texinput" id="namesrch" placeholder="--- First name ---"></input></td>
           <td><input type="text" class="texinput" id="snamesrch" placeholder="---  Surname ---"></input></td></tr>
   </table>
    <div id="phts" style="width: 400px;">
        
    </div>
</div>
        </div>
        <div id="div_formcontainer">
        	<div id="tabs2">

     <?php 
     
     @$type=$_GET['type'];
     
     
     if($type==""){
         
        echo "<font color='green'>&laquo;&nbsp;Use the left menu panel options to navigate through Deposit module</font>" ;
         
         
     }
     else if($type=="error"){
         
         
         echo "<font color='red'>The receipt NOT AVAILABLE </font>";
         
     }
     
     else if($type=="notdeposited"){
         
     ?>    
       
         
             <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">Undeposited Receipts</legend>
           <table  class="ordinal"> 
                   
                   
                   
                   <tr><td>As at :</td><td><input id="atdate" name="atdate"   class="formfield" value="<?php echo date('d-m-Y');?>"/></td><td>Mode :</td><td><select id="pymd" class="formfield"  name="pymd"><option value="CASH">CASH</option><option value="CHEQUE">CHEQUE</option></select></td></tr>
                   <tr><td></td><td><button class="formbuttons" id="viewdlist">View List</button></td><td></td><td></td></tr></table> 

                           </fieldset>
         
         <?php
     }
     
     else if($type=="new"){
     
     
     }
     
     else if($type=="printdeposit"){

         ?>
         <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">Reprint Deposit</legend>
       
            <table class="ordinal">
               <tr><td><input type="radio" name="add" value="depno" id="depositno" checked="true" ><b>&nbsp&nbspDeposit No</b></input> 
                       </td><td><input type="radio" name="add" value="depdate" id="depositdate" ><b>&nbsp&nbspDate &nbsp&nbsp</b></input></td></tr>

            </table>
            <table class="ordinal" id="bydepono" >
              <tr ><td width="150px">Deposit No (*):</td><td><input name="depsitno" id="depsitno"  class="formfield"></input></td></tr>
              <tr> <td colspan="2"><button id="reprintdepno" class="formbuttons">Find</button></td></tr>
        </table>
            <table class="ordinal" id="bydepodate" style="display: none">
                <tr><td width="150px">Date :</td><td><input name="deporeprintdate" id="deporeprintdate"  value="<?php echo date('d-m-Y');?>"  class="formfield"></input></td>
                <td><select  class="formfield" id="incmeacct2" > <option value="all">--Select--</option>'; 
                              <?php
                                $iqry="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id'"; 
                            
                                $data6=$mumin->getdbContent($iqry);
                                
                                 for($h=0;$h<=count($data6)-1;$h++){
                      
                                     echo "<option value=".$data6[$h]['incacc'].">".$data6[$h]['accname']."</option>";
                                   } 
                    ?>
</select> </td></tr>
                <tr><td colspan="2"><button id="reprintdepo"  class="formbuttons"> Search </button></td></tr>
        </table>
            
                </fieldset>
  <?php
  
     }
    else if($type=="reversal"){
 ?>
     
            <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">Receipt Reversal</legend>
            <form method="post" action="">
        <table class="ordinal">  
            <tr><td>Receipt No (*):</td><td><input name="recpnorev"  class="formfield" id="recpnorev" value='<?php if(!isset($_POST['rcptsearch'])){ echo " "; }else{ echo $_POST['recpnorev'];}?>'></input></td><td><button name="rcptsearch" id="rcptsearch"> Search</button></td></tr>
        </table>
            </form>
                <div id="rcpt" style="display:none">
                    <form method="post" action="">
                    <table class="borders">
                        <tr><td> <input name="recpnorv"  class="formfield" id="recpnorv" type="hidden"></input><b>Receipt No:</b></td><td id="recptnoid"></td><td><b>Date:</b></td><td id="daterecptid" style="width: 250px"></td></tr>
                        <tr><td><b>Sabilno:</b></td><td id="sablrecptid"></td><td><b>Name:</b></td><td id="namerecptid" style="width: 250px"></td></tr>
                        <tr><td><b>Account</b></td><td id="incmerecptid"></td><td><b>Amount:</b></td><td id="amntrecptid"></td></tr>
                        <tr><td><b>Remarks</b></td><td colspan="2" style="height: 50px"><textarea style="width: 100%; height: 100%; border: none" id="rmksrecptid" name="rmksrecptid">
    </textarea></td><td><input type="submit"  value="Reverse" name="reversego" class="formbuttons" id="reversego"></input></td></tr>
                    </table></form>
                </div> 
            </fieldset>
  <?php
  
     }
 ?>
   
  <?php
  if (isset($_POST['rcptsearch'])){
      if (empty($_POST['recpnorev'])) {
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
          $recpno=trim($_POST['recpnorev']);
          $est_id=$_SESSION['dept_id'];
          $rlt=$mumin->getdbContent("SELECT * FROM  recptrans WHERE recpno LIKE '$recpno' AND est_id LIKE '$est_id' AND rev='0' AND recon='0' LIMIT 1");
                    If ($rlt){
              $sabiltno = $rlt[0]['sabilno'];
              $amount = number_format($rlt[0]['amount'],2);
               $ejno = $rlt[0]['hofej'];
              $rmks = $rlt[0]['rmks'];
              $dbrcptno = $rlt[0]['recpno'];
              $rdate = date('d-m-Y',strtotime($rlt[0]['rdate']));
              $inctname = $mumin->getdbContent("SELECT accname FROM incomeaccounts WHERE incacc = '".$rlt[0]['incacc']."' ");
              $incomename = $inctname[0]['accname'];
              $muminme = $mumin->get_MuminNames($ejno);
              
              echo "<script> 
                   $('#rcpt').css('display','block');
                   $('#recptnoid').html('$recpno');
                  $('#daterecptid').html('$rdate');
                  $('#sablrecptid').html('$sabiltno');
                  $('#amntrecptid').html('$amount'); 
                  $('#incmerecptid').html('$incomename'); 
                  $('#namerecptid').html('$muminme');
                  $('#rmksrecptid').html('$rmks');
                  $('#recpnorv').val('$dbrcptno');
            </script>";
          }
      }
  }
  
  if(isset($_POST['reversego'])){ // Receipt Reversal
          
      $recpno=trim($_POST['recpnorv']);
      $rmks = trim($_POST['rmksrecptid']);
      $est_id =$_SESSION['dept_id'];
      $timeStamp= date('Y-m-d H:i:s');
      $currntdte = date('Y-m-d');
  
      $rs=$mumin->getdbContent("SELECT * FROM  recptrans WHERE recpno LIKE '$recpno' AND est_id LIKE '$est_id' AND rev='0' AND recon='0'");
           
      If ($rs){
        
    $invoicesettled=$rs[0]['invoicesettled'];
     $invoiceamt=$rs[0]['invceamnt'];
      $payno=$rs[0]['recpno']; 
      $statid = $rs[0]['est_id'];
        // Two entries found -meaning that receipt has  a duplicate, most probably it has been reversed
          
          $q=$mumin->insertdbContent("INSERT INTO recptrans(est_id, rdate, amount, pmode, recpno, chqdet, chqno,chequedate, rmks, hofej, tno, sabilno, incacc, bacc, dno, ts, us, rev,invoicesettled,sector) VALUES 
                            ('$statid','$currntdte','"."-".$rs[0]['amount']."','".$rs[0]['pmode']."', 'R".$rs[0]['recpno']."','".$rs[0]['chqdet']."','".$rs[0]['chqno']."','".$rs[0]['chequedate']."','".$rmks."','".$rs[0]['hofej']."',0,'".$rs[0]['sabilno']."','".$rs[0]['incacc']."','".$rs[0]['bacc']."','".$rs[0]['dno']."','$timeStamp','".$rs[0]['us']."',1,'".$rs[0]['invoicesettled']."','".$rs[0]['sector']."')");
            if($q){ 
               
          $qq=$mumin->updatedbContent("UPDATE recptrans SET rev=1 WHERE recpno = '$recpno' AND est_id = '$est_id'");
          $qry5=$mumin->updatedbContent("UPDATE invoice SET recpno =0, pdamount= 0 WHERE recpno LIKE '$recpno' AND estId LIKE '$est_id' AND isinvce = '1'");      
          if($invoicesettled){
                    
                    $qry6=$mumin->updatedbContent("UPDATE invoice SET recpno =0, pdamount= pdamount-$invoiceamt WHERE invno LIKE '$invoicesettled' AND estId LIKE '$est_id' AND isinvce = '1'");
                }
                
                else{
          $qry6=$mumin->updatedbContent("UPDATE invoice SET recpno =0, pdamount=0 WHERE recpno LIKE '$payno' AND estId LIKE '$est_id' AND isinvce = '1'");    
                }
      echo "<script> 
                    
                   $.modaldialog.success('<br></br><b>Receipt No: $payno  Reversal Succesfull</b>', {
             timeout: 3,
             width:500,
             showClose: false,
             title:'Complete'
            });
                $('#recpnorev').val('');
            </script>
          <font color='green'>Receipt No: $payno Reversal Succesfull </font>"; 
            }}
            
          else{
              echo "<script> 
                    alert ('$recpno');
                   $.modaldialog.warning('<br></br><b>Receipt Reversal Failed - Contact Admin</b>', {
             timeout: 3,
             width:500,
             showClose: true,
             title:'Warning'
            });
                $('#recpnorev').val('');
            </script>";
        
          }
    }
  
  ?>

</div>
           </div>
        </div>
        
      </div>

    </div>
    <!--Right Panel Ends Here-->
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