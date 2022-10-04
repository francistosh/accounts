 <?php
session_start(); 

if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}

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
    $("#fromdte" ).datepicker({ dateFormat: 'yy-mm-dd'} );
	$("#todte" ).datepicker({ dateFormat: 'yy-mm-dd'} );
 $("#balancesearch").live('click',function(){
			var sabilno = $("#generalsabilno").val();
			var $fromdate=$("#fromdte").val();
          var $todte=$("#todte").val();
		  var incacc = $("#generalincacc").val();
		  
			if (sabilno == ""){
			$.modaldialog.warning('<br></br><b>Empty Field not allowed</b>', {
             timeout: 3,
             width:500,
             showClose: true,
             title:'Warning'
            });
			} else{
				
         
        window.open('../finance/generalrpts.php?action=muminbalances&sdate='+$fromdate+'&edate='+$todte+'&incacc='+incacc+'&sabilno='+sabilno,'','width=1300,height=800,toolbar=0,menubar=1,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
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
        	<h3 class="titletext">General Reports</h3>
        </div>
        <div id="div_formcontainer">
            
        <div id="tabs2">
    <?php
           
           $action =$_GET['action'];
           
           
                    
           
                    
         if($action=="new" || $action=="" ){
    
    ?>
    
         <fieldset style="border:1px ghostwhite ridge;color:maroon;width: 750px;font-size: 15px;font-weight: bold">    
       
            <legend>Mumin Balances</legend>
            
			<form method="post" action="">
            <table id="" class="ordinal">  
                               <tr>                    
                    <td style="border: none">Sabil No:</td>
                     </tr><tr>
                    <td style="border: none"><input type="text" id="generalsabilno" name="generalsabilno" class="formfield" value='<?php if(isset($_POST['generalincacc'])){ echo $_POST['generalsabilno']; }?>'> </input></td>
                    <td style="border: none">
                        <select class="formfield" id="generalincacc" onchange="this.form.submit()" name="generalincacc">
                          <option selected value = ''>--All--</option>
                                                      <?php
                                $qr5="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' ORDER BY accname "; 
    
                                $data5=$mumin->getdbContent($qr5);
                                                            
                                 for($h=0;$h<=count($data5)-1;$h++){
                      
                                     echo "<option value=".$data5[$h]['incacc'].">".$data5[$h]['accname']."</option>";
                                     
                                   } 
                            
                            ?>
                      </select></td> 
                    
                    <td style="border: none"> <input type="text" id="incmeid" name="incmeid" class="formfield" hidden="true" value='<?php if(isset($_POST['ovrpymntincacc']))   {  echo $_POST['ovrpymntincacc']; }?>'> </input></td><td></td>

                </tr>
				<tr><td>From Date: </td><td>To Date: </td></tr>
				<tr><td><input type="text" id="fromdte" name="fromdte" class="formfield" value="<?php echo date('d-m-Y'); ?>"> </input></td><td><input type="text" id="todte" name="todte" class="formfield" value="<?php echo date('d-m-Y'); ?>"> </input></td></tr>
				<tr><td><button name="balancesearch" id="balancesearch" > Search </button></td>
				
				</tr>
                 
        </table>
			</form>
     
         </fieldset>   
           
           <?php
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