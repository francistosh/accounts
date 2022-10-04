<div id="div_leftpanel">
   	 
      <?php 
      $departmntd = $_SESSION['dept_id'];
      ?>
      	<div id="div_menutitle">Dash Board</div>
        <div id="navigation">
        <ul id="menu-primary-navigation"  class="top-level">
       
            <li><a href="accounts.php?action=<?php echo $departmntd;?>"><span>Accounts</span></a></li>
                    <li> <a class="arrow expanded" href="#"><span>Reports</span></a>
                        <ul class="sub-menu" style="<?php if (basename($_SERVER['PHP_SELF'])== 'bankacctsrprts.php') {echo 'display:block';}else {echo 'display:none';}?>"> <li><a href="bankacctsrprts.php?type=bankledger">Bank Ledger</a></li>
                            <li><a href="bankacctsrprts.php?type=iestatmnt">Income Statement</a></li>
                            <li><a href="bankacctsrprts.php?type=ageanalysis">Age Analysis</a></li>
                  <li><a href="bankacctsrprts.php?type=trialbalance">Trial Balance</a></li>
                  <li><a href="bankacctsrprts.php?type=bankrecon">Bank Recon</a></li>
                  <li><a href="bankacctsrprts.php?type=reprintbankrecon">Reprint Recon</a></li>

                    </ul></li> 
                    <li> <a class="arrow expanded" href="#"><span>General Reports</span></a>
                    
                    </li>
           <!-- <li class="menuitems"><a href="statement_1.php?type=multistatement">Cumulative Statement<font style="color: red;text-decoration: blink">(new)</font></a></li>  !--> 
           <li><a href="index.php"><span>Home</span></a></li> 
           <li><a href="logout.php"><span> Log Out</span></a> </li>
    
        </ul>
        </div>
    </div>