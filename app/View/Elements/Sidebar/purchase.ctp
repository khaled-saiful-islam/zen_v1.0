<ul class="verticle-left-menu">
		<li>
			<?php echo $this->Html->link('Purchase Order', array('plugin' => 'purchase_order_manager','controller' => 'purchase_orders', 'action' => 'index',"sort" => "purchase_order_num","direction" => "asc"),array('data-controller' => 'purchase_orders', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'purchase'))?>
			<ul class="verticle-left-menu">
					<li><?php echo $this->Html->link('Add Purchase Order', array('plugin' => 'purchase_order_manager','controller' => 'purchase_orders', 'action' => 'add'), array('data-controller' => 'purchase_orders', 'data-action' => 'add', 'data-pass' => '', 'data-top-menu' => 'purchase')) ?></li>
					<li><?php echo $this->Html->link('View Purchase Orders', array('plugin' => 'purchase_order_manager','controller' => 'purchase_orders', 'action' => 'index',"sort" => "purchase_order_num","direction" => "asc"), array('data-controller' => 'purchase_orders', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'purchase')) ?></li>
			</ul>
		</li>
		<li>
				<?php echo $this->Html->link('Purchase Receive', array('plugin' => 'purchase_order_manager','controller' => 'purchase_orders', 'action' => 'received_view',"sort" => "purchase_order_num","direction" => "asc"),array('data-controller' => 'purchase_orders', 'data-action' => 'received_view', 'data-pass' => '', 'data-top-menu' => 'purchase'))?>
			<ul>
				<li><?php echo $this->Html->link('View Purchase Receive', array('plugin' => 'purchase_order_manager','controller' => 'purchase_orders', 'action' => 'received_view',"sort" => "purchase_order_num","direction" => "asc"),array('data-controller' => 'purchase_orders', 'data-action' => 'received_view', 'data-pass' => '', 'data-top-menu' => 'purchase'))?></li>
			</ul>
		</li> 
</ul> 