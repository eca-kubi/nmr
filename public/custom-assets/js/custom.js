// 
let URL_ROOT = "";
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
$(function () {
    jQuery.fx.off = true;
    URL_ROOT = $('#url_root').val();
    //$('.print-it').printPage();
    $('.content-wrapper').css('margin-top', $('.navbar-fixed').height() + 'px');
    $(window).on("resize", function () {
        $('.content-wrapper').css('margin-top', $('.navbar-fixed').height() + 'px');
    });
// fix column width for tables in collapse
    $('.hide-child').removeClass('show').trigger('hidden.bs.collapse');
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
