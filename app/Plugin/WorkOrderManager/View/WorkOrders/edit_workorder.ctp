<?php
	echo $this->Form->create('WorkOrder', array('url' => array('controller' => 'work_orders', 'action' => 'edit_workorder', $wo_data['WorkOrder']['id']) ,'inputDefaults' => array('label' => false, 'div' => false), 'class' => ''));
	echo $this->element('Forms/WorkOrder/new_work_order', array('work_order' => $wo_data,'legend' => 'Edit Work Order', 'edit' => true));
	echo $this->Form->end();
?>