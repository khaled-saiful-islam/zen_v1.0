<?php 
    $sub_form = $this->InventoryLookup->installer_schedule_form_elements($section);
    echo $this->element('Detail/InstallerSchedule/'.$sub_form['detail'], array('edit' => true));
?>