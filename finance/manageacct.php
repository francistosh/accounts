<?php
session_start(); 

if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  
    $level=$_SESSION['jmsacc'];
    $userid = $_SESSION['acctusrid'];
    
    if($level!=1){
  
        header("location: ../index.php"); 
        
    }
    else{
   
include 'operations/Mumin.php';

$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE userid = '$userid'  LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);

if($priviledges[0]['admin']!=1){
   
header("location: index.php");
}
}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    
<head>
    
<title>Jims 2</title> 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';

$usr=$_SESSION['jname'];  
 
?>
 <style>
      
     .menuitems a:link {
	text-decoration:none;
	color:#333;
	font-size:11px;
        padding:10px 5px 10px 5px;
	}
	
 
  .menuitems li:hover {
	  background: #357918;
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
    

<script>
    
  $(function() {
      $('#editsupp').dataTable( {
	"bSort": false,
	// "sPaginationType": "full_numbers",
	"iDisplayLength": 25,
	"aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
	"bJQueryUI": true
  } );
    
    
    $("#prlevel").combobox()  ;  
   
  
  $("#addpr").button({
            icons: {
                
                        secondary:"ui-icon-disk"
            },
            text: true
             
});
           $("#bankacctsprint").button({
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
    });
 
</script>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />


</head>  
    
<body style="overflow-x: hidden;"> 
     
        <?php  
                                  
                                
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
  	<div id="div_logindetails">You are logged in as:  <?php echo $usr;?></div>
    <!--Left Panel Starts Here-->
    <div id="div_leftpanel">
     <?php include_once 'adminleftmenu.php'; ?>
        
      </div>
    <!--Right Panel Starts Here-->
    <div id="div_rightpanel">
      
   	  <div id="div_datainput">
      	<div id="div_formtitle">
        	<h3 class="titletext"><b>Bank Accounts</b></h3>
        </div>
        <div id="div_formcontainer">
        	<div id="tabs2">
    
     
          <?php
          
          $type=$_GET['type'];
          
        
              
           if($type=="edit")   {
               ?>
               <fieldset style="border: 1px gold solid"><legend style="color: #333;font-weight: bold;font-style: italic">Manage Bank Accounts</legend>         
                    <table class="ordinal">
                    <tr> 
                          <td style="border: none"></td>
                     
                     <td style="border: none">
                     <input type="radio" name="modify" value="addact" id="addact" checked="true" ><b>&nbsp&nbspAdd &nbsp&nbsp</b></input>
                     <input type="radio" name="modify" value="Editact" id="Editact"><b>&nbsp&nbspEdit</b></input><br>&nbsp;</td></tr>
                     <tr><td>Account Name: </td><td><input  type="text" id="acctname"  class="formfield"></input> <select class="formfield" id="slctbankname" hidden="true">
                                 <option value="">--Bank Acct--</option>
                                 <?php
                                      
                        $t="SELECT acname,bacc FROM bankaccounts "; 
      
                        $dat=$mumin->getdbContent($t);
      
                        for($y=0;$y<=count($dat)-1;$y++){
          
                         echo "<option value=".$dat[$y]['bacc'].">".$dat[$y]['acname']."</option>";
                                }
                            ?>
                             </select>*</td></tr>
                     <tr><td>Account No: </td><td><input  type="text" id="acctno"  class="formfield"></input> <input  type="text" id="acctno2"  class="formfield" hidden="true"></input>*</td></tr>
                     <tr><td>Department: </td> <td>
                         <select  class="formfield" id="actsector"> <option value="">--Select Department--</option> 
                         <?php
                                      
                        $q="SELECT deptid,deptname  FROM department"; 
      
                        $da=$mumin->getdbContent($q);
      
                        for($k=0;$k<=count($da)-1;$k++){
          
                         echo "<option value=".$da[$k]['deptid'].">".$da[$k]['deptname']."</option>";
                                }
                            ?> </select> <input  type="text" id="actsector2"  class="formfield" hidden="true"></input>
                         </td><td rowspan="2" id="statusacctype" hidden="true" style="color: #4F8A10; font-weight: bold"></td></tr>
                     <tr><td>Type: </td> <td><select  class="formfield" id="acttype"><option value="">--Type--</option> 
                                            <option value="B">Bank</option> 
                                            <option value="C">Cash</option>
                             </select> <select  class="formfield" id="acttype2" hidden="true"><option value="">--Type--</option> 
                                            <option value="B">Bank</option> 
                                            <option value="C">Cash</option>
                             </select> *</td></tr>
                     <tr><td></td><td><button id="createact">Submit</button> <button id="updateact" hidden="true">Update</button></td><td></td></tr>
                    </table>
                   
                   
                   
                   </fieldset>
                 <?php
           }
               else if($type=="view"){
           echo "<div id='suppliersFilterBar' style='width:830px'> <br>&nbsp</br></div>";
     
           $qer="SELECT bacc,acno,acname,deptname,type FROM bankaccounts , department WHERE bankaccounts.deptid = department.deptid  "; 
      
       $data=$mumin->getdbContent($qer);
     
      
      echo "<table id='editsupp' >"; 
      echo '<thead>';
       echo "<tr><th>SN</th><th>Acc .No</th><th style='font-size:10px'>Acc. Name</th><th style='font-size:10px'>Department</th><th style='font-size:10px'>Type</th";
      echo '</thead>';
      echo '<tbody>';
      $sno = 0;
      for($j=0;$j<=count($data)-1;$j++){    
               
               if($data[$j]['type']=='B'){
                   $typename = 'BANK';
               } else{
                   $typename = 'CASH';
               } 
               $sno= $sno+1;
     echo "<tr><td  id='cgl".$j."'>".$sno."</td><td id='cnl".$j."'>".$data[$j]['acno']."</td><td id='ctl".$j."'>".$data[$j]['acname']."</td><td id='cml".$j."' >".$data[$j]['deptname']."</td><td id='cpl".$j."'>".$typename."</td></tr>";
      
             }
      echo '</tbody>';
      echo "</table>";
       
           
            
           }?>
    
     
    <div id="deleteconfirm1" style="display:none " title="Confim Deletion">
        <input type="hidden" id="cnamej"></input>
        <p>Are you sure you want to delete ? </p><p>This action is permanent and irreversible</p> 
        <table><tr><button id="okdelete">Ok,Delete</button></tr></table>
    </div>
    
    
    <div id="d_progress" style="display: none;background: transparent;border: none;text-align: center;vertical-align:middle; line-height: 50px;padding-top: 10px">
     <img align="center" src="../assets/images/icon_animated_prog_dkgy_42wx42h.gif"></img>
 </div> 
    </div>
  </div>
  </div>
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