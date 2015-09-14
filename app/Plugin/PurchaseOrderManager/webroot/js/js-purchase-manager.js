var supplier_info1 = [];
var quantity_info = [];
var price_info = [];
var title_info = [];
var item_name_info = [];
var wo_po_item_total = 0.00
$(function() {
  var item_total = 0.00;
  var extra_cost = 0.00;
  var gst_value = 0.00;
  
  // cabinet items dynamic add/remove section
  $('.purchase-order-form table .add-more').live("click", function(){
    
    $("#add_order_item_po form").validate();
    $('#add_order_item_po').modal();
    $('#add_order_item_po .quantity').val('');
    $('#add_order_item_po select.code').val('');
  });  
  $('#add_order_item_po select.po-code').live('change',function(){
    //console.log($(this).val());
    
    description = $(this).parents('table').find("select.description option[value='"+$(this).val()+"']").text();
    price = $(this).parents('table').find("select.price option[value='"+$(this).val()+"']").text();
    
    $("#item_description").val(description);
    $("#item_price").val(price);
  });
  
  $('.purchase-order-form table .remove').live("click", function(element){
    element.preventDefault();    
    tmp_total = $(this).parent('td').parent('tr').find('.data-per-item-total-cost').html();
    tmp_sub_total = $(this).parent('td').parent('tr').parent('tbody').find('.data-item-total-cost').html();
    removeRow(this);
    item_total= (parseFloat(tmp_sub_total)-parseFloat(tmp_total)).toFixed(2);
    
		var amount_edit = 0;
		
		var ship = parseFloat($('.shipping').val());
		var sub = parseFloat(item_total);
		var gst = parseFloat($('.po_gst').val());
		var pst = parseFloat($('.po_pst').val());
		
		var real_gst = parseFloat(sub * (gst/100));
		var real_pst = parseFloat(sub * (pst/100));
		
		amount_edit = ship + sub + real_gst + real_pst;
		
		$('#total_amount_for_item').html(amount_edit.toFixed(2));
		$('.total_amount_for_po').val(amount_edit.toFixed(2));
		
    $('.data-item-total-cost').html(item_total);
		$('#row_remove_item').val(item_total);
    $('.order-sub-total').val(item_total);
		
    var supplier_gst = parseInt($('.supplier_gst').val());
    var supplier_pst = parseInt($('.supplier_pst').val());
    tmp_supplier_gst = parseFloat(item_total*supplier_gst/100).toFixed(2);
    tmp_supplier_pst = parseFloat(item_total*supplier_pst/100).toFixed(2);
    total_am = +item_total + +tmp_supplier_gst + +tmp_supplier_pst;
    //total_am = +total_am + tmp_supplier_pst;
    //console.log(tmp_supplier_gst);
    //console.log(tmp_supplier_pst);
    //console.log(total_am);
    $('.total_amount').val(total_am);
  });
  
 
 
  $('#add_order_item_po .save').live("click", function(element){
    $("#add_order_item_po form").valid();
    if($('#add_order_item_po .quantity').hasClass('valid') && ($('#add_order_item_po select.po-code').val() != ''))  {
    
      // clone row
      newRow = addRowHiddenPO('.purchase-order-form table .add-more');
      fixCabinetOrderItemRowPO(newRow);
    
      quantity = parseInt($('#add_order_item_po .quantity').val());
      item_code = $('#add_order_item_po select.po-code').val();
      item_cost = parseFloat($('#add_order_item_po .item-price').val()).toFixed(2);
      per_item_total_cost = parseFloat(item_cost*quantity).toFixed(2);
      item_title = $('#add_order_item_po .item-description').val();
      item_code_text = $('#add_order_item_po select.po-code option:selected').text();  
      
      var item_arr = item_code.split('|');
      item_id = (item_arr[1]=='item')?item_arr[0]:0;
      cabite_id = (item_arr[1]=='cabinet')?item_arr[0]:0;
      door_id = (item_arr[1]=='door' || item_arr[1]=='drawer' || item_arr[1]=='wall_door')?item_arr[0]:0;
      
      // reset the form elements for future use
      $("#add_order_item_po input[type='text']").val('');
      $('#add_order_item_po select').val('');
      
      // set public value
      newRow.find('.data-quantity').html(quantity);
      newRow.find('.data-code').html(item_code_text);
      newRow.find('.data-each-cost').html(item_cost);
      newRow.find('.data-per-item-total-cost').html(per_item_total_cost);
      newRow.find('.data-title').html(item_title);
      item_total = item_total_cost();
      
      $('.data-item-total-cost').html(item_total);
			$('#row_remove_item').html(item_total);
			$('#row_remove_item').val(item_total);
      
      $('.order-sub-total').val(item_total);
      var supplier_gst = parseInt($('.supplier_gst').val());
      var supplier_pst = parseInt($('.supplier_pst').val());
      if(isNaN(supplier_gst))
        supplier_gst = 0;
      if(isNaN(supplier_pst))
        supplier_pst = 0; 
      //console.log(supplier_gst);
      //console.log(supplier_pst);
      tmp_supplier_gst = parseFloat(item_total*supplier_gst/100).toFixed(2);
      tmp_supplier_pst = parseFloat(item_total*supplier_pst/100).toFixed(2);
      total_am = +item_total + +tmp_supplier_gst + +tmp_supplier_pst;
      total_am = +total_am + +tmp_supplier_pst;
      //console.log(tmp_supplier_gst);
      //console.log(tmp_supplier_pst);
      //console.log(total_am);
      $('.total_amount').val(parseFloat(total_am).toFixed(2));
      
      //$('input.total-cost').val(total_cost_with_gst());
      
      // set index properly
      newRow.find('input.quantity').val(quantity);
      newRow.find('input.code').val(item_code);
      newRow.find('.data-each-cost').html(item_cost);
      newRow.find('input.purchse_order_id').val('');
      newRow.find('input.item_id').val(item_id);
      newRow.find('input.cabinet_id').val(cabite_id);
      newRow.find('input.door_id').val(door_id);
  
      // close modal
      $('#add_order_item_po form')[0].reset();
      $('#add_order_item_po').modal('hide');
    }
  });
  
  /*------------------------------------ set supplier info -------------------------------------*/
  $('.supplier-select').live('change',function(element){
    main_elm = this;
    supplier_id = $(main_elm).val();
		
    if (supplier_id in supplier_info) {
			console.log();
      //console.log(supplier_info[supplier_id].name);
      //console.log($(main_elm).parents('fieldset').find('table input.supplier_gst'));
      $(main_elm).parents('fieldset').find('table .supplier_name').html(supplier_info[supplier_id].name);
      $(main_elm).parents('fieldset').find('table .supplier_email').html(supplier_info[supplier_id].email);
      $(main_elm).parents('fieldset').find('table .supplier_phone').html(supplier_info[supplier_id].phone);
      $(main_elm).parents('fieldset').find('table .supplier_address').html(supplier_info[supplier_id].address);
      $(main_elm).parents('fieldset').find('table input.supplier_gst').val(supplier_info[supplier_id].gst);
      $(main_elm).parents('fieldset').find('table input.supplier_pst').val(supplier_info[supplier_id].pst);
      
      var item_show = []
      index = 0;
      //console.log($('.item-row-po table').find('.clone-row:first').nextAll('tr.clone-row'));
      $('.item-row-po table').find('.clone-row:first').nextAll('tr.clone-row').remove();
      wo_po_item_total = 0.00;
      $.each(supplier_info[supplier_id].item, function(key,value){
        if (value in quantity_info) {
          item_show[index++] = value;
          genarate_item_row(value);
          $(main_elm).parents('fieldset').find('table input.order-sub-total').val(parseFloat(wo_po_item_total).toFixed(2));
          gst_cost = wo_po_item_total*supplier_info[supplier_id].gst/100;
          pst_cost = wo_po_item_total*supplier_info[supplier_id].pst/100;
          total_cost = parseFloat(+ wo_po_item_total + gst_cost + pst_cost).toFixed(2);
          $(main_elm).parents('fieldset').find('table input.total_amount').val(total_cost);
        }
      });
      
      if(item_show.length<=0){
        $(main_elm).parents('fieldset').find('table .supplier_name').html('');
        $(main_elm).parents('fieldset').find('table .supplier_email').html('');
        $(main_elm).parents('fieldset').find('table .supplier_phone').html('');
        $(main_elm).parents('fieldset').find('table .supplier_address').html('');
        $(main_elm).parents('fieldset').find('table input.supplier_gst').val('');
        $(main_elm).parents('fieldset').find('table input.supplier_pst').val('');
      
        $('.item-row-po table').find('.clone-row:first').nextAll('tr.clone-row').remove();
      
        $(main_elm).parents('fieldset').find('table input.order-sub-total').val('');          
        $(main_elm).parents('fieldset').find('table input.total_amount').val('');
      
        alert('This supplier have no items for this work order');
      }
    }else{
      $(main_elm).parents('fieldset').find('table .supplier_name').html('');
      $(main_elm).parents('fieldset').find('table .supplier_email').html('');
      $(main_elm).parents('fieldset').find('table .supplier_phone').html('');
      $(main_elm).parents('fieldset').find('table .supplier_address').html('');
      $(main_elm).parents('fieldset').find('table input.supplier_gst').val('');
      $(main_elm).parents('fieldset').find('table input.supplier_pst').val('');
      
      $('.item-row-po table').find('.clone-row:first').nextAll('tr.clone-row').remove();
      
      $(main_elm).parents('fieldset').find('table input.order-sub-total').val('');          
      $(main_elm).parents('fieldset').find('table input.total_amount').val('');
      //      
      alert('This supplier have no items for this work order');
    }
  });
});
function set_customer_address(obj,serach){
  if(serach){
    $.each(obj, function(index,val_obj1){        
      $.each(val_obj1, function(index,val_obj2){
        //console.log(val_obj2.id);
        if(val_obj2.id==serach){
          $.each(val_obj2, function(index,val_obj3){          
            $('input.'+index).val(val_obj3);
          });
        }
      });
    });
  }
}
function item_total_cost(){
  total_cost = 0.00;  
  $(".data-per-item-total-cost").each(function(index,value){    
    val = parseFloat($(value).html()).toFixed(2);
    if(isNaN(val))
      val=0.00;
    total_cost = +total_cost + +val;
  });
  return parseFloat(total_cost).toFixed(2);
}

