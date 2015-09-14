<?php
$sub_form = $this->InventoryLookup->user_form_elements($section);;
echo $this->element('Detail/User/'.$sub_form['detail']);
?>