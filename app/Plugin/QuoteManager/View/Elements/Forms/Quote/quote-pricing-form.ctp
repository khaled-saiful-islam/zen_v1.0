<fieldset>
  <?php if ($edit) { ?>
    <legend class='inner-legend'>
      Edit Pricing
    </legend>
  <?php } ?> 

  <div id="quote_pricing" >    
    <table class="table-form-big">
      <tbody>
        <tr>
          <th colspan="2">
            <label style="text-decoration: underline;cursor: text;">Countertop Material & Install</label>
          </th>
        </tr>
        <tr>
          <th>
            <label for="">Countertop Installation</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">5% Administration Fee</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">Subtotal for Installation</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">Subtotal for Material</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">Courier/Delivery Fee</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('value'=>'0.00')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">Total Counter Top</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table-form-big">
      <tbody>
        <tr>
          <th colspan="2">
            <label style="text-decoration: underline;cursor: text;">Special Counter Tops</label>
          </th>
        </tr>
        <tr>
          <th>
            <label for="">Supplier 1</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('value'=>'0.00')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">Supplier Reference</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('value'=>'0.00')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">Quote Date</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('value'=>'0.00')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">Quote Amount</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('value'=>'0.00')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">10% Murphy</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">Sub Total Quote1</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr>        
        <tr>
          <th>
            <label for="">Supplier 2</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('value'=>'0.00')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">Supplier Reference</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('value'=>'0.00')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">Quote Date</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('value'=>'0.00')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">Quote Amount</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('value'=>'0.00')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">10% Murphy</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">Sub Total Quote2</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table-form-big">
      <tbody>
        <tr>
          <th colspan="2">
            <label style="text-decoration: underline;cursor: text;">Cabinet Installation</label>
          </th>
        </tr>
        <tr>
          <th>
            <label for="">Cabinet Installation</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">5% Administration Fee</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">Total Cabinet Installation</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr>              
      </tbody>
    </table>
    <table class="table-form-big">
      <tbody>
        <tr>
          <th colspan="2">
            <label style="text-decoration: underline;cursor: text;">Service Charges</label>
          </th>
        </tr>
        <tr>
          <th>
            <label for="">Total Cabinet Installation</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">Eligible for Service</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">Service Rate(%)</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr> 
        <tr>
          <th>
            <label for="">Sub Total</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr> 
        <tr>
          <th>
            <label for="">Service Add</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('value'=>'0.00')); ?>
          </td>
        </tr> 
        <tr>
          <th>
            <label for="">Service CallBack</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('value'=>'0.00')); ?>
          </td>
        </tr> 
        <tr>
          <th>
            <label for="">Total Service</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr> 
      </tbody>
    </table>
    <table class="table-form-big">
      <tbody>
        <tr>
          <th colspan="2">
            <label style="text-decoration: underline;cursor: text;">Totals</label>
          </th>
        </tr>
        <tr>
          <th>
            <label for="">Cabinet Cost</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('value'=>'0.00')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">Shipping</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('value'=>'0.00')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">Total Counter Top Cost</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr> 
        <tr>
          <th>
            <label for="">Total Special Top Cost</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr> 
        <tr>
          <th>
            <label for="">Total Cabinet Installations</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr> 
        <tr>
          <th>
            <label for="">Total Service Cost</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr> 
        <tr>
          <th>
            <label for="">Calgary Extras</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr> 
        <tr>
          <th>
            <label for="">Sub Total(Job Cost)</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr> 
        <tr>
          <th>
            <label for="">Price Increase</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('value'=>'0.00')); ?>
          </td>
        </tr> 
        <tr>
          <th>
            <label for="">Sub Total:</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr> 
        <tr>
          <th>
            <label for="">Gross Margin:</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr> 
        <tr>
          <th>
            <label for="">Sub Total:</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr> 
        <tr>
          <th>
            <label for="">Small Order Bonus:</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('value'=>'0.00')); ?>
          </td>
        </tr> 
      </tbody>
    </table>
    <table class="table-form-big">
      <tbody>
        <tr>
          <th colspan="2">
            <label style="text-decoration: underline;cursor: text;">Price Breakdown</label>
          </th>
        </tr>
        <tr>
          <th>
            <label for="">Base Price:</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('value'=>'0.00')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">Total PO Upgrade:</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('value'=>'0.00')); ?>
          </td>
        </tr>
        <tr>
          <th>
            <label for="">Total Cash Upgrade:</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('value'=>'0.00')); ?>
          </td>
        </tr> 
        <tr>
          <th>
            <label for="">Invoice Builder:</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr> 
        <tr>
          <th>
            <label for="">Customer Upgrade:</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr> 
        <tr>
          <th>
            <label for="">Apex Portion:</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr> 
        <tr>
          <th>
            <label for="">Builder Credit:</label>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr>
        </tbody>
    </table>
    <table>
      <tbody>
        <tr>
          <th>
            <label for="">GST:</label>
          </th>
          <th>
            <label for="">PST:</label>
          </th>
          <th>
            <label for="">Total:</label>
          </th>
        </tr> 
        <tr>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr> 
        <tr>
          <td>
            <?php echo $this->Form->input('color', array('value'=>'0.00')); ?> %            
          </td>
          <th>
            <label>Total Order:</lable>
          </th>
          <td>
            <?php echo $this->Form->input('color', array('readonly'=>'readonly','value'=>'0.00')); ?>
          </td>
        </tr> 
        
      </tbody>
    </table>
  </div>
</fieldset>
