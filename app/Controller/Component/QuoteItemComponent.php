<?php

App::uses('Component', 'Controller');

class QuoteItemComponent extends Component {

  public function ListQuoteAllItem($cabinet_order_id = null, $quote_id = null, $type = "") {
    App::uses("CabinetOrderItem", "QuoteManager.Model");
    $cabinet_order = new CabinetOrderItem();

    $item = array();
    if ($cabinet_order_id) {
      $item = $cabinet_order->find("all", array("conditions" => array("CabinetOrderItem.cabinet_order_id" => $cabinet_order_id, 'CabinetOrderItem.type' => $type)));
    } else {
      $item = $cabinet_order->find("all", array("conditions" => array("CabinetOrderItem.quote_id" => $quote_id, 'CabinetOrderItem.type' => $type)));
    }
    return $item;
  }

  public function AdjustPOItem($data = array()) {
    if ($data && is_array($data)) {
      foreach ($data['quantity_list'] as $key => $val) {
        //debug(strripos($key, 'cabinet'));
        if (strripos($key, 'cabinet')) {
          $id = explode('|', $key);
          //debug($id);
          App::uses("Cabinet", "Inventory.Model");
          $list_Item = new Cabinet();
          $query = "SELECT i.id as id, i.number as number, i.item_title as title, i.price as price, ci.item_quantity as quantity FROM  cabinets_items as ci INNER JOIN items as i ON i.id=ci.item_id WHERE ci.cabinet_id=$id[0]";

          $list_data = $list_Item->query($query);
          //debug($list_data);
          foreach ($list_data as $row) {
            $tmp_key = $row['i']['id'] . '|item';

            if (array_key_exists($tmp_key, $data['quantity_list'])) {
              $data['quantity_list'][$tmp_key] = $data['quantity_list'][$tmp_key] + ($row['ci']['quantity'] * $val);
            } else {
              $data['quantity_list'] = array_merge($data['quantity_list'], array($tmp_key => ($row['ci']['quantity'] * $val)));
              $data['name_list'] = array_merge($data['name_list'], array($tmp_key => $row['ci']['number']));
              $data['price_list'] = array_merge($data['price_list'], array($tmp_key => $row['ci']['price']));
              $data['title_list'] = array_merge($data['title_list'], array($tmp_key => $row['ci']['title']));
            }
            unset($data['quantity_list'][$key]);
            unset($data['name_list'][$key]);
            unset($data['price_list'][$key]);
            unset($data['title_list'][$key]);
          }
        }
      }
    }
    return $data;
  }

  public function SupplierAndItemInfo() {
    App::uses("Supplier", "Inventory.Model");
    App::import("Model", "Inventory.Item");
    $supplierModel = new Supplier();
    $itemModel = new Item();
    $supplierModel->recursive = 0;
    $suppliers = $supplierModel->find("all");
    $tmp_suplliers = array();
    foreach ($suppliers as $key => $supplier) {
      $tmp_suplliers[$supplier['Supplier']['id']]['name'] = $supplier['Supplier']['name'];
      $tmp_suplliers[$supplier['Supplier']['id']]['email'] = $supplier['Supplier']['email'];
      $tmp_suplliers[$supplier['Supplier']['id']]['gst'] = $supplier['Supplier']['gst_rate'];
      $tmp_suplliers[$supplier['Supplier']['id']]['pst'] = $supplier['Supplier']['pst_rate'];
      $tmp_suplliers[$supplier['Supplier']['id']]['item'] = $itemModel->find("list", array("fields" => array("id_plus_item"), 'conditions' => array('supplier_id' => $supplier['Supplier']['id'])));
      $tmp_suplliers[$supplier['Supplier']['id']]['address'] = $this->address_format($supplier['Supplier']['address'], $supplier['Supplier']['city'], $supplier['Supplier']['province'], $supplier['Supplier']['country'], $supplier['Supplier']['postal_code']);
      $tmp_suplliers[$supplier['Supplier']['id']]['phone'] = $this->phone_format($supplier['Supplier']['phone'], $supplier['Supplier']['phone_ext'], $supplier['Supplier']['cell'], $supplier['Supplier']['fax_number']);
    }

    return $tmp_suplliers;
  }

