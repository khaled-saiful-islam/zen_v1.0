<?php
/**
 * @copyright     Copyright Instalogic Inc 2012
 * @package       Cake.View.Layouts
 * @author         Sarwar Hossain
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <?php echo $this->Html->charset(); ?>
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <title>
      <?php echo "Zen Living" ?>:
      <?php echo $title_for_layout; ?>
    </title>
    <script type="text/javascript">
			var base_url = "<?= $this->here . "/" ?>";
      var BASEURL = '<?php echo $this->webroot; ?>';
      var IMAGEPATH = BASEURL + "/img/";
    </script>
    <?php
    echo $this->Html->meta('icon');
    /**
     * @desc Include All CSS
     */
    echo $this->Html->css("bootstrap");
    echo $this->Html->css("bootstrap-overwrite");
//    echo $this->Html->css('jquery-ui-1.8.22.custom');
    echo $this->Html->css('smoothness/jquery-ui-1.9.1.custom.min');
    echo $this->Html->css('common');
    echo $this->Html->css('select2/select2');
    echo $this->Html->css('fullcalendar/fullcalendar');
    //echo $this->Html->css('fullcalendar/fullcalendar.print');
    echo $this->Html->css('superfish');
    echo $this->Html->css('notificationMessage/style');
    echo $this->Html->css('style');
    echo $this->Html->css('ui.multiselect');
		echo $this->Html->css('jPicker-1.1.6');
    /**
     * @desc Include All JS
     */
//    echo $this->Html->script("jQuery/jquery-1.7.2.min");
    echo $this->Html->script("jQuery/jquery-1.8.2");
