<?php
session_start(); 
date_default_timezone_set('Africa/Nairobi');
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
   
include './operations/Mumin.php';

$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE userid = '$userid' AND deptid = '$id' LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);

if($priviledges[0]['statements']!=1){
   
header("location: index.php");
}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head runat="server">
<title>Statements</title>
 
<style type="text/css">
<!--
#report{ font-family:"Trebuchet MS"; width:100%; border-collapse:collapse; }
#report{ font-size:12px; text-align: left; }
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
    
    <body style="background: white;overflow-x: visible!important;">
        
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
        $param=$_GET['param'];
        $start1=$_GET['start'];
		$start = substr($start1,8,2)."-".substr($start1,5,2)."-".substr($start1,0,4);
        $end1=$_GET['end'];
		$end = substr($end1,8,2)."-".substr($end1,5,2)."-".substr($end1,0,4);
        $estId = $id;
        $account=$_GET['account'];
       
        if($param=="sabil"){
        $sabil=$_GET['sabil'];
        
        $ej=$mumin->get_MuminHofEjnoFromSabilno($sabil);
        
        $muminSector=$mumin->getdbContent("SELECT sector, moh, email, hseno FROM mumin WHERE ejno LIKE '$ej'");
        $statementRecevee=$mumin->get_MuminHofNamesFromSabilno($sabil)."<br/>Mohalla :&nbsp;&nbsp;".$muminSector[0]['moh'];
        $email= $muminSector[0]['email'];
		$hseno= $muminSector[0]['hseno'];
        $display = "display: block";
        @$msector= $muminSector[0]['sector']; $debtelno ='';
        //$toStatement= $start."&nbsp;TO&nbsp;".$end."<br/>Sabil No :<font style='text-transform:uppercase'>".$sabil."</font><br/>HOF Ejamaat No :".$mumin->get_MuminHofEjnoFromSabilno($sabil); 
        if($account== 'all'){
        $qryies = "SELECT invoice.incacc as incacc,accname FROM invoice,incomeaccounts WHERE invoice.incacc = incomeaccounts.incacc AND invoice.estId LIKE '$estId' AND sabilno = '$sabil' 
               UNION SELECT  bad_debtsmbrs.incacc , accname FROM bad_debtsmbrs,incomeaccounts WHERE bad_debtsmbrs.incacc = incomeaccounts.incacc AND deptid = '$estId' AND acc = '$sabil' AND tbl = 'M' GROUP BY incacc ";
        }else{
          $qryies = "SELECT invoice.incacc as incacc,accname FROM invoice,incomeaccounts WHERE invoice.incacc = incomeaccounts.incacc AND invoice.incacc = '$account' AND invoice.estId LIKE '$estId' AND sabilno = '$sabil'
               UNION SELECT  bad_debtsmbrs.incacc , accname FROM bad_debtsmbrs,incomeaccounts WHERE bad_debtsmbrs.incacc = incomeaccounts.incacc AND deptid = '$estId' AND acc = '$sabil' AND bad_debtsmbrs.incacc = '$account' AND tbl = 'M'   GROUP BY incacc ";  
        }
        
        }
        else{
            $debtor=trim($_GET['debtor']);
            $invrc=$mumin->getdbContent("SELECT * FROM debtors WHERE dno = '$debtor' LIMIT 1"); 
            $sabil = $invrc[0]['sabilno'];
            $statementRecevee=$invrc[0]['debtorname']."<br/>Email :&nbsp;&nbsp;".$invrc[0]['email'];
            $debtelno= $invrc[0]['debTelephone'];	
            $email= $invrc[0]['email'];
            @$msector = $_SESSION['sector'];
			$hseno = $invrc[0]['hseno'];
            if ($invrc[0]['sabilno']){
             $display = "display: block";
        }   else{
            $display = "display: none";
        }
         if($account== 'all'){
        $qryies = "SELECT invoice.incacc as incacc,accname FROM invoice,incomeaccounts WHERE invoice.incacc = incomeaccounts.incacc AND invoice.estId LIKE '$estId' AND dno = '$debtor' 
               UNION SELECT  bad_debtsmbrs.incacc , accname FROM bad_debtsmbrs,incomeaccounts WHERE bad_debtsmbrs.incacc = incomeaccounts.incacc AND deptiD = '$estId' AND acc = '$debtor' AND tbl = 'D' GROUP BY incacc ";
        }else{
          $qryies = "SELECT invoice.incacc as incacc,accname FROM invoice,incomeaccounts WHERE invoice.incacc = incomeaccounts.incacc AND invoice.incacc = '$account' AND invoice.estId LIKE '$estId' AND dno = '$debtor' 
                  UNION SELECT bad_debtsmbrs.incacc , accname FROM bad_debtsmbrs,incomeaccounts WHERE bad_debtsmbrs.incacc = incomeaccounts.incacc AND deptiD = '$estId' AND acc = '$debtor' AND bad_debtsmbrs.incacc = '$account' AND tbl = 'D' GROUP BY incacc ";  
        }
        }
     
        
       $indata = $mumin->getdbContent($qryies);
        
      $disp = 'none';
 
