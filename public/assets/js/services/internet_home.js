$(document).ready(function() {




  $("#btn_add_internet_home").click(function() {

      var ringkasan = document.getElementById("ringkasan");

      ringkasan.style.display = "none"; // Show the div

   var name ="{{ Auth::user()->name }}";

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      
      $.ajax({
        url: "/api/customers/get",
        type: "POST",
        dataType: 'json',
        contentType: 'application/json',
        data: '{"branch_id": "' + name + '"}',
        success: function(response) {
          if (response.status == "200") {
              //add array customers
               var selectElement = $("#CbCustomers");
               selectElement.empty();

               $.each(response.data, function(index, option) {
                  var optionElement = $("<option>")
                      .val(option.customer_id)
                      .text(option.fullname);
                  selectElement.append(optionElement);
              });

              get_service_items();


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


    function get_service_items() {

      var service_id =1;

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      
      $.ajax({
        url: "/api/services/service_items/get",
        type: "POST",
        dataType: 'json',
        contentType: 'application/json',
        data: '{"service_id": "' + service_id + '"}',
        success: function(response) {
          if (response.status == "200") {
              //add array customers
               var selectElement = $("#CbPackageInternetHome");
               selectElement.empty();

               $.each(response.data, function(index, option) {
                  var optionElement = $("<option>")
                      .val(option.service_item_id)
                      .text(option.name);
                  selectElement.append(optionElement);
              });

              get_payments_method();


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

    }


    
    function get_payments_method() {

      var name ="{{ Auth::user()->name }}";

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      
      $.ajax({
        url: "/api/utils/payments_method/get",
        type: "POST",
        dataType: 'json',
        contentType: 'application/json',
        data: '{"branch_id": "' + name + '"}',
        success: function(response) {
          if (response.status == "200") {
              //add array customers
               var selectElement = $("#CbPaymentsMethod");
               selectElement.empty();

               $.each(response.data, function(index, option) {
                  var optionElement = $("<option>")
                      .val(option.id)
                      .text(option.name);
                  selectElement.append(optionElement);
              });


            $('#modal_add_internet_home').modal('show');
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

    }

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
          data: '{"fullname": "' + fullname + '" , "gender": "' + gender + '" , "phone": "' + phone + '" ,"address": "' + address + '" ,"rt": "' + rt + '","rw": "' + rw + '","village": "' + village + '","subdistrict": "' + subdistrict + '","city": "' + city + '" ,"zipcode": "' + zipcode + '"}',
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




  //   document.getElementById("CbPackageInternetHome").addEventListener("change", function() {
  //     var service_item_id = 1; // Get the selected value

  //     $.ajaxSetup({
  //       headers: {
  //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //       }
  //     });
      
  //     $.ajax({
  //       url: "/api/services/service_items/get",
  //       type: "POST",
  //       dataType: 'json',
  //       contentType: 'application/json',
  //       data: '{"service_id": "' + service_id + '"}',
  //       success: function(response) {
  //         if (response.status == "200") {
  //             var ringkasan = document.getElementById("ringkasan");

  //             ringkasan.style.display = "block"; // Show the div

  //             var data = response.data[0];


  //             count_prorate(data.price);

  //             $('#lblPrice').html("Rp. " + formatPriceWithoutComma(data.price));
  //             $('#lblPpn').html("Rp. " + formatPriceWithoutComma(data.ppn));
  //             $('#lblInstallationFee').html("Rp. " + formatPriceWithoutComma(data.installation_fee));       

  //         } else {
  //           Swal.fire({
  //             type: 'error',
  //             title: response.message,
  //             text: 'Please try again!'
  //           });
  //         }
  //         console.log(response);
  //       },
  //       error: function(response) {
  //         Swal.fire({
  //           type: 'error',
  //           title: 'Error',
  //           text: 'Server is having problems, please try again later.'
  //         });
  //         console.log(response);
  //       }
  //     });

   
  // });

  function count_prorate(formattedPrice) {


      $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        
        $.ajax({
          url: "/api/utils/prorate/get",
          type: "POST",
          dataType: 'json',
          contentType: 'application/json',
          data: '{"price": "' + formattedPrice + '"}',
          success: function(response) {
            if (response.status == "200") {

              var formattedProrate = new Intl.NumberFormat('id-ID', {
                  style: 'currency',
                  currency: 'IDR'
              }).format(response.data);


                $('#lblProrate').html("Rp. " + formatPriceWithoutComma(response.data));

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

  }

  function formatPriceWithoutComma(price) {
      return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }


    $("#btn_confrim_add_service_internet_home").click(function () {


      if ($("#CbCustomers").val() === "") {
  
        Swal.fire({
          type: 'warning',
          title: 'Error',
          text: 'Customers tidak boleh kosong !!'
        });
      } else if ($("#CbPackageInternetHome").val() === "") {
  
          Swal.fire({
            type: 'warning',
            title: 'Error',
            text: 'Paket Internet tidak boleh kosong !!'
          });
       
      } else {
  


        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        var customer_id = document.getElementById('CbCustomers').value;
        var service_item_id = document.getElementById('CbPackageInternetHome').value;
       var installation_date = document.getElementById('installation_date').value;

        $.ajax({
          url: "/api/services/add",
          type: "POST",
          dataType: 'json',
          contentType: 'application/json',
          data: '{"customer_id": "' + customer_id + '" , "service_item_id": "' + service_item_id + '", "installation_date": "' + installation_date + '" }',
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
                  window.location.href = "/services/internet/home";
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



    $('#btn_search_service_internet_home').click(function () {

      $('#spinner-div').show();
      $('#spinner-modal').show();
  
      $.ajaxSetup({
  
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
  
      });
  
      $.ajax({
  
        url: '/api/inventory/fragments/modal/edc',
  
        method: "POST",
  
        data: { "warehouse_id": "05-CBN", "sn": $('#txt_search_edc').val() },
  
        success: function (data) {
  
          $('#FragmentEDC').html(data);
  
  
        }
  
      });
  
  
    });

    
}); 

function action_internet_home(button) {

  clear_form ();
    
   var service_member_id = button.getAttribute("data-id");
  
  
         
         $.ajaxSetup({
           headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
         });
         
         $.ajax({
           url: "/api/services/service_members/get",
           type: "POST",
           dataType: 'json',
           contentType: 'application/json',
           data: '{"service_member_id": "'+ service_member_id +'"}',
           success: function(response) {
             if (response.status == "200") {
                 //add array customers
                 var action_fullname = $("#action_fullname");
                 var action_service_member_id = $("#action_service_member_id");
                 var action_item_name = $("#action_item_name");
                 var action_price = $("#action_price");
   
                 action_fullname.empty();
                 action_service_member_id.empty();
                 action_item_name.empty();
                 action_price.empty();
   
                 $.each(response.data, function(index, option) {
                  action_fullname.val (option.fullname);
                  action_service_member_id.val (option.service_member_id);
                  action_item_name.val (option.service_item_name);
                  action_price.val (option.price);
                
                  get_profile();
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
           error: function(response) {
             Swal.fire({
               type: 'error',
               title: 'Error',
               text: 'Server is having problems, please try again later.'
             });
             console.log(response);
           }
         });
   }

   function get_profile() {
 
    var name ="{{ Auth::user()->name }}";

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    
    $.ajax({
      url: "/api/services/profile/get",
      type: "POST",
      dataType: 'json',
      contentType: 'application/json',
      data: '',
      success: function(response) {
        if (response.status == "200") {
            //add array customers
             var selectElement = $("#action_profile");
             selectElement.empty();

             $.each(response.data, function(index, option) {
                var optionElement = $("<option>")
                    .val(option.service_profile_id)
                    .text(option.name);
                selectElement.append(optionElement);
            });


            $('#modal_action_internet_home').modal('show');
            $('#spinner-div').hide();
            $('#spinner-modal').hide();

        } else {
          clear_form ();
          Swal.fire({
            type: 'error',
            title:'Error',
            text: response.message,
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

  }

  $("#btn_confrim_action_service_internet_home").click(function () {
 


      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      var profile_name = document.getElementById('action_profile').value;
      var service_member_id = document.getElementById('action_service_member_id').value;
   

      $.ajax({
        url: "/api/services/service_members/action/confrim",
        type: "POST",
        dataType: 'json',
        contentType: 'application/json',
        data: '{"profile_name": "' + profile_name + '"  , "service_member_id": "' + service_member_id + '"}',
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
                window.location.href = "/services/internet/home";
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

  
  });

  function clear_form () {
   
     
  
    // var payment_type = document.getElementById("payment_type");
    // payment_type.selectedIndex = 0; // Thi
    
    // var status_id = document.getElementById("status_id");
    // status_id.selectedIndex = 0; // Thi
    
    //  var CbPaymentsMethod = document.getElementById("CbPaymentsMethod");
    // CbPaymentsMethod.selectedIndex = 0; // Thi
    
    }

  document.getElementById("action_profile").addEventListener("change", function(e) {

    // Get the current date and time in GMT (UTC)
    const currentDateInGMT = new Date();
    
    // Define the GMT+7 time zone offset in minutes (7 hours ahead of GMT)
    const timeZoneOffsetInMinutes = 7 * 60;
    
    // Calculate the date and time in GMT+7 by adding the offset
    const currentDateInGMTPlus7 = new Date(currentDateInGMT.getTime() + timeZoneOffsetInMinutes * 60000);
    
    const monthInGMTPlus7 = currentDateInGMTPlus7.getMonth() + 1; // Adding 1 because months are zero-based (0 for January)
   
      //  $.ajaxSetup({
      //        headers: {
      //          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      //        }
      //      });
           
      //      $.ajax({
      //        url: "/api/services/profile/secret/get",
      //        type: "POST",
      //        dataType: 'json',
      //        contentType: 'application/json',
      //        data: '{"service_profile_id": "' + e.target.value + '"}',
      //        success: function(response) {
      //          if (response.status == "200") {
    
      //       //add array customers
      //       var selectElement = $("#action_local_address");
      //       selectElement.empty();

      //       $.each(response.data, function(index, option) {
      //          var optionElement = $("<option>")
      //              .val(option.local_address)
      //              .text(option.local_address);
      //          selectElement.append(optionElement);
      //      });

      //         //add array customers
      //         var selectElement = $("#action_remote_address");
      //         selectElement.empty();
           
      //          $.each(response.data, function(index, option) {
      //          var optionElement = $("<option>")
      //           .val(option.remote_address)
      //           .text(option.remote_address);
      //           selectElement.append(optionElement);
      //           });
     
      //          } else {
      //            Swal.fire({
      //              type: 'error',
      //              title: response.message,
      //              text: 'Please try again!'
      //            });
      //          }
      //          console.log(response);
      //        },
      //        error: function(response) {
      //          Swal.fire({
      //            type: 'error',
      //            title: 'Error',
      //            text: 'Server is having problems, please try again later.'
      //          });
      //          console.log(response);
      //        }
      //      });
    
      
    
        
          
    
    
      
     
         });

