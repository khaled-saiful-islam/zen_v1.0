<div class="quotes form form-margin-bottom">
    <?php echo $this->Form->create('Quote', array( 'inputDefaults' => array( 'label' => false, 'div' => false ), 'class' => 'quote-form ajax-form-submit' )); ?>
    <?php
    $all_items = $this->InventoryLookup->ListAllTypesOfItems();
    $main_item_list = $all_items['main_list'];
    $price_list = $all_items['price_list'];
    $title_list = $all_items['title_list'];
    ?>
    <script type="text/javascript">
        $(function(){
            json_price = <?php echo json_encode($price_list); ?>;
            json_title = <?php echo json_encode($title_list); ?>;
        });

    </script>
    <?php
    $sub_form = $this->InventoryLookup->form_elements('Quote', $section);

    echo $this->element('Forms/Quote/' . $sub_form['from'] . "-new", array( 'edit' => $edit, 'section' => $section, 'main_item_list' => $main_item_list, 'price_list' => $price_list, 'title_list' => $title_list ));
    ?>

    <div class="align-left align-top-margin">
        <?php echo $this->Form->input('Save', array( 'type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save' )); ?>
    </div>
    <div class="align-left align-top-margin">
        <?php echo $this->Html->link('Cancel', array( 'action' => 'detail_section', $id, $section ), array( 'data-target' => '#' . $sub_form['detail'], 'class' => 'ajax-sub-content btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel' )); ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>

