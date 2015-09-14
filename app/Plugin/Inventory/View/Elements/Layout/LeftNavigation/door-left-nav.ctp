<ul class="nav nav-list well" id="goAjaxUlId">
  <li class="<?php echo $left_nav_selected == 'add_door' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-plus icon-green'></i> Add door", array(
        "controller" => "doors",
        "action" => ADD,
        "plugin" => "inventory"), array(
        "escape" => false,
    ));
    ?>
  </li>
  <li class="<?php echo $left_nav_selected == 'view_door' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-list-alt icon-green'></i> View doors", array(
        "controller" => "doors",
        "action" => 'index',
        "plugin" => "inventory",
        "sort" => "door_style",
        "direction" => "asc",
            ), array(
        "escape" => false
    ));
    ?>
  </li>
</ul>

<script>
  //$("#goAjaxUlId li").ajaxLeftNav("#MainContent");
</script>