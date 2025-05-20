<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak Data Peminjaman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 14px;
        }

        th {
            background-color: #f2f2f2;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            color: #fff;
        }

        .bg-success {
            background-color: #28a745;
        }

        .bg-warning {
            background-color: #ffc107;
            color: #000;
        }

        .bg-danger {
            background-color: #dc3545;
        }
    </style>
</head>

<body onload="window.print()">

    <h2>Data Peminjaman Buku</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Peminjam</th>
                <th>Judul Buku</th>
                <th>Jumlah</th>
                <th>Tanggal Pinjam</th>
                <th>Tenggat</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php

            use CodeIgniter\I18n\Time;

            $i = 1;
            $now = Time::now('Asia/Jakarta', 'id_ID');
            ?>
            <?php if (empty($loans)) : ?>
                <tr>
                    <td colspan="7" style="text-align: center;"><b>Tidak ada data</b></td>
                </tr>
            <?php else: ?>
                <?php foreach ($loans as $loan) :
                    $loanCreateDate = Time::parse($loan['loan_date'], 'Asia/Jakarta', 'id_ID');
                    $loanDueDate = Time::parse($loan['due_date'], 'Asia/Jakarta', 'id_ID');
                ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= "{$loan['first_name']} {$loan['last_name']}"; ?></td>
                        <td>
                            <?= "{$loan['title']} ({$loan['year']})"; ?><br>
                            <small><i>Author: <?= $loan['author']; ?></i></small>
                        </td>
                        <td><?= $loan['quantity']; ?></td>
                        <td><?= $loanCreateDate->toLocalizedString('dd/MM/yyyy'); ?></td>
                        <td><?= $loanDueDate->toLocalizedString('dd/MM/yyyy'); ?></td>
                        <td>
                            <?php if ($now->isBefore($loanDueDate)) : ?>
                                <span class="badge bg-success">Normal</span>
                            <?php elseif ($now->toDateString() === $loanDueDate->toDateString()) : ?>
                                <span class="badge bg-warning">Jatuh tempo</span>
                            <?php else : ?>
                                <span class="badge bg-danger">Terlambat</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>