  public function ListQuoteItems($quote_id) {
//    return; // fix that function
    App::uses("Quote", "QuoteManager.Model");
    $list_quote = new Quote();
    $query = "SELECT t.code as code,SUM(t.quantity) as quantity FROM(SELECT coi.code as code ,coi.quantity as quantity FROM  cabinet_order_items as coi WHERE coi.cabinet_order_id in (
              SELECT co.id FROM cabinet_orders AS co WHERE co.quote_id =$quote_id) || coi.quote_id=$quote_id ) AS t GROUP BY t.code";

    $list_data = $list_quote->query($query);
    $list = array();
    $title_list = array();
    $name_list = array();
    $price_list = array();
    $all_items = $this->ListAllTypesOfItems();
    $index = 0;
//    debug($list_data);
    foreach ($list_data as $row) {
      $list[$row['t']['code']] = $row[0]['quantity'];
      @$name_list[$row['t']['code']] = $all_items['main_list'][$row['t']['code']];
      @$price_list[$row['t']['code']] = $all_items['price_list'][$row['t']['code']];
      @$title_list[$row['t']['code']] = $all_items['title_list'][$row['t']['code']];

      $index++;
    }
    $query = "SELECT t.code as code,SUM(t.quantity) as quantity FROM(SELECT coi.code as code ,coi.quantity as quantity FROM  granite_order_items as coi WHERE coi.granite_order_id= (
              SELECT co.id FROM granite_orders AS co WHERE co.quote_id =$quote_id) || coi.quote_id=$quote_id ) AS t GROUP BY t.code";
    $list_data = $list_quote->query($query);
