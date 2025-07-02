
//Clear Text Boxes
$("#Cancel").click(function () {

    $("#txt_comp_name").val("");
    $("#txt_comp_ad").val("");
    $("#txt_comp_tel").val("");
    $("#txt_comp_email").val("");
    $("#txt_comp_web").val("");
    $("#txt_comp_reg").val("");


});


//Insert Data
$("#frm_comp_pro").submit(function (e) {

//Prevent Default Submit form Data
    e.preventDefault();
    $("#divmessage").hide();

    var jqXHR = $.ajax({
        type: "POST",
        url: baseurl + "Company_Profile/Company_Profile/insert_Data",
        data: $("#frm_comp_pro").serialize(),
        success: function (data) {

            var data1 = JSON.parse(data);


            if (data1[0].a > 0)
            {
                $("#spnmessage").html(' <b>  New Profile added successfully.</b>');
                $("#divmessage").attr("class", "alert alert-dismissable alert-success");
                $("#divmessage").show();
                $("#divmessage").effect("shake", {times: 3}, 1000);
                $("#txt_comp_name").val("");
                $("#txt_comp_ad").val("");
                $("#txt_comp_tel").val("");
                $("#txt_comp_email").val("");
                $("#txt_comp_web").val("");
                $("#txt_comp_reg").val("");




            } else {
                $("#spnmessage").html('<p><h5> <b>Error.</b></h5></p>');
                $("#divmessage").attr("class", "alert alert-danger");
                $("#divmessage").show();
                $("#divmessage").effect("shake", {times: 3}, 1000);
                $("#txtDesig_Code").val(data1[0].b);
            }
        }
    });

});



//Get Designation Data
$(".get_data").click(function () {

    var ID = $(this).attr("data-id");
    $.ajax({
        type: "POST",
        url: baseurl + "index.php/Company_Profile/Company_Profile/get_details",
        data: {'id': ID},
        dataType: "JSON",
        success: function (response) {
//                    alert(response);
            for (var i = 0; i < response.length; i++) {
                $('#id').val(response[i].Cmp_ID);
                $('#Company_Name').val(response[i].Company_Name);
                $('#comp_Address').val(response[i].comp_Address);
                $('#comp_Tel').val(response[i].comp_Tel);
                $('#comp_Email').val(response[i].comp_Email);
                $('#comp_web').val(response[i].comp_web);
                $('#comp_reg_no').val(response[i].comp_reg_no);
                $('#comp_logo').val(response[i].comp_logo);
                

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
                        url: baseurl + "index.php/Company_Profile/Company_Profile/ajax_delete/" + id,
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
                            window.location.replace(baseurl + "Company_Profile/Company_Profile/");
                        }, 1000);
                    });


                } else {
                    swal("Cancelled", "Selected data Cancelled", "error");

                }

            });

}


