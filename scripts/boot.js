$.fn.serializeObject = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

var selROW = "success";
String.prototype.replaceAll = function (target, replacement) {
    return this.split(target).join(replacement);
};
$(document).ready(function () {
    $("table.selectable tbody tr").live('click', function () {
        $(this).parent().find("tr." + selROW).removeClass(selROW);
        $(this).addClass(selROW);
    });

    if (!Modernizr.inputtypes.date) {
        $(".datefield").datepicker();
    }
    if (!Modernizr.inputtypes.time) {
        $(".timefield").timePicker({
            startTime: "01.00", // Using string. Can take string or Date object.
            endTime: new Date(0, 0, 0, 15, 30, 0), // Using Date object here.
            show24Hours: false,
            separator: '.',
            step: 15
        });
    }

    $("#userclicked").change(function () {
        window.location.href="/home/index/" +$(this).val() ;
    });

    $(".delbtn").live('click', function (e) {
        if (!confirm("Are you sure want to delete [" + $(this).attr("data-text") + "] ?")) {
            e.preventdefault();
        }
    });

    $("button[type=submit]").live('click', function () {
        $("button[type=submit]", $(this).parents("form")).removeAttr("clicked");
        $(this).attr("clicked", true);
    });

    var binders = [];

    $("form").live('submit',function () {
        var data = $(this).serializeObject();
        var actionBtn = $("button[type=submit][clicked=true]");
        data.what = actionBtn.val();
        if (!data.what) {
            var myTable = $(this).att("data-table");
            if (!!myTable) {
                data.what = !$("#"+myTable+" tr." + selROW).attr("data-value") ? "add" : "update";
            }
        }
        //in case of delete
        var primaryField = $(this).attr("data-primary");
        if (!!primaryField) {
            if(!data[primaryField]){
                data[primaryField] = actionBtn.attr("data-value");
            }
        }
        var url = $(this).attr("action");
        if (!!url && !!data) {
            $.ajax({
                url: url+"?json",
                data: data,
                type: 'POST',
                dataType: "json",
                success: function (o) {
                    if (!!o.error) {
                        alert(o.error);
                    } else {
                        for (x in o){
                            if(!!binders[x]){
                                binders[x].refill(o[x]);
                            }
                        }
                    }
                }
            });
        }
        return false;
    });

    $(".bindable").each(function(i,o){
        var name=$(o).attr("data-model");
        var tmp=new DynamicModel(model[name]);
        binders[name] = tmp;
        ko.applyBindings(binders[name], $(o)[0]);
    })

    $("table.table").addClass("table-striped");

});