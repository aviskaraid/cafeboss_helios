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
        <a href="<?=site_url('master/warehouse')?>" class="btn"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Create <?= $title ?></h1>
    </div>
    <section class="section">
      <form id="table_area_create">
        <div class="section-body">
          <div class="row">
            <!-- Col -->
            <div class="col-12 col-md-6 col-lg-6">
              <div class="card">
                <div class="card-body col-md-10">
                  <div class="form-group">
                    <label>Name*</label>
                    <input type="text" name="name" id="nameInput" class="form-control" onchange="validateNameInput()" autocomplete="off">
                    <input type="hidden" id="nameStatus" value="0">
                      <span id="nameFeedback" class="error-message"></span>
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <input type="text" name="description" id="descriptionInput" onchange="validateDescInput()" class="form-control">
                    <input type="hidden" id="descriptionStatus" value="0">
                    <span id="descriptionFeedback" class="error-message"></span>
                  </div>
                  <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Spesification</label>
                    <input type="text" name="spesification" class="form-control">
                  </div>
                  <div class="row">
                    <div class="col-12 col-md-3 col-lg-3">
                      <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="ac" class="custom-control-input" id="ac">
                            <label class="custom-control-label" for="ac">AC</label>
                          </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                      <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="smoking" class="custom-control-input" id="smoking">
                            <label class="custom-control-label" for="smoking">Smoking</label>
                          </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                      <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="meeting" class="custom-control-input" id="meeting">
                            <label class="custom-control-label" for="meeting">Meeting</label>
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                     <label>Store</label>
                      <input type="hidden" name="input_store" id="input_store">
                      <select class="item_store form-control " id="item_store" name="store[]">
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
<script src="<?=base_url()?>template/frequently/js/table_area_create.js"></script>
<script src="<?=base_url()?>template/frequently/js/validation.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection() ?>