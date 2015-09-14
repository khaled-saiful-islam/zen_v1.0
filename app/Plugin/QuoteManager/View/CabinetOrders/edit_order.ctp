<fieldset>
  <legend class="inner-legend"><?php echo __('Edit Cabinet Order'); ?></legend>
  <?php
  echo $this->element('Forms/Order/cabinet-order-form', array('edit' => true));
  ?>
</fieldset>