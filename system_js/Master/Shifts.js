$(document).ready(function () {
      $('#txt_B_name').val($(this).val());

});

$("#Cancel").click(function () {


    $("#txt_dep_name").val("");
  


});

//$("#frm_shifts").submit(function (e) {
//
//    e.preventDefault();
//    $("#divmessage").hide();
//
//    var jqXHR = $.ajax({
//        type: "POST",
//        url: baseurl + "Master/Shifts/insert_Data",
//        data: $("#frm_shifts").serialize(),
//        success: function (data) {
//
//            var data1 = JSON.parse(data);
//
//
//            if (data1[0].a > 0)
//            {
//                $("#spnmessage").html(' <b>  New Shift added successfully.</b>');
//                $("#divmessage").attr("class", "alert alert-dismissable alert-success");
//                $("#divmessage").show();
//                $("#divmessage").effect("shake", {times: 3}, 1000);
//                $("#txt_dep_name").val("");
//
//                
//
//            } else {
//                $("#spnmessage").html('<p><h5> <b>Error.</b></h5></p>');
//                $("#divmessage").attr("class", "alert alert-danger");
//                $("#divmessage").show();
//                $("#divmessage").effect("shake", {times: 3}, 1000);
//                $("#txtDesig_Code").val(data1[0].b);
//            }
//        }
//    });
//
//});



//Get Data
$(".get_data").click(function () {



    var ShiftCode = $(this).attr("data-id");
    $.ajax({
        type: "POST",
        url: baseurl + "index.php/Master/Shifts/get_details",
        data: {'ShiftCode': ShiftCode},
        dataType: "JSON",
        success: function (response) {
//                    alert(response);
            for (var i = 0; i < response.length; i++) {
                $('#ShiftCode').val(response[i].ShiftCode);
                $('#ShiftName').val(response[i].ShiftName);
                $('#FromTime').val(response[i].FromTime);
                $('#ToTime').val(response[i].ToTime);
                $('#ShiftGap').val(response[i].ShiftGap);
                


            }
        }
    });
});


//Delete 
function delete_id(id)
{
    swal({title: "Are you sure?", text: "You will not be able to recover this data!", type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Yes, Delete This!", cancelButtonText: "No, Cancel This!", closeOnConfirm: false, closeOnCancel: false},
            function (isConfirm) {
                if (isConfirm) {

                    $.ajax({
                        url: baseurl + "index.php/Master/Shifts/ajax_delete/" + id,
                        type: "POST",
                        dataType: "JSON",
                        success: function (data)
                        {

                            //if success reload ajax table
                            $('#modal_form').modal('hide');
                            reload_table();
                        }

                    });


                    swal("Deleted!", "Selected data has been deleted.", "success");


                    $(document).ready(function () {
                        setTimeout(function () {
                            window.location.replace(baseurl + "Master/Shifts/");
                        }, 1000);
                    });


                } else {
                    swal("Cancelled", "Selected data Cancelled", "error");

                }

            });

}


