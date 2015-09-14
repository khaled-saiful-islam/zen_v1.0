$(function() {
	
//  $('#container_items table .add-more').live("click", function(){
//    newRow = addRow(this);
//    fixCabinetsItemRow(newRow);
//  });
//	
//	$('#container_items table .remove').live("click", function(element){
//    element.preventDefault();
//    removeRow(this);
//  });
	
});

//function fixCabinetsItemRow(jqElement) {
//  parent = jqElement.parents('table');
//  clone_rows = parent.find('.clone-row');
//  last_row = $(clone_rows[clone_rows.length - 2]);//CabinetsItem0ItemId
//  index = last_row.find('input.skid_no').attr('id').split('ContainerSkid')[1].split('SkidNo')[0]; // index of the last valid row name element
//  index++;  //new index for new item
//
//  jqElement.removeClass('hide'); // make it visible
//
//  // remove select2 garbage
//  jqElement.find('.select2-container').remove();
//
//  // set index properly
//  jqElement.find('input.skid_no').attr('name', 'data[ContainerSkid][' + index + '][skid_no]');
//  jqElement.find('input.skid_no').attr('id', 'ContainerSkid' + index + 'SkidNo');
//  jqElement.find('input.skid_no').val('');
//  jqElement.find('input.skid_no').addClass('required');
//
//  jqElement.find('td.workorder').html('');
//  jqElement.find('td.weight').html('');
//
//  // set select2 functionality
//  //select2forCabinetItems(jqElement.find("input.item_id"), jqElement.find('input.accessories').val());
//}
