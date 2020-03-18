//let URL_ROOT = "";
let overlayScrollbarsInstances = [];
/**
 * @type {Object.<jQuery>}
 * */
let jQSelectors = {};
const GHS_SYMBOL = "₵";
let customGH = $.extend(true, {}, kendo.culture(), {
    name: "custom-GH",
    numberFormat: {
        currency: {
            symbol: GHS_SYMBOL,
            name: "GH Cedi",
            abbr: "GHS"
        }
    }
});

//add a reference to the custom culture script
kendo.cultures["custom-GH"] = customGH;
const CHART_GOLD_PRODUCED_BUDGET_OUNCES = 'GOLD PRODUCED AND BUDGET OUNCES';
const CHART_GOLD_PRODUCTION = 'GOLD PRODUCTION';
const CHART_PROCESSING = 'PROCESSING';
const CHART_TONS_MILLED_AND_GOLD_PRODUCED = 'TONNES MILLED AND GOLD PRODUCED';
const CHART_RECOVERY_HEAD_GRADE = 'RECOVERY AND HEAD GRADE';
const CHART_RECOVERY_HEAD_GRADE_2 = 'RECOVERY AND HEAD GRADE 2';
const CHART_GOLD_RECOVERED_ARL_AND_TOLL = 'GOLD RECOVERED ARL & TOLL';
const CHART_PLANNED_VRS_ACTUAL_METRES = 'PLANNED VRS ACTUAL METRES';
const CHART_CLOSING_STOCKPILE_BALANCE = 'CLOSING STOCKPILE BALANCE';
const CHART_TOLL_DELIVERY = 'TOLL DELIVERY AGAINST PROCESSED TOLL AND BUDGET';
const CHART_MINE_SITE_EMPLOYEE_TURNOVER = 'MINE SITE EMPLOYEE TURNOVER';
const CHART_MINE_SITE_EMPLOYEE_TURNOVER_2 = 'MINE SITE EMPLOYEE TURNOVER 2';

let monthNames = kendo.cultures.current.calendars.standard.months.names;
let pdfExportOptions = {
    allPages: true,
    paperSize: 'A4',
    margin: {top: "3cm", right: "1cm", bottom: "1cm", left: "1cm"},
    scale: 0.7,
    multipage: true,
    forcePageBreak: '.page-break',
    keepTogether: "table"
};

$(function () {
    $.blockUI.defaults.overlayCSS.opacity = 0.3;
    $.blockUI.defaults.overlayCSS.cursor = 'default';
    $.blockUI.defaults.message = "<i class='k-loading-mask k-loading-image'></i>";
    $.blockUI.defaults.applyPlatformOpacityRules = false;
    //$(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

    //jQuery.fx.off = true;
    //URL_ROOT = $('#url_root').val();
    //$('.print-it').printPage();
    $('.content-wrapper').css('margin-top', $('.navbar-fixed').height() + 'px');

    jQSelectors.body = $("body");
    jQSelectors.sidebar = $(".sidebar");
    //jQSelectors.emptyChartPlaceholder = $("#emptyChartPlaceHolder");
    initOverlayScrollbars(jQSelectors['body']);
    initOverlayScrollbars(jQSelectors['sidebar']);
    overlayScrollbarsInstances['body'] = jQSelectors['body'].overlayScrollbars();
    overlayScrollbarsInstances['sidebar'] = jQSelectors['sidebar'].overlayScrollbars();

    $(window).on("resize", function () {
        $('.content-wrapper').css('margin-top', $('.navbar-fixed').height() + 'px');
    });

    $(".content").kendoRippleContainer();

// fix column width for tables in collapse
    //$('.hide-child').removeClass('show').trigger('hidden.bs.collapse');
});

window.addEventListener("load", function () {
    setTimeout(() => {
        $('.blockable').removeClass('d-none invisible');
        $('footer').removeClass('d-none');
        setTimeout(function () {
            $.unblockUI();
            $('.blockable').unblock({message: null});
        }, 1000);
    }, 500);
    console.log("All resources finished loading!");
});

