<?php

namespace App\Controllers;

use App\Models\Usermodel;
use App\Models\MileageModel;
use App\Models\AirlinesModel;


helper(['session']);

class Users extends BaseController
{
    public function manage()
    {
        // Manage Add Edit
        return view('users/manage');
    }


    public function profile()
    {
        $userModel = new UserModel();
        if ($this->request->isAJAX()) {
            if ($this->request->getPost('password')) {
                $checkPassword = $userModel->login(session()->email, $this->request->getPost('current_password'));
                if (!$checkPassword['status']) {
                    return $this->response->setJSON([
                        'status' => false,
                        'data' => 'Incorrect Password',
                        'token' => csrf_hash()
                    ]);
                }
                $userData = [
                    'password' => password_hash((string)$this->request->getPost('password'), PASSWORD_DEFAULT)
                ];
            } else {
                $userData = [
                    'fname' => $this->request->getPost('fname'),
                    'lname' => $this->request->getPost('lname'),
                    'phone' => $this->request->getPost('phone_formatted'),
                    'phone_code' => $this->request->getPost('phone_code'),
                    'country_code' => $this->request->getPost('country_code'),
                ];
            }
            $result = $userModel->update(session()->user_id, $userData);
            if ($result) {
                return $this->response->setJSON([
                    'status' => true,
                    'data' => 'Profile Updated',
                    'token' => csrf_hash()
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'data' => 'Connection Error',
                    'token' => csrf_hash()
                ]);
            }
        } else {
            $mileageModel = new MileageModel();
            $user_data = $userModel->get(session()->user_id);
            $mileage_accounts_data = $mileageModel->getByUserID(session()->user_id);
            return view('users/profile', [
                'user_data' => $user_data,
                'mileage_accounts_data' => $mileage_accounts_data
            ]);
        }
    }

    public function view()
    {
        // View All Users
        $userModel = new UserModel();
        
        $result = $userModel->getAllUsers();
            

        $data=[
            'users'=>$result
        ];

        return view('users/view',$data);
    }

    public function user()
    {
        if ($this->request->getGet('id')) {
            $user_id = $this->request->getGet('id');



            $userModel = new UserModel();
            $user = $userModel->where('id',$user_id )
                                    ->first();


            $mileageModel = new MileageModel();
     

            $mileageAccounts = $mileageModel->getByUserID($user_id);

            $airlinesModel = new AirlinesModel();
        
          
            $airlines = $airlinesModel->getAllAirlines();


            $data['airlines'] = $airlines;

            $data['mileageAccounts'] = $mileageAccounts;
            $data['user'] = $user;
        
            

            return view('users/user',$data);


        }
        // View single user
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $userModel = new UserModel();

        
            $postData = $this->request->getPost();

            
           

            if(isset($postData['id']) && !empty($postData['id'])){
                $userId = $userModel->update($postData['id'],$postData);
            }else{
                $emailExists = $userModel->checkEmailExists($postData['email']);
                if ($emailExists) {
                    return $this->response->setJSON([
                        'status' => false,
                        'msg' => "Email already exists.",
                    ]);
                    exit();
                }
                $userId = $userModel->insert($postData);
            }

          
            

            if ($userId) {
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

    public function delete(){

        $id = $this->request->getPost('id');

        $userModel = new UserModel();
        
        $data = [
            'is_deleted' =>1,
        ];
        $result = $userModel->update($id, $data);
        if ($result) {
            
            return $this->response->setJSON([
                'status' => true,
                'data' => 'user deleted.',
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
          

            $userModel = new UserModel();


            $id = $this->request->getGet('id');

            $user = $userModel->where('id', $id)
                                ->first();


            $user['is_edit']=1;
           
            $data['user'] = $user;


            return view('users/manage', $data);
                     
        }
    }

    public function saveMileageAccount()
    {
        if ($this->request->isAJAX()) {
            $mileageModel = new MileageModel();

            $postData = $this->request->getPost();

            if(isset($postData['id']) && !empty($postData['id'])){
                $planId = $mileageModel->update($postData['id'],$postData);
            }else{
                $planId = $mileageModel->insert($postData);
            }

            if ($planId) {
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

    
    public function deleteMileageAccount(){
        $id = $this->request->getPost('id');

        $mileageModel = new MileageModel();
        
        $data = [
            'is_deleted' =>1,
        ];
        $result = $mileageModel->update($id, $data);
        if ($result) {
            
            return $this->response->setJSON([
                'status' => true,
                'data' => 'Account deleted.',
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'data' => 'Connection Error.', 
            ]);
        }
    }
}
