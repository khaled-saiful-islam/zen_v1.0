<div class="users view">  
   <?php
  if (isset($modal) && $modal == "modal") {
    ?>
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3 id="add_item_label" style="font-size: 16px;">
        <?php echo __('User: '); ?>&nbsp;
        <?php echo h($user['User']['first_name']); ?>
        &nbsp;
        <?php echo h($user['User']['last_name']); ?>
      </h3>
    </div>
    <?php echo $this->element('Detail/User/user-basic-info'); ?>
  <?php } else { ?>
    <fieldset>
      <legend><?php echo __('User: '); ?>&nbsp;
        <?php echo h($user['User']['first_name']); ?>
        &nbsp;
        <?php echo h($user['User']['last_name']); ?></legend>
      <ul class="nav nav-tabs form-tab-nav" id="item-form-tab-nav">
        <li class="active"><a href="#user-basic-info" data-toggle="tab"><?php echo __('User Information'); ?></a></li>
      </ul>

      <div class="tab-content">
        <fieldset id="user-basic-info" class="tab-pane active">
          <?php echo $this->element('Detail/User/user-basic-info'); ?>
        </fieldset>        
      </div>
    </fieldset>
  <?php } ?>
</div>