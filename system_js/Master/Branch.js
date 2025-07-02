
//Clear Text Boxes
$("#Cancel").click(function () {

    $("#txt_desig_name").val("");
    $("#txt_desig_order").val("");


});


//Insert Data
//$("#frm_designation").submit(function (e) {
//
////Prevent Default Submit form Data
//    e.preventDefault();
//    $("#divmessage").hide();
//    $("#frm_designation").validate();
//
//    var jqXHR = $.ajax({
//        type: "POST",
//        url: baseurl + "Master/Designation/insert_Designation",
//        data: $("#frm_designation").serialize(),
//        success: function (data) {
//
//            var data1 = JSON.parse(data);
//
//
//            if (data1[0].a > 0)
//            {
//                $("#spnmessage").html(' <b>  New Designation added successfully.</b>');
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



//Get Designation Data
$(".get_data").click(function () {

    var ID = $(this).attr("data-id");
    $.ajax({
        type: "POST",
        url: baseurl + "index.php/Master/Branch/branch_details",
        data: {'id': ID},
        dataType: "JSON",
        success: function (response) {
//                    alert(response);
            for (var i = 0; i < response.length; i++) {
                $('#id').val(response[i].B_id);
                $('#B_name').val(response[i].B_name);
                $('#Address').val(response[i].Address);
                $('#TelNo').val(response[i].Tel1);
                $('#TelNo1').val(response[i].Tel2);
                $('#FaxNo').val(response[i].Fax);
                $('#Email').val(response[i].Email);
                

            }
        }
    });
});



function delete_id(id)
{
    swal({title: "Are you sure?", text: "You will not be able to recover this data!", type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Yes, Delete This!", cancelButtonText: "No, Cancel This!", closeOnConfirm: false, closeOnCancel: false},
            function (isConfirm) {
                if (isConfirm) {

                    $.ajax({
                        url: baseurl + "index.php/Master/Designation/ajax_delete/" + id,
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
                            window.location.replace(baseurl + "Master/Designation/");
                        }, 1000);
                    });


                } else {
                    swal("Cancelled", "Selected data Cancelled", "error");

                }

            });

}


