$(document).ready(function () {
      $('#txt_B_name').val($(this).val());

});

$("#Cancel").click(function () {


    $("#txt_dep_name").val("");
  


});

$("#frm_employee").submit(function (e) {

    e.preventDefault();
    var formData = new FormData(this);
    $("#divmessage").hide();

    var jqXHR = $.ajax({
        type: "POST",
        url: baseurl + "Master/Employees/insert_Data",
//        data: $("#frm_employee").serialize(),
        
         data: formData,
            cache: false,
            contentType: false,
            processData: false,
        success: function (data) {

            var data1 = JSON.parse(data);


            if (data1[0].a > 0)
            {
                $("#spnmessage").html(' <b>  New Employee added successfully.</b>');
                $("#divmessage").attr("class", "alert alert-dismissable alert-success");
                $("#divmessage").show();
                $("#divmessage").effect("shake", {times: 3}, 1000);
                $("#txt_dep_name").val("");

                

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



//Get Department Data
$(".get_data").click(function () {



    var ID = $(this).attr("data-id");
    $.ajax({
        type: "POST",
        url: baseurl + "index.php/Master/Department/get_details",
        data: {'id': ID},
        dataType: "JSON",
        success: function (response) {
//                    alert(response);
            for (var i = 0; i < response.length; i++) {
                $('#id').val(response[i].ID);
                $('#Dep_Name').val(response[i].Dep_Name);


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


