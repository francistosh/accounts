<?php
session_start(); 

if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>JIMS 2</title> 
<?php




  $userid = $_SESSION['acctusrid'];
$usr=$_SESSION['jname'];  
include 'operations/Mumin.php';

$mumin=new Mumin();
/*if($access!="ADMIN"){
    
  
 header("location: ../index.php");
}*/
 date_default_timezone_set('Africa/Nairobi');
 include '../partials/stylesLinks.php';   
 include 'links.php';
?>

<script>
    
  $(function() {
  
  $("#xxxad").button({
            icons: {
                primary: "ui-icon-disk" ,
                        secondary:"ui-icon-check"
            },
            text: true
             
});
  $("#xxxcancel").button({
            icons: {
                primary: "ui-icon-cancel" ,
                        secondary:"ui-icon-circle-close"
            },
            text: true
             
});
 $('#editsupp').dataTable( {
	"bSort": false,
	// "sPaginationType": "full_numbers",
	"iDisplayLength": 25,
	"aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
	"bJQueryUI": true
  } );
           $( "#addcmpy" ).button({
            icons: {
                primary: "ui-icon-newwin"
            },
            text: false
             }).click(function(){
            basicLargeDialog("#newcmpny",400,300);
           
         
 
       });
 $("#tabs").tabs(); 
$('#adeprtmnt').click(function(){
     basicLargeDialog("#newdeprt",400,300);
    
});

  $('#adminaddact').click(function(){
       $("#adminacctname").show();
       $("#adminacctno").show();
       $("#adminactsector").show();
       $("#adminactsector").val("");
       $("#adminacttype").show();
       $("#adminslctbankname").hide();
       $("#adminacctno2").hide();
       $("#adminactsector2").hide();
       $("#adminacttype2").hide();
       $("#estatename").val("");
        $("#adminslctbankname").val(''); $("#adminacctno2").val('');
       $("#adminstatusacctype").hide(); $("#adminactsector2").val('');
       $("#adminupdateact").hide();
       $("#admincreateact").show(); document.getElementById("statusacctype").innerHTML = '';
   });
      $('#adminnEditact').click(function(){
       $("#adminslctbankname").show();
       $("#adminactsector").val("");
        $("#estatename").val("");
       $("#adminacctname").hide();
       $("#adminacctno2").show();
       $("#adminacctno").hide();
       $("#adminactsector2").show();
       $("#adminactsector").hide();
       $("#adminacttype").hide();
       $("#adminacttype2").show();
       $("#adminstatusacctype").show();
       $("#adminupdateact").show();
       $("#admincreateact").hide();
   });
  
  $("#estatename").change((function(){  
         
       var $estname = $(this).val();
       if ($estname !==""){
          // $("#adminactsector").empty();
          $('#adminactsector').find('option:not(:first)').remove();
          $('#adminslctbankname').find('option:not(:first)').remove();
       $.getJSON("../finance/redirect.php?action=fetchestdetails&estateid="+$estname, function(data) {
            
         for(var $i in data){
           $('#adminactsector').append($('<option>').text(data[$i]['sector']).attr('value',data[$i]['sector'])); 
           
        };
       });
    
    $.getJSON("../finance/redirect.php?action=fetchbankdetails&estateid="+$estname, function(data) {
            
         for(var $i in data){
           $('#adminslctbankname').append($('<option>').text(data[$i]['acname']).attr('value',data[$i]['bacc'])); 
           
        };
       });
       } else{
       $("#adminacctname").val("");
       $("#adminacctno").val("");
       $("#adminactsector").val(""); document.getElementById("adminstatusacctype").innerHTML = '';
       $("#adminacttype").val("");
       }
   }));
    $("#deptyr").change((function(){  //
       if($("#budgetyr").val()==" "){
           $.modaldialog.warning("<br></br><b>Year not selected</b>", {
             width:400,
             showClose: true,
             title:"Missing Data"
            });
       } if($("#deptyr").val() == ""){
       $("#tabs").fadeOut("slow");
         }else{
        $("#tabs").fadeIn("slow");    
         }
   }));
    $( "#budgetyr" ).datepicker({dateFormat: 'yy',changeYear: true,showButtonPanel: true});
     $("#addcompny").click(function(){
      
       
       var $cname= $("#cname").val();
            
       
       $.getJSON("../finance/json_redirect.php?action=addcompany&cname="+$cname, function(data) {
        
      
   
     if(data){
        
         $("#newcmpny").dialog("destroy");
         
         window.location.reload();
     }
        
    });   
      
  });
  
       $("#addprtmnt").click(function(){
      
       
       var $dname= $("#dname").val();
            
       
       $.getJSON("../finance/json_redirect.php?action=addepartment&dname="+$dname, function(data) {
        
      
   
     if(data){
        
         $("#newdeprt").dialog("destroy");
         
         window.location.reload();
     }
        
    });   
      
  });
  
  
   $("#editcompny").click(function(){
       var $cnyid= $("#cnyid").val();
        var $cnyame= $("#cnyame").val();
        var $cnytel= $("#cnytel").val();    
       var $cnyemail= $("#cnyemail").val();
       var $cnyaddr= $("#cnyaddr").val();
       var status = $("#sta").val();
       $.getJSON("../finance/json_redirect.php?action=updatecompany&cname="+$cnyame+"&cnyid="+$cnyid+"&cnytel="+$cnytel+"&cnyemail="+$cnyemail+"&cnyaddr="+$cnyaddr+"&stat="+status, function(data) {
        
      
   
     if(data){
        // window.location.reload();
         $("#editcmpny").dialog("destroy");
         $.modaldialog.success("<br></br><b>Update successful</b>", {
             width:400,
             showClose: true,
             title:"SUCCESSFUL TRANSACTION"
            });
      //   window.location.reload();
     }
        
    });   
   });
  
     $("#editdeprt").click(function(){
       var $dpmntid= $("#dpmntid1").val();
        var $dpmntname= $("#dpmntname").val();
        var dpmntcode = $("#dpmntcode").val();
            
       $.getJSON("../finance/json_redirect.php?action=updatedepr&dpid="+$dpmntid+"&dpname="+$dpmntname+"&dprtcode="+dpmntcode, function(data) {
        
      
   
     if(data){
        
         $("#editdeprtmnt").dialog("destroy");
         
                 $.modaldialog.success("<br></br><b>Update successful</b>", {
             width:400,
             showClose: true,
             title:"Successful Transaction"
            });
         
     }
        
    });   
   });
  
  
       $("#editlinkdeprt").click(function(){
       var $dpmntid= $("#dpmntid").val();
        var $compid= $("#compid").val();
               
       $.getJSON("../finance/json_redirect.php?action=updatedeprtlink&dpid="+$dpmntid+"&cmpnyid="+$compid, function(data) {
        
      
   
     if(data){
         $("#linkdeprtmnt").dialog("destroy");
      $.modaldialog.success("<br></br><b>Update successful</b>", {
             width:400,
             showClose: true,
             title:"SUCCESSFUL TRANSACTION"
            });
       // window.location.reload();
         
         
         
     }
        
    });   
   });
  $(document.body).on('click', '.changecompany', function() { 
        var $id=$(this).attr("id");
           
           var $cell="cmpnyname"+$id.substring(1);
           var $cm="cmpny"+$id.substring(1);
           var $ctel="cmpnyt"+$id.substring(1);
           var $cmail="cmpnym"+$id.substring(1);
           var $cpostal="cmpnyp"+$id.substring(1);
           var $status ="stats"+$id.substring(1);
            $("#cnyame").val(document.getElementById($cell).textContent);
            $("#cnyid").val(document.getElementById($cm).textContent);
            $("#cnytel").val(document.getElementById($ctel).textContent);
           $("#cnyemail").val(document.getElementById($cmail).textContent);
            $("#cnyaddr").val(document.getElementById($cpostal).textContent);
            //alert(document.getElementById($status).textContent);
            $("#sta").val($(document.getElementById($status)).val());
        basicLargeDialog("#editcmpny",400,500);
      
   });
    $(document.body).on('click', '.changedepartment', function() {    
           var $id=$(this).attr("id");
           
           var $cell="deptname"+$id.substring(1);
           var $cm="deptid"+$id.substring(1);
          var code = "codeid"+$id.substring(1);
            $("#dpmntname").val(document.getElementById($cell).textContent);
            $("#dpmntid1").val(document.getElementById($cm).textContent);
            $("#dpmntcode").val(document.getElementById(code).textContent);
        basicLargeDialog("#editdeprtmnt",400,300);
      
   });
   $(document.body).on('click', '.linkdepartment', function() {
            var $id=$(this).attr("id");
            var $cell="deptname"+$id.substring(1);
           var $cm="deptid"+$id.substring(1);
          
            $("#linkdpname").val(document.getElementById($cell).textContent);
            $("#dpmntid").val(document.getElementById($cm).textContent);

        basicLargeDialog("#linkdeprtmnt",400,300);
      
   });
   
   
   
   $('.arrow').addClass('collapsed');

$('#menu-primary-navigation > li > a.arrow').click(function(e) {  // select only the child link and not all links, this prevents sub links from being selected. 
    var sub_menu = $(this).next('.sub-menu'); // store the current submenu to be toggled  
    e.preventDefault();
    $('.sub-menu:visible').not(sub_menu).slideToggle('fast'); // select all visible sub menus excluding the current one that was clicked on and close them 
    sub_menu.slideToggle('fast'); // toggle the current sub menu 
	
    $("li a.arrow").addClass('collapsed');  // Add the collapse class to the clicked a	 
    $(this).removeClass('collapsed').addClass('expanded');    //Remove the collapse class from only the clicked tag
});
 
 });   
 
