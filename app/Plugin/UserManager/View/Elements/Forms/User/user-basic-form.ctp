<?php //debug($this->request->data); ?>
<div id="user-basic-information" class="sub-content-detail">
  <fieldset>    
    <legend <?php if ($edit) { ?> class="inner-legend" <?php } ?>>
    <?php echo $legend; ?>
    </legend>
    <table class="table-form-big">
      <tr>
        <th>
          <label>First Name:</label>
        </th>
        <td colspan="2">          
          <?php echo $this->Form->input('first_name', array('type'=>'text','placeholder'=>'First Name','class' => 'required')); ?>          
        </td>
        <th>
          <label>Last Name:</label>
        </th>
        <td colspan="2">
          <?php echo $this->Form->input('last_name', array('placeholder'=>'Last Name','class' => 'required')); ?>
        </td>
      </tr>
      <tr>
        <th>
          <label>Employee Number:</label>
        </th>
        <td colspan="2">
          <?php echo $this->Form->input('empid', array('placeholder'=>'Employee Number','class' => 'required')); ?>
        </td>
        <th>
          <label>Title:</label>
        </th>
        <td colspan="2">
          <?php echo $this->Form->input('title', array('placeholder'=>'Title','class' => 'required')); ?>
        </td>
      </tr>
      <tr>
        <th>
          <label>Username:</label>
        </th>
        <td colspan="2">
          <?php echo $this->Form->input('username', array('placeholder'=>'Username','class' => 'required')); ?>
        </td>
        <th>
          <label>Password:</label>
        </th>
        <td colspan="2">
          <?php echo $this->Form->input('screetp', array('type'=>'password','placeholder'=>'Password','class' => 'required', 'value' => null)); ?>
        </td>
      </tr>
      <tr>
        <th>
          <label>Role:</label>
        </th>
        <td colspan="2">
          <?php echo $this->Form->input('role', array('options'=>$this->InventoryLookup->InventoryLookup('user_role'),'placeholder'=>'Role','class' => 'required form-select')); ?>
        </td>
        <th>
          <label>Status:</label>
        </th>
        <td colspan="2">
          <?php echo $this->Form->input('status', array('placeholder'=>'Status','class' => 'required form-select','default' => '1', 'options' => array(0 => 'Inactive', 1 => 'Active'))); ?>
        </td>
      </tr>
      <tr>
        <th>
          <label>E-mail 1:</label>
        </th>
        <td colspan="2">
          <?php echo $this->Form->input('email1', array('placeholder'=>'E-mail 1','class' => 'required')); ?>
        </td>
        <th>
          <label>E-mail 2:</label>
        </th>
        <td colspan="2">
          <?php echo $this->Form->input('email2', array('placeholder'=>'E-mail 2','class' => '')); ?>
        </td>
      </tr>
      <tr>
        <th rowspan="3"><label for="CustomerAddress">Address: </label></th>
        <td colspan="2">
          <label class="wide-width">Address: </label>
          <?php echo $this->Form->input('address', array('placeholder' => 'Address', 'class' => 'wide-input')); ?>
        </td>
        <th><label for="CustomerAddress">Cell Phone: </label></th>
        <td colspan="2">
          <?php echo $this->Form->input('cell_phone', array('placeholder' => 'Cell Phone', 'class' => '')); ?>
        </td>
      </tr>
      <tr>
        <td>
          <label class="wide-width">City:</label>
          <?php echo $this->Form->input('city', array('placeholder' => 'City', 'class' => '')); ?>
        </td>
        <td>
          <label class="wide-width">Province:</label>
          <?php echo $this->Form->input('province', array('options' => Configure::read('PROVINCE'), 'default' => 'Alberta', 'class' => 'form-select', 'style' => 'width:120px;')); ?>
        </td>
        <th><label>Home Phone: </label></th>
        <td>
          <label class="wide-width">Phone:</label>
          <?php echo $this->Form->input('home_phone', array('placeholder' => '(000) 000-0000', 'class' => 'phone-mask')); ?>
        </td>
        <td>
          <label class="wide-width">Extension:</label>
          <?php echo $this->Form->input('hp_ext', array('placeholder' => 'Ext..', 'class' => 'small-input')); ?>
        </td>
      </tr>
      <tr>
        <td>
          <label class="wide-width">Country:</label>
          <?php echo $this->Form->input('country', array('value' => 'Canada', 'readonly' => 'readonly', 'class' => '')); ?>
        </td>
        <td>
          <label class="wide-width">Postal Code:</label>
          <?php echo $this->Form->input('postal_code', array('placeholder' => 'Postal Code', 'style' => 'width:75px;', 'class' => '')); ?>            
        </td>
        <th><label>Work Phone: </label></th>
        <td>
          <label class="wide-width">Phone:</label>
          <?php echo $this->Form->input('work_phone', array('placeholder' => '(000) 000-0000', 'class' => 'phone-mask')); ?>
        </td>
        <td>
          <label class="wide-width">Extention:</label>
          <?php echo $this->Form->input('wp_ext', array('placeholder' => 'Ext..', 'class' => 'small-input')); ?>
        </td>
      </tr>
      <tr>
        <th>
          <label>	Description/Remark:</label>
        </th>
        <td colspan="5">
          <?php echo $this->Form->input('remark', array('rows' => 2, 'cols' => 60, 'placeholder' => 'Type Description/Remark', 'class' => '')); ?>
        </td>
      </tr>
    </table>
		<?php if($loginUser['role'] == 94){ ?>
      <!--		<div style="width: 100%; background: #EDEBE8; margin-top: 10px; margin-bottom: 5px; font-size: 14px; font-weight: bold;">User Permission</div>
                          <table class="table-form-big">
                                  <tr>
                                          <th style="width: 150px;"><label>Dashboard Section: </label></th>
                                          <td><?php echo $this->Form->input('permission_dashboard', array( 'type' => 'checkbox', 'label' => '', 'div' => true )); ?></td>
                                          <th style="width: 150px;"><label>Customer Section: </label></th>
                                          <td><?php echo $this->Form->input('permission_customer', array( 'type' => 'checkbox', 'label' => '', 'div' => true )); ?></td>
                                  </tr>
                                  <tr>
                                          <th style="width: 150px;"><label>Quote Section: </label></th>
                                          <td><?php echo $this->Form->input('permission_quote', array( 'type' => 'checkbox', 'label' => '', 'div' => true )); ?></td>
                                          <th style="width: 150px;"><label>Work Order Section: </label></th>
                                          <td><?php echo $this->Form->input('permission_work_order', array( 'type' => 'checkbox', 'label' => '', 'div' => true )); ?></td>
                                  </tr>
                                  <tr>
                                          <th style="width: 150px;"><label>Purchase Order Section: </label></th>
                                          <td><?php echo $this->Form->input('permission_purchase_order', array( 'type' => 'checkbox', 'label' => '', 'div' => true )); ?></td>
                                          <th style="width: 150px;"><label>Schedule Section: </label></th>
                                          <td><?php echo $this->Form->input('permission_schedule', array( 'type' => 'checkbox', 'label' => '', 'div' => true )); ?></td>
                                  </tr>
                                  <tr>
                                          <th style="width: 150px;"><label>Admin Section: </label></th>
                                          <td><?php echo $this->Form->input('permission_admin', array( 'type' => 'checkbox', 'label' => '', 'div' => true )); ?></td>
                                  </tr>
                          </table>-->
		<?php } ?>
  </fieldset>
</div>
    