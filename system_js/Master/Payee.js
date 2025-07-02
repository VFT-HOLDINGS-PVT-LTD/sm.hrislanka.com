$(document).ready(function () {
//    $("#divmessage").hide();

//$('#txt_B_Code').change(function () {
//    alert($('#txt_B_Code').val());
//    
//    $s = $('#txt_B_Code').val;
//    
//    $("#txt_B_name") = $s;

//    $('#txt_B_Code').keyup(function() {
//             $('#txt_B_name').val($(this).val());

});

$("#Cancel").click(function () {


    $("#txt_Name").val("");
    $("#txt_address").val("");
    $("#txt_telephone").val("");
    $("#txt_Email").val("");
   


});




//Get branch Data
$(".payee").click(function(){

  var id = $(this).attr("data-id");
            $.ajax( {
                type: "POST",
                url: baseurl + "Master/Payee/get_details",
                data: { 'id': id  },
                dataType: "JSON",
                success: function( response ) {
//                    alert(response);
                    for(var i=0;i<response.length;i++){
                        $('#id').val(response[i].id);
                        $('#name').val(response[i].name);
                        $('#Address').val(response[i].address);
                        $('#TelNo').val(response[i].telephone);
                        $('#email').val(response[i].email);

                    }
		}
            });
});



function delete_id(id)
{
    swal({title: "Are you sure?", text: "You will not be able to recover this data!", type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Yes, Delete This!", cancelButtonText: "No, Cancel This!", closeOnConfirm: false, closeOnCancel: false}, 
    function (isConfirm) {
        if (isConfirm) {
            
            // ajax delete data to database
        $.ajax({
            url: baseurl + "Master/Payee/ajax_delete/" + id,
//            url: baseurl + "/Priority_Message/send_message",
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
            
            
            $(document).ready(function(){
      setTimeout(function() {
       window.location.replace(baseurl + "Master/Payee/");
      }, 1000);
    });

            
        }

        else {
            swal("Cancelled", "Selected data Cancelled", "error");
            
        }

    });

}
