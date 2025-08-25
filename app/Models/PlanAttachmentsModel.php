<?php

namespace App\Models;

use CodeIgniter\Model;

class PlanAttachmentsModel extends Model
{
    protected $table = 'plan_attachments';
    protected $allowedFields = ['id', 'plan_id', 'name', 'extension', 'is_deleted'];

 
    // public function getAllCompanies()
    // {
        
    //     return $this->where('is_deleted', 0)->orderBy('name', 'ASC')->findAll();

    // }

    // public function getUserCompanies()
    // {
    //     return $this->orderBy('name', 'ASC')->findAll();

    // }

    public function getAttachmentsByPlanId($planId){
    
        return $this->where('plan_id', $planId)
                    ->where('is_deleted', 0)
                    ->findAll();
    }

}
