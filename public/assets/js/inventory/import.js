$(document).ready(function() {

$('#Bupload_warranty').click(function() {
    if ($("#Cbinventory_type").val() === "") {
      Swal.fire({
        type: 'warning',
        title: 'Failed',
        text: 'Please select an inventory type!'
      });
    } else if ($("#Cbwarehouse").val() === "") {
      Swal.fire({
        type: 'warning',
        title: 'Failed',
        text: 'Please select a warehouse !'
      });
    } else if ($("#Cbcustomer").val() === "") {
      Swal.fire({
        type: 'warning',
        title: 'Failed',
        text: 'Please select a customer !'
      });
    } else if ($("#Cbend_customer").val() === "") {
      Swal.fire({
        type: 'warning',
        title: 'Failed',
        text: 'Please select an end customer !'
      });
    } else {
      $('#upload_warranty').trigger('click');
      $("#upload_warranty").change(function() {
        if (document.getElementById("upload_warranty").files.length == 0) {} else {
          var excelFile = $(this).val();
          $('#spinner-modal').show();
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          var inventory_type = $('#Cbinventory_type').find(":selected").val();
          var warehouse_id = $('#Cbwarehouse').find(":selected").val();
          var customer = $('#Cbcustomer').find(":selected").val();
          var end_customer = $('#Cbend_customer').find(":selected").val();
          var data = new FormData();
          jQuery.each(jQuery('#upload_warranty')[0].files, function(i, file) {
            data.append('inventory_type', inventory_type);
            data.append('warehouse_id', warehouse_id);
            data.append('customer', customer);
            data.append('end_customer', end_customer);
            data.append('excelFile', file);
          });
          jQuery.ajax({
            url: '/api/inventory/edc/upload/insert',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(response) {
              var json = $.parseJSON(response);
              if (json.status == 200) {
                $('#spinner-div').hide();
                $('#spinner-modal').hide();
                // Swal.fire({
                //   type: 'success',
                //   title: 'Success',
                //   text: json.message
                // });

                Swal.fire({
                  type: 'success',
                  title: "Success",
                  text: json.message,
                 timer: 1500,
                  showCancelButton: false,
                  showConfirmButton: false
                })
                .then (function() {
                 window.location.href = "/inventory/edc";
                });
              



                $('#Cbinventory_type').prop('selectedIndex', 0);
                $('#Cbwarehouse').prop('selectedIndex', 0);
                $('#Cbcustomer').prop('selectedIndex', 0);
                $('#Cbend_customer').prop('selectedIndex', 0);
              } else {
                $('#spinner-div').hide();
                $('#spinner-modal').hide();
                Swal.fire({
                  type: 'error',
                  title: 'Error',
                  text: json.message
                });
              }
              console.log(response);
            },
            error: function(response) {
              $('#spinner-div').hide();
              $('#spinner-modal').hide();
              Swal.fire({
                type: 'error',
                title: 'Error',
                text: 'Data error, please try again later.'
              });
              console.log(response);
            }
          });
        }
      });
    }
  });

  $('#Bwarranty_unit').click(function() {
    $('#Cbinventory_type').prop('selectedIndex', 0);
    $('#Cbwarehouse').prop('selectedIndex', 0);
    $('#Cbcustomer').prop('selectedIndex', 0);
    $('#Cbend_customer').prop('selectedIndex', 0);
    $('#modal_warranty_unit').modal('show');
  });


  $("#btn_warranty_info").click(function() {
    $('#spinner-div').show();
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
            // var myModal = new bootstrap.Modal(document.getElementById('myModal'));
        //myModal.show();
        
          $('#modal_warranty_info').modal('show');
      
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