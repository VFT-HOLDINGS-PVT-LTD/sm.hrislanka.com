$(".action_comp").click(function(){
  

    
  var id = $(this).attr("data-id");
            $.ajax( {
                type: "POST",
                url: baseurl + "index.php/Action_Complain/complain_details",
                data: { 'Ref_No': id  },
                dataType: "JSON",
                success: function( response ) {
//                    alert(response);
                    for(var i=0;i<response.length;i++){
                        $('#Ref_No').val(response[i].Ref_No);
                        $('#B_Code').val(response[i].B_Code);
                        $('#Action').val(response[i].Action);
                        
                        
                    }
		}
            });
});