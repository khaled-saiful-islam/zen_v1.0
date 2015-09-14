<ul class="verticle-left-menu">
    <li>
        <?php echo $this->Html->link('Item/Item Department', array( 'controller' => 'items', 'action' => 'index', "sort" => "number", "direction" => "asc" ), array( 'data-controller' => 'items', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?>
        <ul class="verticle-left-menu">
            <li><?php echo $this->Html->link('Add Item', array( 'controller' => 'items', 'action' => 'add' ), array( 'data-controller' => 'items', 'data-action' => 'add', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('View Item', array( 'controller' => 'items', 'action' => 'index', "sort" => "number", "direction" => "asc" ), array( 'data-controller' => 'items', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('Item Department', array( 'controller' => 'item_departments', 'action' => 'index', "sort" => "name", "direction" => "asc" ), array( 'data-controller' => 'item_departments', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php //echo $this->Html->link('Item Material Setup', array( 'controller' => 'material_groups', 'action' => 'index' ), array( 'data-controller' => 'material_groups', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?></li>
        </ul>
    </li>
    <li>
        <?php echo $this->Html->link('Item Material Setup', array( 'controller' => 'material_groups', 'action' => 'index' ), array( 'data-controller' => 'material_groups', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?>
        <ul class="verticle-left-menu">
            <li><?php echo $this->Html->link('Add Material', array( 'controller' => 'materials', 'action' => 'add' ), array( 'data-controller' => 'materials', 'data-action' => 'add', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('View Material', array( 'controller' => 'materials', 'action' => 'index', "sort" => "number", "direction" => "asc" ), array( 'data-controller' => 'materials', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('Add Material Group', array( 'controller' => 'material_groups', 'action' => 'add' ), array( 'data-controller' => 'material_groups', 'data-action' => 'add', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('View Material Group', array( 'controller' => 'material_groups', 'action' => 'index', "sort" => "number", "direction" => "asc" ), array( 'data-controller' => 'material_groups', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?></li>
        </ul>
    </li>
    <li>
        <?php echo $this->Html->link('Drawer', array( 'controller' => 'inventory_lookups', 'action' => 'index', "Drawer" ), array( 'data-controller' => 'inventory_lookups', 'data-action' => 'index', 'data-pass' => 'Drawer', 'data-top-menu' => 'admin' )) ?>
    </li>
    <li>
        <?php echo $this->Html->link('Door', array( 'controller' => 'doors', 'action' => 'index', "sort" => "door_style", "direction" => "asc" ), array( 'data-controller' => 'doors', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?>
        <ul>
            <li><?php echo $this->Html->link('Add Door', array( 'controller' => 'doors', 'action' => 'add' ), array( 'data-controller' => 'doors', 'data-action' => 'add', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('View Doors', array( 'controller' => 'doors', 'action' => 'index', "sort" => "door_style", "direction" => "asc" ), array( 'data-controller' => 'doors', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('Door Data Setup', array( 'controller' => 'inventory_lookups', 'action' => 'index', "Door" ), array( 'data-controller' => 'inventory_lookups', 'data-action' => 'index', 'data-pass' => 'Door', 'data-top-menu' => 'admin' )) ?></li>
        </ul>
    </li> 
    <li>
        <?php echo $this->Html->link('Cabinet', array( 'controller' => 'cabinets', 'action' => 'index', "sort" => "name", "direction" => "asc" ), array( 'data-controller' => 'cabinets', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?>
        <ul>
            <li><?php echo $this->Html->link('View Cabinets', array( 'controller' => 'cabinets', 'action' => 'index', "sort" => "name", "direction" => "asc" ), array( 'data-controller' => 'cabinets', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('Add Cabinet', array( 'controller' => 'cabinets', 'action' => 'add' ), array( 'data-controller' => 'cabinets', 'data-action' => 'add', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('Cabinet Data Setup', array( 'controller' => 'inventory_lookups', 'action' => 'index', 'Cabinet' ), array( 'data-controller' => 'inventory_lookups', 'data-action' => 'index', 'data-pass' => 'Cabinet', 'data-top-menu' => 'admin' )) ?></li>
            <li><?php echo $this->Html->link('Installation Task', array( 'controller' => 'inventory_lookups', 'action' => 'index', 'Installation' ), array( 'data-controller' => 'inventory_lookups', 'data-action' => 'index', 'data-pass' => 'Installation', 'data-top-menu' => 'admin' )) ?></li>
        </ul>
    </li>
    <li>
        <?php echo $this->Html->link('Color Setup', array( 'controller' => 'colors', 'action' => 'index', "sort" => "name", "direction" => "asc" ), array( 'data-controller' => 'colors', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?>
    </li>
    <li>
        <?php echo $this->Html->link('Builder Price Setup', array( 'plugin' => 'inventory', 'controller' => 'items', 'action' => 'builder_price' ), array( 'data-controller' => 'items', 'data-action' => 'builder_price', 'data-pass' => '', 'data-top-menu' => 'admin' )) ?>
    </li>
</ul> 