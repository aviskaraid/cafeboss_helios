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
                  <th>Description</th>
                  <th>Remark</th>
                  <th>Employee</th>
                  <th>Total</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $no = 1 + (10 * ($page - 1));
                foreach ($rndlist as $key => $value) : ?>
                  <tr>
                    <td><?=$no++?></td>
                    <td><a href="<?=site_url('rnd/edit/'.$value['id'])?>"><?=content_wrap($value['description'],20)?></a></td>
                    <td><?=content_wrap($value['remark'],20)?></td>
                    <td><?=content_wrap($value['employee_name'],20)?></td>
                    <td><?= number_format($value['total'],2,",",".") ?></td>
                    <td class="text-center" style="width:10%">
                      <!-- <a href="<?=site_url('rnd/edit/'.$value['id'])?>" class="btn btn-warning btn-sm" title="Setup Units"><i class="fas fa-pencil-alt"></i>Setup Units</a> -->
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <div class="float-left">
              <i>Showing <?=empty($rndlist) ? 0 : 1 + (10 * ($page - 1))?> to <?=$no-1?> of <?=$pager->getTotal()?> entries</i>
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
<?= $this->endSection() ?>