<?php

App::uses('AppHelper', 'View/Helper');

class InventoryLookupHelper extends AppHelper {

    function Status() {
        App::uses("WorkStatus", "WorkOrderManager.Model");
        $workStatus = new WorkStatus();
        return $workStatus->find("list", array( "fields" => array( "id", "status" ) ));
    }

    /**
     * get the list of suppliers
     * @return records
     */
    function Supplier() {
        App::uses("Supplier", "Inventory.Model");
        $supplier = new Supplier();
        return $supplier->find("list", array( "fields" => array( "id", "name" ) ));
    }

    /**
     * get the list of suppliers
     * @return records
     */
    function SupplierAndItemInfo() {
        App::uses("Supplier", "Inventory.Model");
        App::uses("Item", "Model");
        $supplierModel = new Supplier();
        $itemModel = new Item();
        $supplierModel->recursive = 0;
        $suppliers = $supplierModel->find("all");
        $tmp_suplliers = array( );
        foreach( $suppliers as $key => $supplier ) {
            $tmp_suplliers[$supplier['Supplier']['id']]['name'] = $supplier['Supplier']['name'];
            $tmp_suplliers[$supplier['Supplier']['id']]['email'] = $supplier['Supplier']['email'];
            $tmp_suplliers[$supplier['Supplier']['id']]['gst'] = $supplier['Supplier']['gst_rate'];
            $tmp_suplliers[$supplier['Supplier']['id']]['pst'] = $supplier['Supplier']['pst_rate'];
            $tmp_suplliers[$supplier['Supplier']['id']]['item'] = $itemModel->find("list", array( "fields" => array( "id_plus_item" ), 'conditions' => array( 'supplier_id' => $supplier['Supplier']['id'] ) ));
            $tmp_suplliers[$supplier['Supplier']['id']]['address'] = $this->address_format($supplier['Supplier']['address'], $supplier['Supplier']['city'], $supplier['Supplier']['province'], $supplier['Supplier']['country'], $supplier['Supplier']['postal_code']);
            $tmp_suplliers[$supplier['Supplier']['id']]['phone'] = $this->phone_format($supplier['Supplier']['phone'], $supplier['Supplier']['phone_ext'], $supplier['Supplier']['cell'], $supplier['Supplier']['fax_number']);
        }

        return $tmp_suplliers;
    }

    function SupplierForView($id = null) {
        App::uses("Supplier", "Inventory.Model");
        $supplier = new Supplier();
        return $supplier->find("first", array( "fields" => array( "id", "name" ),
                    "conditions" =>
                    array(
                        "Supplier.id" => $id ) ));
    }

    function DoorDataList($data_column, $use_id = FALSE) {
        $data_id = $data_column; // by default use data as key
        if( $use_id ) {
            $data_id = 'id';
        }

        App::uses("Door", "Inventory.Model");
        $door = new Door();
        return $door->find("list", array( "fields" => array( $data_id, $data_column ) ));
    }

    function Quote() {
        App::uses("Quote", "QuoteManager.Model");
        $quote = new Quote();
        return $quote->find("list", array( "fields" => array( "id", "quote_number" ), 'conditions' => array( 'Quote.vid' => null ) ));
    }

    function WorkOrderInPo() {
        App::uses('WorkOrder', 'WorkOrderManager.Model');
        $workOrder = new WorkOrder();
        $workOrders = $workOrder->find("all", array( "conditions" => array( "WorkOrder.status !=" => 'Approve' ) ));

        $tmp_workOrders = array( );
        foreach( $workOrders as $workOrder ) {
            $tmp_workOrders[$workOrder['WorkOrder']['id']] = $workOrder['Quote']['quote_number'];
        }
        return $tmp_workOrders;
    }

    function getWorkOrder() {
        App::uses('WorkOrder', 'WorkOrderManager.Model');
        $workOrder = new WorkOrder();
        $workOrders = $workOrder->find("list", array( "fields" => array( "id", "work_order_number" ) ));

        return $workOrders;
    }

    function getUserForPOReceive() {
        App::uses('User', 'UserManager.Model');
        $user_model = new User();
        $workOrders = $user_model->find("all", array( "fields" => array( "id", "first_name", "last_name" ) ));
        foreach( $workOrders as $wo ) {
            $workorder[$wo['User']['id']] = $wo['User']['first_name'] . " " . $wo['User']['last_name'];
        }
        return $workorder;
    }

    function QuoteStatus($id = null) {
        App::import("Model", "QuoteManager.QuoteStatus");
        $quotestatus = new QuoteStatus();
        $status = $quotestatus->find("first", array( "conditions" => array( "QuoteStatus.quote_id" => $id ), 'order' => array( 'QuoteStatus.id' => 'DESC' ) ));
        return $status['QuoteStatus']['status'];
    }

    function getPaymentStatus($id = null) {
        App::import("Model", "UploadPayment");
        $upload = new UploadPayment();
        $status = $upload->find("first", array( "conditions" => array( "UploadPayment.ref_id" => $id ) ));
        if( empty($status) )
            return 1;
        else {
            return 2;
        }
    }

    function getWOStatus($id = null) {
        App::import("Model", "WorkOrderManager.WorkOrder");
        $wo = new WorkOrder();
        $wo_data = $wo->find("first", array( "conditions" => array( "WorkOrder.id" => $id ) ));
        if( $wo_data['WorkOrder']['status'] == 'Approve' )
            return 1;
        else {
            return 2;
        }
    }

    function getScheduleColor($type = null) {
        App::import("Model", "ScheduleManager.ScheduleColor");
        $color = new ScheduleColor();
        $color_data = $color->find("first", array( "conditions" => array( "ScheduleColor.type" => $type ) ));
        return $color_data['ScheduleColor']['bgcolor'];
    }

    function getPaymentSerialNo($id = null) {
        App::import("Model", "UploadPayment");
        $upload = new UploadPayment();
        $status = $upload->find("first", array( "conditions" => array( "UploadPayment.ref_id" => $id ) ));
        if( empty($status) )
            $serial_no = 00001;
        else {
            $status = $upload->find("first", array( "conditions" => array( "UploadPayment.ref_id" => $id ), 'order' => array( 'UploadPayment.serial_no' => 'DESC' ) ));
            $serial_no = $status['UploadPayment']['serial_no'] + 1;
        }
        return $serial_no;
    }

    function getTotalAmount($id = null) {
        App::import("Model", "QuoteManager.Quote");
        $q_model = new Quote();
        $quote = $q_model->read(null, $id);

        $total_quote_price = 0;
        $total_quote_price_cabinet = 0;
        $total_quote_price_installation = 0;
        $total_quote_price_discount = 0;
        $cabinets = array( );

        if( $quote['CabinetOrder'] && is_array($quote['CabinetOrder']) ) {
            App::import("Model", "Inventory.Cabinet");
            App::import("Model", "Inventory.Item");
            foreach( $quote['CabinetOrder'] as $cabinet_order ) {

                $cabinet = new Cabinet();
                $item_model = new Item();
                $resource_detail = array( 'Resource' => array( 'name' => '', 'description' => '' ) );
                switch( $cabinet_order['resource_type'] ) {
                    case 'cabinet':
                        $resource_detail = $cabinet->find('first', array( 'conditions' => array( 'id' => $cabinet_order['resource_id'] ) ));
                        $resource_detail['Resource']['name'] = $resource_detail['Cabinet']['name'];
                        $resource_detail['Resource']['description'] = $resource_detail['Cabinet']['description'];
                        $cabinets[] = $resource_detail;
                        break;

                    case 'item':
                        $resource_detail = $item_model->find('first', array( 'conditions' => array( 'Item.id' => $cabinet_order['resource_id'] ) ));
                        $resource_detail['Resource']['name'] = $resource_detail['Cabinet'][0]['name'];
                        $resource_detail['Resource']['description'] = $resource_detail['Cabinet'][0]['description'];
                        $cabinets[] = $resource_detail;
                        break;

                    default:
                        break;
                };
                $sub_total = $cabinet_order['total_cost'];
                $total_quote_price_cabinet += $sub_total;
            }
        }
        if( ($quote['Quote']['installation'] == 'We Installed') && !empty($cabinets) && is_array($cabinets) ) {
            $installation_summery_list = array( );

            foreach( $cabinets as $cabinet ) {
                if( !empty($cabinet['CabinetInstallation']) && is_array($cabinet['CabinetInstallation']) ) {
                    foreach( $cabinet['CabinetInstallation'] as $installation ) {
                        if( isset($installation_summery_list[$installation['name']]['quantity']) ) {
                            $installation_summery_list[$installation['name']]['quantity']++;
                        }
                        else {
                            $installation_summery_list[$installation['name']]['name'] = $installation['name'];
                            $installation_summery_list[$installation['name']]['price_unit'] = $installation['price_unit'];
                            $installation_summery_list[$installation['name']]['price'] = $installation['price'];
                            $installation_summery_list[$installation['name']]['quantity'] = 1;
                        }
                    }
                }
            }
            if( !empty($installation_summery_list) ) {
                foreach( $installation_summery_list as $installation ) {
                    $sub_total = $installation['price'] * $installation['quantity'];
                    $total_quote_price_installation += $sub_total;
                }
            }
        }

        $total_quote_price = $total_quote_price_cabinet + $total_quote_price_installation;

        if( $quote['Quote']['delivery'] == '5 – 10 Weeks Delivery' ) {
            $total_quote_price_discount = $total_quote_price * 0.25; // 25% discount for late delivery
        }

        $total_quote_price -= $total_quote_price_discount;

        return $total_quote_price;
    }

    function WorkOrderStatus($id = null) {
        App::import("Model", "WorkOrderManager.WorkOrderStatus");
        $work_order_model = new WorkOrderStatus();
        $status = $work_order_model->find("first", array( "conditions" => array( "WorkOrderStatus.work_order_id" => $id ), 'order' => array( 'WorkOrderStatus.id' => 'DESC' ) ));
        return $status['WorkOrderStatus']['status'];
    }

    function PurchaseOrder() {
        App::uses("PurchaseOrder", "PurchaseOrderManager.Model");
        $purchaseorder = new PurchaseOrder();
        return $purchaseorder->find("list", array( "fields" => array( "id", "purchase_order_num" ) ));
    }

    function getLocation() {
        App::import("Model", "PurchaseOrderManager.GeneralSetting");
        $GS_model = new GeneralSetting();
        return $GS_model->find("list", array( "conditions" => array( "GeneralSetting.type" => 'location' ), "fields" => array( "id", "name" ) ));
    }

    function QuoteForView($id = null) {
        App::uses("Quote", "QuoteManager.Model");
        $quote = new Quote();
        $quote->recursive = 0;
        return $quote->find("first", array( "fields" => array( "id", "quote_number", 'User.first_name', 'User.last_name' ),
                    "conditions" =>
                    array(
                        "Quote.id" => $id ) ));
    }

