<?php

session_start(); 

if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  
    $level=$_SESSION['jmsacc'];
    $id=$_SESSION['dept_id'];
    $userid = $_SESSION['acctusrid'];
    if($level>999){
  
        header("location: ../index.php"); 
        
    }
 else{
   
include 'operations/Mumin.php';

$data=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE userid = '$userid' AND deptid = '$id' LIMIT 1";

$priviledges=$data->getdbContent($qr2);

if($priviledges[0]['database']!=1){
   
header("location: index.php");
}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    
<head>
    
<title>Jims</title> 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';

$usr=$_SESSION['jname'];  
 
?>


<script>
    
  $(function() {
    
     
            
        
    $("#tabs").tabs(); 
    
   
      
    $("#q" ).autocomplete({
            source: ejamaatNos,
            minLength: 1
        
     
  });
    
   $("#report_go_sabil").button({
            icons: {
                primary: "ui-icon-document" ,
                        secondary:"ui-icon-check"
            },
            text: true
             
});
 
  $("#report_go").button({
            icons: {
                primary: "ui-icon-document" ,
                        secondary:"ui-icon-check"
            },
            text: true
             
});
 $("#hoejbutn").click((function(){ 
        
    window.open('../finance/muminrprt.php?action=hofej','','width=800,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
    
    }));
$("#listbutn").click((function(){ 
        
    window.open('../finance/muminrprt.php?action=list','','width=800,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
    
    }));

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
        .push_button {
	position: relative;
	width:220px;
	height:40px;
	text-align:center;
	color:#FFF;
	text-decoration:none;
	line-height:43px;
	font-family:'Oswald', Helvetica;
        font-weight: bold;
	display: block;
	margin: 30px;
}
        .push_button:before {
	background:#f0f0f0;
	background-image:-webkit-gradient(linear, 0% 0%, 0% 100%, from(#D0D0D0), to(#f0f0f0));
	
	-webkit-border-radius:5px;
	-moz-border-radius:5px;
	border-radius:5px;
	
	-webkit-box-shadow:0 1px 2px rgba(0, 0, 0, .5) inset, 0 1px 0 #FFF; 
	-moz-box-shadow:0 1px 2px rgba(0, 0, 0, .5) inset, 0 1px 0 #FFF; 
	box-shadow:0 1px 2px rgba(0, 0, 0, .5) inset, 0 1px 0 #FFF;
	
	position: absolute;
	content: "";
	left: -6px; right: -6px;
	top: -6px; bottom: -10px;
	z-index: -1;
}

.push_button:active {
	-webkit-box-shadow:0 1px 0 rgba(255, 255, 255, .5) inset, 0 -1px 0 rgba(255, 255, 255, .1) inset;
	top:5px;
}
.push_button:active:before{
	top: -11px;
	bottom: -5px;
	content: "";
}

.red {
	text-shadow:-1px -1px 0 #A84155;
	background: #D25068;
	border:1px solid #D25068;
	
	background-image:-webkit-linear-gradient(top, #F66C7B, #D25068);
	background-image:-moz-linear-gradient(top, #F66C7B, #D25068);
	background-image:-ms-linear-gradient(top, #F66C7B, #D25068);
	background-image:-o-linear-gradient(top, #F66C7B, #D25068);
	background-image:linear-gradient(to bottom, #F66C7B, #D25068);
	
	-webkit-border-radius:5px;
	-moz-border-radius:5px;
	border-radius:5px;
	
	-webkit-box-shadow:0 1px 0 rgba(255, 255, 255, .5) inset, 0 -1px 0 rgba(255, 255, 255, .1) inset, 0 4px 0 #AD4257, 0 4px 2px rgba(0, 0, 0, .5);
	-moz-box-shadow:0 1px 0 rgba(255, 255, 255, .5) inset, 0 -1px 0 rgba(255, 255, 255, .1) inset, 0 4px 0 #AD4257, 0 4px 2px rgba(0, 0, 0, .5);
	box-shadow:0 1px 0 rgba(255, 255, 255, .5) inset, 0 -1px 0 rgba(255, 255, 255, .1) inset, 0 4px 0 #AD4257, 0 4px 2px rgba(0, 0, 0, .5);
}

.red:hover {
	background: #F66C7B;
	background-image:-webkit-linear-gradient(top, #D25068, #F66C7B);
	background-image:-moz-linear-gradient(top, #D25068, #F66C7B);
	background-image:-ms-linear-gradient(top, #D25068, #F66C7B);
	background-image:-o-linear-gradient(top, #D25068, #F66C7B);
	background-image:linear-gradient(top, #D25068, #F66C7B);
}

.blue {
	text-shadow:-1px -1px 0 #2C7982;
	background: #3EACBA;
	border:1px solid #379AA4;
	background-image:-webkit-linear-gradient(top, #48C6D4, #3EACBA);
	background-image:-moz-linear-gradient(top, #48C6D4, #3EACBA);
	background-image:-ms-linear-gradient(top, #48C6D4, #3EACBA);
	background-image:-o-linear-gradient(top, #48C6D4, #3EACBA);
	background-image:linear-gradient(top, #48C6D4, #3EACBA);
	
	-webkit-border-radius:5px;
	-moz-border-radius:5px;
	border-radius:5px;
	
	-webkit-box-shadow:0 1px 0 rgba(255, 255, 255, .5) inset, 0 -1px 0 rgba(255, 255, 255, .1) inset, 0 4px 0 #338A94, 0 4px 2px rgba(0, 0, 0, .5);
	-moz-box-shadow:0 1px 0 rgba(255, 255, 255, .5) inset, 0 -1px 0 rgba(255, 255, 255, .1) inset, 0 4px 0 #338A94, 0 4px 2px rgba(0, 0, 0, .5);
	box-shadow:0 1px 0 rgba(255, 255, 255, .5) inset, 0 -1px 0 rgba(255, 255, 255, .1) inset, 0 4px 0 #338A94, 0 4px 2px rgba(0, 0, 0, .5);
}

.blue:hover {
	background: #48C6D4;
	background-image:-webkit-linear-gradient(top, #3EACBA, #48C6D4);
	background-image:-moz-linear-gradient(top, #3EACBA, #48C6D4);
	background-image:-ms-linear-gradient(top, #3EACBA, #48C6D4);
	background-image:-o-linear-gradient(top, #3EACBA, #48C6D4);
	background-image:linear-gradient(top, #3EACBA, #48C6D4);
}
	</style>


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
   	  <div id="div_pic">
      
            <div id="div_logout" class="button" style="margin-left:10px;"> 
       	<a href="index.php">
          <button class="formbuttons" value="1">
          
              <table style="margin-left: 30px" width="116" border="0">
            <tr>
              <td width="36" height="36" style="text-align:right;"><img src="../assets/images/backward.png" width="35" height="35"/> </td>
              <td width="70" style="text-align:center;">Home</td>
            </tr>
          </table>
          
          </button>
         </a> 
        </div>
      </div>
      
        
      <div id="div_menu">
      	<div id="div_menutitle">Quick links</div>
        <div id="div_menucontent">
       
        	<ul class="menuitems">
                    
            <li class="menuitems"><a href="database_reports.php?action=search">Search Mumineen</a></li>  
            <li class="menuitems"><a href="database_reports.php?action=custom">Custom Reports</a></li>
            <li class="menuitems"><a href="database_reports.php?action=mohalla">Mumin List</a></li>
            <li  class="menuitems" ><a href="index.php">Home</a></li> 
              
                    
                 
          <li class="menuitems"><a href="logout.php" class="menuitems"> Log Out</a> </li>
       </ul>
        </div>
      </div>
    </div>
    <!--Right Panel Starts Here-->
    <div id="div_rightpanel">
   	  <div id="div_datainput">
      	<div id="div_formtitle">
        	<h3 class="titletext">Database sub-section</h3>
        </div>
        <div id="div_formcontainer">
        	<div id="tabs2">
         
         <?php
         
         $action=$_GET['action'];
         
         if($action==""){
             echo "<font color='green'>&laquo;&nbsp;Use the left menu panel options to navigate through Database module</font>" ;   
         }
         
         else if($action=="custom"){
         ?>
         
    
    <fieldset style="border:2px burlywood ridge;color:maroon;font-size: 15px;font-weight: bold">  
       
            <legend>Check Fields to appear in report</legend>
           
         <table class="invview"> 
             
            
                 
                 <tr> <td><input id="rpt0" class="r_port"  value="ejno" type="checkbox"/></td><td>Ejamaat No</td><td><input id="rpt17" class="r_port"  value="misaq" type="checkbox"/></td><td>Misaq</td><td><input class="r_port"  id="rpt33" value="hseare" type="checkbox"/></td><td>House area</td><td><input class="r_port"  id="rpt49" value="psabam" type="checkbox"/></td><td>Professional Sabil</td></tr>
                  <tr><td><input id="rpt1" class="r_port" value="hofej" type="checkbox"/></td><td>Head of family</td><td><input id="rpt18" class="r_port"  value="don" type="checkbox"/></td><td>Date of Nikah</td><td><input class="r_port"  id="rpt34"  value="hsestr" type="checkbox"/></td><td>House Street</td><td><input class="r_port"  id="rpt50" value="hsabam" type="checkbox"/></td><td>House Sabil</td></tr>
                  <tr><td><input id="rpt2" class="r_port" value="fprefix" type="checkbox"/></td><td>Prefix</td><td><input id="rpt19" class="r_port"  value="hjdon" type="checkbox"/></td><td>Hijri date of Nikah</td><td><input class="r_port"   id="rpt35" value="hsebldg" type="checkbox"/></td><td>House Building</td></tr> 
                  <tr><td><input id="rpt3" class="r_port" value="prefdate" type="checkbox"/></td><td>Prefix date</td><td><input id="rpt20" class="r_port"  value="occup" type="checkbox"/></td><td>Occupation</td><td><input class="r_port"  id="rpt36"  value="hseno" type="checkbox"/></td><td>House No</td></tr>
                  <tr><td><input id="rpt4" class="r_port"  value="fname" type="checkbox"/></td><td>First Name</td><td><input id="rpt21" class="r_port"  value="bg" type="checkbox"/></td><td>Blood group</td><td><input class="r_port"   id="rpt37" value="mumej" type="checkbox"/></td><td>Mother's Ejamaat No</td></tr>
                  <tr><td><input id="rpt5" class="r_port" value="sname" type="checkbox"/></td><td>Surname</td><td><input id="rpt22" class="r_port"  value="moh" type="checkbox"/></td><td>Mohala</td><td><input class="r_port"  id="rpt38"  value="dadej" type="checkbox"/></td><td>Father's Ejamaat No</td></tr>
                  <tr><td><input id="rpt6" class="r_port" value="dadname" type="checkbox"/></td><td>Father's Name</td><td><input id="rpt23" class="r_port"  value="hsetel" type="checkbox"/></td><td>House telephone No</td><td><input  id="rpt39" class="r_port"  value="vatan" type="checkbox"/></td><td>Vatan</td></tr>
                  <tr><td><input id="rpt7" class="r_port" value="fathprex" type="checkbox"/></td><td>Father's prefix</td><td><input id="rpt24" class="r_port"  value="smobile" type="checkbox"/></td><td>Safaricom No</td><td><input  id="rpt40" class="r_port"  value="dari" type="checkbox"/></td><td>Wear Dari</td></tr>
                  <tr><td><input id="rpt8" class="r_port" value="fsname" type="checkbox"/></td><td>Father's Surname</td><td><input id="rpt25" class="r_port"  value="zmobile" type="checkbox"/></td><td>Zain Mobile No</td><td><input class="r_port"  id="rpt41" value="rida" type="checkbox"/></td><td>Wear Rida</td></tr>  
                  <tr><td><input id="rpt9" class="r_port" value="husband" type="checkbox"/></td><td>Husband</td><td><input class="r_port"  id="rpt26" value="omobile" type="checkbox"/></td><td>Orange Mobile No</td><td><input class="r_port"  id="rpt42"  value="topi" type="checkbox"/></td><td>Wear topi</td></tr>
                  <tr><td><input id="rpt10" class="r_port" value="sabilno" type="checkbox"/></td><td>Sabil No.</td><td><input class="r_port" id="rpt27"  value="smsmobile" type="checkbox"/></td><td>SMS No</td><td><input class="r_port"   id="rpt43" value="safai" type="checkbox"/></td><td>Safai</td></tr>
                  <tr><td><input id="rpt12" class="r_port" value="rtohof" type="checkbox"/></td><td>Relation to HoF</td><td><input class="r_port" id="rpt28"  value="offtel" type="checkbox"/></td><td>Office telephone</td><td><input  id="rpt44" class="r_port"  value="safaival" type="checkbox"/></td><td>Safai Validity</td></tr>
                  <tr><td><input id="rpt13" class="r_port" value="sex" type="checkbox"/></td><td>Gender</td><td><input class="r_port"  value="estab" id="rpt29" type="checkbox"/></td><td>Establishements</td><td><input class="r_port"   id="rpt45" value="ikhwan1" type="checkbox"/></td><td>Ikhwan 1</td></tr>
                  <tr><td><input id="rpt14" class="r_port" value="dob" type="checkbox"/></td><td>Date of birth</td><td><input class="r_port" id="rpt30"  value="email" type="checkbox"/></td><td>Personal Email</td><td><input class="r_port"  id="rpt46"  value="ikhwan2" type="checkbox"/></td><td>Ikhwan 2</td></tr>
                  <tr><td><input id="rpt15" class="r_port" value="hdob" type="checkbox"/></td><td>Hijri Date of Birth</td><td><input class="r_port" id="rpt31"  value="bemail" type="checkbox"/></td><td>Business Email</td><td><input  id="rpt47" class="r_port"  value="ikhwan3" type="checkbox"/></td><td>Ikhwan 3</td></tr>
                  <tr><td><input id="rpt16" class="r_port" value="mstat" type="checkbox"/></td><td>Marital status</td><td><input class="r_port" id="rpt32"  value="madd" type="checkbox"/></td><td>Mailing Address</td><td><input  id="rpt48" class="r_port"  value="ikhwan4" type="checkbox"/></td><td>Ikhwan 4</td></tr>
         </table><br/>
           <table style="border: none"><tr style="border: none"><td></td><td></td><td></td><td></td><td><button id="report_go_sabil">Sabil Wise</button></td><td><button id="report_go">General</button></td></tr>    
         
         </table>       
    </fieldset>   
         
        <?php
         }
 elseif ($action=="search") {
         ?>  
      
                    <div id="searchbar" style="width: 760px;margin-top: 4px;padding-right: 5px"><div id="searchbox"><input maxlength="8" onchange="getUserInformation($(this).val());" onkeyup="getUserInformation($(this).val());" placeholder="type ejamaat no. " type="text" id="q"  class="query_text"></input><button onclick="getUserInformation($('#q').val());" class="searchbutton"></button></div><div id="wraps" style="width: 400px;"><div id="searchsabil"><button id="sabilbutt" class="sabilbutt"></button></div><div id="progressbar" style="width: 300px;float: left"></div></div></div>
   
   
         <div id="tabs-right-panel" style="height: 150px;right:1030px;top: 300px;position: absolute;width: 125px;background:transparent;z-index: 10"></div> 
             
         
 <div id="tabs" style="display: none;margin-top: 5px">
    <ul>
        <li><a href="#tabs-1">Basic </a></li>
        <li><a href="#tabs-2">Education</a></li>
        <li><a href="#tabs-3">House/Residence</a></li>  
        <li><a href="#tabs-4">Social </a></li>
        <li><a href="#tabs-5">Health </a></li>
        <li><a href="#tabs-6">Deeni umoor</a></li>
        <li><a href="#tabs-7">Financials snapshot</a></li>
        <li><a href="#tabs-8">Family</a></li>
        
    </ul>
     
    <div id="tabs-1"> 
  
            
           
             
           
        <!--  <div id="tabs-right-panel" style="height: 150px;right:960px;top: 90px;position: absolute;width: 125px;background:transparent;z-index: 10"></div> !-->
            
           
       
          
          <div id="formCont" style="background:transparent;width: auto;margin: 0px auto 0px auto;overflow: auto">
              
          
          <table cellspacing="0" cellspadding="0">  
                 
                  
             <tr><td> 
                 
                        <div id="form-span" class="form-span-left"><label>Prefix</label><br/>
                            <input readonly="readonly" class="formfield" type="text" onclick="basicEditDialog('#prefixEdit');" id="prefixview"></input>
                        </div>  
                     
                         
                 </td><td>
                        <div id="form-span" class="form-span-right"><label>First name</label><br/>
                          <input  readonly="readonly" class="formfield" id="fnameview" title="first name" type="text" name="prefix"/>
                        </div>
                     </td><td>
                         
                        <div id="form-span" class="form-span-justified"><label>Prefix date</label><br/>
                             
                            <input readonly="readonly" id="prefixdateview"  class="formfield"    title="Date prefix bestowed" type="text" name="prefix"/>
                        </div>
                         </td>
                    </tr><tr>
            
            
            
            
                       <td>
                         <div id="form-span" class="form-span-left"><label>Surname</label><br/>
                             <input readonly="readonly" class="formfield" title="Surname" id="surnameview" type="text" name="prefix"/>
                        </div>
                           </td><td>
                         
                        <div id="form-span" class="form-span-right"><label>Gender</label><br/>
                            <input readonly="readonly" type="text"  onclick="basicEditDialog('#genderEdit');" id="genderview" class="formfield"/> 
                        </div>
                               </td><td>
                        <div id="form-span" class="form-span-justified"><label>Date of birth</label><br/>
                            <input readonly="readonly" id="dobview"  class="formfield"   title="Date of birth"  type="text" name="prefix"/>
                        </div>
                                   </td>
                        
                        
                    </tr>  <tr><td>
                        
                         
                         <div id="form-span" class="form-span-left"><label>Id Number</label><br/>
                             <input readonly="readonly" class="formfield" id="idnoview" title="National id number"  type="text" name="prefix"/>
                        </div>
                         </td><td>
                        <div id="form-span" class="form-span-right"><label>Nikah/Marriage date</label><br/>
                           <input readonly="readonly" id="donikahview" class="formfield"  title="date of marriage" type="text" name="prefix"/>
                        </div>
                             </td><td>
                        <div id="form-span" class="form-span-justified"><label>Marital status</label><br/>
                            <input readonly="readonly" type="text"  onclick="basicEditDialog('#mstatEdit')" class="formfield" id="marital-statusview"></input>
                           
                        </div>
                                 </td>
                        
                        
                    </tr><tr><td>
                        
                         
                         <div id="form-span" class="form-span-left"><label>Husband Name</label><br/>
                        <input readonly="readonly" class="formfield" id="spouseview"  type="text" name="spouseview"/>
                        </div>
                         </td><td>
                        <div id="form-span" class="form-span-right"><label>Ejamaat No</label><br/>
                        <input readonly="readonly" id="ejnoview" class="formfield"  type="text" name="ejnoview"/>
                        </div>
                             </td><td>
                        <div id="form-span" class="form-span-justified"><label>Rel to HoF</label><br/>
                            <input readonly="readonly" id="rtohofview" class="formfield"  title="Relationship to head of family" type="text" name="prefix"/>
                        </div>
                        </td>
                        
                    </tr><tr><td>
                        
                         
                         <div id="form-span" class="form-span-left"><label>Misaq</label><br/>
                             <input readonly="readonly" class="formfield" type="text" onclick="basicEditDialog('#misaqEdit');" id="misaqview"> </input>
                        </div>
                         </td><td>
                        <div id="form-span" class="form-span-right"><label>Mohala</label><br/>
                            <input readonly="readonly"  class="formfield" onclick="basicEditDialog('#mohalaEdit')" type="text" id="mohalaview"></input>
                            
                              
                        </div>
                             </td><td>
                        <div id="form-span" class="form-span-justified"><label>Cat</label><br/>
                        <input readonly="readonly" id="catview" class="formfield"  type="text" name="prefix"/>
                        </div>
                        </td>
                        
                    </tr><tr><td>
                        
                         
                         <div id="form-span" class="form-span-left"><label>Safai</label><br/>
                             <input readonly="readonly"  class="formfield" onclick="basicEditDialog('#safaiEdit');" type="text" id="safaiview"></input>  
                        </div>
                            </td><td>
                         
                        <div id="form-span" class="form-span-right"><label>Safai validity</label><br/>
                            <input readonly="readonly" type="text" class="formfield" id="safaivalview"></input>
                        </div>
                                </td><td>
                        <div id="form-span" class="form-span-justified"><label>HoF Ejamaat No</label><br/>
                            <input readonly="readonly"  id="hofejview" class="formfield"  type="text" name="prefix"/>
                        </div>
                        </td>
                            
                        
                    </tr><tr><td>
                        
                       
                         <div id="form-span" class="form-span-left"><label>Vatan</label><br/>
                             <input readonly="readonly" class="formfield" type="text" id="vatanview"> </input>
 
                        </div>
                         </td><td>
                        <div id="form-span" class="form-span-right"><label>Nationality</label><br/>
                            <input readonly="readonly" class="formfield" onclick="basicEditDialog('#nationEdit');" type="text" id="nationalityview"> </input>
 
                        </div>
                             </td><td>
                        <div id="form-span" class="form-span-justified"><label><b>Sabil Number</b></label><br/>
                       <input readonly="readonly" id="sabilnoview" maxlength="5" class="formfield" style="color: #357918;font-weight: bold"  type="text" name="prefix"/>
                        </div>
                        </td>
                        
                    </tr><tr><td>
                        
                       
                         <div id="form-span" class="form-span-left"><label>Father's Prefix</label><br/>
                             <input readonly="readonly" class="formfield" onclick="basicEditDialog('#fatherprefixEdit')" id="fatherprefixview" ></input>
                        </div>
                            
                         </td><td>
                        <div id="form-span" class="form-span-right"><label>Father's firstname</label><br/>
                        <input readonly="readonly" id="fatherfnameview" class="formfield" type="text" name="prefix"/>
                        </div>
                             </td><td>
                        <div id="form-span" class="form-span-justified"><label>Father's surname</label><br/>
                        <input readonly="readonly" id="fathersnameview" class="formfield"  type="text" name="prefix"/>
                        </div>
                        </td>
                        
                    </tr><tr><td>
                        
                        
                         <div id="form-span" class="form-span-left"><label>Safaricom Mobile</label><br/>
                        <input readonly="readonly" id="smobileview" class="formfield"  type="text" name="prefix"/>
                        </div>
                            </td><td>
                         
                        <div id="form-span" class="form-span-right"><label>Airtel Mobile</label><br/>
                        <input readonly="readonly" id="zmobileview"class="formfield"  type="text" name="prefix"/>
                        </div>
                                </td><td>
                        <div id="form-span" class="form-span-justified"><label>Orange Mobile</label><br/>
                        <input readonly="readonly" id="omobileview" class="formfield"  type="text" name="prefix"/>
                        </div>
                        </td>
                        
                    </tr><tr><td>
                        
                       
                         <div id="form-span" class="form-span-left"><label>SMS mobile</label><br/>
                        <input readonly="readonly" id="smsmobileview" class="formfield"  type="text" name="prefix"/>
                        </div>
                            </td><td>
                         
                        <div id="form-span" class="form-span-right"><label>Office telephone</label><br/>
                        <input  readonly="readonly" id="oftelview"class="formfield"  type="text" name="prefix"/>
                        </div>
                                </td><td>
                        <div id="form-span" class="form-span-justified"><label>House telephone</label><br/>
                        <input readonly="readonly" id="hsetelview" class="formfield"  type="text" name="prefix"/>
                        </div>
                        </td>
                        
                    </tr><tr><td>
                        
                       
                         <div id="form-span" class="form-span-left"><label>Personal email</label><br/>
                        <input readonly="readonly" id="pmailview" class="formfield"  type="text" name="prefix"/>
                        </div>
                            </td><td>
                         
                        <div id="form-span" class="form-span-right"><label>Office email</label><br/>
                        <input readonly="readonly" id="omailview"class="formfield"  type="text" name="prefix"/>
                        </div>
                                </td><td>
                        <div id="form-span" class="form-span-justified"><label>Passport No</label><br/>
                        <input readonly="readonly" id="ppnoview" class="formfield"  type="text" name="prefix"/>
                        </div>
                        </td>
                        
                    </tr><tr><td>
                        
                        
                         <div id="form-span" class="form-span-left"><label>Mailing address</label><br/>
                             <input readonly="readonly" id="maddview"class="formfield"   type="text" name="prefix"/>
                        </div>
                         </td><td>
                        <div id="form-span" class="form-span-right"><label>Street Address</label><br/>
                        <input readonly="readonly" id="saddview" class="formfield"  type="text" name="prefix"/>
                        </div>
                             </td><td>
                        <div id="form-span" class="form-span-justified"><label>Address Line 2</label><br/>
                        <input readonly="readonly" id="sadd2view" class="formfield"  type="text" name="prefix"/>
                        </div>
                        </td>
                        
                    </tr><tr><td>
                        
                        
                         <div id="form-span" class="form-span-left"><label>City</label><br/>
                        <input readonly="readonly" id="cityview" class="formfield"  type="text" name="prefix"/>
                        </div>
                         </td><td>
                        <div id="form-span" class="form-span-right"><label>State/Province/County</label><br/>
                        <input readonly="readonly"  id="stateview"class="formfield"  type="text" name="prefix"/>
                        </div>
                             </td><td>
                        <div id="form-span" class="form-span-justified"><label>Postal Zip</label><br/>
                            <input id="zipview"  readonly="readonly" class="formfield" title="postal zip" type="text" name="prefix"/>
                        </div>
                        </td>
                        
                    </tr><tr><td>
                         
                         <div id="form-span" class="form-span-left"><label> </label><br/>
                        
                        </div>
                         </td><td>
                        <div id="form-span" class="form-span-right"><label> </label><br/>
                            <button id="basicEdited" style="display: none">&laquo;&nbsp;Save &nbsp&nbsp;&raquo;</button>
                        </div>
                             </td><td>
                        <div id="form-span" class="form-span-justified"><label> </label><br/>
                        </div> 
                             </td></tr></table>
          </div>
        
                          
        
        
       </div>
       <!--end dialogs !-->
        
        
        
        
        
        
        
        
        
    
    <div id="tabs-2">
        
        
        
         <div id="Formcont" style="background: transparent">  
            
           
             
             
             
            <table cellspacing="0" cellspadding="0">
                <tr><td></td><td></td> <td> 
             
                    </td></tr>
         <tr><td>
        
                      <div id="form-span" class="form-span-left"><label>Language 1</label><br/>
                          <select class="formfield" id="lang1view">
                          
                            <?php  
                            
                            $lang1=$data->Autoload_data("languages");
                             
                              
                              
                             for($i=0;$i<=count($lang1)-1;$i++){
                                 echo '<option value='.$lang1[$i]['langid'].'>'.$lang1[$i]['language'].'</option>';
                             
                             }
                            ?>
                          </select>
                                
                        </div>
             </td><td>
                         
                        <div id="form-span" class="form-span-right"><label>Language 2</label><br/>
                            <select class="formfield" id="lang2view">
                                
                             <?php  
                         
                            
                            
                             for($i=0;$i<=count($lang1)-3;$i++){
                                 echo '<option value='.$lang1[$i]['langid'].'>'.$lang1[$i]['language'].'</option>';
                             }
                             
                            ?>
                                
                            </select> 
                           
                        </div>
             </td><td>
                        <div id="form-span" class="form-span-justified"><label>Language 3</label><br/>
                            <select class="formfield"  id="lang3view">
                                 
                            <?php  
                           
                             
                            
                              
                             for($i=0;$i<=count($lang1)-3;$i++){
                                 echo '<option value='.$lang1[$i]['langid'].'>'.$lang1[$i]['language'].'</option>';
                             }
                             
                            ?>
                                
                                
                            </select>
                                          
                        </div>  
                    </td></tr>
               <tr><td>
                    
                
                   
                         <div id="form-span" class="form-span-left"><label>Language 4</label><br/>
                             <select class="formfield" id="lang4view">
                                 
                                
                            <?php  
                             
                              
                             for($i=0;$i<=count($lang1)-3;$i++){
                                 echo '<option value='.$lang1[$i]['langid'].'>'.$lang1[$i]['language'].'</option>';
                             }
                             
                            ?> 
                                 
                             </select>
                                 
                        </div>
                          </td><td>
                        <div id="form-span" class="form-span-right"><label>Language 5</label><br/>
                            <select  class="formfield" id="lang5view">
                                <?php  
                              
                             
                             
                             for($i=0;$i<=count($lang1)-3;$i++){
                                 echo '<option value='.$lang1[$i]['langid'].'>'.$lang1[$i]['language'].'</option>';
                             
                             }
                            ?> 
                             
                            </select> 
                         
                        </div>
                               </td><td>
                        <div id="form-span" class="form-span-justified"><label>Primary school attended</label><br/>
                           
                            <select class="formfield" id="pschidview">
                            
                            
                                
                            </select>
                                  
                        </div>  
                    </td></tr>
               <tr><td>
               
           
                 
                   
                   
                     <div id="form-span" class="form-span-left"><label>Secondary school attended</label><br/>
                         <select class="formfield" id="secidview">
                             
                             
                         </select>
                                  
                              
                        </div>
                          </td><td>
                        <div id="form-span" class="form-span-right"><label>Education level attained</label><br/>
                            <select class="formfield" id="eduqalview">
                                
                                 <option  selected="selected" value="None">None</option>
                                <option value="Peimary">Primary</option>
                                <option value="Secondary">Secondary</option>
                                <option value="Certificate">Certificate</option>
                                <option value="Diploma">Diploma</option>
                                <option value="Undergraduate">Undergraduate</option>
                                <option value="Graduate">Graduate</option>
                                <option value="Post Graduate">Post Graduate</option>
                                <option value="Double degree">Double degree</option>
                                <option value="Doctorate">Doctorate</option>
                                
                            </select>
                               
                        </div>
                               </td><td>
                        <div id="form-span" class="form-span-justified"><label>University/college attended</label><br/>
                            <select class="formfield" id="univview"> 
                            
                                                         </select>
                             
                        </div>
                  </td></tr>
                    <tr>
                        <td>
                        
                         <div id="form-span" class="form-span-left"><label>Education details</label><br/>
                             <input readonly="readonly"  class="formfield" type="text" id="specialityview"> 
                              
                             </input>
                              
                              
                             
                        </div>
                          </td><td>
                        <div id="form-span" class="form-span-right"><label>Attend Madrasa</label><br/>
                            <input maxlength="1" type="text" readonly="readonly" class="formfield" id="attmadrasaview"></input>  
                        </div>
                               </td><td>
                        <div id="form-span" class="form-span-justified"><label>Lisanudawat </label><br/>
                              
                              <input maxlength="2" readonly="readonly" type="text" class="formfield" id="lisanudawatview"></input>     
                        </div>
                         </td></tr>
                    <tr>
                
                   
                   <td>
                         <div id="form-span" class="form-span-left"><label> </label><br/>
                        
                        </div>
                        </td><td>
                         
                        <div id="form-span" class="form-span-right"><label> </label><br/>
                            <button id="edueditsave" style="display: none">&laquo;&nbsp;Save&nbsp&nbsp;&raquo;</button>
                        </div> </td><td>
                        <div id="form-span" class="form-span-justified"><label> </label><br/>
                        </div>  </td></tr>
            </table>
    
         </div>
        
        
        
        
        
        
        
    </div>
    <div id="tabs-3">
        
        
        
        
        
         <div id="Formcont" style="background: transparent">  
            
            
        
        
             <table cellspacing="0" cellspadding="0">
                 <tr><td></td><td></td><td>
            
                    </td></tr>
        
       <tr><td>
                         <div id="form-span" class="form-span-left"><label>House No.</label><br/>
                             <input readonly="readonly" class="formfield" id="hsenoview" title="hsenoview"  type="text" name="prefix"/>
                        </div>
                          </td>
           <td>
                        <div id="form-span" class="form-span-right"><label>House type</label><br/>
                            <input readonly="readonly" type="text" class="formfield" id="hsetypeview" > </input>
                            
                           
                        </div>
                               </td> </tr>
                     <tr><td>
                        
                         <div id="form-span" class="form-span-left"><label>Sector</label><br/>
                             <select class="formfield" id="sectorview"> 
                                                         </select>
                               
                                    
                        </div>
                          </td><td>
                        <div id="form-span" class="form-span-justified"><label>Mohala</label><br/>
                            <input readonly="readonly" type="text" class="formfield" id="moh1view" > </input>
                                                        
                        </div>
                        
                         </td><td>
                        <div id="form-span" class="form-span-right"><label></label><br/>
                               
                        </div>
                               </td></tr>
                    <tr><td>
                           
                         <div id="form-span" class="form-span-left"><label>House details</label><br/>
                             <textarea readonly="readonly" id="hsedetview" class="formfield"></textarea><br/>
                             
                        </div>
                        </td><td></td><td></td></tr>
                    <tr>
                        <td>
                        <div id="form-span" class="form-span-right"><label></label><br/>
                       
                        </div>
                             </td></td><td></td><td>
                    </tr>
                    <tr>
                           <td></td><td></td>
                        <td>
                         
                        <div id="form-span" class="form-span-right"><label> </label><br/>
                            <button id="hsesaveedit" style="display: none">&laquo;&nbsp;Save&nbsp&nbsp;&raquo;</button>
                        </div>
                                       </td></tr>
                         
                    </table>   
         </div>
        
        
        
        
        
        
    </div> 
        
          
    
    
    <div id="tabs-4">
       
        
        
        
        
        
        
         <div id="Formcont" style="background: transparent">  
            
           
            <table cellspacing="0" cellspadding="0">
                <tr><td></td><td></td><td>
             
                    </td></tr>
        <tr><td>
         
                      
                         <div id="form-span" class="form-span-left"><label>Spouse 1 Ejamaat No</label><br/>
                             <input onkeypress="return isNumberKey(event);" readonly="readonly" id="sp1view" maxlength="8" onkeyup="buildSpouses($.trim($(this).val()),'sone');" class="formfield"></input>
                             
                        </div>
            </td><td> 
                       
                         <div id="form-span" class="form-span-right"><label>Spouse 3 Ejamaat No</label><br/>
                             <input onkeypress="return isNumberKey(event);" readonly="readonly" id="sp3view" maxlength="8" onkeyup="buildSpouses($.trim($(this).val()),'sthree');" class="formfield"></input>
                             
                        </div>
                            
                       </td><td> 
                     
                         <div id="form-span" class="form-span-justified"><label>Spouse 2 Ejamaat No</label><br/>
                             <input onkeypress="return isNumberKey(event);" readonly="readonly"  id="sp2view" maxlength="8" onkeyup="buildSpouses($.trim($(this).val()),'stwo'); " class="formfield"></input>
                             
                        </div>
                            
                            </td></tr> 
                      <tr> <td> 
                    
                  
                         <div id="form-span" class="form-span-left"><label>Spouse 4 Ejamaat No</label><br/>
                             <input onkeypress="return isNumberKey(event);" readonly="readonly" id="sp4view" maxlength="8" onkeyup="buildSpouses($.trim($(this).val()),'sfour');" class="formfield"></input>
                             
                        </div>
                               </td><td> 
                            
                       
                    
                     
                         <div id="form-span" class="form-span-right"><label>Mother's Ejamaat No</label><br/>
                             <input onkeypress="return isNumberKey(event);" readonly="readonly" id="mothrview" maxlength="8" onkeyup="buildParents($.trim($(this).val()),'pone');" class="formfield"></input>
                             
                        </div>
                             </td><td> 
                       
                     
                         <div id="form-span" class="form-span-justified"><label>Father's Ejamaat No</label><br/>
                             <input onkeypress="return isNumberKey(event);" readonly="readonly" id="fthrview" maxlength="8" onkeyup="buildParents($.trim($(this).val()),'ptwo');"  class="formfield"></input>
                             
                        </div>
                             </td></tr> 
                      <tr><td> 
                    
                    
                         <div id="form-span" class="form-span-left"><label>Ikhwan 1 Ejamaat No</label><br/>
                            
                             <input onkeypress="return isNumberKey(event);" readonly="readonly"   id="ikno1view" maxlength="8" onkeyup="buildIkhwan($.trim($(this).val()),'one');" class="formfield"></input>
                             
                            
                      </div>   
                     </td><td> 
                     
                         <div id="form-span" class="form-span-right"><label>Ikhwan 3 Ejamaat No</label><br/>
                             <input onkeypress="return isNumberKey(event);" readonly="readonly" id="ikno3view" maxlength="8" onkeyup="buildIkhwan($.trim($(this).val()),'three');" class="formfield"></input>
                             
                          
                      </div>
                     </td><td> 
                     
                         <div id="form-span" class="form-span-justified"><label>Ikhwan 2 Ejamaat No</label><br/>
                             <input onkeypress="return isNumberKey(event);" readonly="readonly" id="ikno2view" maxlength="8" onkeyup="buildIkhwan($.trim($(this).val()),'two');" class="formfield"></input>
                             
                        </div> 
                          </td></tr> 
                      <tr><td>
                    
                    
                        
                        <div id="form-span" class="form-span-left"><label>Ikhwan 4 Ejamaat No</label><br/>
                             
                            <input onkeypress="return isNumberKey(event);" readonly="readonly" id="ikno4view" maxlength="8" onkeyup="buildIkhwan($.trim($(this).val()),'four');" class="formfield"></input>
                             
                            
                      </div>  
                               </td><td> 
                        
                         <div id="form-span" class="form-span-right"><label>Head of Ikhwan Ejamaat No</label><br/>
                             <select id="headiknoview" onclick="headIkwan();" class="formfield" onclick="headikwanEdit();"></select>
                             
                         </div>
                             
                       </td><td>
                    
                    
                     
                         <div id="form-span" class="form-span-justified"><label>Ikhwan 5 Ejamaat No</label><br/>
                             <input readonly="readonly" id="ikno5view" maxlength="8" onkeyup="buildIkhwan($.trim($(this).val()),'five');" class="formfield"></input>
                             
                          
                      </div>
                     </td></tr> 
                     
                     
                     
                
                    
                    <tr><td>
                        <div id="form-span" class="form-span-right"><label> </label><br/>
                            <button id="soceditsave" style="display: none">&laquo;&nbsp;Save&nbsp&nbsp;&raquo;</button>
                        </div>
                               </td><td> 
                        <div id="form-span" class="form-span-justified"><label> </label><br/>
                        </div> 
                                    </td> 
                                      <td>  </td></tr>
                    
            </table>   
        
    </div>
    </div> 
   
    <div id="tabs-5">
         
        
        
     
        
         <div id="Formcont" style="background:  transparent">  
            
           
              <table cellspacing="0" cellspadding=0"><tr><td></td><td></td><td>
            
              
        
                      </td></tr><tr><td>
        
     
                         <div id="form-span" class="form-span-left"><label>Height (feets)</label><br/>
                        <input onkeypress='return isNumberKey(event);' readonly="readonly"  class="formfield" id="heightdview"  type="text"/>
                        </div>
                      </td><td>
                        <div id="form-span" class="form-span-right"><label>Blood group</label><br/>
                            <select class="formfield" id="bgview"> 
                            <option value="A-ve">A-ve</option><option value="B-ve">B-ve</option><option value="AB-ve">AB-ve</option><option value="O-ve">O-ve</option><option value="A+ve">A+ve</option><option value="B+ve">B+ve</option><option value="AB+ve">AB+ve</option><option value="O+ve">0+ve</option>
                            </select>
                        </div>
                          </td><td>
         <div id="form-span"  class="form-span-justified"><label>Weight (Kgs)</label><br/>
                            
                         <input readonly="readonly" id="weightdview" onkeypress='return isNumberKey(event);' class="formfield"  type="text" />
                        </div>
                       </td></tr>
                    <tr><td>
                               
                               
                                      
                         
                         <div id="form-span" class="form-span-left"><label>Health Problem 1</label><br/>
                             <select class="formfield" id="hp1view">
                              <?php
                             $hp1=$data->Autoload_data("healthproblems");
                             if(!$hp1){
                                 echo '<option value=addx>--Add new problem--</option>'; 
                             }
                             else{
                             echo '<option value=9999>None</option>'; 
                             for($i=0;$i<=count($hp1)-1;$i++){
                                 echo '<option value='.$hp1[$i]['hpid'].'>'.$hp1[$i]['hpname'].'</option>';
                             }
                             }
                         ?>
                             </select>
                        </div>
                         </td><td>
                        <div id="form-span" class="form-span-right"><label>Health Problem 3</label><br/>
                            <select   class="formfield" id="hp3view"> 
                             <?php
                             
                             if(!$hp1){
                                 echo '<option value=addx>--Add new problem--</option>'; 
                             }
                             else{
                             echo '<option value=9999>None</option>'; 
                             for($i=0;$i<=count($hp1)-1;$i++){
                                 echo '<option value='.$hp1[$i]['hpid'].'>'.$hp1[$i]['hpname'].'</option>';
                             }
                             }
                         ?>
                            </select> 
                        </div>
                             </td><td>
                        <div id="form-span" class="form-span-justified"><label>Health Problem 2</label><br/>
                            <select  class="formfield" id="hp2view"> 
                             <?php
                             
                             if(!$hp1){
                                 echo '<option value=addx>--Add new problem--</option>'; 
                             }
                             else{
                             echo '<option value=9999>None</option>'; 
                             for($i=0;$i<=count($hp1)-1;$i++){
                                 echo '<option value='.$hp1[$i]['hpid'].'>'.$hp1[$i]['hpname'].'</option>';
                             }
                             }
                         ?>
                            </select>
                        </div>
                       </td></tr>
                    <tr><td>
                               
                        
                         <div id="form-span" class="form-span-left"><label>Health Problem 4</label><br/>
                         <select class="formfield" id="hp4view"> 
                         <?php
                             
                             if(!$hp1){
                                 echo '<option value=addx>--Add new problem--</option>'; 
                             }
                             else{
                             echo '<option value=9999>None</option>'; 
                             for($i=0;$i<=count($hp1)-1;$i++){
                                 echo '<option value='.$hp1[$i]['hpid'].'>'.$hp1[$i]['hpname'].'</option>';
                             }
                             }
                         ?>
                         </select>
                        </div>
                         </td><td>
                        <div id="form-span" class="form-span-justified"><label>Health Problem 5</label><br/>
                            
                            <select class="formfield" id="hp5view"> 
                            
                             <?php
                            
                             if(!$hp1){
                                 echo '<option value=addx>--Add new problem--</option>'; 
                             }
                             else{
                             echo '<option value=9999>None</option>'; 
                             for($i=0;$i<=count($hp1)-1;$i++){
                                 echo '<option value='.$hp1[$i]['hpid'].'>'.$hp1[$i]['hpname'].'</option>';
                             }
                             }
                         ?>
                            </select>
                           
                        </div>
                       </td><td>
                        <div id="form-span" class="form-span-right"><label></label><br/>
                       
                        </div>
                             </td></tr>
                    <tr><td>
                               
                          
                         <div id="form-span" class="form-span-left"><label> </label><br/>
                        
                        </div>
                            </td><td>
                         
                        <div id="form-span" class="form-span-right"><label> </label><br/>
                            <button id="heditsave" style="display: none">&laquo;&nbsp;Save&nbsp&nbsp;&raquo;</button>
                        </div>
                                </td><td>
                        <div id="form-span" class="form-span-justified"><label> </label><br/>
                        </div> 
                                    </td></tr>
              </table> 
        
         </div>
        
        
        
        
        
        
        
        
    </div>
    <div id="tabs-6">
      
        
        
        
        
         <div id="Formcont" style="background: transparent">  
            
             <table cellspacing="0" cellspadding=0"><tr><td></td><td></td><td>
             
                     </td></tr><tr><td>
         
                         <div id="form-span" class="form-span-left"><label>Wear dari?</label><br/>
                             <input maxlength="9" readonly="readonly" type="text" class="formfield" id="dariview"></input>
                        </div>
                     </td><td>
                        <div id="form-span" class="form-span-right"><label>Wear topi?</label><br/>
                            <input maxlength="9" readonly="readonly" type="text" class="formfield" id="topiview"></input>
                        </div>
                         </td><td>
                        <div id="form-span" class="form-span-justified"><label>Wear rida?</label><br/>
                            <input readonly="readonly" maxlength="9" type="text" class="formfield" id="ridaview"></input>
                        </div>
                       </td></tr>
                    <tr><td>
                       
                         <div id="form-span" class="form-span-left"><label>Viyaj</label><br/>
                             <input maxlength="6" readonly="readonly" type="text" class="formfield" id="viyajview"></input>
                        </div>
                         </td><td>
                        <div id="form-span" class="form-span-right"><label>Year Endowed</label><br/>
                            <input readonly="readonly" class="formfield" type="text" id="yoeview"/>
                        </div>
                             </td><td>
                        <div id="form-span" class="form-span-justified"><label>Title</label><br/>
                            <input readonly="readonly" class="formfield" type="text" id="titleview"/>
                        </div>
                       </td></tr>
                    <tr><td>
                       
                       
                        
                         <div id="form-span" class="form-span-left"><label>Haj</label><br/>
                             <input maxlength="5" readonly="readonly" type="text" class="formfield" id="hajview"></input>
                        </div>
                         </td><td>
                        <div id="form-span" class="form-span-right"><label>Ashara</label><br/>
                           
                             <input onkeypress='return isNumberKey(event);' readonly="readonly" class="formfield" type="text" id="asharaview"/>   
                        </div>
                             </td><td>
                        <div id="form-span" class="form-span-justified"><label>India</label><br/>
                          
                              <input onkeypress='return isNumberKey(event);' class="formfield" readonly="readonly" type="text" id="zindview"/>  
                        </div>
                                 </td></tr>
                       
                    <tr><td>
                       
                         <div id="form-span" class="form-span-left"><label>Zqah</label><br/>
                             <input onkeypress='return isNumberKey(event);' readonly="readonly" class="formfield" type="text" id="zqahview"></input>  
                        </div>
                         </td><td>
                        <div id="form-span" class="form-span-right"><label>Yemen</label><br/>
                                <input onkeypress='return isNumberKey(event);' readonly="readonly" class="formfield" type="text" id="zyemview"/>  
                        </div>
                             </td><td>
                        <div id="form-span" class="form-span-justified"><label>Jordan</label><br/>
                           <input onkeypress='return isNumberKey(event);' readonly="readonly" class="formfield" type="text" id="zjorview"/>   
                        </div>
                       </td></tr>
                    <tr>
                       <td>
                        
                         <div id="form-span" class="form-span-left"><label>Zbam</label><br/>
               <input type="text" onkeypress='return isNumberKey(event);' readonly="readonly" class="formfield" id="zbmview"/>  
                        </div>
                           </td><td>
                         
                        <div id="form-span" class="form-span-right"><label>Karbala</label><br/>
                                <input onkeypress='return isNumberKey(event);' class="formfield" readonly="readonly" type="text" id="zkarbview"/>  
                        </div>
                               </td><td>
                        <div id="form-span" class="form-span-justified"><label>Sham</label><br/>
                           <input onkeypress='return isNumberKey(event);' class="formfield" readonly="readonly" type="text" id="zshamview"/>   
                        </div>
                                   </td></tr>
                       
                    <tr><td>
                       
                       
                         
                         <div id="form-span" class="form-span-left"><label>Ummra</label><br/>
               <input type="text" onkeypress='return isNumberKey(event);' readonly="readonly" class="formfield" id="zummview"/>  
                        </div>
                            </td><td>
                         
                        <div id="form-span" class="form-span-right"><label>Qadbosi</label><br/>
                         
                             
                            <input readonly="readonly" id="qadbosiview" class="formfield"></input>
                             
                     
                            
                        </div>
                                </td><td>
                        <div id="form-span" class="form-span-justified"><label>Msharaf</label><br/>
                              
                              
                                <input readonly="readonly" id="msharafview" class="formfield"></input>
                        </div>
                                    
                       </td></tr>
                    
                    
                    
                    
                     <tr>
                    
                    
                      
                        
                    <td> 
                         <div id="form-span" class="form-span-right"><label>Msharaf date</label><br/>
                            
                              <input readonly="readonly" id="msharafdateview"    class="formfield"></input>
                          
                      </div>
                     </td><td> 
                    
                     
                         <div id="form-span" class="form-span-justified"><label>Shehesharif</label><br/>
                            
                             
                             <input readonly="readonly" id="shehesharifview" class="formfield"></input>
                      </div>
                     </td>
                     <td>
                           <div id="form-span" class="form-span-left"><label>ShehSharif date</label><br/>
                           
                              <input  readonly="readonly" id="shehesharifdateview"   class="formfield"></input>   
                     
                      </div>  
                     </td>
                     </tr>
                      
                     
                     
                       
                  <tr>  <td>
                       
                       
                      
                         <div id="form-span" class="form-span-left"><label> </label><br/>
                        
                        </div>
                        </td><td>
                         
                        <div id="form-span" class="form-span-right"><label> </label><br/>
                            <button id="deenieditsave" style="display: none">&laquo;&nbsp;Save&nbsp&nbsp;&raquo;</button>
                        </div>
                            </td><td>
                        <div id="form-span" class="form-span-justified"><label> </label><br/>
                        </div> 
                                </td></tr>
             </table>   
         </div>
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    </div>
     <div id="tabs-7" style="overflow: auto;background: transparent">
       
        
        
        
        
        
         <table cellspacing="0" cellspadding="0">
            
             <tr><td></td><td></td><td>
             
                 </td>
             
             </tr>
             <tr>
       
                 
                     <td>
                         <div id="form-span" class="form-span-left"><label>Occupation</label><br/>
                             <input type="text" readonly="readonly"   class="formfield" id="occupview"></input> 
                 
                        </div>
                         </td>
                     <td>
                         
                        <div id="form-span" class="form-span-right"><label>Business Category</label><br/>
                            <input type="text"  readonly="readonly" class="formfield" id="buscatview"> </input>
                          
                        </div>
                         </td>
                     <td>
                        <div id="form-span" class="form-span-justified"><label>Establishments</label><br/>
                             <input type="text"  readonly="readonly" id="estabview" class="formfield"/>
                        </div>
                       
                         </td>
                     
                    </tr> 
                       
                        <tr><td>
                         <div id="form-span" class="form-span-left"><label>Financial level</label><br/>
                             <input type="text"  readonly="readonly" class="formfield" id="finlevview"></input>
                        </div>
                         </td>
                     <td>
                         
                         
                         <div id="form-span" class="form-span-left"><label>Rent payable-Monthly</label><br/>
                  <input type="text" id="rentview"  readonly="readonly" class="formfield"/>
                        </div>
                        
                         </td>
                     <td>
                         
                         
                          
                        <div id="form-span" class="form-span-right"><label>Professional Sabil Amount</label><br/>
                         <input type="text"  readonly="readonly" id="psabamview" class="formfield"/>
                        </div>
                         
                         </td>
                     </tr>
                        <tr><td>
                      <div id="form-span" class="form-span-justified"><label>House sabil Amount </label><br/>
                            <input type="text"  readonly="readonly" id="hsabamview" class="formfield"/>
                        </div>
                   
                                
                                </td>
                     <td>
                         
                         
                         
                         
                         <div id="form-span" class="form-span-justified"><label>Enayat source</label><br/>
                            <select id="enayatfromview" class="formfield">
                            
                           
                            </select>
                     
                        </div>
                         
                         
                         
                         
                         </td>
                     <td>
                         
                                      
                    <div id="form-span" class="form-span-right"><label>Reasons for Enayat</label><br/>
                            <input id="enayatforview"  readonly="readonly" type="text" class="formfield"/>
                        </div>  
                         
                         
                         </td>
                     </tr>
                       
                     
                       
                       <tr><td>
                         <div id="form-span" class="form-span-left"><label>Qarzpay</label><br/>
                             <input type="text"  readonly="readonly" class="formfield"  id="qarzpayview"></input>
                        </div>
                        
                               </td>
                     <td>
                        <div id="form-span" class="form-span-right"><label>Qarzhan</label><br/>
                         <input id="qarzhanview" readonly="readonly" type="text" class="formfield"></input>
                        </div>
                         
                         </td>
                     <td>
                        <div id="form-span" class="form-span-justified"><label></label><br/>
                          
                        </div>
                         
                         </td>
                     
                       
                   
                       
                        
                       </tr><tr><td>
                         <div id="form-span" class="form-span-left"><label> </label><br/>
                        
                        </div>
                         </td>
                     <td>
                        <div id="form-span" class="form-span-right"><label> </label><br/>
                            <button id="financialseditsave"   style="display: none">&laquo;&nbsp;Save&nbsp&nbsp;&raquo;</button>
                        </div>
                         </td>
                     <td>
                        <div id="form-span" class="form-span-justified"><label> </label><br/>
                        </div> 
                         
                         </td>
                     
                      
                         </tr>
         </table>
        
        
        
        
        
        
         
    </div>  
     
     <div id="tabs-8">
         
       
    <table id="familytable" class="tenantview">
        
        
        
    
    </table>   
       
   
         
         
         
     </div>
     
     
     
     
</div>
        
  
  
  
  <div id="sabilsearchDiv" title="Quick family look up" style="display: none">
  <table class="dottedtable">
    
      <tr><td><label class="label1">Sabil number :</label></td><td><input  class="formfield-error" maxlength="5"  type="text" id="splitsabil" onkeyup="sabil_lookUp($(this).val());"/></td></tr>
 
</table>
    
    
<div id="lookup939"  style="display: block;width:90%;margin: 20px auto 0px auto;min-height:200px;max-height: 500px;height: auto;overflow-x: hidden;overflow-y: auto;background: transparent;padding: 20px 5px 20px 5px;border:1px gainsboro solid ">
    
    <table id="splittable" class="dottedtable">
        
       
    </table>   
       
    
    </div>
  </div>
  
     
         
         
         
         
         
       
      
         
         
         
         
         
         
         <?php
 }
 elseif ($action=="mohalla") {
 ?>
       <fieldset style="border: 1px gold solid"><legend style="color: #333;font-weight: bold;font-style: italic">Mumin Report</legend>
           <div>
               <button class="push_button red" id="hoejbutn"> HEAD OF FAMILY</button>
               <button class="push_button blue" id="listbutn"> LIST</button>
               </div>
       </fieldset>
         <?php
}
 ?>
         
  </div>
   
     
      
      
</div>  
</div>
</body>
</html>
<?php
}
?>