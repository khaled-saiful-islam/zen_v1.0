<div class="detail actions">
  <?php echo $this->Html->link('Edit Customer', array('action' => EDIT, $customer['Customer']['id'], 'basic'), array('data-target' => '#customer-basic-info', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Edit Customer'))); ?>
</div>
<table class='table-form-big'>
  <tr>
    <th><label for="CustomerFirstName">Name: </label></th>
    <td>
      <?php echo h($customer['Customer']['first_name']); ?>
      &nbsp;
      <?php echo h($customer['Customer']['last_name']); ?>
    </td>
    <th><label for="CustomerCustomerTypeId">Customer Type: </label></th>
    <td><?php echo __($customer['CustomerType']['name']); ?>&nbsp;</td> 
  </tr>
  <tr>
    <th><label for="CustomerEmail">Email: </label></th>
    <td><?php echo h($customer['Customer']['email']); ?>
      &nbsp;</td>  
    <th><label for="CustomerStatus">Status: </label></th>
    <td><?php echo $customer['Customer']['status'] == 0 ? 'Inactive' : 'Active'; ?>&nbsp;</td>     
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
    <th valign="top"><label for="CustomerRemark">Re-mark: </label></th>
    <td colspan="3">
      <?php echo h($customer['Customer']['remark']); ?>
      &nbsp;
    </td>
  </tr>
</table>
<?php
if ($customer['Customer']['customer_type_id'] == '2' || $customer['Customer']['customer_type_id'] == '3') {
  ?>
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
        <th><label for="BuilderAccountBuilderLegalName">Legal Name: </label></th>
        <td>
          <?php echo h($customer['BuilderAccount']['builder_legal_name']); ?>
          &nbsp;
        </td>   
        <th><label for="BuilderAccountEffectiveDate">Effective Date: </label></th>
        <td>
          <?php echo h($this->Util->formatDate($customer['BuilderAccount']['effective_date'])); ?>
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
        <th><label for="BuilderAccountCreditTerms">Credit Terms: </label></th>
        <td>
          <?php echo h($customer['BuilderAccount']['credit_terms']); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th><label for="BuilderAccountArAccount">AR Account: </label></th>
        <td>
          <?php echo h($customer['BuilderAccount']['ar_account']); ?>
          &nbsp;
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th><label for="BuilderAccountApAccount">AP Account: </label></th>
        <td>
          <?php echo h($customer['BuilderAccount']['ap_account']); ?>
          &nbsp;
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          &nbsp;
        </td>
      </tr>
    </table>    
  </div>
  <?php
}
?>