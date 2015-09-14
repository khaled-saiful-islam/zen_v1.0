<style>
    .table thead.highlight{
        background: #648819;
        font-weight: bold;
        color: #ffffff;
    }
</style>
<fieldset>
    <legend>User profile : <?php echo $loginUser['first_name']." ".$loginUser['last_name']; ?></legend>

<table class="table table-bordered ">


        <thead class="highlight">
            <tr>
            <th><h3>Tag</h3></th>
            <th><h3>Description</h3></th>
            </tr>     
        </thead>

        <tbody>

            <tr>
                <td width="20%"><h4>ID</h4></td>
                <td><?php echo $loginUser['empid']; ?></td>
            </tr>
            <tr>
                <td><h4>Full Name</h4></td>
                <td><?php echo $loginUser['title'].". ".$loginUser['first_name']." ".$loginUser['last_name'] ; ?></td>
            </tr>
            <tr>
                <td><h4>Cell Phone</h4></td>
                <td><?php echo $loginUser['cell_phone']; ?></td>
            </tr>
            <tr>
                <td><h4>Home Phone</h4></td>
                <td><?php echo $loginUser['home_phone']; ?></td>
            </tr>
            <tr>
                <td><h4>Work Phone</h4></td>
                <td><?php echo $loginUser['work_phone']." "."Ext No."." ". $loginUser['ext'] ; ?></td>
            </tr>
            <tr>
                <td><h4>Email Id 1</h4></td>
                <td><?php echo $loginUser['email1']; ?></td>
            </tr>
            <tr>
                <td><h4>Email Id 2</h4></td>
                <td><?php echo $loginUser['email2']; ?></td>
            </tr>
            <tr>
                <td><h4>Address</h4></td>
                <td><?php echo $loginUser['address']; ?></td>
            </tr>
            <tr>
                <td><h4>User Name</h4></td>
                <td><?php echo $loginUser['username']; ?></td>
            </tr>
            <tr>
                <td><h4>Remark</h4></td>
                <td><?php echo $loginUser['remark']; ?></td>
            </tr>
            <tr>
                <td><h4>Role</h4></td>
                <td><?php echo $loginUser['role']; ?></td>
            </tr>
            <tr>
                <td><h4>Status</h4></td>
                <td><?php echo $loginUser['status']; ?></td>
            </tr>


        </tbody>
</table>



      
</fieldset>


