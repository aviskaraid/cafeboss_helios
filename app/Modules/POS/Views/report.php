<h1>User Index Page</h1><?php
  $c = apps_detail();
?>
<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Title | <?=$c->name?></title>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
    <section class="section">
      <div class="section-header">
          <h1>Title List</h1>
          <div class="section-header-button">
              <a href="<?=site_url('user/new')?>" class="btn btn-primary">Add New</a>
          </div>
      </div>
      <?= $this->include('layout/alert') ?>
      <div class="section-body">
        <div class="card">
          <div class="card-header">
            <h4>Title List</h4>
          </div>
          report
        </div>
      </div>
    </section>
<?= $this->endSection() ?>
