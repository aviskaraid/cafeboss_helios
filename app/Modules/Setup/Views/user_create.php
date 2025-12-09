<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Title || <?= $title ?></title>
<?= $this->endSection() ?>

<?= $this->section('cssScript') ?>
<link rel="stylesheet" href="<?=base_url()?>template/node_modules/select2/dist/css/select2.min.css">
<style>
.hidden {
    display: none;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
  <section class="section">
    <div class="section-header">
      <div class="section-header-back">
        <a href="<?=site_url('settings/users')?>" class="btn"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Create <?= $title ?></h1>
    </div>
    <section class="section">
      <form id="user_create">
        <div class="section-body">
          <div class="row">
            <!-- Col -->
            <div class="col-12 col-md-6 col-lg-6">
              <div class="card">
                <div class="card-header">
                  <h4>New User</h4>
                </div>
                <div class="card-body col-md-10">
                  <div class="mb-3">
                     <label>User Code (Generate)</label>
                      <input type="text" class="form-control d-inline-block w-75" placeholder="User Code" name="code" value="<?= $generate_code ?>" id="user_code" readonly>
                      <button class="btn btn-primary d-inline-block" id="btnGenerateCode">Generate</button>
                  </div>
                  <div class="form-group">
                    <label>Username *(wajib)</label>
                    <input type="text" name="username" id="usernameInput" class="form-control" onchange="validateUsernameInput()" autocomplete="off">
                    <input type="hidden" id="usernameStatus" value="0">
                      <span id="usernameFeedback" class="error-message"></span>
                  </div>
                  <div class="form-group">
                    <label>Email *(wajib)</label>
                    <input type="text" name="email" id="emailInput" onchange="validateEmailInput()" class="form-control">
                    <input type="hidden" id="emailStatus" value="0">
                    <span id="emailFeedback" class="error-message"></span>
                  </div>
                  <div class="form-group">
                    <label>Fullname</label>
                    <input type="text" name="fullname" id="fullnameInput" onchange="validateFullNameInput()" class="form-control" autocomplete="off">
                    <input type="hidden" id="fullnameStatus" value="0">
                    <span id="fullnameFeedback" class="error-message"></span>
                  </div>
                  <div class="form-group">
                    <label>Group User</label>
                    <input type="hidden" name="group" id="input_group">
                    <select class="group_user form-control " id="userGroup">
                    </select>
                  </div>
                  
                </div>
              </div>
            </div>
            <!-- End Col-->
          </div>
        </div>
        <div class="row" style="text-align:left;">
          <div class="col-12 col-md-12 col-lg-12">
            <div class="form-group">
              <label></label>
              <span></span>
              <button type="submit"  id="btnSave"  class="btn btn-lg btn-success"><i class="fas fa-paper-plane"></i> Submit</button>
              <button type="reset" class="btn btn-lg btn-secondary">Reset</button>
            </div>
          </div>
        </div>
      </form>
  </section>
<?= $this->endSection() ?>

<?= $this->section('jsScript') ?>
<script src="<?=base_url()?>template/node_modules/select2/dist/js/select2.full.min.js"></script>
<script src="<?=base_url()?>template/frequently/js/user_create.js"></script>
<script src="<?=base_url()?>template/frequently/js/validation.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection() ?>