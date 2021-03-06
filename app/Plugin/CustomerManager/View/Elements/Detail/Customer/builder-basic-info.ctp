<?php
if (isset($modal) && $modal == "modal") {
  ?>
  <table class='table-form-big margin-bottom'>
    <tr>
      <th><label for="CustomerFirstName">Name: </label></th>
      <td>
        <?php echo h($customer['BuilderAccount']['builder_legal_name']); ?>
      </td>
      <th><label for="CustomerCustomerTypeId">Builder Type: </label></th>
      <td><?php echo __($customer['CustomerType']['name']); ?>&nbsp;</td>
    </tr>
    <tr>
      <th><label for="CustomerEmail">Email: </label></th>
      <td><?php echo h($customer['Customer']['email']); ?>
        &nbsp;</td>
      <th><label for="CustomerStatus">Status: </label></th>
      <td><?php echo h($customer['Customer']['status'] == 0 ? 'Inactive' : 'Active'); ?>&nbsp;</td>
    </tr>
    <tr>
      <th><label for="CustomerPhone">Phone: </label></th>
      <td>
        <?php echo $this->InventoryLookup->phone_format($customer['Customer']['phone'], $customer['Customer']['phone_ext'], $customer['Customer']['cell'], $customer['Customer']['fax_number']); ?>
      </td>
      <th><label for="CustomerAddress">Address: </label></th>
      <td>
        <?php echo $this->InventoryLookup->address_format($customer['Customer']['address'], $customer['Customer']['city'], $customer['Customer']['province'], $customer['Customer']['country'], $customer['Customer']['postal_code']); ?>
      </td>
    </tr>
    <tr>
      <th valign="top"><label for="CustomerRemark">Comment: </label></th>
      <td colspan="3">
        <?php echo h($customer['Customer']['remark']); ?>
        &nbsp;
      </td>
    </tr>
  </table>
<?php } else {
  ?>
  <div class="detail actions">
    <?php
    if ($edit) {
      echo $this->Html->link('Edit', array('action' => EDIT, $customer['Customer']['id'], 'basic'), array('data-target' => '#builder-basic-info', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Edit')));
    }
    ?>
  </div>
  <table class='table-form-big'>
    <tr>
      <th><label for="CustomerFirstName">Name: </label></th>
      <td>
        <?php echo h($customer['BuilderAccount']['builder_legal_name']); ?>
      </td>
      <th><label for="CustomerCustomerTypeId">Builder Type: </label></th>
      <td><?php echo h($customer['CustomerType']['name']); ?>&nbsp;</td>
    </tr>
    <tr>
      <th><label for="CustomerEmail">Email: </label></th>
      <td><?php echo h($customer['Customer']['email']); ?>
        &nbsp;</td>
      <th><label for="CustomerStatus">Status: </label></th>
      <td><?php echo h($customer['Customer']['status'] == 0 ? 'Inactive' : 'Active'); ?>&nbsp;</td>
    </tr>
    <tr>
      <th><label for="CustomerPhone">Phone: </label></th>
      <td>
        <?php echo $this->InventoryLookup->phone_format($customer['Customer']['phone'], $customer['Customer']['phone_ext'], $customer['Customer']['cell'], $customer['Customer']['fax_number']); ?>
      </td>
      <th><label for="CustomerAddress">Address: </label></th>
      <td>
        <table>
          <tr>
            <td>
              <?php echo $this->InventoryLookup->address_format($customer['Customer']['address'], $customer['Customer']['city'], $customer['Customer']['province'], $customer['Customer']['country'], $customer['Customer']['postal_code']); ?>
            </td>
          </tr>
          <?php if ($customer['Customer']['site_address_exists'] == 0) { ?>
            <tr>
              <td>
                <b>Site Address:</b> <br />
                <?php echo $this->InventoryLookup->address_format($customer['Customer']['site_address'], $customer['Customer']['site_city'], $customer['Customer']['site_province'], $customer['Customer']['site_country'], $customer['Customer']['site_postal_code']); ?>
              </td>
            </tr>
          <?php } ?>
        </table>
      </td>
    </tr>
    <tr>
      <th><label for="CustomerSalesPerson">Sales Persons: </label></th>
      <td>
        <?php
//        $cnt = 1;
//        foreach ($sales_representatives as $sales) {
//          $user = $this->CustomerLookup->showSalesRepresentatives($sales['CustomerSalesRepresentetives']['user_id']);
//          echo $cnt . ". " . $user['User']['first_name'] . " " . $user['User']['last_name'] . "</br>";
//          $cnt++;
//        }
        ?>
				<?php 
					$sales = unserialize($customer['Customer']['sales_representatives']); 
					$cnt = count($sales);
					$j = 1;
					for($i = 0; $i<$cnt; $i++){
						$sales_person = $this->InventoryLookup->salesPersonDetail($sales[$i]);
						echo $j.". " . $sales_person['User']['first_name']. " " . $sales_person['User']['last_name']."</br>";
						$j++;
					}						
				?>
      </td>
      <th valign="top"><label for="CustomerReferral">Referral: </label></th>
      <td>
        <?php echo h($this->InventoryLookup->InventoryLookupReverse($customer['Customer']['referral'])); ?>
        &nbsp;
      </td>
    </tr>
    <tr colspan="3">
      <th valign="top"><label for="CustomerRemark">Comment: </label></th>
      <td>
        <?php echo h($customer['Customer']['remark']); ?>
        &nbsp;
      </td>
    </tr>
  </table>
  <div class="builder-account-credit">
    <table class='table-form-big'>
      <tr>
        <th colspan="2" class="table-th-col-title table-separator-right">
          <label style="text-decoration: underline; text-align: left;">Builder Account</label>
        </th>
        <th colspan="2" class="table-th-col-title">
          <label style="text-decoration: underline;text-align: left;">Builder Credit Info</label>
        </th>
      </tr>
      <tr>
        <th><label for="BuilderAccountBuilderSupplyTypeId">Supply Type: </label></th>
        <td>
          <?php // echo h($customer['BuilderAccount']['builder_supply_type_id']); ?>
          <?php
          $cnt = 1;
          foreach ($builder_supply_types as $builder_supply) {
            echo $cnt . ". " . $this->InventoryLookup->InventoryLookupReverse($builder_supply['BuilderSupplyTypesList']['inventory_lookup_id']) . "</br>";
            $cnt++;
          }
          ?>
          &nbsp;
        </td>
        <th>
          <label for="BuilderAccountEffectiveDate">Effective Date: </label>
          <label class="wide-width-date">(dd/mm/yyyy)</label>
        </th>
        <td>
          <?php echo $this->Util->formatDate($customer['BuilderAccount']['effective_date']); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th><label for="BuilderAccountDiscountRate">Discount Rate: </label></th>
        <td>
          <?php echo h($customer['BuilderAccount']['discount_rate']); ?>
          &nbsp;
        </td>
        <th><label for="BuilderAccountInvoiceOnDay">Invoice On Day: </label></th>
        <td>
          <?php echo h($customer['BuilderAccount']['invoice_on_day']); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th>
          <label for="BuilderAccountQuotesValidity">Quotes Validity: </label>
        </th>
        <td>
          <?php if ($customer['BuilderAccount']['quotes_validity']) echo h($customer['BuilderAccount']['quotes_validity'] . " days"); ?>
          &nbsp;
        </td>
        <th><label for="BuilderAccountDueOnDay">Due on day: </label></th>
        <td>
          <?php echo h($customer['BuilderAccount']['due_on_day']); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th><label for="BuilderAccountMultiUnit">Multi Unit: </label></th>
        <td>
          <?php echo h($customer['BuilderAccount']['multi_unit']); ?>
          &nbsp;
        </td>
        <th><label for="BuilderAccountCreditLimit">Credit Limit($): </label></th>
        <td>
          <?php echo h($customer['BuilderAccount']['credit_limit']); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th><label for="BuilderAccountRetailClient">Retail Client: </label></th>
        <td>
          <?php echo h($customer['BuilderAccount']['retail_client']); ?>
          &nbsp;
        </td>
        <th rowspan="3"><label for="BuilderAccountCreditTerms">Credit Terms: </label></th>
        <td rowspan="3">
          <?php echo h($customer['BuilderAccount']['credit_terms']); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th><label for="BuilderAccountNoOfUnits">No. of Units: </label></th>
        <td>
          <?php echo h($customer['BuilderAccount']['no_of_units']); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th><label for="BuilderAccountNoOfHouses">No. of Houses:  </label></th>
        <td>
          <?php echo h($customer['BuilderAccount']['no_of_houses']); ?>
          &nbsp;
        </td>
      </tr>
<!--			<tr>
        <th><label>Multi Family Pricing:  </label></th>
        <td>
          <?php 
						if($customer['Customer']['multi_family_pricing'] == 1)
							echo "Yes"; 
						if($customer['Customer']['multi_family_pricing'] == 0)
							echo "No";
					?>
          &nbsp;
        </td>
      </tr>-->
    </table>
  </div>
<?php } ?>