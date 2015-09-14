<?php
$customer_status = 0;
if (isset($this->request->data['Customer']['status'])) {
  $customer_status = 1;
}
?>
<div class="customers form">
  <fieldset>
    <legend  <?php if ($edit) { ?>class="edit-legend"<?php } ?>><?php echo __($legend); ?></legend>
    <table class='table-form-big'>
      <tr>
        <th><label for="CustomerFirstName">Name: </label></th>
        <td class="" >
          <?php echo $this->Form->input('first_name', array('placeholder' => 'First Name', 'class' => 'required')); ?>
					<div style="color: red; display: none;" class="error-message-customer">Minimum 6 Characters</div>
        </td>
        <td>
          <?php echo $this->Form->input('last_name', array('placeholder' => 'Last Name', 'class' => 'required')); ?>
        </td>
        <th><label for="CustomerWebsite">Website: </label></th>
        <td colspan="2"><?php echo $this->Form->input('website', array('placeholder' => 'Website', 'class' => 'url wide-input', 'type' => 'text')); ?></td>
      </tr>
      <tr>
        <th><label for="CustomerEmail">Email: </label></th>
        <td colspan="2"><?php echo $this->Form->input('email', array('placeholder' => 'Email', 'class' => 'email')); ?></td>
        <th><label for="CustomerStatus">Status: </label></th>
        <td colspan="2"><?php echo $this->Form->input('status', array('class' => 'form-select required', 'default' => '1', 'options' => array(0 => 'Inactive', 1 => 'Active'))); ?></td>
      </tr>
      <tr>
        <th rowspan="3"><label for="CustomerPhone">Phone: </label></th>
        <td>
          <label class="wide-width">Phone: </label>
          <?php echo $this->Form->input('phone', array('placeholder' => '(000) 000-0000', 'class' => 'small-wide-input required phone-mask')); ?>
        </td>
        <td class="width-min">
          <label class="wide-width">Extension: </label>
          <?php echo $this->Form->input('phone_ext', array('placeholder' => 'Ext..', 'class' => 'small-input')); ?>

        </td>
        <th rowspan="3"><label for="CustomerAddress">Address: </label></th>
        <td colspan="2">
          <label class="wide-width">Address: </label>
          <?php echo $this->Form->input('address', array('placeholder' => 'Address', 'class' => 'wide-input')); ?>
        </td>
      <tr>
        <td colspan="2">
          <label class="wide-width">Cell: </label>
          <?php echo $this->Form->input('cell', array('placeholder' => '(000) 000-0000', 'class' => 'small-wide-input phone-mask')); ?>
        </td>
        <td class="width-min">
          <label class="wide-width">City: </label>
          <?php echo $this->Form->input('city', array('placeholder' => 'City', 'class' => '')); ?>
        </td>
        <td>
          <label class="wide-width">Province: </label>
          <?php echo $this->Form->input('province', array('options' => Configure::read('PROVINCE'), 'default' => 'Alberta', 'class' => 'form-select', 'style' => 'width:120px;')); ?>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <label class="wide-width">Fax: </label>
          <?php echo $this->Form->input('fax_number', array('placeholder' => '(000) 000-0000', 'class' => 'small-wide-input phone-mask')); ?>
        </td>
        <td>
          <label class="wide-width">Country: </label>
          <?php echo $this->Form->input('country', array('value' => 'Canada', 'readonly' => 'readonly', 'class' => '')); ?>
        </td>
        <td>
          <label class="wide-width">Postal Code: </label>
          <?php echo $this->Form->input('postal_code', array('placeholder' => 'Postal Code', 'style' => 'width:75px;', 'class' => '')); ?>
        </td>
      </tr>
      <tr>
        <th valign="top"><label for="CustomerReferral">Referral: </label></th>
        <td><?php echo $this->Form->input('referral', array('placeholder' => 'Referral', 'class' => 'form-select', 'options' => $this->InventoryLookup->InventoryLookup('referral'), 'empty' => '')); ?></td>
        <td><?php echo $this->Form->input('sales_representative', array('placeholder' => 'Sales Representatives', 'class' => 'form-select required wide-input', "multiple" => true, "options" => $this->InventoryLookup->salesPersonList(), "value" => isset($sales_data) ? unserialize($sales_data) : "")); ?></td>
        <th valign="top" rowspan="2"><label for="SiteAddress">Site Address: </label></th>
        <td colspan="2" rowspan="2">
          <?php
          $hide_site_address = '';
          if ($edit) {
            if ($this->request->data['Customer']['site_address_exists'] == 0) {
              $hide_site_address = '';
            } else {
              $hide_site_address = 'hide';
            }
          }
          ?>
          <table class="site-address-wrapper">
            <tr>
              <td colspan="2">
                <label class="wide-width" for="CustomerSiteAddressExists">
                  <?php echo $this->Form->input('site_address_exists', array('class' => 'site-address-same', 'default' => '0')); ?> Same as Address
                </label>
              </td>
            </tr>
            <tr class="site-address <?php echo $hide_site_address; ?>">
              <td colspan="2">
                <label class="wide-width">Address: </label>
                <?php echo $this->Form->input('site_address', array('placeholder' => 'Address', 'class' => 'wide-input')); ?>
              </td>
            </tr>
            <tr class="site-address <?php echo $hide_site_address; ?>">
              <td class="width-min">
                <label class="wide-width">City: </label>
                <?php echo $this->Form->input('site_city', array('placeholder' => 'City', 'class' => '')); ?>
              </td>
              <td>
                <label class="wide-width">Province: </label>
                <?php echo $this->Form->input('site_province', array('options' => Configure::read('PROVINCE'), 'default' => 'Alberta', 'class' => 'form-select', 'style' => 'width:120px;')); ?>
              </td>
            </tr>
            <tr class="site-address <?php echo $hide_site_address; ?>">
              <td>
                <label class="wide-width">Country: </label>
                <?php echo $this->Form->input('site_country', array('value' => 'Canada', 'readonly' => 'readonly', 'class' => '')); ?>
              </td>
              <td>
                <label class="wide-width">Postal Code: </label>
                <?php echo $this->Form->input('site_postal_code', array('placeholder' => 'Postal Code', 'style' => 'width:75px;', 'class' => '')); ?>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <th valign="top"><label for="CustomerRemark">Comment: </label></th>
        <td colspan="2"><?php echo $this->Form->input('remark', array('rows' => 2, 'cols' => 47, 'placeholder' => 'Comment', 'class' => '')); ?></td>
      </tr>
    </table>
    <?php
    $display = "style='display:none;'";
    if ($edit) {
      if ($this->request->data['Customer']['customer_type_id'] == 2 || $this->request->data['Customer']['customer_type_id'] == 3) {
        $display = "style='display:block;'";
      } else {
        $display = "style='display:none;'";
      }
    }
    ?>
    <div class="builder-account-credit" <?php echo $display; ?>>
      <table class='table-form-big'  >
        <tr>
          <th colspan="2" class="table-separator-right">
            <label style="text-decoration: underline;cursor: text;">Builder Account</label>
          </th>
          <th colspan="2">
            <label style="text-decoration: underline; cursor: text;">Builder Credit Info</label>
          </th>
        </tr>
        <tr>
          <th><label for="BuilderAccountBuilderLegalName">Legal Name: </label></th>
          <td>
            <?php echo $this->Form->input('BuilderAccount.builder_legal_name', array('placeholder' => 'Legal Name')); ?>
          </td>
          <th>
            <label for="BuilderAccountEffectiveDate">Effective Date: </label>
            <label class="wide-width-date">(dd/mm/yyyy)</label>
          </th>
          <td>
            <?php
            if (!empty($this->data['BuilderAccount']['effective_date']))
              echo $this->Form->input('BuilderAccount.effective_date', array('class' => 'dateP', 'placeholder' => 'DD/MM/YYYY', 'type' => 'text', 'value' => $this->Util->formatDate($this->data['BuilderAccount']['effective_date'])));
            else
              echo $this->Form->input('BuilderAccount.effective_date', array('class' => 'dateP', 'placeholder' => 'DD/MM/YYYY', 'type' => 'text'));
            ?>
          </td>
        </tr>
        <tr>
          <th><label for="BuilderAccountDiscountRate">Discount Rate: </label></th>
          <td>
            <?php echo $this->Form->input('BuilderAccount.discount_rate', array('class' => 'small-input')); ?>
          </td>
          <th><label for="BuilderAccountInvoiceOnDay">Invoice On Day: </label></th>
          <td>
            <?php echo $this->Form->input('BuilderAccount.invoice_on_day', array('placeholder' => 'Invoice On Day')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="BuilderAccountQuotesValidity">Quotes Validity: </label>
          </th>
          <td>
            <?php echo $this->Form->input('BuilderAccount.quotes_validity', array('class' => 'small-input')); ?> &nbsp;days
          </td>
          <th><label for="BuilderAccountDueOnDay">Due on day: </label></th>
          <td>
            <?php echo $this->Form->input('BuilderAccount.due_on_day', array('placeholder' => 'Due On Day')); ?>
          </td>
        </tr>
        <tr>
          <th><label for="BuilderAccountMultiUnit">Multi Unit: </label></th>
          <td class="radio-lable">
            <?php echo $this->Form->radio('BuilderAccount.multi_unit', array('Yes' => 'Yes', 'No' => 'No'), array('legend' => false)); ?>
          </td>
          <th><label for="BuilderAccountCreditLimit">Credit Limit($): </label></th>
          <td>
            <?php echo $this->Form->input('BuilderAccount.credit_limit', array('placeholder' => 'Credit Limit')); ?>
          </td>
        </tr>
        <tr>
          <th><label for="BuilderAccountRetailClient">Retail Client: </label></th>
          <td  class="radio-lable">
            <?php echo $this->Form->radio('BuilderAccount.retail_client', array('Yes' => 'Yes', 'No' => 'No'), array('legend' => false)); ?>
          </td>
          <th rowspan="3"><label for="BuilderAccountCreditTerms">Credit Terms: </label></th>
          <td rowspan="3">
            <?php echo $this->Form->input('BuilderAccount.credit_terms', array('placeholder' => 'Credit Terms', 'cols' => 30, 'rows' => 4)); ?>
          </td>
        </tr>
        <tr>
          <th><label for="BuilderAccountArAccount">AR Account: </label></th>
          <td>
            <?php echo $this->Form->input('BuilderAccount.ar_account', array('placeholder' => 'AR Account')); ?>
          </td>
        </tr>
        <tr>
          <th><label for="BuilderAccountApAccount">AP Account: </label></th>
          <td>
            <?php echo $this->Form->input('BuilderAccount.ap_account', array('placeholder' => 'AP Account')); ?>
          </td>
        </tr>
      </table>
    </div>
  </fieldset>
</div>

<script type="text/javascript">
	$(function(){
		$('.customer_name_valid').click(function(){
			var error_class = 'error';
			var validation_success = true;
			
			var first_name = $('#CustomerFirstName').val();
			var last_name = $('#CustomerLastName').val();
			var cnt = first_name.length + last_name.length;	
			
			if((cnt < 7)) {
				$('#CustomerFirstName').addClass(error_class);
				$('#CustomerLastName').addClass(error_class);
				$('.error-message-customer').show();
				validation_success = false;
			} else {
				$('#CustomerFirstName').removeClass(error_class);
				$('#CustomerLastName').removeClass(error_class);
				$('.error-message-customer').hide();
			}
			
			if(!validation_success) {
				return validation_success;
			}
		});
	})
</script>