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
        $("#txt_Reporter").val("");
        $("#txt_ref_No").val("");
        $("#txt_P_Num").val("");
        $("#txt_comment").val("");  


    });

    $("#frmComplainReview").submit(function (e) {

        e.preventDefault();
        $("#divmessage").hide();

        var jqXHR = $.ajax({
            type: "POST",
            url: baseurl + "index.php/Review_Complain/Comp_action",
            data: $("#frmComplainReview").serialize(),
            
            success: function (data) {

//                var data1 = JSON.parse(data);
                
                var data1 = JSON.parse(data);
                
                
                
//                alert(data);


//                if (data1[0].a > 0)
//                {

                    swal(data);

                    $("#spnmessage").html(data);
                    $("#divmessage").attr("class", "alert alert-dismissable alert-success");
                    $("#divmessage").show();
                    $("#divmessage").effect("shake", {times: 3}, 1000);
//                    $("#txt_B_Code").val("");
//                    $("#txt_B_name").val("");
//                    $("#txt_Reporter").val("");
//                    $("#txt_ref_No").val("");
//                    $("#txt_P_Num").val("");
//                    $("#txt_comment").val("");
//
//                } else {
//                    $("#spnmessage").html('<p><h5> <b>Error.</b></h5></p>');
//                    $("#divmessage").attr("class", "alert alert-danger");
//                    $("#divmessage").show();
//                    $("#divmessage").effect("shake", {times: 3}, 1000);
//                    $("#txtDesig_Code").val(data1[0].b);
//                }
            }
        });

    });



//$j(function() {
//    $j("#txt_B_Code").keyup(
//            
//            {
//            
//        
//        source: baseurl + "index.php/Add_Complain/insert_complain",
//        width: 265,
//        selectFirst: true,
//        minlength: 1,
//        dataType: "json",
//        
//        
//        select: function(event, data) {
//            $j("#area_id").val(data.item.area_id);
//            $j("#area").val(data.item.area_name);
//            $j("#area_code").val(data.item.area_code);
//            $j.getJSON("cl_get_branch?regionId=" + $j("#area_id").val(), function(data) {
//                var option = ['<option value="0">Select Branch</option>'];
//                for (var index = 0; index < data.length; index++) {
//                    option.push('<option value="' + data[index]['id_branch'] + '" >' + data[index]['branch_name'] + '</option>');
//                }
//                $j('#branch').html(option.join(''));
//            });
//        }
//    });
//
//});