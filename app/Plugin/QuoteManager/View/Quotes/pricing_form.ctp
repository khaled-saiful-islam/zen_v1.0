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
        <label>Toronto#</label>
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
  <div style="float: left;width: 350px;">
    <table class="order-pricing">
      <tr class="title-row">
        <th colspan="3">
          <label style="text-align: center;">Cabinet Installation</label>
        </th>
      </tr>
      <tr>
        <td class="wide-width">
          Base Installation Cost
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          &nbsp;
        </td>
      </tr>
      <tr>
        <td>
          5% Administration Fee
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          0.00
        </td>
      </tr>
      <tr>
        <td>
          Total Installation Cost
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          0.00
        </td>
      </tr>
    </table>
    <div class="clear"></div><br/>
    <table class="order-pricing">
      <tr class="title-row">
        <th colspan="3">
          <label style="text-align: center;">Counter Top Installation</label>
        </th>
      </tr>
      <tr>
        <td class="wide-width">
          Base Installation Cost
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          &nbsp;
        </td>
      </tr>
      <tr>
        <td>
          5% Administration Fee
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          0.00
        </td>
        
      </tr>
      <tr>
        <td>
          Counter Laminate Cost
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          &nbsp;
        </td>
      </tr>
      <tr>
        <td>
          Other Counter Material
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          &nbsp;
        </td>
      </tr>
      <tr>
        <td>
          Courier Fee
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          0.00
        </td>
      </tr>
      <tr>
        <td>
          Total Installation Cost
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          0.00
        </td>
      </tr>
    </table>
    <div class="clear"></div><br/><br/><br/>
    <table class="order-pricing">
      <tr class="title-row">
        <th colspan="3">
          <label style="text-align: center;">Special Countertop Installation</label>
        </th>
      </tr>
      <tr>
        <td>
          Supplier Name
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          &nbsp;
        </td>
      </tr>
      <tr>
        <td>
          Installation Cost
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          0.00
        </td>
      </tr>
      <tr>
        <td>
          Supplier Name
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          &nbsp;
        </td>
      </tr>
      <tr>
        <td>
          Installation Cost
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          0.00
        </td>
      </tr>
      <tr>
        <td class="wide-width">
          Total Installation Cost
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          0.00
        </td>
      </tr>      
    </table>
    <div class="clear"></div><br/>
    <table class="order-pricing">
      <tr class="title-row">
        <th colspan="3">
          <label style="text-align: center;">Service Charge</label>
        </th>
      </tr>
      <tr>
        <td>
          Service (BId)
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          0.00
        </td>
      </tr>
      <tr>
        <td>
          Service Add
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          0.00
        </td>
      </tr>
      <tr>
        <td>
          Service Callback
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          0.00
        </td>
      </tr>
      <tr>
        <td class="wide-width">
          Total Service Allowance
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          0.00
        </td>
      </tr>           
    </table>
  </div>
  <div style="float: left;width: 350px;margin-left: 32px;">
    <table class="order-pricing">
      <tr class="title-row">
        <th colspan="3">
          <label style="text-align: center;">Summary</label>
        </th>
      </tr>
      <tr>
        <td>
          Cabinet Cost
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          &nbsp;
        </td>
      </tr>
      <tr>
        <td>
          Shipping Charges
        </td>
        <td>
          &nbsp;
        </td>
        <td>
         0.00
        </td>
      </tr>
      <tr>
        <td>
          Countertop Costs
        </td>
        <td>
          &nbsp;
        </td>
        <td>
         0.00
        </td>
      </tr>
      <tr>
        <td>
          Installation Costs
        </td>
        <td>
          &nbsp;
        </td>
        <td>
         0.00
        </td>
      </tr>
      <tr>
        <td class="wide-width">
          Installation Tops Cost
        </td>
        <td>
          &nbsp;
        </td>
        <td>
         0.00
        </td>
      </tr>
      <tr>
        <td>
          Service Allowance
        </td>
        <td>
          &nbsp;
        </td>
        <td>
         0.00
        </td>
      </tr>
      <tr>
        <td>
          Finishing Cost
        </td>
        <td>
          &nbsp;
        </td>
        <td>
         &nbsp;
        </td>
      </tr>
      <tr>
        <td>
          Extras Cost
        </td>
        <td>
          &nbsp;
        </td>
        <td>
         &nbsp;
        </td>
      </tr>
      <tr>
        <td>
          Glass Cost
        </td>
        <td>
          &nbsp;
        </td>
        <td>
         &nbsp;
        </td>
      </tr>
      <tr>
        <td>
          &nbsp;
        </td>
        <td>
          Total Cost
        </td>
        <td>
         0.00
        </td>
      </tr>
      <tr>
        <td>
          Gross margin
        </td>
        <td>
          100.00%
        </td>
        <td>
         <?php echo number_format($price,'2','.',''); ?>
        </td>
      </tr>
      <tr>
        <td>
          &nbsp;
        </td>
        <td>
          Sub Total
        </td>
        <td>
         <?php echo number_format($price,'2','.',''); ?>
        </td>
      </tr>
      <tr>
        <td>
          &nbsp;
        </td>
        <td>
          &nbsp;
        </td>
        <td>
         0.00
        </td>
      </tr>
      <tr>
        <td>
          Total
        </td>
        <td>
          &nbsp;
        </td>
        <td>
         <?php echo number_format($price,'2','.',''); ?>
        </td>
      </tr>
    </table>
    <table class="order-pricing">
      <tr class="title-row">
        <th colspan="3">
          <label style="text-align: center;">Price Breakdown</label>
        </th>
      </tr>
      <tr>
        <td>
          Base Price
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          <?php echo number_format($price,'2','.',''); ?>
        </td>
      </tr>
      <tr>
        <td class="wide-width">
          Upgrade PO Amount
        </td>
        <td>
          &nbsp;
        </td>
        <td>
         &nbsp;
        </td>
      </tr>
      <tr>
        <td>
          Upgrade Cash Amount
        </td>
        <td>
          &nbsp;
        </td>
        <td>
         &nbsp;
        </td>
      </tr>
      <tr>
        <td>
          Invoice Amount
        </td>
        <td>
          &nbsp;
        </td>
        <td>
         <?php echo number_format($price,'2','.',''); ?>
        </td>
      </tr>
      <tr>
        <td>
          Customer Upgrade
        </td>
        <td>
          &nbsp;
        </td>
        <td>
         0.00
        </td>
      </tr>
      <tr>
        <td>
          Order Portion
        </td>
        <td>
          &nbsp;
        </td>
        <td>
         0.00
        </td>
      </tr>
      <tr>
        <td>
          Builder Credit
        </td>
        <td>
          %
        </td>
        <td>
         0.00
        </td>
      </tr>
      <tr>
        <td>
          &nbsp;
        </td>
        <td>
          GST
        </td>
        <td>
         <?php $gst_rate = ($price*GST)/100; echo number_format($gst_rate,'2','.',''); ?>
        </td>
      </tr>
      <tr>
        <td>
          &nbsp;
        </td>
        <td>
          PST
        </td>
        <td>
         0.00
        </td>
      </tr>
      <tr>
        <td class="wide-width">
          <label style="font-size: 14px; font-weight: bold;">
            Total Including Taxes
          </label>
        </td>
        <td>
          &nbsp;
        </td>
        <td>
         <?php echo number_format(($gst_rate+$price),'2','.',''); ?>
        </td>
      </tr>      
    </table>
  </div>
  <div class="clear"></div><br/>
</div>