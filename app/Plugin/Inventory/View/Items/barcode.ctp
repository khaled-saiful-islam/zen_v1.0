<?php
App::import('Vendor', 'BarcodeGenerator', array('file' => 'barcode_generator/BarcodeGenerator.php'));
$barcode_generator = new BarcodeGenerator();
$barcode_generator->create_barcode($item['Item']['number']);
exit;