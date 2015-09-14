<fieldset>
  <legend><?php echo __('Add Quote'); ?></legend>
  <?php
  echo $this->element('Forms/Quote/quote-pricing-form', array('edit' => false,'section' => 'basic'));
  ?>
</fieldset>
