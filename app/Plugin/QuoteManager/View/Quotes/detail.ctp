<?php ?>
<div class="quotes view">
    <?php
    if( isset($modal) && $modal == "modal" ) {
        ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 id="add_item_label" style="font-size: 16px;">
                Quote:&nbsp;<?php echo h($quote['Quote']['job_name']) . ' [' . $quote['Quote']['quote_number'] . ']'; ?>
            </h3>
        </div>
        <?php echo $this->element('Detail/Quote/quote-basic-info-detail-main'); ?>
    <?php
    }
    else {
        ?>
        <fieldset>
            <legend>
                <div style="float: left;">
                    <?php echo __('Quote of ') . h($quote['Quote']['job_name']) . ' [' . $quote['Quote']['quote_number'] . ']'; ?>
                </div>
                <?php $number = explode("-", $quote['Quote']['quote_number']); ?>
                <div style="margin-left: 20px; float: left; font-size: 12px;"><a class="cad_link btn btn-success" href="#">Design</a></div>
                
                <div style="margin-left: 20px; float: right; margin-top: 10px;">
                    <?php
                    echo $this->Html->link(
                            'Create Duplicate Quote', array( 'controller' => 'quotes', 'action' => 'create_new_quote_from_existing_quote', $quote['Quote']['id'] ), array( 'class' => 'btn btn-success', 'title' => 'Copy', 'style' => 'margin-left: 15px;margin-right: 15px; float: right; position: relative; bottom: 10px; font-size: 12px;' )
                    );
                    ?>
                </div>
                <div style="clear: both;"></div>
                <div style="float: right; font-size: 12px;">	
                    <?php
                    echo $this->Html->link(
                            '<i class="icon-print icon-black"></i> Quote Preview', array( 'controller' => 'quotes', 'action' => 'print_detail', $quote['Quote']['id'] ), array( 'class' => 'open-link', 'data_target' => 'quote_report', 'data_uuid' => $quote['Quote']['id'], 'title' => 'Print Detail Information', 'style' => 'margin-left: 15px;margin-right: 15px; float: right;', "escape" => false )
                    );
                    ?>
                </div>
                
                <?php
//                echo $this->Html->link(
//                        '', array( 'controller' => 'quotes', 'action' => 'view_pdf', $quote['Quote']['id'] ), array( 'class' => 'icon-print', 'title' => 'PDF', 'style' => 'margin-left: 15px;' )
//                );
                ?>
            </legend>

            <ul class="nav nav-tabs form-tab-nav" id="quotes-tab-nav">
                <li class="active"><a href="#quote-basic-info-detail" data-toggle="tab"><?php echo __('General Information'); ?></a></li>
                <li><a href="#quote-detail" data-toggle="tab"><?php echo __('Quote Detail'); ?></a></li>
                <li><a href="#payment-info" data-toggle="tab"><?php echo __('Payment Info'); ?></a></li>
                <li><a href="#quote-documents" data-toggle="tab"><?php echo __('Documents'); ?></a></li>
                <li><a href="#quote-history-detail" data-toggle="tab"><?php echo __('History'); ?></a></li>
            </ul>
            <div class="tab-content">
                <div id="quote-basic-info-detail" class="sub-content-detail tab-pane active">
                    <div id="quote-basic-info-detail-main">
                        <?php echo $this->element('Detail/Quote/quote-basic-info-detail-main', array( 'edit' => true )); ?>
                    </div>
                </div>
                <div id="quote-detail" class="sub-content-detail tab-pane">
                    <?php echo $this->element('Forms/Order/cabinet-order-form', array( 'quote' => $quote, 'CabinetOrder' => $quote['CabinetOrder'], 'edit' => true )); ?>
                </div>
                <div id="payment-info" class="sub-content-detail tab-pane">
                    <?php echo $this->element('Detail/Quote/quote-payments-detail', array( 'edit' => true )); ?>
                    <?php echo $this->element('Forms/Quote/payment-info-form', array( 'quote' => $quote, 'uploads' => $uploads, 'edit' => true )); ?>
                </div>
                <div id="quote-documents" class="sub-content-detail tab-pane">
                    <?php echo $this->element('Detail/Quote/quote-documents-detail', array( 'edit' => true )); ?>
                    <?php echo $this->element('Forms/Quote/quote-documents-form', array( 'quote' => $quote, 'uploads' => $uploads, 'edit' => true )); ?>
                </div>
                <div id="quote-history-detail" class="sub-content-detail tab-pane">
                    <?php echo $this->element('Detail/Quote/quote-history-detail', array( 'edit' => true )); ?>
                </div>
            </div>
        </fieldset>
<?php } ?>
</div>
<form target="_blank" method="POST" style="display: none;" id="cad_link_quote" action="https://cad.zen-living.ca/opencad.php">
    <input type="text" name="quote" value="<?php echo $number[0]; ?>">
    <input type="text" name="userid" value="<?php echo $loginUser['id']; ?>">
    <input type="text" name="first_name" value="<?php echo $loginUser['first_name']; ?>">
    <input type="text" name="last_name" value="<?php echo $loginUser['last_name']; ?>">
</form>

<script>
    var report_list = new Array();
<?php
if( !empty($report_function_list) and is_array($report_function_list) ) {
    foreach( $report_function_list as $function_id => $report_function ) {
        ?>
                    report_list[<?php echo $function_id; ?>] = '<?php echo $report_function; ?>';
        <?php
    }
}
?>
    $('a.open-quote-report-link').live('click', function(event) {
        event.preventDefault();
        var url = BASEURL + 'quote_manager/quotes/' + report_list[$('#report_name').val()] + '/' + $(this).attr("data_uuid");
        window.open(url, $(this).attr("data_target"), "status=0,toolbar=0,resizable=0,height=600,width=1020,location=0,scrollbars=1");
    });
	
    $('.cad_link').click(function(event){
        //event.preventDefault();
        $('#cad_link_quote').submit();
    });
</script>