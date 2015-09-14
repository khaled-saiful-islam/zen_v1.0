/**
 * This prototype is used for application related JS  related functionality
 * @author md.rajib-Ul-Islam<rajib@instalogic.com>
 */
var AppJS = function(){
  var dialog;// global dialog instance
  var dialogDefaults ={
    //        title:"View Details",
    modal:true,
    width:450,
    position:'center',
    loadingText:'Loading...'
  }
  return {
    getDialog:function(el,options,callBack){
      if(options){
        $.extend(dialogDefaults, options, true)
      }
      $(el).bind("click",function(){
        ajaxStart();
        var href = $(this).attr("href");
        if(!dialog){
          dialog = $("<p id='detailDialog'>"+dialogDefaults.loadingText+"</p>").dialog({
            title:dialogDefaults.title,
            modal:dialogDefaults.modal,
            width:dialogDefaults.width,
            position:dialogDefaults.position
          });
          ajaxStop();
        }else{
          dialog.dialog("open");
          dialog.html(dialogDefaults.loadingText);
          ajaxStop();
        }
        $.ajax({
          url : href,
          success:function(data){
            dialog.html(data);
            if(callBack && $.isFunction(callBack)){
              callBack();
            }
            ajaxStop();
          }
        })
        return false;

      })
    }

  }
}();


