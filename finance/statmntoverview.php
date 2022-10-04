
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head runat="server">
<title>Statements</title>
 
<style type="text/css">
<!--
#report{ font-family:"Trebuchet MS"; width:100%; border-collapse:collapse; }
#report{ font-size:85%; text-align: left; }
.right{ text-align: right; }
#report th { background-color: #888; }
.messageCont{
    display: none;
    height: 160px;
    margin-top: 4px;
    padding:2px 0px 2px 10px;
    width: 100%;
    text-align: left;
    border-top: 2px greenyellow solid;
    background: url("../finance/images/s2.png") repeat;
}
.msgtext{
  width: 600px;
  height: 150px;
  float: left;

  background: #FDF5CE;
  border: 1px #FED22F solid;
}
.msgtext:focus{
  width: 600px;
  height: 150px;
  float: left;
  background: #FFF;
  border: 1px #FED22F solid;
}
.send-cancel{
    width: 98px;
    height: 40px;
    background: #EEE;
    border: 1px #CCC solid;
    margin-top: 20px;
     -moz-border-radius:10px;
    -webkit-border-radius:10px;
    border-radius:10px;
}
.send-cancel:hover{
    width: 98px;
    height: 40px;
    background: #FDF5CE;
    border: 1px #CCC solid;
    margin-top: 20px;
     -moz-border-radius:10px;
    -webkit-border-radius:10px;
    border-radius:10px;
}
@media print
{ 
    #report{ font-family:"Trebuchet MS"; width:100%; border-collapse:collapse; }
#printNot {display:none}
#estatesmsg {display:none}
thead {display: table-header-group;}
tfoot{display: table-footer-group; page-break-after:always;
            bottom: 0;}
}
-->
</style>
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';

 ?>

<script>
    
     $(function() {
   
   
  
    $("#pprint").button({
            icons: {
                primary: "ui-icon-print" ,
                        secondary:"ui-icon-document"
            },
            text: true
             
});

 $("#compose").click(function(){
   
    $("#estatesmsg").css("display","block") ;   
    
      //$("#messageCont").fadeIn(300) ;   
     
 });
  $("#cancelb").click(function(){
   
    $("#estatesmsg").fadeOut("slow") ;   
    
      //$("#messageCont").fadeIn(300) ;   
     
 });
  $("#pcancel").button({
            icons: {
                primary: "ui-icon-cross" ,
                        secondary:"ui-icon-circle-close"
            },
            text: true
             
});


  $("#stemail").button({  
            icons: {
                primary: "ui-icon-cross" ,
                        secondary:"ui-icon-mail-closed"
            },
            text: true
             
});

  $("#compose").button({  
            icons: {
                primary: "ui-icon-cross" ,
                        secondary:"ui-icon-mail-closed"
            }             
});
  $("#prntsabl").button({  
            icons: {
                primary: "ui-icon-cross" ,
                        secondary:"ui-icon-print"
            }             
});
   $("#closestmnt").button({  
            icons: {
                primary: "ui-icon-cross" ,
                        secondary:"ui-icon-close"
            },
            text: true
             
});
    });

   function TriggerOutlook()  //trigger ms office outlook  mail client

    {        


        
        var body="Your statement is ready please pick  it";

        var subject = "Anjuman -e Burhani Statements";
        
        var $emails="";
        
         var $cc="";
        
        var $bcc="";

                 window.location.href = "mailto:"+$emails+"&bcc="+$bcc+"&cc="+$cc+"&body="+body+"&subject="+subject;               

            }    
 function sendpdf(){
     var $param = $("#paramid").val();
        
     var $start = $("#startid").val();
     var $end = $("#endid").val();
     var $sabil = $("#sabilid").val();
     var $account =$("#accountid").val();
     var $debtorid = $("#debtorid").val();
     var $emailtxt = $("#estmsgtext").val();
    // var $emailaddress = $("#emailid").val();
     //window.open('data:application/pdf,' + encodeURIComponent($('#printableArea').html()));
    //e.preventDefault();
    basicLargeDialog("#d_progress",50,150);
    $(".ui-dialog-titlebar").hide();
    window.location= "../finance/pdf.php?param="+$param+"&sabil="+$sabil+"&start="+$start+"&end="+$end+"&account="+$account+"&debtor="+$debtorid+"&content="+$emailtxt;
     //"&emailaddress="+$emailaddress
     //estates/sabil_statement.php?param=sabil&sabil='+$sabil+'&start='+$startdate+'&end='+$enddate+'&account='+$stataccount+'',
   
    
}
</script>
</head>
    
    <body style="background: white">
        
 <div align="center" id="printNot">
