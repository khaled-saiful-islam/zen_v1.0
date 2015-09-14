<ul class="nav nav-list well" id="goAjaxUlId">  
  <li class="<?php echo $left_nav_selected == 'add_load_container' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-plus icon-green'></i>Add Container", array(
        "controller" => "containers",
        "action" => "add",
        "plugin" => "container_manager"), array(
        "escape" => false
    ));
    ?>            
  </li>
  <li class="<?php echo $left_nav_selected == 'view_load_container' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-list-alt icon-green'></i>View Containers", array(
        "controller" => "containers",
        "action" => 'container_index',
        "plugin" => "container_manager",
        "sort" => "container_no",
        "direction" => "desc"), array(
        "escape" => false
    ));
    ?>            
  </li>	
</ul>

<script>  
  //$("#goAjaxUlId li").ajaxLeftNav("#MainContent");
</script>