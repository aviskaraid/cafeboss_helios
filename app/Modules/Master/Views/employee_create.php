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
        <a href="<?=site_url('master/employee')?>" class="btn"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Create <?= $title ?></h1>
    </div>
    <section class="section">
      <form id="employee_create">
        <div class="section-body">
          <div class="row">
            <!-- Col -->
            <div class="col-12 col-md-6 col-lg-6">
              <div class="card">
                <div class="card-body col-md-10">
                  <div class="mb-3">
                     <label>Group Code (Generate)</label>
                      <input type="text" class="form-control d-inline-block w-75" placeholder="User Code" name="code" value="<?= $generate_code ?>" id="department_code" readonly>
                      <button class="btn btn-primary d-inline-block" id="btnGenerateCode">Generate</button>
                  </div>
                  <div class="form-group">
                    <label>FirstName*</label>
                    <input type="text" name="first_name" id="firstnameInput" class="form-control" onchange="validateFirstNameInput()" autocomplete="off">
                    <input type="hidden" id="firstnameStatus" value="0">
                      <span id="firstnameFeedback" class="error-message"></span>
                  </div>
                  <div class="form-group">
                    <label>LastName</label>
                    <input type="text" name="last_name" id="lastnameInput" onchange="validateLastNameInput()" class="form-control">
                    <input type="hidden" id="lastnameStatus" value="0">
                    <span id="lastnameFeedback" class="error-message"></span>
                  </div>
                  <div class="form-group">
                      <label>Department</label>
                      <input type="hidden" name="input_department" id="input_department">
                      <select class="item_department form-control " id="item_department" name="department_id">
                      </select>
                  </div>
                   <div class="form-group">
                      <label>Employee Group</label>
                      <input type="hidden" name="input_employeegroup" id="input_employeegroup">
                      <select class="item_employeegroup form-control " id="item_employeegroup" name="group_id">
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
<script src="<?=base_url()?>template/frequently/js/employee_create.js"></script>
<script src="<?=base_url()?>template/frequently/js/validation.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection() ?>