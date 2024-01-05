$(document).ready(function () {
  $("#btn_confrim_send").click(function () {

    if (edc.length == 0) {

      Swal.fire({
        type: 'warning',
        title: 'Failed',
        text: 'You have not selected units'
      });

    } else {


      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      var Torder_no_send = document.getElementById('Torder_no_send').value;
      var Tbast_no = document.getElementById('Tbast_no').value;
      var txt_order_date_send = document.getElementById('txt_order_date_send').value;
      var txt_bast_date = document.getElementById('txt_bast_date').value;
      var Rbreceiver_type_0 = document.getElementById('Rbreceiver_type_0').value;
      var Tcourier = document.getElementById('Tcourier').value;
      var Cbreceiver = document.getElementById('Cbreceiver').value;
      var TAWB = document.getElementById('TAWB').value;
      var edcString = JSON.stringify(edc, null, 2);
      var qty = document.getElementById('lbl_qty').innerHTML;


      $.ajax({
        url: "/api/inventory/edc/send/confirm",
        type: "POST",
        dataType: 'json',
        contentType: 'application/json',
        data: '{"Torder_no_send": "' + Torder_no_send + '" , "Tbast_no": "' + Tbast_no + '" , "txt_order_date_send": "' + txt_order_date_send + '" ,"txt_bast_date": "' + txt_bast_date + '" ,"Rbreceiver_type_0": "' + Rbreceiver_type_0 + '" ,"Tcourier": "' + Tcourier + '" ,"Cbreceiver": "' + Cbreceiver + '" ,"TAWB": "' + TAWB + '" ,"qty": "' + qty + '" ,"edc": ' + edcString + '}',
        success: function (response) {
          if (response.status == "200") {
            $('#modal_send_info').modal('show');
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
                window.location.href = "/inventory/edc";
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


  $("#btn_send_info").click(function () {

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
      success: function (response) {
        if (response.status == "200") {
          $('#modal_send_info').modal('show');
          // $('#modal_send_unit').modal('show');
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

  $(document).ready(function () {

    const Bupload_send_unit = document.getElementById('Bupload_send_unit');
    const upload_send_unit = document.getElementById('upload_send_unit');
	
    Bupload_send_unit.addEventListener('click', function () {
      Bupload_send_unit.disabled = true;

      $('#upload_send_unit').trigger('click');
      $("#upload_send_unit").change(function () {
        if (document.getElementById("upload_send_unit").files.length == 0) { 
		
		} else {
			
          var excelFile = $(this).val();
          $('#spinner-modal').show();
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });

          var data = new FormData();
          jQuery.each(jQuery('#upload_send_unit')[0].files, function (i, file) {
            data.append('excelFile', file);
          });
		  $.ajax({
          
            url: '/api/inventory/fragments/modal/edc/upload_send_unit',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function (response) {
              var json = $.parseJSON(response);
              if (json.status == 200) {
                $('#spinner-div').hide();
                $('#spinner-modal').hide();

                var jsonArray = json.data;

                for (var i = 0; i < jsonArray.length; i++) {

                  var newData = { "customer": jsonArray[i].customer, "sn": jsonArray[i].sn };
                  console.log(newData);
                  edc.push(newData);
                  var edcString = JSON.stringify(edc, null, 2);

                }

                refreshEdc(edc);

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
            //  console.log(response);
            },
            error: function (response) {
              $('#spinner-div').hide();
              $('#spinner-modal').hide();
              Swal.fire({
                type: 'error',
                title: 'Error',
                text: 'Data error, please try again later.'
              });
             // console.log(response);
            }
          });
		  
        }
      });

      setTimeout(function () {
        Bupload_send_unit.disabled = false;
      }, 1000); // Setelah 1 detik, tombol akan diaktifkan kembali
    });
  });



  // $('#Bupload_send_unit').click(function() {

  //     $('#upload_send_unit').trigger('click');
  //           $("#upload_send_unit").change(function() {
  //             if (document.getElementById("upload_send_unit").files.length == 0) {} else {
  //               var excelFile = $(this).val();
  //               $('#spinner-modal').show();
  //               $.ajaxSetup({
  //                 headers: {
  //                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //                 }
  //               });

  //               var data = new FormData();
  //               jQuery.each(jQuery('#upload_send_unit')[0].files, function(i, file) {
  //                 data.append('excelFile', file);
  //               });
  //               jQuery.ajax({
  //                 url: '/api/inventory/fragments/modal/edc/upload_send_unit',
  //                 data: data,
  //                 cache: false,
  //                 contentType: false,
  //                 processData: false,
  //                 method: 'POST',
  //                 type: 'POST',
  //                 success: function(response) {
  //                   var json = $.parseJSON(response);
  //                   if (json.status == 200) {
  //                     $('#spinner-div').hide();
  //                     $('#spinner-modal').hide();

  //                     var jsonArray = json.data;

  //              for (var i = 0; i < jsonArray.length; i++) {

  //               var newData = {"customer": jsonArray[i].customer, "sn": jsonArray[i].sn};
  //               console.log(newData);
  //               edc.push(newData);
  //               var edcString = JSON.stringify(edc, null, 2);

  //              }

  //             refreshEdc(edc) ;

  //              Swal.fire({
  //              type: 'success',
  //              title: 'Success',
  //              text: json.message
  //               });


  //             } else {
  //              $('#spinner-div').hide();
  //              $('#spinner-modal').hide();
  //               Swal.fire({
  //               type: 'error',
  //               title: 'Error',
  //               text: json.message
  //                });
  //                }
  //                   console.log(response);
  //                 },
  //                 error: function(response) {
  //                   $('#spinner-div').hide();
  //                   $('#spinner-modal').hide();
  //                   Swal.fire({
  //                     type: 'error',
  //                     title: 'Error',
  //                     text: 'Data error, please try again later.'
  //                   });
  //                   console.log(response);
  //                 }
  //               });
  //             }
  //           });


  //       });


  $('#btn_search_edc').click(function () {

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



  function refreshPeripheral(peripheral) {

    var outputPeripheral = '';
    $.each(peripheral, function (index, element, no = 1) {
      var row = '<tr>' +
        '<td>' + index + '</td>' +
        '<td>' + element.type + '</td>' +
        '<td>' + element.customer + '</td>' +
        '<td>' + element.edc_sn + '</td>' +
        '<td><button onclick="deletePeripheral(' + index + ')" class="btn btn-default btn-rounded btn-sm"><i class="bi bi-trash-fill fs-5 me-1"></i></button></td>' +
        '</tr>';
      outputPeripheral += row;
    });


    $('#lbl_total_send_peripheral').html(peripheral.length + " Unit");
    $('#FragmentSendUnitPeripheral').html(outputPeripheral);

  }
  function addThermal(item) {

    thermal.push(item);
    console.log("thermal", thermal);
    $('#FragmentSendUnitThermal').html(thermal);
  }

  function deletePeripheral(item) {

    if (item !== -1) {
      peripheral.splice(item, 1);
    }

    refreshPeripheral(peripheral);

    console.log("jsonOutput", JSON.stringify(peripheral, null, 2));

  }



  //Function Thermal
  function addThermal(edc_sn) {

    $.ajaxSetup({

      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }

    });

    $.ajax({

      url: '/api/inventory/fragments/modal/thermal/send_unit_thermal',

      method: "POST",

      data: { "warehouse_id": "ING-MNS", "edc_sn": edc_sn },

      success: function (data) {

        var json = $.parseJSON(data);

        var newData = { "type": json.type, "customer": json.customer, "edc_sn": json.edc_sn };
        thermal.push(newData);
        var thermalString = JSON.stringify(thermal, null, 2);

        refreshPeripheral(thermal);

      }

    });


  }


  function refreshPeripheral(peripheral) {

    var outputPeripheral = '';
    $.each(peripheral, function (index, element, no = 1) {
      var row = '<tr>' +
        '<td>' + index + '</td>' +
        '<td>' + element.type + '</td>' +
        '<td>' + element.customer + '</td>' +
        '<td>' + element.edc_sn + '</td>' +
        '<td><button onclick="deletePeripheral(' + index + ')" class="btn btn-default btn-rounded btn-sm"><i class="bi bi-trash-fill fs-5 me-1"></i></button></td>' +
        '</tr>';
      outputPeripheral += row;
    });


    $('#lbl_total_send_peripheral').html(peripheral.length + " Unit");
    $('#FragmentSendUnitPeripheral').html(outputPeripheral);

  }

  function deletePeripheral(item) {

    if (item !== -1) {
      peripheral.splice(item, 1);
    }

    refreshPeripheral(peripheral);

    console.log("jsonOutput", JSON.stringify(peripheral, null, 2));

  }
  //Function Peripheral
  function addPeripheral(edc_sn) {

    $.ajaxSetup({

      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }

    });

    $.ajax({

      url: '/api/inventory/fragments/modal/peripheral/send_unit_peripheral',

      method: "POST",

      data: { "warehouse_id": "ING-MNS", "edc_sn": edc_sn },

      success: function (data) {

        var json = $.parseJSON(data);

        var newData = { "type": json.type, "customer": json.customer, "edc_sn": json.edc_sn };
        peripheral.push(newData);
        var peripheralString = JSON.stringify(peripheral, null, 2);

        refreshPeripheral(peripheral);

      }

    });


  }


  function refreshSimcard(simcard) {

    var outputSimcard = '';
    $.each(simcard, function (index, element, no = 1) {
      var row = '<tr>' +
        '<td>' + index + '</td>' +
        '<td>' + element.customer + '</td>' +
        '<td>' + element.operator + '</td>' +
        '<td>' + element.iccid + '</td>' +
        '<td><button onclick="deleteSimcard(' + index + ')" class="btn btn-default btn-rounded btn-sm"><i class="bi bi-trash-fill fs-5 me-1"></i></button></td>' +
        '</tr>';
      outputSimcard += row;
    });


    $('#lbl_total_send_simcard').html(simcard.length + " Unit");
    $('#FragmentSendUnitSimcard').html(outputSimcard);

  }


  function deleteSimcard(item) {

    if (item !== -1) {
      simcard.splice(item, 1);
    }

    refreshSimcard(simcard);

    console.log("jsonOutput", JSON.stringify(simcard, null, 2));

  }



  //Funcion Simcard
  function addSimCard(iccid) {

    $.ajaxSetup({

      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }

    });

    $.ajax({

      url: '/api/inventory/fragments/modal/simcard/send_unit_simcard',

      method: "POST",

      data: { "warehouse_id": "ING-MNS", "iccid": iccid },

      success: function (data) {

        var json = $.parseJSON(data);

        var newData = { "customer": json.customer, "operator": json.operator, "iccid": json.iccid };
        simcard.push(newData);
        var simcardString = JSON.stringify(simcard, null, 2);

        refreshSimcard(simcard);

      }

    });


  }










  //load fragment thermal
  function loadFragmentThermal() {

    $.ajaxSetup({

      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }

    });

    $.ajax({

      url: '/api/inventory/fragments/modal/thermal',

      method: "POST",

      data: { "warehouse_id": "ING-MNS" },

      success: function (data) {

        $('#FragmentThermal').html(data);

        //$('#myModal').modal('show');
        $('#modal_send_unit').modal('show');
        $('#spinner-div').hide();
        $('#spinner-modal').hide();
      }

    });

  }



  //load fragment peripheral
  function loadFragmentPeripheral() {

    $.ajaxSetup({

      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }

    });

    $.ajax({

      url: '/api/inventory/fragments/modal/peripheral',

      method: "POST",

      data: { "warehouse_id": "ING-MNS" },

      success: function (data) {

        $('#FragmentPeripheral').html(data);
        loadFragmentThermal();
      }

    });

  }

  //load fragment simcard
  function loadFragmentSimcard() {

    $.ajaxSetup({

      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }

    });

    $.ajax({

      url: '/api/inventory/fragments/modal/simcard',

      method: "POST",

      data: { "warehouse_id": "ING-MNS" },

      success: function (data) {

        $('#FragmentSimcard').html(data);
        loadFragmentPeripheral();
      }

    });

  }


  $("#lbunit_info").click(function () {

    if ($("#Cbreceiver").val() === "") {
      Swal.fire({
        type: 'warning',
        title: 'Failed',
        text: 'Please select Receiver !'
      });

    } else {

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

        data: { "warehouse_id": "05-CBN" },

        success: function (data) {

          $('#FragmentEDC').html(data);
          loadFragmentSimcard();

        }

      });

    }
  });


});


var edc = []
var simcard = [];
var peripheral = [];
var thermal = [];



//Function EDC
function addEdcClick(button) {

  for (let i = 0; i < edc.length; i++) {
    const item = edc[i];
    var snEdc = item.sn;

  }

  const itemId = button.getAttribute('data-id');


  if (itemId == snEdc) {

    Swal.fire({
      type: 'warning',
      title: 'Failed',
      text: 'S/N ' + snEdc + " already available"
    });


  } else {


    $.ajaxSetup({

      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }

    });

    $.ajax({

      url: '/api/inventory/fragments/modal/edc/send_unit_edc',

      method: "POST",

      data: { "warehouse_id": "05-CBN", "sn": itemId },


      success: function (data) {


        var json = $.parseJSON(data);
        var newData = { "customer": json.customer, "sn": json.sn };



        edc.push(newData);
        var edcString = JSON.stringify(edc, null, 2);
        refreshEdc(edc);







      }

    });

  }
}



function refreshEdc(edc) {
  var output = '';
  $.each(edc, function (index, element, no = 1) {
    var row = '<tr>' +
      '<td>' + index + '</td>' +
      '<td>' + element.customer + '</td>' +
      '<td>' + element.sn + '</td>' +
      '<td><button onclick="deleteEdc(' + index + ')" class="btn btn-default btn-rounded btn-sm"><i class="bi bi-trash-fill fs-5 me-1"></i></button></td>' +
      '</tr>';
    output += row;


  });

  $('#lbl_qty').html(edc.length + simcard.length + peripheral.length + thermal.length);
  $('#lbl_total_send_edc').html(edc.length + " Unit");
  $('#FragmentSendUnitEdc').html(output);

}


function deleteEdc(item) {

  if (item !== -1) {
    edc.splice(item, 1);
  }

  refreshEdc(edc);

  console.log("jsonOutput", JSON.stringify(edc, null, 2));

}