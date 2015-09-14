<div class="customer_report_box">
  <div class="customer_report_box_title">Customer General Information</div>
  <table class="report_table">
    <tr>
      <th>Customer Name: </th>
      <td><?php echo h($customer['Customer']['first_name']) . " " . h($customer['Customer']['last_name']); ?></td>
    </tr>
    <tr>
      <th>Email: </th>
      <td><?php echo h($customer['Customer']['email']); ?></td>
    </tr>
    <tr>
      <th>Phone: </th>
      <td>
        <?php
        echo "Phone: " . h($customer['Customer']['phone']) . " Ext: " . $customer['Customer']['phone_ext'] . "</br>";
        echo "Cell: " . h($customer['Customer']['cell']) . "</br>";
        echo "Fax: " . h($customer['Customer']['fax_number']);
        ?>
      </td>
    </tr>
    <tr>
      <th>Address: </th>
      <td>
        <?php
        echo $this->InventoryLookup->address_format($customer['Customer']['address'], $customer['Customer']['city'], $customer['Customer']['province'], $customer['Customer']['country'], $customer['Customer']['postal_code']);
        ?>
      </td>
    </tr>
    <?php if ($customer['Customer']['site_address_exists'] == 0) { ?>
      <tr>
        <th>Site Address: </th>
        <td>
          <?php echo $this->InventoryLookup->address_format($customer['Customer']['site_address'], $customer['Customer']['site_city'], $customer['Customer']['site_province'], $customer['Customer']['site_country'], $customer['Customer']['site_postal_code']); ?>
        </td>
      </tr>
    <?php } else {
      ?>
      <tr>
        <th>Site Address: </th>
        <td>
          <?php echo "Same as Address"; ?>
        </td>
      </tr>
    <?php } ?>
    <tr>
      <th>Sales Rep: </th>
      <td>
        <?php
        $cnt = 1;
        foreach ($sales_representatives as $sales) {
          $user = $this->CustomerLookup->showSalesRepresentatives($sales['CustomerSalesRepresentetives']['user_id']);
          echo $cnt . ". " . $user['User']['first_name'] . " " . $user['User']['last_name'] . "</br>";
          $cnt++;
        }
        ?>
      </td>
    </tr>
    <tr>
      <th>Referral: </th>
      <td><?php echo h($customer['Customer']['referral']); ?></td>
    </tr>
    <tr>
      <th>Comments: </th>
      <td><?php echo h($customer['Customer']['remark']); ?></td>
    </tr>
  </table>
</div>

<div class="customer_report_box">
  <div class="customer_report_box_title_second">Customer Contact Information</div>
  <?php
  foreach ($customer['CustomerAddress'] as $cus) {
    ?>
    <div style="clear: both; border-top: 1px solid #000; "></div>
    <div class="customer_report_box_contact">
      <div class="customer_report_box_contact_first">
        <?php echo $cus['last_name'] . ", " . $cus['first_name'] . " " . "(" . $cus['title'] . ")"; ?>
      </div>
      <div class="customer_report_box_contact_second">
        <?php echo "<b>Email: </b>" . $cus['email']; ?>
      </div>
    </div>
    <div class="contact_second_part">
      <div class="contact_second_part_title">
        <b>Phone</b>
      </div>
      <div class="contact_second_part_phone">
        <?php
        echo "Phone: " . $cus['phone'] . "</br>";
        echo "Cell: " . $cus['cell'] . "</br>";
        echo "Fax: " . $cus['fax_number'];
        ?>
      </div>
    </div>
    <div class="contact_second_part">
      <div class="contact_second_part_title">
        <b>Address</b>
      </div>
      <div class="contact_second_part_phone">
        <?php echo $this->InventoryLookup->address_format($cus['address'], $cus['city'], $cus['province'], $cus['country'], $cus['postal_code']); ?>
      </div>
    </div>
    <div style="clear: both;"></div>
    <?php
  }
  ?>
</div>