<div class="colors form">
    <?php echo $this->Form->create('Color', array( 'class' => 'color-form ajax-form-submit', 'type' => 'post' )); ?>
    <fieldset>
        <?php
        echo $this->Form->input('name', array( 'class' => 'required' ));
        echo $this->Form->input('code', array( 'class' => 'required' ));
        ?>
    </fieldset>

    <fieldset id="cabinet-matarials" class="color-section">
        <legend><?php echo __('Cabinet Matarials'); ?></legend>
        <?php
        echo $this->Form->input('ColorSection.0.cost', array( 'class' => 'cabinate_material_cost' ));
        echo $this->Form->input('ColorSection.0.markup', array( 'class' => 'cabinate_material_markup' ));
        echo $this->Form->input('ColorSection.0.price', array( 'class' => 'cabinate_material_price', 'readonly' => true ));
        ?>
        <div class="input select">
            <label>EdgeTape</label>
            <?php
            if( isset($datas['ColorSection']) ) {
                foreach( $datas['ColorSection'] as $data ) {
                    if( $data['type'] == 'cabinate_material' )
                        $c_m_id = isset($data['id']) ? $data['id'] : '';
                    if( $data['type'] == 'door_material' )
                        $d_m_id = isset($data['id']) ? $data['id'] : '';
                }
            }
            echo $this->Form->input('ColorSection.0.edgetape_id', array( 'options' => $this->InventoryLookup->getItemOption(), 'class' => 'edgetape_id form-select','empty' => true , 'label' => false));
            //echo $this->Form->input('ColorSection.0.edgetape_id', array( 'class' => 'edgetape_id form-select-ajax-item-edgetape', 'type' => 'hidden', 'empty' => true ));
            ?>
        </div>
        <?php
        $i = 0;
        if( isset($datas['ColorMaterial']) ) {
            foreach( $datas['ColorMaterial'] as $d ) {
                if( isset($c_m_id) && $c_m_id == $d['color_section_id'] )
                    $cab[$i] = $d['material_id'];
                $i++;
            }
        }
        echo $this->Form->input('ColorSection.0.ColorMaterial.0.material_id', array( 'options' => $this->InventoryLookup->getMaterial(), 'class' => 'form-select wide-input', 'multiple' => 'multiple', 'value' => isset($cab) ? $cab : '' ));
        ?>
    </fieldset>

    <fieldset id="door-matarials" class="color-section">
        <legend><?php echo __('Door Matarials'); ?></legend>
        <?php
        echo $this->Form->input('ColorSection.1.cost', array( 'class' => 'door_material_cost' ));
        echo $this->Form->input('ColorSection.1.markup', array( 'class' => 'door_material_markup' ));
        echo $this->Form->input('ColorSection.1.price', array( 'class' => 'door_material_price', 'readonly' => true ));
        ?>
        <div class="input select">
            <label>EdgeTape</label>
        <?php
        //echo $this->Form->input('ColorSection.1.edgetape_id', array( 'class' => 'edgetape_id form-select-ajax-item-edgetape', 'type' => 'hidden', 'empty' => true ));
        echo $this->Form->input('ColorSection.1.edgetape_id', array( 'options' => $this->InventoryLookup->getItemOption(), 'class' => 'edgetape_id form-select','empty' => true , 'label' => false));
        ?>
        </div>
        <?php
        $j = 0;
        if( isset($datas['ColorMaterial']) ) {
            foreach( $datas['ColorMaterial'] as $d ) {
                if( isset($d_m_id) && $d_m_id == $d['color_section_id'] )
                    $door[$j] = $d['material_id'];
                $j++;
            }
        }
        echo $this->Form->input('ColorSection.1.ColorMaterial.0.material_id', array( 'options' => $this->InventoryLookup->getMaterial(), 'class' => 'form-select wide-input', 'multiple' => 'multiple', 'value' => isset($door) ? $door : '' ));
        ?>
    </fieldset>

    <div class="clear"></div>
    <div class="align-left align-top-margin">
    <?php echo $this->Form->input('Save', array( 'type' => 'submit', 'class' => 'btn btn-success', 'label' => false, 'value' => 'Save' )); ?>
    </div>
        <?php if( !$edit ) { ?>
        <div class="align-left align-top-margin">
        <?php echo $this->Html->link('Cancel', array( 'action' => 'index' ), array( 'data-target' => '#MainContent', 'class' => 'ajax-sub-content btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel' )); ?>
        </div>
    <?php }
    else { ?>
        <div class="align-left align-top-margin">
    <?php echo $this->Html->link('Cancel', array( 'action' => 'detail_section', $item_id, $section ), array( 'data-target' => '#' . $sub_form['detail'], 'class' => 'ajax-sub-content btn btn-success btn-padding', 'label' => false, 'value' => 'Cancel' )); ?>
        </div>
<?php } ?>
<?php echo $this->Form->end(); ?>
</div>
<script>
    $(".color-form").validate({ignore: null});
    //  $(".color-form").ajaxForm({url: $(this).attr('action'), type: 'post',  target: '#MainContent'});
    $(function(){
        $('.cabinate_material_cost, .cabinate_material_markup').live('change',function(){
            cost = $('.cabinate_material_cost').val();
            markup = $('.cabinate_material_markup').val();
            price = parseFloat(cost * markup).toFixed(2);
            $('.cabinate_material_price').val(price);
        });
        $('.door_material_cost, .door_material_markup').live('change',function(){
            cost = $('.door_material_cost').val();
            markup = $('.door_material_markup').val();
            price = parseFloat(cost * markup).toFixed(2);
            $('.door_material_price').val(price);
        })
    })
</script>
