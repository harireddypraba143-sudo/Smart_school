<!DOCTYPE html>
<html lang="en" dir="<?php if ($text_align == 'right-to-left')
  echo 'rtl'; ?>">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description"
    content="A complete and most powerful school system management system for all. Purchase and enjoy">
  <meta name="author" content="OPTIMUM LINKUP COMPUTERS">
  <?php
  //////////LOADING SYSTEM SETTINGS FOR ALL PAGES AND ACCOUNTS/////////
  $system_title = $this->db->get_where('settings', array('type' => 'system_title'))->row()->description;
  ?>

  <link rel="icon" sizes="16x16" href="<?php echo base_url() ?>uploads/logo.png">
  <title><?php echo $page_title; ?>&nbsp;|&nbsp;<?php echo $system_title; ?></title>
  <!-- Bootstrap Core CSS -->
  <link href="<?php echo base_url(); ?>optimum/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

  <link href="<?php echo base_url(); ?>optimum/plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css"
    rel="stylesheet">
  <!-- Menu CSS -->
  <link href="<?php echo base_url(); ?>optimum/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css"
    rel="stylesheet">
  <!-- morris CSS -->
  <link href="<?php echo base_url(); ?>optimum/plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
  <!-- animation CSS -->
  <link href="<?php echo base_url(); ?>optimum/css/animate.css" rel="stylesheet">
  <!-- Custom CSS -->
  <?php if ($text_align == 'right-to-left') { ?>
    <link href="<?php echo base_url(); ?>optimum/css/style-rtl.css" rel="stylesheet">
  <?php } else { ?>
    <link href="<?php echo base_url(); ?>optimum/css/style.css" rel="stylesheet">
  <?php } ?>


  <!-- color CSS -->
  <link rel="stylesheet"
    href="<?php echo base_url(); ?>optimum/plugins/bower_components/dropify/dist/css/dropify.min.css">
  <link href="<?php echo base_url(); ?>optimum/plugins/bower_components/dropzone-master/dist/dropzone.css"
    rel="stylesheet" type="text/css" />


  <link
    href="<?php echo base_url(); ?>optimum/css/colors/<?php echo $this->db->get_where('settings', array('type' => 'skin_colour'))->row()->description; ?>.css"
    id="theme" rel="stylesheet">
  <link href="<?php echo base_url(); ?>optimum/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css"
    rel="stylesheet">
  <link rel="stylesheet"
    href="<?php echo base_url(); ?>optimum/plugins/bower_components/html5-editor/bootstrap-wysihtml5.css" />

  <link
    href="<?php echo base_url(); ?>optimum/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css"
    rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>optimum/plugins/bower_components/custom-select/custom-select.css"
    rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>optimum/plugins/bower_components/switchery/dist/switchery.min.css"
    rel="stylesheet" />
  <link href="<?php echo base_url(); ?>optimum/plugins/bower_components/bootstrap-select/bootstrap-select.min.css"
    rel="stylesheet" />
  <link
    href="<?php echo base_url(); ?>optimum/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css"
    rel="stylesheet" />
  <link
    href="<?php echo base_url(); ?>optimum/plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css"
    rel="stylesheet" />
  <link href="<?php echo base_url(); ?>optimum/plugins/bower_components/multiselect/css/multi-select.css"
    rel="stylesheet" type="text/css" />

  <link href="<?php echo base_url(); ?>optimum/plugins/bower_components/Magnific-Popup-master/dist/magnific-popup.css"
    rel="stylesheet">
  <link href="<?php echo base_url(); ?>optimum/plugins/bower_components/icheck/skins/all.css" rel="stylesheet">


  <link rel="stylesheet" type="text/css"
    href="<?php echo base_url(); ?>optimum/plugins/bower_components/gallery/css/animated-masonry-gallery.css" />
  <link rel="stylesheet" type="text/css"
    href="<?php echo base_url(); ?>optimum/plugins/bower_components/fancybox/ekko-lightbox.min.css" />

  <link href="<?php echo base_url(); ?>optimum/plugins/bower_components/datatables/jquery.dataTables.min.css"
    rel="stylesheet" type="text/css" />
  <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet"
    type="text/css" />
  <link href="<?php echo base_url(); ?>optimum/plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.css"
    rel="stylesheet">
  <link href="<?php echo base_url(); ?>optimum/plugins/bower_components/calendar/dist/fullcalendar.css"
    rel="stylesheet" />
  <link href="<?php echo base_url(); ?>optimum/plugins/bower_components/toast-master/css/jquery.toast.css"
    rel="stylesheet">


  <!--Owl carousel CSS -->
  <link href="<?php echo base_url(); ?>optimum/plugins/bower_components/owl.carousel/owl.carousel.min.css"
    rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>optimum/plugins/bower_components/owl.carousel/owl.theme.default.css"
    rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>js/font-awesome-icon-picker/fontawesome-four-iconpicker.min.css"
    type="text/css" />






  <script src="<?php echo base_url(); ?>optimum/js/jquery-1.11.0.min.js"></script>


  <!--<link href="<?php echo base_url(); ?>optimum/fullcalendar/css/style.css" rel="stylesheet">-->

  <!--Amcharts-->
  <script src="<?php echo base_url(); ?>optimum/js/amcharts/amcharts.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>optimum/js/amcharts/pie.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>optimum/js/amcharts/serial.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>optimum/js/amcharts/gauge.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>optimum/js/amcharts/funnel.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>optimum/js/amcharts/radar.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>optimum/js/amcharts/exporting/amexport.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>optimum/js/amcharts/exporting/rgbcolor.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>optimum/js/amcharts/exporting/canvg.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>optimum/js/amcharts/exporting/jspdf.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>optimum/js/amcharts/exporting/filesaver.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>optimum/js/amcharts/exporting/jspdf.plugin.addimage.js"
    type="text/javascript"></script>
  <!-- Resources -->
  <script src="<?php echo base_url(); ?>optimum/amcharts/core.js"></script>
  <script src="<?php echo base_url(); ?>optimum/amcharts/charts.js"></script>
  <script src="<?php echo base_url(); ?>optimum/amcharts/animated.js"></script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
  <!-- Smart School Modern Premium Theme Overrides -->
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    body {
      font-family: 'Inter', 'Poppins', sans-serif !important;
      background: #eef4f9 !important;
      /* Soft sky blue color */
    }

    /* Hide scrollbar in sidebar */
    .slimscrollsidebar::-webkit-scrollbar,
    .sidebar::-webkit-scrollbar,
    #side-menu::-webkit-scrollbar {
      display: none !important;
    }

    .slimscrollsidebar,
    .sidebar {
      scrollbar-width: none !important;
      -ms-overflow-style: none !important;
    }

    /* ===== NAVBAR — White Top, Dark Logo Area ===== */
    .navbar-static-top {
      margin-left: 250px !important;
      width: calc(100% - 250px) !important;
    }

    #page-wrapper {
      margin-left: 250px !important;
    }

    .navbar-header {
      background: #ffffff !important;
      border: none !important;
      border-bottom: 1px solid #e5e7eb !important;
      box-shadow: none !important;
      width: 100% !important;
    }

  /* ===== TOP-LEFT LOGO AREA — Premium Dark Gradient ===== */
  .top-left-part {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    z-index: 1001 !important;
    background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%) !important;
    backdrop-filter: none;
    -webkit-backdrop-filter: none;
    width: 250px !important;
    max-width: 250px !important;
    min-width: 250px !important;
    box-sizing: border-box !important;
    overflow: hidden !important;
    border: none !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
    box-shadow: none !important;
    height: 70px !important;
  }
  .top-left-part .logo {
    display: flex !important;
    align-items: center !important;
    overflow: hidden;
    text-decoration: none !important;
    padding-left: 18px;
    height: 100%;
  }
  .top-left-part .logo b {
      background: transparent !important;
      display: inline-flex;
      align-items: center;
      margin-right: 12px;
      flex-shrink: 0;
  }
  .top-left-part .logo img {
      border-radius: 50% !important;
      object-fit: cover !important;
      background: #ffffff !important;
      box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.4) !important;
  }
  .top-left-part .logo span {
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: normal !important; 
    line-height: 1.3 !important;
    display: inline-block !important;
    font-size: 13px !important;
    color: #e2e8f0 !important;
    font-weight: 600 !important;
    letter-spacing: 0.3px !important;
    text-transform: capitalize !important;
  }
  .navbar-top-links > li > a {
    color: #64748b !important;
    transition: all 0.3s ease !important;
  }
  .navbar-top-links > li > a:hover {
    background: #f1f5f9 !important;
    color: #0f172a !important;
    transform: translateY(-1px);
  }
  .app-search .form-control,
  .app-search .form-control:focus {
    background: #f1f5f9 !important;
    color: #334155 !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: 8px !important;
    backdrop-filter: none;
    -webkit-backdrop-filter: none;
  }
  .app-search .form-control::-webkit-input-placeholder {
    color: #94a3b8 !important;
  }
  .app-search a {
    color: #64748b !important;
  }
  .navbar-header .navbar-toggle {
    color: #64748b !important;
  }

  /* ===== SIDEBAR — Premium SaaS Dark Gradient ===== */
  .sidebar { 
    background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%) !important;
    box-shadow: 2px 0 20px rgba(0, 0, 0, 0.15) !important; 
    border-right: 1px solid rgba(255, 255, 255, 0.04) !important;
    padding-top: 70px !important;
    margin-left: 0 !important;
    left: 0 !important;
    top: 0 !important;
    position: fixed !important;
    height: 100vh !important;
    z-index: 1000 !important;
    width: 250px !important;
    min-width: 250px !important;
    max-width: 250px !important;
    box-sizing: border-box !important;
  }
  .slimscrollsidebar { 
    background: transparent !important; 
    padding: 0 !important; 
    width: 250px !important;
  }

  /* ===== MENU ITEMS — Modern SaaS Typography ===== */
  #side-menu { margin-top: 10px !important; }
  #side-menu > li { margin-bottom: 2px !important; padding: 0 14px !important; }
  
  #side-menu > li > a { 
    color: #94a3b8 !important;
    border-radius: 10px !important; 
    border: none !important; 
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important; 
    font-weight: 500 !important; 
    font-size: 13.5px !important;
    padding: 11px 16px !important; 
    display: flex !important;
    align-items: center !important;
    letter-spacing: 0.2px !important;
  }

  /* ===== ICONS — Clean & Modern ===== */
  #side-menu > li > a i {
    color: #64748b !important;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
    width: 28px; 
    font-size: 16px !important;
    opacity: 0.8 !important;
  }
  
  /* ===== HOVER — Micro-interaction with translateX ===== */
  #side-menu > li > a:hover,
  #side-menu > li > a:focus { 
    background: rgba(255, 255, 255, 0.06) !important;
    color: #e2e8f0 !important; 
    transform: translateX(4px) !important;
  }
  #side-menu > li > a:hover i { 
    color: #e2e8f0 !important;
    opacity: 1 !important;
  }
  
  /* ===== ACTIVE STATE — LinkedIn/Stripe Gradient Pill ===== */
  #side-menu > li > a.active,
  #side-menu > li.active > a { 
    background: linear-gradient(90deg, #6366f1, #3b82f6) !important;
    color: #ffffff !important; 
    font-weight: 600 !important;
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.35) !important;
    transform: translateX(0) !important;
  }
  #side-menu > li > a.active i,
  #side-menu > li.active > a i { 
    color: #ffffff !important;
    opacity: 1 !important;
  }

  /* ===== SUBMENU CONTAINER ===== */
  #side-menu ul.nav-second-level { 
    background: rgba(0, 0, 0, 0.12) !important; 
    margin: 4px 0 8px 0 !important; 
    padding: 6px 0 !important;
    padding-left: 0 !important;
    border: none !important;
    box-shadow: none !important;
    border-radius: 8px !important;
  }
  
  /* Forcefully nuke all legacy theme borders from side menus */
  #side-menu li, 
  #side-menu li > a, 
  #side-menu ul > li, 
  #side-menu ul > li > a {
      border: none !important;
      border-bottom: 0px solid transparent !important;
      border-top: 0px solid transparent !important;
      outline: none !important;
  }
  
  /* Hide embedded HTML <hr> tags inside navigation.php */
  #side-menu hr {
      display: none !important;
  }

  /* ===== SUBMENU ITEMS ===== */
  #side-menu ul > li { 
      margin-bottom: 1px !important; 
      padding: 0 8px !important; 
  }
  #side-menu ul > li > a { 
    padding: 9px 14px 9px 42px !important; 
    font-size: 12.5px !important; 
    border-radius: 8px !important;
    color: #64748b !important;
    margin: 0 !important;
    font-weight: 500 !important;
    transition: all 0.2s ease !important;
    letter-spacing: 0.1px !important;
  }
  #side-menu ul > li > a:hover { 
    color: #e2e8f0 !important; 
    background: rgba(255, 255, 255, 0.06) !important;
    transform: translateX(3px) !important;
  }
  #side-menu ul > li > a.active { 
    color: #818cf8 !important;
    background: rgba(99, 102, 241, 0.1) !important; 
    font-weight: 600 !important; 
  }
  
  /* ===== SECTION HEADERS — Strong Visual Hierarchy ===== */
  #side-menu .nav-small-cap {
      color: #94a3b8 !important;
      font-size: 10px !important;
      font-weight: 700 !important;
      letter-spacing: 1.5px !important;
      text-transform: uppercase !important;
      margin-top: 20px !important;
      margin-bottom: 8px !important;
      padding-left: 4px !important;
      position: relative !important;
  }
  /* Subtle gradient accent line before section titles */
  #side-menu .nav-small-cap span[style*="background"] {
      background: linear-gradient(90deg, #6366f1, #3b82f6) !important;
      width: 16px !important;
      height: 2px !important;
      display: inline-block !important;
      vertical-align: middle !important;
      margin-right: 8px !important;
      border-radius: 2px !important;
  }

  /* ===== SIDEBAR ARROW ICONS ===== */
  .sidebar .fa-fw,
  .sidebar .fa,
  .sidebar .ti-dashboard,
  .sidebar [class^="fa"] {
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
  }
  /* Arrow color for expand/collapse */
  #side-menu > li > a .fa.arrow {
    color: #475569 !important;
  }
  #side-menu > li > a:hover .fa.arrow,
  #side-menu > li.active > a .fa.arrow {
    color: #94a3b8 !important;
  }

    .sidebar #side-menu .user-pro>a {
      border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
      padding: 16px 15px !important;
      border-radius: 0 !important;
      color: #ffffff !important;
    }

    .sidebar #side-menu .user-pro .nav-second-level a:hover {
      color: #ffffff !important;
    }

    .sidebar .label-custom {
      background: linear-gradient(135deg, #4f46e5, #6366f1) !important;
      border: none;
    }

    .fix-sidebar .top-left-part {
      background: #1e1e2d !important;
    }

    .nav-small-cap {
      color: #64748b !important;
      font-size: 11px !important;
      font-weight: 700 !important;
      letter-spacing: 0.12em !important;
      text-transform: uppercase !important;
      margin: 25px 0 10px 15px !important;
      padding: 0 !important;
    }

    .nav-small-cap span {
      display: none !important;
    }

    /* ===== User Profile in Sidebar ===== */
    .sidebar #side-menu .user-pro .img-circle {
      border: 2px solid rgba(255, 255, 255, 0.2);
      transition: border-color 0.3s ease;
    }

    .sidebar #side-menu .user-pro:hover .img-circle {
      border-color: #6366f1;
    }

    /* ===== Dropdown Menus ===== */
    .navbar-top-links .dropdown-menu {
      background: #ffffff;
      border: 1px solid rgba(0, 0, 0, 0.08);
      border-radius: 12px !important;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12) !important;
      overflow: hidden;
      margin-top: 5px !important;
    }

    .navbar-top-links .dropdown-menu li a {
      color: #5a6a85 !important;
      transition: all 0.2s ease;
    }

    .navbar-top-links .dropdown-menu li a:hover {
      background: linear-gradient(90deg, rgba(102, 126, 234, 0.08), rgba(118, 75, 162, 0.04)) !important;
      color: #667eea !important;
    }

    .dropdown-user {
      border-radius: 12px !important;
    }

    .drop-title {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
      color: #fff !important;
      font-weight: 600;
    }

    /* ===== Right Sidebar ===== */
    .right-sidebar {
      background: #ffffff !important;
      box-shadow: -5px 0 30px rgba(0, 0, 0, 0.08) !important;
    }

    .right-sidebar .rpanel-title {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }

    /* ===== Page Background ===== */
    html,
    body {
      margin: 0 !important;
      padding: 0 !important;
      overflow-x: hidden;
    }

    #wrapper {
      margin: 0 !important;
      padding: 0 !important;
    }

    #page-wrapper {
      background: #eef4f9 !important;
      /* Soft sky blue color for main background */
    }

    .bg-title {
      background: transparent !important;
      border-bottom: none !important;
      box-shadow: none !important;
    }

    .bg-title h4 {
      color: #1e293b !important;
      font-weight: 700 !important;
      font-size: 20px !important;
    }

    .bg-title .breadcrumb {
      display: none !important;
      /* Hide old breadcrumbs for that clean app look */
    }

    .footer {
      background: transparent !important;
      color: #94a3b8 !important;
      border-top: none !important;
    }

    /* ===== Content Cards / White Box ===== */
    .white-box,
    .glass-card {
      background: #ffffff !important;
      border-radius: 16px !important;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03) !important;
      border: 1px solid #f1f5f9 !important;
      transition: box-shadow 0.3s ease;
      backdrop-filter: none !important;
    }

    .white-box:hover,
    .glass-card:hover {
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06) !important;
      transform: translateY(-2px);
    }

    /* ===== Panels ===== */
    .panel {
      border-radius: 16px !important;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03) !important;
      border: 1px solid #f1f5f9 !important;
    }

    .panel .panel-heading {
      border-radius: 16px 16px 0 0 !important;
    }

    .panel-default .panel-heading,
    .panel-white .panel-heading {
      background: #ffffff !important;
      border-bottom: 1px solid #f1f5f9 !important;
    }

    /* ===== Tables ===== */
    .table>thead>tr>th {
      color: #5a6a85 !important;
      font-weight: 600 !important;
      text-transform: uppercase;
      font-size: 11px !important;
      letter-spacing: 0.05em;
      border-bottom: 2px solid rgba(102, 126, 234, 0.15) !important;
    }

    .table-striped>tbody>tr:nth-of-type(odd) {
      background-color: #fafbfc !important;
    }

    .table-hover>tbody>tr:hover {
      background-color: rgba(102, 126, 234, 0.04) !important;
    }

    /* ===== Forms ===== */
    .form-control {
      border-radius: 8px !important;
      border: 1px solid #e2e8f0 !important;
      transition: all 0.3s ease !important;
    }

    .form-control:focus {
      border-color: #667eea !important;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15) !important;
    }

    /* ===== Buttons ===== */
    .btn {
      border-radius: 8px !important;
      font-weight: 500 !important;
      letter-spacing: 0.02em;
      transition: all 0.3s ease !important;
    }

    .btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-success {
      background: linear-gradient(135deg, #48bb78, #38a169) !important;
      border: none !important;
    }

    .btn-info {
      background: linear-gradient(135deg, #667eea, #764ba2) !important;
      border: none !important;
    }

    .btn-danger {
      background: linear-gradient(135deg, #fc5c7d, #e53e3e) !important;
      border: none !important;
    }

    .btn-warning {
      background: linear-gradient(135deg, #f6e05e, #ecc94b) !important;
      border: none !important;
      color: #2d3748 !important;
    }

    /* ===== Badges ===== */
    .badge {
      border-radius: 20px;
      font-weight: 500;
      letter-spacing: 0.03em;
    }

    .badge-success {
      background: linear-gradient(135deg, #48bb78, #38a169) !important;
    }

    .badge-info {
      background: linear-gradient(135deg, #667eea, #764ba2) !important;
    }

    /* ===== Modal ===== */
    .modal-content {
      border-radius: 16px !important;
      border: none !important;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15) !important;
      overflow: hidden;
    }

    .modal-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
      color: #fff !important;
      border-bottom: none !important;
      padding: 20px 25px !important;
    }

    .modal-header .modal-title,
    .modal-header h4 {
      color: #fff !important;
    }

    .modal-header .close {
      color: #fff !important;
      opacity: 0.8;
    }

    /* ===== Accent Overrides ===== */
    .bg-theme {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }

    .bg-theme-dark {
      background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%) !important;
    }

    /* ===== Scrollbar ===== */
    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }

    ::-webkit-scrollbar-track {
      background: #f7fafc;
    }

    ::-webkit-scrollbar-thumb {
      background: linear-gradient(135deg, #667eea, #764ba2);
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #5a67d8;
    }

    /* ===== Animations ===== */
    .sidebar .nav>li {
      transition: all 0.2s ease;
    }

    .sidebar .nav>li:hover {
      transform: translateX(2px);
    }

    /* ===== Dashboard Stat Cards ===== */
    .bg-success {
      background: linear-gradient(135deg, #48bb78 0%, #38a169 100%) !important;
      border-radius: 12px;
    }

    .bg-info {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
      border-radius: 12px;
    }

    .bg-danger {
      background: linear-gradient(135deg, #fc5c7d 0%, #e53e3e 100%) !important;
      border-radius: 12px;
    }

    .bg-warning {
      background: linear-gradient(135deg, #f6e05e 0%, #ecc94b 100%) !important;
      border-radius: 12px;
    }

    .bg-purple {
      background: linear-gradient(135deg, #9f7aea 0%, #805ad5 100%) !important;
      border-radius: 12px;
    }

    /* ===== Preloader ===== */
    .preloader {
      background: #ffffff !important;
    }

    /* ===== Alert Styles ===== */
    .alert-success {
      background: linear-gradient(135deg, #c6f6d5, #9ae6b4) !important;
      color: #276749 !important;
      border: none !important;
      border-radius: 10px !important;
    }

    .alert-info {
      background: linear-gradient(135deg, #c3dafe, #a3bffa) !important;
      color: #3c366b !important;
      border: none !important;
      border-radius: 10px !important;
    }

    /* ===== Profile Image Glow ===== */
    .profile-pic img {
      border: 2px solid rgba(255, 255, 255, 0.5);
      box-shadow: 0 0 12px rgba(255, 255, 255, 0.3);
      transition: all 0.3s ease;
    }

    .profile-pic img:hover {
      box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
      transform: scale(1.05);
    }

    /* ===== Custom Tab Active ===== */
    .customtab li.active a,
    .customtab li.active a:hover,
    .customtab li.active a:focus {
      border-bottom: 2px solid #667eea !important;
      color: #667eea !important;
    }

    .nav-pills>li.active>a {
      background: linear-gradient(135deg, #667eea, #764ba2) !important;
    }

    /* ===== Pagination ===== */
    .pagination>.active>a {
      background: linear-gradient(135deg, #667eea, #764ba2) !important;
      border-color: #667eea !important;
    }

    /* ===== Progress Bars ===== */
    .progress {
      border-radius: 10px !important;
      height: 6px !important;
      background: #e2e8f0;
    }

    .progress-bar {
      border-radius: 10px !important;
      background: linear-gradient(90deg, #667eea, #764ba2) !important;
    }

    /* ===== FIXED SIDEBAR — scrolls independently ===== */
    .navbar-default.sidebar {
      position: fixed !important;
      top: 60px !important;
      left: 0 !important;
      bottom: 0 !important;
      width: 240px !important;
      z-index: 100 !important;
      overflow-y: auto !important;
      overflow-x: hidden !important;
      transition: all 0.3s ease;
    }

    .sidebar-nav.navbar-collapse {
      overflow-y: auto !important;
      overflow-x: hidden !important;
      height: 100% !important;
      padding-bottom: 60px !important;
    }

    /* Push main content area to the right */
    #page-wrapper {
      margin-left: 240px !important;
      min-height: calc(100vh - 60px) !important;
      overflow-y: auto !important;
    }

    /* Fix the top navbar */
    .fix-header .navbar-static-top,
    nav.navbar.navbar-default.navbar-static-top {
      position: fixed !important;
      top: 0 !important;
      left: 0 !important;
      right: 0 !important;
      z-index: 1030 !important;
    }

    #wrapper {
      padding-top: 60px !important;
    }

    /* Sidebar scrollbar styling */
    .navbar-default.sidebar::-webkit-scrollbar {
      width: 4px;
    }

    .navbar-default.sidebar::-webkit-scrollbar-thumb {
      background: rgba(102, 126, 234, 0.3);
      border-radius: 10px;
    }

    .navbar-default.sidebar::-webkit-scrollbar-track {
      background: transparent;
    }

    /* Responsive: collapse sidebar on small screens */
    @media (max-width: 768px) {
      .navbar-default.sidebar {
        width: 100% !important;
        position: relative !important;
        top: auto !important;
      }

      #page-wrapper {
        margin-left: 0 !important;
      }
    }
  </style>
</head>

<body>