echo '<div id="printableArea" class="container">';
//echo ''
echo '<table width="100%">';   
echo '<tr>';
echo '<td hidden="true"><input type="text" id="paramid" value="'.$param.'"></input><input type="text" id="startid" value="'.$start1.'"></input> <input type="text" id="endid" value="'.$end1.'"></input>
                        <input type="text" id="sabilid" value="'.$sabil.'"></input><input type="text" id="accountid" value="'.$account.'"></input><input type="text" id="debtorid" value="'.@$debtor.'"></input>
                        <input type="text" id="emailid" value="'.$email.'"></input>    </td>';
echo'<td width="100px"><img src="../assets/images/gold new logo.jpg" width="100px" /></img></td>';
echo '<td> <p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">Anjuman-e-Burhani  </font></i> </p> <span style="font-size:8px">'.$_SESSION['details'].'</span> </td>';
echo'<td><span style="float:right;font-size:12px; padding-right: 30px"><b>'.$_SESSION['dptname'].'</b></span><div class="topic"><font size="4"><b>Statement</font></b> </div></td>';
echo '</tr> ';
echo '</table>';
echo '<hr />';
echo '<div><table id="report" style="font-size:12px;padding:10px;">';
echo '<tr><td>Account Name: &nbsp; <b>'.$statementRecevee.' </b>&nbsp;&nbsp;&nbsp; Tel No : '.$debtelno.'</td>';
echo '<td><p font-size="2" align="right">From:&nbsp; <b>'.$start.'</b>&nbsp; to &nbsp;<b>'.$end.'</b></p></td>';
echo '</tr>';
echo '<tr><td style="'.$display.'">Sabil No: &nbsp; '.strtoupper($sabil).'&nbsp;&nbsp; House No.&nbsp;'.ucfirst($hseno).'&nbsp;&nbsp; Massol Name: &nbsp;</td><td style="text-align:Center">  </td></tr>';
echo '</table>';
echo '<hr />';

