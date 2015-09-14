<div class="top_item">
    <div class="top_title">Logic Inventory System &raquo;</div>
    |
    <div>
        <?php echo $this->Html->link("Home", array("controller" => "", "action" =>"")); ?>
    </div>
    |
    <div>
        <?php echo $this->Html->link("My Profile", array("controller" => "", "action" =>"")); ?>
    </div>
    |
    <div>
        <?php echo $this->Html->link("Logout", array("controller" => "users", "action" =>"logout")); ?>
    </div>
</div>
<div class="clear"></div>
<div class="top_item2">Logged in as: <?php echo $loginUser['first_name']; ?></div>
