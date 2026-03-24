<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title><?= $title ?></title>
<?= $this->endSection() ?>

<?= $this->section('cssScript') ?>
<link rel="stylesheet" href="<?=base_url()?>template/node_modules/select2/dist/css/select2.min.css">
<?= $this->endSection() ?>


<?= $this->section('content') ?>
  <section class="section">
    <div class="section-header">
      <div class="section-header-back">
        <a href="<?=site_url('master/food_menu')?>" class="btn"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Bill Of Material</h1>
    </div>
    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4>Create or Update Material (<?= $food->display_name;?>)</h4>
              </div>
              <div class="card-body col-md-12">
                <form id="foodmenu_bom" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <label>Warehouse</label>
                        <input type="hidden" name="input_warehouse" id="input_warehouse">
                        <select class="warehouse form-control " id="warehouse" name="warehouse">
                        </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-4 col-lg-4">
                          <label>Item Bill Of Material</label>
                          <input type="hidden" name="input_bom" id="input_bom">
                          <select class="bom form-control " id="bom" name="bom">
                          </select>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                           <label> </label>
                          <div class="form-group">
                            <button type="button" class="add_btn btn btn-lg btn-icon icon-left btn-primary" id="add_btn"><i class="far fa-edit"></i> Add</button>
                          </div>
                        </div>
                    
                    </div>
                  <div class="row">
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-md" id="myTable">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Name</th>
                              <th>Stock</th>
                              <th>Price</th>
                              <th>Qty</th>
                              <th>Units</th>
                              <th>Total</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody id="detail_list">
                          </tbody>
                           <tfoot id="detail_foot">
                            <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th><label>Total BOM</label></th>
                              <th class="total_bomPrice" name="totalBomPrice">Rp.</th>
                              <th></th>
                            </tfoot>
                        </table>
                      </div>
                      <input type="hidden" value="<?= base_url()?>" name="baseUrl" id="baseUrl">
                      <input type="hidden" name="foodmenu_id" id="foodmenu_id" value="<?=$food->id?>">
                      <input type="hidden" name="totalBomPrice"  id="totalBomPrice">
                  </div>
                  <div>
                    <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                  </div>
                </form>
              </div>
            </div>
        </div>
      </div>
    </div>
  </section>
<?= $this->endSection() ?>

<?= $this->section('jsScript') ?>
<script src="<?=base_url()?>template/node_modules/select2/dist/js/select2.full.min.js"></script>
<script src="<?=base_url()?>template/frequently/js/foodmenu_bom.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection() ?>