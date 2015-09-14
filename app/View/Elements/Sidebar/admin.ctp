<ul class="verticle-left-menu">
    <li>
        <?php echo $this->Html->link('User', array( 'controller' => 'users', 'action' => 'index', "sort" => "name", "direction" => "asc" ), array( 'data-controller' => 'users', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?>
        <ul class="verticle-left-menu">
            <li><?php echo $this->Html->link('Add User', array( 'plugin' => 'user_manager', 'controller' => 'users', 'action' => 'add' ), array( 'data-controller' => 'users', 'data-action' => 'add', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('View Users', array( 'plugin' => 'user_manager', 'controller' => 'users', 'action' => 'index', "sort" => "name", "direction" => "asc" ), array( 'data-controller' => 'users', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('User Data Setup', array( 'plugin' => 'inventory', 'controller' => 'inventory_lookups', 'action' => 'index', "User" ), array( 'data-controller' => 'inventory_lookups', 'data-action' => 'index', 'data-pass' => 'User', 'data-top-menu' => 'admin' )) ?></li>
        </ul>
    </li>
    <li><?php echo $this->Html->link('User Permission', array( 'controller' => 'users', 'action' => 'user_permission_index', "sort" => "name", "direction" => "asc" ), array( 'data-controller' => 'users', 'data-action' => 'user_permission_index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?></li>
    <li>
        <?php echo $this->Html->link('Invendory', array( 'controller' => 'items', 'action' => 'index', "sort" => "number", "direction" => "asc" ), array( 'data-controller' => 'items', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?>
        <ul class="verticle-left-menu">
            <li><?php echo $this->Html->link('Item/Item Department', array( 'plugin' => 'inventory', 'controller' => 'items', 'action' => 'index', "sort" => "number", "direction" => "asc" ), array( 'data-controller' => 'items', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('Drawer', array( 'plugin' => 'inventory', 'controller' => 'inventory_lookups', 'action' => 'index', "Drawer" ), array( 'data-controller' => 'inventory_lookups', 'data-action' => 'index', 'data-pass' => 'Drawer', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('Door', array( 'plugin' => 'inventory', 'controller' => 'doors', 'action' => 'index', "sort" => "door_style", "direction" => "asc" ), array( 'data-controller' => 'doors', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('Cabinet', array( 'plugin' => 'inventory', 'controller' => 'cabinets', 'action' => 'index', "sort" => "name", "direction" => "asc" ), array( 'data-controller' => 'cabinets', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('Color Setup', array( 'plugin' => 'inventory', 'controller' => 'colors', 'action' => 'index', "sort" => "name", "direction" => "asc" ), array( 'data-controller' => 'colors', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?></li>
        </ul>
    </li>
    <li>
        <?php echo $this->Html->link('Vendor', array( 'controller' => 'suppliers', 'action' => 'index', "sort" => "name", "direction" => "asc" ), array( 'data-controller' => 'suppliers', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?>
        <ul>
            <li><?php echo $this->Html->link('Add Vendor', array( 'plugin' => 'inventory', 'controller' => 'suppliers', 'action' => 'add' ), array( 'data-controller' => 'suppliers', 'data-action' => 'add', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('View Vendors', array( 'plugin' => 'inventory', 'controller' => 'suppliers', 'action' => 'index', "sort" => "name", "direction" => "asc" ), array( 'data-controller' => 'suppliers', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('Vendor Data Setup', array( 'plugin' => 'inventory', 'controller' => 'inventory_lookups', 'action' => 'index', "Supplier" ), array( 'data-controller' => 'inventory_lookups', 'data-action' => 'index', 'data-pass' => 'Supplier', 'data-top-menu' => 'admin' )) ?></li>
        </ul>
    </li> 
    <li>
        <?php echo $this->Html->link('Quote Reports Settings', array( 'plugin' => 'quote_manager', 'controller' => 'quote_reports_settings', 'action' => 'index', "sort" => "report_name", "direction" => "asc" ), array( 'data-controller' => 'quote_reports_settings', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?>
        <ul>
            <li><?php echo $this->Html->link('Quote Reports Setting', array( 'plugin' => 'quote_manager', 'controller' => 'quote_reports_settings', 'action' => 'index', "sort" => "report_name", "direction" => "asc" ), array( 'data-controller' => 'quote_reports_settings', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('Door/Drawer Width Setup', array( 'plugin' => 'inventory', 'controller' => 'inventory_lookups', 'action' => 'index', "Door_Drawer_Width" ), array( 'data-controller' => 'inventory_lookups', 'data-action' => 'index', 'data-pass' => 'Door_Drawer_Width', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('Door Height Setup', array( 'plugin' => 'inventory', 'controller' => 'inventory_lookups', 'action' => 'index', 'Door_Height' ), array( 'data-controller' => 'inventory_lookups', 'data-action' => 'index', 'data-pass' => 'Door_Height', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('Door Width Setup', array( 'plugin' => 'inventory', 'controller' => 'inventory_lookups', 'action' => 'index', 'Door_Width' ), array( 'data-controller' => 'inventory_lookups', 'data-action' => 'index', 'data-pass' => 'Door_Width', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('Drawer Height Setup', array( 'plugin' => 'inventory', 'controller' => 'inventory_lookups', 'action' => 'index', 'Drawer_Height' ), array( 'data-controller' => 'inventory_lookups', 'data-action' => 'index', 'data-pass' => 'Drawer_Height', 'data-top-menu' => 'admin' )) ?></li>
        </ul>
    </li>
    <li>
        <?php echo $this->Html->link('General Settings', array( 'plugin' => 'purchase_order_manager', 'controller' => 'purchase_orders', 'action' => 'general_setting_list' ), array( 'data-controller' => 'purchase_orders', 'data-action' => 'general_setting_list', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?>
        <ul>
            <li><?php echo $this->Html->link('General', array( 'plugin' => 'purchase_order_manager', 'controller' => 'purchase_orders', 'action' => 'general_setting_list' ), array( 'data-controller' => 'purchase_orders', 'data-action' => 'general_setting_list', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('Location', array( 'plugin' => 'purchase_order_manager', 'controller' => 'purchase_orders', 'action' => 'location_list', 'location' ), array( 'data-controller' => 'purchase_orders', 'data-action' => 'location_list', 'data-pass' => 'location', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('Production Time', array( 'plugin' => 'purchase_order_manager', 'controller' => 'purchase_orders', 'action' => 'production_time_list', 'production_time' ), array( 'data-controller' => 'purchase_orders', 'data-action' => 'production_time_list', 'data-pass' => 'production_time', 'data-top-menu' => 'admin' )) ?></li>
        </ul>
    </li>
</ul> 