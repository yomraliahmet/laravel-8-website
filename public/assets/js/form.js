$(function(){
    $( document ).ajaxStart(function() {
        $( "#loading" ).show();
    });

    $("form.ajax").each(function(index, formElement){

        $(formElement).submit(function(event){
            event.preventDefault();

            $(".loading").remove();

            var formId = $(this).attr("id");
            var submitButton = $('button[form='+formId+']')[0];

            if(submitButton === undefined){
                var submitButton = $(this).find('button[type=submit]')[0];
            }

            var submitButtonHtml = submitButton.innerHTML;
            var spinnerHtml = '<div class="loading spinner-border text-light spinner-border-sm ml-1" role="status">\n' +
                '  <span class="sr-only">Loading...</span>\n' +
                '</div>';
            $(submitButton).html(submitButtonHtml+" "+spinnerHtml);

            var form = $(this);
            var url = form.attr("action");
            var formData = new FormData();

            for(var i = 0; i < form.serializeArray().length; i++){
                    formData.append(form.serializeArray()[i]["name"], form.serializeArray()[i]["value"]);
                if(form.serializeArray()[i]["value"] !== '' ){
                }
            }

            $("input[type=file]").each(function(key,fileInput){
               var fileName =  $(fileInput).attr("name");
                for(var i = 0; i < $(fileInput).prop('files').length; i++){
                    formData.append(fileName, $(fileInput).prop('files')[i]);
                }
            });
/*
            for (var key of formData.entries()) {
                console.log(key[0] + ', ' + key[1]);
            }
*/
            $.ajax({
                url: url,
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'POST',
                success: function(response) {
                    clearError();
                    if(form.hasClass("reset")){
                        form.trigger("reset");
                        $(".remove").closest(".form-group, .input-group").remove();
                        $("select").trigger('change');
                    }

                    if(response.hasOwnProperty("url")){
                        window.location = response.url;
                    }

                    if(response.hasOwnProperty("code") && response.hasOwnProperty("message")){
                        form.prepend('<div class="alert alert-'+ response.code +' col-12" role="alert">\n' +
                                         response.message +
                            '            <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                            '                <span aria-hidden="true">&times;</span>\n' +
                            '            </button>\n' +
                            '        </div>');

                        setTimeout(function(){
                            $(".alert-"+response.code).remove();
                        },3000);
                    }
                    //console.log(response);
                },
                error: function(error) {
                    displayError(error.responseJSON.data);
                },
                complete: function(){
                    $(".loading").remove();
                }
            });

            return false;
        });
    });
});

function clearError()
{
    $("ul.nav-tabs li a i").addClass("text-hide");
    $("body *").removeClass("is-invalid");
    $(".invalid-feedback").hide();
    $(".alert-danger").remove();
    $("i.error").remove();
    $(".form-group, .input-group").find(".select2-selection").css("border-color","#ced4da");

}

function displayError(errorData)
{
    clearError();
    if(errorData === undefined){
        $("form.ajax").each(function(index, formElement){
            $(formElement).before('<div class="alert alert-danger">'+ trans("messages.common.global_error") +'</div>');
        });
    }
    Object.keys(errorData).forEach(function(k,v){
        if(errorData + "."+ k !== undefined){

            var el;
            var elementName = k.split(".");
            if(elementName.length === 1){
                el = $(
                    "input[name='"+elementName[0]+"[]'"+"], input[name="+elementName[0]+"], select[name="+elementName[0]+"], select[name='"+elementName[0]+"[]'"+"]");
            }

            if(elementName.length === 2){
                if($("input[name='"+elementName[0]+"[]"+"']").length !== 0){
                    el = $("input[name='"+elementName[0]+"[]"+"']").eq(elementName[1]);
                }else{
                    el = $("input[name='"+elementName[0]+"["+elementName[1]+"]"+"']");
                }
            }

            if(el.hasClass("select2")){
                $(".select2-container").append('<i class="fas fa-exclamation-circle error" style="position: absolute;\n' +
                    '    color: #dc3545;\n' +
                    '    right: 0;\n' +
                    '    margin-top: -26px;\n' +
                    '    margin-right: 8px;\n' +
                    '}"></i>');

                el.closest(".form-group, .input-group").find(".select2-selection").css("border-color","#fe5461");
            }


            el.addClass("is-invalid");
            el.closest(".form-group, .input-group").find(".invalid-feedback").html(errorData[k][0]).css("display","block");
            var lang = el.closest(".tab-pane").attr("id");
            if(lang !== undefined){
                $(".tab-warning-"+ lang).removeClass("text-hide");
            }
        }
    });
}

function readURL(input, previewElement) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(previewElement).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
