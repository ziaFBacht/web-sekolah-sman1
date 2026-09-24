<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditLogModel extends Model
{
    protected $table            = 'audit_logs';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['user_id', 'action', 'table_name', 'record_id', 'record_name', 'created_at'];
    protected $useTimestamps    = false; 

    public function recordLog($action, $tableName, $recordId, $recordName = null)
    {
        $this->insert([
            'user_id'     => session()->get('id'),
            'action'      => strtoupper($action),
            'table_name'  => $tableName,
            'record_id'   => $recordId,
            'record_name' => $recordName, // Simpan nama target
            'created_at'  => date('Y-m-d H:i:s')
        ]);
    }

    // Fungsi untuk mengambil log beserta nama user pembuatnya untuk dashboard
    public function getLatestLogs($limit = 10)
    {
        return $this->select('audit_logs.*, users.username')
                    ->join('users', 'users.id = audit_logs.user_id', 'left')
                    ->orderBy('audit_logs.created_at', 'DESC')
                    ->findAll($limit);
    }
}