<?php 
    $sub_form = $this->InventoryLookup->door_form_elements($section);
    echo $this->element('Detail/Door/'.$sub_form['detail'], array('edit' => true));
?>