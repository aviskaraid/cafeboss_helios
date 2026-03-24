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
        <a href="<?=site_url('master/stores')?>" class="btn"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Create <?= $title ?></h1>
    </div>
    <section class="section">
      <form id="stores_edit">
        <div class="section-body">
          <div class="row">
            <!-- Col -->
            <div class="col-12 col-md-6 col-lg-6">
              <div class="card card-primary">
                <div class="card-body col-md-10">
                   <div class="mb-3">
                     <label>Item Code (Generate)</label>
                     <input type="hidden" id="store_id" name="store_id" value="<?= $store->id ?>">
                      <input type="text" class="form-control d-inline-block w-75" placeholder="Item Code" name="code" value="<?= $store->code ?>" id="items_code" readonly>
                  </div>
                  <div class="form-group">
                    <label>Name*</label>
                    <input type="text" name="name" id="nameInput" value="<?= $store->name ?>" class="form-control" onchange="validateNameInput()" autocomplete="off">
                    <input type="hidden" id="nameStatus" value="1">
                      <span id="nameFeedback" class="error-message"></span>
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <input type="text" name="description" id="descriptionInput" value="<?= $store->description ?>" onchange="validateDescInput()" class="form-control">
                    <input type="hidden" id="descriptionStatus" value="1">
                    <span id="descriptionFeedback" class="error-message"></span>
                  </div>
                  <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control" value="<?= $store->address ?>">
                  </div>
                  <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location" class="form-control" value="<?= $store->location ?>">
                  </div>
                  <div class="form-group">
                    <label>Remark</label>
                    <input type="text" name="remark" class="form-control" value="<?= $store->remark ?>">
                  </div>
                </div>
              </div>
            </div>
            <!-- End Col-->

             <!-- Col -->
            <div class="col-12 col-md-6 col-lg-6">
              <div class="card card-success">
                <div class="card-body col-md-10">
                  <div class="form-group">
                     <label>Include Category (POS)</label>
                      <input type="hidden" name="input_category" id="input_category">
                      <select class="item_category form-control " id="item_category" name="category[]">
                      </select>
                  </div>
                </div>
              </div>
               <div class="card card-info">
                <div class="card-header">
                  <h5>Setup</h5>
                </div>
                <div class="card-body col-md-12">
                   <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <label>Minimum Charge Default (0%)</label>
                        <input type="number" name="minimum_charge" id="minimum_chargeInput" value="<?= number_format($setup->minimum_charge,0) ?>"  step="2" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 col-md-4 col-lg-4">
                      <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="dp" class="custom-control-input" id="dp" <?php if ($setup->dp == 1){?> checked="checked" <?php } ?>>
                            <label class="custom-control-label" for="dp">DP</label>
                          </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                      <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="void" class="custom-control-input" id="void" <?php if ($setup->void == 1){?> checked="checked" <?php } ?>>
                            <label class="custom-control-label" for="void">Void</label>
                          </div>
                      </div>
                    </div>
                     <div class="col-12 col-md-4 col-lg-4">
                      <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="lock_close" class="custom-control-input" id="lock_close" title="tidak bisa close dibawah minimum charge" <?php if ($setup->lock_close == 1){?> checked="checked" <?php } ?>>
                            <label class="custom-control-label" for="lock_close">CloseByMC</label>
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 col-md-4 col-lg-4">
                      <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="merge_bill" class="custom-control-input" id="merge_bill" <?php if ($setup->merge_bill == 1){?> checked="checked" <?php } ?>>
                            <label class="custom-control-label" for="merge_bill">Merge Bill</label>
                          </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                      <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="split_bill" class="custom-control-input" id="split_bill" <?php if ($setup->split_bill == 1){?> checked="checked" <?php } ?>>
                            <label class="custom-control-label" for="split_bill">Split Bill</label>
                          </div>
                      </div>
                    </div>
                     <div class="col-12 col-md-4 col-lg-4">
                      <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="take_away" class="custom-control-input" id="take_away" <?php if ($setup->take_away == 1){?> checked="checked" <?php } ?>>
                            <label class="custom-control-label" for="take_away">Take Away</label>
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 col-md-4 col-lg-4">
                      <div class="form-group">
                        <label>Vat (Default0%)</label>
                        <input type="number" name="vat" id="vat" value="<?= number_format($setup->vat,0) ?>"  step="2" class="form-control">
                      </div>
                    </div>
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
<script src="<?=base_url()?>template/frequently/js/store_edit.js"></script>
<script src="<?=base_url()?>template/frequently/js/validation.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection() ?>