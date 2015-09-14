<fieldset style="width: 100%;">
    <legend>Vendor List </legend>

<style>
    .table thead.highlight{
        background: #648819;
        font-weight: bold;
        color: #ffffff;
    }
</style>
    
<table class="table table-bordered table-striped" width="100%">
        <thead class="highlight">
            <tr>
            <th>Vendor Id</th>
            <th>Full Name</th>
            <th>Cell Phone</th>
            <th>Work Phone</th>
            <th>Email Address 1</th>
            <th>Email Address 2</th>
            <th>Home Address</th>
            <th>Work Address</th>
            <th>Company Type</th>
            <th colspan="3">Action</th>
            </tr>
        </thead>

<tbody>
<?php foreach ($data as $vendors): ?>
    <tr>
        <td><?php echo $vendors['Vendor']['vendor_id']; ?></td>
        <td><?php echo $vendors['Vendor']['first_name']." ".$vendors['Vendor']['last_name']; ?></td>
        <td><?php echo $vendors['Vendor']['cell_phone']; ?></td>
        <td><?php echo $vendors['Vendor']['work_phone']; ?></td>
        <td><?php echo $vendors['Vendor']['email1']; ?></td>
        <td><?php echo $vendors['Vendor']['email2']; ?></td>
        <td><?php echo $vendors['Vendor']['home_address']; ?></td>
        <td><?php echo $vendors['Vendor']['work_address']; ?></td>
        <td><?php echo $vendors['Vendor']['company_type']; ?></td>
        
       
        
        <td>
            
            <?php echo $this->Html->link('<i class="icon-user"></i>',
array('controller' => 'vendors', 'action' => 'action', DETAIL,$vendors['Vendor']['id']  ), array("escape" => false,"title" => "View profile")); ?>
        </td>
        
        <td>
            <?php echo $this->Html->link('<i class="icon-edit"></i>',
                    array('controller' => 'vendors', 'action' => 'action', EDIT,$vendors['Vendor']['id']  ), 
                    array("escape" => false, "title" => "Edit")
                    ); ?>

            
        </td>
        <td>      
            <?php echo $this->Html->link('<i class="icon-remove"></i>',
array('controller' => 'vendors', 'action' => 'action', DELETE,$vendors['Vendor']['id']  ), array("escape" => false,"title" => "Delete")); ?>

                    
        </td>
</tr>
    <?php endforeach; ?>
   
</tbody>



</table>
</fieldset>



<script type="text/javascript">
$(document).ready(function() { 


});
 
 
 
 </script>