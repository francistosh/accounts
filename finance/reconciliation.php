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
    
<title>Estates</title> 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';
?>

<style type="text/css">
<!--
#report{ font-family:"Trebuchet MS";  border-collapse:collapse; }
#report{ font-size:85%; text-align: left; }
.right{ text-align: right; }
#report th { background-color:#9c8468; height: 25px; }
.divform {
    border: 2px solid #2C7982;
    border-radius: 3px;
    margin-left:auto;
    margin-right:auto;
    width: 1250px;
    font-size: 14px;
    background: wheat;
    overflow:auto;
    height: 100%;
    
}
#report6{ font-family:"Trebuchet MS";  border-collapse:collapse; border: #8F5B00 solid 1px; width: 100%}
#report6{  text-align: left; }
#report6 th { background-color:#9c8468; height: 25px; }
#report6 td {border: #666 solid 1px; padding: 3px 7px 2px 7px; font-size:85%;}
#report6 tr:nth-child(even) {background: #CCC}
#report6 tr:nth-child(odd) {background: #FFF}
label 
{
width: 200px;
padding-left: 20px;
margin: 5px;
float: left;
text-align: left;
}
@media print
{ 
#printNot {display:none}
#printableArea2 {display:none}
thead {display: table-header-group;}
}
-->
</style>
<script>
$(function() {
  var costcentrs=[];
  var endrecondate = $("#clsingdate").val();
  var lstrecondate = $("#lstreconcidate").val();
   var clsingdatedt = $("#clsingdatedt").val();
 
        $("#closepg").button({  
            icons: {
                primary: "ui-icon-cross" ,
                        secondary:"ui-icon-close"
            },
            text: true
             
});

         $.getJSON("../finance/redirect.php?action=costc", function(data) {
   
    $.each(data, function(i,item) {
       
    costcentrs.push({label: item.centrename,value: item.cntrid});  
        
      
  
       $("#expcstcenter" ).autocomplete({
            source: costcentrs,
         //   minLength: 1,
            focus: function(event, ui ) {
             event.preventDefault();
            $(this).val(ui.item.label);
        },
            select: function(event, ui) {
	event.preventDefault();
	$(this).val(ui.item.label);
         $("#expcstcntreid").val(ui.item.value);
				}
        
     
  });
          $("#recdif").button({
            icons: {
                primary: "ui-icon-check",
                secondary: "ui-icon-gear" 
            }
        });
     }); 
      });
    
        $(".recpreconclas").live('change',function(){  //receipts  -debtors payment invoice checkbox listeners
 
    var $amount=0; 
     var $opbal =  parseFloat($("#oppenblnce").val().replace(/[^-+0-9\.]+/g,""));
   if ($(this).is(':checked')) {
          
             //  $("#clsingbalance").val (0.00);
               $("#recondifference").val (0.00);
        $amount=parseFloat($(this).val().replace(/[^-+0-9\.]+/g,""));
       //alert ($amount);
       var rcpsum = parseFloat($("#receiptsum").val().replace(/[^-+0-9\.]+/g,""))+ $amount;
      
        $("#receiptsum").val(addCommas(rcpsum));
        
         }
   else{
       //$("#clsingbalance").val (0.00);
               $("#recondifference").val (0.00);
          $amount=parseFloat($(this).val().replace(/[^-+0-9\.]+/g,""));
             var rcpsum = parseFloat($("#receiptsum").val().replace(/[^-+0-9\.]+/g,""))-$amount;
     
            $("#receiptsum").val(addCommas(rcpsum));
         
   }
   var $clearedbal = parseFloat($opbal+parseFloat($("#receiptsum").val().replace(/[^-+0-9\.]+/g,""))-parseFloat($("#paymentsum").val().replace(/[^-+0-9\.]+/g,"")));
   var $clearedbal2 = parseFloat($opbal+parseFloat($("#receiptsum").val().replace(/[^-+0-9\.]+/g,""))-parseFloat($("#paymentsum").val().replace(/[^-+0-9\.]+/g,"")));
        var rediff = $clearedbal - parseFloat($("#clsingbalance").val().replace(/[^-+0-9\.]+/g,""));
    $("#cleardbal").val(addCommas($clearedbal.toFixed(2)));
    $("#saveasbankop").val(addCommas($clearedbal2.toFixed(2)));
    $("#recondifference").val(addCommas(rediff.toFixed(2)));
 });
 
 $('#sumall').click(function() {
     var $opbal =  parseFloat($("#oppenblnce").val().replace(/[^-+0-9\.]+/g,""));
     $('.recpreconclas').prop("checked", true);//select all checkboxes with class "checks"  
                var sumtotal = 0;             
            var lngth = $('.recpreconclas').length;
            for(var k = 0; k<=lngth-1; k++ ){
               sumtotal = parseFloat($("#recprecon"+k).val())+ parseFloat(sumtotal);
                   }
               $("#receiptsum").val(sumtotal);
     var $clearedbal = parseFloat($opbal+parseFloat(sumtotal)-parseFloat($("#paymentsum").val())); 
      var $clearedbal2 = parseFloat($opbal+parseFloat(sumtotal)-parseFloat($("#paymentsum").val()));
         $("#cleardbal").val(addCommas($clearedbal.toFixed(2)));
         $("#saveasbankop").val(addCommas($clearedbal2.toFixed(2)));
         var rdifference = parseFloat($("#cleardbal").val().replace(/[^-+0-9\.]+/g,""))-parseFloat($("#clsingbalance").val().replace(/[^-+0-9\.]+/g,""));
         $("#recondifference").val(addCommas(rdifference.toFixed(2)));
 });

 $(".paymentreconclas").live('change',function(){  //receipts  -debtors payment invoice checkbox listeners
 
    var $amount2=0; 
    var $opnbal = parseFloat($("#oppenblnce").val().replace(/[^-+0-9\.]+/g,""));
   if ($(this).is(':checked')) {
          //alert('tets');
             // $("#clsingbalance").val (0.00);
               $("#recondifference").val (0.00);
        $amount2=parseFloat($(this).val().replace(/[^-+0-9\.]+/g,""));
       //alert ($amount);
       
       var paymentval = parseFloat($("#paymentsum").val().replace(/[^-+0-9\.]+/g,""))+ $amount2;
              $("#paymentsum").val(addCommas(paymentval.toFixed(2)));
         var clrdbl = parseFloat($opnbal)+parseFloat($("#receiptsum").val().replace(/[^-+0-9\.]+/g,""))-parseFloat($("#paymentsum").val().replace(/[^-+0-9\.]+/g,""));
    var clrdbl2 = parseFloat($opnbal)+parseFloat($("#receiptsum").val().replace(/[^-+0-9\.]+/g,""))-parseFloat($("#paymentsum").val().replace(/[^-+0-9\.]+/g,""));

        var rediff = clrdbl - parseFloat($("#clsingbalance").val().replace(/[^-+0-9\.]+/g,""));
   $("#cleardbal").val(addCommas(clrdbl.toFixed(2)));
   $("#saveasbankop").val(addCommas(clrdbl2.toFixed(2)));
   $("#recondifference").val(addCommas(rediff.toFixed(2)));
         }
   else{    
        //$("#clsingbalance").val (0.00);
               $("#recondifference").val (0.00);
          $amount2=parseFloat($(this).val().replace(/[^-+0-9\.]+/g,""));
           
           var paymentval = parseFloat($("#paymentsum").val().replace(/[^-+0-9\.]+/g,""))-$amount2;
             $("#paymentsum").val(addCommas(paymentval.toFixed(2)));
     var clrdbl = parseFloat($opnbal)+parseFloat($("#receiptsum").val().replace(/[^-+0-9\.]+/g,""))-parseFloat($("#paymentsum").val().replace(/[^-+0-9\.]+/g,""));
    var clrdbl2 = parseFloat($opnbal)+parseFloat($("#receiptsum").val().replace(/[^-+0-9\.]+/g,""))-parseFloat($("#paymentsum").val().replace(/[^-+0-9\.]+/g,""));

        var rediff = clrdbl - parseFloat($("#clsingbalance").val().replace(/[^-+0-9\.]+/g,""));
   $("#cleardbal").val(addCommas(clrdbl.toFixed(2)));
   $("#saveasbankop").val(addCommas(clrdbl2.toFixed(2)));
   $("#recondifference").val(addCommas(rediff.toFixed(2)));       
   }
   
 });
 
 $("#clsingbalance").keyup(function() {
    //var $amount3=parseInt($(this).val());
      //$("#recondifference").val(parseInt($("#cleardbal").val())- $amount3);
        if($(this).val()==''){
          $("#recondifference").val('');
      }else{
     
      var inti = parseFloat($(this).val().replace(/[^-+0-9\.]+/g,""));
      var clrdbal = parseFloat($("#cleardbal").val().replace(/[^-+0-9\.]+/g,""));
      var oppenblnce = parseFloat($("#oppenblnce").val().replace(/[^-+0-9\.]+/g,""));
          var dif = clrdbal - inti;
      $("#recondifference").val(addCommas(dif.toFixed(2)));}
});
$("#recdif").click(function(){
   
    var diff =  $("#recondifference").val();
       if (diff == '0' || diff == '' || diff == '0.00'){
        $.modaldialog.warning('<br/><br/><b>&nbsp;&nbsp;No pending difference</b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Warning"
            }); 
    } else{
    basicLargeDialog("#recondiff",500,600);
    
    $("#clrdbalance").val(addCommas($("#cleardbal").val()));
   $("#closingbalance").val(addCommas($("#clsingbalance").val()));
    $("#diffrecon").val(addCommas($("#recondifference").val()));
    $("#diffreconstat").val($("#recondifference").val()); //static recon diff amount
    $("#reconincmeamnt").val(0);
     $("#incmereconacc").val(" ");
 }
});
$("#incmeacts").click(function(){
   $("#diffxpense").hide();
   $("#diffincome").show();
   $("#clrdbalance").val(addCommas($("#cleardbal").val()));
   $("#closingbalance").val(addCommas($("#clsingbalance").val()));
    $("#diffrecon").val(addCommas($("#recondifference").val()));
    $("#diffreconstat").val($("#recondifference").val()); //static recon diff amount
    $("#reconincmeamnt").val(0);
    $("#reconexpamnt").val(0);
     $("#reconexpnacc").val(" ");
});
$("#expnsaccts").click(function(){
   $("#diffxpense").show();
   $("#diffincome").hide();
    $("#clrdbalance").val(addCommas($("#cleardbal").val().toFixed(2)));
   $("#closingbalance").val(addCommas($("#clsingbalance").val()));
    $("#diffrecon").val(addCommas($("#recondifference").val().toFixed(2)));
    $("#diffreconstat").val($("#recondifference").val().toFixed(2)); //static recon diff amount
    $("#reconincmeamnt").val(0);
     $("#reconexpamnt").val(0);
     $("#incmereconacc").val(" ");
  
});
 $( "#updaterecon" ).click(function() {
     var bankacctid = $("#bankacctid").val();
     var cleardbal = $("#cleardbal").val().replace(/[^-+0-9\.]+/g,"");
     var cleardbal2 = $("#saveasbankop").val().replace(/[^-+0-9\.]+/g,"");
     var clsingbalance = $("#clsingbalance").val().replace(/[^-+0-9\.]+/g,"");
     var reconcidate =  $("#reconcidate").val();
     var oppenblnce2 = parseFloat($("#oppenblnce").val().replace(/[^-+0-9\.]+/g,""));
     if (!clsingbalance){
        // alert ('Ensure all fields are complete');
         $.modaldialog.warning('<br/><br/><b>&nbsp;&nbsp;Ensure all fields are complete</b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Warning"
            });
        }
     else{
         
     var $docnumbers =""; var withdrawalnos = ""; var $doctypesclrd =""; var clrdwitdrawaldoc = "";
     var $docnumbernotrecon =""; var $withdocnumbernotrecon =""; var $doctypesnotclrd =""; var notclrdwitdrawaldoc = ""; 
     var diffrnce = $("#recondifference").val().replace(/[^-+0-9\.]+/g,"");
     //alert(diffrnce);
        if (diffrnce == "0.00" || diffrnce == '0' ){
      
    for(var j=0;j<=$(".recpreconclas").length-1;j++){
        if ($("#recprecon"+j).is(':checked')) {
           
           var $docnos=$("#recpnorecon"+j).val();
           var doctype = $("#doctype"+j).val();
           $docnumbers+=$docnos+",";
           $doctypesclrd+=doctype+",";
               }
           else{
               var $docnotrecon=$("#recpnorecon"+j).val();
               var doctypenot = $("#doctype"+j).val();
           $docnumbernotrecon +=$docnotrecon+",";
           $doctypesnotclrd +=doctypenot+",";
           }
        
    }
for(var j=0;j<=$(".paymentreconclas").length-1;j++){
        if ($("#paytrecon"+j).is(':checked')) {
           
           var $docnos=$("#paynorecon"+j).val();
           var withdrawaldoc = $("#withdrawaldoc"+j).val();
           withdrawalnos+=$docnos+",";
           clrdwitdrawaldoc +=withdrawaldoc+",";
               }
           else{
               var $withdrwalnotrecon=$("#paynorecon"+j).val();
               var withdrawalnotclrd = $("#withdrawaldoc"+j).val();
           $withdocnumbernotrecon +=$withdrwalnotrecon+",";
           notclrdwitdrawaldoc += withdrawalnotclrd+",";
           }
        
    }


        updaterecon ($docnumbers,$doctypesclrd,bankacctid,$docnumbernotrecon,$doctypesnotclrd,clrdwitdrawaldoc,$withdocnumbernotrecon,notclrdwitdrawaldoc,withdrawalnos,cleardbal,cleardbal2,clsingbalance,reconcidate,diffrnce,oppenblnce2);
}  else{
     // alert ('Difference not cleared');
               $.modaldialog.warning('<br/><b>&nbsp;&nbsp;Difference not cleared</b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Warning"
            }); 
     }
    
        
     }
});
$("#reconincmeamnt").keyup(function(){

  var drecon = parseFloat($("#diffreconstat").val().replace(/[^-+0-9\.]+/g,""))+ parseFloat($(this).val().replace(/[^-+0-9\.]+/g,""));
    //alert(parseFloat($("#diffreconstat").val().replace(/[^-+0-9\.]+/g,"")));
    $("#diffrecon").val(addCommas(drecon));
});
$("#reconexpamnt").keyup(function(){

  var drecon = parseFloat($("#diffreconstat").val().replace(/[^-+0-9\.]+/g,""))- parseFloat($(this).val().replace(/[^-+0-9\.]+/g,""));
    //alert(parseFloat($("#diffreconstat").val().replace(/[^-+0-9\.]+/g,"")));
    $("#diffrecon").val(addCommas(drecon));
});
$("#incmebtn").click(function(){
   // get value of input fields from dialog
   var recondifamnt = $("#diffrecon").val();
 
   if(recondifamnt === '0'){ 
    var incmerecondate = $("#incmerecondate").val();
    var incmereconacc = $("#incmereconacc").val();
    var reconincmeamnt = $("#reconincmeamnt").val().replace(/[^-+0-9\.]+/g,"");
    var reconincmermks = $("#reconincmermks").val();
    if(incmerecondate == '' || incmereconacc == '' || reconincmeamnt == '0' || reconincmermks == ''){
        alert('Ensure all fields are complete');
        
        
        
    } else{
    var bankacctid = $("#bankacctid").val();
    var clrdbalance = $("#clrdbalance").val().replace(/[^-+0-9\.]+/g,"");
    var closingbalance = $("#closingbalance").val().replace(/[^-+0-9\.]+/g,"");
    var oppenblnce = $("#oppenblnce").val().replace(/[^-+0-9\.]+/g,"");
    //
    // get values of background checked figures
    var reconcidate =  $("#reconcidate").val();
    var $docnumbers =""; var withdrawalnos = ""; var $doctypesclrd =""; var clrdwitdrawaldoc = "";
     var $docnumbernotrecon =""; var $withdocnumbernotrecon =""; var $doctypesnotclrd =""; var notclrdwitdrawaldoc = ""; 
     var diffrnce = recondifamnt.replace(/[^-+0-9\.]+/g,"");
     //alert (diffrnce);
      
    for(var j=0;j<=$(".recpreconclas").length-1;j++){
        if ($("#recprecon"+j).is(':checked')) {
           
           var $docnos=$("#recpnorecon"+j).val();
           var doctype = $("#doctype"+j).val();
           $docnumbers+=$docnos+",";
           $doctypesclrd+=doctype+",";
               }
           else{
               var $docnotrecon=$("#recpnorecon"+j).val();
               var doctypenot = $("#doctype"+j).val();
           $docnumbernotrecon +=$docnotrecon+",";
           $doctypesnotclrd +=doctypenot+",";
           }
        
    }
for(var j=0;j<=$(".paymentreconclas").length-1;j++){
        if ($("#paytrecon"+j).is(':checked')) {
           
           var $docnos=$("#paynorecon"+j).val();
           var withdrawaldoc = $("#withdrawaldoc"+j).val();
           withdrawalnos+=$docnos+",";
           clrdwitdrawaldoc +=withdrawaldoc+",";
               }
           else{
               var $withdrwalnotrecon=$("#paynorecon"+j).val();
               var withdrawalnotclrd = $("#withdrawaldoc"+j).val();
           $withdocnumbernotrecon +=$withdrwalnotrecon+",";
           notclrdwitdrawaldoc += withdrawalnotclrd+",";
           }
        
    }
    $("#recondiff").dialog("destroy");
    //pass variable to insert JV as income into bank
     var ok_buttt = new LertButton('Yes', function() {
      //window.close();
        
          $.getJSON("../finance/json_redirect.php?action=reconsavejv&jvfrom="+incmereconacc+"&jvto="+bankacctid+"&jvrmks="+reconincmermks+"&jvamount="+reconincmeamnt+"&jvdate="+incmerecondate+"&debityp=1", function(data) {
    if(data.id===1){
        
         $("#d_progress").dialog("destroy");
         
           
           $.modaldialog.success('Recon successfull', {
          title: 'Success transaction',
          showClose: true
          });  

         updatecon ($docnumbers,$doctypesclrd,bankacctid,reconcidate,diffrnce,oppenblnce,$docnumbernotrecon,$doctypesnotclrd,$withdocnumbernotrecon,notclrdwitdrawaldoc,withdrawalnos,clrdwitdrawaldoc,clrdbalance,closingbalance,data.jvno);
      // window.close();
   
         //$()
          }
    });       });
   var no_buttt = new LertButton('No', function() {
       basicLargeDialog("#recondiff",500,600);
   });
 
var msg = "<b><u>Confirmation</u></b><br/>Are you sure you want to proceed?";
var boxx = new Lert(msg,[ok_buttt,no_buttt],
		{
defaultButton:ok_buttt


		});
boxx.display(); 
    }
}else if(recondifamnt != '0'){
            alert('Difference not yet cleared');
}
    
});

