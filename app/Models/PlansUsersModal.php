<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Usermodel;

class PlansUsersModal extends Model
{
    protected $table = 'plans_users';
    protected $allowedFields = ['id', 'plan_id', 'user_id'];

    public function addRecord($data)
    {
        return $this->insert($data);
    }
    public function getAllRecords()
    {
        return $this->findAll();
    }

    public function getPlanUsers($planId){
        $db = \Config\Database::connect();
        $users = $db->table('users')
        ->select('users.*, plans_users.*, user_confirmations.*')
        ->join('plans_users', 'plans_users.user_id = users.id')
        ->join('user_confirmations', 'user_confirmations.userId = users.id AND user_confirmations.planId = ' . $db->escape($planId), 'left')
        ->where('plans_users.plan_id', $planId)
        ->orderBy('users.fname', 'ASC')
        ->orderBy('users.lname', 'ASC')
        ->get()
        ->getResult();

        return $users;
    }

    
}
