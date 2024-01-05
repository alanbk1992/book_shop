$(document).ready(function() {



    $("#btn_view").click(function() {

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        
        $.ajax({
          url: "/api/warehouse/get",
          type: "POST",
          dataType: 'json',
          contentType: 'application/json',
          data: '{}',
          success: function(response) {
            if (response.status == "200") {
              $('#modal_view').modal('show');
              $('#spinner-div').hide();
              $('#spinner-modal').hide();
            } else {
              Swal.fire({
                type: 'error',
                title: response.message,
                text: 'Please try again!'
              });
            }
            console.log(response);
          },
          error: function(response) {
            Swal.fire({
              type: 'error',
              title: 'Error',
              text: 'Server is having problems, please try again later.'
            });
            console.log(response);
          }
        });
      });



});