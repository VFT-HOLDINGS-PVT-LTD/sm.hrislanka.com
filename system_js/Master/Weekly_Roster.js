$(document).ready(function () {
    $('#txt_B_name').val($(this).val());

});

$("#Cancel").click(function () {


    $("#txt_dep_name").val("");



});


    $("#frmWeeklyRoster").submit(function(e) {
        e.preventDefault();
        $("#divmessage").hide();
        createShiftDataArr();
        var jqXHR = $.ajax({
            type: "POST",
            url: baseurl + "index.php/Master/Weekly_Roster/addRoster",
            data: $("#frmWeeklyRoster").serialize(),
            //dataType: 'json',
            success: function(data) {
                
                var data1 = JSON.parse(data);
                    
                    

                if (data1[0].a > 0)
                {
                    $("#spnmessage").html('<p> <h5> <b>  New Department added successfully.</b></h5></p>');
                    $("#divmessage").attr("class", "alert alert-success");
                    $("#divmessage").show();
                    $("#divmessage").effect("shake", {times: 3}, 1000);
                    $("#txtDepart_Name").val("");
                    $("#txtDesig_Order").val("");
                    $("#txtDepart_Code").val(data1[0].b);
                    //$("#divmessage").hide();
                    //alert(data[1]);
                    //location.reload();
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



$("[id^='SHType'").each(function () {
    $("#" + this.id).on("change", function () {
        elementIndex = this.id.replace("SHType", "");

        var jqXHR = $.ajax({
            type: "POST",
            url: baseurl + "index.php/Master/Weekly_Roster/getShiftData",
            data: {shiftCode: $("#" + this.id).val()},
            dataType: 'json',
            success: function (data) {
                for (x = 0; x < data.length; x++) {
                    $("#txtDayType" + elementIndex).val(data[x].FromTime + "-" + data[x].ToTime);
                }


            }
        });

    });



});




function createShiftDataArr() {
    myData = [];
    $("[id^='SHType'").each(function () {

        elementIndex = this.id.replace("SHType", "");
        
        myData.push({
            "DayType": $("#txtDayType" + elementIndex).val(),
            "SHType": $("#SHType" + elementIndex).val(),
            "Day":$("#DType" +elementIndex).val(),
            "SType":$("#txtSType" +elementIndex).val(),
            
        });

    });
    $("#hdntext").val(JSON.stringify(myData));
//    alert($("#hdntext").val());
}



