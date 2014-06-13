jQuery( document ).ready(function( $ ) {

    /*Тут надо сделать Ajax  запрос и после получении ответа запускать atwho*/
    $.ajax({
        url         : "AT_JS_Plugin.php",
        type        : "POST",
        dataType    : 'json',
        data        : "cmd=AJAXRqst",
        success     : function(data){
                                        $(data.Selector).atwho({
                                            at: data.atChar,
                                            data: data.WP_Users
                                        });
                                    }
        });

});