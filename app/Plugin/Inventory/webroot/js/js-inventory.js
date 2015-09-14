$(function() {
  // calculate item price based on cost and factor
  $('.item-cost-calculation .item-cost, .item-cost-calculation .item-factor').live("change", function(){
    calculateItemPrice(this);
  });

  // item notes dynamic add/remove section
  $('#item_notes table .add-more').live("click", function(){
    newRow = addRow(this);
    fixItemNotesRow(newRow);
  });
  $('#item_notes table .remove').live("click", function(element){
    element.preventDefault();
    removeRow(this);
  });

  // cabinet items dynamic add/remove section
  $('#cabinet_items table .add-more').live("click", function(){
    newRow = addRow(this);
    fixCabinetsItemRow(newRow);
  });
  $('#cabinet_items table .remove').live("click", function(element){
    element.preventDefault();
    removeRow(this);
  });

  // cabinet items dynamic add/remove section
  $('#cabinet_installations table .add-more').live("click", function(){
    newRow = addRow(this);
    fixCabinetsInstallationRow(newRow);
  });
  $('#cabinet_installations .remove').live("click", function(element){
    element.preventDefault();
    removeRow(this);
  });

  // color dynamic add/remove section
  $('.color-form .color-section .add-more').live("click", function(){
    newRow = addFieldsetRow(this);
    fixColorSectionMaterialRow(newRow);
  });
  $('.color-form .color-section .color-section-material .remove').live("click", function(element){
    element.preventDefault();
    removeFieldsetRow(this);
  });

  $('.form-select-ajax-item-cabinet-item').live("change", function(e) {
    current_row = $(this).parents('tr.clone-row');
    $.ajax(BASEURL + "inventory/items/item_json", {
      data: {
        term: e.val // item id
      },
      dataType: "json"
    }).done(function(data) {
      cost = data.detail.price;
      quantity = current_row.find('input.item_quantity').val();
      price = cost * quantity;
      current_row.find('.description').html(data.detail.description);
      current_row.find('.department').html(data.complete_detail.ItemDepartment.name);
      current_row.find('.cost').html(cost);
      current_row.find('.price').html(price);
    });
  });

});

function calculateItemPrice(element) {
  parent = $(element).parents('.item-cost-calculation');
  cost = parent.find('.item-cost').val();
  factor = parent.find('.item-factor').val();
  price = parseFloat(cost * factor).toFixed(2);
  parent.find('.item-price').val(price);
}

function addRow(element) {
  parent = $(element).parents('table');
  clone = parent.find('.clone-row:first').clone().insertAfter(parent.find('.clone-row:last'));
  clone.find('.text input.user-input').val('');
  clone.find('.remove').removeClass('hide');
  return clone;
}

function addFieldsetRow(element) {
  parent = $(element).parent('fieldset');
  clone = parent.find('fieldset.color-section-material:first').clone().insertAfter(parent.find('fieldset.color-section-material:last'));
  clone.find('.text input.user-input').val('');
  clone.find('.remove').removeClass('hide');
  return clone;
}

function removeRow(element) {
  $(element).parents('tr').remove();
}

function removeFieldsetRow(element) {
  $(element).parents('fieldset.color-section-material').remove();
}

function fixItemNotesRow(jqElement) {
  parent = jqElement.parents('table');
  clone_rows = parent.find('.clone-row');
  last_row = $(clone_rows[clone_rows.length - 2]);
  index = last_row.find('input.name').attr('id').split('ItemNote')[1].split('Name')[0]; // index of the last valid row name element
  console.log(index);
  index++;  //new index for new item
  console.log(index);


  // set index properly
  jqElement.find('input.name').attr('name', 'data[ItemNote][' + index + '][name]');
  jqElement.find('input.name').attr('id', 'ItemNote' + index + 'Name');
  jqElement.find('input.name').val('');

  jqElement.find('input.value').attr('name', 'data[ItemNote][' + index + '][value]');
  jqElement.find('input.value').attr('id', 'ItemNote' + index + 'Value');
  jqElement.find('input.value').val('');

  jqElement.find('input.note_date').attr('name', 'data[ItemNote][' + index + '][note_date]');
  jqElement.find('input.note_date').attr('id', 'ItemNote' + index + 'NoteDate');
  jqElement.find('input.note_date').val('');
  jqElement.find('input.note_date').datepicker({
    dateFormat:"dd/mm/yy"
  });
}

