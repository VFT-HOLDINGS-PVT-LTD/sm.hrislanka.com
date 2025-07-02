//
//<SCRIPT LANGUAGE="JavaScript">

//$("#test").submit(function (e) {
//
//    e.preventDefault();
//    $("#divmessage").hide();
//
//    var jqXHR = $.ajax({
//        type: "POST",
//        url: baseurl + "index.php/Write_Cheque/cheque_print",
//        data: $("#test").serialize(),
//        success: function (data) {
//
//            var data1 = JSON.parse(data);
//
//
//            if (data1[0].a > 0)
//            {
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
//
//            } else {
//                $("#spnmessage").html('<p><h5> <b>Error.</b></h5></p>');
//                $("#divmessage").attr("class", "alert alert-danger");
//                $("#divmessage").show();
//                $("#divmessage").effect("shake", {times: 3}, 1000);
//                $("#txtDesig_Code").val(data1[0].b);
//            }
//        }
//    });
//
//});






function formatNum(n, prec, currSign) {
    if(prec==null) prec=2;
  var n = ('' + parseFloat(n).toFixed(prec).toString()).split('.');
  var num = n[0];
  var dec = n[1];
  var r, s, t;

  if (num.length > 3) {
    s = num.length % 3;

    if (s) {
      t = num.substring(0,s);
      num = t + num.substring(s).replace(/(\d{3})/g, ",$1");
    } else {
      num = num.substring(s).replace(/(\d{3})/g, ",$1").substring(1);
    }
  }
    return (currSign == null ? "": currSign +" ") + num + ('');
}
//alert(formatNum(123545.3434));


function GetNumber2d(form) {
	var gf = ""
	var gg = ""
	var gh = ""
	var gi = ""
	var gj = ""
	var gc = "zero"
	var dd = ""
	var cc = ""

	var sNumber = form.txtNumber.value;
	var sNumbec = form.txtNumbe2.value;

	sNumber = stripBad(sNumber);
	sNumber = parseInt(sNumber, 10);
	var sNum2 = String(sNumber);

	sNumbec = stripBad(sNumbec);
	sNumbec = parseInt(sNumbec, 10);
	var sNumc = String(sNumbec);

 	if (sNumber == 1){dd = " Rupees "}
	else {dd = " Rupees"}
 	if (sNumbec == 1){cc = " Cent"}
	else {cc = " Cents"}

 	if (sNumbec < 1){gc = "Zero"}
	if (sNumc=="") {gc = "Zero"}
	if (sNumc > 0) {gc = hto(sNumc)}

	var j =  sNum2.length
	var hNum2 = sNum2.substring((j-3),((j-3)+3))

	if (hNum2 > 0) {
	 gf = hto(hNum2) + ""
		}

	var tNum2 = sNum2.substring((j-6),(j-6)+3)
	if (tNum2 > 0) {
	gg = hto(tNum2) + " Thousand "
			}

	var mNum2 = sNum2.substring((j-9),(j-9)+3)
	if (mNum2 > 0) {
	gh = hto(mNum2) + " Million "
			}

	var bNum2 = sNum2.substring((j-12),(j-12)+3)
	if (bNum2 > 0) {
	gi = hto(bNum2) + " Billion "
			}

	var trNum2 = sNum2.substring((j-15),(j-15)+3)
	if (trNum2 > 0) {
	gj = hto(trNum2) + " Trillion "
			}

 if (sNumber < 1){
	gf = "zero"
		}

 if (j > 15){
	gj = " Your number is too big for me to spell";
	gi = "";
	gh = "";
	gg = "";
	gf = "";
		}
	var dds = gj + gi + gh + gg + gf;
	 if (dds == ""){dds = "Zero"}

	form.txtResult.value= " " + dds + dd + " And " + gc + " " + cc
    
   form.txtNumberWith.value = (formatNum(sNumber));

}
    





function stripBad(string) {
    for (var i=0, output='', valid="0123456789."; i<string.length; i++)
       if (valid.indexOf(string.charAt(i)) != -1)
          output += string.charAt(i)
    return output;
} 

function stripBad2(string) {
    for (var i=0, output='', valid="0123456789"; i<string.length; i++)
       if (valid.indexOf(string.charAt(i)) != -1)
          output += string.charAt(i)
    return output;
}