    function barCodeCheckNum($num = null) {
        $nums = str_split($num);

        $odd_sum = 0;
        $even_sum = 0;
        for( $i = 0; $i <= 10; $i+=2 ) {
            $odd_sum = $odd_sum + $nums[$i];
        }
        for( $i = 1; $i < 10; $i+=2 ) {
            $even_sum = $even_sum + $nums[$i];
        }
        $multibythree = $odd_sum * 3;
        $addEvenodd = $multibythree + $even_sum;

        $reminder = ($addEvenodd % 10);
        $check_digit = 10 - $reminder;

        $check_digit = ($check_digit == 10) ? 0 : $check_digit;

        return $check_digit;
    }

    function ReportsList() {
        App::uses("QuoteReportsSetting", "QuoteManager.Model");
        $quote_reports_setting = new QuoteReportsSetting();
        $quote_reports_setting->recursive = 0;
        return $quote_reports_setting->find("list", array( 'order' => array( 'QuoteReportsSetting.step ASC' ), "fields" => array( "id", "report_name" ) ));
    }

    function PDFList() {
        App::uses("QuotePdfSetting", "QuoteManager.Model");
        $quote_pdf_setting = new QuotePdfSetting();
        $quote_pdf_setting->recursive = 0;
        return $quote_pdf_setting->find("list", array( 'order' => array( 'QuotePdfSetting.step ASC' ), "fields" => array( "id", "pdf_name" ) ));
    }

    function ReportsFunctionList() {
        App::uses("QuoteReportsSetting", "QuoteManager.Model");
        $quote_reports_setting = new QuoteReportsSetting();
        $quote_reports_setting->recursive = 0;
        return $quote_reports_setting->find("list", array( 'order' => array( 'QuoteReportsSetting.step ASC' ), "fields" => array( "id", "report_function" ) ));
    }

    function PDFFunctionList() {
        App::uses("QuotePdfSetting", "QuoteManager.Model");
        $quote_pdf_setting = new QuotePdfSetting();
        $quote_pdf_setting->recursive = 0;
        return $quote_pdf_setting->find("list", array( 'order' => array( 'QuotePdfSetting.step ASC' ), "fields" => array( "id", "pdf_function" ) ));
    }

    function ReportsDepartmentsList($report_function = null) {
        App::uses("QuoteReportsSetting", "QuoteManager.Model");
        $quote_reports_setting = new QuoteReportsSetting();
        $quote_reports_setting->recursive = 0;
        if( is_null($report_function) ) {
            return $quote_reports_setting->find("list", array( "fields" => array( "id", "departments" ) ));
        }
        else {
            $quote_reports_setting_detail = $quote_reports_setting->find("first", array( "fields" => array( "id", "departments" ), 'conditions' => array( 'QuoteReportsSetting.report_function' => $report_function ) ));
            if( $quote_reports_setting_detail ) {
                return unserialize($quote_reports_setting_detail['QuoteReportsSetting']['departments']);
            }
            else {
                return array( );
            }
        }
    }

    function CabinetOrderItem($cabinate_order_id) {
        App::uses("CabinetOrderItem", "QuoteManager.Model");
        $cabinet_order_item = new CabinetOrderItem();
        return $cabinet_order_item->find("all", array( "conditions" => array( "cabinet_order_id" => $cabinate_order_id ) ));
    }

    function GraniteOrderItem($granite_order_id) {
        App::import("Model", "QuoteManager.GraniteOrderItem");
        $granite_order_item = new GraniteOrderItem();
        return $granite_order_item->find("all", array( "conditions" => array( "granite_order_id" => $granite_order_id ) ));
    }

    function PurchaseOrderItem($purchase_order_id) {
        App::uses("PurchaseOrderItem", "PurchaseOrderManager.Model");
        $purchase_order_item = new PurchaseOrderItem();
        return $purchase_order_item->find("all", array( "conditions" => array( "purchase_order_id" => $purchase_order_id ) ));
    }

    function Item($id = null) {
        App::uses("Item", "Inventory.Model");
        $item = new Item();
        $item_list = array( );
        if( $id )
            $item_list = $item->find("list", array( "fields" => array( "id", "item_title" ), 'conditions' => array( 'id' => $id ) ));
        else
            $item_list = $item->find("list", array( "fields" => array( "id", "item_title" ) ));
        return $item_list;
    }

    function DoorCode2ID($code = null, $reverse = false) {
        App::import("Model", "Inventory.Door");
        $door = new Door();
        $door->recursive = 0;

        if( !$reverse ) {
            $door_info = $door->find("first", array( "fields" => array( "id", "code" ), 'conditions' => array( 'Door.code' => $code ) ));
        }
        else {
            $door_info = $door->find("first", array( "fields" => array( "id", "code" ), 'conditions' => array( 'Door.id' => $code ) ));
        }

        if( isset($door_info['Door']['id']) ) {
            if( !$reverse ) {
                return $door_info['Door']['id'];
            }
            else {
                return $door_info['Door']['code'];
            }
        }
        else {
            return null;
        }
    }

    function ItemTitle2ID($item_title = null, $reverse = false) {
        App::import("Model", "Inventory.Door");
        $item = new Item();
        $item->recursive = 0;

        if( !$reverse ) {
            $item_info = $item->find("first", array( "fields" => array( "id", "item_title" ), 'conditions' => array( 'Item.item_title' => $item_title ) ));
        }
        else {
            $item_info = $item->find("first", array( "fields" => array( "id", "item_title" ), 'conditions' => array( 'Item.id' => $item_title ) ));
        }

        if( isset($item_info['Item']['id']) ) {
            if( !$reverse ) {
                return $item_info['Item']['id'];
            }
            else {
                return $item_info['Item']['item_title'];
            }
        }
        else {
            return null;
        }
    }

    function DoorStyle2ID($door_style = null, $reverse = false) {
        App::import("Model", "Inventory.Door");
        $door = new Door();
        $door->recursive = 0;

        if( !$reverse ) {
            $door_info = $door->find("first", array( "fields" => array( "id", "door_style" ), 'conditions' => array( 'Door.door_style' => $door_style ) ));
        }
        else {
            $door_info = $door->find("first", array( "fields" => array( "id", "door_style" ), 'conditions' => array( 'Door.id' => $door_style ) ));
        }

        if( isset($door_info['Door']['id']) ) {
            if( !$reverse ) {
                return $door_info['Door']['id'];
            }
            else {
                return $door_info['Door']['door_style'];
            }
        }
        else {
            return null;
        }
    }

    function Color($id = null) {
        App::uses("Color", "Inventory.Model");
        $color = new Color();
        $color_list = array( );
        if( $id )
            $color_list = $color->find("list", array( "fields" => array( "id", "code" ), 'conditions' => array( 'id' => $id ) ));
        else
        //$color_list = $color->find("all", array("fields" => array("id", "code")));
            $color_list = $color->find("all", array( "fields" => array( "id", "code", "name" ) ));

        foreach( $color_list as $cl ) {
            $c_list[$cl['Color']['id']] = $cl['Color']['code'] . ":" . $cl['Color']['name'];
        }
        return $c_list;
        //return $color_list;
    }

    function ColorCode2ID($code = null, $reverse = false) {
        App::import("Model", "Inventory.Color");
        $color = new Color();
        $color->recursive = 0;

        if( !$reverse ) {
            $color_info = $color->find("first", array( "fields" => array( "id", "code" ), 'conditions' => array( 'Color.code' => $code ) ));
        }
        else {
            $color_info = $color->find("first", array( "fields" => array( "id", "code" ), 'conditions' => array( 'Color.id' => $code ) ));
        }

        if( isset($color_info['Color']['id']) ) {
            if( !$reverse ) {
                return $color_info['Color']['id'];
            }
            else {
                return $color_info['Color']['code'];
            }
        }
        else {
            return null;
        }
    }

    function ColorDetail($id = null) {
        App::uses("Color", "Inventory.Model");
        $color = new Color();
        $color_detail = array( );
        if( $id )
            $color_detail = $color->find("first", array( 'conditions' => array( 'id' => $id ) ));

        return $color_detail;
    }

    function getSalesRepresentatives() {
        App::uses("User", "UserManager.Model");
        $user = new User();
        return $user->find("list", array( "fields" => array( "id", "first_name" ), "conditions" => array( "User.role" => 96 ) ));
    }

    function Cabinet($id = null) {
        App::uses("Cabinet", "Inventory.Model");
        $cabinet = new Cabinet();
        $cabinet_list = array( );
        if( $id )
            $cabinet_list = $cabinet->find("list", array( "fields" => array( "id", "name" ), 'conditions' => array( 'id' => $id ) ));
        else
            $cabinet_list = $cabinet->find("list", array( "fields" => array( "id", "name" ) ));
        return $cabinet_list;
    }

    function CabinetName2ID($name = null, $reverse = false) {
//    App::uses("Cabinet", "Inventory.Model");
        App::import('Model', 'Inventory.Cabinet');
        $cabinet = new Cabinet();
        $cabinet->recursive = 0;

        if( !$reverse ) {
            $cabinet_info = $cabinet->find("first", array( "fields" => array( "id", "name" ), 'conditions' => array( 'Cabinet.name' => $name ) ));
        }
        else {
            $cabinet_info = $cabinet->find("first", array( "fields" => array( "id", "name" ), 'conditions' => array( 'Cabinet.id' => $name ) ));
        }

        if( isset($cabinet_info['Cabinet']['id']) ) {
            if( !$reverse ) {
                return $cabinet_info['Cabinet']['id'];
            }
            else {
                return $cabinet_info['Cabinet']['name'];
            }
        }
        else {
            return null;
        }
    }

    function ItemDetail($id = null) {
        App::uses("Item", "Inventory.Model");
        $item = new Item();
        $item_detail = $item->find("first", array( 'conditions' => array( 'Item.id' => $id ) ));
        return $item_detail;
    }

    function ItemDetailForDrawerBox($id = null) {
        App::uses("Item", "Inventory.Model");
        $item = new Item();
        $item->recursive = -1;
        $item_detail = $item->find("first", array( 'conditions' => array( 'Item.id' => $id ) ));
        return $item_detail;
    }

    function BaseItem() {
        App::uses("Item", "Inventory.Model");
        $item = new Item();
        $item_list = array( );
        $item_list = $item->find("list", array( "fields" => array( "id", "item_title" ), 'conditions' => array( 'base_item' => '0' ) ));
        return $item_list;
    }

    function ItemForPurchaseOrder() {
        App::uses("Item", "Inventory.Model");
        $item = new Item();
        return $item->find("list", array( "fields" => array( "id", "number" ) ));
    }

