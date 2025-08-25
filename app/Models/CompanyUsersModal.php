<?php

namespace App\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;
use App\Models\Usermodel;
use App\Models\CompanyModel;

class CompanyUsersModal extends Model
{
    protected $table = 'users_companies';
    protected $allowedFields = ['id', 'user_id', 'company_id','is_admin'];

    
    public function getAllRecords()
    {
        return $this->findAll();
    }

    public function getCompanyUsers($companyId)
    {
        $userModel = new UserModel();

        $users = $userModel->select('*')
                ->join('users_companies', 'users_companies.user_id = users.id')
                ->where('users_companies.company_id', $companyId)
                ->where('users.is_deleted', 0)
                ->orderBy('users_companies.is_admin', 'DESC')
                ->orderBy('users.fname', 'ASC')
                ->orderBy('users.lname', 'ASC')
                ->findAll();

        return $users;
    }


    public function getAllUsersNotInCompany($companyId)
    {
        $sql = "SELECT *
        FROM `users`
        WHERE `is_deleted` = 0
        AND (
            (`id` NOT IN (SELECT `user_id` FROM `users_companies` WHERE `company_id` = $companyId))
        )
        ORDER BY `fname` ASC, `lname` ASC";


        $query = $this->db->query($sql);
        return $query->getResult();
    }
    


    // public function getAllUsersNotInCompany($id){
    //     $userModel = new UserModel();

    //     $users = $userModel->select('*')
    //             ->join('users_companies', 'users_companies.user_id = users.id')
    //             ->where('users_companies.company_id', $companyId)
    //             ->where('users.is_deleted', 0)
    //             ->orderBy('users_companies.is_admin', 'DESC')
    //             ->orderBy('users.fname', 'ASC')
    //             ->orderBy('users.lname', 'ASC')
    //             ->findAll();

    //     return $users;
        
    // }


    public function getCompanyAdmins($companyId){

        $users = $this->select('user_id')
                ->where('company_id', $companyId)
                ->where('is_admin', 1)
                ->findAll();

        return $users;

    }

    public function getUserCompanies($userId){
        $companyModel = new CompanyModel();

        $companies = $companyModel->select('*')
                ->join('users_companies', 'users_companies.company_id = companies.id')
                ->where('users_companies.user_id', $userId)
                ->where('companies.is_deleted', 0)
                ->orderBy('companies.name', 'ASC')
                ->findAll();

        return $companies;
    }

 
    public function getUsersNotInCompany($companyId,$username)
    {

        $userModel = new UserModel();


        // $sql = "SELECT *
        // FROM `users`
        // WHERE `id` NOT IN (
        //     SELECT `user_id`
        //     FROM `users_companies`
        //     WHERE `company_id` = $companyId
        // )
        // AND `is_deleted` = 0
        // AND (`fname` LIKE '%$username%' OR `lname` LIKE '%$username%' OR `email` LIKE '%$username%')
        // AND  `email` LIKE '$username'
        // ORDER BY `fname` ASC, `lname` ASC";

          $sql = "SELECT *
        FROM `users`
        WHERE `is_deleted` = 0
        AND  `email` LIKE '$username'
        AND `id` NOT IN (
             SELECT `user_id`
             FROM `users_companies`
             WHERE `company_id` = $companyId
            )
        ORDER BY `fname` ASC, `lname` ASC";
    


        $query = $this->db->query($sql);
        return $query->getResult();

    }

    public function getCompaniesUsers($companiesIds){
        $userModel = new UserModel();

        // $users = $userModel->select('*')
        //         ->join('users_companies', 'users_companies.user_id = users.id')
        //         ->whereIn('users_companies.company_id', $companiesIds)
        //         ->where('users.is_deleted', 0)
        //         ->orderBy('users.fname', 'ASC')
        //         ->orderBy('users.lname', 'ASC')
        //         ->findAll();
        
        $users = $userModel->select('*')
                            ->join('users_companies', 'users_companies.user_id = users.id')
                            ->whereIn('users_companies.company_id', $companiesIds)
                            ->where('users.is_deleted', 0)
                            ->groupBy('users.id') // Group by user id to remove duplicates
                            // ->orderBy('users_companies.is_admin', 'DESC')
                            ->orderBy('users.fname', 'ASC')
                            ->orderBy('users.lname', 'ASC')
                            ->findAll();

        return $users;

   

    }

    public function getAllCompaniesUsers(){
        $userModel = new UserModel();


        $users = $userModel->select('*')
                ->join('users_companies', 'users_companies.user_id = users.id')
                ->where('users.is_deleted', 0)
                ->groupBy('users.id') // Group by user id to remove duplicates
                // ->orderBy('users_companies.is_admin', 'DESC')
                ->orderBy('users.fname', 'ASC')
                ->orderBy('users.lname', 'ASC')
                ->findAll();

        return $users;

    }

}
