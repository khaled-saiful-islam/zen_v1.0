<div id="installer-basic-information" class="sub-content-detail">
  <fieldset>    
    <legend <?php if ($edit) { ?> class="inner-legend" <?php } ?>>
    <?php echo $legend; ?>
    </legend>
    <table class="table-form-big">
      <tr>
        <th>
          <label>Name:</label>
        </th>
        <td>
          <?php //echo $this->Form->input('name_lookup_id', array('placeholder'=>'Name','empty' => true,'class' => 'required form-select','options' => $this->InventoryLookup->InventoryLookup('installer_name'))); ?>
          <?php echo $this->Form->input('name_lookup_id', array('type'=>'text','placeholder'=>'Name','class' => 'required')); ?>
          <?php echo $this->Form->input('created_by', array('type'=>'hidden','value'=>$user_id)); ?>
        </td>
        <th>
          <label>Phone Number:</label>
        </th>
        <td>
          <?php echo $this->Form->input('phone', array('placeholder'=>'Phone Number','class' => 'phone-mask')); ?>
        </td>
      </tr>
      <tr>
        <th>
          <label>Pager Number:</label>
        </th>
        <td>
          <?php echo $this->Form->input('pager', array('placeholder'=>'Pager Number','class' => 'phone-mask')); ?>
        </td>
        <th>
          <label>Cell Number:</label>
        </th>
        <td>
          <?php echo $this->Form->input('cell', array('placeholder'=>'Cell Number','class' => 'phone-mask')); ?>
        </td>
      </tr>
      <tr>
        <th>
          <label>Job Preferences:</label>
        </th>
        <td>
          <?php echo $this->Form->input('job_preferences', array('placeholder'=>'Type Job Preferences(Add one per line)','cols'=>40,'rows'=>4,'class' => '')); ?>
        </td>
        <th>
          <label>Comment:</label>
        </th>
        <td class="radio-lable">
          <?php echo $this->Form->input('comments', array('placeholder'=>'Type Comment','cols'=>40,'rows'=>4,'class' => '')); ?>
        </td>
      </tr>
      <tr>
        <th>
          <label>Rating:</label>
        </th>
        <td>
          <?php echo $this->Form->input('rating', array('placeholder'=>'Rating','class' => '')); ?>
        </td>
        <th>
          <label>&nbsp;</label>
        </th>
        <td class="radio-lable">
          <?php
          echo $this->Form->input('installer', array('type'=>'checkbox','label' => 'Installer', 'div' => true));
          echo $this->Form->input('inspector', array('type'=>'checkbox','label' => 'Inspector', 'div' => true));
          echo $this->Form->input('will_inspect_all_job', array('type'=>'checkbox','label' => 'Will Inspect all jobs', 'div' => true));
          ?>
        </td>
      </tr>
    </table>
  </fieldset>
</div>
    