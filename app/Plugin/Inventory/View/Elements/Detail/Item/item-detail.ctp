<div class="detail actions">
  <?php
  if ($edit) {
    echo $this->Html->link('Edit', array('action' => EDIT, $item['Item']['id'], 'item-detail'), array('data-target' => '#item-detail', 'class' => 'ajax-sub-content btn btn-success', 'title' => __('Edit')));
  }
  ?>
</div>
<div id='sub-content-item-detail'>
  <?php //if (!empty($item['ItemOption'])) { ?>
  <table cellpatding="0" cellspacing="0" class="table-form-big">
    <tr>
      <th><?php echo __('Minimum'); ?>:</th>
      <td>
        <?php echo h($item['Item']['minimum']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th><?php echo __('Maximum'); ?>:</th>
      <td>
        <?php echo h($item['Item']['maximum']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th><?php echo __('Item Options'); ?>:</th>
      <td>
        <?php
        foreach ($item['ItemOption'] as $item_option) {
          echo h($item_option['name']);
          echo '<br />'; // line break for each item options
        }
        ?>
        &nbsp;
      </td>
    </tr>
  </table>

<?php //}  ?>
</div>