<?php
$sub_form = $this->InventoryLookup->service_entry_form_elements($section);
echo $this->element('Detail/Service/'.$sub_form['detail'],array('edit'=>true));
?>