</script>

<link rel="stylesheet" href="../assets/css/jquery-ui.css" />
</head>  
    
<body>
    
   
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
  	<div id="div_logindetails">You are logged in as:  <?php echo $usr;?></div>
    <!--Left Panel Starts Here-->
<div id="div_leftpanel">
     <?php include_once 'adminleftmenu.php'; ?>
        
      </div>
    <!--Right Panel Starts Here-->
    <div id="div_rightpanel">
   
   	  <div id="div_datainput">
      	<div id="div_formtitle">
        	<h3 class="titletext">Admin sub-section</h3>
        </div>
        <div id="div_formcontainer">
            
        <div id="tabs2">
            
            
  <?php
  $action=$_GET['action'];
  
  
  if($action=="addcompny"){
            echo "<div id='suppliersFilterBar' style='width:100%'><button id='addcmpy'  style='float: right;height:20px;width:50px;margin:4px 45px 4px 0px' >Add New Company</button></div>";
     
           $qer="SELECT deptid,deptname,tel,email,addr,active as stat,IF(active='0','Closed','Open') as type FROM department "; 
      
       $data=$mumin->getdbContent($qer);
    
       echo "<fieldset style='border:1px lightgray solid;color:gray;font-size: 15px;font-weight: bold'> "; 
       
       echo "<legend>Listed Company</legend>";
      
      echo "<table id='editsupp' class='invview' style='margin-top:3px'>"; 
      echo '<thead>';
       echo "<tr><th style='font-size:12px'>SN</th><th style='font-size:12px'>Names</th><th style='font-size:12px'>Telephone</th><th style='font-size:12px'>Email</th><th style='font-size:12px'>Postal Addr</th><th style='font-size:12px'>Status</th><th style='font-size:12px'></th>";
      echo '</thead>';
      echo '<tbody>';
      for($j=0;$j<=count($data)-1;$j++){    
               
               
     echo "<tr><td  id='cmpny".$j."' style='font-size:12px'>".$data[$j]['deptid']."</td><td id='cmpnyname".$j."' style='font-size:12px'>".$data[$j]['deptname']."</td><td id='cmpnyt".$j."' style='font-size:12px'>".$data[$j]['tel']."</td><td id='cmpnym".$j."' style='font-size:12px'>".$data[$j]['email']."</td><td id='cmpnyp".$j."' style='font-size:12px'>".$data[$j]['addr']."</td><td style='font-size:12px'>".$data[$j]['type']."</td><td style='font-size:12px'><a id='k".$j."' class='changecompany' href='#'>Edit</a>&nbsp;<input type='text' id='stats".$j."' style='font-size:12px;' hidden value='".$data[$j]['stat']."'/></td> </tr>";
      //|&nbsp;<a id='v".$j."' class='changedelete3' href='#'>Delete</a>.
             }
      echo '</tbody>';
      echo "</table>";
      echo "</fieldset>";    
           
            
  }else if($action=="addeprtmnt"){
      
           $qer="SELECT * FROM department2 "; 
      
       $data=$mumin->getdbContent($qer);
    
       echo "<fieldset style='border:1px lightgray solid;color:gray;font-size: 15px;font-weight: bold'> "; 
       
       echo "<legend>Cost Centers</legend>";
      
      echo "<table id='editsupp' class='invview' style='margin-top:3px'>"; 
      echo '<thead>';
       echo "<tr><th style='font-size:12px'>SN</th><th style='font-size:12px'>Names</th><th style='font-size:12px'>Code</th><th style='font-size:12px'></th><th style='font-size:12px'></th>";
      echo '</thead>';
      echo '<tbody>';
      for($h=0;$h<=count($data)-1;$h++){    
               
               
     echo "<tr><td  id='deptid".$h."' style='font-size:12px'>".$data[$h]['id']."</td><td id='deptname".$h."' style='font-size:12px'>".$data[$h]['centrename']."</td><td style='font-size:12px' id='codeid".$h."'>".$data[$h]['code']."</td><td style='font-size:12px'><a id='k".$h."' class='changedepartment' href='#'>Edit</a>&nbsp;</td><td style='font-size:12px'><a id='k".$h."' class='linkdepartment' href='#'>Manage</a>&nbsp;</td></tr>";
      //|&nbsp;<a id='v".$j."' class='changedelete3' href='#'>Delete</a>.
             }
      echo '</tbody>';
      echo "</table>";
      echo "</fieldset>";    
      echo "<div id='suppliersFilterBar' style='width:100%'><br/><button id='adeprtmnt'  class='btncls' style='float: right;' >Add New Cost Center</button></div>";     
      
  }else if($action=="budget"){
      ?>
            <div>
               <fieldset style="-moz-border-radius: 7px; border: 1px #dddddd solid; "><legend style="border: 1px #1a6f93 dotted;font-size: 13px;padding-right: 5px;padding-left: 5px;padding-top: 2px;padding-bottom: 2px;-moz-border-radius: 3px; width: 200px; font-weight: bold">Budget</legend>
 
                   <label class="formlabel">Year:</label><input type="text" id="budgetyr" class="formfield" value="<?php echo date('Y');?>"/>
                <label class="formlabel">Department:</label><select class="formfield" id="deptyr">
                      <option selected="true" value="">--Select--</option>
                 <?php
                      
                     $jqery="SELECT deptid,deptname FROM department order by deptname ASC  "; 
                         $datay=$mumin->getdbContent($jqery);
    
       
      for($j=0;$j<=count($datay)-1;$j++){    
               
               
       echo "<option value='".$datay[$j]['deptid']."'>".$datay[$j]['deptname']."</option>";
      
             }
             ?>
                  </select>
               
            </fieldset>
                <div class="budget" id="tabs" style="display:none">
                   <ul>
    <li><a href="#incmebudget">Income</a></li> 
    <li><a href="#expensebudget">Expense</a></li>
     </ul>
                    <div style="border: 1px solid #008d4c; border-radius: 3px; height: 300px;overflow-y:auto" id="incmebudget">
                    <?php
                    
                    $qryq="SELECT * FROM (SELECT incomeaccounts.incacc,incomeaccounts.accname,budget_income.amount,typ,incomeactmgnt.deptid,if(year is null,'2017',year) as year FROM incomeaccounts  LEFT JOIN  incomeactmgnt  ON  incomeactmgnt.incacc = incomeaccounts.incacc  LEFT JOIN  budget_income  ON budget_income.acct_id = incomeaccounts.incacc)T5 WHERE typ = 'I' AND deptid = '25' AND year = '2017' ORDER BY accname"; 
                   // $qr="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id'"; 

                    $data=$mumin->getdbContent($qryq);
                    for($t=0;$t<=count($data)-1;$t++){
                        echo "<label class='blabel'>".$data[$t]['accname']."</label><input value='".number_format($data[$t]['amount'],2)."' class='amount'></input><br style='clear: left;' /><br/>";
                    }
                    ?>
                        <button>Save</button>
                </div>
                      <div style="border: 1px dotted #1a6f93; border-radius: 3px;height: 300px;overflow-y:auto" id="expensebudget">
                          
                    <?php
                    
                    
                    $qryq="SELECT * FROM (SELECT expnseaccs.id,expnseaccs.accname,budget_expense.amount,type,expenseactmgnt.deptid,if(year is null,'2017',year) as year FROM expnseaccs LEFT JOIN expenseactmgnt ON  expenseactmgnt.expenseacc = expnseaccs.id LEFT JOIN budget_expense 
                                          ON budget_expense.acct_id = expnseaccs.id )T5 WHERE type = 'E' AND deptid = '25' AND year = '2017' ORDER BY accname "; 
                   // $qr="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id'"; 

                    $data=$mumin->getdbContent($qryq);
                    for($t=0;$t<=count($data)-1;$t++){
                        echo "<label class='blabel'>".$data[$t]['accname']."</label><input value='".number_format($data[$t]['amount'],2)."' class='amount'></input><br style='clear: left;' /><br/>";
                    }
                    ?>
                          <button>Save</button>
                          </div>
                    </div>
            </div>       