echo '<table id="statements" style="font-size:12px;" >';
echo '<thead><tr><th style="width: 60px" colspan="2"> Date</th><th colspan="2"> Narration</th><th style="text-align: center;">Debit</th> <th style="text-align: center;"> Credit</th> <th style="text-align: center;"> Balance</th></tr></thead>';
echo '<tbody>';
       
                $dbtotal = 0;  $crdtotal = 0; $balancebbf = 0; $balnce=0;
         for($k=0;$k<=count($indata)-1;$k++){
                 $incmesum = 0;
                  
          echo"<tr><td colspan='17'><b>".$indata[$k]['accname']."</b></td></tr>";
       if($param=="sabil"){
      //opening balance-b/bf
           if($end1 > '2016-12-31' ){ //opening balance-b/bf
           $qry56= $mumin->getdbContent("SELECT SUM(amount) as bbfamnt , tno from (SELECT SUM(IF(isinvce='1',amount,-1*amount)) as amount,tno  FROM invoice WHERE sabilno LIKE '$sabil' AND estId LIKE '$estId'  AND incacc = '".$indata[$k]['incacc']."' AND opb = '1'  ) t1");
            $result36=$qry56[0]['bbfamnt'];
            }else{
                $result36 = '0';
            }
            //balance-b/bf
           $qry3= "SELECT SUM(amount) as bbfamnt , tno from (SELECT SUM(IF(isinvce='1',amount,-1*amount)) as amount,tno  FROM invoice WHERE sabilno LIKE '$sabil' AND estId LIKE '$estId'  AND idate < '$start1' AND incacc = '".$indata[$k]['incacc']."' AND opb = '0' UNION 
               SELECT (SUM(amount))*-1 as amount,tno  FROM recptrans WHERE sabilno LIKE '$sabil' AND est_id LIKE '$estId' AND rdate < '$start1' AND incacc = '".$indata[$k]['incacc']."'  UNION
               SELECT (sum(dramount) - sum(cramount)) as amount,tno FROM bad_debtsmbrs WHERE acc = '$sabil' AND deptid = '$estId' AND jdate < '$start1' AND incacc = '".$indata[$k]['incacc']."' and tbl = 'M' ) t1";
            $result3=$mumin->getdbContent($qry3);
           
           // $amountdr=intval($amountpaid[0]['amountpaid'])+intval($debitjvs1[0]['dr']);
            
          //  $amountcr=intval($amountpayable[0]['amountpayable'])+intval($creditjvs1[0]['cr']);
            
           $balance_bf=$result3[0]['bbfamnt']+ $result36;
           $origbbf = $result3[0]['bbfamnt'];
        $qr="SELECT idate as date,invno as docno,incacc,rmks,ts,IF(isinvce='1',amount,'')as debitamt,IF(isinvce='0',amount,'')as creditamt,if(isinvce='1','Invoice','Credit Note') as doctype , ' ' as pmode, subacc FROM invoice WHERE sabilno LIKE '$sabil' AND estId LIKE '$estId' AND idate BETWEEN '$start1' AND '$end1' AND incacc = '".$indata[$k]['incacc']."' AND opb = '0' UNION 
            SELECT rdate as date,recpno as docno,'0' as incacc,rmks,ts,IF(amount<0,-1*amount,'')as debitamt,IF(amount>0,amount,'')as creditamt,if(tno>0,'Receipt','') as doctype, IF(pmode='CASH',pmode,concat(pmode,' ','NO:',' ',chqno,' ',chqdet)) AS pmode,'' as subacc FROM recptrans WHERE rdate BETWEEN '$start1' AND '$end1' AND sabilno LIKE '$sabil' AND est_id LIKE '$estId' AND incacc = '".$indata[$k]['incacc']."' UNION 
             SELECT jdate as date, jno as docno,incacc,rmks,ts,if(dramount <> '0.00',dramount,'') as debitamt,if(cramount <> '0.00',cramount, '') as creditamt,'Journal Entry' as doctype,' ' as pmode,'' as subacc  FROM bad_debtsmbrs WHERE acc = '$sabil' AND deptid = '$estId' AND jdate BETWEEN '$start1' AND '$end1' AND  incacc = '".$indata[$k]['incacc']."' AND tbl = 'M'  ORDER BY date,ts ASC ";
                 $q=$mumin->getdbContent($qr);    
      }
       else{  //debtor  processing
           if($end1 > '2016-12-31' ){ //opening balance-b/bf
           $qry56= $mumin->getdbContent("SELECT SUM(amount) as bbfamnt , tno from (SELECT SUM(IF(isinvce='1',amount,-1*amount)) as amount,tno  FROM invoice WHERE dno = '$debtor' AND estId LIKE '$estId'  AND incacc = '".$indata[$k]['incacc']."' AND opb = '1'  ) t1");
            $result36=$qry56[0]['bbfamnt'];
            }else{
                $result36 = '0';
            }
      //opening balance-b/bf
            $qr4= "SELECT SUM(amount) as bbfamnt ,tno from (SELECT SUM(IF(isinvce='1',amount,-1*amount)) as amount , tno  FROM invoice WHERE dno = '$debtor' AND estId LIKE '$estId'  AND idate < '$start1' AND incacc = '".$indata[$k]['incacc']."' AND opb = '0' UNION 
                    SELECT (sum(dramount) - sum(cramount)) as amount , tno FROM bad_debtsmbrs WHERE acc = '$debtor' AND deptid = '$estId' AND jdate < '$start1' AND incacc = '".$indata[$k]['incacc']."' and tbl = 'D'  UNION
                  SELECT (SUM(amount))*-1 as amount , tno FROM recptrans WHERE dno = '$debtor' AND est_id LIKE '$estId' AND rdate < '$start1' AND incacc = '".$indata[$k]['incacc']."') t1";
            $result4=$mumin->getdbContent($qr4);           
            $balance_bf= $result4[0]['bbfamnt'] + $result36;
            $origbbf = $result4[0]['bbfamnt'];
      //show the breakdown from recptrans table and Invoice Table  
           
             $qr="SELECT idate as date,ts,invno as docno,incacc,rmks,IF(isinvce='1',amount,'')as debitamt,IF(isinvce='0',amount,'')as creditamt,if(isinvce='1','Invoice','Credit Note') as doctype, ' ' as pmode,subacc FROM invoice WHERE dno = '$debtor' AND estId = '$estId' AND idate BETWEEN '$start1' AND '$end1' AND incacc = '".$indata[$k]['incacc']."' AND opb = '0' UNION 
                 SELECT jdate as date,ts, jno as docno,incacc,rmks,if(dramount <> '0.00',dramount,'') as debitamt,if(cramount <> '0.00',cramount, '') as creditamt,'Journal Entry' as doctype,' ' as pmode,'' as subacc  FROM bad_debtsmbrs WHERE acc = '$debtor' AND deptid = '$estId' AND jdate BETWEEN '$start1' AND '$end1' AND  incacc = '".$indata[$k]['incacc']."' AND tbl = 'D' UNION
                    SELECT rdate as date,ts,recpno as docno,'0' as incacc,rmks,IF(amount<0,-1*amount,'')as debitamt,IF(amount>0,amount,'')as creditamt,if(tno>0,'Receipt','')as doctype, IF(pmode='CASH',pmode,concat(pmode,' ','NO:',' ',chqno,' ',chqdet)) AS pmode,'' as subacc FROM recptrans WHERE rdate BETWEEN '$start1' AND '$end1' AND dno = '$debtor' AND est_id LIKE '$estId' AND incacc = '".$indata[$k]['incacc']."' ORDER BY date,ts ASC";
                 $q=$mumin->getdbContent($qr);   
             
			                
                }
       
       //$q=$mumin->getdbContent("SELECT * FROM $tbname ORDER BY docdate ASC");style=";
                   
                   $drbal=0;
                   
                   $crbal=0;
                   if($result36 != 0 && $origbbf == 0 || $start1 < '2017-01-01' ){
                       echo "<tr><td colspan='5' style='width:300px;text-align:center;font-size:14px'><b>Opening Bal</b></td><td></td><td style='text-align: right;font-size:12px;padding-right:10px'>".number_format($balance_bf,2)."</td></tr>"; 
                   }else{
                   echo "<tr><td colspan='5' style='width:300px;text-align:center;font-size:14px'><b>B/F</b></td><td></td><td style='text-align: right;font-size:12px;padding-right:10px'>".number_format($balance_bf,2)."</td></tr>";
                   }
                  for($l=0;$l<=count($q)-1;$l++){
                  
                      
                           $doctype=$q[$l]['doctype'];
                           
                            
                           
                           if($q[$l]['creditamt']){
                             
                               $balance_bf-=$q[$l]['creditamt'];
                               $crbal+=$q[$l]['creditamt'];
                               $creditamt = number_format($q[$l]['creditamt'],2);
                               $debitamt ='';
                               
                           }
                           else if($q[$l]['debitamt']){
                               
                               $balance_bf+=$q[$l]['debitamt'];
                               $drbal+=$q[$l]['debitamt'];
                               $debitamt = number_format($q[$l]['debitamt'],2);
                               $creditamt='';
                           }else{
                               $creditamt = number_format(0,2);
                                $debitamt = number_format(0,2);
                           }
                           if($q[$l]['incacc']!=='0'){
                               $qer="SELECT accname FROM incomeaccounts WHERE incacc='".$q[$l]['incacc']."'"; 
                                     $dat=$mumin->getdbContent($qer);
                                     $accnmed = $dat[0]['accname'];
                                     if($accnmed == 'Sabil Account'){
                               $ty=$mumin->getdbContent("SELECT accname FROM subincomeaccs WHERE id='".$q[$l]['subacc']."'"); 
                                      if(count($ty)>0){
                                          $accnme =   $ty[0]['accname'];
                                      }else{
                                          $accnme =  $accnmed;
                                      }
                               
                                     }else {
                                        $accnme =  $accnmed;
                                     }
                           }
                           else{
                               $accnme = "";
                           }
                           //&nbsp:&nbsp;&nbsp;".$q[$l]['pmode']."
                           //$start = date('Y-m-d', strtotime($start1));
                           echo "<tr ><td style='font-size:12px;width:100px;' colspan ='2'>".date('d-m-Y', strtotime($q[$l]['date']))."</td><td style='font-size:12px;' colspan='2'>".$doctype." No&nbsp:&nbsp;&nbsp;".$q[$l]['docno']." - $accnme    ".$q[$l]['pmode']."</td><td style='text-align: right;font-size:12px;padding-right:10px'>".$debitamt."</td><td style='text-align: right;font-size:12px;padding-right:10px'>".$creditamt."</td><td style='text-align: right;font-size:12px;padding-right:10px'>".number_format($balance_bf,2)."</td></tr>";
                      
                  }
              echo'<tr><td colspan=4 style="text-align: center">'.$indata[$k]['accname'].' Balance</td><td style="text-align: right;font-size:12px;padding-right:10px">'.number_format($drbal,2).'</td><td style="text-align: right;font-size:12px;padding-right:10px">'.number_format($crbal,2).'</td><td style="text-align: right;font-size:12px;padding-right:10px">'.number_format($balance_bf,2).'</td></tr>';
              $dbtotal = $dbtotal +$drbal;
              $crdtotal = $crdtotal + $crbal;
              $balancebbf = $balancebbf + $balance_bf;
              $balnce = $balancebbf;
         }
 //$empty_temp=$mumin->updatedbContent("DROP TABLE $tbname"); //delete contents  of temp table  in readness for next  operation
