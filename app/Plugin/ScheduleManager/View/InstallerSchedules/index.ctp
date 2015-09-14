<div class="installer-schedule index">
  <fieldset class="content-detail">
    <legend>
      <?php echo __('Installer'); ?>
      
      <?php
      echo $this->Html->link('Calendar View',array('action'=>'calendar_view'),array('class'=>'show-detail-ajax calendar-view'));
      ?>
    </legend>
    
    <div align="right">
      <a class="search_link" href="#">
        <span class="search-img">Search</span>
      </a>
    </div>
    <div id="search_div">
      <?php echo $this->Form->create('InstallerSchedule', array('url' => array_merge(array('action' => 'index'), $this->params['pass']), 'inputDefaults' => array('label' => false, 'div' => false))); ?>
      <table class="table-form-big search_div" style="min-width:200px;">
        <tr>          
          <td>
            <?php echo $this->Form->input('work_order_id', array('options' => $workOrders, 'empty' => true, 'class' => 'form-select', 'placeholder' => 'Work Order Number')); ?>
          </td> 
          <td>
            <?php echo $this->Form->input('name', array('placeholder' => 'Name')); ?>
          </td> 
          <td>
            <?php echo $this->Form->input('installer_id',array('options' => $this->InventoryLookup->getInstallerName(), 'empty' => true, 'class' => 'form-select', 'placeholder' => 'Installer')); ?>
          </td> 
          <td class="width-min">
            <?php echo $this->Form->submit(__('Search'), array('class' => 'btn btn-success', "style" => "position: relative; ;top: -20px;")); ?>
          </td>
        </tr>
      </table>
      <?php echo $this->Form->end(); ?>
    </div>
    <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
      <thead>        
        <tr class="grid-header">
          <th><?php echo $this->Paginator->sort('work_order_id', 'Work Order Number', array('direction' => 'asc')); ?></th>
          <th><?php echo $this->Paginator->sort('name', 'Name'); ?></th>
          <th><?php echo $this->Paginator->sort('start_install', 'Start Install'); ?></th>
          <th><?php echo $this->Paginator->sort('number_of_days', 'Number of days'); ?></th>
          <th><?php echo $this->Paginator->sort('installer_id', 'Installer'); ?></th>
          <th class="actions"><?php echo __(''); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($installerSchedules as $installerSchedule):
          ?>
          <tr>
            <td>	    
              <?php //echo $this->Html->link($installer['InventoryLookup']['name'], array('action' => DETAIL, $installer['Installer']['id']), array('class' => 'table-first-column-color show-tooltip show-detail-ajax')); ?>
              <?php echo $this->Html->link(h($installerSchedule['WorkOrder']['work_order_number']), array('action' => DETAIL, $installerSchedule['InstallerSchedule']['id']), array('class' => 'table-first-column-color show-tooltip show-detail-ajax')); ?>
            </td>
            <td><?php echo h($installerSchedule['InstallerSchedule']['name']); ?></td>
            <td><?php echo $this->Util->formatDate(h($installerSchedule['InstallerSchedule']['start_install'])); ?></td>
            <td><?php echo h($installerSchedule['InstallerSchedule']['number_of_days']); ?></td>
            <td><?php echo h($installerSchedule['Installer']['name_lookup_id']); ?></td>
            <td class="actions">
              <?php echo $this->Html->link('', array('action' => DETAIL, $installerSchedule['InstallerSchedule']['id']), array('class' => 'icon-file show-detail-ajax', 'title' => __('View'))); ?>
              <?php echo $this->Form->postLink('', array('action' => DELETE, $installerSchedule['InstallerSchedule']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $installerSchedule['InstallerSchedule']['id'])); ?>

            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <?php echo $this->element('Common/paginator'); ?>
  </fieldset>
</div>
