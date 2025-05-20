<?php

namespace App\Controllers\Loans;

use App\Controllers\BaseController;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\LoanModel;
use CodeIgniter\I18n\Time;

class Loans extends BaseController
{
    public function printPdf()
    {
        $loanModel = new LoanModel();
        $data['loans'] = $loanModel->getAllWithDetails(); // Ambil data dari model

        // ⬇️ Di sinilah letak baris view
        $html = view('loans/print', $data); // Kirim data ke view dan tangkap HTML-nya

        // Konfigurasi Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html); // Muat HTML yang tadi dirender
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Unduh atau tampilkan PDF
        $dompdf->stream("data_peminjaman.pdf", ["Attachment" => true]);
    }
}