$("#expensebtn").click(function(){
var recondifamnt = $("#diffrecon").val();
 if(recondifamnt === '0'){ 
 
 var expensedate = $("#expensedate").val();
    var reconexpnacc = $("#reconexpnacc").val();
    var reconexpamnt = $("#reconexpamnt").val().replace(/[^-+0-9\.]+/g,"");
    var reconexprmks = $("#reconexprmks").val();
    var expcstcenter = $("#expcstcenter").val();
    var expcstcntreid = $("#expcstcntreid").val();
     if(expensedate == '' || reconexpnacc == '' || reconexpamnt == '0' || reconexprmks ==  '' || expcstcenter == '' || expcstcntreid ==''){
        alert('Ensure all fields are complete');
    }else{
    var bankacctid = $("#bankacctid").val();
    var clrdbalance = $("#clrdbalance").val().replace(/[^-+0-9\.]+/g,"");
    var closingbalance = $("#closingbalance").val().replace(/[^-+0-9\.]+/g,"");
    var oppenblnce = $("#oppenblnce").val().replace(/[^-+0-9\.]+/g,"");
    //
    // get values of background checked figures
    var reconcidate =  $("#reconcidate").val();
    var $docnumbers =""; var withdrawalnos = ""; var $doctypesclrd =""; var clrdwitdrawaldoc = "";
     var $docnumbernotrecon =""; var $withdocnumbernotrecon =""; var $doctypesnotclrd =""; var notclrdwitdrawaldoc = ""; 
     var diffrnce = recondifamnt.replace(/[^-+0-9\.]+/g,"");
     //alert (diffrnce);
      
    for(var j=0;j<=$(".recpreconclas").length-1;j++){
        if ($("#recprecon"+j).is(':checked')) {
           
           var $docnos=$("#recpnorecon"+j).val();
           var doctype = $("#doctype"+j).val();
           $docnumbers+=$docnos+",";
           $doctypesclrd+=doctype+",";
               }
           else{
               var $docnotrecon=$("#recpnorecon"+j).val();
               var doctypenot = $("#doctype"+j).val();
           $docnumbernotrecon +=$docnotrecon+",";
           $doctypesnotclrd +=doctypenot+",";
           }
        
    }
for(var j=0;j<=$(".paymentreconclas").length-1;j++){
        if ($("#paytrecon"+j).is(':checked')) {
           
           var $docnos=$("#paynorecon"+j).val();
           var withdrawaldoc = $("#withdrawaldoc"+j).val();
           withdrawalnos+=$docnos+",";
           clrdwitdrawaldoc +=withdrawaldoc+",";
               }
           else{
               var $withdrwalnotrecon=$("#paynorecon"+j).val();
               var withdrawalnotclrd = $("#withdrawaldoc"+j).val();
           $withdocnumbernotrecon +=$withdrwalnotrecon+",";
           notclrdwitdrawaldoc += withdrawalnotclrd+",";
           }
        
    }
    $("#recondiff").dialog("destroy");
    //pass variable to insert JV as income into bank
     var ok_buttt = new LertButton('Yes', function() {
         //window.close();
          $.getJSON("../finance/json_redirect.php?action=saverecondrctexp&expensacc="+reconexpnacc+"&crdtacc="+bankacctid+"&dexpdate="+expensedate+"&dxamount="+reconexpamnt+"&remks="+reconexprmks+"&ccntrid="+expcstcntreid, function(data) {
    if(data.id===1){
        
         $("#d_progress").dialog("destroy");
         
           
           $.modaldialog.success('Recon successfull', {
          title: 'Success transaction',
          showClose: true
          });  
          
          // preview the reconcilliation
           
         $("#printNot").css("display","none");
         $("#printableArea2").css("display","none");
         
        $("#contents").fadeIn("slow");   
     // window.close();
     $("#contents").load('reconpreview.php?docunumbers='+$docnumbers+'&doctypsclrd='+$doctypesclrd+'&bnkacctid='+bankacctid+'&reconcidate='+reconcidate+'&diffrnce='+diffrnce+'&oppenblnce2='+oppenblnce+'&recpnotrecon='+$docnumbernotrecon+'&doctypesnotclrd='+$doctypesnotclrd+'&withdocnotrecon='+$withdocnumbernotrecon+'&notclrdwitdrawaldoc='+notclrdwitdrawaldoc+'&withdrwalrecon='+withdrawalnos+'&clrdwitdrawaldoc='+clrdwitdrawaldoc+'&cashbkbal='+clrdbalance+'&clsingbalance='+closingbalance+'&directexp='+data.dexpvno);
  //window.open('reconpreview.php?docunumbers='+$docnumbers+'&doctypsclrd='+$doctypesclrd+'&bnkacctid='+bankacctid+'&reconcidate='+reconcidate+'&diffrnce='+diffrnce+'&oppenblnce2='+oppenblnce+'&recpnotrecon='+$docnumbernotrecon+'&doctypesnotclrd='+$doctypesnotclrd+'&withdocnotrecon='+$withdocnumbernotrecon+'&notclrdwitdrawaldoc='+notclrdwitdrawaldoc+'&withdrwalrecon='+withdrawalnos+'&clrdwitdrawaldoc='+clrdwitdrawaldoc+'&cashbkbal='+clrdbalance+'&clsingbalance='+closingbalance+'&directexp='+data.dexpvno,'','width=900,toolbar=0,menubar=1,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
 
         //$()
          }
    });       });
   var no_buttt = new LertButton('No', function() {
       basicLargeDialog("#recondiff",500,650);
   });
 
var msg = "<b><u>Confirmation</u></b><br/>Are you sure you want to proceed?";
var boxx = new Lert(msg,[ok_buttt,no_buttt],
		{
defaultButton:ok_buttt


		});
boxx.display();             }
        }else if(recondifamnt != '0'){
            alert('Difference not yet cleared');
}
    });

