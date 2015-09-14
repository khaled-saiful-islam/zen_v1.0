<h2>Add Production Time</h2>
<?php
echo $this->Form->create('GeneralSetting', array( "url" => array( "controller" => "purchase_orders", "action" => "production_add" ), 'inputDefaults' => array( 'label' => false, 'div' => false ), 'class' => 'purchase-order-form' ));
?>
<table class='table-form-big table-form-big-margin' style="min-width: 890px;">
    <tbody>      
        <tr>
            <th style="width: 45px;"><label>Title: </label></th>
            <td>
                <?php echo $this->Form->input('name', array( 'placeholder' => 'Title', 'class' => 'input-medium required', 'label' => false )); ?>
            </td>
        </tr>
        <tr>
            <th style="width: 45px;"><label>Percentage: </label></th>
            <td>
                <?php echo $this->Form->input('value', array( 'placeholder' => 'Percentage', 'class' => 'input-medium required', 'label' => false ))."%"; ?>
            </td>
        </tr>
    </tbody>	
</table>
<?php echo $this->Form->end('Save'); ?>