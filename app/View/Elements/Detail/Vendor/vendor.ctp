<fieldset>
    <style>
    .table thead.highlight{
        background: #648819;
        font-weight: bold;
        color: #ffffff;
    }
</style>
    
    <legend>Vendor Name : <?php echo $data['Vendor']['first_name']." ".$data['Vendor']['last_name']; ?></legend>

<table class="table table-bordered">


        <thead class="highlight">
            <tr>
            <th><h3>Tag</h3></th>
            <th><h3>Description</h3></th>
            </tr>     
        </thead>

<tbody>

    <tr>
        <td width="20%"><h4>Vendor Id</h4></td>
        <td><?php echo $data['Vendor']['id']; ?></td>
    </tr>
    <tr>
        <td><h4>First Name</h4></td>
        <td><?php echo $data['Vendor']['first_name']; ?></td>
    </tr>
    <tr>
        <td><h4>Last Name</h4></td>
        <td><?php echo $data['Vendor']['last_name']; ?></td>
    </tr>
    <tr>
        <td><h4>Cell Phone</h4></td>
        <td><?php echo $data['Vendor']['cell_phone']; ?></td>
    </tr>
    <tr>
        <td><h4>Work Phone</h4></td>
        <td><?php echo $data['Vendor']['work_phone']; ?></td>
    </tr>
    <tr>
        <td><h4>Home Phone</h4></td>
        <td><?php echo $data['Vendor']['home_phone']; ?></td>
    </tr>
    <tr>
        <td><h4>Email 1</h4></td>
        <td><?php echo $data['Vendor']['email1']; ?></td>
    </tr>
    <tr>
        <td><h4>Email 2</h4></td>
        <td><?php echo $data['Vendor']['email2']; ?></td>
    </tr>
    <tr>
        <td><h4>Office Address</h4></td>
        <td><?php echo $data['Vendor']['office_address']; ?></td>
    </tr>
    <tr>
        <td><h4>Home Address</h4></td>
        <td><?php echo $data['Vendor']['home_address']; ?></td>
    </tr>
    <tr>
        <td><h4>Work Address</h4></td>
        <td><?php echo $data['Vendor']['home_address']; ?></td>
    </tr>
    <tr>
        <td><h4>Company Type</h4></td>
        <td><?php echo $data['Vendor']['company_type']; ?></td>
    </tr>
    <tr>
    
</tbody>
</table>

    <?php echo $this->Html->link('<input type="submit" class="btn btn-warning btn-large" value="Edit Vendor">',
array('controller' => 'Vendors', 'action' => 'action', EDIT,$data['Vendor']['id']  ), array("escape" => false)); ?>


      
</fieldset>
