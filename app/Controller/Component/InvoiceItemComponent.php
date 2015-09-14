<?php

App::uses('Component', 'Controller');

class InvoiceItemComponent extends Component {

  /**
   *
   * @param type $data
   *
   * $data = array(
   *                'header' => 'Header Text',
   *                'invoice_no' => 'Invoice number auto generate',
   *                'invoice_of' => 'Invoice type. e.g. quote, po',
   *                'ref_id' => 'id of the invoice_of',
   *                'ref_number' => 'number the invoice_of',
   *                'gst' => 'GST',
   *                'items' => array(
   *                                  [] => array(
   *                                               'id' => 'db row id of the item',
   *                                               'number' => 'Unique Number of the item',
   *                                               'desc' => 'Description',
   *                                               'qty' => 'Quantity',
   *                                               'price' => 'Each Price',
   *                                               'total' => 'Total',  // NULL in case of autocalculate
   *                                             ),
   *                                ),
   *                'customer' => array(  // null to empty
   *                                     'id' => 'Customer ID',
   *                                     'name' => 'Name',
   *                                     'address' => 'Address',
   *                                     'city' => 'City',
   *                                     'postal-code' => 'Postal Code',
   *                                     'province' => 'Province',
   *                                     'country' => 'Country',
   *                                     'email' => 'Email',
   *                                     'phone' => 'Phone',
   *                                   ),
   *                'supplier' => array(  // null to empty
   *                                     'id' => 'Customer ID',
   *                                     'name' => 'Name',
   *                                     'address' => 'Address',
   *                                     'city' => 'City',
   *                                     'postal-code' => 'Postal Code',
   *                                     'province' => 'Province',
   *                                     'country' => 'Country',
   *                                     'email' => 'Email',
   *                                     'phone' => 'Phone',
   *                                   ),
   *                'total' => 'GST',
   *                'sales-person' => 'Sales Person',
   *                'ship-date' => 'Ship Date',
   *              );
   */
  function createInvoice($data) {
    App::import('Model', 'InvoiceManager.Invoice');
    $invoice = new Invoice();
    $data_json = json_encode($data);

    $invoice_data['Invoice'] = array(
        'invoice_no' => $data['invoice_no'],
        'invoice_of' => $data['invoice_of'],
        'ref_id' => $data['ref_id'],
        'data_set' => $data_json,
        'total' => $data['total'],
        'invoice_status_id' => $data['invoice_status_id'],
    );
    
    $invoice_data['InvoiceLog'] = array(
        'invoice_status_id'=>$data['invoice_status_id']
    );
    
    $invoice->create();
    $flag = $invoice->save($invoice_data);    
    return $flag;
  }

  function showInvoice($invoice_id) {
    
  }

  function formatInvoiceData($invoice_no = null, $invoice_ref = null, $ref_id = null, $infoData = array(), $itemData = array()) {
    $data = array();
    $data['header'] = "";
    $data['invoice_no'] = $invoice_no;
    $data['invoice_of'] = $invoice_ref;
    $data['ref_id'] = $ref_id;
    $data['invoice_status_id'] = 1;
    
    if ($invoice_ref == "Purchase Order") {
      $data['gst'] = $infoData['Supplier']['gst_rate'];
      $data['pst'] = $infoData['Supplier']['pst_rate'];
      $data['ref_number'] = $infoData['PurchaseOrder']['purchase_order_num'];
      
      $data['customer'] = array();
      $data['supplier'] = array(
          'id' => $infoData['Supplier']['id'],
          'name' => $infoData['Supplier']['name'],
          'address' => $infoData['Supplier']['address'],
          'city' => $infoData['Supplier']['city'],
          'postal_code' => $infoData['Supplier']['postal_code'],
          'province' => $infoData['Supplier']['province'],
          'country' => $infoData['Supplier']['country'],
          'email' => $infoData['Supplier']['email'],
          'phone' => $infoData['Supplier']['phone'],
          'fax' => $infoData['Supplier']['fax_number'],
      );
      
      if($infoData['PurchaseOrder']['received']==1)
        $data['invoice_status_id'] = 2;
      
    } elseif ($invoice_ref == "Quote") {
      $data['gst'] = GST;
      $data['pst'] = null;
      $data['ref_number'] = $infoData['Quote']['quote_number'];
      $data['supplier'] = array();
//      App::import('Model', 'CustomerManager.Customer');
//      $customer = new Customer();
//      $customerData = $customer->find('first', array('conditions' => array('Customer.id' => $infoData['Quote']['customer_id'])));

      $data['customer'] = array(
          'id' => $infoData['Quote']['customer_id'],
          'name' => $infoData['Customer']['first_name'] . ' ' . $infoData['Customer']['last_name'],
          'address' => $infoData['Customer']['address'],
          'city' => $infoData['Customer']['city'],
          'postal_code' => $infoData['Customer']['postal_code'],
          'province' => $infoData['Customer']['province'],
          'country' => $infoData['Customer']['country'],
          'email' => $infoData['Customer']['email'],
          'phone' => $infoData['Customer']['phone'],
          'fax' => $infoData['Customer']['fax_number'],
      );
    }

    $data['sales-person'] = $infoData['Quote']['sales_person'];
    $data['ship-date'] = $infoData['Quote']['est_shipping'];

    

    $data['items'] = array();
    $total = 0.00;
    foreach ($itemData['main_list'] as $key => $value) {
      $data['items'][] = array(
          'id' => $key,
          'number' => $itemData['main_list'][$key],
          'desc' => $itemData['title_list'][$key],
          'qty' => $itemData['qty_list'][$key],
          'price' => $itemData['price_list'][$key],
          'total' => number_format($itemData['qty_list'][$key] * $itemData['price_list'][$key], '2', '.', ''), // NULL in case of autocalculate
      );
      $total += number_format($itemData['qty_list'][$key] * $itemData['price_list'][$key], '2', '.', '');
    }
    $data['total'] = $total;    
    
//    debug($infoData);
//    debug($itemData);
//    debug($data);
//    exit;
    return $data;
  }

}

