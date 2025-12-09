<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Access New</title>
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
        <a href="<?=site_url('settings/accessmenu')?>" class="btn"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Edit Access</h1>
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
              <form method="POST" action="<?=site_url('settings/accessmenu/changes/'.$access->id)?>"  method="post" autocomplete="off">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" value="<?= base_url()?>" name="baseUrl" id="baseUrl">
                <input type="hidden" value="<?= $access->parent_id ?>" name="parent_id" id="parent_id">
                <input type="hidden" value="<?= $access->main_module_id ?>" name="main_module_id" id="main_module_id">
                <div class="form-group">
                    <label>As</label>
                    <select class="form-control select2" name="as" id="as">
                        <option value="module"  <?=$access->parent_id == 0 ? 'selected' : null?>>As Module</option>
                        <option value="function" <?=$access->parent_id > 0 ? 'selected' : null?>>As Function</option>
                    </select>
                </div>
                 <div class="form-group" id="getModules">
                  <label>Modules</label>
                  <select class="form-control select2" name="modules" id="modules">
                  <?php foreach ($modules as $key => $value) : ?>
                        <option value=<?=$value->id?> <?=$access->parent_id == $value->id ? 'selected' : null?>>
                            <?=$value->module_name?>
                          </option>
                        <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                    <label>Label Name</label>
                    <input type="text" name="label_name" value="<?= $access->label_name ?>" class="form-control">
                    <div class="invalid-feedback">
                      <?=isset($errors['label_name']) ? $errors['label_name'] : null?>
                    </div>
                </div>
                <div class="form-group" id="getmain_menu">
                  <label>Main Menu</label>
                  <select class="form-control select2" name="main_menu_state" id="main_menu_state">
                  <option>Select Main Menu</option>
                  <?php foreach ($main_module as $key => $value) : ?>
                        <option value=<?=$value->id?>  <?=$access->main_module_id == $value->id ? 'selected' : null?>>
                            <?=$value->name?>
                          </option>
                        <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                    <label>URL Acesss</label>
                    <input type="text" name="url" value="<?= $access->url ?>" class="form-control">
                    <div class="invalid-feedback">
                      <?=isset($errors['url']) ? $errors['url'] : null?>
                    </div>
                </div>
                <div class="form-group">
                  <label>Icon Image</label>
                  <input type="text" name="icon_image" value="<?= $access->icon_image?>" class="form-control">
                  <div class="invalid-feedback">
                    <?=isset($errors['icon_image']) ? $errors['icon_image'] : null?>
                  </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Update</button>
                </div>
            </form>
        </div>
      </div>

    </div>
  </section>
<?= $this->endSection() ?>

<?= $this->section('jsScript') ?>
<script src="<?=base_url()?>template/node_modules/select2/dist/js/select2.full.min.js"></script>
<script src="<?=base_url()?>template/frequently/js/setupaccess_create.js"></script>
<?= $this->endSection() ?>