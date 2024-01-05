$(document).ready(function() {



    $("#btn_add_customers").click(function() {

       
var name ="{{ Auth::user()->name }}";

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        
        $.ajax({
          url: "/api/utils/rt/get",
          type: "POST",
          dataType: 'json',
          contentType: 'application/json',
          data: '{"branch_id": "' + name + '"}',
          success: function(response) {
            if (response.status == "200") {
              $('#modal_add_customers').modal('show');
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



      $("#btn_confrim_add_customers").click(function () {

        var fullname = document.getElementById('fullname').value;
        if ($("#fullname").val() === "") {
    
          Swal.fire({
            type: 'warning',
            title: 'Error',
            text: 'Nama tidak boleh kosong !!'
          });
        } else if ($("#phone").val() === "") {
    
            Swal.fire({
              type: 'warning',
              title: 'Error',
              text: 'No Hp tidak boleh kosong !!'
            });
        } else if ($("#Cbrt").val() === "") {
    
            Swal.fire({
              type: 'warning',
              title: 'Error',
              text: 'RT tidak boleh kosong !!'
            });
        } else if ($("#Cbrw").val() === "") {
    
            Swal.fire({
              type: 'warning',
              title: 'Error',
              text: 'RW tidak boleh kosong !!'
            });
        } else if ($("#Cbvillage").val() === "") {
    
            Swal.fire({
              type: 'warning',
              title: 'Error',
              text: 'Desa tidak boleh kosong !!'
            });
        } else if ($("#Cbsubdistrict").val() === "") {
    
            Swal.fire({
              type: 'warning',
              title: 'Error',
              text: 'Kecamatan tidak boleh kosong !!'
            });
        } else if ($("#Cbcity").val() === "") {
    
            Swal.fire({
              type: 'warning',
              title: 'Error',
              text: 'Kota tidak boleh kosong !!'
            });
        } else if ($("#Cbzipcode").val() === "") {
    
            Swal.fire({
              type: 'warning',
              title: 'Error',
              text: 'Kode Pos tidak boleh kosong !!'
            });
        } else {
    
       var fullname = document.getElementById('fullname').value;

          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });

          var Rbgender_0 = document.getElementById("Rbgender_0");
          var Rbgender_1 = document.getElementById("Rbgender_1");

          if (Rbgender_0.checked) {
            var gender = 1;
              console.log(Rbgender_0.value);
          } else if (Rbgender_1.checked) {
            var gender = 2;
              console.log(Rbgender_0.value);
            }else{
              var gender = 0;
          }
          
          var phone = document.getElementById('phone').value;
          var address = document.getElementById('address').value;
          var remarks = document.getElementById('remarks').value;
          var rt = document.getElementById('Cbrt').value;
          var rw = document.getElementById('Cbrw').value;
          var village = document.getElementById('Cbvillage').value;
          var subdistrict = document.getElementById('Cbsubdistrict').value;
          var city = document.getElementById('Cbcity').value;
          var zipcode = document.getElementById('Cbzipcode').value;
        
    
          $.ajax({
            url: "/api/customers/add",
            type: "POST",
            dataType: 'json',
            contentType: 'application/json',
            data: '{"fullname": "' + fullname + '" , "gender": "' + gender + '" , "phone": "' + phone + '" ,"address": "' + address + '" ,"remarks": "' + remarks + '","rt": "' + rt + '","rw": "' + rw + '","village": "' + village + '","subdistrict": "' + subdistrict + '","city": "' + city + '" ,"zipcode": "' + zipcode + '"}',
            success: function (response) {
              if (response.status == "200") {
             //   $('#modal_send_info').modal('show');
                $('#spinner-div').hide();
                $('#spinner-modal').hide();
                Swal.fire({
                  type: 'success',
                  title: "Success",
                  text: response.message,
                  timer: 1500,
                  showCancelButton: false,
                  showConfirmButton: false
                })
                  .then(function () {
                    window.location.href = "/customers";
                  });
    
              } else {
                Swal.fire({
                  type: 'error',
                  title: response.message,
                  text: 'Please try again!'
                });
              }
              console.log(response);
            },
            error: function (response) {
              Swal.fire({
                type: 'error',
                title: 'Error',
                text: 'Server is having problems, please try again later.'
              });
              console.log(response);
            }
          });
    
        }
      });



});


