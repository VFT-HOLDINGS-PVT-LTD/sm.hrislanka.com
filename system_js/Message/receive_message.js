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


    $("#txt_B_Code").val("");
    $("#txt_B_name").val("");
    $("#txt_address").val("");
    $("#txt_tp").val("");
    $("#txt_fax").val("");
    $("#txt_Email").val("");


});





//Get branch Data
$(".branch").click(function(){
  

    
  var id = $(this).attr("data-id");
            $.ajax( {
                type: "POST",
                url: baseurl + "Master/Banks/bank_details",
                data: { 'Bnk_ID': id  },
                dataType: "JSON",
                success: function( response ) {
//                    alert(response);
                    for(var i=0;i<response.length;i++){
                        $('#B_Code').val(response[i].Bnk_ID);
                        $('#B_name').val(response[i].bank_name);
                        
                         
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
            url: baseurl + "/Message/Receive_Message/ajax_delete/" + id,
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
       window.location.replace(baseurl + "Message/Receive_Message");
      }, 1000);
    });

            
        }

        else {
            swal("Cancelled", "Selected data Cancelled", "error");
            
        }

    });

}
