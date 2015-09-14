<ul class="verticle-left-menu">
		<li>
			<?php echo $this->Html->link('Retail Customer', array('plugin' => 'customer_manager','controller' => 'customers', 'action' => 'index',"sort" => "name","direction" => "asc"),array('data-controller' => 'customers', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'customer'))?>
			<ul class="verticle-left-menu">
					<li><?php echo $this->Html->link('Add Retail Customer', array('plugin' => 'customer_manager','controller' => 'customers', 'action' => 'add'), array('data-controller' => 'customers', 'data-action' => 'add', 'data-pass' => '', 'data-top-menu' => 'customer')) ?></li>
					<li><?php echo $this->Html->link('View Retail Customers', array('plugin' => 'customer_manager','controller' => 'customers', 'action' => 'index',"sort" => "name","direction" => "asc"), array('data-controller' => 'customers', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'customer')) ?></li>
			</ul>
		</li>
		<li>
			<?php echo $this->Html->link('Builder', array('plugin' => 'customer_manager','controller' => 'builders', 'action' => 'index',"sort" => "name","direction" => "asc"),array('data-controller' => 'builders', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'customer'))?>
			<ul class="verticle-left-menu">
					<li><?php echo $this->Html->link('Add Retail Customer', array('plugin' => 'customer_manager','controller' => 'builders', 'action' => 'add'), array('data-controller' => 'builders', 'data-action' => 'add', 'data-pass' => '', 'data-top-menu' => 'customer')) ?></li>
					<li><?php echo $this->Html->link('View Retail Customers', array('plugin' => 'customer_manager','controller' => 'builders', 'action' => 'index',"sort" => "name","direction" => "asc"), array('data-controller' => 'builders', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'customer')) ?></li>
					<li><?php echo $this->Html->link('View Projects', array('plugin' => 'customer_manager','controller' => 'builder_projects', 'action' => 'index'), array('data-controller' => 'builder_projects', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'customer')) ?></li>
			</ul>
		</li>
		<li>
			<?php echo $this->Html->link('Customer Data Setup', array('plugin' => 'inventory','controller' => 'inventory_lookups', 'action' => 'index',"Customer"),array('data-controller' => 'inventory_lookups', 'data-action' => 'index', 'data-pass' => 'Customer', 'data-top-menu' => 'customer'))?>
		</li> 
</ul> 