//    echo $this->Html->script("jQuery/jquery-ui-1.8.22.custom.min");
    echo $this->Html->script("jQuery/jquery-ui-1.9.1.custom.min");
    echo $this->Html->script('bootStrap/bootstrap.min');
		echo $this->Html->script('jpicker-1.1.6');
    ?>

    <?php // echo $this->Html->script('jQuery/plugin/jquery.ezpz_hint');  ?>

    <?php
    echo $this->Html->script('jQuery/plugin/select2');
    echo $this->Html->script('jQuery/plugin/fullcalendar.min');
    echo $this->Html->script('jQuery/plugin/superfish');
    echo $this->Html->script('jQuery/plugin/jquery.form');
    echo $this->Html->script('jQuery/plugin/jquery.validate.min');
    echo $this->Html->script('jQuery/plugin/ui.multiselect');
    echo $this->Html->script('jQuery/plugin/jquery.ui.timepicker.addon');
    echo $this->Html->script('jQuery/plugin/jquery.qtip.min');
    echo $this->Html->script('jQuery/plugin/jquery.mask.min');
    /** Application lib */
    echo $this->Html->script("ITL/itl");
    echo $this->Html->script("ITL/plugin/itl.plugin.notification-message");
    echo $this->Html->script("ITL/lib/itl.utility");
    echo $this->Html->script("ITL/lib/itl.view");
    echo $this->Html->script("ITL/views/itl.view.layout");
    echo $this->Html->script("custom_plugins");
    echo $this->Html->script("lib/AppJs");

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    ?>
    <?php echo $this->Html->css('Inventory.style-inventory.css'); ?>
    <?php echo $this->Html->script('Inventory.js-inventory.js'); ?>
    <?php echo $this->Html->script('QuoteManager.js-quote-manager.js'); ?>
    <?php echo $this->Html->script('PurchaseOrderManager.js-purchase-manager.js'); ?>
    <?php echo $this->Html->script('PurchaseOrderManager.POJs.js'); ?>
    <?php echo $this->Html->script('WorkOrderManager.js_work_order_manager.js'); ?>
    <?php echo $this->Html->script('ScheduleManager.js-schedule-manager.js'); ?>
    <?php echo $this->Html->script('InvoiceManager.js_invoice_manager.js'); ?>
		<?php echo $this->Html->script('ContainerManager.js-container.js'); ?>
		<script type="text/javascript">
			$(document).ready(function () {
				var childUl = $(".verticle-left-menu li ul");
				$(childUl).prev().addClass('arrow-down');
				$(childUl).prev().attr("href", "javascript:void(0)");
				$(".verticle-left-menu li a").bind("click", function () {
					var curEle = $(this);
					if ($(curEle).next('ul').length == 1) {
						if ($(curEle).next('ul').is(':visible')) {
							$(curEle).next('ul').slideUp("slow");
						} else {
							$(curEle).next('ul').slideDown("slow");
						}
						return false;
					}
					return true;
				});
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function () {
				var controller = '<?php echo $this->params['controller'] ?>';
				var action = '<?php echo $this->params['action'] ?>';
				var pass = '<?php echo isset($this->params['pass'][0]) ? $this->params['pass'][0] : "" ?>';
				var second_pass = '<?php echo isset($this->params['pass'][1]) ? $this->params['pass'][1] : "" ?>';

				$('.verticle-left-menu a').each(function () {
					var curController = $(this).attr('data-controller');
					var curAction = $(this).attr('data-action');
					var curPass = $(this).attr('data-pass');
					var topMenu = $(this).attr('data-top-menu');

					if(topMenu == 'admin')
						$('#top-admin').css({backgroundColor : '#51a351'});
					if(topMenu == 'schedule')
						$('#top-schedule').css({backgroundColor : '#51a351'});
					if(topMenu == 'purchase')
						$('#top-purchase').css({backgroundColor : '#51a351'});
					if(topMenu == 'workorder')
						$('#top-workorder').css({backgroundColor : '#51a351'});
					if(topMenu == 'quote')
						$('#top-quote').css({backgroundColor : '#51a351'});
					if(topMenu == 'customer')
						$('#top-customer').css({backgroundColor : '#51a351'});
					
					if (((curController == controller) && (curAction == action) && (curPass == pass)) || ((curController == controller) && (curAction == action) && (curPass == '')) || ((curController == controller) && (curAction != action) && (curPass == '')) || ((curController == controller) && (curAction != action) && (curPass == second_pass))) {
						$(this).parent().parent().css({display: 'block'});
						if (pass != '') {
							if (curPass == pass || ((curPass != '') && (curPass == second_pass))) {
								$(this).addClass("menu_bg_image");
							}

						} else if ((curController == controller) && (curAction == action)) {
							$(this).addClass("menu_bg_image");
						}
					}
				});
			});
		</script>

  </head>

  <body class="body">
    <!-- HEADER Box -->
    <div class="header">
      <div class="logo">
        <div id="header-right">
          <?php echo $this->element("Layout/top_items"); ?>
        </div>
      </div>
    </div>
    <!-- Header end -->

    <!-- Menu bar start -->
    <div class="dashboard"> <!-- class menubar -->
      <?php echo $this->element('Layout/menu'); ?>
    </div>
    <!-- menu bar end -->
    <!-- Main Content -->
    <div class="container-fluid">
      <div class="row-fluid">
        <?php
        $full_width = 'full-width';

        if (!empty($left_nav)) { // is left menu set from controller?
          // does the left menu ctp exist in file system?
          if (!empty($this->request->params['plugin'])) { // is it call from an plugin?
            $element_path = APP . 'Plugin' . DS . $this->plugin . DS . 'View' . DS . 'Elements' . DS . $left_nav . $this->ext;
          } else {
            $element_path = APP . 'View' . DS . 'Elements' . DS . $left_nav . $this->ext;
          }

          if (file_exists($element_path)) {
            $full_width = '';
            ?>
					<div id="sidebar" class="span2">
						<div>
							<?php echo (isset($side_bar) && $side_bar != "") ? $this->element("Sidebar/" . $side_bar) : ""; ?>
						</div>
					</div>
				
            
            <?php
          }
        }
        ?>
				
        <div class="span10">
          <div id="MainContent" class="well">
            <?php
            echo $this->Session->flash();
            echo $this->fetch('content');
            ?>
          </div>
        </div>
      </div>
    </div>
    <!-- Main content finihsed -->
    <!-- Footer section -->
    <div class="footer">
      <table height="100%" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr style=" font-size:12px;font-family:Tahoma, Geneva, sans-serif">
          <td align="left" width="80%"><font color="#698e1a">Powered by Instalogic Inc.</font></td>
          <td align="right"><font color="#698e1a"> ZEN LIVING &copy 2012</font></td>
        </tr>
      </table>
    </div>
    <!-- End of Footer -->

    <?php echo $this->element('sql_dump'); ?>

    <!-- Ajax Loading Modal -->
    <div id="AjaxLoadingModal" class="modal hide" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-body">
        <p align="center"><?php echo $this->Html->image('loading-0C8510.gif'); ?></p>
      </div>
    </div>
		<div id="AjaxLoadingModalOrder" class="modal hide" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-body">
        <p align="center"><?php echo $this->Html->image('332.GIF'); ?></p>
      </div>
    </div>
		<div id="AjaxLoadingModalSubmit" class="modal hide" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-body">
        <p align="center"><?php echo $this->Html->image('33212.GIF'); ?></p>
      </div>
    </div>
    <!-- detail modal  -->
    <div id="ModalContent" class="modal hide fade modal-width" data-keyboard="true" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    </div>

    <!-- confirmation modal  -->
    <div id="dialog-confirm" class="hide" title="Remove it completely?">
      <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span><span class="msg"></span></p>
    </div>

  </body>
</html>
