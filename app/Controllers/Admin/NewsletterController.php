<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\NewsletterModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class NewsletterController extends BaseController
{
    protected $newsletterModel;

    public function __construct()
    {
        $this->newsletterModel = new NewsletterModel();
    }

    public function index()
    {
        $data['newsletters'] = $this->newsletterModel->orderBy('created_at', 'DESC')->findAll();
        return view('admin/newsletter/index', $data);
    }

    public function delete($id)
    {
        $this->newsletterModel->delete($id);
        return redirect()->to('/admin/newsletter')->with('success', 'Data newsletter berhasil dihapus.');
    }

    public function toggle($id)
    {
        $newsletter = $this->newsletterModel->find($id);
        if (!$newsletter) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $this->newsletterModel->update($id, ['subscribed' => $newsletter['subscribed'] ? 0 : 1]);
        return redirect()->back()->with('success', 'Status berhasil diubah.');
    }

    public function exportPdf()
    {
        $data['subscribers'] = $this->newsletterModel->orderBy('created_at', 'DESC')->findAll();

        $html = view('admin/newsletter/pdf', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('newsletter.pdf');
    }

    public function exportExcel()
    {
        $subscribers = $this->newsletterModel->orderBy('created_at', 'DESC')->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Email');
        $sheet->setCellValue('B1', 'Status');
        $sheet->setCellValue('C1', 'Tanggal');

        $row = 2;
        foreach ($subscribers as $s) {
            $sheet->setCellValue('A' . $row, $s['email']);
            $sheet->setCellValue('B' . $row, $s['subscribed'] ? 'Aktif' : 'Tidak Aktif');
            $sheet->setCellValue('C' . $row, $s['created_at']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'newsletter.xlsx';

        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }

    public function kirim()
    {
        $data['emails'] = $this->newsletterModel->where('subscribed', 1)->findAll();
        return view('admin/newsletter/kirim', $data);
    }

    public function prosesKirim()
    {
        $subject = $this->request->getPost('subject');
        $message = $this->request->getPost('message');
        $targetEmails = $this->request->getPost('emails');

        if (!$subject || !$message || !$targetEmails) {
            return redirect()->back()->with('error', 'Subjek, isi pesan, dan penerima wajib diisi.');
        }

        $email = \Config\Services::email();
        $successCount = 0;

        foreach ($targetEmails as $to) {
            $email->setTo($to);
            $email->setSubject($subject);
            $email->setMessage(view('admin/newsletter/template', ['message' => $message]));
            $email->setFrom('salamander.riaadha@gmail.com', 'Lunaya');

            if ($email->send()) {
                $successCount++;
            } else {
                log_message('error', 'Gagal kirim ke: ' . $to);
            }

            $email->clear();
        }

        return redirect()->to('/admin/newsletter')->with('success', "$successCount email berhasil dikirim.");
    }
}