//    debug($list_data);
    foreach ($list_data as $row) {
      if (array_key_exists($row['t']['code'], $list)) {
        $list[$row['t']['code']] = $list[$row['t']['code']] + $row[0]['quantity'];
      } else {
        $list[$row['t']['code']] = $row[0]['quantity'];
        $name_list[$row['t']['code']] = $all_items['main_list'][$row['t']['code']];
        $price_list[$row['t']['code']] = $all_items['price_list'][$row['t']['code']];
        $title_list[$row['t']['code']] = $all_items['title_list'][$row['t']['code']];
      }
    }

    return array('quantity_list' => $list, 'name_list' => $name_list, 'price_list' => $price_list, 'title_list' => $title_list);
  }

  public function ListAllTypesOfItems() {
    App::uses("Item", "Inventory.Model");
    $item = new Item();

    $query = "SELECT cabinets.id AS id, cabinets.name AS code, 'cabinet' AS item_type, cabinets.manual_unit_price AS price, cabinets.name AS title FROM cabinets
              UNION
                SELECT items.id AS id, items.number AS code, 'item' AS item_type, items.price AS price, items.item_title AS title FROM items
              UNION
                SELECT wd.id AS id, wd.wall_door_code AS code, 'wall_door' AS item_type, wd.wall_door_price_each AS price, wd.door_style AS title FROM doors wd WHERE wd.wall_door_code IS NOT NULL AND wd.wall_door_code != ''
              UNION
                SELECT d.id AS id, d.drawer_code AS code, 'drawer' AS item_type, d.drawer_price_each AS price, d.door_style AS title FROM doors d WHERE d.drawer_code IS NOT NULL AND d.drawer_code != ''
              UNION
                SELECT door.id AS id, door.door_code AS code, 'door' AS item_type, door.door_price_each AS price, door.door_style AS title FROM doors door WHERE door.door_code IS NOT NULL AND door.door_code != ''";
    $result = $item->query($query);
    $list = array();
    $title_list = array();
    $price_list = array();

    foreach ($result as $row) {
      $list["{$row[0]['id']}|{$row[0]['item_type']}"] = $row[0]['code'];
      $price_list["{$row[0]['id']}|{$row[0]['item_type']}"] = $row[0]['price'];
      $title_list["{$row[0]['id']}|{$row[0]['item_type']}"] = $row[0]['title'];
    }
    return array('main_list' => $list, 'price_list' => $price_list, 'title_list' => $title_list);
  }

  public function address_format($address, $city, $provience, $country, $postal_code) {
    $content = "";
    if ($address != "")
      $content.=$address . "<br/>";
    if ($city != "" || $provience != "") {
      $content.= "<div class='marT5'>";
      $content.= $city;
      if ($city != "" && $provience != "")
        $content.= ", ";
      $content.= $provience;
      $content.= "</div>";
    }
    if ($country != "" || $postal_code != "") {
      $content.= "<div class='marT5'>";
      $content.= $country;
      if ($country != "" && $postal_code != "")
        $content.= " - ";
      $content.= $postal_code;
      $content.= "</div>";
    }
    return $content;
  }

  public function phone_format($phone, $phone_ext, $cell, $fax) {
    $content = "<div class='marT5'>";
    if ($phone != "") {
      $content.= "<label class='no-width'>";
      $content.= "Phone: " . $phone . "&nbsp;";
      if ($phone_ext != "")
        $content.= "Ext: " . $phone_ext;
      $content.= "</label><br/>";
    }
    if ($cell != "") {
      $content.= "<label class='no-width'>";
      $content.= "Cell: " . $cell;
      $content.= "</label><br/>";
    }
    if ($fax != "") {
      $content.= "<label class='no-width'>";
      $content.= "Fax: " . $fax;
      $content.= "</label><br/>";
    }
    return $content . "</div>";
  }

  function RestrictedSupplierOfPO($work_order_id) {
    App::uses("PurchaseOrder", "PurchaseOrderManager.Model");
    $purchaseOrder = new PurchaseOrder();
    return $purchaseOrder->find("list", array("fields" => array("supplier_id"), 'conditions' => array('work_order_id' => $work_order_id)));
  }

  function get_quote_number($quote_id) {
    if ($quote_id) {
      App::uses('Quote', 'QuoteManager.Model');
      $quoteModel = new Quote();
      $quoteModel->recursive = -1;
      $quote = $quoteModel->find('first', array('fields' => array('Quote.id,Quote.quote_number'), 'conditions' => array('Quote.id' => $quote_id)));
      if ($quote) {
        return $quote['Quote']['quote_number'];
      } else {
        return null;
      }
    } else {
      return null;
    }
  }

  function auto_generate_number($type) {
    $value = "";
    if ($type == "Quote") {
      App::uses('Quote', 'QuoteManager.Model');
      $quoteModel = new Quote();
      $quotes = $quoteModel->find('all', array('fields' => array('Quote.id,Quote.quote_number')));
      if ($quotes) {
        $quote_number = (int) $quotes[count($quotes) - 1]['Quote']['quote_number'];
				$quote_number = explode("-", $quote_number);
        $length = (strlen($quote_number[0] + 1) == strlen($quote_number[0])) ? strlen($quote_number[0]) : strlen($quote_number[0] + 1);
        for ($i = $length; $i < 6; $i++) {
          $value .='0';
        }
        $value.=$quote_number[0] + 1;
      } else {
        $value = "000001";
      }
    } elseif ($type == "Work Order") {
      App::uses('WorkOrder', 'WorkOrderManager.Model');
      $woModel = new WorkOrder();
      $wos = $woModel->find('all', array('fields' => array('WorkOrder.id,work_order_number')));
      if ($wos) {
        $wo_number = (int) $wos[count($wos) - 1]['WorkOrder']['work_order_number'];
        $length = (strlen($wo_number + 1) == strlen($wo_number)) ? strlen($wo_number) : strlen($wo_number + 1);
        for ($i = $length; $i < 6; $i++) {
          $value .='0';
        }
        $value.=$wo_number + 1;
      } else {
        $value = "000001";
      }
    } elseif ($type == "Purchase Order") {
      App::uses('PurchaseOrder', 'PurchaseOrderManager.Model');
      $poModel = new PurchaseOrder();
      $pos = $poModel->find('all', array('fields' => array('PurchaseOrder.id,purchase_order_num')));
      if ($pos) {
        $po_number = (int) $pos[count($pos) - 1]['PurchaseOrder']['purchase_order_num'];
        $length = (strlen($po_number + 1) == strlen($po_number)) ? strlen($po_number) : strlen($po_number + 1);
        for ($i = $length; $i < 6; $i++) {
          $value .='0';
        }
        $value.=$po_number + 1;
      } else {
        $value = "000001";
      }
    } elseif ($type == "Invoice") {
      App::uses('Invoice', 'Invoice.Model');
      $invoiceModel = new Invoice();
      $invoice = $invoiceModel->find('all', array('fields' => array('Invoice.id,invoice_no')));
      if ($invoice) {
        $invoice_number = (int) $invoice[count($invoice) - 1]['Invoice']['invoice_no'];
        $length = (strlen($invoice_number + 1) == strlen($invoice_number)) ? strlen($invoice_number) : strlen($invoice_number + 1);
        for ($i = $length; $i < 6; $i++) {
          $value .='0';
        }
        $value.=$invoice_number + 1;
      } else {
        $value = "000001";
      }
    }

    return $value;
  }

  function listOfPoItem($wo_id = null, $po_id = null) {
    App::uses('PurchaseOrderItem', 'PurchaseOrderManager.Model');
    $purchaseOrderModel = new PurchaseOrderItem();
    $purchaseOrders = array();
    if ($wo_id)
      $purchaseOrders = $purchaseOrderModel->find('all', array('fields' => array('PurchaseOrder.id,PurchaseOrder.purchase_order_num,PurchaseOrderItem.id', 'PurchaseOrderItem.code'), 'conditions' => array('PurchaseOrder.work_order_id' => $wo_id)));
    elseif ($po_id)
      $purchaseOrders = $purchaseOrderModel->find('all', array('fields' => array('PurchaseOrder.id,PurchaseOrder.purchase_order_num,PurchaseOrderItem.id', 'PurchaseOrderItem.code', 'PurchaseOrderItem.quantity'), 'conditions' => array('PurchaseOrder.id' => $po_id)));
//    debug($purchaseOrders);

    $allItems = $this->ListAllTypesOfItems();
    $list = array();
    $title_list = array();
    $price_list = array();
    $qty_list = array();
    $po_list = array();
    $po_id_list = array();
    foreach ($purchaseOrders as $value) {
      if (array_key_exists($value['PurchaseOrderItem']['code'], $allItems['main_list'])) {
        $list[$value['PurchaseOrderItem']['code']] = $allItems['main_list'][$value['PurchaseOrderItem']['code']];
        $title_list[$value['PurchaseOrderItem']['code']] = $allItems['title_list'][$value['PurchaseOrderItem']['code']];
        $price_list[$value['PurchaseOrderItem']['code']] = $allItems['price_list'][$value['PurchaseOrderItem']['code']];
        $po_list[$value['PurchaseOrderItem']['code']] = $value['PurchaseOrder']['purchase_order_num'];
        $po_id_list[$value['PurchaseOrderItem']['code']] = $value['PurchaseOrder']['id'];

        if ($po_id)
          $qty_list[$value['PurchaseOrderItem']['code']] = $value['PurchaseOrderItem']['quantity'];
      }
    }
    return array('main_list' => $list, 'title_list' => $title_list, 'price_list' => $price_list, 'po_list' => $po_list, 'po_id_list' => $po_id_list, 'qty_list' => $qty_list);
  }

  public function quotePrice($data = array()) {

    $itemList = $this->ListQuoteItems($data['Quote']['id']);
    $total_cost = 0.00;
    foreach ($itemList['quantity_list'] as $key => $list) {
      $total_cost += $itemList['quantity_list'][$key] * $itemList['price_list'][$key];
    }
    foreach ($data['QuoteInstallerPaysheet'] as $key => $list) {
      $total_cost += $list['quantity'] * $list['price_each'];
    }
    //debug($data['CabinetOrder']);
    if ($data['CabinetOrder'])
      $total_cost += ($data['CabinetOrder'][0]['delivery_cost'] + $data['CabinetOrder'][0]['extras_glass'] + $data['CabinetOrder'][0]['counter_top'] + $data['CabinetOrder'][0]['installation'] - $data['CabinetOrder'][0]['discount']);
//    debug($itemList);
//    debug($total_cost);
//    exit;
    return $total_cost;
  }

}