function addRowHiddenPO(element) {
  parent = $(element).parents('table');
  clone = parent.find('.clone-row:first').clone().insertAfter(parent.find('.clone-row:last'));
  clone.find('.text input.user-input').val('');
  clone.find('.text input.user-input').addClass('hide');
  clone.find('.remove').removeClass('hide');
  return clone;
}


function fixCabinetOrderItemRowPO(jqElement) {
  parent = jqElement.parents('table');
  clone_rows = parent.find('.clone-row');
  last_row = $(clone_rows[clone_rows.length - 2]);
  index = last_row.find('input.code').attr('id').split('PurchaseOrderItem')[1].split('Code')[0]; // index of the last valid row name element
  index++;  //new index for new item
  
  // set index properly
  jqElement.find('input.quantity').attr('name', 'data[PurchaseOrderItem][' + index + '][quantity]');
  jqElement.find('input.quantity').attr('id', 'PurchaseOrderItem' + index + 'ItemQuantity');
  jqElement.find('input.quantity').val('');
  
  jqElement.find('input.code').attr('name', 'data[PurchaseOrderItem][' + index + '][code]');
  jqElement.find('input.code').attr('id', 'PurchaseOrderItem' + index + 'Code');
  jqElement.find('input.code').val('');  
  
  jqElement.find('input.purchase_order_id').attr('name', 'data[PurchaseOrderItem][' + index + '][purchase_order_id]');
  jqElement.find('input.purchase_order_id').attr('id', 'PurchaseOrderItem' + index + 'PurchaseOrderItem');
  jqElement.find('input.purchase_order_id').val('');
  
  jqElement.find('input.item_id').attr('name', 'data[PurchaseOrderItem][' + index + '][item_id]');
  jqElement.find('input.item_id').attr('id', 'PurchaseOrderItem' + index + 'ItemId');
  jqElement.find('input.item_id').val('');
  
  jqElement.find('input.cabinet_id').attr('name', 'data[PurchaseOrderItem][' + index + '][cabinet_id]');
  jqElement.find('input.cabinet_id').attr('id', 'PurchaseOrderItem' + index + 'CabinetId');
  jqElement.find('input.cabinet_id').val('');
  
  jqElement.find('input.door_id').attr('name', 'data[PurchaseOrderItem][' + index + '][door_id]');
  jqElement.find('input.door_id').attr('id', 'PurchaseOrderItem' + index + 'DoorId');
  jqElement.find('input.door_id').val('');
  
  jqElement.find('.data-quantity').html('');
  jqElement.find('.data-code').html('');
  jqElement.find('.data-each-cost').html('');
  jqElement.find('.data-per-item-total-cost').html('');
  
  jqElement.removeClass('hide');
}


