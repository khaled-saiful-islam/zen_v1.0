<div id="installer-basic-information" class="sub-content-detail">
  <fieldset>    
    <legend <?php if ($edit) { ?> class="inner-legend" <?php } ?>>
      <?php echo $legend; ?>
    </legend>
    <table class="table-form-big">
      <tr>
        <th colspan="3">
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
        <td colspan="2">
          <?php
          echo $this->Form->input('work_order_id', array('label' => false, 'div' => false, 'placeholder' => 'Job Number', 'empty' => true, 'options' => $workOrders, 'class' => 'required form-select work-order-id'));
          ?>
          <?php echo $this->Form->input('created_by', array('type' => 'hidden', 'value' => $user_id)); ?>
          <?php echo $this->Form->input('status', array('type' => 'hidden', 'value' =>'New')); ?>            
        </td>
        <th>
          <label>Start Install:</label>
          <label class="wide-width-date">(dd/mm/yyyy)</label>
        </th>
        <td>
          <?php
          if (!empty($this->data['InstallerSchedule']['start_install']))
            echo $this->Form->input('start_install', array('type'=>'text','label' => false, 'div' => false, 'placeholder' => 'DD/MM/YYYY','value'=>$this->Util->formatDate($this->data['InstallerSchedule']['start_install']) ,'class' => 'required dateP')); 
          else
            echo $this->Form->input('start_install', array('type' => 'text', 'placeholder' => 'DD/MM/YYYY', 'class' => 'required dateP'));
          ?>
        </td>
      </tr>
      <tr>
        <th>
          <label>Name:</label>
        </th>
        <td colspan="2">
          <?php echo $this->Form->input('name', array('label' => false, 'div' => false, 'placeholder' => 'Name', 'class' => 'required')); ?>
        </td>
        <th>
          <label>Number of Days:</label>
        </th>
        <td>
          <?php echo $this->Form->input('number_of_days', array('label' => false, 'div' => false, 'placeholder' => 'Number of Days', 'class' => 'required')); ?>
        </td>
      </tr>
      <tr>
        <th>
          <label>Address:</label>
        </th>
        <td colspan="2" class="">
          <label class="wide-width">Address:</label>
          <?php echo $this->Form->input('address', array('label' => false, 'div' => false, 'placeholder' => 'Address', 'class' => 'address wide-input')); ?>
        </td>
        <th>
          <label>Installer:</label>
        </th>
        <td>
          <?php echo $this->Form->input('installer_id', array('label' => false, 'div' => false,'empty'=>true,'options'=>$installers, 'placeholder' => 'Installer', 'class' => 'form-select required')); ?>
        </td>
      </tr>
      <tr>
        <th>
          &nbsp;
        </th>
        <td>
          <label class="wide-width">City:</label>
          <?php echo $this->Form->input('city', array('label' => false, 'div' => false, 'placeholder' => 'City', 'class' => 'city')); ?>
        </td>
        <td>            
          <label class="wide-width">Province:</label>
          <?php echo $this->Form->input('province', array('label' => false, 'div' => false, 'options' => Configure::read('PROVINCE'), 'default' => 'Alberta', 'class' => 'form-select province', 'style' => 'width:120px;')); ?>
        </td>
        <th>
          &nbsp;
        </th>
        <td>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th>
          &nbsp;
        </th>
        <td>
          <label class="wide-width">Postal Code:</label>
          <?php echo $this->Form->input('postal_code', array('label' => false, 'div' => false, 'placeholder' => 'Postal Code', 'class' => 'postal-code')); ?>
        </td>
        <td>
          <label class="wide-width">Country:</label>
          <?php echo $this->Form->input('country', array('label' => false, 'div' => false, 'value' => 'Canada', 'readonly' => 'readonly', 'class' => 'country')); ?>
        </td>
        <th>
          &nbsp;
        </th>
        <td>
          &nbsp;
        </td>
      </tr>
    </table>
  </fieldset>
</div>

<script type="text/javascript">
$(document).ready(function() {
		$('#InstallerScheduleWorkOrderId').change(function() {
      var wo_id = $('select#InstallerScheduleWorkOrderId').val();

      $.ajax({
        url: '<?php
					echo $this->Util->getURL(array(
							'controller' => "appointments",
							'action' => 'getWOAddress',
							'plugin' => 'schedule_manager',
					))
					?>/'+wo_id,
									type: 'POST',
									data: '',
									dataType: "json",
									success: function( response ) {
										$("#InstallerScheduleAddress").val(response.Quote.address);
										$("#InstallerScheduleCity").val(response.Quote.city);
										$("#InstallerScheduleProvince").val(response.Quote.province);
										$("#InstallerSchedulePostalCode").val(response.Quote.postal_code);
										$("#InstallerScheduleCountry").val(response.Quote.country);
									}
					});
			});
		
});
</script>