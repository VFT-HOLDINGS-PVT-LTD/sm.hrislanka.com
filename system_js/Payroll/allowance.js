//Get  Data
$(".get_data").click(function () {

    var ID = $(this).attr("data-id");
    $.ajax({
        type: "POST",
        url: baseurl + "index.php/Pay/Allowance/get_details",
        data: {'id': ID},
        dataType: "JSON",
        success: function (response) {
//                    alert(response);
            for (var i = 0; i < response.length; i++) {
                $('#id').val(response[i].ID);
                $('#Name').val(response[i].Emp_Full_Name);
                $('#allowance').val(response[i].Allowance_name);
                $('#amount').val(response[i].Amount);

            }
        }
    });
});