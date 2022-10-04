<?php
 session_start();
 
 include '../finance/operations/Mumin.php';
 date_default_timezone_set('Africa/Nairobi');
 $mumin=new Mumin();
  $action=$_GET['action'];
 
 
  if($action=="pulloutlinkedaccount"){
   
      
     $account=$_GET['id']; 
      
     $estatesid=$_SESSION['est_prop'];
      
      //get linked bank account
         
    $linkedaccount=$mumin->getdbContent("SELECT * FROM estate_incomeaccounts i JOIN estate_bankaccounts e ON  e.acno=i.bankaccount WHERE i.estateid LIKE '$estatesid' AND i.id LIKE '$account' LIMIT 1");
         
     //end gate linked  bank  account
   
   header('Content-type: application/json'); 
 
   echo  json_encode($linkedaccount);
 
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
      $balanceamount=intval($_GET['balanceamount']);
     
      
      //$toacc=$_GET['bank'];
      
      $supplier=$_GET['supplier'];
      
      $debtor=$_GET['debtor'];
      
      $muminsabilno=$_GET['mumin'];
      
      $estatesid=$_SESSION['est_prop'];
      
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
 
  if($action=="createlogin"){

      $usname=$_GET['usname'];
      
      $pwd=$_GET['pwd'];
      
      $est_id=$_GET['estateid'];
      
     $q="INSERT INTO  pword (uname,pwd,grp,acclevel,suspended,estate_prop) VALUES('$usname','$pwd','EXTERNAL',999,0,'$est_id') ";   
     
     $id=$mumin->insertdbContent($q);
     
     header('Content-type: application/json'); 
 
     echo  json_encode(array('id'=>$id));
 
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
     $est_id=$_SESSION['est_prop'];
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
             
             $originalAmount= intval($amountreturn[0]['amount']);
             $qr_getAmount=$mumin->getdbContent("SELECT SUM(amount) AS amount FROM estates_recptrans WHERE invoicesettled LIKE '$docnumbers' AND est_id ='$est_id'");
    
                $totalamt = $qr_getAmount[0]['amount'];
                $diff= $originalAmount - $totalamt; 
             if(intval($amount)>$diff){
                     
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
             elseif($diff>intval($amount)){
                 
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
     $est_id=$_SESSION['est_prop'];
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
             
             $originalAmount= intval($amountreturn[0]['amount']);
             $qr_getAmount=$mumin->getdbContent("SELECT SUM(amount) AS amount FROM estates_recptrans WHERE invoicesettled LIKE '$docnumbers' AND est_id ='$est_id'");
    
                $totalamt = $qr_getAmount[0]['amount'];
                $diff= $originalAmount - $totalamt; 
             if(intval($amount)>$diff){
                     
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
             elseif($diff>intval($amount)){
                 
                 $qr="INSERT INTO estates_recptrans(est_id, rdate, amount, pmode, recpno, chqdet, chqno,chequedate, rmks, hofej, tno, sabilno, acc, bacc, dno, ts, us, rev,invoicesettled) VALUES 
                       ('$est_id','$paymentdate','$amount','CASH','$recpno','','','','$payment','$ejno',0,'$sabilno','$expacc','$acc','$debt','$ts','$us',0,'$docnumbers')";
     
                    $data=$mumin->insertdbContent($qr);
                    $rs=1;
             }
             
        header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$rs,'recpno'=>$recpno));
 
   exit();
   
 }
 
 if($action=="savesupplier"){
     $name=trim($_GET['name']);
     $telephone=trim($_GET['telephone']);
     $email=trim($_GET['email']);
     $postal=trim($_GET['postal']);
     $city=trim($_GET['city']);
     $remarks=trim($_GET['remarks']);
     $user=$_SESSION['uname'];
     $est_id=$_SESSION['est_prop'];
     
     $qr="INSERT INTO estate_suppliers(supplier,estId,suppName,suppTelephone,email,postal,city,remarks,user) VALUES (0,$est_id,'$name','$telephone','$email','$postal','$city','$remarks','$user')";
     
     $data=$mumin->insertdbContent($qr);
    
     
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data));
 
   exit();
   
 }
  
 
 
 if($action=="saveaccountb"){
     
      
     $name=trim($_GET['name']);
     $acctno=trim($_GET['acctno']);
     $actsector=trim($_GET['actsector']);
     $acttype=trim($_GET['acttype']);
     $est_id=$_SESSION['est_prop'];    
     $qr="INSERT INTO estate_bankaccounts (bacc,acno,acname,estate_id,sector,type) VALUES (0,'$acctno','$name','$est_id','$actsector','$acttype')";
      $data=$mumin->insertdbContent($qr);
     header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data));
 
   exit();
   
 }
 if($action=="updatebankdetails"){
     
      
     $bankactid=trim($_GET['baankid']);
     $est_id=$_SESSION['est_prop'];    
     $qr="SELECT bacc,acno,acname,sector,type FROM estate_bankaccounts WHERE bacc = '$bankactid' AND estate_id = '$est_id'";
      $data=$mumin->getdbContent($qr);
      $accno = $data[0]['acno'];
      $sect = $data[0]['sector'];
      $type = $data[0]['type'];
     header('Content-type: application/json'); 
    echo  json_encode(array('id'=>count($data),'accno'=>$accno,'sector'=>$sect,'type'=>$type)); 
   exit();
   
 }
 
 
  if($action=="updateccountb"){
     
      
     $acctid=trim($_GET['acctid']);
     $acctno=trim($_GET['acctno']);
     $actsector=trim($_GET['actsector']);
     $acttype=trim($_GET['acttype']);
     $est_id=$_SESSION['est_prop'];    
     $qr="UPDATE estate_bankaccounts SET acno = '$acctno', sector = '$actsector', type = '$acttype' WHERE bacc='$acctid'";
      $data=$mumin->updatedbContent($qr);
     header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data));
 
   exit();
   
 }
 
  if($action=="savedebtor"){
     
      
     $name=trim($_GET['name']);
     $telephone=trim($_GET['telephone']);
     $email=trim($_GET['email']);
     $postal=trim($_GET['postal']);
     $city=trim($_GET['city']);
     $remarks=trim($_GET['remarks']);
     $user=$_SESSION['uname'];
     $est_id=$_SESSION['est_prop'];
     
     $qr="INSERT INTO estate_debtors(dno,debtorname,estId,debTelephone,email,postal,city,remarks,user) VALUES (0,'$name',$est_id,'$telephone','$email','$postal','$city','$remarks','$user')";
     
     $data=$mumin->insertdbContent($qr);
    
     
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data));
 
   exit();
   
 }
 if($action=="savincomex"){  
     
      
     $name=trim($_GET['name']);
        
     $qr="INSERT INTO estate_incomeaccounts(incacc,accname) VALUES ('','$name')";
     
     
    $data=$mumin->insertdbContent($qr);
    
     
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data));
 
   exit();
   
 }
 
 if($action=="pettysavesupplierbill"){
     
      
      
     $date1=trim($_GET['date']);
     $date = date('Y-m-d', strtotime($date1));
     $docno=trim($_GET['docno']);
     $amount=trim($_GET['amount']);
     $expacc=trim($_GET['expacc']);
     $remarks=trim($_GET['remarks']);
     $user=$_SESSION['uname'];
     $est_id=$_SESSION['est_prop'];
     $bank=trim($_GET['bank']);
     $ccid=trim($_GET['ccid']);
     
     $qr="INSERT INTO estate_invoices(estId,Type,idate,amount,invno,rmks,hofej,tno,sabilno,expacc, us, supplier, rev,payno,dno,toacc) VALUES ($est_id,'IN','$date','$amount','$docno','$remarks','',0,'','$expacc','$user','0',0,0,0,'$ccid')";
     
     $data=$mumin->insertdbContent($qr);
     
     if($data){
         
     //$docnumbers=  explode(",",$_GET['docnumbers']);
      
     //$amount=trim($_GET['amount']);
     
     /*$paymentdate=trim($_GET['paymentdate']);
     $expacc=trim($_GET['expacc']);
     $acc=trim($_GET['acc']);
     $remarks=trim($_GET['remarks']);
     $user=$_SESSION['uname'];
     $est_id=$_SESSION['est_prop'];
     $supplier=trim($_GET['supplier']);*/
    $payno=$mumin->refnos("payno");
     
     
     
     $check_balance="SELECT amount FROM  estate_bankaccounts  WHERE acno LIKE '$bank' AND estate_id LIKE '$est_id' LIMIT 1";
         
         $balance= $mumin->getdbContent($check_balance);   //check balance
         
         $actualAmount=$balance[0]['amount'];
         
         if($actualAmount<$amount){
             
             $response="low_balance";
             
         }
     else{  //insert transaction into paytrans
     $qr="INSERT INTO estate_paytrans(estId,pdate,amount,pmode,payno,chqdet,chqno,rmks,supplier,sabno,tno,bacc,expacc,chequedate,ts,us,rev) 
         VALUES ($est_id,'$date','$amount','CASH','$payno','','','$remarks','0','',0,'$bank','$expacc','0',0,'$user',0)";
     $response=$mumin->insertdbContent($qr);
     
     if($response==1){
         
         
         
             $qry="UPDATE estate_invoices SET payno =$payno WHERE invno LIKE '$docno'";
         
             $response=$mumin->updatedbContent($qry);
         
         
         
         if($response==1){
             
          //subtract amount from bank account
         
             $q="UPDATE estate_bankaccounts SET amount=amount-$amount WHERE acno LIKE '$bank' AND estate_id LIKE '$est_id'";
         
             $response= $mumin->updatedbContent($q);
         
         
         }
     }
     }
     }
     header('Content-type: application/json'); 
 
     echo  json_encode(array('id'=>$response,'payno'=>$payno));
 
     exit();
  
    

  
 }
 
 
     
 if($action=="savesupplierbill"){
     
      
      
     $date1=trim($_GET['date']);
     $date = date('Y-m-d', strtotime($date1));
     $docno=trim($_GET['docno']);
     $amount=trim($_GET['amount']);
     $expacc=trim($_GET['expacc']);
     $remarks=trim($_GET['remarks']);
     $user=$_SESSION['uname'];
     $est_id=$_SESSION['est_prop'];
     $supplier=trim($_GET['supplier']);
     $suppamt=$_GET['suppamt'];
     $taxamnt=trim($_GET['taxamnt']);
     $crdtinvno=trim($_GET['crdtinvno']);
     $doctype=trim($_GET['doctyp']);
     $suplrsubacc=trim($_GET['suplrsubacc']);
     $dsector = $_SESSION['sector'];
     $ts=date('Y-m-d h:i:s');
     //if(){}
     $qr="INSERT INTO estate_bills(estate_id,bdate,supplier,docno,expenseacc,amount,supamnt,taxamount,rmks,sector,ts,us,isinvce,payno,revsd,crdtinvce,subacc) VALUES ($est_id,'$date','$supplier','$docno','$expacc','$amount','$suppamt','$taxamnt','$remarks','$dsector','$ts','$user','$doctype','0','0','$crdtinvno','$suplrsubacc')";
     
     $data=$mumin->insertdbContent($qr);
    
     
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data));
 
   exit();
 
 }
  
 
 if($action=="outgoinginvoice"){
     
       
      
     $date1=trim($_GET['date']);
      $date = date('Y-m-d', strtotime($date1));
     $amount=trim($_GET['total']);
     $debtor=trim($_GET['debtor']);
     $remarks=trim($_GET['rmks']);
	 $subacct=trim($_GET['subacct']);
     $user=$_SESSION['uname'];
     $est_id=$_SESSION['est_prop'];
      $sectornme= trim($_GET['sectornme']);
     $ts=date('Y-m-d h:i:s');
     if($_GET['sabilno']){
         $sabilno=trim($_GET['sabilno']);
     $ejamaat= $mumin->get_MuminHofEjnoFromSabilno($sabilno);
     }
 else {
       $sabilno = ' ';
       $ejamaat = ' ';
       $sectornme =$_SESSION['sector'];
     }
     $docno=sprintf('%06d',intval($mumin->refnos("invno")));
     if ($debtor){
         $qr0="SELECT dno,debTelephone,city FROM estate_debtors WHERE debtorname = '$debtor' AND estId = '$est_id'"; 
                                
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
     $qr1="SELECT accname FROM estate_incomeaccounts WHERE incacc = '$accounts' "; 
                                
           $data2=$mumin->getdbContent($qr1);
     $accname3 = $data2[0]['accname'];
     $qr="INSERT INTO estate_invoice(estId,idate,amount,invno,rmks,hofej,sabilno,us,ts,rev,recpno,dno,incacc,isinvce,sector,subacc) VALUES ('$est_id','$date','$amount','$docno','$remarks','$ejamaat','$sabilno','$user','$ts',0,0,'$debtor2','$accounts','1','$sectornme','$subacct')";
     
     $data=$mumin->insertdbContent($qr);
    
    header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data,'invoice'=>$docno,'acctname'=>$accname3,'tel'=>$tel,'city'=>$city1)); 
 
   exit();
 
 }

 
  if($action=="creditnote"){
        
     $date1=trim($_GET['date']);
     $date = date('Y-m-d', strtotime($date1));
     $debtor=trim($_GET['debtor']); // debtorname
     $amount=trim($_GET['amount']); //amount
     $remarks=trim($_GET['remarks']);
     $crditinvce=trim($_GET['crditinvce']);
     $user=$_SESSION['uname'];
     $est_id=$_SESSION['est_prop'];
     $ts=date('Y-m-d h:i:s');
     $sectornme= trim($_GET['sectorname']);;
          $docno=sprintf('%06d',intval($mumin->refnos("crnote")));
  if($_GET['sabilno']){
         $sabilno=trim($_GET['sabilno']);
     $ejamaat= $mumin->get_MuminHofEjnoFromSabilno($sabilno);
     }
 else {
       $sabilno = ' ';
       $ejamaat = ' ';
       $sectornme =$_SESSION['sector'];
     }
     
     if ($debtor){
         $qr0="SELECT dno,debTelephone,city FROM estate_debtors WHERE debtorname = '$debtor' AND estId = '$est_id'"; 
                                
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
     $qr1="SELECT accname FROM estate_incomeaccounts WHERE incacc = '$accounts' "; 
                                
           $data2=$mumin->getdbContent($qr1);
     $accname3 = $data2[0]['accname'];
     $qr="INSERT INTO estate_invoice(estId,idate,amount,invno,rmks,hofej,sabilno,us,ts,rev,recpno,dno,incacc,isinvce,sector,crdtinvce) VALUES ('$est_id','$date','$amount','$docno','$remarks','$ejamaat','$sabilno','$user','$ts',0,0,'$debtor2','$accounts','0','$sectornme','$crditinvce')";
     
     $data3=$mumin->insertdbContent($qr);
    if ($data3){
        $flag= 'Ok';
     $errmessage = 'Inserted';
    }
    header('Content-type: application/json');
     $data=array('flag'=>$flag,'errmessage'=>$errmessage,'ejamaat'=>$ejamaat,'docno'=>$docno,'accounts'=>$accounts,'invoice'=>$accounts,'debtor'=>$debtor2,'sabilno'=>$sabilno,'sectorname'=>$sectornme);

    header('Content-type: application/json'); 
 
   echo  json_encode($data); 
 
   exit();
 
 }
 
 
 if($action=="getunpaidbills"){
     
           
     $supplier=trim($_GET['supplier']);
      
     $est_id=$_SESSION['est_prop'];
      
     if($_SESSION['grp']=='MASOOL'){
     $qr="SELECT DATE_FORMAT(bdate,'%d-%m-%Y') as bdate,docno,IF(isinvce='1',amount,-1*amount)as amount,pdamount FROM estate_bills WHERE estate_id LIKE '$est_id' AND supplier LIKE '$supplier'  AND amount>pdamount AND sector= ''";
     } elseif ($_SESSION['grp']=='EXTERNAL') {
     $qr="SELECT DATE_FORMAT(bdate,'%d-%m-%Y') as bdate,docno,IF(isinvce='1',amount,-1*amount)as amount,pdamount FROM estate_bills WHERE estate_id LIKE '$est_id' AND supplier LIKE '$supplier'  AND amount>pdamount AND sector= '".$_SESSION['sector']."'";    
     }
     
     $data=$mumin->getdbContent($qr);
    
     
    header('Content-type: application/json'); 
 
   echo  json_encode($data);
 
   exit();
 
 }
 
 

 
 
 if($action=="getmuminNameForinvoice"){  //get mumin names and data for invoice
     
      $sabilx=trim($_GET['sabil']);
      
      $mohl = $_SESSION['emoh'];
      //echo $_SESSION['est_prop'];
      //$qry = "SELECT mohalla FROM anjuman_estates WHERE id LIKE '$mohl' LIMIT 1";
      //$data1=$mumin->getdbContent($qry);     
      $mohola = $_SESSION['emoh'];
    if($_SESSION['grp']=='MASOOL'){
     $qr="SELECT hofej,ejno,sabilno,sector FROM  mumin  WHERE sabilno LIKE '$sabilx'  AND ejno =hofej AND moh = '$mohola' LIMIT 1";
      $data=$mumin->getdbContent($qr);
     
      }
      else if($_SESSION['grp']=='EXTERNAL'){
       $qr1="SELECT hofej,ejno,sabilno,sector FROM  mumin  WHERE sabilno LIKE '$sabilx'  AND ejno =hofej AND sector = '".$_SESSION['sector']."' LIMIT 1";
          $data=$mumin->getdbContent($qr1);
      }
     
    if ($data){
     $name=$mumin->get_MuminNames($data[0]['ejno']);
     $ejnu = $data[0]['ejno'];
     $sectorname = $data[0]['sector'];
    }
    else{
        $qry = "SELECT sabilno FROM estate_debtors  WHERE sabilno='$sabilx' AND estId = '$mohl'";
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
     
   
     $debtorid=trim($_GET['id']);
      
      $es_id=$_SESSION['est_prop']; 
     
     $qr="SELECT * FROM estate_debtors  WHERE dno LIKE '$debtorid'  AND estId LIKE '$es_id' LIMIT 1";
     
     $data=$mumin->getdbContent($qr );
     
     $invno=sprintf('%06d',intval($mumin->refnos("invno")));
      
     
    header('Content-type: application/json'); 
 
   echo  json_encode(array('name'=>$data[0]['debtorname'],'invoicenumber'=>$invno));
 
   exit();   
     
     
     
 }
     
 
 
 if($action=="getDebtorNames"){  //get estate debtor names
     
   
     $debtorid=trim($_GET['id']);
      
      $es_id=$_SESSION['est_prop']; 
     
     $qr="SELECT * FROM estate_debtors  WHERE dno LIKE '$debtorid'  AND estId LIKE '$es_id' LIMIT 1";
     
     $data=$mumin->getdbContent($qr );
     
     //$invno=sprintf('%06d',intval($mumin->refnos("invno")));
      
     
    header('Content-type: application/json'); 
 
   echo  json_encode(array('name'=>$data[0]['debtorname']));
 
   exit();   
     
     
     
 }
     
 
 if($action=="invoicepayment"){   //chequepayment to invoices
     
      
     $docnumbers=  explode(",",$_GET['docnumbers']);
     $individualamt= explode(",",$_GET['individualamt']);
     $chequedate1=trim($_GET['chequedate']);
     $chequedate = date('Y-m-d', strtotime($chequedate1));
     $chequeno=trim($_GET['chequeno']);
     $amount=trim($_GET['amount']);
     //$narration=trim($_GET['narration']);
     $paymentdate1=trim($_GET['paymentdate']);
     $paymentdate = date('Y-m-d', strtotime($paymentdate1));
    // $expacc=trim($_GET['expacc']);
     $acc=trim($_GET['acc']);
     $remarks=trim($_GET['remarks']);
     $user=$_SESSION['uname'];
     $est_id=$_SESSION['est_prop'];
     $sectid =$_SESSION['sector'];
     $supplier=trim($_GET['supplier']);
     $pvno=sprintf('%06d',intval($mumin->refnos("payno")));
     $ts=date('Y-m-d h:i:s');
     
     
      //insert transaction into paytrans
     $qr="INSERT INTO estate_paytrans(estId,pdate,amount,pmode,payno,chqdet,chqno,rmks,	supplier,sector,tno,bacc,chequedate,ts,us,rev) 
         VALUES ($est_id,'$paymentdate','$amount','CHEQUE','$pvno','','$chequeno','$remarks','$supplier','$sectid','','$acc','$chequedate','$ts','$user',0)";
     $response=$mumin->insertdbContent($qr);
     
     if($response==1){
         
                for($k=0;$k<=count($docnumbers)-2;$k++){  // mark all invoices bearing this document number as paid
             $query=("SELECT (amount-pdamount) as balance,amount FROM estate_bills WHERE docno LIKE '$docnumbers[$k]' AND supplier = '$supplier' AND estate_id LIKE '$est_id'  LIMIT 1");
                     $amtbalance= $mumin->getdbContent($query);   //check balance
                     $amntinvc= $amtbalance[0]['amount'];
              if($individualamt[$k]<0){
                      $indgsd = -1*$individualamt[$k];
               }else{
                    $indgsd = $individualamt[$k];
                  }
                  
              if($amntinvc==$indgsd){
                         $qq="UPDATE estate_bills SET payno ='$pvno',pdamount=pdamount+$indgsd WHERE docno LIKE '$docnumbers[$k]' AND estate_id  LIKE '$est_id' AND supplier LIKE '$supplier'"; 
                         $rs1=$mumin->updatedbContent($qq);
                   }
           else if($amntinvc>$indgsd){
                         $qq="UPDATE estate_bills SET pdamount=pdamount+$indgsd WHERE docno LIKE '$docnumbers[$k]' AND estate_id LIKE '$est_id' AND supplier LIKE '$supplier'";
                     $rs1=$mumin->updatedbContent($qq);
                        $qqry="UPDATE estate_paytrans SET billsettled='$docnumbers[$k]',billamnt='$individualamt[$k]' WHERE payno = '$pvno' AND estId LIKE '$est_id' AND supplier = '$supplier'";
                    $rs2=$mumin->updatedbContent($qqry);
                         
                     }
                      
                       }
     }
     
     header('Content-type: application/json'); 
 
     echo  json_encode(array('id'=>$response,'payno'=>$pvno));
 
   exit();
 
 }
 
 
  
 if($action=="invoicepaymentcsh"){   //cash payment to invoces  
     
      
     $docnumbers=  explode(",",$_GET['docnumbers']);
     $individualamt= explode(",",$_GET['individualamt']);
     $amount=trim($_GET['amount']);
     
     $paymentdate1=trim($_GET['paymentdate']);
     $paymentdate = date('Y-m-d', strtotime($paymentdate1));
     //$expacc=trim($_GET['expacc']);
     $acc=trim($_GET['acc']);
     $remarks=trim($_GET['remarks']);
     $user=$_SESSION['uname'];
     $est_id=$_SESSION['est_prop'];
     $supplier=trim($_GET['supplier']);
     $ssector = $_SESSION['sector'];
     $pvno= sprintf('%06d',intval($mumin->refnos("payno")));
     
     $ts=date('Y-m-d h:i:s');
     
     
 //insert transaction into paytrans
     $qr="INSERT INTO estate_paytrans(estId,pdate,amount,pmode,payno,chqdet,chqno,rmks,supplier,sector,tno,bacc,chequedate,ts,us,rev) 
         VALUES ($est_id,'$paymentdate','$amount','CASH','$pvno','','','$remarks','$supplier','$ssector','','$acc','','$ts','$user',0)";
     $response=$mumin->insertdbContent($qr);
     
     if($response==1){
         
         for($k=0;$k<=count($docnumbers)-2;$k++){  // mark all invoices bearing this document number as paid
             $query=("SELECT (amount-pdamount) as balance,amount FROM estate_bills WHERE docno LIKE '$docnumbers[$k]' AND supplier = '$supplier' AND estate_id LIKE '$est_id'  LIMIT 1");
                     $amtbalance= $mumin->getdbContent($query);   //check balance
                     $amntinvc= $amtbalance[0]['amount'];
                     if($individualamt[$k]<0){
                          $indgsd = -1*$individualamt[$k];
                      }else{
                          $indgsd = $individualamt[$k];
                      }
                      if($amntinvc==$indgsd){
                         $qq="UPDATE estate_bills SET payno ='$pvno',pdamount=pdamount+$indgsd WHERE docno LIKE '$docnumbers[$k]' AND estate_id  LIKE '$est_id' AND supplier LIKE '$supplier'"; 
                         $rs1=$mumin->updatedbContent($qq);
                         }
                         else if($amntinvc>$indgsd){
                         $qq="UPDATE estate_bills SET pdamount=pdamount+$indgsd WHERE docno LIKE '$docnumbers[$k]' AND estate_id LIKE '$est_id' AND supplier LIKE '$supplier'";
                     $rs1=$mumin->updatedbContent($qq);
                        $qq2="UPDATE estate_paytrans SET billsettled='$docnumbers[$k]',billamnt='$individualamt[$k]' WHERE payno = '$pvno' AND estId LIKE '$est_id' AND supplier = '$supplier'";
                    $rs2=$mumin->updatedbContent($qq2);
                         
                     }
                      
                       }
     }
     
     header('Content-type: application/json'); 
 
     echo  json_encode(array('id'=>$response,'payno'=>$pvno));
 
   exit();
 
 }
 
       if($action=="reprintingpaymentvchr"){
     
       
     $payvno= $_GET['payvno'];
   
 
     $est_id=$_SESSION['est_prop'];
        if($_SESSION['grp']=='MASOOL'){
     $data=$mumin->getdbContent("SELECT * FROM estate_paytrans WHERE payno LIKE '$payvno' AND estId LIKE '$est_id' AND rev = 0 LIMIT 1");
        } elseif ($_SESSION['grp']=='EXTERNAL') {
     $data=$mumin->getdbContent("SELECT * FROM estate_paytrans WHERE payno LIKE '$payvno' AND estId LIKE '$est_id' AND rev = 0 AND sector = '".$_SESSION['sector']."' LIMIT 1");       
        }
        if($data){
     $paymentdate=$data[0]['pdate'];
     $chequedate=$data[0]['chequedate'];
     $chequeno= $data[0]['chqno'];
     $amount=$data[0]['amount'];
     $chequedetails= $data[0]['chqdet'];
     $docnumbers= $data[0]['billsettled'];
     $payvochr=$data[0]['payno'];
     $remarks= $data[0]['rmks'];
     $supplier= $data[0]['supplier'];
     //$expacc=$data[0]['acc'];
     $acc=$data[0]['bacc'];
     if (!$chequeno){
         //$modei = 'CASH';
       $url = "cashpaymentvoucher.php?supplier=".$supplier."&docnumbers=".$docnumbers."&amount=".$amount."&paymentdate=".$paymentdate."&acc=".$acc."&payno=".$payvochr."&rmks=".$remarks."";
         //header("location:cashpaymentvoucher.php?supplier=".$supplier."&docnumbers=".$docnumbers."&amount=".$amount."&paymentdate=".$paymentdate."&acc=".$acc."&payno=".$payvochr."&rmks=".$remarks."");
//echo "<script>window.location='invoicepreview.php?paymentdate=".$data[0]['idate']."&remarks=".$data[0]['rmks']."&amount=".$data[0]['amount'].".00&sabilno=".$data[0]['sabilno']."&docno=".$data[0]['invno']."&debtor=".$data[0]['dno']."&acctname=".$data2[0]['accname']."&dispname=".$dispname."&tel=".$debtel."&sector=".$data[0]['sector']."&city=".$city."';</script>";
     }  else if($chequeno) {
         //$modei = 'CHEQUE';
         $url = "paymentvoucher.php?supplier=".$supplier."&docnumbers=".$docnumbers."&chequedate=".$chequedate."&chequeno=".$chequeno."&amount=".$amount."&narration=".$remarks."&paymentdate=".$paymentdate."&acc=".$acc."&payno=".$payvochr."";
    }}
    else{
        $url = '';
    }
  header('Content-type: application/json'); 
 
   echo  json_encode(array('url'=>$url));

   exit();
    
 }  
 
 
 
 if($action=="adduserpriviledges"){
     
      
     $usname=trim($_GET['usname']);
     
     $pwd=trim($_GET['pwd']); 
       
     $level=trim($_GET['level']);       $sectorn=trim($_GET['sectname']);
     
     $est_id=$_SESSION['est_prop'];
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
         
     $qr="INSERT INTO pword(e_uname,moh,pwd,grp,acclevel,est_id,suspended,privileges,sector) VALUES ('$usname','$moh','$pwd','EXTERNAL','999','$est_id','0','$level','$sectorn')";
     
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
     
     $est_id=$_SESSION['est_prop'];
    
     $qr="UPDATE pword SET privileges= $level WHERE uname LIKE '$usname' AND estate_prop LIKE '$est_id'";
     
     $d=$mumin->updatedbContent($qr);
     
     
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$d));
 
   exit();
   
 }
 
 
 if($action=="removeusers"){
     
      
     $usname=trim($_GET['usname']);
     
       
     
     $est_id=$_SESSION['est_prop'];
    
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
     
     $est_id=$_SESSION['est_prop'];
     
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
 
 
 
 
 
  if($action=="subaccount"){
     
     $accid=trim($_GET['accid']);     
     
      
     $qr="SELECT subaccid ,subaccountname FROM subaccounts WHERE account LIKE '$accid'"; 
     
     $d=$mumin->getdbContent($qr);
    
     
     header('Content-type: application/json'); 
 
   echo  json_encode($d);
 
   exit();
   
 }
  if($action=="autocomplete1"){
     $mohl = $_SESSION['est_prop'];
  
    $query="SELECT distinct debtorname,dno as debid FROM estate_debtors WHERE estId = '$mohl'";
     
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
 if($action=="savejv"){

     
               $est_id=$_SESSION['est_prop'];
      
              $date1=trim($_GET['jvdate']);
             
            $date = date('Y-m-d',  strtotime($date1));
              $amount=trim($_GET['jvamount']);
             $ckdte= trim($_GET['ckdte']);
              if($ckdte!==""){
                  $ckdte1 = date('Y-m-d',  strtotime($ckdte));
              } else{
                  $ckdte1 = '0000-00-00';
              }
             
             $chkno= trim($_GET['chkno']);
             $chkdetails= trim($_GET['chkdetails']);
              $fromjv=trim($_GET['jvfrom']);
              
              $tojv=trim($_GET['jvto']);
                     
              $jvrmks=trim($_GET['jvrmks']);
              $secto = trim($_GET['sectr']);
              $debityp = trim($_GET['debityp']);
              $ts=date('Y-m-d h:i:s');
              
              $us=$_SESSION['uname'];
              
              //$jvno=$mumin->refnos("jvno");
              $jvno=sprintf('%06d',intval($mumin->refnos("jvno")));
               $sector = $secto;
             
              if($fromjv==$tojv){
                 
                 $msg=2;  
              }
              
              else{
             $q="INSERT INTO estate_jentry(estId, jdate, amount, jvno, rmks, tno, dbtacc, crdtacc,chqdate,chqno,chqdet, ts, us,dbacc,cbacc)VALUES ('$est_id','$date','$amount','$jvno','$jvrmks',0,'$fromjv','$tojv','$ckdte1','$chkno','$chkdetails','$ts','$us','$debityp','$sector')";
             
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
  if($action=="savedrctexp"){

     
               $est_id=$_SESSION['est_prop'];
      
              $dexpdate1=trim($_GET['dexpdate']);
             
            $dexpdate = date('Y-m-d',  strtotime($dexpdate1));
              $dxamount =trim($_GET['dxamount']);
             $ckdte= trim($_GET['ckdte']);
              if($ckdte!==""){
                  $ckdte1 = date('Y-m-d',  strtotime($ckdte));
              } else{
                  $ckdte1 = '0000-00-00';
              }
             
             $chkno= trim($_GET['chkno']);
             $chkdetails= trim($_GET['chkdetails']);
              $crdtacc = trim($_GET['crdtacc']);
              
              $expensacc=trim($_GET['expensacc']);
                     
              $dxrmks=trim($_GET['remks']);
              $secto = trim($_GET['sectr']);
              $ts=date('Y-m-d h:i:s');
              
              $us=$_SESSION['uname'];
              
              //$jvno=$mumin->refnos("jvno");
              $dexpno=sprintf('%06d',intval($mumin->refnos("dexpno")));
               $sector = $secto;
             
             $q="INSERT INTO estate_directexpense(dexpno, dexpdate, rmks, dacc, cacc,amount, chqdate, chqno,chqdet, ts, us,sector,estate_id)VALUES 
                                            ('$dexpno','$dexpdate','$dxrmks','$expensacc','$crdtacc','$dxamount','$ckdte1','$chkno','$chkdetails','$ts','$us','$sector','$est_id')";
             
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
 if($action=="selectsctr"){

     $responsearray=array();
               
              $jvto=trim($_GET['jvto']);
                          
             $qery = "SELECT typ FROM  estate_incomeaccounts WHERE incacc = '$jvto'";
                    $sct=$mumin->getdbContent($qery);
                    @$responsearray['typ']=$sct[0]['typ'];
                    if(count($sct)==0){
               $qery2 = "SELECT type FROM  estate_bankaccounts WHERE bacc = '$jvto'";
                    $sct2=$mumin->getdbtypename($qery2);
                    @$responsearray['type'] = $sct2['type'];
                    }     
                  header('Content-type: application/json');
                  
            echo  json_encode($responsearray);
 
   //exit();
   
    }
  if($action=="jvnames"){

      
        $sabil=trim($_GET['sabil']);
        
        $names=$mumin->get_MuminHofNamesFromSabilno($sabil);
        
        
       header('Content-type: application/json'); 
 
   echo  json_encode(array('name'=>$names));
 
   exit();
  }
  
  
  if($action=="updatedebtorsinfo"){

      
        $est_id=$_SESSION['est_prop'];
        $id= trim($_GET['id']);
        $tel =trim($_GET['tel']);
        $name=trim($_GET['name']);
        $postal=trim($_GET['postal']);
        $email=trim($_GET['email']);
        $city=trim($_GET['city']);
        
        $qw="UPDATE estate_debtors SET debtorname='$name',debTelephone='$tel',email='$email',postal='$postal',city='$city' WHERE estId = '$est_id' AND dno = $id ";
        $fd=$mumin->updatedbContent($qw);
        
        
       header('Content-type: application/json'); 
 
       echo  json_encode(count($fd));
 
   exit();
  }
   if($action=="updatesuppliersinfo"){

      
        $est_id=$_SESSION['est_prop'];
        $id= trim($_GET['id']);
        $tel =trim($_GET['tel']);
        $name=trim($_GET['name']);
        $postal=trim($_GET['postal']);
        $email=trim($_GET['email']);
        $city=trim($_GET['city']);
        
        $qw="UPDATE estate_suppliers SET suppName='$name',suppTelephone='$tel',email='$email',postal='$postal',city='$city' WHERE estId LIKE '$est_id' AND supplier = '$id'";
        $fd=$mumin->updatedbContent($qw);
        
        
       header('Content-type: application/json'); 
 
       echo  json_encode($fd);
 
   exit();
  }
  
  if($action=="removesuppliers"){
     
      
     $usname=trim($_GET['usname']);
     
     $est_id=$_SESSION['est_prop'];
    
     $qr="DELETE FROM estate_suppliers WHERE supplier = '$usname' AND estId LIKE '$est_id'";
     
     $d=$mumin->insertdbContent($qr);
     
     
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$d));
 
   exit();
   
 }
 
 if($action=="removedebtors"){
     
      
     $usname=trim($_GET['usname']);
     
     $est_id=$_SESSION['est_prop'];
    
     $qr="DELETE FROM estate_debtors WHERE dno LIKE '$usname' AND estId LIKE '$est_id'";
     
     $d=$mumin->insertdbContent($qr);
     
     
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$d));
 
   exit();
   
 }
 
 if($action=="getUserDatax"){
     
    $ejno=$_GET['ejno'];
    
   $moh=$_SESSION['mohalla'];
    
 $query="SELECT *
FROM mumin m
LEFT JOIN schools s ON m.sschid = s.schid
LEFT JOIN pschools p ON m.pschid = p.pid
LEFT JOIN university u ON m.uschid = u.unid
WHERE m.ejno LIKE '$ejno' AND m.moh LIKE '$moh'"; 
     
    $array=$mumin->getdbContent($query);
  
    header('Content-type: application/json'); 
 
    echo  json_encode($array);
 
    exit();  
 }
  
?>