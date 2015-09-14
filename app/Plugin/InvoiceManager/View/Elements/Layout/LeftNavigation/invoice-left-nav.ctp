<ul class="nav nav-list well" id="goAjaxUlId">
  <li class="<?php echo $left_nav_selected == 'add_invoice' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-plus icon-green'></i> Add Invoice", array(
        "controller" => "invoices",
        "action" => ADD,
        "plugin" => "invoice_manager",h($type)
        ), array(
        "escape" => false,
    ));
    ?>            
  </li>
  <li class="<?php echo $left_nav_selected == 'view_invoice' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-list-alt icon-green'></i> View Invoice", array(
        "controller" => "invoices",
        "action" => 'index',
        "plugin" => "invoice_manager",h($type),
        "sort" => "invoice_no",
        "direction" => "asc"), array(
        "escape" => false
    ));
    ?>
  </li>	
</ul>

<script>  
  $("#goAjaxUlId li").ajaxLeftNav("#MainContent");
</script>