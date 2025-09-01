<?php

namespace App\Controllers;
use App\Models\AirportsModel;
use App\Models\CitiesModel;
use App\Models\AirlinesModel;
use App\Models\PlanModel;
use App\Models\PlansUsersModal;
use App\Models\PlanAttachmentsModel;
use App\Models\UserConfirmationsModel;

class Plans extends BaseController
{
   
    public function save()
    {
        if ($this->request->isAJAX()) {
            $plansUsersModal = new PlansUsersModal();
            $PlanModel = new PlanModel();
            $userConfirmationsModel = new UserConfirmationsModel();

        
            $postData = $this->request->getPost();
            $postData = $this->request->getPost();

            // Debug confirmation fields
            log_message('debug', 'Confirmation fields: ' . print_r($postData['confirmation_fields'] ?? [], true));

            
            $trip_id = $postData['trip_id'];

            if(isset($postData['starting_date']) && !empty($postData['starting_date'])){
                $startingDate = new \DateTime($postData['starting_date']);
                $postData['starting_date'] = $startingDate->format('Y-m-d');
            }

            if(isset($postData['ending_date']) && !empty($postData['ending_date'])){
                $endingDate = new \DateTime($postData['ending_date']);
                $postData['ending_date'] = $endingDate->format('Y-m-d');
            }else{
                $postData['ending_date'] = NULL;
            }
            
            // Convert starting_time and ending_time to 24-hour format
            if(isset($postData['starting_time']) && !empty($postData['starting_time'])){
                $startingTime = new \DateTime($postData['starting_time']);
                $postData['starting_time'] = $startingTime->format('H:i');
            }else{
                $postData['starting_time'] = NULL;
            }
            
            if(isset($postData['ending_time']) && !empty($postData['ending_time'])){
                $endingTime = new \DateTime($postData['ending_time']);
                $postData['ending_time'] = $endingTime->format('H:i');
            }else{
                $postData['ending_time'] = NULL;
            }
            
            

            if(isset($postData['id']) && !empty($postData['id'])){

                $planId = $PlanModel->update($postData['id'],$postData);

                $plansUsersModal->where('plan_id', $postData['id'])->delete();

                if(isset($postData['travelers_id']) && !empty($postData['travelers_id'])){
                    $travelers_id = $postData['travelers_id'];
                    foreach ($travelers_id as $travelerId) {
                            $data = [
                                'plan_id' => $postData['id'] ,
                                'user_id' => $travelerId
                            ];
                    
                        $plansUsersModal->insert($data);
                    }
                }
                 $confirmationNumber=$postData['confirmation_fields'];     
                  foreach ($confirmationNumber as $userId => $confirmationNumber) {
                    if (!empty($confirmationNumber)) {
                        $existing = $userConfirmationsModel
                            ->where('planId', $postData['id'] )
                            ->where('userId', $userId)
                            ->first();

                        if ($existing && isset($existing['id'])) {
                            $userConfirmationsModel->update($existing['id'], [
                                'confirmationNumber' => $confirmationNumber
                            ]);
                        } else {
                            // insert new row
                            $userConfirmationsModel->insert([
                                'planId'             => $postData['id'],
                                'userId'             => $userId,
                                'confirmationNumber' => $confirmationNumber
                            ]);
                        }
                    }
                    
                }

            }else{

                $planId = $PlanModel->insert($postData);
                if(isset($postData['travelers_id']) && !empty($postData['travelers_id'])){
                        $travelers_id = $postData['travelers_id'];
                        foreach ($travelers_id as $travelerId) {
                            $data = [
                                'plan_id' => $planId ,
                                'user_id' => $travelerId
                            ];
                    
                        $plansUsersModal->insert($data);
                    }
                }
                 if(isset($postData['confirmation_fields']) && !empty($postData['confirmation_fields'])){
                    foreach($postData['confirmation_fields'] as $userId => $confirmationNumber){
                        if(!empty($confirmationNumber)){
                            $userConfirmationsModel->insert([
                                'planId' => $planId,
                                'userId' => $userId,
                                'confirmationNumber' => $confirmationNumber
                            ]);
                        }
                    }
                } 
            
            }

            if ($planId) {
                return $this->response->setJSON([
                    'status' => true,
                    'trip_id' => base64_encode($trip_id)
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                ]);
            }
            
            // $users = $obj['planUsers'];
            // foreach ($users as $user) {
            //         $data = [
            //             'plan_id' => $planId ,
            //             'user_id' => $user['user_id']
            //         ];
            
            //         $plansUsersModal->insert($data);
            // }

        
        }
    }


