<?php

echo $this->element('Forms/InventoryLookups/inventory-lookups-form', array('legend' => h($this->InventoryLookup->to_camel_case($type)).' Add Setting', 'edit' => false,'type'=>$type));
?>