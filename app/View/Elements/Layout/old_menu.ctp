<ul class="sf-menu">
    <li style="width:221px !important;">
        <?php echo $this->Html->link("Dashboard", array("controller" => "", "action" => ""), array("style" => "padding: 0.75em 5em")); ?>
    </li>
    <li> 
        <?php echo $this->Html->link("Customer", array("controller" => "customers", "action" => "action")); ?>
        <ul>
            <li> <?php echo $this->Html->link("Customer List", array("controller" => "customers", "action" => "action")); ?></li>
            <li><?php echo $this->Html->link("Add New", array("controller" => "customers", "action" => "action", ADD)); ?></li>
        </ul>
    </li>
</ul>
<ul class="sf-menu ">
    <li class="" > <a class="sf-with-ul" href="#" >Sales </a>
<ul>
        <li ><a href="#">New Quote </a></li>
        <li><a href="#">List Quote</a></li>
        <li ><a href="#">List Work Order</a></li>
        <li class="last"><a href="#">Report</a></li>
</ul>
</li>

</ul>

<ul class="sf-menu ">
<li class="" > <a class="sf-with-ul" href="index.php?id=3" >Production </a>
<ul>
        <li ><a href="#">Pending Measurement </a></li>
        <li><a href="#">Measurement</a></li>
        <li ><a href="#">Pending production</a></li>
        <li ><a href="#">Production</a></li>
        <li ><a href="#">Completed</a></li>
        <li ><a href="#">Reports</a></li>
        <li ><a href="#">no Activity</a></li>
        <li ><a href="#">Find</a></li>
</ul>
</li>

</ul>

<ul class="sf-menu">
<li class=""> <a class="sf-with-ul" href="#" >Purchasing </a>
<ul>
        <li class="first"><a href="#">New PO </a></li>
        <li><a href="#">Pending PO</a></li>
        <li ><a href="#">Received PO</a></li>
        <li ><a href="#">Inventory Setup</a></li>
        <li><a href="#">Find</a></li>
        <li ><a href="#">Reports</a></li>
</ul>
</li>

</ul>

<ul class="sf-menu">
<li class=""> <a class="sf-with-ul" href="#" >Scheduling </a>
<ul>
        <li class="first"><a href="#">Calendar </a></li>
        <li><a href="#">Measurement</a></li>
        <li ><a href="#">Production Type</a></li>
        <li ><a href="#">Services</a></li>
        <li ><a href="#">By Installer</a></li>
        <li ><a href="#">Find</a></li>
</ul>
</li>

</ul>
<ul class="sf-menu">
<li class=""> <a class="sf-with-ul" href="#" >Reports </a>
<ul>
        <li><a href="#">Reports by Module </a></li>

</ul>
</li>

</ul>
<ul  class="sf-menu ">
<li> <a class="sf-with-ul" href="#" >Accounting </a>
<ul>
        <li ><a href="#">Accounting Approvals </a></li>
        <li><a href="#">Customer Credit</a></li>
        <li ><?php echo $this->Html->link("Vendor Setup", array("controller" => "vendors", "action" => "action")); ?></li>
        <li ><a href="#">Inventory Setup</a></li>
        <li ><a href="#">Reports </a> </li>
        <li ><a href="#">vendor Setup</a></li>
        <li ><a href="#">Deposit Received</a></li>
        <li><a href="#">Payments</a></li>
        <li><a href="#">Employee Time-sheet</a></li>
</ul>
</li>

</ul>

<ul  class="sf-menu">
<li class="" > <a class="sf-with-ul" href="#" >Setting </a>
<ul>
        <li class="first"><a href="#">Setup Functions </a></li>
        <li><a href="#">Reporting Functions</a></li>
        <li><a href="#">User Setting</a></li>
        <li><a href="/zenLiving/employees">Employee Module</a></li>
        <li class="last"><a href="#">Report Modifications</a></li>
</ul>
</li>

</ul>
<ul  class="sf-menu">
<li class="" > <a class="sf-with-ul" href="#" >Help </a>

</li>

