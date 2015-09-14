<?php 
    $sub_form = $this->InventoryLookup->installer_form_elements($section);
    echo $this->element('Detail/Installer/'.$sub_form['detail'], array('edit' => true));
?>