<?php
    $sub_detail = $this->InventoryLookup->cabinet_detail_elements($section);
    echo $this->element('Detail/Cabinet/'.$sub_detail, array('edit' => $edit));
?>