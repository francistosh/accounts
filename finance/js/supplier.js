$(function(){
    
       $("#savbill").click(function(){ 
   
   $("#d_progress").show(); basicLargeDialog("#d_progress",50,150);
       var $date,$docno,$amount,$supplier,$expacc,$remarks,$ccid,$doctype,$supplamt,$addtax,$suplrsubacc,$costcntre;
       
       $date=$.trim($("#billdate").val());
       $docno=$.trim($("#billno").val());
       $amount=$.trim($("#billamount").val().replace(/[^0-9\.]+/g,""));
       $supplier=$.trim($("#billsupplier").val());
       $expacc=$.trim($("#expnacc").val());
       $remarks=$.trim($("#billrmks").val());
       $ccid=$.trim($("#ccid").val());
       $supplamt=$("#supplamt").val();
       $addtax=$("#addtax").val();
       $doctype=$.trim($("#doctype").val());
       $suplrsubacc=$.trim($("#suplrsubacc").val());
       $costcntre = $.trim($("#costcntreid").val());
       var crdtinvno = $("#crdtinvno").val();
       
       if($date!=="" && $docno!=="" && $amount!=="" && $supplier!=="" && $expacc!=="" && $costcntre!==""){
          
            if($doctype=='0'){
            $.getJSON("../finance/redirect.php?action=validateamounte&crdtinvoiceno="+crdtinvno+"&supplier="+$supplier+"&bilamnt="+$amount+"&costcntreid="+$costcntre, function(data) {
  
     if(data.available =='1'){
                
                 saveSupplierBill($date, $docno, $amount, $supplier, $expacc, $remarks,$ccid,$doctype,$supplamt,$addtax,crdtinvno,$suplrsubacc,$costcntre);
     }
    else if(data.available == '0'){
         $("#d_progress").dialog("destroy");
            $.modaldialog.warning("<br></br><b>DEBIT NOTE AMOUNT SHOULD NOT BE MORE THAN INVOICE AMOUNT</b>", {
             width:400,
             showClose: true,
             title:"ERROR"
            });
                 }
        
 
    });
       }
       else if ($doctype=='1'){
           $.getJSON("../finance/redirect.php?action=existingbill&crdtinvoiceno="+$docno+"&supplier="+$supplier+"&bilamnt="+$amount+"&costcntreid="+$costcntre, function(data) {
               //alert(data.existing);
               if(data.existing == '0'){
                saveSupplierBill($date, $docno, $amount, $supplier, $expacc, $remarks,$ccid,$doctype,$supplamt,$addtax,crdtinvno,$suplrsubacc,$costcntre);

               }
               else if(data.existing == '1'){
                   $("#d_progress").dialog("destroy");
                  $.modaldialog.warning("<br></br><b>BIll No: "+$docno+" already Exists</b>", {
             width:400,
             showClose: true,
             title:"ERROR"
            }); 
               }
           });
              
        }
    }
       else{
           $("#d_progress").dialog("destroy");
           $.modaldialog.warning('<br></br><b>Field marked with * MUST be filled</b>', {
             timeout: 15,
             width:500,
             showClose: true,
             title:"Missing Data"
            });
       }
        
   
   });
   
          $("#savb").click(function(){ 
   
       var $date,$docno,$amount1,$amount2,$amount3,$amount4,$supplier,$expacc,$remarks,$ccid,$doctype,$supplamt,$multibilltotal,$suplrsubacc,$costcntre1,$costcntre2,$costcntre3,$costcntre4;
       
       $date=$.trim($("#mbilldate").val());
       $docno=$.trim($("#mbillno").val());
       $amount1=$.trim($("#billamount1").val().replace(/[^0-9\.]+/g,""));
       $amount2=$.trim($("#billamount2").val().replace(/[^0-9\.]+/g,""));
       $amount3=$.trim($("#billamount3").val().replace(/[^0-9\.]+/g,""));
       $amount4=$.trim($("#billamount4").val().replace(/[^0-9\.]+/g,""));
       $supplier=$.trim($("#mbillsupplier").val());
       $expacc=$.trim($("#mexpnacc").val());
       $remarks=$.trim($("#mbillrmks").val());
       $doctype=$.trim($("#mdoctype").val());
       $multibilltotal=$.trim($("#multibilltotal").val().replace(/[^0-9\.]+/g,""));
       $suplrsubacc=$.trim($("#suplrsubacc").val());
       $costcntre1 = $.trim($("#costcntreid1").val());
       $costcntre2 = $.trim($("#costcntreid2").val());
       $costcntre3 = $.trim($("#costcntreid3").val());
       $costcntre4 = $.trim($("#costcntreid4").val());
       var costcentres = "", cocenteramnts = ""; 
       
       if($date!=="" && $docno!=="" && $supplier!=="" && $expacc!=="" && $costcntre1!=="" && $multibilltotal > 0){
          
                  for(var j=1;j<=$(".centramnt").length;j++){
         
     if ($("#billamount"+j).val().replace(/[^0-9\.]+/g,"") > 0) {
          var $costcenterid =$("#costcntreid"+j).val();
           
           costcentres+=$costcenterid+",";
           var $billamnt = $.trim($("#billamount"+j).val().replace(/[^0-9\.]+/g,""));
           cocenteramnts+=$billamnt+",";
           
         
            } else{} 
            //alert(costcentres);
           
     }
                   $.getJSON("../finance/redirect.php?action=existingmultibill&crdtinvoiceno="+$docno+"&supplier="+$supplier+"&bilamnt="+cocenteramnts+"&costcntreid="+costcentres, function(data) {
               //alert(data.existing);
               if(data.existing == '0'){
                    saveSupplierBillH($date, $docno, cocenteramnts, $supplier, $expacc, $remarks,$ccid,$doctype,$suplrsubacc,costcentres);
               }
               else if(data.existing == '1'){
                   //$("#d_progress").dialog("destroy");
                  $.modaldialog.warning("<br></br><b>BIll No: "+$docno+" already Exists</b>", {
             width:400,
             showClose: true,
             title:"ERROR"
            }); 
               }
                   
                   }); 
                  
      
              }
       else{
           
           $.modaldialog.warning('<br></br><b>Field marked with * MUST be filled</b>', {
             timeout: 15,
             width:500,
             showClose: true,
             title:"Missing Data"
            });
       }
        
   
   });
   
                $("#appndbutn").click(function(){ 
                 
   var rowcount = $("#suppdebtsrowcount").val();
  $("#debttfield").css("display","block");
   $("#debttinfo").empty();
  
   for (var u=1;u <=rowcount;u++ ){
     $("#debttinfo").append('<tr><td><select class="formfield dc" style="width: 50px" id="ledger_dc'+u+'"><option value="dr" selected>Dr</option><option  value="cr">Cr</option></select></td>\n\
                                    <td><select class="formfield ledgerids" id="ledgerid'+u+'"><option selected value="">--Select--</option></td>\n\
                                    <td><input id="dbtamnt'+u+'"  value="0" class="amount dramount" disabled="true" onkeyup="updatedrdebtamnt('+u+')" onchange="updatesuppdebtdiff() "/></td><td><input id="crdtamnt'+u+'" value="" class="amount cramount" disabled="true" onkeyup="updatecrdebtamnt('+u+')" onchange="updatesuppdebtdiff()"/></td>\n\
                                    <td hidden="true" class="tbltype"></td></tr>'); 
            
        }
 getsuppdebtaccounts();
   $("#debttinfo").append('<tr><td></td></tr><tr style="height: 30px;"><td></td><td style="font-size:14px">Total</td><td style="background-color: yellowgreen;  font-size:14px" id="drtotal"></td><td style="background-color: yellowgreen;font-size:14px" id="crtotal"></td></tr>\n\
                             <tr><td></td></tr><tr style="height: 30px;"><td></td><td style="font-size:12px; color: red">Difference</td><td id="dr-diff"></td><td id="cr-diff"></td></tr>\n\
                            \n\<tr><td>Cost Centre:</td><td><select class="formfield" id="badincmeacct"></select></td></tr>\n\
                            <tr><td>Date:</td><td><input type="text" class="formfield" id="journaldate" /></td></tr>\n\
                            <tr><td>Rmks:</td><td><textarea class="formfield" id="journalrmks"/></td></tr>');
                getbadcostcntre();
   $("#journaldate" ).datepicker({ dateFormat: 'dd-mm-yy',changeMonth: true} );
    });
   
   
        $("#chooseSupplier").change((function(){  // choose supplier event action
        
        
        $("#investamont").val("0.00"); //reset amount fields
        $("#amountt100").val("0.00");
        $("#invamountt100").val("0.00"); //reset amount fileds
        if($(this).val()==""){
        $.modaldialog.prompt('<br></br><b>No Supplier Selected</b>', {
             timeout: 15,
             width:500,
             showClose: true,
             title:"Information"
            });
         $("#billstable1").css("display","none");
         $("#tabs").css("display","none");
        }
    else{
        retriveUnpaidBills($("#chooseSupplier").val());
        }
   }));
    
      $("#cshpay300").click(function(){  //complete cash payment for invoices
       if($(".topayhalf:checked").length>1){
          //alert ('Only one can be paid half');
          $.modaldialog.warning('<br></br><b>Partial Payment allowed for only one Bill</b>', {
             timeout: 5,
             width:500,
             showClose: false,
             title:"Warning"
            });
      }else {
      
      var $docnumbers="";  //global variable to hold invoice numbers for payment
      var $individualamount="";   //global variable to hold invoice amount for payment
      var $costcentre = "";
      
      var $amount=$.trim($("#amountt100").val());
   
      var $paymentdate=$.trim($("#cshpaymentdt100").val());
      
      var $expacc=$.trim($("#expnseaccounts").val());
      
      var $acc=$.trim($("#cshbankaccount").val());
      
      var $remarks=$.trim($("#cshrmks100").val());
      
      var $supplier=$.trim($("#chooseSupplier").val());
      
     // var $costcentre =  $.trim($("#costc").val());
        
     
     if(parseInt($("#investamont").val())<1){
         
          $.modaldialog.warning('<br></br><b>ALL Fields MUST be filled before proceeding</b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Warning"
            });
           
         
     }
     
     else{
     
     
      var paymentArray=new Array();
     for(var j=0;j<=$(".unpaidcheckbox").length;j++){
         
     if ($("#unpcx"+j).is(':checked')) {
          
           var $id=$("#unpcx"+j).attr("id");
           
           var $docnos=document.getElementById("bxn"+$id.substring(5)).textContent;
           
             $docnumbers+=$docnos+",";
             var costcntre = document.getElementById("ccenterid"+$id.substring(5)).textContent;
             $costcentre += costcntre+",";
           var $iamount1 = document.getElementById("amnt2pay"+$id.substring(5)).value;
           $individualamount+=$iamount1+",";
       paymentArray.push({'0':$iamount1,'1':document.getElementById("ccenterid"+$id.substring(5)).textContent}); //push receipt numbers to Array
           
         
            } else{} 
            
            
     }
      
   makeCashPaymentToOutstandingInvoices($supplier,$docnumbers,$individualamount,$amount,$paymentdate,$acc,$remarks,$expacc,$costcentre,paymentArray);
     
     
   }}
   
       
   });
   
      $("#ckpay300").click(function(){  //complete cheque payment for invoices
       
       if($(".topayhalf:checked").length>1){
          //alert ('Only one can be paid half');
          $.modaldialog.warning('<br></br><b>Partial Payment allowed for only one Bill</b>', {
             timeout: 5,
             width:500,
             showClose: false,
             title:"Warning"
            });
      }else {
       
      var $docnumbers="";  //global array to hold invoice numbers for payment
      var $individualamount="";   //global variable to hold invoice amount for payment
      var $costcentre = "";
      var $chequedate=$.trim($("#invoicechqdate").val());
      
      var $chequeno=$.trim($("#invoicechqno").val());
    
      var $amount=$.trim($("#investamont").val());
      
     // var $costcentre =  $.trim($("#costc").val());
   
      var $paymentdate=$.trim($("#invoicepaymentdt100").val());
      
      var $expacc=$.trim($("#expnseaccounts").val());
      
      var $acc=$.trim($("#invoicebankaccount").val());
      
      var $remarks=$.trim($("#invoiceckrmks100").val());
      
     var $supplier=$.trim($("#chooseSupplier").val());
     
     if(parseInt($("#investamont").val())<1  || $remarks===""  || $chequedate==="" || $chequeno==="" || $expacc ==""){
         
          $.modaldialog.warning('<br></br><b>ALL Fields MUST be filled before proceeding</b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Warning"
            });
           
         
     }
     
     else{
     
     var paymentArray=new Array();
     
     for(var j=0;j<=$(".unpaidcheckbox").length;j++){
         
     if ($("#unpcx"+j).is(':checked')) {
          
           var $id=$("#unpcx"+j).attr("id");
           
           var $docnos=document.getElementById("bxn"+$id.substring(5)).textContent;          
             $docnumbers+=$docnos+",";
             var costcntre = document.getElementById("ccenterid"+$id.substring(5)).textContent;
             $costcentre += costcntre+",";
           var $iamount1 = document.getElementById("amnt2pay"+$id.substring(5)).value;
           $individualamount+=$iamount1+",";
        paymentArray.push({'0':$iamount1,'1':document.getElementById("ccenterid"+$id.substring(5)).textContent}); //push receipt numbers to Array
           
         
            } else{} 
            
            
     }
      
     makePaymentToOutstandingInvoices($supplier,$docnumbers,$individualamount,$chequedate,$chequeno,$amount,$paymentdate,$acc,$remarks,$expacc,$costcentre,paymentArray);
     
     
   }
      }
       
   });
   $('#dprtmntchk').click(function(){
       $("#expnacc").css("display","none");
       $("#cctr").css("display","block");
       $("#tdeprtmnt").css("display","block");
       $("#tdexpnse").css("display","none");
       $("#expnacc").val("");
       $("#cctrid").val("all");
   });
   $('#expechk').click(function(){
       $("#expnacc").css("display","block");
       $("#cctr").css("display","none");
       $("#cctrid").val("");
       $("#cctr").val("");
       $("#tdeprtmnt").css("display","none");
        $("#tdexpnse").css("display","block");
   });
   $("#doctype").change(function(){
       var biltype = $("#doctype").val();
       if(biltype=='0'){
          $("#invnotd").show();
          $("#crdtinvno").show();
		  $("#billsupplier").val("");
		  $("#crdtinvno").val("");
		  $("#billno").val("");
		  $("#billamount").val("");
		  $("#expnacc").val("");
		  $("#billrmks").val("");
       }
   else if (biltype=='1'){
    //   $("#invnotd").hide();
       $("#invnotd").hide('blind', function () {
  $(this).remove();
});
         // $("#crdtinvno").hide();
                $("#crdtinvno").hide('blind', function () {
  $(this).remove();
});
		  $("#billsupplier").val("");
		  $("#crdtinvno").val("");
		  $("#billno").val("");
		  $("#billamount").val("");
		  $("#expnacc").val("");
		  $("#billrmks").val("");
   }
       
   });
   

       $("#expnacc").change(function(){  
     
     //     $("#loader").css("visibility","visible");
     
          $('#suplrsubacc').empty();  
                     
           $.getJSON("../finance/json_redirect.php?action=subexpnseaccnt&acctid="+$(this).val(), function(data) {
           
           $("#suplrsubacc").append("<option value=''>--Select--</option>");
           for(var $i in data){
           // $('#suplrsubacc').append($('<option>').text(data[i]['accname']).attr('value',data[i]['id'])); 
           $("#suplrsubacc").append("<option value="+data[$i]['id']+">"+data[$i]['accname']+"</option>");
          };
        //  $("#loader").css("visibility","hidden"); 
    });
   });
   
   $("#reprintpv").click(function(){
      // alert('fsfs');
      var payvno =  $.trim($("#payvno").val());
      if (payvno==""){
             $.modaldialog.warning('<br></br><b>No blanks allowed</b>', {
             timeout: 4,
             width:500,
             showClose: true,
             title:'Warning'
            });

           
     }
      else{
      $datas ={payvno:payvno};
      var $url="../finance/json_redirect.php?action=reprintingpaymentvchr";
      $.ajax({
          url: $url,
                
                type: "GET",
                
                dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
                data:$datas,
          success: function(response) {
              if(response.url !== ""){
              window.open(response.url,'_self','width=800,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
             $("#payvno").val("");
              }
            else{
                $.modaldialog.warning('<br></br><b> Payment Voucher not found</b>', {
             timeout: 4,
             width:500,
             showClose: true,
             title:'Warning'
            });
            }
          }
      });
  }
   });
});
function saveSupplierBill($date,$docno,$amount,$supplier,$expacc,$remarks,$ccid,$doctype,$supplamt,$addtax,crdtinvno,$suplrsubacc,$costcntre){
    
    
     var $dataString={date:$date,docno:$docno,amount:$amount,supplier:$supplier,expacc:$expacc,remarks:$remarks,ccid:$ccid,doctyp:$doctype,suppamt:$supplamt,taxamnt:$addtax,crdtinvno:crdtinvno,suplrsubacc:$suplrsubacc,costcntre:$costcntre};
        
      var $urlString="../finance/json_redirect.php?action=savesupplierbill";

               $.ajax({                                                                        
                
                url: $urlString,
                
                type: "GET",
                
                dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
                data:$dataString,
                
                success: function(response) {
                
                 
            if(response.id===1){ 
             
             $("#d_progress").dialog("destroy");
         
             
             $("#supplierbill").dialog("destroy");
             if($doctype =='1'){
            $.modaldialog.success('<b>Bill Saved Successfully</b>', {
             width:400,
             showClose: true,
             title:"SUCCESS"
            });
              }else if($doctype =='0'){
                $.modaldialog.success('<b>Debit Note Saved Successfully</b>', {
             width:400,
             showClose: true,
             title:"SUCCESS"
            });  
              }
              
           //$("#billdate").val("");
           $("#billno").val("");
           $("#billamount").val("0.00");
           $("#billsupplier").val("");
           $("#expnacc").val("");
           $("#billrmks").val("");
            $("#supplamt").val("");  
           $("#affertax").val("");
           $("#addtax").val("");
           $("#suplrsubacc").val("");
            $("#costcntre").val("");
             $("#costcntreid").val("");
           $("#ratetax").val(0);
           
                 }
             else{
              
             $("#d_progress").dialog("destroy");
               
             alert("Bill not saved-please try again later");
              
              
                    
             }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
                  alert("Bill not saved-please try again later");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              //alert("Bill not saved-please try again later");
                
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              });      
                 
    
}
function saveSupplierBillH($date, $docno, cocenteramnts, $supplier, $expacc, $remarks,$ccid,$doctype,$suplrsubacc,costcentres){
    
    
     var $dataString={date:$date,docno:$docno,amount:cocenteramnts,supplier:$supplier,expacc:$expacc,remarks:$remarks,ccid:$ccid,doctyp:$doctype,suplrsubacc:$suplrsubacc,costcntre:costcentres};
        
      var $urlString="../finance/json_redirect.php?action=savesuppliermultiplebill";

               $.ajax({                                                                        
                
                url: $urlString,
                
                type: "GET",
                
                dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
                data:$dataString,
                
                success: function(response) {
                
                 
            if(response.id===1){ 
             
             $("#d_progress").dialog("destroy");
         
             
             $("#supplierbill").dialog("destroy");
             if($doctype =='1'){
            $.modaldialog.success('<b>Bill Saved Successfully</b>', {
             width:400,
             showClose: true,
             title:"SUCCESS"
            });
            
              }else if($doctype =='0'){
                $.modaldialog.success('<b>Credit Note Saved Successfully</b>', {
             width:400,
             showClose: true,
             title:"SUCCESS"
            });  
              }
              
           //$("#billdate").val("");
           $("#mbillno").val("");
           $("#billamount1").val("0.00");$("#billamount2").val("0.00");$("#billamount3").val("0.00");$("#billamount4").val("0.00");
           $("#mbillsupplier").val("");  $("#multibilltotal").val("0.00");
           $("#mexpnacc").val("");
           $("#mbillrmks").val("");
            $("#suplrsubacc").val("");
            $("#costcntre1").val(""); $("#costcntre2").val(""); $("#costcntre3").val(""); $("#costcntre4").val("");
             $("#costcntreid1").val(""); $("#costcntreid2").val(""); $("#costcntreid3").val(""); $("#costcntreid4").val("");
           $("#ratetax").val(0);
           
                 }
             else{
              
             $("#d_progress").dialog("destroy");
               
             alert("Bill not saved-please try again later");
              
              
                    
             }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
                  alert("Bill not saved-please try again later");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              });      
                 
    
}
function updatemutlibillamnt(i){
    var samount = 0;
     $(".centramnt").each(function(){
        samount += +$(this).val().replace(/[^0-9\.]+/g,"");
    });
    $("#multibilltotal").val(samount);
}
function retriveUnpaidBills($supplier){
    
   var $dataString={supplier:$supplier};
   
    $("#tabs").css("display","none") ;
        
      var $urlString="../finance/json_redirect.php?action=getunpaidbills";

               $.ajax({                                                                        
                
                url: $urlString,
                
                type: "GET",
                
                dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
                data:$dataString,
                
                success: function(response) {
                
                 
               if(response.length>0){ 
             
           $("#d_progress").dialog("destroy");
           
           $("#tabs").css("display","block");
           $("#tabs").css("visibility","visible");  
           $("#billstable1").empty(); 
             
           $("#billstable1").append("<thead ><tr><th style='font-size: 12px;'>Date.</th><th style='font-size: 12px;'>Type</th><th style='font-size: 12px;'>Doc No.</th><th style='font-size: 12px;'>Account</th><th style='font-size: 12px;'>C.Center</th><th style='font-size: 12px;'>Amount</th><th style='font-size: 12px;'>Paid</th><th style='font-size: 12px;'>To Pay</th><th style='font-size: 12px;'>Pay</th></tr></thead>");
           
           $("#billstable1").append("<tbody>");
            
             for(var $t in response){
                               if (parseInt(response[$t]['amount'])>0){
                  var display ='block';
                  var docname = 'Bill';
                  
                            }
                        else if(parseInt(response[$t]['amount'])<0){
                          display ='none';
                          docname = 'Credit Note';
                        }
              $("#billstable1").append("<tr style='font-weight: bold'><td>"+response[$t]['bdate']+"</td><td>"+docname+"</td><td id='bxn"+$t+"'>"+response[$t]['docno']+"</td><td>"+response[$t]['accname']+"</td><td>"+response[$t]['centrename']+"</td><td style='display:none;' id='ccenterid"+$t+"'>"+response[$t]['costcentrid']+"</td><td id='cxam"+$t+"'>"+response[$t]['amount']+"</td><td id='amtpd"+$t+"'>"+response[$t]['pdamount']+"</td>"+ 
             "<td><input type='text' id='amnt2pay"+$t+"' onkeyup='updateamtup("+$t+")'   min='0' style='display: "+display+"' /></td><td><input type='checkbox' class='unpaidcheckbox' id='unpcx"+$t+"'/><input type='checkbox' class='topayhalf' id='unpchbx"+$t+"'hidden/><input type='text' hidden id='expenid"+$t+"' value='"+response[$t]['expenseacc']+"'/><input type='text' hidden id='costcntrid"+$t+"' value='"+response[$t]['costcentrid']+"'/></td></tr>");
             
            
             }
              
            $("#billstable1").append("</tbody>");  
              
            // $("#tabs").css("display","block") ;
            
           // pulloutlinkedaccountinvoices($cc);
             
                 }
             else{
              
             
                   $("#d_progress").dialog("destroy"); 
                
                   $("#billstable1").empty(); 
            //  $("#tabs").hide('blind', function () {
 // $(this).remove();
//});
                 $("#tabs").css("visibility","hidden");
              
               $.modaldialog.prompt('<br></b>No Outstanding/Unpaid Bill found</b>', {
             timeout: 15,
             width:500,
             showClose: true,
             title:"Information"
            });
           
         
     
                    
             }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
                  alert("No Bill found");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
             //  $(".ui-dialog-titlebar").hide();
             $(".ui-dialog-titlebar").hide('blind', function () {
  $(this).remove();
});
             }
                 
              });      
                 
}
function  makeCashPaymentToOutstandingInvoices($supplier,$docnumbers,$individualamount,$amount,$paymentdate,$acc,$remarks,$expacc,$costcentre,paymentArray){
    
    
     var $dataString={supplier:$supplier,docnumbers:$docnumbers,individualamt:$individualamount,amount:$amount,paymentdate:$paymentdate,acc:$acc,remarks:$remarks,expacct:$expacc,ccnter:$costcentre,pymntarry:paymentArray};
        
      var $urlString="../finance/json_redirect.php?action=invoicepaymentcsh";

               $.ajax({                                                                        
                
                url: $urlString,
                
                type: "GET",
                
                dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
                data:$dataString,
                
                success: function(response) {
                
                 
            if(response.id===1){ 
             
             $("#d_progress").dialog("destroy");
         
              
              window.location="../finance/cashpaymentvoucher.php?supplier="+$supplier+"&docnumbers="+$docnumbers+"&amount="+response.camnts+"&paymentdate="+$paymentdate+"&acc="+$acc+"&payno="+response.payno+"&rmks="+$remarks+"&expacc="+$expacc+"&costcid="+$costcentre;
                       reloadSearchpendingbills(); 
                 }
                 else if(response.id==='0'){
               
               $("#d_progress").dialog("destroy");
               
             $.modaldialog.warning('<br><b>Sorry. The selected Bank Balance is not enough to complete this request.<b>', {
             width:400,
             showClose: true,
             title:"Low Balance"
            });
           
                 }
                  else if(response.id==="Error"){
               
               $("#d_progress").dialog("destroy");
               
             $.modaldialog.warning('Sorry .Invalid amount', {
             width:400,
             showClose: true,
             title:"Invalid Data"
            });
           
                 }
             else{
              
             $("#d_progress").dialog("destroy");
                 
                alert("Payment not completed-please try again later");
              
              
                    
             }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
                  alert("Payment not completed-please try again later");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              }); 
    
    
}


function makePaymentToOutstandingInvoices($supplier,$docnumbers,$individualamount,$chequedate,$chequeno,$amount,$paymentdate,$acc,$remarks,$expacc,$costcentre,paymentArray){
    
    var $dataString={supplier:$supplier,docnumbers:$docnumbers,individualamt:$individualamount,chequedate:$chequedate,chequeno:$chequeno,amount:$amount,paymentdate:$paymentdate,acc:$acc,remarks:$remarks,expacct:$expacc,ccentreid:$costcentre,pymntarry:paymentArray};
        
      var $urlString="../finance/json_redirect.php?action=invoicepayment";

               $.ajax({                                                                        
                
                url: $urlString,
                
                type: "GET",
                
                dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
                data:$dataString,
                
                success: function(response) {
                
                 
            if(response.id===1){ 
             
             $("#d_progress").dialog("destroy");
         
              
              window.location="../finance/paymentvoucher.php?supplier="+$supplier+"&docnumbers="+$docnumbers+"&chequedate="+$chequedate+"&chequeno="+$chequeno+"&amount="+response.camnts+"&narration="+$remarks+"&paymentdate="+$paymentdate+"&acc="+$acc+"&payno="+response.payno+"&expacc="+$expacc+"&costcid="+$costcentre;
                                reloadSearchpendingbills();
                 }
                 else if(response.id==='0'){
               
               $("#d_progress").dialog("destroy");
               
             $.modaldialog.warning('<br><b>Sorry. The selected Bank Balance is not enough to complete this request.</b>', {
             width:400,
             showClose: true,
             title:"Low Balance"
            });
           
                 }
             else{
              
             $("#d_progress").dialog("destroy");
                 
                alert("Payment not completed-please try again later");
              
              
                    
             }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
                  alert("Payment not completed-please try again later");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              });       
                 
    
}

function getsuppdebtaccounts(){

    $.getJSON("../finance/json_redirect.php?action=getallsupplraccount", function(data) {
    
    $.each(data, function(i, item) {
       
    $(".ledgerids").append("<option value="+item.incacc+"|"+item.tbl+"|"+item.typ+">"+item.accname+" - "+item.typ+"</option>");
    //$(".tbltype").append("<input type='text' value="+item.tbl+"></input>");  
       });
      
  });
}

function getbadcostcntre(){

    $.getJSON("../finance/json_redirect.php?action=getallcostcentres", function(data) {
    
    $.each(data, function(i, item) {
       
    $("#badincmeacct").append("<option value="+item.cntrid+">"+item.centrename+"</option>");
    //$(".tbltype").append("<input type='text' value="+item.tbl+"></input>");  
       });
      
  });
}
function updatesuppdebtdiff(){
    if($('#crtotal').html() == '' ){
         var crtotl = 0;
     }else{
         crtotl = $('#crtotal').html();
     }
     var $diff = parseFloat($('#drtotal').html())- parseFloat(crtotl);
     if($diff > 0){
         $('#cr-diff').html($diff);
         $('#dr-diff').html('');
         $('#create').hide();
     }
     else{
         $('#dr-diff').html($diff*-1);
         $('#cr-diff').html('');
         $('#create').remove();
         $("#debttinfo").append('<tr><td></td><td ><button id="create" onclick="passuppbaddebtentry()">Create</button></tr>');
     }
    
}

function passuppbaddebtentry(){
    
    var $entrytype =""; var $ledgeraccts =""; var dramount =""; var cramount ="";
         for(var j=1;j<=$('.ledgerids').length;j++){     
           var $ledgertyp=$("#ledger_dc"+j).val();
           $entrytype+=$ledgertyp+",";
           var $ledgeracct =$("#ledgerid"+j).val();
           $ledgeraccts+=$ledgeracct+",";
           var $dr =$("#dbtamnt"+j).val();
           dramount+=$dr+",";
           var $cr = $("#crdtamnt"+j).val();
            cramount+=$cr+",";
            
     }
     var journaldate = $("#journaldate").val();
     var journakrmks = $("#journalrmks").val();
     var incacct = $("#badincmeacct").val();
      basicLargeDialog("#d_progress",50,150);
              
       $(".ui-dialog-titlebar").hide();
     $.getJSON("../finance/json_redirect.php?action=savesupplrdebts&ledgertype="+$entrytype+"&ledgeraccts="+$ledgeraccts+"&dramount="+dramount+"&cramount="+cramount+"&journaldate="+journaldate+"&journalrmks="+journakrmks+"&incmeid="+incacct, function(data) {
         
              if(data.id===1){
        
         $("#d_progress").dialog("destroy");
                    $.modaldialog.success('<br></br><b>Journal Entry completed successfully</b>', {
          title: 'Success transaction',
          showClose: true
          });  
       window.location="../finance/supplrdebtspreview.php?ledgertype="+$entrytype+"&ledgeraccts="+$ledgeraccts+"&dramount="+dramount+"&cramount="+cramount+"&journaldate="+journaldate+"&journalrmks="+journakrmks+"&journalno="+data.journalno;
   
           $("#journaldate").val("");
           $("#journalrmks").val("");
           $("#drtotal").html("");
           $("#crtotal").html("");
           $("#create").remove();
           for(var k=1;k<=$('.ledgerids').length;k++){     
            $("#ledger_dc"+k).val("dr");
           $("#ledgerid"+k).val("");
           $("#dbtamnt"+k).attr('disabled',true);
           $("#crdtamnt"+k).attr('disabled',true);
           document.getElementById("dbtamnt"+k).style.backgroundColor = "white";
        document.getElementById("crdtamnt"+k).style.backgroundColor = "white";
           $("#dbtamnt"+k).val(0);
           $("#crdtamnt"+k).val(0);
     }

                  //$()
        }
 else if(data.id===2){
            $("#d_progress").dialog("destroy");
          
           $.modaldialog.error('<br></br><b>Please check that information you supplied in Debit Account and Credit Account is valid and try again</b>', {
          title: 'Error occured',
          showClose: true
          });
 }
 else{
          $("#d_progress").dialog("destroy");
           $.modaldialog.error('<br></br><b>An Error occured and cannot complete your request- Please try again later </b>', { 
          title: 'Error occured',
          showClose: true
          });
 }
         
         
     });
}

function reloadSearchpendingbills(){
    var $debtor=$("#chooseSupplier").val();
    retriveUnpaidBills($debtor);
    
     $("#amountt100").val(0.00);
              $("#investamont").val(0.00);
              $("#cshrmks100").val("");
              $("#invoicechqno").val("");
              $("#invoicechqdate").val("");
              $("#invoiceckrmks100").val("");
    
}

function viewbilcrdt(){
    var $billsupplier = $("#billsupplier").val();
    var crdtinvno = $("#crdtinvno").val();
    var suppname = $("#billsupplier option:selected").text();
    var costcntreid =  $("#costcntreid").val();
    if ($billsupplier =="" || costcntreid == ""){
        $.modaldialog.warning("<br></br><b>Suppliet/Cost Center Not Selected </b>", {
             width:400,
             showClose: true,
             title:"ERROR"
            });
        $("#crdtinvno").val("");
    }
            else{
              
        $.getJSON("../finance/redirect.php?action=getbilldetails&invcno="+crdtinvno+"&supplier="+$billsupplier+"&costcntreid="+costcntreid, function(data) {
         //   alert(data.available);
     if(data.available =='1'){
         
                $("#billamount").val(data.bamount);
                $("#expnacc").val(data.expenseacc);
                $("#billrmks").val(data.billrmks);
                 
         }
    else if(data.available == '0'){
             $.modaldialog.warning("<br></br><b>INVOICE NO: "+crdtinvno+" NOT FOUND FOR "+suppname+" </b>", {
             width:400,
             showClose: true,
             title:"ERROR"
            });
           $("#crdtinvno").val("");
           $("#billno").val("");
                $("#billamount").val("");
                $("#expnacc").val("");
                $("#billrmks").val("");
           }
        
 
    });
}
}