<?php

defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Cell\DataType;


class R1_Form extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!($this->session->userdata('login_user'))) {
            redirect(base_url() . "");
        }

        /*
         * Load Database model
         */
        $this->load->library("pdf_library");
        $this->load->model('Db_model', '', TRUE);
    }

    /*
     * Index page in Departmrnt
     */

    public function index()
    {

        $data['title'] = "Other Report | HRM System";
        $data['data_dep'] = $this->Db_model->getData('Dep_ID,Dep_Name', 'tbl_departments');
        $data['data_desig'] = $this->Db_model->getData('Des_ID,Desig_Name', 'tbl_designations');
        $data['data_cmp'] = $this->Db_model->getData('Cmp_ID,Company_Name', 'tbl_companyprofile');
        $data['data_branch'] = $this->Db_model->getData('B_id,B_name', 'tbl_branches');
        // $data['data_group'] = $this->Db_model->getData('Grp_ID,EmpGroupName', 'tbl_emp_group');
        $data['data_group'] = $this->Db_model->getfilteredData("SELECT * FROM tbl_emp_group WHERE tbl_emp_group.Grp_ID !=1");

        $this->load->view('Reports/Payroll/R1_Form', $data);
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
        $datacmp = $this->Db_model->getData('Cmp_ID,Company_Name,comp_Address,comp_Tel,comp_Email', 'tbl_companyprofile');

        $emp = $this->input->post("txt_emp");
        $emp_name = $this->input->post("txt_emp_name");
        $desig = $this->input->post("cmb_desig");
        $dept = $this->input->post("cmb_dep");
        $year1 = $this->input->post("cmb_year");
        $Month = $this->input->post("cmb_month");
        $group = $this->input->post("cmb_group");
        // if ($Month == 1) {
        //     $half = "tbl_salary.Month BETWEEN '1' AND '6'";
        // } elseif ($Month == 2) {
        //     $half = "tbl_salary.Month BETWEEN '7' AND '12'";
        // }


        // Filter Data by categories
        $filter = '';

        // if (($this->input->post("cmb_year"))) {
        //     if ($filter == null) {
        //         $filter = " where $half and tbl_salary.Year ='$year1'";
        //     } else {
        //         $filter .= " where $half tbl_salary.Month = '$Month' and tbl_salary.Year ='$year1'";
        //     }
        // }
        if (($this->input->post("txt_emp"))) {
            if ($filter == null) {
                $filter = " where tbl_empmaster.EmpNo =$emp";
            } else {
                $filter .= " AND tbl_empmaster.EmpNo =$emp";
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
                $filter = " where tbl_empmaster.Grp_ID  ='$group'";
            } else {
                $filter .= " AND tbl_empmaster.Grp_ID  ='$group'";
            }
        }
        // echo $filter;
        $data_set = $this->Db_model->getfilteredData("SELECT * FROM tbl_empmaster {$filter} ");
        $data_set_count = $this->Db_model->getfilteredData("SELECT COUNT(*) AS employee_count FROM tbl_empmaster");

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        if ($Month == 1) {
            $half_text = "Return for the period January to June " . $year1;
        } elseif ($Month == 2) {
            $half_text = "Return for the period July to December " . $year1;
        }

        foreach (range('A', 'R') as $columID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columID)->setAutoSize(true);
        }
        $sheet->setCellValue('A1', 'EMPLOYEES TRUST FUND BOARD'); // ID
        $sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
        $sheet->setCellValue('A2', $half_text); // Full Name
        $sheet->getStyle('A2')->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells('A1:R1');
        $sheet->mergeCells('A2:R2');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->setCellValue('B3', 'FORM 11 RETURN'); // ID
        $sheet->getStyle('B3')->getFont()->setSize(14)->setBold(true);
        $sheet->getStyle('B3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->setCellValue('M3', 'TOTAL NUMBER OF EMPLOYEES'); // ID
        $sheet->getStyle('M3')->getFont()->setSize(13)->setBold(true);
        $sheet->mergeCells('M3:N3');
        $sheet->getStyle('M3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('M3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->setCellValue('P3', $data_set_count[0]->employee_count);
        $sheet->getStyle('P3')->getFont()->setSize(13)->setBold(true);
        $sheet->getStyle('P3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('P3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        // 5row
        $sheet->setCellValue('A5', '1');
        $sheet->mergeCells('A5:C5');
        $sheet->getStyle('A5')->getFont()->setSize(14)->setBold(true);
        $sheet->getStyle('A5:C5')->applyFromArray(['borders' => ['left' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],'right' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],'top' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]); 
        $sheet->getStyle('A5')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->setCellValue('D5', '2');
        $sheet->getStyle('D5')->getFont()->setSize(14)->setBold(true);
        $sheet->getStyle('D5')->applyFromArray(['borders' => ['left' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],'right' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],'top' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]); 
        $sheet->getStyle('D5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D5')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->setCellValue('E5', '3');
        $sheet->getStyle('E5')->getFont()->setSize(14)->setBold(true);
        $sheet->getStyle('E5')->applyFromArray(['borders' => ['left' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],'right' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],'top' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]); 
        $sheet->getStyle('E5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E5')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->setCellValue('F5', '4');
        $sheet->getStyle('F5')->getFont()->setSize(14)->setBold(true);
        $sheet->getStyle('F5')->applyFromArray(['borders' => ['left' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],'right' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],'top' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]); 
        $sheet->getStyle('F5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F5')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->setCellValue('G5', '5                                      TOTAL GROSS WAGES AND CONTRIBUTION');
        $sheet->mergeCells('G5:R5');
        $sheet->getStyle('G5')->getFont()->setSize(14)->setBold(true);
        $sheet->getStyle('G5:R5')->applyFromArray(['borders' => ['top' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],['left' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],['right' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],]]);
        $sheet->getStyle('G5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G5')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        // 6row
        $sheet->setCellValue('A6', 'NAME OF MEMBER');
        $sheet->mergeCells('A6:C6');
        $sheet->getStyle('A6')->getFont()->setSize(13)->setBold(true);
        $sheet->getStyle('A6:C6')->applyFromArray(['borders' => ['left' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],['right' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],]]);
        $sheet->getStyle('A6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->setCellValue('D6', 'MEMBERS');
        $sheet->getStyle('D6')->getFont()->setSize(13)->setBold(true);
        $sheet->getStyle('D6')->applyFromArray(['borders' => ['left' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],['right' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],]]);
        $sheet->getStyle('D6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->setCellValue('E6', 'NATIONAL');
        $sheet->getStyle('E6')->getFont()->setSize(13)->setBold(true);
        $sheet->getStyle('E6')->applyFromArray(['borders' => ['left' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],['right' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],]]);
        $sheet->getStyle('E6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->setCellValue('F6', 'TOTAL');
        $sheet->getStyle('F6')->getFont()->setSize(13)->setBold(true);
        $sheet->getStyle('F6')->applyFromArray(['borders' => ['left' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],['right' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],]]);
        $sheet->getStyle('F6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        if ($Month == 1) {
            //6row jan
            $sheet->setCellValue('G6', 'JAN');
            $sheet->mergeCells('G6:H6');
            $sheet->getStyle('G6')->getFont()->setSize(13)->setBold(true);
            $sheet->getStyle('G6:H6')->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('G6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('G6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //6row feb
            $sheet->setCellValue('I6', 'FEB');
            $sheet->mergeCells('I6:J6');
            $sheet->getStyle('I6')->getFont()->setSize(13)->setBold(true);
            $sheet->getStyle('I6:J6')->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('I6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('I6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //6row mar
            $sheet->setCellValue('K6', 'MAR');
            $sheet->mergeCells('K6:L6');
            $sheet->getStyle('K6')->getFont()->setSize(13)->setBold(true);
            $sheet->getStyle('K6:L6')->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('K6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('K6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //6row Apr
            $sheet->setCellValue('M6', 'APR');
            $sheet->mergeCells('M6:N6');
            $sheet->getStyle('M6')->getFont()->setSize(13)->setBold(true);
            $sheet->getStyle('M6:N6')->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('M6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('M6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //6row may
            $sheet->setCellValue('O6', 'MAY');
            $sheet->mergeCells('O6:P6');
            $sheet->getStyle('O6')->getFont()->setSize(13)->setBold(true);
            $sheet->getStyle('O6:P6')->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('O6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('O6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //6row jun
            $sheet->setCellValue('Q6', 'JUN');
            $sheet->mergeCells('Q6:R6');
            $sheet->getStyle('Q6')->getFont()->setSize(13)->setBold(true);
            $sheet->getStyle('Q6:R6')->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('Q6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('Q6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        } elseif ($Month == 2) {
            //6row jan
            $sheet->setCellValue('G6', 'JUL');
            $sheet->mergeCells('G6:H6');
            $sheet->getStyle('G6')->getFont()->setSize(13)->setBold(true);
            $sheet->getStyle('G6:H6')->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('G6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('G6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //6row feb
            $sheet->setCellValue('I6', 'AUG');
            $sheet->mergeCells('I6:J6');
            $sheet->getStyle('I6')->getFont()->setSize(13)->setBold(true);
            $sheet->getStyle('I6:J6')->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('I6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('I6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //6row mar
            $sheet->setCellValue('K6', 'SEP');
            $sheet->mergeCells('K6:L6');
            $sheet->getStyle('K6')->getFont()->setSize(13)->setBold(true);
            $sheet->getStyle('K6:L6')->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('K6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('K6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //6row Apr
            $sheet->setCellValue('M6', 'OCT');
            $sheet->mergeCells('M6:N6');
            $sheet->getStyle('M6')->getFont()->setSize(13)->setBold(true);
            $sheet->getStyle('M6:N6')->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('M6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('M6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //6row may
            $sheet->setCellValue('O6', 'NOV');
            $sheet->mergeCells('O6:P6');
            $sheet->getStyle('O6')->getFont()->setSize(13)->setBold(true);
            $sheet->getStyle('O6:P6')->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('O6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('O6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //6row jun
            $sheet->setCellValue('Q6', 'DEC');
            $sheet->mergeCells('Q6:R6');
            $sheet->getStyle('Q6')->getFont()->setSize(13)->setBold(true);
            $sheet->getStyle('Q6:R6')->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('Q6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('Q6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }
        //7row
        $sheet->setCellValue('A7', '(Surname first followed by initials)');
        $sheet->mergeCells('A7:C7');
        $sheet->getStyle('A7')->getFont()->setSize( 11)->setBold(true);
        $sheet->getStyle('A7:C7')->applyFromArray(['borders' => ['left' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],'right' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);        $sheet->getStyle('A5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //
        $sheet->setCellValue('D7', 'NUMBER');
        $sheet->getStyle('D7')->getFont()->setSize(11)->setBold(true);
        $sheet->getStyle('D7')->applyFromArray(['borders' => ['left' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],'right' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);        $sheet->getStyle('A5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //
        $sheet->setCellValue('E7', 'IDENTICARD NUMBER');
        $sheet->getStyle('E7')->getFont()->setSize(11)->setBold(true);
        $sheet->getStyle('E7')->applyFromArray(['borders' => ['left' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],'right' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);        $sheet->getStyle('A5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //
        $sheet->setCellValue('F7', 'CONTIBUTIONS');
        $sheet->getStyle('F7')->getFont()->setSize(11);
        $sheet->getStyle('F7')->applyFromArray(['borders' => ['bottom' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],['left' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],['right' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],]]);
        $sheet->getStyle('F7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //
        $sheet->setCellValue('G7', 'TOTAL EARNINGS');
        $sheet->getStyle('G7')->getFont()->setSize(11)->setBold(true);
        $sheet->getStyle('G7')->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('G7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //
        $sheet->setCellValue('H7', 'CONTRIBUTIONS');
        $sheet->getStyle('H7')->getFont()->setSize(11);
        $sheet->getStyle('H7')->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('H7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //
        $sheet->setCellValue('I7', 'TOTAL EARNINGS');
        $sheet->getStyle('I7')->getFont()->setSize(11)->setBold(true);
        $sheet->getStyle('I7')->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('I7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('I7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //
        $sheet->setCellValue('J7', 'CONTRIBUTIONS');
        $sheet->getStyle('J7')->getFont()->setSize(11);
        $sheet->getStyle('J7')->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('J7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('J7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //
        $sheet->setCellValue('K7', 'TOTAL EARNINGS');
        $sheet->getStyle('K7')->getFont()->setSize(11)->setBold(true);
        $sheet->getStyle('K7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('K7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //
        $sheet->setCellValue('L7', 'CONTRIBUTIONS');
        $sheet->getStyle('L7')->getFont()->setSize(11);
        $sheet->getStyle('L7')->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('L7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('L7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //
        $sheet->setCellValue('M7', 'TOTAL EARNINGS');
        $sheet->getStyle('M7')->getFont()->setSize(11)->setBold(true);
        $sheet->getStyle('M7')->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('M7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('M7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //
        $sheet->setCellValue('N7', 'CONTRIBUTIONS');
        $sheet->getStyle('N7')->getFont()->setSize(11);
        $sheet->getStyle('N7')->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('N7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('N7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //
        $sheet->setCellValue('O7', 'TOTAL EARNINGS');
        $sheet->getStyle('O7')->getFont()->setSize(11)->setBold(true);
        $sheet->getStyle('O7')->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('O7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('O7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //
        $sheet->setCellValue('P7', 'CONTRIBUTIONS');
        $sheet->getStyle('P7')->getFont()->setSize(11);
        $sheet->getStyle('P7')->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('P7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('P7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //
        $sheet->setCellValue('Q7', 'TOTAL EARNINGS');
        $sheet->getStyle('Q7')->getFont()->setSize(11)->setBold(true);
        $sheet->getStyle('Q7')->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('Q7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('Q7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //
        $sheet->setCellValue('R7', 'CONTRIBUTIONS');
        $sheet->getStyle('R7')->getFont()->setSize(11);
        $sheet->getStyle('R7')->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('R7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('R7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $x = 8;
        $total_t_t = 0;
        $total_c_1 = 0;
        $total_c_2 = 0;
        $total_c_3 = 0;
        $total_c_4 = 0;
        $total_c_5 = 0;
        $total_c_6 = 0;
        foreach ($data_set as $row) {
            //a           
            $sheet->setCellValue('A' . $x, $row->Emp_Full_Name);
            $sheet->mergeCells('A' . $x . ':C' . $x);
            $sheet->getStyle('A'.$x)->getFont()->setSize(11);
            $sheet->getStyle('A' . $x . ':C' . $x)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('A'.$x)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A'.$x)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //b 
            $sheet->setCellValue('D' . $x, $row->EmpNo);
            $sheet->getStyle('D'.$x)->getFont()->setSize(11);
            $sheet->getStyle('D'.$x)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('D'.$x)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('D'.$x)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //b 
            $nic_number = strval($row->NIC);
            
            $sheet->setCellValueExplicit('E' . $x, $nic_number, DataType::TYPE_STRING);
            $sheet->getStyle('E'.$x)->getFont()->setSize(11);
            $sheet->getStyle('E'.$x)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('E'.$x)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E'.$x)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //b
            if($Month == 1){
                $text = "tbl_salary.`Month` BETWEEN '1' AND '6' and tbl_salary.Year ='$year1'";
            }else if($Month == 2){
                $text = "tbl_salary.`Month` BETWEEN '7' AND '12' and tbl_salary.Year ='$year1'";
            }
            $total_epf = $this->Db_model->getfilteredData("SELECT SUM(tbl_salary.ETF_Amount) AS total_etf FROM tbl_salary WHERE ($text) AND tbl_salary.EmpNo = '$row->EmpNo'");
            if(!empty($total_epf)){
                $total_epf_amount = $total_epf[0]->total_etf;
                $total_t_t += $total_epf_amount;
            }else{
                $total_epf_amount = 0;
            }
            $sheet->setCellValue('F' . $x, $total_epf_amount);
            $sheet->getStyle('F'.$x)->getFont()->setSize(11);
            $sheet->getStyle('F'.$x)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('F'.$x)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F'.$x)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //G 
            if($Month == 1){
                $mo1 = 1;
            }else if($Month == 2){
                $mo1 = 7;
            }
            $not = $this->Db_model->getfilteredData("SELECT tbl_salary.ETF_Amount,tbl_salary.Total_F_Epf FROM tbl_salary WHERE tbl_salary.EmpNo = '$row->EmpNo' AND tbl_salary.`Month` = '$mo1' and tbl_salary.Year ='$year1'");
            if(!empty($not)){
                $mo1salary = $not[0]->Total_F_Epf;
            }else{
                $mo1salary = 0;
            }
            $sheet->setCellValue('G' . $x, $mo1salary);
            $sheet->getStyle('G'.$x)->getFont()->setSize(11);
            $sheet->getStyle('G'.$x)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('G'.$x)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('G'.$x)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //H 
            if(!empty($not)){
                $mo1amount = $not[0]->ETF_Amount;
                $total_c_1 += $mo1amount;
            }else{
                $mo1amount = 0;
            }
            $sheet->setCellValue('H' . $x, $mo1amount);
            $sheet->getStyle('H'.$x)->getFont()->setSize(11);
            $sheet->getStyle('H'.$x)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('H'.$x)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('H'.$x)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //I 
            if($Month == 1){
                $mo2 = 2;
            }else if($Month == 2){
                $mo2 = 8;
            }
            $not = $this->Db_model->getfilteredData("SELECT tbl_salary.ETF_Amount,tbl_salary.Total_F_Epf FROM tbl_salary WHERE tbl_salary.EmpNo = '$row->EmpNo' AND tbl_salary.`Month` = '$mo2' and tbl_salary.Year ='$year1'");
            if(!empty($not)){
                $mo2salary = $not[0]->Total_F_Epf;
            }else{
                $mo2salary = 0;
            }
            $sheet->setCellValue('I' . $x, $mo2salary);
            $sheet->getStyle('I'.$x)->getFont()->setSize(11);
            $sheet->getStyle('I'.$x)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('I'.$x)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('I'.$x)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //J 
            if(!empty($not)){
                $mo2amount = $not[0]->ETF_Amount;
                $total_c_2 += $mo2amount;
            }else{
                $mo2amount = 0;
            }
            $sheet->setCellValue('J' . $x, $mo2amount);
            $sheet->getStyle('J'.$x)->getFont()->setSize(11);
            $sheet->getStyle('J'.$x)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('J'.$x)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('J'.$x)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //K 
            if($Month == 1){
                $mo3 = 3;
            }else if($Month == 2){
                $mo3 = 9;
            }
            $not = $this->Db_model->getfilteredData("SELECT tbl_salary.ETF_Amount,tbl_salary.Total_F_Epf FROM tbl_salary WHERE tbl_salary.EmpNo = '$row->EmpNo' AND tbl_salary.`Month` = '$mo3' and tbl_salary.Year ='$year1'");
            if(!empty($not)){
                $mo3salary = $not[0]->Total_F_Epf;
            }else{
                $mo3salary = 0;
            }
            $sheet->setCellValue('K' . $x, $mo3salary);
            $sheet->getStyle('K'.$x)->getFont()->setSize(11);
            $sheet->getStyle('K'.$x)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('K'.$x)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('K'.$x)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //L
            if(!empty($not)){
                $mo3amount = $not[0]->ETF_Amount;
                $total_c_3 += $mo3amount;
            }else{
                $mo3amount = 0;
            } 
            $sheet->setCellValue('L' . $x, $mo3amount);
            $sheet->getStyle('L'.$x)->getFont()->setSize(11);
            $sheet->getStyle('L'.$x)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('L'.$x)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('L'.$x)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //M 
            if($Month == 1){
                $mo4 = 4;
            }else if($Month == 2){
                $mo4 = 10;
            }
            $not = $this->Db_model->getfilteredData("SELECT tbl_salary.ETF_Amount,tbl_salary.Total_F_Epf FROM tbl_salary WHERE tbl_salary.EmpNo = '$row->EmpNo' AND tbl_salary.`Month` = '$mo4' and tbl_salary.Year ='$year1'");
            if(!empty($not)){
                $mo4salary = $not[0]->Total_F_Epf;
            }else{
                $mo4salary = 0;
            }
            $sheet->setCellValue('M' . $x, $mo4salary);
            $sheet->getStyle('M'.$x)->getFont()->setSize(11);
            $sheet->getStyle('M'.$x)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('M'.$x)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('M'.$x)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //N 
            if(!empty($not)){
                $mo4amount = $not[0]->ETF_Amount;
                $total_c_4 += $mo4amount;
            }else{
                $mo4amount = 0;
            }
            $sheet->setCellValue('N' . $x, $mo4amount);
            $sheet->getStyle('N'.$x)->getFont()->setSize(11);
            $sheet->getStyle('N'.$x)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('N'.$x)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('N'.$x)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //O 
            if($Month == 1){
                $mo5 = 5;
            }else if($Month == 2){
                $mo5 = 11;
            }
            $not = $this->Db_model->getfilteredData("SELECT tbl_salary.ETF_Amount,tbl_salary.Total_F_Epf FROM tbl_salary WHERE tbl_salary.EmpNo = '$row->EmpNo' AND tbl_salary.`Month` = '$mo5' and tbl_salary.Year ='$year1'");
            if(!empty($not)){
                $mo5salary = $not[0]->Total_F_Epf;
            }else{
                $mo5salary = 0;
            }
            $sheet->setCellValue('O' . $x, $mo5salary);
            $sheet->getStyle('O'.$x)->getFont()->setSize(11);
            $sheet->getStyle('O'.$x)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('O'.$x)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('O'.$x)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //P 
            if(!empty($not)){
                $mo5amount = $not[0]->ETF_Amount;
                $total_c_5 += $mo5amount;
            }else{
                $mo5amount = 0;
            }
            $sheet->setCellValue('P' . $x, $mo5amount);
            $sheet->getStyle('P'.$x)->getFont()->setSize(11);
            $sheet->getStyle('P'.$x)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('P'.$x)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('P'.$x)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //Q 
            if($Month == 1){
                $mo6 = 6;
            }else if($Month == 2){
                $mo6 = 12;
            }
            $not = $this->Db_model->getfilteredData("SELECT tbl_salary.ETF_Amount,tbl_salary.Total_F_Epf FROM tbl_salary WHERE tbl_salary.EmpNo = '$row->EmpNo' AND tbl_salary.`Month` = '$mo6' and tbl_salary.Year ='$year1'");
            if(!empty($not)){
                $mo6salary = $not[0]->Total_F_Epf;
            }else{
                $mo6salary = 0;
            }
            $sheet->setCellValue('Q' . $x, $mo6salary);
            $sheet->getStyle('Q'.$x)->getFont()->setSize(11);
            $sheet->getStyle('Q'.$x)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('Q'.$x)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('Q'.$x)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //R 
            if(!empty($not)){
                $mo6amount = $not[0]->ETF_Amount;
                $total_c_6 += $mo6amount;
            }else{
                $mo6amount = 0;
            }
            $sheet->setCellValue('R' . $x, $mo6amount);
            $sheet->getStyle('R'.$x)->getFont()->setSize(11);
            $sheet->getStyle('R'.$x)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
            $sheet->getStyle('R'.$x)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('R'.$x)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            
            $x++;
        }

        $footerRow = $x;
        //E 
        $sheet->setCellValue('E' . $footerRow, 'PAGE TOTAL');
        $sheet->getStyle('E'.$footerRow)->getFont()->setSize(11)->setBold(true);
        $sheet->getStyle('E'.$footerRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E'.$footerRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        //F 
        $sheet->setCellValue('F' . $footerRow, $total_t_t);
        $sheet->getStyle('F'.$footerRow)->getFont()->setSize(11)->setBold(true);
        $sheet->getStyle('F'.$footerRow)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('F'.$footerRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F'.$footerRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        //G
        $sheet->setCellValue('G' . $footerRow, '-');
        $sheet->getStyle('G'.$footerRow)->getFont()->setSize(11);
        $sheet->getStyle('G'.$footerRow)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('G'.$footerRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G'.$footerRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //H 
        $sheet->setCellValue('H' . $footerRow, $total_c_1);
        $sheet->getStyle('H'.$footerRow)->getFont()->setSize(11)->setBold(true);
        $sheet->getStyle('H'.$footerRow)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('H'.$footerRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H'.$footerRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        //I
        $sheet->setCellValue('I' . $footerRow, '-');
        $sheet->getStyle('I'.$footerRow)->getFont()->setSize(11);
        $sheet->getStyle('I'.$footerRow)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('I'.$footerRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('I'.$footerRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //J
        $sheet->setCellValue('J' . $footerRow, $total_c_2);
        $sheet->getStyle('J'.$footerRow)->getFont()->setSize(11)->setBold(true);
        $sheet->getStyle('J'.$footerRow)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('J'.$footerRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('J'.$footerRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        //K
        $sheet->setCellValue('K' . $footerRow, '-');
        $sheet->getStyle('K'.$footerRow)->getFont()->setSize(11);
        $sheet->getStyle('K'.$footerRow)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('K'.$footerRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('K'.$footerRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //L 
        $sheet->setCellValue('L' . $footerRow, $total_c_3);
        $sheet->getStyle('L'.$footerRow)->getFont()->setSize(11)->setBold(true);
        $sheet->getStyle('L'.$footerRow)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('L'.$footerRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('L'.$footerRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        //M
        $sheet->setCellValue('M' . $footerRow, '-');
        $sheet->getStyle('M'.$footerRow)->getFont()->setSize(11);
        $sheet->getStyle('M'.$footerRow)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('M'.$footerRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('M'.$footerRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //N 
        $sheet->setCellValue('N' . $footerRow, $total_c_4);
        $sheet->getStyle('N'.$footerRow)->getFont()->setSize(11)->setBold(true);
        $sheet->getStyle('N'.$footerRow)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('N'.$footerRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('N'.$footerRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        //O
        $sheet->setCellValue('O' . $footerRow, '-');
        $sheet->getStyle('O'.$footerRow)->getFont()->setSize(11);
        $sheet->getStyle('O'.$footerRow)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('O'.$footerRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('O'.$footerRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //P 
        $sheet->setCellValue('P' . $footerRow, $total_c_5);
        $sheet->getStyle('P'.$footerRow)->getFont()->setSize(11)->setBold(true);
        $sheet->getStyle('P'.$footerRow)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('P'.$footerRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('P'.$footerRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        //Q
        $sheet->setCellValue('Q' . $footerRow, '-');
        $sheet->getStyle('Q'.$footerRow)->getFont()->setSize(11);
        $sheet->getStyle('Q'.$footerRow)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('Q'.$footerRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('Q'.$footerRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        //R
        $sheet->setCellValue('R' . $footerRow, $total_c_6);
        $sheet->getStyle('R'.$footerRow)->getFont()->setSize(11)->setBold(true);
        $sheet->getStyle('R'.$footerRow)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN,'color' => ['argb' => Color::COLOR_BLACK],],],]);
        $sheet->getStyle('R'.$footerRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('R'.$footerRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $footer1 = $footerRow + 2;
        //A
        $sheet->setCellValue('A' . $footer1, 'EMPLOYERS  REGISTRATION NO.          :-');
        $sheet->mergeCells('A'.$footer1.':C'.$footer1);
        $sheet->getStyle('A'.$footer1)->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A'.$footer1)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$footer1)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $footer2 = $footer1 + 2;
        //A
        $sheet->setCellValue('A' . $footer2, 'NAME & ADDRESS OF EMPLOYER         :-');
        $sheet->mergeCells('A'.$footer2.':C'.$footer2);
        $sheet->getStyle('A'.$footer2)->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A'.$footer2)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$footer2)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $footer3 = $footer2 + 1;
        //K
        $sheet->setCellValue('K' . $footer3, 'I certify that all the particulars given above are correct and that no part of the contributions');
        $sheet->mergeCells('K'.$footer3.':P'.$footer3);
        $sheet->getStyle('K'.$footer3)->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('K'.$footer3)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('K'.$footer3)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $footer4 = $footer3 + 1;
        //A
        $sheet->setCellValue('A' . $footer4, 'TELEPHONE NO.  :-');
        $sheet->mergeCells('A'.$footer4.':C'.$footer4);
        $sheet->getStyle('A'.$footer4)->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A'.$footer4)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$footer4)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //K
        $sheet->setCellValue('K' . $footer4, 'that should be paid by us has been deducted from any employee s earnings');
        $sheet->mergeCells('K'.$footer4.':P'.$footer4);
        $sheet->getStyle('K'.$footer4)->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('K'.$footer4)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('K'.$footer4)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $footer5 = $footer4 + 3;
        //A
        $sheet->setCellValue('A' . $footer5, 'FAX NO.');
        $sheet->mergeCells('A'.$footer5.':C'.$footer5);
        $sheet->getStyle('A'.$footer5)->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A'.$footer5)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$footer5)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //F
        $sheet->setCellValue('F' . $footer5, '………………………');
        $sheet->getStyle('F'.$footer5)->getFont()->setSize(11)->setBold(true);
        $sheet->getStyle('F'.$footer5)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F'.$footer5)->getAlignment()->setVertical(Alignment::VERTICAL_BOTTOM);
        //L
        $sheet->setCellValue('L' . $footer5, '………………………………………………………………');
        $sheet->mergeCells('L'.$footer5.':N'.$footer5);
        $sheet->getStyle('L'.$footer5)->getFont()->setSize(11)->setBold(true);
        $sheet->getStyle('L'.$footer5)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('L'.$footer5)->getAlignment()->setVertical(Alignment::VERTICAL_BOTTOM);

        $footer6 = $footer5 + 1;
        //F
        $sheet->setCellValue('F' . $footer6, 'Date');
        $sheet->getStyle('F'.$footer6)->getFont()->setSize(11)->setBold(true);
        $sheet->getStyle('F'.$footer6)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F'.$footer6)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //L
        $sheet->setCellValue('L' . $footer6, 'Signature of Employer and Rubber Stamp');
        $sheet->mergeCells('L'.$footer6.':N'.$footer6);
        $sheet->getStyle('L'.$footer6)->getFont()->setSize(11)->setBold(true);
        $sheet->getStyle('L'.$footer6)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('L'.$footer6)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        

        // Set headers for file download
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="R1_Form.xlsx"');
        header('Cache-Control: max-age=0');

        
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
