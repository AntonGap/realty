jQuery(document).ready(function () {
    jQuery( "#createObject" ).on('submit', function(e) {
        e.preventDefault();
        var formData = jQuery(this).serializeArray();
        //console.log(JSON.stringify(formData));
        jQuery.ajax({
            type: "POST",
            url: "wp-json/newobject/v1/add",
            data: {data:JSON.stringify(formData)},
            dataType: "json",
            encode: true,
        }).done(function (data) {
            console.log(data);
        });
    });
});