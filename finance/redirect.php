<?php
 session_start();
 
 include '../finance/operations/Mumin.php';
 date_default_timezone_set('Africa/Nairobi');
 $mumin=new Mumin();
 
 $action=$_GET['action'];
  if($action=="savemumindebtor"){
     
      
     $name=trim($_GET['name']);
     $telephone=trim($_GET['telephone']);
     $email=trim($_GET['email']);
     $postal=trim($_GET['postal']);
     $city=trim($_GET['city']);
     $sabilno2= trim($_GET['sabilno']);
     $remarks=trim($_GET['remarks']);
     $user=$_SESSION['jname'];
     $est_id=$_SESSION['dept_id'];
     $sabilno= strtoupper($sabilno2);
     $qr="INSERT INTO debtors(debtorname,sabilno,deptid,debTelephone,email,postal,city,remarks,user) VALUES ('$name','$sabilno',$est_id,'$telephone','$email','$postal','$city','$remarks','$user')";
     
     $data=$mumin->insertdbContent($qr);
    
     
   header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data));
 
   exit();
   
 }
  if($action=="getmuminMohala"){  //get mumin names and data for invoice
     
      $ejnox=trim($_GET['ejno']);
      $mohl = $_SESSION['dept_id'];
      //echo $_SESSION['dept_id'];
     $qr="SELECT sabilno FROM  mumin  WHERE ejno = '$ejnox' LIMIT 1";
     
     $data=$mumin->getdbContent($qr);
    if ($data){
     $name=$mumin->get_MuminNames($ejnox);
     $ejnu = $ejnox;
     $sabilx = $data[0]['sabilno'];
    }
    else{
        $name= 'Not in Mohalla';
        $ejnu = '';
        $sabilx = '';
    }
     //$invno=sprintf('%06d',intval($mumin->refnos("invno")));
     
    header('Content-type: application/json'); 
 
   echo  json_encode(array('name'=>$name,'ejno'=>$ejnu,'sabil'=>$sabilx));
 
   exit();   
 }
 if($action=="fetchestdetails"){
     $estateid=trim($_GET['estateid']);
     
  
    $query="SELECT mohalla  FROM costcenters WHERE ccid = '$estateid'";
     
    $array=$mumin->getdbContent($query);
    $mohal = $array[0]['mohalla'];
    $query2 = "SELECT distinct(sector) FROM mumin WHERE moh = '$mohal'";
    $array2=$mumin->getdbContent($query2);
    header('Content-type: application/json'); 
 
    echo  json_encode($array2);
 
    exit();  
 }
 if($action=="fetchbankdetails"){
     $estateid=trim($_GET['estateid']);
     
  
    $query="SELECT bacc,acname  FROM estate_bankaccounts WHERE 	estate_id = '$estateid'";
     
    $array=$mumin->getdbContent($query);

    header('Content-type: application/json'); 
 
    echo  json_encode($array);
 
    exit();  
 }
 if($action=="updateccountadmin"){
     
      
     $adminactname=trim($_GET['adminactname']);
     $acctno=trim($_GET['acctno']);
     $actsector=trim($_GET['actsector']);
     $acttype=trim($_GET['acttype']);
     $estaid = trim($_GET['estatename']);
     $est_id=$_SESSION['dept_id'];    
     $qr="UPDATE estate_bankaccounts SET acno = '$acctno', sector = '$actsector', type = '$acttype' WHERE bacc = '$adminactname' AND estate_id = '$estaid' ";
      $data=$mumin->updatedbContent($qr);
     header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data));
 
   exit();
   
 }
