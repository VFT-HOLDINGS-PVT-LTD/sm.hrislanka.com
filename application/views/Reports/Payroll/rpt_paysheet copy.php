<?php
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A3', true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Payroll System');
$pdf->SetTitle('Paysheet_Month_' . $data_month . '.pdf');
$pdf->SetSubject('Paysheet');

$pdf->SetHeaderData('', '0', $data_cmp[0]->Company_Name ?? 'Company Name', '', [0, 64, 255], [0, 64, 128]);
$pdf->setFooterData([0, 64, 0], [0, 64, 128]);

$pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
$pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);

$pdf->SetMargins(5, 14, 15);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(1.3);

$pdf->setFontSubsetting(true);
$pdf->SetFont('helvetica', '', 10, '', true);

// Group employees by assigned department name for page grouping
$departments = [];
foreach ($employees as $empNo => $empData) {
    $depName = $empData['info']->ass_dep_name;
    $departments[$depName][$empNo] = $empData;
}

foreach ($departments as $departmentName => $empList) {
    $pdf->AddPage('L', 'LEGAL');

    $html = '
    <style>
        table { width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; }
        th, td { border: 1px solid #ddd; font-size: 9px; padding: 6px; text-align: center; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        h5 { font-size: 16px; margin-bottom: 10px; }
        p { font-size: 10px; margin-bottom: 10px; }
    </style>

    <h5 style="text-align:center;">PAY SHEET</h5>
    <p style="font-size: 10px; border-bottom: 1px solid #000;">
        Year: ' . $data_year . ' &nbsp; Month: ' . date('F', mktime(0, 0, 0, $data_month)) . ' &nbsp; 
        <strong style="color:red">Assigned Department: ' . htmlspecialchars($departmentName) . '</strong>
    </p>

    <table>
        <thead>
            <tr>
                <th>EMP NO</th>
                <th>DEP NAME</th>
                <th>NAME</th>
                <th>BASIC</th>
                <th>BR</th>
                <th>FOR EPF</th>';

    // Allowance headers
    foreach ($allowanceNames as $alw) {
        $html .= '<th>' . htmlspecialchars($alw) . '</th>';
    }

    $html .= '
                <th>GROSS PAY</th>
                <th>ADV.PAID</th>
                <th>NO PAY</th>
                <th>LATE</th>
                <th>ED</th>
                <th>STAMP - D</th>
                <th>EPF 8%</th>';

    // Deduction headers
    foreach ($deductionNames as $ded) {
        $html .= '<th>' . htmlspecialchars($ded) . '</th>';
    }

    $html .= '
                <th>TOT DEDUCTION</th>
                <th>NET SALARY</th>
                <th>EPF 12%</th>
                <th>ETF 3%</th>
                <th>BALANCE</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($empList as $empNo => $empData) {
        $info = $empData['info'];
        $allowances = $empData['allowances'];
        $deductions = $empData['deductions'];

        // Calculate balance as an example (you can customize)
        $balance = $info->Net_salary - $info->Salary_advance;

        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($info->EmpNo) . '</td>';
        $html .= '<td>' . htmlspecialchars($info->Dep_Name) . '</td>';
        $html .= '<td style="text-align:left;">' . htmlspecialchars($info->Emp_Full_Name) . '</td>';
        $html .= '<td>' . number_format($info->Basic_sal, 2) . '</td>';
        $html .= '<td>' . number_format($info->Br_pay, 2) . '</td>';
        $html .= '<td>' . number_format($info->Basic_pay, 2) . '</td>';

        // Allowance values dynamically inserted
        foreach ($allowanceNames as $alw) {
            $val = isset($allowances[$alw]) ? $allowances[$alw] : 0.00;
            $html .= '<td>' . number_format($val, 2) . '</td>';
        }

        $html .= '<td>' . number_format($info->Gross_pay, 2) . '</td>';
        $html .= '<td>' . number_format($info->Salary_advance, 2) . '</td>';
        $html .= '<td>' . number_format($info->no_pay_deduction, 2) . '</td>';
        $html .= '<td>' . number_format($info->Late_deduction, 2) . '</td>';
        $html .= '<td>' . number_format($info->Wellfare, 2) . '</td>';
        $html .= '<td>' . number_format($info->Stamp_duty, 2) . '</td>';
        $html .= '<td>' . number_format($info->EPF_Worker_Amount, 2) . '</td>';

        // Deduction values dynamically inserted
        foreach ($deductionNames as $ded) {
            $val = isset($deductions[$ded]) ? $deductions[$ded] : 0.00;
            $html .= '<td>' . number_format($val, 2) . '</td>';
        }

        $html .= '<td>' . number_format($info->tot_deduction, 2) . '</td>';
        $html .= '<td>' . number_format($info->Net_salary, 2) . '</td>';
        $html .= '<td>' . number_format($info->EPF_Employee_Amount, 2) . '</td>';
        $html .= '<td>' . number_format($info->ETF_Amount, 2) . '</td>';
        $html .= '<td>' . number_format($balance, 2) . '</td>';
        $html .= '</tr>';
    }

    $html .= '
        </tbody>
    </table>';

    $pdf->writeHTML($html, true, false, true, false, '');
}

$pdf->Output('paysheet_month_' . $data_month . '.pdf', 'I');
exit;
?>
