<?php

namespace App\Models;

use CodeIgniter\Model;

class TripAttachmentsModel extends Model
{
    protected $table = 'trip_attachments';
    protected $allowedFields = ['id', 'trip_id', 'name', 'extension', 'is_deleted'];

 
    public function getTripAttchments($id)
    {
        
        return $this->where('is_deleted', 0)->where('trip_id', $id)->orderBy('name', 'ASC')->findAll();

    }

    // public function getUserCompanies()
    // {
    //     return $this->orderBy('name', 'ASC')->findAll();

    // }
}
