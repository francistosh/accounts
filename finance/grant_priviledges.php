<?php
session_start(); 

if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  
   $level=$_SESSION['jmsacc'];
    @$id=$_SESSION['dept_id'];
    $userid = $_SESSION['acctusrid'];
    
    if($level!=1){
  
        header("location: ../index.php"); 
        
    }
    else{
   
include 'operations/Mumin.php';

$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE userid = '$userid' LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);

if($priviledges[0]['admin']!=1){
   
header("location: index.php");
}
}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html >
    
<head>
    
<title>Finance</title> 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';

$usr=$_SESSION['jname'];  


?>
<script>
    
  $(function() {
    
    
    $("#prlevel").combobox()  ;  
   
  
  $("#addpr").button({
            icons: {
                
                        secondary:"ui-icon-disk"
            },
            text: true
             
});
 $("#canceluser").button({
            icons: {
                primary: "ui-icon-check",
                secondary: "ui-icon-gear" 
            }
        });
 $("#adduser").button({
            icons: {
                primary: "ui-icon-check",
                secondary: "ui-icon-gear" 
            }
        });
             $('#userstable').dataTable( {
	"bSort": false,
	// "sPaginationType": "full_numbers",
	"iDisplayLength": 25,
	"aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
	"bJQueryUI": true
  } );
    });
 
</script>
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
        #edditable th td{
            border: 1px solid black;
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
    
<body style="overflow-x: hidden;"> 
     
        <?php  
                                  
                                
    ?>
        
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
  	<div id="div_logindetails">You are logged in as:  <?php echo $usr;?></div>
    <!--Left Panel Starts Here-->
  <?php include_once 'adminleftmenu.php'; ?>
    <!--Right Panel Starts Here-->
    <div id="div_rightpanel">
   	  <div id="div_datainput">
      	<div id="div_formtitle">
        	<h3 class="titletext">Admin sub-section</h3>
        </div>
        <div id="div_formcontainer">
        	<div id="tabs2">
     
       
          <?php
            $type=$_GET['type'];
             if($type=="add"){
              ?>
             <fieldset style="border:1px lightgray solid;color:gray;font-size: 15px;font-weight: bold">  
       
            <legend>New User</legend>
            <table class="ordinal">
                <tr><td>Username: </td><td><input type="text" class="formfield" id="jimsuname"></input></td></tr>
                <tr><td>Password: </td><td><input type="password" class="formfield" id="jimspaswrd"></input></td></tr>
                <tr><td>Confirm Password: </td><td><input type="password" class="formfield" id="jimspaswrd2"></input></td></tr>
                <tr><td>Email: </td><td><input type="text" class="formfield" id="jimsemail"></input></td></tr>
                <tr><td>User Level: </td><td><select class="formfield" id="user_lvl"><option value="">--Select Level--</option>
                                             <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                            </select></td></tr>
                <tr><td colspan="2" style="text-align: center"><button id="adduser">Add User</button><button id="canceluser">Cancel</button></td></tr>
            </table>
          
             </fieldset>
          
          <?php
            }
            
        else if($type=="change"){
               
                
                         
       $sr="SELECT * FROM pword WHERE est_id = '$id'"; 
      
       $data=$mumin->getdbContent($sr);
      
       echo "<fieldset style='border:1px lightgray solid;color:gray;font-size: 15px;font-weight: bold'> "; 
       
          echo "<legend>Users</legend>";
      
      echo "<table class='ordinal' style='margin-top:3px'>"; 
      
       echo "<tr><th>Username</th><th style='font-size:10px'>Password</th><th style='font-size:10px'>Access Level</th><th></th><th></th>";  
                
                
              for($i=0;$i<=count($data)-1;$i++)  {
                  
                  if($usr==$data[$i]['e_uname']){
                
                      echo "<tr style='background:orange'><td style='background:orange'>".$data[$i]['e_uname']."</td><td style='background:orange'>******</td><td style='background:orange'>".$data[$i]['privileges']."</td><td style='background:orange'>ADMIN</td><td></td></tr>";     
                  }
                  else{
                     echo "<tr><td id='cgl".$i."' class=>".$data[$i]['e_uname']."</td><td>******</td><td>".$data[$i]['privileges']."</td><td><a id='k".$i."' class='changepriviledge' href='#'>Change</a></td><td><a id='m".$i."' class='removeusers' href='#'>Remove</a></td></tr>"; 
                  }
              }
                
                echo "</table>";
                  echo "</fieldset>";
                
            }
            else if($type=="view"){
                         
       $sr="SELECT * FROM pword"; 
      
       $data=$mumin->getdbContent($sr);
      
       echo "<fieldset style='border:1px lightgray solid;color:gray;font-size: 15px;font-weight: bold'> "; 
       
          echo '<legend>Users List</legend>';
      echo '<div  style="display: block;float: right"></div>';

      echo "<table  style='margin-top:3px;' id='statements'>"; 
      
       echo "<thead><tr><th style='font-size:12px'>Username</th><th style='font-size:12px'>Password</th><th style='font-size:12px'>Access Level</th><th style='font-size:12px'>Action</th</tr></th>";  
                
                
              for($i=0;$i<=count($data)-1;$i++)  {
                  
                  if($usr==$data[$i]['j_uname']){  
                
                      echo "<tr><td id='jim_uname$i'>".$data[$i]['j_uname']."</td><td>******</td><td id='j_usrgrp$i'>".$data[$i]['grp']."<input type='text' hidden value='".$data[$i]['userid']."' id='useridjim$i'/></td><td><a href='#' id='j_usrid$i' class = 'editjuser'>Edit</a>  |  <a href='#' id='".$data[$i]['userid']."' class = 'managejuser'>Manage</a></td></tr>";     
                  }
                  else{
                     echo "<tr><td id='jim_uname$i'>".$data[$i]['j_uname']."</td><td>******</td><td id='j_usrgrp$i'>".$data[$i]['grp']."<input type='text' hidden value='".$data[$i]['userid']."' id='useridjim$i'/></td><td><a href='#' id='j_usrid$i' class = 'editjuser'>Edit</a>  |  <a href='#' id='".$data[$i]['userid']."' class = 'managejuser'>Manage</a></td></tr>"; 
                  }
              }
                
                echo "</table>";
                  echo "</fieldset>";
                
           
            }
      ?>
   
      
