<?php
 session_start();
 if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}else{
 include '../finance/operations/Mumin.php';
 date_default_timezone_set('Africa/Nairobi');
 $mumin=new Mumin();
  $action=$_GET['action'];
 
 
  if($action=="pulloutlinkedaccount"){
   
      
     $account=$_GET['id']; 
      
     $estatesid=$_SESSION['dept_id'];
      
      //get linked bank account
         
    $linkedaccount=$mumin->getdbContent("SELECT * FROM estate_incomeaccounts i JOIN estate_bankaccounts e ON  e.acno=i.bankaccount WHERE i.estateid LIKE '$financeid' AND i.id LIKE '$account' LIMIT 1");
         
     //end gate linked  bank  account
   
   header('Content-type: application/json'); 
 
   echo  json_encode($linkedaccount);
 
   exit();
     
 }
  if($action=="getallledgeraccount"){
       
     $estatesid=$_SESSION['dept_id'];
      
      //get linked bank account
         
    $linkedaccount=$mumin->getdbContent("SELECT incomeaccounts.incacc,incomeaccounts.accname, typ,'I' as tbl FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc  AND incomeactmgnt.deptid = '$estatesid' GROUP BY incomeaccounts.incacc UNION
                                     SELECT expnseaccs.id,expnseaccs.accname, type,'E' as tbl FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id  AND expenseactmgnt.deptid = '$estatesid' GROUP BY expnseaccs.id order by typ, accname");
         
     //end gate linked  bank  account
   
   header('Content-type: application/json'); 
 
   echo  json_encode($linkedaccount);
 
   exit();
     
 }
   if($action=="getallssabilnoaccount"){
       
     $estatesid=$_SESSION['dept_id'];
      
      
    $linkedaccount=$mumin->getdbContent("SELECT expnseaccs.id as incacc,expnseaccs.accname, type as typ ,'E' as tbl FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id  AND expenseactmgnt.deptid = '$estatesid'   GROUP BY expnseaccs.id    UNION
                                     SELECT sabilno,sabilno, hofej,'M' as tbl FROM mumin WHERE sabilno <> ''  GROUP BY sabilno ");
         
    
   
   header('Content-type: application/json'); 
 
   echo  json_encode($linkedaccount);
 
   exit();
     
 }
       if($action=="getalldebtorsaccount"){
       
     $estatesid=$_SESSION['dept_id'];
      
      
    $linkedaccount=$mumin->getdbContent("SELECT expnseaccs.id as incacc,expnseaccs.accname, type as typ ,'E' as tbl FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id  AND expenseactmgnt.deptid = '$estatesid' AND type = 'E'   GROUP BY expnseaccs.id   UNION
                                     SELECT dno,debtorname, '' as typ,'D' as tbl FROM debtors WHERE deptid = '$estatesid' ");
         
    
   
   header('Content-type: application/json'); 
 
   echo  json_encode($linkedaccount);
 
   exit();
     
 }
       if($action=="getallsupplraccount"){
       
     $estatesid=$_SESSION['dept_id'];
      
      
    $linkedaccount=$mumin->getdbContent("SELECT expnseaccs.id as incacc,expnseaccs.accname, type as typ ,'E' as tbl FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id  AND expenseactmgnt.deptid = '$estatesid' AND type = 'E'   GROUP BY expnseaccs.id   UNION
                                     SELECT supplier,suppName, '' as typ,'S' as tbl FROM suppliers WHERE estId = '$estatesid' ");
         
    
   
   header('Content-type: application/json'); 
 
   echo  json_encode($linkedaccount);
 
   exit();
     
 }
    if($action=="getallincmeaccts"){
       
     $estatesid=$_SESSION['dept_id'];
      
     $linkedaccount=$mumin->getdbContent("SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$estatesid' ORDER BY accname");
         
    
   
   header('Content-type: application/json'); 
 
   echo  json_encode($linkedaccount);
 
   exit();
     
 }
  if($action=="getexpensegrphrprt"){
       $from_date1 = $_GET['startdate'];
$from_date = date('Y-m-d', strtotime($from_date1));
$to_date1 = $_GET['enddate'];
$to_date = date('Y-m-d', strtotime($to_date1));
     $id=$_SESSION['dept_id'];
     $debitotal = 0;
     $a=array();
   
          $expenseamnt = $mumin->getdbContent("select accname,SUM(debitamnt) as debitamnt FROM (SElect accname,SUM(amount)as debitamnt,BILLS.id FROM BILLS,expnseaccs WHERE expnseaccs.id = bills.expenseacc AND estate_id = '$id' AND bdate BETWEEN '$from_date' AND '$to_date' GROUP BY expenseacc union 
                                               SELECT accname,sum(amount)as debitamnt,jid FROM `directexpense`,expnseaccs WHERE expnseaccs.id = directexpense.dacc AND estate_id = '$id' AND dexpdate BETWEEN '$from_date' AND '$to_date' AND revsd = '0' GROUP BY accname UNION
                                               SELECT accname,sum(IF(dramount='0',cramount*-1,dramount))as debitamnt,tno FROM `bad_debtsmbrs`,expnseaccs WHERE expnseaccs.id = bad_debtsmbrs.acc AND tbl = 'E' and bad_debtsmbrs.type = 'E' AND jdate  BETWEEN '$from_date' AND '$to_date' AND deptid = '$id' GROUP BY accname UNION
                                               SELECT accname,sum(IF(dramount='0',cramount*-1,dramount))as debitamnt,tno FROM `bad_debtsupplrs`,expnseaccs WHERE expnseaccs.id = bad_debtsupplrs.acc and tbl = 'E' and bad_debtsupplrs.type = 'E' AND jdate  BETWEEN '$from_date' AND '$to_date' AND deptid = '$id' GROUP BY accname )T7 GROUP BY accname ORDER BY accname");
                                    
        
   header('Content-type: application/json'); 
 
   echo  json_encode($expenseamnt);
 
   exit();
     
 }
     if($action=="getallcostcentres"){
       
     $estatesid=$_SESSION['dept_id'];
      
     $linkedaccount=$mumin->getdbContent("SELECT department2.centrename,department2.id as cntrid FROM department2,costcentrmgnt WHERE costcentrmgnt.costcentrid = department2.id AND costcentrmgnt.deptid = '$estatesid' GROUP BY department2.id");
         
    
   
   header('Content-type: application/json'); 
 
   echo  json_encode($linkedaccount);
 
   exit();
     
 }
 
  if($action=="getsplitdata"){
     
     $sabilno=trim($_GET['sabilno']);
       
     $query="SELECT * FROM  mumin WHERE sabilno LIKE '$sabilno'";
     
     $data=$mumin->getdbContent($query);
     
    
     header('Content-type: application/json'); 
 
     echo  json_encode($data);
 
     exit();
      
      
   
     
 }
   if($action=="getreconstat"){  //get mumin names and data for invoice
     
      $reconsdate =date('Y-m-d',  strtotime($_GET['reconsdate']));
      $bankactid =trim($_GET['bankactid']);
            
            $qr0="SELECT * FROM bankrecon WHERE bacc = '$bankactid' AND recondate >= '$reconsdate'";
            $data1=$mumin->getdbContent($qr0);
   
           $cout = count($data1);
    if ($cout>0){
     $available = '1';
    }
    else{
        $available = '0';
    }
     //$invno=sprintf('%06d',intval($mumin->refnos("invno")));
     
    header('Content-type: application/json'); 
 
   echo  json_encode(array('available'=>$available));
 
   exit();   
 }
    if($action=="getreconreprintstat"){  //get mumin names and data for invoice
     
      $reconsdate =date('Y-m-d',  strtotime($_GET['reconsdate']));
      $bankactid =trim($_GET['bankactid']);
            
            $qr0="SELECT * FROM bankrecon WHERE bacc = '$bankactid' AND recondate = '$reconsdate'";
            $data1=$mumin->getdbContent($qr0);
   
           $cout = count($data1);
    if ($cout>0){
     $available = '1';
    }
    else{
        $available = '0';
    }
     //$invno=sprintf('%06d',intval($mumin->refnos("invno")));
     
    header('Content-type: application/json'); 
 
   echo  json_encode(array('available'=>$available));
 
   exit();   
 }
 if($action=="getallbankaccountsforthisestate"){
      $estid=$_GET['id']; 
      
     $qr="SELECT * FROM estate_bankaccounts WHERE estate_id LIKE '$estid'";
   
     $d=$mumin->getdbContent($qr);
     
     
   header('Content-type: application/json'); 
 
   echo  json_encode($d);
 
   exit();
     
 }
   if($action=="getallincomeforthiscompany"){
      $id=$_GET['id']; 
      
     $qr="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id' ORDER BY accname"; 
   
     $d=$mumin->getdbContent($qr);
     
     
   header('Content-type: application/json'); 
 
   echo  json_encode($d);
 
   exit();
     
 }
    if($action=="getallexpnseforthiscompany"){
      $id=$_GET['id']; 
      
     $qr="SELECT expnseaccs.id,expnseaccs.accname FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id  AND expenseactmgnt.deptid = '$id' ORDER BY accname"; 
   
     $da=$mumin->getdbContent($qr);
     
     
   header('Content-type: application/json'); 
 
   echo  json_encode($da);
 
   exit();
     
 }
 if($action=="savebnk"){  

      $acno=$_GET['acno'];
      
      $acname=$_GET['acname'];
      
      $opam=$_GET['opam'];
      
      $bankname=$_GET['bankname'];
     
      $est_id=$_GET['estateid']; 
      
     $qu="INSERT INTO estate_bankaccounts (id,acno,acname,bankname,estate_id,amount,opam)VALUES (0,'$acno','$acname','$bankname','$est_id','$opam','$opam')";   
     
     $id=$mumin->insertdbContent($qu);
     
     header('Content-type: application/json'); 
 
     echo  json_encode(array('id'=>$id));
 
     exit();
 
 }
 
 if($action=="openingbalance"){  

     $balanceType=$_GET['balanceType'];
      
      $balancedate1=$_GET['balancedate'];
      $balancedate = date('Y-m-d', strtotime($balancedate1));
      $balanceamount=floatval($_GET['balanceamount']);
     
      
      //$toacc=$_GET['bank'];
      
      $supplier=$_GET['supplier'];
      
      $debtor=$_GET['debtor'];
      
      $muminsabilno=$_GET['mumin'];
      
      $estatesid=$_SESSION['dept_id'];
      
      $us=$_SESSION['uname'];
       
      $ts=date('Y-m-d h:i:s');
      
      $recpno=$mumin->refnos("recpno");
      
      //$bankget=$mumin->getdbContent("SELECT bankaccount FROM income_accounts WHERE estateid LIKE '$estatesid' AND id LIKE '$toacc'  LIMIT 1");
      
      //$bank=$bankget[0]['bankaccount'];
      
      $bank=0;
     $toacc=0;
     
     if($balanceType=="sabil"){
      
      $ejno=$mumin->get_MuminHofEjnoFromSabilno($muminsabilno);
      
      }
      
      else if($balanceType=="debtor"){
       
         $ejno=$debtor;  
       
         $muminsabilno=0;
         
         
          
      }
      
      else if($balanceType=="supplier"){
          
          $ejno=$supplier;
          
          $muminsabilno=0;
      }
      
   $balanceremarks=$ejno."-OPENING BALANCE As AT&nbsp;".$ts;
      
   $qr="INSERT INTO estates_recptrans(est_id, rdate, amount, pmode, recpno, chqdet, chqno,chequedate, rmks, hofej, tno, sabilno, acc, bacc, dno, ts, us, rev,invoicesettled)
   VALUES ('$estatesid','$balancedate',$balanceamount,'CHEQUE',$recpno,'','','','$balanceremarks','$ejno',0,'$muminsabilno',$toacc,'$bank','$ejno','$ts','$us',0,'')";
      
   $data=$mumin->insertdbContent($qr);     
     
     
   if($data){
     
       
         //$q="UPDATE estate_bankaccounts SET amount=amount+$balanceamount   WHERE acno LIKE '$bank' AND estate_id LIKE '$estatesid'";
         
         //$res= $mumin->updatedbContent($q);
         
         //if($res){
       
       $id=1; 
       
        // }
         //else{
             
            // $id=0;
        // }
       
   }
   else{
       
      $id=0;   
   }
     header('Content-type: application/json'); 
 
     echo  json_encode(array('id'=>$id));
 
     exit();
 
 }
 
 if($action=="updateaccount"){   

      $usname=$_GET['usname'];
      
      $pwd=$_GET['pwd'];
      
      $est_id=$_GET['estateid'];
      
     $q="UPDATE pword SET uname='$usname',pwd='$pwd',grp='EXTERNAL',acclevel=999,suspended =0 ,privileges =1 WHERE estate_prop LIKE '$est_id' ";   
     
     $id=$mumin->updatedbContent($q);
     
     header('Content-type: application/json'); 
 
     echo  json_encode(array('id'=>$id));
 
     exit();
 
 }
 
  if($action=="editlogindetails"){

      $usname= mysql_real_escape_string($_GET['usrname']);
      $userid= mysql_real_escape_string($_GET['userid']);
      $password= mysql_real_escape_string($_GET['password']);
      $email= mysql_real_escape_string($_GET['email']);
      $userlevel= mysql_real_escape_string($_GET['userlevel']);
       if($userlevel =='ADMIN'){
            $acclevel = '1';
        }else{
            $acclevel = '3';
        }
     $q= $mumin->updatedbContent("UPDATE pword SET j_uname = '$usname',pwd = md5('$password'),email = '$email', grp = '$userlevel',acclevel = '$acclevel' WHERE userid = '$userid'  ");   
     
     if($q){
         
         $returnVal=1;
     }
     else{
         $returnVal=0;
     }
     
     header('Content-type: application/json'); 
 
     echo  json_encode(array('id'=>$returnVal));
 
     exit();
 
 }
   if($action=="updatelogindetails"){

       $userid= mysql_real_escape_string($_GET['usrid']);
      $department= mysql_real_escape_string($_GET['department']);
      $columns= trim($_GET['columns']);
      $columnArray=explode(",",$columns);
       $uncheckedcolumns= trim($_GET['unchecked']);
       $uncheckedcolumnArray=explode(",",$uncheckedcolumns);
       $checkavailabity = $mumin->getdbContent("SELECT * FROM priviledges where userid = '$userid' and deptid = '$department' ");
       if(count($checkavailabity)>0){
       for($q=0;$q<=count($columnArray)-1;$q++){
           $t= $mumin->updatedbContent("UPDATE priviledges SET `$columnArray[$q]` = '1'  WHERE userid = '$userid' AND deptid = '$department'");   

       }
     for($p=0;$p<=count($uncheckedcolumnArray)-1;$p++){
           $t= $mumin->updatedbContent("UPDATE priviledges SET `$uncheckedcolumnArray[$p]` = '0'  WHERE userid = '$userid' AND deptid = '$department'");   

       }}else{
           $insertquery = $mumin->insertdbContent("INSERT INTO priviledges (userid,deptid,invoices,receipts,deposits,withdrawals,payments,jv,directexp,suppliers,statements,bankaccounts,debtors,admin,`database`,incomeaccounts,readonly) 
           VALUES ('$userid','$department','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0')");
       for($q=0;$q<=count($columnArray)-1;$q++){
           $t= $mumin->updatedbContent("UPDATE priviledges SET `$columnArray[$q]` = '1'  WHERE userid = '$userid' AND deptid = '$department'");   

       }
     for($p=0;$p<=count($uncheckedcolumnArray)-1;$p++){
           $t= $mumin->updatedbContent("UPDATE priviledges SET `$uncheckedcolumnArray[$p]` = '0'  WHERE userid = '$userid' AND deptid = '$department'");   

       }
           
       }
     header('Content-type: application/json'); 
 
     echo  json_encode(array('id'=>1));
 
     exit();
 
 }
 if($action=="saveest"){
 
   $name=trim($_GET['name']);
   $mohalla=trim($_GET['mohalla']);
   $masooltel=trim($_GET['masooltel']);
   $masooladdres=trim($_GET['masooladdres']);
   $masoolemail=trim($_GET['masoolemail']);
   $masoul=trim($_GET['masoul']);
   $musaeed=trim($_GET['musaeed']);
   $tanzeem1=trim($_GET['tanzeem1']);
   $tanzeem2=trim($_GET['tanzeem2']);
   $tanzeem3=trim($_GET['tanzeem3']);
   $estcost=trim($_GET['estcost']);
   $estcounty=trim($_GET['estcounty']);
   $estcompleted=trim($_GET['estcompleted']);
   $esttenants=trim($_GET['esttenants']);
   
   $query="INSERT INTO anjuman_estates(	est_id,estate_name,mohalla,mobno,addr,estemail,year,cost,tenants,county) VALUES (0,'$name','$mohalla','$masooltel','$masooladdres','$masoolemail','$estcompleted','$estcost','$esttenants','$estcounty')";
     
  $data=$mumin->insertdbContent($query);
    
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data));
 
   exit();
 
 }
 
 if($action=="receiptgeneratepart"){
     
     $docnumbers=$_GET['docnumbers'];
     $paymentdate1=trim($_GET['paymentdate']);
     $paymentdate = date('Y-m-d', strtotime($paymentdate1));
     $chequedate1=trim($_GET['chequedate']);
     $chequedate = date('Y-m-d', strtotime($chequedate1));
     $chequeno=trim($_GET['chequeno']);
     $amount=trim($_GET['amount']);
     $chequedetails=trim($_GET['chequedetails']);
     
     $sabilno=trim($_GET['sabilno']);
     
     $expacc=trim($_GET['expacc']);
     $acc=trim($_GET['acc']);
     $payment=trim($_GET['payment']);
     $est_id=$_SESSION['dept_id'];
     $us=$_SESSION['uname'];
     $ts=date('Y-m-d h:i:s');
     
     $debtor=trim($_GET['debtor']);
     
     $recpno=sprintf('%06d',intval($mumin->refnos("recpno")));
     
       if ($sabilno != 'null'){
     $ejno=$mumin->get_MuminHofEjnoFromSabilno($sabilno);
     $debt=$ejno;
     } 
     else{
         $ejno=' ';
         $debt=$debtor;  
     }
      
             $rs=0;
             $amountreturn=$mumin->getdbContent("SELECT amount FROM estate_invoice WHERE invno LIKE '$docnumbers' AND payno='0' AND estId ='$est_id' LIMIT 1");
             
             $originalAmount= floatval($amountreturn[0]['amount']);
             $qr_getAmount=$mumin->getdbContent("SELECT SUM(amount) AS amount FROM estates_recptrans WHERE invoicesettled LIKE '$docnumbers' AND est_id ='$est_id'");
    
                $totalamt = $qr_getAmount[0]['amount'];
                $diff= $originalAmount - $totalamt; 
             if(floatval($amount)>$diff){
                     
                 $rs=2;
             }
             else if($diff==$amount){
                
                   
             $qr="INSERT INTO estates_recptrans(est_id, rdate, amount, pmode, recpno, chqdet, chqno,chequedate, rmks, hofej, tno, sabilno, acc, bacc, dno, ts, us, rev,invoicesettled)
                 VALUES ('$est_id','$paymentdate','$amount','CHEQUE','$recpno','$chequedetails','$chequeno','$chequedate','$payment','$ejno',0,'$sabilno','$expacc','$acc','$debt','$ts','$us',0,'$docnumbers')";     
                    $data=$mumin->insertdbContent($qr);
                     $qqq="UPDATE estate_invoice SET payno=$recpno WHERE invno LIKE '$docnumbers' AND estId ='$est_id'"; 
                    $rs2=$mumin->updatedbContent($qqq);
                   $rs=1;
             }
             elseif($diff>floatval($amount)){
                 
                 $qr="INSERT INTO estates_recptrans(est_id, rdate, amount, pmode, recpno, chqdet, chqno,chequedate, rmks, hofej, tno, sabilno, acc, bacc, dno, ts, us, rev,invoicesettled) 
                     VALUES ('$est_id','$paymentdate','$amount','CHEQUE','$recpno','$chequedetails','$chequeno','$chequedate','$payment','$ejno',0,'$sabilno','$expacc','$acc','$debt','$ts','$us',0,'$docnumbers')";     
                    $data=$mumin->insertdbContent($qr);
                    $rs=1;
             }
             
        header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$rs,'recpno'=>$recpno));
 
   exit();
   
 }

 if($action=="receiptgeneratecashpart"){
     
     $docnumbers=$_GET['docnumbers'];
     $paymentdate1=trim($_GET['paymentdate']);
     $paymentdate = date('Y-m-d', strtotime($paymentdate1));
     $amount=trim($_GET['amount']);
     $sabilno=trim($_GET['sabilno']);
     $expacc=trim($_GET['expacc']);
     $acc=trim($_GET['acc']);
     $payment=trim($_GET['payment']);
     $est_id=$_SESSION['dept_id'];
     $us=$_SESSION['uname'];
     $ts=date('Y-m-d h:i:s');
     
     $debtor=trim($_GET['debtor']);
     
     $recpno=sprintf('%06d',intval($mumin->refnos("recpno")));
     if ($sabilno != 'null'){
     $ejno=$mumin->get_MuminHofEjnoFromSabilno($sabilno);
     $debt=$ejno;
     } 
     else{
         $ejno=' ';
         $debt=$debtor;  
     }
      $rs=0;
             $amountreturn=$mumin->getdbContent("SELECT amount FROM estate_invoice WHERE invno LIKE '$docnumbers' AND payno='0'  AND estId ='$est_id' LIMIT 1 ");
             
             $originalAmount= floatval($amountreturn[0]['amount']);
             $qr_getAmount=$mumin->getdbContent("SELECT SUM(amount) AS amount FROM estates_recptrans WHERE invoicesettled LIKE '$docnumbers' AND est_id ='$est_id'");
    
                $totalamt = $qr_getAmount[0]['amount'];
                $diff= $originalAmount - $totalamt; 
             if(floatval($amount)>$diff){
                     
                 $rs=2;
             }
             else if($diff==$amount){
                
                   
             $qr="INSERT INTO estates_recptrans(est_id, rdate, amount, pmode, recpno, chqdet, chqno,chequedate, rmks, hofej, tno, sabilno, acc, bacc, dno, ts, us, rev,invoicesettled) VALUES 
                       ('$est_id','$paymentdate','$amount','CASH','$recpno','','','','$payment','$ejno',0,'$sabilno','$expacc','$acc','$debt','$ts','$us',0,'')";
     
                    $data=$mumin->insertdbContent($qr);
                     $qqq="UPDATE estate_invoice SET payno=$recpno WHERE invno LIKE '$docnumbers' AND estId ='$est_id'"; 
                    $rs2=$mumin->updatedbContent($qqq);
                   $rs=1;
             }
             elseif($diff>floatval($amount)){
                 
                 $qr="INSERT INTO estates_recptrans(est_id, rdate, amount, pmode, recpno, chqdet, chqno,chequedate, rmks, hofej, tno, sabilno, acc, bacc, dno, ts, us, rev,invoicesettled) VALUES 
                       ('$est_id','$paymentdate','$amount','CASH','$recpno','','','','$payment','$ejno',0,'$sabilno','$expacc','$acc','$debt','$ts','$us',0,'$docnumbers')";
     
                    $data=$mumin->insertdbContent($qr);
                    $rs=1;
             }
             
        header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$rs,'recpno'=>$recpno));
 
   exit();
   
 }
 if ($action == "depositamnt"){
     $receiptNos = trim($_GET['receiptdata']);
 $paymode = trim($_GET['paymode']);
  $bankactid = trim($_GET['bankactid']);
  $slctddepositdate = date('Y-m-d h:i:s',  strtotime($_GET['slctddepositdate']));
  $dptid=$_SESSION['dept_id'];
$recpArray=explode(",",$receiptNos);
$imp = "'" . implode("','",$recpArray) . "'";
     $depodate = date('Y-m-d h:i:s');
     
      //Generate unique deposit  id for every transaction
    //$in = "(".implode(',',$receiptNos).')';
   
    if($paymode=='CASH'){
        $depositId= sprintf('%06d',intval($mumin->refnos("depono")));
   //  for($q=0;$q<=count($recpArray)-1;$q++){    // update recptrans to reflect amount deposite- check against double depositing
         
     $dataString2=$mumin->updatedbContent("UPDATE recptrans SET isdeposited ='$depositId',bacc = '$bankactid',depots ='$slctddepositdate' WHERE recpno IN ($imp) AND est_id = '$dptid'");
    
     $result2=$dataString2;
     
     if($result2){
         
         $returnVal=$depositId;
     }
     else{
         $returnVal=0;
     }
    
     //}
     }else if ($paymode=='CHEQUE'){
         $depositId= sprintf('%06d',intval($mumin->refnos("depono")));
             for($q=0;$q<=count($recpArray)-1;$q++){    // update recptrans to reflect amount deposite- check against double depositing
         
     $dataString2=$mumin->updatedbContent("UPDATE recptrans SET isdeposited ='$depositId',bacc = '$bankactid',depots ='$slctddepositdate' WHERE recpno LIKE '$recpArray[$q]' AND est_id = '$dptid'");
    
     $result2= $dataString2;
     
     if($result2){
         
         $returnVal=$depositId;
     }
     else{
         $returnVal=0;
     }
    
     } 
     }
    // return $returnVal;

 header('Content-type: application/json'); 
 
 
 echo  json_encode(array('id'=>$returnVal));
 exit();

 }
 
 if($action=="savesupplier"){
     $name=mysql_real_escape_string($_GET['name']);
     $telephone=mysql_real_escape_string($_GET['telephone']);
     $email=mysql_real_escape_string($_GET['email']);
     $postal=mysql_real_escape_string($_GET['postal']);
     $city=mysql_real_escape_string($_GET['city']);
     $remarks=mysql_real_escape_string($_GET['remarks']);
     $user=$_SESSION['jname'];
     $est_id=$_SESSION['dept_id'];
     
     $qr="INSERT INTO suppliers(supplier,estId,suppName,suppTelephone,email,postal,city,remarks,user) VALUES (0,$est_id,'$name','$telephone','$email','$postal','$city','$remarks','$user')";
     
     $data=$mumin->insertdbContent($qr);
    
     
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data));
 
   exit();
   
 }
  
 
 
 if($action=="saveaccountb"){
     
      
     $name=mysql_real_escape_string($_GET['name']);
     $acctno=mysql_real_escape_string($_GET['acctno']);
     $actsector=mysql_real_escape_string($_GET['actsector']);
     $acttype=mysql_real_escape_string($_GET['acttype']);
     $est_id=$_SESSION['dept_id'];    
     $qr="INSERT INTO bankaccounts (acno,acname,deptid,type) VALUES ('$acctno','$name','$actsector','$acttype')";
      $data=$mumin->insertdbContent($qr);
     header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data));
 
   exit();
   
 }
 if($action=="updatebankdetails"){
     
      
     $bankactid=trim($_GET['baankid']);
     $est_id=$_SESSION['dept_id'];    
     $qr="SELECT bacc,acno,acname,deptid,type FROM bankaccounts WHERE bacc = '$bankactid'";
      $data=$mumin->getdbContent($qr);
      $accno = $data[0]['acno'];
      $sect = $data[0]['deptid'];
      $deptnamer =$mumin->getdepartname($sect);
      $type = $data[0]['type'];
     header('Content-type: application/json'); 
    echo  json_encode(array('id'=>count($data),'accno'=>$accno,'sector'=>$deptnamer,'type'=>$type)); 
   exit();
   
 }
 
 
  if($action=="updateccountb"){
     
      
     $acctid=trim($_GET['acctid']);
     $acctno=trim($_GET['acctno']);
     $actsector=trim($_GET['actsector']);
     $acttype=trim($_GET['acttype']);
     $est_id=$_SESSION['dept_id'];    
     $qr="UPDATE estate_bankaccounts SET acno = '$acctno', sector = '$actsector', type = '$acttype' WHERE bacc='$acctid'";
      $data=$mumin->updatedbContent($qr);
     header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data));
 
   exit();
   
 }
 
  if($action=="savedebtor"){
     
      
     $name=mysql_real_escape_string($_GET['name']);
     $telephone=mysql_real_escape_string($_GET['telephone']);
     $email=mysql_real_escape_string($_GET['email']);
     $postal=mysql_real_escape_string($_GET['postal']);
     $city=mysql_real_escape_string($_GET['city']);
     $remarks=mysql_real_escape_string($_GET['remarks']);
     $user=$_SESSION['uname'];
     $est_id=$_SESSION['dept_id'];
     
     $qr="INSERT INTO debtors(dno,debtorname,estId,debTelephone,email,postal,city,remarks,user) VALUES (0,'$name',$est_id,'$telephone','$email','$postal','$city','$remarks','$user')";
     
     $data=$mumin->insertdbContent($qr);
    
     
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data));
 
   exit();
   
 }
 if($action=="savincomex"){  
     
        $name=mysql_real_escape_string($_GET['name']);
        $esatid=mysql_real_escape_string($_GET['esatid']);
        $bankid =  mysql_real_escape_string($_GET['bankid']);
        $dpmntid =$_SESSION['dept_id'];
        $incmetype = mysql_real_escape_string($_GET['incmetype']);
        $budgetcode = mysql_real_escape_string($_GET['budgetcode']);
        if ($esatid == 'all'){
        $qr="INSERT INTO incomeaccounts(incacc,accname,jims_acct,bacc,typ,mainincgrp) VALUES ('','$name','A','$bankid','$incmetype','$budgetcode')";
        $data=$mumin->insertdbContent($qr);
        $jqery="SELECT incacc FROM incomeaccounts WHERE accname = '$name' AND bacc = '$bankid' "; 
                         $datay=$mumin->getdbContent($jqery);
        for($j=0;$j<=count($datay)-1;$j++){    
               $column = $datay[$j]['incacc'];
        $qryupdte = "INSERT INTO incomeactmgnt (id,incacc,deptid) VALUES (' ','$column','$esatid')";    
             $data86=$mumin->updatedbContent($qryupdte);
             }
        }
        elseif ($esatid !== 'all') {
        $qr="INSERT INTO incomeaccounts(incacc,accname,jims_acct,bacc,typ,mainincgrp) VALUES ('','$name','A','$bankid','$incmetype','$budgetcode')";
        $data=$mumin->insertdbContent($qr);
        $jqery="SELECT incacc FROM incomeaccounts WHERE accname = '$name' AND bacc = '$bankid' "; 
                         $datay=$mumin->getdbContent($jqery);
    
        for($j=0;$j<=count($datay)-1;$j++){    
               $column = $datay[$j]['incacc'];
        $qryupdte = "INSERT INTO incomeactmgnt (id,incacc,deptid) VALUES (' ','$column','$esatid')";
             $data86=$mumin->updatedbContent($qryupdte);
             }
    }
     
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data));
 
   exit();
   
 }
 
  if($action=="savsubincomex"){  
     
      
          $name=mysql_real_escape_string($_GET['name']);
        $incmeacount=mysql_real_escape_string($_GET['incmeacount']);
        $subincmeacct =  mysql_real_escape_string($_GET['subincmeacct']);
           
       $qr="INSERT INTO subincomeaccs(accname,mainincgrp) VALUES ('$subincmeacct','$incmeacount')";
       $data=$mumin->insertdbContent($qr);
   
     
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data));
 
   exit();
   
 }
   if($action=="savsubexpnse"){  
     
      
          $name=mysql_real_escape_string($_GET['name']);
        $expnseacount=mysql_real_escape_string($_GET['expnseacount']);
        $subexpenseacct =  mysql_real_escape_string($_GET['expensesubacct']);
           
       $qr="INSERT INTO subexpnseaccs(accname,mainexpgrp,deptid) VALUES ('$subexpenseacct','$expnseacount','$name')";
       $data=$mumin->insertdbContent($qr);
   
     
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data));
 
   exit();
   
 }
 
 
  if($action=="savclosingdate"){  
     
      
     $clsngdate=mysql_real_escape_string($_GET['cdate']);
        $esatid=mysql_real_escape_string($_GET['esatid']);
        $ts = date ('Y-m-d h:i:s');
        $user=$_SESSION['jname'];
        $cdate = date('Y-m-d',  strtotime($clsngdate));
         $localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING);
        if ($esatid == 'all'){

                   $jqery="SELECT deptid,deptname FROM department"; 
                         $datay=$mumin->getdbContent($jqery);
    
      for($j=0;$j<=count($datay)-1;$j++){    
               $column = $datay[$j]['deptid'];
           $qryupdte = "INSERT INTO closing_period(deptid,cdate,ts,us,ip) VALUES ('$column','$cdate','$ts','$user','$localIP')   ";    
             $data=$mumin->updatedbContent($qryupdte);
             }
        }
         elseif ($esatid !== 'all') {
     $qr="INSERT INTO closing_period(deptid,cdate,ts,us,ip) VALUES ('$esatid','$cdate','$ts','$user','$localIP')";
     
     
    $data=$mumin->insertdbContent($qr);
    }
     
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data));
 
   exit();
   
 }
