<div id="door-images" class="sub-content-detail">
    <fieldset>
      <?php if($edit){ ?>
      <legend class="inner-legend">Edit Door Image</legend>
      <?php } ?>
        <table class="table-form-big">
            <tr>
                <th class="width-medium"><label for="DoorOutsideProfileImage">Outside Profile Image:</label></th>
                <td>
                    <?php echo $this->Form->input('outside_profile_image', array('type' => 'file')); ?>
                    <?php echo $this->Form->input('outside_profile_image_dir', array('type' => 'hidden')); ?>
                </td>
                <th><label for="DoorInsideProfileImage">Inside Profile Image:</label></th>
                <td>
                    <?php echo $this->Form->input('inside_profile_image', array('type' => 'file')); ?>
                    <?php echo $this->Form->input('inside_profile_image_dir', array('type' => 'hidden')); ?>
                </td>
            </tr>
            <tr>
                <th><label for="DoorDoorImage">Door Image:</label></th>
                <td colspan="3">
                    <?php echo $this->Form->input('door_image', array('type' => 'file')); ?>
                    <?php echo $this->Form->input('door_image_dir', array('type' => 'hidden')); ?>
                </td>
            </tr>
        </table>
    </fieldset>
</div>