<!DOCTYPE html>


<!--Description of dashboard page

@author Ashan Rathsara-->

<!--<script src="<?php echo base_url(); ?>system_js/Cheque/new.js"></script>
<script src="<?php echo base_url(); ?>system_js/Cheque/toword.js"></script>-->
<html lang="en">



    <head>
        <title><?php echo $title ?></title>
        <!-- Styles -->
        <?php $this->load->view('template/css.php'); ?>

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

                <div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">

                                <li class=""><a href="">HOME</a></li>
                                <li class="active"><a href="">SALARY ANALYSIS CHART</a></li>

                            </ol>

                            <div class="container-fluid">


                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">

                                        <div class="row">
                                            <div class="col-xs-12">


                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-primary">
                                                            <div class="panel-heading"><h2>SALARY ANALYSIS CHART</h2></div>

                                                            
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>

		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'Monthly Average Salary'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: 'Total Salary RS.'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [{
            name: 'Salary',
            data: [384500, 393214, 412452.12, 403650, 399452.60, 401896.30, 410545, 401998.12,0, 0, 0, 0]
        }]
    });
});
		</script>
	</head>
	<body>


<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

	</body>
</html>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                </div> <!-- .container-fluid -->
                            </div>
                        </div>
                    </div>
                    <!--Footer-->
                    <?php $this->load->view('template/footer.php'); ?>
                    <!--End Footer-->
                </div>
            </div>
        </div>



        <!-- Load site level scripts -->

 						<!-- Initialize scripts for this page-->

        <!-- End loading page level scripts-->

    
     

            <script src="<?php echo base_url(); ?>assets/plugins/highcharts/exporting.js" type="text/javascript"></script>
            <script src="<?php echo base_url(); ?>assets/plugins/highcharts/highcharts-3d.js" type="text/javascript"></script>
            <script src="<?php echo base_url(); ?>assets/plugins/highcharts/highcharts.js" type="text/javascript"></script>


    </body>


</html>