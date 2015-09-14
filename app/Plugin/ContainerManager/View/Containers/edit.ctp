<?php echo $this->Form->create('Container', array('url' => array('controller' => 'containers', 'action' => 'edit', $container['Container']['id']),'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'container-form')); ?>

<?php
	if(isset($container['Container']['id'])){
		echo $this->Form->hidden('id', array('value' => $container['Container']['id']));
	}
?>
<?php echo $this->element('Forms/Container/edit/container-form', array('legend' => 'Edit Container', 'edit' => false)); ?>

<?php echo $this->Form->end(); ?>