    public function edit()
    {
        if ($this->request->getGet('id')) {
          


            $PlanModel = new PlanModel();
            $plansUsersModal = new plansUsersModal();

            $planId = $this->request->getGet('id');

            $plan = $PlanModel->where('id', $planId)
                                ->first();

            $plan['is_edit']=1;
           
            $data['plan'] = $plan;
            $planUsers = $plansUsersModal->getPlanUsers($planId);


            if($plan['plan_type']==1){
              
                $data['travelers'] = session()->trip_users;
                $data['planUsers'] = $planUsers;
                return view('activities/manage', $data);
            } 
            else if($plan['plan_type']==2){
              
                $data['travelers'] = session()->trip_users;
                $data['planUsers'] = $planUsers;
                return view('carrentings/manage',$data);
            }
            else if($plan['plan_type']==4){
              
                $data['travelers'] = session()->trip_users;
                $data['planUsers'] = $planUsers;

                return view('lodgings/manage',$data);
            }
            else if($plan['plan_type']==5){
              
                $data['travelers'] = session()->trip_users;
                $data['planUsers'] = $planUsers;

                return view('restaurants/manage',$data);
            }
            else if($plan['plan_type']==6){
              
                $data['travelers'] = session()->trip_users;
                $data['planUsers'] = $planUsers;

                return view('transportations/manage',$data);
            }
            else if($plan['plan_type']==3){
                $airportsModel = new AirportsModel();
                $CitiesModel = new CitiesModel();
                $airlinesModel = new AirlinesModel();
        
                $airports = $airportsModel->getAllAirports();
                $allCities = $CitiesModel->get10Cities();
                $airlines = $airlinesModel->getAllAirlines();


                $data['airports'] = $airports;
                $data['allCities'] = $allCities;
                $data['airlines'] = $airlines;
                $data['travelers'] = session()->trip_users;
                $data['planUsers'] = $planUsers;
                if($plan['is_layover']==1){
                    return view('layovers/manage', $data);
                }else{
                    return view('flights/manage', $data);
                }
            }                
        }
    }

    public function deletePlan(){

        $id = $this->request->getPost('id');

        $PlanModel = new PlanModel();
        
        $data = [
            'is_deleted' =>1,
        ];
        $result = $PlanModel->update($id, $data);
        if ($result) {
            
            return $this->response->setJSON([
                'status' => true,
                'data' => 'plan deleted.',
                'trip_id' => base64_encode(session()->trip_id)
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'data' => 'Connection Error.', 
            ]);
        }
    }

    public function getPlanTravelers(){
        $plansUsersModal = new PlansUsersModal();

        $id = $this->request->getPost('id');

        $users = $plansUsersModal->getPlanUsers($id);
        
        return $this->response->setJSON([
            'status' => true,
            'data' => $users, 
        ]);
    }

    
    // public function getPlanAttachmentsById(){
    //     $json = file_get_contents('php://input');
    //     $obj  = json_decode($json, true);

    //     if (empty($obj['id'])) {
    //         return $this->response->setJSON([
    //             'status'  => false,
    //             'message' => 'Missing plan id',
    //         ]);
    //     }

    //     $planAttachmentsModel = new PlanAttachmentsModel();

    //     $attachments = $planAttachmentsModel
    //         ->where('plan_id', $obj['id'])
    //         ->where('is_deleted', 0)
    //         ->findAll();

    //     return $this->response->setJSON([
    //         'status' => true,
    //         'data'   => $attachments,
    //     ]);
    // }

   public function addAttachment(){
    $planAttachmentsModel = new PlanAttachmentsModel();
    $file = $this->request->getFile('planAttachment');
    $plan_id = $this->request->getPost('id'); 

    if ($file && $file->isValid() && !$file->hasMoved()) {
        $ext = $file->getClientExtension();
        $name = $file->getClientName();

        $allowedExtensions = ['pdf', 'png', 'jpg', 'jpeg'];
        if (in_array($ext, $allowedExtensions)) {
            $data = [
                'plan_id'=> $plan_id,
                'name' => $name,
                'extension' => $ext,
                'is_deleted' => 1,
            ];
            $attachmentId = $planAttachmentsModel->insert($data);

            if ($attachmentId) {
                $file->move(FCPATH . '../public/assets/plan_attachments', $attachmentId . '.' . $ext);
                return $this->response->setJSON([
                    'status' => true,
                    'data' => 'File uploaded.',
                    'id' => $attachmentId,
                    'name' => $name,
                    'plan_id' => $plan_id
                ]);
            } else {
                return $this->response->setJSON(['status' => false,'data' => 'Connection Error.']);
            }
        } else {
            return $this->response->setJSON(['status' => false,'data' => 'Invalid file type.']);
        }
    }
}

//     public function addAttachment(){
//     $planAttachmentsModel = new PlanAttachmentsModel();
//     $attachmentId = null;

//     // Get plan ID (works for both web & mobile)
//     $planId = $this->request->getPost('id') ?? $this->request->getPost('planId');

//     if (!$planId) {
//         return $this->response->setJSON([
//             'status' => false,
//             'message' => 'planId is required'
//         ]);
//     }

//     // Handle uploaded file (works for both cases)
//     $file = $this->request->getFile('planAttachment') ?? $this->request->getFile('file');

//     if ($file && $file->isValid() && !$file->hasMoved()) {
//         $ext = $file->getClientExtension();
//         $name = $file->getClientName();

//         $allowedExtensions = ['pdf', 'png', 'jpg', 'jpeg'];
//         if (!in_array($ext, $allowedExtensions)) {
//             return $this->response->setJSON([
//                 'status' => false,
//                 'message' => 'Invalid file type'
//             ]);
//         }

//         // Insert record in DB
//         $data = [
//             'plan_id'   => $planId,
//             'name'      => $name,
//             'extension' => $ext,
//             'is_deleted'=> 0, // keep as active
//         ];
//         $attachmentId = $planAttachmentsModel->insert($data);

//         if ($attachmentId) {
//             // Move uploaded file (use one consistent folder)
//             $file->move(FCPATH . '../public/assets/plan_attachments', $attachmentId . '.' . $ext);

//             return $this->response->setJSON([
//                 'status' => true,
//                 'message'=> 'File uploaded successfully',
//                 'id'     => $attachmentId,
//                 'name'   => $name,
//                 'plan_id'=> $planId
//             ]);
//         }
//     }

//     return $this->response->setJSON([
//         'status' => false,
//         'message'=> 'Upload failed'
//     ]);
// }


