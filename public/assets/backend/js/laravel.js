(function(window, $, undefined) {

  var Laravel = {
    initialize: function() {
      this.selector = 'a[data-method]';
      this.registerEvents();
    },

    registerEvents: function() {
        $(document).on('click',this.selector, this.handleMethod);
    },
    handleMethod: function(e) {
      e.preventDefault()

      var link = $(this)
      var httpMethod = link.data('method').toUpperCase()
      var form

      // If the data-method attribute is not PUT or DELETE,
      // then we don't know what to do. Just ignore.
      if ($.inArray(httpMethod, ['PUT', 'DELETE']) === -1) {
        return false
      }

      Laravel
          .verifyConfirm(link)
          .done(function () {
            form = Laravel.createForm(link)
              if(!link.data('ajax')){
                  form.submit();
              }else{
                  var post = $.post(form.attr('action'),form.serialize());
                  post.done(function(){
                      Swal.fire({
                          position: 'top-end',
                          icon: 'success',
                          title: trans("messages.common.success_message"),
                          showConfirmButton: false,
                          timer: 1500
                      });

                      link.closest("table").DataTable().draw(false);
                  });
              }
          })
    },
    verifyConfirm: function(link) {
        var confirm = new $.Deferred()

         Swal.fire({
            title: link.data('confirm'),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: "<i class='fas fa-check-circle'></i> "+ trans("admin.common.confirm"),
            cancelButtonText: "<i class='far fa-times-circle'></i> "+trans_choice("admin.common.cancel"),
        }).then((result) => {
            if (result.isConfirmed) {
                confirm.resolve(link);
            }else{
                confirm.reject(link);
            }
        });

        return confirm.promise()
    },

    createForm: function(link) {
      var form =
          $('<form>', {
            'method': 'POST',
            'action': link.attr('href'),
          });

      var token =
          $('<input>', {
            'type': 'hidden',
            'name': '_token',
            'value': link.data('token')
          });

      var hiddenInput =
          $('<input>', {
            'name': '_method',
            'type': 'hidden',
            'value': link.data('method')
          });

      return form.append(token, hiddenInput)
          .appendTo('body');
    }
  };

  Laravel.initialize();

})(window, jQuery);
