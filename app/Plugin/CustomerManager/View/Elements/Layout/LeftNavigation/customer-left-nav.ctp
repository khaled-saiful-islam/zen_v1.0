<ul class="nav nav-list well" id="goAjaxUlId">
  <li class="<?php echo $left_nav_selected == 'add_customer' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-plus icon-green'></i> Add retail customer", array(
        "controller" => "customers",
        "action" => ADD,
        "plugin" => "customer_manager"), array(
        "escape" => false,
    ));
    ?>
  </li>
  <li class="<?php echo $left_nav_selected == 'view_customer' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-list-alt icon-green'></i> View retail customers", array(
        "controller" => "customers",
        "action" => 'index',
        "plugin" => "customer_manager",
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