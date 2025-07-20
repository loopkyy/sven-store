<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Models\ActivityLogModel;

class ActivityLogController extends BaseController
{
    public function index()
    {
        $model = new ActivityLogModel();
        $query = $model->select('activity_logs.*, users.username')
                       ->join('users', 'users.id = activity_logs.user_id', 'left')
                       ->orderBy('created_at', 'DESC');

        $search = $this->request->getGet('q');
        if ($search) {
            $query->like('activity', $search)
                  ->orLike('users.username', $search);
        }

        $logs = $query->paginate(20); 

        return view('superadmin/log/index', [
            'logs' => $logs,
            'pager' => $model->pager,
        ]);
    }

    public function delete($id)
    {
        $model = new ActivityLogModel();
        $model->delete($id);
        return redirect()->to('/log')->with('success', 'Log berhasil dihapus.');
    }

    public function deleteAll()
    {
        $model = new ActivityLogModel();
        $model->truncate();
        return $this->response->setStatusCode(200);
    }
}
