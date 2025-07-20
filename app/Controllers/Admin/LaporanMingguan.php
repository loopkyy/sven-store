<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Dompdf\Dompdf;
use Dompdf\Options;

class LaporanMingguan extends BaseController
{
    public function export()
    {
        $db = \Config\Database::connect();
        $data = $db->table('weekly_reports')
            ->orderBy('start_date', 'DESC')
            ->get()
            ->getFirstRow();

        if (!$data) {
            return redirect()->back()->with('error', 'Belum ada data laporan mingguan.');
        }

        $data->top_products = json_decode($data->top_products);

        $html = view('dashboard/weekly_pdf', ['report' => $data]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('laporan-mingguan.pdf', ['Attachment' => false]);
    }
}
