let URL_ROOT = "";
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
const CHART_GOLD_PRODUCED_TONS_MILLED = 'GOLD PRODUCED AND TONS MILLED';
const CHART_RECOVERY_HEAD_GRADE = 'RECOVERY AND HEAD GRADE';
let monthNames = kendo.cultures.current.calendars.standard.months.names;
$(function () {
    //jQuery.fx.off = true;
    URL_ROOT = $('#url_root').val();
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
        $('.content').removeClass('d-none invisible');
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

function kendoAlert(title, content) {
    let kAlert = $("<div/>").appendTo("body").kendoDialog({
        width: "450px",
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

function showWindow(message, title= "Are You Sure?", template="#confirmationTemplate") {

    var dfd = new jQuery.Deferred();
    var result = false;

    $("<div id='popupWindow'></div>")
        .appendTo("body")
        .kendoWindow({
            width: "480px",
            modal: true,
            title: title,
            visible: false,
            close: function (e) {
                this.destroy();
                dfd.resolve(result);
            }
        }).data('kendoWindow').content($(template).html()).center().open();

    $('.popupMessage').html(message);

    $('#popupWindow .confirm_yes').val('OK');
    $('#popupWindow .confirm_no').val('Cancel');

    $('#popupWindow .confirm_no').on('click',function () {
        $('#popupWindow').data('kendoWindow').close();
    });

    $('#popupWindow .confirm_yes').on('click', function () {
        result = true;
        $('#popupWindow').data('kendoWindow').close();
    });

    return dfd.promise();
}

// PDF Viewer fromFile method fails with js error, causing inability to programmatically load a file. #5358 . Workaround
// Use the following overwrite to overcome the issue:
kendo.pdfviewer.pdfjs.processor.fn._updateDocument = function (file) {
    if(this.pdf) {
        this.pdf.loadingTask.destroy();
    }

    this.file = file;
};
/*kendo.pdf.defineFont({
    "DejaVu Sans"             : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans.ttf",
    "DejaVu Sans|Bold"        : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Bold.ttf",
    "DejaVu Sans|Bold|Italic" : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf",
    "DejaVu Sans|Italic"      : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf",
    "WebComponentsIcons"      : "https://kendo.cdn.telerik.com/2017.1.223/styles/fonts/glyphs/WebComponentsIcons.ttf"
});*/
/*
$.when(showConfirmationWindow('Are you sure?')).then(function(confirmed){

    if(confirmed){
        alert('OK');
    }
    else{
        alert('Cancel');
    }
});*/
