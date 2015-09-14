<div class="customers index">
  <fieldset class="content-detail">
    <legend><?php echo __('Service Entries'); ?></legend>
    <div align="right">
      <a class="search_link" href="#">
        <span class="search-img">Search</span>
      </a>
    </div>
    <div id="search_div">
      <?php echo $this->Form->create('ServiceEntry', array('url' => array_merge(array('action' => 'index'), $this->params['pass']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
      <table class="table-form-big search_div" style="min-width:200px;">
        <tr>          
          <td>
            <?php echo $this->Form->input('work_order_id', array('options' => $workOrders, 'empty' => true, 'class' => 'form-select', 'placeholder' => 'Work Order Number')); ?>
          </td>          
          <td class="width-min">
            <?php echo $this->Form->submit(__('Search'), array('class' => 'btn btn-success',"style" => "position: relative; ;top: -20px;")); ?>
          </td>
        </tr>
      </table>
      <?php echo $this->Form->end(); ?>
    </div>
    <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
      <thead>        
        <tr class="grid-header">
          <th><?php echo $this->Paginator->sort('work_order_id', 'Work Order Number', array('direction' => 'asc')); ?></th>
          <th><?php echo $this->Paginator->sort('created', 'Created On'); ?></th>
          <th><?php echo $this->Paginator->sort('booked_for', 'Booked For'); ?></th>
          <th><?php echo $this->Paginator->sort('resolved_on', 'Resolved On'); ?></th>
          <th class="actions"><?php echo __(''); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($serviceEntries as $serviceEntry):
          ?>
          <tr>
            <td>	    
              <?php echo $this->Html->link(h($serviceEntry['WorkOrder']['work_order_number']), array('action' => DETAIL, $serviceEntry['ServiceEntry']['id']), array('class' => 'table-first-column-color show-tooltip show-detail-ajax')); ?>
            </td>
            <td><?php echo h($this->Util->formatDate($serviceEntry['ServiceEntry']['created'])); ?></td>
            <td><?php echo h($this->Util->formatDate($serviceEntry['ServiceEntry']['booked_for'])); ?></td>
            <td><?php echo h($this->Util->formatDate($serviceEntry['ServiceEntry']['resolved_on'])); ?></td>
            <td class="actions">
              <?php echo $this->Html->link('', array('action' => DETAIL, $serviceEntry['ServiceEntry']['id']), array('class' => 'icon-file show-detail-ajax', 'title' => __('View'))); ?>
              <?php echo $this->Form->postLink('', array('action' => DELETE, $serviceEntry['ServiceEntry']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $serviceEntry['ServiceEntry']['id'])); ?>

              <?php
              echo $this->Html->link(
                      '', array('controller' => 'service_entries', 'action' => 'print_detail', $serviceEntry['ServiceEntry']['id']), array('class' => 'icon-print open-link', 'data_target' => 'item_report', 'title' => 'Print Detail Information')
              );
              ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <?php echo $this->element('Common/paginator'); ?>
  </fieldset>  
</div>

