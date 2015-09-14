<div class="cabinets index">
  <fieldset class="content-detail">
    <legend><?php echo __('Cabinets Data Settings'); ?></legend>    
    <?php echo $this->Form->create('InventoryLookup', array('inputDefaults' => array('label' => false, 'div' => false), 'class' => 'inventory-lookup-form ajax-form-submit')); ?>
    <table class='table-form-big'>
      <tr>
        <th><label for="InventoryLookupName">Name</label></th>
        <td ><?php echo $this->Form->input('name', array('class' => 'wide-input')); ?></td>
      </tr>
      <tr>
        <th><label for="InventoryLookupLookupType">Type:</label></th>
        <td><?php echo $this->Form->input('lookup_type', array('options' => $this->InventoryLookup->InventoryLookupTypes())); ?></td>
      </tr>
    </table>
    <div class="align-left align-top-margin">
      <?php echo $this->Form->input('Save', array('type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save')); ?>
    </div>
    <?php echo $this->Form->end(); ?>
    <div align="right">
      <a class="search_link" href="#">
        <span class="search-img">Search</span>
      </a>
    </div>
    <div id="search_div">
      <?php echo $this->Form->create('Cabinet', array('url' => array_merge(array('action' => 'index'), $this->params['pass']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
      <table class="table-form-big search_div">
        <tr>
          <td>
            <?php echo $this->Form->input('name', array('placeholder' => 'Cabinet Name')); ?>
          </td>
          <td>
            <?php echo $this->Form->submit(__('Search'), array('class' => 'btn btn-success')); ?>
          </td>
        </tr>
      </table>
      <?php echo $this->Form->end(); ?>
    </div>    
    <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
      <thead>
        <tr class="grid-header">
          <th class="min-width"><?php echo $this->Paginator->sort('name'); ?></th>
          <th class="min-width"><?php echo $this->Paginator->sort('product_type'); ?></th>
          <th class="min-width"><?php echo $this->Paginator->sort('actual_dimensions_width', 'Actual Dimensions Width'); ?></th>
          <th class="min-width"><?php echo $this->Paginator->sort('actual_dimensions_height', 'Actual Dimensions Height'); ?></th>
          <th class="min-width"><?php echo $this->Paginator->sort('actual_dimensions_depth', 'Actual Dimensions Depth'); ?></th>
          <th class="actions"><?php echo __(''); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
        $count = 0;
        foreach ($cabinets as $cabinet):
          $count++;
          $odd_even = 'odd';
          if (($count % 2) == 0) {
            $odd_even = 'even';
          }
          ?>
          <tr class="<?php //echo $odd_even;     ?>">
            <td><?php echo $this->Html->link(h($cabinet['Cabinet']['name']), array('action' => DETAIL, $cabinet['Cabinet']['id']), array('title' => __('View'), 'class' => 'show-detail-ajax')); ?>&nbsp;</td>
            <td>
              <?php
              if ($cabinet['Cabinet']['product_type']) {
                $pt = $this->InventoryLookup->InventorySpecificLookup('cabinet_type', $cabinet['Cabinet']['product_type']);
                echo $pt[$cabinet['Cabinet']['product_type']];
              }
              ?>&nbsp;</td>
            <td><?php echo h($cabinet['Cabinet']['actual_dimensions_width']); ?>&nbsp;</td>
            <td><?php echo h($cabinet['Cabinet']['actual_dimensions_height']); ?>&nbsp;</td>
            <td><?php echo h($cabinet['Cabinet']['actual_dimensions_depth']); ?>&nbsp;</td>
            <td class="actions">
              <?php echo $this->Html->link('', array('action' => DETAIL, $cabinet['Cabinet']['id']), array('class' => 'icon-file show-detail-ajax', 'title' => __('View'))); ?>
              <?php echo $this->Form->postLink('', array('action' => DELETE, $cabinet['Cabinet']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $cabinet['Cabinet']['name'])); ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </fieldset>
  <?php echo $this->element('Common/paginator'); ?>
</div>

<script>
  $(".inventory-lookup-form").validate({ignore: null});
  $(".inventory-lookup-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#MainContent'});
</script>