toastError = function f(message, timeout = 3000) {
    $.toast({
// heading: '<u>Information</u>',
        text: `<b class="text-bold row"><i class="fa fa-warning text-warning p-1"></i> <span class="text-danger">${message}</span></b>`,
//icon: 'warning',
        loader: false,        // Change it to false to disable loader
        loaderBg: '#9EC600',  // To change the background
        position: 'mid-center',
        stack: 1,
        hideAfter: timeout,
        beforeShow: function (element) {
            element.addClass("bg-white card")
        },
        afterShown(element) {
            $(".dimbackground-curtain").remove();
            element.dimBackground({darkness: 0.6});
        },
        afterHidden(element) {
            element.undim();
        }
    });
};

toastSuccess = function f(message, timeout = 3000) {
    $.toast({
// heading: '<u>Information</u>',
        text: `<b class="text-bold text-danger"><i class="fa fa-check text-success p-1"></i> <span class="text-success">${message}</span></b>`,
//icon: 'warning',
        loader: false,        // Change it to false to disable loader
        loaderBg: '#9EC600',  // To change the background
        position: 'top-center',
        stack: 1,
        hideAfter: timeout,
        beforeShow: function (element) {
            element.addClass("bg-white card")
        },
        afterShown(element) {
            $(".dimbackground-curtain").remove();
            element.dimBackground({darkness: 0.6});
        },
        afterHidden(element) {
            element.undim();
        }
    });
};

function progress(target, toggle = false) {
    var element = $(target);
    kendo.ui.progress(element, toggle);
}

function createKendoTooltip(target, filter, position = "top") {
    return target.kendoTooltip({
        filter: filter,
        position: position,
        content: function (e) {
            // hide popup as default action
            e.sender.popup.element.css("visibility", "hidden");
            let text = $(e.target).text();
            if (text) e.sender.popup.element.css("visibility", "visible");
            return text;
        }
    }).data("kendoTooltip");
}

function initOverlayScrollbars(selector, options = {}) {
    let defaultOpt = $.extend(options, {
        scrollbars: {
            autoHide: "leave"
        },
        overflowBehavior: {
            x: "scroll",
            y: "scroll"
        },
        callbacks: {
            onScrollStart() {
                $(".k-animation-container").hide();
            }
        }
    });
    return $(selector).overlayScrollbars(defaultOpt).overlayScrollbars()
}

$.fn.outerHTML = function () {
    // IE, Chrome & Safari will comply with the non-standard outerHTML, all others (FF) will have a fall-back for cloning
    return (!this.length) ? this : (this[0].outerHTML || (
        function (el) {
            var div = document.createElement('div');
            div.appendChild(el.cloneNode(true));
            var contents = div.innerHTML;
            div = null;
            return contents;
        })(this[0]));
};

function kendoAlert(title, content, options = {}) {
    let kAlert = $("<div/>").appendTo("body").kendoDialog({
        width: "300px",
        title: title,
        //closable: false,
        //modal: false,
        content: content,
        close(e) {
            kAlert.destroy();
        }
    }).data("kendoDialog");
    return kAlert;
}

function showWindow(message, title = "Are You Sure?", template = "#confirmationTemplate", onWindowOpen = () => false) {

    var dfd = new jQuery.Deferred();
    var result = false;

    let window = $("<div id='popupWindow'></div>")
        .appendTo("body")
        .kendoWindow({
            width: "480px",
            modal: true,
            title: title,
            visible: false,
            close: function (e) {
                this.destroy();
                if (result) {
                    dfd.resolve(result);
                } else {
                    dfd.reject(result);
                }
            },
            open(e) {
                onWindowOpen();
            }
        }).data('kendoWindow').content("<div id='popupContent' data-role='validator'>" + $(template).html() + "</div>");
    kendo.bind('#popupWindow');
    window.center().open();

    $('.popupMessage').html(message);

    $('#popupWindow .confirm_yes').val('OK');
    $('#popupWindow .confirm_no').val('Cancel');

    $('#popupWindow .confirm_no').on('click', function () {
        $('#popupWindow').data('kendoWindow').close();
    });

    $('#popupWindow .confirm_yes').on('click', function () {
        let v = $("#popupContent").data("kendoValidator");
        if (v.validate()) {
            result = true;
            $('#popupWindow').data('kendoWindow').close();
        } else {
            result = false;
        }
    });

    return dfd.promise();
}

