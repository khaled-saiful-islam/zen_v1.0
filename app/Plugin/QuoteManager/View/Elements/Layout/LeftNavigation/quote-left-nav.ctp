<ul class="nav nav-list well" id="goAjaxUlId">
  <li class="<?php echo $left_nav_selected == 'add_quote' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-plus icon-green'></i> Add quote", array(
        "controller" => "quotes",
        "action" => ADD,
        "plugin" => "quote_manager"), array(
        "escape" => false,
    ));
    ?>
  </li>
  <li class="<?php echo $left_nav_selected == 'view_quote' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-list-alt icon-green'></i> View quotes", array(
        "controller" => "quotes",
        "action" => 'index',
        "plugin" => "quote_manager",
        "sort" => "quote_number",
        "direction" => "desc",), array(
        "escape" => false
    ));
    ?>
  </li>
	<li class="<?php echo $left_nav_selected == 'view_delete_quote' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-list-alt icon-green'></i> View deleted quotes", array(
        "controller" => "quotes",
        "action" => 'deleted_quote',
        "plugin" => "quote_manager",
        "sort" => "quote_number",
        "direction" => "desc",), array(
        "escape" => false
    ));
    ?>
  </li>
  <li class="<?php echo $left_nav_selected == 'report_quote' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-file icon-white'></i> Report", array(
        "controller" => "quotes",
        "action" => "reports",
        "plugin" => "quote_manager"), array(
        "escape" => false
    ));
    ?>
  </li>
</ul>

<script>
  $("#goAjaxUlId li").ajaxLeftNav("#MainContent");
</script>