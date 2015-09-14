<?php
$datas = array();
if (isset($id)) {
  $datas = $this->InventoryLookup->getSubItem($id);
} else {
  $datas = $this->InventoryLookup->getSubItem($item_id);
  $id = $item_id;
}
?>
<div id='sub-content-item-notes'>
  <?php if (!empty($datas)) { ?>
    <table cellpatding="0" cellspacing="0" class="table table-bordered table-hover listing" style="width: 80%;">
      <thead>
        <tr class="grid-header">
          <th class="min-width"><?php echo __('Number'); ?></th>
          <th class="min-width"><?php echo __('Item Code'); ?></th>
          <th class="min-width"><?php echo __('Item Cost'); ?></th>
          <th class="min-width"><?php echo __('Price'); ?></th>
          <th class="min-width"><?php echo __('Supplier Name'); ?></th>
          <th class="min-width"><?php echo __('Material Group'); ?></th>
          <th class="min-width"><?php echo __('Current Stock'); ?></th>
          <th class="min-width"><?php echo __('Width'); ?></th>
          <th class="min-width"><?php echo __('Length'); ?></th>
          <th class="min-width"><?php echo __('Item Department'); ?></th>
          <th class="min-width">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($datas as $data) {
          $sub_item_id = $data['Item']['id'];
          ?>
          <tr>
            <td ><?php echo h($data['Item']['number']); ?></td>
            <td ><?php echo h($data['Item']['item_title']); ?></td>
            <td ><?php echo h($data['Item']['item_cost']); ?></td>
            <td ><?php echo h($data['Item']['price']); ?></td>
            <td ><?php echo h($data['Supplier']['name']); ?></td>
            <td ><?php echo $this->InventoryLookup->findMaterialGroup($data['Item']['item_material_group']); ?></td>
            <td ><?php echo h($data['Item']['current_stock']); ?></td>
            <td ><?php echo h($data['Item']['width']); ?></td>
            <td ><?php echo h($data['Item']['length']); ?></td>
            <td ><?php echo h($data['ItemDepartment']['name']); ?></td>
            <td >
              <?php echo $this->Html->link('', array('action' => 'detail_section', $data['Item']['id'], 'detail', 0), array('class' => 'icon-list modal_ajax_jq_ui_detail', 'title' => __('View'))); ?>
              <?php echo $this->Html->link('', array('action' => EDIT, $data['Item']['id']), array('class' => 'icon-edit edit_sub_item', 'title' => __('Edit'), 'data-id' => $data['Item']['id'])); ?>
            </td>
          <?php } ?>
      </tbody>
    </table>
  <?php } else { ?>
    <table class="table table-bordered table-hover listing" style="width: 50%;">
      <thead>
        <tr class="grid-header">
          <?php $sub_item_id = null; ?>
          <th class="min-width"><?php echo __('Number'); ?></th>
          <th class="min-width"><?php echo __('Item Code'); ?></th>
          <th class="min-width"><?php echo __('Item Cost'); ?></th>
          <th class="min-width"><?php echo __('Price'); ?></th>
          <th class="min-width"><?php echo __('Supplier Name'); ?></th>
          <th class="min-width"><?php echo __('Material Group'); ?></th>
          <th class="min-width"><?php echo __('Current Stock'); ?></th>
          <th class="min-width"><?php echo __('Width'); ?></th>
          <th class="min-width"><?php echo __('Length'); ?></th>
          <th class="min-width"><?php echo __('Item Department'); ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="5">
            <label class="text-cursor-normal">No data here</label>
          </td>
        </tr>
      </tbody>
    </table>
  <?php } ?>
</div>

<script type="text/javascript">
  $(function(){
    $('a.edit_sub_item').click(function(event){
      event.preventDefault();
      ajaxStart();
      var item_id = '<?php echo $id; ?>';
      $.ajax({
        url: '<?php
  echo $this->Util->getURL(array(
      'controller' => "items",
      'action' => 'edit_sub_item',
      'plugin' => 'inventory',
  ))
  ?>/'+$(this).attr('data-id')+'/'+null+'/'+item_id,
          data: '',
          success: function( response ) {
            $('#item-sub #sub-content-item-notes').html(response);
            ajaxStop();
          }
        });
      });
    })
</script>