$("#expensedate" ).datepicker({ dateFormat: 'dd-mm-yy',
    minDate: parseInt(endrecondate)+parseInt(1),
    maxDate: parseInt(clsingdatedt)
   });

 $("#incmerecondate" ).datepicker({ dateFormat: 'dd-mm-yy',
     minDate: parseInt(endrecondate)+parseInt(1),
    maxDate: parseInt(clsingdatedt)
   } );
 
});
function updaterecon ($docnumbers,$doctypesclrd,bankacctid,$docnumbernotrecon,$doctypesnotclrd,clrdwitdrawaldoc,$withdocnumbernotrecon,notclrdwitdrawaldoc,withdrawalnos,cleardbal,cleardbal2,clsingbalance,reconcidate,diffrnce,oppenblnce2){
       // var urlst = 
       var ok_buttt = new LertButton('Yes', function() {
         window.close();
        //window.open('reconpreview.php?docunumbers='+$docnumbers+'&doctypsclrd='+$doctypesclrd+'&bnkacctid='+bankacctid+'&reconcidate='+reconcidate+'&diffrnce='+diffrnce+'&oppenblnce2='+oppenblnce2+'&recpnotrecon='+$docnumbernotrecon+'&doctypesnotclrd='+$doctypesnotclrd+'&withdocnotrecon='+$withdocnumbernotrecon+'&notclrdwitdrawaldoc='+notclrdwitdrawaldoc+'&withdrwalrecon='+withdrawalnos+'&clrdwitdrawaldoc='+clrdwitdrawaldoc+'&cashbkbal='+cleardbal+'&cashbkbal2='+cleardbal2+'&clsingbalance='+clsingbalance+'&bnkdebtchequedet='+$debtchqdet+'&bnkdebtchequedate='+$debtchqdate+'&bnkdebtchequermk='+$debtchqrmks+'&bnkdebtchqamnt='+$debtchqamnt+'&bnkcrdtchequedet='+$crdtchqdet+'&bnkcrdtchequedate='+$crdtchqdate+'&bnkcrdtchequermk='+$crdtchqrmks+'&bnkcrdtchqamnt='+$crdtchqamnt,'','width=900,toolbar=0,menubar=1,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
		var $dataString= {docunumbers:$docnumbers,doctypsclrd:$doctypesclrd,bnkacctid:bankacctid,reconcidate:reconcidate,diffrnce:diffrnce,oppenblnce2:oppenblnce2,recpnotrecon:$docnumbernotrecon,doctypesnotclrd:$doctypesnotclrd,withdocnotrecon:$withdocnumbernotrecon,notclrdwitdrawaldoc:notclrdwitdrawaldoc,withdrwalrecon:withdrawalnos,clrdwitdrawaldoc:clrdwitdrawaldoc,cashbkbal:cleardbal,cashbkbal2:cleardbal2,clsingbalance:clsingbalance,bnkdebtchequedet:$debtchqdet,bnkdebtchequedate:$debtchqdate,bnkdebtchequermk:$debtchqrmks,bnkdebtchqamnt:$debtchqamnt,bnkcrdtchequedet:$crdtchqdet,bnkcrdtchequedate:$crdtchqdate,bnkcrdtchequermk:$crdtchqrmks,bnkcrdtchqamnt:$crdtchqamnt}
	 
    $. post(url, function (dataString) {
    var w = window.open('about:blank');
    w.document.open();
    w.document.write(dataString);
    w.document.close();
	   });
	   
	   });
   var no_buttt = new LertButton('No', function() {});
 
var msg = "<b><u>Confirmation</u></b><br/>Are you sure you want to proceed?";
var boxx = new Lert(msg,[ok_buttt,no_buttt],
		{
defaultButton:ok_buttt,
icon:'../finance/images/dialog-error.png'

		});
boxx.display();   
     
}
function updatecon ($docnumbers,$doctypesclrd,bankacctid,reconcidate,diffrnce,oppenblnce,$docnumbernotrecon,$doctypesnotclrd,$withdocnumbernotrecon,notclrdwitdrawaldoc,withdrawalnos,clrdwitdrawaldoc,clrdbalance,closingbalance,jvno){
         $("#printNot").css("display","none");
         $("#printableArea2").css("display","none");
         
        $("#contents").fadeIn("slow");   
        $("#contents").load('reconpreview.php?docunumbers='+$docnumbers+'&doctypsclrd='+$doctypesclrd+'&bnkacctid='+bankacctid+'&reconcidate='+reconcidate+'&diffrnce='+diffrnce+'&oppenblnce2='+oppenblnce+'&recpnotrecon='+$docnumbernotrecon+'&doctypesnotclrd='+$doctypesnotclrd+'&withdocnotrecon='+$withdocnumbernotrecon+'&notclrdwitdrawaldoc='+notclrdwitdrawaldoc+'&withdrwalrecon='+withdrawalnos+'&clrdwitdrawaldoc='+clrdwitdrawaldoc+'&cashbkbal='+clrdbalance+'&clsingbalance='+closingbalance+'&incmejv='+jvno);

       // window.open('reconpreview.php?docunumbers='+$docnumbers+'&doctypsclrd='+$doctypesclrd+'&bnkacctid='+bankacctid+'&reconcidate='+reconcidate+'&diffrnce='+diffrnce+'&oppenblnce2='+oppenblnce+'&recpnotrecon='+$docnumbernotrecon+'&doctypesnotclrd='+$doctypesnotclrd+'&withdocnotrecon='+$withdocnumbernotrecon+'&notclrdwitdrawaldoc='+notclrdwitdrawaldoc+'&withdrwalrecon='+withdrawalnos+'&clrdwitdrawaldoc='+clrdwitdrawaldoc+'&cashbkbal='+clrdbalance+'&clsingbalance='+closingbalance+'&incmejv='+jvno,'','width=900,toolbar=0,menubar=1,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');

    
}
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
</script>
<!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />-->
<link rel="stylesheet" href="../assets/css/jquery-ui.css" />
</head>
    <body style="background:#FFF;overflow-x: visible!important;">
           <div align="center" id="printNot">
