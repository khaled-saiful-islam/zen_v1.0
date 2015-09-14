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
        <th><label for="BuilderAccountBuilderLegalName">Name: </label></th>
        <td colspan="2">
          <?php echo $this->Form->input('BuilderAccount.builder_legal_name', array('placeholder' => 'Legal Name', 'class' => 'required wide-input')); ?>
					<div style="color: red; display: none;" class="error-message-customer">Minimum 6 Characters</div>
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
          <?php echo $this->Form->input('phone', array('placeholder' => '(000) 000-0000', 'class' => 'small-wide-input fillone phone-mask')); ?>
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
          <?php echo $this->Form->input('cell', array('placeholder' => '(000) 000-0000', 'class' => 'small-wide-input fillone phone-mask')); ?>
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
        <th><label for="CustomerCustomerTypeId">Builder Type: </label></th>
        <td colspan="2">
          <?php echo $this->Form->input('customer_type_id', array('class' => 'required customer-type form-select', 'value' => '2', 'type' => 'hidden')); ?>
          <?php echo $this->Form->input('BuilderAccount.builder_type', array('class' => 'required customer-type form-select', 'options' => $this->InventoryLookup->InventoryLookup('builder_type'), 'empty' => ' ')); ?>
        </td>
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
        <th valign="top"><label for="CustomerReferral">Referral: </label></th>
        <td><?php echo $this->Form->input('referral', array('placeholder' => 'Referral', 'class' => 'form-select', 'options' => $this->InventoryLookup->InventoryLookup('referral'), 'empty' => '')); ?></td>
        <td><?php echo $this->Form->input('sales_representative', array('placeholder' => 'Sales Representatives', 'class' => 'form-select required wide-input', "multiple" => true, "options" => $this->InventoryLookup->salesPersonList(), "value" => isset($sales_data) ? unserialize($sales_data) : "")); ?></td>
      </tr>
      <tr>
        <th valign="top"><label for="CustomerRemark">Comment: </label></th>
        <td colspan="5"><?php echo $this->Form->input('remark', array('rows' => 2, 'cols' => 47, 'placeholder' => 'Comment', 'class' => '')); ?></td>
      </tr>
    </table>
    <?php
    $display = "style='display:nlock;'";
    ?>
    <div class="builder-account">
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
          <th><label for="BuilderAccountBuilderSupplyTypeId">Supply Type: </label></th>
          <td>
            <?php
            $builder_supply = array();
            if (isset($builder_supply_types) && is_array($builder_supply_types)) {
              foreach ($builder_supply_types as $builder_supply_type) {
                $builder_supply[$builder_supply_type['BuilderSupplyTypesList']['inventory_lookup_id']] = $builder_supply_type['BuilderSupplyTypesList']['inventory_lookup_id'];
              }
            }
            echo $this->Form->input('BuilderAccount.builder_supply_type_id', array('class' => 'form-select input-large', "multiple" => true, "options" => $this->InventoryLookup->InventoryLookup('builder_supply_type'), "selected" => isset($builder_supply) ? $builder_supply : ""));
            ?>
          </td>
          <th>
            <label for="BuilderAccountEffectiveDate">Effective Date: </label>
            <label class="wide-width-date">(dd/mm/yyyy)</label>
          </th>
          <td>
            <?php
            if (!empty($this->data['BuilderAccount']['effective_date']))
              echo $this->Form->input('BuilderAccount.effective_date', array('placeholder' => 'DD/MM/YYYY', 'type' => 'text', 'value' => $this->Util->formatDate($this->data['BuilderAccount']['effective_date'])));
            else
              echo $this->Form->input('BuilderAccount.effective_date', array('placeholder' => 'DD/MM/YYYY', 'type' => 'text'));
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
            <?php echo $this->Form->input('BuilderAccount.invoice_on_day', array('placeholder' => 'Invoice On Day', 'disabled' => true)); ?>
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
            <?php echo $this->Form->input('BuilderAccount.due_on_day', array('placeholder' => 'Due On Day', 'disabled' => true)); ?>
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
          <th><label for="BuilderAccountNoOfUnits">No. of Units: </label></th>
          <td>
            <?php echo $this->Form->input('BuilderAccount.no_of_units', array('placeholder' => 'No. of Units')); ?>
          </td>
        </tr>
        <tr>
          <th><label for="BuilderAccountNoOfHouses">No. of Houses: </label></th>
          <td>
            <?php echo $this->Form->input('BuilderAccount.no_of_houses', array('placeholder' => 'No. of Houses')); ?>
          </td>
        </tr>
<!--				<tr>
					<th><label for="QuoteSkidNumber">Multi Family Pricing: </label></th>
					<td colspan="2">
							<?php echo $this->Form->input('multi_family_pricing', array('type'=>'checkbox','label' => '', 'div' => true)); ?>
					</td>
				</tr>-->
      </table>
    </div>
  </fieldset>
</div>
<script type="text/javascript">
	$(function(){
		$("#BuilderAccountEffectiveDate").datepicker({ dateFormat:"dd/mm/yy" });
		
		$('.customer_name_valid').click(function(){
			var error_class = 'error';
			var validation_success = true;
			
			var legal_name = $('#BuilderAccountBuilderLegalName').val();
			var cnt = legal_name.length;	
			
			if((cnt < 7)) {
				$('#BuilderAccountBuilderLegalName').addClass(error_class);
				$('.error-message-customer').show();
				validation_success = false;
			} else {
				$('#BuilderAccountBuilderLegalName').removeClass(error_class);
				$('.error-message-customer').hide();
			}
			
			if(!validation_success) {
				return validation_success;
			}
		});
	})
</script>