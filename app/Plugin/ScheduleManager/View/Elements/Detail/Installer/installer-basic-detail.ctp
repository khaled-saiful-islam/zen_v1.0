<div class="detail actions">
  <?php echo $this->Html->link('Edit', array('action' => EDIT, $installer['Installer']['id'], 'basic'), array('data-target' => '#installer-basic-detail', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Edit'))); ?>
</div>
<?php //debug($installer); ?>
<table class="table-form-big">
  <tr>
    <th>
      <label>Name:</label>
    </th>
    <td>
      <?php echo h($installer['Installer']['name_lookup_id']); ?>
    </td>
    <th>
      <label>Phone Number:</label>
    </th>
    <td>
      <?php echo h($installer['Installer']['phone']); ?>
      
    </td>
  </tr>
  <tr>
    <th>
      <label>Pager Number:</label>
    </th>
    <td>
      <?php echo h($installer['Installer']['pager']); ?>
    </td>
    <th>
      <label>Cell Number:</label>
    </th>
    <td>
      <?php echo h($installer['Installer']['cell']); ?>
    </td>
  </tr>
  <tr>
    <th>
      <label>Job Preferences:</label>
    </th>
    <td>
      <?php echo h($installer['Installer']['job_preferences']); ?>
    </td>
    <th>
      <label>Comment:</label>
    </th>
    <td>
      <?php echo h($installer['Installer']['comments']); ?>
    </td>
  </tr>
  <tr>
    <th>
      <label>Rating:</label>
    </th>
    <td>
      <?php echo h($installer['Installer']['rating']); ?>
    </td>
    <th>
      <label>&nbsp;</label>
    </th>
    <td class="radio-lable">
      <?php
      echo $this->Form->input('installer', array('type' => 'checkbox', 'label' => 'Installer', 'div' => true,'checked' => $installer['Installer']['installer'],'disabled'=>'disabled'));
      echo $this->Form->input('inspector', array('type' => 'checkbox', 'label' => 'Inspector', 'div' => true,'checked' => $installer['Installer']['inspector'],'disabled'=>'disabled'));
      echo $this->Form->input('will_inspect_all_job', array('type' => 'checkbox', 'label' => 'Will Inspect all jobs', 'div' => true,'checked' => $installer['Installer']['will_inspect_all_job'],'disabled'=>'disabled'));
      ?>
    </td>
  </tr>
</table>

