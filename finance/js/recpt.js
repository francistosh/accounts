   $(function(){
   $("#choosedebtorgo").click(function(){ 
        var $debtor=$("#choosedebtor").val();  //debtor selector
         var rcptinc =  $("#recptincacc").val();
               //var $incaccounts=$("#incaccounts").val();  //income account
         
               var  $mumindebtor=$("#mumineendebtor").val();  //mumin debtor 
               
               
             // $("#paymentdt100").val("");  //CLEAR TEXT FIELDS
             // $("#ckdate100").val("");
              $("#ckno100").val("");
              $("#ckamount100").val("0");
              $("#ckdetails100").val("");
              $("#ckrmks100").val("");
              //$("#cashdt100").val("");
              $("#cshamount100").val("0"); 
              $("#cshrmks100").val("");
               
               retrieveUnpaidincmeDebtorBills($debtor,$mumindebtor,rcptinc);
             //  retrieveUnpaidDebtorBills($debtor,$mumindebtor);
       
   });

    $(".unpaidcheckboxx").live('change',function(){  //receipts  -debtors payment invoice checkbox listeners
     
    var $amount=0; var $pdamount=0; var $topay=0;
    
   if ($(this).is(':checked')) {
                var $id=$(this).attr("id");
         
         var $amountid = $id.substring(6);
         
           if($("#credit2").val()!="" && $("#credit2").val() !=$("#incmeid"+$amountid).val()){
                    $.modaldialog.warning('<b><br></br>Not Possible to pay in different Income Accounts</b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Warning"
            });
                $("#unpcxx"+$amountid).attr('checked',false);
          
        }else{
         $("#credit2").val($("#incmeid"+$amountid).val());
         $("#recptincacc").val($("#incmeid"+$amountid).val());
         $("#incaccounts").val($("#incmeid"+$amountid).val());
          $("#unpcbx"+$amountid).attr('checked',false);
        $amount=parseFloat(document.getElementById("cxamx"+$amountid).innerHTML);
        $pdamount=parseFloat(document.getElementById("pdamnt"+$amountid).innerHTML);
        $topay =  parseFloat($amount-$pdamount);
         $("#amntopay"+$amountid).val($topay);
        
        $("#ckamount100").val(parseFloat($("#ckamount100").val().replace(/[^0-9\.]+/g,""))+$topay);
        
        //$("#ckamount100").val('500');
       
         $("#cshamount100").val(parseFloat($("#cshamount100").val().replace(/[^0-9\.]+/g,""))+$topay);
		 if(parseFloat($pdamount)> 0){
             $("#crdtedinvce"+$amountid).attr('checked','checked');
         }
        else{
            $("#crdtedinvce"+$amountid).attr('checked',false);
        }
   }}
   else{
          var $id=$(this).attr("id");
          
          var $amountid=$id.substring(6);
          
          if($('.unpaidcheckboxx:checked').length == 0){
              $("#credit2").val("");
               $("#recptincacc").val("");
              $("#incaccounts").val("");
          }
       $amount=parseFloat(document.getElementById("cxamx"+$amountid).innerHTML);
        $pdamount=parseFloat(document.getElementById("pdamnt"+$amountid).innerHTML);
        $topay =  parseFloat($("#amntopay"+$amountid).val());
                   $("#unpcbx"+$amountid).attr('checked',false);
         $("#ckamount100").val(parseFloat($("#ckamount100").val().replace(/[^0-9\.]+/g,""))-$topay);
         //$("#credit2").val("");
          $("#cshamount100").val(parseFloat($("#cshamount100").val().replace(/[^0-9\.]+/g,""))-$topay);
         $("#amntopay"+$amountid).val(0);
             $("#crdtedinvce"+$amountid).attr('checked',false);
   }
 });
 
 $("#ckamount100").keyup(function(){ 
 if ($("#recptincacc").val() == "" ){
     $.modaldialog.warning('<br></br><b>Please select Income account above </b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Warning"
            });
           $("#ckamount100").val("");
 }
 else{
 distributeamntchq();
 }
 });
 $(".selectpdchq").live('change',function(){
    
     var $id=$(this).attr("id");
     var $chqid=$id.substring(9);
    var $mumindebtor =document.getElementById("pdsablno"+$chqid).innerHTML;
    var rcptinc = document.getElementById("incmact"+$chqid).innerHTML;

    var $debtor = '';
   ///  retrieveUnpaidincmeDebtorinvoices($debtor,$mumindebtor,rcptinc);
    // distributepdchq($chqid);
 });
 
  $(".pdschqamnt").keyup(function(){ 
      
 if ($("#recptincacc").val() == "" ){
     $.modaldialog.warning('<br></br><b>Please select Income account above </b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Warning"
            });
           $("#pdchqamount1").val("");
           $("#pdtotal").val("");
 }
 else{
     var $id=$(this).attr("id");
     var $amountid=$id.substring(11);
      $("#pdtotal").val(samount);
      var samount = 0;
      $(".pdschqamnt").each(function(){
        samount += +$(this).val().replace(/[^0-9\.]+/g,"");
    });
     $("#pdtotal").val(samount);
 distributepdchq();
 }
 });
  $("#cshamount100").keyup(function(){
      
       if ($("#recptincacc").val() == "" ){
     $.modaldialog.warning('<br></br><b>Please select Income account above </b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Warning"
            });
           $("#cshamount100").val("");
 }      else{
      
            distributeamntcash();
        }
 });
   $("#cshreceipt").click(function(){   //generate receipt through cash payment
      var $docnumbers ="";
      var $individualamount="";
      var $acctsnumber="";
      var $paymentdate=$.trim($("#cashdt100").val());
     
      var $amount=$.trim($("#cshamount100").val().replace(/[^0-9\.]+/g,"")); 
      
      var $ejno=$.trim($("#mumineendebtor").val());
      
      var $incacc=$.trim($("#incaccounts").val());
      
      //var $acc=$.trim($("#bankaccount100").val());
      
      var $payment= $("#cshrmks100").val().replace(/["',]/g,"/");
      
      var $debtor=$.trim($("#choosedebtor").val());
      var $bankacct=$.trim($("#bnkaccounts").val());
      var $sector=$.trim($("#muminsectr").val());
      
      if(parseFloat($amount)>0 &&  $paymentdate!=="" &&  $payment!==""  && $incacc!==""){
      
     
     for(var j=0;j<=$(".unpaidcheckboxx").length;j++){
         
     if ($("#unpcxx"+j).is(':checked')) {
          
           var $id=$("#unpcxx"+j).attr("id");
           
           var $docnos=document.getElementById("bxxn"+$id.substring(6)).textContent;
           
           $docnumbers+=$docnos+",";
           //pledgeAmountArray.push(document.getElementById("paymntpldge"+h).value);
           var $iamount1 = document.getElementById("amntopay"+$id.substring(6)).value;
           $individualamount+=$iamount1+",";
           
         var $incmeacts =document.getElementById("incme"+$id.substring(6)).textContent;
           $acctsnumber =$incmeacts;
            } else{} 
            
            
     }
      
      
      cash_receipt($debtor,$docnumbers,$acctsnumber,$individualamount,$paymentdate,$amount,$ejno,$incacc,$payment,$bankacct,$sector);  
      
      
      }
       else{
           
            
          $.modaldialog.warning('ALL Fields MUST be filled before proceeding', {
             timeout: 5,
             width:500,
             showClose: false,
             title:"Warning"
            });
           
         
     
     
       }
   });
   
        $("#choosedebtor").change(function(){     // view bill onchange action
    
          $("#cshamount100").val("0") ;//reset amount fields
        
        $("#ckamount100").val("0") ;//reset amount fileds
        
        var $dbt=$("#choosedebtor").val();  //mumineen debtor
        

             
              $("#mumineendebtor").val("");// reset field
              
             // $("#mumineendebtor").css("visibility","hidden");
              
               var $debtor=$("#choosedebtor").val();  //debtor selector
        
               var $incaccounts=$("#incaccounts").val();  //income account
         
               var  $mumindebtor=$("#mumineendebtor").val();  //mumin debtor ejamaat number
       
               retrieveUnpaidDebtorBills($debtor,$mumindebtor);
              
               
      
   });
 //  $("#recpnorev").keyup(function(e){  //sabil no field click;
        
    
    //   $("#rcpt").css("display","none");
   //});
   
         $('#rcptdebtor').click(function(){
             $("#choosedebtor").css("display","block");
             $("#mumineendebtor").css("display","none");
             $("#gallerydisp").css("display","none");
             $("#choosedebtor").val("");
             $("#debtor_mumin_name").empty();
             $("#billstable2").empty();
             $("#ckamount100").val(0);
             $("#cshamount100").val(0);
   });
   $('#backbtn').click(function(){
   
         history.back();
   });
   

   $('#rcptmumin').click(function(){
       $("#choosedebtor").css("display","none");
       $("#mumineendebtor").css("display","block");
       $("#mumineendebtor").val("");
       $("#gallerydisp").css("display","block");
       $("#debtor_mumin_name").empty();
       $("#billstable2").empty();
       $("#ckamount100").val(0);
       $("#cshamount100").val(0);
       $("#choosedebtor").val(" ");
   });
     $("#gallerydisp").click(function(){  // invoice field click listener
   
    $("#gallery").fadeIn('Slow');
      
  }); 
  
     $("#rcptcancelrint201").click (function(){
       
       
      window.close();  
   });
      $("#rcpprint201").click((function(){  
    
        window.print();
    
    window.location="../finance/receipts.php?type=new";
    
    }));
   
    $("#mumineendebtor").keypress(function(e){  //sabil no field click;
       
       if(e.keyCode===13){
           
             var $debtor=$("#choosedebtor").val();  //debtor selector
              $("#ckamount100").val(0);
               $("#cshamount100").val(0);
               //var $incaccounts=$("#incaccounts").val();  //income account
         
               var  $mumindebtor=$("#mumineendebtor").val();  //mumin debtor ejamaat number
       
               retrieveUnpaidDebtorBills($debtor,$mumindebtor);
       }
       
       
   });
   
       $("#recptincacc").change(function(e){  //sabil no field click;
       
              var rcptinc =  $("#recptincacc").val();
             var $debtor=$("#choosedebtor").val();  //debtor selector
              $("#ckamount100").val(0);
               $("#cshamount100").val(0);
               //var $incaccounts=$("#incaccounts").val();  //income account
         
               var  $mumindebtor=$("#mumineendebtor").val();  //mumin debtor ejamaat number
       
               retrieveUnpaidincmeDebtorBills($debtor,$mumindebtor,rcptinc);
      
       
       
        });   
   
          $("#viewlist").click(function(){
      
      
          var $fromdate=$("#sdate").val();
          var $todate=$("#edate").val();
          var $dept=$("#dpt").val();
          var $mode=$("#pmd").val();
          
          
        window.open('../finance/receiptlistpreview.php?pmd='+$mode+'&sdate='+$fromdate+'&edate='+$todate+'&dpt='+$dept,'','width=1300,height=800,toolbar=0,menubar=1,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
      
  });
           
   $("#viewdlist").click(function(){
      
      
          var $atdate=$("#atdate").val();
                 var pymd=$("#pymd").val();
          
        window.open('../finance/depositlist.php?pmd='+pymd+'&sdate='+$atdate+'&acct=all',' ','width=1300,height=800,toolbar=0,menubar=1,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
     
  });
   
          $('#sumall').click(function() {
     
           $('.checks').prop("checked", true);//select all checkboxes with class "checks"  
                var sumtotal = 0;             
            var lngth = $('.checks').length;
            for(var k = 0; k<=lngth-1; k++ ){
               sumtotal = (parseFloat($('#depsit'+k).val())+ parseFloat(sumtotal)).toFixed(2);
              
            //   var receiptno = document.getElementById("rectno"+k).textContent;
      //  var rectdate = document.getElementById("rectdte"+k).textContent;
      //  var ctname = document.getElementById("ctname"+k).textContent;
      //  var rectamnt = document.getElementById("rectamnt"+k).textContent;
      //  var chqno = document.getElementById("chqueno"+k).textContent;
      //  $("#tpreview").append('<tr id="amt'+k+'"><td style="width:100px" id="rcpnodpst'+k+'">'+receiptno+'</td><td style= "width:100px">'+rectdate+'</td><td style="width:200px">'+ctname+'</td><td style="width:200px">'+chqno+'</td><td style="width:150px">'+rectamnt+'</td></tr>');
        
            }
        //$("#tpreview").append('<tr><td colspan="8" style="text-align: right;font-size:20px"> <b>Total Amount Kshs '+sumtotal+'</b>&nbsp;&nbsp;<button onclick="depositamnt('+lngth+')">Deposit this Amount</button></td></tr>');
        $('#amttodeposit').val(parseFloat(sumtotal));
	});
   
   $('#clearall').click(function() {
           $('.checks').prop("checked", false);//unselect all checkboxes with class "checks"
                    $('#amttodeposit').val(parseFloat(0));           
          //  $("#tpreview").empty(); 
	});
          
      $("#ckreceipt").click(function(){   //generate receipt through cheque payment
      

      var $docnumbers ="";
      var $individualamount="";
      var $acctsnumber = "";
      var $paymentdate=$.trim($("#paymentdt100").val());
      
      var $chequedate=$.trim($("#ckdate100").val());
      
      var $chequeno=$.trim($("#ckno100").val().replace(/["',]/g,"/"));
      
      var $amount=$.trim($("#ckamount100").val().replace(/[^0-9\.]+/g,""));
      
      var $chequedetails=$("#ckdetails100").val().replace(/["',]/g,"/");
      
      var $ejno=$.trim($("#mumineendebtor").val());
      
      var $incmeacc=$.trim($("#credit2").val());
      
      var $acc=$.trim($("#bankaccount").val());
      
      var $payment=$("#ckrmks100").val().replace(/["',]/g,"/");
      
      var $debtor=$.trim($("#choosedebtor").val());
      var $sector=$.trim($("#muminsectr").val());
      var $bnkaccounts2=$.trim($("#bnkaccounts2").val());
      if(parseFloat($amount)>0 &&  $paymentdate!=="" &&  $chequedate!==""  && $chequeno!=="" && $amount!=="" && $chequedetails!=="" && $payment!== "" && $incmeacc!== ""){
      
     for(var j=0;j<=$(".unpaidcheckboxx").length;j++){
         
     if ($("#unpcxx"+j).is(':checked')) {
          
           var $id=$("#unpcxx"+j).attr("id");
           
           var $docnos=document.getElementById("bxxn"+$id.substring(6)).textContent;
           
           $docnumbers+=$docnos+",";
           var $iamount1 = document.getElementById("amntopay"+$id.substring(6)).value;
           $individualamount+=$iamount1+",";
            var $incmeacts =document.getElementById("incme"+$id.substring(6)).textContent;
           $acctsnumber =$incmeacts;
         
            } else{} 
            
            
     }
      
   
      cheque_receipt($debtor,$docnumbers,$acctsnumber,$individualamount,$paymentdate,$chequedate,$chequeno,$amount,$chequedetails,$ejno,$incmeacc,$acc,$payment,$bnkaccounts2,$sector);  
      
      
      }
       else{
           
            
          $.modaldialog.warning('ALL Fields MUST be filled and at least one invoice checked before proceeding', {
             timeout: 5,
             width:500,
             showClose: false,
             title:"Warning"
            });
           
         
     
     
       }
   });
      $(".activatelink").click(function(){  
       
           var $id=$(this).attr("id");
           
           var $cell="pd_date"+$id.substring(6);
           
            var $pdsablno="pdsablno"+$id.substring(6);
            
             var $name="pdname"+$id.substring(6);
             
	    var $pdchqn="pdchqno"+$id.substring(6);
               
             var $pdchqdetails="pdchqdetails"+$id.substring(6);
             
            var $cpdamnt="cpdamnt"+$id.substring(6);
             var $incmact = "incmact"+$id.substring(6);
                 
		       
            $("#pdeditdate").val(document.getElementById($cell).textContent);
            $("#pdeditsabilno").val(document.getElementById($pdsablno).textContent);
            $("#pdeditname").val(document.getElementById($name).textContent);
            $("#pdeditchqno").val(document.getElementById($pdchqn).textContent);
            $("#pdeditbank").val(document.getElementById($pdchqdetails).textContent);
                   $("#pdeditamnt").val(document.getElementById($cpdamnt).textContent);
                   $("#pdeditacct").val(document.getElementById($incmact).textContent);
                   $("#cgid").val($("#tno"+$id.substring(6)).val());
           basicLargeDialog("#changepdchq",400,500);
      
  });
  
        $(".linkremove").click(function(){  
       
           var $id=$(this).attr("id");
           
            var tno = $("#tno"+$id.substring(4)).val();
            // alert(tno);
                   $.getJSON("../finance/json_redirect.php?action=removepdchq&id="+tno, function(data) {
        
      
   
     if(data.id =='1'){
        
            $.modaldialog.success('<br></br><b>PD Cheque Deleted Succesfull</b>', {
             timeout: 3,
             width:500,
             showClose: false,
             title:'Complete'
            });
        } else{
            $.modaldialog.warning('<br></br><b>Error- Contact Admin</b>', {
             timeout: 3,
             width:500,
             showClose: true,
             title:'Warning'
            });
        }
        
    }); 
      
  });
  
   $('#prvwdeposit').click(function(){
                            var $docnumbers ="";
                            var bankacct = $("#bnkaccnt").val();
                            var ddate = $("#slctddepodate").val();
                            if(bankacct === 'all'){
                                 $.modaldialog.warning('<br></br><b>Select To Account</b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Warning"
            });
                            }else{
                               $('input.checks:checked').each(function(j, obj) {
                                   var $id=$(this).attr("id");
          
          var $tid=$id.substring(6);
           //var $id=$("#depsit"+j).attr("id");
           
           var $docnos=document.getElementById("rcpnodpst"+$tid).textContent;
           //alert($docnos);
           $docnumbers+=$docnos+",";
                               }); 
 

                    printLargeDialog('#deposit_previewl',500,700,$docnumbers,bankacct,ddate);
                            } });
      $("#ckreceiptpart").click(function(){   //generate receipt through cheque payment -partially payment
      
      
      var $docnumbers =$.trim($("#invnopart").val());;
      
      var $paymentdate=$.trim($("#paymentdt100part").val());
      
      var $chequedate=$.trim($("#ckdate100part").val());
      
      var $chequeno=$.trim($("#ckno100part").val());
      
      var $amount=$.trim($("#ckamount100part").val());
      
      var $chequedetails=$.trim($("#ckdetails100part").val());
      
      var $sabilno=$.trim($("#sabilnopart").val());
      
      var $expacc=$.trim($("#deptpart").val());
      
      var $acc=$.trim($("#bankaccountpart").val());
      
      var $payment=$.trim($("#ckrmks100part").val());
      
      var $debtor=$.trim($("#debtorpart").val());
      
      
    if(parseFloat($amount)>0 &&  $paymentdate!=="" &&  $chequedate!==""  && $chequeno!=="" && $amount!=="" && $chequedetails!=="" && $payment!== ""){
      
     
    cheque_receipt_partpayment($docnumbers,$paymentdate,$chequedate,$chequeno,$amount,$chequedetails,$sabilno,$expacc,$acc,$payment,$debtor);  
      
      
      }
       else{
           
            
          $.modaldialog.warning('ALL Fields MUST be filled -ensure correct amount is entered before proceeding', {
             timeout: 5,
             width:500,
             showClose: false,
             title:"Warning"
            });
           
         
     
     
       }
   }); 
   
   $("#cshreceiptpart").click(function(){   //generate receipt through cash payment
      
      
      var $docnumbers =$.trim($("#invnopart").val());
      
      var $paymentdate=$.trim($("#dt100part").val());
     
      var $amount=$.trim($("#cshamount100part").val()); 
      
      var $sabilno=$.trim($("#sabilnopart").val());
      
      var $expacc=$.trim($("#deptpart").val());
      
      var $acc=$.trim($("#bankaccount100part").val());
      
      var $payment=$.trim($("#cshrmks100part").val());
      
      var $debtor=$.trim($("#debtorpart").val());
      
      
      if(parseFloat($amount)>0 &&  $paymentdate!=="" &&  $payment!==""){

      cash_receipt_partpayment($debtor,$docnumbers,$paymentdate,$amount,$sabilno,$expacc,$acc,$payment);  

      }
       else{
           
            
          $.modaldialog.warning('ALL Fields MUST be filled -ensure correct amount is entered before proceeding', {
             timeout: 5,
             width:500,
             showClose: false,
             title:"Warning"
            });
           
         
     
     
       }
   });
            $("#pdsubmit").click(function(){ 
   
       var $pdtotal,sabilno,$incmeacc,$chqno1,$chqdate1,$pdremarks;
       sabilno=$.trim($("#mumineendebtor").val());
       $incmeacc=$.trim($("#recptincacc").val());
       $chqno1 = $.trim($("#pdchqno1").val());
       $chqdate1 = $.trim($("#pdchqdate1").val());
       $pdremarks = $("#pdremarks").val();
       $pdtotal=$.trim($("#pdtotal").val().replace(/[^0-9\.]+/g,""));
       var $debtor=$.trim($("#choosedebtor").val());
     
       var chqdates = "", chqnos = "" , chqdetails = "",chqamounts = "",$docnumbers ="", $individualamount="",$acctsnumber =""; 
       
       if($incmeacc!=="" && $chqdate1!=="" && $chqno1!=="" && $pdtotal> 0){
               for(var j=0;j<=$(".unpaidcheckboxx").length;j++){
         
     if ($("#unpcxx"+j).is(':checked')) {
          
           var $id=$("#unpcxx"+j).attr("id");
           
           var $docnos=document.getElementById("bxxn"+$id.substring(6)).textContent;
           
           $docnumbers+=$docnos+",";
           var $iamount1 = document.getElementById("amntopay"+$id.substring(6)).value;
           $individualamount+=$iamount1+",";
            var $incmeacts =document.getElementById("incme"+$id.substring(6)).textContent;
           $acctsnumber =$incmeacts;
         
            } else{} 
            
            
     }
                  for(var j=1;j<=$(".pdchqno").length;j++){
         
     if ($("#pdchqamount"+j).val().replace(/[^0-9\.]+/g,"") > 0) {
          var $chqdateid =$("#pdchqdate"+j).val();
           chqdates+=$chqdateid+",";
          var $chqnoid = $.trim($("#pdchqno"+j).val().replace(/[^0-9\.]+/g,""));
           chqnos+=$chqnoid+",";
          var $chqdetid = $("#pdchqdet"+j).val();
           chqdetails+=$chqdetid+","; 
          var $chqamntid = $.trim($("#pdchqamount"+j).val().replace(/[^0-9\.]+/g,""));
           chqamounts+=$chqamntid+","; 
            } else{} 
            //alert(costcentres);
           
     }
          savepdchqs($debtor,sabilno,$docnumbers,$acctsnumber,$individualamount,$incmeacc,chqdates,chqnos,chqdetails,chqamounts,$pdremarks);
                  
      
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
   
   });
   
   function savepdchqs($debtor,sabilno,$docnumbers,$acctsnumber,$individualamount,$incmeacc,chqdates,chqnos,chqdetails,chqamounts,$pdremarks){
            var $dataString={debtor:$debtor,sabilno:sabilno,docnumbers:$docnumbers,acctnumbers:$acctsnumber,individualamt:$individualamount,incmeacc:$incmeacc,chqdates:chqdates,chqnos:chqnos,chqdetails:chqdetails,chqamounts:chqamounts,pdremarks:$pdremarks};
        
      var $urlString="../finance/receipting.php?action=savepdchqs";

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
 
            
            reloadSearchpendingInvoices() ;
            $("#mumineendebtor").val("");
             $("#pdchqno1").val("");
             $("#pdchqdet1").val("");
             $("#pdincmeact1").val("");
             $("#pdchqamount1").val("0.00");
             $("#pdremarks").val("");
             $("#pdtotal").val("");
             $("#recptincacc").val("");
           $.modaldialog.success('<b>PD Cheque: '+response.pdno+' Saved Successfully</b>', {
             width:400,
             showClose: true,
             timeout: 50,
             title:"SUCCESS"
            });
                 }
             else{
              
             $("#d_progress").dialog("destroy");
               
             alert("PD Cheques not saved-please try again later");
              
              
                    
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
   
            function previewdeposit(){
                
            if($(".checks:checked").length == 0){
                
                $.modaldialog.warning('<br></br><b>No Receipt Selected for Deposit</b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Warning"
            });
                            }else if($('#bnkacct2').val()=="all" || $('#bnkaccnt').val()=="all"){
                 $.modaldialog.warning('<br></br><b>No Account Selected for Deposit</b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Warning"
            });               
                            }
                            else{
         
         var receiptArray=new Array();
         var pymntmode = $("#paymntmde").val();
         var bankactid = $("#bnkaccnt").val();
         var slctdepodate = $("#slctddepodate").val();
         
       
    for(var j=0;j<=(document.getElementById("treport").rows.length)-2;j++){
        if($("#depsit"+j).is(":checked")){
                receiptArray.push(""+document.getElementById("rcpnodpst"+j).textContent+""); //push receipt numbers to Array
        }
      }
      var $urlString = "../finance/json_redirect.php?action=depositamnt&receiptdata="+receiptArray+"&paymode="+pymntmode+"&bankactid="+bankactid+"&slctddepositdate="+slctdepodate;

   
 $.ajax({                                                                        
                
                url: $urlString,
                
                type: "GET",
                
                dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
               //data:$dataString,
                
                success: function(response) {
                       
                
                if(response.id != '0'){
             //alert('Transaction : Successfull Deposit No '+response.id+' Successfull');
             $.modaldialog.success('<br><b>Transaction : Successfull Deposit No '+response.id+' Successfull</b>', {
             timeout: 15,
             width:500,
             showClose: true,
             title:"Information"
            });
            setTimeout(function(){
            window.close();
            },3000);
          //  printLargeDialog('#deposit_noreprintl',500,700,response.id,bankacct);
                }
                
                else{
                    
                    alert("Error occured");
                }
               
                },
                error:function (xhr, ajaxOptions, thrownError){
                    
                 
                 
                 alert("Error");
                   
                },
                beforeSend:function(){
                    
                
                
                }
                 
  });
        }
    }
                  function oncheckbox(i){
           var amount = $('#amttodeposit').val();
        if($("#depsit"+i).is(':checked')){
            amount = (parseFloat($("#depsit"+i).val())+parseFloat(amount)).toFixed(2) ;
           $('#amttodeposit').val(amount);
          // var receiptno = document.getElementById("rectno"+i).textContent;
       // var rectdate = document.getElementById("rectdte"+i).textContent;
       // var ctname = document.getElementById("ctname"+i).textContent;
       // var rectamnt = document.getElementById("rectamnt"+i).textContent;
       // var chqno = document.getElementById("chqueno"+i).textContent;
        //   $("#tpreview").append('<tr id="amt'+i+'"><td style="width:100px" id="rcpnodpst'+i+'">'+receiptno+'</td><td style= "width:100px">'+rectdate+'</td><td style="width:200px">'+ctname+'</td><td style="width:200px">'+chqno+'</td><td style="width:150px">'+rectamnt+'</td></tr>');

        }
    
    else {
        amount = (parseFloat (amount) - parseFloat($("#depsit"+i).val())).toFixed(2);
           $('#amttodeposit').val(amount);
          // $("#amt"+i).remove();
    }
//$("#tpreview").append('<tr><td colspan="8" style="text-align: right;font-size:20px"> <b>Total Amount Kshs '+amount+'</b>&nbsp;&nbsp;<button onclick="depositamnt('+amount+')">Deposit this Amount</button></td></tr>');

    }
   
function cash_receipt_partpayment($debtor,$docnumbers,$paymentdate,$amount,$sabilno,$expacc,$acc,$payment)  { 
  
  var $dataString={docnumbers:$docnumbers,paymentdate:$paymentdate,amount:$amount,sabilno:$sabilno,expacc:$expacc,acc:$acc,payment:$payment,debtor:$debtor};
        
      var $urlString="../finance/json_redirect.php?action=receiptgeneratecashpart";

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
             
          
              
              window.location="../finance/receipt_preview.php?mode=CASH&paymentdate="+$paymentdate+"&amount="+$amount+"&ejno="+$sabilno+"&expacc="+$expacc+"&acc="+$acc+"&payment="+$payment+"&recpno="+response.recpno+"&debtor="+$debtor;
              
                window.opener.reloadSearchpendingInvoices();  //reload search page
              
              
                 }
             else{
              
             $("#d_progress").dialog("destroy");
                 
             $.modaldialog.warning('Ensure correct amount is entered before proceeding', {
             timeout: 5,
             width:500,
             showClose: false,
             title:"Warning"
            });
              
              
                    
             }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
                  alert("Transaction could not be completed");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
             $(".ui-dialog-titlebar").hide();
              
             }
                 
              });       
  
}
 function cheque_receipt_partpayment($docnumbers,$paymentdate,$chequedate,$chequeno,$amount,$chequedetails,$sabilno,$expacc,$acc,$payment,$debtor){ 
  
  var $dataString={docnumbers:$docnumbers,paymentdate:$paymentdate,chequedate:$chequedate,chequeno:$chequeno,amount:$amount,chequedetails:$chequedetails,sabilno:$sabilno,expacc:$expacc,acc:$acc,payment:$payment,debtor:$debtor};
        
      var $urlString="../finance/json_redirect.php?action=receiptgeneratepart";

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
             
              
              
              window.location="../finance/receipt_preview.php?mode=CHEQUE&paymentdate="+$paymentdate+"&chequedate="+$chequedate+"&chequeno="+$chequeno+"&amount="+$amount+"&chequedetails="+$chequedetails+"&ejno="+$sabilno+"&expacc="+$expacc+"&acc="+$acc+"&payment="+$payment+"&recpno="+response.recpno+"&debtor="+$debtor;
             
                 window.opener.reloadSearchpendingInvoices();  //reload search page
             
                 }
             else{
              
             $("#d_progress").dialog("destroy");
                 
            $.modaldialog.warning('Ensure correct amount is entered before proceeding', {
             timeout: 4,
             width:500,
             showClose: false,
             title:"Warning"
            });
              
              
                    
             }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
                  alert("Estate not saved-please try again later");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
             $(".ui-dialog-titlebar").hide();
              
             }
                 
              });       
  
} 
  
  
function cheque_receipt($debtor,$docnumbers,$acctsnumber,$individualamount,$paymentdate,$chequedate,$chequeno,$amount,$chequedetails,$ejno,$incmeacc,$acc,$payment,$bnkaccounts2,$sector){ 
  
  var $dataString={docnumbers:$docnumbers,acctnumbers:$acctsnumber,individualamt:$individualamount,paymentdate:$paymentdate,chequedate:$chequedate,chequeno:$chequeno,amount:$amount,chequedetails:$chequedetails,ejno:$ejno,incmeacc:$incmeacc,acc:$acc,payment:$payment,debtor:$debtor,bnkacct:$bnkaccounts2,sector:$sector};
        
      var $urlString="../finance/receipting.php?action=receiptgenerate";

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
             
          window.location="../finance/receipt_preview.php?mode=CHEQUE&paymentdate="+$paymentdate+"&incmeacts="+response.incmats+"&chequedate="+$chequedate+"&chequeno="+$chequeno+"&amount="+$amount+"&chequedetails="+$chequedetails+"&ejno="+$ejno+"&expacc="+$incmeacc+"&acc="+$acc+"&payment="+$payment+"&recpno="+response.recpno+"&debtor="+$debtor+"&rcpts="+$paymentdate+"&rcptus="+$acc+"&reprint=0",'width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0';
          
          reloadSearchpendingInvoices() ;  
              
                 }
             else{
              
             $("#d_progress").dialog("destroy");
                 
             alert("Transaction could not be completed-please contact the admin");
              
              
                    
             }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
                  alert("Estate not saved-please try again later");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
             $(".ui-dialog-titlebar").hide();
              
             }
                 
              });       
  
}


