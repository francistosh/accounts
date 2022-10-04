  <?php
session_start();  
 
if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  
    $level=$_SESSION['jmsacc'];
    
    $id=$_SESSION['dept_id'];
//die($id);
    $userid = $_SESSION['acctusrid'];
    if($level>999){
  
        header("location: ../index.php"); 
        
    }
    else{
   
include 'operations/Mumin.php';

$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE userid = '$userid' AND deptid = '$id' LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);
if($priviledges[0]['receipts']!=1){
   
header("location: index.php");
}
if($priviledges[0]['readonly']==1){
    $displ = '';
     $rcptsearch = '';
     $recpsearch = '';
     $pdsubmit = '';
}else if($priviledges[0]['readonly']!=1){
    $displ = '<button id="ckreceipt">complete</button>';
    $pdsubmit = '<button id="pdsubmit">Submit</button>';
    $rcptsearch = '<button name="rcptsearch" id="rcptsearch"> Search</button>';
    $recpsearch = '<button name="recpsearch" id="recpsearch"> Search</button>';
}
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head>
<title>PDs | Jamaat  Information System</title>
    
 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';
 

?>
     
<script>
    
    
$(function() {
   $("#pdchqbank").click(function(){
      $("#rep_pdchqs").show();
      $("#modfy_pdchqs").hide();
       $("#accounteditpd").hide();
   });
      $("#modfypdchq").click(function(){
      $("#rep_pdchqs").hide();
      $("#modfy_pdchqs").show();
    $("#maturedchqrslts").hide();
     $("#accounteditpd").hide();
   });
   $('#editsupp').dataTable( {
	"bSort":false,
	// "sPaginationType": "full_numbers",
	"iDisplayLength": 25,
	"aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
	"bJQueryUI": true
  } );
  	$( "#dialog-message" ).dialog({
			modal: true,
			width: 400,
			buttons: {
				Ok: function() {
				window.location.replace("pdcheqs_operation.php");
				}
		}
});
$( "#from_date" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#to_date" ).datepicker( "option", "minDate", selectedDate );
}
});
$( "#to_date" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#from_date" ).datepicker( "option", "maxDate", selectedDate );
}
});
$('#pdcheqs').submit(function(){
    if($('input[type="checkbox"]:checked').length == 0) {
       alert('Please select at least one PD Cheque before submitting');  
      return false;	   
    }		
});
    });

</script>

<style type="text/css">
.menuitems a:link {
	text-decoration:none;
	color:#333;
	font-size:11px;
        padding:10px 5px 10px 5px;
	}
	
 
  .menuitems li:hover {
	 background: #357918;
         color: #FFF;
         border-radius: 3px;
         line-height: 30px;
         
	}
        .menuitems li a:hover{
            color: white;
        }
.menuitems a:visited {
	text-decoration:none;
	color:#333;
	
	}
        label 
{
width: 200px;
padding-left: 20px;
margin: 5px;
float: left;
text-align: left;
}
        
	</style>

 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
 
</head>
   
<body> 
  
    <?php

                                $id=$_SESSION['dept_id'];
                                
                                $qr11="SELECT deptname FROM department WHERE deptid LIKE '$id' LIMIT 1";
                               
                                 $data11=$mumin->getdbContent($qr11);
                                
                                 $estname=$data11[0]['deptname'];
    ?>
   
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
  	<div id="div_logindetails" ><div>You are logged in as: <?php echo $_SESSION['jname'];?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp</span></div>
      <span style="text-align: right;display:block">Company: <b><?php echo $_SESSION['dptname'];?></b></span>
      </div>
    <!--Left Panel Starts Here-->
    <div id="div_leftpanel">
 
      <?php include_once 'leftmenu.php'; ?>
  
    </div>
    <!--Right Panel Starts Here-->
    <div id="div_rightpanel">
         <?php include_once 'topmenu.php'; ?>
   	  <div id="div_datainput">
      	<div id="div_formtitle">
        	<h3 class="titletext"></h3>

        </div>
        <div id="div_formcontainer">
        	<div id="tabs2">
    <?php 
     
     $type=@$_GET['type'];
     
     
     if($type==""){
         ?>
                    <button id="pdchqbank">PD Cheques Banking</button>
                    <button id="modfypdchq">Modify PD Cheques</button>
                    
    <?php
     }
         ?>
              
  
</div>
            <div id="rep_pdchqs" style="display:none">
            <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic;font-size: 12px">Select PD Cheques to Bank</legend>
            <form method="post" name="rep_pdchqs"  action="">
                <div>
<label for="date1">Enter Start Date:</label>
<input name="from_date" id="from_date" class="datepicker formfield" type="text" size="50" value="<?php echo date("d-m-Y"); ?>" required="required" /><br /><br />

