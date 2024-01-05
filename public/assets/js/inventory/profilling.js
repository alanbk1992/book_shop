$(document).ready(function() {
$('#btn_confrim_profilling').click(function() {

    if (profilling_unit_available.length == 0) {
           Swal.fire({
             type: 'warning',
             title: 'Failed',
             text: 'You have uploaded units yet !'
           });
   
         
         }else{
   
           console.log("jsonOutput", JSON.stringify(profilling_unit_available, null, 2));
   
           $.ajaxSetup({
             headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
           });
           $.ajax({
             url: "/api/inventory/fragments/modal/profilling/confrim_send_profilling",
             type: "POST",
             dataType: 'json',
             contentType: 'application/json',
             data: '{"warehouse_id":"ING-MNS" , "profilling_unit": ' + JSON.stringify(profilling_unit_available) + '}',
             success: function(response) {
               if (response.status == "200") {
   
                 Swal.fire({
                       type: 'success',
                       title: response.message,
                       text: 'Data sent successfully',
                      timer: 3000,
                       showCancelButton: false,
                       showConfirmButton: false
                     })
                     .then (function() {
                      window.location.href = "/inventory/edc";
                     });
   
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
   
      });



      function refreshProfillingUnit (profilling_unit_available) {
	

        var output = '';
        $.each(profilling_unit_available, function(index, element , no = 1) {
        var row = '<tr>' +
       '<td>' + index + '</td>' +
       '<td>' + element.sn + '</td>' +
       '<td>' + element.spk_no + '</td>' +
       '<td>' + element.tid + '</td>' +
       '<td>' + element.tid2 + '</td>' +
       '<td>' + element.mid + '</td>' +
       '<td>' + element.merchant + '</td>' +
       '<td>' + element.address + '</td>' +
       '<td>' + element.city + '</td>' +
       '<td>' + element.zipcode + '</td>' +
       '<td>' + element.warehouse_id + '</td>' +
       '<td>' + element.location_id + '</td>' +
       '<td>' + element.installation_date + '</td>' +
       '<td>' + element.job_type + '</td>' +
       '<td>' + element.remarks + '</td>' +
       '<td>' + element.status_upload + '</td>' +
       '<td><button onclick="deleteEdc(' + index + ')" class="btn btn-default btn-rounded btn-sm"><i class="bi bi-trash-fill fs-5 me-1"></i></button></td>' +
       '</tr>';
       output += row;
       
      
     });
    
    $('#lbl_profilling_available').html(profilling_unit_available.length + " Unit");
    $('#lbl_total_profilling').html(profilling_unit_available.length);
    $('#lbl_total_profilling_upload').html(profilling_unit_available.length + " Unit");
    $('#FragmentProfillingUnit').html(output);
                        
    }



    $('#Bunit_profilling').click(function() {
	
        $('#modal_profilling_unit').modal('show');
    });	 


var profilling_unit_available = [] ;
var profilling_unit_not_found = [] ;	

$('#Bupload_profilling').click(function() {

  $('#Iupload_profilling').trigger('click');

        $('#Iupload_profilling').change(function() {
          if (document.getElementById("Iupload_profilling").files.length == 0) {} else {
            var excelFile = $(this).val();
            $('#spinner-modal').show();
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });


            var data = new FormData();
            jQuery.each(jQuery('#Iupload_profilling')[0].files, function(i, file) {
              data.append('excelFile', file);
            });
            jQuery.ajax({
              url: '/api/inventory/fragments/modal/profilling/preview_upload_profilling',
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
                 
           var jsonArray = json.available;

           for (var i = 0; i < jsonArray.length; i++) {

            var newData = {"sn": jsonArray[i].sn, 
                          "spk_no": jsonArray[i].spk_no,
                          "tid": jsonArray[i].tid,
                          "tid2": jsonArray[i].tid2,
                          "mid": jsonArray[i].mid,
                          "merchant": jsonArray[i].merchant,
                          "address": jsonArray[i].address,
                          "city": jsonArray[i].city,
                          "zipcode": jsonArray[i].zipcode,
                          "warehouse_id": jsonArray[i].warehouse_id,
                          "location_id": jsonArray[i].location_id,
                          "installation_date": jsonArray[i].installation_date,
                          "job_type": jsonArray[i].job_type,
                          "remarks": jsonArray[i].remarks,
                          "status_upload": jsonArray[i].status_upload};
            console.log(newData);
            profilling_unit_available.push(newData);

           }
            
		   refreshProfillingUnit(profilling_unit_available);

           Swal.fire({
           type: 'success',
           title: 'Success',
           text: json.message
            });

           
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
    });


    $("#btn_profilling").click(function() {

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
              $('#modal_profilling').modal('show');
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

    
 