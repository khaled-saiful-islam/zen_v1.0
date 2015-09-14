<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Commonjs
 *
 * @author Sarwar Hossain <http://instalogic.com>
 */
class CommonjsHelper extends AppHelper{
      
    function validate($opt, $vmsg = "")
    {
     //return "";   
        switch($opt)
        {
            case "username": return "{required:true, minlength:6, remote: '".Dispatcher::baseUrl()."/common_ajax_request/isUniqueUser/', messages:{required:'".V_USERNAME."', minlength:'".V_USERNAME_LENGTH."', remote: '".V_USERNAME_ALREDY_EXISTS."' }}";
            case "Password": return "{required:true, minlength:6, messages:{required:'".V_PASSWORD."', minlength:'".V_PASSWORD_LENGTH."'}}";
            
            case "Office": return "{required:true, messages:{required:'".V_OFFICE."'}}";

            case "Required": return "{required:true, messages:{required:'This field is required'}}";
            case "noMSG": return "{required:true, messages:{required:''}}";
            
            case "Price": return "{required:true, messages:{required:'".V_PRICE."'}}";
            
            case "maxLength": return "{maxlength:true, messages:{required:''}}";

            case "enddate": return "{enddate:true}";
            
            # COMMON USED 
            case "Client": return "{required:true, messages:{required:'Client Name is required'}}";
            case "Title": return "{required:true, messages:{required:'".V_TITLE."'}}";
            case "Description": return "{required:true, messages:{required:'Description is required'}}";
            case "Client": return "{required:true, messages:{required:'Client is required'}}";
            case "Phone": return "{required:true, messages:{required:'Phone number is required'}}";
            case "Status": return "{required:true, messages:{required:'".V_STATUS."'}}";
            case "Name": return "{required:true, messages:{required:'Name is required'}}";
            case "FirstName": return "{required:true, messages:{required:'".V_FIRSTNAME."'}}";
            case "LasttName": return "{required:true, messages:{required:'".V_LASTNAME."'}}";
            case "Role": return "{required:true, messages:{required:'".V_ROLE."'}}";
            case "Status": return "{required:true, messages:{required:'".V_STATUS."'}}";
            case "Rmail": return "{required:true, email:true, messages:{required:'Email is required'}}";
            case "OnlyEmail": return "{email:true, messages:{email: '".EMAIL_VALID."'}}";
            case "Address": return "{required:true, messages:{required:'Address is required'}}";
            case "City": return "{required:true, messages:{required:'City is required'}}";
            case "Province": return "{required:true, messages:{required:'Province is required'}}";
            case "Country": return "{required:true, messages:{required:'Country is required'}}";
            case "Sex": return "{required:true, messages:{required:'Sex is required'}}";
            case "Type": return "{required:true, messages:{required:'".V_TYPE."'}}";
            case "Manager": return "{required:true, messages:{required:'Manager is required'}}";
            case "Code": return "{required:true, messages:{required:'Code is required'}}";
            case "Date": return "{required:true, messages:{required:'".V_DATE."'}}";
            case "DigitOnly": return "{number: true, messages:{number: '".V_ONLY_NUMBER."' }}"; 
            case "OnlyDigit": return "{number: true, messages:{number: '".V_ONLY_NUMBER."' }}"; 
            case "URL": return "{url: true, messages:{url: '".V_URL."' }}"; 
            case "Image": return "{accept:'jpg|jpeg|png|bmp|gif', messages:{accept:'".V_IMG_FORMAT."'}}"; 
            case "SEO_URL": return "{SEO_URL: true, messages:{SEO_URL: '".V_SEO_URL."' }}"; 
            case "Broker": return "{required: true, messages:{number: '".V_BROKER."' }}";                 
            
                
            
            
            
            default: return "{required:true, messages:{required:'".V_COMMON."'}}";
            
            
        }
    }
    function remote_validate($url, $type)
    {
        
       switch($type){
            case "User": return "{required:true, minlength:6, remote: '$url', messages:{required:'".V_USERNAME."', minlength:'".V_USERNAME_LENGTH."', remote: '".V_USERNAME_ALREADY_EXISTS."' }}"; 
            case "Internal_Listing": return "{required: true, number: true, remote: '".$url."', messages:{required: '".V_LISTING_NO."', number: '".V_ONLY_NUMBER."', remote: '".V_LISTING_NO_ALREADY_EXISTS."' }}"; 
       }
    }
    function validate_depend($opt, $depend_opt = "true")
    {

        switch($opt)
        {
            
        }
    }

