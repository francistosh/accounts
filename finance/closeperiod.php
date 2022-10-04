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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head>
<title>finance | Mombasa Jamaat  Information System</title>
    
 
<?php
 
   
 
include '../partials/stylesLinks.php';  
 
include 'links.php';



?>
     
    
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
  
  $("#clsingdate" ).datepicker({ dateFormat: 'yy-mm-dd'} );
  
   $("#saveclsing" ).click(function(){
  
   var $clsingdate = $("#clsingdate").val();
  var $clsingestatid=$("#clsingestatid").val();
     
  if($clsingdate==="" || $clsingestatid ==="" ){
      
               
             $.modaldialog.warning('All Fields Required', {
             width:400,
             showClose: true,
             title:"WARNING"
            });
        
    }else{

     var $dataString={cdate:$clsingdate,esatid:$clsingestatid};
        
      var $urlString="../finance/json_redirect.php?action=savclosingdate";

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
         
                $("#clsingdate").val("");
                 $("#clsingestatid").val("");
             $("#adddebtors").dialog("destroy");
             
             $.modaldialog.success("<br></br><b>Closing successfull</>", {
             width:400,
             showClose: true,
             title:"Data Entry Sucess"
            });
                 }
             else{
              
             $("#d_progress").dialog("destroy");
                 
                         $.modaldialog.warning('Information not saved-please try again later', {
             width:400,
             showClose: true,
             title:"WARNING"
            });
              
                    
             }
                },
              error:function (xhr, ajaxOptions, thrownError){
                
               $("#d_progress").dialog("destroy");
                  
             $.modaldialog.warning('Information not saved-please try again later', {
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
<link rel='stylesheet' type='text/css' href='properties/js/print.css' media="print" />
 
</head>
   
<body style="overflow-x: hidden;"> 
  
  <?php
  
  include 'operations/Mumin.php';

  $mumin=new Mumin();
   
  include_once 'header.php';
  ?>
  
 
    
     
        </div>
    
    <!--Right Panel Starts Here-->
    <div id="div_rightpanel">
   	  <div id="div_datainput">
      	<div id="div_formtitle">
        	<h3 class="titletext">Close Period</h3>
        </div>
        <div id="div_formcontainer">
            
        <div id="tabs2">
    <?php
           
           $action =$_GET['action'];
           
           
                    
           
                    
         if($action=="new" || $action=="" ){
    
    ?>
    
         <fieldset style="border:1px ghostwhite ridge;color:maroon;width: 750px;font-size: 15px;font-weight: bold">    
       
            <legend>Close Period</legend>
            
          
          <table class="ordinal"> 
          <tr><td>Closing Date: </td><td><input id="clsingdate" name="clsingdate"   class="formfield" value="<?php echo date('d-m-Y');?>"/></td></tr>            
          <tr><td></td><td><font class="tooltits"></font></td></tr>
          <tr><td>Department: </td><td><select class="formfield" id="clsingestatid">
                      <option selected="true" value="all">--ALL--</option>
                 <?php
                      
                     $jqery="SELECT deptid,deptname FROM department order by deptname ASC  "; 
                         $datay=$mumin->getdbContent($jqery);
    
       
      for($j=0;$j<=count($datay)-1;$j++){    
               
               
       echo "<option value='".$datay[$j]['deptid']."'>".$datay[$j]['deptname']."</option>";
      
             }
             ?>
                  </select></td></tr>
          <tr><td></td><td><button id="saveclsing" class="formbuttons">Save</button>&nbsp;&nbsp;&nbsp;<button id="caclexpnse" class="formbuttons">Cancel</button>  
               </td></tr>
         </table>
      
     
         </fieldset>   
           
           <?php
           }
           else if($action=="edit"){
          
     
           $qer="SELECT * FROM estate_expaccs"; 
      
          $data=$mumin->getdbContent($qer);
    
       echo "<fieldset style='border:1px lightgray solid;color:gray;font-size: 15px;font-weight: bold'> "; 
       
       echo "<legend>Listed Expense accounts</legend>";
      
      echo "<table id='sortableaccounts' class='invview' style='margin-top:3px'>"; 
      echo '<thead>';
       echo "<tr><th>SN</th><th>Names</th><th style='font-size:10px'>Owner Estate</th>";
      echo '</thead>';
      echo '<tbody>';
      for($j=0;$j<=count($data)-1;$j++){    
               
               
     echo "<tr><td  id='cgl".$j."'>".$data[$j]['id']."</td><td id='cnl".$j."'>".$data[$j]['accname']."</td><td id='cnl".$j."'></td></tr>";
      
             }
      echo '</tbody>';
      echo "</table>";
      echo "</fieldset>";    
           
            
           }
           ?>
             
 <div id="d_progress" style="display: none;background: transparent;border: none;text-align: center;vertical-align:middle; line-height: 50px;padding-top: 10px">
 <img align="center" src="../assets/images/icon_animated_prog_dkgy_42wx42h.gif"></img>
 </div> 
  </div>
      
      
      
      
      
    
      
  </div>
    
   
    
    
      
    
    
          </div>   
    
    </div>
    </div>
    <?php include 'footer.php' ?> 
</div>
<?php include './dropdown.php';?>
</body>
</html> 