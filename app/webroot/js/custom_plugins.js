(function($) {
    $.fn.ajaxLeftNav = function(contentDivId) {
        return; // disable left menu ajax;
        this.click(function(e) {
            var link = $(this).find('a').attr('href').split('/');
            //      if($(this).attr("class") == 'active') return false;
            //First Remove active from all li
            $(this).siblings().removeClass("active");
            // Reset Icons from all i under li
            $(this).siblings().children().children().removeClass("icon-white").addClass("icon-green");

            // Set li active and change the icon
            $(this).addClass("active");
            $(this).children().children().removeClass("icon-green").addClass("icon-white");

            var href = $(this).children().attr("href");
            var cls_name = $(this).attr('class').split(' ');

            ajaxStart();
            $(contentDivId).slideUp('slow');
            //      $(contentDivId).slideUp("fast", function(){
            $.ajax({
                url: href,
                type: 'get',
                async: false,
                data: null,
                success: function(data) {
                    $(contentDivId).html(data);
                    ajaxStop();
                },
                error: function(data) {
                    showAjaxError(contentDivId, data);
                    ajaxStop();
                },
                complete: function() {
                    $('.toolTipCls').tooltip()
                    $('.dateP #PatientDob').datepicker({
                        //dateFormat:"dd-mm-yy",
                        changeYear: true,
                        changeMonth: true
                    });
                    ajaxStop();
                }
            });
            //      });

            $(contentDivId).slideDown("slow");

            return false;
        });


        // properly set active item in left nav bar in inventory section during page load
        $(this).parent().find('.active a i').removeClass("icon-green").addClass("icon-white");
    };

})(jQuery);


$(function() {
    // ajax section
    //  $(this).ajaxStart(function() {
    //    $('#AjaxLoadingModal').modal('show');
    //  });
    //  $(this).ajaxStop(function() {
    //    $('#AjaxLoadingModal').modal('hide');
    //    initialization();
    //  });

    // initialize at very first and recurrent in ajax stop
    initialization();

    tabbed_form_page_next();
    ajaxLink();
    openLink();
    askDelete();

    $('.site-address-same').live('click', function() {
        if ($(this).is(':checked')) {
            $('.site-address').hide();
        } else {
            $('.site-address').show();
        }
    });

    //  $('.search_link').live('click', function() {
    //    $('#search_div').toggle('slow');
    //  });

    // Javascript to enable link to tab
    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs a[href=#' + url.split('#')[1] + ']').tab('show');
    }

    // Change hash for page-reload
    $('.nav-tabs a').on('shown', function(e) {
        window.location.hash = e.target.hash;
    })
});

