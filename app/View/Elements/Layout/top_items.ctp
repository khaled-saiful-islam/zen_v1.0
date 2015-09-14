<div class="top_item">
  <span class="label label-info">Logic Inventory System &raquo;</span>
  &nbsp;
  <?php
	if($loginUser['permission_dashboard'] == 1){
  echo $this->Html->link('<i class="icon-home "></i>', array(
      "controller" => "dashboards",
      "action" => "index",
      "plugin" => "inventory"), array(
      'escape' => false,
      "rel" => 'tooltip',
      "title" => "Dashboard",
  ));
	}
  ?>
  &nbsp;
  <?php
  echo $this->Html->link('<i class="icon-user "></i>', array(
      "controller" => "users",
      "action" => DETAIL,
      "plugin" => "user_manager",$loginUser['id']
          ), array(
      'escape' => false,
      "rel" => 'tooltip',
      "title" => "My Profile",
  ));
  ?>
  &nbsp;
  <?php
//  echo $this->Html->link('<i class="icon-cog "></i>', array(
//      "controller" => "",
//      "action" => ""), array(
//      'escape' => false,
//      "rel" => 'tooltip',
//      "title" => "Settings",
//  ));
  ?>
  <?php
	if($loginUser['permission_schedule'] == 1){
  echo $this->Html->link('<i class="icon-calendar"></i>', array(
      "controller" => "appointments",
      "action" => "calendar",
      "plugin" => "schedule_manager"
      ), array(
      'escape' => false,
      "rel" => 'tooltip',
      "title" => "Calender",
  ));
	}
  ?>
  &nbsp;
  <?php
  echo $this->Html->link('<i class="icon-exclamation-sign "></i>', array(
      "controller" => "users",
      "action" => "logout",
      "plugin" => "user_manager"
          ), array(
      'escape' => false,
      "rel" => 'tooltip',
      "title" => "Logout",
  ));
  ?>
</div>
<div class="clear"></div>
<div class="top_item2">
  <div class="btn-group">
    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
      Logged in as <b><?php echo $loginUser['first_name']; ?></b>
      <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
      <li>
        <?php
        echo $this->Html->link('<i class="icon-home "></i> Dashboard', array(
            "controller" => "dashboards",
            "action" => "index",
            "plugin" => "inventory"), array(
            'escape' => false,
            "title" => "Dashboard",
        ));
        ?>
      </li>
      <li>
        <?php
        echo $this->Html->link('<i class="icon-user "></i> My Profile', array(
            "controller" => "users",
            "action" => "detail",
            "plugin" => "user_manager", $loginUser['id']
                ), array(
            'escape' => false,
            "title" => "My Profile",
        ));
        ?>
      </li>
      <!--<li>
        <a href='#'>
          <i class="icon-cog "></i> Settings
        </a>
      </li>-->
      <li>
        <?php
        echo $this->Html->link('<i class="icon-exclamation-sign "></i> Log Out', array(
            "controller" => "users",
            "action" => "logout",
            "plugin" => "user_manager"
                ), array(
            'escape' => false,
            "rel" => 'tooltip',
            "title" => "Logout",
        ));
        ?>


      </li>
    </ul>
  </div>    

</div>

