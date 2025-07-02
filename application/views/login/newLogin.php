
<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />

  <!-- Core Css -->
  <link rel="stylesheet" href="https://bootstrapdemos.adminmart.com/matdash/dist/assets/css/styles.css" />

  <title>MatDash Bootstrap Admin</title>
</head>

<body>
  <!-- Preloader -->
  <div class="preloader">
    <img src="https://www.vftholdings.lk/img/vft_footer.png" alt="loader" class="lds-ripple img-fluid" />
  </div>
  <div id="main-wrapper">
    <div class="position-relative overflow-hidden auth-bg min-vh-100 w-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100 my-5 my-xl-0">
          <div class="col-md-9 d-flex flex-column justify-content-center">
            <div class="card mb-0 bg-body auth-login m-auto w-100">
              <div class="row gx-0">
                <!-- ------------------------------------------------- -->
                <!-- Part 1 -->
                <!-- ------------------------------------------------- -->
                <div class="col-xl-12 border-end">
                  <div class="row justify-content-center py-4">
                    <div class="col-lg-11">
                      <div class="card-body">
                        <a href="../main/index.html" class="text-nowrap logo-img d-block mb-4 w-100">
                          <img src="https://vftholdings.lk/img/vft_logo_2020.png" class="dark-logo" alt="Logo-Dark" style="width: 230px;"/>
                        </a>
                        <h2 class="lh-base mb-4">Let's get you signed in</h2>
                        <!-- <div class="row">
                          <div class="col-6 mb-2 mb-sm-0">
                            <a class="btn btn-white shadow-sm text-dark link-primary border fw-semibold d-flex align-items-center justify-content-center rounded-1 py-6" href="javascript:void(0)" role="button">
                              <img src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/images/svgs/facebook-icon.svg" alt="matdash-img" class="img-fluid me-2" width="18" height="18">
                              <span class="d-none d-xxl-inline-flex"> Sign in with </span>&nbsp; Facebook
                            </a>
                          </div>
                          <div class="col-6">
                            <a class="btn btn-white shadow-sm text-dark link-primary border fw-semibold d-flex align-items-center justify-content-center rounded-1 py-6" href="javascript:void(0)" role="button">
                              <img src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/images/svgs/google-icon.svg" alt="matdash-img" class="img-fluid me-2" width="18" height="18">
                              <span class="d-none d-xxl-inline-flex"> Sign in with </span>&nbsp; Google
                            </a>

                          </div>
                        </div>
                        <div class="position-relative text-center my-4">
                          <p class="mb-0 fs-12 px-3 d-inline-block bg-body z-index-5 position-relative">Or sign in with
                            email
                          </p>
                          <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                        </div> -->
                        <form class="form-horizontal" id="frmLogin" name="frmLogin" action="<?php echo base_url() ?>login/verifyUser" method="POST">                          <div class="mb-3">
                            <label  class="form-label">Email Address</label>
                            <input type="text" class="form-control" id="txt_username" name="txt_username" placeholder="Username" data-parsley-minlength="6" required="" placeholder="Enter your email" aria-describedby="emailHelp">
                          </div>
                          <div class="mb-4">
                            <div class="d-flex align-items-center justify-content-between">
                              <label class="form-label">Password</label>
                              <a class="text-primary link-dark fs-2" href="../main/authentication-forgot-password2.html">Forgot
                                Password ?</a>
                            </div>
                            <input type="password" class="form-control" id="txt_password" name="txt_password" placeholder="Password" required="" placeholder="Enter your password">
                          </div>
                          <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                              <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                              <label class="form-check-label text-dark" for="flexCheckChecked">
                                Keep me logged in
                              </label>
                            </div>
                          </div>
                          <div id="divmessage" >
                          <center>
                          <div id="spnmessage" style="color: #002640;font-weight: bold; margin-top: 0px;"> </div>
                          </center>
                          </div>
                          <button type="submit" id="btnSubmit" name="btnSubmit" class="btn btn-dark w-100 py-8 mb-4 rounded-1">Sign In</button>
                          <div class="d-flex align-items-center">
                            <p class="fs-12 mb-0 fw-medium">Don’t have an account yet?</p>
                            <a class="text-primary fw-bolder ms-2" href="../main/authentication-register2.html">Sign Up Now</a>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                </div>
                <!-- ------------------------------------------------- -->
                <!-- Part 2 -->
                <!-- ------------------------------------------------- -->
                <!-- <div class="col-xl-6 d-none d-xl-block">
                  <div class="row justify-content-center align-items-start h-100">
                    <div class="col-lg-9">
                      <div id="auth-login" class="carousel slide auth-carousel mt-5 pt-4" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                          <button type="button" data-bs-target="#auth-login" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                          <button type="button" data-bs-target="#auth-login" data-bs-slide-to="1" aria-label="Slide 2"></button>
                          <button type="button" data-bs-target="#auth-login" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                          <div class="carousel-item active">
                            <div class="d-flex align-items-center justify-content-center w-100 h-100 flex-column gap-9 text-center">
                              <img src="https://plantation.vfthris.com/assets/images/company/companyLogo.png" alt="login-side-img" width="300" class="img-fluid" />
                              <h4 class="mb-0">Feature Rich 3D Charts</h4>
                              <p class="fs-12 mb-0">Donec justo tortor, malesuada vitae faucibus ac, tristique sit amet
                                massa.
                                Aliquam dignissim nec felis quis imperdiet.</p>
                              <a href="javascript:void(0)" class="btn btn-primary rounded-1">Learn More</a>
                            </div>
                          </div>
                          <div class="carousel-item">
                            <div class="d-flex align-items-center justify-content-center w-100 h-100 flex-column gap-9 text-center">
                              <img src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/images/backgrounds/login-side.png" alt="login-side-img" width="300" class="img-fluid" />
                              <h4 class="mb-0">Feature Rich 2D Charts</h4>
                              <p class="fs-12 mb-0">Donec justo tortor, malesuada vitae faucibus ac, tristique sit amet
                                massa.
                                Aliquam dignissim nec felis quis imperdiet.</p>
                              <a href="javascript:void(0)" class="btn btn-primary rounded-1">Learn More</a>
                            </div>
                          </div>
                          <div class="carousel-item">
                            <div class="d-flex align-items-center justify-content-center w-100 h-100 flex-column gap-9 text-center">
                              <img src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/images/backgrounds/login-side.png" alt="login-side-img" width="300" class="img-fluid" />
                              <h4 class="mb-0">Feature Rich 1D Charts</h4>
                              <p class="fs-12 mb-0">Donec justo tortor, malesuada vitae faucibus ac, tristique sit amet
                                massa.
                                Aliquam dignissim nec felis quis imperdiet.</p>
                              <a href="javascript:void(0)" class="btn btn-primary rounded-1">Learn More</a>
                            </div>
                          </div>
                        </div>

                      </div>


                    </div>
                  </div>

                </div> -->
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="dark-transparent sidebartoggler"></div>
  <!-- Import Js Files -->
  <script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/libs/simplebar/dist/simplebar.min.js"></script>
  <script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/js/theme/app.init.js"></script>
  <script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/js/theme/theme.js"></script>
  <script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/js/theme/app.min.js"></script>

  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.min.js"></script> 							<!-- Load jQuery -->
    <script src="<?php echo base_url(); ?>assets/js/jqueryui-1.9.2.min.js"></script> 							<!-- Load jQueryUI -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script> 								<!-- Load Bootstrap -->
    <script src="<?php echo base_url(); ?>assets/plugins/easypiechart/jquery.easypiechart.js"></script> 		<!-- EasyPieChart-->
    <script src="<?php echo base_url(); ?>assets/plugins/sparklines/jquery.sparklines.min.js"></script>  		<!-- Sparkline -->
    <script src="<?php echo base_url(); ?>assets/plugins/jstree/dist/jstree.min.js"></script>  				<!-- jsTree -->
    <script src="<?php echo base_url(); ?>assets/plugins/codeprettifier/prettify.js"></script> 				<!-- Code Prettifier  -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-switch/bootstrap-switch.js"></script> 		<!-- Swith/Toggle Button -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js"></script>  <!-- Bootstrap Tabdrop -->
    <script src="<?php echo base_url(); ?>assets/plugins/iCheck/icheck.min.js"></script>     					<!-- iCheck -->
    <script src="<?php echo base_url(); ?>assets/js/enquire.min.js"></script> 									<!-- Enquire for Responsiveness -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootbox/bootbox.js"></script>							<!-- Bootbox -->
    <script src="<?php echo base_url(); ?>assets/plugins/simpleWeather/jquery.simpleWeather.min.js"></script> <!-- Weather plugin-->
    <script src="<?php echo base_url(); ?>assets/plugins/nanoScroller/js/jquery.nanoscroller.min.js"></script> <!-- nano scroller -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-mousewheel/jquery.mousewheel.min.js"></script> 	<!-- Mousewheel support needed for jScrollPane -->
    <script src="<?php echo base_url(); ?>assets/js/application.js"></script>
    <script src="<?php echo base_url(); ?>assets/demo/demo.js"></script>
    <script src="<?php echo base_url(); ?>assets/demo/demo-switcher.js"></script>
    <script src="<?php echo base_url(); ?>system_js/utility.js" type="text/javascript"></script>

     <!--Ajax-->
     <script src="<?php echo base_url(); ?>system_js/login/login.js"></script>

<!--Jquary Validation-->
<script src="<?php echo base_url(); ?>assets/plugins/validation/jquery.validate.js"></script>

<!--JQuary Validation-->
<script type="text/javascript">
    $(document).ready(function () {
        $("#frmLogin").validate({
            rules: {
                txt_username: {
                    required: true,
                    minlength: 1
                },
                txt_password: {
                    required: true,
                    minlength: 1
                },
            },
            messages: {
                txt_username: {
                    required: "<i class='fa fa-user'></i>  Please enter Username !",
                    minlength: "Your username must consist of at least 1 characters"
                },
                txt_password: {
                    required: "<i class='fa fa-key'></i> Please enter your Password !",
                    minlength: "Your password must be at least 1 characters long"
                }

            }
        });
    });
</script>


<!--Clear Text Boxes-->
<script type="text/javascript">

    $("#cancel").click(function () {

        $("#txt_username").val("");
        $("#txt_password").val("");

    });
</script>

</body>

</html>