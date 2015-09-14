<ul class="nav nav-list well" id="goAjaxUlId">
  <li class="<?php echo $left_nav_selected == 'add_color' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-plus icon-green'></i> Add color", array(
        "controller" => "colors",
        "action" => ADD,
        "plugin" => "inventory"), array(
        "escape" => false,
    ));
    ?>
  </li>
  <li class="<?php echo $left_nav_selected == 'view_color' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-list-alt icon-green'></i> View colors", array(
        "controller" => "colors",
        "action" => 'index',
        "plugin" => "inventory",
        "sort" => "name",
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