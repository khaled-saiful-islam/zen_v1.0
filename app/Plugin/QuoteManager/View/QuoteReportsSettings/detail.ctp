<div class="quoteReportsSettings view">
    <fieldset>
        <legend>
            <?php echo __('Quote Reports Setting'); ?>
        </legend>
        <?php
        if( $edit ) {
            echo $this->Html->link('Return', array( 'controller' => "quote_reports_settings", 'action' => 'index' ), array( 'data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success right' ));
            echo $this->Html->link('Edit Quote', array( 'action' => EDIT, $quoteReportsSetting['QuoteReportsSetting']['id'] ), array('style' => 'margin-right: 10px;', 'data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success right' ));
        }
        ?>
        <table class="table-form-big margin-bottom">
            <tr>
                <th><?php echo __('Report Name'); ?></th>
                <td>
                    <?php echo h($quoteReportsSetting['QuoteReportsSetting']['report_name']); ?>
                    &nbsp;
                </td>
            </tr>
            <tr>
                <th><?php echo __('Departments'); ?></th>
                <td style="min-width: 350px;">
                    <ul>
                        <?php
                        $item_departments = $this->InventoryLookup->ItemDepartment();
                        $departments = unserialize($quoteReportsSetting['QuoteReportsSetting']['departments']);
                        if( !empty($departments) && is_array($departments) ) {
                            foreach( $departments as $department_id ) {
                                echo '<li>' . h($item_departments[$department_id]) . '</li>';
                            }
                        }
                        ?>
                    </ul>
                    &nbsp;
                </td>
            </tr>
        </table>
    </fieldset>
</div>