<div id="add-custom-panel-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Add Customer</h3>
    </div>
    <div class="modal-body">
        <?php
        echo $this->Form->create('Customer', array( 'inputDefaults' => array( ) ));
        ?>
        <table class="customer_quote_form">
            <tr>
                <th>Customer: </th>
                <td>
                    <?php
                    echo $this->Form->input('Customer.first_name', array(
                        'class' => 'input-medium',
                        'placeholder' => "First Name",
                        'label' => false,
                    ));
                    ?>
                    <div style="color: red; display: none;" class="error-message-customer">Minimum 6 Characters</div>
                </td>
                <td>
                    <?php
                    echo $this->Form->input('Customer.last_name', array(
                        'class' => 'input-medium',
                        'placeholder' => "last Name",
                        'label' => false,
                    ));
                    ?>
                    <div style="color: red; display: none;" class="error-message-customer">&nbsp;</div>
                </td>
            </tr>
            <tr>
                <th>Phone: </th>
                <td>
                    <?php
                    echo $this->Form->input('Customer.phone', array(
                        'class' => 'input-medium fillone phone-mask',
                        'placeholder' => '(000) 000-0000',
                        'label' => false,
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <th>Sales Person: </th>
                <td>
                    <?php
                    echo $this->Form->input('Customer.sales_representatives', array(
                        'class' => 'form-select required input-medium',
                        'label' => false,
                        "multiple" => true,
                        "options" => $this->InventoryLookup->salesPersonList()
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <th>Type: </th>
                <td>
                    <?php
                    echo $this->Form->input('Customer.type', array(
                        'class' => 'input-medium form-select',
                        'label' => false,
                        'empty' => false,
                        'placeholder' => 'Type',
                        'options' => array( 'Retail Customer' => 'Retail Customer', 'Builder' => 'Builder' )
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="button" id="add-customer-quote" class="btn btn-info add-more" value="Save" />
                </td>
            </tr>
        </table>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<!---------------------------------------------------------------------------------------------->

<div id="add-project-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Add Project</h3>
    </div>
    <div class="modal-body">
        <?php
        echo $this->Form->create('BuilderProject', array( 'inputDefaults' => array( ) ));
        ?>
        <table class="customer_quote_form">
            <tr>
                <th>Project: </th>
                <td>
                    <?php
                    echo $this->Form->input('BuilderProject.project_name', array(
                        'class' => 'input-medium',
                        'placeholder' => "Project Name",
                        'label' => false,
                    ));
                    ?>
                    <?php echo $this->Form->hidden('selected_customer_id', array( )); ?>
                    <div style="color: red; display: none;" class="error-message-customer">Project Name Required.</div>
                </td>
            </tr>
            <tr>
                <th>Site Address: </th>
                <td>
                    <?php
                    echo $this->Form->input('BuilderProject.site_address', array(
                        'class' => 'input-xlarge',
                        'placeholder' => "Site Address",
                        'label' => false,
                    ));
                    ?>
                    <div style="color: red; display: none;" class="error-message-customer">Site Address Required.</div>
                </td>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <td>
                    <table>
                        <tr>
                            <td>
                                <?php
                                echo $this->Form->input('BuilderProject.city', array(
                                    'class' => 'input-medium',
                                    'placeholder' => "City",
                                    'label' => false
                                ));
                                ?>
                            </td>
                            <td>
                                <?php echo $this->Form->input('province', array( 'options' => Configure::read('PROVINCE'), 'default' => 'Alberta', 'class' => 'form-select', 'style' => 'width:120px;', 'label' => false )); ?>
                            </td>
                        </tr>
                    </table>
                </td>

            </tr>
            <tr>
                <th>&nbsp;</th>
                <td>
                    <table>
                        <tr>
                            <td>
                                <?php
                                echo $this->Form->input('BuilderProject.postal_code', array(
                                    'class' => 'input-medium',
                                    'placeholder' => "Postal Code",
                                    'label' => false,
                                ));
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $this->Form->input('BuilderProject.country', array(
                                    'class' => 'input-medium',
                                    'placeholder' => "Country",
                                    'label' => false,
                                ));
                                ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <th>Contact Person: </th>
                <td>
                    <?php
                    echo $this->Form->input('BuilderProject.contact_person', array(
                        'class' => 'input-medium',
                        'placeholder' => 'Contact Person',
                        'label' => false,
                    ));
                    ?>
                    <div style="color: red; display: none;" class="error-message-customer">Contact Person Required.</div>
                </td>
            </tr>
            <tr>
                <th>Phone: </th>
                <td>
                    <?php
                    echo $this->Form->input('BuilderProject.contact_person_phone', array(
                        'class' => 'input-medium phone-mask',
                        'placeholder' => '(000) 000-0000',
                        'label' => false,
                    ));
                    ?>
                    <div style="color: red; display: none;" class="error-message-customer">Contact Person Phone Required.</div>
                </td>
            </tr>
            <tr>
                <th>Cell: </th>
                <td>
                    <?php
                    echo $this->Form->input('BuilderProject.contact_person_cell', array(
                        'class' => 'input-medium phone-mask',
                        'placeholder' => '(000) 000-0000',
                        'label' => false,
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <th style="width: 150px!important;">Multi Family Pricing:</th>
                <td>
                    <?php echo $this->Form->input('BuilderProject.multi_family_pricing', array( 'type' => 'checkbox', 'label' => '', 'div' => true )); ?>
                </td>
            </tr>
            <tr>
<!--					<th>Builder Name: </th>-->
                <td>
                    <?php
                    echo $this->Form->hidden('BuilderProject.customer_id', array(
                        'class' => 'input-medium',
                        'label' => false,
                        'empty' => true
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <th>Comments: </th>
                <td><?php echo $this->Form->input('BuilderProject.comment', array( 'placeholder' => 'Comments', 'type' => 'text', 'rows' => 3, 'cols' => '88', 'label' => false, )); ?></td>
            </tr>
            <tr>
                <td>
                    <input type="button" id="add-project-sction" class="btn btn-info add-more" value="Save" />
                </td>
            </tr>
        </table>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $("#add-customer-quote").click(function() {
            if(CustomFormQuote(true)) {
                $('#add-custom-panel-modal').modal('hide');
            }
        });
        $("#add-project-sction").click(function() {
            if(BuilderProject(true)) {
                $('#add-project-modal').modal('hide');
            }
        });		
    });
</script>

<script type="text/javascript">

    $(".quote-form").validate({ignore: null});
    //<?php if( $edit && !empty($section) ) { // do ajax if edit             ?>
        $(".quote-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#//<?php echo $sub_form['detail']; ?>'});
        //<?php } ?>

</script>

<style type="text/css">
    .modal-body{
        max-height: 550px!important
    }
    .modal{
        height: 550px!important;
    }
</style>