<?php
  }
  ?>
      <div id="newcmpny" style="display:none " title="Add New Company">
         
             
          <table class="ordinal">   
              
             
               <tr><td>Company:</td><td><input  type="text"  class="formfield"   id="cname"/> </td></tr> 
              <tr><td></td><td> <button id="addcompny" class="formbuttons">Add Company</button>   
               </td></tr>
         </table>
      </div>
            <div id="newdeprt" style="display:none " title="Add Cost Center">
         
             
          <table class="ordinal">   
              
             
               <tr><td>Cost Center:</td><td><input  type="text"  class="formfield"   id="dname"/> </td></tr> 
              <tr><td></td><td> <button id="addprtmnt" class="formbuttons">Add Cost Center</button>   
               </td></tr>
         </table>
      </div>
            <div id="editcmpny" style="display:none " title="Edit Company">
         
             
          <table class="ordinal">   
              
              <tr><td></td><td><input  type="hidden"  class="formfield" readonly="readonly" id="cnyid"/> </td></tr>
               <tr><td>Company:</td><td><input  type="text"  class="formfield"   id="cnyame"/> </td></tr> 
               <tr><td>Telephone:</td><td><input  type="text"  class="formfield"   id="cnytel"/> </td></tr>
                <tr><td>Email:</td><td><input  type="text"  class="formfield"   id="cnyemail"/> </td></tr>
                <tr><td>Address:</td><td><input  type="text"  class="formfield"   id="cnyaddr"/> </td></tr>
                <tr><td>Status:</td><td><select id="sta" class="formfield"><option value="0">Closed</option><option value="1">Open</option></select> </td></tr>
                             <tr><td></td><td> <button id="editcompny" class="formbuttons">Update</button>   
               </td></tr>
         </table>
      </div>
             <div id="editdeprtmnt" style="display:none " title="Edit Cost Center">
          <table class="ordinal">   
              <tr><td></td><td><input  type="hidden"  class="formfield"   id="dpmntid1" readonly="readonly"/> </td></tr>
               <tr><td>Cost Center:</td><td><input  type="text"  class="formfield"   id="dpmntname"/> </td></tr> 
               <tr><td>Code:</td><td><input  type="text"  class="formfield"   id="dpmntcode" maxlength="5"/> </td></tr> 
                  <tr><td></td><td> <button id="editdeprt" class="formbuttons">Update</button>   
               </td></tr>
         </table>
      </div>
              <div id="linkdeprtmnt" style="display:none " title="Link Cost Center">
         
             
          <table class="ordinal">   
              
              <tr><td></td><td><input  type="hidden"  class="formfield" readonly="readonly" id="dpmntid"/> </td></tr>
              <tr><td>Cost Center:</td><td><input  type="text"  class="formfield"  id="linkdpname" readonly="readonly"/> </td></tr> 
               <tr><td>Company:</td><td><select class="formfield" id="compid">
                      <option selected="true" value="all">--ALL--</option>
                 <?php
                      
                     $jqery="SELECT deptid,deptname FROM department order by deptname ASC  "; 
                         $datay=$mumin->getdbContent($jqery);
    
       
      for($j=0;$j<=count($datay)-1;$j++){    
               
               
       echo "<option value='".$datay[$j]['deptid']."'>".$datay[$j]['deptname']."</option>";
      
             }
             ?>
                  </select> </td></tr> 
                  <tr><td></td><td> <button id="editlinkdeprt" class="formbuttons">Update</button>   
               </td></tr>
         </table>
      </div>
           <div id="permgrant" style="display:none" title="Grant / Deny Access to estate"> 
        
               
    </div>     
      <div id="d_progress" style="display: none;background: transparent;border: none;text-align: center;vertical-align:middle; line-height: 50px;padding-top: 10px">
     <img align="center" src="../assets/images/icon_animated_prog_dkgy_42wx42h.gif"></img>
 </div>      
            
  </div>
 
    
  </div>
</div>
    </div>
  </div>
     </div>

</body>
</html>