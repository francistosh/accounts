    <div id="div_leftpanel">
   	    
      	<div id="div_menutitle">Menu</div>  
        <div id="navigation">
        	<ul id="menu-primary-navigation"  class="top-level">
                    <li><a href="index.php"><span>Home</span></a></li>
                    <li><a class="arrow expanded" href="#"><span>Notifications</span></a></li>
            	<li style="display: <?php if(intval($priviledges[0]['admin'])==1){ echo 'block';} else {echo 'none';} ?>"><a class="arrow expanded"  > Admin Operations </a>
                    <ul class="sub-menu" ><li><a href="incomeaccounts.php?action=new">New Income account</a></li>
            <li> <a href="incomeaccounts.php?action=edit">View Income Accounts</a> </li>
            <li> <a href="incomeaccounts.php?action=edit">User Management</a> </li>
	    </ul></li>
                                 <li><a href="<?php if(intval($priviledges[0]['admin'])==1){ echo "grant_priviledges.php?type=";}else{ echo "#";} ?>"> Account Settings </a></li>
                <li> <a href="logout.php"> Log Out </a></li>
        	</ul>
        </div>
    
    </div>