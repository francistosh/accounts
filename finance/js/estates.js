 
var ejamaatNos=[];  //global array to hold ejamaat numbers   members for population ejnos select

$(function(){
     
   // $.getJSON("../muminoperations/json_redirect.php?action=autocomplete", function(data) {
   
   // $.each(data, function(i, item) {
      
   // ejamaatNos.push(item.ejno);  
        
  //     });
   //});
   
   
   
 $("#estate_nameid").change(function(){
   
    $("#estate_bankid").empty();
   
    $.getJSON("../finance/json_redirect.php?action=getallbankaccountsforthisestate&id="+$(this).val(), function(data) {
   
     $("#estate_bankid").append("<option value='999'>--select bank--</option>");
   
    $.each(data, function(i, item) {
       
    $("#estate_bankid").append("<option value="+item.acno+">"+item.acname+"</option>");
        
       });
      
  });
  }); 
   
    $("#compname").change(function(){
   
    $("#incmeacount").empty();
   
    $.getJSON("../finance/json_redirect.php?action=getallincomeforthiscompany&id="+$(this).val(), function(data) {
   
     $("#incmeacount").append("<option value=''>--select account--</option>");
   
    $.each(data, function(i, item) {
       
    $("#incmeacount").append("<option value="+item.incacc+">"+item.accname+"</option>");
        
       });
      
  });
  });
   
       $("#compnyname").change(function(event){
   event.stopImmediatePropagation();
    $("#expnseacount").empty();
   
    $.getJSON("../finance/json_redirect.php?action=getallexpnseforthiscompany&id="+$(this).val(), function(data) {
   
     $("#expnseacount").append("<option value=''>--select account--</option>");
   
    $.each(data, function(i, item) {
       
    $("#expnseacount").append("<option value="+item.id+">"+item.accname+"</option>");
        
       });
      
  });
  });
 
    $("#report_go").click((function(){  //generate reports
        
       var $fields="";  //global array to hold invoice numbers for payment
  
       for(var j=0;j<=$(".r_port").length;j++){
         
        if ($("#rpt"+j).is(':checked')) {
          
           var $val=$("#rpt"+j).val();
           
        
          $fields+=$val+",";
           
       
           
         
            } 
            else{} 
              
      
      
     
      
       
   }
  
  
  
   window.open('../finance/reportview.php?action=general&fields='+$fields+'','','width=1500,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
})); 
   
   
   
   
   
  $("#report_go_sabil").click((function(){  //generate reports
        
       var $fields="";  //global array to hold invoice numbers for payment
  
       for(var j=0;j<=$(".r_port").length;j++){
         
        if ($("#rpt"+j).is(':checked')) {
          
           var $val=$("#rpt"+j).val();
           
        
          $fields+=$val+",";
           
       
           
         
            } 
            else{}   
              
      
      
     
      
       
   }
   window.open('../finance/reportview.php?action=sabil&fields='+$fields+'','','width=1500,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
}));  


 
   
   
   
   
   
  $("#balanceType").change(function(){
      
         if($(this).val()==="supplier"){
             
            $("#estplaceholder").css("display","none");
             $("#estdebtors1").css("display","none");
             $("#estmumin1").css("display","none");  
              $("#estsuppliers1").css("display","block");
         }
         else if($(this).val()==="sabil"){
             $("#estplaceholder").css("display","none");
             $("#estsuppliers1").css("display","none");
             $("#estdebtors1").css("display","none");
             $("#estmumin1").css("display","block");  
         }
         else if($(this).val()==="debtor"){
             
             $("#estplaceholder").css("display","none");
             $("#estsuppliers1").css("display","none");
             
             $("#estmumin1").css("display","none");
              $("#estdebtors1").css("display","block");
         }
         else{}
  });
    
    $("#billamount").keyup(function(){
  $("#supplamt").val($(this).val());
  $("#addtax").val("");
  $("#affertax").val("");
  $("#taxtd").fadeOut("slow");
 });
   $("#gnrtbalance").click(function(){
   
       var $balanceType=$("#balanceType").val();
       var $balancedate=$("#balancedt").val();
       var $balanceamount=$("#balanceamount").val();
       var $balanceremarks=$("#balanceremarks").val();
       //var $bank=$("#balancebank").val();
         
       var $supplier=$("#estsuppliers1").val();
       var $debtor= $("#estdebtors1").val();
       var $mumin= $("#estmumin1").val();
       
       
 
   
    $.getJSON("../finance/json_redirect.php?action=openingbalance&balanceType="+$balanceType+"&balancedate="+$balancedate+"&balanceamount="+$balanceamount+"&supplier="+$supplier+"&debtor="+$debtor+"&mumin="+$mumin, function($response) {
        
    basicLargeDialog("#d_progress",50,150);
              
             $(".ui-dialog-titlebar").hide();
            
     
   if($response.id===1){
      
        $("#d_progress").dialog("destroy");
        
        $("#balancedt").val("");
       $("#balanceamount").val("0.00");
               
             $.modaldialog.success("Deposit was successfull", {
             width:400,
             showClose: true,
             title:"SUCCESSFULL TRANSACTION"
            });
   }
   else{
         $("#d_progress").dialog("destroy");
               
             $.modaldialog.warning("Error occured,Please try again", {
             width:400,
             showClose: true,
             title:"ERROR"
            });
   }
     
      
  });
  }); 
   
   $(".cksabil").change(function(){
      
        var $ejn=$.trim($(this).val());
      
        $("#q").val($ejn);
      
        getUserInformation($ejn);
       
        $(this).removeAttr("checked");
       
       $("#sabilsearchDiv").dialog("destroy");
  });
  
   $(".ckfamily").change(function(){
   
   
      var $ejn=$.trim($(this).val());
      
      $("#q").val($ejn);
      
       getUserInformation($ejn);
      
  });
   
   
    $("#sabilbutt").click (function(){
     
        basicLargeDialog("#sabilsearchDiv",600,600);
      
  });
   
    $("#cancl1").click ((function(){  //destroy popup dialog
        
        $("#inv_success").dialog("destroy");  
        
        
       
   })); 
   

   
   $(".changepriviledge").click(function(){  //change access level 
       
         var $id=$(this).attr("id");
           
           var $cell="cgl"+$id.substring(1);
          
            $("#cguname").val(document.getElementById($cell).textContent);
        basicLargeDialog("#cgpri",400,300);
      
  });
  
  
  
    $(".removeusers").click(function(){  //change access level 
       
           var $id=$(this).attr("id");
           
           var $cell="cgl"+$id.substring(1);
          
           var $user=document.getElementById($cell).textContent;
           
            $("#cnamej").val($user);
           
            basicLargeDialog("#deleteconfirm1",330,250);
           
           
           
  });
  
   $(".changedelete3").click(function(){  //change access level 
       
           var $id=$(this).attr("id");
           
           var $cell="cgl"+$id.substring(1);
          
           var $user=document.getElementById($cell).textContent;
           
            $("#cidd").val($user);
           
            basicLargeDialog("#deleteconfirm2",330,350);
           
           
           
  });
  
  
  $('#addact').click(function(){
       $("#acctname").show();
       $("#acctno").show();
       $("#actsector").show();
       $("#acttype").show();
       $("#slctbankname").hide();
       $("#acctno2").hide();
       $("#actsector2").hide();
       $("#acttype2").hide();
        $("#slctbankname").val(''); $("#acctno2").val('');
       $("#statusacctype").hide(); $("#actsector2").val('');
       $("#updateact").hide();
       $("#createact").show(); document.getElementById("statusacctype").innerHTML = '';
   });
      $('#Editact').click(function(){
       $("#slctbankname").show();
       $("#acctname").hide();
       $("#acctno2").show();
       $("#acctno").hide();
       $("#actsector2").show();
       $("#actsector").hide();
       $("#acttype").hide();
       $("#acttype2").show();
       $("#statusacctype").show();
       $("#updateact").show();
       $("#createact").hide();
   });
  
    
     $("#slctbankname").change((function(){  //print invoices
        
       var $bankname = $(this).val();
       if ($bankname !==""){
       $.getJSON("../finance/json_redirect.php?action=updatebankdetails&baankid="+$bankname, function(data) {
            
            if(data.id=='1'){
              //  alert(ds);
        $("#acctno2").val(data.accno);
        $("#actsector2").val(data.sector);
        if(data.type=='B'){
            var name = 'BANK';
           } else {
            name = 'CASH';
           }
          document.getElementById("statusacctype").innerHTML = 'CURRENT TYPE: <br>'+name;
       
     }
       });
       } else{
       $("#acctno2").val("");
       $("#actsector2").val("");
       $("#createact").show(); document.getElementById("statusacctype").innerHTML = '';
       $("#createact").hide();
       }
   }));
  $("#okcancel5").click(function(){
      
       $("#deleteconfirm5").dialog("destroy");
  });
  
  $("#okcancel").click(function(){
      
       $("#deleteconfirm2").dialog("destroy");
  });
  
  $(".changeaction").click(function(){  //change access level 
       
           var $id=$(this).attr("id");
           
           var $cell="cgl"+$id.substring(1);
           
            var $tel="ctl"+$id.substring(1);
            
             var $name="cnl"+$id.substring(1);
             
              var $email="cml"+$id.substring(1);
              
               var $postal="cpl"+$id.substring(1);
               
                var $city="ccl"+$id.substring(1);
          
            $("#cgid").val(document.getElementById($cell).textContent);
            $("#cgtel").val(document.getElementById($tel).textContent);
              $("#cgname").val(document.getElementById($name).textContent);
                $("#cgpostal").val(document.getElementById($postal).textContent);
                  $("#cgemail").val(document.getElementById($email).textContent);
                    $("#cgcity").val(document.getElementById($city).textContent);
           basicLargeDialog("#changeedit",400,500);
      
  });
  
       $(".changebill").click(function(){  //change access level 
       
           var $id=$(this).attr("id");
           
           var $cell="cgl"+$id.substring(1);
           
            var $tel="bild"+$id.substring(1);
            
             var $name="biln"+$id.substring(1);
             
			 var $suplid="supl"+$id.substring(1);
               
             var $rmks="rmk"+$id.substring(1);
             
			 var $exp="exp"+$id.substring(1);
             // alert(document.getElementById($rmks).textContent);
		       
            $("#cgid").val(document.getElementById($cell).textContent);
            $("#billdate").val(document.getElementById($tel).textContent);
              $("#billnum").val(document.getElementById($name).textContent);
                $("#billsupplier").val($(document.getElementById($suplid)).val());
                  $("#bilrmks").val(document.getElementById($rmks).textContent);
                   $("#expnacc").val($(document.getElementById($exp)).val());
           basicLargeDialog("#changeeditbill",400,500);
      
  });
   $(".changepdbill").click(function(){  //change access level 
       
           var $id=$(this).attr("id");
           
           var $cell="cgl"+$id.substring(1);
           
            var $tel="bild"+$id.substring(1);
            
             var $name="biln"+$id.substring(1);
             
			 var $suplid="supl"+$id.substring(1);
               
             var $rmks="rmk"+$id.substring(1);
             
			 var $exp="exp"+$id.substring(1);
             // alert(document.getElementById($rmks).textContent);
		       
            $("#cgid").val(document.getElementById($cell).textContent);
            $("#billdate").val(document.getElementById($tel).textContent);
              $("#billnum").val(document.getElementById($name).textContent);
                $("#billsupplier").val($(document.getElementById($suplid)).val());
                  $("#bilrmks").val(document.getElementById($rmks).textContent);
                   $("#expnacc").val($(document.getElementById($exp)).val());
           basicLargeDialog("#changepdeditbill",400,500);
      
  });
  
  
   $(".changedebtoraction").click(function(){  //change access level 
       
           var $id=$(this).attr("id");
           
           var $cell3="cgl"+$id.substring(1);
           
            var $tel="ctl"+$id.substring(1);
            
             var $name="cnl"+$id.substring(1);
             
              var $email="cml"+$id.substring(1);
              
               var $postal="cpl"+$id.substring(1);
               
                var $city="ccl"+$id.substring(1);
          
            $("#cgid12").val(document.getElementById($cell3).textContent);;
            $("#cgtel").val(document.getElementById($tel).textContent);
              $("#cgname").val(document.getElementById($name).textContent);
                $("#cgpostal").val(document.getElementById($postal).textContent);
                  $("#cgemail").val(document.getElementById($email).textContent);
                    $("#cgcity").val(document.getElementById($city).textContent);
		 $("#cghseno").val($("#hseno"+$id.substring(1)).val());
           basicLargeDialog("#changeeditdebtor",400,500);
		$("#dtable").css("display","block");
      
  });
   
  
  
  
  
  $("#debsaver").click(function(){
      
       

       var $tel = $("#cgtel").val();
       var $id = $("#cgid12").val();
       var $name=$("#cgname").val();
       var $postal=$("#cgpostal").val();
       var $email=$("#cgemail").val();
       var $city=$("#cgcity").val();
       var $cghseno=$("#cghseno").val();
       
       $.getJSON("../finance/json_redirect.php?action=updatedebtorsinfo&id="+$id+"&tel="+$tel+"&name="+$name+"&postal="+$postal+"&email="+$email+"&city="+$city+"&hseno="+$cghseno, function(data) {
        
      
   
     if(data){
        var options = {};
        $( "#changeeditdebtor" ).effect( 'explode', options, 1000, callback );
         $("#changeeditdebtor").dialog("destroy");
         
         window.location.reload();
        } 
        
    });   
      
  });
  
    $("#editpdch").click(function(){

       var $pdeditdate = $("#pdeditdate").val();
       var $pdeditchqno = $("#pdeditchqno").val();
       var $pdeditbank =$("#pdeditbank").val();
        var $tno = $("#cgid").val();
       $.getJSON("../finance/json_redirect.php?action=updatepdchqinfo&id="+$tno+"&pdeditdate="+$pdeditdate+"&pdeditchqno="+$pdeditchqno+"&pdeditbank="+$pdeditbank, function(data) {
        
      
   
     if(data){
        var options = {};
        $( "#changepdchq" ).effect('explode', options, 1000, callback );
         $("#changepdchq").dialog("destroy");
       //  $("#view_editpdchqs").click();
         window.location.reload();
        } 
        
    });   
      
  });
  function callback() {
      setTimeout(function() {
        $( "#changeeditdebtor" ).removeAttr( "style" ).hide().fadeIn();
      }, 1000 );
    };
  
  
  
  
  
  $("#suppsaver").click(function(){
      
       
       var $id= $("#cgid").val();
       var $tel =$("#cgtel").val();
       var $name=$("#cgname").val();
       var $postal=$("#cgpostal").val();
       var $email=$("#cgemail").val();
       var $city=$("#cgcity").val();
       
       
       $.getJSON("../finance/json_redirect.php?action=updatesuppliersinfo&id="+$id+"&tel="+$tel+"&name="+$name+"&postal="+$postal+"&email="+$email+"&city="+$city, function(data) {
        
      
   
     if(data){
        
         $("#changeedit").dialog("destroy");
         
         window.location.reload();
     }
        
    });   
      
  });
  
     $("#saveditedbill").click(function(){
      
       
       var $billnum= $("#billnum").val();
       var $billdate =$("#billdate").val();
       var $billsupplier=$("#billsupplier").val();
       var $bilrmks=$("#bilrmks").val();
       var $expnacc=$("#expnacc").val();
       var $id=$("#cgid").val();
      // alert($cgid);
       
     $.getJSON("../finance/json_redirect.php?action=updatesuppliersbill&id="+$id+"&billnum="+$billnum+"&billdate="+$billdate+"&billsupplier="+$billsupplier+"&bilrmks="+$bilrmks+"&expnacc="+$expnacc, function(data) {
        
      
   
     if(data){
        
         $("#changeeditbill").dialog("destroy");
         
        window.location.reload();
    }
        
   });   
      
  });
    $("#usersave").click(function(){
      
       
       var $uname= $("#jimsuname").val();
       var $email =$("#jimsemail").val();
       var $paswrd=$("#jimspaswrd").val();
       var $paswrd2=$("#jimspaswrd2").val();
          for(var j=0;j<=$(".privi").length;j++){
         
     $('input.privi:checkbox:checked').each(function () {
          
           
           
           var $docnos=$(this).attr('id');
           
           $docnumbers+=$docnos+",";
           var $iamount1 = document.getElementById("amntopay"+$id.substring(6)).value;
           $individualamount+=$iamount1+",";
            var $incmeacts =document.getElementById("incme"+$id.substring(6)).textContent;
           $acctsnumber =$incmeacts;
         
            }); 
            
            
     }   
       
       $.getJSON("../finance/json_redirect.php?action=updateusers&usrname="+$uname+"&email="+$email+"&paswrd="+$paswrd, function(data) {
        
      
   
     if(data){
        
         $("#changeedit").dialog("destroy");
         
         window.location.reload();
     }
        
    });   
      
  });
  
      $("#adduser").click(function(){
      
       
       var $uname= $("#jimsuname").val();
       var $email =$("#jimsemail").val();
       var $paswrd=$("#jimspaswrd").val();
       var $paswrd2=$("#jimspaswrd2").val(); 
       var userlvl = $("#user_lvl").val();
       if($uname=="" || $email== "" || $paswrd== "" || $paswrd2 == "" || userlvl==""){
           $.modaldialog.error('<br><b>Empty fields are not allowed</b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Error!"
            });
       } else{
       if($paswrd !== $paswrd2 ){
                    $.modaldialog.warning('<br><b>The passwords do not match</b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Not Matching"
            });
       }else{
       
       $.getJSON("../finance/json_redirect.php?action=updateusers&usrname="+$uname+"&email="+$email+"&paswrd="+$paswrd+"&usrlevel="+userlvl, function(data) {
   
     if(data){
         $.modaldialog.success('<br><b>User '+$uname+' created successfully</b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Done"
            });
           $("#jimsuname").val('');
            $("#jimspaswrd").val('');
             $("#jimspaswrd2").val('');
             $("#jimsemail").val('');
     }
        else{
            $.modaldialog.error('<br><b>Error creating user</b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Error!"
            });
        }
    });   
      }
  }
  });
  
     $(".managejuser").click(function(){  //change access level 
            
           var $id=$(this).attr("id");
                $("#jimsdepartment").val(" ");    
            $("#jimuser").val($id);
            basicLargeDialog("#juseraccess",600,500);
           $("#systmpriviledges").hide();
      
  });
  
     $("#jimsdepartment").change(function(){  //change access level 
            
         if($(this).val !== "" ){
                var juser = $("#jimuser").val();
                       $.getJSON("../finance/json_redirect.php?action=getprivldges&juser="+juser+"&departmnt="+$("#jimsdepartment").val(), function(data) {
   
     if(data.length !== 0){
         if(data[0]['invoices'] == '1'){
             $("#userpriv4").prop('checked',true);
         }else{
             $("#userpriv4").prop('checked',false);
         }
         if(data[0]['receipts'] == '1'){
             $("#userpriv5").prop('checked',true);
         }else{
             $("#userpriv5").prop('checked',false);
         }
         if(data[0]['deposits'] == '1'){
             $("#userpriv6").prop('checked',true);
         }else{
             $("#userpriv6").prop('checked',false);
         }
         if(data[0]['withdrawals'] == '1'){
             $("#userpriv7").prop('checked',true);
         }else{
             $("#userpriv7").prop('checked',false);
         }
         if(data[0]['payments'] == '1'){
             $("#userpriv8").prop('checked',true);
         }else{
             $("#userpriv8").prop('checked',false);
         }
         if(data[0]['jv'] == '1'){
             $("#userpriv9").prop('checked',true);
         }else{
             $("#userpriv9").prop('checked',false);
         }
         
         if(data[0]['directexp'] == '1'){
             $("#userpriv10").prop('checked',true);
         }else{
             $("#userpriv10").prop('checked',false);
         }
         if(data[0]['suppliers'] == '1'){
             $("#userpriv11").prop('checked',true);
         }else{
             $("#userpriv11").prop('checked',false);
         }
         if(data[0]['statements'] == '1'){
             $("#userpriv12").prop('checked',true);
         }else{
             $("#userpriv12").prop('checked',false);
         }
         if(data[0]['bankaccounts'] == '1'){
             $("#userpriv13").prop('checked',true);
         }else{
             $("#userpriv13").prop('checked',false);
         }
         if(data[0]['debtors'] == '1'){
             $("#userpriv14").prop('checked',true);
         }else{
             $("#userpriv14").prop('checked',false);
         }
         if(data[0]['admin'] == '1'){
             $("#userpriv15").prop('checked',true);
         }else{
             $("#userpriv15").prop('checked',false);
         }
         if(data[0]['database'] == '1'){
             $("#userpriv16").prop('checked',true);
         }else{
             $("#userpriv16").prop('checked',false);
         }
         if(data[0]['incomeaccounts'] == '1'){
             $("#userpriv17").prop('checked',true);
         }else{
             $("#userpriv17").prop('checked',false);
         }
         if(data[0]['readonly'] == '1'){
             $("#userpriv18").prop('checked',true);
         }else{
             $("#userpriv18").prop('checked',false);
         }
     }
     else{
        
         $('input.privcheckbox:checkbox').prop('checked',false);
        //$(".kselItems").prop('checked', this.checked);
        // $("input:checkbox").removeAttr("checked");
     }
    });
                
                
                
                
                $("#systmpriviledges").show();
            } else{
                $("#systmpriviledges").hide();
            } 
  });
        
       $("#updateprivildg").click(function(){
          var userid = $("#jimuser").val();
          var jimsdepartment =  $("#jimsdepartment").val();
           var sThisVal = ''; var unchecked = '';
           
          $('input.privcheckbox:checkbox:checked').each(function () {
        var $id=$(this).attr("id");
        
         var $key = $id.substring(8);
         var columnnamechckd = document.getElementById("privlenl"+$key).textContent;
           sThisVal+=columnnamechckd+",";
        });
        $('input.privcheckbox:checkbox:not(:checked)').each(function () {
        var $id=$(this).attr("id");
        
         var $key = $id.substring(8);
         var columnnamechckd = document.getElementById("privlenl"+$key).textContent;
           unchecked+=columnnamechckd+",";
        });
        
         $.getJSON("../finance/json_redirect.php?action=updatelogindetails&usrid="+userid+"&department="+jimsdepartment+"&columns="+sThisVal+"&unchecked="+unchecked, function(data) {
             if(data.id == '1'){
            $("#juseraccess").dialog("destroy"); 
         $("#systmpriviledges").hide();
         $.modaldialog.success('<br><b>Updated Successfully</b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Data Entry complete"
            });
       
     }
        else{
           $("#systmpriviledges").dialog("destroy"); 
         $.modaldialog.warning('<br><b>Problem updating details ..</b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Warning"
            });
        }
          
            }); 
       }); 
        
  $(".editjuser").click(function(){  //change access level 
        var $id=$(this).attr("id");
        
         var $key = $id.substring(7);
         var username = document.getElementById("jim_uname"+$key).textContent;
         var userid = $("#useridjim"+$key).val();
         var usergrp = document.getElementById("j_usrgrp"+$key).textContent; 
          $("#usenamejims").val(username);
          $("#useridjims").val(userid);
          $("#user_lvljims").val(usergrp);
            basicLargeDialog("#editjuser",600,500);
            // $("#jimuser").val($id);
      
  });
    $("#updatejimsuser").click(function(){  //change access level 
        
            var $usenamejims= $("#usenamejims").val();
       var useridjims = $("#useridjims").val();
       var $paswrd=$("#password1jims").val();
       var $paswrd2=$("#password2jims").val();
       var $email =$("#emailjims").val();
       var $usrlevel =$("#user_lvljims").val();
       
        if($usenamejims =="" || $paswrd =="" || $paswrd2 =="" || $email == "" || $usrlevel == "" ){
            alert('Empty fields not allowed');
            $.modaldialog.warning('<br><b>Empty fields not allowed</b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Warning"
            });
        } else{
            if($paswrd2 == $paswrd ){
                
        // alert("../finance/json_redirect.php?action=editlogindetails&usrname="+$usenamejims+"&userid="+useridjims+"&password="+$paswrd+"&email="+$email+"&userlevel="+$usrlevel);
        $.getJSON("../finance/json_redirect.php?action=editlogindetails&usrname="+$usenamejims+"&userid="+useridjims+"&password="+$paswrd+"&email="+$email+"&userlevel="+$usrlevel, function(data) {
   
     if(data.id == 1){
         $("#editjuser").dialog("destroy"); 
         $.modaldialog.success('<br><b>'+$usenamejims+' details updated Successfully</b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Data Entry complete"
            });
          window.reload();
     }
        else{
           $("#editjuser").dialog("destroy"); 
         $.modaldialog.warning('<br><b>Problem updating '+$usenamejims+' details ..</b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Warning"
            });
        }
    });
       }
    else{
       $.modaldialog.warning('<br><b>Passwords do not match</b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Warning"
            }); 
    }
    
    }
  });
  
  $("#okdelete").click(function(){
      
       
       var $user= $("#cnamej").val();
       
       
       $.getJSON("../finance/json_redirect.php?action=removeusers&usname="+$user, function(data) {
        
      
   
     if(data){
        
         $("#deleteconfirm1").dialog("destroy");
         
         window.location.reload();
     }
        
    });   
      
  });
  
  
  $("#okdelete2").click(function(){
      
       
       var $user= $("#cidd").val();
       
       
       $.getJSON("../finance/json_redirect.php?action=removesuppliers&usname="+$user, function(data) {
        
      
   
     if(data){
        
         $("#deleteconfirm2").dialog("destroy");
         
         window.location.reload();
     }
        
    });   
      
  });
    
    
    
    
    
  $("#okdelete5").click(function(){
      
       
       var $user= $("#cidd").val();
       
       
       $.getJSON("../finance/json_redirect.php?action=removedebtors&usname="+$user, function(data) {
        
      
   
     if(data){
        
         $("#deleteconfirm5").dialog("destroy");
         
         window.location.reload();
     }
        
    });   
      
  });
   
   
   
   $("#vchrprint201").click((function(){  //print voucher
        
        
        window.print();
       
   }));
    
   $("#myinvoiceprint").click((function(){  //print invoices
         
      
       
     window.print();
       
   }));
   
   
   
   
    $("#addpr").click((function(){  // add  users and priviledges
        
        
       var $usname=$("#prusname").val();  
        
        var $pwd=$("#prpwd").val();
        
         var $level=$("#prlevel").val();
          var $sectornme=$("#sectornme").val();
        
       if($usname!=="" && $pwd!=="" && $sectornme!==""){
            
             basicLargeDialog("#d_progress",50,150);
              
             $(".ui-dialog-titlebar").hide();
            
            $.getJSON("../finance/json_redirect.php?action=adduserpriviledges&usname="+$usname+"&pwd="+$pwd+"&level="+$level+"&sectname="+$sectornme, function(data) {
   
           
   
     if(data){
        
        $("#d_progress").dialog("destroy");
        
         alert(data.id);
        
        $("#prusname").val("");  
        
        $("#prpwd").val("");
   
     }
          
          });
        }
        else{
           
        alert("Ensure all fields are completely filled");
           
        }
         }));
   
    $("#cgsaver").click((function(){  // change users and priviledges
        
        
       var $usname=$("#cguname").val();  
        
        
        
         var $level=$("#newcglevel").val();
        
       
            
            $.getJSON("../finance/json_redirect.php?action=changeuserpriviledges&usname="+$usname+"&level="+$level, function(data) {
   
           
   
     if(data){
        
        if(data.id==1){
       
       $("#cgpri").dialog("destroy");
       
       window.location.reload();
        
      
        }
        else{
            
        }
         
   
     }
          
          });
        }));
         
    
  
   
 
   
   
     $("#debtorType").change((function(){  //print invoices
        
        if($(this).val()==="sabil"){
            
            $("#ppp").css("display","none");
            $("#invsabil").css("display","block");
        }
       else if($(this).val()==="debtor"){
         
          $("#invsabil").css("display","none");
          $("#ppp").css("display","block");
          
           
       }
       else{
          $("#invsabil").css("display","none");
          $("#ppp").css("display","none");  
       }
   }));


    
  $("#viewpaymentslist").click(function(){
      
      
          var $fromdate=$("#paymentssdate").val();
          var $todate=$("#paymentsedate").val();
           var $bnktype=$("#bnkacctyp").val();
          var $supplier=$("#paymentsupplier").val();
          
          
        window.open('../finance/paymentlistpreview.php?paymentsupplier='+$supplier+'&sdate='+$fromdate+'&edate='+$todate+'&dpt='+$bnktype+'','','width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
      
  });
 
   $("#viewpaymntslist").click(function(){
      
      //alert('test');
          var $fromdate=$("#paymentssdate").val();
          var $todate=$("#paymentsedate").val();
          var $expnacc=$("#expnacc").val();
          var $costcntreid=$("#costcntreid").val();
          
        window.open('../finance/allpayments.php?costcenterid='+$costcntreid+'&sdate='+$fromdate+'&edate='+$todate+'&expenseacc='+$expnacc+'','','width=1300,height=800,toolbar=0,menubar=1,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
      
  });
     $("#supplamt").keyup(function(){  // invoice field click listener
            cal_tax($(this).val());

  });
  
       $("#ratetax").keyup(function(){  // invoice field click listener
            cal_tax2($(this).val());
  });
  
  $("#taxbtn").click(function(){  // invoice field click listener
            $("#taxtd").fadeIn('slow');
  });

  
  
  $("#invsabil").keypress(function(e){  // invoice field click listener
    
    if(e.keyCode==13){
       
        invoice_data($(this).val());
    }
      
  });
    $("#crdtsabil").keypress(function(e){  // invoice field click listener
    
    if(e.keyCode==13){
       
        invoice_data($(this).val());
    }
      
  });
      $("#invsabil").keyup(function(){  // invoice field click listener
    
    if($(this).val().length<4){
       
        $("#ejnoinv").val("");
         $("#sabilname").val("");
    }
      
  });
    
    
  $("#billslist1").click(function(){
      
      _send2Printer(document.getElementById("sortablebills"));
           
      
  });  
    
  
      $("#statsabil").keyup(function(e){  //sabil no field click;
        
       if($(this).val().length==4){
           
           getHofNames($(this).val());
       }
   else if($(this).val().length<4 || $(this).val()=="" ){
      // $("#statname").val('');
      $("#statmntfield").css("display","none");
       document.getElementById("statname").innerHTML=""; 
   }
       
       
   });
 
 
  $("#stat").click((function(){  //statatement click;
       
      
  var $selectedButt = $("#radiobutt input:radio:checked").val();  //check for selected button
    
		var st = $("#ssstart").val();
        var  $startdate=st.substr(6,4)+"-"+st.substr(3,2)+"-"+st.substr(0,2);
		var et = $("#ssend").val();
        var  $enddate=et.substr(6,4)+"-"+et.substr(3,2)+"-"+et.substr(0,2);
        
        var  $stataccount=$("#stataccount").val();
        
      
      
      if($selectedButt==="sabil"){
           var  $sabil=$("#statsabil").val();
          if ($("#stamntwithpd").is(':checked')){
             
       window.open('../finance/pdsabil_statement.php?param=sabil&sabil='+$sabil+'&start='+$startdate+'&end='+$enddate+'&account='+$stataccount+'','','width=1000,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');

          } else{
           
       window.open('../finance/sabil_statement.php?param=sabil&sabil='+$sabil+'&start='+$startdate+'&end='+$enddate+'&account='+$stataccount+'','','width=1000,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
  
          }
          
          
      }
      else{
          
          
        var  $dbt=$("#dbt3").val();  
          if($dbt==''){        
          $.modaldialog.warning(' <b>Please Select a Debtor</b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Warning"
            })
          } else{
       window.open('../finance/sabil_statement.php?param=debtor&start='+$startdate+'&end='+$enddate+'&debtor='+$dbt+'&account='+$stataccount+'','','width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');   
      }
    }


}));


  $("#pprint").click(function(){  //print statement button click;
       
      window.print();
        
  });
  
   $("#pcancel").click((function(){  //dismiss statement window button click;
       
      window.close();
        
  }));
   
  
   $(".rb").click((function(){  //radio button click;
        
         
         if($(this).val()==="sabil"){
             
             $("#dbt3").css("visibility","hidden");
             
             $("#tbl3").css("visibility","visible");
             
             $("#statmntfield").css("display","none");
             $("#dbt3").val("");
		$("#displaypic").css("display","block");
         }
         else{
              $("#displaypic").fadeOut("slow");
             $("#gallery").css("display","none");
             $("#tbl3").css("visibility","hidden");
              
             $("#dbt3").css("visibility","visible");
             
             $("#statmntfield").css("display","block");
              $("#statsabil").val("");
              document.getElementById("statname").innerHTML="";
         }
       
   }));  
   
      $(".rbdbts").click((function(){  //radio button click;
        
         
         if($(this).val()==="sabil"){
             
             $("#dbtrs3").css("visibility","hidden");
             
             $("#tbl3").css("display","block");
             
             $("#statmntfield").css("display","none");
             $("#dbtrs3").val("");
             $("#tbl4").css("display","none");
		$("#displaypic").css("display","block");
         }
         else{
              $("#displaypic").fadeOut("slow");
             $("#gallery").css("display","none");
             $("#tbl3").css("display","none");
              $("#tbl4").css("display","block");
             $("#dbtrs3").css("visibility","visible");
             $("#debttfield").css("display","block");
             $("#statmntfield").css("display","block");
              $("#statsabil").val("");
              $("#debttinfo").empty();
              document.getElementById("statname").innerHTML="";
         }
       
   }));  
   
            $("#appendbtn").click(function(){      
   var rowcount = $("#debtsrowcount").val();
  $("#debttfield").css("display","block");
   $("#debttinfo").empty();
   for (var u=1;u <=rowcount;u++ ){
     $("#debttinfo").append('<tr><td><select class="formfield dc" style="width: 50px" id="ledger_dc'+u+'"><option value="dr" selected>Dr</option><option  value="cr">Cr</option></select></td>\n\
                                    <td><select class="formfield ledgerids" id="ledgerid'+u+'"><option selected value="">--Select--</option></td>\n\
                                    <td><input id="dbtamnt'+u+'"  value="0" class="amount dramount" disabled="true" onkeyup="updatedrdebtamnt('+u+')" onchange="updatedebtdiff() "/></td><td><input id="crdtamnt'+u+'" value="" class="amount cramount" disabled="true" onkeyup="updatecrdebtamnt('+u+')" onchange="updatedebtdiff()"/></td>\n\
                                    <td hidden="true" class="tbltype"></td></tr>'); 
            
        }
 getdebtaccounts();
   $("#debttinfo").append('<tr><td></td></tr><tr style="height: 30px;"><td></td><td style="font-size:14px">Total</td><td style="background-color: yellowgreen;  font-size:14px" id="drtotal"></td><td style="background-color: yellowgreen;font-size:14px" id="crtotal"></td></tr>\n\
                             <tr><td></td></tr><tr style="height: 30px;"><td></td><td style="font-size:12px; color: red">Difference</td><td id="dr-diff"></td><td id="cr-diff"></td></tr>\n\
                            \n\<tr><td>Income Acct:</td><td><select class="formfield" id="badincmeacct"></select></td></tr>\n\
                            <tr><td>Date:</td><td><input type="text" class="formfield" id="journaldate" /></td></tr>\n\
                            <tr><td>Rmks:</td><td><textarea class="formfield" id="journalrmks"/></td></tr>');
                getbadincmeacct();
   $("#journaldate" ).datepicker({ dateFormat: 'dd-mm-yy',changeMonth: true} );
    });
   
               $("#appndbtn").click(function(){      
   var rowcount = $("#debtsrwcount").val();
  $("#debttfield").css("display","block");
   $("#debttinfo").empty();
   for (var u=1;u <=rowcount;u++ ){
     $("#debttinfo").append('<tr><td><select class="formfield dc" style="width: 50px" id="ledger_dc'+u+'"><option value="dr" selected>Dr</option><option  value="cr">Cr</option></select></td>\n\
                                    <td><select class="formfield ledgerids" id="ledgerid'+u+'"><option selected value="">--Select--</option></td>\n\
                                    <td><input id="dbtamnt'+u+'"  value="0" class="amount dramount" disabled="true" onkeyup="updatedrdebtamnt('+u+')" onchange="updatedebtdiff() "/></td><td><input id="crdtamnt'+u+'" value="" class="amount cramount" disabled="true" onkeyup="updatecrdebtamnt('+u+')" onchange="updatedebtdiff()"/></td>\n\
                                    <td hidden="true" class="tbltype"></td></tr>'); 
            
        }
 getnonresidentdebtaccounts();
   $("#debttinfo").append('<tr><td></td></tr><tr style="height: 30px;"><td></td><td style="font-size:14px">Total</td><td style="background-color: yellowgreen;  font-size:14px" id="drtotal"></td><td style="background-color: yellowgreen;font-size:14px" id="crtotal"></td></tr>\n\
                             <tr><td></td></tr><tr style="height: 30px;"><td></td><td style="font-size:12px; color: red">Difference</td><td id="dr-diff"></td><td id="cr-diff"></td></tr>\n\
                            \n\<tr><td>Income Acct:</td><td><select class="formfield" id="badincmeacct"></select></td></tr>\n\
                            <tr><td>Date:</td><td><input type="text" class="formfield" id="journaldate" /></td></tr>\n\
                            <tr><td>Rmks:</td><td><textarea class="formfield" id="journalrmks"/></td></tr>');
                getbadincmeacct();
   $("#journaldate" ).datepicker({ dateFormat: 'dd-mm-yy',changeMonth: true} );
    });
   
   $("#choosesuppliergo").click((function(){  // choose supplier event action
        
        
        //$("#investamont").val("0.00") //reset amount fields
        
        //$("#invamountt100").val("0.00") //reset amount fileds
        
        retriveUnpaidBills($("#chooseSupplier").val());
        
       
   }));

   
      $("#mohalas").change(function(){ 
   
    if($(this).val()==="A.M.S"){
          
         //$("#secidt").removeAttr("disabled"); 
         $("#sector_pane").css("visibility","visible");
      }
   else{
       //  $("#secidt").attr("disabled","disabled");   
        $("#sector_pane").css("visibility","hidden");
   }
   //alert($(this).val());
      });
   
 
   $("#mumineendebtor").click(function(){
       $("#debtor_mumin_name").empty(); 
       $("#ckamount100").val(0);
       $("#cshamount100").val(0);
       $("#billstable2").empty(); //Empty table in readiness for new set  of data
   });
      $("#crdtsabil").click(function(){
        $("#crdtamount").val(0);
       $("#disp_invoices").empty(); //Empty table in readiness for new set  of data
        $("#crestacc").val('');
   });
   
   //jv
   
    $("#createjv").click(function(){  //complete cheque payment for invoices
        
         $("#jvform").validationEngine(); 
    });
   
   
   $("#rcpcancelrint201").click (function(){
       
       
      window.location="../finance/create_invoice.php?idaction=new";  
   });
   
   
   
 $(".unpaidcheckbox").live('change',function(){  // payment out-invoice checkbox listeners
     
    var $amount=0; var $pdamount=0; var $topay=0;
    
   if ($(this).is(':checked')) {
          
         var $id=$(this).attr("id");
         
         var $amountid=$id.substring(5);
          if($("#expnseaccounts").val()!="" && $("#expnseaccounts").val() !=$("#expenid"+$amountid).val()){
                    $.modaldialog.warning('<b><br></br>Not Possible to pay in different Expense Accounts</b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Warning"
            });
                $("#unpcx"+$amountid).attr('checked',false);
          
        }
      //  else if($("#costc").val()!="" && $("#costc").val() !=$("#costcntrid"+$amountid).val()){
      //       $.modaldialog.warning('<b><br></br>Not allowed to pay in different Cost Centres</b>', {
     //        timeout: 5,
     //        width:500,
     //        showClose: true,
      //       title:"Warning"
      //      });
      //          $("#unpcx"+$amountid).attr('checked',false);
      //  }
         
         else{
           
            $("#expnseaccounts").val($("#expenid"+$amountid).val());
            $("#costc").val($("#costcntrid"+$amountid).val());
           $("#unpchbx"+$amountid).attr('checked',false);
        $amount=parseFloat(document.getElementById("cxam"+$amountid).textContent);
        $pdamount= parseFloat(document.getElementById("amtpd"+$amountid).textContent);
        $topay =  parseFloat($amount-$pdamount);
         $("#amnt2pay"+$amountid).val($topay);
        $("#investamont").val(parseFloat($("#investamont").val())+$topay);
        
        $("#amountt100").val(parseFloat($("#amountt100").val())+$topay);
    }}
   else{
          var $id=$(this).attr("id");
          
          var $amountid=$id.substring(5);
          $("#expnseaccounts").val("");
          $("#costc").val("");
          $topay =  parseFloat($("#amnt2pay"+$amountid).val());
         $amount=parseFloat(document.getElementById("cxam"+$amountid).textContent);
          $("#unpchbx"+$amountid).attr('checked',false);
         $("#investamont").val(parseFloat($("#investamont").val())-$topay);
         
        $("#amountt100").val(parseFloat($("#amountt100").val())-$topay);
         $("#amnt2pay"+$amountid).val(0);
             
   }
 });  
   
 
 

 $("#jvprint201").click((function(){  
    
        window.print();
    
    window.location="../finance/jv.php";
    
    }));
   
    $("#xxad").click((function(){ //admin add estate
       
       basicLargeDialog("#addxest",900,700);
       
   }));
   
   
   $("#xxpermgrant").click((function(){ //admin add estate
       
       basicLargeDialog("#permgrant",900,700);
       
   }));
   
   
   $("#xxxcancel").click((function(){ //admin add estate
       
       $("#addxest").dialog("destroy");
       
   }));
   
   
    $("#caclbill").click((function(){ 
       
      //$("#billdate").val("");
      $("#billno").val("");
      $("#billamount").val("");
      $("#billsupplier").val("");
      $("#expnacc").val("");
      $("#billrmks").val("");
       
       
   }));
   
   $(".showpswd").click((function(){ //admin add estate
       
        var $id=$(this).attr("id");
        
        var $pwd=$("#pw"+$id).val();
        alert($pwd);
       
   }));
   
 
   
  $("#jvfrom").change((function(){  
       
        
       if($("#jvtype").val()==="1"){
    
          $.getJSON("../finance/json_redirect.php?action=jvnames&sabil="+$(this).val(), function(data) {
    
             
     if(data){
              document.getElementById("div_fromAccount").innerHTML=data.name; 
              
              }
     });
       }else{}
   }));
   
      
   
   
   

   
 $(".updater").click((function(){ //admin  update estate username /pword   
       
        var $id=$(this).attr("id"); //ss1
        
        var $pwd=$("#pw"+$id).val();
        
         var $usname=$("#u"+$id).val();
         
         var $id=document.getElementById("i"+$id).textContent;
         
           if($pwd!=="" && $usname!==""){
         
       
    $.getJSON("../finance/json_redirect.php?action=updateaccount&usname="+$usname+"&pwd="+$pwd+"&estateid="+$id, function(data) {
   
     if(data.id===1){
        
         
         
          alert('Account updated successfully'); 
           
      
     }
 else{
      alert('Error occured while processing transaction-Try again'); 
 }
    });
           }
       else{
           alert("Username /Password cannot be  blank");
       }
       
   }));  
   
   
 $(".newsetup").click((function(){ //admin  create new estate username /pword  
       
        var $id=$(this).attr("id"); //ss1
        
        var $pwd=$("#pw"+$id).val();
        
         var $usname=$("#u"+$id).val();
         
         var $id=document.getElementById("i"+$id).textContent;
         
         if($pwd!=="" && $usname!==""){
         
       
    $.getJSON("../finance/json_redirect.php?action=createlogin&usname="+$usname+"&pwd="+$pwd+"&estateid="+$id, function(data) {
   
     if(data.id===1){
        
         
         
          alert('Login created successfully'); 
           
      
     }
 else{
      alert('Error occured while processing transaction-Try again'); 
 }
    });
         }
     else{
         alert("Username/Password cannot be blank");
     }
       
   }));  
   
   
   $("#savsupplier").click(function(){
   
   
       var $name,$telephone,$email,$postal,$city,$remarks;
       
       $name=$.trim($("#supname").val());
       $telephone=$.trim($("#supmobile").val());
       $email=$.trim($("#semail").val());
       $postal=$.trim($("#pzip").val());
       $city=$.trim($("#scity").val());
       $remarks=$.trim($("#supprmks").val());
       
       
       if($name!=="" && $telephone!=="" && $city!==""){
           
           saveSupplier($name,$telephone,$email,$postal,$city,$remarks);
       }
       else{
           $.modaldialog.warning('FIELDS MARKED WITH * REQUIRED', {
             width:400,
             showClose: true,
             title:"WARNING"
            });
       }
        
   
   });
	
        $("#estatidname").change(function(){
            var deprt = $("#estatidname").val();
            
                var $dataString={departmntid:deprt};
        
      var $urlString="../finance/json_redirect.php?action=getbankaccts";

               $.ajax({                                                                        
                
                url: $urlString,
                
                type: "GET",
                
                dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
                data:$dataString,
                
                success: function(response) {
                $("#d_progress").dialog("destroy");
                     if(response.length>0){
     
     $("#bankidname").css("display","block");
     $("#bname").css("display","block");
    $.each(response, function(i, item) {
       
    $("#bankidname").append("<option value="+item.bacc+">"+item.acno+":"+item.acname+"</option>");
    
       });
    }else{
            $("#bankidname").css("display","none");
            $("#bname").css("display","none");
         $.modaldialog.warning('<br><b>We are unable to link this account .Please contact admin for assistance</b>', {
             timeout: 5,
             width:500,
             showClose: true,
             title:"Accounts unlinked"
            });
            $("#bankidname").val("");
    }

                },
              error:function (xhr, ajaxOptions, thrownError){
                
               
                  
             $.modaldialog.warning('Account not saved-please try again later', {
             width:400,
             showClose: true,
             title:"WARNING"
            });
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              });  
            });
        
        
   $("#savincome").click(function(){
      
  var $name=$("#acc1name").val();
  
   var $estatidname=$("#estatidname").val();
    var $bankidname =  $("#bankidname").val();
    var $incactyp = $("#incactyp").val();
    var $codebdget = $("#codebdget").val();
    if($name==="" || $estatidname ===""  || $incactyp === ""){
      
               
             $.modaldialog.warning('<br><b>ALL FIELDS REQUIRED</b>', {
             width:400,
             showClose: true,
             title:"WARNING"
            });
        
    }else{
     var $dataString={name:$name,esatid:$estatidname,bankid:$bankidname,incmetype:$incactyp,budgetcode:$codebdget };
        
      var $urlString="../finance/json_redirect.php?action=savincomex";

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
         
                $("#acc1name").val("");
		$("#estatidname").val("");
                          
            $.modaldialog.success("<br><b>Income Account added successfully</b>", {
             width:400,
             showClose: true,
             title:"Data Entry Sucess"
            });
              
              
                 }
             else{
              
             $("#d_progress").dialog("destroy");
                 
                         $.modaldialog.warning('Account not saved-please try again later', {
             width:400,
             showClose: true,
             title:"WARNING"
            });
              
              
                    
             }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
           $.modaldialog.warning('Account not saved-please try again later', {
             width:400,
             showClose: true,
             title:"WARNING"
            });
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              });      
                 
    
 
    }
       
       
   });
   
      $("#savsubincome").click(function(){
      
  var $cname=$("#compname").val();
  
   var $incmeacount=$("#incmeacount").val();
    var $incmesubacct =  $("#incmesubacct").val();
    if($cname==="" || $incmeacount ==="" || $incmesubacct ==="" ){
      
               
             $.modaldialog.warning('<br><b>ALL FIELDS REQUIRED</b>', {
             width:400,
             showClose: true,
             title:"WARNING"
            });
        
    }else{
     var $dataString={name:$cname,incmeacount:$incmeacount,subincmeacct:$incmesubacct};
        
      var $urlString="../finance/json_redirect.php?action=savsubincomex";

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
         
                $("#compname").val("");
		("#incmeacount").val("");
                          
            $.modaldialog.success("Sub Income Account added successfully", {
             width:400,
             showClose: true,
             title:"Data Entry Sucess"
            });
              
              
                 }
             else{
              
             $("#d_progress").dialog("destroy");
                 
                         $.modaldialog.warning('Account not saved-please try again later', {
             width:400,
             showClose: true,
             title:"WARNING"
            });
              
              
                    
             }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
           $.modaldialog.warning('Account not saved-please try again later', {
             width:400,
             showClose: true,
             title:"WARNING"
            });
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              });      
                 
    
 
    }
       
       
   });
   
         $("#savsbexpnseincome").click(function(){
      
  var $cname=$("#compnyname").val();
  
   var $expnseacount=$("#expnseacount").val();
    var $expensesubacct =  $("#expensesubacct").val();
    if($cname==="" || $expnseacount ==="" || $expensesubacct ==="" ){
      
               
             $.modaldialog.warning('<br><b>All Fields Required</b>', {
             width:400,
             showClose: true,
             title:"WARNING"
            });
        
    }else{
     var $dataString={name:$cname,expnseacount:$expnseacount,expensesubacct:$expensesubacct};
        
      var $urlString="../finance/json_redirect.php?action=savsubexpnse";

               $.ajax({                                                                        
                
                url: $urlString,
                
                type: "GET",
                
                dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
                data:$dataString,
                
                success: function(response) {
                
                 
            if(response.id=='1'){ 
             
             $("#d_progress").dialog("destroy");
         
                $("#compnyname").val("");
		("#expnseacount").val("");
                          
            $.modaldialog.success("Sub Expense Account added successfully", {
             width:400,
             showClose: true,
             title:"Data Entry Sucess"
            });
              
              
                 }
             else{
              
             $("#d_progress").dialog("destroy");
                 
                         $.modaldialog.warning('Account not saved-please try again later', {
             width:400,
             showClose: true,
             title:"WARNING"
            });
              
              
                    
             }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
           $.modaldialog.warning('Account not saved-please try again later', {
             width:400,
             showClose: true,
             title:"WARNING"
            });
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              });      
                 
    
 
    }
       
       
   });
   
   
   
    $("#admincreateact").click(function(){
       var $adminactnme,$admnacctno,$admnactsector,adminacttype,estatename;
        $adminactnme = $.trim($("#adminacctname").val());
         $admnacctno = $.trim($("#adminacctno").val());
         $admnactsector = $.trim($("#adminactsector").val());
         adminacttype = $.trim($("#adminacttype").val());
         estatename = $.trim($("#estatename").val());
        
        if ($adminactnme=="" && $admnacctno=="" && adminacttype =="" ){
         
         $.modaldialog.warning('<br></br><b>Fields Marked with * must be filled</b>', {
             width:400,
             showClose: true,
             title:"MISSING FIELDS"
            });
            }
        else{
            createadminacct($adminactnme,$admnacctno,$admnactsector,adminacttype,estatename);
            }
    });
   
   
   $("#createact").click(function(){
       var $acctname,$acctno,$actsector,acttype;
        $acctname = $.trim($("#acctname").val());
         $acctno = $.trim($("#acctno").val());
         $actsector = $.trim($("#actsector").val());
         acttype = $.trim($("#acttype").val());
        
        if ($acctname=="" && $acctno=="" && acttype ==""){
         
         $.modaldialog.warning('<br></br><b>Fields Marked with * must be filled</b>', {
             width:400,
             showClose: true,
             title:"MISSING FIELDS"
            });
            }
        else{
            createacct($acctname,$acctno,$actsector,acttype);
            }
    });
       
           $("#updateact").click(function(){
       var $acctno,$actsector,acttype,$acctid;
            $acctid =  $.trim($("#slctbankname").val());
              $acctno = $.trim($("#acctno2").val());
         $actsector = $.trim($("#actsector2").val());
         acttype = $.trim($("#acttype2").val());
        
        if ( $acctno=="" && acttype =="" && $acctid ==""){
         
         $.modaldialog.warning('<br></br><b>Fields Marked with * must be filled</b>', {
             width:400,
             showClose: true,
             title:"MISSING FIELDS"
            });
            }
        else{
            updteacct($acctno,$actsector,acttype,$acctid);
            }
    });
        $("#adminupdateact").click(function(){
       var $adminactnme,$admnacctno,$admnactsector,adminacttype,estatename;
        $adminactnme = $.trim($("#adminslctbankname").val());
         $admnacctno = $.trim($("#adminacctno2").val());
         $admnactsector = $.trim($("#adminactsector2").val());
         adminacttype = $.trim($("#adminacttype2").val());
         estatename = $.trim($("#estatename").val());
        
        if ($adminactnme=="" && $admnacctno=="" && adminacttype =="" ){
         
         $.modaldialog.warning('<br></br><b>Fields Marked with * must be filled</b>', {
             width:400,
             showClose: true,
             title:"MISSING FIELDS"
            });
            }
        else{
             adminupdteacct($adminactnme,$admnacctno,$admnactsector,adminacttype,estatename);
            }
       
       });
       
       
    $("#savdebtor").click(function(){
   
   
       var $name,$telephone,$email,$postal,$city,$remarks;
       $name=$.trim($("#debname").val());
       $telephone=$.trim($("#debmobile").val());
       $email=$.trim($("#demail").val());
       $postal=$.trim($("#dzip").val());
       $city=$.trim($("#dcity").val());
       $remarks=$.trim($("#debrmks").val());
       
       
       if($name!=="" && $telephone!=="" && $email!==""){
           
           saveDebtor($name,$telephone,$email,$postal,$city,$remarks);
       }
       else{
           alert("Field marked with * MUST be filled");
       }
        
   
   });
   
     $("#pettysavbill").click(function(){ 
   
   
       var $date,$docno,$amount,$bank,$expacc,$remarks,$ccid;
       
       $date=$.trim($("#pettybilldate").val());
       $docno=$.trim($("#pettybillno").val());
       $amount=$.trim($("#pettybillamount").val());
       $bank=$.trim($("#pettybank").val());
       $expacc=$.trim($("#pettyexpnacc").val());
       $remarks=$.trim($("#pettybillrmks").val());
       $ccid=$.trim($("#pettyccid").val());
       
       
       if($date!==""  && $amount!=="" ){
           
            pettysaveSupplierBill($date, $docno, $amount,$bank, $expacc, $remarks,$ccid);
       }
       else{
           alert("Field marked with * MUST be filled");
       }
        
   
   });
     
  
   
    $("#xxxad").click(function(){
       
       var $name,$mohalla,$sector,$masoul,$musaed,$tanzeem1,$tanzeem2,$tanzeem3,$tanzeem4,$tanzeem5,$estcost,$estcounty, $estcompleted,$esttenants;
       
       $name=$.trim($("#estname").val());
       $mohalla=$.trim($("#estmohalla").val());
       $sector=$.trim($("#estsector").val());
       $masoul=$.trim($("#estmasoul").val());
       $musaed=$.trim($("#estmusaeed").val());
       $tanzeem1=$.trim($("#esttanzeem1").val());
       $tanzeem2=$.trim($("#esttanzeem2").val());
       $tanzeem3=$.trim($("#esttanzeem3").val());
       $tanzeem4=$.trim($("#esttanzeem4").val());
       $tanzeem5=$.trim($("#esttanzeem5").val());
       
       $estcost=$.trim($("#estcost").val());
       $estcounty=$.trim($("#estcounty").val());
       $estcompleted=$.trim($("#estcompleted").val());
       $esttenants=$.trim($("#esttenants").val());
       
       if($name!==""){
         
            save_estate($name,$mohalla,$sector,$masoul,$musaed,$tanzeem1,$tanzeem2,$tanzeem3,$tanzeem4,$tanzeem5,$estcost,$estcounty,$estcompleted,$esttenants);
           
       }
       else{
              alert("Error name cannot be blank");
       }
       
   });
   
     $("#savbnk").click((function(){
        
         var $acno=$("#acnox").val();
         
        var $acname=$("#accnamess").val();
        
         var $bankname=$("#banknamess").val();
         
         var $estate_name=$("#estate_name").val();
        
         var $opam=$("#opam").val();
        
        if($acname==="" || $acno==="" || $opam==="" || $bankname===""){  
      
        alert("All fields MUST be filled");
    
        }
        else{
        
     basicLargeDialog("#d_progress",50,150);
              
      $(".ui-dialog-titlebar").hide();
               
    $.getJSON("../finance/json_redirect.php?action=savebnk&acno="+$acno+"&acname="+$acname+"&opam="+$opam+"&bankname="+$bankname+"&estateid="+$estate_name, function(data) {
   
     if(data.id===1){
        
          $("#d_progress").dialog("destroy") ; 
          
          $("#acnox").val("");
         
          $("#accnamess").val("");
        
          $("#banknamess").val("");
        
          $("#opam").val("");
         
          alert('Bank account added successfully');
           
      
     }
 else{
      alert('Error occured while processing transaction-Try again'); 
 }
    });
        }
         
         
   }));
   
    $("#cacldebtor").click((function(){
        
     $("#adddebtors").dialog("destroy") ; 
   }));
   
    $("#caclsupplier").click((function(){
        
     $("#addsuppliers").dialog("destroy") ; 
   }));
   
   
       });
       
       function basicLargeDialog(id,$width,$height){
        $(id).dialog({
            height: $height,
            width:$width,
            modal: true,
                  show: {
        effect: "drop",
        duration: 500,
      },
                  hide: {
        effect: "drop",
        duration: 500,
        
        }
        });
  }
    function printLargeDialog(id,$width,$height,$docnumbers,bankacct,ddate){
       //var $urlString = ('../finance/depositpreview.php?rcptsnumbrs='+$docnumbers+'&bankacct='+bankacct+'','width=1500,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
//$.ajax({url: $urlString});
        window.open('../finance/depositpreview.php?rcptsnumbrs='+$docnumbers+'&bankacct='+bankacct+'&ddate='+ddate+'','','width=1500,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');

         
        
  }
    
    function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode();
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }




  function save_estate($name,$mohalla,$sector,$masoul,$musaed,$tanzeem1,$tanzeem2,$tanzeem3,$tanzeem4,$tanzeem5,$estcost,$estcounty,$estcompleted,$esttenants){
  
    
      var $dataString={name:$name,mohalla:$mohalla,sector:$sector,masoul:$masoul,musaeed:$musaed,tanzeem1:$tanzeem1,tanzeem2:$tanzeem2,tanzeem3:$tanzeem3,tanzeem4:$tanzeem4,tanzeem5:$tanzeem5,estcost:$estcost,estcounty:$estcounty,estcompleted:$estcompleted,esttenants:$esttenants};
        
      var $urlString="../finance/json_redirect.php?action=saveest";

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
             
              alert("Estate saved successfully");
                 }
             else{
              
             $("#d_progress").dialog("destroy");
                 
             alert("Estate not saved-please try again later");
              
              
                    
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

function createacct($acctname,$acctno,$actsector,acttype){
    var $dataString={name:$acctname,acctno:$acctno,actsector:$actsector,acttype:acttype};

            
      var $urlString="../finance/json_redirect.php?action=saveaccountb";

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
              $.modaldialog.success("<br></br><b>Account: "+$acctname+" saved successfully</b>", {
             width:400,
             showClose: true,
             title:"DATA INPUT SUCCESS"
            });
        $("#acctname").val("");
        $("#acctno").val("");
        $("#actsector").val("");
        $("#acttype").val("");
                                 
                 }
             else{
              
             $("#d_progress").dialog("destroy");
                 
             $.modaldialog.warning('<br></br><b> ACCOUNT ENTRY FAILED</b>', {
             width:400,
             showClose: true,
             title:"ERROR"
            });
              
               
             }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
                  alert("Account not saved-please try again later");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              });  
}