function genarate_item_row(item_list) {
  newRow = addRowHiddenPO('.item-row-po table .add-more');
  fixCabinetOrderItemRowPO(newRow);
  //console.log(item_list);
  //console.log(quantity_info[item_list]);
  quantity = parseInt(quantity_info[item_list]);
  item_code = item_list;
  item_cost = parseFloat(price_info[item_list]).toFixed(2);
  per_item_total_cost = parseFloat(item_cost*quantity).toFixed(2);
  item_title = title_info[item_list];
  item_code_text = item_name_info[item_list];
      
  var item_arr = item_code.split('|');
  item_id = (item_arr[1]=='item')?item_arr[0]:0;
  cabite_id = (item_arr[1]=='cabinet')?item_arr[0]:0;
  door_id = (item_arr[1]=='door' || item_arr[1]=='drawer' || item_arr[1]=='wall_door')?item_arr[0]:0;
  
  // set public value
  newRow.find('.data-quantity').html(quantity);
  newRow.find('.data-code').html(item_code_text);
  newRow.find('.data-each-cost').html(item_cost);
  newRow.find('.data-per-item-total-cost').html(per_item_total_cost);
  newRow.find('.data-title').html(item_title);
  wo_po_item_total = +wo_po_item_total + +per_item_total_cost;
  $('.data-item-total-cost').html(parseFloat(wo_po_item_total).toFixed(2));
	$('#row_remove_item').html(parseFloat(wo_po_item_total).toFixed(2));
	$('#row_remove_item').val(parseFloat(wo_po_item_total).toFixed(2));
      
  // set index properly
  newRow.find('input.quantity').val(quantity);
  newRow.find('input.code').val(item_code);
  newRow.find('.data-each-cost').html(item_cost);
  newRow.find('input.purchse_order_id').val('');
  newRow.find('input.item_id').val(item_id);
  newRow.find('input.cabinet_id').val(cabite_id);
  newRow.find('input.door_id').val(door_id);
}


