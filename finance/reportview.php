<?php
session_start();
if(!$_SESSION['jmsloggedIn']){
   header("location:../index.php");
       
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>  
<head>  
<title>Estates</title> 

<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';

?>
</head>
    
    <body style="background:#FFF">
          
    <div id="topBar" style="background: #fff;width: 100%;height: 30px;margin: 0;-moz-border-radius-bottomleft: 5px;-moz-border-radius-bottomright: 5px;-webkit-border-bottom-left-radius: 5px;-webkit-border-bottom-right-radius: 5px;border-bottom-left-radius: 5px;border-bottom-right-radius: 5px"><button id="pcancel">Cancel</button><button id="pprint">print</button><button onclick="TriggerOutlook()" id="stemail">Email</button></div>
              
    <div id="xlogohead" style="width: 90%;margin: 0px auto 10px auto;border-bottom: 5px #000;height: 100px;background:#FFF"><img  style="float: left" width="100" height="100" src="../assets/images/gold new logo.png"></img><div id="titlesvi" style="padding-left: 10px;font-size: 24px;font-weight: bold">Anjuman burhani,Mombasa<br/>Mumin List</div></div>

    
 <?php
        
 include 'operations/Mumin.php';
 
 $mumin=new Mumin();
         
 
 
  $fields=  rtrim($_GET['fields'],',');
  
  $header=  explode(",",$_GET['fields']);
  
  //$moh=$_SESSION['mohalla'];
  
  $action=$_GET['action'];

  if($action=="general"){
  
  
 $q=$mumin->getdbContent("SELECT $fields FROM mumin ");      
     
 $numb=1;
             
 echo "<table class=ordinal>" ;   
        
  echo"<tr><th>SN</th>";
 for($i=0;$i<=count($header)-1;$i++){
     echo"<th>".$header[$i]."</th>";
 }
    
  echo"</tr>";
  
   for($j=0;$j<=count($q)-1;$j++){ 

   echo"<tr><td>".$numb."</td>";
       for($i=0;$i<=count($header)-2;$i++){
   
        echo"<td>".$q[$j][$header[$i]]."</td>";
       
       }
       echo '</tr>';
       $numb++;
 }
 echo"</table>";  
  }
  else{
      
       
  echo "<table class='invview'>" ;     
      
  $sabilnos=$mumin->getdbContent("SELECT DISTINCT sabilno FROM mumin WHERE sabilno IS NOT NULL ORDER BY sabilno ASC ");     
     
   
  echo"<tr><th>SN</th>";   
   
 for($i=0;$i<=count($header)-1;$i++){
     echo"<th>".$header[$i]."</th>";
 }
   echo"</tr>";
   
 
 for($j=0;$j<=count($sabilnos)-1;$j++){
 // echo"<tr><td></td><td style='font-size:20px;font-weight:bold'>".$sabilnos[$j]['sabilno']."</td>";
  
  //     for($i=0;$i<=count($header)-2;$i++){
     
  //      echo"<td></td>";
       
  //     }
  //     echo '</tr>';
     
     
  $q=$mumin->getdbContent("SELECT ".$fields." FROM mumin WHERE sabilno LIKE '".$sabilnos[$j]['sabilno']."' AND hofej = ejno");      
     
  
  $numb=1;
   
    
  
  
   for($m=0;$m<=count($q)-1;$m++){ 
    
      
   echo"<tr><td>".$numb."</td>";
       for($l=0;$l<=count($header)-2;$l++){
     
        echo"<td>".$q[$m][$header[$l]]."</td>";
       
       }
       echo '</tr>';
       $numb+=1;
 }
 
 }
 
 
 echo"</table>";  
  
      
      
      
      
      
      
      
      
      
      
  }
?>
    </body>
</html>