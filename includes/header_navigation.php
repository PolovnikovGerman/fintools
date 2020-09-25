<div class="header_default" >
 <div style="float:left;  margin-top:8px;">
     <a href="blank.php">
         <img style="margin-left:10px;" src="/images/page_newlogo.png" id="logo"/>
     </a>
 </div>
 <div style="float:left; position:absolute; top:0; margin-left:450px;"></div>
 <div class="menu" >
 <ul id="sddm">
    <li><a href="devControl.php" 
        onmouseover="mopen('m1')" 
        onmouseout="mclosetime()">Tasks</a>
        <div id="m1" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">

        </div>
    </li>
    <li><a href="leads.php" 
        onmouseover="mopen('m6')" 
        onmouseout="mclosetime()">Leads</a>
      <div id="m6" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">
            <a href="webQuotes.php">BU Quotes</a>
            <a href="sbQuotes.php">SB Quotes</a>
            
       
        </div>
    </li>
    
    <li><a href="#" 
        onmouseover="mopen('m12')" 
        onmouseout="mclosetime()">Marketing</a>
      <div id="m12" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">
            <a href="coupons.php">Coupons</a>
            <a href="surveys.php">Surveys</a>
        <a href="competitor.php">Competitor</a>
            
       
        </div>
    </li>
    
     <li><a href="orders.php" onmouseover="mopen('m4')" 
        onmouseout="mclosetime()">Orders</a>
       <div id="m4" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">
            <a href="sbOrders.php">SB Orders</a>
        
        </div>
    </li>
    
    <li><a href="art.php" 
        onmouseover="mopen('m2')" 
        onmouseout="mclosetime()">Art</a>
        <div id="m2" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">

        </div>
    </li>
    <li><a href="fullfillment.php" 
        onmouseover="mopen('m3')" 
        onmouseout="mclosetime()">Fullfillment</a>
        <div id="m3" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">
        <a href="ff_items.php">FF Items</a>
        <a href="ff_vendors.php">FF Vendors</a>
        <a href="amount_listing.php">Amt Listing</a>

        </div>
    </li>
   
    <li><a href="customerTickets.php" onmouseover="mopen('m8')" 
        onmouseout="mclosetime()">Tickets</a>
        <div id="m8" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">
        <a href="customerTickets.php">Cust Tix</a>
        <a href="vendorTickets.php">Vend Tix</a>
        <a href="adjustments.php">Adjustments</a>

        </div>
    </li>
    <li><a href="revenue.php" 
        onmouseover="mopen('m5')" 
        onmouseout="mclosetime()">Finance</a>
        <div id="m5" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">
        <a href="revenue.php">Revenue</a>
        <?php
		if($_SESSION['uid'] != 11 && $_SESSION['uid'] != 12) { ?>
        <a href="reportOrders.php">Profit</a>
        <?php } ?>
         
        </div>
    </li>
    
    <li><a href="#" 
        onmouseover="mopen('m7')" 
        onmouseout="mclosetime()">Admin</a>
        <div id="m7" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">
        <a href="websites.php">Websites</a>
        <a href="brandBU.php">Items</a>
        
        <a href="users.php">Users</a>
        
        </div>
    </li>
    
    
    
    
</ul>
</div>





<div class="user_logout" >



&nbsp;<?php echo $_SESSION['screenname']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
[&nbsp;<a href="logout.php">Logout</a>&nbsp;]
</div>
<!-- REMEMBER YOU HAVE PLACE HERE TO PLACE LINKS LIKE ADMIN HELP ETC ETC ETC ITS JUST HIDDEN AS WE HAVE NO USE FOR IT NOW. LOOK AT MOCK UP FOR MORE INFO. -->
<!--<div class="links"><a href="admin.php">Admin</a> | <a href="help.php">Help</a></div>-->
<div class="clear"></div>
</div>

 