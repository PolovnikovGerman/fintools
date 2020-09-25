<div class="header_default">
 <div style="float:left;">
     <img src="../images/page_newlogo.png" id="logo"/>
 </div>
 <?php if($_SESSION['uid'] == 1 || $_SESSION['uid'] ==2 || $_SESSION['uid'] == 9) { ?>
 <div class="development"><a href="devControl.php">dev</a></div>
<?php } else { ?>
 <div class="development" style="padding:0; border:none;"></div>
 <?php } ?>
 
 <div class="menu">
 <ul id="sddm">
    <li><a href="#" 
        onmouseover="mopen('m1')" 
        onmouseout="mclosetime()">Database</a>
        <div id="m1" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">
            <a href="brandItems.php">Items</a>
       <!-- <a href="items_list.php">Items</a>-->
      <!--  <a href="#">Customers</a>-->
        <a href="vendor_list.php">Vendors</a>
<!--        <a href="#">Other</a>-->
        </div>
    </li>
    <li><a href="art.php" 
        onmouseover="mopen('m2')" 
        onmouseout="mclosetime()">Art</a>
        <!--<div id="m2" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">
        <a href="#">Web Reports</a>
        <a href="#">Competitors</a>
        </div>-->
    </li>
    <li><a href="fullfillment.php" 
        onmouseover="mopen('m3')" 
        onmouseout="mclosetime()">Fullfillment</a>
        <div id="m3" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">
        <a href="ff_items.php">FF Items</a>
        <a href="ff_vendors.php">FF Vendors</a>

        </div>
    </li>
    
    
    
    <li><a href="#" 
        onmouseover="mopen('m7')" 
        onmouseout="mclosetime()">Finance</a>
        <div id="m7" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">
        <a href="revenue.php">Revenue</a>
        <a href="reportOrders.php">Profit</a>
        </div>
    </li>
    <li><a href="leads.php" 
        onmouseover="mopen('m4')" 
        onmouseout="mclosetime()">Leads</a>
<!--        <div id="m4" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">
        <a href="#">Finance</a>
        <a href="#">Accounting</a>
        </div>-->
    </li>
    <li><a href="#" 
        onmouseover="mopen('m5')" 
        onmouseout="mclosetime()">Tasks</a>
<!--        <div id="m5" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">
        <a href="art.php">Art</a>
         <a href="fullfillment.php">Fulfillment</a>
          <a href="ff_items.php">FF Items</a>
         <a href="ff_vendors.php">FF Vendors</a>       
        <a href="#">Vendor Ticks</a>
        </div>-->
    </li>
    <!--<li><a href="#" 
        onmouseover="mopen('m6')" 
        onmouseout="mclosetime()">Others</a>
        <div id="m6" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">
        <a href="task.php">Tasks</a>
        <a href="#">Admin</a>
        </div>
    </li>-->
    
    
    
    
</ul>
</div>





<div class="user_logout" >
<?php echo "<span style=\"color:#0000ff;\">".date("M d D")."</span>"; ?>&nbsp;&nbsp;&nbsp;
<span id="clock">&nbsp;</span> 


<BR>

&nbsp;<?php echo $_SESSION['screenname']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
[&nbsp;<a href="logout.php">Logout</a>&nbsp;]
</div>

</div>

 