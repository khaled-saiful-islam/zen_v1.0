<h2>Edit Production Time</h2>
<?php
echo $this->Form->create('GeneralSetting', array( "url" => array( "controller" => "purchase_orders", "action" => "production_add" ), 'inputDefaults' => array( 'label' => false, 'div' => false ), 'class' => 'purchase-order-form' ));
?>
<table class='table-form-big table-form-big-margin' style="min-width: 890px;">
    <tbody>
        <tr>
            <td>
                <?php echo $this->Form->input('id', array( 'type' => 'hidden', 'class' => 'input-medium', 'value' => isset($data['GeneralSetting']['id']) ? $data['GeneralSetting']['id'] : '' )); ?>
            </td>
        </tr>
        <tr>
            <th style="width: 45px;"><label>Title: </label></th>
            <td>
                <?php echo $this->Form->input('name', array( 'placeholder' => 'Title', 'class' => 'input-medium required', 'label' => false, 'value' => isset($data['GeneralSetting']['name']) ? $data['GeneralSetting']['name'] : '' )); ?>
            </td>
        </tr>
        <tr>
            <th style="width: 45px;"><label>Percentage: </label></th>
            <td>
                <?php echo $this->Form->input('value', array( 'placeholder' => 'Percentage', 'class' => 'input-medium required', 'label' => false, 'value' => isset($data['GeneralSetting']['value']) ? $data['GeneralSetting']['value'] : '' )); ?>
            </td>
        </tr>
    </tbody>	
</table>
<?php echo $this->Form->end('Save'); ?>