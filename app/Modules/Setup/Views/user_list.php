<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Title | <?= $title ?></title>
<?= $this->endSection() ?>

<?= $this->section('cssScript') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="section">
      <div class="section-header">
          <h1><?= $title ?></h1>
          <div class="section-header-button">
              <a href="<?=site_url('settings/users/create')?>" class="btn btn-primary">Add New</a>
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
                  <th></th>
                  <th>code</th>
                  <th>Username</th>
                  <th>Picture</th>
                  <th>Email</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $no = 1 + (10 * ($page - 1));
                foreach ($users as $key => $value) : ?>
                  <tr>
                    <td><?=$no++?></td>
                    <td>
                      <div class="dropdown d-inline">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-eye"></i> Action
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item has-icon upload_Image" data-target="#uploadImage" data-toggle="modal"  href="#uploadImage"
                            data-id="<?= $value['id'] ?>">
                            <i class="fas fa-eye"></i> Upload Image
                          </a>
                          <a href="<?=site_url('user/editpermissions/'.$value['id'])?>" class="dropdown-item has-icon" title="Permissions"><i class="fas fa-shield-alt"></i> Set Permissions</a>
                          <a href="<?=site_url('user/edit/'.$value['id'])?>" class="dropdown-item has-icon" title="Edit"><i class="fas fa-pencil-alt"></i>Edit</a>
                          <form action="<?=site_url('user/delete/'.$value['id'])?>" method="post" class="d-inline" id="del-<?=$value['id']?>" title="Delete">
                            <?= csrf_field() ?>
                            <button class="dropdown-item has-icon" data-confirm="Hapus Data?|Apakah Anda yakin?" data-confirm-yes="submitDel(<?=$value['id']?>)">
                              <i class="fas fa-trash"></i>Delete
                            </button>
                          </form>
                        </div>
                      </div>
                      </td>
                    <td><?=content_wrap($value['code'],20)?></td>
                    <td><?=content_wrap($value['username'],20)?></td>
                    <td>
                    <?php $imageUrl = (($value['picture']==null))?"uploads/noImage.png":$value['picture']?>
                    <img src="<?=base_url($imageUrl); ?>"style="height: 50px; width:40%; object-fit: fill;"></td>
                    <td><?=content_wrap($value['email'],100)?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <div class="float-left">
              <i>Showing <?=empty($users) ? 0 : 1 + (10 * ($page - 1))?> to <?=$no-1?> of <?=$pager->getTotal()?> entries</i>
            </div>
            <div class="float-right">
              <?= $pager->links('default', 'pagination') ?>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Bootstrap Modal Structure -->
  <div class="modal fade" id="uploadImage" tabindex="-1" role="dialog" aria-labelledby="uploadImageLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="uploadImageLabel">Upload Image</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="message"></div>
          <form id="fileUploadForm" enctype="multipart/form-data">
            <div class="mb-3">
              <input type="hidden" class="form-control" id="user_id" name="user_id">
              <label for="imageToUpload" class="form-label">Select Picture:</label>
              <input type="file" class="form-control" id="imageToUpload" name="imageToUpload">
            </div>
            <button type="submit" class="btn btn-success" id="submit_btn">Upload</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<?= $this->endSection() ?>

<?= $this->section('jsScript') ?>
<script src="<?=base_url()?>template/frequently/js/user_view.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection() ?>