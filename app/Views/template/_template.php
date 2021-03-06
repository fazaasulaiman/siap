<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?php echo base_url(); ?>/favicon.ico" type="image/ico" />

  <title>Gentelella Alela! | </title>

  <!-- Bootstrap -->
  <link href="<?php echo base_url(); ?>/assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="<?php echo base_url(); ?>/assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- PNotify -->
  <link href="<?php echo base_url(); ?>/assets/vendors/pnotify/dist/pnotify.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/assets/vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/assets/vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
  <!-- Datatables -->

  <link href="<?php echo base_url(); ?>/assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <!-- <link href="<?php echo base_url(); ?>/assets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/assets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>/assets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet"> -->
  <!-- Select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
  <!-- Datepicker -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />
  <!-- Custom Theme Style -->
  <link href="<?php echo base_url(); ?>/assets/build/css/custom.min.css" rel="stylesheet">

  <!-- jQuery -->
  <script src="<?php echo base_url(); ?>/assets/vendors/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="<?php echo base_url(); ?>/assets/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- chart js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
<script src="https://cdn.jsdelivr.net/npm/moment@2.27.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@0.1.1"></script>

  <style>
    .logo-kiri {
      width: 200%;
      /* background: #fff; */
      margin: 38%;
      z-index: 1000;
      /* position: center; */
      /* margin-top: 20px; */
      /* border: 1px solid rgba(52,73,94,0.44); */
      /* padding: 4px; */
    }
  </style>
</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="index.html" class="site_title"><img src="<?php echo base_url(); ?>/assets/production/images/siap.png"></a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic">
              <img src="<?php echo base_url(); ?>/assets/production/images/siap.png" alt="..." class="logo-kiri">
            </div>
          </div>
          <!-- /menu profile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3>General</h3>
              <ul class="nav side-menu">
                <li><a href="<?php echo base_url('/home'); ?>"><i class="fa fa-line-chart" aria-hidden="true"></i>
                    Dashboard</a></li>
                <li><a><i class="fa fa-user-times"></i> Penolakan <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <?php
                    if (session('level') == 'seksi') {
                    ?>
                    <li><a href="<?php echo base_url('/penolakan/input'); ?>">Input</a></li>
                    <?php } ?>
                    <li><a href="<?php echo base_url('/penolakan/arsip'); ?>">Arsip</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-user-secret"></i> Waskat <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <?php
                    if (session('level') == 'seksi') {
                    ?>
                    <li><a href="<?php echo base_url('/waskat/input'); ?>">Input</a></li>
                    <?php } ?>
                    <li><a href="<?php echo base_url('/waskat/arsip'); ?>">Arsip</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-exclamation-triangle"></i> Penundaan <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <?php
                    if (session('level') == 'seksi') {
                    ?>
                    <li><a href="<?php echo base_url('/penundaan/input'); ?>">Input</a></li>
                    <?php } ?>
                    <li><a href="<?php echo base_url('/penundaan/arsip'); ?>">Arsip</a></li>
                  </ul>
                </li>
                <?php
                if (session('level') == 'admin') {
                ?>
                  <li><a><i class="fa fa fa-users"></i> User <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url('/register'); ?>">Seksi</a></li>
                      <li><a href="<?php echo base_url('/register/pimpinan'); ?>">Pimpinan</a></li>
                    </ul>
                  </li>
                <?php } ?>
            </div>

          </div>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->
          <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
              <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
              <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
          </div>
          <!-- /menu footer buttons -->
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
          </div>
          <nav class="nav navbar-nav">
            <ul class=" navbar-right">
              <li class="nav-item dropdown open" style="padding-left: 15px;">
                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                  <img src="<?php echo base_url(); ?>/assets/production/images/img.jpg" alt=""><?php echo session('username'); ?>
                </a>
                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="<?php echo base_url(); ?>/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                </div>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">
        <?= $this->renderSection('content') ?>
      </div>
      <!-- /page content -->

      <!-- footer content -->
      <footer>
        <div class="pull-right">
          Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
        </div>
        <div class="clearfix"></div>
      </footer>
      <!-- /footer content -->
    </div>
  </div>
  <!-- FastClick -->
  <script src="<?php echo base_url(); ?>/assets/vendors/fastclick/lib/fastclick.js"></script>
  <!-- Datepicker -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.id.min.js" integrity="sha512-zHDWtKP91CHnvBDpPpfLo9UsuMa02/WgXDYcnFp5DFs8lQvhCe2tx56h2l7SqKs/+yQCx4W++hZ/ABg8t3KH/Q==" crossorigin="anonymous"></script>
  <!-- Select2 -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <!-- Custom Theme Scripts -->
  <script src="<?php echo base_url(); ?>/assets/build/js/custom.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
  <!-- Datatables -->
  <script src="<?php echo base_url(); ?>/assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <!-- <script src="<?php echo base_url(); ?>/assets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script> -->
  <script src="<?php echo base_url(); ?>/assets/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
  <script>
    $('.custom-file-input').on('change', function() {
      let fileName = $(this).val().split('\\').pop();
      $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
    $(".reset").click(function() {
      $(".error").empty();
      $('.datepicker').datepicker('setDate', null);
      $(".state").val('').trigger('change');
      $('#dokumen').val('').trigger('change');
      $("input[type=text], textarea,input[type=password], select").val("");
      $('input[name="gender"]').prop('checked', false);
      $('#tambah input[name],#tambah select').removeClass('is-invalid');
    });
    $('.datepicker').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
      todayHighlight: true,
      orientation: "bottom"
    });
    $('.fa-calendar').click(function() {
      $(this).parent().parent().prev().focus();
    });

    function reset() {
      $("input[type=text], textarea,input[type=password],select").val("");
    }

    function Nberhasil(text) {
      Swal.fire({
        icon: 'success',
        title: text,
        showConfirmButton: false,
        timer: 1500
      })
    }

    function Nloading() {
      Swal.fire({
        title: "Loading...",
        text: "",
        imageUrl: "<?php echo base_url(); ?>/assets/production/images/loading.gif",
        showConfirmButton: false,
        allowOutsideClick: false
      });
    }

    function Nwarning(text) {
      Swal.fire({
        icon: 'warning',
        title: 'Oops...',
        text: text
      })
    }

    function Nerror(text) {
      Swal.fire({
        icon: 'error',
        title: 'Error !!!',
        text: text
      })
    }

    function Toggle() {
      var temp = $(".inputPassword");
      $.each(temp, function(key, value) {
        if (value.type === "password") {
          value.type = "text";
        } else {
          value.type = "password";
        }
      });

    }

    function removeError(param) {
      $('input[name="' + param + '"],select[name="' + param + '"],radio[name="' + param + '"]').removeClass('is-invalid')
    }
  </script>
</body>

</html>