<!--<button class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print List</span></span></span></button>-->
<button id="closepg" class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
</div>
<br />

<?php
        
  date_default_timezone_set('Africa/Nairobi');
         // $sdate2=trim($_GET['brstart']);
         // $sdate11 = date('Y-m-d', strtotime($sdate2));
          $edate2=trim($_GET['brend']);
          $edate11 = date('Y-m-d', strtotime($edate2));
          $bnktid =trim($_GET['bnktid']);
          $est_id=$id;
          
                 $numbering=1;
          
          $sum=0;
          $sum1=0;
   $bankqry="SELECT acname,acno FROM bankaccounts WHERE bacc = '$bnktid'";       
            $databank=$mumin->getdbContent($bankqry);
  $slctop = $mumin->getdbContent("SELECT IFNULL(MIN(bnkclsbal), 0) as bnkclsbal,recondate FROM bankrecon WHERE  bacc = '$bnktid' AND id = (select max(id) from bankrecon WHERE  bacc = '$bnktid' )  ");
          $oppenbal = $slctop[0]['bnkclsbal'];
          $lastrecondate = date('Y-m-d',strtotime($slctop[0]['recondate']));
                                    
      $disp = 'block';
  
           
          echo '<div id="printableArea2" >';
echo '<div align="right"><font size="3"><b>Bank Reconciliation</font></b> </div>';
//echo '<hr />';
echo '<div><table id="report" style="font-size:14px;margin-left:40px">';
echo '<tr><td>&nbsp; Account Name:  <b>'.$databank[0]['acname'].' - '.$databank[0]['acno'].'</b></td></tr>';
echo '<tr><td>&nbsp; Bank Reconciliation as at:&nbsp; &nbsp;<b>'.$edate2.'</b> </td></tr>'; 
echo '</table></div>
    <input style="display:none" value="'.$bnktid.'" id="bankacctid"></input>
    <input style="display:none" value="'.$edate2.'" id="reconcidate"></input>
    <input style="display:none" value="'.$lastrecondate.'" id="lstreconcidate"></input>    ';
