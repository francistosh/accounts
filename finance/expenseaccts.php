 <?php
session_start(); 

if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}
/*else{
  
    $level=$_SESSION['acc'];
    
    if($level!=999){
  
        header("location: ../index.php"); 
        
    }
    else{
   
include '../muminoperations/Mumin.php';

$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE id LIKE ".$_SESSION['priviledge']." LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);

if($priviledges[0]['admin']!=1){
   
header("location: index.php");
}
}
}*/ 
 
include '../partials/stylesLinks.php';  
 
include 'links.php';
include './operations/Mumin.php';
$mumin=new Mumin();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head>
<title>finance | Mombasa Jamaat  Information System</title>
    

     
    
<script>
    
    
$(function() {
    

 
        $("#okcancel5").button({
            icons: {
                primary: "ui-icon-check"
            }});
           $("#okdelete5").button({
            icons: {
                primary: "ui-icon-trash"
            }});
        
         
      // DataTable configuration
  $('#sortableaccounts').dataTable( {
	"bSort": false,
	// "sPaginationType": "full_numbers",
	"iDisplayLength": 25,
	"aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
	"bJQueryUI": true
  } );
  
  $(document.body).on('click', '.linkexpense', function() { 
      var $id=$(this).attr("id");
           
           var $cell="cnl"+$id.substring(1);
           var $cm="cgl"+$id.substring(1);
          
            $("#linkexpname").val(document.getElementById($cell).textContent);
            $("#expnactid").val(document.getElementById($cm).textContent);

        basicLargeDialog("#linkexpnseact",400,300);
      
   });
     $(document.body).on('click', '.expenseupdate', function() { 
      var $id=$(this).attr("id");
           
           var $cell="cnl"+$id.substring(2);
           var $cm="cgl"+$id.substring(2);
          var $cde = "ce"+$id.substring(2);
            $("#clinkexpname").val(document.getElementById($cell).textContent);
            $("#cexpnactid").val(document.getElementById($cm).textContent);
            $("#codeid").val(document.getElementById($cde).textContent);
            
        basicLargeDialog("#editexpnseact",400,300);
      
   });
            $("#ceditlinkexpnse").click(function(){
       var $expnactid= $("#cexpnactid").val();
        var $codeid= $("#codeid").val();
               
       $.getJSON("../finance/json_redirect.php?action=updatexpnsecode&expnactid="+$expnactid+"&codeid="+$codeid, function(data) {
        
      
   
     if(data){
         $("#editexpnseact").dialog("destroy");
         alert('Update Successful');
         window.location.reload();
      $.modaldialog.success("<br></br><b>Update successful</b>", {
             width:400,
             showClose: true,
             title:"SUCCESSFULL TRANSACTION"
            });
 
     }
        
    });   
   });
         $("#editlinkexpnse").click(function(){
       var $expnactid= $("#expnactid").val();
        var $ecompid= $("#ecompid").val();
               
       $.getJSON("../finance/json_redirect.php?action=updatexpnselink&expnactid="+$expnactid+"&ecompid="+$ecompid, function(data) {
        
      
   
     if(data){
         $("#linkexpnseact").dialog("destroy");
      $.modaldialog.success("<br></br><b>Expense account Update successful</b>", {
             width:400,
             showClose: true,
             title:"SUCCESSFULL TRANSACTION"
            });
 
     }
        
    });   
   });
   	$("#savexpenses").click(function(){
      
  var $expacctname =$("#expacctname").val();
  var $expestatidname =$("#expestatidname").val();
  var $acctype = $("#expnsetype").val();
     var $dataString={expname:$expacctname,expnsatid:$expestatidname,expenstype:$acctype};
    if($expacctname==="" || $expestatidname ==="" ){
      
               
             $.modaldialog.warning('All Fields Required', {
             width:400,
             showClose: true,
             title:"WARNING"
            });
        
    }
    else{
  ///  alert ("Error!!! Contains Bug");
     
        
      var $urlString="../finance/json_redirect.php?action=savxpnse";

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
         
                $("#expacctname").val("");
                 $("#expestatidname").val("");
             $("#adddebtors").dialog("destroy");
             
             $.modaldialog.success("<br></br><b>Expense Account added successfully</b>", {
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
    });
 
</script>
<style>
    
    
</style>

 <link rel="stylesheet" href="../assets/css/jquery-ui.css" />
</head>
   
<body style="overflow-x: hidden;"> 
  
  <?php
    
  include_once 'header.php';
  ?>
    
           </div>
    
    <!--Right Panel Starts Here-->
    <div id="div_rightpanel">
   	  <div id="div_datainput">
      	<div id="div_formtitle">
        	<h3 class="titletext">Expense Accounts</h3>
        </div>
        <div id="div_formcontainer">
            
        <div id="tabs2">
    <?php
           
           $action =$_GET['action'];
           
           
           if($action==""){
              
               
           }
           
           
                    
           else if($action=="new"){
    
    ?>
    
         <fieldset style="border:1px ghostwhite ridge;color:maroon;width: 750px;font-size: 15px;font-weight: bold">    
       
            <legend>Add new Expense Account</legend>
            
          
          <table class="ordinal"> 
          <tr><td>Account  Name </td><td><input  type="text" id="expacctname" class="formfield"></input></td></tr>            
          <tr><td></td><td><font class="tooltits">e.g land rates,service charge</font></td></tr>
          <tr><td>Company: </td><td><select class="formfield" id="expestatidname">
                      <option selected="true" value="all">--ALL--</option>
                 <?php
                      
                     $jqery="SELECT deptid,deptname FROM department order by deptname ASC"; 
                         $datay=$mumin->getdbContent($jqery);
    
       
      for($j=0;$j<=count($datay)-1;$j++){    
               
               
       echo "<option value='".$datay[$j]['deptid']."'>".$datay[$j]['deptname']."</option>";
      
             }
             ?>
                  </select></td></tr>
          <tr><td>Type: </td><td><select id="expnsetype" class="formfield">
              <?php 
              $typqry = $mumin->getdbContent("SELECT type FROM expnseaccs GROUP BY type");
              for($k=0;$k<=count($typqry)-1;$k++){
                  echo "<option value='".$typqry[$k]['type']."'>".$typqry[$k]['type']."</option>";
              }
              
              ?>
                  </select></td></tr>
          <tr><td></td><td><font class="tooltits">A: Asset , E: Expense Account</font></td></tr>
          <tr><td></td><td><button id="savexpenses" class="formbuttons">Save</button>&nbsp;&nbsp;&nbsp;<button id="caclexpnse" class="formbuttons">Cancel</button>  
               </td></tr>
         </table>
      
     
         </fieldset>   
           
           <?php
           }
           else if($action=="edit"){
          
     
          // $qer="SELECT accname,expnseaccs.id,deptname,if(code = '0','-',code) as code  FROM `expnseaccs`,expenseactmgnt,department WHERE expnseaccs.id = expenseactmgnt.expenseacc AND expenseactmgnt.deptid = department.deptid group by id "; 
           $qer ="SELECT accname,expnseaccs.id,deptname,if(exp_point12 = '0','-',exp_point12) as code,expenseactmgnt.id as exmngid FROM `expnseaccs`,expenseactmgnt,department WHERE expnseaccs.id = expenseactmgnt.expenseacc AND expenseactmgnt.deptid = department.deptid group by exmngid ORDER BY  deptname,accname";
          $data=$mumin->getdbContent($qer);
    
       echo "<fieldset style='border:1px lightgray solid;color:gray;font-size: 15px;font-weight: bold'> "; 
       
       echo "<legend>Listed Expense accounts</legend>";
      
      echo "<table id='sortableaccounts' class='invview' style='margin-top:3px'>"; 
      echo '<thead>';
       echo "<tr style='font-size:12px'><th hidden></th><th>SN</th><th>Names</th><th >Company</th><th >Code</th><th></th>";
      echo '</thead>';
      echo '<tbody>';
      for($j=0;$j<=count($data)-1;$j++){    
               
     echo "<tr style='font-size:12px'><td  id='cgl".$j."' hidden>".$data[$j]['id']."</td><td>".$j."</td><td id='cnl".$j."'>".$data[$j]['accname']."</td><td id='cnl".$j."'>".$data[$j]['deptname']."</td><td id='ce".$j."'>".$data[$j]['code']."</td><td><a id='e".$j."' class='linkexpense' href='#'>Manage</a>&nbsp;|&nbsp; <a id='ex$j' class='expenseupdate' href='#'>Edit</a></td></tr>";
      
             }
      echo '</tbody>';
      echo "</table>";
      echo "</fieldset>";    
           
            
           }
           else if($action=="addsubexpnse"){
               ?>
                                <fieldset style="border:1px ghostwhite ridge;color:maroon;width: 750px;font-size: 15px;font-weight: bold">    
       
            <legend>Add Sub Expense</legend>
            
          
          <table class="ordinal"> 
          <tr><td>Company: </td><td><select class="formfield" id="compnyname">
                      <option selected="true" value="">-- Select --</option>
                 <?php
                      
                     $jqery="SELECT deptid,deptname FROM department order by deptname ASC  "; 
                         $datay=$mumin->getdbContent($jqery);
    
       
      for($j=0;$j<=count($datay)-1;$j++){    
               
               
       echo "<option value='".$datay[$j]['deptid']."'>".$datay[$j]['deptname']."</option>";
      
             }
             ?>
                  </select></td></tr>
                        <tr><td>Expense Account: </td><td><select class="formfield" id="expnseacount">
                     
                  </select></td></tr>
          <tr><td>Sub Account </td><td><input  type="text" id="expensesubacct" class="formfield"></input></td></tr>            
          <tr><td></td><td><font class="tooltits">e.g House Sabil</font></td></tr>

          <tr><td></td><td><button id="savsbexpnseincome" class="formbuttons">Save</button>&nbsp;&nbsp;&nbsp;<button id="caclincome" class="formbuttons">Cancel</button>  
               </td></tr>
         </table>
      
     
         </fieldset> 
            <?php
           }
           ?>
             
 <div id="d_progress" style="display: none;background: transparent;border: none;text-align: center;vertical-align:middle; line-height: 50px;padding-top: 10px">
 <img align="center" src="../assets/images/icon_animated_prog_dkgy_42wx42h.gif"></img>
 </div> 
                          <div id="linkexpnseact" style="display:none " title="Link Expense">
         
             
          <table class="ordinal">   
              
              <tr><td></td><td><input  type="hidden"  class="formfield" readonly="readonly" id="expnactid"/> </td></tr>
              <tr><td>Expense Acct:</td><td><input  type="text"  class="formfield"  id="linkexpname" readonly="readonly"/> </td></tr> 
               <tr><td>Company:</td><td><select class="formfield" id="ecompid">
                      <option selected="true" value="all">--ALL--</option>
                 <?php
                      
                     $jqery="SELECT deptid,deptname FROM department order by deptname ASC  "; 
                         $datay=$mumin->getdbContent($jqery);
    
       
      for($j=0;$j<=count($datay)-1;$j++){    
               
               
       echo "<option value='".$datay[$j]['deptid']."'>".$datay[$j]['deptname']."</option>";
      
             }
             ?>
                  </select> </td></tr> 
                  <tr><td></td><td> <button id="editlinkexpnse" class="formbuttons">Update</button>   
               </td></tr>
         </table>
      </div>
            <div id="editexpnseact" style="display:none " title="Link Expense">
         
             
          <table class="ordinal">   
              
              <tr><td></td><td><input  type="hidden"  class="formfield" readonly="readonly" id="cexpnactid"/> </td></tr>
              <tr><td>Expense Acct:</td><td><input  type="text"  class="formfield"  id="clinkexpname" readonly="readonly"/> </td></tr> 
              <tr><td>Department:</td><td><input  type="text"  class="formfield"  id="departmentid" maxlength="5" /> </td></tr> 
              <tr><td>Code:</td><td><input  type="text"  class="formfield"  id="codeid" maxlength="5" /> </td></tr> 
              <tr><td></td><td> <button id="ceditlinkexpnse" class="formbuttons">Update</button>   
               </td></tr>
         </table>
      </div>
  </div>
      
      
      
      
      
    
      
  </div>
           </div>   
    
    </div>
    </div><?php include 'footer.php' ?> 
</div>
<?php include './dropdown.php';?>
</body>
</html> 