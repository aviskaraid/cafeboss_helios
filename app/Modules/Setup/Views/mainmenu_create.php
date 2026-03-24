<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Main MenuNew</title>
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
        <a href="<?=site_url('settings/mainmenu')?>" class="btn"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Create New Main Menu</h1>
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
              <form method="POST" action="<?=site_url('settings/mainmenu/create_process')?>"  method="post" autocomplete="off">
                <?= csrf_field() ?>
                <input type="hidden" value="<?= base_url()?>" name="baseUrl" id="baseUrl">
                <div class="form-group">
                    <label>Label Name</label>
                    <input type="text" name="name" value="<?=old('name')?>" class="form-control">
                    <div class="invalid-feedback">
                      <?=isset($errors['name']) ? $errors['name'] : null?>
                    </div>
                </div>
                 <div class="form-group">
                    <label>Order Number</label>
                    <input type="text" name="order_number" value="<?=old('order_number')?>" class="form-control">
                    <div class="invalid-feedback">
                      <?=isset($errors['order_number']) ? $errors['order_number'] : null?>
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
<?= $this->endSection() ?>