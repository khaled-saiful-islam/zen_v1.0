<?php if ($installerSchedule['InstallerSchedule']['status'] != "Installed") { ?>
<div class="detail actions">
  <?php echo $this->Html->link('Edit', array('action' => EDIT, $installerSchedule['InstallerSchedule']['id'], 'basic'), array('data-target' => '#installer-schedule-basic-detail', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Edit'))); ?>
</div>
<?php } ?>
<?php //debug($installerSchedule); ?>
<table class="table-form-big">
  <tr>
    <th colspan="2">
      <label class="table-th-col-title">Job Information</label>
    </th>
    <th colspan="2">
      <label class="table-th-col-title">Install Information</label>
    </th>
  </tr>
  <tr>
    <th>
      <label>
        Job Number:
      </label>
    </th>
    <td>
      <?php
      echo h($installerSchedule['WorkOrder']['work_order_number']);
      ?>          
    </td>
    <th>
      <label>Start Install:</label>
      <label class="wide-width-date">(dd/mm/yyyy)</label>
    </th>
    <td>
      <?php echo h($this->Util->formatDate(h($installerSchedule['InstallerSchedule']['start_install']))); ?>
    </td>
  </tr>
  <tr>
    <th>
      <label>Name:</label>
    </th>
    <td>
      <?php
      echo h($installerSchedule['InstallerSchedule']['name']);
      ?> 
    </td>
    <th>
      <label>Number of Days:</label>
    </th>
    <td>
      <?php
      echo h($installerSchedule['InstallerSchedule']['number_of_days']);
      ?> 
    </td>
  </tr>
  <tr>
    <th>
      <label>Address:</label>
    </th>
    <td>      
      <?php echo $this->InventoryLookup->address_format(h($installerSchedule['InstallerSchedule']['address']), h($installerSchedule['InstallerSchedule']['city']), h($installerSchedule['InstallerSchedule']['province']), h($installerSchedule['InstallerSchedule']['country']), h($installerSchedule['InstallerSchedule']['postal_code'])); ?>
    </td>
    <th>
      <label>Installer:</label>
    </th>
    <td>
      <?php
      echo h($installerSchedule['Installer']['name_lookup_id']);
      ?> 
    </td>
  </tr>  
</table>