echo'<tr><th colspan=4 style="border-bottom:double;">Totals</th><th style="text-align: right;font-size:12px;padding-right:10px;border-bottom:double;">'.number_format($dbtotal,2).'</th><th style="text-align: right;font-size:12px;padding-right:10px;border-bottom:double;">'.number_format($crdtotal,2).'</th><th style="text-align: right;font-size:12px;padding-right:10px;border-bottom:double;">'.number_format($balnce,2).'</th></tr>';
           
            $totalpaid = $crdtotal;
            
echo'<tr><td rowspan=4 colspan=5><h7>Please check your balance and bring any discrepancies within 15 days</h7>
<br><span align="left" style="font-size:x-small;">Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span></td>';
echo'</td><td colspan=2><center>Transaction Summary</center></td></tr>';
echo'<tr><td>Total Payable</td><td align="right">'.number_format($totalpaid+$balnce,2).'</td></tr>';
echo'<tr><td>Paid</td><td align="right">'.number_format($totalpaid,2).'</td></tr>';
echo'<tr><td>Balance</td><td align="right">'.number_format($balnce,2).'</td></tr>';

echo'</tbody></table><br>';


?>
<div id="d_progress" style="display: none;background: transparent;border: none;text-align: center;vertical-align:middle; line-height: 50px;padding-top: 10px">
     <img align="center" src="./images/ajax_loader_green_64.gif"></img>
 </div>
 
</body>
    
</html>
<?php
}
?>