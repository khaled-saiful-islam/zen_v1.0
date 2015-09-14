<div class="builders index">
  <fieldset class="content-detail">
    <legend><?php echo __('Builders'); ?></legend>
    <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
      <thead>
        <tr class="heading">
          <th><?php echo $this->Paginator->sort('number'); ?></th>
          <th><?php echo $this->Paginator->sort('name'); ?></th>
          <th><?php echo $this->Paginator->sort('status'); ?></th>
          <th><?php echo $this->Paginator->sort('city'); ?></th>
          <th><?php echo $this->Paginator->sort('state'); ?></th>
          <th><?php echo $this->Paginator->sort('zip'); ?></th>
          <th><?php echo $this->Paginator->sort('country'); ?></th>
          <th><?php echo $this->Paginator->sort('phone'); ?></th>
          <th><?php echo $this->Paginator->sort('fax'); ?></th>
          <th><?php echo $this->Paginator->sort('discount_rate'); ?></th>
          <th><?php echo $this->Paginator->sort('customer_type_id'); ?></th>
          <th><?php echo $this->Paginator->sort('quotes_validity'); ?></th>
          <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($builders as $builder): ?>
          <tr>
            <td><?php echo h($builder['Builder']['number']); ?>&nbsp;</td>
            <td><?php echo h($builder['Builder']['name']); ?>&nbsp;</td>
            <td><?php echo h($builder['Builder']['status']); ?>&nbsp;</td>
            <td><?php echo h($builder['Builder']['city']); ?>&nbsp;</td>
            <td><?php echo h($builder['Builder']['state']); ?>&nbsp;</td>
            <td><?php echo h($builder['Builder']['zip']); ?>&nbsp;</td>
            <td><?php echo h($builder['Builder']['country']); ?>&nbsp;</td>
            <td><?php echo h($builder['Builder']['phone']); ?>&nbsp;</td>
            <td><?php echo h($builder['Builder']['fax']); ?>&nbsp;</td>
            <td><?php echo h($builder['Builder']['discount_rate']); ?>&nbsp;</td>
            <td>
              <?php echo $this->Html->link($builder['CustomerType']['name'], array('controller' => 'customer_types', 'action' => 'view', $builder['CustomerType']['id'])); ?>
            </td>
            <td><?php echo h($builder['Builder']['quotes_validity']); ?>&nbsp;</td>
            <td class="actions">
              <?php echo $this->Html->link('', array('action' => DETAIL, $builder['Builder']['id']), array('class' => 'icon-file show-detail-ajax', 'title' => __('View'))); ?>
              <?php // echo $this->Html->link(__('Edit'), array('action' => 'edit', $builder['Builder']['id'])); ?>
              <?php echo $this->Form->postLink('', array('action' => DELETE, $builder['Builder']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $builder['Builder']['id'])); ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </fieldset>
  <?php echo $this->element('Common/paginator'); ?>
</div>