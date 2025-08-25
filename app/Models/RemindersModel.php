<?php

namespace App\Models;

use CodeIgniter\Model;

class RemindersModel extends Model
{
    protected $table = 'reminders';
    protected $allowedFields = ['id', 'company_id','title', 'description', 'is_redeemed', 'is_deleted'];

    public function add($data)
    {
        return $this->insert($data);
    }

    public function getByCompanyId($id)
    {
        $data = $this->where('company_id', $id)
                        ->where('is_deleted', 0)
                        ->orderBy('is_redeemed', 'ASC')
                        ->findAll();
        return $data;
    }

    public function getAllReminders()
    {
        return $this->where('is_deleted', 0)->orderBy('id', 'ASC')->findAll();
    }

    public function getRedeemedReminders()
    {
        return $this->where('is_deleted', 0)->where('is_redeemed', 1)->orderBy('id', 'ASC')->findAll();
    }
    public function getUnredeemedReminders()
    {
        return $this->where('is_deleted', 0)->where('is_redeemed', 0)->orderBy('id', 'ASC')->findAll();
    }
}
