<?php
$type_label = $this->InventoryLookup->to_camel_case($type);
if($type_label == 'Supplier') $type_label = 'Vendor';
$add_label = "Add {$type_label} values";
$view_label = "View {$type_label} values";

switch ($type) {
  case 'Drawer':
    $add_label = "Add Drawer";
    $view_label = "View Drawers";
    break;
  case 'Installation':
    $add_label = "Add Installation Task";
    $view_label = "View Installation Task";
    break;
}
?>
<ul class="nav nav-list well" id="goAjaxUlId">
  <li class="<?php echo $left_nav_selected == 'add_inventory_lookup' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-plus icon-green'></i> {$add_label}", array(
        "controller" => "inventory_lookups",
        "action" => ADD,
        "plugin" => "inventory", $type), array(
        "escape" => false,
    ));
    ?>
  </li>
  <li class="<?php echo $left_nav_selected == 'view_inventory_lookup' ? "active " : "" ?>">
    <?php
    echo $this->Html->link("<i class='icon-list-alt icon-green'></i> {$view_label}", array(
        "controller" => "inventory_lookups",
        "action" => 'index',
        "plugin" => "inventory", $type), array(
        "escape" => false
    ));
    ?>
  </li>
</ul>

<script>
  //$("#goAjaxUlId li").ajaxLeftNav("#MainContent");
</script>