    /**
    * @desc Sime Ajax Loading
    */
    function ajax_load($url = null, $opt = "", $msg_div=null){
        $url = $this->url($url);
        return $this->output("ajax_load('$url','$opt', '$msg_div')");
    }
    /**
    * @desc Ajax Loading After confirm
    */
    function ajax_load_after_confirm($url = null, $opt = "", $msg_div=null, $msg = "Are you sure?"){
        $url = $this->url($url);
        $confirm = 'var c = confirm("'.$msg.'"); if(c == false) return;';
        return $this->output($confirm." ajax_load('$url','$opt', '$msg_div')");
    }

    // Only used for ajax loading
    function ajax_load_dropdown($url = null, $value, $opt = "")
    {
        $url = $this->url($url);
        return $this->output("ajax_load_dropdown('$url', $value, '$opt')");
    }
    
    function ajax_append($url = null, $div_id = "", $loading_div = "")
    {
        $url = $this->url($url);
        return $this->output("ajax_append('$url','$div_id','$loading_div')");

    }

                                       //turl, value, field_id, load_id
    function ajax_set_text_field_value($url = null, $value, $field_id, $loading_div = "")
    {
        $url = $this->url($url);
        return $this->output("ajax_set_text_field_value('$url',$value, '$field_id', '$loading_div')");

    }

