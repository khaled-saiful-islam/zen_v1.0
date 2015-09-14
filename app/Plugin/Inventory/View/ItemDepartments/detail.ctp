<div class="itemDepartments view">
  <?php
  if (isset($modal) && $modal == "modal") {
    ?>
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3 id="add_item_label" style="font-size: 16px;">
        Item Department:&nbsp;<?php echo h($itemDepartment['ItemDepartment']['name']); ?>
      </h3>
    </div>
    <table class='table-form-compact'>
      <tr>
        <th>&nbsp;</th>
        <td class="radio-lable">
          <?php
          echo $this->Form->input('active', array('disabled' => 'disabled', 'label' => 'Active', 'div' => true, 'checked' => $itemDepartment['ItemDepartment']['active']));
          echo $this->Form->input('supplier_required', array('disabled' => 'disabled', 'label' => 'Create PO', 'div' => true, 'checked' => $itemDepartment['ItemDepartment']['supplier_required']));
          echo $this->Form->input('stock_number_required', array('disabled' => 'disabled', 'label' => 'Stock Number Required', 'div' => true, 'checked' => $itemDepartment['ItemDepartment']['stock_number_required']));
          echo $this->Form->input('direct_sale', array('disabled' => 'disabled', 'label' => 'Direct Sale', 'div' => true, 'checked' => $itemDepartment['ItemDepartment']['direct_sale']));
          echo $this->Form->input('avaiable_in_website', array('disabled' => 'disabled', 'label' => 'Available in Website', 'div' => true, 'checked' => $itemDepartment['ItemDepartment']['avaiable_in_website']));
          ?>
        </td>
        <th><label for="ItemDepartmentQbItemRef">ACC Item Ref:</label></th>
        <td>
          <?php echo h($itemDepartment['ItemDepartment']['qb_item_ref']); ?>&nbsp;
        </td>
      </tr>
    </table>
  <?php } else { ?>
    <fieldset class="content-detail">
      <legend><?php echo __('Item Department'); ?>:&nbsp;<?php echo h($itemDepartment['ItemDepartment']['name']); ?></legend>
      <div id="item-deparment-information">
        <div class="detail actions">
          <?php echo $this->Html->link('Edit Item Department', array('action' => EDIT, $itemDepartment['ItemDepartment']['id']), array('data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success', 'title' => __('Edit Item Department'))); ?>
        </div>
        <table class='table-form-big'>
          <tr>
            <th><label for="ItemDepartmentName">Name</label></th>
            <td><?php echo h($itemDepartment['ItemDepartment']['name']); ?>&nbsp;</td>
            <th><label for="ItemDepartmentQbItemRef">ACC Item Ref:</label></th>
            <td>
              <?php echo h($itemDepartment['ItemDepartment']['qb_item_ref']); ?>&nbsp;
            </td>
          </tr>
          <tr>
            <th><label for="ItemDepartmentName">Instruction</label></th>
            <td>
              <?php echo h($itemDepartment['ItemDepartment']['instruction']); ?>&nbsp;
            </td>
            <th>&nbsp;</th>
            <td class="radio-lable">
              <?php
              echo $this->Form->input('active', array('disabled' => 'disabled', 'label' => 'Active', 'div' => true, 'checked' => $itemDepartment['ItemDepartment']['active']));
              echo $this->Form->input('supplier_required', array('disabled' => 'disabled', 'label' => 'Create PO', 'div' => true, 'checked' => $itemDepartment['ItemDepartment']['supplier_required']));
              echo $this->Form->input('stock_number_required', array('disabled' => 'disabled', 'label' => 'Stock Number Required', 'div' => true, 'checked' => $itemDepartment['ItemDepartment']['stock_number_required']));
              echo $this->Form->input('direct_sale', array('disabled' => 'disabled', 'label' => 'Direct Sale', 'div' => true, 'checked' => $itemDepartment['ItemDepartment']['direct_sale']));
              echo $this->Form->input('avaiable_in_website', array('disabled' => 'disabled', 'label' => 'Available in Website', 'div' => true, 'checked' => $itemDepartment['ItemDepartment']['avaiable_in_website']));
              ?>
            </td>
          </tr>
        </table>

      </div>

      <!--<div class="related">
      <?php if (!empty($itemDepartment['Item'])): ?>
                <h3><?php echo __('Related Items'); ?>:</h3>
                <table cellpatding="0" cellspacing="0" class="table table-bordered table-hover listing">
                  <thead>
                    <tr class="heading">
                      <th class="min-witdh"><?php echo __('Number'); ?></th>
                      <th class="min-witdh"><?php echo __('Item Cost'); ?></th>
                      <th class="min-witdh"><?php echo __('Price'); ?></th>
                      <th class="min-witdh"><?php echo __('Current Stock'); ?></th>
                    </tr>
                  </thead>
        <?php
        $count = 0;
        foreach ($itemDepartment['Item'] as $item):
          $count++;
          $otd_even = 'otd';
          if (($count % 2) == 0) {
            $otd_even = 'even';
          }
          ?>
                          <tr class="<?php echo $otd_even; ?>">
                            <td><?php echo h($item['number']); //echo $this->Html->link(h($item['number']), array('controller' => 'items', 'action' => DETAIL, $item['id']), array('title' => __('View'), 'class' => 'show-detail-ajax'));    ?>&nbsp;</td>
                            <td><?php echo h($item['item_cost']); ?>&nbsp;</td>
                            <td><?php echo h($item['price']); ?>&nbsp;</td>
                            <td style="width: 100px;"><?php echo h($item['current_stock']); ?>&nbsp;</td>
                          </tr>
        <?php endforeach; ?>
                </table>
      <?php endif; ?>
      </div>-->
    </fieldset>
  <?php } ?>
</div>
