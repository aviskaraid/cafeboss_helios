<?php
  // $c = apps_detail();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Cafe Boss</title>
  <link rel="shortcut icon" href="<?=base_url()?>template/assets/img/favicon.png"/>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?=base_url()?>/template/node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?=base_url()?>/template/node_modules/@fortawesome/fontawesome-free/css/all.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?=base_url()?>/template/assets/css/style.css">
  <link rel="stylesheet" href="<?=base_url()?>/template/frequently/css/loader.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <div id="loader-wrapper">
    <div id="loader"></div>
  </div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <input type="hidden" value="<?= base_url()?>" name="baseUrl" id="baseUrl">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <?php $imageUrl = ((getApps()->img_profile==null))?"/images/noImage.png":getApps()->img_profile?>
              <img src="<?= base_url($imageUrl) ?>" alt="logo" width="200" class="shadow-light">
            </div>

            <div class="card card-primary">
              <div class="card-header d-flex justify-content-center"><h4><?=$title?></h4></div>
              <label for="sub_title" class=" d-flex justify-content-center"><?=$message?></label>
              <div class="card-body">
                <div id="message"></div>
                <form id="myForm">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" id="email" tabindex="1" autocomplete="email" required autofocus>
                    <div class="invalid-feedback">
                      Please fill in your email
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                    	<label for="password" class="control-label">Password</label>
                      <div class="float-right">
                        <a href="" class="text-small">
                          Forgot Password?
                        </a>
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" autocomplete="current-password" required>
                    <div class="invalid-feedback">
                      Please fill in your password
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
              </div>
            </div>
             <div class="mt-5 text-muted text-center">
              Don't have an account? <a href="<?= url_to('authentication/register') ?>">Register</a>
            </div>
            <div class="simple-footer">
              Copyright &copy; VirtualZax 2025 by Soegi
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="<?=base_url()?>/template/node_modules/jquery/dist/jquery.min.js"></script>
  <script src="<?=base_url()?>/template/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="<?=base_url()?>/template/frequently/js/login_form.js"></script>
  <!-- Page Specific JS File -->
</body>
</html>
