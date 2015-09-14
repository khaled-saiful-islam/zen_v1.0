<?php 
    $sub_form = $this->InventoryLookup->invoice_form_elements($section);
    echo $this->element('Detail/Invoice/'.$sub_form['detail'], array('edit' => true,'section'=>$section));
?>