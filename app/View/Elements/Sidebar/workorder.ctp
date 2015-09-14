<ul class="verticle-left-menu">
		<li>
			<?php echo $this->Html->link('Work Orders', array('plugin' => 'work_order_manager','controller' => 'work_orders', 'action' => 'index',"sort" => "work_order_number","direction" => "asc"),array('data-controller' => 'work_orders', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'workorder'))?>
			<ul class="verticle-left-menu">
					<li><?php echo $this->Html->link('View Work Orders', array('plugin' => 'work_order_manager','controller' => 'work_orders', 'action' => 'index',"sort" => "work_order_number","direction" => "asc"), array('data-controller' => 'work_orders', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'workorder')) ?></li>
			</ul>
		</li>
		<li>
				<?php echo $this->Html->link('Book/Load Container', array('plugin' => 'container_manager','controller' => 'containers', 'action' => 'container_index',"sort" => "container_no","direction" => "asc"),array('data-controller' => 'containers', 'data-action' => 'container_index', 'data-pass' => '', 'data-top-menu' => 'workorder'))?>
			<ul>
				<li><?php echo $this->Html->link('Add Container', array('plugin' => 'container_manager','controller' => 'containers', 'action' => 'add'),array('data-controller' => 'containers', 'data-action' => 'add', 'data-pass' => '', 'data-top-menu' => 'workorder'))?></li>
				<li><?php echo $this->Html->link('View Containers', array('plugin' => 'container_manager','controller' => 'containers', 'action' => 'container_index',"sort" => "container_no","direction" => "asc"),array('data-controller' => 'containers', 'data-action' => 'container_index', 'data-pass' => '', 'data-top-menu' => 'workorder'))?></li>
			</ul>
		</li>
		<li>
				<?php echo $this->Html->link('Inventory Skids', array('plugin' => 'container_manager','controller' => 'skid_inventorys', 'action' => 'index',"sort" => "skid_no","direction" => "asc"),array('data-controller' => 'skid_inventorys', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'workorder'))?>
			<ul>
				<li><?php echo $this->Html->link('Add Skid', array('plugin' => 'container_manager','controller' => 'skid_inventorys', 'action' => 'add'),array('data-controller' => 'skid_inventorys', 'data-action' => 'add', 'data-pass' => '', 'data-top-menu' => 'workorder'))?></li>
				<li><?php echo $this->Html->link('View Skids', array('plugin' => 'container_manager','controller' => 'skid_inventorys', 'action' => 'index',"sort" => "skid_no","direction" => "asc"),array('data-controller' => 'skid_inventorys', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'workorder'))?></li>
			</ul>
		</li> 
</ul> 