<div id="cabinet_installations" class="tab-pane">
  <fieldset>
    <legend <?php if ($edit) { ?>class='inner-legend'<?php } ?>>Edit Installation</legend>
    <div class="cabinets_installationss">
      <table class="table-form-big" style="width: 70%;">
        <thead>
          <tr>
            <th>Installation Code</th>
            <th>Description</th>
            <th>Price</th>
            <th>Price Unit</th>
            <th>&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <tr class="clone-row hide">
            <td>
              <?php
              $installation_type_list = $this->InventoryLookup->InventoryLookup('installation_type');
              $description = '';
              $price_unit = '';
              $installer_type = '';
              $price = 0;
//              if (!empty($this->data['CabinetInstallation'])) {
//                $description = $this->data['CabinetInstallation']['-1']['value'];
//                $price = $this->data['CabinetInstallation']['-1']['price'];
//                $price_unit = $this->data['CabinetInstallation']['-1']['price_unit'];
//                $installer_type = $this->data['CabinetInstallation']['-1']['id'];
//              }
              echo $this->Form->input("CabinetsInstallation.-1.inventory_lookup_id", array(
                  "class" => "inventory_lookup_id user-input form-select-installation-type wide-input",
                  "label" => false,
                  'data-placeholder' => 'Installation Code',
                  "options" => $installation_type_list,
                  'empty' => true,
                  'default' => $installer_type
              ));
              ?>
            </td>
            <td class="description">
              <?php echo $description; ?>&nbsp;
            </td>
            <td class="price">
              <?php echo $price; ?>&nbsp;
            </td>
            <td class="price_unit">
              <?php echo $price_unit; ?>&nbsp;
            </td>
            <td>
              &nbsp
              <a href="#" class="icon-remove icon-remove-margin remove hide">&nbsp;</a>
            </td>
          </tr>
          <tr class="clone-row">
            <td>
              <?php
              if (!empty($this->data['CabinetInstallation'])) {
                $description = $this->data['CabinetInstallation'][0]['value'];
                $price = $this->data['CabinetInstallation'][0]['price'];
                $price_unit = $this->data['CabinetInstallation'][0]['price_unit'];
                $installer_type = $this->data['CabinetInstallation'][0]['id'];
              }
              echo $this->Form->input("CabinetsInstallation.0.inventory_lookup_id", array(
                  "class" => "inventory_lookup_id user-input form-select-installation-type wide-input required",
                  "label" => false,
                  'data-placeholder' => 'Installation Code',
                  "options" => $installation_type_list,
                  'empty' => true,
                  'default' => $installer_type
              ));
              ?>
            </td>
            <td class="description">
              <?php echo $description; ?>&nbsp;
            </td>
            <td class="price">
              <?php echo $price; ?>&nbsp;
            </td>
            <td class="price_unit">
              <?php echo $price_unit; ?>&nbsp;
            </td>
            <td>
              &nbsp
              <a href="#" class="icon-remove icon-remove-margin remove hide">&nbsp;</a>
            </td>
          </tr>
          <?php
          if (!empty($this->data['CabinetInstallation'])) {
            foreach ($this->data['CabinetInstallation'] as $index => $value) {
              if ($index == 0)
                continue; // skip the first one to avoid duplicate

              $description = $this->data['CabinetInstallation'][$index]['value'];
              $price = $this->data['CabinetInstallation'][$index]['price'];
              $price_unit = $this->data['CabinetInstallation'][$index]['price_unit'];
              $installer_type = $this->data['CabinetInstallation'][$index]['id'];
              ?>
              <tr class="clone-row">
                <td>
                  <?php
                  echo $this->Form->input("CabinetsInstallation.{$index}.inventory_lookup_id", array(
                      "class" => "inventory_lookup_id user-input form-select-installation-type wide-input required",
                      "label" => false,
                      'data-placeholder' => 'Installation Code',
                      "options" => $installation_type_list,
                      'empty' => true,
                      'default' => $installer_type
                  ));
                  ?>
                </td>
                <td class="description">
                  <?php echo $description; ?>&nbsp;
                </td>
                <td class="price">
                  <?php echo $price; ?>
                </td>
                <td class="price_unit">
                  <?php
//                  echo $this->Form->input("CabinetsInstallation.{$index}.price_unit", array(
//                      "class" => "price_unit user-input required form-select",
//                      "placeholder" => "Price Unit",
//                      "label" => false,
//                      'empty' => true,
//                      'options' => array('each' => 'Each', 'sqft' => 'SQFT'),
//                      'default' => $price_unit
//                  ));
                  ?>
                  <?php echo $price_unit; ?>&nbsp;

                </td>
                <td class="remove">
                  &nbsp
                  <a href="#" class="icon-remove icon-remove-margin remove">&nbsp;</a>
                </td>
              </tr>
              <?php
            }
          }
          ?>
          <tr>
            <td colspan="5">
              <input type="button" class="btn btn-info add-more" value="Add More" />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </fieldset>
</div>
<script>
  var installation_type_list = <?php echo json_encode($this->InventoryLookup->InventoryLookupWholeData('installation_type')) ?>;

  $(function(){
    select2inCabinetInstallationType($('select.form-select-installation-type'));
  });

  function select2inCabinetInstallationType(selector) {
    selector.select2({
    }).on("change",
    function (e) {
      id = e.val;
      if(id > 0) {
        parent = $(this).parents('table tr');
        parent.find('td.description').html(installation_type_list[id].value);
        parent.find('td.price').html(installation_type_list[id].price);
        parent.find('td.price_unit').html(installation_type_list[id].price_unit);
      }
    });
  }
</script>