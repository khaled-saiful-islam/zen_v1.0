<ul class="nav nav-list well" id="goAjaxUlId">
  <li class="<?php echo $left_nav_selected == 'add_service' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-plus icon-green'></i> Add Service", array(
        "controller" => "service_entries",
        "action" => ADD,
        "plugin" => "schedule_manager"), array(
        "escape" => false,
    ));
    ?>
  </li>
  <li class="<?php echo $left_nav_selected == 'view_service_entry' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-list-alt icon-green'></i> View Services", array(
        "controller" => "service_entries",
        "action" => 'index',
        "plugin" => "schedule_manager",                    
        "sort" => "work_order_id",
        "direction" => "asc"
            ), array(
        "escape" => false
    ));
    ?>
    <br/>
  </li>
  <li class="appointment-cls <?php echo $left_nav_selected == 'view_appointment' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-list-alt icon-green'></i> Schedule", array(
        "controller" => "appointments",
        "action" => 'index',
        "plugin" => "schedule_manager",
            ), array(
        "escape" => false
    ));
    ?>
    <br/>
  </li>
  <li class="<?php echo $left_nav_selected == 'add_installers' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-plus icon-green'></i> Add Installer", array(
        "controller" => "installers",
        "action" => ADD,
        "plugin" => "schedule_manager"), array(
        "escape" => false,
    ));
    ?>
  </li>
  <li class="<?php echo $left_nav_selected == 'view_installers' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-list-alt icon-green'></i> View Installer", array(
        "controller" => "installers",
        "action" => 'index',
        "plugin" => "schedule_manager",                    
        //"sort" => "work_order_id",
        //"direction" => "asc"
            ), array(
        "escape" => false
    ));
    ?><br/>
  </li>
  <li class="<?php echo $left_nav_selected == 'add_installer_schedule' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-plus icon-green'></i> Add Schedule Installer", array(
        "controller" => "installer_schedules",
        "action" => ADD,
        "plugin" => "schedule_manager"), array(
        "escape" => false,
    ));
    ?>
  </li>
  <li class="<?php echo $left_nav_selected == 'view_installer_schedule' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-list-alt icon-green'></i> View Schedule Installer", array(
        "controller" => "installer_schedules",
        "action" => 'index',
        "plugin" => "schedule_manager",                    
        //"sort" => "work_order_id",
        //"direction" => "asc"
            ), array(
        "escape" => false
    ));
    ?><br/>
  </li>
	<li class="<?php echo $left_nav_selected == 'view_color_change' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-list-alt icon-green'></i> Schedule Color Setup", array(
        "controller" => "appointments",
        "action" => 'view_color',
        "plugin" => "schedule_manager"
            ), array(
        "escape" => false
    ));
    ?>
  </li>
</ul>

<script>
  
  $("#goAjaxUlId li").ajaxLeftNav("#MainContent");
  
</script>
