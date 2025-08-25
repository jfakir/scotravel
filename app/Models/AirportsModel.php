<?php

namespace App\Models;

use CodeIgniter\Model;

class AirportsModel extends Model
{
    protected $table = 'airports';
    // protected $allowedFields = ['fname', 'lname', 'email', 'country_code', 'phone_code', 'phone', 'password', 'account_type', 'is_subscribed', 'is_verified', 'is_deleted'];

    public function getAllAirports()
    {
        return $this->distinct('name')->orderBy('name', 'ASC')->findAll();
    }

    
}

