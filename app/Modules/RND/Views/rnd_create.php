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
      <form id="rnd_create">
        <div class="section-body">
          <div class="row">
            <!-- Col -->
            <div class="col-12 col-md-6 col-lg-6">
              <div class="card">
                <input type="hidden" id="rnd_id" value="<?= $id?>">
                <div class="card-body col-md-10">
                  <div class="mb-3">
                     <label>RND Code (Generate)</label>
                      <input type="text" class="form-control d-inline-block w-75" placeholder="User Code" name="code" value="<?= $generate_code ?>" id="department_code" readonly>
                      <button class="btn btn-primary d-inline-block" id="btnGenerateCode">Generate</button>
                  </div>
                  <div class="form-group">
                    <label>Description*</label>
                    <input type="text" name="description" id="descriptionInput" class="form-control" onchange="validateDescInput()" autocomplete="off">
                    <input type="hidden" id="descriptionStatus" value="0">
                      <span id="descriptionFeedback" class="error-message"></span>
                  </div>
                  <div class="form-group">
                    <label>Remark</label>
                    <input type="text" name="remark" class="form-control">
                  </div>
                   <div class="form-group">
                      <label>Employee</label>
                      <input type="hidden" name="input_employee" id="input_employee">
                      <select class="item_employee form-control " id="item_employee" name="employee_id">
                      </select>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Col-->
          </div>
          <div class="row">
            <!-- Col -->
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-body col-md-10">
                  <div class="form-group">
                     <button type="button" class="btn btn-lg btn-success" id="btnAddIngredient"><i class="	fas fa-file-medical"></i> Add Ingredient</button>
                  </div>
                  <div class="card-body table-responsive">
                      <table class="table table-striped table-md" id="myTable">
                        <thead>
                          <tr>
                            <th>Items</th>
                            <th>Unit</th>
                            <th>Consumption</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody id="detail_list">
                        </tbody>
                      </table>
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
<script src="<?=base_url()?>template/frequently/js/rnd_create.js"></script>
<script src="<?=base_url()?>template/frequently/js/validation.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection() ?>