    function findGST() {
        App::import('Model', 'PurchaseOrderManager.GeneralSetting');
        $gst = new GeneralSetting();
        $gst_data = $gst->find('first', array( 'conditions' => array( 'GeneralSetting.type' => 'gst' ) ));
        return $gst_data['GeneralSetting']['value'];
    }

    function FindPST() {
        App::import('Model', 'PurchaseOrderManager.GeneralSetting');
        $pst = new GeneralSetting();
        $pst_data = $pst->find('first', array( 'conditions' => array( 'GeneralSetting.type' => 'pst' ) ));
        return $pst_data['GeneralSetting']['value'];
    }

    function FindRecentCustomer() {
        App::import('Model', 'CustomerManager.Customer');
        $cus_model = new Customer();

        $cus_data = $cus_model->find('first', array( 'order' => array( 'Customer.id DESC' ) ));
        return $cus_data['Customer']['id'];
    }

    function Customer() {
        App::uses("Customer", "CustomerManager.Model");
        $customer = new Customer();
        $customer->recursive = 0;
        $customers = $customer->find("all", array( "fields" => array( "id", "first_name", 'last_name' ) ));
//    debug($customers); exit;
        $tmp_customer = array( );
        foreach( $customers as $list ) {
            $tmp_customer[$list['Customer']['id']] = $list['Customer']['first_name'] . ' ' . $list['Customer']['last_name'];
        }
        return $tmp_customer;
    }

    function builderCustomer() {
        App::uses("Customer", "CustomerManager.Model");
        $customer = new Customer();
        $customer->recursive = 0;
        $customers = $customer->find("all", array( 'conditions' => array( 'Customer.customer_type_id' => 2 ), "fields" => array( "id", "first_name", 'last_name' ) ));

        $tmp_customer = array( );
        foreach( $customers as $list ) {
            $tmp_customer[$list['Customer']['id']] = $list['Customer']['first_name'] . ' ' . $list['Customer']['last_name'];
        }
        return $tmp_customer;
    }

    function findBuilderCustomer() {
        App::uses("BuilderProject", "CustomerManager.Model");
        $BuilderProject_model = new BuilderProject();
        $customer->recursive = 0;
        $customers = $BuilderProject_model->find("list", array( "fields" => array( "id", "project_name" ) ));

        return $customers;
    }

    function CustomerAddressType($id) {
        App::uses("AddressType", "CustomerManager.Model");
        $customer_address_type = new AddressType();
        return $customer_address_type->find("list", array( "conditions" => array( "id" => $id ) ));
    }

    function TemplateItem($current_item_id) {
        App::uses("Item", "Inventory.Model");
        $item = new Item();
        return $item->find("list", array( "fields" => array( "id", "item_title" ), 'conditions' => array( 'id !=' => $current_item_id ) ));
    }

    function ListQuoteItems($quote_id) {
        App::uses("Quote", "QuoteManager.Model");
        $list_quote = new Quote();
        $query = "SELECT t.code as code,SUM(t.quantity) as quantity FROM(SELECT coi.code as code ,coi.quantity as quantity FROM  cabinet_order_items as coi WHERE coi.cabinet_order_id in (
              SELECT co.id FROM cabinet_orders AS co WHERE co.quote_id =$quote_id) || coi.quote_id=$quote_id ) AS t GROUP BY t.code";

        $list_data = $list_quote->query($query);
        $list = array( );
        $title_list = array( );
        $name_list = array( );
        $price_list = array( );
        $all_items = $this->ListAllTypesOfItems();
        $index = 0;
//    cake_debug($list_data);
        if( $list_data && is_array($list_data) ) {
            foreach( $list_data as $row ) {
                @$list[$row['t']['code']] = $row[0]['quantity'];
                @$name_list[$row['t']['code']] = $all_items['main_list'][$row['t']['code']];
                @$price_list[$row['t']['code']] = $all_items['price_list'][$row['t']['code']];
                @$title_list[$row['t']['code']] = $all_items['title_list'][$row['t']['code']];

                $index++;
            }
        }

        $query = "SELECT t.code as code,SUM(t.quantity) as quantity FROM(SELECT coi.code as code ,coi.quantity as quantity FROM  granite_order_items as coi WHERE coi.granite_order_id= (
              SELECT co.id FROM granite_orders AS co WHERE co.quote_id =$quote_id) || coi.quote_id=$quote_id ) AS t GROUP BY t.code";
        $list_data = $list_quote->query($query);
//    debug($list_data);
        foreach( $list_data as $row ) {
            if( array_key_exists($row['t']['code'], $list) ) {
                $list[$row['t']['code']] = $list[$row['t']['code']] + $row[0]['quantity'];
            }
            else {
                @$list[$row['t']['code']] = $row[0]['quantity'];
                @$name_list[$row['t']['code']] = $all_items['main_list'][$row['t']['code']];
                @$price_list[$row['t']['code']] = $all_items['price_list'][$row['t']['code']];
                @$title_list[$row['t']['code']] = $all_items['title_list'][$row['t']['code']];
            }
        }

        return array( 'quantity_list' => $list, 'name_list' => $name_list, 'price_list' => $price_list, 'title_list' => $title_list );
    }

    function ListAllTypesOfItems() {
        App::uses("Item", "Inventory.Model");
        $item = new Item();

        $query = "SELECT cabinets.id AS id, cabinets.name AS code, 'cabinet' AS item_type, cabinets.manual_unit_price AS price, cabinets.name AS title FROM cabinets
              UNION
                SELECT items.id AS id, items.item_title AS code, 'item' AS item_type, items.price AS price, items.item_title AS title FROM items
              UNION
                SELECT wd.id AS id, wd.wall_door_code AS code, 'wall_door' AS item_type, wd.wall_door_price_each AS price, wd.door_style AS title FROM doors wd WHERE wd.wall_door_code IS NOT NULL AND wd.wall_door_code != ''
              UNION
                SELECT d.id AS id, d.drawer_code AS code, 'drawer' AS item_type, d.drawer_price_each AS price, d.door_style AS title FROM doors d WHERE d.drawer_code IS NOT NULL AND d.drawer_code != ''
              UNION
                SELECT door.id AS id, door.door_code AS code, 'door' AS item_type, door.door_price_each AS price, door.door_style AS title FROM doors door WHERE door.door_code IS NOT NULL AND door.door_code != ''";
        $result = $item->query($query);
        $list = array( );
        $title_list = array( );
        $price_list = array( );

        foreach( $result as $row ) {
            $list["{$row[0]['id']}|{$row[0]['item_type']}"] = $row[0]['code'];
            $price_list["{$row[0]['id']}|{$row[0]['item_type']}"] = $row[0]['price'];
            $title_list["{$row[0]['id']}|{$row[0]['item_type']}"] = $row[0]['title'];
        }
        return array( 'main_list' => $list, 'price_list' => $price_list, 'title_list' => $title_list );
    }

    function getEdgeTapeItems() {
        App::uses("Item", "Inventory.Model");
        $item = new Item();

        $query = "SELECT items.id AS id, items.item_title AS code, 'item' AS item_type, items.price AS price, items.item_title AS title
                FROM items
                LEFT JOIN `items_options` `items_options` ON `items_options`.item_id = items.id
                WHERE `items_options`.inventory_lookup_id = 117";
        $result = $item->query($query);
        $list = array( );
        $title_list = array( );
        $price_list = array( );

        foreach( $result as $row ) {
            $list[$row['items']['id']] = $row['items']['code'];
            $price_list[$row['items']['id']] = $row['items']['price'];
            $title_list[$row['items']['id']] = $row['items']['title'];
        }
        return array( 'main_list' => $list, 'price_list' => $price_list, 'title_list' => $title_list );
    }

