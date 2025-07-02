<?php
// Ensure error messages aren't displayed (important to prevent output before PDF)
error_reporting(0);
ini_set('display_errors', 0);

// Start output buffering immediately at the very beginning to catch any potential output
ob_start();

// Set timezone to prevent date warnings
date_default_timezone_set('Asia/Colombo'); // Adjust to your timezone

$date = date("Y/m/d");

// Function to generate payslip HTML for a single employee
function generatePayslipHTML($data_set, $data_cmp, $data_month, $data_year, $allowances, $deductions) {
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

    // Generate a compact HTML for the payslip (optimized for multiple payslips on one page)
    $html = '
    <div class="payslip">
        <div class="header">
            <h1>' . htmlspecialchars($data_cmp[0]->Company_Name) . '</h1>
            <p>Employee Payslip - ' . htmlspecialchars($pay_period) . '</p>
        </div>
        
        <div class="employee-info">
            <table width="100%">
                <tr>
                    <td width="50%"><strong>Name:</strong> ' . htmlspecialchars($data_set[0]->Emp_Full_Name) . '</td>
                    <td width="50%"><strong>ID:</strong> ' . htmlspecialchars($data_set[0]->EmpNo) . '</td>
                </tr>
                <tr>
                    <td><strong>Dept:</strong> ' . htmlspecialchars($data_set[0]->Dep_Name) . '</td>
                    <td><strong>Branch:</strong> ' . htmlspecialchars($data_set[0]->B_name) . '</td>
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
                    <td>EPF (8%)</td>
                    <td class="amount">' . number_format($epf_worker, 2) . '</td>
                </tr>
                <tr class="total-row">
                    <td>Total Deductions</td>
                    <td class="amount">' . number_format($total_all_deductions, 2) . '</td>
                </tr>
            </table>
        </div>

        <div class="net-salary">
            Net Salary: Rs. ' . number_format($net_salary, 2) . '
        </div>
    </div>';

    return $html;
}

