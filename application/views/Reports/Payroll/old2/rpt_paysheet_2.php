<?php

$date = date("Y/m/d");

$data_month;

//var_dump($data_c[0]->id);die;
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Paysheet_Month_' . $data_month . '.pdf');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . '', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

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



$pdf->SetMargins(5, 14, 15, 0, true);
$pdf->AddPage('L', 'LEGAL');
//$pdf->SetMargins(0, 0, 0, true);
// set text shadow effect
$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.0, 'depth_h' => 0.0, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

// Set some content to print
$html = '
            <h6 style="margin-left:0px; text-align:center; ">PAY SHEET </h6>
            <div style="font-size: 11px; float: left; border-bottom: solid #000 1px;">Year : ' . $data_year . ' &nbsp;  Month : ' . date('F', mktime(0, 0, 0, $data_month)) . '</div></font><br>
            <table cellpadding="3">
                <thead style="border-bottom: #000 solid 1px;">
                    <tr style="border-bottom: 1px solid black; font-weight:bold"> 
                        <th style="font-size:11px;border-bottom: 1px solid black; width:60px;">EMP NO</th>
                        <th style="font-size:11px;border-bottom: 1px solid black; width:60px;">EPF NO</th>
                        <th style="font-size:11px;border-bottom: 1px solid black; width:100px;">NAME</th>
                        
                        <th style="font-size:11px;border-bottom: 1px solid black;width:60px;">BASIC</th>
                        <th style="font-size:11px;border-bottom: 1px solid black;width:60px;">BDJ. ALLOW</th>
                        <th style="font-size:11px;border-bottom: 1px solid black;width:60px;">NOPAY DAYS</th>
                        <th style="font-size:11px;border-bottom: 1px solid black;width:60px;">NOPAY AMOUNT</th>
                         <th style="font-size:11px;border-bottom: 1px solid black;width:50px;">GROSS</th>
                        <th style="font-size:11px;border-bottom: 1px solid black;width:50px;">EPF</th>
                        <th style="font-size:11px;border-bottom: 1px solid black;width:40px;">LATE MIN</th>
                        <th style="font-size:11px;border-bottom: 1px solid black;width:55px;">LATE DEDUCT</th>
                        <th style="font-size:11px;border-bottom: 1px solid black;width:55px;">ADVANCE</th>
                        <th style="font-size:11px;border-bottom: 1px solid black;width:50px;">LOAN</th>
                        <th style="font-size:11px;border-bottom: 1px solid black;width:55px;">TOT DEDUCTIONS</th>

                        
                        <th style="font-size:11px;border-bottom: 1px solid black;width:70px;">NET SALARY</th>
                        
                        <th style="font-size:11px;border-bottom: 1px solid black;width:50px;">N OT HRS</th>
                        <th style="font-size:11px;border-bottom: 1px solid black;width:50px;">N OT PAY</th>
                        
                        <th style="font-size:11px;border-bottom: 1px solid black;width:50px;">D OT HRS</th>
                        <th style="font-size:11px;border-bottom: 1px solid black;width:50px;">D OT PAY</th>
                        
                        
                        
                       
                        
                        
                    
                        <th style="font-size:11px;border-bottom: 1px solid black;width:70px;">NET SALARY</th>
                             
                    </tr>
                </thead>
             <tbody>';

foreach ($data_set as $data) {


    $html .= ' <tr>
                        <td  style="font-size:10px;  width:60px;">' . $data->EmpNo . '</td>
                        <td  style="font-size:10px; width:60px;">' . $data->EPFNO . '</td>
                        <td style="font-size:10px;width:100px;">' . $data->Emp_Full_Name . '</td> 
                         
                        <td style="font-size:10px;width:60px;">' . $data->Basic_sal . '</td>
                            <td style="font-size:10px;width:60px;">' . $data->Fixed_Allowance . '</td>
                                <td style="font-size:10px;width:60px;">' . $data->No_Pay_days . '</td>
                                    <td style="font-size:10px;width:60px;">' . $data->no_pay_deduction . '</td>
                                        <td style="font-size:10px;width:50px;">' . ($data->Basic_sal + $data->Incentive) . '</td>
                                        <td style="font-size:10px;width:50px;">' . $data->EPF_Worker_Amount . '</td>

                        <td style="font-size:10px;width:40px;">' . $data->Late_min . '</td>
                        <td style="font-size:10px;width:55px;">' . number_format($data->Late_deduction, 2, '.', ',') . '</td>
                            <td style="font-size:10px;width:55px;">' .  number_format($data->Salary_advance, 2, '.', ',') . '</td>
                                <td style="font-size:10px;width:50px;">' . number_format($data->Loan_Instalment, 2, '.', ',') . '</td>
                                    <td style="font-size:10px;width:55px;">' . number_format($data->tot_deduction, 2, '.', ',')  . '</td>
                            

                            <td style="font-size:10px;width:70px;">' . number_format($data->D_Salary, 2, '.', ',') . '</td>
                               
                            
                        
                        <td style="font-size:10px;width:50px;">' . number_format($data->Normal_OT_Hrs, 2, '.', ',') . '</td>
                        <td style="font-size:10px;width:50px;">' . number_format($data->Normal_OT_Pay, 2, '.', ',') . '</td>
                            <td style="font-size:10px;width:50px;">' . number_format($data->Double_OT_Hrs, 2, '.', ',') . '</td>
                        <td style="font-size:10px;width:50px;">' . number_format($data->Double_OT_Pay, 2, '.', ',') . '</td>
                        
                        
                        
                        
                        
                        
                        
                        <td style="font-size:10px;width:70px; font-weight:bold">' . number_format($data->Net_salary, 2, '.', ',') . '</td>
                        
                              
                    </tr>'

    ;
}
$html .= '</tbody>
                  
          </table>
        <br>




';

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------    
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Paysheet_Month_' . $data_month . '.pdf', 'I');

//============================================================+
    // END OF FILE
    //============================================================+
    
