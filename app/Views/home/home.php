<?= $this->extend('layouts/home_layout') ?>

<?= $this->section('head') ?>
<title>Home</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="px-4 pt-5 my-5 text-center border-bottom">
  <h1 class="display-4 fw-bold text-body-emphasis">Perpustakaan<span class="text-primary">Umum</span></h1>
  <div class="col-lg-6 mx-auto">
    <p class="lead mb-4">Jelajahi beragam buku menarik yang memperkaya pengetahuan dan menghidupkan imajinasi Anda. Perpustakaan Umum, sahabat setia para pencinta buku dan pembelajar di mana pun dan kapan pun.</p>
    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5">
      <a href="<?= base_url('login'); ?>" class="btn btn-primary btn-lg px-4 me-sm-3">Login petugas</a>
      <a href="<?= base_url('book'); ?>" class="btn btn-outline-secondary btn-lg px-4">Daftar buku</a>
    </div>
  </div>
  <div class="overflow-hidden" style="max-height: 45vh;">
    <div class="container px-5">
      <img src="<?= base_url('assets/images/dashboard_2.png'); ?>" class="img-fluid border rounded-3 shadow-lg mb-4" alt="Example image" width="700" height="500" loading="lazy">
    </div>
  </div>
</div>
<?= $this->endSection() ?>