$("#login-form").submit(function(){
    $("#spinner").css("display","block");
    $("#alert-content").html("");
    var url = $(this).attr("action");
    var data = $('#login-form').serialize();
    var post = $.post(url,data);

    post.done(function(data){
        $("#spinner").hide();
        if(data.url){
            window.location = data.url;
        }
    });

    post.fail(function(jqXHR, textStatus, errorThrown){
        var status_message = "";
        $("#spinner").hide();
        if(jqXHR.status === 400){
            status_message = jqXHR.responseJSON.message;
        }
        else if(jqXHR.status === 403){
            status_message = jqXHR.responseJSON.message;
        }
        else if(jqXHR.status === 0){
            status_message = trans('messages.common.connection_refused');
        }
        else{
            status_message = errorThrown;
            if(status_message === ""){
                status_message = trans('messages.common.global_error');
            }
        }
        var alert = '<div class="alert alert-danger mt-2 pt-2 pb-2">'+status_message+'</div>';
        $("#alert-content").html(alert);
        setTimeout(function(){
            $(".alert").hide(300);
        },3000);
    });
});
