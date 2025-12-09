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
      <h1><?= $title ?></h1>
    </div>
    <section class="section">
      <form id="items_create">
        <div class="section-body">
          <div class="row">
            <!-- Col -->
            <div class="col-12 col-md-5 col-lg-5">
              <div class="card">
                <div class="card-body col-md-10">
                   <div class="mb-3">
                     <label>Item Code (Generate)</label>
                      <input type="text" class="form-control d-inline-block w-75" placeholder="Item Code" name="code" value="<?= $generate_code ?>" id="items_code" readonly>
                      <button class="btn btn-primary d-inline-block" id="btnGenerateCode">Generate</button>
                  </div>  
                  <div class="form-group">
                    <label>Name*</label>
                    <input type="text" name="name" id="nameInput" class="form-control" autocomplete="off">
                    <input type="hidden" id="nameStatus" value="0">
                    <span id="nameFeedback" class="error-message"></span>
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <input type="text" name="description" id="descriptionInput" class="form-control">
                    <input type="hidden" id="descriptionStatus" value="0">
                    <span id="descriptionFeedback" class="error-message"></span>
                  </div>
                  <div class="form-group">
                    <label>SKU</label>
                    <input type="text" name="sku" id="skuInput" class="form-control">
                  </div>
                  <div class="form-group">
                    <label><b>Display Name</b></label>
                    <input type="text" name="display_name" id="displaynameInput" class="form-control">
                  </div>
                  <div class="row">
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label></label>
                            <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="enable_stock" class="custom-control-input" id="enable_stock">
                              <label class="custom-control-label" for="enable_stock">Enable Stock</label>
                            </div>
                        </div>
                      </div>
                      <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label></label>
                            <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="premade" class="custom-control-input" id="premade">
                              <label class="custom-control-label" for="premade">Item WIP</label>
                            </div>
                        </div>
                      </div>
                      <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group">
                           <label></label>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="ingredient" class="custom-control-input" id="ingredient">
                              <label class="custom-control-label" for="ingredient">Ingredient</label>
                            </div>
                        </div>
                      </div>
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
                      <label>Category</label>
                      <input type="hidden" name="category_id" id="input_item_category">
                      <select class="item_category form-control " id="item_category">
                      </select>
                    </div>
                  <div class="form-group">
                      <label>Main Units</label>
                        <input type="hidden" name="main_unit" id="input_main_unit">
                        <select class="item_units form-control " id="item_units">
                      </select>
                  </div>
                  <div class="form-group">
                      <label>Purchase Units</label>
                        <input type="hidden" name="purchase_unit" id="input_purchase_unit">
                        <select class="item_units_purchase form-control " id="item_units_purchase">
                      </select>
                  </div>
                  <div class="form-group">
                      <label>Alert Min Qty</label>
                            <input type="number" name="alert_qty" min="0" max="99999" value="0" class="form-control">
                  </div>
                  <div class="form-group">
                      <label>Warehouse</label>
                      <input type="hidden" name="input_warehouse" id="input_warehouse">
                      <select class="warehouse form-control " id="warehouse" name="warehouse[]" multiple="multiple">
                      </select>
                  </div>
                   <div class="form-group">
                      <label>Sell Price</label>
                      <input type="text" name="sell_price" id="sell_price" class="form-control">
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
<script src="<?=base_url()?>template/node_modules/select2/dist/js/select2.full.min.js"></script>
<script src="<?=base_url()?>template/frequently/js/items_create.js"></script>
<script src="<?=base_url()?>template/frequently/js/validation.js"></script>
<script src="<?=base_url()?>template/frequently/js/currency.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection() ?>