function ajaxStart() {
    $('#AjaxLoadingModal').modal('show');
}
function ajaxStartOrder() {
    $('#AjaxLoadingModalOrder').modal('show');
}
function ajaxStopOrder() {
    $('#AjaxLoadingModalOrder').modal('hide');
    initialization();
}
function ajaxStartSubmit(){
    $('#AjaxLoadingModalSubmit').modal('show');
}
function ajaxStopSubmit() {
    $('#AjaxLoadingModalSubmit').modal('hide');
    initialization();
}
function ajaxStop() {
    $('#AjaxLoadingModal').modal('hide');
    initialization();
}
function initialization() {
    AppJS.getDialog($(".modal_ajax_jq_ui_detail"), {
        width: 800,
        my: "top",
        at: "center",
        of: window
    });

    $('a.show-tooltip').tooltip();

    $(".multiselect").multiselect({
        sortable: false
    });
    $(".dateP").datepicker({
        dateFormat: "dd/mm/yy"
    });
    $('select.form-select').select2({
        //placeholder:"Select One"
        allowClear: true
    });
    $('select.form-select-min-input').select2({
        minimumInputLength: 1
    });
    $('.form-select-ajax-base-item').select2({
        minimumInputLength: 1,
        initSelection: function(element, callback) {
            var id = $(element).val();
            if (id !== "") {
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
            url: BASEURL + "inventory/items/get_base_item_list",
            dataType: 'json',
            data: function(term, page) {
                return {
                    term: term
                };
            },
            results: function(data, page) {
                return {
                    results: data
                };
            }
        }
    });
    $('.form-select-ajax-item-accessories').select2({
        minimumInputLength: 1,
        initSelection: function(element, callback) {
            var id = $(element).val();
            if (id !== "") {
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
            url: BASEURL + "inventory/items/get_item_accessories",
            dataType: 'json',
            data: function(term, page) {
                return {
                    term: term
                };
            },
            results: function(data, page) {
                return {
                    results: data
                };
            }
        }
    });
    $('.form-select-ajax-item').select2({
        minimumInputLength: 1,
        initSelection: function(element, callback) {
            var id = $(element).val();
            if (id !== "") {
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
            url: BASEURL + "inventory/items/get_item_list",
            dataType: 'json',
            data: function(term, page) {
                return {
                    term: term
                };
            },
            results: function(data, page) {
                return {
                    results: data
                };
            }
        }
    });
    $('.form-select-ajax-item-edgetape').select2({
        minimumInputLength: 1,
        initSelection: function(element, callback) {
            var id = $(element).val();
            if (id !== "") {
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
            url: BASEURL + "inventory/items/get_item_edgetape",
            dataType: 'json',
            data: function(term, page) {
                return {
                    term: term
                };
            },
            results: function(data, page) {
                return {
                    results: data
                };
            }
        }
    });
    $('.form-select-ajax-cabinet').select2({
        minimumInputLength: 1,
        initSelection: function(element, callback) {
            var id = $(element).val();
            if (id !== "") {
                $.ajax(BASEURL + "inventory/cabinets/cabinet_json", {
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
            url: BASEURL + "inventory/cabinets/get_cabinet_list",
            dataType: 'json',
            data: function(term, page) {
                return {
                    term: term
                };
            },
            results: function(data, page) {
                return {
                    results: data
                };
            }
        }
    });
    $('.form-select-ajax-all-type-item').select2({
        minimumInputLength: 1,
        initSelection: function(element, callback) {
            var id = $(element).val();
            if (id !== "") {
                var resource_parts = id.split('|');
                var resource_url = 'inventory/cabinets/cabinet_json';
                if(resource_parts[1] == 'item') {
                    resource_url = 'inventory/items/item_json';
                }
                $.ajax(BASEURL + resource_url, {
                    data: {
                        term: resource_parts[0]
                    },
                    dataType: "json"
                }).done(function(data) {
                    intelligentSelectionQuoteOptions(data);
                    callback(data);
                });
            }
        },
        ajax: {
            url: BASEURL + "quote_manager/quotes/get_all_type_item_list",
            dataType: 'json',
            data: function(term, page) {
                return {
                    term: term
                };
            },
            results: function(data, page) {
                return {
                    results: data
                };
            }
        }
    });
    $('select.select-item-material-group').select2({
        }).on("change",
        function(e) {
            ajaxStart();
            $.ajax({
                url: BASEURL + "inventory/materials/get_material_list_by_material_group?term=" + e.val,
                type: 'get',
                async: false,
                data: null,
                dataType: 'json',
                success: function(data) {
                    $('select.select-item-material')
                    .find('option')
                    .remove()
                    .end();
                    $("select.select-item-material").append('<option value=""></option>');
                    $.each(data, function(index, value) {
                        $("select.select-item-material").append('<option value="' + value.id + '">' + value.text + '</option>');
                    });
                    ajaxStop();
                },
                error: function(data) {
                    $('select.select-item-material')
                    .find('option')
                    .remove()
                    .end();
                    $("select.select-item-material").append('<option value=""></option>');
                    ajaxStop();
                }
            });
        }
        );
    $('select.form-select-multiple').select2({
        multiple: true
    });
    $('.phone-mask').mask('(000) 000-0000');
//$("input[type=text]").ezpz_hint();
}

function intelligentSelectionQuoteOptions(data) {
    if (data.item_type == 'item') {
        $('#CabinetOrderBasicDetailForm .door-style').hide();
        $('#CabinetOrderBasicDoorStyle').val('');
        $('#CabinetOrderBasicDetailForm .door-side').hide();
        $('#CabinetOrderBasicDoorSide').val('');
        $('#CabinetOrderBasicDetailForm .door-color').hide();
        $('#CabinetOrderBasicDoorColor').val('');
    //          $('#CabinetOrderBasicDetailForm .cabinet-color').hide();
    } else {
        $('#CabinetOrderBasicDetailForm .door-style').show();
        $('#CabinetOrderBasicDetailForm .door-color').show();
        $('#CabinetOrderBasicDetailForm .door-side').show();
    //          $('#CabinetOrderBasicDetailForm .cabinet-color').show();
    }

    if (data.door_count <= 0) {
        $('#CabinetOrderBasicDetailForm .door-style').hide();
        $('#CabinetOrderBasicDoorStyle').val('');
        $('#CabinetOrderBasicDetailForm .door-side').hide();
        $('#CabinetOrderBasicDoorSide').val('');
        $('#CabinetOrderBasicDetailForm .door-color').hide();
        $('#CabinetOrderBasicDoorColor').val('');
        $('#CabinetOrderBasicDetailForm .door-side').hide();
        $('#CabinetOrderBasicDoorSide').val('');
    } else {
        $('#CabinetOrderBasicDetailForm .door-style').show();
        $('#CabinetOrderBasicDetailForm .door-color').show();
        $('#CabinetOrderBasicDetailForm .door-side').show();
    }

    $('#quote_color_required').html(data.quote_color_required);
    $('#quote_material_required').html(data.quote_material_required);
}

function calculateQuotePrice(addRow) {
    if(!validateCalculationCriteria()) {
        return;
    }
    ajaxStart();
    var quote_id = $('#current_quote_id').val();
    var resource = $('#CabinetOrderBasicResourceId').val();
    var resource_quantity = $('#CabinetOrderBasicResourceQuantity').val();
    var cabinet_color = $('#CabinetOrderBasicCabinetColor').val();
    var material_id = $('#CabinetOrderBasicMaterialId').val();
    var door_id = $('#CabinetOrderBasicDoorStyle').val();
    var door_color = $('#CabinetOrderBasicDoorColor').val();
    var drawer_id = $('#GlobalDrawer').val();
    var drawer_slide = $('#GlobalDrawerSlide').val();
    var delivery_option = $('#GlobalDelivery').val();
    var door_side = $('#CabinetOrderBasicDoorSide').val();
    var door_drilling = $('#CabinetOrderBasicDoorDrilling').val();
    var customer_id = $('#CabinetOrderBasicCustomerId').val();

    $.ajax({
        type: "POST",
        url: BASEURL + "quote_manager/quotes/calculate_cabinet_price",
        dataType: 'json',
        data: {
            quote_id: quote_id,
            resource: resource,
            resource_quantity: resource_quantity,
            cabinet_color: cabinet_color,
            material_id: material_id,
            door_id: door_id,
            door_color: door_color,
            drawer_id: drawer_id,
            drawer_slide: drawer_slide,
            delivery_option: delivery_option,
            door_side : door_side,
            door_drilling : door_drilling,
            customer_id : customer_id
        }
    }).done(function(cabinet_quote_price_detail) {
        //    $('#debug-data').html(cabinet_quote_price_detail.debug_calculation);
        if (addRow) {
            $('#cabinet-list tbody').append(cabinet_quote_price_detail.new_row);
            //console.log($('#CabinetOrderBasicResourceQuantity').reset());
            var reset_value = 1;
            $('#CabinetOrderBasicResourceQuantity').val(reset_value);
        }
        ajaxStop();
    });
}

function calculateCustomPanel(addRow) {
    //  ajaxStart();
    var error_class = 'error';
    var validation_success = true;
    var quote_id = $('#current_quote_id').val();
    var height = $('#CabinetOrderCustomPanelHeight').val();
    var width = $('#CabinetOrderCustomPanelWidth').val();
    var color_id = $('#CabinetOrderCustomPanelColorId').val();
    var material_id = $('#CabinetOrderCustomPanelMaterialId').val();
    var edgetape = $('#CabinetOrderCustomPanelEdgetape').val();

    if(!(height.length > 0)) {
        $('#CabinetOrderCustomPanelHeight').addClass(error_class);
        validation_success = false;
    } else {
        $('#CabinetOrderCustomPanelHeight').removeClass(error_class);
    }

    if(!(width.length > 0)) {
        $('#CabinetOrderCustomPanelWidth').addClass(error_class);
        validation_success = false;
    } else {
        $('#CabinetOrderCustomPanelWidth').removeClass(error_class);
    }

    if(!(edgetape.length > 0)) {
        $('#CabinetOrderCustomPanelEdgetape').addClass(error_class);
        validation_success = false;
    } else {
        $('#CabinetOrderCustomPanelEdgetape').removeClass(error_class);
    }

    if(!(color_id.length > 0)) {
        $('#s2id_CabinetOrderCustomPanelColorId').addClass(error_class);
        validation_success = false;
    } else {
        $('#s2id_CabinetOrderCustomPanelColorId').removeClass(error_class);
    }

    if(!(material_id.length > 0)) {
        $('#s2id_CabinetOrderCustomPanelMaterialId').addClass(error_class);
        validation_success = false;
    } else {
        $('#s2id_CabinetOrderCustomPanelMaterialId').removeClass(error_class);
    }

    if(!validation_success) {
        return validation_success;
    }

    $.ajax({
        type: "POST",
        url: BASEURL + "quote_manager/quotes/calculate_custom_panel",
        dataType: 'json',
        data: {
            quote_id: quote_id,
            height: height,
            width: width,
            color_id: color_id,
            material_id: material_id,
            edgetape: edgetape
        }
    }).done(function(custom_panel_detail) {
        //    $('#debug-data').html(cabinet_quote_price_detail.debug_calculation);
        if (addRow) {
            $('#cabinet-list tbody').append(custom_panel_detail.new_row);
        }
        ajaxStop();
    });

    return validation_success;
}

function calculateCustomDoor(addRow) {
    //  ajaxStart();
    var error_class = 'error';
    var validation_success = true;
    var quote_id = $('#current_quote_id').val();
    var height = $('#CabinetOrderCustomDoorHeight').val();
    var width = $('#CabinetOrderCustomDoorWidth').val();
    var color = $('#CabinetOrderCustomDoorColor').val();
    var door_id = $('#CabinetOrderCustomDoorDoor').val();

    if(!(height.length > 0)) {
        $('#CabinetOrderCustomDoorHeight').addClass(error_class);
        validation_success = false;
    } else {
        $('#CabinetOrderCustomDoorHeight').removeClass(error_class);
    }

    if(!(width.length > 0)) {
        $('#CabinetOrderCustomDoorWidth').addClass(error_class);
        validation_success = false;
    } else {
        $('#CabinetOrderCustomDoorWidth').removeClass(error_class);
    }

    if(!(door_id.length > 0)) {
        $('#s2id_CabinetOrderCustomDoorDoor').addClass(error_class);
        validation_success = false;
    } else {
        $('#s2id_CabinetOrderCustomDoorDoor').removeClass(error_class);
    }

    if(!(color.length > 0)) {
        $('#s2id_CabinetOrderCustomDoorColor').addClass(error_class);
        validation_success = false;
    } else {
        $('#s2id_CabinetOrderCustomDoorColor').removeClass(error_class);
    }

    if(!validation_success) {
        return validation_success;
    }

    $.ajax({
        type: "POST",
        url: BASEURL + "quote_manager/quotes/calculate_custom_door",
        dataType: 'json',
        data: {
            quote_id: quote_id,
            height: height,
            width: width,
            color: color,
            door_id: door_id
        }
    }).done(function(custom_door_detail) {
        //    $('#debug-data').html(cabinet_quote_price_detail.debug_calculation);
        if (addRow) {
            $('#cabinet-list tbody').append(custom_door_detail.new_row);
        }
        ajaxStop();
    });

    return validation_success;
}
function CustomFormQuote(addRow) {
    //  ajaxStart();
    var error_class = 'error';
    var validation_success = true;
    var first_name = $('#CustomerFirstName').val();
    var last_name = $('#CustomerLastName').val();
    var phone = $('#CustomerPhone').val();
    var sales_person = $('#CustomerSalesRepresentatives').val();
    var type = $('#CustomerType').val();

    var cnt = first_name.length + last_name.length;	
	
    if(!(first_name.length > 0)) {
        $('#CustomerFirstName').addClass(error_class);
        validation_success = false;
    } else {
        $('#CustomerFirstName').removeClass(error_class);
    }
	
    if(!(last_name.length > 0)) {
        $('#CustomerLastName').addClass(error_class);
        validation_success = false;
    } else {
        $('#CustomerLastName').removeClass(error_class);
    }

    if(!(phone.length > 0)) {
        $('#CustomerPhone').addClass(error_class);
        validation_success = false;
    } else {
        $('#CustomerPhone').removeClass(error_class);
    }

    if(sales_person) {
        $('#s2id_CustomerSalesRepresentatives').removeClass(error_class);    
    } else {
        $('#s2id_CustomerSalesRepresentatives').addClass('customer-form-error');
        validation_success = false;
    }
	
    if((cnt < 7)) {
        $('#CustomerFirstName').addClass(error_class);
        $('#CustomerLastName').addClass(error_class);
        $('.error-message-customer').show();
        validation_success = false;
    } else {
        $('#CustomerFirstName').removeClass(error_class);
        $('#CustomerLastName').removeClass(error_class);
        $('.error-message-customer').hide();
    }

    if(!validation_success) {
        return validation_success;
    }

    $.ajax({
        type: "POST",
        url: BASEURL + "quote_manager/quotes/saveCustomerForm",
        dataType: 'json',
        data: {
            first_name: first_name,
            last_name: last_name,
            phone: phone,
            sales_person: sales_person,
            type: type
        }
    }).done(function(success) {
        if (addRow) {
            $('#add-custom-panel-modal').modal('hide');

            $('#QuoteCustomerId').append($('<option></option>').val(success.value).html(success.name));
            $('#QuoteCustomerId').select2().select2('val',success.value);
        }
    });

    return validation_success;
}

function BuilderProject(addRow) {
  
    var error_class = 'error';
    var validation_success = true;
    var project_name = $('#BuilderProjectProjectName').val();
    var site_address = $('#BuilderProjectSiteAddress').val();
    var city = $('#BuilderProjectCity').val();
    var province = $('#BuilderProjectProvince').val();
    var postal_code = $('#BuilderProjectPostalCode').val();
    var country = $('#BuilderProjectCountry').val();
    var contact_person = $('#BuilderProjectContactPerson').val();
    var phone = $('#BuilderProjectContactPersonPhone').val();
    var cell = $('#BuilderProjectContactPersonCell').val();
    var m_f_p = $('#BuilderProjectMultiFamilyPricing').val();
    var customer_id = $('#BuilderProjectCustomerId').val();
    var comment = $('#BuilderProjectComment').val();
	
    if(!(project_name.length > 0)) {
        $('#BuilderProjectProjectName').addClass(error_class);
        validation_success = false;
    } else {
        $('#BuilderProjectProjectName').removeClass(error_class);
    }
	
    if(!(site_address.length > 0)) {
        $('#BuilderProjectSiteAddress').addClass(error_class);
        validation_success = false;
    } else {
        $('#BuilderProjectSiteAddress').removeClass(error_class);
    }

    if(!(contact_person.length > 0)) {
        $('#BuilderProjectContactPerson').addClass(error_class);
        validation_success = false;
    } else {
        $('#BuilderProjectContactPerson').removeClass(error_class);
    }
	
    if(!(phone.length > 0)) {
        $('#BuilderProjectContactPersonPhone').addClass(error_class);
        validation_success = false;
    } else {
        $('#BuilderProjectContactPersonPhone').removeClass(error_class);
    }

    if(!validation_success) {
        return validation_success;
    }

    $.ajax({
        type: "POST",
        url: BASEURL + "customer_manager/builder_projects/add",
        dataType: 'json',
        data: {
            project_name: project_name,
            site_address: site_address,
            city: city,
            province: province,
            postal_code: postal_code,
            country: country,
            contact_person: contact_person,
            phone: phone,
            cell: cell,
            m_f_p: m_f_p,
            customer_id: customer_id,
            comment: comment
        }
    }).done(function(success) {

        if (addRow) {
            $('#add-project-modal').modal('hide');
            $('#QuoteProjectId').append($('<option></option>').val(success.value).html(success.title));
            $('#QuoteProjectId').select2().select2('val',success.value);
        }
    });
	
    return validation_success;
}

function BuilderProjectOnBuilderSction(addRow) {
  
    var error_class = 'error';
    var validation_success = true;
    var project_name = $('#BuilderProjectProjectName').val();
    var site_address = $('#BuilderProjectSiteAddress').val();
    var city = $('#BuilderProjectCity').val();
    var province = $('#BuilderProjectProvince').val();
    var postal_code = $('#BuilderProjectPostalCode').val();
    var country = $('#BuilderProjectCountry').val();
    var contact_person = $('#BuilderProjectContactPerson').val();
    var phone = $('#BuilderProjectContactPersonPhone').val();
    var cell = $('#BuilderProjectContactPersonCell').val();
    var m_f_p = $('#BuilderProjectMultiFamilyPricing').val();
    var customer_id = $('#BuilderProjectCustomerId').val();
    var comment = $('#BuilderProjectComment').val();
	
    if(!(project_name.length > 0)) {
        $('#BuilderProjectProjectName').addClass(error_class);
        validation_success = false;
    } else {
        $('#BuilderProjectProjectName').removeClass(error_class);
    }
	
    if(!(site_address.length > 0)) {
        $('#BuilderProjectSiteAddress').addClass(error_class);
        validation_success = false;
    } else {
        $('#BuilderProjectSiteAddress').removeClass(error_class);
    }

    if(!(contact_person.length > 0)) {
        $('#BuilderProjectContactPerson').addClass(error_class);
        validation_success = false;
    } else {
        $('#BuilderProjectContactPerson').removeClass(error_class);
    }
	
    if(!(phone.length > 0)) {
        $('#BuilderProjectContactPersonPhone').addClass(error_class);
        validation_success = false;
    } else {
        $('#BuilderProjectContactPersonPhone').removeClass(error_class);
    }

    if(!validation_success) {
        return validation_success;
    }

    $.ajax({
        type: "POST",
        url: BASEURL + "customer_manager/builder_projects/add",
        dataType: 'json',
        data: {
            project_name: project_name,
            site_address: site_address,
            city: city,
            province: province,
            postal_code: postal_code,
            country: country,
            contact_person: contact_person,
            phone: phone,
            cell: cell,
            m_f_p: m_f_p,
            customer_id: customer_id,
            comment: comment
        }
    }).done(function(success) {

        if (addRow) {
            window.location.reload();
        }
    });
	
    return validation_success;
}

function select_own_db_data(fe_class, data) {
    $('.' + fe_class).select2({
        initSelection: function(element, callback) {
            var data = {
                id: element.val(),
                text: element.val()
            };
            callback(data);
        },
        createSearchChoice: function(term, data) {
            if ($(data).filter(function() {
                return this.text.localeCompare(term) === 0;
            }).length === 0) {
                return {
                    id: term,
                    text: term
                };
            }
        },
        data: data
    });
}

function work_order_job_title(element, data, select_data) {
    preload_data = data;
    $(element).select2({
        //    multiple: true,
        query: function(query) {
            var data = {
                results: []
            };
            $.each(preload_data, function() {
                if (query.term.length == 0 || this.text.toUpperCase().indexOf(query.term.toUpperCase()) >= 0) {
                    data.results.push({
                        id: this.id,
                        text: this.text
                    });
                }
            });

            query.callback(data);
        }
    });

    $(element).select2('data', select_data);
}

function ajaxLink() {
    // bind for once only
    $('a.ajax-main-content, a.show-detail-ajax, a.show-list-ajax, a.show-add-ajax, a.show-edit-ajax').live('click', function(event) {
        event.preventDefault();
        ajaxMainContent($(this).attr("href"));
    });

    $('a.ajax-sub-content').live('click', function(event) {
        event.preventDefault();
        ajaxSubContent($(this).attr("data-target"), $(this).attr("href"));
    });

    $('a.show-detail-ajax-modal').live('click', function(event) {
        event.preventDefault();
        ajaxModalContent($(this).attr("href"));
    });
}

function ajaxMainContent(target_url) {
    contentDivId = '#MainContent';
    ajaxStart();
    $(contentDivId).slideUp('slow');
    $.ajax({
        url: target_url,
        type: 'get',
        async: false,
        data: null,
        success: function(data) {
            $(contentDivId).html(data);
            ajaxStop();
        },
        error: function(data) {
            showAjaxError(contentDivId, data);
            ajaxStop();
        }
    });

    $(contentDivId).slideDown("slow");
}

function ajaxModalContent(target_url) {
    contentDivId = '#ModalContent';
    $.ajax({
        url: target_url,
        type: 'get',
        async: false,
        data: null,
        success: function(data) {
            $(contentDivId).html(data);
            $(contentDivId).modal('show');
        },
        error: function(data) {
            showAjaxError(contentDivId, data);
        }
    });
}

function ajaxSubContent(contentDivId, target_url) {
    //  contentDivId = '.show-tab-edit-ajax';
    ajaxStart();
    $(contentDivId).slideUp('slow');
    $.ajax({
        url: target_url,
        type: 'get',
        async: false,
        data: null,
        success: function(data) {
            $(contentDivId).html(data);
            ajaxStop();
        },
        error: function(data) {
            showAjaxError(contentDivId, data);
            ajaxStop();
        }
    });

    $(contentDivId).slideDown("slow", function() {
        $(this).css('display', '');
    });
}

/**
 * error (alert) message using twitter bootstrap
 */
function showAjaxError(contentDivId, data) {
    var msg = '<div class="alert alert-error"><a class="close" data-dismiss="alert" href="#">×</a>';
    msg += '<h4 class="alert-heading">Failed!</h4>';
    if ((data.responseText == "") || (data.responseText == "undefined") || (data == "undefined")) {
        msg += 'Your request cannot be proccessed, please try again.';
    } else {
        msg += data.responseText;
    }
    msg += "</div>";

    $(contentDivId).html(msg);
}

function tabbed_form_page_next() {
    $('.tab-content .next-step').live('click', function(event) {
        target = $(this).attr('data-target');
        nav_tab = $(this).parents('form').find('.nav-tabs');
        $(nav_tab).find('li').removeClass('active');
        nav_tab.find("[href='" + target + "']").parent().addClass('active');
    })
}

function formAJAXsubmit() {

}

function openLink() {
    // bind for once only
    $('a.open-link').live('click', function(event) {
        event.preventDefault();
        window.open($(this).attr("href"), $(this).attr("data_target"), "status=0,toolbar=0,resizable=0,height=600,width=1020,location=0,scrollbars=1");
    });
}

function askDelete() {
    // bind for once only
    $('a.ask-delete').live('click', function(event) {
        event.preventDefault();
        //    window.open($(this).attr("href"), $(this).attr("data_target"),"status=0,toolbar=0,resizable=0,height=600,width=1020,location=0,scrollbars=1");

        $("#dialog-confirm .msg").html($(this).attr('data-msg'));
        path = $(this).attr("href");

        $("#dialog-confirm").dialog({
            resizable: false,
            //      height:140,
            modal: true,
            buttons: {
                Yes: function() {
                    $(this).dialog("close");
                    window.location = path;
                },
                No: function() {
                    $(this).dialog("close");
                }
            }
        });
    });
}

function setCustomPanelEdgetape() {
    var s1 = $('#panel-edgatape-selection-s1');
    var s2 = $('#panel-edgatape-selection-s2');
    var l1 = $('#panel-edgatape-selection-l1');
    var l2 = $('#panel-edgatape-selection-l2');
    var et = "";

    if ((s1.is(':checked')) && (s2.is(':checked'))) {
        et = "2S";
    } else {
        if ((s1.is(':checked')) || (s2.is(':checked'))) {
            et = "1S";
        }
    }

    if ((l1.is(':checked')) && (l2.is(':checked'))) {
        et = et + "2L";
    } else {
        if ((l1.is(':checked')) || (l2.is(':checked'))) {
            et = et + "1L";
        }
    }

    if (l1.is(':checked') && l2.is(':checked') && s1.is(':checked') && s2.is(':checked')) {
        et = '4S';
    }

    if (et != "") {
        $('#CabinetOrderCustomPanelEdgetape').val("E" + et);
    } else {
        $('#CabinetOrderCustomPanelEdgetape').val('');
    }
}

function clearCustomPanelInputs() {
    $('#panel-edgatape-selection-l1').prop('checked', false);
    $('#panel-edgatape-selection-l2').prop('checked', false);
    $('#panel-edgatape-selection-s1').prop('checked', false);
    $('#panel-edgatape-selection-s2').prop('checked', false);
    $('#CabinetOrderCustomPanelHeight').val('');
    $('#CabinetOrderCustomPanelWidth').val('');
    //  $('#CabinetOrderCustomPanelColorId').val('');
    //  $('#CabinetOrderCustomPanelMaterialId').val('');
    $('#CabinetOrderCustomPanelEdgetape').val('');
}

function clearCustomDoorInputs() {
    $('#CabinetOrderCustomDoorHeight').val('');
    $('#CabinetOrderCustomDoorWidth').val('');
//  $('#CabinetOrderCustomDoorDoor').val('');
//  $('#CabinetOrderCustomDoorColor').val('');
}


function validateCalculationCriteria() {
    var error_class = 'error';
    var validation_success = true;
    var resource = $('#CabinetOrderBasicResourceId').val();
    var cabinet_color = $('#CabinetOrderBasicCabinetColor').val();
    var material_id = $('#CabinetOrderBasicMaterialId').val();

    if(!(resource.length > 0)) {
        $('.resource .select2-container').addClass(error_class);
        validation_success = false;
    } else {
        $('.resource .select2-container').removeClass(error_class);
    }


    if((cabinet_color.length == 0) && ($('#quote_color_required').html() == 1)) {
        $('.cabinet-color .select2-container').addClass(error_class);
        validation_success = false;
    } else {
        $('.cabinet-color .select2-container').removeClass(error_class);
    }

    if((material_id.length == 0) && ($('#quote_material_required').html() == 1)) {
        $('.material .select2-container').addClass(error_class);
        validation_success = false;
    } else {
        $('.material .select2-container').removeClass(error_class);
    }

    if((material_id.length > 0) && (cabinet_color.length == 0)) {
        $('.cabinet-color .select2-container').addClass(error_class);
        validation_success = false;
    } else {
        $('.cabinet-color .select2-container').removeClass(error_class);
    }

    return validation_success;
}
function toggle(div_id) {
    $("#" + div_id).toggle("slow");
}