try {
    // Clean any previous output
    ob_clean();
    
    // Create new PDF document
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Company Name');
    $pdf->SetTitle('Multiple Payslips');
    $pdf->SetSubject('Employee Payslips');
    $pdf->SetKeywords('Payslip, Salary, Reports');

    // Remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // Set margins
    $pdf->SetMargins(10, 10, 10, true);
    $pdf->SetAutoPageBreak(TRUE, 15);

    // Set font
    $pdf->SetFont('helvetica', '', 8); // Smaller font for multiple reports

    // Add a page
    $pdf->AddPage();

    // CSS for multiple payslips on one page
    $css = '
    <style>
        /* Base styles */
        body {
            font-family: "Helvetica", sans-serif;
            font-size: 8pt;
            line-height: 1.2;
            color: #333;
        }
        
        /* Payslip container */
        .payslip {
            border: 1px solid #ddd;
            margin-bottom: 10px;
            padding: 5px;
            page-break-inside: avoid;
        }
        
        /* Header section */
        .header {
            background-color: #2c3e50;
            color: white;
            padding: 5px;
            text-align: center;
            margin-bottom: 5px;
            border-radius: 3px;
        }
        .header h1 {
            font-size: 12px;
            margin: 2px 0;
            font-weight: bold;
        }
        .header p {
            font-size: 9px;
            margin: 2px 0;
        }
        
        /* Employee info box */
        .employee-info {
            background-color: #f8f9fa;
            padding: 5px;
            border-radius: 3px;
            margin-bottom: 5px;
            font-size: 7pt;
        }
        
        /* Section styling */
        .section {
            margin-bottom: 5px;
        }
        
        /* Tables */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
            font-size: 7pt;
        }
        .table th {
            background-color: #f1f1f1;
            padding: 3px;
            text-align: left;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
        }
        .table td {
            padding: 2px 3px;
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
            padding: 3px;
            text-align: center;
            font-size: 9px;
            font-weight: bold;
            border-radius: 3px;
            margin-top: 5px;
        }
        
        /* 2x2 grid layout */
        .payslip-grid {
            display: table;
            width: 100%;
            table-layout: fixed;
        }
        .payslip-row {
            display: table-row;
        }
        .payslip-cell {
            display: table-cell;
            width: 50%;
            padding: 5px;
            vertical-align: top;
        }
    </style>';

    // Assume we have 4 sets of employee data (you'll need to load these from your database)
    // For this example, we'll simulate having 4 different employees

    // Start the grid layout
    $html = $css . '<div class="payslip-grid">';
    
    // First row with 2 payslips
    $html .= '<div class="payslip-row">';
    $html .= '<div class="payslip-cell">';
    
    // First employee data
    // In a real scenario, you would fetch this data from your database
    // For this example, we'll use the same data structure as your original code
    // but assume we have 4 different employee records
    
    // Simulate data for employee 1
    $data_set1 = [
        (object)[
            'Emp_Full_Name' => 'John Smith',
            'EmpNo' => 'EMP001',
            'Dep_Name' => 'IT Department',
            'B_name' => 'Head Office',
            'Basic_sal' => 50000,
            'Normal_OT_Pay' => 5000,
            'Incentive' => 2000,
            'Br_pay' => 1000,
            'Gross_pay' => 58000,
            'Salary_advance' => 2000,
            'no_pay_deduction' => 0,
            'Late_deduction' => 500,
            'Ed_deduction' => 0,
            'Payee_amount' => 1000,
            'EPF_Worker_Amount' => 4000,
            'EPF_Employee_Amount' => 6000,
            'ETF_Amount' => 1500,
            'Stamp_duty' => 25,
            'tot_deduction' => 7525,
            'Net_salary' => 50475,
        ]
    ];
    
    // Simulate company data
    $data_cmp = [
        (object)[
            'Company_Name' => 'ABC Corporation',
            'Company_Address' => '123 Main Street, Colombo 05, Sri Lanka',
            'Company_Logo' => ''
        ]
    ];
    
    // Simulate allowances and deductions for employee 1
    $allowances1 = [
        'fixed' => [
            (object)['Allowance_name' => 'Transport Allowance', 'Amount' => 3000],
            (object)['Allowance_name' => 'Meal Allowance', 'Amount' => 2000]
        ],
        'variable' => []
    ];
    
    $deductions1 = [
        'fixed' => [
            (object)['Deduction_name' => 'Welfare Fund', 'Amount' => 500]
        ],
        'variable' => []
    ];
    
    // Generate HTML for employee 1
    $html .= generatePayslipHTML($data_set1, $data_cmp, 5, 2025, $allowances1, $deductions1);
    $html .= '</div>';
    
    // Second employee in the first row
    $html .= '<div class="payslip-cell">';
    
    // Simulate data for employee 2
    $data_set2 = [
        (object)[
            'Emp_Full_Name' => 'Jane Doe',
            'EmpNo' => 'EMP002',
            'Dep_Name' => 'Finance',
            'B_name' => 'Head Office',
            'Basic_sal' => 60000,
            'Normal_OT_Pay' => 3000,
            'Incentive' => 5000,
            'Br_pay' => 1200,
            'Gross_pay' => 69200,
            'Salary_advance' => 0,
            'no_pay_deduction' => 2000,
            'Late_deduction' => 0,
            'Ed_deduction' => 1000,
            'Payee_amount' => 1500,
            'EPF_Worker_Amount' => 4800,
            'EPF_Employee_Amount' => 7200,
            'ETF_Amount' => 1800,
            'Stamp_duty' => 25,
            'tot_deduction' => 9325,
            'Net_salary' => 59875,
        ]
    ];
    
    // Simulate allowances and deductions for employee 2
    $allowances2 = [
        'fixed' => [
            (object)['Allowance_name' => 'Transport Allowance', 'Amount' => 3500],
            (object)['Allowance_name' => 'Meal Allowance', 'Amount' => 2500]
        ],
        'variable' => []
    ];
    
    $deductions2 = [
        'fixed' => [
            (object)['Deduction_name' => 'Welfare Fund', 'Amount' => 500],
            (object)['Deduction_name' => 'Professional Fee', 'Amount' => 1000]
        ],
        'variable' => []
    ];
    
    // Generate HTML for employee 2
    $html .= generatePayslipHTML($data_set2, $data_cmp, 5, 2025, $allowances2, $deductions2);
    $html .= '</div>';
    $html .= '</div>'; // End of first row
    
    // Second row with 2 more payslips
    $html .= '<div class="payslip-row">';
    $html .= '<div class="payslip-cell">';
    
    // Simulate data for employee 3
    $data_set3 = [
        (object)[
            'Emp_Full_Name' => 'Robert Johnson',
            'EmpNo' => 'EMP003',
            'Dep_Name' => 'Marketing',
            'B_name' => 'Branch A',
            'Basic_sal' => 45000,
            'Normal_OT_Pay' => 6000,
            'Incentive' => 8000,
            'Br_pay' => 900,
            'Gross_pay' => 59900,
            'Salary_advance' => 5000,
            'no_pay_deduction' => 0,
            'Late_deduction' => 0,
            'Ed_deduction' => 0,
            'Payee_amount' => 800,
            'EPF_Worker_Amount' => 3600,
            'EPF_Employee_Amount' => 5400,
            'ETF_Amount' => 1350,
            'Stamp_duty' => 25,
            'tot_deduction' => 9425,
            'Net_salary' => 50475,
        ]
    ];
    
    // Simulate allowances and deductions for employee 3
    $allowances3 = [
        'fixed' => [
            (object)['Allowance_name' => 'Transport Allowance', 'Amount' => 2500],
            (object)['Allowance_name' => 'Meal Allowance', 'Amount' => 1500]
        ],
        'variable' => []
    ];
    
    $deductions3 = [
        'fixed' => [
            (object)['Deduction_name' => 'Welfare Fund', 'Amount' => 500],
            (object)['Deduction_name' => 'Union Fee', 'Amount' => 800]
        ],
        'variable' => []
    ];
    
    // Generate HTML for employee 3
    $html .= generatePayslipHTML($data_set3, $data_cmp, 5, 2025, $allowances3, $deductions3);
    $html .= '</div>';
    
    // Fourth employee in the second row
    $html .= '<div class="payslip-cell">';
    
    // Simulate data for employee 4
    $data_set4 = [
        (object)[
            'Emp_Full_Name' => 'Sarah Williams',
            'EmpNo' => 'EMP004',
            'Dep_Name' => 'HR',
            'B_name' => 'Branch B',
            'Basic_sal' => 55000,
            'Normal_OT_Pay' => 2000,
            'Incentive' => 4000,
            'Br_pay' => 1100,
            'Gross_pay' => 62100,
            'Salary_advance' => 3000,
            'no_pay_deduction' => 0,
            'Late_deduction' => 300,
            'Ed_deduction' => 500,
            'Payee_amount' => 1200,
            'EPF_Worker_Amount' => 4400,
            'EPF_Employee_Amount' => 6600,
            'ETF_Amount' => 1650,
            'Stamp_duty' => 25,
            'tot_deduction' => 9425,
            'Net_salary' => 52675,
        ]
    ];
    
    // Simulate allowances and deductions for employee 4
    $allowances4 = [
        'fixed' => [
            (object)['Allowance_name' => 'Transport Allowance', 'Amount' => 3000],
            (object)['Allowance_name' => 'Meal Allowance', 'Amount' => 2000]
        ],
        'variable' => []
    ];
    
    $deductions4 = [
        'fixed' => [
            (object)['Deduction_name' => 'Welfare Fund', 'Amount' => 500],
            (object)['Deduction_name' => 'Insurance Premium', 'Amount' => 1500]
        ],
        'variable' => []
    ];
    
    // Generate HTML for employee 4
    $html .= generatePayslipHTML($data_set4, $data_cmp, 5, 2025, $allowances4, $deductions4);
    $html .= '</div>';
    $html .= '</div>'; // End of second row
    
    $html .= '</div>'; // End of grid layout
    
    // Add a footer with page number
    $html .= '
    <div style="text-align: center; font-size: 8pt; margin-top: 10px; border-top: 1px solid #ddd; padding-top: 5px;">
        <p>This is a computer-generated document. No signature is required.</p>
        <p>' . htmlspecialchars($data_cmp[0]->Company_Name) . ' | ' . htmlspecialchars($data_cmp[0]->Company_Address) . '</p>
    </div>';

    // Output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // Clear all buffers
    while (ob_get_level()) {
        ob_end_clean();
    }
    
    // Close and output PDF document
    $pdf->Output('Multiple_Payslips_' . date('F_Y', mktime(0, 0, 0, 5, 1, 2025)) . '.pdf', 'I');

} catch (Exception $e) {
    // Clean all output buffers
    while (ob_get_level()) {
        ob_end_clean();
    }
    
    // Log the error for debugging (in a production environment)
    error_log('PDF Generation Error: ' . $e->getMessage());
    
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
                <h2>Error Generating Payslips</h2>
                <p>We\'re sorry, but there was an error generating the payslips. Please try again later or contact technical support.</p>
                <p>Error reference: ' . time() . '</p>
                <div class="back-btn">
                    <a href="javascript:history.back()">Go Back</a>
                </div>
            </div>
        </body>
        </html>';
    exit;
}