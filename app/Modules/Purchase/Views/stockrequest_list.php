<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Title | <?=$title ?></title>
<?= $this->endSection() ?>

<?= $this->section('cssScript') ?>
<style>.disabled {
  pointer-events: none;
  cursor: default;
}</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="section">
      <div class="section-header">
          <h1><?= $title ?></h1>
          <div class="section-header-button">
              <a href="<?=site_url('purchase/stockrequest/create')?>" class="btn btn-primary">Add New</a>
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
                  <th>Ref No</th>
                  <th>Requester</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $no = 1 + (10 * ($page - 1));
                foreach ($stockrequest as $key => $value) : ?>
                  <tr>
                    <td><?=$no++?></td>
                    <td style="width:15%"><?=content_wrap($value['transaction_date'],14)?></td>
                    <td style="width: 12%;"><a href="<?=site_url('purchase/stockrequest/'.$value['id'])?>" title="Edit Data" class="font-weight-bold"><?=content_wrap($value['ref_no'],20)?></td>
                    <td><?=content_wrap($value['requester_name'],20)?></td>
                    <td>
                     <?php if ($value['status'] =='request'): ?>
                      <button class="btn btn-outline-warning">Request</button>
                      <?php else: ?>
                          <button class="btn btn-outline-info"><i class="fas fa-check"></i> Approved</span>
                      <?php endif; ?>  
                    <td>
                      <?php if ($value['status'] =='request'): ?>
                        <button class ="btn btn-md btn-outline-primary text-dark" id="btn_approved" data-id="<?= $value['id'] ?>"data-refno="<?= $value['ref_no'] ?>">Approve</button>
                        <button class ="btn btn-md btn-outline-danger text-danger" id="btn_declined" data-id="<?= $value['id'] ?>"data-refno="<?= $value['ref_no'] ?>">Declined</button>
                       <?php elseif ($value['status'] =='deleted'): ?>
                        <span class="badge bg-danger text-white"><i class="fas fa-trash"></i> Deleted</a>
                      <?php elseif ($value['status'] =='declined'): ?>
                        <span class="badge bg-danger text-white"><i class="fas fa-ban"></i> Declined</a>
                      <?php else:?>
                        <span class="badge bg-info text-white"><i class="fas fa-check"></i> Purchase Request</a>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <div class="float-left">
              <i>Showing <?=empty($stockrequest) ? 0 : 1 + (10 * ($page - 1))?> to <?=$no-1?> of <?=$pager->getTotal()?> entries</i>
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
<script src="<?=base_url()?>template/frequently/js/stockrequest.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection() ?>