    function getSmallMessage($text)
    {
        return $this->output("<script>\$(document).ready(function() {      
                                                \$('#msginfo')
                                                 .insertAfter( \$(this) )
                                                 .fadeIn('slow')
                                                 .animate({opacity: 1.0}, 2500)
                                                 .fadeOut('slow', function() {
                                                    \$(this).remove();
                                                    });        
                                                    });
                               </script>
                                                    ".
                               '<div class="small_message" id="msginfo">'.$text.'</div>');
    }
    
   
   
   /**
   * @desc Generate Text box with date picker options
   * @param 1: attribute array 
   *           Examile: $attr = array(
   *                                   "name" => "data[ClassName][fieldName]",
   *                                   "id" => ""
   *                                   "size" => "",
   *                                   "value" =>"",
   *                                    ... .... .... 
   *                                    ... .... .... 
   *                                 );
   * @param 2: Date Picker array();
   *            Example: $picker_options = array(
   *                                            "changeMonth" => "true",
   *                                            "dateFormat" => "dd/mm/yy",
   *                                            "yearRange" => "1990:2022",
   *                                            );
   * SEE MORE OPTION HERE http://jqueryui.com/demos/datepicker/#date-formats
   */
    function datePicker($attr = array(), $picker_options = array())
    {
        /*
        // Default values 
        $other_attr = array("type" => "text", "size" => 15, "name" => "datePickerName", "id" => "datePickerId", "value" => "");
        
        // Overwrite default values
        $attr = array_merge($other_attr, $attr);
        
        $id = $attr['id'];
                                                                                                 
        $field = "<input "; 
        
        foreach($attr as $key=>$value){
            $field .= $key."= \"".$value."\" ";
        }
        $field .= "/>";
        
        
        $startYear = '1930';
        $nextYear = date("Y")+5;
        
        $button_image = ' showOn: "button", buttonImage: "'.Dispatcher::baseUrl().'/img/calendar.gif" , buttonImageOnly: true';
        
        $options = array("changeMonth: true", "changeYear: true", "dateFormat: 'dd/mm/yy'", "yearRange: '$startYear:$nextYear', $button_image ");
        
        $options = array_merge($options, $picker_options);
        $options = implode(",", $options);
        
        return $this->output($field."\n<script>\$(document).ready(function() {      
                                                                \$('#$id').datepicker({ 
                                                                $options
                                                                });
                                                    });
                               </script>"
                             );
    */
    }
    
    /**
    * @desc This method generate the popup
    */
    function openDialog($div_id , $the_title, $the_height = 600, $the_width = 800, $the_modal = 'true', $the_autoOpen = 'false', $the_show = "blind", $the_hide = "blind"  )
    {
        $parames = "";
        return $this->output("open_dialog('$div_id', '$the_title', '$the_height', '$the_width', '$the_modal', '$the_autoOpen', '$the_show', '$the_hide' )");
    }
    
 function openAjaxDialog($url, $div_id , $the_title, $the_height = 600, $the_width = 800, $the_modal = 'true', $the_autoOpen = 'false', $the_show = "blind", $the_hide = "blind"  )
    {
        $url = $this->url($url);     
        $parames = "";
        return $this->output("open_dialog_ajax('$url', '$div_id', '$the_title', '$the_height', '$the_width', '$the_modal', '$the_autoOpen', '$the_show', '$the_hide' )");
    }
    
    function redirect($url = null)
    {
        $url = $this->url($url);
        return $this->output("window.location='".$url."'");
    }
    function redirectDropDown($url, $opt)
    {
        $url = $this->url($url);
        return $this->output("redirectDropDown('".$url."', $opt)");
    }
    
    function validateForm($formId, $custom_options = array())
    {
        
        $options = array(
                           'errorElement' => "'div'",
                           'errorClass' => "'error'"
                           //'validClass' => "'valid'"
                         );
        
        
        $options = array_merge($options, $custom_options);
        
        $i = 0;
        $opt = "";
        foreach($options as $key => $value){
            if($i > 0) $opt .=",\n";
            $opt .= $key." : ".$value;
            $i++;
            
        }
        
        
        $str = '<script type="text/javascript">
                    $(document).ready(function() {
                    $("#'.$formId.'").validate({
                            '.$opt.'
                    });
                    }); 
               </script>';
        return $this->output($str);
    }    
    
    function open_popup($url, $title, $custom_option = array()){
        
        $url = $this->url($url);
        
        $options = array("width" => "1000", "height" => "600","top" => "50", "left" => "50", "toolbars" => "no", "scrollbars" => "yes","status" => "no", "resiable" => "yes");
        $options = array_merge($options, $custom_option);
        
        $opt = array();
        foreach($options as $key=>$value){
            $opt[] = $key."=".$value;
        }
        $options = implode(",", $opt);
  
        
        return $this->output("open_popup('$url','$title', '$options')");
    }
 
    /**
    * @desc Generate Javascrpt with cach option for Autocomplete
    * @param $url: The request URL
    * @param $txt_fild_id: The typing field id where you need to show the label
    * @param $hidden_fld_id: The hidden field id where you keep id of selected item
    * @return: The generated script
    * 
    * @response type ajax: json_encode(  array( 
    *                                  array("id" => "222", "value" => "22992", "label" => "The Name"),
    *                                  array("id" => "222", "value" => "22992", "label" => "The Name"),
    *                                   )
    *                               )   
    */
    function autocomplete($url, $txt_fld_id, $hidden_fld_id){
    
        $msg = '    
        <script>
        $(function() {
            var cache = {},
                lastXhr;
            $( "#'.$txt_fld_id.'" ).autocomplete({
                minLength: 2,
                source: function( request, response ) {
                    var term = request.term;
                    if ( term in cache ) {
                        response( cache[ term ] );
                        return;
                    }
                    
                    lastXhr = $.getJSON( "'.$url.'", request, function( data, status, xhr ) {
                        cache[ term ] = data;
                        if ( xhr === lastXhr ) {
                            response( data );
                        }
                    });
                },
                select: function(event, ui){  
                    $("#'.$hidden_fld_id.'").val(ui.item.id);
                        
                    $("#agent_name_auto").html(ui.item.value);
                }
            });
        });    
        </script>
        ';
        return $this->output($msg);
    }
    
}

?>
