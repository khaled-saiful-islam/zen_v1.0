<table class='table-form-big'>
    <tr>
        <th><label for="MaterialGroupName">Name: </label></th>
        <td><?php echo $this->Form->input('name', array( 'class' => 'input-medium required', 'placeholder' => 'Name' )); ?></td>
    </tr>
    <tr>
        <th><label for="MaterialGroupCode">Code: </label></th>
        <td><?php echo $this->Form->input('code', array( 'class' => 'input-medium required', 'placeholder' => 'Code' )); ?></td>
    </tr>
    <tr>
        <th><label for="MaterialGroupDefault">Default: </label></th>
        <td><?php
echo $this->Form->input('default', array(
    'type' => 'checkbox',
    "value" => 1,
));
?>
    </tr>
</table>