<?php 
session_start(); 
$title="Ziara | Accounts Login ";
 
if(!isset($_SESSION['jmsloggedIn'])) {
   
?>


<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ACCOUNTS | Login</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
<link href="assets/css/fa/css/font-awesome.min.css" rel="stylesheet">
<link href="assets/css/cool.css" rel="stylesheet">

<link href="assets/css/site.css" rel="stylesheet">


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
  
 <link  type="text/css" href="assets/css/bootstrap.min.css" rel="stylesheet"/>

<link  type="text/css" href="assets/css/login.css" rel="stylesheet"/>
<script src="assets/js/login.js"></script>
<script src="assets/js/framework/jquery-1.8.3.js"></script>
<script>

 $(function(){
     
     
         $("#blogin").click(function(){ 
      login();
     
      });
          $("#usname").keypress(function(e){  //sabil no field click;
       
       if(e.keyCode===13){
           
             login();
       }
       
       
   });
             $("#pswd").keypress(function(e){  //sabil no field click;
       
       if(e.keyCode===13){
           
             login();
       }
       
       
   });
       function login(){
      var $usname=$.trim($("#usname").val());
    
    var $pwd=$.trim($("#pswd").val());
    
      //alert($usname);
    
    if($usname==="" || $pwd===""){
        
       $("#login-message").removeClass("login-successful").removeClass("login-info").removeClass("login-progressing").addClass("login-error").html("<i class='fa fa-warning redfont'></i>Username/password cannot be empty") ;            
       
     }
   
    else{
        
   
    var $dataString={usname:$usname,pwd:$pwd};
     
    var $urlString="general/logindata.php/?action=login"; 

               $.ajax({                                                                        
                
                url: $urlString,
                
                type: "GET",
                
                dataType:"json",
                
                contentType: "application/json",
               
                cache: false,
                
                data:$dataString,
                
                success: function(response) {
                 
                  
                 
              if(response.id===1){
                  $("#login-message").css("display","none") ;  
                
                 $("#b_mumin").css("background","gray");
                 
                 window.location="home/"; 
                    
                 }  
             
             else{
                 $("#login-message").removeClass("login-successful").removeClass("login-info").removeClass("login-progressing").addClass("login-error").html("<img align='left' height='40px' width='40px' src='assets/images/cross.png'/>"+response.msg);          
             
                    }
                },
              error:function (xhr, ajaxOptions, thrownError){
                    
              $("#login-message").removeClass("login-successful").removeClass("login-info").removeClass("login-progressing").addClass("login-error").html("<img align='left' height='40px' width='40px' src='assets/images/cross.png'/>"+thrownError);          
                   
                },
               beforeSend:function(){                       
                
             $("#login-message").removeClass("login-error").removeClass("login-info").removeClass("login-successful").addClass("login-progressing").html("<img align='left' height='40px' width='40px' src='../images/green_rot.gif'/>Requesting...");
                
                }
                 
  
              });      
        
    }
  
 }
 });

</script>
      
</head> 

<body >    
  
     <div class="form-box"  id="login-box" >
    <div class="row"><div class="col-md-3"></div><div class="col-md-6"><center><img src="assets/images/anjumangold.png"></center></div><div class="col-md-3"></div></div>
    <div class="header bg-green-gradient"><i class="fa fa-lock"></i>&nbsp;<?php echo $title?></div>

                <div class="body bg-gray">
                    <div class="form-group">
                        <input name="usname" type="text" id="usname" placeholder="Username" class="form-control"  />
                        
                      
                    </div>
                    <div class="form-group">
                        <input name="pswd" type="password" class="form-control" placeholder="Password" maxlength="30" id="pswd" />
                        
                       
                    </div>
                   
                   
                </div>
                <div class="footer">
              
                    <button name="blogin" class="btn bg-green btn-block" id="blogin" >Login</button>
                    <p><a class="pull-left" href="http://abmsasvr/jims/"><i class="fa fa-arrow-circle-o-left"></i>&nbspBack To Jims 2.0</a>&nbsp;</p>
                    
<div style="width: 280px" id="login-message"></div>
                   

                    
                </div>
 

           
        </div>
  
  
  
  
    
    
    
</body>

</html>
<?php

}
else {

        header("location:finance/index.php");  
    if($_SESSION['jmsgrp'] =="ADMIN"){
      
      header("location:finance/index.php");  
      
    }
   
  else if($_SESSION['jmsgrp'] =="EXTERNAL"){
     
        header("location:finance/index.php"); 
        
    }  
    
}
?>