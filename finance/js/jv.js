$(function(){
    
       $("#passjv").click((function(){ //admin  J.V.   
       
               
        var $jvdate=$("#jvdate").val();
        
        var $jvamount=$("#jvamount").val().replace(/[^0-9\.]+/g,"");
        var   $jvfrom = $("#jvfrom2").val();
        var   $jvto =$("#jvto2").val();
        var debitype = $("#myLabel2").val();    
        var $sector = $("#myLabel").val();
               // } else {
               // $sector = "0";
               // }
           // alert ($sector);
         var $ckdte=$("#ckdte").val();
         var $chkno=$("#chkno").val();
         var $chkdetails=$("#chkdetails").val();
           var $jvrmks=$("#jvrmks").val();
         if(debitype){}
        //alert (debitype);
         
     if($jvfrom!=="" && $jvto!=="" && $jvdate!=="" && $jvamount!=="" && $jvrmks!=="" ){
          if( ($jvfrom==$jvto) && (debitype== '1' && $sector== '1') || (debitype== '0' && $sector== '0')){
              $.modaldialog.error('<br></br><b>Cant Transfer to the same account</b>', {
          title: 'Error occured',
          showClose: true
          });
          }
         else{
         basicLargeDialog("#d_progress",50,150);
              
       $(".ui-dialog-titlebar").hide();
       
    $.getJSON("../finance/json_redirect.php?action=savejv&jvfrom="+$jvfrom+"&jvto="+$jvto+"&jvrmks="+$jvrmks+"&jvamount="+$jvamount+"&jvdate="+$jvdate+"&sectr="+$sector+"&debityp="+debitype+"&ckdte="+$ckdte+"&chkno="+$chkno+"&chkdetails="+$chkdetails, function(data) {
    
             
     if(data.id===1){
        
         $("#d_progress").dialog("destroy");
         
           
           $.modaldialog.success('Journal Entry completed successfull', {
          title: 'Success transaction',
          showClose: true
          });  
          $("#jvamount").val("");
          $("#jvfrom").val("");
          $("#jvto").val("");
         $("#jvrmks").val("");
         //$()
        window.location="../finance/jv_preview.php?jvdate="+$jvdate+"&jvfrom="+$jvfrom+"&jvto="+$jvto+"&jvamount="+$jvamount+"&jvrmks="+$jvrmks+"&jvno="+data.jvno+"&crdtype="+$sector+"&dbtype="+debitype+"&ckdte="+$ckdte+"&chkno="+$chkno+"&chkdetails="+$chkdetails;
     }
 else if(data.id===2){
            $("#d_progress").dialog("destroy");
          
           $.modaldialog.error('Please check that information you supplied in Debit Account and Credit Account is valid and try again', {
          title: 'Error occured',
          showClose: true
          });
 }
 else{
          $("#d_progress").dialog("destroy");
           $.modaldialog.error('An Error occured and cannot complete your request- Please try again later', { 
          title: 'Error occured',
          showClose: true
          });
 }
    });
           }}
       else{
             $.modaldialog.error('All FIELDS MUST be filled', {
          title: 'Error occured',
          showClose: true
          });
       }
       
   }));  
   
   $("#passdirectexp").click((function(){ //admin  update estate username /pword   
       
               
        var $dexpdate=$("#jvdate2").val();
        
        var $dxamount =$("#dxamount").val().replace(/[^0-9\.]+/g,"");
        var   $expensacc = $("#jvfrom").val();
        var   $crdtacc =$("#jvto").val();
         var $ckdte=$("#ckdte2").val();
         var $chkno=$("#chkno2").val();
         var $chkdetails=$("#chkdetails2").val();
           var $dxrmks=$("#dxrmks").val();
         var $sectr = $("#mysector").val();
        var $cstcntreid = $("#cstcntreid").val();
         
     if($dexpdate!=="" && $dxamount!=="" && $expensacc!=="" && $crdtacc!=="" && $dxrmks!=="" && $cstcntreid !=="" && $cstcntreid !=="0"){
               
         basicLargeDialog("#d_progress",50,150);
              
       $(".ui-dialog-titlebar").hide();
       
    $.getJSON("../finance/json_redirect.php?action=savedrctexp&expensacc="+$expensacc+"&crdtacc="+$crdtacc+"&dexpdate="+$dexpdate+"&dxamount="+$dxamount+"&ckdte="+$ckdte+"&chkno="+$chkno+"&chkdetails="+$chkdetails+"&remks="+$dxrmks+"&sectr="+$sectr+"&ccntrid="+$cstcntreid, function(data) {
    
             
     if(data.id===1){
        
         $("#d_progress").dialog("destroy");
         
           
           $.modaldialog.success('Journal Entry completed successfull', {
          title: 'Success transaction',
          showClose: true
          }); 
          $("#ckdte2").val("");
          $("#chkno2").val("");
          $("#chkdetails2").val("");
          $("#jvfrom").val("");
          $("#dxrmks").val("");
         $("#dxamount").val("");
        window.location="../finance/directexpreview.php?dexpdate="+$dexpdate+"&expensacc="+$expensacc+"&crdtacc="+$crdtacc+"&dxamount="+$dxamount+"&remks="+$dxrmks+"&dexpvno="+data.dexpvno+"&ckdte="+$ckdte+"&chkno="+$chkno+"&chkdetails="+$chkdetails+"&cstcntreid="+$cstcntreid;
     }
 else if(data.id===2){
            $("#d_progress").dialog("destroy");
          
           $.modaldialog.error('Please check that information you supplied in Debit Account and Credit Account is valid and try again', {
          title: 'Error occured',
          showClose: true
          });
 }
 else{
          $("#d_progress").dialog("destroy");
           $.modaldialog.error('An Error occured and cannot complete your request- Please try again later', { 
          title: 'Error occured',
          showClose: true
          });
 }
    });
           }
       else{
             $.modaldialog.error('<b><br></br>All FIELDS MUST be filled</b>', {
          title: 'Error occured',
          showClose: true
          });
       }
       
   }));
   
     $("#jvto2").change(function(){
       
       var $jvto =$("#jvto2").val();
      var jvtoname = $("#jvto2 option:selected").text();
            $.getJSON("../finance/json_redirect.php?action=selectsctr&jvto="+$jvto+"&idname="+jvtoname, function(response){
         if(response){
            
           if(response.typ =='G' || response.typ =='L'){
           $("#myLabel").val(0);
           }
           else {
               $("#myLabel").val(1);
           }
           if(response.type=='B' || response.typ=='G'){
           $("#datelabel").fadeIn("slow"); $("#ckdte").val("");
           $("#dateinpt").fadeIn("slow");   $("#chkno").val("");
           $("#typebank").fadeIn("slow");   $("#chkdetails").val("");
                }
            else if (response.type=='C'){
                $("#datelabel").fadeOut("slow");  $("#ckdte").val("");
           $("#dateinpt").fadeOut("slow");        $("#chkno").val("");
           $("#typebank").fadeOut("slow");        $("#chkdetails").val("");
            }
           //}
             } 
       
     });
     });
  // PASS JV: NB: make sure bank ids and income account grant and Loans are not the same
  $("#jvfrom2").live('change',function(){
       
     var $jvto =$("#jvfrom2").val();
       var jvtoname = $("#jvfrom2 option:selected").text();
      // alert(jvtoname);
   $.getJSON("../finance/json_redirect.php?action=selectsctr&jvto="+$jvto+"&idname="+jvtoname, function(response){
         if(response){
            //alert(response.typ);
              if(response.typ=='G' || response.typ=='L'){
           $("#myLabel2").val(0);
           }
           else {
               $("#myLabel2").val(1);
           }
          //var sectorm = ;
          // if(response.sector === tosect ||(response.sector !== "" && tosect !=="")){
             //  $.modaldialog.error('<br></br><b>Not allowed - Please check the selection</b>', { 
          //title: 'Error occured',
         // showClose: true
         // });
             //  $("#jvfrom2").val('');
          // }else{
          // $("#myLabel2").val(response.sector);
             // }
         } 
     
         
     });
     });
  $("#jvto").live('change',function(){
       
       var $jvto =$("#jvto").val();
      $("#mysector").val("");
     $.getJSON("../finance/json_redirect.php?action=selectsctr&jvto="+$jvto, function(response){
         if(response){
          //var sectorm = ;
          $("#mysector").val(response.sector);
           if(response.type=='B'){
              $("#datelabel2").fadeIn("slow");
              $("#dateinpt2").fadeIn("slow");
               $("#typebank2").fadeIn("slow");
               
           }
           else{
               $("#datelabel2").fadeOut("slow");  $("#ckdte2").val("");
              $("#dateinpt2").fadeOut("slow");      $("#chkno2").val("");
               $("#typebank2").fadeOut("slow");     $("#chkdetails2").val("");
           }
       
         }
     
         
     });
     });
 $("#jvlist").click(function(){      
   
  var $startdate= $("#jvstartdate").val();
  var $enddate= $("#jvenddate").val();

  window.open("../finance/jvlist.php?startdate="+$startdate+"&enddate="+$enddate,'','width=800,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
   
   
   });
    $("#creatable").click(function(){      
   var rowcount = $("#rowcount").val();
   $("#appendtable").empty();
   for (var u=1;u <=rowcount;u++ ){
     $("#appendtable").append('<tr><td><select class="formfield dc" style="width: 50px" id="ledger_dc'+u+'"><option value="dr" selected>Dr</option><option  value="cr">Cr</option></select></td>\n\
                                    <td><select class="formfield ledgerids" id="ledgerid'+u+'"><option selected value="">--Select--</option></td>\n\
                                    <td><input id="dbtamnt'+u+'"  value="0" class="amount dramount" disabled="true" onkeyup="updatedramnt('+u+')" onchange="updatediff() "/></td><td><input id="crdtamnt'+u+'" value="" class="amount cramount" disabled="true" onkeyup="updatecramnt('+u+')" onchange="updatediff()"/></td>\n\
                                    <td hidden="true" class="tbltype"></td></tr>'); 
            
        }
 getledgeraccounts();
   $("#appendtable").append('<tr><td></td></tr><tr style="height: 30px;"><td></td><td style="font-size:14px">Total</td><td style="background-color: yellowgreen;  font-size:14px" id="drtotal"></td><td style="background-color: yellowgreen;font-size:14px" id="crtotal"></td></tr>\n\
                             <tr><td></td></tr><tr style="height: 30px;"><td></td><td style="font-size:12px; color: red">Difference</td><td id="dr-diff"></td><td id="cr-diff"></td></tr>\n\
                            <tr><td>Date:</td><td><input type="text" class="formfield" id="journaldate" /></td></tr>\n\
                            <tr><td>Rmks:</td><td><textarea class="formfield" id="journalrmks"/></td></tr>');
   $("#journaldate" ).datepicker({ dateFormat: 'dd-mm-yy',changeMonth: true} );
    });
   
   $(".dc").live('change',function(){
   var $id=$(this).attr("id");
   var $inputid = $id.substring(9);
   if($(this).val()=='dr' && $("#ledgerid"+$inputid).val()!=""){
         $("#crdtamnt"+$inputid).attr("disabled",true);
        document.getElementById("crdtamnt"+$inputid).style.backgroundColor = "grey";
        $("#crdtamnt"+$inputid).val(0);
        updatedramnt();
        updatecramnt();
        updatediff();
         $("#dbtamnt"+$inputid).attr("disabled",false);
         document.getElementById("dbtamnt"+$inputid).style.backgroundColor = "white";
         }else if($(this).val()=='cr' && $("#ledgerid"+$inputid).val()!=""){
        $("#dbtamnt"+$inputid).attr("disabled",true);
        $("#crdtamnt"+$inputid).attr("disabled",false);
        document.getElementById("crdtamnt"+$inputid).style.backgroundColor = "white";
        document.getElementById("dbtamnt"+$inputid).style.backgroundColor = "grey";
        $("#dbtamnt"+$inputid).val(0);
        updatedramnt();
        updatecramnt();
        updatediff();
         }
   });
   
    $(".ledgerids").live('change',function(){
   var $id=$(this).attr("id");
   var $inputid = $id.substring(8);
   
   if($("#ledger_dc"+$inputid).val()=='dr' && $("#ledgerid"+$inputid).val()!=""){
         $("#crdtamnt"+$inputid).attr("disabled",true);
        document.getElementById("crdtamnt"+$inputid).style.backgroundColor = "grey";
        $("#crdtamnt"+$inputid).val(0);
        updatedramnt();
        updatecramnt();
       // updatediff();
         $("#dbtamnt"+$inputid).attr("disabled",false);
         document.getElementById("dbtamnt"+$inputid).style.backgroundColor = "white";
         }else if($("#ledger_dc"+$inputid).val()=='cr' && $("#ledgerid"+$inputid).val()!=""){
        $("#dbtamnt"+$inputid).attr("disabled",true);
        $("#crdtamnt"+$inputid).attr("disabled",false);
        document.getElementById("crdtamnt"+$inputid).style.backgroundColor = "white";
        document.getElementById("dbtamnt"+$inputid).style.backgroundColor = "grey";
        $("#dbtamnt"+$inputid).val(0);
        updatedramnt();
        updatecramnt();
      //  updatediff();
         } else if ($("#ledgerid"+$inputid).val()==""){
        $("#dbtamnt"+$inputid).attr("disabled",true);
        $("#crdtamnt"+$inputid).attr("disabled",true);
        document.getElementById("crdtamnt"+$inputid).style.backgroundColor = "grey";
        document.getElementById("dbtamnt"+$inputid).style.backgroundColor = "grey";
         }
   });
   
  $("#dexpenselist").click(function(){      
   
  var $startdate= $("#directstartdate").val();
  var $enddate= $("#directenddate").val();
   var $drctxpnse= $("#drctxpnse").val();

  window.open("../finance/drctxpnselist.php?startdate="+$startdate+"&enddate="+$enddate+"&drctxpense="+$drctxpnse,'','width=1000,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
   
   
   });    
});
function getledgeraccounts(){

    $.getJSON("../finance/json_redirect.php?action=getallledgeraccount", function(data) {
    
    $.each(data, function(i, item) {
       
    $(".ledgerids").append("<option value="+item.incacc+"|"+item.tbl+"|"+item.typ+">"+item.accname+" - "+item.typ+"</option>");
    //$(".tbltype").append("<input type='text' value="+item.tbl+"></input>");  
       });
      
  });
}
function updatedramnt(i){
   // alert($('.dramount').length);
    var cashamount2 = 0; 
      for (var j=1;j<=($('.dramount').length);j++){

  if ($("#dbtamnt"+j).val() == ''){
	
	var $pldgeamount = 0;
		
		  } else {
	
	$pldgeamount = $("#dbtamnt"+j).val();
	
			  }
	

 
		cashamount2 = parseFloat($pldgeamount)+ parseFloat(cashamount2) ;
    }
     $('#drtotal').html(cashamount2);
    // alert(parseFloat($('#crtotal').html()));
     
}
function updatecramnt(){
      var amount2 = 0; 
      for (var j=1;j<=($('.cramount').length);j++){

  if ($("#crdtamnt"+j).val() == ''){
	
	var $amount = 0;
		
		  } else {
	
	$amount = $("#crdtamnt"+j).val();
	
			  }
	

 
		amount2 = parseFloat($amount)+ parseFloat(amount2) ;
    }
     $('#crtotal').html(amount2);
     
}
function updatediff(){
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
         $("#appendtable").append('<tr><td></td><td ><button id="create" onclick="passjournalentry()">Create</button></tr>');
     }
    
}
function passjournalentry(){
    
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
      basicLargeDialog("#d_progress",50,150);
              
       $(".ui-dialog-titlebar").hide();
     $.getJSON("../finance/json_redirect.php?action=savejournalentry&ledgertype="+$entrytype+"&ledgeraccts="+$ledgeraccts+"&dramount="+dramount+"&cramount="+cramount+"&journaldate="+journaldate+"&journalrmks="+journakrmks, function(data) {
         
              if(data.id===1){
        
         $("#d_progress").dialog("destroy");
       window.location="../finance/journalpreview.php?ledgertype="+$entrytype+"&ledgeraccts="+$ledgeraccts+"&dramount="+dramount+"&cramount="+cramount+"&journaldate="+journaldate+"&journalrmks="+journakrmks+"&journalno="+data.journalno;
   
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
           $.modaldialog.success('<br></br><b>Journal Entry completed successfully</b>', {
          title: 'Success transaction',
          showClose: true
          });  
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