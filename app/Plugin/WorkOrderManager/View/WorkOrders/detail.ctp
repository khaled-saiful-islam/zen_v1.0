<div class="work-order view">
    <?php
    if( isset($modal) && $modal == "modal" ) {
        ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 id="add_item_label" style="font-size: 16px;">
                Work Order of&nbsp;<?php echo h($work_order['Quote']['job_name']); ?> [<?php echo h($work_order['WorkOrder']['work_order_number']); ?>]
            </h3>
        </div>
        <?php echo $this->element('Detail/WorkOrder/work-order-basic-info-detail'); ?>
        <?php
    }
    else {
        ?>
        <div class="report-buttons">
            <?php
            $pdf_list = $this->InventoryLookup->PDFList();
            $pdf_function_list = $this->InventoryLookup->PDFFunctionList();
            echo $this->Form->input('pdf_name', array( 'type' => 'select', 'label' => false, 'class' => 'form-select', 'options' => $pdf_list ));
            echo $this->Html->link(
                    'Quote Report', array( 'plugin' => 'quote_manager', 'controller' => 'quotes', 'action' => 'view_pdf', $quote['Quote']['id'] ), array( 'class' => 'open-quote-pdf-link', 'data_target' => 'quote_report', 'data_uuid' => $quote['Quote']['id'], 'title' => 'PDF Report', 'style' => 'margin-left: 200px;' )
            );
            ?>
        </div>
        <div style="clear: both;"></div>

        <fieldset>
            <legend><?php echo __('Work Order of ') . $work_order['Quote']['job_name'] . " [" . $work_order['WorkOrder']['work_order_number'] . "]"; ?></legend>
            <div class="report-buttons">
                <?php
                $report_list = $this->InventoryLookup->ReportsList();
                $report_function_list = $this->InventoryLookup->ReportsFunctionList();
                echo $this->Form->input('report_name', array( 'type' => 'select', 'label' => false, 'class' => 'form-select', 'options' => $report_list ));
                echo $this->Html->link(
                        '', array( 'controller' => 'quotes', 'action' => 'print_detail', $quote['Quote']['id'] ), array( 'class' => 'icon-print open-quote-report-link', 'data_target' => 'quote_report', 'data_uuid' => $quote['Quote']['id'], 'title' => 'Print Detail Information', 'style' => 'margin-left: 15px;' )
                );
                ?>
            </div>	
            <?php
//            echo $this->Html->link(
//                    '', array( 'plugin' => 'quote_manager', 'controller' => 'quotes', 'action' => 'pdf_wood_drawer_box', $work_order['Quote']['id'] ), array( 'class' => 'icon-print', 'title' => 'PDF', 'style' => 'margin-left: 15px;' )
//            );
            ?>
            <ul class="nav nav-tabs form-tab-nav" id="quotes-tab-nav">
                <li class="active"><a href="#work-order-basic-info-detail" data-toggle="tab"><?php echo __('General Information'); ?></a></li>            
                <li><a href="#work-order-detail" data-toggle="tab"><?php echo __('Work Order Detail'); ?></a></li>
                <li><a href="#work-order-po-list" data-toggle="tab"><?php echo __('Purchase Order'); ?></a></li>
                <li><a href="#payment-info" data-toggle="tab"><?php echo __('Payment Info'); ?></a></li>
                <li><a href="#quote-documents" data-toggle="tab"><?php echo __('Documents'); ?></a></li>
                <li><a href="#work-order-status-detail" data-toggle="tab"><?php echo __('Status'); ?></a></li>
            </ul>
            <div class="tab-content">
                <div id="work-order-basic-info-detail" class="sub-content-detail tab-pane active">
                    <div id="work-basic-info-detail-main">
                        <?php echo $this->element('Detail/WorkOrder/work-order-basic-info-detail', array( 'edit' => false )); ?>
                    </div>
                </div> 
                <div id="work-order-detail" class="sub-content-detail tab-pane">
                    <?php echo $this->element('Forms/WorkOrder/cabinet-order-form', array( 'quote' => $quote, 'edit' => true )); ?>
                </div>
                <div id="work-order-po-list" class="sub-content-detail tab-pane">
                    <?php echo $this->element('Detail/WorkOrder/work-order-po-list', array( 'edit' => true )); ?>
                </div>
                <div id="payment-info" class="sub-content-detail tab-pane">
                    <?php echo $this->element('Detail/WorkOrder/quote-payments-detail', array( 'edit' => true )); ?>
                    <?php echo $this->element('Forms/WorkOrder/payment-info-form', array( 'quote' => $quote, 'uploads' => $uploads, 'edit' => true )); ?>
                </div>
                <div id="quote-documents" class="sub-content-detail tab-pane">
                    <?php echo $this->element('Detail/WorkOrder/quote-documents-detail', array( 'edit' => true )); ?>
                    <?php echo $this->element('Forms/WorkOrder/quote-documents-form', array( 'quote' => $quote, 'uploads' => $uploads, 'edit' => true )); ?>
                </div>
                <div id="work-order-status-detail" class="sub-content-detail tab-pane">
                    <?php echo $this->element('Detail/WorkOrder/work-order-status-detail', array( 'edit' => true )); ?>
                </div>      
            </div>
        </fieldset>
    <?php } ?>
</div>

<script>
    var report_list = new Array();
    var pdf_list = new Array();
<?php
if( !empty($report_function_list) and is_array($report_function_list) ) {
    foreach( $report_function_list as $function_id => $report_function ) {
        ?>
                    report_list[<?php echo $function_id; ?>] = '<?php echo $report_function; ?>';
        <?php
    }
}
if( !empty($pdf_function_list) and is_array($pdf_function_list) ) {
    foreach( $pdf_function_list as $pdf_function_id => $pdf_function ) {
        ?>
            pdf_list[<?php echo $pdf_function_id; ?>] = '<?php echo $pdf_function; ?>';
        <?php
    }
}
?>
    $('a.open-quote-report-link').live('click', function(event) {
        event.preventDefault();
        var url = BASEURL + 'quote_manager/quotes/' + report_list[$('#report_name').val()] + '/' + $(this).attr("data_uuid");
        window.open(url, $(this).attr("data_target"), "status=0,toolbar=0,resizable=0,height=600,width=1030,location=0,scrollbars=1");
    });
    
    $('a.open-quote-pdf-link').live('click', function(event) {
        event.preventDefault();
        var url = BASEURL + 'quote_manager/quotes/' + pdf_list[$('#pdf_name').val()] + '/' + $(this).attr("data_uuid");
        window.open(url);
    });
	
</script>