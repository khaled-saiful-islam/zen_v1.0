<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <?php echo $this->Html->charset(); ?>
    <title>
      <?php echo "Zen Living" ?>:
      <?php echo $title_for_layout; ?>
    </title>
    <script type="text/javascript">
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
    echo $this->Html->css('superfish');
    echo $this->Html->css('notificationMessage/style');
    echo $this->Html->css('style');
    echo $this->Html->css('report');
    ?>
  </head>

  <body style="background-color: white;" class="body report">
    <!-- HEADER Box -->
    <button style="float: left;" onclick="javascript:window.print();" class="hide-in-print">Print</button>
<!--		<div style="margin-left:5px; float: left;">
			<?php
				echo $this->Html->link($this->Html->image('pdf.png'), array(
											'plugin' => 'quote_manager',
											'controller' => 'quotes',
											'action' => 'pdf_report_cab_parts',
											$quote['Quote']['id']
													), array( 'escape' => false, 'style' => 'margin-left: 20px;' ));
			?>
		</div>-->
		<div style="clear: both;"></div>
    <!--<div class="header hide-in-print">-->
    <div style="border: none;" class="header">
      <div class="header-left">
        <div class="logo logo_report" style="position: relative; z-index: 999;">
          <?php
          echo $this->Html->image('header_logo.png');
          ?>
        </div>
        <div class="address">
          <span style="display: block;">2790 32nd Avenue N.E.</span><br/>
          <span style="display: block; margin-top: -8px;">Calgary, AB T1Y 5S5</span><br/>
					<span style="display: block; margin-top: -8px;">Phone: 403-7201928</span><br/>
        </div>
      </div>
      <div class="header-right">
				<span class="report-title">
        <?php //if (isset($reportTitle)) echo h($reportTitle); ?>
        </span>
        <br/>
        <span class="report-date">
          <?php
//          if (isset($reportDate)) {
//            if (is_int($reportDate)) {
//              echo h(date('D, M jS, Y - h:i a', $reportDate));
//            } else {
//              echo h($reportDate);
//            }
//          }
          ?>
        </span>
        <span class="report-date">
          <?php if (isset($reportStartDate)) echo '<br/><br/>Date Range: ' . h($reportStartDate); ?> <br/>
          <?php if (isset($reportEndDate)) echo h($reportEndDate); ?>
        </span>
        <span class="report-number">
          <?php if (isset($reportNumber)) echo h($reportNumber); ?>
        </span>
        <br/>
      </div>
    </div>
    <div class="clear"></div>
    <!-- Header end -->
    <div class="container-report">
      <div class="report-area">
        <?php
        echo $this->fetch('content');
        ?>
      </div>
    </div>
  </body>
</html>