<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title><?= $title ?></title>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
    <section class="section">
      <div class="section-header">
          <h1><?= $module ?> <?= $title ?></h1>
      </div>
      <?= $this->include('layout/alert') ?>
      <div class="section-body">
        <div class="row">
          <div class="col-12 col-sm-12 col-lg-12">
            <div class="card">
              <div class="card-body">
                <?php $errors = session()->getFlashdata('errors'); ?>
                  <form method="POST" action="<?=site_url('settings/apps/save_process')?>" enctype="multipart/form-data"  method="post" autocomplete="off">
                    <?= csrf_field() ?>
                <div class="row">
                  <div class="col-12 col-md-4 col-lg-4">
                    <div class="form-group">
                      <label>Name of Application *</label>
                      <input type="text" name="name" value="<?=old('name',$data->name)?>" class="form-control">
                    </div>
                  </div>
                  <div class="col-12 col-md-4 col-lg-4">
                    <div class="form-group">
                      <label>Description</label>
                      <input type="text" name="description" value="<?=old('description',$data->description)?>" class="form-control">
                    </div>
                  </div>
                  <div class="col-12 col-md-4 col-lg-4">
                    <div class="form-group">
                      <label>Website</label>
                      <input type="text" name="website" value="<?=old('website',$data->website)?>" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-md-4 col-lg-4">
                    <label>Image Thumbnail</label>
                    <div class="form-group">
                      <?php $imageUrl = (($data->img_thumbnails==null))?"/images/noImage.png":$data->img_thumbnails?>
                         <img src="<?= base_url($imageUrl) ?>" class="img-thumbnail"  width="200" height="200">
                      <div class="custom-file">
                        <input type="file" name="image_thumbnail" class="custom-file-input" id="image_thumbnail">
                        <label class="custom-file-label">Choose File</label>
                      </div>
                      <div class="form-text text-muted">The image must have a maximum size of 2MB</div>
                    </div>
                  </div>
                  <div class="col-12 col-md-4 col-lg-4">
                    <label>Image Display</label>
                    <div class="form-group">
                      <?php $imageUrl = (($data->img_profile==null))?"/images/noImage.png":$data->img_profile?>
                         <img src="<?= base_url($imageUrl) ?>" class="img-thumbnail"  width="200" height="200">
                      <div class="custom-file">
                        <input type="file" name="image_profile" class="custom-file-input" id="image-profile">
                        <label class="custom-file-label">Choose File</label>
                      </div>
                      <div class="form-text text-muted">The image must have a maximum size of 2MB</div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-md-4 col-lg-4">
                    <div class="form-group">
                      <label>URL</label>
                      <input type="text" name="url" value="<?=old('url',$data->url)?>" class="form-control">
                    </div>
                  </div>
                  <div class="col-12 col-md-4 col-lg-4">
                    <div class="form-group">
                      <label>Access Api</label>
                      <input type="text" name="access_api" value="<?=old('access_api',$data->access_api)?>" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-md-4 col-lg-4">
                    <div class="form-group">
                      <label>Access Code</label>
                      <input type="text" name="access_code" value="<?=old('access_code',$data->access_code)?>" class="form-control">
                    </div>
                  </div>
                  <div class="col-12 col-md-4 col-lg-4">
                    <div class="form-group">
                      <label>Access Hash</label>
                      <input type="text" name="access_hash" value="<?=old('access_hash',$data->access_hash)?>" class="form-control">
                    </div>
                  </div>
                  <div class="col-12 col-md-4 col-lg-4">
                    <div class="form-group">
                      <label>Access Expired</label>
                      <input type="text" name="access_expired" value="<?=old('access_expired',$data->access_expired)?>" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-md-4 col-lg-4">
                    <div class="form-group">
                      <label>Access Activate</label>
                      <input type="text" name="access_activate" value="<?=old('access_activate',$data->access_activate)?>" class="form-control">
                    </div>
                  </div>
                  <div class="col-12 col-md-4 col-lg-4">
                    <div class="form-group">
                      <label>Access Email</label>
                      <input type="text" name="access_email" value="<?=old('access_email',$data->access_email)?>" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-md-4 col-lg-4">
                    <div class="form-group">
                      <label>Server URL</label>
                      <input type="text" name="server_url" value="<?=old('server_url',$data->server_url)?>" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-md-4 col-lg-4">
                    <div class="form-group">
                      <label>Developed By</label>
                      <input type="text" name="developed_by" value="<?=old('developed_by',$data->developed_by)?>" class="form-control">
                    </div>
                  </div>
                  <div class="col-12 col-md-4 col-lg-4">
                    <div class="form-group">
                      <label>Made By</label>
                      <input type="text" name="made_by" value="<?=old('made_by',$data->made_by)?>" class="form-control">
                    </div>
                  </div>
                  <div class="col-12 col-md-4 col-lg-4">
                    <div class="form-group">
                      <label>Made Year</label>
                      <input type="text" name="made_year" value="<?=old('made_year',$data->made_year)?>" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row justify-content-end">
                  <button type="submit" class="btn btn-success btn-lg mr-2"><i class="fas fa-paper-plane"></i> Save</button>
                  <button type="reset" class="btn btn-secondary btn-lg">Reset</button>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </section>
<?= $this->endSection() ?>
