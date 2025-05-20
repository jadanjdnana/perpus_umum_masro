<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>Anggota</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php if (session()->getFlashdata('msg')) : ?>
  <div class="pb-2">
    <div class="alert <?= (session()->getFlashdata('error') ?? false) ? 'alert-danger' : 'alert-success'; ?> alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('msg') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
<?php endif; ?>

<div class="card">
  <div class="card-body">
    <div class="row mb-2">
      <div class="col-12 col-lg-5">
        <h5 class="card-title fw-semibold mb-4">Data Anggota</h5>
      </div>
      <div class="col-12 col-lg-7">
        <div class="d-flex gap-2 justify-content-md-end">
          <div>
            <form action="" method="get">
              <div class="input-group mb-3">
                <input type="text" class="form-control" name="search" value="<?= $search ?? ''; ?>" placeholder="Cari anggota" aria-label="Cari anggota" aria-describedby="searchButton">
                <button class="btn btn-outline-secondary" type="submit" id="searchButton">Cari</button>
              </div>
            </form>
          </div>
          <div>
            <a href="<?= base_url('admin/members/new'); ?>" class="btn btn-primary py-2">
              <i class="ti ti-plus"></i>
              Tambah Anggota
            </a>
          </div>
          <div>
            <button type="button" class="btn btn-danger text-white" onclick="generatePDF()">
              Cetak PDF
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="overflow-x-scroll">
      <table class="table table-hover table-striped">
        <thead class="table-light">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nama lengkap</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col">Alamat</th>
            <th scope="col">Jenis kelamin</th>
            <th scope="col" class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">
          <?php $i = 1 + ($itemPerPage * ($currentPage - 1)) ?>
          <?php if (empty($members)) : ?>
            <tr>
              <td class="text-center" colspan="7"><b>Tidak ada data</b></td>
            </tr>
          <?php endif; ?>
          <?php foreach ($members as $key => $member) : ?>
            <tr>
              <th scope="row"><?= $i++; ?></th>
              <td>
                <a href="<?= base_url("admin/members/{$member['uid']}"); ?>" class="text-primary-emphasis text-decoration-underline">
                  <b><?= $member['first_name'] . ' ' . $member['last_name']; ?></b>
                </a>
              </td>
              <td><?= $member['email']; ?></td>
              <td><?= $member['phone']; ?></td>
              <td><?= $member['address']; ?></td>
              <td><?= $member['gender']; ?></td>
              <td>
                <div class="d-flex justify-content-center gap-2">
                  <a href="<?= base_url("admin/members/{$member['uid']}/edit"); ?>" class="btn btn-primary mb-2">
                    Edit
                  </a>
                  <form action="<?= base_url("admin/members/{$member['uid']}"); ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?');">
                      Delete
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?= $pager->links('members', 'my_pager'); ?>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

<script>
  function generatePDF() {
    // Load jsPDF library dynamically if not already loaded
    if (typeof jsPDF === 'undefined') {
      loadScript('https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js', function() {
        loadScript('https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js', createPDF);
      });
    } else {
      createPDF();
    }
  }

  function loadScript(url, callback) {
    const script = document.createElement('script');
    script.src = url;
    script.onload = callback;
    document.head.appendChild(script);
  }

  function createPDF() {
    const {
      jsPDF
    } = window.jspdf;
    const doc = new jsPDF();

    // Add title
    doc.setFontSize(16);
    doc.text("LAPORAN DATA ANGGOTA", 105, 15, null, null, "center");
    doc.setFontSize(12);
    doc.text("PERPUSTAKAAN UMUM", 105, 23, null, null, "center");

    // Prepare data
    const rows = [
      <?php foreach ($members as $index => $member): ?>[
          <?= $index + 1 ?>,
          "<?= addslashes($member['first_name'] . ' ' . $member['last_name']) ?>",
          "<?= addslashes($member['email']) ?>",
          "<?= addslashes($member['phone']) ?>",
          "<?= addslashes($member['address']) ?>",
          "<?= addslashes($member['gender']) ?>"
        ],
      <?php endforeach; ?>
    ];

    // Create table
    doc.autoTable({
      startY: 30,
      head: [
        ['No', 'Nama Lengkap', 'Email', 'Telepon', 'Alamat', 'Jenis Kelamin']
      ],
      body: rows,
      styles: {
        fontSize: 8,
        cellPadding: 2,
        overflow: 'linebreak'
      },
      headStyles: {
        fillColor: [0, 0, 0]
      },
      theme: 'grid',
      margin: {
        top: 30
      }
    });

    // Save the PDF
    doc.save("laporan-anggota-<?= date('Y-m-d') ?>.pdf");
  }
</script>

<?= $this->endSection() ?>