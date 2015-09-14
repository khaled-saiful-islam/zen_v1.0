<ul class="verticle-left-menu">
    <li>
        <?php echo $this->Html->link('Service', array( 'controller' => 'service_entries', 'action' => 'index', "sort" => "work_order_id", "direction" => "asc" ), array( 'data-controller' => 'service_entries', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'schedule' )) ?>
        <ul class="verticle-left-menu">
            <li><?php echo $this->Html->link('Add Service', array( 'plugin' => 'schedule_manager', 'controller' => 'service_entries', 'action' => 'add' ), array( 'data-controller' => 'service_entries', 'data-action' => 'add', 'data-pass' => '', 'data-top-menu' => 'schedule' )) ?></li>
            <li><?php echo $this->Html->link('View Services', array( 'plugin' => 'schedule_manager', 'controller' => 'service_entries', 'action' => 'index', "sort" => "work_order_id", "direction" => "asc" ), array( 'data-controller' => 'service_entries', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'schedule' )) ?></li>
        </ul>
    </li>
    <li>
        <?php echo $this->Html->link('Schedule', array( 'plugin' => 'schedule_manager', 'controller' => 'appointments', 'action' => 'index' ), array( 'data-controller' => 'appointments', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'schedule' )) ?>
    </li>
    <li>
        <?php echo $this->Html->link('Installer', array( 'plugin' => 'schedule_manager', 'controller' => 'installers', 'action' => 'index', "sort" => "name_lookup_id", "direction" => "asc" ), array( 'data-controller' => 'installers', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'schedule' )) ?>
        <ul>
            <li><?php echo $this->Html->link('Add Installer', array( 'plugin' => 'schedule_manager', 'controller' => 'installers', 'action' => 'add' ), array( 'data-controller' => 'installers', 'data-action' => 'add', 'data-pass' => '', 'data-top-menu' => 'schedule' )) ?></li>
            <li><?php echo $this->Html->link('View Installers', array( 'plugin' => 'schedule_manager', 'controller' => 'installers', 'action' => 'index', "sort" => "name", "direction" => "asc" ), array( 'data-controller' => 'installers', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'schedule' )) ?></li>
        </ul>
    </li> 
    <li>
        <?php echo $this->Html->link('Schedule Installer', array( 'plugin' => 'schedule_manager', 'controller' => 'installer_schedules', 'action' => 'index' ), array( 'data-controller' => 'installer_schedules', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'schedule' )) ?>
        <ul>
            <li><?php echo $this->Html->link('Add Schedule Installer', array( 'plugin' => 'schedule_manager', 'controller' => 'installer_schedules', 'action' => 'add' ), array( 'data-controller' => 'installer_schedules', 'data-action' => 'add', 'data-pass' => '', 'data-top-menu' => 'schedule' )) ?></li>
            <li><?php echo $this->Html->link('View Schedule Installer', array( 'plugin' => 'schedule_manager', 'controller' => 'installer_schedules', 'action' => 'index' ), array( 'data-controller' => 'installer_schedules', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'schedule' )) ?></li>
        </ul>
    </li>
    <li>
        <?php echo $this->Html->link('Schedule Color Setup', array( 'plugin' => 'schedule_manager', 'controller' => 'appointments', 'action' => 'view_color' ), array( 'data-controller' => 'appointments', 'data-action' => 'view_color', 'data-pass' => '', 'data-top-menu' => 'schedule' )) ?>
    </li>
</ul> 