</div>
</div>
    
    <div id="cgpri" style="display:none " title="Change Access Level">
         
             
          <table class="ordinal">   
              
              <tr><td>Username:</td><td><input  type="text" class="formfield" readonly="readonly"  id="cguname"/> </td></tr>
          <tr><td>New Level:</td><td> 
              
               <select class="formfield" id="newcglevel">
                            
                            
                            <?php
                                      
       $q="SELECT *  FROM priviledges"; 
      
      $da=$mumin->getdbContent($q);
      
      for($k=0;$k<=count($da)-1;$k++){
          
          echo "<option value=".$da[$k]['id'].">".$da[$k]['id']."</option>";
      }
                            ?>
                        </select> 
              
              </td></tr>            
           
          <tr><td></td><td> <button id="cgsaver" class="formbuttons">Change</button>  
               </td></tr>
         </table>
      </div>
    
                    <div id="juseraccess" style="display: none" title="User Management">
                <fieldset style="-moz-border-radius: 7px; border: 1px #dddddd solid; "><legend style="border: 1px #1a6f93 dotted;font-size: 13px;padding-right: 5px;padding-left: 5px;padding-top: 2px;padding-bottom: 2px;-moz-border-radius: 3px; width: 200px; font-weight: bold">Asign Priviledges</legend>
 
                    <label>User:</label><select class="formfield" id="jimuser" disabled="true">
                            <?php
                      
                     $jqery2="SELECT j_uname,userid FROM pword  "; 
                         $datay2=$mumin->getdbContent($jqery2);
    
       
      for($j=0;$j<=count($datay2)-1;$j++){    
               
               
       echo "<option value='".$datay2[$j]['userid']."'>".$datay2[$j]['j_uname']."</option>";
      
             }
             ?>
                  </select><br style="clear: left;" /><br/>
 
<label>Department:</label><select class="formfield" id="jimsdepartment">
    <option value="" selected="true">-- Select --</option>
                            <?php
                      
                     $jqery="SELECT deptid,deptname FROM department order by deptname ASC  "; 
                         $datay=$mumin->getdbContent($jqery);
    
       
      for($j=0;$j<=count($datay)-1;$j++){    
               
               
       echo "<option value='".$datay[$j]['deptid']."'>".$datay[$j]['deptname']."</option>";
      
             }
             ?>
                  </select><br style="clear: left;" /><br/>
  

 
</fieldset>
                        <div hidden="true" id="systmpriviledges">
                            <fieldset style="-moz-border-radius: 7px; border: 1px #dddddd solid; "><legend style="border: 1px #1a6f93 dotted;font-size: 13px;padding-right: 5px;padding-left: 5px;padding-top: 2px;padding-bottom: 2px;-moz-border-radius: 3px; width: 200px; font-weight: bold">Access</legend>

                            <?php 
                                  $tabl = "SHOW COLUMNS FROM priviledges";
      $dataclmns = $mumin->getdbContent($tabl);

      echo "<table id='treport' style='margin-top:3px'>";  
      
       echo "<tr><th>Priv. Level</th><th>Action</th></tr>";
       for($j=4;$j<=count($dataclmns)-1;$j++){ 
      echo "<tr><td style='font-size:13px' id='privlenl$j'>".$dataclmns[$j]['Field']."</td><td><input type='checkbox' class='privcheckbox' id='userpriv$j'> </input></td></tr>";
       }
       echo '</table>';                
                            
                            ?>
                                <br></br><button id="updateprivildg"> Update </button>
                            </fieldset>
                        </div>
               </div> 
                        <div id="editjuser" style="display: none" title="User Management">
                <fieldset style="-moz-border-radius: 7px; border: 1px #dddddd solid; "><legend style="border: 1px #1a6f93 dotted;font-size: 13px;padding-right: 5px;padding-left: 5px;padding-top: 2px;padding-bottom: 2px;-moz-border-radius: 3px; width: 200px; font-weight: bold">Edit User</legend>
 
                    <label>Username:</label><input type="text" class="formfield" id="usenamejims" disabled="true"></input><input id="useridjims" hidden="true"></input><br style="clear: left;" /><br/>
 
                    <label>Password:</label><input type="password" class="formfield" id="password1jims" placeholder="**********"></input><br style="clear: left;" /><br/>
                    <label>Confirm password:</label><input type="password" class="formfield" id="password2jims" placeholder="**********"></input><br style="clear: left;" /><br/>
                    <label>Email:</label><input type="email" class="formfield" id="emailjims"></input><br style="clear: left;" /><br/>
                    <label>User Level:</label><select class="formfield" id="user_lvljims"><option value="">--Select Level--</option>
                                             <option value="ADMIN">Admin</option>
                                            <option value="USER">User</option>
                                            </select><br style="clear: left;" /><br/>
                                            <button id="updatejimsuser"> Update</button>
 
</fieldset>
               </div>
     
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
  </div><?php include 'footer.php' ?> 
  </div>
     <?php include './dropdown.php';?>
</body>
</html>