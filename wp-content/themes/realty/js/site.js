jQuery(document).ready(function () {

    var thumb, gallery;

    jQuery('#thumbnail').on('change', function(){
		thumb = this.files;
	});

    jQuery('#gallery').on('change', function(){
		gallery = this.files;
	});

    

    jQuery( "#createObject" ).on('submit', function(e) {
        e.stopPropagation();
        e.preventDefault();
        var reply = jQuery('.ajax-reply');
        var post_id;
        
        var formData = jQuery(this).serialize();
        jQuery.ajax({
            type: "POST",
            url: "wp-json/newobject/v1/add",
            data: formData,
            dataType: "json",
            encode: true,
        }).done(function (data) {
            if(data.success) {
                post_id = data.id;
                
                if( typeof thumb != 'undefined' ) {
                    var nonce = jQuery('#nonce').val();
                    var data = new FormData();
                    jQuery.each( thumb, function( key, value ){
                        data.append( key, value );
                    });
        
                    data.append( 'action', 'ajax_fileload' );
                    data.append( 'nonce', nonce );
                    data.append( 'post_id', post_id);
        
                    reply.text( 'Загружаю...' );
                    jQuery.ajax({
                        url         : 'wp-admin/admin-ajax.php',
                        type        : 'POST',
                        data        : data,
                        cache       : false,
                        dataType    : 'json',
                        processData : false,
                        contentType : false,
                        success     : function( respond, status, jqXHR ){
                            if( respond.success ){
                                reply.text( 'Успешно загружено' );
                            }
                            else {
                                reply.text( 'ОШИБКА: ' + respond.error );
                            }
                        },
                        error: function( jqXHR, status, errorThrown ){
                            reply.text( 'ОШИБКА запроса: ' + status );
                        }
                    });
                }

                if( typeof gallery != 'undefined' ) {
                    var nonce = jQuery('#nonce').val();
                    var data = new FormData();
                    jQuery.each( gallery, function( key, value ){
                        data.append( key, value );
                    });
        
                    data.append( 'action', 'ajax_fileload' );
                    data.append( 'nonce', nonce );
                    data.append( 'post_id', post_id);
                    data.append( 'is_gallery', true );
        
                    reply.text( 'Загружаю...' );
                    jQuery.ajax({
                        url         : 'wp-admin/admin-ajax.php',
                        type        : 'POST',
                        data        : data,
                        cache       : false,
                        dataType    : 'json',
                        processData : false,
                        contentType : false,
                        success     : function( respond, status, jqXHR ){
                            if( respond.success ){
                                reply.text( 'Успешно загружено' );
                            }
                            else {
                                reply.text( 'ОШИБКА: ' + respond.error );
                            }
                        },
                        error: function( jqXHR, status, errorThrown ){
                            reply.text( 'ОШИБКА запроса: ' + status );
                        }
                    });
                }

            } else {
                reply.text( data.message );
            }
        });
    });
});