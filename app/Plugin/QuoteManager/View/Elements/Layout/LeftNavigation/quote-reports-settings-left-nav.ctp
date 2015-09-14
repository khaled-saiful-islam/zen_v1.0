<ul class="nav nav-list well" id="goAjaxUlId">
<!--  <li class="<?php echo $left_nav_selected == 'add_quote-reports-settings' ? "active " : "" ?>">
  <?php
  echo $this->Html->link("<i class='icon-plus icon-green'></i> Add quote report setting", array(
      "controller" => "quote_reports_settings",
      "action" => ADD,
      "plugin" => "quote_manager"), array(
      "escape" => false,
  ));
  ?>
  </li>-->
  <li class="<?php echo $left_nav_selected == 'view_quote-reports-settings' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-list-alt icon-green'></i> View quotes reports settings", array(
        "controller" => "quote_reports_settings",
        "action" => 'index',
        "plugin" => "quote_manager",
        "sort" => "report_name",
        "direction" => "asc",), array(
        "escape" => false
    ));
    ?>
  </li>
<!--  <li class="<?php echo $left_nav_selected == 'report_quote' ? "active " : "" ?>">
  <?php
  echo $this->Html->link("<i class='icon-file icon-white'></i> Report", array(
      "controller" => "quotes",
      "action" => "reports",
      "plugin" => "quote_manager"), array(
      "escape" => false
  ));
  ?>
  </li>-->
</ul>

<script>
  $("#goAjaxUlId li").ajaxLeftNav("#MainContent");
</script>