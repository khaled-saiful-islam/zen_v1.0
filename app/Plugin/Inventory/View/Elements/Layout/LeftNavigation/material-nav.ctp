<ul class="nav nav-list well" id="goAjaxUlId">
  <li class="<?php echo $left_nav_selected == 'add_material' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-plus icon-green'></i> Add Material", array(
        "controller" => "materials",
        "action" => ADD,
        "plugin" => "inventory"), array(
        "escape" => false,
    ));
    ?>
  </li>
  <li class="<?php echo $left_nav_selected == 'view_material' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-list-alt icon-green'></i> View Materials", array(
        "controller" => "materials",
        "action" => 'index',
        "plugin" => "inventory"
            ), array(
        "escape" => false
    ));
    ?>
  </li>
</ul>

<script>
  //$("#goAjaxUlId li").ajaxLeftNav("#MainContent");
</script>