//echo '<hr />';
?>
<div class="divform" >
<div  style="width:615px; height:350px; float: left;margin: 5px; overflow:auto;">
<table id="report6" >
      
<thead><tr><th colspan="4" style="background-color: #357918;">Deposits</th><th colspan="3" style="background-color: #357918; text-align: center"><a href="#" id="sumall">Select All</a> | <a href="#">Clear All</a></th></tr></thead>
<tr style="font-weight: bold;"><td style="width:100px" colspan="2">Date</td><td style="width:400px" colspan="2">Narration</td><td style="width:100px" colspan="2">Amount</td><td style="width:10px; text-align: center">Status</td></tr>
<?php
        $qrry= "SELECT DATE_FORMAT(depots, '%Y-%m-%d') as rdate ,isdeposited as recpno,SUM(amount) as amount,'Deposit No' as doctype,'depo' as doc,isdeposited,pmode,depots as ts FROM recptrans WHERE DATE_FORMAT(depots, '%Y-%m-%d') <= '$edate11' AND est_id LIKE '$est_id' AND recon = '0' AND bacc = $bnktid AND pmode = 'CASH' AND isdeposited <> '0' GROUP BY isdeposited  UNION
                SELECT DATE_FORMAT(depots, '%Y-%m-%d') as rdate ,recpno,amount,'Deposit No' as doctype,'recp' as doc,isdeposited,concat(pmode,' ','No:',' ',chqno,' ',chqdet) AS pmode,depots as ts FROM recptrans WHERE DATE_FORMAT(depots, '%Y-%m-%d') <= '$edate11' AND est_id LIKE '$est_id' AND recon = '0' AND bacc = $bnktid AND pmode = 'CHEQUE' AND isdeposited <> '0' UNION
                SELECT DATE_FORMAT(depots, '%Y-%m-%d') as rdate ,recpno,amount,'Deposit No' as doctype,'uncleared' as doc,isdeposited,concat(pmode,' ','No:',' ',chqno,' ',chqdet) AS pmode,depots as ts FROM recptrans_temp WHERE DATE_FORMAT(depots, '%Y-%m-%d') <= '$edate11' AND est_id LIKE '$est_id' AND recon = '0' AND bacc = $bnktid AND pmode = 'CHEQUE'  UNION                
                SELECT jdate as date,jvno as docno,IF(dbtacc='$bnktid' AND dbacc = '1',amount,'0')as amount,'J.V No' as doctype ,'jv' as doc,jvno, rmks AS pmode,ts FROM jentry where jdate  <= '$edate11' AND estId = '$est_id' AND (dbtacc = '$bnktid') AND recon = '0' ORDER BY rdate,ts";
        
       // $qrry= "SELECT DATE_FORMAT(depots, '%Y-%m-%d') as rdate ,isdeposited as recpno,amount,'Deposit No' as doctype,'recp' as doc,IF(pmode='CASH',pmode,concat(pmode,' ','No:',' ',chqno,' ',chqdet)) AS pmode,depots as ts FROM recptrans WHERE DATE_FORMAT(depots, '%Y-%m-%d') <= '$edate11' AND est_id LIKE '$est_id' AND recon = '0' AND bacc = $bnktid  UNION
        //            SELECT jdate as date,jvno as docno,IF(dbtacc='$bnktid' AND dbacc = '1',amount,'0')as amount,'J.V No' as doctype ,'jv' as doc, rmks AS pmode,ts FROM societies_jentry where jdate  <= '$edate11' AND societyid = '$est_id' AND (dbtacc = '$bnktid') AND recon = '0' ORDER BY rdate,ts";

  $data34=$mumin->getdbContent($qrry);
  for($i=0;$i<=count($data34)-1;$i++){
      echo '<tr><td style="width:100px" colspan="2">&nbsp;&nbsp;'.date('d-m-Y', strtotime($data34[$i]['rdate'])).' <input style="display:none" value="'.$data34[$i]['recpno'].'" id="recpnorecon'.$i.'"></input></td><td style="width:400px" colspan="2">&nbsp;'.$data34[$i]['doctype'].': '.$data34[$i]['isdeposited'].' - '.$data34[$i]['pmode'].' <input style="display:none" value="'.$data34[$i]['doc'].'" id="doctype'.$i.'"></input></td><td style="width:100px; text-align: right;padding-right: 10px" colspan="2">'.number_format($data34[$i]['amount'],2).'</td><td style="width:60px; text-align: center"><input type="checkbox" id="recprecon'.$i.'" value="'.$data34[$i]['amount'].'" class="recpreconclas"></input></td></tr>';
  }
          ?>