<label for="date2">Enter End Date:</label>
<input name="to_date" id="to_date" class="datepicker formfield" type="text" size="50" value="<?php echo date("d-m-Y"); ?>" required="required" /><br /><br />

</div>

<br /> 
<input class="submitbutton" name="view_jimsreport" type="submit" value="Get PD Cheques"/>  
</form>   </fieldset>

                </div>
           <div id="modfy_pdchqs" style="display:none">
                <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic;font-size: 12px">Select PD Cheques to Bank</legend>
                            <form method="post" name="modfy_pdchqs"  action="">
                <div>
<label for="s_number">Sabil No:</label>
<input name="sabilactno" id="sabilactno" class="formfield" type="text" size="50" required="required" /><br /><br />
</div>

<br /> 
<input class="submitbutton" name="view_editpdchqs" id="view_editpdchqs"  type="submit" value="Get PD Cheques"/>  
                            </form> </fieldset>
           </div>
            <?php 
              if (isset($_POST['view_jimsreport'])){
                  $startdate = date('Y-m-d',strtotime($_POST['from_date']));
                  $todate =  date('Y-m-d',strtotime($_POST['to_date']));
                  $qrpds=$mumin->getdbContent("SELECT * FROM pdchqs WHERE rdate BETWEEN '$startdate' AND '$todate' AND est_id = '$id' AND banked = '0'");
                 if(count($qrpds) == 0)
{
    die('<div id="dialog-message" title="PD Cheques for Banking!">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:4px 5px 50px 0;"></span>
	<b>Sorry, there are no PD cheques ready to be banked. </b></p></div>');
}
                  ?>
            <div id="maturedchqrslts" >
            <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic;font-size: 14px">Matured PD Cheques</legend>
         <form method="post" name="pdcheqs" id="pdcheqs" action="postpdcheqs.php">
                <table id='editsupp' style="width:100%;"> 
            <thead>
       <tr><th hidden></th><th>No</th><th>Date</th><th>Sabil No</th><th>Names</th><th>Chq No</th><th>Bank</th><th>Account</th><th>Amount</th><th>Select</th></tr>
            </thead>
      <tbody>
      
            <?php
            $t=1;
      for($k=0;$k<=count($qrpds)-1;$k++){    
             $name = $mumin->get_MuminHofNamesFromSabilno($qrpds[$k]['sabilno']);
             $incmactnme = $mumin->getincmename($qrpds[$k]['incacc']);   
     echo "<tr><td hidden='true' id='incmact".$k."'>".$qrpds[$k]['incacc']."</td><td>".$qrpds[$k]['recpno']."</td><td  id='cgl".$k."'>".$qrpds[$k]['rdate']."</td><td id='pdsablno".$k."'>".$qrpds[$k]['sabilno']."</td><td id='cnl".$k."'>".$name."</td><td id='ctl".$k."'>".$qrpds[$k]['chqno']."</td><td id='cml".$k."' >".$qrpds[$k]['chqdet']."</td><td>".$incmactnme."</td><td id='cpdamnt".$k."' style='text-align:right'>".number_format($qrpds[$k]['amount'],2)."</td><td><input type='checkbox' class='selectpdchq' name='chqtobank[]' id='chqtobank".$k."' value='".$qrpds[$k]['tno']."'></input></td></tr>";
           // <a id='v".$j."' class='changedelete5' href='#'>Delete</a>
             }?>
      </tbody>
      </table><br></br>
      <input class="formbuttons" name="bankslctdpds" id="bankslctdpds" type="submit" value="< Receipt Selected Cheque >"/>  
                </form>
            </fieldset>
                </div>
            <table id="invoicesstable2" class="ordinal" style="width: 100%"></table>  
           <?php  
          // $r=$mumin->getdbContent("SELECT invno,DATE_FORMAT(idate,'%d-%m-%Y') as idate,IF(isinvce=1,amount,-1*amount)as amount,accname,e.incacc as incacc ,sabilno,pdamount,(amount-pdamount)as balnce FROM  invoice e JOIN incomeaccounts a ON  e.incacc =a.incacc WHERE e.estId LIKE '$est_id' AND e.dno LIKE '$debtor'  AND e.pdamount<e.amount AND e.incacc = '$incomeaccount' ORDER BY opb desc,DATE(idate)");
         //  for($t=0;$t<=count($r);$t++){}
           
      } else if (isset($_POST['view_editpdchqs'])){
          $sabilactno = $_POST['sabilactno'];
           $qrps=$mumin->getdbContent("SELECT * FROM pdchqs WHERE sabilno = '$sabilactno' AND  banked = '0' AND est_id = '$id'");
                 if(count($qrps) == 0)
{
    die('<div id="dialog-message" title="PD Cheques for Banking!">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:4px 5px 50px 0;"></span>
	<b>Sorry, there are no PD cheques for '.$sabilactno.' </b></p></div>');
          
      }
      ?>    
            <div id="accounteditpd">
             <table id='editsupp' style="width:100%;"> 
            <thead>
                <tr><th hidden></th><th>No</th><th style="width: 40px">Date</th><th>Sabil</th><th>Names</th><th>Chq No</th><th>Bank</th><th>Account</th><th>Amount</th><th style="width: 130px">Select</th></tr>
            </thead>
      <tbody>
      
            <?php
            $t=1;
      for($p=0;$p<=count($qrps)-1;$p++){    
             $name = $mumin->get_MuminHofNamesFromSabilno($qrps[$p]['sabilno']);
             $incmactnme = $mumin->getincmename($qrps[$p]['incacc']);   
     echo "<tr><td hidden='true' id='incmact".$p."'>".$qrps[$p]['incacc']."</td><td>".$qrps[$p]['recpno']."</td><td  id='pd_date".$p."'>".$qrps[$p]['rdate']."</td><td id='pdsablno".$p."'>".$qrps[$p]['sabilno']."</td><td id='pdname".$p."'>".$name."</td><td id='pdchqno".$p."'>".$qrps[$p]['chqno']."</td><td id='pdchqdetails".$p."' >".$qrps[$p]['chqdet']."</td><td>".$incmactnme."</td><td id='cpdamnt".$p."' style='text-align: right'>".number_format($qrps[$p]['amount'],2)."</td><td><a id='editpd".$p."' class='activatelink' href='#'><b>Edit |</b></a><a id='rmve".$p."' class='linkremove' href='#'><b> Remove</b></a><input type='text' hidden='true' id='tno".$p."' value='".$qrps[$p]['tno']."'></input></td></tr>";
           // <a id='v".$j."' class='changedelete5' href='#'>Delete</a>
             }?>
      </tbody>
      </table></div>
      <?php
}
            ?>
            <div id="changepdchq" style="display:none " title="Edit PD Cheque Info">
  
          <table class="ordinal">   
              
              <tr><td></td><td><input  type="hidden"  class="formfield" readonly="readonly" id="cgid"/> </td></tr>
               <tr><td>Date:</td><td><input  type="text"  class="formfield" id="pdeditdate"/> </td></tr> 
               <tr><td>Sabil No:</td><td><input  type="text"  class="formfield" id="pdeditsabilno" disabled/> </td></tr>
            <tr><td>Names:</td><td><input  type="text"  class="formfield" id="pdeditname" disabled/> </td></tr>
             <tr><td>Chq No:</td><td><input  type="text"  class="formfield" id="pdeditchqno"/> </td></tr>
             <tr><td>Bank:</td><td><input  type="text"  class="formfield" id="pdeditbank"/> </td></tr>
             <tr><td>Account:</td><td><select  class="formfield" id="pdeditacct" disabled="true" disabled>
                      <option value="" selected>--Select Supplier--</option>
                      <?php
                      
                      $qr="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id' GROUP BY incomeaccounts.incacc ORDER BY accname asc"; 
                                
                                $data=$mumin->getdbContent($qr);
                                
                                 for($h=0;$h<=count($data)-1;$h++){
                      
                                     echo "<option value=".$data[$h]['incacc'].">".$data[$h]['accname']."</option>";
                                   } 
                      ?>
                      
                  </select> 
               </td></tr>
              <tr><td>Amount:</td><td><input  type="text"  class="formfield" id="pdeditamnt" disabled/> </td></tr>
              <tr><td></td><td> <button  class="formbuttons"  id="editpdch">Save Changes</button>   
               </td></tr>
         </table>
      </div>
           </div>
        </div>
        
      </div>

    </div>
    <!--Right Panel Ends Here-->
     <?php include 'footer.php' ?>  
  </div>
           <script>
$('.arrow').addClass('collapsed');

$('#menu-primary-navigation > li > a.arrow').click(function(e) {  // select only the child link and not all links, this prevents sub links from being selected. 
    var sub_menu = $(this).next('.sub-menu'); // store the current submenu to be toggled  
    e.preventDefault();
    $('.sub-menu:visible').not(sub_menu).slideToggle('fast'); // select all visible sub menus excluding the current one that was clicked on and close them 
    sub_menu.slideToggle('fast'); // toggle the current sub menu 
	
    $("li a.arrow").addClass('collapsed');  // Add the collapse class to the clicked a	 
    $(this).removeClass('collapsed').addClass('expanded');    //Remove the collapse class from only the clicked tag
});
</script>  
</body>
</html>