
$(document).ready(function() {
    initDialogs();
    initValidation();
    initResponsiveMenus();
});

function initDialogs() {
    $(".dialog").dialog({
        modal: true,
        position: "center",
        autoOpen: false,
        width:800,
        height: 500
    });
}

function initValidation() {
    $(".validate").change(function() {
        var valid = true;
        var value = $(this).val();
        var obj = $(this);

        if (obj.hasClass("forceempty")) {
            if (value != "") valid = false;
        }

        if (obj.hasClass("forcenoempty")) {
            if (value == "") valid = false;
        }

        if (obj.hasClass("forceemail")) {
            if (!isEmail(value)) valid = false;
        }

        if (obj.hasClass("forcepassword")) {
            if (!isValidPassword(value)) valid = false;
        }

        if (obj.hasClass("forcelink")) {
            if (!isValidLink(value)) valid = false;
        }

        if (obj.hasClass("forcequals")) {
            var val2 = $("input#"+obj.attr("data-equals")).val();
            if (value != val2) valid = false;
        }

        if (obj.hasClass("forcealpha")) {
            if (!value.match(/^([a-zA-Z0-9]+)$/)) valid = false;
        }

        if (obj.attr("data-minlength")) {
            var length = value.length;
            var min = parseInt(obj.attr("data-minlength"));
            if (length < min) valid = false;
        } else if (obj.attr("maxlength") != undefined) {
            if (value.length > parseInt(obj.attr("maxlength"))) valid = false;
        }

        if (obj.hasClass("valid")) obj.removeClass("valid");
        if (obj.hasClass("invalid")) obj.removeClass("invalid");

        if (valid)
            obj.addClass("valid")
        else
            obj.addClass("invalid");
    });

    $("form").submit(function() {
        if ($("form .invalid").length > 0) {
            alert("The information you entered into this form is not valid. Please edit the fields highlighted in red.");
            return false;
        }
    });
}

function initResponsiveMenus() {
    var func = function() {
        $(".responsive-menu").each(function() {
            $(this).children().show();

            var subtract = $("."+$(this).attr("data-responsive-subtract")).width();
            var width = childrenWidth($(this));
            var realwidth = $(this).width()-subtract;
            //var dropdown = new Array();

            var i = 0;
            while (realwidth < width) {
                var elem = $(this).children().not(":hidden").last();
                elem.hide();
                //dropdown.add(elem);

                width = childrenWidth($(this));
                i++;

                if (i > 50) break;
            }
        });
    }

    func();
    $(window).resize(func);
}

function childrenWidth(elem) {
    var width = 0;
    elem.children(":visible").each(function() {
        width += $(this).width();
        width += parseInt($(this).css("padding-left"), 10) + parseInt($(this).css("padding-right"), 10); //Total Padding Width
        width += parseInt($(this).css("margin-left"), 10) + parseInt($(this).css("margin-right"), 10); //Total Margin Width
        width += parseInt($(this).css("borderLeftWidth"), 10) + parseInt($(this).css("borderRightWidth"), 10); //Total Border Width
    });
    return width;
}

function isEmail(x) {
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
    return !(atpos < 1 || dotpos < atpos+2 || dotpos+2 >= x.length);
}

function isValidPassword(str) {
    var length = str.length;

    return (length <= passwordMaxLength && length >= passwordMinLength);
}

// Credit: http://stackoverflow.com/questions/1303872/trying-to-validate-url-using-javascript
function isValidLink(value) {
    return /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(value);
}

function search() {
    $.ajax({
        url: "search/",
        success: function(html) {
            $(".admin-search").html(html).css({opacity:0}).show().animate({
                opacity:1
            }, 200);
            $(".admin-search input").keyup(function(ev) {
                var value = $(this).val();
                $.ajax({
                    url: "search/api/?query="+encodeURIComponent(value),
                    success: function(html) {
                        $(".search-results").html(html);
                    }
                });
            });
        }
    })
}