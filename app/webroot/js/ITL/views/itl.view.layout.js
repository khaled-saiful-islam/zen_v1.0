/**
 * ITL.view.layout.js
 * @package js/ITL/views
 * @class ITL.views
 * @author Md.Rajib-Ul-Islam<mdrajibul@gmail.com>
 * used for common layout event .
 *
 */
ITL.view.layout = function() {
    var viewPanel = undefined;
    var thisClass;

    /**
     * Initially load in layout functionality
     */
    function initialLoad() {
        $('ul.sf-menu').superfish({
            delay:       500,
            animation:   {opacity:'show',height:'show'},
            speed:       'slow',
            autoArrows:  true,
            dropShadows: false
        });
        $('.toolTipCls').tooltip();
        ITL.view.datePicker($(".datepicker"));
    }

    return {
        init:function() {
            initialLoad();
        }
    }
}();
/**
 * Window onLoad function call by calling layout init function call
 */
$(function() {
    ITL.view.layout.init();
});