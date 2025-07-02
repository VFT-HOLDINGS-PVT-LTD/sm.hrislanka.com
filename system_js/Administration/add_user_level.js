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


    $("#txt_Userlevel").val("");
   


});

$("#frm_adduserlevel").submit(function (e) {

    e.preventDefault();
    $("#divmessage").hide();

    var jqXHR = $.ajax({
        type: "POST",
        url: baseurl + "Add_User_level/insert_user_level",
        data: $("#frm_adduserlevel").serialize(),
        success: function (data) {
            
     

            var data1 = JSON.parse(data);


            if (data1[0].a > 0)
            {
                $("#spnmessage").html(' <b>  New User Level added successfully.</b>');
                $("#divmessage").attr("class", "alert alert-dismissable alert-success");
                $("#divmessage").show();
                $("#divmessage").effect("shake", {times: 3}, 1000);
               $("#txt_Userlevel").val("");

            } else {
                $("#spnmessage").html('<p><h5> <b>Error.</b></h5></p>');
                $("#divmessage").attr("class", "alert alert-danger");
                $("#divmessage").show();
                $("#divmessage").effect("shake", {times: 3}, 1000);
               
            }
        }
    });

});