function reloadSearchpendingInvoices(){
   
               var $debtor=$("#choosedebtor").val();  //debtor selector
        
               //var $incaccounts=$("#incaccounts").val();  //income account
         
               var  $mumindebtor=$("#mumineendebtor").val();  //mumin debtor ejamaat number
               $("#debtor_mumin_name").css("display","none");
               retrieveUnpaidDebtorBills($debtor,$mumindebtor);
               
              
              //$("#paymentdt100").val("");
              $("#ckdate100").val("");
              $("#ckno100").val("");
              $("#ckamount100").val("0");
              $("#ckdetails100").val("");
              $("#ckrmks100").val("");
               $("#cshamount100").val("0"); 
              $("#cshrmks100").val("");
             $("#incaccounts5").val("");  $("#bnkaccounts2").val("");
             $("#bnkaccounts").val(""); $("#incaccounts").val("");
      
      
}
function retrieveUnpaidDebtorBills($debtor,$mumindebtor){
    
    if(!$debtor && !$mumindebtor){
                   $.modaldialog.warning('<br></br><b>Complete the Fields as Required</b>', {
             timeout: 3,
             width:500,
             showClose: false,
             title:"Warning"
            });
    }
    else{
   var $dataString={debtor:$debtor,ejamaat:$mumindebtor};
        
      var $urlString="../finance/receipting.php?action=getunpaiddebtorbills";

               $.ajax({                                                                        
                
                url: $urlString,
                
                type: "GET",
                
                dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
                data:$dataString,
                
                success: function(response) {
                
                
            if(response.length>0){ 
             $("#tabs").css("display","block");
           $("#d_progress").dialog("destroy");
             
           $("#billstable2").empty(); 
           
            document.getElementById("debtor_mumin_name").innerHTML="";
           
          
           $("#billstable2").append("<thead><tr style='font-size:12px'><th>Doc date.</th><th>Doc Type</th><th>Doc No.</th><th>Account</th><th>Balance</th><th>Paid</th><th>To Pay</th><th>Pay</th></tr></thead>");
           
           $("#billstable2").append("<tbody>");
          
           
          // var left = (screen.width/2)-(1000/2);
          // var top = (screen.height/2)-(600/2);
            
             for(var $t in response){
  
              $("#debtor_mumin_name").css("display","block");
              $("#muminsectr"). val(response[$t].sectr);
              document.getElementById("debtor_mumin_name").innerHTML=response[$t].ourdebtor;
              
              if (response[$t]['sabilno']=== ' ' || response[$t]['sabilno']=== '' ){
                  var  sabilresponse = 'null';
                                
              }else {
                  sabilresponse = response[$t]['sabilno'];     
              }
              if (parseFloat(response[$t]['amount'])>0){
                  var display ='block';
                  var docname = 'Invoice';
                  
                            }
                        else if(parseFloat(response[$t]['amount'])<0){
                          display ='none';
                          docname = 'Credit Note';
                        }
                       var bal = parseFloat(response[$t]['amount']) - parseFloat(response[$t]['paidamnt']); 
              $("#billstable2").append("<tr><td >"+response[$t]['idate']+"</td><td>"+docname+"</td><td id='bxxn"+$t+"'>"+response[$t]['invno']+"</td><td id='incme"+$t+"'>"+response[$t]['accname']+"</td><td style='display: none' id='cxamx"+$t+"'>"+parseFloat(response[$t]['amount'])+"</td><td>"+bal.toFixed(2)+"</td><td id='pdamnt"+$t+"'>"+response[$t]['paidamnt']+"</td><td >"+ 
             "<input type='text' id='amntopay"+$t+"' min='0' onkeyup='updateamnt("+$t+")' class='amount'  style='display: "+display+";width:150px;' /></td><td><input type='checkbox' class='unpaidcheckboxx' id='unpcxx"+$t+"'/><input type='checkbox' class='halfpay' id='unpcbx"+$t+"' hidden/><input type='checkbox' class='creditedinvce' id='crdtedinvce"+$t+"' hidden/><input type='text' hidden id='incmeid"+$t+"' value='"+response[$t]['incacc']+"'/></td></tr>");
             //}
       //  else if(parseInt(response[$t]['amount'])<0){
         //   var $displaval= 0;
          //  $displaval = parseInt(response[$t]['amount'])+ parseInt(response[$t]['paidamnt']);
          //   $("#billstable2").append("<tr><td>"+response[$t]['idate']+"</td><td id='bxxn"+$t+"'>"+response[$t]['invno']+"</td><td>"+response[$t]['accname']+"</td><td id='cxamx"+$t+"'>"+response[$t]['amount']+"</td><td id='pdamnt"+$t+"'>"+response[$t]['paidamnt']+"</td><td id='pdamnt"+$t+"'></td><input type='text' id='amntopay"+$t+"'onkeyup='updateamnt("+$t+")' hidden value='"+$displaval+"' /><td><input type='checkbox' class='unpaidcheckboxx' id='unpcxx"+$t+"'/></td></tr>");
           
         //}
         }
              $("#billstable2").append("</tbody>");
              pulloutlinkedaccount($incaccounts);
                 }
             else{
                
             
                  $("#d_progress").dialog("destroy"); 
                  
                  document.getElementById("debtor_mumin_name").innerHTML="";
                   
                  $("#debtor_mumin_name").css("display","none");
                
                  $("#billstable2").empty(); 
              
                  $("#tabs").css("display","none");
              
                  alert("No Pending Invoice found");
              
              
                    
             }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
                  alert("No Invoice found");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              });      
                 
}}

function retrieveUnpaidincmeDebtorBills($debtor,$mumindebtor,rcptinc){
    
    if(!$debtor && !$mumindebtor){
                   $.modaldialog.warning('<br></br><b>Complete the Fields as Required</b>', {
             timeout: 3,
             width:500,
             showClose: false,
             title:"Warning"
            });
    }
    else{
   var $dataString={debtor:$debtor,ejamaat:$mumindebtor,incacct:rcptinc};
        
      var $urlString="../finance/receipting.php?action=getunpaidincmedebtorbills";

               $.ajax({                                                                        
                
                url: $urlString,
                
                type: "GET",
                
                dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
                data:$dataString,
                
                success: function(response) {
                
                
            if(response.length>0){ 
       
             $("#tabs").css("display","block");
           $("#d_progress").dialog("destroy");
             
           $("#billstable2").empty(); 
           
            document.getElementById("debtor_mumin_name").innerHTML="";
           
          
           $("#billstable2").append("<thead><tr style='font-size:12px'><th>Doc date.</th><th>Doc Type</th><th>Doc No.</th><th>Account</th><th>Balance</th><th>Paid</th><th>To Pay</th><th>Pay</th></tr></thead>");
           
           $("#billstable2").append("<tbody>");
          
           
          // var left = (screen.width/2)-(1000/2);
          // var top = (screen.height/2)-(600/2);
            
             for(var $t in response){
  
              $("#debtor_mumin_name").css("display","block");
              $("#muminsectr"). val(response[$t].sectr);
              document.getElementById("debtor_mumin_name").innerHTML=response[$t].ourdebtor;
              
              if (response[$t]['sabilno']=== ' ' || response[$t]['sabilno']=== '' ){
                  var  sabilresponse = 'null';
                                
              }else {
                  sabilresponse = response[$t]['sabilno'];     
              }
              if (parseFloat(response[$t]['amount'])>0){
                  var display ='block';
                  var docname = 'Invoice';
                  
                            }
                        else if(parseFloat(response[$t]['amount'])<0){
                          display ='none';
                          docname = 'Credit Note';
                        }
                        var bal = parseFloat(response[$t]['amount']) - parseFloat(response[$t]['paidamnt']);
              $("#billstable2").append("<tr><td >"+response[$t]['idate']+"</td><td>"+docname+"</td><td id='bxxn"+$t+"'>"+response[$t]['invno']+"</td><td id='incme"+$t+"'>"+response[$t]['accname']+"</td><td style='display:none' id='cxamx"+$t+"'>"+parseFloat(response[$t]['amount'])+"</td><td>"+bal.toFixed(2)+"</td><td id='pdamnt"+$t+"'>"+response[$t]['paidamnt']+"</td><td >"+ 
             "<input type='text' id='amntopay"+$t+"' min='0' onkeyup='updateamnt("+$t+")' class='amount'  style='display: "+display+";width:150px;' /></td><td><input type='checkbox' class='unpaidcheckboxx' id='unpcxx"+$t+"'/><input type='checkbox' class='halfpay' id='unpcbx"+$t+"' hidden/><input type='checkbox' class='creditedinvce' id='crdtedinvce"+$t+"' hidden/><input type='text' hidden id='incmeid"+$t+"' value='"+response[$t]['incacc']+"'/></td></tr>");
             //}
       //  else if(parseInt(response[$t]['amount'])<0){
         //   var $displaval= 0;
          //  $displaval = parseInt(response[$t]['amount'])+ parseInt(response[$t]['paidamnt']);
          //   $("#billstable2").append("<tr><td>"+response[$t]['idate']+"</td><td id='bxxn"+$t+"'>"+response[$t]['invno']+"</td><td>"+response[$t]['accname']+"</td><td id='cxamx"+$t+"'>"+response[$t]['amount']+"</td><td id='pdamnt"+$t+"'>"+response[$t]['paidamnt']+"</td><td id='pdamnt"+$t+"'></td><input type='text' id='amntopay"+$t+"'onkeyup='updateamnt("+$t+")' hidden value='"+$displaval+"' /><td><input type='checkbox' class='unpaidcheckboxx' id='unpcxx"+$t+"'/></td></tr>");
           
         //}
         }
              $("#billstable2").append("</tbody>");
              pulloutlinkedaccount($incaccounts);
                 }
             else{
                
             
                  $("#d_progress").dialog("destroy"); 
                  
                  document.getElementById("debtor_mumin_name").innerHTML="";
                   
                  $("#debtor_mumin_name").css("display","none");
                
                  $("#billstable2").empty(); 
              
                  $("#tabs").css("display","none");
              
                  alert("No Pending Invoice found");
              
              
                    
             }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
                  alert("No Invoice found");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              });      
                 
}}
function retrieveUnpaidincmeDebtorinvoices($debtor,$mumindebtor,rcptinc){
    
    if(!$debtor && !$mumindebtor){
                   $.modaldialog.warning('<br></br><b>Complete the Fields as Required</b>', {
             timeout: 3,
             width:500,
             showClose: false,
             title:"Warning"
            });
    }
    else{
   var $dataString={debtor:$debtor,ejamaat:$mumindebtor,incacct:rcptinc};
        
      var $urlString="../finance/receipting.php?action=getunpaidincmedebtorbills";

               $.ajax({                                                                        
                
                url: $urlString,
                
                type: "GET",
                
                dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
                data:$dataString,
                
                success: function(response) {
                
                
            if(response.length>0){ 
                  
           $("#invoicesstable2").empty(); 
         
           $("#invoicesstable2").append("<thead><tr style='font-size:12px'><th>Doc date.</th><th>Doc Type</th><th>Doc No.</th><th>Account</th><th>Balance</th><th>Paid</th><th>To Pay</th><th>Pay</th></tr></thead>");
           
           $("#invoicesstable2").append("<tbody>");
          
           
          // var left = (screen.width/2)-(1000/2);
          // var top = (screen.height/2)-(600/2);
            
             for(var $t in response){
              if (parseFloat(response[$t]['amount'])>0){
                  var display ='block';
                  var docname = 'Invoice';
                  
                            }
                        else if(parseFloat(response[$t]['amount'])<0){
                          display ='none';
                          docname = 'Credit Note';
                        }
                        var bal = parseFloat(response[$t]['amount']) - parseFloat(response[$t]['paidamnt']);
              $("#invoicesstable2").append("<tr><td >"+response[$t]['idate']+"</td><td>"+docname+"</td><td id='bxxn"+$t+"'>"+response[$t]['invno']+"</td><td id='incme"+$t+"'>"+response[$t]['accname']+"</td><td style='display:none' id='cxamx"+$t+"'>"+parseFloat(response[$t]['amount'])+"</td><td>"+bal.toFixed(2)+"</td><td id='pdamnt"+$t+"'>"+response[$t]['paidamnt']+"</td><td >"+ 
             "<input type='text' id='amntopay"+$t+"' min='0' onkeyup='updateamnt("+$t+")' class='amount'  style='display: "+display+";width:150px;' /></td><td><input type='checkbox' class='unpaidcheckboxx' id='unpcxx"+$t+"'/><input type='checkbox' class='halfpay' id='unpcbx"+$t+"' hidden/><input type='checkbox' class='creditedinvce' id='crdtedinvce"+$t+"' hidden/><input type='text' hidden id='incmeid"+$t+"' value='"+response[$t]['incacc']+"'/></td></tr>");
             //}
       //  else if(parseInt(response[$t]['amount'])<0){
         //   var $displaval= 0;
          //  $displaval = parseInt(response[$t]['amount'])+ parseInt(response[$t]['paidamnt']);
          //   $("#billstable2").append("<tr><td>"+response[$t]['idate']+"</td><td id='bxxn"+$t+"'>"+response[$t]['invno']+"</td><td>"+response[$t]['accname']+"</td><td id='cxamx"+$t+"'>"+response[$t]['amount']+"</td><td id='pdamnt"+$t+"'>"+response[$t]['paidamnt']+"</td><td id='pdamnt"+$t+"'></td><input type='text' id='amntopay"+$t+"'onkeyup='updateamnt("+$t+")' hidden value='"+$displaval+"' /><td><input type='checkbox' class='unpaidcheckboxx' id='unpcxx"+$t+"'/></td></tr>");
           
         //}
         }
              $("#invoicesstable2").append("</tbody>");
              
                 }
             else{
                
             
                 
                
                  $("#invoicesstable2").empty(); 
              
                  
              
                  alert("No Pending Invoice found");
              
              
                    
             }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               
                  
                  alert("No Invoice found");
                
                },
             beforeSend:function(){                       
                
             
              
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              });      
                 
}}
function cash_receipt($debtor,$docnumbers,$acctsnumber,$individualamount,$paymentdate,$amount,$ejno,$incaccounts,$payment,$bankacct,$sector){ 
  
  var $dataString={docnumbers:$docnumbers,acctsnumber:$acctsnumber,individualamt:$individualamount,paymentdate:$paymentdate,amount:$amount,ejno:$ejno,incmeacc:$incaccounts,payment:$payment,debtor:$debtor,bankacct:$bankacct,sector:$sector};
        
      var $urlString="../finance/receipting.php?action=receiptgeneratecash";

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
             
                
           
                window.location="../finance/receipt_preview.php?&mode=CASH&paymentdate="+$paymentdate+"&incmeacts="+response.incmats+"&amount="+$amount+"&ejno="+$ejno+"&expacc="+$incaccounts+"&acc="+$incaccounts+"&payment="+$payment+"&recpno="+response.recpno+"&debtor="+$debtor+"&rcpts="+$paymentdate+"&rcptus="+$incaccounts+"&reprint=0",'width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0';
              
              reloadSearchpendingInvoices() ;  
                 }
             else{
              
             $("#d_progress").dialog("destroy");
                 
             alert("Transaction could not be completed-please try again later");
              
              
                    
             }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
                  alert("Not saved-please try again later");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
             $(".ui-dialog-titlebar").hide();
              
             }
                 
              });       
  
}
function updateamnt(i){

   // parseInt(document.getElementById("cxamx"+$amountid).innerHTML);
       var cashamount = 0;
                        if(!$("#amntopay"+i).val()){ // check whether the input field is null
              $("#unpcxx"+i).attr('checked',false);
               $("#incaccounts").val("");
               $("#credit2").val("");
              //$("#plg"+i).attr('checked',false);
             }
         $("#unpcxx"+i).attr('checked','checked');
         $("#incaccounts").val($("#incmeid"+i).val());
          $("#credit2").val($("#incmeid"+i).val());
         // $("#checkfirst").css("display","none");
         var $orgamnt = document.getElementById("cxamx"+i).textContent;
         var $pd = document.getElementById("pdamnt"+i).textContent;
		 var balance = parseFloat($orgamnt)-parseFloat($pd);
         //var balance = parseInt($orgamnt);
         var $amountopay = $("#amntopay"+i).val();
         if(parseFloat(balance)>=parseFloat($amountopay)){
             $("#unpcbx"+i).attr('checked','checked');
         }
        else{
            $("#unpcbx"+i).attr('checked',false);
            $("#incaccounts").val("");
            $("#credit2").val("");
        }
		
           if(parseFloat($amountopay)>parseFloat(balance)){
            // $.modaldialog.warning('Over Payment not Allowed! Check amount', {
           // timeout: 5,
           // width:500,
           //  showClose: false,
           //  title:"Warning"
          //});
             
	basicLargeDialog("#overpayment_rqst",450,350);
	
		$("#mkeoverpayment").click(function(){
	$("#credit2").val($("#incmeid"+i).val());
        $("#incaccounts").val($("#incmeid"+i).val());
		 var cashamount2 = 0; 
		
	$("#overpayment_rqst").dialog("destroy");

      for (var j=0;j<=(document.getElementById("billstable2").rows.length)-2;j++){

  if ($("#amntopay"+j).val() == ''){
	
	var $pldgeamount = 0;
		
		  } else {
	
	$pldgeamount = $("#amntopay"+j).val();
	
			  }
	

 
		cashamount2 = parseFloat($pldgeamount)+ parseFloat(cashamount2) ;
 
       
                 
    }
	
	$("#ckamount100").val(parseFloat(cashamount2));
 
        $("#cshamount100").val(parseFloat(cashamount2)); 

				});
     function callback() {
      setTimeout(function() {
        $( "#overpayment_rqst" ).removeAttr( "style" ).hide().fadeIn();
      }, 1000 );
    };
			
	$("#cancelovrpaymnt").click(function(){
   $("#credit2").val("");
   $("#incaccounts").val("");
        var options = {};
        $( "#overpayment_rqst" ).effect( 'explode', options, 1000, callback );
	$("#overpayment_rqst").dialog("close");
	 $("#overpayment_rqst").css("display","none") ;

	for (var j=0;j<=(document.getElementById("billstable2").rows.length)-2;j++){

				$("#amntopay"+j).val("");

			 $("#unpcxx"+j).attr('checked',false);

				}
		
		$("#ckamount100").val(0);
      
       		$("#cshamount100").val(0); 
                   
			});
			



        }else{
      for (var j=0;j<=(document.getElementById("billstable2").rows.length)-2;j++){
                    parseFloat($orgamnt);
            if(!$("#amntopay"+j).val() || $("#amntopay"+j).val()==0){ // check whether the input field is null
              var $pldgeamount = 0 ;
              $("#unpcxx"+j).attr('checked',false);
              
              //$("#plg"+i).attr('checked',false);
             }
              else{
                   $pldgeamount = $("#amntopay"+j).val();
                  
              }
          cashamount= parseFloat($pldgeamount)+parseFloat(cashamount) ;
          
                 
    }
       $('#cshamount100').val(cashamount); 
    $('#ckamount100').val(cashamount);
        }
		if((parseFloat($pd) == 0 && (parseFloat($amountopay) < parseFloat($orgamnt)))){
                    
               $("#crdtedinvce"+i).attr('checked','checked');
         }
        else{
            $("#crdtedinvce"+i).attr('checked',false);
        }

}

