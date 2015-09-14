<?php echo $this->Form->create('Item', array( 'controller' => 'items', 'action' => 'edit_builder_price', 'inputDefaults' => array( 'label' => false, 'div' => false ) )); ?>
<legend>Builder price Setup</legend>
<table class='table-form-big'>
    <tr>
        <th for="ItemItemTitle">Item Code:</th>
        <td colspan="3"><?php echo $item['Item']['item_title']; ?></td>
        <?php echo $this->Form->hidden('id', array( 'value' => isset($item['Item']['id']) ? $item['Item']['id'] : '' )); ?>
    </tr>
    <tr>
        <th for="ItemFactor">Factor:</th>
        <td><?php echo $item['Item']['factor'];?></td>
    </tr>
    <tr>
        <th for="ItemItemCost">Item Cost:</th>
        <td><?php echo $item['Item']['item_cost'];?></td>
    </tr>
    <tr>
        <th for="ItemFactor">Builder Factor:</th>
        <td><?php echo $item['Item']['builder_factor'];?></td>
    </tr>
    <tr>
        <th for="ItemItemCost">Builder Price:</th>
        <td><?php echo $this->Form->input('builder_price', array( 'placeholder' => 'Builder Price', 'class' => 'money-input', 'value' => isset($item['Item']['builder_price']) ? $item['Item']['builder_price'] : '' )); ?></td>
    </tr>
    <tr>
        <th for="ItemPrice">Price:</th>
        <td><?php echo $item['Item']['price'];?></td>
    </tr>
    <tr>
        <td colspan="3">
            <input type="submit" class="btn btn-info" value="Save" />
        </td>
    </tr>
</table>
<?php echo $this->Form->end(); ?>