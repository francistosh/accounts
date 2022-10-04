<?php
 session_start();
 
 include '../finance/operations/Mumin.php';
 date_default_timezone_set('Africa/Nairobi');
 $mumin=new Mumin();
 
 $action=$_GET['action'];
 
   if($action=="receiptgeneratecash"){ // Function for cash payment
     
     $docnumbers=  explode(",",$_GET['docnumbers']);
      $individualamts=  explode(",",$_GET['individualamt']);
      $acctsnumber = $_GET['acctsnumber'];
     $paymentdate1=trim($_GET['paymentdate']); 
     $paymentdate = date('Y-m-d', strtotime($paymentdate1));
     $amount=trim($_GET['amount']);
     $sabilno=trim($_GET['ejno']);
     $incmeacc=trim($_GET['incmeacc']);
     //$acc=trim($_GET['acc']);
     $payment= urldecode($_GET['payment']);
     $est_id=$_SESSION['dept_id'];
     $us=$_SESSION['jname'];
     $ts=date('Y-m-d h:i:s');
     $debtor=trim($_GET['debtor']);
      $bankcct=trim($_GET['bankacct']);
     $sector=trim($_GET['sector']);
     //$groupIDStr = implode(',', $docnumbers);
     $rs=1;
     //$recpno=$mumin->refnos("recpno");
     $recpno=sprintf('%06d',intval($mumin->refnos("recpno")));
    if($sabilno){
        
      $ejno=$mumin->get_MuminHofEjnoFromSabilno($sabilno);
      $debt=$ejno;
      $secto = $sector;
      if (!$debtor){
          $debtor=0;
      }
     }
      else{
    
    $debt=$debtor;  
    $ejno = '';
    $secto = '';
     }
     
$localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
     $qr="INSERT INTO recptrans (est_id, rdate, amount, pmode, recpno, chqdet, chqno,chequedate, rmks, hofej, tno, sabilno, sector, incacc, dno, ts, us, rev,invoicesettled,invoices,invceamnt) VALUES ('$est_id','$paymentdate','$amount','CASH','$recpno','','','','$payment','$ejno',0,'".strtoupper($sabilno)."','$localIP','$incmeacc','$debtor','$ts','$us',0,'','".$_GET['docnumbers']."','".$_GET['individualamt']."')";
     
     $data=$mumin->insertdbContent($qr);
     
     
     if($data==1){
         
                 for($i=0;$i<=count($docnumbers)-1;$i++){
                     $query=("SELECT (amount-pdamount) as balance,amount FROM invoice WHERE invno LIKE '$docnumbers[$i]' AND estId LIKE '$est_id' AND isinvce = '1' LIMIT 1");
                     $amtbalance= $mumin->getdbContent($query);   //check balance
                     //$balance=@$amtbalance[0]['balance'];
                     $amntinvc= @$amtbalance[0]['amount'];
                     if($individualamts[$i]<0){
                          $indgsd = -1*$individualamts[$i];
                      }else{
                          $indgsd = $individualamts[$i];
                      }
                     if($amntinvc==$indgsd || $indgsd > $amntinvc ){
                         $qq="UPDATE invoice SET recpno ='$recpno',pdamount=pdamount+$indgsd WHERE invno LIKE '$docnumbers[$i]' AND estId LIKE '$est_id' AND isinvce = '1'"; 
                         $rs1=$mumin->updatedbContent($qq);
                         
                     }else if($amntinvc>$indgsd){
                         $qq="UPDATE invoice SET pdamount=pdamount+$indgsd WHERE invno LIKE '$docnumbers[$i]' AND estId LIKE '$est_id' AND isinvce = '1'";
                     $rs1=$mumin->updatedbContent($qq);
                        $qq2="UPDATE recptrans SET invoicesettled='$docnumbers[$i]' WHERE recpno LIKE '$recpno' AND est_id LIKE '$est_id'";
                    $rs2=$mumin->updatedbContent($qq2);
                         
                     }
                 
                 
        
     }
     if($data==1){
         $rs=1;
     }
     else {
         $rs=0;
     }
     }
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$rs,'recpno'=>$recpno,'incmats'=>$acctsnumber));
 
   exit();
   
 }
  if($action=="receiptgenerate"){
     
     $docnumbers=  explode(",",$_GET['docnumbers']);
     $acctnumbrs = $_GET['acctnumbers'];
     $individualamts=  explode(",",$_GET['individualamt']);
     $paymentdate1=trim($_GET['paymentdate']);
     $paymentdate = date('Y-m-d', strtotime($paymentdate1));
     $chequedate1=trim($_GET['chequedate']);
     $chequedate = date('Y-m-d', strtotime($chequedate1));
     $chequeno=trim($_GET['chequeno']);
     $amount=trim($_GET['amount']);
     $chequedetails=trim($_GET['chequedetails']);
     
     $sabilno=trim($_GET['ejno']);
     $bnkacct=trim($_GET['bnkacct']);
     $incmeacc=trim($_GET['incmeacc']);
     $acc=trim($_GET['acc']);
     $payment=mysql_real_escape_string($_GET['payment']);  
     $sector2=trim($_GET['sector']);
     $est_id=$_SESSION['dept_id'];
     $us=$_SESSION['jname'];
     $ts=date('Y-m-d h:i:s');
     $rs=1;
     $debtor=trim($_GET['debtor']);
     
     $recpno=sprintf('%06d',intval($mumin->refnos("recpno")));

         if($sabilno){
        
      $ejno=$mumin->get_MuminHofEjnoFromSabilno($sabilno);
      $debt=$ejno;
      $sect2 = $sector2;
            if (!$debtor){
          $debtor=0;
      }
     }
      else{
    $debtor=trim($_GET['debtor']);
    $debt=$debtor;  
    $ejno = '';
    $sect2 = '';
     }
     
    $localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
     $qr="INSERT INTO recptrans(est_id, rdate, amount, pmode, recpno, chqdet, chqno,chequedate, rmks, hofej, tno, sabilno, sector, incacc, dno, ts, us, rev,invoicesettled,invoices,invceamnt) VALUES ('$est_id','$paymentdate','$amount','CHEQUE','$recpno','$chequedetails','$chequeno','$chequedate','$payment','$ejno',0,'".strtoupper($sabilno)."','$localIP','$incmeacc','$debtor','$ts','$us',0,'','".$_GET['docnumbers']."','".$_GET['individualamt']."')";
     
     $data=$mumin->insertdbContent($qr);
     
     
     if($data==1){
                  for($i=0;$i<=count($docnumbers)-1;$i++){
                     
                 $query=("SELECT (amount-pdamount) as balance,amount FROM invoice WHERE invno LIKE '$docnumbers[$i]' AND estId LIKE '$est_id' AND isinvce = '1' LIMIT 1");
                     $amtbalance= $mumin->getdbContent($query);   //check balance
                    // $balance=@$amtbalance[0]['balance'];
                      $amntinvc= @$amtbalance[0]['amount'];
                     if($individualamts[$i]<0){
                          $indgsd = -1*$individualamts[$i];
                      }else{
                          $indgsd = $individualamts[$i];
                      }
                     if($amntinvc==$indgsd || $indgsd > $amntinvc){
                         $qq="UPDATE invoice SET recpno ='$recpno',pdamount=pdamount+$indgsd WHERE invno LIKE '$docnumbers[$i]' AND estId LIKE '$est_id' AND isinvce = '1'"; 
                         $rs1=$mumin->updatedbContent($qq);
                          //$nur= mysql_affected_rows();
                     }else if($amntinvc>$indgsd){
                         $qq="UPDATE invoice SET pdamount=pdamount+$indgsd WHERE invno LIKE '$docnumbers[$i]' AND estId LIKE '$est_id' AND isinvce = '1'";
                     $rs1=$mumin->updatedbContent($qq);
                     //$nur= mysql_affected_rows();
                         $qq2="UPDATE recptrans SET invoicesettled='$docnumbers[$i]' WHERE recpno LIKE '$recpno' AND est_id LIKE '$est_id'";
                    $rs2=$mumin->updatedbContent($qq2);
                     }
        // }
        
     }
     if($data==1){
         $rs=1;
     }else{
         $rs=0;
     }
     }
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$rs,'recpno'=>$recpno,'incmats'=>$acctnumbrs));
 
   exit();
   
 }
 
 if($action=="reprintingreceipt"){
     
       isset($_POST['recpno']) ? $recpnos = $_POST['recpno'] : $recpnos = $_GET['recpno'];
     //$recpnos=trim($_POST['recpno']);
     
     $est_id=$_SESSION['dept_id'];
   
     $data=$mumin->getdbContent("SELECT * FROM recptrans WHERE recpno LIKE '$recpnos' AND est_id LIKE '$est_id' AND rev LIKE 0 LIMIT 1");

     //"SELECT invoicesettled"
     $paymentdate=$data[0]['rdate'];
     $chequedate=$data[0]['chequedate'];
     $chequeno= $data[0]['chqno'];
     $amount=$data[0]['amount'];
     $chequedetails= urlencode($data[0]['chqdet']);
     $sabilno= $data[0]['sabilno'];
     $recpno=$data[0]['recpno'];
     $payment= urlencode($data[0]['rmks']);
     $debtor= $data[0]['dno'];
     $invcestld=$data[0]['invoicesettled'];
     $acc=$data[0]['bacc'];
     $tmsp=$data[0]['ts'];
     $rcptus=$data[0]['us'];
     $incmeacct = $data[0]['incacc'];
      $qery=$mumin->getdbContent("SELECT accname FROM incomeaccounts WHERE incacc = '$incmeacct' ");
       //$incmeats = implode(",",$qery[0]['accname']);
       $incmeats = $qery[0]['accname'];
     if (!$chequeno){
         $modei = 'CASH';
     }  else {
         $modei = 'CHEQUE';
     }
    
     
     if($data){
     
     header("location:receipt_preview.php?mode=".$modei."&paymentdate=".$paymentdate."&amount=".$amount."&chequedate=".$chequedate."&chequeno=".$chequeno."&chequedetails=".$chequedetails."&ejno=".$sabilno."&incmeacts=".$incmeats."&acc=".$acc."&payment=".$payment."&recpno=".$recpno."&debtor=".$debtor."&rcpts=".$tmsp."&rcptus=".$rcptus."&reprint=1");
     }
     else{
         header("location:receipts.php?type=error");  
     }
   
     
 }
   if($action=="getunpaiddebtorbills"){

     $debtor=trim($_GET['debtor']);
     
     $sab=trim($_GET['ejamaat']);
     
     //$incomeaccount=$_GET['incacct'];
      
     $est_id=$_SESSION['dept_id'];
     
     if($sab){
      
          $ourdebtor=$mumin->get_MuminHofNamesFromSabilno($sab);
          $sqry = $mumin->getdbContent("SELECT sector FROM mumin WHERE sabilno = '$sab' LIMIT 1");
          $msect = $sqry[0]['sector'];
        
         $qr="SELECT invno,DATE_FORMAT(idate,'%d-%m-%Y') as idate,IF(isinvce=1,amount,-1*amount)as amount,accname,e.incacc as incacc,sabilno,pdamount,(amount-pdamount)as balnce FROM  invoice e JOIN incomeaccounts a ON  e.incacc =a.incacc WHERE e.estId = '$est_id' AND e.sabilno LIKE '$sab'  AND e.pdamount<e.amount order by opb desc,DATE(idate) ";
      
     }
     else{
      
         $m=$mumin->getdbContent("SELECT * FROM debtors WHERE dno LIKE '$debtor' AND deptid LIKE'$est_id' LIMIT 1");
         $msect= '';
         $ourdebtor=$m[0]['debtorname'];
        
         $qr="SELECT invno,DATE_FORMAT(idate,'%d-%m-%Y') as idate,IF(isinvce=1,amount,-1*amount)as amount,accname,e.incacc as incacc ,sabilno,pdamount,(amount-pdamount)as balnce FROM  invoice e JOIN incomeaccounts a ON  e.incacc =a.incacc WHERE e.estId LIKE '$est_id' AND e.dno LIKE '$debtor'  AND e.pdamount<e.amount order by opb desc,DATE(idate) ";
       
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
 if($action=="savepdchqs"){
         
     $docnumbers=  explode(",",$_GET['docnumbers']);
     $individualamts=  explode(",",$_GET['individualamt']);
     $chqnos= explode(",",$_GET['chqnos']);
     $chqdates= explode(",",$_GET['chqdates']);
     $chqdetails= explode(",",$_GET['chqdetails']);
     $chqamounts= explode(",",$_GET['chqamounts']);
     $incmeacc=mysql_real_escape_string($_GET['incmeacc']);
    $pdremarks = urldecode($_GET['pdremarks']);
     $user=$_SESSION['jname'];
     $est_id=$_SESSION['dept_id'];
     $debtor=trim($_GET['debtor']);
     $sabilno=mysql_real_escape_string($_GET['sabilno']);

     $ts=date('Y-m-d h:i:s');
     $us=$_SESSION['jname'];
$localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
            for($f=0;$f<=count($chqamounts)-2;$f++){
                $pdchqno=sprintf('%06d',intval($mumin->refnos("vn")));
                   if($sabilno){
        
      $ejno=$mumin->get_MuminHofEjnoFromSabilno($sabilno);
      $debt=$ejno;
            if (!$debtor){
          $debtor=0;
      }
     }
      else{
    $debtor=trim($_GET['debtor']);
    $debt=$debtor;  
    $ejno = '';

     }
     $qr="INSERT INTO pdchqs(est_id,rdate,amount,pmode,recpno,chqdet,chqno,chequedate,rmks,hofej,sabilno,sector,incacc,bacc,dno,isdeposited,ts,us,rev,invoices,invceamnt)
                    VALUES ('$est_id','".date('Y-m-d',strtotime($chqdates[$f]))."','$chqamounts[$f]','CHEQUE','PD-$pdchqno','$chqdetails[$f]','$chqnos[$f]','".date('Y-m-d',strtotime($chqdates[$f]))."','$pdremarks','$ejno','".strtoupper($sabilno)."','$localIP','$incmeacc','0','$debtor','','$ts','$us','','".$_GET['docnumbers']."','".$_GET['individualamt']."')";
   $data=$mumin->insertdbContent($qr);
        if($data==1){
                  for($i=0;$i<=count($docnumbers)-1;$i++){
                     
                 $query=("SELECT (amount-pdamount) as balance,amount FROM invoice WHERE invno LIKE '$docnumbers[$i]' AND estId LIKE '$est_id' AND isinvce = '1' LIMIT 1");
                     $amtbalance= $mumin->getdbContent($query);   //check balance
                    // $balance=@$amtbalance[0]['balance'];
                      $amntinvc= @$amtbalance[0]['amount'];
                     if($individualamts[$i]<0){
                          $indgsd = -1*$individualamts[$i];
                      }else{
                          $indgsd = $individualamts[$i];
                      }
                     if($amntinvc==$indgsd || $indgsd > $amntinvc){
                         $qq="UPDATE invoice SET recpno ='$pdchqno',pdamount=pdamount+$indgsd WHERE invno LIKE '$docnumbers[$i]' AND estId LIKE '$est_id' AND isinvce = '1'"; 
                         $rs1=$mumin->updatedbContent($qq);
                          //$nur= mysql_affected_rows();
                     }else if($amntinvc>$indgsd){
                         $qq="UPDATE invoice SET pdamount=pdamount+$indgsd WHERE invno LIKE '$docnumbers[$i]' AND estId LIKE '$est_id' AND isinvce = '1'";
                     $rs1=$mumin->updatedbContent($qq);
                     //$nur= mysql_affected_rows();
                         $qq2="UPDATE pdchqs SET invoicesettled='$docnumbers[$i]' WHERE recpno LIKE '$pdchqno' AND est_id LIKE '$est_id'";
                    $rs2=$mumin->updatedbContent($qq2);
                     }
        // }
        
     }
     if($data==1){
         $rs=1;
         $pdno = 'PD-'.$pdchqno;
     }else{
         $rs=0;
         $pdno = 0;
     }
     }
            }
	 
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$rs,'pdno'=>$pdno));
 
   exit();
 
     
 }
    if($action=="getunpaidincmedebtorbills"){
     
      
      
     $debtor=trim($_GET['debtor']);
     
     $sab=trim($_GET['ejamaat']);
     
     $incomeaccount=$_GET['incacct'];
      
     $est_id=$_SESSION['dept_id'];
     
     if($sab){
      
          $ourdebtor=$mumin->get_MuminHofNamesFromSabilno($sab);
          $sqry = $mumin->getdbContent("SELECT sector FROM mumin WHERE sabilno = '$sab' LIMIT 1");
          $msect = $sqry[0]['sector'];
        if($incomeaccount==""){
         $qr="SELECT invno,DATE_FORMAT(idate,'%d-%m-%Y') as idate,IF(isinvce=1,amount,-1*amount)as amount,accname,e.incacc as incacc,sabilno,pdamount,(amount-pdamount)as balnce FROM  invoice e JOIN incomeaccounts a ON  e.incacc =a.incacc WHERE e.estId = '$est_id' AND e.sabilno LIKE '$sab'  AND e.pdamount<e.amount ORDER BY opb desc,DATE(idate) ";
          } else{
          $qr="SELECT invno,DATE_FORMAT(idate,'%d-%m-%Y') as idate,IF(isinvce=1,amount,-1*amount)as amount,accname,e.incacc as incacc,sabilno,pdamount,(amount-pdamount)as balnce FROM  invoice e JOIN incomeaccounts a ON  e.incacc =a.incacc WHERE e.estId = '$est_id' AND e.sabilno LIKE '$sab'  AND e.pdamount<e.amount AND e.incacc = '$incomeaccount' ORDER BY opb desc,DATE(idate) ";     
          }
     }
     else{
      
         $m=$mumin->getdbContent("SELECT * FROM debtors WHERE dno LIKE '$debtor' AND deptid LIKE'$est_id' LIMIT 1");
         $msect= '';
         $ourdebtor=$m[0]['debtorname'];
        if($incomeaccount==""){
         $qr="SELECT invno,DATE_FORMAT(idate,'%d-%m-%Y') as idate,IF(isinvce=1,amount,-1*amount)as amount,accname,e.incacc as incacc ,sabilno,pdamount,(amount-pdamount)as balnce FROM  invoice e JOIN incomeaccounts a ON  e.incacc =a.incacc WHERE e.estId LIKE '$est_id' AND e.dno LIKE '$debtor'  AND e.pdamount<e.amount  ORDER BY opb desc,DATE(idate)  ";
        }else{
         $qr="SELECT invno,DATE_FORMAT(idate,'%d-%m-%Y') as idate,IF(isinvce=1,amount,-1*amount)as amount,accname,e.incacc as incacc ,sabilno,pdamount,(amount-pdamount)as balnce FROM  invoice e JOIN incomeaccounts a ON  e.incacc =a.incacc WHERE e.estId LIKE '$est_id' AND e.dno LIKE '$debtor'  AND e.pdamount<e.amount AND e.incacc = '$incomeaccount' ORDER BY opb desc,DATE(idate)  ";   
        }
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
 
 if($action=="getreceipts"){
     
          //$rcptnos = trim($_GET['rcptno']);
     $responses=array();
     //$id=$_SESSION['dept_id'];
    $rs=$mumin->getdbContent("SELECT * FROM  recptrans WHERE recpno LIKE '008040' AND est_id LIKE '25' AND rev='0' AND recon='0' LIMIT 1");
 for($i=0;$i<=count($rs);$i++){
    $responses[$i]=array('rdate'=> $rs[$i]['rdate'],'recpno'=> $rs[$i]['recpno'],'amount'=>$rs[$i]['amount'],"incacc"=>$rs[$i]['incacc'],"sabilno"=>$rs[$i]['sabilno'],"rmks"=>$rs[$i]['rmks']);  
 }
    header('Content-type: application/json'); 
 
   echo  json_encode($responses);  
 
   exit();
 }
  if($action=="getreceiptnolog"){
     
          $rcptnos = trim($_GET['rcptno']);
     $responses=array();
     $id=$_SESSION['dept_id'];
    $rs=$mumin->getdbContent("SELECT DATE_FORMAT(depots,'%m-%d-%Y %h:%i') as depots ,isdeposited AS depositno,IF(recon<>'0','Reconciled','Pending') AS status,bacc,us,IF(rev='1','Reversed','Not-Reversed') as rcptstat,invoices,invceamnt FROM  recptrans WHERE  recpno = '$rcptnos' AND est_id LIKE '$id' LIMIT 1");
    @$banknme = $mumin->getbankname($rs[0]['bacc']);
    @$responses[0]=array('depots'=> $rs[0]['depots'],'depositno'=> $rs[0]['depositno'],'status'=>$rs[0]['status'],"acctname"=>$banknme,"user"=>$rs[0]['us'],"rcptstat"=>$rs[0]['rcptstat'],"invoices"=>$rs[0]['invoices'],"invceamnt"=>$rs[0]['invceamnt']);  

    header('Content-type: application/json'); 
 
   echo  json_encode($responses);  
 
   exit();
 }
 if($action=="updtereceipts"){
        $rdate=date('Y-m-d', strtotime($_GET['rdate']));
     $rcpno=trim($_GET['rcptno']);
     $incmeid=trim($_GET['incmeid']);
     $sabin=trim($_GET['sabin']);
     $amount= floatval(str_replace(',', '', $_GET['amount']));
     $rmksrecpt=trim($_GET['rmksrecpt']);
     $itsno=trim($_GET['itsno']);
     $paymode=trim($_GET['paymode']);
     $chqdate= trim($_GET['chqdate']);
     $invcenumbrs = explode(",",$_GET['invcenumbrs']);
     $invoiceamnt  =  explode(",",$_GET['invoiceamnt']);
     $adjustfigures =  explode(",",$_GET['adjustfig']);
     if ($chqdate ==''){
         $chqdate1 ='';
     }else{
         $chqdate1= date('Y-m-d',  strtotime($chqdate));
     }
     
     $chqno=trim($_GET['chqno']);
     $chqdetls=urldecode($_GET['chqdetls']);
     $id=$_SESSION['dept_id'];
     $succss=0;

    $qwr="UPDATE recptrans SET rdate='$rdate' ,incacc= '$incmeid',sabilno='$sabin',amount='$amount',rmks='$rmksrecpt',hofej = '$itsno',pmode = '$paymode',chequedate = '$chqdate1',chqno = '$chqno',chqdet = '$chqdetls',invoices ='".$_GET['invcenumbrs']."',invceamnt='".$_GET['invoiceamnt']."'  WHERE recpno = '$rcpno' AND est_id = '$id' "; 
       

           $update= $mumin->updatedbContent($qwr);
           if($update==1)
               
               {
                            
               for($v=0;$v<=count($invcenumbrs)-1;$v++){
                 
                 $q8=$mumin->updatedbContent("SELECT  pdamount FROM invoice WHERE  invno LIKE '$invcenumbrs[$v]' AND estId LIKE '$id' AND isinvce = '1'");
                 $dif =  $invoiceamnt[$v] - @$q8[0]['pdamount'] ;
               //  if($dif != 0){
                 $q9=$mumin->updatedbContent("UPDATE invoice  SET pdamount =  (pdamount -$adjustfigures[$v]) + $invoiceamnt[$v]  WHERE invno LIKE '$invcenumbrs[$v]' AND estId LIKE '$id' AND isinvce = '1'");
                //  }
             }
              $succss = 1; 
           }else{
               $succss =0; 
           }
     header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$succss));
 
   exit();      
 }
 ?>