<div class="suppliers view">
  <?php //echo $this->element('Actions/supplier', array('detail' => true)); ?>
  <?php
  if (isset($modal) && $modal == "modal") {
    ?>
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3 id="add_item_label" style="font-size: 16px;">
        Vendor:&nbsp;<?php echo h($supplier['Supplier']['name']); ?>
      </h3>
    </div>
    <table class="table-form-big margin-bottom">
      <tr>
        <th>Name: </th>
        <td>
          <?php echo h($supplier['Supplier']['name']); ?>
          &nbsp;
        </td>
        <th>E-mail: </th>
        <td>
          <?php echo h($supplier['Supplier']['email']); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th>Phone:</th>
        <td>
          <?php echo $this->InventoryLookup->phone_format($supplier['Supplier']['phone'], $supplier['Supplier']['phone_ext'], $supplier['Supplier']['cell'], $supplier['Supplier']['fax_number']); ?>
          &nbsp;
        </td>
        <th>Address:</th>
        <td>
          <?php echo $this->InventoryLookup->address_format($supplier['Supplier']['address'], $supplier['Supplier']['city'], $supplier['Supplier']['province'], $supplier['Supplier']['country'], $supplier['Supplier']['postal_code']); ?>
        </td>
      </tr>
      <tr>
        <th><label>Vendor Type: </label></th>
        <td class="radio-lable">
          <?php
          echo $this->Form->input('door_supplier', array('type' => 'checkbox', 'label' => 'Door Vendor', 'div' => true, 'disabled' => 'disabled', 'checked' => $supplier['Supplier']['door_supplier']));
          echo $this->Form->input('cabinet_supplier', array('type' => 'checkbox', 'label' => 'Cabinet Vendor', 'div' => true, 'disabled' => 'disabled', 'checked' => $supplier['Supplier']['cabinet_supplier']));
          echo $this->Form->input('laminate_supplier', array('type' => 'checkbox', 'label' => 'Laminate Vendor', 'div' => true, 'disabled' => 'disabled', 'checked' => $supplier['Supplier']['laminate_supplier']));
          echo $this->Form->input('hardware_supplier', array('type' => 'checkbox', 'label' => 'Hardware Vendor', 'div' => true, 'disabled' => 'disabled', 'checked' => $supplier['Supplier']['hardware_supplier']));
          ?>
        </td>
        <th><label for="SupplierTerms">Terms: </label></th>
        <td>
          <?php echo h($supplier['Supplier']['terms']); ?>
          &nbsp;
        </td>
      </tr>
      <tr>
        <th><?php echo __('GST Rate(%)'); ?>:</th>
        <td>
          <?php echo h($supplier['Supplier']['gst_rate']); ?>
          &nbsp;
        </td>
        <th><?php echo __('PST Rate(%)'); ?>:</th>
        <td>
          <?php echo h($supplier['Supplier']['pst_rate']); ?>
          &nbsp;
        </td>
      </tr>
    </table>
  <?php } else { ?>
    <div class="report-buttons" style="float: right;">
      <?php
      echo $this->Html->link(
              '', array('controller' => 'suppliers', 'action' => 'print_detail', $supplier['Supplier']['id']), array('class' => 'icon-print open-link', 'data_target' => 'item_report', 'title' => 'Print Detail Information')
      );
      ?>
    </div>
    <fieldset class="content-detail">
      <legend><?php echo __('Vendor'); ?>:&nbsp;<?php echo h($supplier['Supplier']['name']); ?></legend>
      <ul class="nav nav-tabs form-tab-nav" id="item-form-tab-nav">
        <li class="active"><a href="#supplier-information" data-toggle="tab"><?php echo __('Vendor Information'); ?></a></li>
        <li><a href="#supplier-contact" data-toggle="tab"><?php echo __('Vendor Contact'); ?></a></li>
      </ul>

      <div class="tab-content">
        <fieldset id="supplier-information" class="tab-pane active">
          <div class="detail actions">
            <?php echo $this->Html->link('Edit Vendor', array('action' => EDIT, $supplier['Supplier']['id']), array('data-target' => '#supplier-information', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'title' => __('Edit Vendor'))); ?>
          </div>
          <table class="table-form-big">
            <tr>
              <th>Name: </th>
              <td>
                <?php echo h($supplier['Supplier']['name']); ?>
                &nbsp;
              </td>
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
              <th>E-mail: </th>
              <td>
                <?php echo h($supplier['Supplier']['email']); ?>
                &nbsp;
              </td>
              <th>Website:</th>
              <td>
                <?php echo h($supplier['Supplier']['website']); ?>
                &nbsp;
              </td>
            </tr>
            <tr>
              <th>Phone:</th>
              <td>
                <?php echo $this->InventoryLookup->phone_format($supplier['Supplier']['phone'], $supplier['Supplier']['phone_ext'], $supplier['Supplier']['cell'], $supplier['Supplier']['fax_number']); ?>
                &nbsp;
              </td>
              <th>Address:</th>
              <td>
                <?php echo $this->InventoryLookup->address_format($supplier['Supplier']['address'], $supplier['Supplier']['city'], $supplier['Supplier']['province'], $supplier['Supplier']['country'], $supplier['Supplier']['postal_code']); ?>
              </td>
            </tr>
            <tr>
              <th><label>Vendor Type: </label></th>
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
              <th><label for="SupplierTerms">Terms: </label></th>
              <td>
                <?php echo h($supplier['Supplier']['terms']); ?>
                &nbsp;
              </td>
            </tr>
            <tr>
              <th class="width-medium"><?php echo h('QB Vendor Name'); ?>:</th>
              <td>
                <?php echo h($supplier['Supplier']['qb_suplier_name']); ?>
                &nbsp;
              </td>
              <th><?php //echo h('Default PO Type'); ?></th>
              <td>
                <?php //echo h($supplier['Supplier']['default_po_type']); ?>
                &nbsp;
              </td>
            </tr>
            <tr>
              <th><?php echo h('GST Rate(%)'); ?>:</th>
              <td>
                <?php echo h($supplier['Supplier']['gst_rate']); ?>
                &nbsp;
              </td>
              <th><?php echo h('PST Rate(%)'); ?>:</th>
              <td>
                <?php echo h($supplier['Supplier']['pst_rate']); ?>
                &nbsp;
              </td>
            </tr>
            <tr>
              <th><?php echo h('Notes'); ?>:</th>
              <td>
                <?php echo h($supplier['Supplier']['notes']); ?>
                &nbsp;
              </td>
              <th><?php echo h('Notes (on PO)'); ?>:</th>
              <td>
                <?php echo h($supplier['Supplier']['notes_on_po']); ?>
                &nbsp;
              </td>
            </tr>
          </table>

        </fieldset>

        <fieldset id="supplier-contact" class="tab-pane">
          <?php
          echo $this->element('PartialData/supplier_contact', array('supplier_contacts' => $supplier['SupplierContact'], 'supplier_id' => $supplier['Supplier']['id']));
          ?>
        </fieldset>
      </div>
    </fieldset>
  <?php } ?>
</div>