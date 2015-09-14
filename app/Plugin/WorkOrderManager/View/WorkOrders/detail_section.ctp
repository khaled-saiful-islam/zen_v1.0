<?php 
    $sub_form = $this->InventoryLookup->work_order_form_elements($section);
    echo $this->element('Detail/WorkOrder/'.$sub_form['detail'], array('edit' => true,'section'=>$section));
?>