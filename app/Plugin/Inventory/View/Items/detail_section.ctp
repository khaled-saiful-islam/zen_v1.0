<?php
    $sub_form = $this->InventoryLookup->item_form_elements($section);
    echo $this->element('Detail/Item/'.$sub_form['detail'], array('edit' => $edit));
?>