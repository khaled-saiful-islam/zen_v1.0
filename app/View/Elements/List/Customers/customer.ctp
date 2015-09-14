<fieldset style="width: 100%;">
    <legend>Client List </legend>

<style>
    .table thead.highlight{
        background: #648819;
        font-weight: bold;
        color: #ffffff;
    }
    .table thead.highlight th a{
        background: #648819;
        font-weight: bold;
        color: #ffffff;
    }
</style>
    
<table class="table table-bordered table-striped" width="100%">
        <thead class="highlight">
            <tr>
            <th><?php
echo $this->Paginator->sort('id', 'ID', array('direction' => 'desc')); ?></th>
            <th>Full Name</th>
            <th>Primary Phone</th>
            <th>Secondary Phone</th>
            <th>Email Address</th>
            <th>Billing Address</th>
            <th>City</th>
            <th>Province</th>
            <th>Customer Note</th>
            <th colspan="3">Action</th>
            </tr>
        </thead>

<tbody>
<?php foreach ($data as $customers): ?>
    <tr>
        <td><?php echo $customers['Customer']['id']; ?></td>
        <td><?php echo $customers['Customer']['first_name']." ".$customers['Customer']['last_name']; ?></td>
        <td><?php echo $customers['Customer']['primary_phone']; ?></td>
        <td><?php echo $customers['Customer']['secondary_phone']; ?></td>
        <td><?php echo $customers['Customer']['email_address']; ?></td>
        <td><?php echo $customers['Customer']['billing_address']; ?></td>
        <td><?php echo $customers['Customer']['city']; ?></td>
        <td><?php echo $customers['Customer']['province']; ?></td>
        <td><?php echo $customers['Customer']['customer_note']; ?></td>
        
       
        
        <td>
            
            <?php echo $this->Html->link('<i class="icon-user"></i>',
array('controller' => 'customers', 'action' => 'action', DETAIL,$customers['Customer']['id']  ), array("escape" => false,"title" => "View Profile")); ?>
        </td>
        
        <td>
            <?php echo $this->Html->link('<i class="icon-edit"></i>',
                    array('controller' => 'customers', 'action' => 'action', EDIT,$customers['Customer']['id']  ), 
                    array("escape" => false, "title" => "Edit")
                    ); ?>

            
        </td>
        <td>      
            <?php echo $this->Html->link('<i class="icon-remove"></i>',
array('controller' => 'customers', 'action' => 'action', DELETE,$customers['Customer']['id']  ), array("escape" => false, "title" => "Delete")); ?>

                    
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