function createadminacct($adminactnme,$admnacctno,$admnactsector,adminacttype,estatename){
    var $dataString={name:$adminactnme,acctno:$admnacctno,actsector:$admnactsector,acttype:adminacttype,estatename: estatename};

            
      var $urlString="../finance/redirect.php?action=saveadminaccount";

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
              $.modaldialog.success("<br></br><b>Account: "+$adminactnme+" saved successfully</b>", {
             width:400,
             showClose: true,
             title:"DATA INPUT SUCCESS"
            });
        $("#adminacctname").val("");
        $("#estatename").val("");
        $("#adminacctno").val("");
        $("#adminactsector").val("");
         $("#adminacttype").val("");                        
                 }
             else{
              
             $("#d_progress").dialog("destroy");
                 
             $.modaldialog.warning('<br></br><b> ACCOUNT ENTRY FAILED</b>', {
             width:400,
             showClose: true,
             title:"ERROR"
            });
              
               
             }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
                  alert("Account not saved-please try again later");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              });  
}


function updteacct($acctno,$actsector,acttype,$acctid){
    var $dataString={acctid:$acctid,acctno:$acctno,actsector:$actsector,acttype:acttype};

            
      var $urlString="../finance/json_redirect.php?action=updateccountb";

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
              $.modaldialog.success("<br></br><b>Account Updated successfully</b>", {
             width:400,
             showClose: true,
             title:"UPDATE SUCCESS"
            });
                $("#acctno2").val("");
                $("#slctbankname").val("");
                $("#actsector2").val("");
                $("#acttype2").val("");
              $("#statusacctype").hide(); document.getElementById("statusacctype").innerHTML = '';                  
                 }
             else{
              
             $("#d_progress").dialog("destroy");
                 
             $.modaldialog.warning('<br></br><b> ACCOUNT UPDATE FAILED</b>', {
             width:400,
             showClose: true,
             title:"ERROR"
            });
              
               
             }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
                  alert("ACCOUNT UPDATE FAILED");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              });  
}