</table>
</div>

<div style="width:615px; margin: 5px; height:350px; overflow:auto;">
    <table id="report6" >
      
<thead><tr><th colspan="7">Payments</th></tr></thead>
    <tr style="font-weight: bold;"><td style="width:100px;" colspan="2">Date</td><td style="width:400px" colspan="2">Narration</td><td style="width:100px" colspan="2">Amount</td><td style="width:40px">Status</td></tr>
    <?php       $qrly="SELECT pdate,payno,amount,'Payment V. No' as doctype ,'pv' as doc, IF(pmode='CASH',pmode,concat(pmode,' ','No:',' ',chqno,' ',chqdet)) AS pmode FROM paytrans WHERE pdate <= '$edate11' AND estId LIKE '$est_id' AND bacc = $bnktid AND recon = '0' UNION
                  SELECT jdate as date,jvno as docno,IF(crdtacc='".$bnktid."' AND cbacc = '1' ,amount,'0')as amount,'J.V No' as doctype ,'jv' as doc, rmks AS pmode FROM jentry where jdate <= '$edate11'  AND estId = '$est_id' AND (crdtacc = '$bnktid') AND 	crdtaccrecon = '0' UNION 
                  SELECT date,docno,amount,doctype,doc,pmode FROM (SELECT dexpdate as date,dexpno as docno,IF(cacc='$bnktid' ,amount,amount*-1)as amount,'Direct Expense' as doctype ,'de' as doc,rmks AS pmode,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,ts FROM directexpense WHERE dexpdate <= '$edate11'  and estate_id ='$est_id' AND recon = '0')t7 WHERE bankacct = '$bnktid'    ORDER by pdate ";
              
                
          $data43=$mumin->getdbContent($qrly);
  for($i=0;$i<=count($data43)-1;$i++){
      echo '<tr><td style="width:100px" colspan="2">&nbsp;&nbsp;'.date('d-m-Y', strtotime($data43[$i]['pdate'])).' <input style="display:none" value="'.$data43[$i]['payno'].'" id="paynorecon'.$i.'"></input></td><td style="width:200px" colspan="2">&nbsp;&nbsp;'.$data43[$i]['doctype'].':'.$data43[$i]['payno'].' - '.$data43[$i]['pmode'].' <input style="display:none" value="'.$data43[$i]['doc'].'" id="withdrawaldoc'.$i.'"></input></td><td style="width:100px; text-align: right" colspan="2">'.number_format($data43[$i]['amount'],2).'&nbsp;&nbsp;</td><td style="width:60px; text-align: center"><input type="checkbox" id="paytrecon'.$i.'" value="'.$data43[$i]['amount'].'" class="paymentreconclas"></input></td></tr>';
  }  
    ?>
    </table>
