<?php
/**
 * @desc This class contain all the common features
 */
App::uses("AppHelper", "View/Helper");

class UtilHelper extends AppHelper {
    /**
     * @desc Make the date format
     */
    function dateFormat($date_time) {
        if ($date_time == null) return "N/A";
        if (strcmp($date_time, "0000-00-00") == 0 || strcmp($date_time, "0000-00-00 00:00:00") == 0) return "N/A";
        $str = strtotime($date_time);

        $result_date_time = date("d/m/Y", $str);

        return $result_date_time;

    }

    function formatDate($date_time) {
        return self::dateFormat($date_time);
    }

    /**
     * @desc Make the date and time format
     */
    function dateTimeFormat($date_time) {
        if ($date_time == null) return "N/A";
        $str = strtotime($date_time);

        $result_date_time = date("d/m/Y, H:i a", $str);

        return $result_date_time;

    }

    /**
     * @desc Used for seperater text
     */
    function getSeperatorText($arr, $seperator = "##") {
        return implode($seperator, $arr);
    }

    /**
     * @desc Used for seperator Array
     */
    function getSeperatorArray($str, $delimiter = "##") {
        return explode($delimiter, $str);
    }

      /**
     * @desc Make array to text
     * @param: $arr contain lits of items array
     * @param: $seperator ## to put each itam
     * @return text
     * @input: array('test', 'test2, 'test3)
     * @output: test##test2##test3
     */

    function getImploade($arr, $seperator = "##") {
        if (is_array($arr))
            return implode($seperator, $arr);
        return "";
    }

    /**
     * @desc It make the array from text
     * @param 1: String
     * @param 2: Delimiter or Seperator
     */
    function getExploade($str, $delimiter = "##") {
        return explode($delimiter, $str);
    }

    /**
     * @desc Different between two dates
     */
    function dateDifference($start_date, $end_date) {
        $diff = abs(strtotime($start_date) - strtotime($end_date));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));

        $y = ($years == 0) ? "" : $years . " year";
        $m = ($months == 0) ? "" : (($months == 1) ? $months . " month" : $months . " months");
        $d = ($days == 0) ? "" : (($days == 1) ? $days . " day" : $days . " days");
        $h = ($hours == 0) ? "" : (($hours == 1) ? $hours . " hour" : $hours . " hours");

        return $y . " " . $m . " " . $d . " " . $h;
    }

    /**
     * @desc Used for makeing url
     * @param: array of controller and action
     */
    function getURL($url = null) {
        $url = $this->url($url);
        return $url;
    }


    /**
     * @desc used to get Total date of a Month
     */
    function getTotalDateOfMonth($month, $year = "") {
        if ($month == 2) {
            return $this->checkLeapYear($year) ? 28 : 29;
        }
        else
        {
            switch ($month)
            {
                case 1:
                    return 31;
                case 3:
                    return 31;
                case 4:
                    return 30;
                case 5:
                    return 31;
                case 6:
                    return 30;
                case 7:
                    return 31;
                case 8:
                    return 31;
                case 9:
                    return 30;
                case 10:
                    return 31;
                case 11:
                    return 30;
                case 12:
                    return 31;
            }
        }
    }

    /**
     * @desc Used for checking leapyear
     */
    function checkLeapYear($year) {
        if ($year % 4) {
            if ($year % 100) {
                if ($year % 400) return true;
                else return false;
            }
            else return true;
        }
        else return false;
    }

    /**
     * @desc Get Status Text
     */
    function statusText($opt) {
        return ($opt == ACTIVE) ? ACTIVE_TEXT : INACTIVE_TEXT;
    }

    /**
     * @desc Make the Array to Serialized to insert array into database
     * @param: Array
     */
    function getSerialized($data) {
        return serialize($data);
    }

    /**
     * @desc  After fetching data using serialized we need to make it undserilazed
     * @param: Fetched string from the database or Serialize data
     */
    function getUnSerialized($data) {
        return unserialize($data);
    }

    /**
     * @desc Get the image type default is thumb
     * @param $data : Database field image array which is serialized
     * @param $type : Type of iamge is it resized, thumb or orifinal version
     * @param $path : Database Field image path
     */
    function getImage($data, $type = IMG_THUMB, $path = IMG_PATH) {


        $photo = $this->getUnSerialized($data);

        if (empty($photo)) {
            return $this->webroot . "img/noimage.png";
        } else {
            return $photo[$path] . $photo[$type];
        }
    }

    /**
     * @desc Showing Schedule Array
     */
    function showing_schedule_array() {

        $week = array(SUN, MON, TUES, WED, THURS, FRI, SAT);
        $wday = array("12:00", "12:30", "01:00", "01:30", "02:00", "02:30", "03:00", "03:30", "04:00", "04:30", "05:00", "05:30", "06:00", "06:30", "07:00", "07:30", "08:00", "08:30", "09:00", "09:30", "10:00", "10:30", "11:00", "11:30");

        $day = array();
        // Put AM
        $i = 0;
        foreach ($wday as $d) {
            $day[$i++] = $d . " am";
        }
        foreach ($wday as $d) {
            $day[$i++] = $d . " pm";
        }

        $data = array();
        foreach ($day as $d) {
            foreach ($week as $w) {
                $data[$d][$w] = 0;
            }
        }
        return $data;
    }

    /**
     * @desc Extrat the name to array
     * @param: Time String
     * @return : Array with hour, min, meridian
     */
    function extractTime($time) {

        $pattarn = "/([0-9]{2}):([0-9]{2}) ([a-z]{2})/";
        preg_match($pattarn, $time, $regs);
        $hour = isset($regs[1]) ? $regs[1] : "12";
        $min = isset($regs[2]) ? $regs[2] : "00";
        $merdian = isset($regs[3]) ? $regs[3] : "";

        return array("hour" => $hour, "min" => $min, "meridian" => $merdian);
    }

    /**
     * Camelize a (-,_) related string to uppercase first String
     * @author MD.Rajib-Ul-Islam<rajib@instalogic.com>
     * @param  $str
     * @param $splitType - (_,-)
     * @return string
     */
    function toCamelize($str, $splitType = "-") {
        $modStr = "";
        if ($str) {
            $exStr = explode($splitType, $str);
            if (is_array($exStr)) {
                foreach ($exStr as $eStr) {
                    $modStr .= ucfirst($eStr);
                }
            }
        }
        return $modStr;
    }

    /**
     * remove slash and and line break if need to giver string
     * @author MD.Rajib-Ul-Islam<rajib@instalogic.com>
     * @param  $str
     * @return string
     */
    function toStrips($str) {
        if ($str) {
            return htmlspecialchars_decode(stripslashes($str));
        } else {
            return "";
        }
    }

    function formatCurrency($number) {
      return number_format((double)$number, 2, '.', ',');
    }
}
