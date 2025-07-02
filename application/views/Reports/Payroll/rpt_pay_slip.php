<?php
// Ensure no output is sent before this point and handle errors properly
ob_start(); // Start output buffering

// Set error reporting for development (remove in production)
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Set timezone to prevent date warnings
date_default_timezone_set('Asia/Colombo'); // Adjust to your timezone

$date = date("Y/m/d");

// Your existing data preparation code here...
// Assume $data_set, $data_cmp, $data_month, $data_year variables are prepared

try {
    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor(htmlspecialchars($data_cmp[0]->Company_Name));
    $pdf->SetTitle('Pay Slip - ' . htmlspecialchars($data_set[0]->Emp_Full_Name) . ' - ' . 
                  htmlspecialchars(date('F Y', mktime(0, 0, 0, $data_month, 1, $data_year))));
    $pdf->SetSubject('Employee Payslip');
    $pdf->SetKeywords('Payslip, Salary, ' . htmlspecialchars($data_cmp[0]->Company_Name));

    // Remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // Set margins
    $pdf->SetMargins(10, 10, 10, true);
    $pdf->SetAutoPageBreak(TRUE, 15);

    // Set font
    $pdf->SetFont('helvetica', '', 10);

    // Add a page
    $pdf->AddPage('P', 'A5');

    // Initialize total calculations
    $total_allowances = 0;
    $total_deductions = 0;

    // Process allowances
    $earnings_html = '';
    if (!empty($allowances)) {
        if (isset($allowances['fixed']) && is_array($allowances['fixed'])) {
            foreach ($allowances['fixed'] as $alw) {
                if (isset($alw->Allowance_name) && isset($alw->Amount)) {
                    $earnings_html .= '<tr>
                        <td>' . htmlspecialchars($alw->Allowance_name) . '</td>
                        <td class="amount">' . number_format((float)$alw->Amount, 2) . '</td>
                    </tr>';
                    $total_allowances += (float)$alw->Amount;
                }
            }
        }
        
        if (isset($allowances['variable']) && is_array($allowances['variable'])) {
            foreach ($allowances['variable'] as $alw) {
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

    // Process deductions
    $deductions_html = '';
    if (!empty($deductions)) {
        if (isset($deductions['fixed']) && is_array($deductions['fixed'])) {
            foreach ($deductions['fixed'] as $ded) {
                if (isset($ded->Deduction_name) && isset($ded->Amount)) {
                    $deductions_html .= '<tr>
                        <td>' . htmlspecialchars($ded->Deduction_name) . '</td>
                        <td class="amount">' . number_format((float)$ded->Amount, 2) . '</td>
                    </tr>';
                    $total_deductions += (float)$ded->Amount;
                }
            }
        }
        
        if (isset($deductions['variable']) && is_array($deductions['variable'])) {
            foreach ($deductions['variable'] as $ded) {
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

    // Ensure basic salary exists and is numeric
    $basic_salary = isset($data_set[0]->Basic_sal) ? (float)$data_set[0]->Basic_sal : 0;
    $Normal_OT_Pay = isset($data_set[0]->Normal_OT_Pay) ? (float)$data_set[0]->Normal_OT_Pay : 0;
    $Incentive = isset($data_set[0]->Incentive) ? (float)$data_set[0]->Incentive : 0;
    $Br_pay_Data = isset($data_set[0]->Br_pay) ? (float)$data_set[0]->Br_pay : 0;
    $Gross_pay_Data = isset($data_set[0]->Gross_pay) ? (float)$data_set[0]->Gross_pay : 0;

    // Calculate other values safely
    $salary_advance = isset($data_set[0]->Salary_advance) ? (float)$data_set[0]->Salary_advance : 0;
    $no_pay_deduction = isset($data_set[0]->no_pay_deduction) ? (float)$data_set[0]->no_pay_deduction : 0;
    $Late_deduction = isset($data_set[0]->Late_deduction) ? (float)$data_set[0]->Late_deduction : 0;
    $Ed_deduction = isset($data_set[0]->Ed_deduction) ? (float)$data_set[0]->Ed_deduction : 0;
    $payee_amount = isset($data_set[0]->Payee_amount) ? (float)$data_set[0]->Payee_amount : 0;
    $epf_worker = isset($data_set[0]->EPF_Worker_Amount) ? (float)$data_set[0]->EPF_Worker_Amount : 0;
    $epf_employer = isset($data_set[0]->EPF_Employee_Amount) ? (float)$data_set[0]->EPF_Employee_Amount : 0;
    $etf_amount = isset($data_set[0]->ETF_Amount) ? (float)$data_set[0]->ETF_Amount : 0;
    $stamp_duty = isset($data_set[0]->Stamp_duty) ? (float)$data_set[0]->Stamp_duty : 0;
    
    // Get total deduction from data or calculate it
    $total_all_deductions = isset($data_set[0]->tot_deduction) ? (float)$data_set[0]->tot_deduction : 
                          ($total_deductions + $salary_advance + $no_pay_deduction + $Late_deduction + $Ed_deduction + $payee_amount + $epf_worker + $stamp_duty);
    
    // Get net salary from data or calculate it
    $net_salary = isset($data_set[0]->Net_salary) ? (float)$data_set[0]->Net_salary : 
                 (($basic_salary + $Normal_OT_Pay + $Incentive + $total_allowances) - $total_all_deductions);

    // Generate pay period string for better display
    $pay_period = date('F Y', mktime(0, 0, 0, $data_month, 1, $data_year));
    
    // Get company logo if available
    $logo_html = '';
    if (isset($data_cmp[0]->Company_Logo) && file_exists($data_cmp[0]->Company_Logo)) {
        $logo_html = '<img src="' . $data_cmp[0]->Company_Logo . '" style="max-width: 150px; max-height: 60px;">';
    }

    // Modern HTML design with improved styling
    $html = '
    <style>
        /* Base styles */
        body {
            font-family: "Helvetica", sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #333;
        }
        
        /* Header section */
        .header {
            background-color: #2c3e50;
            color: white;
            padding: 12px;
            text-align: center;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .header h1 {
            font-size: 18px;
            margin: 5px 0;
            font-weight: bold;
        }
        .header p {
            font-size: 12px;
            margin: 3px 0;
        }
        
        /* Employee info box */
        .employee-info {
            background-color: #f8f9fa;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        
        /* Section styling */
        .section {
            margin-bottom: 15px;
        }
        .section-title {
            background-color: #e9ecef;
            padding: 5px 10px;
            font-weight: bold;
            border-left: 4px solid #2c3e50;
            margin-bottom: 8px;
            border-radius: 3px;
        }
        
        /* Tables */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .table th {
            background-color: #f1f1f1;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
        }
        .table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .amount {
            text-align: right;
            font-family: courier, monospace;
            white-space: nowrap;
        }
        .total-row {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        
        /* Net salary box */
        .net-salary {
            background-color: #2c3e50;
            color: white;
            padding: 10px;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            border-radius: 5px;
            margin: 15px 0;
        }
        
        /* Footer */
        .footer {
            font-size: 9px;
            text-align: center;
            color: #777;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }
        
        /* Divider */
        .divider {
            border-top: 1px dashed #ddd;
            margin: 10px 0;
        }
        
        /* Pay period banner */
        .pay-period {
            background-color: #3498db;
            color: white;
            padding: 5px 10px;
            font-weight: bold;
            text-align: center;
            border-radius: 3px;
            margin-bottom: 10px;
        }
        
        /* Improved layout for summary section */
        .summary-box {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 8px;
            margin-top: 10px;
            background-color: #f9f9f9;
        }
    </style>

    <div class="header">
        <h1>' . htmlspecialchars($data_cmp[0]->Company_Name) . '</h1>
        <p>Employee Payslip</p>
    </div>
    
    <div class="pay-period">
        Pay Period: ' . htmlspecialchars($pay_period) . '
    </div>

    <div class="employee-info">
        <table width="100%">
            <tr>
                <td width="50%"><strong>Employee Name:</strong> ' . htmlspecialchars($data_set[0]->Emp_Full_Name) . '</td>
                <td width="50%"><strong>Employee ID:</strong> ' . htmlspecialchars($data_set[0]->EmpNo) . '</td>
            </tr>
            <tr>
                <td><strong>Department:</strong> ' . htmlspecialchars($data_set[0]->Dep_Name) . '</td>
                <td><strong>Branch:</strong> ' . htmlspecialchars($data_set[0]->B_name) . '</td>
            </tr>
            <tr>
                <td><strong>Position:</strong> ' . (isset($data_set[0]->Position) ? htmlspecialchars($data_set[0]->Position) : 'N/A') . '</td>
                <td><strong>Generated on:</strong> ' . htmlspecialchars(date('d M Y, h:i A')) . '</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <table class="table">
            <tr>
                <th width="70%">Earnings</th>
                <th class="amount" width="30%">Amount (Rs.)</th>
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

    <div class="divider"></div>

    <div class="section">
        <table class="table">
            <tr>
                <th width="70%">Deductions</th>
                <th class="amount" width="30%">Amount (Rs.)</th>
            </tr>
            ' . $deductions_html . '
            <tr>
                <td>Salary Advance</td>
                <td class="amount">' . number_format($salary_advance, 2) . '</td>
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
                <td>NoPay Deduction</td>
                <td class="amount">' . number_format($no_pay_deduction, 2) . '</td>
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

    <div class="divider"></div>

    <div class="section">
        <table class="table">
            <tr>
                <th width="70%">Description</th>
                <th class="amount" width="30%">Amount (Rs.)</th>
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
                <td>Total Employer Contributions</td>
                <td class="amount">' . number_format($epf_employer + $etf_amount, 2) . '</td>
            </tr>
        </table>
    </div>

    <div class="summary-box">
        <table width="100%">
            <tr>
                <td width="70%"><strong>Gross Earnings:</strong></td>
                <td class="amount" width="30%"><strong>Rs. ' . number_format($Gross_pay_Data, 2) . '</strong></td>
            </tr>
            <tr>
                <td><strong>Total Deductions:</strong></td>
                <td class="amount"><strong>Rs. ' . number_format($total_all_deductions, 2) . '</strong></td>
            </tr>
        </table>
    </div>

    <div class="net-salary">
        Net Salary: Rs. ' . number_format($net_salary, 2) . '
    </div>

    <div class="footer">
        <p>This is a computer-generated payslip and does not require a signature.</p>
        <p>' . htmlspecialchars($data_cmp[0]->Company_Name) . ' | ' . htmlspecialchars($data_cmp[0]->Company_Address) . '</p>
        <p>For any queries regarding this payslip, please contact HR department.</p>
    </div>';

    // Output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // Clear any previous output
    ob_end_clean();
    
    // Close and output PDF document
    $pdf->Output('Payslip_' . $data_set[0]->EmpNo . '_' . date('F_Y', mktime(0, 0, 0, $data_month, 1, $data_year)) . '.pdf', 'I');

} catch (Exception $e) {
    // Clean any output that might have been generated
    ob_end_clean();
    
    // Log the error for debugging (in a production environment)
    // error_log('PDF Generation Error: ' . $e->getMessage());
    
    // Display user-friendly error message
    echo '<!DOCTYPE html>
        <html>
        <head>
            <title>Error</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 50px; }
                .error-box { border: 1px solid #f5c6cb; background-color: #f8d7da; color: #721c24; padding: 20px; border-radius: 5px; }
                h2 { margin-top: 0; }
                .back-btn { margin-top: 20px; }
                .back-btn a { background-color: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; }
            </style>
        </head>
        <body>
            <div class="error-box">
                <h2>Error Generating Payslip</h2>
                <p>We\'re sorry, but there was an error generating your payslip. Please try again later or contact technical support.</p>
                <p>Error reference: ' . time() . '</p>
                <div class="back-btn">
                    <a href="javascript:history.back()">Go Back</a>
                </div>
            </div>
        </body>
        </html>';
    exit;
}