if($action=="savxpnse"){  
     
      
     $name=mysql_real_escape_string($_GET['expname']);
        $esatid=mysql_real_escape_string($_GET['expnsatid']);
        $acctype = mysql_real_escape_string($_GET['expenstype']);
        if ($esatid == 'all'){
                  $qr="INSERT INTO expnseaccs(id,accname,type) VALUES ('','$name','$acctype')";
       $data37=$mumin->insertdbContent($qr);
            $jqery="SELECT id,accname FROM expnseaccs"; 
                         $datay=$mumin->getdbContent($jqery);
      for($t=0;$t<=count($datay)-1;$t++){    
               $column = $datay[$t]['id'];
           $qryupdte = "UPDATE expnseaccs set `$column`= '1' WHERE accname = '$name'   ";    
             $data86=$mumin->updatedbContent($qryupdte);
             }
        }
        else {
     $qr2="INSERT INTO expnseaccs(id,accname,subexpgrp,	type) VALUES ('','$name','0','$acctype')";
     $data37=$mumin->insertdbContent($qr2);
           $jqery="SELECT id FROM expnseaccs WHERE accname = '$name' "; 
                         $datay=$mumin->getdbContent($jqery);
    
      for($j=0;$j<=count($datay)-1;$j++){    
               $column = $datay[$j]['id'];
           $qryupdte = "INSERT INTO expenseactmgnt (id,expenseacc,deptid) VALUES (' ','$column','$esatid')";
             $data86=$mumin->updatedbContent($qryupdte);
             }
    }
     
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data37));
 
   exit();
   
 }

 
 
     
 if($action=="savesupplierbill"){
     
      
      
     $date1=mysql_real_escape_string($_GET['date']);
     $date = date('Y-m-d', strtotime($date1));
     $docno=mysql_real_escape_string($_GET['docno']);
     $amount=mysql_real_escape_string($_GET['amount']);
     $expacc=mysql_real_escape_string($_GET['expacc']);
     $remarks=mysql_real_escape_string($_GET['remarks']);
     $user=$_SESSION['jname'];
     $est_id=$_SESSION['dept_id'];
     $supplier=mysql_real_escape_string($_GET['supplier']);
     $suppamt=$_GET['suppamt'];
     $taxamnt=mysql_real_escape_string($_GET['taxamnt']);
     $crdtinvno=mysql_real_escape_string($_GET['crdtinvno']);
     $doctype=mysql_real_escape_string($_GET['doctyp']);
     $suplrsubacc=mysql_real_escape_string($_GET['suplrsubacc']);
     $costcntre=mysql_real_escape_string($_GET['costcntre']);
     $ts=date('Y-m-d h:i:s');
     
$localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
    if ($doctype == '1'){
     $qr="INSERT INTO bills(estate_id,bdate,supplier,docno,expenseacc,amount,supamnt,taxamount,rmks,sector,ts,us,isinvce,payno,revsd,crdtinvce,subacc,costcentrid) VALUES ('$est_id','$date','$supplier','$docno','$expacc','$amount','$suppamt','$taxamnt','$remarks','$localIP','$ts','$user','$doctype','0','0','$crdtinvno','$suplrsubacc','$costcntre')";
     }
	 else if($doctype == '0'){
	 $qr="INSERT INTO bills(estate_id,bdate,supplier,docno,expenseacc,amount,pdamount,supamnt,taxamount,rmks,sector,ts,us,isinvce,payno,revsd,crdtinvce,subacc,costcentrid) VALUES ('$est_id','$date','$supplier','$docno','$expacc','$amount','$amount','$suppamt','$taxamnt','$remarks','$localIP','$ts','$user','$doctype','0','0','$crdtinvno','$suplrsubacc','$costcntre')";
	 $qry5 = "UPDATE bills  SET pdamount = pdamount + '$amount' WHERE estate_id = ' $est_id' AND supplier = '$supplier' AND docno = '$crdtinvno' AND isinvce = '1'";
	 $data78=$mumin->insertdbContent($qry5);
	 }
	 
     $data=$mumin->insertdbContent($qr);

     
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data));
 
   exit();
 
 }
   if($action=="savesuppliermultiplebill"){
     
      
      
     $date1=mysql_real_escape_string($_GET['date']);
     $date = date('Y-m-d', strtotime($date1));
     $docno=mysql_real_escape_string($_GET['docno']);
     $amount= explode(",",$_GET['amount']);
     $expacc=mysql_real_escape_string($_GET['expacc']);
     $remarks=mysql_real_escape_string($_GET['remarks']);
     $user=$_SESSION['jname'];
     $est_id=$_SESSION['dept_id'];
     $supplier=mysql_real_escape_string($_GET['supplier']);
     $doctype=mysql_real_escape_string($_GET['doctyp']);
     $suplrsubacc=mysql_real_escape_string($_GET['suplrsubacc']);
     $costicntre= explode(",",$_GET['costcntre']);
     $ts=date('Y-m-d h:i:s');
     
$localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
            for($f=0;$f<=count($amount)-2;$f++){
     $qr="INSERT INTO bills(estate_id,bdate,supplier,docno,expenseacc,amount,supamnt,taxamount,rmks,sector,ts,us,isinvce,payno,revsd,crdtinvce,subacc,costcentrid) VALUES ('$est_id','$date','$supplier','$docno','$expacc','$amount[$f]',' ',' ','$remarks','$localIP','$ts','$user','$doctype','0','0',' ','$suplrsubacc','$costicntre[$f]')";
   $data=$mumin->insertdbContent($qr);
            }
	 
     

     
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data));
 
   exit();
 
 }
 
 if($action=="outgoinginvoice"){
     
     $date1=mysqli_real_escape_string($mumin->connectiondb(),$_GET['date']);
      $date = date('2018-08-05');
     $amount=mysqli_real_escape_string($mumin->connectiondb(),$_GET['total']);
     $debtor=mysqli_real_escape_string($mumin->connectiondb(),$_GET['debtor']);
     $remarks=mysqli_real_escape_string($mumin->connectiondb(),$_GET['rmks']);
	 $subacct=mysqli_real_escape_string($mumin->connectiondb(),$_GET['subacct']);
     $user=$_SESSION['jname'];
     $est_id=$_SESSION['dept_id'];; // Used as cost centerid
     $ts=date('Y-m-d h:i:s');
     // Check if mumin or Debtor
     if($_GET['sabilno']){
         $sabilno=mysqli_real_escape_string($mumin->connectiondb(),$_GET['sabilno']);
     $ejamaat= $mumin->get_MuminHofEjnoFromSabilno($sabilno);
     }
 else {
       $sabilno = ' ';
       $ejamaat = ' ';
     }
     //Auto increament invoice Number 
     $docno=sprintf('%06d',intval($mumin->refnos("invno")));
     if ($debtor){
         // Find debtor details
         $qr0="SELECT dno,debTelephone,city FROM debtors WHERE debtorname = '$debtor' AND deptid = '$est_id'"; 
                                
           $data1=$mumin->getdbContent($qr0);
     $debtor2 = $data1[0]['dno'];
     $tel= $data1[0]['debTelephone'];
     $city1= $data1[0]['city'];
     }
     else{
         //Mumin display
         $debtor2 = '0';
         $tel='';
         $city1='';
         
     }
     //Get income account Name
     $accounts=trim($_GET['account']); 
     $qr1="SELECT accname FROM incomeaccounts WHERE incacc = '$accounts' "; 
                                
           $data2=$mumin->getdbContent($qr1);
     $accname3 = $data2[0]['accname'];
     $localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
     $qr="INSERT INTO invoice(estId,idate,amount,invno,rmks,hofej,sabilno,us,ts,rev,recpno,dno,incacc,isinvce,sector,subacc) VALUES ('$est_id','$date','$amount','$docno','$remarks','$ejamaat','$sabilno','$user','$ts',0,0,'$debtor2','$accounts','1','$localIP','$subacct')";
    // die($subacct);
     $data=$mumin->insertdbContent($qr);
     
    
    header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data,'invoice'=>$docno,'acctname'=>$accname3,'tel'=>$tel,'city'=>$city1)); 
 
   exit();
 
 }
    if($action=="unpaidinvoices"){
     
      
      
     $debtor=mysql_real_escape_string($_GET['debtor']);
     
     $sab=mysql_real_escape_string($_GET['sabilno']);
     
     $incomeaccount=$_GET['incacct'];
      
     $est_id=$_SESSION['dept_id'];
     
     if($sab){
      
          $ourdebtor=$mumin->get_MuminHofNamesFromSabilno($sab);
          $sqry = $mumin->getdbContent("SELECT sector FROM mumin WHERE sabilno = '$sab' LIMIT 1");
          $msect = $sqry[0]['sector'];
        
         $qr="SELECT invno,DATE_FORMAT(idate,'%d-%m-%Y') as idate, amount,accname,e.incacc as incacc,sabilno,pdamount,(amount-pdamount)as balnce FROM  invoice e JOIN incomeaccounts a ON  e.incacc =a.incacc WHERE e.estId = '$est_id' AND e.sabilno LIKE '$sab'  AND e.pdamount<e.amount AND e.incacc = '$incomeaccount' order by opb desc ";
      
     }
     else{
      
         $m=$mumin->getdbContent("SELECT * FROM debtors WHERE debtorname LIKE '$debtor' AND deptid LIKE '$est_id' LIMIT 1");
         $msect= '';
         $ourdebtor=$m[0]['debtorname'];
        $deptrid = $m[0]['dno'];
         $qr="SELECT invno,DATE_FORMAT(idate,'%d-%m-%Y') as idate, amount,accname,e.incacc as incacc ,sabilno,pdamount,(amount-pdamount)as balnce FROM  invoice e JOIN incomeaccounts a ON  e.incacc =a.incacc WHERE e.estId LIKE '$est_id' AND e.dno LIKE '$deptrid'  AND e.pdamount<e.amount AND e.incacc = '$incomeaccount' order by opb desc";
       
     }
     $data=$mumin->getdbContent($qr);
     
     $amount=0;
     
     $response=array();
     $totalamt=0;
     for($i=0;$i<=count($data)-1;$i++){ //complex algorithm to bring to board partial payment and opening  balances
     
         $response[$i]=array('idate'=>$data[$i]['idate'],'invno'=>$data[$i]['invno'],'amount'=>$data[$i]['amount'],"accname"=>$data[$i]['accname'],"toacc"=>$data[$i]['incacc'],"sabilno"=>$data[$i]['sabilno'],"ourdebtor"=>$ourdebtor,"totlamount"=>$totalamt,"paidamnt"=>$data[$i]['pdamount'],"sectr"=>$msect,"incacc"=>$data[$i]['incacc']);  
     
     }
     
     header('Content-type: application/json'); 
 
   echo  json_encode($response);  
 
   exit();
 
 }
 
  if($action=="creditnote"){
        
     $date1=mysql_real_escape_string($_GET['date']);
     $date = date('Y-m-d', strtotime($date1));
     $debtor=mysql_real_escape_string($_GET['debtor']); // debtorname
     $amount=mysql_real_escape_string($_GET['amount']); //amount
     $remarks=mysql_real_escape_string($_GET['remarks']);
     $crditinvce=mysql_real_escape_string($_GET['crditinvce']);
     $user=$_SESSION['jname'];
     $est_id=$_SESSION['dept_id'];
     $ts=date('Y-m-d h:i:s');
          $docno=sprintf('%06d',intval($mumin->refnos("crnote")));
  if($_GET['sabilno']){
         $sabilno=mysql_real_escape_string($_GET['sabilno']);
     $ejamaat= $mumin->get_MuminHofEjnoFromSabilno($sabilno);
     }
 else {
       $sabilno = ' ';
       $ejamaat = ' ';
     }
     
     if ($debtor){
         $qr0="SELECT dno,debTelephone,city FROM debtors WHERE debtorname = '$debtor' AND deptid = '$est_id'"; 
                                
           $data1=$mumin->getdbContent($qr0);
     $debtor2 = $data1[0]['dno'];
     $tel= $data1[0]['debTelephone'];
     $city1= $data1[0]['city'];
     }
     else{
         $debtor2 = '';
         $tel='';
         $city1='';
         
     }
     $accounts=trim($_GET['account']); 
     $qr1="SELECT accname FROM incomeaccounts WHERE incacc = '$accounts' "; 
                                
           $data2=$mumin->getdbContent($qr1);
     $accname3 = $data2[0]['accname'];
    $localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
     $qr="INSERT INTO invoice(estId,idate,amount,pdamount,invno,rmks,hofej,sabilno,us,ts,rev,recpno,dno,incacc,isinvce,sector,crdtinvce) VALUES ('$est_id','$date','$amount','$amount','$docno','$remarks','$ejamaat','$sabilno','$user','$ts',0,0,'$debtor2','$accounts','0','$localIP','$crditinvce')";
     
     $data3=$mumin->insertdbContent($qr);
    if ($data3){
	$upda = "UPDATE invoice SET pdamount = pdamount + $amount WHERE estId = '$est_id' AND invno = '$crditinvce' AND isinvce = '1'";
        $response9= $mumin->updatedbContent($upda);
        $flag= 'Ok';
     $errmessage = 'Inserted';
    }
    header('Content-type: application/json');
     $data=array('flag'=>$flag,'errmessage'=>$errmessage,'ejamaat'=>$ejamaat,'docno'=>$docno,'accounts'=>$accounts,'invoice'=>$crditinvce,'debtor'=>$debtor2,'sabilno'=>$sabilno,'sectorname');

    header('Content-type: application/json'); 
 
   echo  json_encode($data); 
 
   exit();
 
 }
   if($action=="creditnotes"){
        
     $date1=mysql_real_escape_string($_GET['date']);
     $date = date('Y-m-d', strtotime($date1));
     $debtor=mysql_real_escape_string($_GET['debtor']); // debtorname
     $amount=mysql_real_escape_string($_GET['amount']); //amount
     $remarks=mysql_real_escape_string($_GET['remarks']);
     $crditinvce=explode(',',$_GET['crditinvce']);
     $indvidualamnt=explode(',',$_GET['individualamnt']);
     $user=$_SESSION['jname'];
     $est_id=$_SESSION['dept_id'];
     $ts=date('Y-m-d h:i:s');
          $docno=sprintf('%06d',intval($mumin->refnos("crnote")));
  if($_GET['sabilno']){
         $sabilno=mysql_real_escape_string($_GET['sabilno']);
     $ejamaat= $mumin->get_MuminHofEjnoFromSabilno($sabilno);
     }
 else {
       $sabilno = ' ';
       $ejamaat = ' ';
     }
     
     if ($debtor){
         $qr0="SELECT dno,debTelephone,city FROM debtors WHERE debtorname = '$debtor' AND deptid = '$est_id'"; 
                                
           $data1=$mumin->getdbContent($qr0);
     $debtor2 = $data1[0]['dno'];
     $tel= $data1[0]['debTelephone'];
     $city1= $data1[0]['city'];
     }
     else{
         $debtor2 = '';
         $tel='';
         $city1='';
         
     }
     $accounts=trim($_GET['account']); 
     $qr1="SELECT accname FROM incomeaccounts WHERE incacc = '$accounts' "; 
                                
           $data2=$mumin->getdbContent($qr1);
     $accname3 = $data2[0]['accname'];
    $localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
     $qr="INSERT INTO invoice(estId,idate,amount,pdamount,invno,rmks,hofej,sabilno,us,ts,rev,recpno,dno,incacc,isinvce,sector,crdtinvce) VALUES ('$est_id','$date','$amount','$amount','$docno','$remarks','$ejamaat','$sabilno','$user','$ts',0,0,'$debtor2','$accounts','0','$localIP','".$_GET['crditinvce']."')";
     
     $data3=$mumin->insertdbContent($qr);
    if ($data3){
        for($k=0;$k<=count($crditinvce)-1;$k++){
	$upda = "UPDATE invoice SET pdamount = pdamount + $indvidualamnt[$k] WHERE estId = '$est_id' AND invno = '$crditinvce[$k]' AND isinvce = '1'";
        $response9= $mumin->updatedbContent($upda);
        }
        $flag= 'Ok';
     $errmessage = 'Inserted';
    }
    header('Content-type: application/json');
     $data=array('flag'=>$flag,'errmessage'=>$errmessage,'ejamaat'=>$ejamaat,'docno'=>$docno,'accounts'=>$accounts,'invoice'=>$crditinvce,'debtor'=>$debtor2,'sabilno'=>$sabilno,'sectorname');

    header('Content-type: application/json'); 
 
   echo  json_encode($data); 
 
   exit();
 
 }
  if($action=="getUserDatax"){
     
    $ejno=$_GET['ejno'];
    
   //$moh=$_SESSION['mohalla'];
   
   //$socty_id=$_SESSION['socty_id'];
    
 $query="SELECT * FROM mumin WHERE ejno = '$ejno'"; 
     
    $array=$mumin->getdbContent($query);
  
    header('Content-type: application/json'); 
 
    echo  json_encode($array);
 
    exit();  
 }
 
 
 if($action=="getunpaidbills"){
     
           
     $supplier=mysql_real_escape_string($_GET['supplier']);
      
     $est_id=$_SESSION['dept_id'];
      
    
     $qr="SELECT DATE_FORMAT(bdate,'%d-%m-%Y') as bdate,docno,IF(isinvce='1',amount,-1*amount)as amount,pdamount,accname,expenseacc,costcentrid,centrename FROM bills,expnseaccs,department2 WHERE bills.expenseacc = expnseaccs.id AND department2.id = bills.costcentrid AND estate_id LIKE '$est_id' AND supplier LIKE '$supplier'  AND amount>pdamount ORDER BY DATE(bdate)";
   
     $data=$mumin->getdbContent($qr);
    
     
    header('Content-type: application/json'); 
 
   echo  json_encode($data);
 
   exit();
 
 }
 
 

 
 
 if($action=="getmuminNameForinvoice"){  //get mumin names and data for invoice
     
      $sabilx=$_GET['sabil'];
      
          $id=$_SESSION['dept_id'];;
     $qr="SELECT hofej,ejno,sabilno,sector FROM  mumin  WHERE sabilno = '$sabilx'  AND ejno = hofej  LIMIT 1";
      $data=$mumin->getdbContent($qr);
          
    if ($data){
     $name=$mumin->get_MuminNames($data[0]['ejno']);
     $ejnu = $data[0]['ejno'];
     $sectorname = $data[0]['sector'];
    }
    else{
        $qry = "SELECT sabilno FROM debtors  WHERE sabilno='$sabilx' AND deptid = '$id'";
        $result1=$mumin->getdbContent($qry);
        if($result1){
            $name = 'debtor';
            $ejnu = '';
           
        } else{
        $name= 'Not in Mohalla';
        $ejnu = '';
        $sectorname = '';
        }
    }
     //$invno=sprintf('%06d',intval($mumin->refnos("invno")));
     
    header('Content-type: application/json'); 
 
   echo  json_encode(array('name'=>$name,'ejno'=>$ejnu,'sabil'=>$sabilx,'sector'=>$sectorname));
 
   exit();   
 }

 if($action=="sortablereceiptlist"){  //get estate debtor names
     
   
     $debtorid=mysql_real_escape_string($_GET['id']);
      
      $es_id=$_SESSION['dept_id']; 
     
     $qr="SELECT * FROM debtors  WHERE dno LIKE '$debtorid'  AND deptid LIKE '$es_id' LIMIT 1";
     
     $data=$mumin->getdbContent($qr );
     
     $invno=sprintf('%06d',intval($mumin->refnos("invno")));
      
     
    header('Content-type: application/json'); 
 
   echo  json_encode(array('name'=>$data[0]['debtorname'],'invoicenumber'=>$invno));
 
   exit();   
     
     
     
 }
     
 
 
 if($action=="getDebtorNames"){  //get estate debtor names
     
   
     $debtorid=mysql_real_escape_string($_GET['id']);
      
      $es_id=$_SESSION['dept_id']; 
     
     $qr="SELECT * FROM debtors  WHERE dno LIKE '$debtorid'  AND deptid LIKE '$es_id' LIMIT 1";
     
     $data=$mumin->getdbContent($qr );
     
     //$invno=sprintf('%06d',intval($mumin->refnos("invno")));
      
     
    header('Content-type: application/json'); 
 
   echo  json_encode(array('name'=>$data[0]['debtorname']));
 
   exit();   
     
     
     
 }
     
 
 if($action=="invoicepayment"){   //chequepayment to invoices
     
      
     $docnumbers=  explode(",",$_GET['docnumbers']);
     $individualamt= explode(",",$_GET['individualamt']);
	 $individualbillid= explode(",",$_GET['individualbillid']);
     $chequedate1=trim($_GET['chequedate']);
     $chequedate = date('Y-m-d', strtotime($chequedate1));
     $chequeno=trim($_GET['chequeno']);
     $amount=trim($_GET['amount']);
     //$narration=trim($_GET['narration']);
     $paymentdate1=trim($_GET['paymentdate']);
     $paymentdate = date('Y-m-d', strtotime($paymentdate1));
     $expacc=trim($_GET['expacct']);
     $acc=trim($_GET['acc']);
     $remarks=trim($_GET['remarks']);
     $ccentreid = explode(",",$_GET['ccentreid']);
     $user=$_SESSION['jname'];
     $est_id=$_SESSION['dept_id'];
     $supplier=trim($_GET['supplier']);
     
     $ts=date('Y-m-d h:i:s');
     $array = $_GET["pymntarry"];
     $transactiontime = date('Y-m-d');
     $imp = "'" . implode("','", $docnumbers) . "'";
     $payno = array();
     $camnts = array();
$localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
               $qtery = "SELECT sum(bbfamt) as bankbal FROM (SELECT sum(amount) as bbfamt FROM recptrans WHERE bacc=$acc AND est_id = '$est_id' AND date(depots) <= '$transactiontime' UNION
                                                       SELECT sum(amount) as bbfamt FROM (SELECT IF(revsd='1' and dexpno LIKE '%R%',amount,amount*-1)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,jid FROM directexpense WHERE dexpdate <= '$transactiontime'  and estate_id ='$est_id')t7 WHERE bankacct = $acc UNION                        
                                                        SELECT (sum(amount)*-1)as bbfamt FROM paytrans WHERE bacc='$acc' AND estId = '$est_id' AND pdate <= '$transactiontime' UNION
                                                       SELECT sum(amount) as bbfamt FROM (SELECT IF(crdtacc= '$acc' AND cbacc = '1' ,amount*-1,amount)as amount,tno FROM jentry WHERE (crdtacc= '$acc' or dbtacc = '$acc') AND  estId = '$est_id' AND jdate <= '$transactiontime')T1) t6 ";
           $balanceldgr=$mumin->getdbContent($qtery);                                                                                                                                                        
           $balbbf = $balanceldgr[0]['bankbal'];
     if($balbbf < $amount ){
         $response='0';
         $payno[] = '0';
         $camnts[] = '0';
     }else{
      //insert transaction into paytrans
         foreach ($array as $key => $value) {
 $return[$value[1]][] = $value[0];
}
        foreach ($return as $key => $value) {
            $centramnt =  implode(',', $value);
            $amnt = array_sum($value);
            $pvno=sprintf('%06d',intval($mumin->refnos("payno")));
     $qr="INSERT INTO paytrans(estId,pdate,amount,pmode,payno,chqdet,chqno,rmks,supplier,sector,tno,bacc,chequedate,ts,us,rev,expenseacc,costcentrid) 
         VALUES ($est_id,'$paymentdate','$amnt','CHEQUE','$pvno','','$chequeno','$remarks','$supplier','$localIP','','$acc','$chequedate','$ts','$user',0,'$expacc','$key')";
     $response=$mumin->insertdbContent($qr);
     $payno[] =+  $pvno;
 $camnts[] =+ $amnt;
 $gry = "SELECT GROUP_CONCAT(docno) as docno FROM bills WHERE costcentrid = '$key' AND docno IN ($imp) " ;
     $d=$mumin->getdbContent($gry);
     $updt = "UPDATE paytrans SET bills = '".$d[0]['docno']."' , billamnt = '$centramnt' WHERE payno = '$pvno' AND estId = '$est_id' AND costcentrid = '$key' ";
     $rst=$mumin->updatedbContent($updt);
     }
     if($response==1){
         
           for($k=0;$k<=count($docnumbers)-2;$k++){  // mark all invoices bearing this document number as paid

                         $qq="UPDATE bills SET pdamount = pdamount + $individualamt[$k]  WHERE docno = '$docnumbers[$k]' AND estate_id  LIKE '$est_id' AND id = '$individualbillid[$k]' AND supplier LIKE '$supplier' AND costcentrid = '$ccentreid[$k]'"; 
                         $rs1=$mumin->updatedbContent($qq);
                        }
     }
     }
     header('Content-type: application/json'); 
 
     echo  json_encode(array('id'=>$response,'payno'=>$payno,'camnts'=>$camnts));
 
   exit();
 
 }
 
 
  
 if($action=="invoicepaymentcsh"){   //cash payment to invoces  
     
      
     $docnumbers=  explode(",",$_GET['docnumbers']);
     $individualamt= explode(",",$_GET['individualamt']);
     $amount=trim($_GET['amount']);
     
     $paymentdate1=mysql_real_escape_string($_GET['paymentdate']);
     $paymentdate = date('Y-m-d', strtotime($paymentdate1));
     $expacc=mysql_real_escape_string($_GET['expacct']);
     $acc=mysql_real_escape_string($_GET['acc']);
     $remarks=mysql_real_escape_string($_GET['remarks']);
     $user=$_SESSION['jname'];
     $est_id=$_SESSION['dept_id'];
     $supplier=mysql_real_escape_string($_GET['supplier']);
     $ccnter = explode(",",$_GET['ccnter']);
     $transactiontime = date('Y-m-d');
     $ts=date('Y-m-d h:i:s');
     $array = $_GET["pymntarry"];
      $imp = "'" . implode("','", $docnumbers) . "'";
     $payno = array();
     $camnts = array();
$localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
            $qtery = "SELECT sum(bbfamt) as bankbal FROM (SELECT sum(amount) as bbfamt FROM recptrans WHERE bacc=$acc AND est_id = '$est_id' AND date(depots) <= '$transactiontime' UNION
                                                       SELECT sum(amount) as bbfamt FROM (SELECT IF(revsd='1' and dexpno LIKE '%R%',amount,amount*-1)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,jid FROM directexpense WHERE dexpdate <= '$transactiontime'  and estate_id ='$est_id')t7 WHERE bankacct = $acc UNION                        
                                                        SELECT (sum(amount)*-1)as bbfamt FROM paytrans WHERE bacc='$acc' AND estId = '$est_id' AND pdate <= '$transactiontime' UNION
                                                       SELECT sum(amount) as bbfamt FROM (SELECT IF(crdtacc= '$acc' AND cbacc = '1' ,amount*-1,amount)as amount,tno FROM jentry WHERE (crdtacc= '$acc' or dbtacc = '$acc') AND  estId = '$est_id' AND jdate <= '$transactiontime')T1) t6 ";
           $balanceldgr=$mumin->getdbContent($qtery);                                                                                                                                                        
           $balbbf = $balanceldgr[0]['bankbal'];
     if($balbbf < $amount ){
         $response='0';
         $payno[] = '0';
         $camnts[] = '0';
     }
     else{
         

foreach ($array as $key => $value) {
 $return[$value[1]][] = $value[0];
}

foreach ($return as $key => $value) {
 $centramnt =  implode(',', $value);
  //$indvilamnt = implode(',', $value);
  $amnt = array_sum($value);
 // echo (array_sum($value));
       $pvno= sprintf('%06d',intval($mumin->refnos("payno")));
     $qr="INSERT INTO paytrans(estId,pdate,amount,pmode,payno,chqdet,chqno,rmks,supplier,sector,tno,bacc,chequedate,ts,us,rev,expenseacc,costcentrid) 
         VALUES ($est_id,'$paymentdate','$amnt','CASH','$pvno','','','$remarks','$supplier','$localIP','','$acc','','$ts','$user',0,'$expacc','$key')";
     $response=$mumin->insertdbContent($qr);  
 $payno[] =+  $pvno;
 $camnts[] =+ $amnt;
    $gry = "SELECT GROUP_CONCAT(docno) as docno FROM bills WHERE costcentrid = '$key' AND docno IN ($imp) " ;
     $d=$mumin->getdbContent($gry);
     $updt = "UPDATE paytrans SET bills = '".$d[0]['docno']."' , billamnt = '$centramnt' WHERE payno = '$pvno' AND estId = '$est_id' AND costcentrid = '$key' ";
     $rst=$mumin->updatedbContent($updt);
     
}
   if($response==1){
         
         for($k=0;$k<=count($docnumbers)-2;$k++){  // mark all invoices bearing this document number as paid

                         $qq = "UPDATE bills SET pdamount = pdamount + $individualamt[$k]  WHERE docno = '$docnumbers[$k]' AND estate_id  LIKE '$est_id' AND supplier LIKE '$supplier' AND costcentrid = '$ccnter[$k]'"; 
                         $rs1=$mumin->updatedbContent($qq);
                        }
                          
                      
                       
     }
     }
     header('Content-type: application/json'); 
 
     echo  json_encode(array('id'=>$response,'payno'=>$payno,'camnts'=>$camnts));
 
   exit();
 
 }
 
       if($action=="reprintingpaymentvchr"){
     
       
     $payvno= $_GET['payvno'];
   
 
     $est_id=$_SESSION['dept_id'];
     
     $data=$mumin->getdbContent("SELECT * FROM paytrans WHERE payno LIKE '$payvno' AND estId LIKE '$est_id' AND rev = 0 LIMIT 1");

        if($data){
     $paymentdate=$data[0]['pdate'];
     $chequedate=$data[0]['chequedate'];
     $chequeno= $data[0]['chqno'];
     $amount=$data[0]['amount'];
     $chequedetails= $data[0]['chqdet'];
     $docnumbers= $data[0]['bills'];
     $payvochr=$data[0]['payno'];
     $remarks= $data[0]['rmks'];
     $supplier= $data[0]['supplier'];
     $acc=$data[0]['bacc'];
      $expenseacc=$data[0]['expenseacc'];
       $costcid=$data[0]['costcentrid'];
      
     if (!$chequeno){
         //$modei = 'CASH';
       $url = "cashpaymentvoucher.php?supplier=".$supplier."&docnumbers=".$docnumbers."&amount=".$amount."&paymentdate=".$paymentdate."&acc=".$acc."&payno=".$payvochr."&rmks=".$remarks."&expacc=".$expenseacc."&costcid=".$costcid."";
         //header("location:cashpaymentvoucher.php?supplier=".$supplier."&docnumbers=".$docnumbers."&amount=".$amount."&paymentdate=".$paymentdate."&acc=".$acc."&payno=".$payvochr."&rmks=".$remarks."");
//echo "<script>window.location='invoicepreview.php?paymentdate=".$data[0]['idate']."&remarks=".$data[0]['rmks']."&amount=".$data[0]['amount'].".00&sabilno=".$data[0]['sabilno']."&docno=".$data[0]['invno']."&debtor=".$data[0]['dno']."&acctname=".$data2[0]['accname']."&dispname=".$dispname."&tel=".$debtel."&sector=".$data[0]['sector']."&city=".$city."';</script>";
     }  else if($chequeno) {
         //$modei = 'CHEQUE';
         $url = "paymentvoucher.php?supplier=".$supplier."&docnumbers=".$docnumbers."&chequedate=".$chequedate."&chequeno=".$chequeno."&amount=".$amount."&narration=".$remarks."&paymentdate=".$paymentdate."&acc=".$acc."&payno=".$payvochr."&expacc=".$expenseacc."&costcid=".$costcid."";
    }}
    else{
        $url = '';
    }
  header('Content-type: application/json'); 
 
   echo  json_encode(array('url'=>$url));

   exit();
    
 }  
 
 
 
 if($action=="adduserpriviledges"){
     
      
     $usname=mysql_real_escape_string($_GET['usname']);
     
     $pwd=mysql_real_escape_string($_GET['pwd']); 
       
     $level=mysql_real_escape_string($_GET['level']);       $sectorn=mysql_real_escape_string($_GET['sectname']);
     
     $est_id=$_SESSION['dept_id'];
     $moh= $_SESSION['emoh'];
     
     if($usname=="" || $pwd ==""){
         
         $data="UserName /PassWord CANNOT be blank";
     }
     else{
     
      $check="SELECT * FROM pword WHERE e_uname LIKE '$usname'" ;  
      $rs=$mumin->getdbContent($check);
      
      if($rs){
         
          $data="USERNAME NOT AVAILABLE ,PLEASE TRY ANOTHER USERNAME";
      }
        else{ 
         
     $qr="INSERT INTO pword(e_uname,moh,pwd,grp,acclevel,est_id,suspended,privileges,sector) VALUES ('$usname','$moh','".password_hash($pwd,PASSWORD_BCRYPT)."','EXTERNAL','999','$est_id','0','$level','$sectorn')";
     
     $d=$mumin->insertdbContent($qr);
     
     if($d==1){
         $data="User Added successfully";
     }
    else{
       $data="Error-User not added"; 
    }
     }
     }
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data));
 
   exit();
   
 }
 
 
 
 
 if($action=="changeuserpriviledges"){
     
      
     $usname=trim($_GET['usname']);
     
       
     $level=trim($_GET['level']);
     
     $est_id=$_SESSION['dept_id'];
    
     $qr="UPDATE pword SET privileges= $level WHERE uname LIKE '$usname' AND estate_prop LIKE '$est_id'";
     
     $d=$mumin->updatedbContent($qr);
     
     
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$d));
 
   exit();
   
 }
 
 
 if($action=="removeusers"){
     
      
     $usname=trim($_GET['usname']);
     
       
     
     $est_id=$_SESSION['dept_id'];
    
     $qr="DELETE FROM pword WHERE uname LIKE '$usname' AND estate_prop LIKE '$est_id'";
     
     $d=$mumin->insertdbContent($qr);
     
     
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$d));
 
   exit();
   
 }
 
 
 if($action=="checkavailability"){
     
      
     $val=trim($_GET['value']);
     
     $qr="SELECT * FROM pword  WHERE e_uname = '$val'";
     
     $d=$mumin->getdbContent($qr);
     
     if($d){
         
         $data="<font color='red'>Username Already taken</font>";
     }
     else{
         $data="<font color='green'>Username Allowed </font>";  
     }
     
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data));
 
   exit();
   
 }
 
 if($action=="jvvalue"){
     
     $est_id=$_SESSION['dept_id'];
     
     $type=trim($_GET['type']);
     
     if($type==0){
         
     $qr="SELECT bacc as id,acname as accname FROM estate_bankaccounts WHERE estate_id LIKE '$est_id'";
     //$q2="SELECT bacc,acname FROM estate_bankaccounts WHERE estate_id LIKE '$est_id'";
     $d=$mumin->getdbContent($qr);
     //$d2=$mumin->getdbContent($q2);
     header('Content-type: application/json'); 
     echo  json_encode(array($d));
     }
     else if($type==1){
         
        $qr="SELECT id,accname FROM estate_expaccs";
        $q2="SELECT bacc,acname FROM estate_bankaccounts WHERE estate_id LIKE '$est_id'";
           $d=$mumin->getdbContent($qr);
     $d2=$mumin->getdbContent($q2);
     
     
   header('Content-type: application/json'); 
 
   echo  json_encode(array($d,$d2));
//   echo  json_encode(array('id'=>$response,'payno'=>$pvno));
        
     }
     
  
   exit();
   
 }
 
 
 
 
 
  if($action=="subexpnseaccnt"){
     
     $acctid=trim($_GET['acctid']);     
     $est_id=$_SESSION['dept_id'];
      
     $qr="SELECT id ,accname FROM subexpnseaccs WHERE mainexpgrp = '$acctid' AND deptid = '$est_id' "; 
     
     $d=$mumin->getdbContent($qr);
    
     
     header('Content-type: application/json'); 
 
   echo  json_encode($d);
 
   exit();
   
 }
 
 
   if($action=="subincmeaccnt"){
     
     $acctid=trim($_GET['acctid']);     
     
      
     $qr="SELECT id ,accname FROM subincomeaccs WHERE mainincgrp = '$acctid'"; 
     
     $d=$mumin->getdbContent($qr);
    
     
     header('Content-type: application/json'); 
 
   echo  json_encode($d);
 
   exit();
   
 }
 
   if($action=="getbankaccts"){
     
     $departmntid = trim($_GET['departmntid']);     
     
      
     $qr="SELECT bacc ,acno,acname FROM bankaccounts WHERE deptid LIKE '$departmntid'"; 
     
     $d=$mumin->getdbContent($qr);
    
     
     header('Content-type: application/json'); 
 
   echo  json_encode($d);
 
   exit();
   
 }
  if($action=="autocomplete1"){
     $deptid = @$_SESSION['dept_id'];
  
    $query="SELECT distinct debtorname,dno as debid FROM debtors WHERE deptid = '$deptid'";
     
    $array=$mumin->getdbContent($query);
  
    header('Content-type: application/json'); 
 
    echo  json_encode($array);
 
    exit();  
 }
  if($action=="autocomplete2"){
       
    $query="SELECT distinct moh FROM mumin";
     
    $array=$mumin->getdbContent($query);
  
    header('Content-type: application/json'); 
 
    echo  json_encode($array);
 
    exit();  
 }
   if($action=="invoiceperincome"){
       
       
    $query="SELECT incomeaccounts.accname,sum(amount) as amount FROM `invoice`,incomeaccounts WHERE invoice.incacc = incomeaccounts.incacc group by invoice.incacc";
     
    $array=$mumin->getdbContent($query);
  
    header('Content-type: application/json'); 
    echo  json_encode($array);
 
    exit();  
 }
   if($action=="autocomplete3"){
       $id=$_SESSION['dept_id'];
    $query="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id'";
     
    $array=$mumin->getdbContent($query);
  
    header('Content-type: application/json'); 
 
    echo  json_encode($array);
 
    exit();  
 }
 if($action=="savejv"){

     
               $est_id=$_SESSION['dept_id'];
      
              $date1=$_GET['jvdate'];
             
            $date = date('Y-m-d',  strtotime($date1));
              $amount=$_GET['jvamount'];
			 // die($amount);
             $ckdte= $_GET['ckdte'];
              if($ckdte!==""){
                  $ckdte1 = date('Y-m-d',  strtotime($ckdte));
              } else{
                  $ckdte1 = '0000-00-00';
              }
             
             $chkno= $_GET['chkno'];
             $chkdetails= $_GET['chkdetails'];
              $fromjv=$_GET['jvfrom'];
              
              $tojv=$_GET['jvto'];
                     
              $jvrmks=$_GET['jvrmks'];
              $secto = $_GET['sectr'];
              $debityp = $_GET['debityp'];
              $ts=date('Y-m-d h:i:s');
              
              $us=$_SESSION['jname'];
              
              //$jvno=$mumin->refnos("jvno");
              $jvno=sprintf('%06d',intval($mumin->refnos("jvno")));
               $sector = $secto;
             $localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
              if($fromjv==$tojv && $debityp == $secto ){
                 
                 $msg=2;  
              }
              
              else{
             $q="INSERT INTO jentry(estId, jdate, amount, jvno, rmks, tno, dbtacc, crdtacc,chqdate,chqno,chqdet, ts, us,dbacc,cbacc,sector)VALUES ('$est_id','$date','$amount','$jvno','$jvrmks',0,'$fromjv','$tojv','$ckdte1','$chkno','$chkdetails','$ts','$us','$debityp','$sector','$localIP')";
             
             $submit=$mumin->insertdbContent($q);
             
            if($submit==1){
              
            
              $msg=1;    
                 
         }
         else{
             
             $msg=0;   
              
         }
           
              }
         
      
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$msg,'jvno'=>$jvno));
 
   exit();
   
 }
  if($action=="reconsavejv"){

     
               $est_id=$_SESSION['dept_id'];
      
              $date1=mysql_real_escape_string($_GET['jvdate']);
             
            $date = date('Y-m-d',  strtotime($date1));
              $amount=mysql_real_escape_string($_GET['jvamount']);
              $ckdte1 = '0000-00-00';
              
              $fromjv=mysql_real_escape_string($_GET['jvfrom']);
              
              $tojv=mysql_real_escape_string($_GET['jvto']);
                     
              $jvrmks=mysql_real_escape_string($_GET['jvrmks']);
              $debityp = mysql_real_escape_string($_GET['debityp']);
              $ts=date('Y-m-d h:i:s');
              
              $us=$_SESSION['jname'];
              
              //$jvno=$mumin->refnos("jvno");
              $jvno=sprintf('%06d',intval($mumin->refnos("jvno")));
               
             $localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
    
             $q="INSERT INTO jentry(estId, jdate, amount, jvno, rmks, tno, dbtacc, crdtacc,chqdate,chqno,chqdet, ts, us,dbacc,cbacc,sector,recon)VALUES ('$est_id','$date','$amount','$jvno','$jvrmks',0,'$tojv','$fromjv','$ckdte1','','','$ts','$us','1','0','$localIP','1')";
             
             $submit=$mumin->insertdbContent($q);
             
            if($submit==1){
              
            
              $msg=1;    
                 
         }
         else{
             
             $msg=0;   
              
         }
           
              
         
      
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$msg,'jvno'=>$jvno));
 
   exit();
   
 }
  if($action=="savedrctexp"){

     
               $est_id=$_SESSION['dept_id'];
      
              $dexpdate1=mysql_real_escape_string($_GET['dexpdate']);
             $ccntrid = mysql_real_escape_string($_GET['ccntrid']);
            $dexpdate = date('Y-m-d',  strtotime($dexpdate1));
              $dxamount =mysql_real_escape_string($_GET['dxamount']);
             $ckdte= mysql_real_escape_string($_GET['ckdte']);
              if($ckdte!==""){
                  $ckdte1 = date('Y-m-d',  strtotime($ckdte));
              } else{
                  $ckdte1 = '0000-00-00';
              }
             
             $chkno= mysql_real_escape_string($_GET['chkno']);
             $chkdetails= trim($_GET['chkdetails']);
              $crdtacc = trim($_GET['crdtacc']);
              
              $expensacc=mysql_real_escape_string($_GET['expensacc']);
                     
              $dxrmks=mysql_real_escape_string($_GET['remks']);
              $secto = mysql_real_escape_string($_GET['sectr']);
              $ts=date('Y-m-d h:i:s');
              
              $us=$_SESSION['jname'];
              
              //$jvno=$mumin->refnos("jvno");
              $dexpno=sprintf('%06d',intval($mumin->refnos("dexpno")));
               $localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
             
             $q="INSERT INTO directexpense(dexpno, dexpdate, rmks, dacc, cacc,amount, chqdate, chqno,chqdet, ts, us,sector,estate_id,costcentrid)VALUES 
                                            ('$dexpno','$dexpdate','$dxrmks','$expensacc','$crdtacc','$dxamount','$ckdte1','$chkno','$chkdetails','$ts','$us','$localIP','$est_id','$ccntrid')";
             
             $submit=$mumin->insertdbContent($q);
             
            if($submit==1){

              $msg=1;    
                 
         }
         else{
             
             $msg=0;   
              
         }
           
              
         
      
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$msg,'dexpvno'=>$dexpno));
 
   exit();
   
 }
   if($action=="saverecondrctexp"){

     
               $est_id=$_SESSION['dept_id'];
      
              $dexpdate1=mysql_real_escape_string($_GET['dexpdate']);
             $ccntrid = mysql_real_escape_string($_GET['ccntrid']);
            $dexpdate = date('Y-m-d',  strtotime($dexpdate1));
              $dxamount =mysql_real_escape_string($_GET['dxamount']);
                  $ckdte1 = '0000-00-00';
             $crdtacc = mysql_real_escape_string($_GET['crdtacc']);
             $expensacc=mysql_real_escape_string($_GET['expensacc']);
                     
              $dxrmks=mysql_real_escape_string($_GET['remks']);
              $ts=date('Y-m-d h:i:s');
              
              $us=$_SESSION['jname'];
              
              //$jvno=$mumin->refnos("jvno");
              $dexpno=sprintf('%06d',intval($mumin->refnos("dexpno")));
               $localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
             
             $q="INSERT INTO directexpense(dexpno, dexpdate, rmks, dacc, cacc,amount, chqdate, chqno,chqdet, ts, us,sector,estate_id,costcentrid,recon)VALUES 
                                            ('$dexpno','$dexpdate','$dxrmks','$expensacc','$crdtacc','$dxamount','$ckdte1','','','$ts','$us','$localIP','$est_id','$ccntrid','1')";
             
             $submit=$mumin->insertdbContent($q);
             
            if($submit==1){

              $msg=1;    
                 
         }
         else{
             
             $msg=0;   
              
         }
           
              
         
      
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$msg,'dexpvno'=>$dexpno));
 
   exit();
   
 }
  if($action=="savejournalentry"){ // Function for cash payment
     
    // $docnumbers=  explode(",",$_GET['docnumbers']);
     $ledgertype=  explode(",",$_GET['ledgertype']);
      $ledgeraccts=  explode(",",$_GET['ledgeraccts']);
      $dramount=  explode(",",$_GET['dramount']);
      $cramount=  explode(",",$_GET['cramount']);
      $ledgeraccts2 = $_GET['ledgeraccts'];
     $journaldate1=mysql_real_escape_string($_GET['journaldate']); 
     $journaldate= date('Y-m-d', strtotime($journaldate1));
     $journalrmks=mysql_real_escape_string($_GET['journalrmks']); 
     
      $est_id=$_SESSION['dept_id'];
     $us=$_SESSION['jname'];
     $ts=date('Y-m-d h:i:s');
          //$groupIDStr = implode(',', $docnumbers);
     $rs=1;
     //$recpno=$mumin->refnos("recpno");
     $journaleno=sprintf('%06d',intval($mumin->refnos("jeno")));
     
$localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
      for($i=0;$i<=count($ledgertype)-2;$i++){
          $ledgeracctsval = explode('|',$ledgeraccts[$i]);
          $accntid = $ledgeracctsval[0]; //get value of account id
          $table = $ledgeracctsval[1];
          $typeid = $ledgeracctsval[2];
$qr="INSERT INTO journals (deptid, jdate, dramount,cramount, jno, rmks, acc, ip,tbl, type, ts, us) VALUES "
        . "            ('$est_id','$journaldate','$dramount[$i]','$cramount[$i]','$journaleno','$journalrmks','$accntid','$localIP','$table','$typeid','$ts','$us')";
      
$data=$mumin->insertdbContent($qr);
      }
    if($data==1){
         $rs=1;
     }
     else {
         $rs=0;
     }
  
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$rs,'journalno'=>$journaleno));
 
   exit();
   
 }
   if($action=="savedebtrbdebts"){ // Function for 
     
    // $docnumbers=  explode(",",$_GET['docnumbers']);
     $ledgertype=  explode(",",$_GET['ledgertype']);
      $ledgeraccts=  explode(",",$_GET['ledgeraccts']);
      $dramount=  explode(",",$_GET['dramount']);
      $cramount=  explode(",",$_GET['cramount']);
      $ledgeraccts2 = $_GET['ledgeraccts'];
     $journaldate1=mysql_real_escape_string($_GET['journaldate']); 
     $incmeid=mysql_real_escape_string($_GET['incmeid']); 
     $journaldate= date('Y-m-d', strtotime($journaldate1));
     $journalrmks=mysql_real_escape_string($_GET['journalrmks']); 
     
      $est_id=$_SESSION['dept_id'];
     $us=$_SESSION['jname'];
     $ts=date('Y-m-d h:i:s');
          //$groupIDStr = implode(',', $docnumbers);
     $rs=1;
     //$recpno=$mumin->refnos("recpno");
     $journaleno=sprintf('%06d',intval($mumin->refnos("gvno")));
     
$localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
      for($i=0;$i<=count($ledgertype)-2;$i++){
          $ledgeracctsval = explode('|',$ledgeraccts[$i]);
         $accntid = $ledgeracctsval[0]; //get value of account id
          $table = $ledgeracctsval[1];
          $typeid = $ledgeracctsval[2];
$qr="INSERT INTO bad_debtsmbrs (deptid, jdate, dramount,cramount, jno, rmks, acc, ip,tbl, type, ts, us,incacc) VALUES
                   ('$est_id','$journaldate','$dramount[$i]','$cramount[$i]','$journaleno','$journalrmks','$accntid','$localIP','$table','$typeid','$ts','$us','$incmeid')";
      
$data=$mumin->insertdbContent($qr);
      }
    if($data==1){
         $rs=1;
     }
     else {
         $rs=0;
     }
  
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$rs,'journalno'=>$journaleno));
 
   exit();
   
 }
 
    if($action=="savesupplrdebts"){ // Function for 
     
    // $docnumbers=  explode(",",$_GET['docnumbers']);
     $ledgertype=  explode(",",$_GET['ledgertype']);
      $ledgeraccts=  explode(",",$_GET['ledgeraccts']);
      $dramount=  explode(",",$_GET['dramount']);
      $cramount=  explode(",",$_GET['cramount']);
      $ledgeraccts2 = $_GET['ledgeraccts'];
     $journaldate1=mysql_real_escape_string($_GET['journaldate']); 
     $incmeid=mysql_real_escape_string($_GET['incmeid']); 
     $journaldate= date('Y-m-d', strtotime($journaldate1));
     $journalrmks=mysql_real_escape_string($_GET['journalrmks']); 
     
      $est_id=$_SESSION['dept_id'];
     $us=$_SESSION['jname'];
     $ts=date('Y-m-d h:i:s');
          //$groupIDStr = implode(',', $docnumbers);
     $rs=1;
     //$recpno=$mumin->refnos("recpno");
     $journaleno=sprintf('%06d',intval($mumin->refnos("gvno")));
     
$localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
      for($i=0;$i<=count($ledgertype)-2;$i++){
          $ledgeracctsval = explode('|',$ledgeraccts[$i]);
         $accntid = $ledgeracctsval[0]; //get value of account id
          $table = $ledgeracctsval[1];
          $typeid = $ledgeracctsval[2];
$qr="INSERT INTO bad_debtsupplrs (deptid, jdate, dramount,cramount, jno, rmks, acc, ip,tbl, type, ts, us,costcentrid) VALUES
                   ('$est_id','$journaldate','$dramount[$i]','$cramount[$i]','$journaleno','$journalrmks','$accntid','$localIP','$table','$typeid','$ts','$us','$incmeid')";
      
$data=$mumin->insertdbContent($qr);
      }
    if($data==1){
         $rs=1;
     }
     else {
         $rs=0;
     }
  
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$rs,'journalno'=>$journaleno));
 
   exit();
   
 }
 
 if($action=="selectsctr"){

     $responsearray=array();
               
              $jvto=$_GET['jvto'];
              $jvname=@$_GET['idname'];       
             $qery = "SELECT typ FROM  incomeaccounts WHERE incacc = '$jvto' and accname like  '%$jvname%'";
                    $sct=$mumin->getdbContent($qery);
                    @$responsearray['typ']=$sct[0]['typ'];
                    if(count($sct)==0){
               $qery2 = "SELECT type FROM  bankaccounts WHERE bacc = '$jvto' and CONCAT(acname,' ',acno) LIKE '%$jvname%'";
                    $sct2=$mumin->getdbtypename($qery2);
                    @$responsearray['type'] = $sct2['type'];
                    }     
                  header('Content-type: application/json');
                  
            echo  json_encode($responsearray);
 
   //exit();
   
    }
  if($action=="jvnames"){

      
        $sabil=mysql_real_escape_string($_GET['sabil']);
        
        $names=$mumin->get_MuminHofNamesFromSabilno($sabil);
        
        
       header('Content-type: application/json'); 
 
   echo  json_encode(array('name'=>$names));
 
   exit();
  }
  
  
  if($action=="updatedebtorsinfo"){

      
        $est_id=$_SESSION['dept_id'];
        $id= mysql_real_escape_string($_GET['id']);
        $tel =mysql_real_escape_string($_GET['tel']);
        $name=mysql_real_escape_string($_GET['name']);
        $postal=mysql_real_escape_string($_GET['postal']);
        $email=mysql_real_escape_string($_GET['email']);
        $city=mysql_real_escape_string($_GET['city']);
	$hseno=mysql_real_escape_string($_GET['hseno']);
        
        $qw="UPDATE debtors SET debtorname='$name',debTelephone='$tel',email='$email',postal='$postal',city='$city',hseno ='$hseno' WHERE deptid = '$est_id' AND dno = $id ";
        $fd=$mumin->updatedbContent($qw);
        
        
       header('Content-type: application/json'); 
 
       echo  json_encode(count($fd));
 
   exit();
  }
  
    if($action=="updatepdchqinfo"){

      
        $est_id=$_SESSION['dept_id'];
        $id= mysql_real_escape_string($_GET['id']);
        $pdeditdate =mysql_real_escape_string($_GET['pdeditdate']);
        $pdeditchqno=mysql_real_escape_string($_GET['pdeditchqno']);
        $pdeditbank=mysql_real_escape_string($_GET['pdeditbank']);
        
        
        $qw=$mumin->updatedbContent("UPDATE pdchqs SET rdate='$pdeditdate',chqno='$pdeditchqno',chqdet='$pdeditbank' WHERE tno = '$id' AND est_id = '$est_id' ");
       
        
        
       header('Content-type: application/json'); 
 
       echo  json_encode(count($qw));
 
   exit();
  }
  if($action =="removepdchq"){
                
      $pdchqno_id=trim($_GET['id']);
      $est_id =$_SESSION['dept_id'];
      $timeStamp= date('Y-m-d H:i:s');
      $currntdte = date('Y-m-d');
 
      $rs=$mumin->getdbContent("SELECT * FROM  pdchqs WHERE tno = '$pdchqno_id' AND est_id LIKE '$est_id'");
           
      If ($rs){
        
    $invoicesettled=$rs[0]['invoicesettled'];
    	$invoices = explode(",",$rs[0]['invoices']);
     $invoiceamt= explode(",",$rs[0]['invceamnt']);
      $payno=$rs[0]['recpno']; 
      $statid = $rs[0]['est_id'];
        // Two entries found -meaning that receipt has  a duplicate, most probably it has been reversed
          
        $localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
          $q=$mumin->updatedbContent("DELETE FROM pdchqs WHERE tno = '$pdchqno_id' AND est_id LIKE '$est_id'");
            if($q){ 
               
                            for($i=0;$i<=count($invoiceamt)-1;$i++){
                        $qry6=$mumin->updatedbContent("UPDATE invoice SET recpno =0, pdamount= pdamount-$invoiceamt[$i] WHERE invno LIKE '$invoices[$i]' AND estId LIKE '$est_id' AND isinvce = '1'");

                    }
                    $response = '1';
            }}
            
          else{
                $response = '0';
          }
             header('Content-type: application/json'); 
 
       echo  json_encode(array('id'=>$response));
  }
   if($action=="updatesuppliersinfo"){

      
        $est_id=$_SESSION['dept_id'];
        $id= trim($_GET['id']);
        $tel =trim($_GET['tel']);
        $name=  trim($_GET['name']);
        $postal=trim($_GET['postal']);
        $email=trim($_GET['email']);
        $city=trim($_GET['city']);
        
        $qw="UPDATE suppliers SET suppName='$name',suppTelephone='$tel',email='$email',postal='$postal',city='$city' WHERE estId LIKE '$est_id' AND supplier = '$id'";
        $fd=$mumin->updatedbContent($qw);
        
        
       header('Content-type: application/json'); 
 
       echo  json_encode($fd);
 
   exit();
  }
  
     if($action=="addcompany"){

      
        $cname=mysql_real_escape_string($_GET['cname']);
          $date = date('d-m-Y h:i:s');      
        $qw="INSERT INTO `department`(`deptname`,ts) VALUES('$cname','$date')";
        $fd=$mumin->updatedbContent($qw);
        if($fd){
        $jqery=$mumin->getdbContent("SELECT deptid,deptname FROM department WHERE deptname = '$cname'"); 
        
        $qw=$mumin->updatedbContent("INSERT INTO `refnos`(`est_id`,`deptname`) VALUES('".$jqery[0]['deptid']."','$cname')");            
                         
        }
       header('Content-type: application/json'); 
 
       echo  json_encode($fd);
 
   exit();
  }
       if($action=="addepartment"){

      
        $dname=mysql_real_escape_string($_GET['dname']);
         
        $qw="INSERT INTO `department2`(centrename) VALUES('$dname')";
        $fd=$mumin->updatedbContent($qw);
        
        
       header('Content-type: application/json'); 
 
       echo  json_encode($fd);
 
   exit();
  }
    if($action=="updatecompany"){

        $cid=mysql_real_escape_string($_GET['cnyid']);
        $cname=mysql_real_escape_string($_GET['cname']);
        $cnytel=mysql_real_escape_string($_GET['cnytel']);
        $cnyemail=mysql_real_escape_string($_GET['cnyemail']);
        $cnyaddr=mysql_real_escape_string($_GET['cnyaddr']);
        $stat = mysql_real_escape_string($_GET['stat']);
          $date = date('d-m-Y h:i:s');      
        $qw="UPDATE `department` set deptname = '$cname',tel = '$cnytel',email = '$cnyemail',addr = '$cnyaddr',active = '$stat' WHERE deptid ='$cid'";
        $fd=$mumin->updatedbContent($qw);
        
        
       header('Content-type: application/json'); 
 
       echo  json_encode($fd);
 
   exit();
  }
      if($action=="updatedepr"){

        $dpid=mysql_real_escape_string($_GET['dpid']);
        $dpname=mysql_real_escape_string($_GET['dpname']);
        $dprtcode=mysql_real_escape_string($_GET['dprtcode']);        
          $date = date('d-m-Y h:i:s');      
        $qw="UPDATE `department2` set centrename = '$dpname',code = '$dprtcode' WHERE id ='$dpid'";
        $fd=$mumin->updatedbContent($qw);
        
        
       header('Content-type: application/json'); 
 
       echo  json_encode($fd);
 
   exit();
  }
  
  if($action=="updatedeprtlink"){

        $dpid=mysql_real_escape_string($_GET['dpid']);
        $cmpnyid=mysql_real_escape_string($_GET['cmpnyid']);
                
          $date = date('d-m-Y h:i:s');
          if ($cmpnyid == 'all'){

                   $jqery="SELECT deptid,deptname FROM department"; 
                         $datay=$mumin->getdbContent($jqery);
    
      for($j=0;$j<=count($datay)-1;$j++){    
               $column = $datay[$j]['deptid'];
           $qryupdte = "INSERT INTO costcentrmgnt(costcentrid, deptid) VALUES ('$dpid','$column')   ";    
             $fd=$mumin->updatedbContent($qryupdte);
             }
        }
          else{
        $qw="INSERT INTO costcentrmgnt(costcentrid, deptid) VALUES ('$dpid','$cmpnyid')";
        $fd=$mumin->updatedbContent($qw);
        
          }
       header('Content-type: application/json'); 
 
       echo  json_encode($fd);
 
   exit();
  }
    if($action=="updatexpnselink"){

        $expnactid=mysql_real_escape_string($_GET['expnactid']);
        $cmpnyid=mysql_real_escape_string($_GET['ecompid']);
                
          $date = date('d-m-Y h:i:s');
          if ($cmpnyid == 'all'){

                   $jqery="SELECT deptid,deptname FROM department"; 
                         $datay=$mumin->getdbContent($jqery);
    
      for($j=0;$j<=count($datay)-1;$j++){    
               $column = $datay[$j]['deptid'];
           $qryupdte = "INSERT INTO expenseactmgnt(expenseacc, deptid) VALUES ('$expnactid','$column')   ";    
             $fd=$mumin->updatedbContent($qryupdte);
             }
        }
          else{
        $qw="INSERT INTO expenseactmgnt(expenseacc, deptid) VALUES ('$expnactid','$cmpnyid')";
        $fd=$mumin->updatedbContent($qw);
        
          }
       header('Content-type: application/json'); 
 
       echo  json_encode($fd);
 
   exit();
  }
  if($action=="updatexpnsecode"){

        $expnactid=mysql_real_escape_string($_GET['expnactid']);
       // $cmpnyid=trim($_GET['incompid']);
        $codeid = mysql_real_escape_string($_GET['codeid']);
        $codeid == '-' ? $ecode = '0' : $ecode = $codeid;
        $expenseupdate = $mumin->updatedbContent("UPDATE expnseaccs SET code = '$ecode' WHERE id = '$expnactid'");
        

       header('Content-type: application/json'); 
 
       echo  json_encode($expenseupdate);
 
   exit();
  }
      if($action=="updateincmelink"){

        $incmeactid=mysql_real_escape_string($_GET['incmeactid']);
        $incmename=mysql_real_escape_string($_GET['incmename']);
        $incmecode = mysql_real_escape_string($_GET['incmecode']);
        $date = date('d-m-Y h:i:s');
        $incmecode == '-' ? $icode = '0' : $icode = $incmecode;
        $incmeupdate = $mumin->updatedbContent("UPDATE incomeaccounts SET mainincgrp = '$icode',accname = '$incmename' WHERE incacc = '$incmeactid'");
        

       header('Content-type: application/json'); 
 
       echo  json_encode($incmeupdate);
 
   exit();
  }
   if($action=="updateusers"){

      
        $usrname= trim(mysql_real_escape_string($_GET['usrname']));
        $email= trim(mysql_real_escape_string($_GET['email']));
        $paswrd =trim(mysql_real_escape_string($_GET['paswrd']));
         $usrlevel =trim(mysql_real_escape_string($_GET['usrlevel']));
        if($usrlevel =='ADMIN'){
            $acclevel = '1';
        }else{
            $acclevel = '3';
        }
        $qw="INSERT INTO pword (`j_uname`, `moh`, `pwd`, `grp`, `acclevel`, `email`, `deptid`) 
                    VALUES ('$usrname','',md5('$paswrd'),'$usrlevel','$acclevel','$email','') ";
        $fd=$mumin->updatedbContent($qw);
        
        
       header('Content-type: application/json'); 
 
       echo  json_encode($fd);
 
   exit();
  }
    if($action=="getprivldges"){

      
        $juser= trim(mysql_real_escape_string($_GET['juser']));
        $departmnt= trim(mysql_real_escape_string($_GET['departmnt']));
        
        
        $qw= $mumin->getdbContent("SELECT * FROM priviledges WHERE userid = '$juser' AND deptid = '$departmnt' ");
        
       header('Content-type: application/json'); 
 
       echo  json_encode($qw);
 
   exit();
  }
 

}

  
?>