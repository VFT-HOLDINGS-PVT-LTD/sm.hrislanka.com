<!DOCTYPE html>


<!--Description of dashboard page

@author Ashan Rathsara-->


<html lang="en">


<head>
    <!-- Styles -->
    <?php $this->load->view('template/css.php'); ?>
    <style>
        /* CSS Styling */
        /* body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        } */

        .container1 {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
        }

        .terms-section {
            margin: 20px 0;
        }

        .section-header {
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
            cursor: pointer;
            padding: 15px;
            background-color: #f1f1f1;
            border: 1px solid #ddd;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .section-header:hover {
            background-color: #e0e0e0;
        }

        .section-content {
            margin: 10px 0;
            padding: 15px;
            display: none;
            border-left: 4px solid #007BFF;
            background-color: #f9f9f9;
            border-radius: 4px;
        }

        /* ul {
            padding-left: 20px;
        }

        ul li {
            margin-bottom: 10px;
        } */

        .agree-section {
            text-align: center;
            margin: 20px 0;
        }

        .agree-section label {
            font-size: 16px;
            margin-right: 10px;
        }

        /* footer {
            text-align: center;
            padding: 10px;
            margin-top: 30px;
            font-size: 10px;
            color: #777;
        } */

        button {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:disabled {
            background-color: #aaa;
            cursor: not-allowed;
        }
    </style>
</head>

<body class="infobar-offcanvas">

    <!--header-->

    <?php $this->load->view('template/header.php'); ?>

    <!--end header-->

    <div id="wrapper">
        <div id="layout-static">

            <!--dashboard side-->

            <?php $this->load->view('template/dashboard_side.php'); ?>

            <!--dashboard side end-->

            <div class="container1">
                <h1>Software Terms and Conditions</h1>
                <div class="terms-section">
                    <h2 class="section-header" onclick="toggleSection('section1')">1. Pricing and Payment Terms</h2>
                    <div id="section1" class="section-content">
                        <p><strong>1.1. Payment Terms:</strong></p>
                        <ul>
                            <li>Customers shall pay the agreed fees as outlined in the order form/proposal within 30
                                days of receiving the invoice.</li>
                        </ul>
                        <p><strong>1.2. Billing Schedule:</strong></p>
                        <ul>
                            <li>Upon receiving the order form or purchase order, VFT Holdings (Pvt) Ltd will issue an
                                invoice for a three-month subscription fee upfront. Subsequent invoices will cover
                                annual subscription fees</li>
                        </ul>
                        <p><strong>1.3. Non-Refundable Fees:</strong></p>
                        <ul>
                            <li>All subscription fees are non-refundable and non-cancellable.</li>
                        </ul>
                        <p><strong>1.4. Quarterly Employee Verification:</strong></p>
                        <ul>
                            <li>VFT Holdings (Pvt) Ltd will verify active employees quarterly and bill based on actual
                                active employee counts, regardless of initial order form data.</li>
                        </ul>
                        <p><strong>1.5. Fee Adjustments and Renewal:</strong></p>
                        <ul>
                            <li>Fees are fixed during the agreed term.</li>
                            <li>At term renewal, fees may increase up to a maximum of 5% to 15% per year, subject to
                                prior written notification.</li>
                        </ul>
                        <p><strong>1.6. Suspension and Termination for Non-Payment:</strong></p>
                        <ul>
                            <li>Services will be suspended if fees remain unpaid for over 30 days and permanently
                                cancelled if unpaid for 90 days.</li>
                            <li>If the annual cloud payment is not received, the software subscription and access will
                                be immediately terminated.</li>
                        </ul>
                    </div>

                    <h2 class="section-header" onclick="toggleSection('section2')">2. Payroll Data Disclaimer</h2>
                    <div id="section2" class="section-content">
                        <p><strong>2.1. Customer Responsibility:</strong></p>
                        <ul>
                            <li>Customers are solely responsible for the accuracy, quality, and legality of all payroll
                                data entered into the HRIS system.</li>
                            <li>If incorrect payroll data leads to employees being paid incorrect amounts, VFT Holdings
                                (Pvt) Ltd will not be held liable for any errors, losses, or disputes arising from such
                                incidents.</li>
                        </ul>
                        <p><strong>2.2. Verification:</strong></p>
                        <ul>
                            <li>Customers must review and verify payroll calculations and amounts before processing
                                payments.</li>
                        </ul>
                    </div>

                    <h2 class="section-header" onclick="toggleSection('section3')">3. Customer Conduct and Cancellation
                    </h2>
                    <div id="section3" class="section-content">
                        <p><strong>3.1. Right to Action:</strong></p>
                        <ul>
                            <li>VFT Holdings (Pvt) Ltd reserves the right to take necessary action, including suspension
                                or termination of the project or services, if the customer exhibits any of the following
                                unacceptable behaviors, including but not limited to:</li>
                            <ul>
                                <li>Harassment or misconduct toward VFT Holdings’ employees.</li>
                                <li>Abusive, unprofessional, or unethical behaviour.</li>
                                <li>Deliberate attempts to disrupt project progress or misrepresentation.</li>
                            </ul>
                        </ul>
                        <p><strong>3.2. Termination Policy:</strong></p>
                        <ul>
                            <li>In such cases, VFT Holdings (Pvt) Ltd may terminate the agreement at its discretion,
                                with prior written notice. Any pre-paid fees will be non-refundable in this scenario
                            </li>
                        </ul>
                    </div>

                    <!-- Add more sections in the same format -->

                    <h2 class="section-header" onclick="toggleSection('section4')">4. Termination</h2>
                    <div id="section4" class="section-content">
                        <p><strong>4.1. Termination by Either Party:</strong></p>
                        <ul>
                            <li>Either party may terminate this agreement by providing 30 days' written notice of
                                material breach, allowing time to cure the breach.</li>
                        </ul>
                        <p><strong>4.2. Access and Data Availability:</strong></p>
                        <ul>
                            <li>Upon termination, access to the HRIS system will cease, and data will be available upon
                                written request for up to 30 days.</li>
                        </ul>
                    </div>

                    <h2 class="section-header" onclick="toggleSection('section5')">5. Confidentiality</h2>
                    <div id="section5" class="section-content">
                        <p><strong>5.1. Confidentiality Agreement:</strong></p>
                        <ul>
                            <li>Both parties agree to maintain the confidentiality of all business, technical, and
                                operational information shared.</li>
                        </ul>
                        <p><strong>5.2. Disclosure Restrictions:</strong></p>
                        <ul>
                            <li>Confidential information will not be disclosed to third parties without prior written
                                consent.</li>
                        </ul>
                    </div>

                    <h2 class="section-header" onclick="toggleSection('section6')">6. Taxes</h2>
                    <div id="section6" class="section-content">
                        <p><strong>6.1. Taxes Excluded:</strong></p>
                        <ul>
                            <li>All fees exclude applicable taxes.</li>
                        </ul>
                        <p><strong>6.2. Customer Responsibility:</strong></p>
                        <ul>
                            <li>Customers will bear all government taxes, duties, and levies as required by law.</li>
                        </ul>
                    </div>

                    <h2 class="section-header" onclick="toggleSection('section7')">7. Customer Responsibilities</h2>
                    <div id="section7" class="section-content">
                        <p><strong>7.1. Access Control:</strong></p>
                        <ul>
                            <li>Customers are responsible for ensuring that access to the HRIS system is limited to
                                authorized personnel.</li>
                        </ul>
                        <p><strong>7.2. Data Compliance:</strong></p>
                        <ul>
                            <li>Customer data accuracy and compliance with applicable laws are the customer’s
                                responsibility.</li>
                        </ul>
                    </div>

                    <h2 class="section-header" onclick="toggleSection('section8')">8. Ownership of Data and Intellectual
                        Property</h2>
                    <div id="section8" class="section-content">
                        <p><strong>8.1. Data Ownership:</strong></p>
                        <ul>
                            <li>Customers retain ownership of their data.</li>
                        </ul>
                        <p><strong>8.2. System Ownership:</strong></p>
                        <ul>
                            <li>VFT Holdings (Pvt) Ltd retains ownership of the HRIS system and associated intellectual
                                property.</li>
                        </ul>
                    </div>

                    <h2 class="section-header" onclick="toggleSection('section9')">9. Updates and Upgrades</h2>
                    <div id="section9" class="section-content">
                        <p><strong>9.1. Updates Included:</strong></p>
                        <ul>
                            <li>Customers are entitled to free updates and upgrades to the subscribed modules during the
                                subscription period.</li>
                        </ul>
                        <p><strong>9.2. Additional Modules:</strong></p>
                        <ul>
                            <li>Additional modules are available for subscription based on prevailing list prices.</li>
                        </ul>
                    </div>

                    <h2 class="section-header" onclick="toggleSection('section10')">10. Service Interruptions</h2>
                    <div id="section10" class="section-content">
                        <p><strong>10.1. Notification of Interruptions:</strong></p>
                        <ul>
                            <li>In case of any service interruptions or material changes affecting service delivery, VFT
                                Holdings (Pvt) Ltd will notify customers promptly.</li>
                        </ul>
                    </div>

                </div>
                <div class="agree-section">
            <label>
                <input type="checkbox" id="agreeCheckbox" onclick="toggleButton()"> I have read and agree to the terms and conditions
            </label>
            <br><br>
            <button id="agreeButton" disabled onclick="saveToLocalStorage()">Agree and Continue</button>
        
                    <p style="margin-top: 30px;">
                        &copy; <?= date('Y') ?> VFT Holdings (Pvt) Ltd. All rights reserved.
                    </p>
                </div>


            </div>

        </div>

    </div>






    <!-- Load site level scripts -->

    <?php $this->load->view('template/js.php'); ?> <!-- Initialize scripts for this page-->

    <!-- End loading page level scripts-->

    <!--Ajax-->
    <script src="<?php echo base_url(); ?>system_js/Master/Weekly_Roster.js"></script>


    <!-- Load page level scripts-->


    <script>
        function toggleSection(sectionId) {
            const section = document.getElementById(sectionId);
            section.style.display = section.style.display === "block" ? "none" : "block";
        }

        function toggleButton() {
            const checkbox = document.getElementById('agreeCheckbox');
            const button = document.getElementById('agreeButton');
            button.disabled = !checkbox.checked;
        }

        function saveToLocalStorage() {
            // Save agreement confirmation to localStorage
            localStorage.setItem('termsAccepted', 'true');
            alert('Your agreement has been saved.');
        }

        function checkLocalStorage() {
            // Check if terms have already been accepted
            const isAccepted = localStorage.getItem('termsAccepted') === 'true';
            const checkbox = document.getElementById('agreeCheckbox');
            const button = document.getElementById('agreeButton');

            if (isAccepted) {
                checkbox.checked = true;
                button.disabled = false;
            }
        }

        // Run on page load
        document.addEventListener('DOMContentLoaded', checkLocalStorage);
    </script>
</body>


</html>