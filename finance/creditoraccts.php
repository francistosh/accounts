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
if($priviledges[0]['payments']!=1){
   
header("location: index.php");
}
if($priviledges[0]['readonly']==1){
    $appndbutn = '';
     
}else if($priviledges[0]['readonly']!=1){
    $appndbutn = '<input  type="submit" id="appndbutn" value="Append" class="formfield" style="width: 100px; font-weight: bold"></input>';
   
   }
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mombasa Jamaat Mumineen </title>
 
<?php include '../partials/stylesLinks.php';   include 'links.php'; ?>
 <script>
    $(function() {
     
     
     var costcentrs=[];
      // DataTable configuration
    $('#editsupp').dataTable( {
	"bSort": false,
	// "sPaginationType": "full_numbers",
	"iDisplayLength": 25,
	"aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
	"bJQueryUI": true
  } );
     // DataTable configuration
        // DataTable configuration
          $("#cancl1").button({
            icons: {
                primary: "ui-icon-close"
                 
            }
        });
        
   
        $("#gnrt").button({
            icons: {
                primary: "ui-icon-check",
                secondary: "ui-icon-gear" 
            }
        });
        
        $("#creditgnrt").button({
            icons: {
                primary: "ui-icon-check",
                secondary: "ui-icon-gear" 
            }
        });
        
          $("#myinvoiceprint").button({
            icons: {
                 
                secondary: "ui-icon-print" 
            }
        });
        $("#billslist1 ").button({
            icons: {
                 
                secondary: "ui-icon-print" 
            }
        });
 
   
  $("#billdate" ).datepicker({ dateFormat: 'dd-mm-yy'} );
  
   $("#invsdate" ).datepicker({ dateFormat: 'dd-mm-yy'} );
      
   
    $("#invdt" ).datepicker({ dateFormat: 'dd-mm-yy'} );
    
    $("#balancedt" ).datepicker({ dateFormat: 'dd-mm-yy'} );


  
  
           $( "#supprint" ).button({
            icons: {
                primary: "ui-icon-print"
            },
            text: false
             }).click(function(){
            
            var newWin= window.open("");
            newWin.document.write(document.getElementById("editsupp").outerHTML);
            newWin.print();
            newWin.close();
          return false; 
 
       });
       
        $("#okcancel").button({
            icons: {
                primary: "ui-icon-check"
            }});
           $("#okdelete2").button({
            icons: {
                primary: "ui-icon-trash"
            }});
 
          $("#supplierstatements").live('click',function(){
       if($("#dprtmntchk").is(':checked')){
          
           if($("#cctr").val()===""){
               $("#cctrid").val("all");
           }
           window.open('suppstatement.php?startdate='+$("#ssstart").val()+'&enddate='+$("#ssend").val()+'&supplier='+$("#supplierId").val()+'&expnseacct='+$("#cctrid").val()+'&type=1','width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
 
       }else if($("#expechk").is(':checked')){
           window.open('suppstatement.php?startdate='+$("#ssstart").val()+'&enddate='+$("#ssend").val()+'&supplier='+$("#supplierId").val()+'&expnseacct='+$("#expnacc").val()+'&type=2','width=1300,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
 
       }
                  });

       $("#supplisummary").click(function(){
       
       
       
         window.open('suppsummary.php?fromdate='+$("#summarystart").val()+'&enddate='+$("#summaryend").val()+'','width=600,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
   });
       $( "#ssstart" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#ssend" ).datepicker( "option", "minDate", selectedDate );
}
});


       $( "#summarystart" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#summaryend" ).datepicker( "option", "minDate", selectedDate );
}
});

$( "#ssend" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#ssstart" ).datepicker( "option", "maxDate", selectedDate );
} });
 $( "#summaryend" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#summarystart" ).datepicker( "option", "maxDate", selectedDate );
} });

     $.getJSON("../finance/redirect.php?action=costc", function(data) {
   
    $.each(data, function(i,item) {
       
    costcentrs.push({label: item.centrename,value: item.cntrid});  
        
      
  
       $("#cctr" ).autocomplete({
            source: costcentrs,
         //   minLength: 1,
            focus: function(event, ui ) {
             event.preventDefault();
            $(this).val(ui.item.label);
        },
            select: function(event, ui) {
	event.preventDefault();
	$(this).val(ui.item.label);
         $("#cctrid").val(ui.item.value);
				}
        
     
  });
     }); 
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
         color: white;
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
	</style>
   

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

<!--<link rel="stylesheet" href="../themes/smoothness/jquery-ui.css" />!-->
 
 
 
	 
    
</head>

<body>
<div id="div_pagecontainer">
    <div id="div_pageheader">
  	<div id="div_orglogo"><img src="../assets/images/smallhomegoldlogo.png" width="80" height="84" alt="Mombasa Jamaat Home"/></div>
    <div id="div_orgname">
    	<h1 class="titletext"> </h1>
    </div>
    <div id="div_currentlocation">
    	<h2 class="titletext"></h2>
    </div>
  </div>
  <div id="div_pagecontent">
  	<div id="div_logindetails" ><div>You are logged in as: <?php echo $_SESSION['jname'];?></div>
     <span style="text-align: right;display:block">Company: <b><?php echo $_SESSION['dptname'];?></b></span>      </div>
    <!--Left Panel Starts Here-->
    <div id="div_leftpanel">
        <?php include_once 'leftmenu.php'; ?>      
    </div>
    <!--Right Panel Starts Here-->
    <div id="div_rightpanel">
         <?php include_once 'topmenu.php'; ?>
   	  <div id="div_datainput">
      	
        <div id="div_formcontainer">
        	<div id="tabs2">

 

  
      
          
         <?php
         
         $acti=$_GET['idaction'];
         
        
                   
          if($acti==""){
           ?>   
              
         <?php
          }
          else if($acti=="print"){
            
          
          ?>
          
           <form method="post" action="#">
            <table id="" class="ordinal">  
                
                <tr> 
                    
                    
                    <td style="border: none">Invoice Number:</td>
                     
                    <td style="border: none"><input type="text" value="<?php if(isset($_POST['invsubmit']))   {  echo $_POST['invnos']; }?>" id="invnos" name="invnos" class="formfield"> </input></td>
                    
                    
                    <td style="border: none"><input type="submit" class="formbuttons" value="submit" name="invsubmit" ></input></td>
                    <td style="border: none"> </td><td></td>

                </tr>
                 
        </table> 
        </form>  
              
              
              
         
          <?php
          }
          
          
          else if($acti=="modify"){
          ?>
          
          
          <form method="post" action="">
            <table id="" class="ordinal">  
                
                <tr> 
                    
                    
                    <td style="border: none">Invoice Number:</td>
                     
                    <td style="border: none"><input type="text"  value="<?php if(isset($_POST['invnumbersubmit'])){echo $_POST['invnumber'];} ?>" id="invnos" name="invnumber" class="formfield"></input></td>
                    
                    
                    <td style="border: none"><input type="submit" class="formbuttons" value="submit" name="invnumbersubmit" ></input></td>
                    <td style="border: none"> </td>
                    
                    <tr style="border: none"><td style="border: none"> </td><td style="border: none"><font class="tooltits">Enter number then press SUBMIT</font></td></tr>  
                    
                       
                    
                    
                    
                </tr>
                 
        </table> 
                     </form>
             
         
          <?php
          }
          
                 
          
       if($acti=="print"){
           
         } 
          
          if(isset($_POST['invsubmit'])){         
              
              $invnos=trim(strip_tags(stripslashes($_POST['invnos'])));
              if ($invnos==''){
                  echo "<span style='color:red;'><br>&nbsp&nbsp&nbspInsert invoice Number</span>";
              }
              else{
              $q="SELECT * FROM  estate_invoice WHERE invno LIKE '$invnos' AND estId LIKE '$id' AND isinvce = '1' LIMIT 1";
              
              $data=$mumin->getdbContent($q);
              
              if($data){
              $qry2 = "SELECT accname FROM estate_incomeaccounts where id = ".$data[0]['incacc']." and estateid = '$id'";
              $data2=$mumin->getdbContent($qry2);
              
              if($data[0]['dno'] =='0'){
                  
                  $dispname=$mumin->get_MuminHofNamesFromSabilno($data[0]['sabilno']); 
              }
              else if($data[0]['dno'] !=='0'){
                 
                  $d=$mumin->getdbContent("SELECT debtorname,debTelephone,city FROM estate_debtors WHERE dno = ".$data[0]['dno']." AND estId LIKE '$id'");
                  
                  $dispname=$d[0]['debtorname'];
                  $debtel = $d[0]['debTelephone'];
                  $city = $d[0]['city'];
              }
              
              echo "<script>window.location='invoicepreview.php?paymentdate=".$data[0]['idate']."&remarks=".$data[0]['rmks']."&amount=".$data[0]['amount'].".00&sabilno=".$data[0]['sabilno']."&docno=".$data[0]['invno']."&debtor=".$data[0]['debtor']."&acctname=".$data2[0]['accname']."&dispname=".$dispname."&tel=".$debtel."&city=".$city."';</script>";
              }
              else{
                
                  echo "<script>alert('Invoice not found')</script>";
              }
              }
          }
        
           
        
         
         else if(isset($_POST['invnumbersubmit'])){
          
             $number=  $_POST['invnumber'];
             
             $qwr="SELECT * FROM estate_invoice WHERE invno LIKE '$number' AND estId LIKE '$id' LIMIT 1"; 
             
             $data= $mumin->getdbContent($qwr);
            
            if(!$data){
                
               echo "<script>alert('Invoice not found!')</script>" ;
            }
        else{
         
         ?>
                 <form method="post" action="">
	  <table class="ordinal" >        
              <tr><td>Invoice No:</td><td><input value="<?php echo $data[0]['invno']?>" id="invsno" name="invsno" readonly="readonly"   type="text" class="formfield"></input>
                     
               </td></tr>  
          
           <tr><td>Invoice Date:</td><td><input value="<?php echo $data[0]['idate']?>" id="invsdate"   name="invsdate"  type="text" class="formfield"></input>
                     
             </td></tr>
          
              <tr><td>Amount:</td><td><input readonly="readonly" name="invsamount" type="text" value="<?php echo $data[0]['amount']?>" class="formfield"/></td></tr>  
          
          <tr><td>Credit:</td><td>
                  <select id="toaccs" class="formfield" name="toaccs">
              
              <?php
                      
                      $qrs1="SELECT * FROM estate_incomeaccounts WHERE estateid LIKE '$id' ";
                      
                      $datas1=$mumin->getdbContent($qrs1);
                      
                      
                       echo "<option value='ALL'>ALL</option>";
                    
                      
                      for($k=0;$k<=count($datas1)-1;$k++){
                          
                        
                          
                          
                          
                               echo '<option value="'.$datas1[$k]['id'].'"';
                               if($datas1[$k]['id'] == $data[0]['incacc']) echo 'SELECTED';
                              echo '>' .$datas1[$k]['accname'].'</option>';   
                      }
                      ?>                   
              
              
                  </select></td></tr>  
          
          <tr><td></td><td><input type="submit" name="invoicechange" class="buttons" value="Update"></input></td></tr>
           
          </table></form>
               <?php
         }
         }
         
                    
              if($acti=="supstatement"){
                 ?>
            
             <fieldset style="border: 1px burlywood solid;margin-top: 30px"><legend style="color: black;font-size: 14px;font-weight: normal">Generate Supplier Statement</legend>
                 <table class="ordinal" >
                     <tr style="text-align:right"><td colspan="4" ><input type="radio" name="stmntype" value="costcenter" id="dprtmntchk" checked="true">&nbsp&nbsp&nbsp&nbspCost Center&nbsp&nbsp&nbsp&nbsp</input>
                         <input type="radio" name="stmntype" value="expense" id="expechk">&nbsp&nbsp&nbsp&nbspExpense&nbsp&nbsp&nbsp&nbsp</input>
                         </td></tr>
                     <tr><td>Supplier :</td><td><select id="supplierId" name="supplierId" class="formfield">
                            
                              <?php
                              
                                $qrf="SELECT * FROM suppliers WHERE estId LIKE '$id' ORDER BY suppName asc"; 
                                
                                $data=$mumin->getdbContent($qrf);
                                
                                for($h=0;$h<=count($data)-1;$h++){
                      
                                     echo "<option value=".$data[$h]['supplier'].">".$data[$h]['suppName']."</option>";
                                     
                                   }
                            
                            ?>
                            
                             </select></td><td id="tdeprtmnt">&nbsp;Cost Center :</td><td id="tdexpnse" style="display: none">&nbsp;Account :</td><td>
                                 <select id="expnacc" class="formfield" hidden="true">
                      <option value="all" selected>--Expense Account--</option>
                     <?php
                      
                      $qry="SELECT expnseaccs.id,expnseaccs.accname FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id  AND expenseactmgnt.deptid = '$id' GROUP BY expnseaccs.id ORDER BY accname asc";
                      
                      $data11=$mumin->getdbContent($qry);
                      
                      for($k=0;$k<=count($data11)-1;$k++){
                          
                          echo "<option value='".$data11[$k]['id']."'>".$data11[$k]['accname']."</option>";
                      }
                      ?> 
                      
                      
                  </select>
                                 <input id="cctr" class="formfield"></input><input id="cctrid" hidden="true" value="all"></input>
                         </td></tr>
       
                     <tr><td>Start Date :</td><td style="width: 80px"><input id="ssstart" name="ssstart" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td><td>&nbsp;End date :</td><td><input id="ssend" name="ssend" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td></tr>
                <tr><td></td><td><button id="supplierstatements">View Ledger</button></td></tr>
                     </table>
         </fieldset> 
  
            
            
            <?php
                  
                  
              }
                            if($acti=="supbadebts"){
                 ?>
            
             <fieldset style="border: 1px burlywood solid;margin-top: 30px"><legend style="color: black;font-size: 14px;font-weight: normal">   Supplier Bad debts</legend>
                                  
           <table class="ordinal" style="visibility: visible" id="tbl3" >  
               <tr><td style="width: 290px" ><input class="formfield" id="suppdebtsrowcount" placeholder="No of Rows :" type="text" maxlength="6"/></td><td id="statname" style="width:300px;border: none;font-weight: bold;font-size: 13px;"></td></tr> 
               <tr><td><?php echo $appndbutn; ?></td></tr>
           </table>   
       </fieldset>
       
         <fieldset id="debttfield" style="border: 1px burlywood solid;margin-top: 30px;display: none"><legend style="color: black;font-size: 13px;font-weight: bold">Bad debts data</legend>
            <table class="ordinal" id="debttinfo"  >
       
               
       </table>
         </fieldset> 
  

            
            <?php
                  
                  
              }
              if($acti=="supsummary"){
                 ?>
            
             <fieldset style="border: 1px burlywood solid;margin-top: 30px"><legend style="color: black;font-size: 14px;font-weight: normal">Generate supplier summary</legend>
                 <table class="ordinal" >       
                     <tr><td>Start Date :</td><td style="width: 80px"><input id="summarystart" name="summarystart" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td><td>&nbsp;End date :</td><td><input id="summaryend" name="summaryend" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td></tr>
                <tr><td></td><td><button id="supplisummary">View Summary</button></td></tr>
                     </table>
         </fieldset> 
  
            
            
            <?php
                  
                  
              }
   
         ?>
                 
    <?php
          if(isset($_POST['invoicechange'])){
          
               $number=  $_POST['invsno'];
             
                $toacc=  $_POST['toaccs'];
                
                  $datesof= $_POST['invsdate'];
             
                   
            $qwr="UPDATE estate_invoice SET idate='$datesof' ,incacc= $toacc  WHERE invno = '$number' AND estId LIKE '$id' "; 
             
           $update= $mumin->updatedbContent($qwr);
            
            if($update==1){
                
                echo "<center>update successfull</center>";
            }
            else{
            echo "<center>update not successfully</centeer>";
            }
            }
            
    
    
    ?>
                 
    <div id="succes" style="display: none">
        
    </div>
    <div id="inv_success" style="display: none" title="Transaction complete">
        
        <p>Invoice was generated successfully at <?php echo date('d-m-Y h:i:s') ;?></p>
        <p>  <button id="cancl1">OK</button></p>
    </div>
        
        <div id="inv_rqst" style="display: none" title="Mumin Error">
        <p></p>
        <p></p>
        <p></p>
        <p> Not Registered Under this Mohalla. <br></br> Add as Debtor?</p>
        <p></p>
        <p></p>
        <p> <button id="adddebtor">OK</button> <button id="canceladd">CANCEL</button>  </p>
    </div>
      <div id="readydebtr" style="display: none" title="Mumin Error">
        <p></p>
        <p></p>
        <p></p>
        <p> Already a Debtor. <br></br>Select him/her?</p>
        <p></p>
        <p></p>
        <p> <button id="slctdebtor">OK</button> <button id="cancelready">CANCEL</button>  </p>
    </div>
    <div id="addebt" style="display:none" title="ADD DEBTOR">
       <table class="ordinal" id="esdeb">   
              
              <tr><td></td><td><input  type="hidden"  class="formfield" readonly="readonly" id="cgid"/> </td></tr>
               <tr><td>Names:</td><td><input  type="text"  class="formfield"   id="muname"/>  * </td></tr> 
            <tr><td>Telephone:</td><td><input  type="text"  class="formfield"    id="mutel"/>  * </td></tr>
             <tr><td>Email:</td><td><input  type="text"  class="formfield"   id="muemail"/> </td></tr>
              <tr><td>Postal Addr:</td><td><input  type="text"  class="formfield"   id="mupostal"/> </td></tr>
           <tr><td>City/Mohalla:</td><td><input  type="text"  class="formfield"   id="mucity"/>  * </td></tr>
           <tr><td>Sabil No:</td><td><input  type="text"  class="formfield"   id="musabil" style="text-transform: uppercase;"/>  </td></tr>
           <tr><td>Remarks:</td><td><textarea class="formfield" id="murmks" ></textarea> 
               </td></tr>
              <tr><td></td><td> <br><button id="debtorsaver" >&nbspSave&nbsp</button>   
               </td></tr>
         </table>
        
    </div>
                         <div id="changeedit" style="display:none " title="Change /Edit supplier Info">
         
             
          <table class="ordinal">   
              
              <tr><td></td><td><input  type="hidden"  class="formfield" readonly="readonly" id="cgid"/> </td></tr>
               <tr><td>Names:</td><td><input  type="text"  class="formfield"   id="cgname"/> </td></tr> 
            <tr><td>Telephone:</td><td><input  type="text"  class="formfield"    id="cgtel"/> </td></tr>
             <tr><td>Email:</td><td><input  type="text"  class="formfield"   id="cgemail"/> </td></tr>
              <tr><td>Postal Addr:</td><td><input  type="text"  class="formfield"   id="cgpostal"/> </td></tr>
           <tr><td>City:</td><td><input  type="text"  class="formfield"    id="cgcity"/> </td></tr>
              <tr><td></td><td> <button id="suppsaver" class="formbuttons">Save Changes</button>   
               </td></tr>
         </table>
      </div>
                    <div id="gallery">
   <table>
       <tr><td style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;<b>Name:</b></td><td style="width: 230px"><img src="images/cross.png" align="right" id="closegallery"></img></td></tr>
       <tr><td><input type="text" class="texinput" id="namesrch" placeholder="--- First name / Surname ---"></input></td></tr>
   </table>
    <div id="phts" style="width: 400px;">
        
    </div>
</div>
   <div id="d_progress" style="display: none;background: transparent;border: none;text-align: center;vertical-align:middle; line-height: 50px;padding-top: 10px">
     <img align="center" src="../assets/images/icon_animated_prog_dkgy_42wx42h.gif"></img>
 </div> 
    
    

            </div>
        </div>
        
      </div> 
    
    </div>
    <!--Right Panel Ends Here-->
  </div>  <?php include 'footer.php' ?>
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
