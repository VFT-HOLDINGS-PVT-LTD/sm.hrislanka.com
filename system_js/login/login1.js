$(document).ready(function() {
    $("#frmLogin").submit(function(e) {
        
        e.preventDefault();
        
      
        $("#divmessage").hide();});
    
        $("#btnSubmit").click(function(){
            
            
                $.ajax({
                    type: "POST",
                    url: baseurl + "login/verifyUser",
                    data: $("#frmLogin").serialize(),
                    //dataType: 'json',
                    success: function(data) {
                        
                        var username=$('#txtusername').val();
                        var password=$('#txtpassword').val();
                        
                        if(username | password ==="")
                        {
                        $("#spnmessage").html('<p><b>    Username and Password Cannot be Empty....</b></p>');
                            $("#divmessage").attr("class", "alert alert-danger");
                            $("#divmessage").show();
                            
                        return false;
                        }

                        if(username==="")
                        {
                        $("#spnmessage").html('<p><b>    Username Cannot be Empty....</b></p>');
                            $("#divmessage").attr("class", "alert alert-danger");
                            $("#divmessage").show();
                        return false;
                        }
                         if(password==="")
                        {
                        $("#spnmessage").html('<p>    Password Cannot be Empty....</p>');
                            $("#divmessage").attr("class", "alert alert-danger");
                            $("#divmessage").show();
                         return false;
                         }
                        
                        if (data >= 1)
                        {
                            $("#spnmessage").html('<p>    Login successfull....</p>');
                            $("#divmessage").attr("class", "alert alert-success");
                            $("#divmessage").show();
                           // $("#divmessage").effect("shake", {times: 2}, 2000);
                            location.replace(baseurl + "dashboard");
                        } else {
                            $("#spnmessage").html('<p>    Check Username or Password</p>');
                            $("#divmessage").attr("class", "alert alert-danger");
                            $("#divmessage").show();
                            $("#divmessage").effect("shake", {times: 4}, 1300);
                            
//                            location.reload();
        
                        }
                    }
                });
            
        });
//        $.ajax({
//            type: "POST",
//            url: baseurl + "index.php/login/verifyUser",
//            data: $("#frmLogin").serialize(),
//            //dataType: 'json',
//            success: function(data) {
//
//                if (data > 0)
//                {
//                    $("#spnmessage").html('<p>    New Student added successfully.</p>');
//                    $("#divmessage").attr("class", "alert alert-success");
//                    $("#divmessage").show();
//                    $("#divmessage").effect("shake", {times: 6}, 2000);
//                    //location.reload();
//                } else {
//                    $("#spnmessage").html('<p>Error.</p>');
//                    $("#divmessage").attr("class", "alert alert-danger");
//                    $("#divmessage").show();
//                    $("#divmessage").effect("shake", {times: 6}, 2000);
//                    
//                    //location.reload();
//
//                }
//            }
//        });

//    });
    
    
    
});

