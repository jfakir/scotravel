<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\CompanyUsersModal;

class CompanyModel extends Model
{
    protected $table = 'companies';
    protected $allowedFields = ['id', 'name', 'created_by', 'created_on', 'is_deleted'];

 
    public function getAllCompanies($id)
    {
        $companyUsersModal = new CompanyUsersModal();
        if(isset($id) && !empty($id)){
            $companies = $companyUsersModal->where('user_id', $id)->findAll();

            $companyIds = array_column($companies, 'company_id');
    
            $companies = $this
                ->select('companies.*, users_companies.is_admin')
                ->join('users_companies', 'users_companies.company_id = companies.id', 'left')
                ->where('users_companies.user_id', $id)
                ->where('companies.is_deleted', 0);

            // Check if $companyIds is an array and apply whereIn condition
            if (is_array($companyIds) && !empty($companyIds)) {
                $companies = $companies->whereIn('companies.id', $companyIds);
            }

            $companies = $companies->orderBy('companies.name', 'ASC')
                                ->findAll();
            return $companies;

        }else{
            return $this->where('is_deleted', 0)->orderBy('name', 'ASC')->findAll();

        }

    }

    public function getUserCompanies()
    {
        return $this->orderBy('name', 'ASC')->findAll();

    }
}
