/**
 * This prototype is used for application related JS  related functionality
 * @author md.rajib-Ul-Islam<rajib@instalogic.com>
 */
var POJS = function(){
    var dialog;// global dialog instance
    var dialogDefaults ={
        title:"Purchase Order Detail",
        modal:true,
        width:960,
        position:'top',
        loadingText:'Loading...'
    }
    return {
        getDialog:function(el,options,callBack){
            if(options){
                $.extend(dialogDefaults, options, true)
            }
            $(el).bind("click",function(){
                var href = $(this).attr("href");
                if(!dialog){
                    dialog = $("<p id='detailDialog'>"+dialogDefaults.loadingText+"</p>").dialog({
                        title:dialogDefaults.title,
                        modal:dialogDefaults.modal,
                        width:dialogDefaults.width,
                        position:dialogDefaults.position
                    });
                }else{
                    dialog.dialog("open");
                    dialog.html(dialogDefaults.loadingText);  
                }
                $.ajax({
                    url : href,
                    success:function(data){
                        dialog.html(data); 
                        if(callBack && $.isFunction(callBack)){
                            callBack();
                        }
                    }
                })
                return false;

            })
        }
        
    }
}();


