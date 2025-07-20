<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CouponModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class CouponController extends BaseController
{
    protected $couponModel;

    public function __construct()
    {
        $this->couponModel = new CouponModel();
    }

    public function index()
    {
        $data['coupons'] = $this->couponModel->orderBy('created_at', 'DESC')->findAll();
        return view('admin/kupon/index', $data);
    }

    public function create()
    {
        return view('admin/kupon/create');
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'code'       => 'required|is_unique[coupons.code]',
            'type'       => 'required|in_list[percentage,fixed]',
            'value'      => 'required|numeric',
            'max_uses'   => 'required|integer',
            'start_date' => 'required|valid_date',
            'end_date'   => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $this->couponModel->insert([
            'code'       => $this->request->getPost('code'),
            'type'       => $this->request->getPost('type'),
            'value'      => $this->request->getPost('value'),
            'max_uses'   => $this->request->getPost('max_uses'),
            'used_count' => 0,
            'start_date' => $this->request->getPost('start_date'),
            'end_date'   => $this->request->getPost('end_date'),
            'is_active'  => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('admin/kupon')->with('success', 'Kupon berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $coupon = $this->couponModel->find($id);
        if (!$coupon) {
            return redirect()->to('admin/kupon')->with('error', 'Kupon tidak ditemukan.');
        }

        return view('admin/kupon/edit', ['coupon' => $coupon]);
    }

    public function update($id)
    {
        $rules = [
            'code'       => 'required',
            'type'       => 'required|in_list[percentage,fixed]',
            'value'      => 'required|numeric',
            'max_uses'   => 'required|integer',
            'start_date' => 'required|valid_date',
            'end_date'   => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $startDate = $this->request->getPost('start_date');
        $endDate   = $this->request->getPost('end_date');

        if ($endDate < $startDate) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Tanggal berakhir tidak boleh sebelum tanggal mulai.');
        }

        $this->couponModel->update($id, [
            'code'       => $this->request->getPost('code'),
            'type'       => $this->request->getPost('type'),
            'value'      => $this->request->getPost('value'),
            'max_uses'   => $this->request->getPost('max_uses'),
            'start_date' => $startDate,
            'end_date'   => $endDate,
            'is_active'  => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('admin/kupon')->with('success', 'Kupon berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->couponModel->delete($id);
        return redirect()->to('admin/kupon')->with('success', 'Kupon berhasil dihapus.');
    }

    public function toggle($id)
    {
        $coupon = $this->couponModel->find($id);
        if (!$coupon) {
            return redirect()->to('admin/kupon')->with('error', 'Kupon tidak ditemukan.');
        }

        $this->couponModel->update($id, [
            'is_active' => $coupon['is_active'] ? 0 : 1
        ]);

        return redirect()->to('admin/kupon')->with('success', 'Status kupon berhasil diperbarui.');
    }

    public function exportPdf()
    {
        $data['coupons'] = $this->couponModel->findAll();

        $html = view('admin/kupon/pdf', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('kupon.pdf');
    }

    public function exportExcel()
    {
        $coupons = $this->couponModel->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Kupon');

        $sheet->setCellValue('A1', 'Kode');
        $sheet->setCellValue('B1', 'Jenis');
        $sheet->setCellValue('C1', 'Nilai');
        $sheet->setCellValue('D1', 'Maks. Penggunaan');
        $sheet->setCellValue('E1', 'Tanggal Berlaku');
        $sheet->setCellValue('F1', 'Status');

        $row = 2;
        foreach ($coupons as $c) {
            $used = isset($c['used_count']) ? $c['used_count'] : 0;
            $max  = isset($c['max_uses']) ? $c['max_uses'] : 0;

            $sheet->setCellValue('A' . $row, $c['code']);
            $sheet->setCellValue('B' . $row, $c['type']);
            $sheet->setCellValue('C' . $row, $c['value']);
            $sheet->setCellValue('D' . $row, "$used/$max");
            $sheet->setCellValue('E' . $row, $c['start_date'] . ' s/d ' . $c['end_date']);
            $sheet->setCellValue('F' . $row, $c['is_active'] ? 'Aktif' : 'Nonaktif');
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'kupon.xlsx';

        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }
}
