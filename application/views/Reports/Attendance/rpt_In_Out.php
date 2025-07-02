<?php

$date = date("Y/m/d");





// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//set_time_limit(0);
ini_set('memory_limit', '-1');
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('IN OUT Report' . $f_date . ' to ' . $t_date . '.pdf');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');


//var_dump($data_cmp[0]->Company_Name);
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
$pdf->SetMargins(PDF_MARGIN_LEFT, 12, PDF_MARGIN_RIGHT);
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
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.0, 'depth_h' => 0.0, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

// Set some content to print
$html = '
        <div style="margin-left:200px; text-align:center; font-size:13px;">IN OUT REPORT</div>
            <div style="font-size: 11px; float: left; border-bottom: solid #000 1px;">From Date:' . $f_date . ' &nbsp;- To Date : ' . $t_date . '</div></font><br>
            <table cellpadding="3">
                <thead style="border-bottom: #000 solid 1px;">
                    <tr style="border-bottom: 1px solid black;"> 
                        <th style="font-size:11px;border-bottom: 1px solid black; width:60px;">EMP NO</th>
                        <th style="font-size:11px;border-bottom: 1px solid black; width:120px;">NAME</th>
                        <th style="font-size:11px;border-bottom: 1px solid black;">DATE</th>
                        <th style="font-size:11px;border-bottom: 1px solid black;">FROM TIME</th>
                        <th style="font-size:11px;border-bottom: 1px solid black;">TO TIME</th>
                        <th style="font-size:11px;border-bottom: 1px solid black;">IN TIME</th>
                        <th style="font-size:11px;border-bottom: 1px solid black;">OUT TIME</th>
                        <th style="font-size:11px;border-bottom: 1px solid black; width:100px;">STATUS</th>         
                    </tr>
                </thead>
             <tbody>';

foreach ($data_set as $data) {
    $day = $data->DayStatus;
    
    if($day === "AB"){
      $day ='<h4 style="color: #ff0000; font-size:10px;">AB</h4>';
    }


    $html .= ' <tr>
                        <td  style="font-size:10px;  width:60px;">' . $data->EmpNo . '</td>
                        <td  style="font-size:10px; width:120px;">' . $data->Emp_Full_Name . '</td>
                        <td style="font-size:10px;">' . $data->FDate . '</td> 
                        <td style="font-size:10px;">' . $data->FTime . '</td>    
                        <td style="font-size:10px;">' . $data->TTime . '</td>
                        <td style="font-size:10px;">' . $data->InTime . '</td>
                        <td style="font-size:10px;">' . $data->OutTime . '</td>
                        <td style="font-size:10px;">' . 
            $day
          . '</td>
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
$pdf->Output('IN OUT Report' . $f_date . ' to ' . $t_date . '.pdf', 'I');

//============================================================+
    // END OF FILE
    //============================================================+
    
