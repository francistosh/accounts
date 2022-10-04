<?php
$id = $_SESSION['dept_id'];
?>
<div id="div_leftpanel">
   	    
      	<div id="div_menutitle">Menu</div>  
        <div id="navigation">
        	<ul id="menu-primary-navigation"  class="top-level">
                    <li><a href="index.php"><span>Home</span></a></li>
                    <li> <a class="arrow expanded" href="#"><span>Invoices/Credit Note</span></a>
                        <ul class="sub-menu" style="<?php if (basename($_SERVER['PHP_SELF'])== 'create_invoice.php') {echo 'display:block';}else {echo 'display:none';}?>"> 
                  <?php if ($priviledges[0]['invoices']==1){echo '
                  <li><a href="create_invoice.php?idaction=new&id='.$id.'">New Invoice</a></li>
                  <li><a href="create_invoice.php?idaction=print">Re-Print Invoice</a></li>
                  <li><a href="create_invoice.php?idaction=multicreditnote">New Credit Note</a></li>
                  <li><a href="create_invoice.php?idaction=crprnt">Re-Print Credit Note</a></li>
                  <li><a href="create_invoice.php?idaction=invoicelist">Invoice List</a></li>
                  <li><a href="create_invoice.php?idaction=creditlist">Credit Note List</a></li>';}else{ }?>
                       <!--<li><a href="create_invoice.php?idaction=creditnote">New Credit Note</a></li>-->
                  
                  <?php if ($priviledges[0]['invoices']==1){echo '
                  <li><a href="create_invoice.php?idaction=indivdlsabil">Sabil Invoicing </a></li>
                  <li><a href="create_invoice.php?idaction=sabil">Mohalla Invoicing</a></li>
                  <li><a href="create_invoice.php?idaction=batch">Batch Invoices</a></li>
                  <li><a href="statements.php?type=selectivebatch">Selective Invoicing</a></li>';}else{ }?>
                  
                  <?php if ($priviledges[0]['debtors']==1){echo '
                      <li><a href="create_invoice.php?idaction=edit" >Debtor List</a></li>';}else{}?>
                  
                  <?php if ($priviledges[0]['admin']==1){echo '
                      <li><a href="create_invoice.php?idaction=modify" >Modify Invoice</a></li>
                      <li><a href="create_invoice.php?idaction=overpayment" >Over Payment</a></li>';}else{}?>
                    </ul></li> 
                     <li> <a class="arrow expanded" href="#"><span>Receipts</span></a>
                        <ul class="sub-menu" style="<?php if (basename($_SERVER['PHP_SELF'])== 'receipts.php' || basename($_SERVER['PHP_SELF'])== 'pdcheqs_operation.php' ) {echo 'display:block';}else {echo 'display:none';}?>">
                 <?php if ($priviledges[0]['receipts']==1){echo '
                    <li><a href="receipts.php?type=new&id='.$id.'">New Receipts</a></li>  
                    <li><a href="receipts.php?type=reprint">Reprint Receipts</a></li>
                    <li><a href="receipts.php?type=receiptlist">Receipts List</a></li>
                    <li><a href="receipts.php?type=status">Receipt Log</a></li>
                    <li><a href="receipts.php?type=reversal">Receipts reversal</a></li>
                    <li><a href="pdcheqs_operation.php?type=">PD Cheques Banking</a></li>';}else{}?>
             
            <?php if ($priviledges[0]['admin']==1){
                //echo '<li><a href="pdcheqs_operation.php?type=">PD Cheques Banking</a></li>';
                
                echo '<li><a href="receipts.php?type=edit">Modify Receipt</a></li>';}else{}?>
</ul></li>
                       <li> <a class="arrow expanded" href="#"><span>Debtor Accounts</span></a>
                        <ul class="sub-menu" style="<?php if (basename($_SERVER['PHP_SELF'])== 'statements.php') {echo 'display:block';}else {echo 'display:none';}?>">
                 <?php if ($priviledges[0]['receipts']==1 || $priviledges[0]['invoices']==1){echo '
                        <li><a href="statements.php?type=mumin">Mumin Statement</a></li>
                        <li><a href="statements.php?type=debtorsmry">Debtor Summary</a> </li>
                        <li><a href="statements.php?type=multistamnt">Batch Statements</a></li>
                        <li><a href="statements.php?type=multiemailstmnt">Email Statement</a></li>
                            ';}else{}?> 
                            <?php if ($priviledges[0]['receipts']==1){echo '
                             <li> <a href="statements.php?type=badebts">Bad Debts</a> </li>
                            ';}else{}?> 
                  <?php if ($priviledges[0]['invoices']==1){echo '
                             <li><a href="statements.php?type=selectivebatch">Selective Invoicing</a></li>
                            ';}else{}?>           
                           
                            </ul></li>
            
            <li> <a class="arrow expanded" href="#"><span>Deposits</span></a>
                <ul class="sub-menu" style="<?php if (basename($_SERVER['PHP_SELF'])== 'deposit.php') {echo 'display:block';}else {echo 'display:none';}?>">
            <?php if ($priviledges[0]['deposits']==1){echo '
                             <li><a href="deposit.php?type=notdeposited">Undeposited Receipts</a></li>
                            <li><a href="deposit.php?type=printdeposit">Reprint Deposit</a> </li>
                            ';}else{}?>  
            <?php if ($priviledges[0]['admin']==1){echo '<li><a href="#">Modify Deposit</a></li>';}else{}?>
	    
                
                </ul></li>
            
              <li> <a class="arrow expanded" href="#"><span>Supplier Bill</span></a>
                        <ul class="sub-menu" style="<?php if (basename($_SERVER['PHP_SELF'])== 'splrbills.php') {echo 'display:block';}else {echo 'display:none';}?>">
                  <?php if ($priviledges[0]['suppliers']==1){echo '
                      <li><a href="splrbills.php?idaction=newsupp">Add new supplier</a></li> 
                  <li><a href="splrbills.php?idaction=newbill">New Bill</a></li>
                 <li><a href="splrbills.php?idaction=newcrdtnote">Debit Note</a></li>
                 <li><a href="splrbills.php?idaction=billslist">Bills List</a></li>
                 <li><a href="splrbills.php?idaction=editsupp">Supplier List</a></li>';}else{}?>
                    <?php if ($priviledges[0]['admin']==1){echo '
                   <li><a href="splrbills.php?idaction=editbill">Modify Bill</a></li> ';}else{}?>     
                        </ul></li>
                  <li> <a class="arrow expanded" href="#"><span>Payments</span></a>
                        <ul class="sub-menu" style="<?php if (basename($_SERVER['PHP_SELF'])== 'payments.php') {echo 'display:block';}else {echo 'display:none';}?>">
             <?php if ($priviledges[0]['payments']==1){echo '
                 <li><a href="payments.php?action=new">New payment</a></li>
            <li><a href="payments.php?action=printvoucher">Print Voucher</a></li>
            <li><a href="payments.php?action=paymentlist">Payment Vouchers</a></li>
            <li><a href="payments.php?action=paymentslist">Payment List</a></li>';}else{}?>
                            <?php if ($priviledges[0]['admin']==1){echo '
                  <li><a href="payments.php?action=voucherreversal">Payment Reversal</a></li>
                 <li><a href="payments.php?action=editpayment">Edit P.Voucher</a></li> ';}else{}?> 
                        </ul></li>
                        <li> <a class="arrow expanded" href="#"><span>Creditor Account</span></a>
                        <ul class="sub-menu" style="<?php if (basename($_SERVER['PHP_SELF'])== 'creditoraccts.php') {echo 'display:block';}else {echo 'display:none';}?>">
                    <?php if ($priviledges[0]['statements']==1){echo '<li><a href="creditoraccts.php?idaction=supstatement">Supplier Account</a></li>
                 <li><a href="creditoraccts.php?idaction=supsummary">Supplier Summary</a></li>';}else{}?>         
                 <?php if ($priviledges[0]['payments']==1){echo '<li><a href="creditoraccts.php?idaction=supbadebts">Supplier Bad Debts</a></li>';}else{}?>
                        </ul></li>

                    <li> <a class="arrow expanded" href="#"><span>Direct Expense</span></a>
                        <ul class="sub-menu" style="<?php if (basename($_SERVER['PHP_SELF'])== 'directexpe.php') {echo 'display:block';}else {echo 'display:none';}?>">
                            <?php if ($priviledges[0]['directexp']==1){echo '<li><a href="directexpe.php?action=new">Direct Expense Voucher</a></li>
                            <li><a href="directexpe.php?action=list">Direct Expense List</a></li>   
                            <li><a href="directexpe.php?action=print">Print Direct Expense</a></li>';}else{}?>
                            <?php if ($priviledges[0]['admin']==1){echo '
                  <li><a href="directexpe.php?action=modify">D. Expense Reversal</a></li>';}else{}?> 
                        </ul></li>
                        <li> <a class="arrow expanded" href="#"><span>Transfers</span></a>
                        <ul class="sub-menu" style="<?php if (basename($_SERVER['PHP_SELF'])== 'jv.php') {echo 'display:block';}else {echo 'display:none';}?>">
                            <?php if ($priviledges[0]['jv']==1){echo '<li><a href="jv.php?action=new">Bank Journal Voucher</a></li>
                            <li><a href="jv.php?action=list">Bank Voucher List</a></li>
                            <li><a href="jv.php?action=journalentry">Journal Entry</a></li>
                            <li><a href="jv.php?action=jentrylist">Journal Entry List</a></li> 
                            <li><a href="jv.php?action=print">Print Bank J.V</a></li>';}else{}?>
                        </ul></li>
                         <li> <a class="arrow expanded" href="#"><span>Account Operations</span></a>
                        <ul class="sub-menu" style="<?php if (basename($_SERVER['PHP_SELF'])== 'accountoperations.php') {echo 'display:block';}else {echo 'display:none';}?>"><li><a href="accountoperations.php?type=incrprt">Income Report</a></li>
            <li><a href="accountoperations.php?type=costcentrewise">Cost Center Expense</a></li>   
            <li><a href="accountoperations.php?type=expenseactwse">Expense Report</a></li>
            <li><a href="accountoperations.php?type=badebtsrprts">Bad debts Reports</a></li>
                        </ul></li>   
            	<li> <a href="logout.php"> Log Out </a></li>
        	</ul>
        </div>
    
</div>