</div>
    <div>
     
    </div>
</div>
<hr />
   <table style="margin-bottom: 20px; margin-left: 50px">
            <tr><td></td><td></td><td></td>
                <td style="color: blue;font-weight: bold">Opening Balance</td><td><input class="formfield" id="oppenblnce" readonly="true" value="<?php echo number_format($oppenbal,2);?>"></input></td><td style="width:105px"></td>
                <td></td><td></td>
            </tr>
            <tr><td><b>Total Deposits</b></td><td><input class="formfield" id="receiptsum" value="0" readonly="true"></input></td><td style="width:105px"></td> 
                <td style="color: green;font-weight: bold">Cleared Balance</td><td><input class="formfield" readonly="true" id="cleardbal" value="<?php echo number_format($oppenbal,2);?>"></input></td><td><input type="hidden" id="saveasbankop"></input></td>
               <td><b>Total Payments</b></td><td><input class="formfield" value="0" id="paymentsum" readonly="true"></input></td> 
            </tr>
            <tr><td></td><td></td><td></td>
                <td style="color: #903;font-weight: bold">Bank Balance</td><td><input class="amount" id="clsingbalance" value="0" ></input></td><td></td>
                <td></td><td></td>
            </tr>
       <tr><td></td><td></td><td></td>
            <td style="color: red;font-weight: bold">Difference</td><td><input class="formfield" readonly="true" id="recondifference"></input></td><td></td>
                <td colspan="2"><button id="recdif"> Reconcile Difference </button> </td>
            </tr>
       <tr><td></td><td></td><td></td>
           <td  style="text-align: center; " colspan="2"><button style="margin-top: 15px;" id="updaterecon">UPDATE</button>     <button id="cancelrecon" onclick="window.close();" >CANCEL</button></td><td></td>
                <td></td><td></td>
            </tr>
       </table>
