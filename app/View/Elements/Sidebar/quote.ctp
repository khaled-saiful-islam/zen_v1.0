<ul class="verticle-left-menu">
		<li>
			<?php echo $this->Html->link('Quotes', array('plugin' => 'quote_manager','controller' => 'quotes', 'action' => 'index',"sort" => "quote_number","direction" => "asc"),array('data-controller' => 'quotes', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'quote'))?>
			<ul class="verticle-left-menu">
					<li><?php echo $this->Html->link('Add quote', array('plugin' => 'quote_manager','controller' => 'quotes', 'action' => 'add'), array('data-controller' => 'quotes', 'data-action' => 'add', 'data-pass' => '', 'data-top-menu' => 'quote')) ?></li>
					<li><?php echo $this->Html->link('View quotes', array('plugin' => 'quote_manager','controller' => 'quotes', 'action' => 'index',"sort" => "quote_number","direction" => "asc"), array('data-controller' => 'quotes', 'data-action' => 'index', 'data-pass' => '', 'data-top-menu' => 'quote')) ?></li>
					<li><?php echo $this->Html->link('View deleted quotes', array('plugin' => 'quote_manager','controller' => 'quotes', 'action' => 'deleted_quote',"sort" => "quote_number","direction" => "asc"), array('data-controller' => 'quotes', 'data-action' => 'deleted_quote', 'data-pass' => '', 'data-top-menu' => 'quote')) ?></li>
					<li><?php echo $this->Html->link('Report', array('plugin' => 'quote_manager','controller' => 'quotes', 'action' => 'reports'), array('data-controller' => 'quotes', 'data-action' => 'reports', 'data-pass' => '', 'data-top-menu' => 'quote')) ?></li>
			</ul>
		</li> 
</ul> 