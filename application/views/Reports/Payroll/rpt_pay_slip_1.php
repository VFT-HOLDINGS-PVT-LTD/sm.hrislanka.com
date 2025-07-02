<?php

$date = date("Y/m/d");

$data_month;

//var_dump($data_c[0]->id);die;
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Pay_slip_Month_' . $data_month . '.pdf');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);


$PDF_HEADER_TITLE = $data_cmp[0]->Company_Name;
$PDF_HEADER_LOGO_WIDTH = '0';
$PDF_HEADER_LOGO = '';
$PDF_HEADER_STRING = '';


// set default header data
$pdf->SetHeaderData($PDF_HEADER_LOGO, $PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE . '', $PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------    
// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('helvetica', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage('P', 'A6');


//$pdf = new CUSTOMPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
////Add a custom size  
//$width = 175;  
//$height = 266; 
//$orientation = ($height>$width) ? 'P' : 'L';  
//$pdf->addFormat("custom", $width, $height);  
//$pdf->reFormat("custom", $orientation);  


$pdf->SetMargins(0, 0, 15, -10, true);

$pdf->SetAutoPageBreak(TRUE, 0);

// set text shadow effect
$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.0, 'depth_h' => 0.0, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

// Set some content to print
$html = '

    

            <h6 style="margin-left:200px;margin-top:-90px; text-align:center; ">' . $PDF_HEADER_TITLE . '</h6>
            


            
            <table  width="" style="font-size:9px;margin-left: 500px;">
                <tr>
                    <td width="120" height="10">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name</td>
                    
                    <td width="180" height="10">' . $data_set[0]->Emp_Full_Name . '-' . $data_set[0]->EmpNo . '</td>
                </tr>
                <tr>
                    <td width="120" height="10">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Category:</td>
                    
                    <td width="180" height="10">' . $data_set[0]->Dep_Name . '  -' . $data_set[0]->B_name . '</td>
                </tr>
                <tr>
                    <td width="120" height="10">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Month:</td>
                    
                    <td width="180" height="10">' . date('F', mktime(0, 0, 0, $data_month)) . " of " . $data_year . '</td>
                </tr>
            </table>
            


           <hr>
            
                
             <table width="" border="0" align="left" style="font-size:9px;font-family:calibri">
             <br>
                <tr>
                    <td width="120" style="font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Earnings</td>
                    <td width="20" ></td>
                    <td height="05"></td>
                </tr>
                <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Basic Salary</td>
                    <td > </td>
                    <td align="right">' . number_format($data_set[0]->Basic_sal, 2, '.', ',') . '</td>
                </tr>
                <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Budgetary Allowances</td>
                    <td ></td>
                    <td align="right">' . number_format($data_set[0]->BD_Al1, 2, '.', ',') . '</td>
                </tr>

               
                
                <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Incentive</td>
                    <td > </td>
                    <td align="right">' . number_format($data_set[0]->Incentive, 2, '.', ',') . '</td>
                </tr>
               
                
                
           
                <tr style="font-weight:bold">
                    <td  align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Gross Salary</td>
                    <td > </td>
                    <td  align="right">' . number_format($data_set[0]->Gross_sal, 2, '.', ',') . '</td>
                </tr>
                <br>

                <tr >
                    <td width="120" style="font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deductions</td>
                    <td width="20" ></td>
                    <td height="20"></td>
                </tr>
                <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EPF</td>
                    <td width="50"> 8% </td>
                    <td align="right">' . number_format($data_set[0]->EPF_Worker_Amount, 2, '.', ',') . '</td>
                </tr>
                <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deductions</td>
                    <td > </td>
                    <td align="right">' . number_format($data_set[0]->Deductions, 2, '.', ',') . '</td>
                </tr>
                <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Salary Advance</td>
                    <td > </td>
                    <td align="right">' . number_format($data_set[0]->Salary_advance, 2, '.', ',') . '</td>
                </tr>
                <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Loan Instalment</td>
                    <td > </td>
                    <td align="right">' . number_format($data_set[0]->Loan_Instalment, 2, '.', ',') . '</td>
                </tr>
                <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Late Amount</td>
                    <td > </td>
                    <td align="right">' . number_format($data_set[0]->Late_deduction, 2, '.', ',') . '</td>
                </tr>
                
                <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Wellfare</td>
                    <td > </td>
                    <td align="right">' . number_format($data_set[0]->Wellfare, 2, '.', ',') . '</td>
                </tr>
                <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Festival Advance</td>
                    <td > </td>
                    <td align="right">' . number_format($data_set[0]->Festivel_Advance, 2, '.', ',') . '</td>
                </tr>
                 <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO-PAY Amount</td>
                    <td > </td>
                    <td align="right">' . number_format($data_set[0]->no_pay_deduction, 2, '.', ',') . '</td>
                </tr>
                <tr style="font-weight:bold">
                    <td  align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL DEDUCTIONS </td>
                    <td > </td>
                    <td  align="right">' . number_format($data_set[0]->tot_deduction, 2, '.', ',') . '</td>
                </tr>
                <br>
                <tr >
                    <td width="120" style="font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NET SALARY</td>
                    <td width="20" ></td>
                    <td align="right" style="font-weight:bold">' . number_format($data_set[0]->D_Salary, 2, '.', ',') . '</td>
                </tr>

                <tr>
                    <td width="120" style="font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Extra Earnings</td>
                    <td width="20" ></td>
                    <td height="20"></td>
                </tr>
                 <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Allowances</td>
                    <td > </td>
                    <td align="right">' . number_format($data_set[0]->Allowances, 2, '.', ',') . '</td>
                </tr>
                <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NORMAL OT</td>
                    <td > </td>
                    <td align="right">' . number_format($data_set[0]->Normal_OT_Pay, 2, '.', ',') . '</td>
                </tr>
                <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DOUBLE OT</td>
                    <td > </td>
                    <td align="right">' . number_format($data_set[0]->Double_OT_Pay, 2, '.', ',') . '</td>
                </tr>
                <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL OT</td>
                    <td > </td>
                    <td align="right"><b>' . number_format($data_set[0]->Double_OT_Pay + $data_set[0]->Normal_OT_Pay, 2, '.', ',') . '</b></td>
                </tr>
                
                <br>
                <tr >
                    <td width="120" style="font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TOTAL SALARY</td>
                    <td width="20" ></td>
                    <td align="right" style="font-weight:bold">' . number_format($data_set[0]->Net_salary, 2, '.', ',') . '</td>
                </tr>
                <hr>  
                
                <tr >
                    <td width="120" style="font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Further Information</td>
                    <td width="20" ></td>
                    <td height="20"></td>
                </tr>
                <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EPF EMPLOYEE</td>
                    <td width="50"> 8% </td>
                    <td align="right">' . number_format($data_set[0]->EPF_Worker_Amount, 2, '.', ',') . '</td>
                </tr>
                <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EPF EMPLOYER</td>
                     <td width="50"> 12% </td>
                    <td align="right">' . number_format($data_set[0]->EPF_Employee_Amount, 2, '.', ',') . '</td>
                </tr>
                <tr>
                    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ETF EMPLOYER</td>
                     <td width="50"> 3% </td>
                    <td align="right">' . number_format($data_set[0]->ETF_Amount, 2, '.', ',') . '</td>
                </tr>
            </table>
        <br>




';

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------    
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Pay_slip_Month_' . $data_month . '.pdf', 'I');

//============================================================+
    // END OF FILE
    //============================================================+
    
