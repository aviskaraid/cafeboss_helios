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
.card-disabled {
  /* Apply desired disabled styles (e.g., greyed out, less opacity) */
  opacity: 0.5;
  pointer-events: none; /* Prevents clicks/interactions on the card and its children */
  cursor: not-allowed;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
  <section class="section">
    <div class="section-header">
       <div class="section-header-back">
        <a href="<?=site_url('purchase/purchaseorder')?>" class="btn"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1><?= $title ?></h1>
    </div>
    <section class="section">
      <form id="purchaseorder_form">
        <div class="section-body">
          <div class="row">
            <!-- Col -->
            <div class="col-12 col-md-5 col-lg-5">
              <div class="card">
                <div class="card-body col-md-10">
                   <div class="mb-3">
                     <label>Ref Code (Generate)</label>
                      <input type="text" class="form-control d-inline-block w-75" placeholder="Ref Code" name="ref_code" value="<?= $generate_code ?>" id="ref_code" readonly>
                      <button type="button" class="btn btn-primary d-inline-block" id="btnGenerateCode">Generate</button>
                  </div>  
                  <div class="form-group">
                    <label>Ref No*</label>
                    <input type="text" name="ref_no" id="ref_no" class="form-control" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label>Get Purchase Order </label>
                    <input type="text" name="po_id" id="po_id">
                    <input type="hidden" name="now_date" id="now_date" value="<?= getDateNow() ?>">
                    <input type="text" name="raw_po" id="raw_po">
                    <select class="purchase_order form-control " id="purchase_order" name="purchase_order">
                    </select>
                  </div>
                   <div class="form-group">
                      <button type="button" class="create_btn btn btn-lg btn-icon icon-left btn-primary" id="create_btn">
                          <i class="far fa-edit"></i> Receive Create</button>
                    </div>
                </div>
              </div>
            </div>
            <!-- End Col-->
             <!-- Col 2 -->
            <div class="col-12 col-md-4 col-lg-4">
              <div class="card">
                <div class="card-body col-md-10" id="form_gudang">
                    <div class="form-group">
                        <label>Gudang Tujuan </label>
                        <input type="hidden" name="input_gudang" id="input_gudang">
                        <select class="filter_gudang form-control " id="filter_gudang" name="gudang">
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Transaction Date</label>
                        <input type="text" name="transaction_date" id="transaction_date" class="transaction_date form-control" value="<?= $transaction_date ?>">
                    </div>
                </div>
              </div>
            </div>
            <!-- End Col 2-->
          </div>
          <!-- Table -->
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-body table-responsive">
                  <table class="table table-striped table-md" id="myTable">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>SKU</th>
                        <th>Warehouse</th>
                        <th>Item</th>
                        <th>Par Stock</th>
                        <th>SOH</th>
                        <th>Request</th>
                        <th>Received</th>
                        <th>Units</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody id="detail_list">
                    </tbody>
                  </table>
                  <div class="pagination-controls float-right" style="display: none;">
                      <button type="button" class="prev_btn btn btn-sm btn-icon icon-left btn-primary" id="prev_btn">Prev</button>
                        <span id="page-info"></span>
                      <button type="button" class="next_btn btn btn-sm btn-icon icon-left btn-primary" id="next_btn">Next</button>
                  </div>
                </div>
              </div>
            </div>
            <input type="hidden" value="<?= base_url()?>" name="baseUrl" id="baseUrl">
          </div>
          <!-- Table -->
          <!-- Col Pay -->
          
          <div class="row payment">
            <div class="col-12 col-md-6 col-lg-6" style="justify-content: left;">
                <div class="card">
                  <div class="card-body col-md-10" id="form_remark">
                    <div class="form-group">
                      <label>Catatan Tambahan</label>
                      <textarea id="remark" name="remark" class="remark form-control" placeholder="Catatan" rows="5"></textarea>
                    </div>
                  </div>
                  
                </div>
              </div>
          </div>
        <!-- End Col Pay-->
        <div class="row" style="text-align:left;">
          <div class="col-12 col-md-12 col-lg-12">
            <div class="form-group">
              <label></label>
              <span></span>
              <button type="submit"  id="btnSave"  class="btn btn-lg btn-success"><i class="fas fa-paper-plane"></i> Submit</button>
              <!-- <button type="reset" class="btn btn-lg btn-secondary">Reset</button> -->
            </div>
          </div>
        </div>
      </form>
  </section>
<?= $this->endSection() ?>

<?= $this->section('jsScript') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js" integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?=base_url()?>template/node_modules/select2/dist/js/select2.full.min.js"></script>
<script src="<?=base_url()?>template/frequently/js/goodreceive_create.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection() ?>