function adminupdteacct($adminactnme,$admnacctno,$admnactsector,adminacttype,estatename){
    var $dataString={adminactname:$adminactnme,acctno:$admnacctno,actsector:$admnactsector,acttype:adminacttype,estatename:estatename};

            
      var $urlString="../finance/redirect.php?action=updateccountadmin";

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
              $.modaldialog.success("<br></br><b>Account Updated successfully</b>", {
             width:400,
             showClose: true,
             title:"UPDATE SUCCESS"
            });
                $("#adminacctno2").val("");
                $("#adminslctbankname").val("");
                $("#estatename").val("");
                $("#adminactsector2").val("");
                $("#adminacttype2").val("");
              $("#adminacttype2").hide(); 
              //document.getElementById("statusacctype").innerHTML = '';                  
                 }
             else{
              
             $("#d_progress").dialog("destroy");
                 
             $.modaldialog.warning('<br></br><b> ACCOUNT UPDATE FAILED</b>', {
             width:400,
             showClose: true,
             title:"ERROR"
            });
              
               
             }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
                  alert("ACCOUNT UPDATE FAILED");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              });  
}


function saveDebtor($name,$telephone,$email,$postal,$city,$remarks){
    
    
     var $dataString={name:$name,telephone:$telephone,email:$email,postal:$postal,city:$city,remarks:$remarks};
        
      var $urlString="../finance/json_redirect.php?action=savedebtor";

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
         
             
             $("#adddebtors").dialog("destroy");
             
        $("#debname").val("");
        $("#debmobile").val("");
        $("#demail").val("");
        $("#dzip").val("");
        $("#dcity").val("");
        $("#debrmks").val("");
             
              alert("Debtor saved successfully");
              
              
                 }
             else{
              
             $("#d_progress").dialog("destroy");
                 
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

function saveSupplier($name,$telephone,$email,$postal,$city,$remarks){
    
    
     var $dataString={name:$name,telephone:$telephone,email:$email,postal:$postal,city:$city,remarks:$remarks};
        
      var $urlString="../finance/json_redirect.php?action=savesupplier";

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
         
             
             $("#addsuppliers").dialog("destroy");
             $.modaldialog.success("<br></br>Supplier saved successfully", {
             width:400,
             showClose: true,
             title:"SUCCESSFULL TRANSACTION"
            });
             // alert("Supplier saved successfully");
              
              $("#supname").val("");
              $("#supmobile").val("");
              $("#semail").val("");
              $("#pzip").val(""); 
               $("#scity").val("");      $("#supprmks").val("");
                 }
             else{
              
             $("#d_progress").dialog("destroy");
                 
             alert("Supplier not saved-please try again later");
              
              
                    
             }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
                  alert("Supplier not saved-please try again later");
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
               $(".ui-dialog-titlebar").hide();
              
             }
                 
              });      
                 
    
}




