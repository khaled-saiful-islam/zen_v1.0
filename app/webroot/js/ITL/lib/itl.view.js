/**
 * ITL.view.js
 * @package js/ITL/libs
 * @class ITL.view
 * @author Md.Rajib-Ul-Islam<mdrajibul@gmail.com>
 * Used as view related global functionality .
 *
 */
ITL.view = (function () {
    /** Default configuration settings
     * @type Object
     * @cfg {paginationEl} specify pagination element - default .paginateButtons a
     * @cfg {generateRandomEl} specify generate random string element - default .generate
     * @cfg {checkUniqueElm} specify unique check input element - default .uniqueCheck
     * @method private
     */
    var properties = {
        paginationEl:".paginator a",
        checkUniqueElm:".uniqueCheck"
    };
    var dialog;// global dialog instance
    return {
        /**
         * Combo Box Item Per Page Number
         */
        comboBoxItemPerPage:20,
        /**
         * user access/permission variable
         */
        permission:{},
        /**
         *  constructor which is used for initialize configuration properties.useful if need chaining method call.
         *    @type Object
         *    @return entire scope
         */
        constructor:function (settings) {
            if (settings) {$.extend(properties, settings);}
            return this;
        },
        /**
         *  used for server side unique checking.
         *  @param {settings} configuration object
         *  @cfg {settings.url} ajax request url
         *  @cfg {settings.editId} need when you are in editing a database item(optional)
         *  @cfg {settings.elm} element name for handling event(optional)
         *  @cfg {settings.afterSuccess} a custom event function which is invoked when get ajax response(optional)
         *  @return void
         */
        checkUnique:function (settings) {
            var config = {
                url:'',
                elm:properties.checkUniqueElm,
                editId:'',
                afterSuccess:function (el, data) {
                    if (data.result) {
                        el.after("<ul class='errorlist'><span></span><li>" + data.message.text + "</li></ul>");
                    } else {
                        el.parent().find(".errorlist").remove();
                    }
                }
            };
            if (settings) {$.extend(config, settings);}
            $(config.elm).bind("change", function () {
                var el = $(this);
                var params = {};
                if (config.editId) {
                    params.id = el.closest("form").find("input[name=id]").val();
                }
                params.uniqueValue = el.attr("value");
                ITL.utility.callAjax({
                    url:config.url,
                    data:params,
                    success:function (data) {
                        config.afterSuccess(el, data);
                    }
                });
                return false;
            })
        },
        /**
         *  used for ajax pagination.
         *  @method _loadAjaxPaginationRequest used as private variable which is useful for ajax pagination
         *  @param {settings} configuration object
         *  @cfg {settings.elm} specify element name for handling event
         *  @cfg {settings.loadEl} specify load container where data loaded.
         *  @cfg {settings.isInner} specify load data by inner method in server side(optional)
         *  @cfg {settings.appendUrl} specify extra params need to be pass when ajax call (optional)
         *  @cfg {settings.afterShow} a custom event function which is invoked when get ajax response(optional)
         *  @return void
         */
        _loadAjaxPaginationRequest:function (config, url, el) {
            if (config.appendUrl != null) {
                url += config.appendUrl;
            }
            var loadEl = config.loadEl ? config.loadEl : $("#" + el.parents(".tab-panel-content").attr("id"));
            ITL.utility.callAjax({
                url:url,
                type:'get',
                dataType:'html',
                success:function (data) {
                    loadEl.html(data);
                    ITL.view.ajaxPagination({loadEl:config.loadEl, maxUrl:config.maxUrl, appendUrl:config.appendUrl, afterShow:function () {
                        config.afterShow();
                    }});
                    ITL.utility.rowColor(config.loadEl.find("table"));
                    config.afterShow();
                },
                beforeSend:function () {
                    ITL.view.loadMask(config.loadEl.find(".table-grid"));
                },
                complete:function () {
                    ITL.view.hideMask(config.loadEl.find(".table-grid"));
                }
            });
            return false;
        },

        ajaxPagination:function (settings) {
            var config = {
                elm:$(properties.paginationEl),
                loadEl:null,
                tabElm:null,
                maxUrl:'',
                isInner:false,
                appendUrl:null,
                afterShow:function () {
                }
            };
            if (settings)$.extend(config, settings);
            config.loadEl.find('.pagination-max select').change(function (e) {
                var el = $(this);
                var url = config.maxUrl;
                return ITL.view._loadAjaxPaginationRequest(config, url, el);
            });
            config.elm.on("click", function (e) {
                var el = $(this);
                var url = el.attr("href");
                return ITL.view._loadAjaxPaginationRequest(config, url, el);
            });
            config.loadEl.find('th a').on("click", function (e) {
                var el = $(this);
                var url = el.attr("href");
                return ITL.view._loadAjaxPaginationRequest(config, url, el);
            })
        },
        loadMask:function (loadEl, height) {
            var elm = $("<div/>");
            elm.addClass('masking');
            elm.append('<img src="' + IMAGEPATH + 'ajax-loader.gif" alt="Loading...">');
            loadEl.append(elm).show();
            var containerHeight = height || loadEl.height();
            var marginTopHeight = (containerHeight / 2);
            if (marginTopHeight > 24) {
                marginTopHeight = marginTopHeight - 12;
            }
            elm.find('img').css({'margin-top':marginTopHeight});
        },
        hideMask:function (loadEl) {
            loadEl.find(".masking").hide();
        },
        /**
         *  used for delete an item from database.
         *  @param {settings} configuration object
         *  @cfg {settings.messageElm} jQuery element object with message text which will render to dialog box.
         *  @cfg {settings.deleteElm} jQuery element object which would be deleted.
         *  @cfg {settings.urlParams} the parameters which need to be pass as request to the server(optional)
         *  @cfg {settings.title} dialogBox title(optional)
         *  @cfg {settings.width} dialogBox width.default 400(optional)
         *  @cfg {settings.height} dialogBox height.default 140(optional)
         *  @cfg {settings._showMessageBox} a private function which invoke after delete is completed
         *  @cfg {settings.afterDelete} a custom event function which is invoked after delete is completed(optional)
         *  @cfg {settings.beforeDelete} a custom event function which is invoked before delete is precessed(optional)
         *  @return void
         */
        itemDelete:function ($messageEl, url, settings) {
            var thisClass = this;

            var config = {
                width:400,
                height:140,
                title:'Confirm?',
                afterDelete:function (resp) {
                },
                showMessage:true,
                urlParams:{},
                beforeDelete:function () {
                }
            };
            if (settings) {$.extend(config, settings);}
            $messageEl.dialog({
                resizable:false,
                height:config.height,
                modal:true,
                title:config.title,
                width:config.width,
                zIndex:2000,
                buttons:{
                    "Yes":function () {
                        ITL.utility.callAjax({
                            url:url,
                            data:config.urlParams,
                            success:function (data) {
                                config.afterDelete(data);
                            },
                            beforeSend:function () {
                                $messageEl.dialog("close");
                            }
                        });
                    },
                    No:function () {
                        $(this).dialog("close");
                    }
                }
            });
        },
        setDefaultFormBeforeSend:function ($form, config) {
            $("body").addClass("curWait");
            config._btnValue = $form.find(".btnSubmit").html();
            if (config.btnLoadingText) {
                $form.find(".btnSubmit").html(config.btnLoadingText);
            }
            $form.find(".btnSubmit").attr("disabled", true);
        },
        setDefaultFormAfterSuccess:function ($form, config) {
            $("body").removeClass("curWait");
            config.buttonEnabled($form);
        },
        /**
         * Simple form submit function.
         * @param $form - jQuery from element object
         */
        formSubmit:function ($form, settings) {

            var config = {
                _btnValue:'',
                resetForm:false,
                data:undefined,
                btnLoadingText:'Saving..',
                beforeSend:function ($form, config) {
                    ITL.view.setDefaultFormBeforeSend($form, config);
                },
                buttonEnabled:function ($form) {
                    $form.find(".btnSubmit").html(this._btnValue);
                    $form.find(".btnSubmit").removeAttr("disabled");
                },
                beforeFormSubmit:undefined,
                afterSuccess:undefined
            };


            if (typeof settings != 'undefined') {
                $.extend(config, settings);
            }

            $form.ajaxSubmit({
                resetForm:config.resetForm,
                data:config.data,
                dataType:settings.dataType ? settings.dataType : 'json',
                before:function() {
                    if (typeof config.beforeFormSubmit != 'undefined') {
                        config.beforeFormSubmit($form, config);
                    }
                },
                success:function (resp, statusText, xhr) {
                    if (typeof config.afterSuccess != 'undefined') {
                        config.afterSuccess(resp, $form);
                    }
                },
                complete:function () {
                    ITL.view.setDefaultFormAfterSuccess($form, config);
                }
            });
        },
        headerToggle:function (viewPanel) {
            viewPanel.find(".header-title").click(function (e) {
                if ($(e.target).hasClass("header-command") || $(e.target).hasClass("noClick")) {
                    return true;
                }
                var elm = $(this);
                var targetPanel = elm.next();
                if (!targetPanel.is(":hidden")) {
                    targetPanel.slideUp(200);
                    elm.find('span').removeClass('expand').addClass('collapse');
                } else {
                    targetPanel.slideDown(200);
                    elm.find('span').removeClass('collapse').addClass('expand');
                }
            });
        },
        gridHeaderToggle:function (viewPanel) {
            viewPanel.find(".grid-head").bind("click", function () {
                var el = $(this);
                var targetEl = viewPanel.find(".table-grid");
                var toggleEl = el.find("span");
                if (toggleEl.hasClass("panel-down")) {
                    targetEl.slideUp(200);
                    toggleEl.removeClass('panel-down').addClass('panel-up');
                } else {
                    targetEl.slideDown(200);
                    toggleEl.removeClass('panel-up').addClass('panel-down');
                }
            });
        },
        /**
         * Common form validation error message
         * @param $form
         * @param message
         */
        populateErrorMessage:function ($form, message) {
            var errorField = $form.find(".errorMessage");
            if (errorField.length < 1) {
                $form.prepend("<div class='errorMessage'>" + message + "</div>");
            } else {
                errorField.html(message);
            }
        },
        /**
         * date picker common function
         * @param el
         * @param dateFormat
         */
        datePicker:function (el, dateFormat) {
            el.datepicker({
                dateFormat:dateFormat || 'yy-mm-dd',
                changeMonth:true,
                changeYear:true,
                yearRange:"-120:+30"
            });
        },
        /**
         * Get dialog - singleton
         * @param el
         * @param options
         * @param callBack
         */
        getDialog:function(el, options, callBack) {
            var dialogDefaults = {
                title:"View Details",
                modal:true,
                width:600,
                position:'top',
                loadingText:'Loading...'
            };
            if (options) {
                $.extend(dialogDefaults, options, true)
            }
            $(el).bind("click", function() {
                var href = $(this).attr("href");
                if (!dialog) {
                    dialog = $("<p id='detailDialog'>" + dialogDefaults.loadingText + "</p>").dialog({
                        title:dialogDefaults.title,
                        modal:dialogDefaults.modal,
                        width:dialogDefaults.width,
                        position:dialogDefaults.position
                    });
                } else {
                    dialog.dialog("open");
                    dialog.html(dialogDefaults.loadingText);
                }
                ITL.utility.callAjax({
                    url : href,
                    success:function(data) {
                        dialog.html(data);
                        if (callBack && $.isFunction(callBack)) {
                            callBack();
                        }
                    }
                });
                return false;
            })
        },
        /**
         * Make tabs
         * @param el
         * @param afterComplete
         */
        makeTab:function(el, afterComplete) {
            $(el).tabs({
                fx:{
                    opacity: 'toggle'
                },
                ajaxOptions: {
                    error: function(xhr, status, index, anchor) {
                        $(anchor.hash).html("Couldn't load this tab. Please try again.");
                    },
                    complete: function() {
                        if (afterComplete && $.isFunction(afterComplete)) {
                            afterComplete();
                        }
                    }
                }
            });
        }
    }
}());