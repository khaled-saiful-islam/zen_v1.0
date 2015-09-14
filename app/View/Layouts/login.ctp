<?php
/**
 * @copyright     Instalogic Inc, 2012, (http://instalogic.com)
 * @package       Cake.View.Layouts
 * 
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>


		<?php echo $this->Html->charset(); ?>
		<title>
			Zen Living:
		</title>
		<?php
		echo $this->Html->css("bootstrap");
		echo $this->Html->css("login");

		echo $this->fetch('css');
		?>
	</head>
	<body>

		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>

		<?php //echo $this->element('sql_dump');  ?>
	</body>
</html>
