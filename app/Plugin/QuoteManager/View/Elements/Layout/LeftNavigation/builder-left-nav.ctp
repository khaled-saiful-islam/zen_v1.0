<ul class="nav nav-list well" id="goAjaxUlId">
  <li class="<?php echo $left_nav_selected == 'add_builder' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-plus icon-green'></i> Add builder", array(
        "controller" => "builders",
        "action" => ADD,
        "plugin" => "quote_manager"), array(
        "escape" => false,
    ));
    ?>            
  </li>
  <li class="<?php echo $left_nav_selected == 'view_builder' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-list-alt icon-green'></i> View builders", array(
        "controller" => "builders",
        "action" => 'index',
        "plugin" => "quote_manager"), array(
        "escape" => false
    ));
    ?>            
  </li>
</ul>

<script>  
  $("#goAjaxUlId li").ajaxLeftNav("#MainContent");
</script>