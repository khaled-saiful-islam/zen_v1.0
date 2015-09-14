<fieldset>
  <legend>
    <?php echo $legend.' of '.$type; ?>
  </legend>
  <?php
    $invoice_no = $this->InventoryLookup->auto_generate_number('Invoice');
    $invoice_status = $this->InventoryLookup->invoice_status_list();
    debug($invoice_status);
  ?>
  <table class="table-form-big">
    <tr>
      <th>
        <label>Invoice Number:</label>
      </th>
      <td>
        <?php
        echo $this->Form->input('invoice_no',array('readonly'=>true,'value'=>$invoice_no));
        ?>
      </td>
      <th>
        <label>Invoice Ref.:</label>
      </th>
      <td>
        <?php
        echo $this->Form->input('invoice_ref',array('value'=>$type,'readonly'=>true));
        ?>
      </td>
    </tr>
    <tr>
      <th>
        <label>Ref. Number:</label>
      </th>
      <td>
        <?php
        echo $this->Form->input('ref_id',array('readonly'=>true,'value'=>$invoice_no));
        ?>
        <?php
        echo $this->Form->input('ref_id',array('readonly'=>true,'value'=>$invoice_no));
        ?>
      </td>
      <th>
        <label>Total:</label>
      </th>
      <td>
        <?php
        echo $this->Form->input('total',array('value'=>$type,'readonly'=>true));
        ?>
      </td>
    </tr>
    <tr>
      <th>
        <label>Status:</label>
      </th>
      <td>
        <?php
        echo $this->Form->input('invoice_status_id',array('placeholder'=>'Status','empty'=>true,'options'=>$this->InventoryLookup->invoice_status_list(),'class'=>'form-select'));
        ?>
      </td>
    </tr>
  </table>
</fieldset>