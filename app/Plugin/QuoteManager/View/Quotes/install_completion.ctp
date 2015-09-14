<div class="report-print install-completion">

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
        <label>Cabinet Order#</label>
        <br/><br/>
      </th>
      <td>
        &nbsp;
        <br/><br/>
      </td>
    </tr>     
  </table>
  <div class="clear"></div><br/>
  <table class="report-full-box-info">
    <tr>
      <th>
        <label>Job Notes: </label>
      </th>
      <td>
        
      </td>
    </tr>
    <tr>
      <th>
        <label>Date Completed:</label>
      </th>
      <td>
        _____________________________________________
      </td>
    </tr>
  </table>
  <div class="clear"></div><br/>
  <table class="report-full-box-info table-border">
    <tr>
      <th colspan="12" class="main-title">
        <label>Installation Checklist</label>
        <label>Complete = C</label>
        <label>Incomplete = I</label>
        <label class="last">Not Applicable = NA</label>
      </th>
    </tr>
    <tr class="sub-title">
      <td class="wide-width">Item</td>
      <td>C</td>
      <td>I</td>
      <td>NA</td>
      <td class="wide-width">Item</td>
      <td>C</td>
      <td>I</td>
      <td>NA</td>
      <td class="wide-width">Item</td>
      <td>C</td>
      <td>I</td>
      <td>NA</td>
    </tr>
    <tr>
      <td class="wide-width">Wall Cabinets</td>
      <td></td>
      <td></td>
      <td></td>
      <td class="wide-width">Fillers</td>
      <td></td>
      <td></td>
      <td></td>
      <td class="wide-width">Handles</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="wide-width">Base Cabinets</td>
      <td></td>
      <td></td>
      <td></td>
      <td class="wide-width">Meds/Cabs</td>
      <td></td>
      <td></td>
      <td></td>
      <td class="wide-width">Bum pers</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="wide-width">Pantry</td>
      <td></td>
      <td></td>
      <td></td>
      <td class="wide-width">Gables</td>
      <td></td>
      <td></td>
      <td></td>
      <td class="wide-width">Caulking</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="wide-width">Vanity</td>
      <td></td>
      <td></td>
      <td></td>
      <td class="wide-width">Panels</td>
      <td></td>
      <td></td>
      <td></td>
      <td class="wide-width">Drawer Adj</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="wide-width">Crown Moldings</td>
      <td></td>
      <td></td>
      <td></td>
      <td class="wide-width">Countertops</td>
      <td></td>
      <td></td>
      <td></td>
      <td class="wide-width">Door Adj</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="wide-width">Light Valance</td>
      <td></td>
      <td></td>
      <td></td>
      <td class="wide-width">Accessories</td>
      <td></td>
      <td></td>
      <td></td>
      <td class="wide-width">Screw Caps</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="wide-width">Toe Kick</td>
      <td></td>
      <td></td>
      <td></td>
      <td class="wide-width">Vents Kits</td>
      <td></td>
      <td></td>
      <td></td>
      <td class="wide-width">Touchup/Cleanup</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="wide-width">All Shelves Installed</td>
      <td></td>
      <td></td>
      <td></td>
      <td class="wide-width">Underblocking</td>
      <td></td>
      <td></td>
      <td></td>
      <td class="wide-width">Drawers run Smoothly</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="wide-width">Cardboard on Laminate</td>
      <td></td>
      <td></td>
      <td></td>
      <td class="wide-width">Countertops Secure</td>
      <td></td>
      <td></td>
      <td></td>
      <td class="wide-width">Garbage Removed</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="wide-width">Sink Cutouts</td>
      <td></td>
      <td></td>
      <td></td>
      <td class="wide-width"></td>
      <td></td>
      <td></td>
      <td></td>
      <td class="wide-width">R.O.S. Checked</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </table>
  <div class="clear"></div><br/>
  <table class="report-full-box-info table-border">
    <tr>
      <th colspan="3" class="main-title">
        <label>Specify Items Required to Complete Job, with Dimensions </label>
        <label class="last">Specify hinging when Ordering Doors</label>
      </th>
    </tr>
    <tr class="sub-title">
      <td class="wide-width">Work to be done</td>
      <td>Parts Required</td>
      <td>Check</td>
    </tr>
    <tr>
      <td class="wide-width">1.</td>
      <td class="wide-width"></td>
      <td></td>
    </tr>
    <tr>
      <td class="wide-width">2.</td>
      <td class="wide-width"></td>
      <td></td>
    </tr>
    <tr>
      <td class="wide-width">3.</td>
      <td class="wide-width"></td>
      <td></td>
    </tr>
    <tr>
      <td class="wide-width">4.</td>
      <td class="wide-width"></td>
      <td></td>
    </tr>
    <tr>
      <td class="wide-width">5.</td>
      <td class="wide-width"></td>
      <td></td>
    </tr>
    <tr>
      <td class="wide-width">6.</td>
      <td class="wide-width"></td>
      <td></td>
    </tr>
    <tr>
      <td class="wide-width">7.</td>
      <td class="wide-width"></td>
      <td></td>
    </tr>
    <tr>
      <td class="wide-width">8.</td>
      <td class="wide-width"></td>
      <td></td>
    </tr>
  </table>
  <div class="clear"></div><br/>
  <table style="width: 732px; border: none;">
    <tr>
      <td style="font-weight:bold; line-height:25px;">
        I ___________________________________________________________ have authority to sign off 
        this job as complete and payment to be forwarded. &nbsp;&nbsp;&nbsp; Signature: ______________________ Date: ___________
      </td>
    </tr>
  </table>
  <div class="clear"></div><br/>
</div>