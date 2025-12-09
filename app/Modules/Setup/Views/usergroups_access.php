<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Groups Access</title>
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
      <h1>Groups Access</h1>
    </div>

    <div class="section-body">
      <div class="card col-md-12">
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
              <form method="POST" action="<?=site_url('settings/user_groups/access_changes/'.$groups->id)?>"  method="post" autocomplete="off">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" value="<?= base_url()?>" name="baseUrl" id="baseUrl">
                <input type="hidden" value="<?= $groups->id?>" name="group_id" id="group_id">
                 <div class="card-body">
                  <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" name="select_all_access" class="custom-control-input" id="select_all_access">
                          <label class="custom-control-label" for="select_all_access"><p class="h6"><b>Select All</b></p></label>
                        </div>
                    </div>
                  </div>
                  <?php foreach ($access_menu as $key => $value) : ?>
                  <div class="row -mt-2">
                    <h2 class="section-title"><?= $value->name ?></h2>
                  </div>
                    <?php foreach ($value->access as $key2 => $val) :?>
                      <div class="parentAccess<?= $val->id ?>">
                        <div class="row ml-4 mt-2">
                          <div class="col-12 col-md-6 col-lg-6">
                          <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input checkboxAccess" name="access[]" value="<?=$val->id?>" id="customCheckAccess<?= $val->id ?>">
                              <label class="custom-control-label" for="customCheckAccess<?=$val->id?>"><p class="h6"><b><?=$val->label_name?></b></p></label>
                          </div>
                          </div>
                        </div>
                        <div class="row ml-4 pl-4 mt-2">
                          <?php foreach ($val->function as $key3 => $func) :?>
                            <?php $acesss = $func->parent_id.";".$func->id?>
                            <div class="col-2 col-md-2 col-lg-2">
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input checkboxFunction" name="groups_access[]" value="<?= $func->parent_id ?>;<?= $func->id ?>"
                                id="customCheckFunction<?= $func->parent_id?>;<?= $func->id?>"  <?=in_array($acesss, $access_group) ? 'checked' : null?>>
                                <label class="custom-control-label" for="customCheckFunction<?= $func->parent_id?>;<?= $func->id?>"><?=$func->label_name?></label>
                              </div>
                            </div>
                        <?php endforeach;?>
                        </div>
                        </div>
                    <?php endforeach;?>
                  <?php endforeach; ?>
                </div>
                <div class="row justify-content-end">
                    <button type="submit" class="btn btn-success mr-2"><i class="fas fa-paper-plane"></i> Save</button>
                </div>
            </form>
        </div>
      </div>

    </div>
  </section>
<?= $this->endSection() ?>

<?= $this->section('jsScript') ?>
<script src="<?=base_url()?>template/node_modules/select2/dist/js/select2.full.min.js"></script>
<script src="<?=base_url()?>template/frequently/js/groups_access.js"></script>
<?= $this->endSection() ?>