function verifyamnt(i){
    
    var actual = parseFloat($("#cxamx"+i).val());
    var paidamt = parseFloat($("#pdamnt"+i).val());
    var topay = parseFloat($("#pdamnt"+i).val());
    var balance = 0; var difference = 0;
    balance = actual - paidamt;
    difference = balance - topay;
    if(parseFloat(difference)<0){
        alert ('Not Allowed');
    }
}
function recheckaccount(){
   var $bnkacct2=$("#bnkacct2").val();
                 var pymd=$("#paymntmde").val();
          var strtdte = $("#strtdte").val();
        window.open('../finance/depositlist.php?pmd='+pymd+'&sdate='+strtdte+'&acct='+$bnkacct2,'_self','width=1300,height=800,toolbar=0,menubar=1,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
         
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
             
           $("#billstable1").append("<thead><tr><th>Doc date.</th><th>Doc Type</th><th>Doc No.</th><th>Amount</th><th>Paid</th><th>To Pay</th><th>Pay</th></tr></thead>");
           
           $("#billstable1").append("<tbody>");
            
             for(var $t in response){
                               if (parseFloat(response[$t]['amount'])>0){
                  var display ='block';
                  var docname = 'Invoice';
                  
                            }
                        else if(parseFloat(response[$t]['amount'])<0){
                          display ='none';
                          docname = 'Credit Note';
                        }
              $("#billstable1").append("<tr><td>"+response[$t]['bdate']+"</td><td>"+docname+"</td><td id='bxn"+$t+"'>"+response[$t]['docno']+"</td><td id='cxam"+$t+"'>"+response[$t]['amount']+"</td><td id='amtpd"+$t+"'>"+response[$t]['pdamount']+"</td>"+ 
             "<td><input type='number' id='amnt2pay"+$t+"' min ='0' onkeyup='updateamtup("+$t+")' style='display: "+display+"' /></td><td><input type='checkbox' class='unpaidcheckbox' id='unpcx"+$t+"'/><input type='checkbox' class='topayhalf' id='unpchbx"+$t+"'hidden/></td></tr>");
             
            
             }
              
            $("#billstable1").append("</tbody>");  
              
            // $("#tabs").css("display","block") ;
            
            pulloutlinkedaccountinvoices($cc);
             
                 }
             else{
              
             
                   $("#d_progress").dialog("destroy"); 
                
                   $("#billstable1").empty(); 
              
                 $("#tabs").css("visibility","hidden");
              
               $.modaldialog.prompt('<br><b>No Outstanding/Unpaid Bill found</b>', {
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
              
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              });      
                 
}

function distributeamntcash (){
    var oidata = [];
var poidata = "", poibalance = "",sumbal = 0; ;
 var $pendinginvces = $('.unpaidcheckboxx').length;
 var total = $("#cshamount100").val().replace(/[^0-9\.]+/g,"");
 $("#ckamount100").val($("#cshamount100").val().replace(/[^0-9\.]+/g,""));
    $('.unpaidcheckboxx').each(function(i, obj) {
          var     $amount=parseFloat(document.getElementById("cxamx"+i).innerHTML);
      var  $pdamount=parseFloat(document.getElementById("pdamnt"+i).innerHTML);
      var balamnt = $amount - $pdamount;
      sumbal = sumbal + balamnt;
    var dataValue =  balamnt;
    var dataId =  parseFloat(document.getElementById("bxxn"+i).innerHTML);
    var $row = $(this).closest("tr");
    var priceAmt = 0;
    if(dataValue > 0){
        if(total > dataValue || 
            total === dataValue){
                total = total - dataValue;
                
                if(dataValue>0){ //Only tick if value greater that zero
                    if($("#credit2").val()!="" && $("#credit2").val() !=$("#incmeid"+i).val()){
                    $.modaldialog.warning('<b><br></br>Not Possible to pay in different Income Accounts</b>', {
             timeout: 10,
             width:500,
             showClose: true,
             title:"Warning"
            });
                $('.unpaidcheckboxx').attr('checked',false);
                $('.amount').val(0);
                $("#incaccounts").val('');
                $("#credit2").val('');
                $("#recptincacc").val('');
                 //$("#ckamount100").val(0);
               //  $("#cshamount100").val(0);
                    } else{
                                 $('#amntopay'+i).val(dataValue);
                             $("#unpcxx"+i).attr('checked','checked');
                             $("#incaccounts").val($("#incmeid"+i).val());
                             $("#credit2").val($("#incmeid"+i).val());
                             $("#recptincacc").val($("#incmeid"+i).val());
                         }
                     }else{
                             $('#amntopay'+i).val('');
                             $("#unpcxx"+i).attr('checked',false);
                         }
                  oidata.push(dataId);
                 
               }
               else{                            
                priceAmt = dataValue - total;
                             
                             if(total>0){
                                 
                                 $('#amntopay'+i).val(total);
                             $("#unpcxx"+i).attr('checked','checked');
                              $("#incaccounts").val($("#incmeid"+i).val());
                              $("#credit2").val($("#incmeid"+i).val());
                              $("#recptincacc").val($("#incmeid"+i).val());
                         }else{
                             $('#amntopay'+i).val('');
                             $("#unpcxx"+i).attr('checked',false);
                         }
               // $row.find('.balance').val(priceAmt.toFixed(2));
                if(total>0){
                    poibalance=priceAmt;
                    poidata=dataId;
                    oidata.push(dataId);
                }
                total=0;                                                        
                }
              }                 
            });
if(total != 0){
               basicLargeDialog("#overpayment_rqst",450,350);
                		$("#mkeoverpayment").click(function(){
                                   
                                        var ind = $pendinginvces - 1;
                                        //alert(total);
                                        var     $famount=parseFloat(document.getElementById("cxamx"+ind).innerHTML);
      var  $fpdamount=parseFloat(document.getElementById("pdamnt"+ind).innerHTML);
      var fbalamnt = $famount - $fpdamount;
                                    var afterovp =    parseFloat(fbalamnt) + parseFloat(total);
                                          $('#amntopay'+ind).val(afterovp);
                                          $("#overpayment_rqst").dialog("destroy");
                                        
				});
                                   function callback() {
      setTimeout(function() {
        $( "#overpayment_rqst" ).removeAttr( "style" ).hide().fadeIn();
      }, 1000 );
    };
                                $("#cancelovrpaymnt").click(function(){
                                       $("#ckamount100").val(0);
                                       $("#cshamount100").val(0);
                                      $('.unpaidcheckboxx').attr('checked',false);
                $('.amount').val(0);
                $("#incaccounts").val('');
                $("#credit2").val('');
                $("#recptincacc").val('');
                   var options = {};
        $( "#overpayment_rqst" ).effect( 'explode', options, 1000, callback );
	$("#overpayment_rqst").dialog("close");
	 $("#overpayment_rqst").css("display","none") ;
			});
            }
            
}

function distributeamntchq(){
        var oidata = [];
var poidata = "", poibalance = "" , sumbal = 0; 
 var $pendinginvces = $('.unpaidcheckboxx').length;
 var total = $("#ckamount100").val().replace(/[^0-9\.]+/g,"");
 $("#cshamount100").val($("#ckamount100").val().replace(/[^0-9\.]+/g,""));
 $("#pdchqamount1").val($("#ckamount100").val().replace(/[^0-9\.]+/g,""));
    $('.unpaidcheckboxx').each(function(i, obj) {
          var     $amount=parseFloat(document.getElementById("cxamx"+i).innerHTML);
      var  $pdamount=parseFloat(document.getElementById("pdamnt"+i).innerHTML);
      var balamnt = $amount - $pdamount;
      sumbal = sumbal + balamnt; 
    var dataValue =  balamnt;
    var dataId =  parseFloat(document.getElementById("bxxn"+i).innerHTML);
    var $row = $(this).closest("tr");
    var priceAmt = 0;
    if(dataValue > 0 ){
        if(total > dataValue || 
            total === dataValue){
                total = total - dataValue;
                
                if(dataValue>0){ //Only tick if value greater that zero
                     if($("#credit2").val()!="" && $("#credit2").val() !=$("#incmeid"+i).val()){
                    $.modaldialog.warning('<b><br></br>Not Possible to pay in different Income Accounts</b>', {
             timeout: 10,
             width:500,
             showClose: true,
             title:"Warning"
            });
                $('.unpaidcheckboxx').attr('checked',false);
                $('.amount').val(0);
                $("#incaccounts").val('');
                $("#credit2").val('');
                $("#recptincacc").val('');
                 //$("#ckamount100").val(0);
               //  $("#cshamount100").val(0);
                    }
            else{
                                 $('#amntopay'+i).val(dataValue);
                             $("#unpcxx"+i).attr('checked','checked');
                             $("#incaccounts").val($("#incmeid"+i).val());
                             $("#credit2").val($("#incmeid"+i).val());
                             $("#recptincacc").val($("#incmeid"+i).val());
                         }
                     }else{
                             $('#amntopay'+i).val('');
                             $("#unpcxx"+i).attr('checked',false);
                         }
                  oidata.push(dataId);
                 
               }
               else{                            
                priceAmt = dataValue - total;
                             
                             if(total>0){
                                 
                                 $('#amntopay'+i).val(total);
                             $("#unpcxx"+i).attr('checked','checked');
                              $("#incaccounts").val($("#incmeid"+i).val());
                              $("#credit2").val($("#incmeid"+i).val());
                              $("#recptincacc").val($("#incmeid"+i).val());
                         }else{
                             $('#amntopay'+i).val('');
                             $("#unpcxx"+i).attr('checked',false);
                         }
               // $row.find('.balance').val(priceAmt.toFixed(2));
                if(total>0){
                    poibalance=priceAmt;
                    poidata=dataId;
                    oidata.push(dataId);
                }
                total=0;                                                        
                }
              }  
             
            });
            if(total != 0){
               basicLargeDialog("#overpayment_rqst",450,350);
                		$("#mkeoverpayment").click(function(){
                                   
                                        var ind = $pendinginvces - 1;
                                        var     $famount=parseFloat(document.getElementById("cxamx"+ind).innerHTML);
      var  $fpdamount=parseFloat(document.getElementById("pdamnt"+ind).innerHTML);
      var fbalamnt = $famount - $fpdamount;
                                    var afterovp =    parseFloat(fbalamnt) + parseFloat(total);
                                          $('#amntopay'+ind).val(afterovp);
                                          $("#overpayment_rqst").dialog("destroy");
                                        
				});
                                   function callback() {
      setTimeout(function() {
        $( "#overpayment_rqst" ).removeAttr( "style" ).hide().fadeIn();
      }, 1000 );
    };
                                $("#cancelovrpaymnt").click(function(){
                                       $("#ckamount100").val(0);
                                       $("#cshamount100").val(0);
                                        $("#pdchqamount1").val(0);
                                      $('.unpaidcheckboxx').attr('checked',false);
                $('.amount').val(0);
                $("#incaccounts").val('');
                $("#credit2").val('');
                $("#recptincacc").val('');
                   var options = {};
        $( "#overpayment_rqst" ).effect( 'explode', options, 1000, callback );
	$("#overpayment_rqst").dialog("close");
	 $("#overpayment_rqst").css("display","none") ;
			});
            }
            
}
function distributepdchq($k){
            var oidata = [];
var poidata = "", poibalance = "" , sumbal = 0; 
 var $pendinginvces = $('.unpaidcheckboxx').length;
 var total = $("#pdchqamount1").val().replace(/[^0-9\.]+/g,"");
 $("#cshamount100").val($("#pdchqamount1").val().replace(/[^0-9\.]+/g,""));
 $("#ckamount100").val($("#pdchqamount1").val().replace(/[^0-9\.]+/g,""));
    $('.unpaidcheckboxx').each(function(i, obj) {
          var     $amount=parseFloat(document.getElementById("cxamx"+i).innerHTML);
      var  $pdamount=parseFloat(document.getElementById("pdamnt"+i).innerHTML);
      var balamnt = $amount - $pdamount;
      sumbal = sumbal + balamnt; 
    var dataValue =  balamnt;
    var dataId =  parseFloat(document.getElementById("bxxn"+i).innerHTML);
    var $row = $(this).closest("tr");
    var priceAmt = 0;
    if(dataValue > 0 ){
        if(total > dataValue || 
            total === dataValue){
                total = total - dataValue;
                
                if(dataValue>0){ //Only tick if value greater that zero
                     if($("#credit2").val()!="" && $("#credit2").val() !=$("#incmeid"+i).val()){
                    $.modaldialog.warning('<b><br></br>Not Possible to pay in different Income Accounts</b>', {
             timeout: 10,
             width:500,
             showClose: true,
             title:"Warning"
            });
                $('.unpaidcheckboxx').attr('checked',false);
                $('.amount').val(0);
                $("#incaccounts").val('');
                $("#credit2").val('');
                 $("#pdincmeact1").val('');
                $("#recptincacc").val('');
                 //$("#ckamount100").val(0);
               //  $("#cshamount100").val(0);
                    }
            else{
                                 $('#amntopay'+i).val(dataValue);
                             $("#unpcxx"+i).attr('checked','checked');
                             $("#incaccounts").val($("#incmeid"+i).val());
                             $("#credit2").val($("#incmeid"+i).val());
                             $("#pdincmeact1").val($("#incmeid"+i).val());
                             $("#recptincacc").val($("#incmeid"+i).val());
                         }
                     }else{
                             $('#amntopay'+i).val('');
                             $("#unpcxx"+i).attr('checked',false);
                         }
                  oidata.push(dataId);
                 
               }
               else{                            
                priceAmt = dataValue - total;
                             
                             if(total>0){
                                 
                                 $('#amntopay'+i).val(total);
                             $("#unpcxx"+i).attr('checked','checked');
                              $("#incaccounts").val($("#incmeid"+i).val());
                              $("#credit2").val($("#incmeid"+i).val());
                              $("#pdincmeact1").val($("#incmeid"+i).val());
                              $("#recptincacc").val($("#incmeid"+i).val());
                         }else{
                             $('#amntopay'+i).val('');
                             $("#unpcxx"+i).attr('checked',false);
                         }
               // $row.find('.balance').val(priceAmt.toFixed(2));
                if(total>0){
                    poibalance=priceAmt;
                    poidata=dataId;
                    oidata.push(dataId);
                }
                total=0;                                                        
                }
              }  
             
            });
            if(total != 0){
               basicLargeDialog("#overpayment_rqst",450,350);
                		$("#mkeoverpayment").click(function(){
                                   
                                        var ind = $pendinginvces - 1;
                                        var     $famount=parseFloat(document.getElementById("cxamx"+ind).innerHTML);
      var  $fpdamount=parseFloat(document.getElementById("pdamnt"+ind).innerHTML);
      var fbalamnt = $famount - $fpdamount;
                                    var afterovp =    parseFloat(fbalamnt) + parseFloat(total);
                                          $('#amntopay'+ind).val(afterovp);
                                          $("#overpayment_rqst").dialog("destroy");
                                        
				});
                                   function callback() {
      setTimeout(function() {
        $( "#overpayment_rqst" ).removeAttr( "style" ).hide().fadeIn();
      }, 1000 );
    };
                                $("#cancelovrpaymnt").click(function(){
                                       $("#ckamount100").val(0);
                                       $("#cshamount100").val(0);
                                        $("#pdchqamount1").val(0);
                                      $('.unpaidcheckboxx').attr('checked',false);
                $('.amount').val(0);
                $("#incaccounts").val('');
                $("#credit2").val('');
                $("#pdincmeact1").val('');
                $("#recptincacc").val('');
                   var options = {};
        $( "#overpayment_rqst" ).effect( 'explode', options, 1000, callback );
	$("#overpayment_rqst").dialog("close");
	 $("#overpayment_rqst").css("display","none") ;
			});
            }
            
}