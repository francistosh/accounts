 <?php
session_start(); 

if(!(isset($_SESSION['eloggedIn']))) {  
    
header("location: ../index.php");

}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    
<head>
    
<title>Estates</title> 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';


$usr=$_SESSION['uname'];  
 
$access=$_SESSION['grp'];   

$id=$_SESSION['est_prop'];

if($access!="ADMIN"){
    
  
    header("location: ../index.php");
}
 
?>

<script>
    
  $(function() {
    var $counties=new Array('Mombasa','Kwale','Kilifi','Tana River','Lamu','Taita Taveta','Garissa','Wajir','Mandera','Marsabit','Isiolo','Meru','Tharaka Nithi','Embu','Kitui','Machakos','Makueni','Nyandarua','Nyeri','Kirinyaga','Muranga','Kiambu','Turkana','West Pokot','Samburu','Trans Nzoia','Uasin Gishu','Elgeyo/Marakwet','Nandi','Baringo','Laikipia','Nakuru','Narok','Kajiado','Kericho','Bomet','Kakamega','Vihiga','Bungoma','Busia','Siaya','Kisumu','Homa Bay','Migori','Kisii','Nyamira','Nairobi City');
   var tooltips = $( "[title]" ).tooltip();     
     
  $("#esttanzeem1" ).autocomplete({source: ejamaatNos}); $("#esttanzeem2" ).autocomplete({source: ejamaatNos}); $("#esttanzeem3" ).autocomplete({source: ejamaatNos});
 
  $("#esttanzeem4" ).autocomplete({source: ejamaatNos}); $("#esttanzeem5" ).autocomplete({source: ejamaatNos});$("#estmasoul" ).autocomplete({source: ejamaatNos});$("#estmusaeed" ).autocomplete({source: ejamaatNos});
 
 $("#estcounty" ).autocomplete({source: $counties});
  
   $('select').selectbox();
   
   
  
  $("#xxxad").button({
            icons: {
                primary: "ui-icon-disk" ,
                        secondary:"ui-icon-check"
            },
            text: true
             
});
  $("#xxxcancel").button({
            icons: {
                primary: "ui-icon-cancel" ,
                        secondary:"ui-icon-circle-close"
            },
            text: true
             
});
 
 });   
 
</script>
</head>  
    
<body style="overflow-x: hidden"><div id="hd">
<div id="menubar">
    <font class="ttfont">Estates control panel</font>
</div>

    </div>     
    <div id="_outstanding_invoices" style="width: 70%;height:40px; border:1px #BDE5F8 solid;line-height: 10px ;vertical-align: middle;background: transparent; margin: 2px auto 2px auto;padding: 0 10px 0px 10px;border-radius: 5px;-webkit-border-radius: 5px;-moz-border-radius: 5px">   
         
        <p class="p-font"><a href="setup.php">Go Back </a>&nbsp;<font class="p-font" style="float: right">|Current User : <?php echo $_SESSION['uname']."|&nbsp;Login Time :".$_SESSION['logintime']; ?> |&nbsp;<a href="logout.php">LOGOUT</a>|</font></p>  
        
   </div>
    
   <div id="estate-area_det" style="background: transparent;height: auto;min-height: 500px;width: 70%;padding: 1px 10px 10px 10px;border:1px #BDE5F8 solid;margin: 5px auto 5px auto;border-radius: 5px;-webkit-border-radius: 5px;-moz-border-radius: 5px">
   <?php
      
    $id=$_GET['id'];
   
   $action=$_GET['action'];
   
   ?>
   
   </div>
  <?php include_once '../partials/footer.php';?>
    
</body>
</html>