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
<?php $json_data = json_encode($data)?>
  <section class="section">
    <div class="section-header">
       <div class="section-header-back">
        <a href="<?=site_url('purchase/purchaseorder')?>" class="btn"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1><?= $title ?></h1>
    </div>
    <section class="section">
      <form id="purchaseorder_form_edit">
        <div class="section-body">
          <div class="row">
            <!-- Col -->
            <div class="col-12 col-md-5 col-lg-5">
              <div class="card">
                <div class="card-body col-md-10">
                   <div class="mb-3">
                     <label>Ref Code</label>
                      <input type="text" name="transaction_id" id="transaction_id" value="<?= $data->id ?>">
                      <input type="text" class="form-control" placeholder="Ref Code" name="ref_code" value="<?= $data->ref_code?>" id="ref_code" readonly>
                  </div>  
                  <div class="form-group">
                    <label>Ref No*</label>
                    <input type="text" name="ref_no" id="ref_no" class="form-control" autocomplete="off" value="<?= $data->ref_no ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label>Purchase Request No </label>
                    <input type="text" name="pr_id" id="pr_id" value="<?= $data->pr_id ?>">
                    <input type="text" name="now_date" id="now_date" value="<?= getDateNow() ?>" readonly>
                    <input type="text" name="raw_pr" id="raw_pr" value="<?= $data->raw_pr ?>">
                      <input type="text" name="purchase_request_no" id="purchase_request_no" class="form-control" autocomplete="off" value="<?= $data->pr_no?>" readonly>
                  </div>
                   <div class="form-group" style="display: none;">
                      <button type="button" class="create_btn btn btn-lg btn-icon icon-left btn-primary" id="create_btn">
                          <i class="far fa-edit"></i> Purchase Order Create</button>
                    </div>
                </div>
              </div>
            </div>
            <!-- End Col-->
             <!-- Col 2 -->
            <div class="col-12 col-md-4 col-lg-4">
              <div class="card">
                <div class="card-body col-md-10" id="form_supplier">
                    <div class="form-group">
                        <label>Filter Supplier </label>
                        <input type="text" name="input_supplier" id="input_supplier">
                        <select class="filter_supplier form-control " id="filter_supplier" name="supplier">
                        </select>
                    </div>
                    <div class="form-group mt-4">
                        <label>Supplier Address </label>
                        <textarea id="input_supplier_address" name="input_supplier_address" class="input_supplier_address form-control" placeholder="Supplier Address"></textarea>
                    </div>
                    <div class="form-group">
                      <div class="control-label">Taktikal</div>
                      <input type="text" id="taktikal_status" name="taktikal_status">
                      <div class="custom-switches-stacked mt-2">
                        <div class="row">
                          <label class="custom-switch col-12 col-md-6 col-lg-6">
                            <input type="radio" name="taktikal" value="0" class="custom-switch-input" id="taktikal_off" checked>
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Reguler</span>
                          </label>
                          <label class="custom-switch col-12 col-md-6 col-lg-6">
                            <input type="radio" name="taktikal" value="1" class="custom-switch-input" id="taktikal_on">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Taktikal</span>
                          </label>
                        </div>
                      </div>
                    </div>
                     <div class="form-group">
                        <label>Taktikal Contract Number </label>
                        <input type="text" name="input_taktikal_contract" id="input_taktikal_contract" value="0">
                        <select class="filter_taktikal form-control " id="filter_taktikal" name="taktikal">
                        </select>
                    </div>
                </div>
              </div>
            </div>
            <!-- End Col 2-->
            <!-- Col 3 -->
            <div class="col-12 col-md-3 col-lg-3">
              <div class="card">
                <div class="card-body col-md-10" id="form_date">
                    <div class="form-group">
                        <label>Transaction Date</label>
                        <input type="text" name="transaction_date" id="transaction_date" class="transcation_date form-control" value="<?= $data->transaction_date ?>">
                    </div>
                    <div class="form-group">
                        <label>Due Date</label>
                        <input type="text" name="due_date" id="due_date" class="due_date form-control" placeholder="yyyy-mm-dd">
                    </div>
                    <div class="form-group">
                        <label>Delivery Date</label>
                        <input type="text" name="delivery_date" id="delivery_date" class="delivery_date form-control" placeholder="yyyy-mm-dd">
                    </div>
                </div>
              </div>
            </div>
            <!-- End Col 3-->
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
                        <th>Price</th>
                        <th>Request Qty</th>
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
            <input type="text" value="<?= base_url()?>" name="baseUrl" id="baseUrl">
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
                    <div class="form-group">
                      <label>Catatan Pengiriman</label>
                      <textarea id="remark_delivery" name="remark_delivery" class="remark_delivery form-control" placeholder="Catatan Pengiriman" rows="5"></textarea>
                    </div>
                  </div>
                  
                </div>
              </div>  
            <div class="col-12 col-md-6 col-lg-6" style="justify-content: right;">
                <div class="card">
                  <div class="card-body col-md-10" id="form_payment">
                    <div class="row form-group mt-4" style="display: flex;justify-content: center;align-items: center;">
                      <div class="col-12 col-md-4 col-lg-4">
                        <label><b>SubTotal</b></label>
                      </div>
                        <div class="col-12 col-md-8 col-lg-8" style="justify-content: right;">
                          <input type="text" name="sub_total" id="sub_total">
                          <input type="text" name="sub_total_view" id="sub_total_view" class="form-control" style="text-align: right;" value="0" readonly>
                      </div>
                    </div>
                    <div class="row form-group mt-4" style="display: flex;justify-content: center;align-items: center;">
                      <div class="col-12 col-md-4 col-lg-4">
                        <label><b>Disc</b> Rp.</label>
                      </div>
                        <div class="col-12 col-md-8 col-lg-8" style="justify-content: right;">
                          <input type="text" name="discount" id="discount">
                          <input type="text" name="discount_view" id="discount_view" class="form-control" style="text-align: right;" value="0">
                      </div>
                    </div>
                    <div class="row form-group mt-4" style="display: flex;justify-content: center;align-items: center;">
                      <div class="col-12 col-md-4 col-lg-4">
                        <label><b>Biaya Pengiriman</b> Rp.</label>
                      </div>
                        <div class="col-12 col-md-8 col-lg-8" style="justify-content: right;">
                          <input type="text" name="delivery_charge" id="delivery_charge" value="0">
                          <input type="text" name="delivery_charge_view" id="delivery_charge_view" class="form-control" style="text-align: right;" value="0">
                      </div>
                    </div>
                     <div class="row form-group mt-4" style="display: flex;justify-content: center;align-items: center;">
                      <div class="col-12 col-md-8 col-lg-8">
                        <label><b>Vat %</b></label>
                      </div>
                        <div class="col-12 col-md-4 col-lg-4" style="justify-content: right;">
                          <input type="text" name="vat" id="vat" class="form-control" style="text-align: right;" value="0" maxlength="3">
                      </div>
                    </div>
                     <div class="row form-group mt-4" style="display: flex;justify-content: center;align-items: center;">
                      <div class="col-12 col-md-4 col-lg-4">
                        <label class="fs-4 font-weight-bold"><b>Total</b> .Rp</label>
                      </div>
                        <div class="col-12 col-md-8 col-lg-8" style="justify-content: right;">
                          <input type="text" name="total" id="total"/> 
                          <input type="text" name="total_view" id="total_view" class="form-control fs-4 font-weight-bold" style="text-align: right;" value="0" readonly>
                      </div>
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
              <button type="submit" id="btnSave"  class="btn btn-lg btn-success"><i class="fas fa-paper-plane"></i> Submit</button>
              <!-- <button type="reset" class="btn btn-lg btn-secondary">Reset</button> -->
            </div>
          </div>
        </div>
      </form>
  </section>
<?= $this->endSection() ?>

<?= $this->section('jsScript') ?>
<script>
    var userData = <?php echo $json_data; ?>;
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js" integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?=base_url()?>template/node_modules/select2/dist/js/select2.full.min.js"></script>
<script src="<?=base_url()?>template/frequently/js/purchaseorder_edit.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection() ?>