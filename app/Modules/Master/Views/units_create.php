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
        <a href="<?=site_url('master/units')?>" class="btn"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Create <?= $title ?></h1>
    </div>
    <section class="section">
      <form id="units_create">
        <div class="section-body">
          <div class="row">
            <!-- Col -->
            <div class="col-12 col-md-6 col-lg-6">
              <div class="card">
                <div class="card-body col-md-10">
                  <div class="form-group">
                    <label>Name*</label>
                    <input type="text" name="name" id="nameInput" class="form-control" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <input type="text" name="description" id="descriptionInput" class="form-control">
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
<script src="<?=base_url()?>template/frequently/js/units_create.js"></script>
<script src="<?=base_url()?>template/frequently/js/validation.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection() ?>