function fixCabinetsItemRow(jqElement) {
  parent = jqElement.parents('table');
  clone_rows = parent.find('.clone-row');
  last_row = $(clone_rows[clone_rows.length - 2]);//CabinetsItem0ItemId
  index = last_row.find('input.item_id').attr('id').split('CabinetsItem')[1].split('ItemId')[0]; // index of the last valid row name element
  index++;  //new index for new item

  jqElement.removeClass('hide'); // make it visible

  // remove select2 garbage
  jqElement.find('.select2-container').remove();

  // set index properly
  jqElement.find('input.accessories').attr('name', 'data[CabinetsItem][' + index + '][accessories]');
  jqElement.find('input.accessories').attr('id', 'CabinetsItem' + index + 'Accessories');
  jqElement.find('input.accessories').addClass('required');
  jqElement.find('input.item_id').attr('name', 'data[CabinetsItem][' + index + '][item_id]');
  jqElement.find('input.item_id').attr('id', 'CabinetsItem' + index + 'ItemId');
  jqElement.find('input.item_id').val('');
  jqElement.find('input.item_id').addClass('required');
  jqElement.find('input.item_quantity').attr('name', 'data[CabinetsItem][' + index + '][item_quantity]');
  jqElement.find('input.item_quantity').attr('id', 'CabinetsItem' + index + 'ItemQuantity');
  jqElement.find('input.item_quantity').val('');
  jqElement.find('input.item_quantity').addClass('required');

  jqElement.find('td.description').html('');
  jqElement.find('td.cost').html('');
  jqElement.find('td.price').html('');

  // set select2 functionality
  select2forCabinetItems(jqElement.find("input.item_id"), jqElement.find('input.accessories').val());
}

function fixCabinetsInstallationRow(jqElement) {
  parent = jqElement.parents('table');
  clone_rows = parent.find('.clone-row');
  last_row = $(clone_rows[clone_rows.length - 2]);//CabinetsItem0ItemId
  index = last_row.find('select.inventory_lookup_id').attr('id').split('CabinetsInstallation')[1].split('InventoryLookupId')[0]; // index of the last valid row name element
  index++;  //new index for new item

  // remove select2 garbage
  jqElement.find('.select2-container').remove();

  // set index properly
  jqElement.find('select.inventory_lookup_id').addClass('required');
  jqElement.find('select.inventory_lookup_id').attr('name', 'data[CabinetsInstallation][' + index + '][inventory_lookup_id]');
  jqElement.find('select.inventory_lookup_id').attr('id', 'CabinetsInstallation' + index + 'inventory_lookup_id');
  //  jqElement.find('select.price_unit').attr('name', 'data[CabinetsInstallation][' + index + '][price_unit]');
  //  jqElement.find('select.price_unit').attr('id', 'CabinetsInstallation' + index + 'price_unit');

  jqElement.find('td.description').html('');
  jqElement.find('td.price').html('0');
  jqElement.find('td.price_unit').html('');

  jqElement.find('select.inventory_lookup_id').val('');
  //  jqElement.find('select.price_unit').val('');

  // set select2 functionality
  select2inCabinetInstallationType(jqElement.find("select.inventory_lookup_id"));
  //  jqElement.find("select.price_unit").select2();

  jqElement.removeClass('hide');
}

function fixColorSectionMaterialRow(jqElement) {
  //  return;
  parent = jqElement.parent('fieldset');
  clone_rows = parent.find('fieldset.color-section-material');
  last_row = $(clone_rows[clone_rows.length - 2]);//ColorSection1ColorMaterial
  index = last_row.find('select.material_id').attr('id').split('ColorSection0ColorMaterial')[1]; // check the current section door/cabinate
  type = 0;
  if(index == undefined) {
    index = last_row.find('select.material_id').attr('id').split('ColorSection1ColorMaterial')[1].split('MaterialId')[0]; // index of the last valid row name element (door)
    type = 1;
  } else {
    index = last_row.find('select.material_id').attr('id').split('ColorSection0ColorMaterial')[1].split('MaterialId')[0]; // index of the last valid row name element (cabinet)
  }
  index++;  //new index for new item

  // remove select2 garbage
  jqElement.find('.select2-container').remove();

  // set index properly
  jqElement.find('select.material_id').attr('name', 'data[ColorSection]['+ type +'][ColorMaterial][' + index + '][material_id]');
  jqElement.find('select.material_id').attr('id', 'ColorSection'+ type +'ColorMaterial' + index + 'MaterialId');
  jqElement.find('select.material_id').val('');
  jqElement.find('select.edgetape_id').attr('name', 'data[ColorSection]['+ type +'][ColorMaterial][' + index + '][edgetape_id]');
  jqElement.find('select.edgetape_id').attr('id', 'ColorSection'+ type +'ColorMaterial' + index + 'EdgeTapeId');
  jqElement.find('select.edgetape_id').val('');

  // set select2 functionality
  jqElement.find("select.material_id").select2();
  jqElement.find("select.edgetape_id").select2();
}

function select2forCabinetItems(jqElement, accessories) {
  var ajax_path = "inventory/items/get_base_item_list";
  if(accessories == '1') {
    ajax_path = "inventory/items/get_item_accessories";
  }

  jqElement.select2({
    minimumInputLength: 1,
    initSelection: function(element, callback) {
      var id=$(element).val();
      if (id!=="") {
        $.ajax(BASEURL + "inventory/items/item_json", {
          data: {
            term: id
          },
          dataType: "json"
        }).done(function(data) {
          callback(data);
        });
      }
    },
    ajax: {
      url: BASEURL + ajax_path,
      dataType: 'json',
      data: function (term, page) {
        return {
          term: term
        };
      },
      results: function (data, page) {
        return {
          results: data
        };
      }
    }
  });
}