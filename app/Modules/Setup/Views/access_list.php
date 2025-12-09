<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Title | Access</title>
<?= $this->endSection() ?>

<?= $this->section('cssScript') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="section">
      <div class="section-header">
          <h1>List Access</h1>
          <div class="section-header-button">
              <a href="<?=site_url('settings/accessmenu/create')?>" class="btn btn-primary">Add New</a>
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
                      <!-- Button Export -->
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
                  <th>Module</th>
                  <th>Function</th>
                  <th>Label</th>
                  <th>Parent Id</th>
                  <th>Main Module</th>
                  <th>URLs</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $no = 1 + (10 * ($page - 1));
                foreach ($access as $key => $value) : ?>
                  <tr>
                    <td><?=$no++?></td>
                    <td><?=content_wrap($value['module_name'],20)?></td>
                    <td><?=content_wrap($value['function_name'],20)?></td>
                    <td><?=content_wrap($value['label_name'],30)?></td>
                    <td><?=$value['parent_id']?></td>
                    <td><?=$value['main_module_id']?></td>
                    <td><?=content_wrap($value['url'],100)?></td>
                    <td class="text-center" style="width:15%">
                        <a href="<?=site_url('settings/accessmenu/edit/'.$value['id'])?>" class="btn btn-warning btn-sm" title="Permissions"><i class="fas fa-pencil-alt"></i></a>
                        <form action="<?=site_url('category/delete/'.$value['id'])?>" method="post" class="d-inline" id="del-<?=$value['id']?>" title="Delete">
                          <?= csrf_field() ?>
                          <button class="btn btn-danger btn-sm" data-confirm="Hapus Data?|Apakah Anda yakin?" data-confirm-yes="submitDel(<?=$value['id']?>)">
                            <i class="fas fa-trash"></i>
                          </button>
                        </form>
                    </td>
                   
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <div class="float-left">
              <i>Showing <?=empty($category) ? 0 : 1 + (10 * ($page - 1))?> to <?=$no-1?> of <?=$pager->getTotal()?> entries</i>
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