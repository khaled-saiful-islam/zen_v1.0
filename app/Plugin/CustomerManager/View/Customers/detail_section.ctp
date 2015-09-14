<?php
$sub_form = $this->InventoryLookup->customer_form_elements($section);
echo $this->element('Detail/Customer/'.$sub_form['detail']);
?>