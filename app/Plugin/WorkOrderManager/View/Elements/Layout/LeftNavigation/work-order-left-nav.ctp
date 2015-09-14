<ul class="nav nav-list well" id="goAjaxUlId">  
<!--  <li class="<?php echo $left_nav_selected == 'add_work_order' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-list-alt icon-green'></i> Add Work Orders", array(
        "controller" => "work_orders",
        "action" => ADD,
        "plugin" => "work_order_manager"), array(
        "escape" => false
    ));
    ?>            
  </li>-->
  <li class="<?php echo $left_nav_selected == 'view_work_order' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-list-alt icon-green'></i> View Work Orders", array(
        "controller" => "work_orders",
        "action" => 'index',
        "plugin" => "work_order_manager",
        "sort" => "work_order_number",
        "direction" => "desc"), array(
        "escape" => false
    ));
    ?>            
  </li>	
</ul>

<script>  
  //$("#goAjaxUlId li").ajaxLeftNav("#MainContent");
</script>