function hto(ff){
	var sNum3 = ""
	var p1=""
	var p2=""
	var p3=""

	var hy=""
 var n1 = new Array
    ('', 'One', 'Two', 'Three', 'Four', 'Five', 'Six',
    'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve',
    'Thirteen', 'Fourteen', 'Fifteen',  'Sixteen', 'Seventeen',
    'Eighteen', 'Nineteen')

  var n2 = new Array('', '', 'Twenty', 'Thirty', 'Forty',
    'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety')


	sNum3 = ff
	var j =  sNum3.length
	var h3 = sNum3.substring((j-3),(j-3)+1)
		if (h3 > 0) {
		p3= n1[h3] + " Hundred "}
		else {p3=""}

	var t2 = parseInt(sNum3.substring((j-2),(j-2)+1), 10)
	var u1 = parseInt(sNum3.substring((j-1),(j-1)+1), 10)
	var tu21 = parseInt(sNum3.substring((j-2),(j-2)+2), 10)

		if (tu21 == 0) {
		 p1="";
		 p2="";
				}

		else if ((t2 < 1) && (u1 > 0)) {
			p2="";
			p1= n1[u1]
					}

		else if (tu21 < 20) {
			p2="";
			p1= n1[tu21]
					}

		else if ((t2 > 1) && (u1 == 0)) {
			p2= n2[t2]
			p1=""
					}

		else {
			p2= n2[t2] + " "
			p1=n1[u1] 
				}

	ff = p3 + p2 + p1

  return ff;
}

function ohto(ff){
	var sNum3 = ""
	var p1=""
	var p2=""
	var p3=""

	var hy=""
 var n1 = new Array
    ('', 'First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth',
    'Seventh', 'Eighth', 'Ninth', 'Tenth', 'Eleventh', 'Twelfth',
    'Thirteenth', 'Fourteenth', 'Fifteenth',  'Sixteenth', 'Seventeenth',
    'Eighteenth', 'Nineteenth')

  var n2 = new Array('', '', 'Twentieth', 'Thirtieth', 'Fortieth',
    'Fiftieth', 'Sixtieth', 'Seventieth', 'Eightieth', 'Ninetieth')

  var n3 = new Array('', '', 'Twenty', 'Thirty', 'Forty',
    'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety')

 var n4 = new Array
    ('', 'One', 'Two', 'Three', 'Four', 'Five', 'Six',
    'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve',
    'Thirteen', 'Fourteen', 'Fifteen',  'Sixteen', 'Seventeen',
    'Eighteen', 'Nineteen')


	sNum3 = ff
	var j =  sNum3.length
	var h3 = sNum3.substring((j-3),(j-3)+1)
		if (h3 > 0) {
		p3= n4[h3] + " Hundred "}
		else {p3=""}

	var t2 = parseInt(sNum3.substring((j-2),(j-2)+1), 10)
	var u1 = parseInt(sNum3.substring((j-1),(j-1)+1), 10)
	var tu21 = parseInt(sNum3.substring((j-2),(j-2)+2), 10)

		if (tu21 == 0) {
		 p1="";
		 p2="";
		 p3= n4[h3] + " Hundredth "
				}

		else if ((t2 < 1) && (u1 > 0)) {
			p2="";
			p1= n1[u1]
					}

		else if (tu21 < 20) {
			p2="";
			p1= n1[tu21]
					}

		else if ((t2 > 1) && (u1 == 0)) {
			p2= n2[t2]
			p1=""
					}

		else {
			p2= n3[t2] + " "
			p1=n1[u1] 
				}

	ff = p3 + p2 + p1

  return ff;
}




function gesult(ff){

 if (Number.prototype.toFixed) {
   ff = ff.toFixed(2);
   ff = parseFloat(ff);
 }
 else {
   var leftSide = Math.floor(ff);
   var rightSide = ff - leftSide;
   ff = leftSide + Math.round(rightSide *1e+14)/1e+14;
 }

 return comma(ff);
}

function comma(num) {
 var n = Math.floor(num);
 var myNum = num + "";
 var myDec = ""
 
 if (myNum.indexOf('.',0) > -1){
  myDec = myNum.substring(myNum.indexOf('.',0),myNum.length);
 }

  var arr=new Array('0'), i=0; 
  while (n>0) 
    {arr[i]=''+n%1000; n=Math.floor(n/1000); i++;}
  arr=arr.reverse();
  for (var i in arr) if (i>0)
    while (arr[i].length<3) arr[i]='0'+arr[i];
  return arr.join() + myDec;
}