<button id ="prntsabl" class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print Statement</span></span></span></button>
<button id="closestmnt" class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
<button class="sexybutton sexymedium sexyyellow" id="compose"><span><span><span class="cancel">Email</span></span></span></button>
 </div>
<br />
       <div id="estatesmsg" class="messageCont" style="display: none"> <!-- hidden message box editor v1!-->
 <textarea class="msgtext" id="estmsgtext" max-height="150px" max-width="600px" placeholder="Type to compose"></textarea>  
 <div id="messageContright">
     &nbsp;&nbsp;<button class="send-cancel" id="send" onclick="sendpdf();">Send</button> <br>   
 &nbsp;&nbsp;<button class="send-cancel" id="cancelb" >Cancel</button>  
 </div> 
 </div>
        <?php

echo '<div id="printableArea">';
//echo ''
echo '<table width="100%" border="0">';   
echo '<tr>';
echo '<td style="width:200px"> <img src="../assets/images/mqhtlogobwmedium.jpg"  height="80" width="120" /></img> </td>';
echo '<td colspan="2">';
echo '<b><i><font size="5" >Mohammedi Qardhan Hassana Trust&nbsp;</font></i></b><br />';
echo '<span style="font-size:70%" >P.O Box 81766-80100, Tel: 020-2040372, Mombasa, Kenya<br>
        Mobile: 0732911777, Email: qardan@msajamaat.org';
echo '</span>';
echo '</td>';
echo '</tr> ';
echo '</table>';
echo '<div align="right"><font size="5"><b>STATEMENT</font></b> </div>';
echo '<hr />';
echo '<div><table id="report" style="font-size:14px;padding:10px;margin-left:10px;margin-right:10px;">';
echo '<tr><td >Account No: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Account Name: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b> </b></td><td>&nbsp;&nbsp;&nbsp; TEL NO : </td></tr>';
echo '<tr><td style="text-transform:uppercase;"></td><td style="text-align:Center"><span></span>  </td></tr>';
echo '<tr><td>Account Transaction List From:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b></b>&nbsp;&nbsp; to &nbsp;&nbsp;&nbsp;&nbsp;<b></b></td></tr>'; 
echo '</table></div>';
echo '<hr />';
echo '<br />';

echo '<table id="report" style="font-size:14px; border-collapse:separate;border-spacing:0 5px;margin-left:10px;margin-right:10px;" >';
echo '<thead><tr><th> Date</th><th style="width: 10px;"></th><th > Doc. No.</th> <th>Narration</th><th style="text-align: center;">Debit</th> <th style="text-align: center;"> Credit</th> <th style="text-align: center;"> Balance</th></tr></thead>';
echo '<tbody><tr><td colspan="7"><hr></td></tr>';
       

  
      
       
 //$empty_temp=$mumin->updatedbContent("DROP TABLE $tbname"); //delete contents  of temp table  in readness for next  operation

echo'</tbody>';

 echo' <tfoot>
     <tr><td> <br></br><br></br><br></br><br></br><br></br><br></br><br></br><br></br><br></br><br></br><br></br><br></br><br></br><br></br>&nbsp<br></br></td></tr>
         <tr><td style="border-top: 3px solid #000" colspan="7"><h5>Please check your balance and bring any discrepancies within 15 days</h5>
         <span align="left" style="font-size:x-small;">Printed by: Angela  &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span></td> </tr></tfoot></table><br />';
echo '
';

echo '<div id="report"></div> <br /><br />';
echo '<div>';

echo '</div> ';

?>
          
     <?php
      echo '</div>'; 
     ?> 

 </div>

 
</body>
    
</html>
