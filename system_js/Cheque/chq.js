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

$("#test").submit(function (e) {

  

//           
//                $("#spnmessage").html(' <b>  New Cheque added successfully.</b>');
//                $("#divmessage").attr("class", "alert alert-dismissable alert-success");
//                $("#divmessage").show();
//                $("#divmessage").effect("shake", {times: 3}, 1000);
//                $("#txt_Name").val("");
//                $("#txt_address").val("");
//                $("#txt_telephone").val("");
//                $("#txt_Email").val("");
//                
//                $("#cmb_Comp_type").find('option').removeAttr("selected");
//                $("#cmb_priority_type").find('option').removeAttr("selected");
//
//                $("#txt_ref_No").val(data1[0].b);


//setTimeout(function(){location.reload();},4000);

      
   
});


//Get branch Data
$(".branch").click(function(){
  

    
  var id = $(this).attr("data-id");
            $.ajax( {
                type: "POST",
                url: baseurl + "index.php/Add_Branch/branch_details",
                data: { 'B_Code': id  },
                dataType: "JSON",
                success: function( response ) {
//                    alert(response);
                    for(var i=0;i<response.length;i++){
                        $('#B_Code').val(response[i].B_Code);
                        $('#B_name').val(response[i].B_name);
                        $('#Address').val(response[i].Address);
                        $('#TelNo').val(response[i].TelNo);
                        $('#TelNo1').val(response[i].TelNo1);
                        $('#FaxNo').val(response[i].FaxNo);
                        $('#Email').val(response[i].Email);
                        $('#IsActive').val(response[i].IsActive);
                         
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
            url: baseurl + "/Add_Branch/ajax_delete/" + id,
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
            
            
//            $(document).ready(function(){
//      setTimeout(function() {
//       window.location.replace(baseurl + "Add_Branch/");
//      }, 1000);
//    });

            
        }

        else {
            swal("Cancelled", "Selected data Cancelled", "error");
            
        }

    });

}
