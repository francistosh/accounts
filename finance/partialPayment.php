<?php
session_start(); 

if(!(isset($_SESSION['eloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  
    $level=$_SESSION['acc'];
    
    if($level!=999){
  
        header("location: ../index.php"); 
        
    }
    else{
   
include '../muminoperations/Mumin.php';

$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE id LIKE ".$_SESSION['priviledge']." LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);

if($priviledges[0]['payments']!=1){
   
header("location: index.php");
}
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head>
<title>finance | Mombasa Jamaat  Information System</title>
    
 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';
 

?>
     
<script>
    
    
$(function() {
    
   
   $("#tabs").tabs();
   
   
     //$("#oc" ).datepicker({ dateFormat: 'yy-mm-dd'} );
     $("#dt100part" ).datepicker({ dateFormat: 'dd-mm-yy'} );
      $("#paymentdt100part" ).datepicker({ dateFormat: 'dd-mm-yy'} );
     $("#ckdate100part" ).datepicker({ dateFormat: 'dd-mm-yy'} );
  
   $("#invprint201").button({
            icons: {
                primary: "ui-icon-check",
                secondary: "ui-icon-print" 
            }
        });
    
     $("#ckreceiptpart").button({  
            icons: {
                primary: "ui-icon-check",
                secondary: "ui-icon-cart" 
            }
        });
        
         
   
     $("#cshreceiptpart").button({
            icons: {
                primary: "ui-icon-check",
                secondary: "ui-icon-cart" 
            }
        });
    
    $("#rcptprintpart").button({
            icons: {
                primary: "ui-icon-check",
                secondary: "ui-icon-print" 
            }
        });
    
    
        $("select").addClass("formfield");  
 
    $("input").addClass("formfield");
  
  
   
   
  
    });
 
</script>
<link rel='stylesheet' type='text/css' href='properties/js/print.css' media="print" />
 
</head>
   
<body style="overflow-x: hidden;"> 
  
    <?php
    
                                
                                
                                $id=$_SESSION['est_prop'];
                                
                                $qr11="SELECT ccname FROM costcenters WHERE ccid LIKE '$id' LIMIT 1";
                               
                                 $data11=$mumin->getdbContent($qr11);
                                
                                 $estname=$data11[0]['ccname'];
    ?>
   
    
<div id="div_browsercontainer">
   
 
     <?php
     $account=$_GET['account'];
       
     $qr1="SELECT * FROM estate_incomeaccounts i JOIN estate_bankaccounts e ON  e.acno=i.bankaccount WHERE i.estateid LIKE '$id' AND i.id LIKE '$account' LIMIT 1";
                                
     $check=$mumin->getdbContent($qr1);
     if($check){
     ?>
 
    
     
    <input id="sabilnopart" value="<?php echo $_GET['sabilno'];?>" type="hidden"></input>
    <input id="invnopart" value="<?php echo $_GET['invno'];?>" type="hidden"></input>
     
   <input id="datepart" value="<?php echo $_GET['date'];?>" type="hidden"></input>
   
    <input id="deptpart" value="<?php echo $_GET['account'];?>" type="hidden"></input>
    
      <input id="debtorpart" value="<?php echo $_GET['debtor'];?>" type="hidden"></input>
      
      
           
     <div id="tabs" style="display: block;width: 780px;height: auto;margin-top: 10px;">  
    <ul>
       
    <li><a href="#CHQ">CHEQUE</a></li>
    <li><a href="#CSH">CASH</a></li>
        
         
    </ul>
    <div id="CHQ"> 
        <div id="highlighter-tips">Fields marked with  * are mandatory</div>
        
        <table class="ordinal"> <!--if cheque !-->
            
            
            
          <tr><td>Payment Date:&nbsp;*</td><td><input readonly="true" type="text" id="paymentdt100part" class="text-input" value="<?php echo date('d-m-Y'); ?>"></input></td></tr>            
           
           <tr><td>Cheque Date:&nbsp;*</td><td><input id="ckdate100part" type="text" class="text-input"></input>
                     
                    </td></tr>   
                    <tr><td>Cheque No:&nbsp;*</td><td><input id="ckno100part" type="text" class="text-input"></input></td></tr>  
                    <tr><td>Amount:&nbsp;*</td><td><input value="0.00" id="ckamount100part"  onkeypress="return isNumberKey(event);"   type="text" class="text-input"></input></td></tr>   
                    
                    <tr><td>Cheque details:&nbsp;*</td><td><input id="ckdetails100part" type="text" class="text-input"></input></td></tr> 
                     
                    
                    
                    
                    
                    <tr><td>Bank Account:&nbsp;*</td>
                        <td>
        <select id="bankaccountpart" readonly="readonly">
                                <?php
                                  
                                 
                                  $qr1="SELECT * FROM estate_incomeaccounts i JOIN estate_bankaccounts e ON  e.acno=i.bankaccount WHERE i.estateid LIKE '$id' AND i.id LIKE '$account' LIMIT 1";
                                
                                  $data5=$mumin->getdbContent($qr1);
                                
                                  for($k=0;$k<=count($data5)-1;$k++){ 
                      
                                     echo "<option value=".$data5[$k]['acno'].">".$data5[$k]['acno']."-".$data5[$k]['acname']."</option>";
                                   }
                            
                            
                            ?>
                  
        </select>
                        
                        </td>
                    </tr>
                    
                    
                    
                    
                    <tr><td>Being payment of:&nbsp;*</td><td><textarea  id="ckrmks100part" class="formfield" ></textarea></td></tr> 
                    
                    <tr><td></td><td><button id="ckreceiptpart">complete</button></td></tr>   
                </table>  
                    
           
        
        
        
         
        
       </div>     
              
         
      <div id="CSH">               
             
        <div id="highlighter-tips">Fields marked with  * are mandatory</div>
          
        
        <table class="ordinal"> <!--if cash !-->
                     
                        <tr><td>Date:&nbsp;</td><td><input readonly="true" type="text" id="dt100part" class="text-input" value="<?php echo date('d-m-Y');?>"></input></td></tr>   
                        <tr><td>Cash  amount:&nbsp;</td><td><input value="0.00"    onkeypress="return isNumberKey(event);" type="text" id="cshamount100part" class="text-input"></input></td></tr>   
                        
                        
                         
                        <tr><td>Bank Account:</td>
                        <td>
                          <select id="bankaccount100part" readonly="readonly">
                                <?php
                                  
                                  
                                
                                  for($k=0;$k<=count($data5)-1;$k++){ 
                      
                                     echo "<option value=".$data5[$k]['acno'].">".$data5[$k]['acno']."-".$data5[$k]['acname']."</option>";
                                   }
                            
                            
                            ?>
                  
        </select>
                        
                        </td> 
                    </tr>
                    <tr><td>Being payment of </td><td><textarea id="cshrmks100part"  class="formfield"></textarea></td></tr> 
                       <tr><td></td><td><button id="cshreceiptpart">complete</button></td></tr>   
                </table>      
          
       </div>  
        
         
  </div>
    
    
    
 <?php
 
 
 
 
 ?>
    
    
    
    
    
    
    
    
        
  
   
              
 <div id="d_progress" style="display: none;background: transparent;border: none;text-align: center;vertical-align:middle; line-height: 50px;padding-top: 10px">
 <img align="center" src="../assets/images/icon_animated_prog_dkgy_42wx42h.gif"></img>
 </div>  
  <div id="print_panel" style="width:600px;display: none;height:25px;background: #ccffcc;border: 1px #fff solid; margin: 1px auto 1px auto;padding: 10px;text-align: right;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px"><button id="rcptprint">print</button></div>
  <div id="receiptnode" style="width:600px;display: none;height:auto;background: #FFF;border: 1px #000 solid; margin: 0px auto 2px auto;padding: 10px;">
                          
  </div>      
  
</div>
 <?php
  }
  else{
      echo "We were unable to link this account .Please contact admin for assistance";
  }
  ?>
   
     
     
</body>
</html> 