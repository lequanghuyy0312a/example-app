<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.8.335/pdf_viewer.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/fontawesome-free-6.4.0-web/css/all.min.css">

  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">

  <link rel="stylesheet" href="../../plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">

  <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

  <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <link rel="stylesheet" href="../../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <link rel="stylesheet" href="{{ url('css/styles.css') }}">

  <link rel="stylesheet" href="../../plugins/bs-stepper/css/bs-stepper.min.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css?v=3.2.0">
  <link rel="stylesheet" href="../../plugins/dropzone/min/dropzone.min.css">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../../dist/css/myCSS.css">
  <link rel="stylesheet" href="../plugins/ekko-lightbox/ekko-lightbox.css">
  <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">

  <!-- public chat -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

  <!-- Styles -->
</head>

<body class="hold-transition sidebar-mini layout-fixed  text-sm">
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light position-sticky">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars text-dark"></i></a>
        </li>

      </ul>
      <ul class="navbar-nav ml-auto ">
        <!-- Navbar Search -->
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false" id="dropdown01">
            <i class="fa-solid fa-globe"></i>
          </a>
          <div class="dropdown-menu p-0 dropdown-menu-right dropdown-menu-lg " aria-labelledby="dropdown01">
            <a class="dropdown-item" href="javascript:void(0);" onclick="changeLanguage('vi')"> <img class="mr-1" style="width: 25px; border: 0.5px solid #000;" src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/21/Flag_of_Vietnam.svg/510px-Flag_of_Vietnam.svg.png"> Tiếng Việt</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="javascript:void(0);" onclick="changeLanguage('ja')"> <img class="mr-1" style="width: 25px; border: 0.5px solid #000;" src="https://upload.wikimedia.org/wikipedia/en/thumb/9/9e/Flag_of_Japan.svg/800px-Flag_of_Japan.svg.png"> 日本語</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="javascript:void(0);" onclick="changeLanguage('en')"> <img class="mr-1" style="width: 25px; border: 0.5px solid #000;" src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Flag_of_the_United_Kingdom_%281-2%29.svg/1200px-Flag_of_the_United_Kingdom_%281-2%29.svg.png"> English</a>

        </div>
        </li>
      </ul>
    </nav>
      <!-- Right navbar links -->

    </nav>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-warning bg-white shadow" >
      <div class="">
        <a href="/" class="brand-link  text-center mx-0 px-0 bg-white" style="padding: 0.58em; border-bottom: 0px">
          <img src="{{ asset('assets/img/logo_kvn.jpg') }}" alt="KVN logo" class="brand-image m-0 ml-3 p-0" style="width:100px;">
          <span class="brand-text font-weight-light text-primary ">
            <img style="width: 3.0rem; border: 1px solid #ff0000;" src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/21/Flag_of_Vietnam.svg/510px-Flag_of_Vietnam.svg.png">
            <img class="ml-1" style="width: 3.0rem; border: 1px solid #000;" src="https://upload.wikimedia.org/wikipedia/en/thumb/9/9e/Flag_of_Japan.svg/800px-Flag_of_Japan.svg.png">
          </span>
        </a>
      </div>
      <!-- Brand Logo -->
      <!-- Sidebar -->
      <div class="sidebar">
        @include('partials.navbar')
      </div>
    </aside>
    <main>
      <!-- <div class="content-wrapper " style="background-size:cover;
                                           background-repeat:no-repeat;
                                           background-image: url('<?php echo asset('assets/img/bg_kvn.png'); ?>')">  -->
      <div class="content-wrapper">
        @yield('content')
      </div>
    </main>

    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../../plugins/select2/js/select2.full.min.js"></script>
    <script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <script src="../../plugins/moment/moment.min.js"></script>
    <script src="../../plugins/inputmask/jquery.inputmask.min.js"></script>
    <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
    <script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <script src="../../plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <script src="../../plugins/dropzone/min/dropzone.min.js"></script>
    <!-- PDF.js JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.8.335/pdf.min.js"></script>
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="dist/js/adminlte.js"></script>

    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../../plugins/jszip/jszip.min.js"></script>
    <script src="../../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="../plugins/filterizr/jquery.filterizr.min.js"></script>
    <script src="../plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <!-- <script src="../dist/js/adminlte.min.js"></script> -->
    <script src="dist/js/pages/dashboard.js"></script>
    <!-- SweetAlert2 -->
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="../../plugins/toastr/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
    @include('scripts.my-script')
    @yield('scripts-bom')
    @yield('scripts-product')
    @yield('scripts-product-detail')
    @yield('scripts-purchase-order')
    @yield('scripts-process-purchase')
    @yield('scripts-quotation-supplier')
    @yield('scripts-compare-prices')
    @yield('scripts-partner')
    @yield('scripts-partner-detail')
    @stack('scripts_fixPushMenu')
    <script src="../../plugins/select2/js/select2.full.min.js"></script>

</body>

</html>
