<ul class="nav nav-list well" id="goAjaxUlId">
  <li class="<?php echo $left_nav_selected == 'add_purchase_order' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-plus icon-green'></i> Add Purchase Order", array(
        "controller" => "purchase_orders",
        "action" => ADD,
        "plugin" => "purchase_order_manager"
        ), array(
        "escape" => false,
    ));
    ?>            
  </li>
  <li class="<?php echo $left_nav_selected == 'view_purchase_order' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-list-alt icon-green'></i> View Purchase Orders", array(
        "controller" => "purchase_orders",
        "action" => 'index',
        "plugin" => "purchase_order_manager",
        "sort" => "purchase_order_num",
        "direction" => "desc"), array(
        "escape" => false
    ));
    ?>
    <br/>
  </li>
<!--	<li class="<?php echo $left_nav_selected == 'view_purchase_receive' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-plus icon-green'></i> Purchase Receive", array(
        "controller" => "purchase_orders",
        "action" => 'received',
        "plugin" => "purchase_order_manager"), array(
        "escape" => false
    ));
    ?>            
  </li>-->
	<li class="<?php echo $left_nav_selected == 'view_purchase_receive_all' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-list-alt icon-green'></i> View Purchase Receive", array(
        "controller" => "purchase_orders",
        "action" => 'received_view',
        "plugin" => "purchase_order_manager",
        "sort" => "purchase_order_num",
        "direction" => "desc"), array(
        "escape" => false
    ));
    ?>            
  </li>
  <!--<li class="<?php echo $left_nav_selected == 'view_reports' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-file icon-green'></i> Reports", array(
        "controller" => "purchase_orders",
        "action" => 'reports',
        "plugin" => "purchase_order_manager",
        "sort" => "purchase_order_num",
        "direction" => "asc"), array(
        "escape" => false
    ));
    ?>            
  </li>-->
</ul>

<script>  
  $("#goAjaxUlId li").ajaxLeftNav("#MainContent");
</script>