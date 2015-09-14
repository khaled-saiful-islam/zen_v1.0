<?php

$sub_form = $this->InventoryLookup->form_elements('Quote', $section);
echo $this->element('Detail/Quote/' . $sub_form['detail'], array('edit' => true));
?>