<?php
//echo '<br></br><div id="report">Please check your balance and bring any discrepancies within 15 days</div> <br /><br />';
echo '<br></br><span align="left" style="font-size:x-small">Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span> </div> <br />';
echo '<div style="page-break-after:always"> </div>';
  echo"</table>";
          
?>
 <div id="recondiff" style="display: none" title="Reconcilliation">
                <fieldset style="-moz-border-radius: 7px; border: 1px #dddddd solid; "><legend style="border: 1px #1a6f93 dotted;font-size: 13px;padding-right: 5px;padding-left: 5px;padding-top: 2px;padding-bottom: 2px;-moz-border-radius: 3px; width: 200px; font-weight: bold">Recon</legend>
 
                    <label>Cleared Balance:</label><input type="text" id="clrdbalance" class="formfield" disabled /><br style="clear: left;" /><br/>
 
<label>Bank Balance:</label><input type="text" id="closingbalance" class="formfield" disabled /><br style="clear: left;" /><br/>
  
<label>Difference: </label><input type="text" id="diffrecon" class="formfield" disabled/><input type="text" id="diffreconstat" class="formfield" disabled style="display:none"/><br style="clear: left;" /><br/>
</fieldset>
     <label><input type="radio" name="typ" checked="checked" id="incmeacts" ><span> Income</span></label>
     <label><input type="radio" name="typ" id="expnsaccts"><span> Expense</span></label><br style="clear: left;" /><br/>
     <div id="diffincome"> 
         <fieldset style="-moz-border-radius: 7px; border: 1px #003300 solid; "><legend style="border: 1px #003300 dotted;background: #CCC;font-size: 13px;padding-right: 5px;padding-left: 5px;padding-top: 2px;padding-bottom: 2px;-moz-border-radius: 3px; width: 200px; font-weight: bold; border-radius: 3px">Income</legend>
 
             <label>Date: </label><input type="text" id="incmerecondate" class="formfield" value="<?php echo date('d-m-Y',strtotime($edate2)) ?>"/><br style="clear: left;" /><br/>
 <label>Account: </label><select  class="formfield" id="incmereconacc"><option value="">-select--</option> 
                                <?php
                                          
                                $qr="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'G' AND incomeactmgnt.deptid = '$id' GROUP BY incomeaccounts.incacc ORDER BY accname asc"; 
                                
                                $data=$mumin->getdbContent($qr);
                                
                                 for($h=0;$h<=count($data)-1;$h++){
                      
                                     echo "<option value=".$data[$h]['incacc'].">".$data[$h]['accname']."</option>";
                                   } 
                            
                            ?>
                        </select><br style="clear: left;" /><br/>
 <label>Amount: </label><input type="text" id="reconincmeamnt" class="amount"/><br style="clear: left;" /><br/>
 <label>Remarks: </label><input type="text" id="reconincmermks" class="formfield"/><br style="clear: left;" /><br/>
   <label><button id="incmebtn"><span>Ok</button></label>
   </fieldset>
     </div>
     <div style="display: none" id="diffxpense"> 
         <fieldset style="-moz-border-radius: 7px; border: 1px #003300 solid; "><legend style="border: 1px #1a6f93 dotted; background-color: #9c8468; font-size:13px;padding-right: 5px;padding-left: 5px;padding-top: 2px;padding-bottom: 2px;-moz-border-radius: 3px; width: 200px; font-weight: bold">Expense</legend>
 
             <label>Date: </label><input type="text" id="expensedate" readonly="true" class="formfield" value="<?php echo date('d-m-Y',  strtotime($edate2)) ?>"></input><br style="clear: left;" /><br/>
 <label>Account: </label><select id="reconexpnacc" class="formfield">
                      <option value="" selected>--Expense Account--</option>
                     <?php
                      
                      $qry="SELECT expnseaccs.id,expnseaccs.accname FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id  AND expenseactmgnt.deptid = '$id' GROUP BY expnseaccs.id ORDER BY accname asc";
                      
                      $data11=$mumin->getdbContent($qry);
                      
                      for($k=0;$k<=count($data11)-1;$k++){
                          
                          echo "<option value='".$data11[$k]['id']."'>".$data11[$k]['accname']."</option>";
                      }
                      ?> 
                      
                      
                  </select><br style="clear: left;" /><br/>
  <label>Cost Centre: </label><input id="expcstcenter" value=""  name="expcstcenter"  class="formfield" /><input  type="hidden" readonly="readonly" id="expcstcntreid"/><br style="clear: left;" /><br/>                
 <label>Amount: </label><input type="text" id="reconexpamnt" class="amount" /><br style="clear: left;" /><br/>
 <label>Remarks: </label><input type="text" id="reconexprmks" class="formfield"/><br style="clear: left;" /><br/>
   <label><button id="expensebtn"><span>Ok</button></label>
   </fieldset>
         <?php 
         $qru=  "SELECT DATEDIFF('$lastrecondate','".date('Y-m-d')."') AS DiffDate";
                                    $datau=$mumin->getdbContent($qru);
                                     echo "<input hidden='true' type='text' id='clsingdate'  class='formfield' value='".$datau[0]['DiffDate']."'>";
          $qru23=  "SELECT DATEDIFF('$edate11','".date('Y-m-d')."') AS DiffDate";
                                    $datau23=$mumin->getdbContent($qru23);
                                     echo "<input hidden='true' type='text' id='clsingdatedt'  class='formfield' value='".$datau23[0]['DiffDate']."'>";

         ?>
     </div>
                   </div>
<div id="contents" style="display: none">
    
</div>
    </body>
</html>