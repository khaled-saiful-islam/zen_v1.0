<?php
if( $paginate ) {
    ?>
    <div class="items index">
        <fieldset class="content-detail">
            <legend>
                <?php echo __($legend); ?>
            </legend>
            <div align="right">
                <a class="search_link" href="#">
                    <span class="search-img">Search</span>
                </a>
            </div>
            <div id="search_div">
                <?php echo $this->Form->create('MaterialGroup', array( 'url' => array_merge(array( 'action' => 'index' ), $this->params['pass']), 'inputDefaults' => array( 'label' => false, 'div' => false ) )); ?>
                <table class="table-form-big search_div">
                    <tr>
                        <td>
                            <?php echo "<div class=''>Name</div>" . $this->Form->input('name', array( 'placeholder' => 'Name' )); ?>
                        </td>
                        <td>
                            <?php echo "<div class=''>Code</div>" . $this->Form->input('code', array( 'placeholder' => 'Code' )); ?>
                        </td>
                        <td>
                            <?php echo $this->Form->submit(__('Search'), array( 'class' => 'btn btn-success item_submit' )); ?>
                        </td>
                    </tr>
                </table>
                <?php echo $this->Form->end(); ?>
            </div>
            <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
                <thead>
                    <tr class="grid-header">
                        <th class="min-width"><?php echo $this->Paginator->sort('name'); ?></th>
                        <th class="min-width"><?php echo $this->Paginator->sort('code'); ?></th>
                        <th class="min-width"><?php echo $this->Paginator->sort('default'); ?></th>
                        <th class="actions"><?php echo __(''); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    foreach( $materialgroups as $materialgroup ):
                        $count++;
                        ?>
                        <tr class="<?php //echo $odd_even;    ?>">
                            <td><?php echo h($materialgroup['MaterialGroup']['name']); ?>&nbsp;</td>
                            <td><?php echo h($materialgroup['MaterialGroup']['code']); ?>&nbsp;</td>
                            <td><?php
                if( $materialgroup['MaterialGroup']['default'] == 1 )
                    echo "Yes";
                if( $materialgroup['MaterialGroup']['default'] == 0 )
                    echo "No";
                        ?>&nbsp;</td>
                            <td class="actions">
                        <?php echo $this->Html->link('', array( 'action' => DETAIL, $materialgroup['MaterialGroup']['id'] ), array( 'class' => 'icon-folder-open show-tooltip', 'title' => __('View') )); ?>
                        <?php echo $this->Form->postLink('', array('action' => DELETE, $materialgroup['MaterialGroup']['id']), array('class' => 'icon-trash show-tooltip', 'title' => __('Delete')), __('Are you sure you want to delete # %s?', $materialgroup['MaterialGroup']['id'])); ?>
                            </td>
                        </tr>
    <?php endforeach; ?>
                </tbody>
            </table>

        </fieldset>
    <?php echo $this->element('Common/paginator'); ?>
    </div>
<?php }else { ?>
    <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing items-report-table">
        <thead>
            <tr class="grid-header">
                <th><?php echo h('Name'); ?></th>
                <th><?php echo h('Code'); ?></th>
                <th><?php echo h('Default'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 0;
            foreach( $materialgroups as $materialgroup ):
                $count++;
                ?>
                <tr class="<?php //echo $odd_even;    ?>">
                    <td><?php echo h($materialgroup['MaterialGroup']['name']); ?>&nbsp;</td>
                    <td><?php echo h($materialgroup['MaterialGroup']['code']); ?>&nbsp;</td>
                    <td><?php echo h($materialgroup['MaterialGroup']['default']); ?>&nbsp;</td>
                </tr>
    <?php endforeach; ?>
        </tbody>
    </table>
<?php } ?>