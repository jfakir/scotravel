<?php

namespace App\Models;

use CodeIgniter\Model;

class AirlinesModel extends Model
{
    protected $table = 'airlines';
    // protected $allowedFields = ['fname', 'lname', 'email', 'country_code', 'phone_code', 'phone', 'password', 'account_type', 'is_subscribed', 'is_verified', 'is_deleted'];

    public function getAllAirlines()
    {
        return $this->distinct('name')->orderBy('name', 'ASC')->findAll();
    }

    
}

