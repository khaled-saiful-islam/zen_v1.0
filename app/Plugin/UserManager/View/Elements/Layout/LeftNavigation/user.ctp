<ul class="nav nav-list well" id="goAjaxUlId">
  <li class="<?php echo $left_nav_selected == 'add_user' ? "active leftnavSelectedItem" : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-plus icon-green'></i> Add User", array(
        "controller" => "users",
        "action" => ADD,
        "plugin" => "user_manager",
            ), array(
        "escape" => false,
    ));
    ?>            
  </li>
  <li class="<?php echo $left_nav_selected == 'view_users' ? "active leftnavSelectedItem" : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-list-alt icon-green'></i> View Users", array(
        "controller" => "users",
        "action" => "index",
        "plugin" => "user_manager",
            ), array(
        "escape" => false
    ));
    ?>            
  </li>
  <li class="<?php echo $left_nav_selected == 'my_profile' ? "active leftnavSelectedItem" : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-list-alt icon-green'></i> My Profile", array(
        "controller" => "users",
        "action" => "detail",
        "plugin" => "user_manager",$loginUser['id']
            ), array(
        "escape" => false
    ));
    ?>            
  </li>
</ul>

<script>
  $("#goAjaxUlId li").ajaxLeftNav("#MainContent")
</script>