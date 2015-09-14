<div class="cabinetOrders index">
  <h2><?php echo __('Cabinet Orders'); ?></h2>
  <table cellpadding="0" cellspacing="0">
    <tr>
      <th><?php echo $this->Paginator->sort('quote_id'); ?></th>
      <th><?php echo $this->Paginator->sort('door_species'); ?></th>
      <th><?php echo $this->Paginator->sort('door_style'); ?></th>
      <th><?php echo $this->Paginator->sort('stain_color'); ?></th>
      <th><?php echo $this->Paginator->sort('rush_order'); ?></th>
      <th><?php echo $this->Paginator->sort('drawer_slides'); ?></th>
      <th><?php echo $this->Paginator->sort('delivery'); ?></th>
      <th class="actions"><?php echo __('Actions'); ?></th>
    </tr>
    <?php foreach ($cabinetOrders as $cabinetOrder): ?>
      <tr>
        <td>
          <?php echo $this->Html->link($cabinetOrder['Quote']['id'], array('controller' => 'quotes', 'action' => 'view', $cabinetOrder['Quote']['id'])); ?>
        </td>
        <td><?php echo h($cabinetOrder['CabinetOrder']['door_species']); ?>&nbsp;</td>
        <td><?php echo h($cabinetOrder['CabinetOrder']['door_style']); ?>&nbsp;</td>
        <td><?php echo h($cabinetOrder['CabinetOrder']['stain_color']); ?>&nbsp;</td>
        <td><?php echo h($cabinetOrder['CabinetOrder']['rush_order']); ?>&nbsp;</td>
        <td><?php echo h($cabinetOrder['CabinetOrder']['drawer_slides']); ?>&nbsp;</td>
        <td><?php echo h($cabinetOrder['CabinetOrder']['delivery']); ?>&nbsp;</td>
        <td class="actions">
          <?php echo $this->Html->link(__('View'), array('action' => 'view', $cabinetOrder['CabinetOrder']['id'])); ?>
          <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $cabinetOrder['CabinetOrder']['id'])); ?>
          <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $cabinetOrder['CabinetOrder']['id']), null, __('Are you sure you want to delete # %s?', $cabinetOrder['CabinetOrder']['id'])); ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
  <?php echo $this->element('Common/paginator'); ?>
</div>
