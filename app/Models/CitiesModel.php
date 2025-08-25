<?php

namespace App\Models;

use CodeIgniter\Model;

class CitiesModel extends Model
{
    protected $table = 'cities';
    // protected $allowedFields = ['fname', 'lname', 'email', 'country_code', 'phone_code', 'phone', 'password', 'account_type', 'is_subscribed', 'is_verified', 'is_deleted'];

    public function getAllCities()
    {
        // return $this->distinct('city')->orderBy('city', 'ASC')->findAll();
        return $this->distinct('TRIM(city)')->orderBy('city', 'ASC')->findAll();
        // return $this->distinct('LOWER(TRIM(city))')->orderBy('city', 'ASC')->findAll();


    }

    // public function get10Cities()
    // {
    //     return $this->where('id <', 1000)
    //     ->orderBy('city', 'ASC')
    //     ->findAll();

    // }
    public function get10Cities()
    {
        // return $this->where('id <', 1000)
        // ->orderBy('city', 'ASC')
        // ->findAll();
        $sql = "
    (
        SELECT c.*
        FROM cities c
        WHERE c.id < 2000
        ORDER BY c.city ASC
    )
    UNION
    (
        SELECT DISTINCT c.*
        FROM cities c
        INNER JOIN trips t ON c.id = t.destination_id
    )
    ORDER BY city ASC
";

// Execute the query
   $results = $this->db->query($sql)->getResultArray();
        return $results;
    }


    
}

