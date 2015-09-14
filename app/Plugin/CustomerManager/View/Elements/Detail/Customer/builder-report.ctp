<div class="customer_report_box">
  <div class="customer_report_box_title">Builder General Information</div>
  <table class="report_table">
    <tr>
      <th>Builder Name: </th>
      <td class="value"><?php echo h($customer['BuilderAccount']['builder_legal_name']); ?></td>
    </tr>
    <tr>
      <th>Email: </th>
      <td class="value"><?php echo h($customer['Customer']['email']); ?></td>
    </tr>
    <tr>
      <th>Phone: </th>
      <td class="value">
        <?php
        echo "Phone: " . h($customer['Customer']['phone']) . " Ext: " . $customer['Customer']['phone_ext'] . "</br>";
        echo "Cell: " . h($customer['Customer']['cell']) . "</br>";
        echo "Fax: " . h($customer['Customer']['fax_number']);
        ?>
      </td>
    </tr>
    <tr>
      <th>Address: </th>
      <td class="value">
        <?php
        echo $this->InventoryLookup->address_format($customer['Customer']['address'], $customer['Customer']['city'], $customer['Customer']['province'], $customer['Customer']['country'], $customer['Customer']['postal_code']);
        ?>
      </td>
    </tr>
    <?php if ($customer['Customer']['site_address_exists'] == 0) { ?>
      <tr>
        <th>Site Address: </th>
        <td class="value">
          <?php echo $this->InventoryLookup->address_format($customer['Customer']['site_address'], $customer['Customer']['site_city'], $customer['Customer']['site_province'], $customer['Customer']['site_country'], $customer['Customer']['site_postal_code']); ?>
        </td>
      </tr>
    <?php } else {
      ?>
      <tr>
        <th>Site Address: </th>
        <td class="value">
          <?php echo "Same as Address"; ?>
        </td>
      </tr>
    <?php } ?>
    <tr>
      <th>Sales Rep: </th>
      <td class="value">
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
      <td class="value"><?php echo h($customer['Customer']['referral']); ?></td>
    </tr>
    <tr>
      <th>Referral: </th>
      <td class="value"><?php echo h($customer['Customer']['referral']); ?></td>
    </tr>
    <tr>
      <th>Comments: </th>
      <td class="value"><?php echo h($customer['Customer']['remark']); ?></td>
    </tr>
  </table>
</div>

<div class="customer_report_box">
  <div class="customer_report_box_title_second">Builder Contact Information</div>
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

<div class="customer_report_box">
  <div class="customer_report_box_title">Builder Account</div>
  <table class='report_table'>
    <tr>
      <th><label for="BuilderAccountBuilderSupplyTypeId">Supply Type: </label></th>
      <td class="value">
        <?php // echo h($customer['BuilderAccount']['builder_supply_type_id']); ?>
        <?php
        $cnt = 1;
        foreach ($builder_supply_types as $builder_supply) {
          echo $cnt . ". " . $this->InventoryLookup->InventoryLookupReverse($builder_supply['BuilderSupplyTypesList']['inventory_lookup_id']) . "</br>";
          $cnt++;
        }
        ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th><label for="BuilderAccountDiscountRate">Discount Rate: </label></th>
      <td class="value">
        <?php echo h($customer['BuilderAccount']['discount_rate']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th>
        <label for="BuilderAccountQuotesValidity">Quotes Validity: </label>
      </th>
      <td class="value">
        <?php if ($customer['BuilderAccount']['quotes_validity']) echo h($customer['BuilderAccount']['quotes_validity'] . " days"); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th><label for="BuilderAccountMultiUnit">Multi Unit: </label></th>
      <td class="value">
        <?php echo h($customer['BuilderAccount']['multi_unit']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th><label for="BuilderAccountRetailClient">Retail Client: </label></th>
      <td class="value">
        <?php echo h($customer['BuilderAccount']['retail_client']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th><label for="BuilderAccountNoOfUnits">No. of Units: </label></th>
      <td class="value">
        <?php echo h($customer['BuilderAccount']['no_of_units']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th><label for="BuilderAccountNoOfHouses">No. of Houses:  </label></th>
      <td class="value">
        <?php echo h($customer['BuilderAccount']['no_of_houses']); ?>
        &nbsp;
      </td>
    </tr>
  </table>
</div>

<div class="customer_report_box">
  <div class="customer_report_box_title">Builder Credit Info</div>
  <table class='report_table'>
    <tr>
      <th>
        <label for="BuilderAccountEffectiveDate">Effective Date: </label>
        <label class="wide-width-date">(dd/mm/yyyy)</label>
      </th>
      <td class="value">
        <?php echo $this->Util->formatDate($customer['BuilderAccount']['effective_date']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th><label for="BuilderAccountInvoiceOnDay">Invoice On Day: </label></th>
      <td class="value">
        <?php echo h($customer['BuilderAccount']['invoice_on_day']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th><label for="BuilderAccountDueOnDay">Due on day: </label></th>
      <td class="value">
        <?php echo h($customer['BuilderAccount']['due_on_day']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th><label for="BuilderAccountCreditLimit">Credit Limit($): </label></th>
      <td class="value">
        <?php echo h($customer['BuilderAccount']['credit_limit']); ?>
        &nbsp;
      </td>
    </tr>
    <tr>
      <th rowspan="3"><label for="BuilderAccountCreditTerms">Credit Terms: </label></th>
      <td rowspan="3">
        <?php echo h($customer['BuilderAccount']['credit_terms']); ?>
        &nbsp;
      </td>
    </tr>
  </table>
</div>
