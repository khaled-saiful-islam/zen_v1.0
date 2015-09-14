var invoice_year = '';
var invoice_month = '';
var invoice_date = '';
var target_value = "";
$(function() {
  $('.invoice-status-link').live('click',function(){

    $('#invoice_status_div').toggle('slow');
  });
  $('.invoice-status-link-cancel').live('click',function(){
    $('#invoice_status_div').toggle('slow');
  });
  $('.invoice-status-option').live('change',function(){
    value = $(this).val();
    if(value=="Approve")
      target_value = "#MainContent";
  });
});
function customRange(a) {
  var b = new Date();
  var c = new Date(invoice_year, invoice_month, invoice_date);
  console.log(invoice_year);
  console.log(invoice_month);
  console.log(invoice_date);
  return {
    minDate: c
  }
}
function set_value(year,month,date){
  invoice_year = year;
  invoice_month = month;
  invoice_date = date;
}