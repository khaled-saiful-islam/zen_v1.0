<fieldset>
    <?php if( $edit ) { ?>
        <legend class='inner-legend'>Edit Quote</legend>
    <?php } ?>
    <?php
    $sales_person = $this->InventoryLookup->salesPersonList();
    $c_id = $this->InventoryLookup->FindRecentCustomer();

    $customer_add = json_encode($customers);
    ?>
    <script type="text/javascript">
        $(function(){
            json_costomer_address = <?php echo $customer_add; ?>;
        });

    </script>
    <?php
    if( empty($this->data['Quote']['quote_number']) ) {
        $quote_number = $this->InventoryLookup->auto_generate_number('Quote');
        ?>
        <?php echo $this->Form->input('quote_number', array( 'type' => 'hidden', 'value' => $quote_number )); ?>
    <?php }
    else {
        ?>
        <?php echo $this->Form->input('quote_number', array( 'type' => 'hidden' )); ?>
<?php } ?>
    <table class='item-cost-calculation table-form-big'>
        <tr>
            <th><label for="QuoteCustomerId">Customer: </label></th>
                <?php //echo $this->Form->input('last_customer_add_id', array('type' => 'hidden'));   ?>
            <td colspan="2"><?php echo $this->Form->input('customer_id', array( 'placeholder' => 'Customer', 'options' => $this->InventoryLookup->Customer(), 'empty' => true, 'class' => 'form-select required customer' )); ?>
<?php if( !$edit ) { ?>
                    <span style="position: relative; top: -10px; left: 25px;"><a href="#add-custom-panel-modal" role="button" class="btn btn-inverse" data-toggle="modal">Add Customer</a></span>

                    <div class="project_section" style="display: none;">
    <?php echo $this->Form->input('project_id', array( 'placeholder' => 'Project', 'options' => $this->InventoryLookup->findBuilderCustomer(), 'empty' => true, 'class' => 'form-select', 'style' => 'width: 165px;' )); ?>
                        <span style="position: relative; top: -10px; left: 25px;"><a href="#add-project-modal" role="button" class="btn btn-inverse" data-toggle="modal">Add Project</a></span>
                    </div>
<?php } ?>
            </td>
            <th><label>ESD: </label></th>
            <td>
<?php echo $this->Form->input('est_shipping', array( 'placeholder' => 'Estimated Shipping Date', 'class' => 'dateP', 'type' => 'text', 'value' => isset($quote_data['Quote']['est_shipping']) ? $this->Util->formatDate($quote_data['Quote']['est_shipping']) : '' )); ?>
            </td>
        </tr>
<?php //echo $this->element('Forms/address-sub-form', array('edit' => false));   ?>
        <tr>
            <th rowspan="3"><label for="QuoteAddress">Address: </label></th>
            <td colspan="2">
                <label class="wide-width">Address:</label>
<?php echo $this->Form->input('address', array( 'placeholder' => 'Address', 'class' => 'address wide-input' )); ?>
            </td>
            <th rowspan="3"><label for="QuoteJobDetail">Job Detail: </label></th>
            <td rowspan="3" colspan="3"><?php echo $this->Form->input('job_detail', array( 'placeholder' => 'Job Detail', 'class' => '', 'rows' => 7, 'cols' => '88' )); ?></td>
        </tr>
        <tr>
            <td class="">
                <label class="wide-width">City:</label>
<?php echo $this->Form->input('city', array( 'placeholder' => 'City', 'class' => 'city' )); ?>
            </td>
            <td>
                <label class="wide-width">Province:</label>
<?php echo $this->Form->input('province', array( 'options' => Configure::read('PROVINCE'), 'default' => 'Alberta', 'class' => 'form-select province', 'style' => 'width:120px;' )); ?>
            </td>
        </tr>
        <tr>
            <td>
                <label class="wide-width">Country:</label>
<?php echo $this->Form->input('country', array( 'value' => 'Canada', 'readonly' => 'readonly', 'class' => '' )); ?>
            </td>
            <td class="width-min">
                <label class="wide-width">Postal Code:</label>
<?php echo $this->Form->input('postal_code', array( 'placeholder' => 'Postal Code', 'class' => 'postal_code', 'style' => 'width:75px;' )); ?>
            </td>
        </tr>
        <tr>
            <th><label for="QuoteSkidNumber">Skid Number: </label></th>
            <td colspan="2"><?php echo $this->Form->input('skid_number', array( 'placeholder' => 'Skid Number', 'type' => 'text', 'rows' => 3, 'cols' => '88' )); ?>
            </td>
            <th><label for="QuoteSkidWeight">Skid Weight: </label></th>
            <td>
<?php echo $this->Form->input('skid_weight', array( 'placeholder' => 'Skid Weight', 'type' => 'text', 'rows' => 3, 'cols' => '88' )); ?>
            </td>
        </tr>
        <tr>
            <th><label for="QuoteSkidNumber">First Measure: </label></th>
            <td colspan="2"><?php echo $this->Form->input('first_date_measure', array( 'placeholder' => 'First Measure', 'type' => 'text', 'class' => 'dateP', 'value' => isset($quote_data['Quote']['first_date_measure']) ? $this->Util->formatDate($quote_data['Quote']['first_date_measure']) : '' )); ?>
            </td>
            <th><label for="QuoteSkidWeight">Second Measure: </label></th>
            <td>
<?php echo $this->Form->input('second_date_measure', array( 'placeholder' => 'Second Measure', 'type' => 'text', 'class' => 'dateP', 'value' => isset($quote_data['Quote']['second_date_measure']) ? $this->Util->formatDate($quote_data['Quote']['second_date_measure']) : '' )); ?>
            </td>
        </tr>
    <!--		<tr>
                            <th><label for="QuoteSkidNumber">Interior: </label></th>
                            <td colspan="2">
<?php echo $this->Form->input('is_interior_melamine', array( 'type' => 'checkbox', 'label' => 'White Melamine', 'div' => true )); ?>
                            </td>
                    </tr>-->
    </table>
    <table class="table-form-big table-form-big-margin">
        <tr>

        </tr>
    </table>
</fieldset>

<script type="text/javascript">
    $(".customer").bind('click', function() {

        var customer_id = $(this).val();
        $.ajax({
            url: BASEURL + "customer_manager/builder_projects/getProjectSection/" + customer_id,
            type: 'POST',
            data: null,
            success: function(data) {
                if(data == 1){
                    $('.project_section').css('display', 'block');
                    $('#BuilderProjectCustomerId').val(customer_id);
                }
                if(data == 0){
                    $('.project_section').css('display', 'none');
                }
            }
        });
    });
</script>