function pettysaveSupplierBill($date,$docno,$amount,$bank,$expacc,$remarks,$ccid){
    
    
     var $dataString={date:$date,docno:$docno,amount:$amount,bank:$bank,expacc:$expacc,remarks:$remarks,ccid:$ccid};
        
      var $urlString="../finance/json_redirect.php?action=pettysavesupplierbill";

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
         
              
              window.location="../finance/pettypayments.php?supplier=0&docnumbers="+$docno+"&chequedate=0"+"&chequeno=0&amount="+$amount+"&narration="+$remarks+"&paymentdate="+$date+"&expacc="+$expacc+"&acc="+$bank+"&payno="+response.payno;
              
                 }
                 else if(response.id==="low_balance"){
               
               $("#d_progress").dialog("destroy");
               
             $.modaldialog.warning('Sorry .Your Bank Balance is not enough to complete this request .Please make a deposit or switch to another account', {
             width:400,
             showClose: true,
             title:"LOW BALANCE"
            });
           
                 }
             else{
              
             $("#d_progress").dialog("destroy");
                 
                alert("Payment not completed-please try again later");
              
              
                    
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
function updatedrdebtamnt(i){
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
function updatecrdebtamnt(){
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
function updatedebtdiff(){
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
         $("#debttinfo").append('<tr><td></td><td ><button id="create" onclick="passbaddebtentry()">Create</button></tr>');
     }
    
}

function passbaddebtentry(){
    
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
     $.getJSON("../finance/json_redirect.php?action=savedebtrbdebts&ledgertype="+$entrytype+"&ledgeraccts="+$ledgeraccts+"&dramount="+dramount+"&cramount="+cramount+"&journaldate="+journaldate+"&journalrmks="+journakrmks+"&incmeid="+incacct, function(data) {
         
              if(data.id===1){
        
         $("#d_progress").dialog("destroy");
                    $.modaldialog.success('<br></br><b>Journal Entry completed successfully</b>', {
          title: 'Success transaction',
          showClose: true
          });  
       window.location="../finance/baddebtspreview.php?ledgertype="+$entrytype+"&ledgeraccts="+$ledgeraccts+"&dramount="+dramount+"&cramount="+cramount+"&journaldate="+journaldate+"&journalrmks="+journakrmks+"&journalno="+data.journalno;
   
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
function compute_invoice_totals(){
   
   var $unit_price=$("#cost4").val();
   
   var $qtt=$("#qty4").val();
   
   if($unit_price===""){
      
      $unit_price=0;
   }
   
    if($qtt===""){
      
      $qtt=0;
   }
   
   
   var $totalsamount=parseFloat($unit_price)* parseFloat($qtt);  
    
      document.getElementById("price4").innerHTML=$totalsamount;
      document.getElementById("inamount1").innerHTML=$totalsamount;
      document.getElementById("subtotal").innerHTML=$totalsamount;
      document.getElementById("total").innerHTML=$totalsamount;
      document.getElementById("due").innerHTML=$totalsamount;
}


function cal_tax($amount){
    //alert ('GOAL');
    if($amount==''){
        $amount=0;
    }
   var $taxrate = $("#ratetax").val();
   var $taxamt =  parseFloat($amount)*parseFloat($taxrate/100);
   var aftertax = parseFloat($amount)+(parseFloat($taxamt));
   $("#addtax").val(parseFloat($taxamt));
    $("#affertax").val(parseFloat(aftertax));
     $("#billamount").val(parseFloat(aftertax));
}

function  cal_tax2 ($rate){

var $supplamt = $("#supplamt").val();
     if($supplamt==''){
        $supplamt=0;
    }
var taxamt = parseFloat($supplamt)*parseFloat($rate/100);
var aftertax = parseFloat($supplamt)+parseFloat(taxamt);
$("#addtax").val(parseFloat(taxamt));
$("#affertax").val(parseFloat(aftertax));
 $("#billamount").val(parseFloat(aftertax));
}

function invoice_data($val){
   
       
     if($val.length>=4){
          
    $.getJSON("../finance/json_redirect.php?action=getmuminNameForinvoice&sabil="+$val, function(data) {
   
        
         
   
   if(data.name ==='Not in Mohalla'){
                basicLargeDialog("#inv_rqst",450,350);
                $("#musabil").val(data.sabil);
     }
    else if(data.name === 'debtor'){
                basicLargeDialog("#readydebtr",450,350);
                
        }
    else{
     
            $("#sabilname").val(data.name);
           $("#invsabil").val(data.sabil);
            $("#ejnoinv").val(data.ejno);
           $("#sectornme").val(data.sector);
            $('#nameinvcenoid').html(data.name);
             $("#invceits").val(data.ejno);
             //alert(data.ejno);
        }
 
    });
       }
       else{
            
       }
   
}

function _send2Printer(document_to_print){
  
  var newWin= window.open("");
  newWin.document.write(document_to_print.outerHTML);
  newWin.print();
  newWin.close();
  return false;  
   
 
}

function getHofNames($sabil){
    
    //if($sabil.length>=4){
         document.getElementById("statname").innerHTML=" "; 
          var $dataString={sabil:$sabil};
        
      var $urlString="../finance/json_redirect.php?action=getmuminNameForinvoice";

               $.ajax({                                                                        
                
                url: $urlString,
                
                type: "GET",
                
                dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
                data:$dataString,
                
                success: function(response) {
                    
                               if(response.name!=='Not in Mohalla'){
         $("#statmntfield").css("display","block");
         document.getElementById("statname").textContent=response.name;
         } else{
          $("#statmntfield").css("display","none");
          document.getElementById("statname").textContent="Sabil No. Unavailable";
         }
            $("#d_progress").dialog("destroy");
                   
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
                  alert(thrownError);
                
                },
             beforeSend:function(){                       
                
              basicLargeDialog("#d_progress",50,150);
              
               $(".ui-dialog-titlebar").hide();
              
             } });   
    
   
     // }
 // else{}
    
}

function submitPost($post){
    
   $.getJSON("../finance/json_redirect.php?action=posts&post="+$post, function(data) {
   
   
     if(data.id===1){
        
         
          alert('Post submitted successfully'); 
           
           
      
     }
 else{
        alert('Error occured while submiting post');  
 }
    });
    
    
    
}




function  getUserInformation($ejno){
       
     
     
   if($ejno.length===8){
      
   $("#tabs").css("display","block");    
     
   $.getJSON("../finance/json_redirect.php?action=getUserDatax&ejno="+$ejno, function(data) { 
  
  
  if(data.length>0){
   
    $.each(data, function(i, item) {
         
       
       if(item.status==="W"){
           
          // alert("Mumin for the ejamaat No you provided is wafat");
            $.modaldialog.error('Mumin for the ejamaat No you provided is wafat', {
          title: 'Missing data',
          showClose: true
          });   
       }
	    else if(item.status==="T"){
           
          // alert("Mumin for the ejamaat No you provided is wafat");
            $.modaldialog.error('Mumin for the ejamaat No you provided has been Transfered', {
          title: 'Missing data',
          showClose: true
          });   
       }
 else{
      $("#prefixview").val(item.fprefix);
      $("#prefixdateview").val(item.prefdate);
      $("#fnameview").val(item.fname);
      $("#surnameview").val(item.sname);
      $("#genderview").val(item.sex);
      $("#dobview").val(item.dob);
      $("#idnoview").val(item.idno);
      $("#donikahview").val(item.don);
      $("#marital-statusview").val(item.mstat);
      $("#spouseview").val(item.husband);
      $("#ejnoview").val(item.ejno);
      $("#hofejview").val(item.hofej);
      $("#rtohofview").val(item.rtohof);
      $("#misaqview").val(item.misaq);
      $("#mohalaview").val(item.moh);
       $("#moh1view").val(item.moh);
      $("#catview").val(item.cat);
      
      if(item.safai==="G"){
       
             $("#safaiview").css("background","green");
      }
      else if (item.safai==="R"){
          $("#safaiview").css("background","red"); 
      }
  else if (item.safai==="Y"){
          $("#safaiview").css("background","yellow"); 
      }
  else{
      
  }
     // $("#safaiview").val(item.safai);
      $("#safaivalview").val(item.safaival);
      $("#vatanview").val(item.vatan);
      $("#nationalityview").val(item.nation);
      $("#sabilnoview").val(item.sabilno);
      $("#fatherprefixview").val(item.fathprex);
      $("#fatherfnameview").val(item.dadname);
      $("#fathersnameview").val(item.fsname);
      $("#smobileview").val(item.smobile);
      $("#zmobileview").val(item.zmobile);
      $("#omobileview").val(item.omobile);
      $("#smsmobileview").val(item.smsmobile);
      $("#oftelview").val(item.offtel);
      $("#hsetelview").val(item.hsetel);
      $("#pmailview").val(item.mail);
      $("#omailview").val(item.bemail);
      $("#ppnoview").val(item.ppno);
      $("#maddview").val(item.madd);
      $("#saddview").val(item.sadd);
      $("#zipview").val(item.zip);
      $("#safaivalview").val(item.safaival);
      
      
      
     $("#hsenoview").val(item.hseno);
     $("#hsetypeview").val(item.hsetyp);
     $("#roomtypeview").val(item.roomtyp);
     $("#sectorview").val(item.sector);
     $("#moh1view").val(item.moh);
     $("#hsedetview").val(item.hsedet);
       
        
   
        
      $("#sp1view").val(item.sp1ej);
      $("#sp2view").val(item.sp2ej);
      $("#sp3view").val(item.sp3ej);
      $("#sp4view").val(item.sp4ej);
      $("#ikno1view").val(item.ikhwan1);
      $("#ikno2view").val(item.ikhwan2);
      $("#ikno3view").val(item.ikhwan3);
      $("#ikno4view").val(item.ikhwan4);
      $("#ikno5view").val(item.ikhwan5);
      $("#headiknoview").val(item.ikno);
      $("#mothrview").val(item.mumej);
      $("#fthrview").val(item.dadej);
      $("#qadbosiview").val(item.qadbosi);
      $("#msharafview").val(item.msharaf);
      $("#msharafdateview").val(item.msharafdt);
      $("#shehesharifview").val(item.shehsharf);
      $("#shehesharifdateview").val(item.shehsharfdt);
      
      

       
       $("#occupview").val(item.occup);
       $("#estabview").val(item.estab);
       $("#buscatview").val(item.buscat);
       $("#finlevview").val(item.finlev);
       $("#enayatfromview").val(item.enayetfrm);
       $("#enayatforview").val(item.enayatfor);
       $("#rentview").val(item.rent);
       $("#hsabamview").val(item.hsabam);
       $("#psabamview").val(item.psabam);
       $("#qarzpayview").val(item.qarzpay);
       $("#qarzhanview").val(item.qarzhan);
      
       
        

     $("#tabs-right-panel").html('<img  width="150" height="150" alt="Image not found" src="../assets/images/mumin/'+item.ejno+'.jpg"></img>') ;
       
     $("#progressbar").html(item.fprefix+"&nbsp;"+item.fname+"&nbsp;"+item.sname+"&nbsp;"+item.dadname);
       
  
  
   
   
   
   $.getJSON("./json_redirect.php?action=getsplitdata&sabilno="+item.sabilno, function(data) {
  
    
     $("#familytable").empty();
     
      for(var $i in data){
          
          if(data[$i]['hofej']===data[$i]['ejno']){
           
              $("#familytable").append("<tr><td><input class='ckfamily' title='HEAD OF FAMILY '   id='checkbox"+$i+"' value='"+data[$i]['ejno']+"' type='checkbox'/></td><td>"+data[$i]['ejno']+"</td><td>"+data[$i]['fprefix']+"&nbsp;"+data[$i]['fname']+"&nbsp;"+data[$i]['sname']+"&nbsp;"+data[$i]['dadname']+"</td><td><img width='48' height='56' src='../assets/images/mumin/"+data[$i]['ejno']+".jpg'<td><tr>");
            
           }
     else{
              $("#familytable").append("<tr><td><input class='ckfamily' id='checkbox"+$i+"' value='"+data[$i]['ejno']+"' type='checkbox'/></td><td id='e"+$i+"'>"+data[$i]['ejno']+"</td><td id='n"+$i+"'>"+data[$i]['fprefix']+"&nbsp;"+data[$i]['fname']+"&nbsp;"+data[$i]['sname']+"&nbsp;"+data[$i]['dadname']+"</td><td><img width='48' height='56' src='../assets/images/mumin/"+data[$i]['ejno']+".jpg'<td><tr>");
           }
     }
   });
    }
   
     }); 
  }
  else{
   $.modaldialog.prompt('Mumin owner of ejamaat No '+$ejno+' is not a member of this Mohalla. Kindly contact Anjuman office if you think this is an error', {
          title: 'Record not found',
          showClose: true
          });   
  }
   });
   
   
   }
   else{
   
   }
   } 
   
   function sabil_lookUp($sabil){
   
     
   $.getJSON("./json_redirect.php?action=getsplitdata&sabilno="+$sabil, function(data) {
  
    
     $("#splittable").empty();
     
      for(var $i in data){
          
          if(data[$i]['hofej']===data[$i]['ejno']){
           
              $("#splittable").append("<tr><td><input class='cksabil' title='THIS IS HEAD OF FAMILY'  value='"+data[$i]['ejno']+"' type='checkbox'/></td><td>"+data[$i]['ejno']+"</td><td>"+data[$i]['fprefix']+"&nbsp;"+data[$i]['fname']+"&nbsp;"+data[$i]['sname']+"&nbsp;"+data[$i]['dadname']+"</td><td><img width='48' height='56' src='../assets/images/mumin/"+data[$i]['ejno']+".jpg'<td><tr>");
            
           }
     else{
              $("#splittable").append("<tr><td><input class='cksabil'  value='"+data[$i]['ejno']+"' type='checkbox'/></td><td id='e"+$i+"'>"+data[$i]['ejno']+"</td><td id='n"+$i+"'>"+data[$i]['fprefix']+"&nbsp;"+data[$i]['fname']+"&nbsp;"+data[$i]['sname']+"&nbsp;"+data[$i]['dadname']+"</td><td><img width='48' height='56' src='../assets/images/mumin/"+data[$i]['ejno']+".jpg'<td><tr>");
           }
     }
   });
}

 function checkUsernameAvailability($val, $label){
   
      
      
      if($val===""){
         
         document.getElementById($label).innerHTML="<font color='red'>Username CANNOT be empty</font>";
          
      }
      else{
      $.getJSON("../finance/json_redirect.php?action=checkavailability&value="+$val, function(data) {
   
           
   
     if(data){
     document.getElementById($label).innerHTML=data.id;
 }
 
            
        
    });
      }
}

 
function pulloutlinkedaccount($incaccounts){
 
     $("#tabs").css("display","none");
     
    $("#bankaccount").empty();
    
     $("#bankaccount100").empty();
   
    $.getJSON("../finance/json_redirect.php?action=pulloutlinkedaccount&id="+$incaccounts, function(data) {
  
    if(data.length>0){
     
     $("#tabs").css("display","block");
    
    $.each(data, function(i, item) {
       
    $("#bankaccount").append("<option value="+item.acno+">"+item.bankaccount+":"+item.acname+"</option>");
    $("#bankaccount100").append("<option value="+item.acno+">"+item.bankaccount+":"+item.acname+"</option>");
    
   
       });
    }
    else{
        
        //alert("We are unable to link this accounts, Please contact system admin")
          $.modaldialog.warning('We are unable to link this account .Please contact admin for assistance', {
             timeout: 5,
             width:500,
             showClose: false,
             title:"Accounts unlinked"
            });
           
    }
      
  }); 
  
  
}

function pulloutlinkedaccountinvoices($incaccounts){
 
     $("#tabs").css("display","none");
     
    $("#cshbankaccount").empty();
    
     $("#invoicebankaccount").empty();
   
    $.getJSON("../finance/json_redirect.php?action=pulloutlinkedaccount&id="+$incaccounts, function(data) {
  
    if(data.length>0){
     
     $("#tabs").css("display","block");
    
    $.each(data, function(i, item) {
       
    $("#cshbankaccount").append("<option value="+item.acno+">"+item.bankaccount+":"+item.acname+"</option>");
    $("#invoicebankaccount").append("<option value="+item.acno+">"+item.bankaccount+":"+item.acname+"</option>");
    
   
       });
    }
    else{
          $.modaldialog.warning('We are unable to link this account .Please contact admin for assistance', {
             timeout: 5,
             width:500,
             showClose: false,
             title:"Accounts unlinked"
            });
           
    }
      
  }); 
  
  
}
function getdebtaccounts(){

    $.getJSON("../finance/json_redirect.php?action=getallssabilnoaccount", function(data) {
    
    $.each(data, function(i, item) {
       
    $(".ledgerids").append("<option value="+item.incacc+"|"+item.tbl+"|"+item.typ+">"+item.accname+" - "+item.typ+"</option>");
    //$(".tbltype").append("<input type='text' value="+item.tbl+"></input>");  
       });
      
  });
}

function getnonresidentdebtaccounts(){

    $.getJSON("../finance/json_redirect.php?action=getalldebtorsaccount", function(data) {
    
    $.each(data, function(i, item) {
       
    $(".ledgerids").append("<option value="+item.incacc+"|"+item.tbl+"|"+item.typ+">"+item.accname+" - "+item.typ+"</option>");
    //$(".tbltype").append("<input type='text' value="+item.tbl+"></input>");  
       });
      
  });
}
function getbadincmeacct(){

    $.getJSON("../finance/json_redirect.php?action=getallincmeaccts", function(data) {
    
    $.each(data, function(i, item) {
       
    $("#badincmeacct").append("<option value="+item.incacc+">"+item.accname+"</option>");
    //$(".tbltype").append("<input type='text' value="+item.tbl+"></input>");  
       });
      
  });
}
function updateamtup(i){

   // parseInt(document.getElementById("cxamx"+$amountid).innerHTML);
       var cashamount = 0;
                if(!$("#amnt2pay"+i).val()){
                    $("#unpcx"+i).attr('checked',false);
                     $("#expnseaccounts").val(" ");
                $("#costc").val(" ");
                }
           
         $("#unpcx"+i).attr('checked','checked');
         $("#expnseaccounts").val($("#expenid"+i).val());
         $("#costc").val($("#costcntrid"+i).val());
         var $orgamnt = document.getElementById("cxam"+i).textContent;
         var $pd = document.getElementById("amtpd"+i).textContent;
         var balance = parseFloat($orgamnt)-parseFloat($pd);
         var $amountopay = $("#amnt2pay"+i).val();
         if(parseFloat(balance)>parseFloat($amountopay)){
             $("#unpchbx"+i).attr('checked','checked');
         }
        else{
            $("#unpchbx"+i).attr('checked',false);
            $("#expnseaccounts").val(" ");
            $("#costc").val(" ");
        }
           //           if($(".halfpay:checked").length>1){
          //alert ('Only one can be paid half');
          if($("#amnt2pay"+i).val()>balance){
              $.modaldialog.warning('Over payment not allowed', {
                 timeout: 4,
            width:500,
            showClose: false,
             title:"Warning"
            });
            $("#amountt100").val(0.00); $("#investamont").val(0.00);
            $("#amnt2pay"+i).val("");
            $("#unpcx"+i).attr('checked',false);
          }
      else{
        //  
      //  $("#amntopay"+i).val('');
       // $("#unpcxx"+i).attr('checked',false);
      //}
        // var $docnos=document.getElementById("bxxn"+i).textContent;
       //  var $amntpay = $("#amntopay"+i).val();
      for (var j=0;j<=(document.getElementById("billstable1").rows.length)-2;j++){
                    
            if(!$("#amnt2pay"+j).val() ||$("#amnt2pay"+j).val()== 0 ){ // check whether the input field is null
              var $pldgeamount = 0 ;
              $("#unpcx"+j).attr('checked',false);
                    }
              else{
                   $pldgeamount = $("#amnt2pay"+j).val();
                  
              }
          cashamount= parseFloat($pldgeamount)+parseFloat(cashamount) ;
          
                 
    }
       $('#investamont').val(cashamount); 
    $('#amountt100').val(cashamount);
    
}}