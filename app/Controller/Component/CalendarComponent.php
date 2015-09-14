<?php

App::uses('Component', 'Controller');

class CalendarComponent extends Component {

  public function dataFormat($type = null, $data = array(), $calendarData = array()) {

//    App::import('Component','QuoteItem');
//    $t = new QuoteItemComponent();
//    debug($t);exit;
		App::import('Model','ScheduleManager.ScheduleColor');
    $ScheduleColorModel = new ScheduleColor();
		
    $index = count($calendarData);
    if ($type == 'Service') {
			$color_data = $ScheduleColorModel->find('first',array('conditions' => array('ScheduleColor.type' =>"Service")));
      foreach ($data as $item) {
        $calendarData[$index]['id'] = $item['ServiceEntry']['id'];
        $calendarData[$index]['title'] = 'Work Order: ' . $item['WorkOrder']['work_order_number'];
        $calendarData[$index]['start'] = $item['ServiceEntry']['created'];
        $calendarData[$index]['end'] = $item['ServiceEntry']['booked_for'];
        $calendarData[$index]['allDay'] = false;
        $calendarData[$index]['color'] = "#".$color_data['ScheduleColor']['bgcolor'];

        $description = "<table class='tooltip-table'>";
        $description .= "<tr><th><lable>Work order: </label></th><td>" . $item['WorkOrder']['work_order_number'] . "</td></tr>";
        $description .= "<tr><th><lable>Booked for: </label></th><td>" . $this->formatDate($item['ServiceEntry']['created']) . "</td></tr>";
        $description .= "<tr><th><lable>Resolved: </label></th><td>" . $this->formatDate($item['ServiceEntry']['resolved_on']) . "</td></tr>";
        $description .= "<tr><th><lable>Created by: </label></th><td>" . $item['User']['first_name'] . ' ' . $item['User']['last_name'] . "</td></tr>";
        $description .= "<tr><th><lable>Created date: </label></th><td>" . $this->formatDate($item['ServiceEntry']['created']) . "</td></tr>";
        $description .= "<tr><th><lable>Status: </label></th><td>" . $item['ServiceEntry']['status'] . "</td></tr>";
        $description .= "</table>";

        $calendarData[$index]['description'] = $description;
        $index++;
      }
    }elseif($type == 'Installation') {
			$color_data = $ScheduleColorModel->find('first',array('conditions' => array('ScheduleColor.type' =>"Installation")));
      foreach ($data as $item) {
        $number_of_days = 0;
        if($item['InstallerSchedule']['number_of_days']>0)
          $number_of_days = $item['InstallerSchedule']['number_of_days']-1;
        
        $calendarData[$index]['id'] = $item['InstallerSchedule']['id'];
        $calendarData[$index]['title'] = 'Work Order: ' . $item['WorkOrder']['work_order_number'];
        $calendarData[$index]['start'] = $item['InstallerSchedule']['start_install'];
        $calendarData[$index]['end'] = date('Y-m-d', strtotime("+{$number_of_days} days", strtotime($item['InstallerSchedule']['start_install'])));
        $calendarData[$index]['allDay'] = true;
        $calendarData[$index]['color'] = "#".$color_data['ScheduleColor']['bgcolor'];

        $description = "<table class='tooltip-table'>";
        $description .= "<tr><th><lable>Work order: </label></th><td>" . $item['WorkOrder']['work_order_number'] . "</td></tr>";
        $description .= "<tr><th><lable>Name: </label></th><td>" . $item['InstallerSchedule']['name'] . "</td></tr>";
        $description .= "<tr><th><lable>Address: </label></th><td>" . $this->address_format($item['InstallerSchedule']['address'],$item['InstallerSchedule']['city'],$item['InstallerSchedule']['province'],$item['InstallerSchedule']['country'],$item['InstallerSchedule']['postal_code']) . "</td></tr>";
        $description .= "<tr><th><lable>Installer: </label></th><td>" . $item['Installer']['name_lookup_id'] . "</td></tr>";
        $description .= "<tr><th><lable>Status: </label></th><td>" . $item['InstallerSchedule']['status'] . "</td></tr>";
        $description .= "</table>";

        $calendarData[$index]['description'] = $description;
        $index++;
      }
    }elseif($type == 'Appointment') {
			$color_data = $ScheduleColorModel->find('first',array('conditions' => array('ScheduleColor.type' =>"Appointment")));
      foreach ($data as $item) {        
        
        $calendarData[$index]['id'] = $item['Appointment']['id'];
        $calendarData[$index]['title'] = 'Work Order: ' . $item['WorkOrder']['work_order_number'];
        $calendarData[$index]['start'] = $item['Appointment']['start_date'];
        $calendarData[$index]['end'] = $item['Appointment']['end_date'];
        $calendarData[$index]['allDay'] = false;
        $calendarData[$index]['color'] = "#".$color_data['ScheduleColor']['bgcolor'];

        $description = "<table class='tooltip-table'>";
        $description .= "<tr><th><lable>Work order: </label></th><td>" . $item['WorkOrder']['work_order_number'] . "</td></tr>";
        $description .= "<tr><th><lable>Address: </label></th><td>" . $this->address_format($item['Appointment']['address'],$item['Appointment']['city'],$item['Appointment']['province'],$item['Appointment']['country'],$item['Appointment']['postal_code']) . "</td></tr>";
        $description .= "</table>";

        $calendarData[$index]['description'] = $description;
        $index++;
      }
    }

    return $calendarData;
  }

  public function dateFormat($date_time) {
    if ($date_time == null)
      return "N/A";
    if (strcmp($date_time, "0000-00-00") == 0 || strcmp($date_time, "0000-00-00 00:00:00") == 0)
      return "N/A";
    $str = strtotime($date_time);

    $result_date_time = date("d/m/Y", $str);

    return $result_date_time;
  }

  public function formatDate($date_time) {
    return self::dateFormat($date_time);
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
  function dbFormatDate($date) {

    $exp = explode("/", $date);

    $year = $month = $day = 0;

    if (isset($exp[2]))
      $year = $exp[2];
    if (isset($exp[1]))
      $month = $exp[1];
    if (isset($exp[0]))
      $day = $exp[0];

    $date = strtotime($year . "-" . $month . "-" . $day);

    return date("Y-m-d", $date);
  }
}

