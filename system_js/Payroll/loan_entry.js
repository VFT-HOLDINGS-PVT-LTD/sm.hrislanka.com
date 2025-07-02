

function calculate() {
	
        
        //var LAmount = document.getElementById("txtLoanAmount").value="";
        
        
	var LAmount = document.getElementById("txt_amount").value;
        var Rate = document.getElementById("txt_rate").value;
	var Ins = document.getElementById("txt_no_of_inst").value;
        
      
      if ( LAmount === "" ){
          
          
          
           $("#spnmessage").html('<p><b>Loan Amount cannot be empty</b></p>');
                            $("#divmessage").attr("class", "alert alert-danger");
                            $("#divmessage").show();
                            
                        return false;
          
      }
      if ( Rate === "" ){
          
          
          
           $("#spnmessage").html('<p><b>Rate cannot be empty</b></p>');
                            $("#divmessage").attr("class", "alert alert-danger");
                            $("#divmessage").show();
                            
                        return false;
          
      }
      if ( Ins === "" ){
          
          
          
           $("#spnmessage").html('<p><b>No Of Installment be empty</b></p>');
                            $("#divmessage").attr("class", "alert alert-danger");
                            $("#divmessage").show();
                            
                        return false;
                    }
          
//      } else
//      {     $("#spnmessage").html('<p><b>Success</b></p>');
//            $("#divmessage").attr("class", "alert alert-success");
//      }
      
        
        
        //var Error = "Error Message";
        
//        alert(Error);
//        
//        var Error = document.getElementById('ErrorDive');
//        Error.value=Error;
//        
//        swal(Error);
//        
        
        
	//var Installment = document.getElementById("txtNoOFIns").value;
	

        var Interst = (Rate/100)*LAmount;   
        var FullAmount = (+Interst) + (+LAmount);
        var Month = (FullAmount/Ins);
        
        
        var txtAwithIns = document.getElementById('txt_amt_with_ins');
        txtAwithIns.value =FullAmount.toFixed(2);
        
        var txtMonthIns = document.getElementById('txt_m_inst');
        txtMonthIns.value=Month.toFixed(2);
   
        }



