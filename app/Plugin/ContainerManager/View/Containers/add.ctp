<?php echo $this->Form->create('Container', array('url' => array('controller' => 'containers', 'action' => 'add'),'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'container-form')); ?>

<?php echo $this->element('Forms/Container/container-form', array('legend' => 'Add Container', 'edit' => false)); ?>

<?php echo $this->Form->end(); ?>