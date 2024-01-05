$(document).ready(function() {

  var service_member_id = "" ;
  
   $("#btn_add_invoice").click(function() {
 
     clear_form();
	
     $('#modal_add_invoice').modal('show');
     });
 
 

 
     $("#btn_confrim_action_service").click(function () {
 
       if ($("#invoice_id").val() === "") {
   
         Swal.fire({
           type: 'warning',
           title: 'Error',
           text: 'No Invoice tidak boleh kosong !!'
         });
       } else if ($("#CbPaymentsMethod").val() === "") {
   
           Swal.fire({
             type: 'warning',
             title: 'Error',
             text: 'Metode Pembayaran tidak boleh kosong !!'
           });
       } else if ($("#status_id").val() === "") {
   
           Swal.fire({
             type: 'warning',
             title: 'Error',
             text: 'Status tidak boleh kosong !!'
           });
 
       } else {
   
 
         $.ajaxSetup({
           headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
         });
 
         var invoice_id = document.getElementById('invoice_id').value;
         var payments_method = document.getElementById('CbPaymentsMethod').value;
         var status_id = document.getElementById('status_id').value;
         var payments_date = document.getElementById('payments_date').value;
      
   
         $.ajax({
           url: "/api/invoices/approved",
           type: "POST",
           dataType: 'json',
           contentType: 'application/json',
           data: '{"invoice_id": "' + invoice_id + '" , "payments_date": "' + payments_date + '" , "payments_method": "' + payments_method + '" , "status_id": "' + status_id  + '"}',
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
                   window.location.href = "/invoices";
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
 
 
 function clear_form () {
   
     
 var fullname = document.getElementById("fullname");
 var price = document.getElementById("price");
 var service_member_id = document.getElementById("service_member_id");
 var search_service_member_id = document.getElementById("search_service_member_id");
 var service_item_name = document.getElementById("service_item_name");
 var total_bill = document.getElementById("total_bill");
 var remarks = document.getElementById("remarks");
var invoice_id = document.getElementById("invoice_id");
 var action_customer_name = document.getElementById("action_service_item_name");
var action_total_bill = document.getElementById("action_total_bill");
var action_remarks = document.getElementById("action_remarks");
 var due_date = document.getElementById("due_date");
 
 
 
 

 search_service_member_id.value = "";
 fullname.value = "";
 price.value = "";
   service_member_id.value = "";
   service_member_id = "";
 service_item_name.value = "";
 total_bill.value = ""
 remarks.value = "";
  invoice_id.value = "";
  action_customer_name.value = "";
   action_total_bill.value = "";
    action_remarks.value = "";
    due_date.value = "";

 var payment_type = document.getElementById("payment_type");
 payment_type.selectedIndex = 0; // Thi
 
 var status_id = document.getElementById("status_id");
 status_id.selectedIndex = 0; // Thi
 
  var CbPaymentsMethod = document.getElementById("CbPaymentsMethod");
 CbPaymentsMethod.selectedIndex = 0; // Thi
 
 }
 

   

 $("#search_service_member_id").on("keydown",function search(e) {
   
   if(e.keyCode == 13) {
       var search_service_member_id = ($(this).val());
 
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
         data: '{"service_member_id": "' + search_service_member_id + '"}',
         success: function(response) {
           if (response.status == "200") {
               var fullname = $("#fullname");
               var price = $("#price");
        var service_item_name = $("#service_item_name");
        var service_member_id2 = $("#service_member_id");
          var due_date = $("#due_date");
               fullname.empty();
               price.empty();
               service_item_name.empty();
				due_date.empty();
				
               $.each(response.data, function(index, option) {
                service_member_id2.val (option.service_member_id);
        service_member_id = (option.service_member_id);
                   fullname.val (option.fullname);
                   price.val (option.price);
            service_item_name.val (option.service_item_name);
			due_date.val (option.due_date);
              });
 
               $('#spinner-div').hide();
               $('#spinner-modal').hide();
 
           } else {
       clear_form();
             Swal.fire({
               type: 'error',
               title: response.message,
               text: 'Please try again!'
             });
           }
           console.log(response);
         },
         error: function(response) {
       clear_form();
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
 
 $("#search_invoices").on("keydown",function search(e) {
   
  if(e.keyCode == 13) {
      var search = ($(this).val());

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
        data: '{"search": "' + search + '"}',
        success: function(response) {
          if (response.status == "200") {
              var fullname = $("#fullname");
              var price = $("#price");
       var service_item_name = $("#service_item_name");
       var service_member_id2 = $("#service_member_id");
         var due_date = $("#due_date");
              fullname.empty();
              price.empty();
              service_item_name.empty();
       due_date.empty();
       
              $.each(response.data, function(index, option) {
               service_member_id2.val (option.service_member_id);
       service_member_id = (option.service_member_id);
                  fullname.val (option.fullname);
                  price.val (option.price);
           service_item_name.val (option.service_item_name);
     due_date.val (option.due_date);
             });

              $('#spinner-div').hide();
              $('#spinner-modal').hide();

          } else {
      clear_form();
            Swal.fire({
              type: 'error',
              title: response.message,
              text: 'Please try again!'
            });
          }
          console.log(response);
        },
        error: function(response) {
      clear_form();
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

document.getElementById("payment_type").addEventListener("change", function(e) {




  if (service_member_id == "") {
    
      Swal.fire({
        type: 'error',
        title: "Error",
        text: 'Data has not been filled in!'
        });
    
  }else{
var price = document.getElementById("price").value;

  if (e.target.value === "1") {
	     $.ajaxSetup({
         headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
       });
       
       $.ajax({
         url: "/api/utils/date/get",
         type: "POST",
         dataType: 'json',
         contentType: 'application/json',
         data: '{}',
         success: function(response) {
           if (response.status == "200") {

 
			    var due_date = $("#due_date");
				due_date.empty();
			   $('#total_bill').val(price);
			   $('#remarks').val("Pembayaran Internet " + response.date_fy);
			   due_date.val (response.date_ym + "-28");
			   
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
	   

	
  }else  if (e.target.value === "2") {
	  var due_date = document.getElementById("due_date").value;
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
         data: '{"price": "' + price + '" , "start_date": "' + due_date + '" }',
         success: function(response) {
           if (response.status == "200") {

               //var data = response.data[0];
 
 
               //count_prorate(data.price);
 
               $('#total_bill').val(response.data);
               $('#remarks').val("Prorate Pembayaran Internet");
 
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

	

    }else {
		
		Swal.fire({
             type: 'error',
             title: 'Error',
             text: 'Error'
           });

	}
			
}

  
 
     });


     $("#btn_confrim_invoice").click(function () {
 
       if ($("#fullname").val() === "") {
   
         Swal.fire({
           type: 'warning',
           title: 'Error',
           text: 'Nama pelanggan tidak boleh kosong !!'
         });
       } else if ($("#total_bill").val() === "") {
   
           Swal.fire({
             type: 'warning',
             title: 'Error',
             text: 'Total tagihan tidak boleh kosong !!'
           });
       } else if ($("#price").val() === "") {
   
           Swal.fire({
             type: 'warning',
             title: 'Error',
             text: 'Harga tidak boleh kosong !!'
           });
 
       } else {
   
 
         $.ajaxSetup({
           headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
         });
 
         var service_member_id = document.getElementById('service_member_id').value;
         var total_bill = document.getElementById('total_bill').value;
		var remarks = document.getElementById('remarks').value;
		var due_date = document.getElementById('due_date').value;
   
         $.ajax({
           url: "/api/invoices/add",
           type: "POST",
           dataType: 'json',
           contentType: 'application/json',
           data: '{"service_member_id": "' + service_member_id + '" , "total_bill": "' + total_bill + '" , "remarks": "' + remarks  + '", "due_date": "' + due_date  + '"}',
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
                   window.location.href = "/invoices";
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
 
  function action_invoices(button) {

 
    //clear_form();
	
 var invoice_id = button.getAttribute("data-id");


			 
       $.ajaxSetup({
         headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
       });
       
       $.ajax({
         url: "/api/invoices/get",
         type: "POST",
         dataType: 'json',
         contentType: 'application/json',
         data: '{"invoice_id": "'+ invoice_id +'"}',
         success: function(response) {
           if (response.status == "200") {
               //add array customers
               var invoice_id = $("#invoice_id");
               var customer_name = $("#action_customer_name");
               var service_item_name = $("#action_service_item_name");
               var total_bill = $("#action_total_bill");
               var remarks = $("#action_remarks");
 
               invoice_id.empty();
               customer_name.empty();
               service_item_name.empty();
               total_bill.empty();
               remarks.empty();
 
               $.each(response.data, function(index, option) {
                   invoice_id.val (option.invoice_id);
                   customer_name.val (option.customer_name);
                   service_item_name.val (option.service_item_name);
                   total_bill.val (option.total_bill);
                   remarks.val (option.remarks);
              });
 
               get_payments_method();
               $('#modal_action_invoice').modal('show');
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
 
   function send_invoice_wa(button) {

 
    //clear_form();
	
 var invoice_id = button.getAttribute("data-id");


			 
       $.ajaxSetup({
         headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
       });
       
       $.ajax({
         url: "/api/invoices/send_wa",
         type: "POST",
         dataType: 'json',
         contentType: 'application/json',
         data: '{"invoice_id": "'+ invoice_id +'"}',
         success: function(response) {
           if (response.status == "200") {
               //add array customers
         var popupUrl = response.data;

    // Membuka jendela popup dengan ukuran yang Anda inginkan
    window.open(popupUrl, "_blank", "width=600,height=400");


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
                       .val(option.name)
                       .text(option.name);
                   selectElement.append(optionElement);
               });
 
 
               $('#modal_action_invoice').modal('show');
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