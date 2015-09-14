<div class="users view">  
    <fieldset>
        <legend><?php echo __('User: '); ?>&nbsp;
            <?php echo h($user['User']['first_name']); ?>
            &nbsp;
            <?php echo h($user['User']['last_name']); ?></legend>
        <ul class="nav nav-tabs form-tab-nav" id="item-form-tab-nav">
            <li class="active"><a href="#user-basic-info" data-toggle="tab"><?php echo __('User Permission'); ?></a></li>
        </ul>
        
        <div class="tab-content">
            <fieldset id="user-basic-info" class="tab-pane active">
                <?php echo $this->element('Detail/User/user-basic-info_permission'); ?>
            </fieldset>        
        </div>
    </fieldset>
</div>