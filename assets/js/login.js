 $(function(){
     
 
  
  $("#binfo").live('click',function(){
      
     
   $("#login-message").removeClass("login-error").removeClass("login-progressing").removeClass("login-successful").addClass("login-info").html("<img align='left' height='40px' width='40px' src='/jims2/assets/images/info.png'/>&nbsp;Contact anjuman burhani for assistance");          
      
      
  });
  
   $("#usname").keypress(function(e){   
     
       if(e.keyCode===13){
            login();
       }
       
   });
   
   
    $("#pswd").keypress(function(e){   
       
       
       if(e.keyCode===13){
            login();
       }
   });
   
   
  
    $("#blogin").click(function(){ 
       alert('Test');
        login();
    
 });
     $("#blogin").keypress(function(e){ 
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
                 $("#login-message").removeClass("login-successful").removeClass("login-info").removeClass("login-progressing").addClass("login-error").html("<img align='left' height='40px' width='40px' src='../images/info.png'/>"+response.msg);          
             
                    }
                },
              error:function (xhr, ajaxOptions, thrownError){
                    
              $("#login-message").removeClass("login-successful").removeClass("login-info").removeClass("login-progressing").addClass("login-error").html("<img align='left' height='40px' width='40px' src='../images/info.png'/>"+thrownError);          
                   
                },
               beforeSend:function(){                       
                
             $("#login-message").removeClass("login-error").removeClass("login-info").removeClass("login-successful").addClass("login-progressing").html("<img align='left' height='40px' width='40px' src='../images/info.gif'/>Requesting...");
                
                }
                 
  
              });      
        
    }
  
 }
 });
 