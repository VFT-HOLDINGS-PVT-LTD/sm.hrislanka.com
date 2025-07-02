$(document).ready(function () {
    $('#txt_B_name').val($(this).val());

});

$("#Cancel").click(function () {


    $("#txt_dep_name").val("");



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





function createOTPatternArr() {
    myData = [];
    $("[id^='Day'").each(function () {

        elementIndex = this.id.replace("Day", "");
        
        myData.push({
            "Day": $("#Day" + elementIndex).val(),
            "Type": $("#Type" + elementIndex).val(),
            "chkBSH":$("#chkBSH" +elementIndex).val(),
            "MinTw":$("#MinTw" +elementIndex).val(),
            "ChkASH":$("#chkASH" +elementIndex).val(),
            "ASH_MinTw":$("#ASH_MinTw" +elementIndex).val(),
            "RoundUp":$("#RoundUp" +elementIndex).val()
            
            
        });

    });
    $("#hdntext").val(JSON.stringify(myData));
   // alert($("#hdntext").val());
}


