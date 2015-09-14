<?php //debug($this->Customer);  ?>
<div class="customers form">   
  <fieldset>
    <legend><?php echo __($legend); ?></legend>
    <table class='table-form-big'>
      <tr>
        <th><label for="BuilderAccountDiscountRate">Discount rate(%): </label></th>
        <td>
          <?php echo $this->Form->input('discount_rate'); ?>
          <?php echo $this->Form->input('customer_id', array('type' => 'hidden', 'value' => $id)); ?>
          <?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
        </td>
        <th><label for="BuilderAccountQuotesValidity">Quotes Validity: </label></th>
        <td>
          <?php echo $this->Form->input('quotes_validity'); ?> &nbsp;days
        </td>                
      </tr>
      <tr>
        <th><label for="BuilderAccountMultiUnit">Multi Unit: </label></th>
        <td>
          <?php echo $this->Form->radio('multi_unit', array('Yes' => 'Yes', 'No' => 'No'), array('legend' => false)); ?>
        </td>                
        <th><label for="BuilderAccountRetailClient">Retail Client: </label></th>
        <td>
          <?php echo $this->Form->radio('retail_client', array('Yes' => 'Yes', 'No' => 'No'), array('legend' => false)); ?>
        </td>
      </tr>
      <tr>
        <th><label for="BuilderAccountArAccount">AR Account: </label></th>
        <td>
          <?php echo $this->Form->input('ar_account'); ?>
        </td>
        <th><label for="BuilderAccountApAccount">AP Account: </label></th>
        <td>
          <?php echo $this->Form->input('ap_account'); ?>
        </td>
      </tr>
      <tr>
        <th><label for="BuilderAccountEffectiveDate">Effective Date: </label></th>
        <td>
          <?php echo $this->Form->input('effective_date', array('class' => 'dateP')); ?>
        </td>
        <th><label for="BuilderAccountInvoiceOnDay">Invoice On Day: </label></th>
        <td>
          <?php echo $this->Form->input('invoice_on_day'); ?>
        </td>
      </tr>
      <tr>
        <th><label for="BuilderAccountDueOnDay">Due on day: </label></th>
        <td>
          <?php echo $this->Form->input('due_on_day'); ?>
        </td>
        <th><label for="BuilderAccountCreditLimit">Credit Limit: </label></th>
        <td>
          $&nbsp;<?php echo $this->Form->input('credit_limit'); ?>
        </td>
      </tr>
      <tr>
        <th><label for="BuilderAccountCreditTerms">Credit Terms: </label></th>
        <td colspan="3">
          <?php echo $this->Form->input('credit_terms', array('style' => 'width:300px;')); ?>
        </td>
      </tr>
    </table>
  </fieldset>
</div>