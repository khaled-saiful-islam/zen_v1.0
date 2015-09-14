<div class="report-print">

  <table class="report-left-box-info">
    <tr style="border-bottom: 1px solid #000; ">
      <th colspan="4">
        <label>Customer</label>
      </th>
    </tr>
    <tr>
      <th>
        <label>Name</label>
      </th>
      <td colspan="3">
        <?php echo h($quote['Customer']['name']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th>
        <label>Address</label>
      </th>
      <td colspan="3">
        <?php echo h($quote['Customer']['address']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th>
        <label>City</label>
      </th>
      <td>
        <?php echo h($quote['Customer']['city']); ?>
        &nbsp;
      </td>
      <th>
        <label>Province</label>
      </th>
      <td>
        <?php echo h($quote['Customer']['province']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th>
        <label>Phone</label>
      </th>
      <td>
        <?php echo h($quote['Customer']['phone']); ?>
        &nbsp;
      </td>
      <th>
        <label>Postal Code</label>
      </th>
      <td>
        <?php echo h($quote['Customer']['postal_code']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th>
        <label>Sales Person</label>
      </th>
      <td colspan="3">
        <?php echo h($quote['User']['first_name']); ?>
        &nbsp;
        <?php echo h($quote['User']['last_name']); ?>
      </td>
    </tr> 
    <tr>
      <th>
        <label>Ship Date</label>
      </th>
      <td colspan="3">
        <?php echo $this->Util->formatDate(h($quote['Quote']['est_shipping'])); ?>
        &nbsp;        
      </td>
    </tr> 
  </table>
  <table class="report-right-box-info">
    <tr>
      <th>
        <label>Start Date</label>
      </th>
      <td>
        <?php echo date('d/m/Y', strtotime(h($quote['Quote']['created']))); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th>
        <label>Color</label>
      </th>
      <td>
        <?php echo h($quote['Quote']['color']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th>
        <label>Style</label>
      </th>
      <td>
        <?php echo h($quote['Quote']['style']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th>
        <label>CabOrder#</label>
      </th>
      <td>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th>
        <label>Builder#</label>
      </th>
      <td>
        <?php echo h($quote['Quote']['builder_job']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th>
        <label>Builder PO</label>
      </th>
      <td>
        <?php echo h($quote['Quote']['builder_po']); ?>
        &nbsp;
      </td>
    </tr>  
  </table>
  <div class="clear"></div><br/>
  <table class="table-form-big" style="width: 734px;">
    <tr>
      <th >
        <label style="text-align: center;">
          Counter Top Selection
        </label>
      </th>
    </tr>
    <tr>
      <?php echo $this->element('Detail/Quote/quote-counter-top-detail',array('edit'=>false)); ?>
    </tr>
  </table>
  <br/>
  
  
</div>