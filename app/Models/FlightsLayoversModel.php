<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Usermodel;

class FlightsLayoversModel extends Model
{
    protected $table = 'flights_layovers';
    protected $allowedFields = ['id', 'flight_id', 'flight_layover_id','rank'];

    public function addRecord($data)
    {
        return $this->insert($data);
    }
    public function getAllRecords()
    {
        return $this->findAll();
    }

    // public function getPlanUsers($planId){
    //     $userModel = new UserModel();

    //     $users = $userModel->select('*')
    //             ->join('plans_users', 'plans_users.user_id = users.id')
    //             ->where('plans_users.plan_id', $planId)
    //             ->orderBy('users.fname', 'ASC')
    //             ->orderBy('users.lname', 'ASC')
    //             ->findAll();

    //     return $users;
    // }

    
}
