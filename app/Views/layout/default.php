<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <?= csrf_meta() ?>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <?= $this->renderSection('title') ?>
  <!-- General CSS Files -->
  <link rel="shortcut icon" href="<?=base_url()?>template/assets/img/favicon.png"/>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?=base_url()?>template/node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?=base_url()?>template/node_modules/@fortawesome/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?=base_url()?>template/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?=base_url()?>/template/frequently/css/loader.css">
    <?= $this->renderSection('cssScript') ?>
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?=base_url()?>template/assets/css/style.css">
  <link rel="stylesheet" href="<?=base_url()?>template/assets/css/components.css">
  <style>
    .badgeTitle {
       pointer-events:none;
      background-color: #e1ebff;
      color: #7c8efc;
      font-weight: bold;
      padding: 10px 12px;
      text-align: center;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <div id="loader-wrapper">
    <div id="loader"></div>
  </div>
  <div id="app">
    <input type="hidden" value="<?= base_url()?>" name="baseUrl" id="baseUrl">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
           <?= $this->include('layout/default_form_search') ?>
        </form>
        <ul class="navbar-nav navbar-right">
          <?= $this->include('layout/default_right_navbar') ?>
        </ul>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <?= $this->include('layout/default_wrapper') ?>
          <ul class="sidebar-menu" id="my_menu">
            <?= $this->include('layout/menu') ?>
          </ul>
        </aside>
      </div> 

      <!-- Main Content -->
      <div class="main-content">
        <?= $this->renderSection('content') ?>
      </div>

      <!-- Main Footer -->
        <footer class="main-footer">
            <?= $this->include('layout/default_footer') ?>
        </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="<?=base_url()?>template/node_modules/jquery/dist/jquery.min.js"></script>
  <script src="<?=base_url()?>template/node_modules/popper.js/dist/umd/popper.min.js"></script>
  <script src="<?=base_url()?>template/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="<?=base_url()?>template/node_modules/jquery.nicescroll/dist/jquery.nicescroll.min.js"></script>
  <script src="<?=base_url()?>template/node_modules/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="<?=base_url()?>template/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
  <?= $this->renderSection('jsScript') ?>
  <script src="<?=base_url()?>template/assets/js/stisla.js"></script>
  <!-- JS Libraies -->
  <script src="<?=base_url()?>template/assets/js/scripts.js"></script>
  <script src="<?=base_url()?>template/assets/js/custom.js"></script>
  <script src="<?=base_url()?>template/frequently/js/cookie.js"></script>


</body>
</html>


