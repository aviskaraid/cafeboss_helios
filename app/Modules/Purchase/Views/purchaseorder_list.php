<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Title | <?=$title ?></title>
<?= $this->endSection() ?>

<?= $this->section('cssScript') ?>
<style>.disabled {
  pointer-events: none;
  cursor: default;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="section">
      <div class="section-header">
          <h1><?= $title ?></h1>
          <div class="section-header-button">
              <a href="<?=site_url('purchase/purchaseorder/create')?>" class="btn btn-primary">Add New</a>
          </div>
      </div>
      <?= $this->include('layout/alert') ?>
      <div class="section-body">
        <h5>Filter</h5>
        <div class="card card-primary">  
          <form action="" method="get" autocomplete="off">
            <div class="card-body">
              <div class="row">
                  <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="float-left">
                      <?php
                        $request = \Config\Services::request();
                        $keyword = $request->getGet('keyword');
                        if($keyword != '') {
                          $param = "?keyword=".$keyword;
                        } else {
                          $param = "";
                        }
                      ?>
                      <!-- button export -->
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="float-right">
                      <div class="d-flex form-group m-0">
                        <input type="hidden" id="total_data" value="<?= count($purchaseorder)?>">
                        <input type="text" name="keyword" class="form-control form-control-sm" value="<?=$request->getGet('keyword')?>" placeholder="Name or Description Find ">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </form>
        </div>
        <div class="card card-info">
          <div class="card-body table-responsive">
            <table class="table table-striped table-md">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Date</th>
                  <th>Ref</th>
                  <th>Requester</th>
                  <th>Approval</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $no = 1 + (10 * ($page - 1));
                foreach ($purchaseorder as $key => $value) : ?>
                  <tr>
                    <td><?=$no++?></td>
                    <td style="width:13%"><?=content_wrap($value['transaction_date'],14)?></td>
                    <td style="width: 12%;"><a href="<?=site_url('purchase/purchaseorder/'.$value['id'])?>" title="Edit Data" class="font-weight-bold"><?=content_wrap($value['ref_code'],20)?> || <?=content_wrap($value['ref_no'],20)?></td>
                    <td><?=content_wrap($value['requester_name'],20)?></td>
                     <td> <?= ($value['approval_name'] != null) ? content_wrap($value['approval_name'],20) : ''?>
                    </td>
                    <td>
                     <?php if ($value['status'] =='New' or $value['status'] =='Pending'): ?>
                      <button class="btn btn-outline-success" id="no_cursor"><?= $value['status'] ?></button>
                      <?php elseif ($value['status'] =='Processing'): ?>
                        <button class="btn btn-outline-danger"><i class="fas fa-refresh"></i> Proses</a></button>
                      <?php elseif ($value['status'] =='Canceled'): ?>
                        <button class="btn btn-outline-danger"><i class="fas fa-cross"></i> Cancel</a></button>
                      <?php else:?>
                          <button class="btn btn-outline-info" id="no_cursor"><i class="fas fa-check"></i> Approved</span></button>
                      <?php endif; ?>  
                      </td>
                    <td>
                      <?php if ($value['status'] =='New' or $value['status'] =='Pending'): ?>
                        <button class ="btn btn-md btn-outline-warning text-warning" id="btn_pending" data-id="<?= $value['id'] ?>"data-refno="<?= $value['ref_no'] ?>">Pending</button>
                        <button class ="btn btn-md btn-outline-primary text-dark" id="btn_approved" data-id="<?= $value['id'] ?>"data-refno="<?= $value['ref_no'] ?>">Approve</button>
                        <button class ="btn btn-md btn-outline-danger text-danger" id="btn_declined" data-id="<?= $value['id'] ?>"data-refno="<?= $value['ref_no'] ?>">Declined</button>
                       <?php elseif ($value['status'] =='Processing'): ?>
                        <span class="badge bg-danger text-white"><i class="fas fa-trash"></i> Proses</a>
                      <?php elseif ($value['status'] =='Canceled'): ?>
                        <span class="badge bg-danger text-white"><i class="fas fa-ban"></i> Canceled</a>
                      <?php elseif ($value['status'] =='Approved'): ?>
                        <span class="badge bg-primary text-white"><i class="fas fa-check"></i> Approved</a>
                      <?php else:?>
                        <span class="badge bg-info text-white"><i class="fas fa-box"></i> Good Receive</a>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <div class="float-left">
              <i>Showing <?=empty($purchaseorder) ? 0 : 1 + (10 * ($page - 1))?> to <?=$no-1?> of <?=$pager->getTotal()?> entries</i>
            </div>
            <div class="float-right">
              <?= $pager->links('default', 'pagination') ?>
            </div>
          </div>
        </div>
      </div>
    </section>
<?= $this->endSection() ?>

<?= $this->section('jsScript') ?>
<script src="<?=base_url()?>template/frequently/js/purchaseorder.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection() ?>