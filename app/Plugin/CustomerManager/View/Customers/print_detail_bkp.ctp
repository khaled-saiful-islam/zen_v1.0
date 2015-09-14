<div class="quotes report-print">
  <fieldset>
    <legend><?php echo __($title_prefix, array('edit' => false)); ?></legend>

    <div class="tab-content">
      <fieldset id="customer-basic-info" class="tab-pane active">
          <?php echo $this->element('Detail/Customer/customer-basic-info',array('edit' => false)); ?>
        </fieldset>
        <fieldset id="customer-address" class="tab-pane">
          <?php echo $this->element('Detail/Customer/customer-contact-info',array('edit' => false)); ?>
        </fieldset>
    </div>

  </fieldset>
</div>