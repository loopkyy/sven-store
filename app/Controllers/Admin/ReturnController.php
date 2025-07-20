<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ReturnModel;
use App\Models\OrderModel;
use App\Models\ActivityLogModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class ReturnController extends BaseController
{
    protected $returModel;

    public function __construct()
    {
        $this->returModel = new ReturnModel();
    }

    public function index()
    {
        $data['returns'] = $this->returModel->withOrder()->orderBy('returns.created_at', 'DESC')->findAll();
        return view('admin/retur/index', $data);
    }

    public function create()
    {
        $orderModel = new OrderModel();
        $data['orders'] = $orderModel->where('status', 'paid')->findAll();
        return view('admin/retur/create', $data);
    }

    public function store()
    {
        $this->returModel->insert([
            'order_id' => $this->request->getPost('order_id'),
            'reason'   => $this->request->getPost('reason'),
            'status'   => 'pending',
        ]);

        $this->logActivity("Pengajuan retur dari order ID: " . $this->request->getPost('order_id'));

        return redirect()->to('/admin/retur')->with('success', 'Pengajuan retur berhasil disimpan.');
    }

    public function updateStatus($id)
    {
        $status = $this->request->getPost('status');
        $this->returModel->update($id, ['status' => $status]);

        $this->logActivity("Update status retur ID $id menjadi: $status");

        return redirect()->to('/admin/retur')->with('success', 'Status retur diperbarui.');
    }

    public function edit($id)
    {
        $retur = $this->returModel->find($id);
        if (!$retur) {
            return redirect()->to('/admin/retur')->with('error', 'Data retur tidak ditemukan.');
        }

        return view('admin/retur/edit', ['retur' => $retur]);
    }

    public function update($id)
    {
        $data = [
            'reason' => $this->request->getPost('reason'),
            'status' => $this->request->getPost('status'),
        ];

        $this->returModel->update($id, $data);
        $this->logActivity("Retur ID $id diperbarui.");

        return redirect()->to('/admin/retur')->with('success', 'Data retur berhasil diperbarui.');
    }

    public function exportPdf()
    {
        $data['returns'] = $this->returModel
            ->select('returns.*, users.username')
            ->join('orders', 'orders.id = returns.order_id')
            ->join('users', 'users.id = orders.user_id')
            ->findAll();

        $html = view('admin/retur/pdf', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('laporan-retur.pdf');
    }

    public function exportExcel()
    {
        $returns = $this->returModel
            ->select('returns.*, users.username')
            ->join('orders', 'orders.id = returns.order_id')
            ->join('users', 'users.id = orders.user_id')
            ->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Retur');

        // Header
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Order ID');
        $sheet->setCellValue('C1', 'Username');
        $sheet->setCellValue('D1', 'Alasan');
        $sheet->setCellValue('E1', 'Status');
        $sheet->setCellValue('F1', 'Waktu');

        $row = 2;
        foreach ($returns as $retur) {
            $sheet->setCellValue('A' . $row, $retur['id']);
            $sheet->setCellValue('B' . $row, $retur['order_id']);
            $sheet->setCellValue('C' . $row, $retur['username']);
            $sheet->setCellValue('D' . $row, $retur['reason']);
            $sheet->setCellValue('E' . $row, $retur['status']);
            $sheet->setCellValue('F' . $row, $retur['created_at']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan-retur.xlsx';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }

    // Opsional log_activity() di sini agar tidak error
    protected function logActivity(string $message): void
    {
        if (function_exists('log_activity')) {
            log_activity($message);
        } else {
            $logModel = new ActivityLogModel();
            $logModel->insert([
                'user_id' => session('user_id') ?? 0,
                'activity' => $message,
            ]);
        }
    }
}
