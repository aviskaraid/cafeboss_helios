<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Title || <?= $title ?></title>
<?= $this->endSection() ?>

<?= $this->section('cssScript') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker3.min.css" integrity="sha512-aQb0/doxDGrw/OC7drNaJQkIKFu6eSWnVMAwPN64p6sZKeJ4QCDYL42Rumw2ZtL8DB9f66q4CnLIUnAw28dEbg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        <a href="<?=site_url('taktikal')?>" class="btn"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1><?= $title ?></h1>
    </div>
    <section class="section">
      <form id="taktikal_update">
        <div class="section-body">
          <div class="row">
            <!-- Col -->
            <div class="col-12 col-md-5 col-lg-5">
              <div class="card">
                <div class="card-body col-md-10">
                   <div class="mb-3">
                     <label>Taktikal Code (Generate)</label>
                      <input type="text" class="form-control d-inline-block w-75" placeholder="Taktikal Code" name="code" value="<?= $data->ref_code ?>" id="taktikal_code" readonly>
                  </div>  
                  <div class="mb-3">
                     <label>Contract Number</label>
                      <input type="text" class="form-control d-inline-block" placeholder="Contract Number" name="ref_no" id="ref_no" value="<?= $data->ref_no ?>">
                  </div>  
                  <div class="form-group">
                    <label>Description</label>
                    <input type="hidden" name="taktikal_id" id="taktikal_id" value="<?= $data->id ?>" class="form-control">
                    <input type="text" name="description" id="descriptionInput" value="<?= $data->description ?>" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Detail</label>
                    <input type="text" name="detail" class="form-control" value="<?= $data->detail ?>">
                  </div>
                </div>
              </div>
            </div>
            <!-- End Col-->
             <!-- Col 2 -->
            <div class="col-12 col-md-4 col-lg-4">
              <div class="card">
                <div class="card-body col-md-10">
                    <div class="form-group">
                     <label>Supplier</label>
                      <input type="hidden" name="input_supplier" id="input_supplier" value="<?= $data->supplier_id ?>">
                      <select class="item_supplier form-control " id="item_supplier" name="supplier">
                      </select>
                  </div>
                  <div class="form-group">
                      <label>Start Time</label>
                      <input type="text" name ="start_time" class="form-control start_time" value="<?= $data->start_time ?>">
                  </div>
                  <div class="form-group">
                      <label>End Time</label>
                      <input type="text" name ="end_time" class="form-control end_time" value="<?= $data->end_time ?>">
                  </div>
                </div>
              </div>
            </div>
            <!-- End Col 2-->
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js" integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?=base_url()?>template/node_modules/select2/dist/js/select2.full.min.js"></script>
<script src="<?=base_url()?>template/frequently/js/taktikal_edit.js"></script>
<script src="<?=base_url()?>template/frequently/js/validation.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection() ?>