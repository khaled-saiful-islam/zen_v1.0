<?php
$data_set = json_decode($invoice['Invoice']['data_set']);
?>
<table class="table-form-big">
  <tr>
    <th>
      <label>Invoice Number:</label>
    </th>
    <td>
      <?php echo h($invoice['Invoice']['invoice_no']); ?>
    </td>
    <th>
      <label>Invoice Of</label>
    </th>
    <td>
      <?php echo h($invoice['Invoice']['invoice_of']); ?> (<?php echo h($data_set->ref_number); ?>)
    </td>
  </tr>
  <tr>
    <th>
      <label>Total:</label>
    </th>
    <td colspan="3">
      <?php echo h($invoice['Invoice']['total']); ?>
    </td>    
  </tr>
</table>
<?php
if ($data_set->items) {
  ?>
  <table class="table table-bordered table-hover listing table-form-big-margin" style="width: 700px;">
    <tr class="grid-header">
      <th>
        <a href="#">Number</a>
      </th>
      <th>
        <a href="#">Description</a>
      </th>
      <th>
        <a href="#">Quantity</a>
      </th>
      <th>
        <a href="#">Price</a>
      </th>
      <th>
        <a href="#">Total</a>
      </th>
    </tr>
    <?php
    $total = 0.00;
    foreach ($data_set->items as $item) {
      $total+=$item->total;
      ?>
      <tr>
        <td>
          <?php echo h($item->number); ?>
        </td>
        <td>
          <?php echo h($item->desc); ?>
        </td>
        <td>
          <?php echo h($item->qty); ?>
        </td>
        <td>
          <?php echo h($item->price); ?>
        </td>
        <td>
          <?php echo h($item->total); ?>
        </td>
      </tr>
      <?php
    }
    ?>
    <tr>
      <td colspan="4">

      </td>
      <td>
        <?php echo h(number_format($total,2,'.','')); ?>
      </td>
    </tr>
  </table>
  <?php
}
?>