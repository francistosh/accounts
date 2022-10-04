	  <div id="div_navigation">
      	<ul id="menu">
            <li><a href="index.php">Home</a>        
            </li>  
            <li><a href="#" class="drop">Financials</a>
            <div class="dropdown_column">  
                <a href="<?php if(intval($priviledges[0]['invoices'])==1){ echo "create_invoice.php?idaction=";}else{ echo "#";} ?>" class="navButton"><p class="navButton">Invoices</p></a> 
                <a href="<?php if(intval($priviledges[0]['receipts'])==1){ echo "receipts.php?type=";}else{ echo "#";} ?>" class="navButton"><p class="navButton">Receipts</p></a> 
                <a href="<?php if(intval($priviledges[0]['statements'])==1){ echo "statements.php?type=mumin";}else{ echo "#";} ?>" class="navButton"><p class="navButton">Statement</p></a>
                <a href="<?php if(intval($priviledges[0]['invoices'])==1){ echo "splrbills.php?idaction=";}else{ echo "#";} ?>" class="navButton"><p class="navButton">Supplier Bills</p></a>
                <a href="<?php if(intval($priviledges[0]['invoices'])==1){ echo "creditoraccts.php?idaction=";}else{ echo "#";} ?>" class="navButton"><p class="navButton">Supplier</p></a>
                <a href="<?php if(intval($priviledges[0]['payments'])==1){ echo "payments.php?action=new";}else{ echo "#";} ?>" class="navButton"><p class="navButton">Payments</p></a>
                <a href="jv.php?action=" class="navButton" style=" display:<?php if(intval($priviledges[0]['jv'])==1){ echo "block";}else{ echo "none";} ?>"><p class="navButton">Journal Vouchers</p></a>
                <a href="directexpe.php?action=new" class="navButton" style=" display:<?php if(intval($priviledges[0]['directexp'])==1){ echo "block";}else{ echo "none";} ?>"><p class="navButton">Direct Expense</p></a>
                <!--<a href="<?php //if(intval($priviledges[0]['suppliers'])==1){ echo "suppliersmanagement.php?action=new";}else{ echo "#";} ?>" class="navButton"><p class="navButton">Suppliers Management</p></a> -->
                <!--<a href="<?php  if(intval($priviledges[0]['debtors'])==1){echo "debtorsmanagement.php?action=new";} else{ echo "#";}?>" class="navButton"><p class="navButton">Debtors Management</p></a> -->
                <!--<a href="<?php //if(intval($priviledges[0]['bankaccounts'])==1){echo "bankmanagement.php?action=edit";} else{ echo "#";}?>" class="navButton"><p class="navButton">Bank Accounts</p></a> -->
            </div> 
            </li>  
             
            <li style="display: <?php if(intval($priviledges[0]['admin'])==1){ echo "block";}else{ echo "none";} ?>"><a href="#" class="drop">Settings</a> 
            <div class="dropdown_column">
                <a href="<?php if(intval($priviledges[0]['admin'])==1){ echo "manageacct.php?type=edit";}else{ echo "#";} ?>" class="navButton"><p class="navButton">Bank Accounts</p></a>
                <a href="<?php if(intval($priviledges[0]['admin'])==1){ echo "grant_priviledges.php?type=view";}else{ echo "#";} ?>" class="navButton"><p class="navButton">Manage Users</p></a>
                 
        	</div>      
            </li>  
            <li><a href="#" class="drop">Reports</a>
                <div class="dropdown_column">
		<a href="<?php if(intval($priviledges[0]['payments'])==1){ echo "bankacctsrprts.php?type=ageanalysis";}else{ echo "#";} ?>" class="navButton"><p class="navButton">Age Analysis</p></a>
                <a href="<?php if(intval($priviledges[0]['payments'])==1){ echo "bankacctsrprts.php?type=iestatmnt";}else{ echo "#";} ?>" class="navButton"><p class="navButton">Income Statement</p></a>
           	<a href="<?php if(intval($priviledges[0]['payments'])==1){ echo "bankacctsrprts.php?type=bankledger";}else{ echo "#";} ?>" class="navButton"><p class="navButton">Bank Ledger</p></a>
                <a href="<?php if(intval($priviledges[0]['payments'])==1){ echo "bankacctsrprts.php?type=trialbalance";}else{ echo "#";} ?>" class="navButton"><p class="navButton">Trial Balance</p></a>
		<a href="<?php if(intval($priviledges[0]['payments'])==1){ echo "bankacctsrprts.php?type=bankrecon";}else{ echo "#";} ?>" class="navButton"><p class="navButton">Bank Recon</p></a>
                <a href="<?php if(intval($priviledges[0]['payments'])==1){ echo "bankacctsrprts.php?type=expenserprt";}else{ echo "#";} ?>" class="navButton"><p class="navButton">Expense Report</p></a>
                <a href="<?php if(intval($priviledges[0]['admin'])==1){ echo "bankacctsrprts.php?type=";}else{ echo "#";} ?>" class="navButton" style="display: <?php if(intval($priviledges[0]['admin'])==1){ echo "block";}else{ echo "none";} ?>"><p class="navButton">More.. </p></a>
        
                </div>
            </li>  	
        </ul>
      </div>