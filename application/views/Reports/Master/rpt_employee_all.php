<?php

$date = date("Y/m/d");


//var_dump($data_c[0]->id);die;
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
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
$pdf->AddPage('L', 'A4');

// set text shadow effect
$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.0, 'depth_h' => 0.0, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

// Set some content to print
$html = '
        <div style="margin-left:200px; text-align:center; font-size:13px;font-weight:bold">EMPLOYEE DETAILS REPORT</div><br>
            
            <table cellpadding="3">
                <thead style="border-bottom: #000 solid 1px;">
                    <tr style="border-bottom: 1px solid black; font-weight:bold"> 
                        <th style="font-size:11px;border-bottom: 1px solid black; width:60px;">EMP NO</th>
                        <th style="font-size:11px;border-bottom: 1px solid black; width:200px;">FULL NAME</th>
                        <th style="font-size:11px;border-bottom: 1px solid black;width:75px;">NIC</th>
                        <th style="font-size:11px;border-bottom: 1px solid black;width:250px;">ADDRESS</th>
                        <th style="font-size:11px;border-bottom: 1px solid black; width:65px;">MOBILE</th>
                        <th style="font-size:11px;border-bottom: 1px solid black; width:65px;">GENDER</th>
                        <th style="font-size:11px;border-bottom: 1px solid black; width:80px;">APOINT DATE</th>
                        <th style="font-size:11px;border-bottom: 1px solid black;width:100px;">DEPARTMENT</th>
                        <th style="font-size:11px;border-bottom: 1px solid black;">DESIGNATION</th>
                                  
                    </tr>
                </thead>
             <tbody>';


foreach ($data_set as $data) {

    $html .= ' <tr>
                    <td  style="font-size:10px; width:60px;">' . $data->EmpNo . '</td>
                    <td style="font-size:10px; width:200px;">' . $data->Title . ' ' . $data->Emp_Full_Name . '</td>
                    <td style="font-size:10px;width:75px;">' . $data->NIC . '</td>
                    <td style="font-size:10px;width:250px;">' . $data->Address . '</td>
                    <td style="font-size:10px;width:65px;">' . $data->Tel_mobile . '</td>
                    <td style="font-size:10px; width:65px;">' . $data->Gender . '</td>
                        <td style="font-size:10px; width:80px;">' . $data->ApointDate . '</td>
                    <td style="font-size:10px;width:100px;">' . $data->Dep_Name . '</td>
                    <td style="font-size:10px;">' . $data->Desig_Name . '</td>
         
               </tr>';
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
$pdf->Output('Employee Master Report ' . $date . '.pdf', 'I');

//============================================================+
    // END OF FILE
    //============================================================+
    
