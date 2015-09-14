<div class="customer_report_box">
  <div class="customer_report_box_title">Supplier General Information</div>
  <table class="report_table">
    <tr>
      <th>Supplier Name: </th>
      <td><?php echo h($supplier['Supplier']['name']); ?></td>
    </tr>
    <tr>
      <th>Email: </th>
      <td><?php echo h($supplier['Supplier']['email']); ?></td>
    </tr>
    <tr>
      <th>Website: </th>
      <td><?php echo h($supplier['Supplier']['website']); ?></td>
    </tr>
    <tr>
      <th>Phone: </th>
      <td>
        <?php
        echo "Phone: " . h($supplier['Supplier']['phone']) . " Ext: " . $supplier['Supplier']['phone_ext'] . "</br>";
        echo "Cell: " . h($supplier['Supplier']['cell']) . "</br>";
        echo "Fax: " . h($supplier['Supplier']['fax_number']);
        ?>
      </td>
    </tr>
    <tr>
      <th>Address: </th>
      <td>
        <?php
        echo $this->InventoryLookup->address_format($supplier['Supplier']['address'], $supplier['Supplier']['city'], $supplier['Supplier']['province'], $supplier['Supplier']['country'], $supplier['Supplier']['postal_code']);
        ?>
      </td>
    </tr>
    <tr>
      <th>Employee Representative: </th>
      <td>
        <?php
        if (isset($supplier['Supplier']['employee_rep'])) {
          $cnt = 1;
          $employee_representatives = unserialize($supplier['Supplier']['employee_rep']);
          if (is_array($employee_representatives)) {
            foreach ($employee_representatives as $employee_rep) {
              $user = $this->CustomerLookup->showSalesRepresentatives($employee_rep);
              echo $cnt . ". " . $user['User']['first_name'] . " " . $user['User']['last_name'] . "</br>";
              $cnt++;
            }
          }
        }
        ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th>Supplier Type: </th>
      <td class="radio-lable">
        <?php
        if (isset($supplier['Supplier']['supplier_type'])) {
          $cnt = 1;
          $supplier_types = unserialize($supplier['Supplier']['supplier_type']);
          if (is_array($supplier_types)) {
            foreach ($supplier_types as $supplier_type) {
              echo $cnt . ". " . h($this->InventoryLookup->InventoryLookupReverse($supplier_type)) . "</br>";
              $cnt++;
            }
          }
        }
        ?>
      </td>
    </tr>
    <tr>
      <th>QB Supplier Name: </th>
      <td><?php echo h($supplier['Supplier']['qb_suplier_name']); ?></td>
    </tr>
    <tr>
      <th><!--Default PO Type: --></th>
      <td><?php //echo h($supplier['Supplier']['default_po_type']); ?></td>
    </tr>
    <tr>
      <th>GST Rate(%): </th>
      <td><?php echo h($supplier['Supplier']['gst_rate']); ?></td>
    </tr>
    <tr>
      <th> 	PST Rate(%): </th>
      <td><?php echo h($supplier['Supplier']['pst_rate']); ?></td>
    </tr>
    <tr>
      <th>Terms: </th>
      <td><?php echo h($supplier['Supplier']['terms']); ?></td>
    </tr>
    <tr>
      <th>Notes: </th>
      <td><?php echo h($supplier['Supplier']['notes']); ?></td>
    </tr>
    <tr>
      <th>Notes (on PO): </th>
      <td><?php echo h($supplier['Supplier']['notes_on_po']); ?></td>
    </tr>
  </table>
</div>

<div class="customer_report_box">
  <div class="customer_report_box_title_second">Supplier Contact Information</div>
  <?php
  foreach ($supplier['SupplierContact'] as $sup) {
    ?>
    <div style="clear: both; border-top: 1px solid #000; "></div>
    <div class="customer_report_box_contact">
      <div class="customer_report_box_contact_first">
        <?php echo $sup['last_name'] . ", " . $sup['first_name'] . " " . "(" . $sup['title'] . ")"; ?>
      </div>
      <div class="customer_report_box_contact_second">
        <?php echo "<b>Email: </b>" . $sup['email']; ?>
      </div>
    </div>
    <div class="contact_second_part">
      <div class="contact_second_part_title">
        <b>Phones</b>
      </div>
      <div class="contact_second_part_phone">
        <?php
        echo "Phone: " . $sup['phone'] . "</br>";
        echo "Cell: " . $sup['cell'] . "</br>";
        echo "Fax: " . $sup['fax_number'];
        ?>
      </div>
      <div class="clr"></div>
    </div>
    <div class="contact_second_part">
      <div class="contact_second_part_title">
        <b>Address</b>
      </div>
      <div class="contact_second_part_phone">
        <?php echo $this->InventoryLookup->address_format($sup['address'], $sup['city'], $sup['province'], $sup['country'], $sup['postal_code']); ?>
      </div>
    </div>
    <div style="clear: both;"></div>
    <?php
  }
  ?>
</div>