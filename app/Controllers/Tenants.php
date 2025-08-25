<?php

namespace App\Controllers;
use App\Models\CompanyModel;
use App\Models\CompanyUsersModal;
use App\Models\Usermodel;

class Tenants extends BaseController
{
    public function manage()
    {
        // Manage Add Edit
        return view('tenants/manage');
    }


    public function view()
    {
        $companyModel = new CompanyModel();

        if(session()->access_type==2){
            $result = $companyModel->getAllCompanies(0);
        }else{
            $result = $companyModel->getAllCompanies(session()->user_id);
        }
        $data=[
            'companies'=>$result
        ];
        return view('tenants/view',$data);
    }

    public function tenant()
    {
        $companyModel = new CompanyModel();
        $CompanyUsersModal = new CompanyUsersModal();

        $id = $this->request->getGet('id');

        $tenant = $companyModel->where('id', $id)->first();

       
        $data['tenant'] = $tenant;
        $users = $CompanyUsersModal->getCompanyUsers($id);
        $data['users'] = $users;

        //get Tenant admins
        $tenantAdmins = $CompanyUsersModal->getCompanyAdmins($id);

        $adminsIds = array_column($tenantAdmins, 'user_id');
        if (in_array(session()->user_id, $adminsIds)||session()->access_type==2) {
            $isTripAdmin = true ;
        } else {
            $isTripAdmin = false ;
        }


        $data['isTripAdmin'] = $isTripAdmin;


        return view('tenants/tenant',$data);
    }

    public function getAllCompanies()
    {
        // return view('flights/view');
        $companyModel = new CompanyModel();
        

      
        $result = $companyModel->getAllCompanies(0);
        if ($result) {
            
            return $this->response->setJSON([
                'status' => true,
                'data' => $result,
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'data' => $result,
            ]);
        }

    }


    public function getTenantsUsers()
    {
        // return view('flights/view');
        $CompanyUsersModal = new CompanyUsersModal();

        

        $ids = $this->request->getPost('ids');
        if($ids==-1){
            //  $userModel = new UserModel();
            //  $users = $userModel->getAllUsers();

            $users = $CompanyUsersModal->getAllCompaniesUsers();

        }else{
            $idsArray = explode(',', $ids);
      
            $users = $CompanyUsersModal->getCompaniesUsers($idsArray);
        }

        

        return $this->response->setJSON([
            'status' => true,
            'data' => $users
        ]);

    }

    public function getTenantUsers()
    {
        // return view('flights/view');
        $CompanyUsersModal = new CompanyUsersModal();

        

        $id = $this->request->getPost('id');
      
        $users = $CompanyUsersModal->getCompanyUsers($id);
        return $this->response->setJSON([
            'status' => true,
            'data' => $users
        ]);

    }
    
    public function delete(){

        $id = $this->request->getPost('id');

        $companyModel = new CompanyModel();

        
        $data = [
            'is_deleted' =>1,
        ];
        $result = $companyModel->update($id, $data);
        if ($result) {
            
            return $this->response->setJSON([
                'status' => true,
                'data' => 'Company deleted.',
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'data' => 'Connection Error.', 
            ]);
        }
    }

    public function edit()
    {
        if ($this->request->getGet('id')) {

            $companyModel = new CompanyModel();

            $id = $this->request->getGet('id');

            $company = $companyModel->where('id', $id)
                                    ->first();

            $company['is_edit']=1;
           
            $data['company'] = $company;


            return view('tenants/manage', $data);
                     
        }
    }
    
    public function save()
    {
        if ($this->request->isAJAX()) {
            $CompanyModel = new CompanyModel();

            $postData = $this->request->getPost();
            
            if(isset($postData['id']) && !empty($postData['id'])){
                $id = $CompanyModel->update($postData['id'],$postData);
            }else{
                $id = $CompanyModel->insert($postData);
            }


            if ($id) {
                return $this->response->setJSON([
                    'status' => true,
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                ]);
            }
            
        }
    }

    public function removeUser()
    {
        // return view('flights/view');
        $CompanyUsersModal = new CompanyUsersModal();

        $user_id = $this->request->getPost('user_id');
        $tenant_id = $this->request->getPost('tenant_id');

        $CompanyUsersModal->where('user_id', $user_id)->where('company_id', $tenant_id)->delete();


        return $this->response->setJSON([
            'status' => true,
        ]);
    }

    public function makeAdmin()
    {
        // return view('flights/view');
        $CompanyUsersModal = new CompanyUsersModal();

        $user_id = $this->request->getPost('user_id');
        $tenant_id = $this->request->getPost('tenant_id');
        $record_id = $this->request->getPost('record_id');
        
        $values = [
            'is_admin'=>1
        ];


        $CompanyUsersModal->update($record_id, $values);

        return $this->response->setJSON([
            'status' => true,
        ]);
    }


    public function dismissAdmin()
    {
        // return view('flights/view');
        $CompanyUsersModal = new CompanyUsersModal();

        $user_id = $this->request->getPost('user_id');
        $tenant_id = $this->request->getPost('tenant_id');
        $record_id = $this->request->getPost('record_id');
        
        $values = [
            'is_admin'=>0
        ];


        $CompanyUsersModal->update($record_id, $values);;


        return $this->response->setJSON([
            'status' => true,
        ]);
    }

    public function searchUsersForCompany(){
        $username = $this->request->getPost('username');
        $company_id = $this->request->getPost('company_id');
     
        $CompanyUsersModal = new CompanyUsersModal();

        
        $users = $CompanyUsersModal->getUsersNotInCompany($company_id,$username);
        return $this->response->setJSON([
            'status' => true,
            'data' => $users
        ]);
    }

    public function addUserToCompany(){
        $user_id = $this->request->getPost('user_id');
        $company_id = $this->request->getPost('company_id');

        $CompanyUsersModal = new CompanyUsersModal();
       
        $data = [
            'company_id' => $company_id,
            'user_id' => $user_id
        ];

        $CompanyUsersModal->insert($data);
        
        return $this->response->setJSON([
            'status' => true,
            'data' => 'users Added',
        ]);
    }
}
