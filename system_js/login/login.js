$(document).ready(function () {
    $("#frmLogin").submit(function (e) {

        e.preventDefault();
        $("#divmessage").hide();
    });

    $("#btnSubmit").click(function () {

        $.ajax({
            type: "POST",
            url: baseurl + "login/verifyUser",
            data: $("#frmLogin").serialize(),
            success: function (data) {

                if (data >= 1)
                {
                    $("#spnmessage").html('<p>    Login successfull....</p>');
                    $("#divmessage").attr("class", "alert alert-success");
                    $("#divmessage").show();
                    location.replace(baseurl + "dashboard");
                } else {
                    $("#spnmessage").html('<p>    Check Username or Password</p>');
                    $("#divmessage").attr("class", "alert alert-danger");
                    $("#divmessage").show();
                    $("#divmessage").effect("shake", {times: 4}, 1300);

                }
            }
        });

    });

});