if($action=="saveadminaccount"){
     
      
     $name=trim($_GET['name']);
     $acctno=trim($_GET['acctno']);
     $actsector=trim($_GET['actsector']);
     $acttype=trim($_GET['acttype']);
     $estatename=trim($_GET['estatename']);
     $est_id=$_SESSION['dept_id'];    
     $qr="INSERT INTO estate_bankaccounts (bacc,acno,acname,estate_id,sector,type,estate_id) VALUES (0,'$acctno','$name','$est_id','$actsector','$acttype','$estatename')";
      $data=$mumin->insertdbContent($qr);
     header('Content-type: application/json'); 
 
   echo  json_encode(array('id'=>$data));
 
   exit();
   
 } 
 
  if($action=="expsubacc"){
     $mohl = $_SESSION['dept_id'];
  
    $query="SELECT distinct subacc  FROM bills WHERE estate_id = '$mohl'";
     
    $array=$mumin->getdbContent($query);
  
    header('Content-type: application/json'); 
 
    echo  json_encode($array);
 
    exit();  
 }
   if($action=="costc"){
     $mohl = $_SESSION['dept_id'];
  //"SELECT expnseaccs.id,expnseaccs.accname FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id  AND expenseactmgnt.deptid = '$id'";
    $query="SELECT department2.centrename,department2.id as cntrid FROM department2,costcentrmgnt WHERE costcentrmgnt.costcentrid = department2.id AND costcentrmgnt.deptid = '$mohl' GROUP BY department2.id";
     
    $array=$mumin->getdbContent($query);
  
    header('Content-type: application/json'); 
 
    echo  json_encode($array);
 
    exit();  
 }
  if($action=="getinvoice"){  //get mumin names and data for invoice
     
      $invoicenum =trim($_GET['invoiceno']);
      $sabil =trim($_GET['sabil']);
      $debtor =trim($_GET['debtor']);
      $amount =trim($_GET['amount']);
      $account =trim($_GET['account']);
      $etid = $_SESSION['dept_id'];
      //echo $_SESSION['dept_id'];
  
          if($sabil !==""){
               
      $qry = "SELECT invno FROM invoice WHERE invno = '$invoicenum' AND estId = '$etid' AND isinvce ='1' AND sabilno = '$sabil' AND amount - pdamount >='$amount' and incacc ='$account' LIMIT 1";
        } else{
            $qr0="SELECT dno FROM debtors WHERE debtorname = '$debtor' AND deptid = '$etid'";
            $data1=$mumin->getdbContent($qr0);
     $debtor2 = $data1[0]['dno'];
      $qry = "SELECT invno FROM invoice WHERE invno = '$invoicenum' AND estId = '$etid' AND isinvce ='1' AND dno = '$debtor2' AND amount - pdamount >='$amount' and incacc ='$account' LIMIT 1";
      
        }
      

      $data1=$mumin->getdbContent($qry);     
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
if($action=="validateamounte"){  //get mumin names and data for invoice
     
      $crdtinvoiceno =trim($_GET['crdtinvoiceno']);
      $supplier =trim($_GET['supplier']);
      $bilamnt =trim($_GET['bilamnt']);
      $costcntreid=  trim($_GET['costcntreid']);
      $etid = $_SESSION['dept_id'];
      
     $qry = "SELECT docno FROM bills WHERE docno = '$crdtinvoiceno' AND estate_id = '$etid' AND isinvce ='1' AND supplier = '$supplier' AND amount >= '$bilamnt' AND costcentrid = '$costcntreid' LIMIT 1";

      $data1=$mumin->getdbContent($qry);     
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
 
 if($action=="existingbill"){  //get mumin names and data for invoice
     
      $crdtinvoiceno =trim($_GET['crdtinvoiceno']);
      $supplier =trim($_GET['supplier']);
      $bilamnt =trim($_GET['bilamnt']);
      $costcntreid=  trim($_GET['costcntreid']);
      $etid = $_SESSION['dept_id'];
      
     $qry = "SELECT docno FROM bills WHERE docno = '$crdtinvoiceno' AND estate_id = '$etid' AND isinvce ='1' AND supplier = '$supplier' AND costcentrid = '$costcntreid'";

      $data1=$mumin->getdbContent($qry);     
      $coutb = count($data1);
    if ($coutb>0){
     $existing = '1';
    }
    else{
        $existing = '0';
    }
     //$invno=sprintf('%06d',intval($mumin->refnos("invno")));
     
    header('Content-type: application/json'); 
 
   echo  json_encode(array('existing'=>$existing));
 
   exit();   
 }
  if($action=="existingmultibill"){  //get mumin names and data for invoice
     
      $crdtinvoiceno =trim($_GET['crdtinvoiceno']);
      $supplier =trim($_GET['supplier']);
      $bilamnt = explode(",",$_GET['bilamnt']);
      $costcntreid = explode(",",$_GET['costcntreid']);
      $etid = $_SESSION['dept_id'];
      $coutb = 0;
      for($f=0;$f<=count($bilamnt)-2;$f++){
     $qry = "SELECT docno FROM bills WHERE docno = '$crdtinvoiceno' AND estate_id = '$etid' AND isinvce ='1' AND supplier = '$supplier' AND costcentrid = '$costcntreid[$f]'";

      $data1=$mumin->getdbContent($qry); 
      $coutb = $coutb + count($data1);
      }      
    if ($coutb>0){
     $existing = '1';
    }
    else{
        $existing = '0';
    }
     //$invno=sprintf('%06d',intval($mumin->refnos("invno")));
     
    header('Content-type: application/json'); 
 
   echo  json_encode(array('existing'=>$existing));
 
   exit();   
 }
 
 if($action=="getinvoicedetails"){  //get data for invoice
     
      $invoicenum =trim($_GET['invceno']);
      $sabil =trim($_GET['invsabil']);
      $debtor =trim($_GET['invdebtor']);
      
      $etid = $_SESSION['dept_id'];
      //echo $_SESSION['dept_id'];

          if($sabil !==""){
      $qry = "SELECT * FROM invoice WHERE invno = '$invoicenum' AND estId = '$etid' AND isinvce ='1' AND sabilno = '$sabil' LIMIT 1";
            } 
         else{
            $qr0="SELECT dno FROM debtors WHERE debtorname = '$debtor' AND deptid = '$etid'";
            $data1=$mumin->getdbContent($qr0);
     $debtor2 = $data1[0]['dno'];
      $qry = "SELECT * FROM invoice WHERE invno = '$invoicenum' AND estId = '$etid' AND isinvce ='1' AND dno = '$debtor2'  LIMIT 1";
            }
      
   

      $data2=$mumin->getdbContent($qry);     
      $cout = count($data2);
    if ($cout>0){
     $available = '1';
     $incacc = $data2[0]['incacc'];
    $iamount = $data2[0]['amount']; 
    $irmks = $data2[0]['rmks'];
    }
    elseif ($cout<=0){
        $available = '0';
        $incacc = '';
        $iamount = '';
        $irmks = '';
    }
    
     //$invno=sprintf('%06d',intval($mumin->refnos("invno")));
     
    header('Content-type: application/json'); 
 
   echo  json_encode(array('available'=>$available,'incacc'=>$incacc,'iamount'=>$iamount,'iremarks'=>$irmks));
 
   exit();   
 }
  if($action=="getbilldetails"){  //get data for invoice
     
      $crdtinvcno =trim($_GET['invcno']);
      $supplier =trim($_GET['supplier']);
       $costcntreid   = trim($_GET['costcntreid']);
      $etid = $_SESSION['dept_id'];
      //echo $_SESSION['dept_id'];
         
      $qry = "SELECT * FROM bills WHERE docno = '$crdtinvcno' AND estate_id = '$etid' AND isinvce ='1' AND supplier = '$supplier' AND costcentrid = '$costcntreid' LIMIT 1";
  
      $data2=$mumin->getdbContent($qry);     
      $cout = count($data2);
    if ($cout>0){
     $available = '1';
         $bamount = $data2[0]['amount']; 
    $expenseacc = $data2[0]['expenseacc'];
    $brmks = $data2[0]['rmks'];
    
    }
    elseif ($cout<=0){
        $available = '0';
        $bdocno = '';
        $bamount = ''; 
        $expenseacc = '';
        $brmks = '';
    }
    
     //$invno=sprintf('%06d',intval($mumin->refnos("invno")));
     
    header('Content-type: application/json'); 
 
   echo  json_encode(array('available'=>$available,'bamount'=>$bamount,'expenseacc'=>$expenseacc,'billrmks'=>$brmks));
 
   exit();   
 }
 if ($action=="photos"){
     $mumin->dbConnect();
    $muminame =$_GET['name'];
    $surname=$_GET['sname'];
    if($muminame || $surname){
   //$estatesid=$_SESSION['dept_id'];
      $counter = 0 ;
      //$qry = "SELECT mohalla FROM anjuman_estates WHERE est_id LIKE '$estatesid' LIMIT 1";
      //$data1=$mumin->getdbContent($qry);     
          
      $queryr="SELECT ejno,sabilno FROM mumin WHERE (sname LIKE '$surname%' AND fname LIKE '$muminame%') ";
      $result= mysql_query($queryr);
           while ($row = mysql_fetch_array($result)){
          $counter = $counter+1;
          echo '<div class="images">';
                   ?>
            <a href="#" value="<?php echo $row['sabilno'];?>" id="sabilimg<?php echo $counter;?>">
                <img  id="image"  height='50' width='50' src="../assets/images/mumin/<?php echo $row['ejno'];?>.jpg" onclick="ejnosabil(<?php echo $counter;?>)" ></img></a>
          <?php
                    echo '<span id="spanid'.$counter.'" style="font-size:12px;font-family: Arial;"><br>'.$row['ejno'].'</br></span>  ';
                    echo "<span id='spaname$counter' style='display:none'>".$name = $mumin->get_MuminNames($row['ejno'])."</span>";
                    echo "<span id='sectorname$counter' style='display:none'>".$sctrname = $mumin->getsectorname($row['ejno'])."</span>";
          echo '</div>';
               }
               if(!$result){
                    echo 'No result found';
               }
      
}}
?>
