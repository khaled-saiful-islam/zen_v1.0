<table style="margin-bottom: 20px;">
  <tr>
    <th style="padding-right: 40px;">Sub-Item: </th>
    <td>
      <?php
      echo $this->Form->input('Item.id', array(
          'class' => 'input-medium item_sub_history form-select',
          "label" => false,
          "options" => array($item['Item']['id'] => $item['Item']['item_title']) + $this->InventoryLookup->getItemTitleForSub($id),
      ));
      ?>
    </td>
  </tr>
</table>
<div id='sub-content-item-history'>
  <div>
    <span>Current Stock: </span>
    <span><?php print h($item['Item']['current_stock']); ?></span>
  </div>
  <?php if (!empty($item['ItemInventoryTransaction'])) { ?>
    <table cellpatding="0" cellspacing="0" class="table table-bordered table-hover listing" style="width: 80%;">
      <thead>
        <tr class="grid-header">
          <th ><?php echo __('Quantity'); ?></th>
          <th ><?php echo __('Type'); ?></th>
          <th style="min-width: 200px;"><?php echo __('Comment'); ?></th>
          <th ><?php echo __('Updated By'); ?></th>
          <th style="min-width: 200px;"><?php echo __('Updated Date'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
//        debug($itemInventoryTransaction);
        arsort($itemInventoryTransaction);
        foreach ($itemInventoryTransaction as $item_name) {
          ?>
          <tr>
            <td ><?php echo h($item_name['ItemInventoryTransaction']['count']); ?></td>
            <td ><?php echo h(strtoupper($item_name['ItemInventoryTransaction']['type'])); ?></td>
            <td style="min-width: 200px;"><?php echo h($item_name['ItemInventoryTransaction']['comment']); ?></td>
            <td><?php echo h($item_name['User']['first_name'] . ' ' . $item_name['User']['last_name']); ?></td>
            <td style="min-width: 200px;"><?php echo h($this->Util->formatDate($item_name['ItemInventoryTransaction']['created'])); ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php } else { ?>
    <table class="table table-bordered table-hover listing" style="width: 50%;">
      <thead>
        <tr class="grid-header">
          <th ><?php echo __('Quantity'); ?></th>
          <th ><?php echo __('Type'); ?></th>
          <th style="min-width: 200px;"><?php echo __('Comment'); ?></th>
          <th><?php echo __('Updated By'); ?></th>
          <th style="min-width: 200px;"><?php echo __('Updated Date'); ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="5">
            <label class="text-cursor-normal">No data here</label>
          </td>
        </tr>
      </tbody>
    </table>
  <?php } ?>
</div>
<script type="text/javascript">
  $(function(){
    $('select.item_sub_history').change(function(){
      var item_id = $(this).val();
      ajaxStart();
      $.ajax({
        url: '<?php
  echo $this->Util->getURL(array(
      'controller' => "items",
      'action' => 'get_history',
      'plugin' => 'inventory',
  ))
  ?>/'+item_id,
          type: 'POST',
          data: '',
          //					dataType: "json",
          success: function( response ) {
            $('#sub-content-item-history').html(response);
            ajaxStop();
          }
        });
      })
    })
</script>