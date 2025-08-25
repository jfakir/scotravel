<?php

namespace App\Controllers;
use App\Models\RemindersModel;

class Notification extends BaseController
{
    public function save()
    {
        if ($this->request->isAJAX()) {
            $RemindersModel = new RemindersModel();

            $postData = $this->request->getPost();

            
            if(isset($postData['id']) && !empty($postData['id'])){
                $id = $RemindersModel->update($postData['id'],$postData);
            }else{
                $id = $RemindersModel->insert($postData);
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

    public function delete(){

        $id = $this->request->getPost('id');

        $RemindersModel = new RemindersModel();
        
        $data = [
            'is_deleted' =>1,
        ];
        
        $result = $RemindersModel->update($id, $data);
        if ($result) {
            
            return $this->response->setJSON([
                'status' => true,
                'data' => 'Notification deleted.',
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'data' => 'Connection Error.', 
            ]);
        }
    }
}