(function( $ ) {
  $.widget( "ui.combobox", {
    _create: function() {
      var input,
      that = this,
      select = this.element.hide(),
      selected = select.children( ":selected" ),
      value = selected.val() ? selected.text() : "",
      wrapper = this.wrapper = $( "<span>" )
      .addClass( "ui-combobox" )
      .insertAfter( select );
 
      function removeIfInvalid(element) {
        var value = $( element ).val(),
        matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( value ) + "$", "i" ),
        valid = false;
        select.children( "option" ).each(function() {
          if ( $( this ).text().match( matcher ) ) {
            this.selected = valid = true;
            return false;
          }
        });
        if ( !valid ) {
          // remove invalid value, as it didn't match anything
          $( element )
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
          select.val( "" );
          setTimeout(function() {
            input.tooltip( "close" ).attr( "title", "" );
          }, 2500 );
          input.data( "autocomplete" ).term = "";
          return false;
        }
      }
 
      input = $( "<input>" )
      .appendTo( wrapper )
      .val( value )
      .attr( "title", "" )
      .addClass( "ui-state-default ui-combobox-input" )
      .autocomplete({
        delay: 0,
        minLength: 0,
        source: function( request, response ) {
          var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
          response( select.children( "option" ).map(function() {
            var text = $( this ).text();
            if ( this.value && ( !request.term || matcher.test(text) ) )
              return {
                label: text.replace(
                  new RegExp(
                    "(?![^&;]+;)(?!<[^<>]*)(" +
                    $.ui.autocomplete.escapeRegex(request.term) +
                    ")(?![^<>]*>)(?![^&;]+;)", "gi"
                    ), "<strong>$1</strong>" ),
                value: text,
                option: this
              };
          }) );
        },
        select: function( event, ui ) {
          ui.item.option.selected = true;
          that._trigger( "selected", event, {
            item: ui.item.option
          });
          $("#item_description").val($("#description option[value='"+ui.item.option.value+"']").text());
          $("#item_price").val($("#price option[value='"+ui.item.option.value+"']").text());
        },
        change: function( event, ui ) {
          if ( !ui.item ) {
            return removeIfInvalid( this );
          }
        }
      })
      .addClass( "ui-widget ui-widget-content ui-corner-left" );
 
      input.data( "autocomplete" )._renderItem = function( ul, item ) {
        return $( "<li>" )
        .data( "item.autocomplete", item )
        .append( "<a>" + item.label + "</a>" )
        .appendTo( ul );
      };
 
      $( "<a>" )
      .attr( "tabIndex", -1 )
      .attr( "title", "Show All Items" )
      .tooltip()
      .appendTo( wrapper )
      .button({
        icons: {
          primary: "ui-icon-triangle-1-s"
        },
        text: false
      })
      .removeClass( "ui-corner-all" )
      .addClass( "ui-corner-right ui-combobox-toggle" )
      .click(function() {
        // close if already visible
        if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
          input.autocomplete( "close" );
          removeIfInvalid( input );
          return;
        }
 
        // work around a bug (likely same cause as #5265)
        $( this ).blur();
 
        // pass empty string as value to search for, displaying all results
        input.autocomplete( "search", "" );
        input.focus();
      });
 
      input
      .tooltip({
        position: {
          of: this.button
        },
        tooltipClass: "ui-state-highlight"
      });
    },
 
    destroy: function() {
      this.wrapper.remove();
      this.element.show();
      $.Widget.prototype.destroy.call( this );
    }
  });
})( jQuery );