//	function ListAllTypesOfItemsForPO($id=null) {
//		App::uses("CabinetOrder", "QuoteManager.Model");
//    $cabinetorder = new CabinetOrder();
//
//		$cabinetorder_id = $cabinetorder->find("first", array("fields" => array("id"),
//                "conditions" =>
//                array(
//                    "CabinetOrder.quote_id" => $id)));
//		//pr($cabinetorder_id);exit;
////    App::uses("Item", "Inventory.Model");
////    $item = new Item();
////
////    $query = "SELECT cabinets.id AS id, cabinets.name AS code, 'cabinet' AS item_type, cabinets.manual_unit_price AS price, cabinets.name AS title FROM cabinets WhERE cabinets.
////              UNION
////                SELECT items.id AS id, items.number AS code, 'item' AS item_type, items.price AS price, items.item_title AS title FROM items
////              UNION
////                SELECT wd.id AS id, wd.wall_door_code AS code, 'wall_door' AS item_type, wd.wall_door_price_each AS price, wd.door_style AS title FROM doors wd WHERE wd.wall_door_code IS NOT NULL AND wd.wall_door_code != ''
////              UNION
////                SELECT d.id AS id, d.drawer_code AS code, 'drawer' AS item_type, d.drawer_price_each AS price, d.door_style AS title FROM doors d WHERE d.drawer_code IS NOT NULL AND d.drawer_code != ''
////              UNION
////                SELECT door.id AS id, door.door_code AS code, 'door' AS item_type, door.door_price_each AS price, door.door_style AS title FROM doors door WHERE door.door_code IS NOT NULL AND door.door_code != ''";
////    $result = $item->query($query);
////    $list = array();
////    $title_list = array();
////    $price_list = array();
////
////    foreach ($result as $row) {
////      $list["{$row[0]['id']}|{$row[0]['item_type']}"] = $row[0]['code'];
////      $price_list["{$row[0]['id']}|{$row[0]['item_type']}"] = $row[0]['price'];
////      $title_list["{$row[0]['id']}|{$row[0]['item_type']}"] = $row[0]['title'];
////    }
////    return array('main_list' => $list, 'price_list' => $price_list, 'title_list' => $title_list);
//  }

    function InventoryLookup($lookup_type = 'item_group') {
        App::uses("InventoryLookup", "Inventory.Model");
        $itemDepartment = new InventoryLookup();
        return $itemDepartment->find("list", array( "fields" => array( "id", "name" ), 'conditions' => array( 'lookup_type' => $lookup_type ) ));
    }

    function getInstallerName() {
        App::import('Model', 'ScheduleManager.Installer');
        $installer_model = new Installer();
        return $installer_model->find("list", array( "fields" => array( "id", "name_lookup_id" ) ));
    }

    function InventoryLookupWholeData($lookup_type = 'item_group') {
        App::uses("InventoryLookup", "Inventory.Model");
        $itemDepartment = new InventoryLookup();
        $found = $itemDepartment->find("all", array( 'conditions' => array( 'lookup_type' => $lookup_type ) ));
        $data = array( );
        if( isset($found) ) {
            foreach( $found as $row ) {
                $data[$row['InventoryLookup']['id']] = $row['InventoryLookup'];
            }
        }
        return $data;
    }

    function InventoryLookupReverse($id) {
        App::uses("InventoryLookup", "Inventory.Model");
        $itemDepartment = new InventoryLookup();
        $found = $itemDepartment->find("first", array( "fields" => array( "id", "name" ), 'conditions' => array( 'id' => $id ) ));
        return isset($found['InventoryLookup']['name']) ? $found['InventoryLookup']['name'] : null;
    }

    function InventoryLookupReverseDetail($id) {
        App::uses("InventoryLookup", "Inventory.Model");
        $itemDepartment = new InventoryLookup();
        $found = $itemDepartment->find("first", array( 'conditions' => array( 'id' => $id ) ));
        return isset($found) ? $found : null;
    }

    function InventorySpecificLookup($lookup_type = 'item_group', $id) {
        App::uses("InventoryLookup", "Inventory.Model");
        $itemDepartment = new InventoryLookup();
        return $itemDepartment->find("list", array( "fields" => array( "id", "name" ), 'conditions' => array( 'lookup_type' => $lookup_type, 'id' => $id ) ));
    }

    function InventoryLookupTypes($type = array( )) {
        App::uses("InventoryLookup", "Inventory.Model");
        $itemDepartment = new InventoryLookup();
        if( is_array($type) )
            $inventoryLookups = $itemDepartment->find("all", array( "fields" => array( "DISTINCT InventoryLookup.lookup_type" ), 'conditions' => array( 'lookup_type' => $type ) ));
        else
            $inventoryLookups = $itemDepartment->find("all", array( "fields" => array( "DISTINCT InventoryLookup.lookup_type" ) ));

        $inventoryLookupList = array( );
        foreach( $inventoryLookups as $inventoryLookup ) {
            $inventoryLookupList[$inventoryLookup['InventoryLookup']['lookup_type']] = $this->text_setting_type($inventoryLookup['InventoryLookup']['lookup_type']);
        }
        return $inventoryLookupList;
    }

    function InventoryLookupTypesStatic($type = array( )) {
        $inventoryLookups = $type;
        $inventoryLookupList = array( );
        foreach( $inventoryLookups as $inventoryLookup ) {
            $inventoryLookupList[$inventoryLookup] = $this->text_setting_type($inventoryLookup);
        }
        return $inventoryLookupList;
    }

    function ItemDepartment($active = 1) {
        App::uses("ItemDepartment", "Inventory.Model");
        $itemDepartment = new ItemDepartment();
        return $itemDepartment->find("list", array( "fields" => array( "id", "name" ), 'conditions' => array( 'active' => $active ) ));
    }

    function ItemDepartmentDetails($active = 1) {
        App::uses("ItemDepartment", "Inventory.Model");
        $itemDepartment = new ItemDepartment();
        $itemDepartment->recursive = -1;
        return $itemDepartment->find("all", array( "fields" => array( "id", "name", 'supplier_required', 'stock_number_required', 'direct_sale', 'system', 'avaiable_in_website' ), 'conditions' => array( 'active' => $active ) ));
    }

    function ProductionTime() {
        App::uses("GeneralSetting", "PurchaseOrderManager.Model");
        $general_setting = new GeneralSetting();
        return $general_setting->find("list", array( "fields" => array( "id", "name" ), 'conditions' => array( 'GeneralSetting.type' => "production_time" ) ));
    }

    function findProductionTime($id = null) {
        App::uses("GeneralSetting", "PurchaseOrderManager.Model");
        $general_setting = new GeneralSetting();
        $data = $general_setting->find("first", array( 'conditions' => array( 'GeneralSetting.id' => $id ) ));

        return $data['GeneralSetting']['name'];
    }

    function ItemDepartmentAll() {
        App::uses("ItemDepartment", "Inventory.Model");
        $itemDepartment = new ItemDepartment();
        return $itemDepartment->find("list", array( "fields" => array( "id", "name" ), 'conditions' => array( ) ));
    }

    function getItemDepartmentName($id) {
        App::uses("ItemDepartment", "Inventory.Model");
        $itemDepartment = new ItemDepartment();
        $itemDepartment->recursive = 0;
        $itemDepartmentDetail = $itemDepartment->find("first", array( "fields" => array( "id", "name" ), 'conditions' => array( 'ItemDepartment.id' => $id ) ));
        return $itemDepartmentDetail['ItemDepartment']['name'];
    }

    function getDefaultLocaltionName($id = null) {
        App::import('Model', 'PurchaseOrderManager.GeneralSetting');
        $gs = new GeneralSetting();
        $gs_data = $gs->find("first", array( 'conditions' => array( 'GeneralSetting.id' => $id ) ));
        return $gs_data['GeneralSetting']['name'];
    }

    function option_public_access() {
        return array( '1' => 'Public', '0' => 'Private' );
    }

    function text_yes_no($bool) {
        $text_for_yes_no = '';
        switch( $bool ) {
            case '1':
                $text_for_yes_no = 'Yes';
                break;
            default:
                $text_for_yes_no = 'No';
                break;
        }

        return __($text_for_yes_no);
    }

    function text_public_access($bool) {
        $text_for_public_access = '';
        switch( $bool ) {
            case '1':
                $text_for_public_access = 'Public';
                break;
            default:
                $text_for_public_access = 'Private';
                break;
        }
        return __($text_for_public_access);
    }

    function text_status($status) {
        $text_for_status = '';
        switch( $status ) {
            case '1':
                $text_for_status = 'Active';
                break;
            default:
                $text_for_status = 'Inactive';
                break;
        }

        return __($text_for_status);
    }

    function text_setting_type($setting_type) {
        $text_for_setting_type = '';
        switch( $setting_type ) {
            case 'item_group':
                $text_for_setting_type = 'Item Group';
                break;
            case 'item_option':
                $text_for_setting_type = 'Item Option';
                break;
            case 'cabinet_type':
                $text_for_setting_type = 'Cabinet Type';
                break;
            case 'cabinet_item_category':
                $text_for_setting_type = 'Cabinet Item Category';
                break;
            case 'doors_rounding_method':
                $text_for_setting_type = 'Door Rounding Method';
                break;
            case 'doors_product_line':
                $text_for_setting_type = 'Door Product Line';
                break;
            case 'order_door_information':
                $text_for_setting_type = 'Cabinet Order Door Options';
                break;
            case 'product_line':
                $text_for_setting_type = 'Product Line';
                break;
            default:
                $text_for_setting_type = $this->to_camel_case($setting_type);
                break;
        }

        return __($text_for_setting_type);
    }

    /**
     * Translates a string with underscores into camel case (e.g. first_name -&gt; firstName)
     * @param    string   $str                     String in underscore format
     * @param    bool     $capitalise_first_char   If true, capitalise the first char in $str
     * @return   string                              $str translated into camel caps
     */
    function to_camel_case($str) {
        $str = str_replace('_', ' ', $str);
        return ucwords($str);
    }

    function door_form_elements($section) {
        $sub_form = array( );
        switch( $section ) {
            case 'basic':
                $sub_form['from'] = 'door-basic-info-form';
                $sub_form['detail'] = 'door-basic-info-detail';
                break;
            case 'images':
                $sub_form['from'] = 'door-images-form';
                $sub_form['detail'] = 'door-images-detail';
                break;
            case 'factory':
                $sub_form['from'] = 'door-factory-info-form';
                $sub_form['detail'] = 'door-factory-info-detail';
                break;
            default :
                $sub_form['from'] = 'door-basic-info-form';
                $sub_form['detail'] = 'door-basic-info-detail';
        }

        return $sub_form;
    }

    function invoice_form_elements($section) {
        $sub_form = array( );
        switch( $section ) {
            case 'basic':
                $sub_form['from'] = 'invoice-basic-info-form';
                $sub_form['detail'] = 'invoice-basic-info-detail';
                break;
            case 'status':
                $sub_form['detail'] = 'invoice-status-info';
                break;
            default :
                $sub_form['from'] = 'invoice-basic-info-form';
                $sub_form['detail'] = 'invoice-basic-info-detail';
        }

        return $sub_form;
    }

    function service_entry_form_elements($section) {
        $sub_form = array( );
        switch( $section ) {
            case 'basic':
                $sub_form['from'] = 'service-entry-basic-info-form';
                $sub_form['detail'] = 'service-entry-basic-info-detail';
                break;
            case 'status':
                $sub_form['detail'] = 'service-status-info';
                break;
            default :
                $sub_form['from'] = 'service-entry-basic-info-form';
                $sub_form['detail'] = 'service-entry-basic-info-detail';
        }

        return $sub_form;
    }

    function item_form_elements($section) {
        $sub_form = array( );
        switch( $section ) {
            case 'item-detail':
                $sub_form['form'] = 'item-detail-form';
                $sub_form['detail'] = 'item-detail';
                break;
            case 'item-notes':
                $sub_form['form'] = 'item-notes-form';
                $sub_form['detail'] = 'item-notes-detail';
                break;
            case 'item-sub':
                $sub_form['form'] = 'item-core-form';
                $sub_form['detail'] = 'item-sub';
                break;
            default:
                $sub_form['form'] = 'item-core-form';
                $sub_form['detail'] = 'item-basic-info-detail';
                break;
        }
        return $sub_form;
    }

    function installer_form_elements($section) {
        $sub_form = array( );
        switch( $section ) {
            case 'basic':
                $sub_form['form'] = 'installer-basic-form';
                $sub_form['detail'] = 'installer-basic-detail';
                break;
            default:
                $sub_form['form'] = 'installer-basic-form';
                $sub_form['detail'] = 'installer-basic-detail';
                break;
        }
        return $sub_form;
    }

    function installer_schedule_form_elements($section) {
        $sub_form = array( );
        switch( $section ) {
            case 'basic':
                $sub_form['form'] = 'installer-schedule-basic-form';
                $sub_form['detail'] = 'installer-schedule-basic-detail';
                break;
            case 'status':
                $sub_form['detail'] = 'installer-schedule-status-detail';
                break;
            default:
                $sub_form['form'] = 'installer-schedule-basic-form';
                $sub_form['detail'] = 'installer-schedule-basic-detail';
                break;
        }
        return $sub_form;
    }

    function work_order_form_elements($section) {
        $sub_form = array( );
        switch( $section ) {
            case 'basic':
                $sub_form['form'] = 'work-order-form';
                $sub_form['detail'] = 'work-order-basic-info-detail';
                break;
            case 'status':
                //$sub_form['form'] = 'work-order-status-form';
                $sub_form['detail'] = 'work-order-status-detail';
                break;
            case 'work-order-po':
                $sub_form['detail'] = 'work-order-po-list';
                break;
            default:
                $sub_form['form'] = 'work-order-form';
                $sub_form['detail'] = 'work-order-basic-info-detail';
                break;
        }
        return $sub_form;
    }

    function customer_form_elements($section) {
        $sub_form = array( );
        switch( $section ) {
            case 'basic':
                $sub_form['form'] = 'customer-basic-form';
                $sub_form['detail'] = 'customer-basic-info';
                break;
            case 'builder-basic':
                $sub_form['form'] = 'builder-basic-form';
                $sub_form['detail'] = 'builder-basic-info';
                break;
            case 'account-credit':
                $sub_form['form'] = 'customer-account-credit-form';
                $sub_form['detail'] = 'customer-account-credit-info';
                break;
            default:
                $sub_form['form'] = 'customer-basic-form';
                $sub_form['detail'] = 'customer-basic-info';
                break;
        }
        return $sub_form;
    }

    function cabinet_form_elements($section) {
        $sub_form = '';
        switch( $section ) {
            case 'basic':
                $sub_form = 'cabinet-info-form';
                break;
            case 'door-drawer':
                $sub_form = 'cabinet-door-drawer-form';
                break;
            case 'item':
                $sub_form = 'cabinet-item-form';
                break;
            case 'installation':
                $sub_form = 'cabinet-installation-form';
                break;
            case 'pricing':
                $sub_form = 'cabinet-pricing-form';
                break;
            case 'accessories':
                $sub_form = 'cabinet-accessories-form';
                break;
            default :
                $sub_form = 'cabinet-info-form';
        }

        return $sub_form;
    }

    function cabinet_detail_elements($section) {
        $sub_form = '';
        switch( $section ) {
            case 'basic':
                $sub_form = 'cabinet-basic-info-detail';
                break;
            case 'door-drawer':
                $sub_form = 'cabinet-door-drawer-detail';
                break;
            case 'item':
                $sub_form = 'cabinet-items-detail';
                break;
            case 'installation':
                $sub_form = 'cabinet-installation-detail';
                break;
            case 'pricing':
                $sub_form = 'cabinet-pricing-detail';
                break;
            case 'accessories':
                $sub_form = 'cabinet-accessories-detail';
                break;
            default :
                $sub_form = 'cabinet-basic-info-detail';
        }
        return $sub_form;
    }

    function cabinet_ajax_sub_content($section) {
        $sub_form = '';
        switch( $section ) {
            case 'basic':
                $sub_form = 'cabinet_information';
                break;
            case 'door-drawer':
                $sub_form = 'cabinet_door_drawer';
                break;
            case 'item':
                $sub_form = 'cabinet_items';
                break;
            case 'installation':
                $sub_form = 'cabinet_installations';
                break;
            case 'pricing':
                $sub_form = 'cabinet_pricing';
                break;
            case 'accessories':
                $sub_form = 'cabinet_accessories';
                break;
            default :
                $sub_form = 'cabinet_information';
        }

        return $sub_form;
    }

    function user_form_elements($section) {
        $sub_form = array( );
        switch( $section ) {
            case 'basic':
                $sub_form['form'] = 'user-basic-form';
                $sub_form['detail'] = 'user-basic-info';
                break;
            default:
                $sub_form['form'] = 'user-basic-form';
                $sub_form['detail'] = 'user-basic-info';
                break;
        }
        return $sub_form;
    }

    function form_elements($type, $section) {
        $sub_form = array( );
        if( $type == 'Quote' ) {
            switch( $section ) {
                case 'basic':
                    $sub_form['from'] = 'quote-basic-form';
                    $sub_form['detail'] = 'quote-basic-info-detail-main';
                    break;
                case 'counter-top':
                    $sub_form['from'] = 'quote-counter-top-form';
                    $sub_form['detail'] = 'quote-counter-top-detail';
                    break;
                case 'extra-hardware':
                    $sub_form['from'] = 'quote-extra-hardware-form';
                    $sub_form['detail'] = 'quote-extra-hardware-detail';
                    break;
                case 'door-shelf':
                    $sub_form['from'] = 'quote-extra-hardware-form';
                    $sub_form['detail'] = 'quote-glass-doors-shelf-detail';
                    break;
                case 'installer-paysheet':
                    $sub_form['from'] = 'quote-installer-paysheet-form';
                    $sub_form['detail'] = 'quote-installer-paysheet-detail';
                    break;
                case 'pricing':
                    $sub_form['from'] = 'quote-pricing-form';
                    $sub_form['detail'] = 'quote-pricing-detail';
                    break;
                case 'status':
                    $sub_form['from'] = 'quote-status-form';
                    $sub_form['detail'] = 'quote-status-detail';
                    break;
                default :
                    $sub_form['from'] = 'quote-basic-form';
                    $sub_form['detail'] = 'quote-basic-info-detail';
            }
        }

        return $sub_form;
    }

    function select2_json_format($data = array( )) {
        $return_data = array( );
        $index = 0;
        $data = array_unique($data, SORT_STRING);
        foreach( $data as $val ) {
            if( $val ) {
                $return_data[$index]['id'] = $val;
                $return_data[$index]['text'] = $val;
                $index++;
            }
        }
        return json_encode($return_data);
    }

    function select2_multi_json_format($data = array( ), $select_data = array( )) {
        $return_data = array( );
        $index = 0;
        $data = array_unique($data, SORT_STRING);
        foreach( $data as $key => $val ) {
            if( $val ) {
                $return_data[$index]['id'] = $key;
                $return_data[$index]['text'] = $val;
                $index++;
            }
        }
        return json_encode($return_data);
    }

    function address_format_quote_report($address, $city, $provience, $country, $postal_code) {
        $content = "";
        if( $address != "" )
            $content.=$address . "<br/>";
        if( $city != "" || $provience != "" ) {
            $content.= "<div class='marT5'>";
            $content.= $city;
            if( $city != "" && $provience != "" )
                $content.= ", ";
            $content.= $provience . " " . $postal_code;
            $content.= "</div>";
        }
        if( $country != "" || $postal_code != "" ) {
            $content.= "<div class='marT5'>";
            $content.= $country;
            $content.= "</div>";
        }
        return $content;
    }

    function address_format($address, $city, $provience, $country, $postal_code) {
        $content = "";
        if( $address != "" )
            $content.=$address . "<br/>";
        if( $city != "" || $provience != "" ) {
            $content.= "<div class='marT5'>";
            $content.= $city;
            if( $city != "" && $provience != "" )
                $content.= ", ";
            $content.= $provience . " " . $postal_code;
            $content.= "</div>";
        }
        if( $country != "" || $postal_code != "" ) {
            $content.= "<div class='marT5'>";
            $content.= $country;
            $content.= "</div>";
        }
        return $content;
    }

    function phone_format($phone, $phone_ext, $cell, $fax) {
        $content = "<div class='marT5'>";
        if( $phone != "" ) {
            $content.= "<label class='no-width'>";
            $content.= "Phone: " . $phone . "&nbsp;";
            if( $phone_ext != "" )
                $content.= "Ext: " . $phone_ext;
            $content.= "</label><br/>";
        }
        if( $cell != "" ) {
            $content.= "<label class='no-width'>";
            $content.= "Cell: " . $cell;
            $content.= "</label><br/>";
        }
        if( $fax != "" ) {
            $content.= "<label class='no-width'>";
            $content.= "Fax: " . $fax;
            $content.= "</label><br/>";
        }
        return $content . "</div>";
    }

    function getOrderInfo($opt = null) {
        $d = array( ORDER_1 => "50177", ORDER_2 => "50178", ORDER_3 => "50179" );
        return $opt == null ? $d : $d[$opt];
    }

    function getPaymentType($opt = null) {
        $d = array( ON_ACCOUNT => "On Account", CASH => "Cash", CHEQUE => "Cheque", CREDIT_CARD => "Credit Card" );
        return $opt == null ? $d : $d[$opt];
    }

    function ListQuoteAllItem($cabinet_order_id = null, $quote_id = null, $type = "") {
        App::uses("CabinetOrderItem", "QuoteManager.Model");
        $cabinet_order = new CabinetOrderItem();

        $item = array( );
        if( $cabinet_order_id ) {
            $item = $cabinet_order->find("all", array( "conditions" => array( "CabinetOrderItem.cabinet_order_id" => $cabinet_order_id, 'CabinetOrderItem.type' => $type ) ));
        }
        else {
            $item = $cabinet_order->find("all", array( "conditions" => array( "CabinetOrderItem.quote_id" => $quote_id, 'CabinetOrderItem.type' => $type ) ));
        }

        return $item;
    }

    function AdjustPOItem($data = array( )) {
        foreach( $data['quantity_list'] as $key => $val ) {
            //debug(strripos($key, 'cabinet'));
            if( strripos($key, 'cabinet') ) {
                $id = explode('|', $key);
                //debug($id);
                App::uses("Cabinet", "Inventory.Model");
                $list_Item = new Cabinet();
                $query = "SELECT i.id as id, i.number as number, i.item_title as title, i.price as price, ci.item_quantity as quantity FROM  cabinets_items as ci INNER JOIN items as i ON i.id=ci.item_id WHERE ci.cabinet_id=$id[0]";

                $list_data = $list_Item->query($query);
                //debug($list_data);
                foreach( $list_data as $row ) {
                    $tmp_key = $row['i']['id'] . '|item';

                    if( array_key_exists($tmp_key, $data['quantity_list']) ) {
                        $data['quantity_list'][$tmp_key] = $data['quantity_list'][$tmp_key] + ($row['ci']['quantity'] * $val);
                    }
                    else {
                        $data['quantity_list'] = array_merge($data['quantity_list'], array( $tmp_key => ($row['ci']['quantity'] * $val) ));
                        $data['name_list'] = array_merge($data['name_list'], array( $tmp_key => $row['ci']['number'] ));
                        $data['price_list'] = array_merge($data['price_list'], array( $tmp_key => $row['ci']['price'] ));
                        $data['title_list'] = array_merge($data['title_list'], array( $tmp_key => $row['ci']['title'] ));
                    }
                    unset($data['quantity_list'][$key]);
                    unset($data['name_list'][$key]);
                    unset($data['price_list'][$key]);
                    unset($data['title_list'][$key]);
                }
            }
        }
        return $data;
    }

    function RestrictedSupplierOfPO($work_order_id) {
        App::uses("PurchaseOrder", "PurchaseOrderManager.Model");
        $purchaseOrder = new PurchaseOrder();
        return $purchaseOrder->find("list", array( "fields" => array( "supplier_id" ), 'conditions' => array( 'work_order_id' => $work_order_id ) ));
    }

    function listOfPoItem($wo_id) {
        App::uses('PurchaseOrderItem', 'PurchaseOrderManager.Model');
        $purchaseOrderModel = new PurchaseOrderItem();
        $purchaseOrders = $purchaseOrderModel->find('all', array( 'fields' => array( 'PurchaseOrder.id,PurchaseOrder.purchase_order_num,PurchaseOrderItem.id', 'PurchaseOrderItem.code' ), 'conditions' => array( 'PurchaseOrder.work_order_id' => $wo_id ) ));
        //debug($purchaseOrders);

        $allItems = $this->ListAllTypesOfItems();
        $list = array( );
        $title_list = array( );
        $price_list = array( );
        $po_list = array( );
        $po_id_list = array( );
        foreach( $purchaseOrders as $value ) {
            if( array_key_exists($value['PurchaseOrderItem']['code'], $allItems['main_list']) ) {
                $list[$value['PurchaseOrderItem']['code']] = $allItems['main_list'][$value['PurchaseOrderItem']['code']];
                $title_list[$value['PurchaseOrderItem']['code']] = $allItems['title_list'][$value['PurchaseOrderItem']['code']];
                $price_list[$value['PurchaseOrderItem']['code']] = $allItems['price_list'][$value['PurchaseOrderItem']['code']];
                $po_list[$value['PurchaseOrderItem']['code']] = $value['PurchaseOrder']['purchase_order_num'];
                $po_id_list[$value['PurchaseOrderItem']['code']] = $value['PurchaseOrder']['id'];
            }
        }
        return array( 'main_list' => $list, 'title_list' => $title_list, 'price_list' => $price_list, 'po_list' => $po_list, 'po_id_list' => $po_id_list );
    }

    function fullCalenderJsonFormate($all_data) {
        $tmp_data = array( );
        $index = 0;
        foreach( $all_data as $data ) {
            $tmp_data[$index]['id'] = $data['Appointment']['id'];
            $tmp_data[$index]['title'] = $data['WorkOrder']['work_order_number'] . ': ' . $data['Appointment']['quote_number'];
            $tmp_data[$index]['start'] = $data['Appointment']['start_date'];
            $tmp_data[$index]['end'] = $data['Appointment']['end_date'];
            $tmp_data[$index]['allDay'] = false;
            $index++;
        }
        return $tmp_data;
    }

    function auto_generate_number($type) {
        $value = "";
        if( $type == "Quote" ) {
            App::uses('Quote', 'QuoteManager.Model');
            $quoteModel = new Quote();
            $quotes = $quoteModel->find('all', array( 'fields' => array( 'Quote.id,Quote.quote_number' ) ));
            if( $quotes ) {
                $quote_number = (int) $quotes[count($quotes) - 1]['Quote']['quote_number'];
                $cnt = count($quotes);
                $max = 0;
                for( $i = 1; $i <= $cnt; $i++ ) {
                    $num = (int) $quotes[$i - 1]['Quote']['quote_number'];
                    if( $max < $num )
                        $max = $num;
                }
                $quote_number = explode("-", $quote_number);
                $length = (strlen($quote_number[0] + 1) == strlen($quote_number[0])) ? strlen($quote_number[0]) : strlen($quote_number[0] + 1);
                for( $i = $length; $i < 6; $i++ ) {
                    $value .='0';
                }
                //$value.=$quote_number[0] + 1;
                $value.=$max + 1;
            }
            else {
                $value = "000001";
            }
        }
        elseif( $type == "Work Order" ) {
            App::uses('WorkOrder', 'WorkOrderManager.Model');
            $woModel = new WorkOrder();
            $wos = $woModel->find('all', array( 'fields' => array( 'WorkOrder.id,work_order_number' ) ));
            if( $wos ) {
                $wo_number = (int) $wos[count($wos) - 1]['WorkOrder']['work_order_number'];
                $length = (strlen($wo_number + 1) == strlen($wo_number)) ? strlen($wo_number) : strlen($wo_number + 1);
                for( $i = $length; $i < 6; $i++ ) {
                    $value .='0';
                }
                $value.=$wo_number + 1;
            }
            else {
                $value = "000001";
            }
        }
        elseif( $type == "Purchase Order" ) {
            App::uses('PurchaseOrder', 'PurchaseOrderManager.Model');
            $poModel = new PurchaseOrder();
            $pos = $poModel->find('all', array( 'fields' => array( 'PurchaseOrder.id,purchase_order_num' ) ));
            if( $pos ) {
                $po_number = (int) $pos[count($pos) - 1]['PurchaseOrder']['purchase_order_num'];
                $length = (strlen($po_number + 1) == strlen($po_number)) ? strlen($po_number) : strlen($po_number + 1);
                for( $i = $length; $i < 6; $i++ ) {
                    $value .='0';
                }
                $value.=$po_number + 1;
            }
            else {
                $value = "000001";
            }
        }
        elseif( $type == "Invoice" ) {
            App::uses('Invoice', 'Invoice.Model');
            $invoiceModel = new Invoice();
            $invoice = $invoiceModel->find('all', array( 'fields' => array( 'Invoice.id,invoice_no' ) ));
            if( $invoice ) {
                $invoice_number = (int) $invoice[count($invoice) - 1]['Invoice']['invoice_no'];
                $length = (strlen($invoice_number + 1) == strlen($invoice_number)) ? strlen($invoice_number) : strlen($invoice_number + 1);
                for( $i = $length; $i < 6; $i++ ) {
                    $value .='0';
                }
                $value.=$invoice_number + 1;
            }
            else {
                $value = "000001";
            }
        }

        return $value;
    }

    function holiday_list() {
        App::uses('Holiday', 'ScheduleManager.Model');
        $holidayModel = new Holiday();
        $holidays = $holidayModel->find('all', array( 'fields' => array( 'Holiday.type_holidays_id,Holiday.holidays_date' ) ));
        //debug($holidays);
        $tmp_holidays = array( );
        foreach( $holidays as $holiday ) {
            if( !array_key_exists($holiday['Holiday']['type_holidays_id'], $tmp_holidays) )
                $tmp_holidays[$holiday['Holiday']['type_holidays_id']] = array( );

            $tmp_holidays[$holiday['Holiday']['type_holidays_id']][$holiday['Holiday']['holidays_date']] = $holiday['Holiday']['holidays_date'];
        }

        return $tmp_holidays;
    }

    function installer_schedule_list() {
        App::uses('InstallerSchedule', 'ScheduleManager.Model');
        $installerScheduleModel = new InstallerSchedule();
        $installerSchedules = $installerScheduleModel->find('all');
        //debug($installerSchedules);exit;

        $tmp_installerSchedules = array( );
        foreach( $installerSchedules as $installerSchedule ) {
            if( !array_key_exists($installerSchedule['InstallerSchedule']['installer_id'], $tmp_installerSchedules) )
                $tmp_installerSchedules[$installerSchedule['InstallerSchedule']['installer_id']] = array( );

            $address = $this->address_format($installerSchedule['InstallerSchedule']['address'], $installerSchedule['InstallerSchedule']['city'], $installerSchedule['InstallerSchedule']['province'], $installerSchedule['InstallerSchedule']['country'], $installerSchedule['InstallerSchedule']['postal_code']);
            $new_array = array(
                "work_order_number" => $installerSchedule['WorkOrder']['work_order_number'],
                "name" => $installerSchedule['InstallerSchedule']['name'],
                "address" => $address
            );
            $tmp_installerSchedules[$installerSchedule['InstallerSchedule']['installer_id']][$installerSchedule['InstallerSchedule']['start_install']] = $new_array;
            for( $i = 1; $i <= ($installerSchedule['InstallerSchedule']['number_of_days'] - 1); $i++ ) {
                $inc_day = date('Y-m-d', strtotime("+" . $i . " days", strtotime($installerSchedule['InstallerSchedule']['start_install'])));
                $tmp_installerSchedules[$installerSchedule['InstallerSchedule']['installer_id']][$inc_day] = $new_array;
            }
        }

        return $tmp_installerSchedules;
    }

    function salesPersonList() {
        App::import('Model', 'UserManager.User');
        //App::uses('UserManager', 'User.Model');
        $userModel = new User();
        $users = $userModel->find('all', array( 'fields' => array( 'id', 'first_name', 'last_name' ), 'conditions' => array( 'role' => '96' ) ));
//    debug($users); exit;
        $tmp_users = array( );
        foreach( $users as $user ) {
            $tmp_users[$user['User']['id']] = $user['User']['first_name'] . ' ' . $user['User']['last_name'];
        }

        return $tmp_users;
    }

    function salesPersonDetail($id = null) {
        App::import('Model', 'UserManager.User');
        $userModel = new User();
        $users = $userModel->find('first', array( 'conditions' => array( 'User.id' => $id ) ));
        return $users;
    }

    function userList() {
        App::import('Model', 'UserManager.User');
        $userModel = new User();
        $users = $userModel->find('all', array( 'fields' => array( 'id', 'first_name', 'last_name' ) ));

        $tmp_users = array( );
        foreach( $users as $user ) {
            $tmp_users[$user['User']['id']] = $user['User']['first_name'] . ' ' . $user['User']['last_name'];
        }

        return $tmp_users;
    }

    function getUserForPO($id = null) {
        App::import('Model', 'UserManager.User');
        $userModel = new User();
        $users = $userModel->find('first', array( 'conditions' => array( 'User.id' => $id ) ));

        return $users['User']['first_name'] . " " . $users['User']['last_name'];
    }

    function FinduserQuote($id) {
        App::import('Model', 'UserManager.User');
        $userModel = new User();
        $users = $userModel->find('first', array( 'conditions' => array( 'User.id' => $id ) ));

        return $users['User']['first_name'] . " " . $users['User']['last_name'];
    }

    function invoice_status_list() {
        App::import('Model', 'InvoiceManager.InvoiceStatus');
        $invoiceStatus = new InvoiceStatus();

        $invoiceStatusData = $invoiceStatus->find('list', array( 'fields' => array( 'id', 'name' ) ));

        return $invoiceStatusData;
    }

    function GraniteOrderCost($order_id = null, $quote_id = null) {
        $order_data = array( );
        $total_cost = 0.00;
        $gst_cost = 0.00;
        $item_cost = 0.00;
        App::import("Model", "QuoteManager.GraniteOrder");
        $granite_order = new GraniteOrder();

        if( $order_id ) {
            $order_data = $granite_order->find("first", array( "conditions" => array( "GraniteOrder.id" => $order_id ) ));
        }
        elseif( $quote_id ) {
            $order_data = $granite_order->find("first", array( "conditions" => array( "quote_id" => $quote_id ) ));
        }
        if( $order_data ) {
            $total_cost += $order_data['GraniteOrder']['cost'];
            $order_items = $this->GraniteOrderItem($order_data['GraniteOrder']['id']);

            foreach( $order_items as $order_item ) {
                $item_info = explode('|', $order_item['GraniteOrderItem']['code']);
                $item_type = $item_info[1];

                switch( $item_type ) {
                    case 'item':
                        $item_cost += $order_item['GraniteOrderItem']['quantity'] * $order_item['Item']['price'];
                        break;
                    case 'cabinet':
                        $item_cost += $order_item['GraniteOrderItem']['quantity'] * $order_item['Cabinet']['manual_unit_price'];
                        break;
                    case 'door':
                        $item_cost += $order_item['GraniteOrderItem']['quantity'] * $order_item['Door']['door_price_each'];
                        break;
                    case 'drawer':
                        $item_cost += $order_item['GraniteOrderItem']['quantity'] * $order_item['Door']['drawer_price_each'];
                        break;
                    case 'wall_door':
                        $item_cost += $order_item['GraniteOrderItem']['quantity'] * $order_item['Door']['wall_door_price_each'];
                        break;
                }
            }
            $total_cost += $item_cost;
            $gst_cost = ($total_cost * GST) / 100;
            $total_cost += $gst_cost;
        }

        return array( 'total_cost' => $total_cost, 'gst_cost' => $gst_cost, 'item_cost' => $item_cost );
//    debug($order_data);
    }

    function CabinetOrderCost($order_id = null, $quote_id = null) {
        $order_data = array( );
        $total_cost = 0.00;
        $gst_cost = 0.00;
        $item_cost = 0.00;
        App::import("Model", "QuoteManager.CabinetOrder");
        $cabinet_order = new CabinetOrder();

        if( $order_id ) {
            $order_data = $cabinet_order->find("first", array( "conditions" => array( "CabinetOrder.id" => $order_id ) ));
        }
        elseif( $quote_id ) {
            $order_data = $cabinet_order->find("first", array( "conditions" => array( "quote_id" => $quote_id ) ));
        }
        if( $order_data ) {
            $order_items = $this->CabinetOrderItem($order_data['CabinetOrder']['id']);
//      debug($order_items);
            foreach( $order_items as $order_item ) {
                $item_info = explode('|', $order_item['CabinetOrderItem']['code']);
                $item_type = $item_info[1];

                switch( $item_type ) {
                    case 'item':
                        $item_cost += $order_item['CabinetOrderItem']['quantity'] * $order_item['Item']['price'];
                        break;
                    case 'cabinet':
                        $item_cost += $order_item['CabinetOrderItem']['quantity'] * $order_item['Cabinet']['manual_unit_price'];
                        break;
                    case 'door':
                        $item_cost += $order_item['CabinetOrderItem']['quantity'] * $order_item['Door']['door_price_each'];
                        break;
                    case 'drawer':
                        $item_cost += $order_item['CabinetOrderItem']['quantity'] * $order_item['Door']['drawer_price_each'];
                        break;
                    case 'wall_door':
                        $item_cost += $order_item['GraniteOrderItem']['quantity'] * $order_item['Door']['wall_door_price_each'];
                        break;
                }
            }
            $total_cost += $item_cost;
            $total_cost += $order_data['CabinetOrder']['delivery_cost'] + $order_data['CabinetOrder']['extras_glass'] + $order_data['CabinetOrder']['counter_top'] + $order_data['CabinetOrder']['installation'] - $order_data['CabinetOrder']['discount'];
            $gst_cost = ($total_cost * GST) / 100;
            $total_cost += $gst_cost;
        }

        return array( 'total_cost' => $total_cost, 'gst_cost' => $gst_cost, 'item_cost' => $item_cost );
//    debug($order_data);
    }

    function workOrderCost($wo_id = null) {
        App::import('Model', 'WorkOrderManager.WorkOrder');
        $workOrder = new WorkOrder();
        $workOrderData = $workOrder->find('first', array( 'conditions' => array( 'WorkOrder.id' => $wo_id ) ));
    }

    function Item_name_for_sub_base($id = null) {
        App::import('Model', 'Inventory.Item');
        $item = new Item();
        $item_data = $item->find('first', array( 'conditions' => array( 'Item.id' => $id ) ));
        return $item_data['Item']['item_title'];
    }

    function getSubItem($id = 0) {
        App::import('Model', 'Inventory.Item');
        $item = new Item();
        $item_data = $item->find('all', array( 'conditions' => array( 'Item.base_item' => $id ) ));
        return $item_data;
    }

    function getItemAdditionDetail($id = null) {
        App::import('Model', 'Inventory.ItemAdditionalDetail');
        $item_additional_detail = new ItemAdditionalDetail();
        $item_data = $item_additional_detail->find('first', array( 'conditions' => array( 'ItemAdditionalDetail.item_id' => $id ) ));
        return $item_data;
    }

    function getItemTitle($id = null) {
        App::import('Model', 'Inventory.Item');
        $item = new Item();
        $item_data = $item->find("list", array( "fields" => array( "id", "item_title" ), 'conditions' => array( 'OR' => array( 'Item.base_item' => $id, 'Item.id' => $id ) ) ));
        return $item_data;
    }

    function getItemTitleForSub($id = null) {
        App::import('Model', 'Inventory.Item');
        $item = new Item();
        $item_data = $item->find("list", array( "fields" => array( "id", "item_title" ), 'conditions' => array( 'Item.base_item' => $id ) ));
        return $item_data;
    }

    function getMaterialGroup() {
        App::import('Model', 'Inventory.MaterialGroup');
        $mg = new MaterialGroup();
        $mg_data = $mg->find("list", array( "fields" => array( "id", "name" ) ));
        return $mg_data;
    }

    function getMaterial() {
        App::import('Model', 'Inventory.Material');
        $material = new Material();
        $material_data = $material->find("list", array( "fields" => array( "id", "name" ) ));
        return $material_data;
    }

    function getItemOption() {
        App::uses('Sanitize', 'Utility');

        App::uses("Item", "Inventory.Model");
        $item = new Item();
        $query = "SELECT items.id AS id, items.item_title AS code, 'item' AS item_type, items.price AS price, items.item_title AS title
                FROM items
                LEFT JOIN `items_options` `items_options` ON `items_options`.item_id = items.id AND items.base_item = 0
                WHERE `items_options`.inventory_lookup_id = 117";
        $item_list = $item->query($query);

        $return_data = array( );
        $index = 0;

        foreach( $item_list as $id => $val ) {
            if( $val ) {
                $return_data[$val['items']['id']] = $val['items']['code'];
//                $return_data[$index]['text'] = $val['items']['code'];
                $index++;
            }
        }//pr($return_data);
        return $return_data;
    }

    function getWOInfo($id = null) {
        App::import('Model', 'WorkOrderManager.WorkOrder');
        $WorkOrder = new WorkOrder();
        $WorkOrder_data = $WorkOrder->find("first", array( "conditions" => array( 'WorkOrder.id' => $id ) ));
        return $WorkOrder_data;
    }

    function getCustomerInfo($id = null) {
        App::import('Model', 'CustomerManager.Customer');
        $Customer = new Customer();
        $WorkOrder_data = $Customer->find("first", array( "conditions" => array( 'Customer.id' => $id ) ));
        return $WorkOrder_data;
    }

    function MaterialCode2ID($code = null, $reverse = false) {
        App::import('Model', 'Inventory.Material');
        $material = new Material();
        $material->recursive = 0;
        $material_data = array( );
        if( !$reverse ) {
            $material_data = $material->find("first", array( "fields" => array( "id", "code" ), 'conditions' => array( 'Material.code' => $code ) ));
        }
        else {
            $material_data = $material->find("first", array( "fields" => array( "id", "code" ), 'conditions' => array( 'Material.id' => $code ) ));
        }

        if( isset($material_data['Material']['id']) ) {
            if( !$reverse ) {
                return $material_data['Material']['id'];
            }
            else {
                return $material_data['Material']['code'];
            }
        }
        else {
            return null;
        }
    }

    function findMaterialGroup($id = null) {
        App::import('Model', 'Inventory.MaterialGroup');
        $mg = new MaterialGroup();
        $mg_data = $mg->find("first", array( 'conditions' => array( 'MaterialGroup.id' => $id ) ));
        return $mg_data['MaterialGroup']['name'];
    }

    function findMaterialName($id = null) {
        App::import('Model', 'Inventory.Material');
        $material = new Material();
        $material_data = $material->find("first", array( 'conditions' => array( 'Material.id' => $id ) ));
        return $material_data['Material']['name'];
    }

    function findUserName($id = null) {
        App::import('Model', 'UserManager.User');
        $user_model = new User();
        $user_data = $user_model->find("first", array( 'conditions' => array( 'User.id' => $id ) ));
        return $user_data['User']['first_name'] . " " . $user_data['User']['last_name'];
    }

    function Material($id = null) {
        App::import('Model', 'Inventory.Material');
        $material = new Material();
        $material_data = $material->find("first", array( 'conditions' => array( 'Material.id' => $id ) ));
        return $material_data['Material'];
    }

    function getMaterialByMaterialGroup($material_group_id = null) {
        App::import('Model', 'Inventory.Material');
        $material = new Material();
        $material_data = $material->find("list", array( "fields" => array( "id", "name" ), 'conditions' => array( 'Material.material_group_id' => $material_group_id ) ));
        return $material_data;
    }

    function InventoryLookupValue2Name($value) {
        App::uses("InventoryLookup", "Inventory.Model");
        $itemDepartment = new InventoryLookup();
        $found = $itemDepartment->find("first", array( "fields" => array( "id", "name" ), 'conditions' => array( 'InventoryLookup.value' => $value ) ));
        return isset($found['InventoryLookup']['name']) ? $found['InventoryLookup']['name'] : null;
    }

    /**
     *
     * @param type $report_items
     * @param type $count
     * @param type $door_id
     * @param type $width
     * @param type $height
     * @param type $is_it_drawer
     * @param type $cabinet_count
     */
    function door_drawer_report(&$report_items, $cabinet_order, $count, $door_id, $width, $height, $cabinet_count = 1, $is_it_drawer = false) {
        if( $count > 0 ) {
            $count *= $cabinet_count;
            $index_key = "{$cabinet_order['resource_id']}|{$door_id}|{$width}X{$height}";

            if( isset($report_items[$index_key]['quantity']) ) {
                $report_items[$index_key]['quantity'] += $count;
            }
            else {
                App::import("Model", "Inventory.Door");
                $door = new Door();
                $door->recursive = -1;
                $door_info = $door->find('first', array( 'conditions' => array( 'Door.id' => $door_id ) ));
                $door_detail = $door_info['Door'];
                App::import("Model", "Inventory.Color");
                $color = new Color();
                $color->recursive = -1;
                $color_info = $color->find('first', array( 'conditions' => array( 'Color.id' => $cabinet_order['door_color'] ) ));
                $door_color_detail = $color_info['Color'];
                $color_info = $color->find('first', array( 'conditions' => array( 'Color.id' => $cabinet_order['cabinet_color'] ) ));
                $cabinet_color_detail = $color_info['Color'];

                $width_code = $this->InventoryLookupValue2Name($width);
                $width_code = empty($width_code) ? '--' : $width_code;
                $height_code = $this->InventoryLookupValue2Name($height);
                $height_code = empty($height_code) ? '--' : $height_code;
                if( $is_it_drawer ) {
                    $report_items[$index_key]['code'] = "DR{$width_code}{$height_code}";
                }
                else {
                    $height_code_door_only = $this->InventoryLookupValue2Name($height);
                    if( !is_null($height_code_door_only) ) {
                        $height_code = $height_code_door_only;
                        $height_code = empty($height_code) ? '--' : $height_code;
                    }
                    $report_items[$index_key]['code'] = "DO{$width_code}{$height_code}";
                }

                $report_items[$index_key]['cabinet_color'] = $cabinet_color_detail['name'];
                $report_items[$index_key]['quantity'] = $count;
                $report_items[$index_key]['width'] = $width;
                $report_items[$index_key]['height'] = $height;
                $report_items[$index_key]['door_style'] = $door_detail['door_style'];
                $report_items[$index_key]['door_color'] = $door_color_detail['name'];
                $report_items[$index_key]['description'] = '';
                $report_items[$index_key]['wood_species'] = $this->InventoryLookupReverse($door_detail['wood_species']);
                $report_items[$index_key]['outside_profile'] = $door_detail['outside_profile'];
            }
        }
    }

    /**
     *
     * @param type $report_items
     * @param type $count
     * @param type $door_id
     * @param type $width
     * @param type $height
     * @param type $is_it_drawer
     * @param type $cabinet_count
     */
    function report_door_manufacturing_list(&$report_items, $cabinet_order, $count, $door_id, $width, $height, $cabinet_count = 1, $is_it_drawer = false) {
        if( $count > 0 ) {
            $count *= $cabinet_count;
            $index_key = "{$door_id}|{$width}X{$height}";

            if( isset($report_items[$index_key]['quantity']) ) {
                $report_items[$index_key]['quantity'] += $count;
            }
            else {
                App::import("Model", "Inventory.Door");
                $door = new Door();
                $door->recursive = -1;
                $door_info = $door->find('first', array( 'conditions' => array( 'Door.id' => $door_id ) ));
                $door_detail = $door_info['Door'];
                App::import("Model", "Inventory.Color");
                $color = new Color();
                $color->recursive = -1;
                $color_info = $color->find('first', array( 'conditions' => array( 'Color.id' => $cabinet_order['door_color'] ) ));
                $door_color_detail = $color_info['Color'];
                $color_info = $color->find('first', array( 'conditions' => array( 'Color.id' => $cabinet_order['cabinet_color'] ) ));
                $cabinet_color_detail = $color_info['Color'];

                $width_code = $this->InventoryLookupValue2Name($width);
                $width_code = empty($width_code) ? '--' : $width_code;
                $height_code = $this->InventoryLookupValue2Name($height);
                $height_code = empty($height_code) ? '--' : $height_code;
                if( $is_it_drawer ) {
                    $report_items[$index_key]['code'] = "DR{$width_code}{$height_code}";
                }
                else {
                    $height_code_door_only = $this->InventoryLookupValue2Name($height);
                    if( !is_null($height_code_door_only) ) {
                        $height_code = $height_code_door_only;
                        $height_code = empty($height_code) ? '--' : $height_code;
                    }
                    $report_items[$index_key]['code'] = "DO{$width_code}{$height_code}";
                }

                $report_items[$index_key]['cabinet_color'] = $cabinet_color_detail['name'];
                $report_items[$index_key]['door_style'] = $door_detail['door_style'];
                $report_items[$index_key]['door_color'] = $door_color_detail['name'];
                $report_items[$index_key]['outside_profile'] = $door_detail['outside_profile'];
                $report_items[$index_key]['router_cope'] = $door_detail['router_cope'];
                $report_items[$index_key]['router_panel'] = $door_detail['router_panel'];
                $report_items[$index_key]['wood_species'] = $this->InventoryLookupReverse($door_detail['wood_species']);

                $report_items[$index_key]['quantity'] = $count;
                $report_items[$index_key]['width'] = $width;
                $report_items[$index_key]['height'] = $height;

                $report_items[$index_key]['stile_quantity'] = $report_items[$index_key]['quantity'] * 2;
                $report_items[$index_key]['stile_width'] = $door_detail['door_stile_width'];
                if( !$is_it_drawer || ($is_it_drawer && ($height >= 170)) ) {
                    $report_items[$index_key]['stile_height'] = $height + $door_detail['door_stile_offset'];
                }
                else {
                    $report_items[$index_key]['stile_height'] = $height + $door_detail['drawer_stile_offset'];
                }

                $report_items[$index_key]['rail_quantity'] = $report_items[$index_key]['quantity'] * 2;
                $report_items[$index_key]['rail_width'] = $door_detail['door_rail_width'];
                if( !$is_it_drawer || ($is_it_drawer && ($height >= 170)) ) {
                    $report_items[$index_key]['rail_height'] = $report_items[$index_key]['height'] + $door_detail['door_rail_offset'];
                }
                else {
                    $report_items[$index_key]['rail_height'] = $height + $door_detail['drawer_rail_offset'];
                }


                $report_items[$index_key]['panel_quantity'] = $report_items[$index_key]['quantity'];
                $report_items[$index_key]['panel_width'] = $report_items[$index_key]['width'] + $door_detail['door_panel_width_offset'];
                if( !$is_it_drawer || ($is_it_drawer && ($height >= 170)) ) {
                    $report_items[$index_key]['panel_height'] = $report_items[$index_key]['height'] + $door_detail['door_panel_height_offset'];
                }
                else {
                    $report_items[$index_key]['panel_height'] = $height + $door_detail['drawer_panel_height_offset'];
                }
            }
        }
    }

    function getPaymentMethod($opt = null) {
        $d = array( "Cash" => "Cash", "Cheque" => "Cheque", "Credit Card" => "Credit Card", "On Account" => "On Account" );
        return $opt == null ? $d : $d[$opt];
    }

    function getDoorSide($opt = null) {
        $d = array( "Left" => "L", "Right" => "R", "Left-Glass" => "LG", "Right-Glass" => "RG", "Top" => "T", "Bottom" => "B", "Top-Glass" => "TG", "Bottom-Glass" => "BG" );
        return $opt == null ? $d : $d[$opt];
    }

    function getItemMaterialForReport($id = null) {
        App::import("Model", "Inventory.MaterialGroup");
        $MaterialGroup_model = new MaterialGroup();
        return $MaterialGroup_model->find("first", array( 'conditions' => array( 'MaterialGroup.id' => $id ) ));
    }

    function getReceivedStatus($opt = null) {
        $d = array( Open_PO => "Open", 1 => "Received", 2 => "Partial Received" );
        return $opt == null ? $d : $d[$opt];
    }

    function getTimeList() {
        APP::import("Model", "Inventory.LookupHour");
        $LookupHour = new LookupHour();
        $data = $LookupHour->find("list", array(
            "fields" => array( "LookupHour.hours", "LookupHour.hours" ),
                ));
        return $data;
    }

    function getDoorDrilling($opt = null) {
        $d = array( "1" => "Standard", "2" => "Do not Drill", "3" => "Drill Top", "4" => "Drill Bottom" );
        return $opt == null ? $d : $d[$opt];
    }

    function getDoorDrillingForQuote($opt = null) {
        $d = array( "Standard" => "Standard", "Do not Drill" => "Do not Drill", "Drill Top" => "Drill Top", "Drill Bottom" => "Drill Bottom" );
        return $opt == null ? $d : $d[$opt];
    }

    function findCustomer($id) {
        App::uses("Customer", "CustomerManager.Model");
        $Customer_model = new Customer();
        $customer->recursive = 0;
        $customers = $Customer_model->find("first", array( 'conditions' => array( 'Customer.id' => $id ) ));

        return $customers['Customer']['last_name'];
    }

    function getProjectName($id = null) {
        App::import('Model', 'CustomerManager.BuilderProject');
        $BuilderProjectModel = new BuilderProject();
        $BuilderProject = $BuilderProjectModel->find('first', array( 'conditions' => array( 'BuilderProject.id' => $id ) ));
        return $BuilderProject['BuilderProject']['project_name'];
    }

    function getQuoteForCornJob($id = null) {
        App::import('Model', 'QuoteManager.Quote');
        $Quote_Model = new Quote();

        $quote = $Quote_Model->find("first", array( "conditions" => array( "Quote.id" => $id ) ));
        return $quote;
    }

    function getQuoteStatusForCornJob($id = null) {
        App::import('Model', 'QuoteManager.QuoteStatus');
        $QuoteStatus_Model = new QuoteStatus();

        $quote_status = $QuoteStatus_Model->find('all', array( 'conditions' => array( 'QuoteStatus.quote_id' => $id ) ));
        return $quote_status;
    }

    function getSkidDescrition($num = null) {
        App::import('Model', 'ContainerManager.SkidInventory');
        $SkidInventory_Model = new SkidInventory();

        $data = $SkidInventory_Model->find('first', array( 'conditions' => array( 'SkidInventory.skid_no' => $num ) ));
        return $data['SkidInventory']['description'];
    }

    function getDoorStyleImg($door_style = null) {
        App::import('Model', 'Inventory.Door');
        $Door_Model = new Door();

        $data = $Door_Model->find('first', array( 'conditions' => array( 'Door.door_style' => $door_style ) ));
        return $data['Door']['door_image'];
    }

    function barCodeImageGenerator($code = null) {
        App::uses('BarcodeHelper', 'Vendor');
        $data_to_encode = $code;

        $barcode = new BarcodeHelper();

        // Generate Barcode data
        $barcode->barcode();
        $barcode->setType('UPC');
        $barcode->setCode($data_to_encode);
        $barcode->setSize(80, 100);
        $barcode->hideCodeType();
        $barcode->setText($text = '');

        // Generate filename           
        $random = rand(0, 1000000);
        $file = 'img/barcode/code_' . $random . '.png';

        // Generates image file on server           
        $barcode->writeBarcodeFile($file);
        return 'barcode/code_' . $random . '.png';
    }

    function getEdgeTapeForCabParts($id = null, $code = null) {
        App::import('Model', 'Inventory.ItemsOption');
        $ItemsOption_Model = new ItemsOption();

        $data = $ItemsOption_Model->find('first', array( 'conditions' => array( 'ItemsOption.item_id' => $id ) ));
        if(!empty($data)){
            return $code;
        }
        else {
            return "";
        }
    }

}

?>
