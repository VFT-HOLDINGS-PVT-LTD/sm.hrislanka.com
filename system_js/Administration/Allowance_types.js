
$("#Cancel").click(function () {


    $("#txt_allowance").val("");
  


});

//$("#frm_allowance_types").submit(function (e) {
//
//    e.preventDefault();
//    $("#divmessage").hide();
//
//    var jqXHR = $.ajax({
//        type: "POST",
//        url: baseurl + "Administration/Allowance_Types/insert_data",
//        data: $("#frm_allowance_types").serialize(),
//        success: function (data) {
//
//            var data1 = JSON.parse(data);
//
//
//            if (data1[0].a > 0)
//            {
//                $("#spnmessage").html(' <b>  New Allowance Type added successfully.</b>');
//                $("#divmessage").attr("class", "alert alert-dismissable alert-success");
//                $("#divmessage").show();
//                $("#divmessage").effect("shake", {times: 3}, 1000);
//                $("#txt_allowance").val("");
//
//                
//
//            } else {
//                $("#spnmessage").html('<p><h5> <b>Error.</b></h5></p>');
//                $("#divmessage").attr("class", "alert alert-danger");
//                $("#divmessage").show();
//                $("#divmessage").effect("shake", {times: 3}, 1000);
//                
//            }
//        }
//    });
//
//});



//Get Department Data
$(".get_data").click(function () {



    var ID = $(this).attr("data-id");
    $.ajax({
        type: "POST",
        url: baseurl + "index.php/Master/Allowance_Types/get_details",
        data: {'id': ID},
        dataType: "JSON",
        success: function (response) {
//                    alert(response);
            for (var i = 0; i < response.length; i++) {
                $('#id').val(response[i].id);
                $('#Allowance_Name').val(response[i].Allowance_name);
                $('#is_Fixced').val(response[i].isFixed);
                $('#is_Active').val(response[i].IsActive);


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
                        url: baseurl + "index.php/Master/Department/ajax_delete/" + id,
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
                            window.location.replace(baseurl + "Master/Department/");
                        }, 1000);
                    });


                } else {
                    swal("Cancelled", "Selected data Cancelled", "error");

                }

            });

}


