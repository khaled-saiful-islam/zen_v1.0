<ul class="nav nav-list well" id="goAjaxUlId">
  <li class="<?php echo $left_nav_selected == 'add_location' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-plus icon-green'></i> List location", array(
        "controller" => "purchase_orders",
        "action" => "location_list",
        "plugin" => "purchase_order_manager", null, 'location'), array(
        "escape" => false,
    ));
    ?>
  </li>
	<li class="<?php echo $left_nav_selected == 'list_general' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-plus icon-green'></i> List General Setting", array(
        "controller" => "purchase_orders",
        "action" => "general_setting_list",
        "plugin" => "purchase_order_manager"), array(
        "escape" => false,
    ));
    ?>
  </li>
</ul>

<script>
  $("#goAjaxUlId li").ajaxLeftNav("#MainContent");
</script>