// PDF Viewer fromFile method fails with js error, causing inability to programmatically load a file. #5358 . Workaround
// Use the following overwrite to overcome the issue:
kendo.pdfviewer.pdfjs.processor.fn._updateDocument = function (file) {
    if (this.pdf) {
        this.pdf.loadingTask.destroy();
    }

    this.file = file;
};


function appendScriptsToEditor(document, urls) {
    let body = document.body;

    let appendScript = (url) => {
        let script = document.createElement('script');
        script.src = url;
        script.type = "text/javascript";
        body.appendChild(script);
    };

    for (let i = 0; i < urls.length; i++) {
        appendScript(urls[i]);
    }
}

function appendStyleSheets(document, urls) {
    let body = document.body;

    let appendStyleSheet = (url) => {
        let link = $("<link />", {
            rel: "stylesheet",
            type: "text/css",
            href: url
        });
        $(document.head).append(link);
    };

    for (let i = 0; i < urls.length; i++) {
        appendStyleSheet(urls[i]);
    }
}

function notify(message, type = 'success') {
    let notification = $('<span class="notification" />').appendTo('body').kendoNotification({
        position: {
            right: 0,
            top: 0
        }
    }).data('kendoNotification');
    notification.show(message, type)
}

function getYearsBetween(startDate, endDate) {
    let s = new Date(startDate);
    let start = s.getFullYear();

    let e = new Date(endDate);
    let end = e.getFullYear();
    let arr = Array();

    for (let i = start; i <= end; i++) arr.push(i);
    return arr;
}

function arabicToRoman(number) {
    let roman = "";
    const romanNumList = {
        M: 1000,
        CM: 900,
        D: 500,
        CD: 400,
        C: 100,
        XC: 90,
        L: 50,
        XV: 40,
        X: 10,
        IX: 9,
        V: 5,
        IV: 4,
        I: 1
    };
    let a;
    if (number < 1 || number > 3999)
        return "Enter a number between 1 and 3999";
    else {
        for (let key in romanNumList) {
            a = Math.floor(number / romanNumList[key]);
            if (a >= 0) {
                for (let i = 0; i < a; i++) {
                    roman += key;
                }
            }
            number = number % romanNumList[key];
        }
    }

    return roman;
}

function pageMeta(page) {
    switch (page) {
        case 'editDraft':
            return {
                templateId: `#page-template-body_${tablePrefix}`,
                fileName: 'Nzema Monthly Report'
            };
        default:
            return {};
    }
}

function removeTagAndContent(tag, str) {
    let regex = new RegExp("<" + tag + ".*>.*?<\/" + tag + ">", "ig");
    return str.replace(regex, '');
}

function extractTag(tag, str) {
    let regex = new RegExp("<" + tag + ".*>.*?<\/" + tag + ">", "ig");
    return str.match(regex, '');
}

function getPageBreak() {
    return "<div class=\"page-break\" style=\"page-break-after:always;\"><span style=\"display:none;\">&nbsp;</span></div><p></p>";
}

String.prototype.insert = function (index, string) {
    if (index > 0) {
        return this.substring(0, index) + string + this.substring(index, this.length);
    }

    return string + this;
};

function random() {
    return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
}

/*
$.when(showConfirmationWindow('Are you sure?')).then(function(confirmed){

    if(confirmed){
        alert('OK');
    }
    else{
        alert('Cancel');
    }
});*/
