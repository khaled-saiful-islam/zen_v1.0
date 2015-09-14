<div class="quoteReportsSettings index">
    <fieldset class="content-detail">
        <legend>
            <?php echo __($legend); ?>
        </legend>
        <div align="right">
            <a class="search_link" href="#">
                <span class="search-img">Search</span>
            </a>
        </div>
        <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover listing">
            <thead class="grid-header">
                <tr>
                    <th><?php echo $this->Paginator->sort('report_name'); ?></th>
                    <th><?php echo $this->Paginator->sort('departments'); ?></th>
                    <th class="actions"><?php echo __(''); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach( $quoteReportsSettings as $quoteReportsSetting ): ?>
                    <tr>
                        <td>
                            <?php echo $this->Html->link(h($quoteReportsSetting['QuoteReportsSetting']['report_name']), array( 'action' => DETAIL, $quoteReportsSetting['QuoteReportsSetting']['id'] ), array( 'class' => 'table-first-column-color', 'title' => __('View') )); ?>
                            &nbsp;
                        </td>
                        <td>
                            <?php
                            $item_departments = $this->InventoryLookup->ItemDepartment();
                            $departments = unserialize($quoteReportsSetting['QuoteReportsSetting']['departments']);
                            $department_list = array( );
                            if( !empty($departments) && is_array($departments) ) {
                                foreach( $departments as $department_id ) {
                                    $department_list[] = h($item_departments[$department_id]);
                                }
                            }
                            echo implode(',', $department_list);
                            ?>
                            &nbsp;</td>
                        <td class="actions">
                            <?php echo $this->Html->link(__(''), array( 'action' => DETAIL, $quoteReportsSetting['QuoteReportsSetting']['id'] ), array( 'class' => 'icon-file', 'title' => __('View') )); ?>
                            <?php echo $this->Html->link(__(''), array( 'action' => EDIT, $quoteReportsSetting['QuoteReportsSetting']['id'] ), array( 'class' => 'icon-edit', 'title' => __('Edit') )); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </fieldset>
    <?php echo $this->element('Common/paginator'); ?>
</div>
