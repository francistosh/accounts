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
if($priviledges[0]['receipts']!=1){
   
header("location: index.php");
}
if($priviledges[0]['readonly']==1){
    $displ = '';
     $rcptsearch = '';
     $recpsearch = '';
     $pdsubmit = '';
}else if($priviledges[0]['readonly']!=1){
    $displ = '<button id="ckreceipt"><b>Generate Receipt</b></button>';
    $pdsubmit = '<button id="pdsubmit"><b>Generate PD</b></button>';
    $rcptsearch = '<button name="rcptsearch" id="rcptsearch"> Search</button>';
    $recpsearch = '<button name="recpsearch" id="recpsearch"> Search</button>';
}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head>
<title>Receipts | Jamaat  Information System</title>
    
 
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
   
  
$( "#sdate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#edate" ).datepicker( "option", "minDate", selectedDate );
}
});
$( "#edate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#sdate" ).datepicker( "option", "maxDate", selectedDate );
}
});
   
   
     $("#oc" ).datepicker({ dateFormat: 'yy-mm-dd'} );
      $("#daterecpnoid").datepicker({ dateFormat: 'dd-mm-yy'} );
      $("#recpchqdate").datepicker({ dateFormat: 'dd-mm-yy'} );
        $(".datepicker").datepicker({dateFormat: 'dd-mm-yy',minDate: parseInt(clsingdate)+parseInt(1) });
      $("#paymentdt100" ).datepicker({ dateFormat: 'dd-mm-yy', minDate: parseInt(0),maxDate:parseInt(1)} );
       $("#cashdt100").datepicker({ dateFormat: 'dd-mm-yy', minDate:0,maxDate:parseInt(1)} );
     $("#ckdate100").datepicker({ dateFormat: 'dd-mm-yy'} );
   $("#pdchqdate1").datepicker({ dateFormat: 'dd-mm-yy',minDate:1} );
   $("#pdchqdate2").datepicker({ dateFormat: 'dd-mm-yy',minDate:1} );
   $("#pdchqdate3").datepicker({ dateFormat: 'dd-mm-yy',minDate:1} );
   $("#pdchqdate4").datepicker({ dateFormat: 'dd-mm-yy',minDate:1} );
   $("#pdchqdate5").datepicker({ dateFormat: 'dd-mm-yy',minDate:1} );
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
        
        $("#pdsubmit").button({  
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
      
      $('.amount') .change(function(e) {
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
    
    
    $('#incmerecpnoid').click(function(){
        
    alert ('Can not change');
    });
    
    $('#cancelrcpty').click(function(){
        
    $("#rcpt_rqst").dialog("destroy");
    });
    
    
    
  $('#updatercpty').click(function(){
       
     var  recpnonumber = $('#recpnomodfy').val();
       var $sabin= $('#sabrecpnoid').val();
      var  $itsno = $('#recpits').val();
      var   $incmeid = $('#incmerecpnoid').val(); 
      var   $date=  $('#daterecpnoid').val();           
      var   $amntid = $('#amntrecpnoid').val(); ;
      var   $rmksrecpt = $('#rmksrecpid').val();
      var   $paymode =  $('#recptpmode').val();
      var   $chqdate =  $('#recpchqdate').val();
      var   $chqno =  $('#recpchqno').val();
      var   $chqdetls =   encodeURIComponent($('#recochqdetls').val());
      var $docnumbers = "";
      var $individualamount = "";
      var $linkedamounts = "";
      
           for(var j=0; j<= $(".sablaffectedinvces").length-1;j++){
          var flnkdamnt = parseFloat(document.getElementById("linkdinvceamnt"+j).innerHTML.replace(/[^0-9\.]+/g,""));
          //alert(flnkdamnt);
           if(flnkdamnt != 0 && $("#editedamnt"+j).val() >= 0 ){
           var $docnos= document.getElementById("pinvn"+j).innerHTML;
           
           $docnumbers+=$docnos+",";
           var $iamount1 = $("#editedamnt"+j).val().replace(/[^0-9\.]+/g,"");
           $individualamount+=$iamount1+",";
            var $linkedamount =parseFloat(document.getElementById("linkdinvceamnt"+j).innerHTML.replace(/[^0-9\.]+/g,""));
           $linkedamounts+=$linkedamount+",";
           
          
           } else if(flnkdamnt == 0 && $("#editedamnt"+j).val() > 0 ){
              var $docnos=document.getElementById("pinvn"+j).innerHTML;
                $docnumbers+=$docnos+",";
           var $iamount1 = $("#editedamnt"+j).val().replace(/[^0-9\.]+/g,"");
           $individualamount+=$iamount1+",";
            var $linkedamount =parseFloat(document.getElementById("linkdinvceamnt"+j).innerHTML.replace(/[^0-9\.]+/g,""));
           $linkedamounts+=$linkedamount+",";
          
            }
            
     }
           
            var $urlString = "../finance/receipting.php?action=updtereceipts&rdate="+$date+"&incmeid="+$incmeid+"&sabin="+$sabin+"&amount="+$amntid+"&rmksrecpt="+$rmksrecpt+"&itsno="+$itsno+"&paymode="+$paymode+"&chqdate="+$chqdate+"&chqno="+$chqno+"&chqdetls="+$chqdetls+"&rcptno="+recpnonumber+"&invcenumbrs="+$docnumbers+"&invoiceamnt="+$individualamount+"&adjustfig="+$linkedamounts;
            
   
 $.ajax({                                                                        
                
                url: $urlString,
                
                type: "GET",
                
                //dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
               //data:$dataString,
                
                success: function(response) {
                       
                
                if(response.id == '1'){
$.modaldialog.success('<br></br><b>Update Successful</b>', {
             timeout: 3,
             width:500,
             showClose: true,
             title:'Successful Update'
            });
           $("#rcpt_rqst").dialog("destroy");
           $("#recpmod").css('display','none');
            $("#mdfyrecp").val('');
              $("#invcetble").fadeOut("slow");
                }
                
                else{
                    
                    $.modaldialog.warning('<br></br><b>Update not Successful</b>', {
             timeout: 3,
             width:500,
             showClose: true,
             title:'Error'
            });
                }
               
                },
                error:function (xhr, ajaxOptions, thrownError){
                    
                 
                 
                 alert(ajaxOptions);
                   
                },
                beforeSend:function(){
                    
                
                
                }
                 
  });
      
      
      
   });
   
$('#recplogsearch').click(function(){

    var $rcptnolog = $("#recplog").val();
            if( $rcptnolog ==""){
           
           $.modaldialog.warning("<br></br><b>Receipt No is Blank</b>", {
             width:400,
             showClose: true,
             title:"Missing Data!!!"
            });
        //  $("#d_progress").dialog("destroy");
        } else {
        $("#depsiton").val("");
                   $("#depsitno").val("");
                   $("#status").val("");
                   $("#bnkacct").val("");
                   $("#createdby").val("");
     $.getJSON("../finance/receipting.php?action=getreceiptnolog&rcptno="+$rcptnolog, function(data) {
                if(data[0]['depots']=="00-00-0000 12:00"){
                    $("#depsiton").val("Not Deposited");
                }else{
                    $("#depsiton").val(data[0]['depots']);
                }
                   $("#depsitno").val(data[0]['depositno']);
                   $("#status").val(data[0]['status']);
                   $("#bnkacct").val(data[0]['acctname']);
                   $("#createdby").val(data[0]['user']);
                    $("#rcptstatus").val(data[0]['rcptstat']);
                    $("#linkedinvces").empty();
                    $("#linkedinvces").append('<tr><th>Invoice No:</th><th>Invoice Amount:</th></tr>');
               
                   var arrayinvces = data[0]['invoices'].split(",");
                   var arrayamnts = data[0]['invceamnt'].split(",");
                   var invamnt = 0;
                  for (var i=0;i<arrayamnts.length-1;i++){
               
                $("#linkedinvces").append('<tr><td>'+arrayinvces[i]+'</td><td>'+addCommas(arrayamnts[i])+'</td></tr>');
                invamnt += parseFloat(arrayamnts[i]);
                };
                
                    $("#linkedinvces").append('<tr><td><b>Total :</b></td><td><b>'+addCommas(invamnt)+'</b></td></tr>');
                   
           if(!data[0]['status']){
         $.modaldialog.error('<br/><b>Receipt No:'+$rcptnolog+' Not found<b>', {
             width:400,
             showClose: true,
             title:"Error"
            });
    }else {
        basicLargeDialog("#recplg",500,500);
    }
    });
  
    
    //alert('test');
    }
    });
    $("#amntrecpnoid").keyup(function(){ 
 
 modfyrcptamnt();
 
 });

    });
     function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

     function modfyrcptamnt(){
        var oidata = [];
var poidata = "", poibalance = "" , sumbal = 0; 
 var $pendinginvces = $('.sablaffectedinvces').length;
 //alert ($pendinginvces);
 var total = $("#amntrecpnoid").val().replace(/[^0-9\.]+/g,"");
var k = $pendinginvces;
    $('.sablaffectedinvces').each(function(k, obj) {
          var     $amount=parseFloat(document.getElementById("maxamnt"+k).innerHTML.replace(/[^0-9\.]+/g,""));
    //alert(i);
        sumbal = sumbal + $amount;; 
    var dataValue =  $amount;
    var dataId =  parseFloat(document.getElementById("pinvn"+k).innerHTML);
   // var $row = $(this).closest("tr");
    var priceAmt = 0;
   
    if(dataValue > 0 ){
        
        if(total > dataValue || total === dataValue){
                total = total - dataValue;
                $('#editedamnt'+k).val(dataValue);
                    oidata.push(dataId);
                     }
                else{    
                   $('#editedamnt'+k).val(total);
                priceAmt = dataValue - total;
                             
               // $row.find('.balance').val(priceAmt.toFixed(2));
                if(total>0){
                    poibalance=priceAmt;
                    poidata=dataId;
                    oidata.push(dataId);
                }
                total=0;                                                        
                } 
                  if($('#editedamnt'+k).val() < $amount || $('#editedamnt'+k).val() > $amount){
                 var eamnt = $('#editedamnt'+k).val().replace(/[^0-9\.]+/g,"");
                 var mamnt = $amount;
                 var balamnt  =  eamnt - mamnt;
                 $('#otherrcpt'+k).val(balamnt);
            // alert($('#otherrcpt'+k).val());
             }
             }
             
           
            });
            
            
}

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
        label 
{
width: 200px;
padding-left: 20px;
margin: 5px;
float: left;
text-align: left;
}
      .ui-effects-wrapper{overflow-x: visible !important; width: 2px !important; height: 2px !important }   
	</style>

  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
 <!--<link rel="stylesheet" href="../assets/css/jquery-ui.css" />-->
</head>
   
<body> 
  
    <?php
                                
                                
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
                <div id="gallerydisp" style="display: block;float: right"><button class="btncls" >Mumin Search</button></div>
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
     
     $type=$_GET['type'];
     
     
     if($type==""){
         
        echo "<font color='green'>&laquo;&nbsp;Use the left menu panel options to navigate through recipts module</font>" ;
         
         
     }
     else if($type=="error"){
         
         
         echo "<font color='red'>The receipt NOT AVAILABLE </font>";
         
     }
     
     else if($type=="receiptlist"){
         
     ?>    
       
         
             <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">Receipt List</legend>
           <table  class="ordinal"> 
                   
                   
                   
                   <tr><td>From Date :</td><td><input id="sdate" name="sdate"   class="formfield" value="<?php echo date('d-m-Y');?>"/></td><td>Mode :</td><td><select id="pmd" class="formfield"  name="pmd"><option value="ALL">ALL</option><option value="CHEQUE">CHEQUE</option><option value="CASH">CASH</option></select></td></tr>
                   <tr><td>To Date :</td><td><input  id="edate"  name="edate" class="formfield" value="<?php echo date('d-m-Y');?>"/></td> <td>Account :</td><td><select id="dpt" class="formfield"  name="dpt">
                               
                     <?php
                      
                      $qrs1="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id' GROUP BY incomeaccounts.incacc"; 
                      
                      $datas1=$mumin->getdbContent($qrs1);
                      
                      
                       echo "<option value='ALL'>ALL</option>";
                    
                      
                      for($k=0;$k<=count($datas1)-1;$k++){
                              echo '<option value="'.$datas1[$k]['incacc'].'"';
                               
                              echo '>' .$datas1[$k]['accname'].'</option>';   
                      }
                      ?>                   
                               
                               <!--<button id="viewlist" name="viewlist">View List</button>!-->
                               
                           </select></td></tr><tr><td></td><td><button class="formbuttons" id="viewlist">View List</button></td><td></td><td></td></tr></table> 

                           </fieldset>
         
         <?php
     }
     
     else if($type=="new"){
     
     ?>
        <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">New Receipt</legend>
        
            <table class="ordinal" style="float: left">
            <tr><td style="width:150px">To:</td><td>
                    <input type="radio" name="receipt" value="sabil" id="rcptmumin" checked="true"><b>&nbsp&nbspMumin</b></input>
                    <input type="radio" name="receipt" value="debtor" id="rcptdebtor"  ><b>&nbsp&nbspDebtor &nbsp&nbsp</b></input>
                      <input type="text"  id="muminsectr" hidden></input>
                </td></tr>
                <tr><td></td><td><br><select id="choosedebtor"  class="formfield" style="display: none;">
               <?php
                      
                      $qrs="SELECT * FROM debtors WHERE deptid LIKE '$id' ORDER BY debtorname";
                      
                      $datas=$mumin->getdbContent($qrs);
                      
                       echo "<option value='' selected>--Select Debtor--</option>"; 
                      
                      //echo "<option value='mumin'>Mumineen</option>";
                      
                      for($k=0;$k<=count($datas)-1;$k++){
                          
                          echo "<option value='".$datas[$k]['dno']."'>".$datas[$k]['debtorname']."</option>";
                      }
                      ?>        
                      
                  </select><input type="text" id="mumineendebtor" placeholder="Enter Sabil No" style="text-transform: uppercase" class="formfield" maxlength="6" ></input></td>
                  <td style="width:150px"><br><select class="formfield" id="recptincacc">
                          <option selected value = ''>--Account--</option>
                                                      <?php
                                $qr5="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id' ORDER BY accname "; 
    
                                $data5=$mumin->getdbContent($qr5);
                                                            
                                 for($h=0;$h<=count($data5)-1;$h++){
                      
                                     echo "<option value=".$data5[$h]['incacc'].">".$data5[$h]['accname']."</option>";
                                     
                                   } 
                            
                            ?>
                      </select></td> 
                  <td style="text-align: right"><br><button class="btn" id="choosedebtorgo">View Invoices</button></td> </tr>
                   
        </table>
            </fieldset>
         
   
        
    
    
    <div id="_outstanding_invoices" style="width: 99%;min-height: 10px;max-height:200px;overflow-y: auto; border:1px #FFF solid;line-height: 10px ;vertical-align: middle;background: transparent; margin: 2px auto 2px auto;padding: 1px 1px 10px 1px;border-radius: 5px;-webkit-border-radius: 5px;-moz-border-radius: 5px">   
        <div id="debtor_mumin_name" style="height: 30px;display: none;width:748px;font-size: 16px;color: orangered;vertical-align: middle;line-height: 30px;padding-left: 20px;border: 1px gainsboro solid;background: ghostwhite;font-weight: bold">
                  </div>
        <table id="billstable2" class="ordinal" style="width: 100%"></table>  
    
    
    </div>
    
  
      
      
           
     <div id="tabs" style="display: none;width: 770px;height: auto">  
    <ul>
    <li><a href="#CSH">CASH</a></li> 
    <li><a href="#CHQ">CHEQUE</a></li>
    <li><a href="#PD">PD</a></li>
        
         
    </ul>
             <div id="CSH">               
             
        <div id="highlighter-tips">Fields marked with  * are mandatory</div>
          
        
        <table class="ordinal"> <!--if cash !-->    
                     
                        <tr><td>Date:&nbsp;*</td><td>
			<input  type="text" id="cashdt100" readonly="readonly" class="formfield" value="<?php echo date('d-m-Y'); ?>"></input></td></tr>
                        <tr><td>Cash  amount:*&nbsp;</td><td><input value="0"   type="text" id="cshamount100" class="amount"></input></td>
                            <td hidden="true">Account:&nbsp;</td><td hidden="true">
                                <select  class="formfield" id="bnkaccounts"> <option value="" selected></option>>
                                <?php
                             
                                $iqr="SELECT * FROM bankaccounts WHERE deptid = '$id' AND sector = ' ' order by acname"; 
                              
                                $data4=$mumin->getdbContent($iqr);
                                
                                 for($h=0;$h<=count($data4)-1;$h++){
                      
                                     echo "<option value=".$data4[$h]['bacc'].">".$data4[$h]['acname'].":&nbsp".$data4[$h]['acno']."</option>";
                                   } 
                            
                            ?>
                        </select>
                            </td></tr>   
                        
                        
                         
                        <tr><td hidden="true">Income Acc:*</td>
                        <td hidden="true">
                          
                            <select  class="formfield" id="incaccounts" disabled> <option value="">--Income account--</option> 
                                <?php
                                $inqry="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id'";
                                
                                $data2=$mumin->getdbContent($inqry);
                                
                                 for($h=0;$h<=count($data2)-1;$h++){
                      
                                     echo "<option value=".$data2[$h]['incacc'].">".$data2[$h]['accname']."</option>";
                                   } 
                            
                            ?>
                        </select>
                        </td> 
                    </tr>
                    <tr><td>Being payment of </td><td colspan="2"><textarea id="cshrmks100" class="formfield"></textarea></td></tr> 
                    <tr><td></td><td><button id="cshreceipt"><b>Generate Receipt</b></button></td></tr>   
                </table>      
          
       </div>    
         
    <div id="CHQ"> 
        <div id="highlighter-tips">Fields marked with  * are mandatory</div>
        
        <table class="ordinal"> <!--if cheque !-->
          <tr><td>Payment Date:&nbsp;*</td><td><?php
                                 
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
	<input  type="text" id="paymentdt100" readonly="readonly" class="formfield" value="<?php echo date('d-m-Y'); ?>"></input></td>
              <td>Income Acct:*</td><td><select name="credit2" class="formfield" id="credit2" disabled> 
                                <?php
                                $qr="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id'";
                                
                                $data=$mumin->getdbContent($qr);
                                 echo "<option value=''>--Income Account--</option>";
                                
                                 for($h=0;$h<=count($data)-1;$h++){
                      
                                     echo "<option value=".$data[$h]['incacc'].">".$data[$h]['accname']."</option>";
                                     
                                   } 
                            
                            ?>
                        </select></td>

            </tr>            
           
           <tr><td>Cheque Date:&nbsp;*</td><td><input id="ckdate100" type="text" class="formfield" ></input>
                     
                    </td><td>Cheque No:&nbsp;*</td><td><input id="ckno100" type="text" class="formfield"></input></td></tr>   
                    <tr></tr>  
                    <tr><td>Amount:&nbsp;*</td><td><input value="0" id="ckamount100" type="text" class="amount"></input></td>
                    <td>Cheque details:&nbsp;*</td><td><input id="ckdetails100" type="text" class="formfield"></input></td></tr>   
                    <tr></tr> 
                    <tr><td hidden>Income Acc:&nbsp;*</td>
                        <td hidden>
        <select  class="formfield" id="incaccounts5"> <option value="">--Select--</option>

                        </select>
                        
                        </td>
                        <td hidden="true">Account:</td><td hidden="true">
                                <select  class="formfield" id="bnkaccounts2" > <option value="">--Select--</option>
                                <?php
                             
                                $iqry="SELECT * FROM bankaccounts WHERE deptid = '$id' "; 
                          
                                $data6=$mumin->getdbContent($iqry);
                                
                                 for($h=0;$h<=count($data6)-1;$h++){
                      
                                     echo "<option value=".$data6[$h]['bacc'].">".$data6[$h]['acname'].":&nbsp".$data6[$h]['acno']."</option>";
                                   } 
                            
                            ?>
                        </select>
                            </td>
                    </tr>
                    <tr><td>Being payment of:&nbsp;*</td><td><textarea class="formfield" id="ckrmks100" type="text"  ></textarea></td></tr> 
                    
                    <tr><td></td><td><?php echo $displ;?></td></tr>   
                </table>  
                    

       </div>     
        <div id="PD">
            <table class="ordinal"> <!--if cheque !-->
          <tr><td><b>Chq Date:&nbsp;*</b></td><td><b>Chq No:&nbsp;*</b></td><td><b>Chq Details:&nbsp;*</b></td><td><b>Income:&nbsp;*</b></td><td><b>Amount:&nbsp;*</b></td></tr>
          <tr><td><input type="text" class="formfield pdchqdate" style="width: 130px" id="pdchqdate1"></input></td><td><input type="text" class="formfield pdchqno" style="width: 150px" id="pdchqno1"></input></td><td><input type="text" class="formfield pdchqdet" style="width: 150px" id="pdchqdet1"></input></td><td>
                  <select class="formfield pdincmeacct" style="width: 150px" id="pdincmeact1"><option value="">--Select--</option>
                                <?php
 
                                 echo "<option value=''>--Income Account--</option>";
                                
                                 for($h=0;$h<=count($data)-1;$h++){
                      
                                     echo "<option value=".$data[$h]['incacc'].">".$data[$h]['accname']."</option>";
                                     
                                   } 
                            ?></select></td><td><input type="text" class="amount pdschqamnt" style="width: 150px" id="pdchqamount1"></input></td></tr>
                            <tr><td colspan="3"><b>Remarks:&nbsp;*</b></td></tr>
                            <tr><td colspan="3"><textarea class="formfield" id="pdremarks" type="text"  ></textarea></td></tr>
          <tr><td></td><td></td><td></td><td><b>Total:</b></td><td><input type="text" class="formfield" id="pdtotal" style="width: 150px"></input></td></tr>  
          <tr><td></td><td><?php echo $pdsubmit;?></td></tr>  
            </table>
        </div>
         
  </div>
       
  <div id="print_panel" style="width:600px;display: none;height:25px;background: #ccffcc;border: 1px #fff solid; margin: 1px auto 1px auto;padding: 10px;text-align: right;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px"><button id="rcptprint">print</button></div>
  <div id="receiptnode" style="width:600px;display: none;height:auto;background: #FFF;border: 1px #000 solid; margin: 0px auto 2px auto;padding: 10px;">
                          
  </div>      
             
 <div id="d_progress" style="display: none;background: transparent;border: none;text-align: center;vertical-align:middle; line-height: 50px;padding-top: 10px">
 <img align="center" src="../assets/images/icon_animated_prog_dkgy_42wx42h.gif"></img>
 </div> 
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
     
     else if($type=="reprint"){

         ?>
         <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">Reprint Receipt</legend>
        <form method="post" action="receipting.php?action=reprintingreceipt">
        <table class="ordinal">  
        <tr><td>Receipt No (*):</td><td><input name="recpno"  value="<?php if(isset($_POST['reversego'])){ echo $_POST['recpno'];} ?>"  class="formfield"></input></td><td><input type="submit" name="reprintgo" value="Reprint" class="formbuttons"></input></td></tr>
        </table>
       </form>       
          </fieldset>
  <?php
  
     }
    else if($type=="reversal"){
 ?>
     
            <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">Receipt Reversal</legend>
            <form method="post" action="">
        <table class="ordinal">  
            <tr><td>Receipt No (*):</td><td><input name="recpnorev"  class="formfield" id="recpnorev" value='<?php if(!isset($_POST['rcptsearch'])){ echo " "; }else{ echo $_POST['recpnorev'];}?>'></input></td><td><?php echo $rcptsearch; ?></td></tr>
        </table>
            </form>
                <div id="rcpt" style="display:none">
                    <form method="post" action="">
                    <table class="borders">
                        <tr><td> <input name="recpnorv"  class="formfield" id="recpnorv" type="hidden"></input><b>Receipt No:</b></td><td id="recptnoid"></td><td><b>Date:</b></td><td id="daterecptid" style="width: 250px"></td></tr>
                        <tr><td><b>Sabilno:</b></td><td id="sablrecptid"></td><td><b>Name:</b></td><td id="namerecptid" style="width: 250px"></td></tr>
                        <tr><td><b>Account</b></td><td id="incmerecptid"></td><td><b>Amount:</b></td><td id="amntrecptid"></td></tr>
                        <tr><td><b>Remarks</b></td><td colspan="2" style="height: 50px"><textarea style="width: 100%; height: 80%; border: none; background-color: #83a94c" id="rmksrecptid" name="rmksrecptid">
    </textarea></td><td><input type="submit"  style="font-weight: bold" value="Reverse" name="reversego" class="formbuttons" id="reversego"></input></td></tr>
                    </table></form>
                </div> 
            </fieldset>
  <?php
  
     }
     else if($type=="edit"){
 ?>
    <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">Modify Receipt</legend>
            <form method="post" action="">
        <table class="ordinal">  
            <tr><td>Recp No :</td><td><input name="mdfyrecp"  class="formfield" id="mdfyrecp" value='<?php if(!isset($_POST['mdfyrecp'])){ echo ""; }else{ echo $_POST['mdfyrecp'];}?>'></input></td><td><?php echo $recpsearch; ?></td></tr>
        </table>
            </form>
        <div id="recpmod" style="display: none">
                    
                    <table class="borders">
                        <tr><td> <input name="recpnomodfy"  class="formfield" id="recpnomodfy" type="hidden"></input><b>Recp No:</b></td><td id="recpnoid"></td><td><b>Date:</b></td><td  style="width: 250px"><input id="daterecpnoid" class="formfield" name="daterecpnoid"></input></td></tr>
                        <tr><td><b>Sabilno:</b></td><td ><input id="sabrecpnoid" class="formfield" name="sabrecpnoid" disabled="true"></input></td><td><b>Name:</b><input name="recpits" id="recpits" type="hidden"></input></td><td id="namerecpnoid" style="width: 300px"></td></tr>
                        
                        <tr><td>Payment Mode:</td><td><select class="formfield" id="recptpmode" name="recptpmode"><option>--select--</option>
                                    <option value="CASH">Cash</option><option value="CHEQUE">Cheque</option>
                                </select></td><td>Chq Date:</td><td><input id="recpchqdate" name="recpchqdate" class="formfield"></input></td></tr>
                        <tr><td>Chq No:</td><td><input name="recpchqno" id="recpchqno" class="formfield"></input></td> <td>Chq Details:</td><td><input name="recochqdetls" id="recochqdetls" class="formfield"></input></td></tr>
                        <tr><td><b>Account</b></td><td >
                                <select  class="formfield" id="incmerecpnoid" name="incmerecpnoid" disabled="true"><option>-select--</option> 
                                <?php
                                $qr="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id'"; 
                                
                                $data=$mumin->getdbContent($qr);
                                
                                 for($h=0;$h<=count($data)-1;$h++){
                      
                                     echo "<option value=".$data[$h]['incacc'].">".$data[$h]['accname']."</option>";
                                   } 
                            
                            ?>
                        </select>
                            </td><td><b>Amount:</b></td><td><input id="amntrecpnoid" class="amount" name="amntrecpnoid"></input></td></tr>
                        <tr><td><b>Remarks</b></td><td colspan="2" style="height: 50px"><textarea style="width: 100%; height: 80%; border: none; background-color: #83a94c" id="rmksrecpid" name="rmksrecpid">
    </textarea></td><td><input type="submit"  value="Update" name="updaterecp" class="formbuttons" id="updaterecp"></input></td></tr>
                    </table>
                </div>
        <table id="recptstable2" class="ordinal" style="width: 100%"></table>  
            </fieldset>
  <?php
  }     else if($type=="status"){
 ?>
    <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">Receipt Status</legend>
         
        <table class="ordinal">  
            <tr><td>Recp No :</td><td><input name="recplog"  class="formfield" id="recplog" value=''></input></td><td><button id="recplogsearch"> Search</button></td></tr>
        </table>
            </fieldset>
  <?php
  }
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
          $rlt=$mumin->getdbContent("SELECT * FROM  recptrans WHERE recpno LIKE '$recpno' AND est_id LIKE '$est_id' AND rev='0'  LIMIT 1");
                    If ($rlt){
              $sabiltno = $rlt[0]['sabilno'];
              $amount = number_format($rlt[0]['amount'],2);
               $ejno = $rlt[0]['hofej'];
               $dno = $rlt[0]['dno'];
              $rmks = $rlt[0]['rmks'];
              $dbrcptno = trim($rlt[0]['recpno']);
              $rdate = date('d-m-Y',strtotime($rlt[0]['rdate']));
              $inctname = $mumin->getdbContent("SELECT accname FROM incomeaccounts WHERE incacc = '".$rlt[0]['incacc']."' ");
              $incomename = $inctname[0]['accname'];
              if($dno == '0'){
                 $muminme = $mumin->get_MuminNames($ejno); 
              }else{
                $muminme = $mumin->get_debtorName($dno);
              }
             
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
          }else{
              echo "<script> 
                   
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
  }
  
  if(isset($_POST['reversego'])){ // Receipt Reversal
          
      $recpno=trim($_POST['recpnorv']);
      $rmks = trim($_POST['rmksrecptid']);
      $est_id =$_SESSION['dept_id'];
      $timeStamp= date('Y-m-d H:i:s');
      $currntdte = date('Y-m-d');
 
      $rs=$mumin->getdbContent("SELECT * FROM  recptrans WHERE recpno LIKE '$recpno' AND est_id LIKE '$est_id' AND rev='0' ");
           
      If ($rs){
        
    $invoicesettled=$rs[0]['invoicesettled'];
    	$invoices = explode(",",$rs[0]['invoices']);
     $invoiceamt= explode(",",$rs[0]['invceamnt']);
      $payno=$rs[0]['recpno']; 
      $statid = $rs[0]['est_id'];
        // Two entries found -meaning that receipt has  a duplicate, most probably it has been reversed
          
        $localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
          $q=$mumin->insertdbContent("INSERT INTO recptrans(est_id, rdate, amount, pmode, recpno, chqdet, chqno,chequedate, rmks, hofej, tno, sabilno, incacc, bacc, dno, ts, us, rev,invoicesettled,sector) VALUES 
                            ('$statid','$currntdte','"."-".$rs[0]['amount']."','".$rs[0]['pmode']."', 'R".$rs[0]['recpno']."','".$rs[0]['chqdet']."','".$rs[0]['chqno']."','".$rs[0]['chequedate']."','".$rmks."','".$rs[0]['hofej']."',0,'".$rs[0]['sabilno']."','".$rs[0]['incacc']."','0','".$rs[0]['dno']."','$timeStamp','".$rs[0]['us']."',1,'".$rs[0]['invoicesettled']."','$localIP')");
            if($q){ 
               
          $qq=$mumin->updatedbContent("UPDATE recptrans SET rev=1 WHERE recpno = '$recpno' AND est_id = '$est_id'");
          //$qry5=$mumin->updatedbContent("UPDATE invoice SET recpno =0, pdamount= 0 WHERE recpno LIKE '$recpno' AND estId LIKE '$est_id' AND isinvce = '1'");      

                    for($i=0;$i<=count($invoiceamt)-1;$i++){
                        $qry6=$mumin->updatedbContent("UPDATE invoice SET recpno =0, pdamount= pdamount-$invoiceamt[$i] WHERE invno LIKE '$invoices[$i]' AND estId LIKE '$est_id' AND isinvce = '1'");

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
    if (isset($_POST['recpsearch'])){
      if (empty($_POST['mdfyrecp'])) {
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
          $recpno=trim($_POST['mdfyrecp']);
          $est_id=$_SESSION['dept_id'];
          $rlt=$mumin->getdbContent("SELECT * FROM  recptrans WHERE recpno = '$recpno' AND est_id LIKE '$est_id' AND recon = '0' AND rev <> '1' LIMIT 1");
                    If ($rlt){
              $sabiltno = $rlt[0]['sabilno'];
              $amount = number_format($rlt[0]['amount'],2);
               $ejno = $rlt[0]['hofej'];
               $dno = $rlt[0]['dno'];
              $rmks = $rlt[0]['rmks'];
              $dbinvno = $rlt[0]['invoices'];
              
              $stldinv = explode(",",$rlt[0]['invoices']);
              $imp = "'" . implode("','", $stldinv) . "'";
              $estindvamnts = explode(",",$rlt[0]['invceamnt']);
              $rdate = date('d-m-Y',strtotime($rlt[0]['rdate']));
              $incacct = $rlt[0]['incacc'];
              $pmode = $rlt[0]['pmode'];            $chqdet = $rlt[0]['chqdet'];
              $chqno = $rlt[0]['chqno'];            $chqdate = $rlt[0]['chequedate'];
              $rev = $rlt[0]['rev'];

              //Check debtor name and Mumin Name
              if($dno == '0'){
                 $muminme = $mumin->get_MuminNames($ejno); 
              }else{
                $muminme = $mumin->get_debtorName($dno);
              }
              //IF checkdate is 0000-00-00 display Empty String
             if($chqdate=='0000-00-00'){
                 $displaydte = '';
             }else {
                 $displaydte = date('d-m-Y',  strtotime($chqdate));
             }
            
              echo "<script> 
                   $('#recpmod').css('display','block');
                   $('#recpnomodfy').val('$recpno');
                   $('#recpnoid').html('$recpno');
                  $('#daterecpnoid').val('$rdate');
                  $('#sabrecpnoid').val('$sabiltno');
                  $('#amntrecpnoid').val('$amount'); 
                  $('#incmerecpnoid').val('$incacct'); 
                  $('#namerecpnoid').html('$muminme');
                  $('#rmksrecpid').html('$rmks');
                  $('#mdfyrecp').val('$recpno');
                  $('#recpits').val('$ejno');
                  $('#recptpmode').val('$pmode');
                  $('#recpchqno').val('$chqno');
                  $('#recochqdetls').val('$chqdet');
                  $('#recpchqdate').val('$displaydte');
                      
            </script>";
              echo '<table id="invcetble" class="ordinal" style="width: 100%">';
              echo "<thead><tr style='font-size:10px'><th>Doc date.</th><th>Doc No.</th><th>Account.</th><th>Balance</th><th>Amount</th><th>Paid</th><th>Modified</th></tr></thead>";
              for($p=0;$p<=count($stldinv)-2;$p++){
                  $rltinv=$mumin->getdbContent("SELECT 	idate,invno,invoice.incacc,amount,pdamount,incomeaccounts.accname FROM  invoice,incomeaccounts WHERE incomeaccounts.incacc = invoice.incacc AND invno = '$stldinv[$p]' AND estId LIKE '$est_id' AND sabilno = '$sabiltno' AND invoice.incacc = '$incacct' ");
                  echo "<tr><td class='sablaffectedinvces'>".@$rltinv[0]['idate']."</td><td id='pinvn".$p."'>".@$rltinv[0]['invno']."</td><td>".@$rltinv[0]['accname']."</td><td style='text-align: right;padding-right:40px'>".number_format(@$rltinv[0]['amount'] - @$rltinv[0]['pdamount'],2)."</td><td style='text-align: right;padding-right:30px'>".number_format(@$rltinv[0]['pdamount'],2)."</td><td style='display: none' id='linkdinvceamnt$p'>".number_format($estindvamnts[$p],2)."</td><td style='text-align: right;padding-right:20px' id='maxamnt$p'>".number_format($estindvamnts[$p]+(@$rltinv[0]['amount'] - @$rltinv[0]['pdamount']),2)."</td><td><input class='formfield' id='editedamnt$p' readonly='true' value='$estindvamnts[$p]'></input><input type='text' hidden='true' id='otherrcpt$p' value=''/></td></tr>";
              }
                   $k = 0;
              $rsltqry2 = $mumin->getdbContent("SELECT idate,invno,invoice.incacc,amount,pdamount,incomeaccounts.accname FROM  invoice,incomeaccounts WHERE incomeaccounts.incacc = invoice.incacc AND estId LIKE '$est_id' AND sabilno = '$sabiltno' AND invno NOT IN ($imp) AND pdamount < amount AND invoice.incacc = '$incacct'");
                                                    for($m=0;$m<=count($rsltqry2)-1;$m++){
                                                        $k= $p++;
                    echo "<tr><td class='sablaffectedinvces'>".$rsltqry2[$m]['idate']."</td><td id='pinvn".$k."'>".$rsltqry2[$m]['invno']."</td><td>".@$rsltqry2[$m]['accname']."</td><td style='text-align: right;padding-right:40px'>".number_format($rsltqry2[$m]['amount'] - $rsltqry2[$m]['pdamount'],2)."</td><td style='text-align: right;padding-right:30px'>".number_format($rsltqry2[$m]['pdamount'],2)."</td><td style='display: none' id='linkdinvceamnt$k'>".number_format(0,2)."</td><td style='text-align: right;padding-right:20px' id='maxamnt$k'>".number_format($rsltqry2[$m]['amount']-$rsltqry2[$m]['pdamount'],2)."</td><td><input class='formfield' id='editedamnt$k' readonly='true' value='0'></input><input type='text' hidden='true' id='otherrcpt$k' value=''/></td></tr>";
                                   }
                                     echo '</table>';
          }else{
              echo "<script> 
                   
                   $.modaldialog.warning('<br></br><b>Receipt No. ".$recpno." cannot be modified</b>', {
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
                      echo "<script> 
                          
                          $(function(){
                          $('#updaterecp').click(function(){
      
                    basicLargeDialog('#rcpt_rqst',450,350);
                     });
                    });
            </script>";


  
  
  ?>
        <div id="rcpt_rqst" style="display: none" title="Confirmation">
           
        <p></p>
        <p></p>
        <p></p>
        <p> Are you sure you want to update this Receipt. <br></br> Linked to invoice number: <?php
         $qrs="SELECT invoices FROM recptrans WHERE recpno = '".@$_POST['mdfyrecp']."' and est_id = '$id'";
                      $datas=$mumin->getdbContent($qrs);
                          echo '<b>'.@$datas[0]['invoices'].'</b>';
                   
        ?> </p>
        <p></p>
        <p></p>
        <p> <button id="updatercpty" name="updatercpty">OK</button> <button id="cancelrcpty" name="cancelrcpty">CANCEL</button>  </p>
            </div>
                <div id="recplg" style="display: none" title="Receipt Log">
                <fieldset style="-moz-border-radius: 7px; border: 1px #dddddd solid; "><legend style="border: 1px #1a6f93 dotted;font-size: 13px;padding-right: 5px;padding-left: 5px;padding-top: 2px;padding-bottom: 2px;-moz-border-radius: 3px; width: 200px; font-weight: bold">Receipt Details</legend>
 
                    <label>Deposited On:</label><input type="text" id="depsiton" class="formfield" disabled /><br style="clear: left;" /><br/>
 
<label>Deposit No:</label><input type="text" id="depsitno" class="formfield" disabled style="color: #008d4c;font-weight: bold" /><br style="clear: left;" /><br/>
  
<label>Bank Account: </label><input type="text" id="bnkacct" class="formfield" disabled/><br style="clear: left;" /><br/>

<label>(Reconciled/Pending) </label><input type="text" id="status" class="formfield" disabled/><br style="clear: left;" /><br/>

<label> Status: </label><input type="text" id="rcptstatus" class="formfield" disabled style="color: #0072b1;font-weight: bold"/><br style="clear: left;" /><br/>

<label>Created by: </label><input type="text" id="createdby" class="formfield" disabled /><br style="clear: left;"/><br/>
 
 
</fieldset>
                    <div>
                        <table id="linkedinvces" class="borders" style="width:400px">
                            
                        </table>
                    </div>
               </div> 
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
<?php
}?>