     public function updateAttachment(){
        $planAttachmentsModel = new PlanAttachmentsModel();

        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');
        $plan_id = $this->request->getPost('plan_id');
    
        $data = [
            'name' => $name,
            'is_deleted' => 0, 
        ];

        $attachId = $planAttachmentsModel->update($id,$data);
      
        if ($attachId) {
            return $this->response->setJSON([
                'status' => true,
                'plan_id' => $plan_id,
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
            ]);
        }
    }

    public function getAttachments(){
        $planId = $this->request->getGet('plan_id'); 
        // $attachments = $planAttachmentsModel->getAttachmentsByPlanId($planId);

         $planAttachmentsModel = new PlanAttachmentsModel();

  
        
        $attachments = $planAttachmentsModel->select('*')
                                        ->where('is_deleted', 0)
                                        ->where('plan_id', $planId)
                                        ->findAll();
                                        

        return $this->response->setJSON([
            'status' => true,
            'data'   => $attachments
        ]);
  }

// public function getAttachments()
// {
//     $planId = null;

//     // Try GET first
//     if ($this->request->getGet('plan_id')) {
//         $planId = $this->request->getGet('plan_id');
//     } else {
//         // Fallback: Try JSON body (for mobile)
//         $json = file_get_contents('php://input');
//         if (!empty($json)) {
//             $obj = json_decode($json, true);
//             $planId = $obj['id'] ?? null;
//         }
//     }

//     if (!$planId) {
//         return $this->response->setJSON([
//             'status' => false,
//             'message' => 'plan_id is required'
//         ]);
//     }

//     $planAttachmentsModel = new PlanAttachmentsModel();
//     $attachments = $planAttachmentsModel
//                         ->where('plan_id', $planId)
//                         ->where('is_deleted', 0)
//                         ->findAll();

//     return $this->response->setJSON([
//         'status' => true,
//         'data'   => $attachments
//     ]);
// }



  public function deleteAttachment(){
    $id = $this->request->getPost('id');

    $planAttachmentsModel = new PlanAttachmentsModel();
    $attachment = $planAttachmentsModel->find($id);

    if ($attachment) {
        // soft delete
        $planAttachmentsModel->update($id, ['is_deleted' => 1]);

        return $this->response->setJSON([
            'status' => true,
            'plan_id' => $attachment['plan_id']
        ]);
    }

    return $this->response->setJSON(['status' => false]);
 }

    // public function downloadAttachment()
    // {
    //     $id = $this->request->getGet('id');
    //     $extension = $this->request->getGet('extension');
    //     $name = $this->request->getGet('name');

        

    //     $filePath = FCPATH . 'assets\plan_attachments\\' . $id . '.' . $extension;

    //     // Debugging: print file path
    //     echo "File Path: " . $filePath . "<br>";

    //     if (file_exists($filePath)) {
    //         echo "File exists.<br>";

    //         // Clean the output buffer
    //         ob_clean();
    //         flush();

    //         // Set headers for download
    //         header('Content-Description: File Transfer');
    //         header('Content-Type: application/octet-stream');
    //         header('Content-Disposition: attachment; filename="' . $name.'.'.$extension);
    //         header('Content-Transfer-Encoding: binary');
    //         header('Expires: 0');
    //         header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    //         header('Pragma: public');
    //         header('Content-Length: ' . filesize($filePath));

    //         // Read the file and output its contents
    //         readfile($filePath);
    //         exit();
    //     } else {
    //         echo "File does not exist.<br>";
    //     }
    // }

    public function downloadAttachment(){
        $id = $this->request->getGet('id');
        $extension = $this->request->getGet('extension');
        $name = $this->request->getGet('name');

        $filePath = FCPATH . "assets/plan_attachments/" . $id . "." . $extension;

        if (file_exists($filePath)) {
            return $this->response->download($filePath, null)
                                ->setFileName($name);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }



}
