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
        <a href="<?=site_url('purchase/purchaserequest')?>" class="btn"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Purchase Request</h1>
    </div>
    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4>Purchase Request</h4>
              </div>
              <div class="card-body col-md-12">
                <form id="purchaserequest_form" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row">
                      <div class="col-12 col-md-4 col-lg-4">
                        <div class="mb-3">
                          <label>Ref Code (Generate)</label>
                            <input type="text" class="form-control d-inline-block w-75" placeholder="Ref No" name="ref_code" value="<?= $generate_code ?>" id="ref_code" readonly>
                        </div>
                        <div class="form-group">
                          <label>Ref No*</label>
                          <input type="text" name="ref_no" id="ref_no" class="form-control" autocomplete="off">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 col-md-4 col-lg-4">
                          <label>Get Stock Request ID </label>
                          <input type="hidden" name="request_id" id="request_id">
                          <input type="hidden" name="now_date" id="now_date" value="<?= getDateNow() ?>">
                          <input type="text" name="raw_sr" id="raw_sr"> 
                          <select class="stock_request form-control " id="stock_request" name="stock_request">
                          </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-4 col-lg-4">
                           <label></label>
                          <div class="form-group">
                            <button type="button" class="create_btn btn btn-lg btn-icon icon-left btn-primary" id="create_btn">
                                <i class="far fa-edit"></i> Purchase Request Create</button>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-12 col-md-4 col-lg-4">
                          <label>Remark</label>
                          <textarea name="remark" id="remark" class="form-control"  rows="4" cols="50"></textarea>
                        </div>
                    </div>
                    <div class="row mt-2" style="display: none;">
                      <div class="col-12 col-md-4 col-lg-4">
                          <label>Filter Supplier </label>
                          <input type="hidden" name="input_supplier" id="input_supplier">
                          <select class="filter_supplier form-control " id="filter_supplier" name="supplier">
                          </select>
                        </div>
                    </div>
                  <div class="row">
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-md" id="myTable">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>SKU</th>
                              <th>SRLines</th>
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
                        <div class="pagination-controls float-right" style="display: none;">
                            <button type="button" class="prev_btn btn btn-sm btn-icon icon-left btn-primary" id="prev_btn">Prev</button>
                              <span id="page-info"></span>
                            <button type="button" class="next_btn btn btn-sm btn-icon icon-left btn-primary" id="next_btn">Next</button>
                        </div>
                      </div>
                      <input type="hidden" value="<?= base_url()?>" name="baseUrl" id="baseUrl">
                  </div>
                  <div>
                    <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Submit</button>
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
<script src="<?=base_url()?>template/frequently/js/purchaserequest_create.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection() ?>