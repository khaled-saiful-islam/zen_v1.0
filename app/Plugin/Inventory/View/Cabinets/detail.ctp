<div class="cabinets view">
    <?php //echo $this->element('Actions/cabinet', array('detail' => true)); ?>
    <!--<fieldset class="content-detail">
      <legend><?php echo __('Cabinet'); ?></legend>
      <ul class="nav nav-tabs form-tab-nav" id="cabinet-tab-nav">
        <li class="active"><a href="#cabinet_information" data-toggle="tab"><?php echo __('Cabinet Information'); ?></a></li>
        <li><a href="#cabinet_door_drawer" data-toggle="tab"><?php echo __('Door/Drawer Information'); ?></a></li>
        <li><a href="#cabinet_items" data-toggle="tab"><?php echo __('Cabinet Items'); ?></a></li>
        <li><a href="#cabinet_pricing" data-toggle="tab"><?php echo __('Cabinet Pricing Information'); ?></a></li>
      </ul>
      <div class="tab-content">
        <div id="cabinet_information" class="sub-content-detail tab-pane active">
    <?php echo $this->element('Detail/cabinet-basic-info-detail', array( 'edit' => $edit )); ?>
        </div>-->
    <?php //echo $this->element('Actions/cabinet', array('detail' => true)); ?>
    <div class="report-buttons">
        <?php
        echo $this->Html->link(
                '', array( 'controller' => 'cabinets', 'action' => 'print_detail', $cabinet['Cabinet']['id'] ), array( 'class' => 'icon-print open-link', 'data_target' => 'item_report', 'title' => 'Print Detail Information' )
        );
        ?>
    </div>
    <fieldset class="content-detail">
        <legend><?php echo __('Cabinet'); ?>:&nbsp;<?php echo h($cabinet['Cabinet']['name']); ?>
            &nbsp;</legend>
        <ul class="nav nav-tabs form-tab-nav" id="cabinet-tab-nav">
            <li class="active"><a href="#cabinet_information" data-toggle="tab"><?php echo __('Cabinet Information'); ?></a></li>
            <li><a href="#cabinet_door_drawer" data-toggle="tab"><?php echo __('Door/Drawer Information'); ?></a></li>
            <li><a href="#cabinet_items" data-toggle="tab"><?php echo __('Cabinet Parts'); ?></a></li>
            <li><a href="#cabinet_installation" data-toggle="tab"><?php echo __('Installation'); ?></a></li>
            <li><a href="#cabinet_accessories" data-toggle="tab"><?php echo __('Accessory'); ?></a></li>
            <li><a href="#cabinet_general" data-toggle="tab"><?php echo __('General'); ?></a></li>
        </ul>
        <div class="tab-content">
            <div id="cabinet_information" class="sub-content-detail tab-pane active">
                <?php echo $this->element('Detail/Cabinet/cabinet-basic-info-detail', array( 'edit' => $edit )); ?>
            </div>
            <div id="cabinet_door_drawer" class="sub-content-detail tab-pane">
                <?php echo $this->element('Detail/Cabinet/cabinet-door-drawer-detail', array( 'edit' => $edit )); ?>
            </div>
            <div id="cabinet_items" class="sub-content-detail tab-pane">
                <?php echo $this->element('Detail/Cabinet/cabinet-items-detail', array( 'edit' => $edit )); ?>
            </div>
            <div id="cabinet_installation" class="sub-content-detail tab-pane">
                <?php echo $this->element('Detail/Cabinet/cabinet-installation-detail', array( 'edit' => $edit )); ?>
            </div>
            <div id="cabinet_accessories" class="sub-content-detail tab-pane">
                <?php echo $this->element('Detail/Cabinet/cabinet-accessories-detail', array( 'edit' => $edit )); ?>
            </div>
            <div id="cabinet_general" class="sub-content-detail tab-pane">
                <?php echo $this->element('Forms/Cabinet/cabinet-general-form', array( 'edit' => $edit )); ?>
            </div>
        </div>


        <!--    <div class="related">
        <?php if( !empty($cabinet['Item']) ): ?>
                                <h3><?php echo __('Related Items'); ?></h3>
                                <table cellpatding="0" cellspacing="0" class="table table-bordered table-hover listing">
                                  <thead>
                                    <tr class="heading">
                                      <th class="min-witdh"><?php echo __('Number'); ?></th>
                                      <th class="min-witdh"><?php echo __('Item Cost'); ?></th>
                                      <th class="min-witdh"><?php echo __('Price'); ?></th>
                                      <th class="min-witdh"><?php echo __('Current Stock'); ?></th>
                                      <th class="actions"><?php echo __('Actions'); ?></th>
                                    </tr>
                                  </thead>
                                  <tbody>
            <?php
            $count = 0;
            foreach( $cabinet['Item'] as $item ):
                $count++;
                $odd_even = 'odd';
                if( ($count % 2) == 0 ) {
                    $odd_even = 'even';
                }
                ?>
                                                      <tr class="<?php echo $odd_even; ?>">
                                                        <td><?php echo $this->Html->link(h($item['number']), array( 'controller' => 'items', 'action' => DETAIL, $item['id'] ), array( 'title' => __('View'), 'class' => 'show-detail-ajax' )); ?>&nbsp;</td>
                                                        <td><?php echo h($item['item_cost']); ?>&nbsp;</td>
                                                        <td><?php echo h($item['price']); ?>&nbsp;</td>
                                                        <td><?php echo h($item['current_stock']); ?>&nbsp;</td>
                                                        <td class="actions">
                <?php echo $this->Html->link('', array( 'controller' => 'items', 'action' => DETAIL, $item['id'] ), array( 'class' => 'icon-file show-detail-ajax', 'title' => __('View') )); ?>
                <?php echo $this->Html->link('', array( 'controller' => 'items', 'action' => EDIT, $item['id'] ), array( 'class' => 'icon-edit show-edit-ajax', 'title' => __('Edit') )); ?>
                <?php echo $this->Form->postLink('', array( 'controller' => 'items', 'action' => DELETE, $item['id'] ), array( 'class' => 'icon-trash show-tooltip', 'title' => __('Delete') ), __('Are you sure you want to delete # %s?', $item['id'])); ?>
                                                        </td>
                                                      </tr>
            <?php endforeach; ?>
                                  </tbody>
                                </table>
        <?php endif; ?>
            </div>-->
    </fieldset>
</div>
