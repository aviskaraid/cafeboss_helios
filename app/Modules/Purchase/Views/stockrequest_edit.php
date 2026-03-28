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
        <a href="<?=site_url('purchase/stockrequest')?>" class="btn"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Stock Request</h1>
    </div>
    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4>Stock Request</h4>
              </div>
              <div class="card-body col-md-12">
                <form id="stockrequest_form_changes" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row mb-2">
                        <div class="col-12 col-md-4 col-lg-4">
                          <label>Ref Code</label>
                          <input type="hidden" name="transaction_id" id="transaction_id" value="<?= $data->id ?>">
                          <input type="text" class="form-control" placeholder="Ref Code" name="ref_code" value="<?= $data->ref_code?>" id="ref_code" readonly>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 col-md-4 col-lg-4">
                          <label>Ref No</label>
                          <input type="text" class="form-control" placeholder="Ref No" name="ref_no" value="<?= $data->ref_no?>" id="ref_no">
                        </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-12 col-md-4 col-lg-4">
                          <label>Department</label>
                          <input type="hidden" name="input_department" id="input_department" value="<?= $data->department_id ?>">
                          <input type="hidden" name="now_date" id="now_date" value="<?= getDateNow() ?>">
                          <select class="department form-control " id="department" name="department">
                          </select>
                        </div>
                    </div>
                    <div class="row ">
                      <div class="col-12 col-md-4 col-lg-4">
                          <label>Remark</label>
                          <textarea name="remark" id="remark" class="form-control"  rows="4" cols="50" placeholder="Remark"><?= $data->remark ?></textarea>
                        </div>
                    </div>
                  <div class="row">
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
                              <th>Request Qty</th>
                              <th>Units</th>
                              <th>Date</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody id="detail_list">
                          </tbody>
                        </table>
                        <div class="pagination-controls float-right " style="display: none;">
                            <button type="button" class="prev_btn btn btn-sm btn-icon icon-left btn-primary" id="prev_btn">Prev</button>
                              <span id="page-info"></span>
                            <button type="button" class="next_btn btn btn-sm btn-icon icon-left btn-primary" id="next_btn">Next</button>
                        </div>
                      </div>
                      <input type="hidden" value="<?= base_url()?>" name="baseUrl" id="baseUrl">
                       <input type="hidden" value="<?= $data->status?>" name="satus" id="status">
                        <input type="hidden" value="<?= $data->pr_selected?>" name="pr_selected" id="pr_selected">
                  </div>
                  <div>
                    <button type="submit" class="btn btn-success" id="btn_submit"><i class="fas fa-paper-plane"></i> Submit</button>
                    <button type="reset" class="btn btn-secondary" id="btn_reset">Reset</button>
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
<script src="<?=base_url()?>template/frequently/js/stockrequest_edit.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection() ?>