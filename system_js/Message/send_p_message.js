$(document).ready(function () {


});


function delete_id(id)
{
    swal({title: "Are you sure?", text: "You will not be able to recover this data!", type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55", confirmButtonText: "Yes, Delete This!", cancelButtonText: "No, Cancel This!", closeOnConfirm: false, closeOnCancel: false}, 
    function (isConfirm) {
        if (isConfirm) {
            
            // ajax delete data to database
        $.ajax({
            url: baseurl + "/Priority_Message/ajax_delete/" + id,
//            url: baseurl + "/Priority_Message/send_message",
            type: "POST",
            dataType: "JSON",
            success: function (data)
            {



                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            }
//            error: function (jqXHR, textStatus, errorThrown)
//            {
//                alert('Error deleting data');
//            }
        });
            
            
            swal("Deleted!", "Selected data has been deleted.", "success");
            
            
            $(document).ready(function(){
      setTimeout(function() {
       window.location.replace(baseurl + "Priority_Message/");
      }, 1000);
    });
           
//            
            
        }
//        window.location.replace(baseurl + "Priority_Message/");
        else {
            swal("Cancelled", "Selected data Cancelled", "error");
            
        }
    
    
    
    });
//    if (confirm('Are you sure delete this data?'))
//    {
//        
//
//    }
}


$("#Cancel").click(function () {


    $("#txt_message").val("");



});

$("#frm_message").submit(function (e) {

    e.preventDefault();
    $("#divmessage").hide();

    var jqXHR = $.ajax({
        type: "POST",
        url: baseurl + "/Priority_Message/send_message",
        data: $("#frm_message").serialize(),
        success: function (data) {

            var data1 = JSON.parse(data);


            if (data1[0].a > 0)
            {
                $("#spnmessage").html(' <b>  Message Send successfully.</b>');
                $("#divmessage").attr("class", "alert alert-dismissable alert-success");

                swal("Message Send!", "", "success");

                $("#divmessage").show();
                $("#divmessage").effect("shake", {times: 3}, 1000);
                $("#txt_message").val("");


                $("#txt_ref_No").val(data1[0].b);

            } else {
                $("#spnmessage").html('<p><h5> <b>Error.</b></h5></p>');
                $("#divmessage").attr("class", "alert alert-danger");
                $("#divmessage").show();
                $("#divmessage").effect("shake", {times: 3}, 1000);

            }
        }
    });

});




//Get Message Data
$(".message").click(function(){
  

    
  var id = $(this).attr("data-id");
            $.ajax( {
                type: "POST",
                url: baseurl + "index.php/Priority_Message/message_details",
                data: { 'id': id  },
                dataType: "JSON",
                success: function( response ) {
//                    alert(response);
                    for(var i=0;i<response.length;i++){
                        $('#id').val(response[i].id);
                        $('#message').val(response[i].message);
                        $('#is_active').val(response[i].is_active);
                         
                    }
		}
            });
});