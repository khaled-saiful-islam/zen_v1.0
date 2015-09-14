<div class="invoice report-print">
  <?php
  if ($invoice['Invoice']['invoice_of'] == 'Purchase Order') {
    $data_set = json_decode($invoice['Invoice']['data_set']);
//    debug($data_set);
    ?>
    <table class="report-left-box-info">
      <tr style="border-bottom: 1px solid #000; ">
        <th colspan="4">
          <label>Supplier</label>
        </th>
      </tr>
      <tr>
        <th>
          <label>Name</label>
        </th>
        <td colspan="3">
          <?php echo h($data_set->supplier->name); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th>
          <label>Address</label>
        </th>
        <td colspan="3">
          <?php echo h($data_set->supplier->address); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th>
          <label>City</label>
        </th>
        <td>
          <?php echo h($data_set->supplier->city); ?>
          &nbsp;
        </td>
        <th>
          <label>Province</label>
        </th>
        <td>
          <?php echo h($data_set->supplier->province); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th>
          <label>Phone</label>
        </th>
        <td>
          <?php echo h($data_set->supplier->phone); ?>
          &nbsp;
        </td>
        <th>
          <label>Postal Code</label>
        </th>
        <td>
          <?php echo h($data_set->supplier->postal_code); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th>
          <label>Fax</label>
        </th>
        <td colspan="3">
          <?php echo h($data_set->supplier->fax); ?>
          &nbsp;
        </td>
      </tr>    
    </table>

    <table class="report-right-box-info">
      <tr style="border-bottom: 1px solid #000; ">
        <th colspan="4">
          <label>Ship To</label>
        </th>
      </tr>
      <tr>
        <th>
          <label>Name</label>
        </th>
        <td colspan="3">
          <?php echo h($invoice['PurchaseOrder']['name_ship_to']); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th>
          <label>Address</label>
        </th>
        <td colspan="3">
          <?php echo h($invoice['PurchaseOrder']['address']); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th>
          <label>City</label>
        </th>
        <td>
          <?php echo h($invoice['PurchaseOrder']['city']); ?>
          &nbsp;
        </td>
        <th>
          <label>Province</label>
        </th>
        <td>
          <?php echo h($invoice['PurchaseOrder']['province']); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th>
          <label>Phone</label>
        </th>
        <td>
          <?php echo h($invoice['PurchaseOrder']['phone']); ?>
          &nbsp;
        </td>
        <th>
          <label>Postal Code</label>
        </th>
        <td>
          <?php echo h($invoice['PurchaseOrder']['postal_code']); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th>
          <label>Fax</label>
        </th>
        <td colspan="3">
          <?php echo h($invoice['PurchaseOrder']['fax']); ?>
          &nbsp;
        </td>
      </tr>    
    </table>
    <table class="service-detail">
      <tr class="top-row">
        <th>
          <label>Ship When</label>
        </th>
        <th>
          <label>Ship Via</label>
        </th>
        <th>
          <label>F.O.B Point</label>
        </th>
        <th>
          <label>Terms</label>
        </th>
      </tr>
      <tr>
        <td class="text-center">
          <?php echo $this->Util->formatDate(h($invoice['PurchaseOrder']['shipment_date'])); ?>
          &nbsp;
        </td>
        <td class="text-center">
          <?php echo h($invoice['PurchaseOrder']['shipment_via']); ?>&nbsp;
        </td>
        <td class="text-center">
          <?php echo h($invoice['PurchaseOrder']['f_o_b_point']); ?>
        </td>
        <td>
          <?php echo h($invoice['PurchaseOrder']['term']); ?>
          &nbsp;
        </td>
      </tr>      
    </table>
    <h2 style="float: left; font-size: 14px; margin-left: 32px; width: 100%;">
      <?php echo __('Items Information'); ?>
    </h2>
    <table class="table table-bordered table-hover listing table-form-big-margin">
      <thead>
        <tr class="grid-header">          
          <th><?php echo __('Qty'); ?></th>
          <th><?php echo __('Number'); ?></th>
          <th><?php echo __('Description'); ?></th>
          <th><?php echo __('Each Cost'); ?></th>
          <th><?php echo __('Total Cost'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php
        $total_cost = 0.00;
        if (!empty($data_set->items)) {
          foreach ($data_set->items as $index => $value) {
            ?>
            <tr>
              <td>
                <?php echo h($value->qty); ?>
              </td>
              <td>
                <?php echo h($value->number); ?>
              </td>
              <td>
                <?php echo h($value->desc); ?>
              </td>
              <td>
                <?php echo h($value->price); ?>
              </td>
              <td>
                <?php echo h($value->total); ?>
              </td>
            </tr>
            <?php
          }
          ?>
          <tr>
            <td colspan="4" class="text-right" style="font-weight: bold;">
              Total:	
            </td>
            <td>
              <span class='data-item-total-cost'><?php echo number_format($data_set->total, 2, '.', ''); ?></span>
            </td>
          </tr>        
        </tbody>
      <?php } else { ?>
        <tr>
          <td colspan="7" class="text-right" style="font-weight: bold;">
            <label class="text-cursor-normal">No data here</label>
          </td>
        </tr>   
      <?php } ?>
    </table>
  <?php } elseif ($invoice['Invoice']['invoice_of'] == 'Quote') {
    $data_set = json_decode($invoice['Invoice']['data_set']);
//    debug($data_set);
    ?>
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
          <?php echo h($data_set->customer->name); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th>
          <label>Address</label>
        </th>
        <td colspan="3">
          <?php echo h($data_set->customer->address); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th>
          <label>City</label>
        </th>
        <td>
          <?php echo h($data_set->customer->city); ?>
          &nbsp;
        </td>
        <th>
          <label>Province</label>
        </th>
        <td>
          <?php echo h($data_set->customer->province); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th>
          <label>Phone</label>
        </th>
        <td>
          <?php echo h($data_set->customer->phone); ?>
          &nbsp;
        </td>
        <th>
          <label>Postal Code</label>
        </th>
        <td>
          <?php echo h($data_set->customer->postal_code); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th>
          <label>Fax</label>
        </th>
        <td colspan="3">
          <?php echo h($data_set->customer->fax); ?>
          &nbsp;
        </td>
      </tr>    
    </table>
  <?php } ?>
  <h2 style="float: left; font-size: 14px; margin-left: 32px; width: 100%;">
    <?php echo __('Invoice Status'); ?>
  </h2>
  <?php echo $this->element('Detail/Invoice/invoice-status-info', array('edit' => false)); ?>
</div>