    <div id="div_leftpanel">
   	    
      	<div id="div_menutitle">Menu</div>  
        <div id="navigation">
        	<ul id="menu-primary-navigation"  class="top-level">
                    <li><a href="index.php"><span>Home</span></a></li>
                    <li><a class="arrow expanded" href="#"><span>Notifications</span></a></li>
                    
            <li><a class="arrow expanded"  > Account Settings </a>
                    <ul class="sub-menu" style="<?php if (basename($_SERVER['PHP_SELF'])== 'manageacct.php' || basename($_SERVER['PHP_SELF'])== 'incomeaccounts.php' || basename($_SERVER['PHP_SELF'])== 'expenseaccts.php' || basename($_SERVER['PHP_SELF'])== 'closeperiod.php') {echo 'display:block';}else {echo 'display:none';}?>"><li><a  href="manageacct.php?type=edit">Manage Account</a></li>
            <li> <a href="manageacct.php?type=view">Bank Accounts</a> </li>
            <li><a href="incomeaccounts.php?action=new">New Income account</a></li>
            <li> <a href="incomeaccounts.php?action=edit">Income Accounts</a> </li>
            <li> <a href="incomeaccounts.php?action=addsubincome">Sub Income Acct</a> </li>
            <li><a href="expenseaccts.php?action=new">New Expense account</a></li>
            <li><a href="expenseaccts.php?action=edit">Expense Accounts</a></li>
            <li> <a href="expenseaccts.php?action=addsubexpnse">Sub Expense Acct</a> </li>
             <li> <a href="closeperiod.php?action=new">Close Period</a> </li>
             <li> <a href="general.php?action=new">Mumin Balances </a> </li>
	    </ul></li>
    <li><a class="arrow expanded"  > Admin Operations </a>
                    <ul class="sub-menu" style="<?php if (basename($_SERVER['PHP_SELF'])== 'setup.php') {echo 'display:block';}else {echo 'display:none';}?>" >
                        <li> <a href="setup.php?action=addcompny">Add Company</a> </li>
                        <li> <a href="setup.php?action=addeprtmnt">Cost Center</a> </li>
                        <li> <a href="setup.php?action=budget">Budget</a> </li>
                        <li><a href="adminrprts.php"> Banking Report </a> </li>
                        <li><a href="../reports/reports.php"> Admin Reports </a> </li>
	    </ul></li>
                <li><a class="arrow expanded"  > User Management </a>
                    <ul class="sub-menu" style="<?php if (basename($_SERVER['PHP_SELF'])== 'grant_priviledges.php') {echo 'display:block';}else {echo 'display:none';}?>" >
            <li> <a href="grant_priviledges.php?type=add">Add users</a> </li>
            <li> <a href="grant_priviledges.php?type=view">View Users </a> </li>
	    </ul></li>
                <li> <a href="logout.php"> Log Out </a></li>
        	</ul>
        </div>
    
    </div>