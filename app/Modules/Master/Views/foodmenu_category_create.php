<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title><?= $title ?></title>
<?= $this->endSection() ?>

<?= $this->section('cssScript') ?>
<link rel="stylesheet" href="<?=base_url()?>template/node_modules/select2/dist/css/select2.min.css">
<style>
.hidden {
    display: none;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
  <section class="section">
    <div class="section-header">
      <div class="section-header-back">
        <a href="<?=site_url('settings/foodmenucategory')?>" class="btn"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1><?= $title ?></h1>
    </div>

    <div class="section-body">
      <div class="card col-md-6">
        <div class="card-body col-md-12">
            <?php if(session()->getFlashdata('error')) : ?>
                  <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                      <button class="close" data-dismiss="alert">x</button>
                      <b>Error !</b>
                      <?=session()->getFlashdata('error')?>
                    </div>
                  </div>
                <?php endif; ?>
            <?php $errors = session()->getFlashdata('errors'); ?>
             <form id="itemCategory_Create">
                <input type="hidden" value="0" name="parent_id" id="parent_id">
                <div class="form-group">
                    <label>As</label>
                    <select class="form-control select2" name="as" id="as">
                        <option value="main" selected="selected" >As Category</option>
                        <option value="sub">As Sub Category</option>
                    </select>
                </div>
                <div class="form-group" id="getCategory">
                  <label>Category</label>
                  <select class="form-control select2" name="category" id="category">
                     <option>Select Category</option>
                  <?php foreach ($category as $key => $value) : ?>
                        <option value=<?=$value->id?>>
                            <?=$value->category_name?>
                          </option>
                        <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                    <label>Label Name</label>
                    <input type="text" name="label_name" value="<?=old('label_name')?>" class="form-control">
                    <div class="invalid-feedback">
                      <?=isset($errors['label_name']) ? $errors['label_name'] : null?>
                    </div>
                </div> 
                <div>
                    <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Save</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form>
        </div>
      </div>

    </div>
  </section>
<?= $this->endSection() ?>

<?= $this->section('jsScript') ?>
<script src="<?=base_url()?>template/node_modules/select2/dist/js/select2.full.min.js"></script>
<script src="<?=base_url()?>template/frequently/js/foodmenucategory_create.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection() ?>
