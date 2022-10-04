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

if($priviledges[0]['database']!=1){
   
header("location: index.php");
}
if($priviledges[0]['readonly']==1){
    $displ = 'display: none';
}else if($priviledges[0]['readonly']!=1){
    $displ = '';
}
}
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<title></title>
<?php
date_default_timezone_set('Africa/Nairobi');
include '../partials/stylesLinks.php';  
 
include 'links.php';

?>
 
</head>
    <style>
        .filterlabel{
    float: left;
    font-size: 12px;
    line-height: 30px;
    vertical-align: middle;
    color: #F6AF3A;
    margin-left: 2px;
}
.tbb td
{
    height: 20px;
    text-align: left;
    border-bottom:1px lightgrey solid;

}
.tbb tr {
    border-collapse: collapse;
}
.filterInput{
    font-size: 19px;
    color: #CCC;
    font-style: normal;
    text-align: center;
    text-transform: capitalize;
    height: 30px;
    float: left;
    
    width: 200px;
    margin:4px 0px 0px 50px;
    border: 1px #F6AF3A solid;
}
@media print
{ 
#printNot {display:none}
thead {display: table-header-group;}
tfoot{display: table-footer-group;}
@page { counter-increment: tfoot }

}
        
    </style>
	<script>
	
    function prnttoexcel(e){
    
     window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#printableDiv').html()));
    e.preventDefault();
		}
      </script>
    <link rel='stylesheet' type='text/css' href='properties/js/print.css' media="print" />
<body> 
<div align="center" id="printNot">
<button class="sexybutton sexymedium sexyyellow" onclick="window.print();" id="prntst"><span><span><span class="print">Print Report</span></span></span></button>
<button class="sexybutton sexymedium sexyyellow" onclick="window.close();" id="closest"><span><span><span class="cancel">Close</span></span></span></button>
<img src='images/excelicon.png' onclick='prnttoexcel()' align ="right"></img>
</div>
 
  <div id="printableDiv">
<?php
    
    $action=$_GET['action'];
    $color=0; $count7=0; $counting = 0;
    $mumin=new Mumin();
    if($action=="hofej"){?>
        <div id="filterbar" style="display:none"><label class="filterlabel">Filter by sabilno :</label> <input type="text" name="filter"  onkeyup="filter(this,'tab1',2)" class="filterInput" id="sabilno"></input></div>
        <?php 
        echo "<div id='notatt'>";
        echo "<u  class='lab' style='float:left;margin-left:8px'> </u><br/>" ; 
  
echo "<table id='tab1' style='text-align:left;width:840px;font-size:11px;font-family:verdana;font-weight:normal' class='tbb'><thead>"; 
//echo "<tr style='text-align:center;font-size:11px;font-family:verdana'>  </tr> ";
echo "<tr><th colspan='7' style='text-align:center; font-size:14px;'> Anjuman-e-Burhani</th></tr>";
echo "<tr><th colspan='7' style='text-align:center; font-size:14px;'>Head Of Family </th></tr>";
echo "<tr style='text-align:left;font-size:11px;font-family:verdana'><th>S.No</th><th>Mohalla</th><th>Sabil No</th><th>House No</th><th>Name</th><th>Contacts</th></tr></thead>";
	
    $mumnqry = $mumin->getdbContent("SELECT distinct(sabilno)as sabilno,moh,hseno,ejno,smsmobile FROM mumin WHERE ejno=hofej  and status ='A' order by moh,sabilno");
   
	for($t=0;$t<count($mumnqry);$t++){
        if($color==1)  {
        
  $color2="aliceblue";
        
    }
    elseif($color==0){
        
  $color2="white"  ;
      
    }
        $ejano = $mumnqry[$t]['ejno'];
        $muminsector = $mumnqry[$t]['moh'];
        $muminsabil = $mumnqry[$t]['sabilno'];
        $muminhseno =  $mumnqry[$t]['hseno'];
        $mumintel = $mumnqry[$t]['smsmobile'];
        $muminame = $mumin->get_MuminNames($ejano);
         $counting = $counting +1;
        echo "<tr style='background-color:$color2'><td>$counting</td><td>$muminsector</td><td>$muminsabil</td><td>$muminhseno</td><td>$muminame</td><td>$mumintel</td></tr>";
   
    if($color==1){
     
     $color=0;
 }
 else{
     $color=1;
 } 
       
 }
 echo '<tfoot><tr><td colspan="5"><br></br><br></br>Printed on &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</td></tr></tfoot>';
echo "</table>";
    echo "</div>";    
    }
    else if($action=="list"){?>
       <!-- <div id="filterbar" ><label class="filterlabel">Filter by sabilno :</label> <input type="text" name="filter"  onkeyup="filter(this,'tab1',4)" class="filterInput" id="sabilno"></input><div id="filterbarRight"><button id="sendmail" class="sendmail">Send email</button><button class="printBt" id="printmohRec">print</button><img src='/ashara/images/excelicon.png' onclick='prntmohattdnce()'></img></div></div>--!>
        <?php 
        
 
    echo "<div id='notatt'>";
        echo "<u  class='lab' style='float:left;margin-left:8px'> </u><br/>" ; 
  
echo "<table id='tab1' style='text-align:left;width:840px;font-size:11px;font-family:verdana;font-weight:normal' class='tbb'>"; 
//echo "<tr style='text-align:center;font-size:11px;font-family:verdana'>  </tr> ";
echo "<tr><th colspan='7' style='text-align:center; font-size:14px;'>FAMILY WISE LIST  </th></tr>";
echo "<tr><th colspan='7' style='text-align:center; font-size:14px;'> Anjuman-e-Burhani</th></tr>";
echo "<tr style='text-align:left;font-size:11px;font-family:verdana'><th></th><th>Mohalla</th><th>Sabil No</th><th>House No</th><th>Name</th><th>Phone No</th></tr>";
       
			$mumnqry = $mumin->getdbContent("SELECT sabilno,moh,hseno,ejno,smsmobile FROM mumin WHERE status = 'A' order by moh,sabilno");
		
	for($t=0;$t<count($mumnqry);$t++){
        if($color==1)  {
        
  $color2="aliceblue";
        
    }
    elseif($color==0){
        
  $color2="white"  ;
      
    }
        $ejano = $mumnqry[$t]['ejno'];
        $muminsector = $mumnqry[$t]['moh'];
        $muminsabil = $mumnqry[$t]['sabilno'];
        $muminhseno =  $mumnqry[$t]['hseno'];
        $mumintel = $mumnqry[$t]['smsmobile'];
       // if($mumnqry[$t+1]['sabilno'] == $mumnqry[$t]['sabilno']){
        //    $count7 =  $count7;
       // } else{
            $count7 = $count7 +1;
       // }
        $muminame = $mumin->get_MuminNames($ejano);
        echo "<tr style='background-color:$color2'><td>$count7</td><td>$muminsector</td><td>$muminsabil</td><td>$muminhseno</td><td>$muminame</td><td>$mumintel</td></tr>";
   
    if($color==1){
     
     $color=0;
 }
 else{
     $color=1;
 } }
  
                    
  echo '<tfoot><tr><td colspan="5"><br></br><br></br>Printed on &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</td></tr></tfoot>';
echo "</table>";
      echo "</div>";  
    }
?>
      </div>
</html>