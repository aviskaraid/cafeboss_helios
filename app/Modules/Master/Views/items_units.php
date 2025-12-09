<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Title | <?= $title ?></title>
<?= $this->endSection() ?>

<?= $this->section('cssScript') ?>
<link rel="stylesheet" href="<?=base_url()?>template/node_modules/bootstrap-daterangepicker/daterangepicker.css">
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
        <a href="<?=site_url('master/items')?>" class="btn"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1><?= $title ?></h1>
    </div>
    <form id="itemUnits_create">
    <div class="section-body">
      <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
            <div class="card card-info">
               <input name="items_id" value="<?= $items->id ?>" id="items_id" type="hidden"></input>
              <div class="card-body col-md-12">
                <div class="row">
                  <div class="col-12 col-md-12 col-lg-12">
                    <div class="form-group">
                     <button type="button" class="btn btn-lg btn-success" id="btnAddUnits"><i class="	fas fa-file-medical"></i> Add Units</button>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="card-body table-responsive">
                      <table class="table table-striped table-md" id="myTable">
                        <thead>
                          <tr>
                            <th>Unit Source</th>
                            <th>Value</th>
                            <th>Unit Destination</th>
                            <th>Value</th>
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
            <div class="row" style="text-align:right;">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="form-group">
                  <label></label>
                  <span></span>
                  <button type="submit" class="btn btn-lg btn-success"><i class="fas fa-paper-plane"></i> Submit</button>
                  <button type="reset" class="btn btn-lg btn-secondary">Reset</button>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
    </form>
  </section>
<?= $this->endSection() ?>

<?= $this->section('jsScript') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?=base_url()?>template/node_modules/select2/dist/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="<?=base_url()?>template/node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?=base_url()?>template/frequently/js/items_units.js"></script>

<?= $this->endSection() ?>