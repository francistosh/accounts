var debtorsAcc=[];
var mohalla=[];
$(function(){
      
   
     $.getJSON("../finance/json_redirect.php?action=autocomplete1", function(data) {
   
    $.each(data, function(i,item) {
       
  debtorsAcc.push(item.debtorname);
    
    $("#invdebtor").autocomplete({
        source: debtorsAcc,
         focus: function(event, ui ) {
             event.preventDefault();
            $(this).val(ui.item.label);
        },
            select: function(event, ui) {
	event.preventDefault();
	$(this).val(ui.item.label);
	$("#sabilname").val(ui.item.label);
         $("#debtorid").val(ui.item.debid);
				},
           change: function(event, ui) {
        console.log(this.value);
        if (ui.item == null) {
            basicLargeDialog("#inv_rqst",450,350);
        }
    }
        });
        
       });
   });
$.getJSON("../finance/json_redirect.php?action=autocomplete2", function(data) {
   
    $.each(data, function(i, item) {
       
    mohalla.push(item.moh);
    $("#mucity").autocomplete({source: mohalla});
        
       });
   });
   
 $("#invcelstoxcel").click(function(e){
       var x = $(".exporttable").clone();
$(x).find("tr td a").replaceWith(function(){
  return $.text([this]);
});
   x.table2excel({
					//exclude: ".noExl",
					name: "Exported File",
					filename: "List"
				});
                                	});
$("#creditgnrt").click(function(){
            $("#d_progress").show(); basicLargeDialog("#d_progress",50,150);
         $(".ui-dialog-titlebar").hide();
    var $debtor=$("#invdebtor").val();
           
           var $account=$("#estacc").val();
           var $date=$("#creditdate").val();
            var $amount=$("#creditamount").val();
         var $sabilno=$("#invsabil").val();
         var $sectornme=$("#sectornme").val();
        
        var $invoice=$("#crdtinvce").val();     
        
         
        var $remarks=$("#creditremarks").val();
        
       if($date=="" || parseFloat($amount)<=0 || $remarks==="" || $account==="" || $invoice ===""){
           
          $("#d_progress").dialog("destroy");
           $.modaldialog.warning("<br></br><b>All fields are Required </b>", {
             width:400,
             showClose: true,
             title:"Missing Data!!!"
            });
          
        }
       
        else{
            
            $.getJSON("../finance/redirect.php?action=getinvoice&invoiceno="+$invoice+"&sabil="+$sabilno+"&debtor="+$debtor+"&amount="+$amount+"&account="+$account, function(data) {
  
     if(data.available =='1'){
                
                 generatecreditnote($date,$debtor,$amount,$remarks,$account,$sabilno.toUpperCase(),$sectornme,$invoice);
                // $("#d_progress").dialog("destroy");
                }
    else if(data.available == '0'){
            $("#d_progress").dialog("destroy");
                    $.modaldialog.warning("<br></br><b>CREDIT NOTE AMOUNT SHOULD NOT BE MORE THAN INVOICE BALANCE</b>", {
             width:400,
             showClose: true,
             title:"ERROR"
            });
                 }
        
 
    });
       
        
        }
     
   }); 
   $("#creditnotegnrt").click(function(){
            $("#d_progress").show(); basicLargeDialog("#d_progress",50,150);
         $(".ui-dialog-titlebar").hide();
    var $debtor=$("#invdebtor").val();
           
           var $account=$("#crestacc").val();
           var $date=$("#creditdate").val();
            var $amount=$("#crdtamount").val();
         var $sabilno=$("#crdtsabil").val();
         var $sectornme=$("#sectornme").val();
        var $remarks=$("#creditremarks").val();
              var $docnumbers ="";
      var $individualamount="";
      
       for(var j=0;j<=$(".unpaidcheckboxx").length;j++){
         
     if ($("#unpcxx"+j).is(':checked')) {
          
           var $id=$("#unpcxx"+j).attr("id");
           
           var $docnos=document.getElementById("bxxn"+$id.substring(6)).textContent;
           
           $docnumbers+=$docnos+",";
           var $iamount1 = document.getElementById("amntopay"+$id.substring(6)).value;
           $individualamount+=$iamount1+",";
           
         
            } else{} 
            
            
     }
      
      
      
      
       if($date=="" || parseFloat($amount)<=0 || $remarks==="" || $account==="" ){
           
          $("#d_progress").dialog("destroy");
           $.modaldialog.warning("<br></br><b>All fields are Required </b>", {
             width:400,
             showClose: true,
             title:"Missing Data!!!"
            });
          
        }
       
        else{
         //   $.getJSON("../finance/redirect.php?action=getinvoice&invoiceno="+$docnumbers+"&sabil="+$sabilno+"&debtor="+$debtor+"&amount="+$amount+"&account="+$account+"&crdtnoteamnts="+$individualamount, function(data) {
  
    // if(data.available =='1'){
                
                 generatecreditnote_moreinvce($date,$debtor,$amount,$remarks,$account,$sabilno.toUpperCase(),$sectornme,$docnumbers,$individualamount);
                // $("#d_progress").dialog("destroy");
     //           }
   // else if(data.available == '0'){
   //         $("#d_progress").dialog("destroy");
   //                 $.modaldialog.warning("<br></br><b>Credit Note Amount Should Not Be More Than Invoice Balance</b>", {
   //          width:400,
   //          showClose: true,
   //          title:"ERROR"
    //        });
     //            }
        
 
   // });
       
        
        }
     
   }); 
   $("#estacc").change(function(){  
     
     //     $("#loader").css("visibility","visible");
     
          $('#subacct').empty();  
                     
           $.getJSON("../finance/json_redirect.php?action=subincmeaccnt&acctid="+$(this).val(), function(data) {
           
         $("#subacct").append("<option value=''>-- Select --</option>");
           for(var $i in data){
           $("#subacct").append("<option value="+data[$i]['id']+">"+data[$i]['accname']+"</option>");
          };
        //  $("#loader").css("visibility","hidden"); 
    });
   });
   $("#ovrpymntsabilno").change(function(){  

          $('#ovrpymntincacc').val('');  

   });
   
      $("#crestacc").live('change',function(){
         
        var crestacc =  $("#crestacc").val();
             var crdtsabil=$("#crdtsabil").val();  //debtor selector
              $("#crdt").val(0);
              
               //var $incaccounts=$("#incaccounts").val();  //income account
         
               var  $debtor=$("#invdebtor").val();  //mumin debtor ejamaat number
       // alert($debtor);
               retrieveUnpaidinvoices($debtor,crdtsabil,crestacc);
    });
    
     $("#crdtamount").keyup(function(){ 
 
 distributecrdtnoteamnt();
 
 });
$("#adddebtor").click(function(){
   
    $("#inv_rqst").dialog("destroy");
     basicLargeDialog("#addebt",500,470);
    $("#addebt").fadeIn("slow");
     $("#muname").val($("#invdebtor").val());
         });
  
      $("#sabinvcenoid").keyup(function(){  // invoice field click listener
    
     if($(this).val().length>=4){
        
         invoice_data($(this).val());
     } else{
         $("#nameinvcenoid").val(" ");
          
     }
      
  });
  
$("#canceladd").click(function(){
      
       $("#invsabil").val('');
       $("#ejnoinv").val('');
        $("#invdebtor").val('');
        var options = {};
        $( "#inv_rqst" ).effect( 'explode', options, 1000, callback );
         $("#inv_rqst").dialog("destroy");
            });
                function callback() {
      setTimeout(function() {
        $( "#inv_rqst" ).removeAttr( "style" ).hide().fadeIn();
      }, 1000 );
    };
  $("#cancelready").click(function(){
       $("#readydebtr").dialog("destroy");
       $("#invsabil").val('');
       $("#ejnoinv").val('');
            });      
   
  
     $("#mdfyinvno").keyup(function(e){  //sabil no field click;

       $("#invmod").css("display","none");
   });
  
  $("#slctdebtor").click(function(){
   
    $("#readydebtr").dialog("destroy");
     document.getElementById("debtor").checked = true;
     $("#invsabil").css("display","none");
     $("#ejnoinv").css("display","none");
     $("#ppp").css("display","block");
      $("#invdebtor").val('');
       $("#gallerydisp").css("display","none");
         });
  
     $("#debtorsaver").click(function(){
       
       var $name =$("#muname").val();
       var $tel=$("#mutel").val();
       var $email=$("#muemail").val();
       var $postal=$("#mupostal").val();
       var $city=$("#mucity").val();
       var $sabil=$("#musabil").val();
       var $remarks=$.trim($("#murmks").val());
              if($name=="" || $tel=="" || $city=="" ){
           
           alert("Error. Fields marked with * are required");
           
        }
        else{
        savemumindebtor($name,$tel,$email,$postal,$city,$remarks,$sabil);
        
        }
            });
        
        $("#ejnoinv").keyup(function(){  // invoice field click listener
    
     if($(this).val().length>=8){
        
        ejinvoice_data($(this).val());
     } else{
         $("#sabilname").val(" ");
           $("#invsabil").val(" ");
     }
      
  });
  //New invoice button
    $("#gnrt").click(function(){
       
     $("#d_progress").show(); basicLargeDialog("#d_progress",50,150);
         $(".ui-dialog-titlebar").hide();
        var $sabilno=$("#invsabil").val();
        
        var $debtor=$("#invdebtor").val();
        
        var $dispname=$("#sabilname").val();
         
        var $account=$("#estacc").val();
        
       var $sectornme=$("#sectornme").val();
           
        var $total_amount=$("#invamount100").val().replace(/[^0-9\.]+/g,"");
        
        var $rmks=$("#invrmks100").val().replace(/["',]/g,"/");
        
        var $date=$("#invdt").val();
		
		var $subacct = $("#subacct").val();
        // Check fields
        if( $total_amount=="" || parseFloat($total_amount)<=0 || $date=="" || $dispname=="" || $account=="" ){
           
           $.modaldialog.warning("<br></br><b>Ensure all fields are completed </b>", {
             width:400,
             showClose: true,
             title:"Missing Data!!!"
            });
         $("#d_progress").dialog("destroy");
        }
       
        else{
            //Generate new invoice function
        generate_outgoing_invoice($date,$sabilno.toUpperCase(),$debtor,$account,$total_amount,$rmks,$dispname,$sectornme,$subacct);
        //$("#d_progress").dialog("destroy");
        }
       
   });
   $('#debtor').click(function(){
       $("#invsabilgallerydisp").css("display","none");
       $("#ppp").css("display","block");
       $("#ejnoinv").css("display","none");
       $("#gallerydisp").css("display","none");
       $("#invsabil").css("display","none");
       $("#crdtsabil").css("display","none");
       $("#sabilname").css("display","none");
	   $("#tdname4").hide();
       $("#namefld").css("display","none");
        $("#sabilname").val('');
        $("#invdebtor ").val('');
         $("#estacc").val('');
          $("#ejnoinv").val('');
	$("#crdtinvce").val('');
	$("#creditamount").val('');
        $("#disp_invoices").empty();
        $("#crestacc").val('');
         $("#crdtsabil").val('');
   });
      $('#muminchk').click(function(){
       $("#ppp").css("display","none");
       $("#invsabil").css("display","block");
       $("#ejnoinv").css("display","block");
       $("#gallerydisp").css("display","block");
       $("#sabilname").css("display","block");
       $("#crdtsabil").css("display","block");
	   $("#tdname4").show();
	   $("#namefld").show();
       $("#invsabil").val('');
       $("#sabilname").val('');
       $("#estacc").val('');
       $("#ejnoinv").val('');
	$("#crdtinvce").val('');
	$("#creditamount").val('');
         $("#invdebtor").val('');
         $("#disp_invoices").empty();
         $("#crestacc").val('');
   });
   
         $('#depositdate').click(function(){
       $("#bydepono").css("display","none");
        $("#bydepodate").css("display","block");

   });
        $('#depositno').click(function(){
       $("#bydepono").css("display","block");
        $("#bydepodate").css("display","none");

   });
   
         $('#psabil').click(function(){
              $("#batchpinvoice").css("display","block");
              $("#batchsablinvoice").css("display","none");
              $("#individualpinvoice").css("display","block");
               $("#individualsablinvoice").css("display","none");
   });
                 $('#hsesabil').click(function(){
              $("#batchpinvoice").css("display","none");
              $("#batchsablinvoice").css("display","block");
              $("#individualpinvoice").css("display","none");
               $("#individualsablinvoice").css("display","block");
   });
  $("#ejnoinv").keypress(function(e){  // invoice field click listener
    
    if(e.keyCode==13){
        
        ejinvoice_data($(this).val());
    }
      
  });
    $("#gallerydisp").click(function(){  // invoice field click listener
   
    $("#gallery").fadeIn('Slow');
      
  }); 
  
  $("#closegallery").click(function(){  // invoice field click listener
   
    $("#gallery").fadeOut('Slow');
      
  }); 
     
   $("#namesrch").keyup(function(){  // gallery field click listener
   
   var sname= $("#snamesrch").val();
    searchbyname($(this).val(),sname);
      
  });
    $("#snamesrch").keyup(function(){  // gallery field click listener
   
   var fname= $("#namesrch").val();
    searchbyname(fname,$(this).val());
      
  });
  $("#viewcrdtlist").click(function(){
      
      
      var $category=$("#crdtcat").val();
      var $fromdate=$("#crdtstartdate").val();
      var $todate=$("#crdtenddate").val();
      var $dept=$("#crdtdpt").val();
       window.open('../finance/creditnotelist.php?category='+$category+'&sdate='+$fromdate+'&edate='+$todate+'&dpt='+$dept+'','','width=1300,height=800,toolbar=0,menubar=1,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
      
  });
     $("#viewinvoicelist").click(function(){
      
      
      var $category=$("#invoicecat").val();
      var $fromdate=$("#invoicestartdate").val();
      var $todate=$("#invoiceenddate").val();
      var $dept=$("#invoicedpt").val();
      window.open('../finance/invoicelistpreview.php?category='+$category+'&sdate='+$fromdate+'&edate='+$todate+'&dpt='+$dept+'','','width=900,height=800,toolbar=0,menubar=1,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
      
  });

});
function showprogressbar (){
     $("#d_progress").show(); basicLargeDialog("#d_progress",50,150);
         $(".ui-dialog-titlebar").hide();
}
        function savemumindebtor($name,$tel,$email,$postal,$city,$remarks,$sabil){
            
                 var $dataString={name:$name,telephone:$tel,email:$email,postal:$postal,city:$city,remarks:$remarks,sabilno:$sabil};
        
      var $urlString="../finance/redirect.php?action=savemumindebtor";

               $.ajax({                                                                        
                
                url: $urlString,
                
                type: "GET",
                
                dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
                data:$dataString,
                
                success: function(response) {
                
                 
            if(response.id===1){ 
             

             
              $("#succes").css("display","block").html("<b>Debtor added successfully</b>");
        $("#succes").css("background", "yellowgreen");
       
  setTimeout(function() {   //Set timeout for display of message
      $("#succes").css("display", "none");
}, 3000);
                           $("#d_progress").dialog("destroy");
             document.getElementById("debtor").checked = true;
             $("#invsabil").css("display","none");
              $("#ejnoinv").css("display","none");
             
             $("#invdebtor").val($name);  
             $("#ppp").css("display","block");
             $("#addebt").dialog("destroy"); 
                          
        $("#sabilname").val($name);
         //window.location.reload(); 
                 }
             else{
              
             $("#addebt").dialog("destroy");
                 
             alert("Debtor not saved-please try again later");
              
              
                    
             }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
                  alert("Debtor not saved-please try again later");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              });         
        }
    function ejinvoice_data($val){
     
       
     if($val.length>=8){
          
    $.getJSON("../finance/redirect.php?action=getmuminMohala&ejno="+$val, function(data) {
  
     if(data.name =='Not in Mohalla'){
                basicLargeDialog("#inv_rqst",450,350);

     }
    else if(data.name == 'debtor'){
                alert ('Debtor');
        }
    else{
     
            $("#sabilname").val(data.name);
           $("#invsabil").val(data.sabil);
        }
    
 
    });
       }
       else{
           
       }
   
}  

        function searchbyname($muminname,sname){

    $("#phts").empty();
        //$("#invoicestatement").load("/ashara/accountsdata.php?choose=acctsrcvblesummary&from="+date+"&to="+todate).fadeIn("slow");
    $("#phts").load("../finance/redirect.php?action=photos&name="+$muminname+"&sname="+sname).fadeIn("slow");
    $("#phts").css("display","block");

}
 function ejnosabil(i){
     //alert('TESTING');
     $("#sectornme").val("");
     $("#gallery").fadeOut("slow");
     //var $sabilno = $("#image").value;
     var sabil = document.getElementById('sabilimg'+i).getAttribute("value");
     var sctorname = document.getElementById('sectorname'+i).textContent;
     var ejamaat = document.getElementById('spanid'+i).textContent;
     $("#sectornme").val(sctorname);
     $("#ejnoinv").val(ejamaat);
     $("#invsabil").val(sabil);
     $("#debtor_mumin_name").css("display","block");
      $("#mumineendebtor").val(sabil);
	$("#statsabil").val(sabil);
   $("#statmntfield").css("display","block");
      var name = document.getElementById('spaname'+i).textContent;
      $("#sabilname").val(name); $("#muminsectr").val(sctorname)
      document.getElementById("debtor_mumin_name").innerHTML=name;
  
      
      
     //$("#fetchedsabno").css("display","block");
     
 }
 
 function generatecreditnote($date,$debtor,$amount,$remarks,$account,$sabilno,$sectornme,$invoice){ //OUT GOING credit note   GENERATION
 
  var $dataString={date:$date,debtor:$debtor,amount:$amount,remarks:$remarks,account:$account,sabilno:$sabilno,sectorname:$sectornme,crditinvce:$invoice};
        
      var $urlString="../finance/json_redirect.php?action=creditnote";

               $.ajax({                                                                        
                
                url: $urlString,
                
                type: "GET",
                
                dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
                data:$dataString,
                
                success: function(response) {
                
                 
            if(response.flag==="Ok"){ 
             
             $("#d_progress").dialog("destroy");

             window.location="../finance/creditnote.php?paymentdate="+$date+"&remarks="+$remarks+"&amount="+$amount+"&sabilno="+response.sabilno+"&docno="+response.docno+"&debtor="+response.debtor+"&invoice="+response.invoice+"&accounts="+response.accounts+"&sector=";
             }
                 else {
               
               $("#d_progress").dialog("destroy");
               
             $.modaldialog.warning(response.errmessage, {
             width:400,
             showClose: true,
             title:"ERROR"
            });
                 }
                 
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
                  alert("Could not generate credit note now");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              }); 
    
    
}
 function generatecreditnote_moreinvce($date,$debtor,$amount,$remarks,$account,$sabilno,$sectornme,$docnumbers,$individualamount){ //OUT GOING credit note   GENERATION
 
  var $dataString={date:$date,debtor:$debtor,amount:$amount,remarks:$remarks,account:$account,sabilno:$sabilno,sectorname:$sectornme,crditinvce:$docnumbers,individualamnt:$individualamount};
        
      var $urlString="../finance/json_redirect.php?action=creditnotes";

               $.ajax({                                                                        
                
                url: $urlString,
                
                type: "GET",
                
                dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
                data:$dataString,
                
                success: function(response) {
                
                 
            if(response.flag==="Ok"){ 
             
             $("#d_progress").dialog("destroy");

             window.location="../finance/creditnote.php?paymentdate="+$date+"&remarks="+$remarks+"&amount="+$amount+"&sabilno="+response.sabilno+"&docno="+response.docno+"&debtor="+response.debtor+"&invoice="+response.invoice+"&accounts="+response.accounts+"&sector=";
             }
                 else {
               
               $("#d_progress").dialog("destroy");
               
             $.modaldialog.warning(response.errmessage, {
             width:400,
             showClose: true,
             title:"ERROR"
            });
                 }
                 
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
                  alert("Could not generate credit note now");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              }); 
    
    
}
function viewamount (){
    var $crdtinvceno = $("#crdtinvce").val();
    var invdebtor = $("#invdebtor").val();
    var invsabil = $("#invsabil").val();
       $.getJSON("../finance/redirect.php?action=getinvoicedetails&invceno="+$crdtinvceno+"&invdebtor="+invdebtor+"&invsabil="+invsabil, function(data) {
  
     if(data.available =='1'){
                $("#creditamount").val(data.iamount);
                $("#creditremarks").val(data.iamountiremarks);
                $("#estacc").val(data.incacc);
                 
         }
    else if(data.available == '0'){
             $.modaldialog.warning("<br></br><b>INVOICE NO: "+$crdtinvceno+" NOT FOUND FOR "+invdebtor+invsabil.toUpperCase()+" </b>", {
             width:400,
             showClose: true,
             title:"ERROR"
            });
           $("#crdtinvce").val("");
           $("#creditamount").val("");
                $("#creditremarks").val("");
                $("#estacc").val("");
           }
        
 
    });
}


function generate_outgoing_invoice($date,$sabilno,$debtor,$account,$total_amount,$rmks,$dispname,$sectornme,$subacct){ //OUT GOING  INVOICE   GENERATION
 
  var $dataString={date:$date,sabilno:$sabilno,debtor:$debtor,account:$account,total:$total_amount,rmks:$rmks,dispname:$dispname,sectornme:$sectornme,subacct:$subacct};
        
      var $urlString="../finance/json_redirect.php?action=outgoinginvoice";

               $.ajax({                                                                        
                
                url: $urlString,
                
                type: "GET",
                
                dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
                data:$dataString,
                
                success: function(response){
					alert (response.id);
            if(response.id===1){ 
             
             $("#d_progress").dialog("destroy");
         
             $("#invsabil").val("");
            
             $("#invdebtor").val("");
         
             $("#invamount100").val("0.00");
        
             $("#invrmks100").val("");  
            //basicLargeDialog("#inv_success",500,200);
              //Open window and display invoice
             window.location="../finance/invoicepreview.php?paymentdate="+$date+"&remarks="+$rmks+"&amount="+$total_amount+"&sabilno="+$sabilno+"&docno="+response.invoice+"&debtor="+$debtor+"&dispname="+$dispname+"&acctname="+response.acctname+"&tel="+response.tel+"&city="+response.city+"&sector="+$sectornme+"&subacct="+$subacct+"&reprint="+0;
                 
             }
                 else {
               
               $("#d_progress").dialog("destroy");
               
             $.modaldialog.warning('Could not generate invoice now', {
             width:400,
             showClose: true,
             title:"ERROR"
            });
                 }
                 
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
                  alert("Could not generate invoice nffsow");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              }); 
    
    
}
function retrieveUnpaidinvoices($debtor,crdtsabil,crestacc){
    //alert($debtor);
    if(!$debtor && !crdtsabil){
                   $.modaldialog.warning('<br></br><b>Complete the Fields as Required</b>', {
             timeout: 3,
             width:500,
             showClose: false,
             title:"Warning"
            });
    }
    else{
   var $dataString={debtor:$debtor,sabilno:crdtsabil,incacct:crestacc};
        //alert();
      var $urlString="../finance/json_redirect.php?action=unpaidinvoices";

               $.ajax({                                                                        
                
                url: $urlString,
                
                type: "GET",
                
                dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
                data:$dataString,
                
                success: function(response) {
                
                
            if(response.length>0){ 
            // $("#tabs").css("display","block");
           $("#d_progress").dialog("destroy");
             
           $("#disp_invoices").empty(); 
           
           // document.getElementById("debtor_mumin_name").innerHTML="";
           
          
           $("#disp_invoices").append("<thead><tr style='font-size:12px'><th>Doc date.</th><th>Doc Type</th><th>Doc No.</th><th>Account</th><th>Balance</th><th>Paid</th><th>Credit</th><th>Pay</th></tr></thead>");
           
           $("#disp_invoices").append("<tbody>");
          
           
          // var left = (screen.width/2)-(1000/2);
          // var top = (screen.height/2)-(600/2);
            
             for(var $t in response){
  
              //$("#debtor_mumin_name").css("display","block");
             // $("#muminsectr"). val(response[$t].sectr);
              //document.getElementById("debtor_mumin_name").innerHTML=response[$t].ourdebtor;
              
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
              $("#disp_invoices").append("<tr><td >"+response[$t]['idate']+"</td><td>"+docname+"</td><td id='bxxn"+$t+"'>"+response[$t]['invno']+"</td><td id='incme"+$t+"'>"+response[$t]['accname']+"</td><td style='display:none' id='cxamx"+$t+"'>"+parseFloat(response[$t]['amount'])+"</td><td>"+bal.toFixed(2)+"</td><td id='pdamnt"+$t+"'>"+response[$t]['paidamnt']+"</td><td >"+ 
             "<input type='text' id='amntopay"+$t+"' min='0' onkeyup='updateamnt("+$t+")' class='amount'  style='display: "+display+";width:150px;' /></td><td><input type='checkbox' class='unpaidcheckboxx' id='unpcxx"+$t+"'/><input type='checkbox' class='halfpay' id='unpcbx"+$t+"' hidden/><input type='checkbox' class='creditedinvce' id='crdtedinvce"+$t+"' hidden/><input type='text' hidden id='incmeid"+$t+"' value='"+response[$t]['incacc']+"'/></td></tr>");
             //}
       //  else if(parseInt(response[$t]['amount'])<0){
         //   var $displaval= 0;
          //  $displaval = parseInt(response[$t]['amount'])+ parseInt(response[$t]['paidamnt']);
          //   $("#billstable2").append("<tr><td>"+response[$t]['idate']+"</td><td id='bxxn"+$t+"'>"+response[$t]['invno']+"</td><td>"+response[$t]['accname']+"</td><td id='cxamx"+$t+"'>"+response[$t]['amount']+"</td><td id='pdamnt"+$t+"'>"+response[$t]['paidamnt']+"</td><td id='pdamnt"+$t+"'></td><input type='text' id='amntopay"+$t+"'onkeyup='updateamnt("+$t+")' hidden value='"+$displaval+"' /><td><input type='checkbox' class='unpaidcheckboxx' id='unpcxx"+$t+"'/></td></tr>");
           
         //}
         }
              $("#disp_invoices").append("</tbody>");
             // pulloutlinkedaccount($incaccounts);
                 }
             else{
                
             
                  $("#d_progress").dialog("destroy"); 
                  
                //  document.getElementById("debtor_mumin_name").innerHTML="";
                   
                 // $("#debtor_mumin_name").css("display","none");
                
                  $("#disp_invoices").empty(); 
              
                 // $("#tabs").css("display","none");
                  
                  alert("No Pending Invoice found");
                  $("#crestacc").val(""); 
                  
                    
             }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  $("#crestacc").val("");
                  alert("No Invoice found");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              });      
                 
}}
function distributecrdtnoteamnt(){
        var oidata = [];
var poidata = "", poibalance = "" , sumbal = 0; 
 var $pendinginvces = $('.unpaidcheckboxx').length;
 var total = $("#crdtamount").val().replace(/[^0-9\.]+/g,"");
 
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
                     if($("#crestacc").val()==""){
                    $.modaldialog.warning('<b><br></br>Not Possible to pay in different Income Accounts</b>', {
             timeout: 10,
             width:500,
             showClose: true,
             title:"Warning"
            });
                $('.unpaidcheckboxx').attr('checked',false);
                $('.amount').val(0);
                
                 //$("#ckamount100").val(0);
               //  $("#cshamount100").val(0);
                    }
            else{
                                 $('#amntopay'+i).val(dataValue);
                             $("#unpcxx"+i).attr('checked','checked');
                             
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
                                    var afterovp =    parseFloat($('#amntopay'+ind).val()) + parseFloat(total);
                                          $('#amntopay'+ind).val(afterovp);
                                          $("#overpayment_rqst").dialog("destroy");
                                        
				});
                                   function callback() {
      setTimeout(function() {
        $( "#overpayment_rqst" ).removeAttr( "style" ).hide().fadeIn();
      }, 1000 );
    };
                                $("#cancelovrpaymnt").click(function(){
                                       $("#crdtamount").val(0);
                                      
                                      $('.unpaidcheckboxx').attr('checked',false);
                $('.amount').val(0);
                
                   var options = {};
        $( "#overpayment_rqst" ).effect( 'explode', options, 1000, callback );
	$("#overpayment_rqst").dialog("close");
	 $("#overpayment_rqst").css("display","none") ;
			});
            }
            
}