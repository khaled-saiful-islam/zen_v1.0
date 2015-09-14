<div class="detail actions">
  <?php
  if ($edit) {
    echo $this->Html->link('Edit', array('action' => EDIT, $item['Item']['id'], 'item-notes'), array('data-target' => '#item-notes-detail', 'class' => 'ajax-sub-content btn btn-success', 'title' => __('Edit')));
  }
  ?>
</div>
<div id='sub-content-item-notes'>
  <?php if (!empty($item['ItemNote'])) { ?>
    <table cellpatding="0" cellspacing="0" class="table table-bordered table-hover listing" style="width: 50%;">
      <thead>
        <tr class="grid-header">
          <th style="min-width: 200px;"><?php echo __('Title'); ?></th>
          <th style="min-width: 200px;"><?php echo __('Description'); ?></th>
          <th style="min-width: 200px;"><?php echo __('Date'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($item['ItemNote'] as $item_name) { ?>
          <tr>
            <td style="min-width: 200px;"><?php echo h($item_name['name']); ?></td>
            <td style="min-width: 200px;"><?php echo h($item_name['value']); ?></td>
            <td style="min-width: 200px;"><?php echo h($item_name['note_date']); ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php } else { ?>
    <table class="table table-bordered table-hover listing" style="width: 50%;">
      <thead>
        <tr class="grid-header">
          <th>Title</th>
          <th>Description</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="3">
            <label class="text-cursor-normal">No data here</label>
          </td>
        </tr>
      </tbody>
    </table>
  <?php } ?>
</div>