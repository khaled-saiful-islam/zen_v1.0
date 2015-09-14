<ul class="nav nav-list well" id="goAjaxUlId">  
  <li class="<?php echo $left_nav_selected == 'add_skid' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-plus icon-green'></i>Add Skid Inventory", array(
        "controller" => "skid_inventorys",
        "action" => "add",
        "plugin" => "container_manager"), array(
        "escape" => false
    ));
    ?>            
  </li>
  <li class="<?php echo $left_nav_selected == 'view_skid' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-list-alt icon-green'></i>View Skid Inventories", array(
        "controller" => "skid_inventorys",
        "action" => 'index',
        "plugin" => "container_manager",
        "sort" => "skid_no",
        "direction" => "desc"), array(
        "escape" => false
    ));
    ?>            
  </li>	
</ul>

<script>  
  //$("#goAjaxUlId li").ajaxLeftNav("#MainContent");
</script>