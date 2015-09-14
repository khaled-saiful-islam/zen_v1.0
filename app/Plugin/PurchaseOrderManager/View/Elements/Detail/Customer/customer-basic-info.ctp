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
    <th><label for="CustomerStatus">Status: </label></th>
    <td><?php echo $customer['Customer']['status'] == 0 ? 'Inactive' : 'Active'; ?>&nbsp;</td>
    <th><label for="CustomerEmail">Email: </label></th>
    <td><?php echo h($customer['Customer']['email']); ?>
      &nbsp;</td>   
  </tr>
  <tr>
    <th><label for="CustomerPhone">Phone: </label></th>
    <td>
      <div class="marT5">
        <label for="CustomerPhone" class="no-width">Phone: 
          <?php echo __($customer['Customer']['phone']); ?>&nbsp;
          Ext:<?php echo __($customer['Customer']['phone_ext']); ?>&nbsp;<br/>
          <label for="CustomerCell" class="no-width">Cell: 
            <?php echo __($customer['Customer']['cell']); ?>&nbsp;<br/>
            <label class="no-width">Fax:
              <?php echo __($customer['Customer']['fax_number']); ?>&nbsp;
            </label>
          </label>
      </div>
    </td>
    <th><label for="CustomerAddress">Address: </label></th>
    <td>
      <?php echo __($customer['Customer']['address']); ?><br/>
      <div class="marT5">
        <?php echo __($customer['Customer']['city']); ?>,
        <?php echo __($customer['Customer']['province']); ?>
      </div>
      <div class="marT5">
        Canada-<?php echo __($customer['Customer']['postal_code']); ?>
      </div>
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
    <table class='table-form-big table-float-left'>
      <tr>
        <th colspan="2">
          <label style="text-decoration: underline; text-align: center;">Builder Account</label>
        </th>    
      </tr>
      <tr>
        <th><label for="BuilderAccountBuilderLegalName">Legal Name: </label></th>
        <td>
          <?php echo h($customer['BuilderAccount']['builder_legal_name']); ?>
          &nbsp;
        </td>    
      </tr>
      <tr>
        <th><label for="BuilderAccountDiscountRate">Discount Rate: </label></th>
        <td>
          <?php echo h($customer['BuilderAccount']['discount_rate']); ?>
          &nbsp;
        </td>    
      </tr>
      <tr>
        <th>
          <label for="BuilderAccountQuotesValidity">Quotes Validity: </label>
        </th>
        <td>
          <?php echo h($customer['BuilderAccount']['quotes_validity']); ?>
          &nbsp;days
        </td>    
      </tr>
      <tr>
        <th><label for="BuilderAccountMultiUnit">Multi Unit: </label></th>
        <td>
          <?php echo h($customer['BuilderAccount']['multi_unit']); ?>
          &nbsp;      
        </td>    
      </tr>
      <tr>
        <th><label for="BuilderAccountRetailClient">Retail Client: </label></th>
        <td>
          <?php echo h($customer['BuilderAccount']['retail_client']); ?>
          &nbsp;
        </td>    
      </tr>
      <tr>
        <th><label for="BuilderAccountArAccount">AR Account: </label></th>
        <td>
          <?php echo h($customer['BuilderAccount']['ar_account']); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th><label for="BuilderAccountApAccount">AP Account: </label></th>
        <td>
          <?php echo h($customer['BuilderAccount']['ap_account']); ?>
          &nbsp;
        </td>
      </tr>
    </table>
    <table class="table-form-big table-float-left">
      <tr>
        <th colspan="2">
          <label style="text-decoration: underline;text-align: center;">Builder Credit Info</label>
        </th>
      </tr>
      <tr>
        <th><label for="BuilderAccountEffectiveDate">Effective Date: </label></th>
        <td>
          <?php echo h($customer['BuilderAccount']['effective_date']); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th><label for="BuilderAccountInvoiceOnDay">Invoice On Day: </label></th>
        <td>
          <?php echo h($customer['BuilderAccount']['invoice_on_day']); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th><label for="BuilderAccountDueOnDay">Due on day: </label></th>
        <td>
          <?php echo h($customer['BuilderAccount']['due_on_day']); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th><label for="BuilderAccountCreditLimit">Credit Limit($): </label></th>
        <td>
          <?php echo h($customer['BuilderAccount']['credit_limit']); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th><label for="BuilderAccountCreditTerms">Credit Terms: </label></th>
        <td colspan="3">
          <?php echo h($customer['BuilderAccount']['credit_terms']); ?>
          &nbsp;
        </td>
      </tr>
    </table>
  </div>
  <?php
}
?>