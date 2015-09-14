<?php if ($edit) { ?>
  <div class="detail actions">
    <?php echo $this->Html->link('Edit', array('action' => EDIT, $door['Door']['id'], 'images'), array('data-target' => '#door-images-detail', 'class' => 'ajax-sub-content btn btn-success', 'title' => __('Edit'))); ?>
  </div>
<?php } ?>
<table class="table-form-big">
  <tr>
    <th class="width-medium"><?php echo h('Outside Profile Image'); ?>:</th>
    <td>
      <?php
      if (!empty($door['Door']['outside_profile_image'])) {
        echo $this->Html->image("../files/door/outside_profile_image/{$door['Door']['outside_profile_image_dir']}/thumb_{$door['Door']['outside_profile_image']}");
      }
      ?>
      &nbsp;
    </td>
  </tr>
  <tr>
    <th><?php echo h('Inside Profile Image'); ?>:</th>
    <td>
      <?php
      if (!empty($door['Door']['inside_profile_image'])) {
        echo $this->Html->image("../files/door/inside_profile_image/{$door['Door']['inside_profile_image_dir']}/thumb_{$door['Door']['inside_profile_image']}");
      }
      ?>
      &nbsp;
    </td>
  </tr>
  <tr>
    <th><?php echo h('Door Image'); ?>:</th>
    <td>
      <?php
      if (!empty($door['Door']['door_image'])) {
        echo $this->Html->image("../files/door/door_image/{$door['Door']['door_image_dir']}/thumb_{$door['Door']['door_image']}", array('style' => 'width: 80px; height: 80px;'));
      }
      ?>
      &nbsp;
    </td>
  </tr>
</table>