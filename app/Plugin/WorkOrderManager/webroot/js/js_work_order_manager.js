var wo_year = '';
var wo_month = '';
var wo_date = '';
var target_value = "";
$(function() {
  $('.wo-status-link').live('click',function(){
    $('#wo_status_div').toggle('slow');
  });
  $('.wo-status-link-cancel').live('click',function(){
    $('#wo_status_div').toggle('slow');
  });
  $('.wo-status-option').live('change',function(){
    value = $(this).val();
    if(value=="Approve")
      target_value = "#MainContent";
  });
});
function customRange(a) {  
  var b = new Date();  
  var c = new Date(wo_year, wo_month, wo_date);
  console.log(wo_year);
  console.log(wo_month);
  console.log(wo_date);
  return {  
    minDate: c  
  }  
}  
function set_value(year,month,date){
  console.log(year);
  wo_year = year;
  wo_month = month;
  wo_date = date;
}