<?php
// Ensure no output is sent before this point
ob_start();

// Set timezone to prevent date warnings
date_default_timezone_set('Asia/Colombo');
$date = date("Y/m/d");

try {
    // Create new PDF document
    $pdf = new TCPDF('P', PDF_UNIT, 'A5', true, 'UTF-8', false);
    
    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor(htmlspecialchars($data_cmp[0]->Company_Name));
    $pdf->SetTitle('Pay Slip - ' . htmlspecialchars($data_set[0]->Emp_Full_Name) . ' - ' . 
                  htmlspecialchars(date('F Y', mktime(0, 0, 0, $data_month, 1, $data_year))));
    
    // Remove header/footer, set margins and disable auto page break for better control
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(10, 5, 10, true); // Increased left/right margins to 10mm
    $pdf->SetAutoPageBreak(TRUE, 5);
    
    // Set smaller font size for better fit
    $pdf->SetFont('helvetica', '', 8);
    
    // Add a page
    $pdf->AddPage('P', 'A5');
    
    // Initialize totals
    $total_allowances = 0;
    $total_deductions = 0;
    
    // Process allowances
    $earnings_html = '';
    if (!empty($allowances)) {
        foreach (['fixed', 'variable'] as $type) {
            if (isset($allowances[$type]) && is_array($allowances[$type])) {
                foreach ($allowances[$type] as $alw) {
                    if (isset($alw->Allowance_name) && isset($alw->Amount)) {
                        $earnings_html .= '<tr>
                            <td>' . htmlspecialchars($alw->Allowance_name) . '</td>
                            <td class="amount">' . number_format((float)$alw->Amount, 2) . '</td>
                        </tr>';
                        $total_allowances += (float)$alw->Amount;
                    }
                }
            }
        }
    }
    
    // Process deductions
    $deductions_html = '';
    if (!empty($deductions)) {
        foreach (['fixed', 'variable'] as $type) {
            if (isset($deductions[$type]) && is_array($deductions[$type])) {
                foreach ($deductions[$type] as $ded) {
                    if (isset($ded->Deduction_name) && isset($ded->Amount)) {
                        $deductions_html .= '<tr>
                            <td>' . htmlspecialchars($ded->Deduction_name) . '</td>
                            <td class="amount">' . number_format((float)$ded->Amount, 2) . '</td>
                        </tr>';
                        $total_deductions += (float)$ded->Amount;
                    }
                }
            }
        }
    }
    
    // Safely get salary data with default values of 0
    $basic_salary = isset($data_set[0]->Basic_sal) ? (float)$data_set[0]->Basic_sal : 0;
    $Normal_OT_Pay = isset($data_set[0]->Normal_OT_Pay) ? (float)$data_set[0]->Normal_OT_Pay : 0;
    $Incentive = isset($data_set[0]->Incentive) ? (float)$data_set[0]->Incentive : 0;
    $Br_pay_Data = isset($data_set[0]->Br_pay) ? (float)$data_set[0]->Br_pay : 0;
    $Gross_pay_Data = isset($data_set[0]->Gross_pay) ? (float)$data_set[0]->Gross_pay : 0;
    
    // Get deduction data
    $salary_advance = isset($data_set[0]->Salary_advance) ? (float)$data_set[0]->Salary_advance : 0;
    $no_pay_deduction = isset($data_set[0]->no_pay_deduction) ? (float)$data_set[0]->no_pay_deduction : 0;
    $Late_deduction = isset($data_set[0]->Late_deduction) ? (float)$data_set[0]->Late_deduction : 0;
    $Ed_deduction = isset($data_set[0]->Ed_deduction) ? (float)$data_set[0]->Ed_deduction : 0;
    $payee_amount = isset($data_set[0]->Payee_amount) ? (float)$data_set[0]->Payee_amount : 0;
    $epf_worker = isset($data_set[0]->EPF_Worker_Amount) ? (float)$data_set[0]->EPF_Worker_Amount : 0;
    $epf_employer = isset($data_set[0]->EPF_Employee_Amount) ? (float)$data_set[0]->EPF_Employee_Amount : 0;
    $etf_amount = isset($data_set[0]->ETF_Amount) ? (float)$data_set[0]->ETF_Amount : 0;
    $stamp_duty = isset($data_set[0]->Stamp_duty) ? (float)$data_set[0]->Stamp_duty : 0;
    
    // Get totals
    $total_all_deductions = isset($data_set[0]->tot_deduction) ? (float)$data_set[0]->tot_deduction : 
                          ($total_deductions + $salary_advance + $no_pay_deduction + $Late_deduction + 
                           $Ed_deduction + $payee_amount + $epf_worker + $stamp_duty);
    
    $net_salary = isset($data_set[0]->Net_salary) ? (float)$data_set[0]->Net_salary : 
                 (($basic_salary + $Normal_OT_Pay + $Incentive + $total_allowances) - $total_all_deductions);
    
    // Pay period
    $pay_period = date('F Y', mktime(0, 0, 0, $data_month, 1, $data_year));
    
    // Compact HTML with smaller elements and spacing for better fit
    $html = '
    <style>
        body { font-family: "Helvetica", sans-serif; font-size: 8pt; line-height: 1.2; color: #333; }
        
        /* Modern header with gradient */
        .header { 
            background: linear-gradient(to right, #2c3e50, #3498db); 
            color: white; 
            padding: 6px; 
            text-align: center; 
            margin-bottom: 7px; 
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .header h1 { font-size: 13px; margin: 2px 0; font-weight: bold; }
        .header p { font-size: 8px; margin: 1px 0; }
        
        /* Employee info box with subtle shadow */
        .employee-info { 
            background-color: #f8f9fa; 
            padding: 6px; 
            border-radius: 4px; 
            margin-bottom: 7px; 
            font-size: 7pt;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            border-left: 3px solid #3498db;
        }
        
        .section { margin-bottom: 6px; }
        .section-title { 
            background-color: #e9ecef; 
            padding: 3px 6px; 
            font-weight: bold; 
            border-left: 3px solid #3498db; 
            margin-bottom: 3px; 
            border-radius: 3px; 
            font-size: 7pt;
        }
        
        /* Modern tables with subtle lines */
        .table { width: 100%; border-collapse: collapse; margin-bottom: 6px; font-size: 7pt; }
        .table th { 
            background-color: #f1f1f1; 
            padding: 4px; 
            text-align: left; 
            font-weight: bold; 
            border-bottom: 1px solid #ddd;
        }
        .table td { padding: 3px 4px; border-bottom: 1px solid #eee; }
        .amount { text-align: right; font-family: courier, monospace; white-space: nowrap; }
        .total-row { 
            font-weight: bold; 
            background-color: #f8f9fa;
        }
        
        /* Net salary box with gradient */
        .net-salary { 
            background: linear-gradient(to right, #2c3e50, #3498db);
            color: white; 
            padding: 5px; 
            text-align: center; 
            font-size: 10pt; 
            font-weight: bold; 
            border-radius: 4px; 
            margin: 6px 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .footer { 
            font-size: 6pt; 
            text-align: center; 
            color: #777; 
            margin-top: 7px; 
            padding-top: 4px; 
            border-top: 1px solid #eee;
        }
        
        .divider { 
            border-top: 1px dashed #ddd; 
            margin: 5px 0;
        }
        
        /* Pay period banner with gradient */
        .pay-period { 
            background: linear-gradient(to right, #3498db, #2980b9); 
            color: white; 
            padding: 3px 6px; 
            font-weight: bold; 
            text-align: center; 
            border-radius: 3px; 
            margin-bottom: 6px; 
            font-size: 7pt;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        
        /* Summary box with border and shadow */
        .summary-box { 
            border: 1px solid #ddd; 
            border-radius: 4px; 
            padding: 5px; 
            margin-top: 6px; 
            background-color: #f9f9f9; 
            font-size: 7pt;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        
        /* Two-column layout for better space usage */
        .col-layout { width: 100%; }
        .col-layout .col { width: 48%; display: inline-block; vertical-align: top; }
    </style>

    <div class="header">
        <h1>' . htmlspecialchars($data_cmp[0]->Company_Name) . '</h1>
        <p>Employee Payslip - ' . htmlspecialchars($pay_period) . '</p>
    </div>

    <div class="employee-info">
        <table width="100%" cellspacing="0" cellpadding="1">
            <tr>
                <td width="22%"><strong>Name:</strong></td>
                <td width="28%">' . htmlspecialchars($data_set[0]->Emp_Full_Name) . '</td>
                <td width="22%"><strong>ID:</strong></td>
                <td width="28%">' . htmlspecialchars($data_set[0]->EmpNo) . '</td>
            </tr>
            <tr>
                <td><strong>Department:</strong></td>
                <td>' . htmlspecialchars($data_set[0]->Dep_Name) . '</td>
                <td><strong>Branch:</strong></td>
                <td>' . htmlspecialchars($data_set[0]->B_name) . '</td>
            </tr>
        </table>
    </div>

    <div class="col-layout">
        <div class="col" style="padding-right: 5px;">
            <table class="table" cellspacing="0" cellpadding="2">
                <tr>
                    <th width="65%">Earnings</th>
                    <th class="amount" width="35%">Amount</th>
                </tr>
                <tr>
                    <td>Basic Salary</td>
                    <td class="amount">' . number_format($basic_salary, 2) . '</td>
                </tr>
                <tr>
                    <td>BR</td>
                    <td class="amount">' . number_format($Br_pay_Data, 2) . '</td>
                </tr>
                <tr>
                    <td>Incentive</td>
                    <td class="amount">' . number_format($Incentive, 2) . '</td>
                </tr>
                <tr>
                    <td>OT</td>
                    <td class="amount">' . number_format($Normal_OT_Pay, 2) . '</td>
                </tr>
                ' . $earnings_html . '
                <tr class="total-row">
                    <td>Total Earnings</td>
                    <td class="amount">' . number_format($Gross_pay_Data, 2) . '</td>
                </tr>
            </table>
        </div>
        
        <div class="col" style="padding-left: 5px;">
            <table class="table" cellspacing="0" cellpadding="2">
                <tr>
                    <th width="65%">Deductions</th>
                    <th class="amount" width="35%">Amount</th>
                </tr>
                ' . $deductions_html . '
                <tr>
                    <td>Salary Advance</td>
                    <td class="amount">' . number_format($salary_advance, 2) . '</td>
                </tr>
                <tr>
                    <td>NoPay Deduction</td>
                    <td class="amount">' . number_format($no_pay_deduction, 2) . '</td>
                </tr>
                <tr>
                    <td>Late Deduction</td>
                    <td class="amount">' . number_format($Late_deduction, 2) . '</td>
                </tr>
                <tr>
                    <td>ED Deduction</td>
                    <td class="amount">' . number_format($Ed_deduction, 2) . '</td>
                </tr>
                <tr>
                    <td>PAYE Tax</td>
                    <td class="amount">' . number_format($payee_amount, 2) . '</td>
                </tr>
                <tr>
                    <td>EPF (8%)</td>
                    <td class="amount">' . number_format($epf_worker, 2) . '</td>
                </tr>
                <tr>
                    <td>Stamp Duty</td>
                    <td class="amount">' . number_format($stamp_duty, 2) . '</td>
                </tr>
                <tr class="total-row">
                    <td>Total Deductions</td>
                    <td class="amount">' . number_format($total_all_deductions, 2) . '</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="divider"></div>

    <div class="col-layout">
        <div class="col" style="padding-right: 5px;">
            <table class="table" cellspacing="0" cellpadding="2">
                <tr>
                    <th width="65%">Employer Contributions</th>
                    <th class="amount" width="35%">Amount</th>
                </tr>
                <tr>
                    <td>EPF (12%)</td>
                    <td class="amount">' . number_format($epf_employer, 2) . '</td>
                </tr>
                <tr>
                    <td>ETF (3%)</td>
                    <td class="amount">' . number_format($etf_amount, 2) . '</td>
                </tr>
                <tr class="total-row">
                    <td>Total</td>
                    <td class="amount">' . number_format($epf_employer + $etf_amount, 2) . '</td>
                </tr>
            </table>
        </div>
        
        <div class="col" style="padding-left: 5px;">
            <div class="summary-box">
                <table width="100%" cellspacing="0" cellpadding="2">
                    <tr>
                        <td width="60%"><strong>Gross Earnings:</strong></td>
                        <td class="amount" width="40%">Rs. ' . number_format($Gross_pay_Data, 2) . '</td>
                    </tr>
                    <tr>
                        <td><strong>Total Deductions:</strong></td>
                        <td class="amount">Rs. ' . number_format($total_all_deductions, 2) . '</td>
                    </tr>
                </table>
            </div>
            
            <div class="net-salary">
                Net Salary: Rs. ' . number_format($net_salary, 2) . '
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Computer-generated payslip - no signature required | ' . htmlspecialchars($data_cmp[0]->Company_Name) . ' | ' . htmlspecialchars($data_cmp[0]->Company_Address) . '</p>
    </div>';

    // Output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // Clean buffer and output PDF
    ob_end_clean();
    $pdf->Output('Payslip_' . $data_set[0]->EmpNo . '_' . date('F_Y', mktime(0, 0, 0, $data_month, 1, $data_year)) . '.pdf', 'I');

} catch (Exception $e) {
    ob_end_clean();
    echo '<!DOCTYPE html>
        <html>
        <head>
            <title>Error</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .error-box { border: 1px solid #f5c6cb; background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 3px; }
                h3 { margin-top: 0; }
                .back-btn { margin-top: 15px; }
                .back-btn a { background-color: #007bff; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 14px; }
            </style>
        </head>
        <body>
            <div class="error-box">
                <h3>Error Generating Payslip</h3>
                <p>We\'re sorry, but there was an error generating your payslip. Please try again or contact support.</p>
                <div class="back-btn">
                    <a href="javascript:history.back()">Go Back</a>
                </div>
            </div>
        </body>
        </html>';
    exit;
}
?>