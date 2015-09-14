

<div class="page-header">
<h2>
User Information

</h2>
</div>

<fieldset>
            <legend>Basic Details</legend>

        <table class="table table-bordered">

            <tr>
                <td><h4>User Name </h4></td>
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
                <td><h4>Email Address 1</h4></td>
                <td><?php echo $loginUser['email1']; ?></td>
            </tr>
            <tr>
                <td><h4>Remark</h4></td>
                <td><?php echo $loginUser['remark']; ?></td>
            </tr>           
            <tr>
                <td><h4>Role</h4></td>
                <td><?php echo $loginUser['role']; ?></td>
            </tr>          
        </table>
 </fieldset>




