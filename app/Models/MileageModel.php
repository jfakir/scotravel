<?php

namespace App\Models;

use CodeIgniter\Model;

class MileageModel extends Model
{
    protected $table = 'mileage_accounts';
    protected $allowedFields = ['user_id', 'airline_id','airline_name', 'name', 'points', 'is_deleted'];

    public function add($data)
    {
        return $this->insert($data);
    }

    public function getByUserID($id)
    {
        $data = $this->where('user_id', $id)->where('is_deleted', 0)->findAll();
        return $data;
    }
}
