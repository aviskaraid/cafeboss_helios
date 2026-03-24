<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>User Groups Edit</title>
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
        <a href="<?=site_url('settings/user_groups')?>" class="btn"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Create New User Edit</h1>
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
              <form method="POST" action="<?=site_url('settings/user_groups/changes/'.$groups->id)?>"  method="post" autocomplete="off">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" value="<?= base_url()?>" name="baseUrl" id="baseUrl">
                <input type="hidden" value="<?= $groups->id?>" name="group_id" id="group_id">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="<?=$groups->name?>" class="form-control">
                    <div class="invalid-feedback">
                      <?=isset($errors['name']) ? $errors['name'] : null?>
                    </div>
                </div>
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" name="description" value="<?= $groups->description?>" class="form-control">
                  <div class="invalid-feedback">
                    <?=isset($errors['description']) ? $errors['description'] : null?>
                  </div>
                </div>
                <div class="form-group">
                  <label>Order Number</label>
                  <select class="form-control select2" name="order_number" id="order_number">
                  <?php foreach ($order_number as $key => $value) : ?>
                        <option value=<?=$value['id']?>>
                            <?=$value['number']?>
                          </option>
                        <?php endforeach; ?>
                  </select>
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