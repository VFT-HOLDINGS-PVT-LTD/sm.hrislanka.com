<?php
$currentUser = $this->session->userdata('login_user');

//$Image = $currentUser[0]->Image;
$Image = ' <?php echo base_url(); ?>assets/images/Employees/Add_User.png ?>';


$User_Name = $currentUser[0]->Emp_Full_Name;
?>

<div class="static-sidebar-wrapper sidebar-midnightblue">
    <div class="static-sidebar">
        <div class="sidebar">
            <div class="widget stay-on-collapse" id="widget-welcomebox" style="">
                <div class="widget-body welcome-box tabular">
                    <div class="tabular-row">
                        <div class="tabular-cell welcome-avatar">
                            <a href="#"><img src="<?php echo base_url(); ?>assets/images/Employees/Add_User.png" class="avatar"></a>
                        </div>
                        <div class="tabular-cell welcome-options">
                            <span class="welcome-text">Welcome</span>
                            <a href="#" class="name"><?php echo $User_Name; ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget stay-on-collapse" id="widget-sidebar">
                <nav role="navigation" class="widget-body">
                    <ul class="acc-menu">
                        <li class="nav-separator">SYSTEM</li>
                        <?php if ($currentUser[0]->Dashboard == 1): ?>
                            <li><a href="<?php echo base_url(); ?>Dashboard/"><i class="fa fa-home"></i><span>DASHBOARD</span></a></li>
                        <?php endif; ?>

                        <?php if ($currentUser[0]->master_data == 1): ?>
                            <li><a href="javascript:;"><i class="fa fa-columns"></i><span>MASTER DATA</span><span class="badge badge-primary"></span></a>
                            <?php endif; ?> 

                            <?php if ($currentUser[0]->master_data == 1): ?>
                                <ul class="acc-menu">
                                <?php endif; ?>

                                <?php if ($currentUser[0]->designation == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Master/Designation/">DESIGNATION</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->department == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Master/Department/">DEPARTMENT</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->holiday_types == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Master/Holiday_Types/">HOLIDAY TYPES</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->holidays == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Master/Holidays/">HOLIDAYS</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->shifts == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Master/Shifts/">SHIFTS</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->weekly_roster == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Master/Weekly_Roster/">WEEKLY ROSTER PATTERN</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->user_level == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Master/User_Levels/">USER LEVELS</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->leave_types == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Master/OT_Pattern/">OT PATTERN</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->leave_types == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Master/Leave_Types/">LEAVE TYPES</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->banks == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Master/Banks/">BANKS</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->bank_accounts == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Master/Bank_Accounts/">BANK ACCOUNTS</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->payees == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Master/Payee/">PAYEES</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->loan_types == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Master/Loan_Types/">LOAN TYPES</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->allowance_types == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Master/Allowance_Types/">ALLOWANCE TYPES</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->deduction_types == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Master/Deduction_Types/">DEDUCTION TYPES</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->branches == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Master/Branch/">BRANCHES</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->employee_groups == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Master/Employee_Groups/">EMPLOYEE GROUPS</a></li>
                                <?php endif; ?>


                                <?php if ($currentUser[0]->master_data == 1): ?>
                                </ul>
                            <?php endif; ?>

                        </li>


                        <?php if ($currentUser[0]->Employee_mgt == 1): ?>
                            <li><a href="javascript:;"><i class="fa fa-group"></i><span>EMPLOYEE MANAGEMENT</span></a>
                            <?php endif; ?>

                            <?php if ($currentUser[0]->Employee_mgt == 1): ?>  
                                <ul class="acc-menu">
                                <?php endif; ?>

                                <?php if ($currentUser[0]->add_employee == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Employee_Management/ADD_Employees">ADD EMPLOYEE</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->add_employee_branch == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Employee_Management/ADD_Employees_Branch">ADD EMPLOYEE</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->view_employee == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Employee_Management/View_Employees">VIEW EMPLOYEE</a></li>
                                <?php endif; ?>


                                <?php if ($currentUser[0]->Employee_mgt == 1): ?>  
                                </ul>
                            <?php endif; ?>
                        </li>

                        <?php if ($currentUser[0]->Attendance == 1): ?>
                            <li><a href="javascript:;"><i class="fa fa-clock-o"></i><span>ATTENDANCE</span></a>
                            <?php endif; ?>

                            <ul class="acc-menu">
                                <?php if ($currentUser[0]->shift_allocation == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Attendance/Shift_Allocation">SHIFT ALLOCATION</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->attendance_collection == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Attendance/Attendance_Collection">ATTENDANCE COLLECTION</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->attendance_row_data == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Attendance/Attendance_Row_Data">ATTENDANCE ROW DATA</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->manual_attendance == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Attendance/Attendance_Manual_Entry">MANUAL ATTENDANCE ENTRY</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->manual_attendance == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Attendance/Attendance_Manual_Entry_SAPP">MANUAL ATTENDANCE SUP</a></li>
                                <?php endif; ?>    

                                <?php if ($currentUser[0]->manual_attendance == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Attendance/Attendance_Manual_Entry_ADMIN">MANUAL ATTENDANCE ADMIN</a></li>
                                <?php endif; ?>    

                                <?php if ($currentUser[0]->attendance_process == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Attendance/Attendance_Process_New">ATTENDANCE PROCESS</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->attendance_process == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Attendance/Attendance_Initialize">ATTENDANCE INITIALIZE</a></li>
                                <?php endif; ?>

                            </ul>
                        </li>

                        <?php if ($currentUser[0]->Leave_Transaction == 1): ?>
                            <li><a href="javascript:;"><i class="fa fa-cogs"></i><span>LEAVE TRANSACTION</span></a>
                            <?php endif; ?>    
                            <ul class="acc-menu">
                                <?php if ($currentUser[0]->leave_allocation == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Leave_Transaction/Leave_Allocation">LEAVE ALLOCATION</a></li>
                                <?php endif; ?>

                                <!--<li><a href="ui-progress.html">INDIVIDUAL LEAVE ALLOCATION</a></li>-->
                                <?php if ($currentUser[0]->leave_approve == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Leave_Transaction/Leave_Approve">LEAVE APPROVE</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->leave_approve == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Leave_Transaction/Leave_Approve_Sup">LEAVE APPROVE SUP</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->leave_entry == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Leave_Transaction/Leave_Entry">LEAVE ENTRY</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->leave_request == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Leave_Transaction/Leave_Request">LEAVE REQUEST</a></li>
                                <?php endif; ?>



                                <?php if ($currentUser[0]->employee_groups == 1): ?>
                                    <!--<li><a href="ui-labelsbadges.html">SHORT LEAVE ENTRY</a></li>-->
                                <?php endif; ?>

                                <?php if ($currentUser[0]->employee_groups == 1): ?>
                                    <!--<li><a href="ui-breadcrumbs.html">LEAVE DELETE</a></li>-->
                                <?php endif; ?>

                                <?php if ($currentUser[0]->employee_groups == 1): ?>
                                    <!--<li><a href="ui-alerts.html">SHORT LEAVE DELETE</a></li>-->
                                <?php endif; ?>

                            </ul>
                        </li>

                        <?php if ($currentUser[0]->Payroll == 1): ?>
                            <!--<li><a href="javascript:;"><i class="fa fa-calculator"></i><span>PAYROLL</span></a>-->
                            <?php endif; ?>
                            <!--<ul class="acc-menu">-->

                                <?php if ($currentUser[0]->allowance == 1): ?>
                                    <!--<li><a href="<?php echo base_url(); ?>Pay/Allowance">ALLOWANCE</a></li>-->
                                <?php endif; ?>

                                <?php if ($currentUser[0]->deduction == 1): ?>
                                    <!--<li><a href="<?php echo base_url(); ?>Pay/Deduction">DEDUCTIONS</a></li>-->
                                <?php endif; ?>

                                <?php if ($currentUser[0]->loan_entry == 1): ?>
                                    <!--<li><a href="<?php echo base_url(); ?>Pay/Loan_Entry">LOAN ENTRY</a></li>-->
                                <?php endif; ?>

                                <?php if ($currentUser[0]->salary_increment == 1): ?>
                                    <!--<li><a href="ui-paginations.html">SALARY INCREMENT</a></li>-->
                                <?php endif; ?>

                                <?php if ($currentUser[0]->salary_advance == 1): ?>
                                    <!--<li><a href="<?php echo base_url(); ?>Pay/Salary_Advance">SALARY ADVANCE</a></li>-->
                                <?php endif; ?>

                                <?php if ($currentUser[0]->request_advance == 1): ?>
                                    <!--<li><a href="<?php echo base_url(); ?>Pay/Salary_Advance_req">REQUEST SALARY ADVANCE</a></li>-->
                                <?php endif; ?>

                                <?php if ($currentUser[0]->approve_advance == 1): ?>
                                                <!--<li><a href="<?php echo base_url(); ?>Payroll/Req_Salary_Advance/">APPROVE SALARY ADVANCE</a></li>-->
                                <?php endif; ?>

                                <?php if ($currentUser[0]->payroll_process == 1): ?>
                                    <!--<li><a href="<?php echo base_url(); ?>Pay/Payroll_Process">PAYROLL PROCESS</a></li>-->
                                <?php endif; ?>
                            <!--</ul>-->
                        <!--</li>-->

                        <?php if ($currentUser[0]->Cheque == 1): ?>
                            <li><a href="javascript:;"><i class="fa fa-money"></i><span>CHEQUE</span></a>
                            <?php endif; ?>
                            <ul class="acc-menu">
                                <?php if ($currentUser[0]->write_cheque == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Cheque/Write_Cheque/">WRITE CHEQUE</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->view_cheque == 1): ?>
                                                <!--<li><a href="<?php echo base_url(); ?>Cheque/View_Cheque/">VIEW CHEQUE</a></li>-->
                                <?php endif; ?>
                            </ul>
                        </li>

                        <?php if ($currentUser[0]->Messages == 1): ?>
                            <li><a href="javascript:;"><i class="fa fa-envelope"></i><span>MESSAGES</span></a>
                            <?php endif; ?>
                            <ul class="acc-menu">
                                <?php if ($currentUser[0]->send_message == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Message/Send_Message">SEND MESSAGE</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->view_message == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Message/Receive_Message">RECEIVE MESSAGE</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>


                        <?php if ($currentUser[0]->company == 1): ?>
                            <li><a href="javascript:;"><i class="fa fa-building-o"></i><span>COMPANY PROFILE</span></a>
                            <?php endif; ?>

                            <ul class="acc-menu">
                                <?php if ($currentUser[0]->company_profile == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Company_Profile/Company_Profile">COMPANY PROFILE</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>

                        <?php if ($currentUser[0]->Reports == 1): ?>
                            <li class="nav-separator">REPORTS</li>
                        <?php endif; ?>

                        <?php if ($currentUser[0]->Master_Reports == 1): ?>
                            <li><a href="javascript:;"><i class="fa fa-random"></i><span>MASTER REPORTS</span></a>
                            <?php endif; ?>

                            <?php if ($currentUser[0]->Reports == 1): ?>
                                <ul class="acc-menu">
                                <?php endif; ?>

                                <?php if ($currentUser[0]->employee_report == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Reports/Master/Employee_Report/">EMPLOYEES</a></li>
                                <?php endif; ?>


                                <?php if ($currentUser[0]->designation_report == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Reports/Master/Designation_Report/Report_designation">DESIGNATION</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->department_report == 1): ?>
                                    <li><a formtarget="_new" href="<?php echo base_url(); ?>Reports/Master/Departments_Report/Report_department">DEPARTMENT</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->holidays_report == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Reports/Master/Holidays_Report/Report_holidays">HOLIDAYS</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->employee_birthdays == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Reports/Master/Employee_birthdays/Report_DOB">EMPLOYEE BIRTHDAYS</a></li>
                                <?php endif; ?>
                                <!--<li><a href="custom-notific8.html">ROSTER PATTERN</a></li>-->
                                <?php if ($currentUser[0]->Reports == 1): ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                        <?php if ($currentUser[0]->Attendance_Report == 1): ?>
                            <li><a href="javascript:;"><i class="fa fa-pencil"></i><span>ATTENDANCE REPORTS</span></a>
                            <?php endif; ?>

                            <?php if ($currentUser[0]->Attendance_Report == 1): ?>
                                <ul class="acc-menu">
                                <?php endif; ?>    

                                <?php if ($currentUser[0]->in_out_report == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Reports/Attendance/Report_Attendance_In_Out">IN OUT REPORTS</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->overtime_report == 1): ?>
                                    <li><a href="form-pickers.html">OVER TIME REPORTS</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->absence_report == 1): ?>
                                    <li><a href="form-wizard.html">ABSENCE REPORT</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->leave_report == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Reports/Attendance/Report_Leave">LEAVE REPORT</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->late_report == 1): ?>
                                    <li><a href="form-masks.html">LATE REPORT</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->monthly_summery_report == 1): ?>
                                    <li><a href="form-dropzone.html">MONTHLY SUMMERY</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->leave_summery_report == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Reports/Attendance/Report_Leave_summery">LEAVE SUMMERY</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->ot_summery_report == 1): ?>
                                    <li><a href="form-summernote.html">OT SUMMERY</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->Attendance_Report == 1): ?>    
                                </ul>
                            <?php endif; ?>
                        </li>

                        <?php if ($currentUser[0]->Payroll_reports == 1): ?>
                            <li><a href="javascript:;"><i class="fa fa-table"></i><span>PAYROLL REPORTS</span></a>
                            <?php endif; ?>

                            <?php if ($currentUser[0]->Payroll_reports == 1): ?>    
                                <ul class="acc-menu">
                                <?php endif; ?>

                                <?php if ($currentUser[0]->allowance_report == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Reports/Payroll/Allowance_Report">ALLOWANCES</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->deduction_report == 1): ?>
                                    <li><a href="tables-editable.html">DEDUCTIONS</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->salary_advance_report == 1): ?>
                                    <li><a href="tables-data.html">SALARY ADVANCE</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->paysheet_report == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Reports/Payroll/Paysheet">PAYSHEET</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->payslip_report == 1): ?>
                                    <li><a href="<?php echo base_url(); ?>Reports/Payroll/Pay_slip">PAY SLIP</a></li>
                                <?php endif; ?>

                                <?php if ($currentUser[0]->Payroll_reports == 1): ?>          
                                </ul>
                            <?php endif; ?>    
                        </li>

                        <?php if ($currentUser[0]->Analysis_Report == 1): ?>
                                        <!--<li><a href="javascript:;"><i class="fa fa-bar-chart-o"></i><span>ANALYSIS REPORTS</span></a>-->
                        <?php endif; ?>

                        <?php if ($currentUser[0]->Analysis_Report == 1): ?>    
                            <!--<ul class="acc-menu">-->
                        <?php endif; ?>

                        <?php if ($currentUser[0]->month_absence_rpt == 1): ?>
                            <!--<li><a href="charts-flot.html">MONTH ABSENCE</a></li>-->
                        <?php endif; ?>

                        <?php if ($currentUser[0]->attendance_rpt == 1): ?>
                            <!--<li><a href="charts-sparklines.html">ATTENDANCE</a></li>-->
                        <?php endif; ?>

                        <?php if ($currentUser[0]->leave_rpt == 1): ?>
                            <!--<li><a href="charts-morris.html">LEAVE</a></li>-->
                        <?php endif; ?>

                        <?php if ($currentUser[0]->payslip_report == 1): ?>
                    <!--<li><a href="<?php echo base_url(); ?>Reports/Analysis/Salary_Analysis_chart">SALARY</a></li>-->
                        <?php endif; ?>

                        <?php if ($currentUser[0]->payslip_report == 1): ?>
                            <!--<li><a href="charts-easypiechart.html">RECRUITMENT</a></li>-->
                        <?php endif; ?>

                        <?php if ($currentUser[0]->Analysis_Report == 1): ?>                
                            <!--</ul>-->
                        <?php endif; ?>    
                        </li>

                        <?php if ($currentUser[0]->Tools == 1): ?>
                            <li class="nav-separator">TOOLS</li>
                        <?php endif; ?>

                        <?php if ($currentUser[0]->System_backup == 1): ?>
                            <li><a href="<?php echo base_url(); ?>Tools/DB_Backup"><i class="fa fa-inbox"></i><span>SYSTEM BACKUP</span></a></li>
                        <?php endif; ?>


                        <li><a href="<?php echo base_url() . "index.php/login/logout/" ?>"><i class="fa fa-tasks"></i><span>LOGOUT</span></a></li>




                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>