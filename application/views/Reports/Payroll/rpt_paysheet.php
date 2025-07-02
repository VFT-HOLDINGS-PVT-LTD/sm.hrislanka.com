<?php
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A3', true, 'UTF-8', false);

// PDF metadata
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Payroll System');
$pdf->SetTitle('Paysheet_Month_' . $data_month . '.pdf');
$pdf->SetSubject('Paysheet');

// Modern header/footer styling
$pdf->SetHeaderData('', '0', $data_cmp[0]->Company_Name ?? 'Company Name', '', [44, 62, 80], [44, 62, 80]);
$pdf->setFooterData([44, 62, 80], [44, 62, 80]);

$pdf->setHeaderFont(['helvetica', 'B', 12]);
$pdf->setFooterFont(['helvetica', '', 8]);

$pdf->SetMargins(10, 20, 10);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(true, 15);
$pdf->setImageScale(1.3);

$pdf->setFontSubsetting(true);
$pdf->SetFont('helvetica', '', 9, '', true);

// Group employees by department
$departments = [];
foreach ($employees as $empNo => $empData) {
    $depName                       = $empData['info']->ass_dep_name;
    $departments[$depName][$empNo] = $empData;
}

foreach ($departments as $departmentName => $empList) {
    $pdf->AddPage('L', 'LEGAL');

    $html = '
    <style>
        body { font-family: "Helvetica", Arial, sans-serif; color: #333; }
        .header { margin-bottom: 15px; text-align: center; }
        .title { font-size: 18px; font-weight: bold; color: #2c3e50; margin-bottom: 5px; }
        .subtitle { font-size: 12px; color: #7f8c8d; margin-bottom: 10px; border-bottom: 1px solid #ecf0f1; padding-bottom: 8px; }
        .dept-name { color: #3498db; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #2c3e50; color: white; font-weight: bold; padding: 8px; font-size: 9px; text-align: center; border: 1px solid #ddd; }
        td { padding: 6px; font-size: 8px; text-align: center; border: 1px solid #ecf0f1; }
        tr:nth-child(even) { background-color: #f8f9fa; }
        tr:hover { background-color: #f1f8fe; }
        .highlight { font-weight: bold; color: #e74c3c; }
        .total-row { background-color: #eaf2f8 !important; font-weight: bold;color:rgb(247, 251, 255); }
        .currency { text-align: right; }
    </style>

    <div class="header">
        <div class="title">EMPLOYEE PAY SHEET</div>
        <div class="subtitle">
            Year: ' . $data_year . ' | Month: ' . date('F', mktime(0, 0, 0, $data_month)) . ' |
            Department: <span class="dept-name">' . htmlspecialchars($departmentName) . '</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">EMP ID</th>
                <th width="5%">DEPARTMENT</th>
                <th width="5%">EMPLOYEE NAME</th>
                <th width="5%">BASIC</th>
                <th width="4%">BR</th>
                <th width="5%">FOR EPF</th>';

    // Allowance headers
    foreach ($allowanceNames as $alw) {
        $html .= '<th width="5%">' . htmlspecialchars($alw) . '</th>';
    }

    $html .= '
                <th width="5%">GROSS PAY</th>
                <th width="5%">ADVANCE</th>
                <th width="4%">NO PAY</th>
                <th width="4%">LATE</th>
                <th width="4%">ED</th>
                <th width="4%">STAMP</th>
                <th width="5%">EPF 8%</th>';

    // Deduction headers
    foreach ($deductionNames as $ded) {
        $html .= '<th width="5%">' . htmlspecialchars($ded) . '</th>';
    }

    $html .= '
                <th width="5%">TOTAL DEDUCTIONS</th>
                <th width="5%">NET SALARY</th>
                <th width="5%">EPF 12%</th>
                <th width="5%">ETF 3%</th>
                <th width="5%">BALANCE</th>
            </tr>
        </thead>
        <tbody>';

    $totalGross      = 0;
    $totalNet        = 0;
    $totalDeductions = 0;
    $totalBalance    = 0;

    foreach ($empList as $empNo => $empData) {
        $info       = $empData['info'];
        $allowances = $empData['allowances'];
        $deductions = $empData['deductions'];
        $balance    = $info->Net_salary - $info->Salary_advance;

        $totalGross += $info->Gross_pay;
        $totalNet += $info->Net_salary;
        $totalDeductions += $info->tot_deduction;
        $totalBalance += $balance;

        $html .= '<tr>';
        $html .= '<td width="4%">' . htmlspecialchars($info->EmpNo) . '</td>';
        $html .= '<td width="5%">' . htmlspecialchars($info->Dep_Name) . '</td>';
        $html .= '<td width="5%" style="text-align:left;">' . htmlspecialchars($info->Emp_Full_Name) . '</td>';
        $html .= '<td width="5%" class="currency">' . number_format($info->Basic_sal, 2) . '</td>';
        $html .= '<td width="4%" class="currency">' . number_format($info->Br_pay, 2) . '</td>';
        $html .= '<td width="5%" class="currency">' . number_format($info->Total_F_Epf, 2) . '</td>';

        // Allowance values
        foreach ($allowanceNames as $alw) {
            $val = isset($allowances[$alw]) ? $allowances[$alw] : 0.00;
            $html .= '<td width="5%" class="currency">' . number_format($val, 2) . '</td>';
        }

        $html .= '<td width="5%" class="currency highlight">' . number_format($info->Gross_pay, 2) . '</td>';
        $html .= '<td width="5%" class="currency">' . number_format($info->Salary_advance, 2) . '</td>';
        $html .= '<td width="4%" class="currency">' . number_format($info->no_pay_deduction, 2) . '</td>';
        $html .= '<td width="4%" class="currency">' . number_format($info->Late_deduction, 2) . '</td>';
        $html .= '<td width="4%" class="currency">' . number_format($info->Ed_deduction, 2) . '</td>';
        $html .= '<td width="4%" class="currency">' . number_format($info->Stamp_duty, 2) . '</td>';
        $html .= '<td width="5%" class="currency">' . number_format($info->EPF_Worker_Amount, 2) . '</td>';

        // Deduction values
        foreach ($deductionNames as $ded) {
            $val = isset($deductions[$ded]) ? $deductions[$ded] : 0.00;
            $html .= '<td width="5%" class="currency">' . number_format($val, 2) . '</td>';
        }

        $html .= '<td width="5%" class="currency highlight">' . number_format($info->tot_deduction, 2) . '</td>';
        $html .= '<td width="5%" class="currency highlight">' . number_format($info->Net_salary, 2) . '</td>';
        $html .= '<td width="5%" class="currency">' . number_format($info->EPF_Employee_Amount, 2) . '</td>';
        $html .= '<td width="5%" class="currency">' . number_format($info->ETF_Amount, 2) . '</td>';
        $html .= '<td width="5%" class="currency highlight">' . number_format($balance, 2) . '</td>';
        $html .= '</tr>';
    }

    // Add totals row
    $html .= '<tr class="total-row">';
    $html .= '<td colspan="' . (6 + count($allowanceNames)) . '" style="text-align:right;"><strong>TOTALS:</strong></td>';
    $html .= '<td class="currency">' . number_format($totalGross, 2) . '</td>';
    $html .= '<td colspan="' . (5 + count($deductionNames)) . '"></td>';
    $html .= '<td class="currency">' . number_format($totalDeductions, 2) . '</td>';
    $html .= '<td class="currency">' . number_format($totalNet, 2) . '</td>';
    $html .= '<td colspan="3"></td>';
    $html .= '<td class="currency">' . number_format($totalBalance, 2) . '</td>';
    $html .= '</tr>';

    $html .= '
        </tbody>
    </table>';

    $pdf->writeHTML($html, true, false, true, false, '');
}

$pdf->Output('paysheet_month_' . $data_month . '.pdf', 'I');
exit;
