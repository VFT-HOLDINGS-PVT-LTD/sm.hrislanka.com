<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_Form extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (! ($this->session->userdata('login_user'))) {
            redirect(base_url() . "");
        }

        /*
         * Load Database model
         */
        $this->load->library("pdf_library");
        $this->load->model('Db_model', '', true);
    }

    /*
     * Index page in Departmrnt
     */

    public function index()
    {

        $data['title']       = "Other Report | HRM System";
        $data['data_dep']    = $this->Db_model->getData('Dep_ID,Dep_Name', 'tbl_departments');
        $data['data_desig']  = $this->Db_model->getData('Des_ID,Desig_Name', 'tbl_designations');
        $data['data_cmp']    = $this->Db_model->getData('Cmp_ID,Company_Name', 'tbl_companyprofile');
        $data['data_branch'] = $this->Db_model->getData('B_id,B_name', 'tbl_branches');
        // $data['data_group'] = $this->Db_model->getData('Grp_ID,EmpGroupName', 'tbl_emp_group');
        $data['data_group'] = $this->Db_model->getfilteredData("SELECT * FROM tbl_emp_group");

        $this->load->view('Reports/Payroll/C_Form', $data);
    }

    /*
     * Insert Departmrnt
     */

    public function Report_department()
    {
        $Data['data_cmp'] = $this->Db_model->getData('Cmp_ID,Company_Name', 'tbl_companyprofile');
        $Data['data_set'] = $this->Db_model->getfilteredData("SELECT
                                                                    COUNT(EmpNo) AS EmpCount, tbl_departments.Dep_ID, tbl_departments.Dep_Name
                                                                FROM
                                                                    tbl_empmaster
                                                                        INNER JOIN
                                                                    tbl_departments ON tbl_empmaster.Dep_ID = tbl_departments.Dep_ID
                                                                GROUP BY tbl_departments.Dep_ID");

        $this->load->view('Reports/Master/rpt_Departments', $Data);
    }

    public function generateReport()
    {
        $datagrp = "";
        if (! empty($this->input->post("cmb_group"))) {
            $datagrp = $this->Db_model->getfilteredData("SELECT tbl_emp_group.EmpGroupName FROM tbl_emp_group WHERE tbl_emp_group.Grp_ID = '" . $this->input->post("cmb_group") . "'");
        }
        $datacmp = $this->Db_model->getData('Cmp_ID,Company_Name,comp_Address,comp_Tel,comp_Email', 'tbl_companyprofile');

        $emp      = $this->input->post("txt_emp");
        $emp_name = $this->input->post("txt_emp_name");
        $desig    = $this->input->post("cmb_desig");
        $dept     = $this->input->post("cmb_dep");
        $group    = $this->input->post("cmb_group");
        $year1    = $this->input->post("cmb_year");
        $Month    = $this->input->post("cmb_month");

        // Filter Data by categories
        $filter = '';

        if (! empty($this->input->post("cmb_year"))) {
            if (! empty($this->input->post("cmb_month")) && ($this->input->post("cmb_month") == '13' || $this->input->post("cmb_month") == '14')) {
                if ($this->input->post("cmb_month") == '13') {
                    $filter = " where tbl_salary.Month BETWEEN 1 and 6 and tbl_salary.Year ='$year1' and tbl_empmaster.Status = '1' AND tbl_empmaster.EmpNo != '9000' ";
                } else if ($this->input->post("cmb_month") == '14') {
                    $filter = " where tbl_salary.Month BETWEEN 7 and 12 and tbl_salary.Year ='$year1' and tbl_empmaster.Status = '1' AND tbl_empmaster.EmpNo != '9000' ";
                }
            } else {
                if (empty($this->input->post("cmb_month")) && ! empty($this->input->post("cmb_year"))) {
                    $filter = " where tbl_salary.Year ='$year1' and tbl_empmaster.Status = '1' AND tbl_empmaster.EmpNo != '9000' ";
                } else if ($this->input->post("cmb_month") != '13' && $this->input->post("cmb_month") != '14') {
                    $filter = " where tbl_salary.Month = '$Month' and tbl_salary.Year ='$year1' and tbl_empmaster.Status = '1' AND tbl_empmaster.EmpNo != '9000' ";
                }
            }
        }
        if (($this->input->post("txt_emp"))) {
            if ($filter == null) {
                $filter = " where tbl_salary.EmpNo =$emp";
            } else {
                $filter .= " AND tbl_salary.EmpNo =$emp";
            }
        }

        if (($this->input->post("txt_emp_name"))) {
            if ($filter == null) {
                $filter = " where tbl_empmaster.Emp_Full_Name ='$emp_name'";
            } else {
                $filter .= " AND tbl_empmaster.Emp_Full_Name ='$emp_name'";
            }
        }
        if (($this->input->post("cmb_desig"))) {
            if ($filter == null) {
                $filter = " where dsg.Des_ID  ='$desig'";
            } else {
                $filter .= " AND dsg.Des_ID  ='$desig'";
            }
        }
        if (($this->input->post("cmb_dep"))) {
            if ($filter == null) {
                $filter = " where tbl_departments.Dep_id  ='$dept'";
            } else {
                $filter .= " AND tbl_departments.Dep_id  ='$dept'";
            }
        }
        if (($this->input->post("cmb_group"))) {
            if ($filter == null) {
                $filter = " where tbl_emp_group.Grp_ID  ='$group'";
            } else {
                $filter .= " AND tbl_emp_group.Grp_ID  ='$group'";
            }
        }

        $data_set = $this->Db_model->getfilteredData("SELECT
                                                                    tbl_salary.id,
                                                                    tbl_salary.EmpNo,
                                                                    tbl_empmaster.Emp_Full_Name,
                                                                    tbl_empmaster.EPFNO,
                                                                    tbl_emp_group.EmpGroupName,
                                                                    tbl_empmaster.Status,
                                                                    tbl_empmaster.NIC,
                                                                    tbl_salary.EPF_Worker_Rate,
                                                                    tbl_salary.EPF_Employee_Rate,
                                                                    tbl_salary.ETF_Rate,
                                                                    tbl_salary.ETF_Amount,
                                                                    SUM(tbl_salary.Total_F_Epf) AS Total_F_Epf,
                                                                    SUM(tbl_salary.EPF_Worker_Amount) AS EPF_Worker_Amount,
                                                                    SUM(tbl_salary.EPF_Employee_Amount) AS EPF_Employee_Amount
                                                                FROM
                                                                    tbl_salary
                                                                    inner join
                                                                    tbl_empmaster on tbl_empmaster.EmpNo = tbl_salary.EmpNo
                                                                    inner join
                                                                    tbl_branches on tbl_branches.B_id = tbl_empmaster.B_id
                                                                    inner join
                                                                    tbl_emp_group on tbl_empmaster.Grp_ID = tbl_emp_group.Grp_ID

                                                                  {$filter}  GROUP BY
                                                                    tbl_salary.EmpNo, tbl_empmaster.Emp_Full_Name, tbl_empmaster.EPFNO,
                                                                    tbl_emp_group.EmpGroupName, tbl_empmaster.Status, tbl_empmaster.NIC ORDER BY tbl_empmaster.EmpNo ASC", $filter);

        function formatCurrency($amount)
        {
            // Format the number to always have two decimal places
            $formattedAmount = number_format($amount, 2, '.', '');

            // Split the number into two parts (before and after the decimal)
            $parts = explode('.', $formattedAmount);

                                      // Assign the integer and decimal parts
            $integerPart = $parts[0]; // before the decimal
            $decimalPart = $parts[1]; // after the decimal

            return [$integerPart, $decimalPart];
        }
        // Load the FPDI and FPDF libraries
        require_once APPPATH . 'third_party/fpdf/fpdf.php';
        require_once APPPATH . 'third_party/fpdi/src/autoload.php';

        // Create a new FPDI object
        $pdf = new \setasign\Fpdi\Fpdi();

                                      // Set margins (left, top, right)
        $pdf->SetMargins(10, 10, 10); // 10 units for left, top, and right margins

        // Function to generate header for every page
        function addHeader($pdf, $datacmp, $datagrp)
        {

            $headerImage = base_url('assets/templates/super4.jpg'); // Adjust the header image path
            $pdf->Image($headerImage, 10, 10, 190, 100);            // Adjust x, y, width, height for header
            $pdf->Ln(40);                                           // Leave space after the header
                                                                    // Set font size and style for the company name
            $pdf->SetFont('Helvetica', 'B', 10);                    // Set font to 'Helvetica', bold, size 16
            $pdf->Text(15, 35, $datacmp[0]->Company_Name);          // X=10, Y=40, text

                                               // Set a different font size for the address
            $pdf->SetFont('Helvetica', '', 8); // Set font to 'Helvetica', regular, size 10
            $pdf->Text(15, 43, ' ');           // X=10, Y=46

                                                                         // Set font size for contact info
            $pdf->SetFont('Helvetica', '', 9);                           // Same font as before, regular, size 10
            $pdf->Text(15, 52, 'Phone :' . ' ' . $datacmp[0]->comp_Tel); // X=10, Y=52
                                                                         // Set font size for contact info
            $pdf->SetFont('Helvetica', '', 9);                           // Same font as before, regular, size 10
            $pdf->Text(15, 57, 'E-Mail :' . ' ' . $datacmp[0]->comp_Email);

            $pdf->SetFont('Helvetica', '', 7);
        }

        // Function to generate footer for every page
        function addFooter($pdf, $pluspart1, $plusemployee1, $plusworker1)
        {

            $footerImage = base_url('assets/templates/super_footer4.jpg'); // Adjust the footer image path
            $pdf->SetY(-37);                                               // Position footer 30 units from the bottom
            $pdf->Image($footerImage, 10.18, $pdf->GetY(), 189.5, 33);     // Adjust x, y, width, height for footer

            list($pluslast1, $pluslast2) = formatCurrency($pluspart1);
            $pdf->SetFont('Helvetica', '', 10); // Same font as before, regular, size 10
            $pdf->Text(117, 265, $pluslast1);
            $pdf->SetFont('Helvetica', '', 10); // Same font as before, regular, size 10
            $pdf->Text(135, 265, $pluslast2);
            list($employelast1, $employelast2) = formatCurrency($plusemployee1);
            $pdf->SetFont('Helvetica', '', 10); // Same font as before, regular, size 10
            $pdf->Text(142, 265, $employelast1);
            $pdf->SetFont('Helvetica', '', 10); // Same font as before, regular, size 10
            $pdf->Text(156.6, 265, $employelast2);
            list($workerlast1, $workerlast2) = formatCurrency($plusworker1);
            $pdf->SetFont('Helvetica', '', 10); // Same font as before, regular, size 10
            $pdf->Text(162.6, 265, $workerlast1);
            $pdf->SetFont('Helvetica', '', 10); // Same font as before, regular, size 10
            $pdf->Text(176, 265, $workerlast2);
        }

        // Add a page and generate the header
        $pdf->AddPage();
        addHeader($pdf, $datacmp, $datagrp);
        //databse search

                                              // --- TABLE GENERATION ---
        $pdf->SetFont('Helvetica', '', 7);    // Regular font for the content
        $employeesPerPage = 30;               // Number of employees per page
        $totalEmployees   = count($data_set); // Example number, replace with actual data
        $rowHeight        = 5;                // Height of each row

                               // Initial Y position
        $initialY = 110;       // Adjust this based on your header size and desired spacing
        $pdf->SetY($initialY); // Start the table at the initial Y position

        // Calculate total pages
        $totalPages = ceil($totalEmployees / $employeesPerPage);
        // echo $data_set[0]->Emp_Full_Name;
        $i             = 0;
        $pluspart1     = 0;
        $plusemployee1 = 0;
        $plusworker1   = 0;
        foreach ($data_set as $data) {
            $i += 1;
            $pdf->SetX(12.6); // Ensure each row respects the left margin
            $pdf->Cell(66.3, $rowHeight, $data->Emp_Full_Name, 1);
            $pdf->Cell(25.3, $rowHeight, $data->NIC, 1);
            $pdf->Cell(14.8, $rowHeight, $data->EmpNo, 1);
            list($plus1, $plus2) = formatCurrency(($data->EPF_Employee_Amount + $data->EPF_Worker_Amount));
            $pluspart1 += ($data->EPF_Employee_Amount + $data->EPF_Worker_Amount);
            $pdf->Cell(15.2, $rowHeight, $plus1, 1);
            $pdf->Cell(7.4, $rowHeight, $plus2, 1);
            list($employe1, $employe2) = formatCurrency($data->EPF_Employee_Amount);
            $plusemployee1 += $data->EPF_Employee_Amount;
            $pdf->Cell(14.1, $rowHeight, $employe1, 1);
            $pdf->Cell(6.1, $rowHeight, $employe2, 1);
            list($workerp1, $workerp2) = formatCurrency($data->EPF_Worker_Amount);
            $plusworker1 += $data->EPF_Worker_Amount;
            $pdf->Cell(13.9, $rowHeight, $workerp1, 1);
            $pdf->Cell(4.1, $rowHeight, $workerp2, 1);
            $pdf->Cell(14.4, $rowHeight, number_format($data->Total_F_Epf, 2, '.', ','), 1);
            $pdf->Ln(); // Move to the next line after each row

            // Check if we've printed 28 employees on the current page
            if ($i % $employeesPerPage == 0 && $i != $totalEmployees) {

                // Add footer for the current page
                addFooter($pdf, $pluspart1, $plusemployee1, $plusworker1);
                $pluspart1     = 0;
                $plusemployee1 = 0;
                $plusworker1   = 0;

                // Start a new page for the next batch of employees
                $pdf->AddPage();
                addHeader($pdf, $datacmp, $datagrp); // Add the header on the new page

                                       // Reset table Y position on the new page
                $pdf->SetY($initialY); // Adjust this value to start the table lower
            }
        }

        // Add empty rows if necessary on the last page
        $remainingRows = $employeesPerPage - ($totalEmployees % $employeesPerPage);

        if ($remainingRows < $employeesPerPage && $remainingRows > 0) {

            for ($i = 1; $i <= $remainingRows; $i++) {
                                                     // $pdf->SetFont('Helvetica', '', 8);
                                                     // $pdf->SetFont('Helvetica', '', 6);
                $pdf->SetX(12.6);                    // Ensure each row respects the left margin
                $pdf->Cell(66.3, $rowHeight, '', 1); // Empty cell
                $pdf->Cell(25.3, $rowHeight, '', 1); // Empty cell
                $pdf->Cell(14.8, $rowHeight, '', 1); // Empty cell
                $pdf->Cell(15.2, $rowHeight, '', 1); // Empty cell
                $pdf->Cell(7.4, $rowHeight, '', 1);  // Empty cell
                $pdf->Cell(14.1, $rowHeight, '', 1); // Empty cell
                $pdf->Cell(6.1, $rowHeight, '', 1);  // Empty cell
                $pdf->Cell(13.9, $rowHeight, '', 1); // Empty cell
                $pdf->Cell(4.1, $rowHeight, '', 1);  // Empty cell
                $pdf->Cell(14.4, $rowHeight, '', 1); // Empty cell
                $pdf->Ln();                          // Move to the next line after each row
            }
        }

        // Add the footer on the last page
        addFooter($pdf, $pluspart1, $plusemployee1, $plusworker1);

        // Output the PDF (I for inline view in the browser, D for download)
        $pdf->Output('example_with_header_footer_table.pdf', 'I');
    }
}
