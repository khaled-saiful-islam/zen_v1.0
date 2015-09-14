<?php //pr($item);        ?>
<div class="items view">
  <?php
  if (isset($modal) && $modal == "modal") {
    ?>
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3 id="add_item_label" style="font-size: 16px;">
        Item:&nbsp;<?php echo h($item['Item']['item_code']); ?>
      </h3>
    </div>
  <?php echo $this->element('Detail/Item/item-basic-info-detail', array('edit' => false)); ?>
  <?php } else { ?>
    <?php //echo $this->element('Actions/item', array('detail' => true)); ?>
    <div class="report-buttons">
      <?php
      echo $this->Html->link(
              '', array('controller' => 'items', 'action' => 'print_label', $item['Item']['id']), array('class' => 'icon-barcode open-link', 'data_target' => 'item_barcode', 'title' => 'Print Barcode')
      );
      ?>
      <?php
      echo $this->Html->link(
              '', array('controller' => 'items', 'action' => 'print_detail', $item['Item']['id']), array('class' => 'icon-print open-link', 'data_target' => 'item_report', 'title' => 'Print Detail Information')
      );
      ?>
    </div>
    <fieldset class="content-detail">
      <legend><?php echo __('Item'); ?>&nbsp;:<?php echo h($item['Item']['item_title']); ?>
        &nbsp;[<?php echo h($item['Item']['number']); ?>]</legend>
      <div style="font-size: 12px;">
        <div style="float: right;">
          <?php echo $this->Html->link('Damaged', array('controller' => 'items', 'action' => 'damaged', $item['Item']['id']), array('class' => 'btn btn-success modal_damaged')); ?>
        </div>
        <div style="float: right; margin-right: 20px;">
          <?php echo $this->Html->link('Add to Inventory', array('controller' => 'items', 'action' => 'add_to_inventory', $item['Item']['id']), array('class' => 'btn btn-success modal_add_inventory')); ?>
        </div>
        <div style="float: right; margin-right: 20px;">
          <?php echo $this->Html->link('Add Sub Item', 'http://' . $_SERVER['SERVER_NAME'] . $this->Html->url(array('plugin' => 'inventory', 'controller' => 'items', 'action' => ADD, $item['Item']['id'], '#' => 'item-sub')), array('class' => 'btn btn-success ajax-sub-content', 'data-target' => '#item-sub', 'onclick' => "$('#tab-select-item-sub').trigger('click');")); ?>
        </div>
      </div>


      <ul class="nav nav-tabs form-tab-nav" id="item-form-tab-nav">
        <li class="active"><a href="#item-basic-info-detail" data-toggle="tab"><?php echo __('Item Information'); ?></a></li>
        <li><a href="#item-notes-detail" data-toggle="tab"><?php echo __('Item Notes'); ?></a></li>
        <li><a href="#item-history-detail" data-toggle="tab"><?php echo __('Item History'); ?></a></li>
        <li><a href="#item-sub" data-toggle="tab" id="tab-select-item-sub"><?php echo __('Sub Item'); ?></a></li>
        <li><a href="#item-additional-detail" data-toggle="tab"><?php echo __('Additional Details'); ?></a></li>
      </ul>

      <div class="tab-content">
        <fieldset id="item-basic-info-detail" class="tab-pane active">
          <?php echo $this->element('Detail/Item/item-basic-info-detail', array('edit' => true)); ?>
        </fieldset>
        <fieldset id="item-notes-detail" class="tab-pane">
          <?php echo $this->element('Detail/Item/item-notes-detail', array('edit' => true)); ?>
        </fieldset>
        <fieldset id="item-history-detail" class="tab-pane">
          <?php echo $this->element('Detail/Item/item-history-detail', array('edit' => true)); ?>
        </fieldset>
        <fieldset id="item-sub" class="tab-pane">
          <?php echo $this->element('Detail/Item/item-sub', array('edit' => true)); ?>
        </fieldset>
        <fieldset id="item-additional-detail" class="tab-pane">
          <?php echo $this->element('Detail/Item/item-additional-fields', array('edit' => true)); ?>
        </fieldset>
      </div>
    </fieldset>
  <?php } ?>
</div>

<script type="text/javascript">
  $(function(){
    AppJS.getDialog($(".modal_add_inventory"));
    AppJS.getDialog($(".modal_damaged"));
  })
</script>