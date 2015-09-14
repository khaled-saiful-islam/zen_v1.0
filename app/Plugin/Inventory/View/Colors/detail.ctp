<div  class="colors view" id="ColorAddForm"><?php //pr($color);  ?>
    <?php echo "<span style='float: right'>" . $this->Html->link('Edit Color', array( 'action' => EDIT, $color['Color']['id'] ), array( 'data-target' => '#ColorAddForm', 'class' => 'ajax-sub-content btn btn-success', 'title' => __('Edit Color') )) . "</span>"; ?>
    <fieldset><legend>Color Detail</legend></fieldset>
    <fieldset style="margin-bottom: 20px;">
        <?php
        echo "<span style='display: block; width: 90px; float: left;'>Name: </span>" . "<span style='float: left;'>" . $color['Color']['name'] . "</span></br></br>";
        echo "<span style='display: block; width: 90px; float: left;'>Code: </span>" . "<span style='float: left;'>" . $color['Color']['code'] . "</span>";
        ?>
    </fieldset>

    <fieldset id="cabinet-matarials" class="color-section">
        <legend><?php echo __('Cabinet Matarials'); ?></legend>
        <?php
        foreach( $color['ColorSection'] as $c_section ) {
            if( $c_section['type'] == 'cabinate_material' ) {
                $c_s_id_c = isset($c_section['id']) ? $c_section['id'] : '';

                echo "<span style='display: block; width: 90px; float: left;'>Cost: </span>" . "<span style='float: left;'>" . $c_section['cost'] . "</span></br></br>";
                echo "<span style='display: block; width: 90px; float: left;'>Markup: </span>" . "<span style='float: left;'>" . $c_section['markup'] . "</span></br></br>";
                echo "<span style='display: block; width: 90px; float: left;'>Price: </span>" . "<span style='float: left;'>" . $c_section['price'] . "</span></br></br>";
                $edge_cab = !isset($c_section['edgetape_id']) ? '' : $this->InventoryLookup->Item_name_for_sub_base($c_section['edgetape_id']);
                echo "<span style='display: block; width: 90px; float: left;'>EdgeTape: </span>" . "<span style='float: left;'>" . $edge_cab . "</span>";
                echo "<div style='clear: both; margin-bottom: 20px;'></div>";
            }
        }
        ?>
        <fieldset>
            <fieldset class="color-section-material">
                <?php
                $materials_html_list = '';
                foreach( $color['ColorMaterial'] as $c_material ) {
                    if( isset($c_s_id_c) && $c_material['color_section_id'] == $c_s_id_c ) {
                        $materials_html_list .= '<li>' . $this->InventoryLookup->findMaterialName($c_material['material_id']) . '</li>';
                    }
                }
                if( !empty($materials_html_list) ) {
                    echo "<div><strong>Material Name</strong></div><ol>{$materials_html_list}</ol>";
                }
                ?>
            </fieldset>
        </fieldset>
    </fieldset>

    <fieldset id="door-matarials" class="color-section">
        <legend><?php echo __('Door Matarials'); ?></legend>
        <?php
        foreach( $color['ColorSection'] as $c_section ) {
            if( $c_section['type'] == 'door_material' ) {
                $c_s_id_d = isset($c_section['id']) ? $c_section['id'] : '';

                echo "<span style='display: block; width: 90px; float: left;'>Cost: </span>" . "<span style='float: left;'>" . $c_section['cost'] . "</span></br></br>";
                echo "<span style='display: block; width: 90px; float: left;'>Markup: </span>" . "<span style='float: left;'>" . $c_section['markup'] . "</span></br></br>";
                echo "<span style='display: block; width: 90px; float: left;'>Price: </span>" . "<span style='float: left;'>" . $c_section['price'] . "</span></br></br>";
                echo "<span style='display: block; width: 90px; float: left;'>EdgeTape: </span>" . "<span style='float: left;'>" . empty($c_section['edgetape_id']) ? '&nbsp;' : $this->InventoryLookup->Item_name_for_sub_base($c_section['edgetape_id']) . "</span></br></br>";
                $edge_door = $this->InventoryLookup->Item_name_for_sub_base($c_section['edgetape_id']);
                echo "<span style='display: block; width: 90px; float: left;'>EdgeTape: </span>" . "<span style='float: left;'>" . $edge_door . "</span>";
                echo "<div style='clear: both; margin-bottom: 20px;'></div>";
            }
        }
        ?>
        <fieldset>
            <fieldset class="color-section-material">
                <?php
                $materials_html_list = '';
                foreach( $color['ColorMaterial'] as $c_material ) {
                    if( isset($c_s_id_d) && $c_material['color_section_id'] == $c_s_id_d ) {
                        $materials_html_list .= '<li>' . $this->InventoryLookup->findMaterialName($c_material['material_id']) . '</li>';
                    }
                }
                if( !empty($materials_html_list) ) {
                    echo "<div><strong>Material Name</strong></div><ol>{$materials_html_list}</ol>";
                }
                ?>
            </fieldset>
        </fieldset>
    </fieldset>

    <div class="clear"></div>
</div>