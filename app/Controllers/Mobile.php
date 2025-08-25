<?php

namespace App\Controllers;
// use CodeIgniter\API\ResponseTrait;
use App\Models\ForgetPasswordmodel;
use App\Models\Usermodel;
use App\Models\CitiesModel;
use App\Models\TripsModal;
use App\Models\TripsUsersModal;
use App\Models\PlanModel;
use App\Models\AirlinesModel;
use App\Models\AirportsModel;

use App\Models\CompanyModel;
use App\Models\CompanyUsersModal;
use App\Models\PlanAttachmentsModel;
use App\Models\PlansUsersModal;

use App\Models\MileageModel;
use App\Models\RemindersModel;



use App\Models\FlightsLayoversModel;
use App\Models\TripAttachmentsModel;


use App\Models\UserConfirmationsModel;


class Mobile extends BaseController
{

    // use ResponseTrait;
    public function signup()
    {
        // $userModel = new UserModel();
		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
        // return $this->response->setJSON(54353);


        $userModel = new UserModel();
        $obj = $obj['values'];


        if ($userModel->checkEmailExists($obj['email'])) {
            return $this->response->setJSON([
                'status' => false,
                'data' => 'Email already exists.'
            ]);
        }
     
        // if ($userModel->checkPhoneExists($obj['phone'])) {
        //     return $this->response->setJSON([
        //         'status' => false,
        //         'data' => 'Phone already exists.'
        //     ]);
        // }

  
        $password = password_hash((string)$obj['password'], PASSWORD_DEFAULT);
        $userData = [
            'fname' => $obj['fname'],
            'lname' =>  $obj['lname'],
            'email' =>  $obj['email'],
            'country_code' =>  $obj['country_code'],
            'phone_code' =>  $obj['phone_code'],
            'phone' =>  $obj['phone'],
            'password' => $password,
            'account_type' =>  $obj['accountType'],
            'is_subscribed' => $obj['is_subscribed']
        ];


        

        $userID = $userModel->addUser($userData);
        $encodedUserID = base64_encode($userID);
        $emailContent = '
        <html>
        <head>
        <title>Verify Your Account - ScoTravel</title>
        </head>
        <body>
        <p>Dear ' . $obj['fname'] . ',</p>
        <p>Thank you for signing up with ScoTravel! To complete your registration, please click on the link below to verify your account:</p>
        <p><a href="' . base_url() . 'verifyAccount?userID=' . $encodedUserID . '">Verify Account</a></p>
        <p>If you did not sign up for a ScoTravel account, please ignore this email.</p>
        <p>Thank you,</p>
        <p>ScoTravel Support Team</p>
        </body>
        </html>
        ';
        

        $email = \Config\Services::email();
        $email->setFrom('no-reply@sconet.com', 'ScoTravel Support Team');
        $email->setTo($obj['email']);
        $email->setSubject('Verify Your ScoTravel Account');
        $email->setMessage($emailContent);
        $email->setMailType('html'); // Set email content type to HTML for proper formatting
        $email->send();

        if ($userID) {
            return $this->response->setJSON([
                'status' => true,
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
            ]);
        }
        


    }
    public function login()
    {
        // $userModel = new UserModel();
		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
        // return $this->response->setJSON(54353);


        $userModel = new UserModel();
        $obj = $obj['values'];


        $result = $userModel->login($obj['email'], $obj['password']);
        if ($result['status']) { // if we got a status true from the model.
            $user = $result['user'];
            $user_data = [
                'id' => $user['id'],
                'email' => $user['email'],
                'fname' => $user['fname'],
                'lname' => $user['lname'],
                'phone_code' => $user['phone_code'],
                'country_code' => $user['country_code'],
                'phone' => $user['phone'],
                'account_type' => $user['account_type'],
                'access_type' => $user['access_type'],
            ];
      
            return $this->response->setJSON([
                'status' => true,
                'result' =>  $user_data
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'result' => "Invalid login."
            ]);
        }

    }

    public function updatename(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);
        // return $this->response->setJSON(54353);


        $userModel = new UserModel();
        $obj = $obj['values'];

        $userData = [
            'fname' =>$obj['fname'],
            'lname' =>$obj['lname'],
            'phone_code' => $obj['phone_code'],
            'country_code' => $obj['country_code'],
            'phone' => $obj['phone'],
        ];

        $result = $userModel->update($obj['id'], $userData);
        if ($result) {
            $user_data = $userModel->get($obj['id']);
            return $this->response->setJSON([
                'status' => true,
                'data' => 'Profile updated.',
                'result' => $user_data
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'data' => 'Connection Error.',
            ]);
        }
    }

    public function changepassword(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);
        // return $this->response->setJSON(54353);


        $userModel = new UserModel();
        $obj = $obj['values'];
        $result = $userModel->login($obj['email'], $obj['currentPassword']);
        if ($result['status']) { // if we got a status true from the model.
            $password = password_hash((string)$obj['password'], PASSWORD_DEFAULT);
            $userData = [
                'password' => $password,
            ];
            $result = $userModel->update($obj['id'], $userData);
            if ($result) {
                $user_data = $userModel->get($obj['id']);
                return $this->response->setJSON([
                    'status' => true,
                    'data' => 'Password changed.',
                    'result' => $user_data
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'data' => 'Connection Error.',
                ]);
            }
        } else {
            return $this->response->setJSON([
                'status' => false,
                'data' => "Current password is incorrect."
            ]);
        }
    }

    public function changeUserPassword(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);
        // return $this->response->setJSON(54353);


        $userModel = new UserModel();
        $obj = $obj['values'];
        $password = password_hash((string)$obj['password'], PASSWORD_DEFAULT);
        $userData = [
            'password' => $password,
        ];
        $result = $userModel->update($obj['id'], $userData);
        if ($result) {
            return $this->response->setJSON([
                'status' => true,
                'data' => 'Password changed.',
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'data' => 'Connection Error.',
            ]);
        }
     
    }

    public function forgetpassword(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);
        // return $this->response->setJSON(54353);


        $userModel = new UserModel();
        $obj = $obj['values'];
        
        $userEmail = $obj['email'];

        $user = $userModel->getByMail($userEmail);
        if (!$user) {
            return $this->response->setJSON([
                'status' => false,
                'data' => 'Email not found.'
            ]);
        }
        $userID = $user['id'];
        $encodedUserID = base64_encode($userID);
        $forgetPasswordModel = new ForgetPasswordModel();
        $tokenData = [
            'user_id' => $userID,
            'token' => $encodedUserID,
        ];
        $token = $forgetPasswordModel->addToken($tokenData);
        if (!$token) {
            return $this->response->setJSON([
                'status' => false,
                'data' => 'Unable to generate reset link.'
            ]);
        }
        $emailContent = '
        <html>
        <head>
        <title>Reset Your Password - ScoTravel</title>
        </head>
        <body>
        <p>Dear ' . $user['fname'] . ' ' . $user['lname'] . ',</p>
        <p>You have requested to reset your passowrd. To complete the process, please click on the link below:</p>
        <p><a href="' . base_url() . 'resetPassword?token=' . $encodedUserID . '">Reset Password</a></p>
        <p>If you did not request to reset password, please ignore this email.</p>
        <p style="color:red !important;">This link will expire after 2 days.</p>
        <p>Thank you,</p>
        <p>ScoTravel Support Team</p>
        </body>
        </html>
        ';

        $email = \Config\Services::email();
        $email->setFrom('no-reply@sconet.com', 'ScoTravel Support Team');
        $email->setTo($userEmail);
        $email->setSubject('Reset Password Of Your ScoTravel Account');
        $email->setMessage($emailContent);
        $email->setMailType('html'); // Set email content type to HTML for proper formatting
        $email->send();

        return $this->response->setJSON([
            'status' => true,
        ]);

       
    }


    public function deleteaccount(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);
        // return $this->response->setJSON(54353);


        $userModel = new UserModel();
        $obj = $obj['values'];
        

        $userData = [
            'is_deleted' =>1,
        ];
        $result = $userModel->update($obj['id'], $userData);
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

    public function getAllCities(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $citiesModel = new CitiesModel();
        

     
        $result = $citiesModel->getAllCities();
        if ($result) {
            
            return $this->response->setJSON([
                'status' => true,
                'data' => $result,
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'data' => 'Connection Error.',
            ]);
        }
    }

    public function getAllAirlines(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $airlinesModel = new AirlinesModel();
        

     
        $result = $airlinesModel->getAllAirlines();
        if ($result) {
            return $this->response->setJSON([
                'status' => true,
                'data' => $result,
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'data' => 'Connection Error.',
            ]);
        }
    }

    public function getAllAirports(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $airportsModel = new AirportsModel();
        

     
        $result = $airportsModel->getAllAirports();
        if ($result) {
            return $this->response->setJSON([
                'status' => true,
                'data' => $result,
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'data' => 'Connection Error.',
            ]);
        }
    }
    

    public function saveTrip(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $tripsModal = new TripsModal();
        $tripsUsersModal = new TripsUsersModal();
        $obj = $obj['values'];

        if(isset($obj['image_url'])&&!empty($obj['image_url'])){
            $url = $obj['image_url'];
        }else{
            $url ='https://images.unsplash.com/photo-1493612276216-ee3925520721?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w0NDg2NzF8MHwxfHNlYXJjaHwxfHxyYW5kb218ZW58MHx8fHwxNzE5OTIzODEyfDA&ixlib=rb-4.0.3&q=80&w=1080';
        }

        $tripData = [
            'name' =>$obj['name'],
            'destination_id' =>$obj['destination_id'],
            'company_id' =>$obj['company_id'],
            'image_url' =>$url,
            'starting_date' => $obj['starting_date'],
            'ending_date' => $obj['ending_date'],
            'is_round_trip' => $obj['is_round_trip'],
        ];

     

        $tripId = $tripsModal->addTrip($tripData);

        $created_by=$obj['user_id'];
        $tripsUsersData = [
            'trip_id' =>$tripId,
            'user_id' =>$created_by,
            'is_admin' =>1,
        ];

        $result = $tripsUsersModal->addRecord($tripsUsersData);
     
        $users = $obj['tripUsers'];
        if(intval($obj['isSingleUserTrip'])==1){
            $data = [
                'is_traveler' => 1,
            ];
            $tripsUsersModal->update($result,$data);
        }else{
            foreach ($users as $user) {
                if($created_by==$user["user_id"]){
                    $data = [
                        'is_traveler' => 1,
                    ];
                    $tripsUsersModal->update($result,$data);
                }else{
                    $data = [
                        'trip_id' => $tripId ,
                        'user_id' => $user['user_id'],
                        'is_traveler' => 1,
                    ];
            
                    $tripsUsersModal->insert($data);
                }
              
            }
        }
        


        if ($tripId) {
            return $this->response->setJSON([
                'status' => true,
                'result' => $result,
                'isSingleUserTrip' => $obj['isSingleUserTrip'],
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
            ]);
        }
    }

    public function getTrips(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $tripsModal = new TripsModal();
        // $obj = $obj['values'];

        
        $trips = $tripsModal->getTrips($obj['user_id'],$obj['fromDate'],$obj['toDate'],$obj['selectedCompanies'],$obj['selectedUsers']);
        // if ($trips) {
            return $this->response->setJSON([
                'status' => true,
                'data' => $trips[0],
                'past_trips' => $trips[1]
            ]);
        // } else {
        //     return $this->response->setJSON([
        //         'status' => false,
        //     ]);
        // }
    }
  
    public function deleteTrip(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);
        // return $this->response->setJSON(54353);


        $tripsModal = new TripsModal();
        $obj = $obj['values'];
        

        $data = [
            'is_deleted' =>1,
        ];
        $result = $tripsModal->update($obj['id'], $data);
        if ($result) {
            
            return $this->response->setJSON([
                'status' => true,
                'data' => 'Trip deleted.',
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'data' => 'Connection Error.',
            ]);
        }
    }
    
    public function updateTrip(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);
        // return $this->response->setJSON(54353);


        $tripsModal = new TripsModal();
        $tripsUsersModal = new TripsUsersModal();

        $obj = $obj['values'];


        

     
        $result = $tripsModal->update($obj['id'], $obj);

        $users = $obj['tripUsers'];
        // foreach ($users as $user) {
        //     $existingRecord = $tripsUsersModal->select(['trip_id' => $obj['id'], 'user_id' => $user['user_id']]);
    
        //     if (!$existingRecord) {
        //         $data = [
        //             'trip_id' => $obj['id'],
        //             'user_id' => $user['user_id']
        //         ];
        //         $tripsUsersModal->insert($data);
        //     }

       
        // }

        // Create an array of user IDs from the $users array
        $userIds = array_column($users, 'user_id');

  

        // If $userIds array is empty, delete all records for the trip_id
if (empty($userIds)) {
    $tripsUsersModal->where('trip_id', $obj['id'])->delete();
} else {
    // Delete records where user_id is not in the $userIds array
    $tripsUsersModal->where('trip_id', $obj['id'])->whereNotIn('user_id', $userIds)->delete();
}


        // Insert new records from the $users array using ON DUPLICATE KEY UPDATE
        foreach ($users as $user) {
       
            $existingRecord = $tripsUsersModal->where('trip_id', $obj['id'])
            ->where('user_id', $user['user_id'])
            // ->where('is_traveler',1)
            ->first();

            if (!$existingRecord) {
                $data = [
                    'trip_id' => $obj['id'],
                    'user_id' => $user['user_id'],
                    'is_traveler' => 1,
                ];
                $tripsUsersModal->insert($data);
            }
        }

        if ($result) {
            
            return $this->response->setJSON([
                'status' => true,
                // 'data' => 'Trip updated.',
                'data' => $userIds,
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'data' => 'Connection Error.',
            ]);
        }
    }

    // public function savePlan(){
    //     $json = file_get_contents('php://input');
	// 	$obj = json_decode($json,true);


    //     $PlanModel = new PlanModel();
    //     $plansUsersModal = new PlansUsersModal();
    //     $values = $obj['values'];
     
    //     $timeZone  = $values['timezone'];
	// 	date_default_timezone_set($timeZone);

    //     $planId = $PlanModel->insert($values);

    //     if(isset($values['is_layover'])&&$values['is_layover']==1){
            
    //         $FlightsLayoversModel = new FlightsLayoversModel();

    //         $data = [
    //             'flight_id' => $values['flight_id'],
    //             'flight_layover_id' => $planId 
    //         ];

    //         $FlightsLayoversModel->insert($data);
    //     }
        
    //     $users = $obj['planUsers'];
    //     foreach ($users as $user) {
    //             $data = [
    //                 'plan_id' => $planId ,
    //                 'user_id' => $user['user_id']
    //             ];
        
    //             $plansUsersModal->insert($data);
    //     }
      
    //     if ($planId) {
    //         return $this->response->setJSON([
    //             'status' => true,
    //         ]);
    //     } else {
    //         return $this->response->setJSON([
    //             'status' => false,
    //         ]);
    //     }
    // }

    public function savePlan() {
    $json = file_get_contents('php://input');
    $obj = json_decode($json, true);

    $PlanModel = new PlanModel();
    $plansUsersModal = new PlansUsersModal();
    $UserConfirmationsModel = new UserConfirmationsModel();

    $values = $obj['values'];
    $confirmationsByUser = $obj['confirmationsByUser'] ?? [];
    $users = $obj['planUsers'];

    $timeZone = $values['timezone'];
    date_default_timezone_set($timeZone);

    $planId = $PlanModel->insert($values);

    if (isset($values['is_layover']) && $values['is_layover'] == 1) {
        $FlightsLayoversModel = new FlightsLayoversModel();

        $data = [
            'flight_id' => $values['flight_id'],
            'flight_layover_id' => $planId 
        ];

        $FlightsLayoversModel->insert($data);
    }

    // Insert plan users
    foreach ($users as $user) {
        $data = [
            'plan_id' => $planId,
            'user_id' => $user['user_id']
        ];
        $plansUsersModal->insert($data);
    }

    // Insert confirmations
    foreach ($confirmationsByUser as $userId => $confirmationNumber) {
        if (trim($confirmationNumber) !== '') {
            $UserConfirmationsModel->insert([
                'userId' => $userId,
                'planId' => $planId,
                'confirmationNumber' => $confirmationNumber,
                'isDeleted' => 0
            ]);
        }
    }

    if ($planId) {
        return $this->response->setJSON(['status' => true]);
    } else {
        return $this->response->setJSON(['status' => false]);
    }
}


    // public function updatePlan(){
    //     $json = file_get_contents('php://input');
	// 	$obj = json_decode($json,true);


    //     $PlanModel = new PlanModel();
    //     $plansUsersModal = new PlansUsersModal();
    //     $values = $obj['values'];
     
    //     $timeZone  = $values['timezone'];
	// 	date_default_timezone_set($timeZone);
        
    //     $planId = $PlanModel->update($values['id'],$values);

    //     $plansUsersModal->where('plan_id', $values['id'])->delete();
    //     $users = $obj['planUsers'];
    //     foreach ($users as $user) {
    //         $data = [
    //             'plan_id' => $values['id'],
    //             'user_id' => $user['user_id']
    //         ];
    //         $plansUsersModal->insert($data);
    //     }
      
    //     if ($planId) {
    //         return $this->response->setJSON([
    //             'status' => true,
    //         ]);
    //     } else {
    //         return $this->response->setJSON([
    //             'status' => false,
    //         ]);
    //     }
    // }

    public function updatePlan() {
    $json = file_get_contents('php://input');
    $obj = json_decode($json, true);

    $PlanModel = new PlanModel();
    $plansUsersModal = new PlansUsersModal();
    $UserConfirmationsModel = new UserConfirmationsModel();

    $values = $obj['values'];
    $confirmationsByUser = $obj['confirmationsByUser'] ?? [];
    $users = $obj['planUsers'];

    $timeZone = $values['timezone'];
    date_default_timezone_set($timeZone);

    $planId = $values['id'];
    $PlanModel->update($planId, $values);

    // Update plan users: delete old, insert new
    $plansUsersModal->where('plan_id', $planId)->delete();

    foreach ($users as $user) {
        unset($user['id']);
        $data = [
            'plan_id' => $planId,
            'user_id' => $user['user_id']
        ];
        $plansUsersModal->insert($data);
    }

    // Update user confirmations: delete old, insert new
    $UserConfirmationsModel->where('planId', $planId)->delete();

    foreach ($confirmationsByUser as $userId => $confirmationNumber) {
        if (trim($confirmationNumber) !== '') {
            $UserConfirmationsModel->insert([
                'userId' => $userId,
                'planId' => $planId,
                'confirmationNumber' => $confirmationNumber,
                'isDeleted' => 0
            ]);
        }
    }

    if ($planId) {
        return $this->response->setJSON(['status' => true]);
    } else {
        return $this->response->setJSON(['status' => false]);
    }
 }

    


    public function getTripPlansAndUsers(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);
        // return $this->response->setJSON(54353);


        $PlanModel = new PlanModel();
        $tripsUsersModal = new TripsUsersModal();
        $tripAttachmentsModel = new TripAttachmentsModel();
       

        $trip_id = $obj['tripId'];
        


        $result = $PlanModel->getAllPlans($trip_id);
        $users = $tripsUsersModal->getTripUsers($trip_id);
        $attachments = $tripAttachmentsModel->getTripAttchments($trip_id);

        // if ($result) {
            
        //     return $this->response->setJSON([
        //         'status' => true,
        //         'plans' => $result
        //     ]);
        // } else {
        //     return $this->response->setJSON([
        //         'status' => false,
        //         'data' => 'Connection Error.',
        //     ]);
        // }
            return $this->response->setJSON([
                'status' => true,
                'plans' => $result,
                'users' => $users,
                'attachments' => $attachments,
                
            ]);
    
    }

    public function getTripUsers(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);

        $tripsUsersModal = new TripsUsersModal();

        $trip_id = $obj['tripId'];
        
        $users = $tripsUsersModal->getTripUsers($trip_id);
      
            return $this->response->setJSON([
                'status' => true,
                'users' => $users,
            ]);
    
    }

      
    public function deletePlan(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $planModel = new PlanModel();
        $obj = $obj['values'];
        

        $data = [
            'is_deleted' =>1,
        ];
        $result = $planModel->update($obj['id'], $data);
        if ($result) {
            
            return $this->response->setJSON([
                'status' => true,
                'data' => 'Plan deleted.',
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'data' => 'Connection Error.',
            ]);
        }
    }



    //////////////////////Companies

    public function getAllCompanies(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $companyModel = new CompanyModel();
        $id = $obj['id'];
        

      
        $result = $companyModel->getAllCompanies($id);
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


    public function saveCompany(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $CompanyModel = new CompanyModel();
        $CompanyUsersModal = new CompanyUsersModal();
        $values = $obj['values'];
     

        $companyId = $CompanyModel->insert($values);
        
        $companyUsersData = [
            'user_id' =>  $values['created_by'],
            'company_id' => $companyId,
            'is_admin' => 1,
        ];

        $CompanyUsersModal->insert($companyUsersData);
      
        if ($companyId) {
            return $this->response->setJSON([
                'status' => true,
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
            ]);
        }
    }

    public function updateCompany(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $CompanyModel = new CompanyModel();
        $tripsUsersModal = new TripsUsersModal();
        $values = $obj['values'];
     

        $companyId = $CompanyModel->update($values['id'],$values);
      
        if ($companyId) {
            return $this->response->setJSON([
                'status' => true,
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
            ]);
        }
    }

    public function deleteCompany(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $CompanyModel = new CompanyModel();
        $obj = $obj['values'];
        

        $data = [
            'is_deleted' =>1,
        ];
        $result = $CompanyModel->update($obj['id'], $data);
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


    public function getCompanyUsers(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $CompanyUsersModal = new CompanyUsersModal();
        // $obj = $obj['id'];

        
        $users = $CompanyUsersModal->getCompanyUsers($obj['id']);
        // if ($trips) {
            return $this->response->setJSON([
                'status' => true,
                'data' => $users
            ]);
    }

    // getAllUsersNotInCompany
    public function getAllUsersNotInCompany(){
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $CompanyUsersModal = new CompanyUsersModal();

        $users = $CompanyUsersModal->getAllUsersNotInCompany($obj['id']);

        return $this->response->setJSON([
            'status' => true,
            'data' => $users
        ]);
    }

    public function searchUsersForCompany(){
        $username = $this->request->getGet('username');
        $company_id = $this->request->getGet('company_id');

     

        $CompanyUsersModal = new CompanyUsersModal();

        
        $users = $CompanyUsersModal->getUsersNotInCompany($company_id,$username);
        // if ($trips) {
            return $this->response->setJSON([
                'status' => true,
                'data' => $users
            ]);
    }

    
    public function addUsersToCompany(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $CompanyUsersModal = new CompanyUsersModal();
        $company_id=  $obj['company_id'];
        $usersIds=  $obj['usersIds'];

        foreach ($usersIds as $userId) {
            $data = [
                'company_id' => $company_id,
                'user_id' => $userId
            ];
    
            $CompanyUsersModal->insert($data);
        }
        
            return $this->response->setJSON([
                'status' => true,
                'data' => 'users Added',
            ]);
    }

        
    public function updateUserCompanyRecord(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $CompanyUsersModal = new CompanyUsersModal();
        $values=  $obj['values'];

    
        $CompanyUsersModal->update($values['id'],$values);
        
        return $this->response->setJSON([
            'status' => true,
            'data' => 'user UPDATED',
        ]);
    }
    
    public function deleteUserCompanyRecord(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $CompanyUsersModal = new CompanyUsersModal();
        $id=  $obj['id'];

    
        $CompanyUsersModal->where('id', $id)->delete();

        return $this->response->setJSON([
            'status' => true,
            'data' => 'user Deleted',
        ]);
    }

    public function leaveCompany(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $CompanyUsersModal = new CompanyUsersModal();
        $obj =$obj ['values'];
        $user_id=  $obj['user_id'];
        $company_id=  $obj['company_id'];

    
        $CompanyUsersModal->where('company_id', $company_id)->where('user_id', $user_id)->delete();

        return $this->response->setJSON([
            'status' => true,
            'data' => 'user Delteed',
        ]);
    }



    public function updateUserCompanies(){
        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);

        $CompanyUsersModal = new CompanyUsersModal();
        $obj = $obj['values'];
        $user_id = $obj['user_id'];
        $newUserCompanies = $obj['newUserCompanies'];

        // $CompanyUsersModal->where('user_id', $user_id)->delete();

        $companyIds = array_column($newUserCompanies, 'company_id');

        // Delete records where user_id matches and company_id is not in the list of companyIds
        if(!empty($companyIds)){
            $CompanyUsersModal->where('user_id', $user_id)
            ->whereNotIn('company_id', $companyIds)
            ->delete();
        }else{
            $CompanyUsersModal->where('user_id', $user_id)
            ->delete();
        }



        foreach ($newUserCompanies as $userCompany) {
            $record = $CompanyUsersModal->where('user_id', $user_id)
                                        ->where('company_id', $userCompany['company_id'])
                                        ->first();
            if (!$record) {
                // Record does not exists
                $data = [
                    'user_id' => $user_id ,
                    'company_id' => $userCompany['company_id'],
                ];
                $CompanyUsersModal->insert($data);
            }

        }

        return $this->response->setJSON([
            'status' => true,
            'data' => 'Success'
        ]);
    }



    
    public function getAllUsers(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);

        $userModel = new UserModel();
        
        $result = $userModel->getAllUsers();
            
        return $this->response->setJSON([
            'status' => true,
            'data' => $result,
        ]);
    }

    public function saveUser(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);



        $userModel = new UserModel();

        $values = $obj['values'];

         
        $emailExists = $userModel->checkEmailExists($values['email']);
        if ($emailExists) {
            return $this->response->setJSON([
                'status' => false,
                'msg' => "Email already exists.",
            ]);
            exit();
        }
     

        $userId = $userModel->insert($values);

      
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

    public function updateUser(){
        
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $userModel = new UserModel();
        $values = $obj['values'];
     

        $userId = $userModel->update($values['id'],$values);
      
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

    public function getUserCompanies(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $CompanyUsersModal = new CompanyUsersModal();
        // $obj = $obj['values'];

        
        $users = $CompanyUsersModal->getUserCompanies($obj['id']);
        // if ($trips) {
            return $this->response->setJSON([
                'status' => true,
                'data' => $users
            ]);
    }

    public function deleteUser(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $userModel = new UserModel();
        $obj = $obj['values'];
        

        $userData = [
            'is_deleted' =>1,
        ];
        $result = $userModel->update($obj['id'], $userData);
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

  
    public function uploadPlanAttachment()
    {
        $planId = $this->request->getPost('planId');
        $result = -1;

        $planAttachmentsModel = new PlanAttachmentsModel();

        if ($this->request->getFiles()) {
            // print_r($this->request->getFiles());
            $file = $this->request->getFiles()['file'] ;
                if ($file->isValid() && !$file->hasMoved()) {
                    $ext = $file->getClientExtension();
                    $name = $file->getClientName();

                    // Insert file data into the database
                    $data = [
                        'plan_id' => $planId,
                        'name' => $name,
                        'extension' => $ext,
                        'is_deleted' => 1, // Assuming default value
                    ];
                    $attachmentId = $planAttachmentsModel->insert($data);

                    if ($attachmentId) {
                        // Move the uploaded file to the desired directory
                        $file->move(WRITEPATH . '../public/assets/plan_attachments', $attachmentId . '.' . $ext);
                    }
                }
            // }
        }

        return $this->response->setJSON([
            'status' => true,
            'attachmentId' => $attachmentId,
        ]);
    }

    public function updatePlanAttachment(){
        
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $planAttachmentsModel = new PlanAttachmentsModel();

        $values = $obj['values'];
     

        $attachId = $planAttachmentsModel->update($values['id'],$values);
      
        if ($attachId) {
            return $this->response->setJSON([
                'status' => true,
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
            ]);
        }
    }


    
    public function getPlanAttachments()
    {
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $planAttachmentsModel = new PlanAttachmentsModel();

  
        
        $attachments = $planAttachmentsModel->select('*')
                                        ->where('is_deleted', 0)
                                        ->where('plan_id',$obj['id'])
                                        ->findAll();
        return $this->response->setJSON([
            'status' => true,
            'data' => $attachments
        ]);
    }

    public function uploadTripAttachment()
    {
        $tripId = $this->request->getPost('tripId');
        $result = -1;

        $tripAttachmentsModel = new TripAttachmentsModel();

        if ($this->request->getFiles()) {
            // print_r($this->request->getFiles());
            $file = $this->request->getFiles()['file'] ;
                if ($file->isValid() && !$file->hasMoved()) {
                    $ext = $file->getClientExtension();
                    $name = $file->getClientName();

                    // Insert file data into the database
                    $data = [
                        'trip_id' => $tripId,
                        'name' => $name,
                        'extension' => $ext,
                        'is_deleted' => 1, // Assuming default value
                    ];
                    $attachmentId = $tripAttachmentsModel->insert($data);

                    if ($attachmentId) {
                        // Move the uploaded file to the desired directory
                        $file->move(WRITEPATH . '../public/assets/trip_attachments', $attachmentId . '.' . $ext);
                    }
                }
            // }
        }

        return $this->response->setJSON([
            'status' => true,
            'attachmentId' => $attachmentId,
        ]);
    }

    public function updateTripAttachment(){
        
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $tripAttachmentsModel = new TripAttachmentsModel();

        $values = $obj['values'];
     

        $attachId = $tripAttachmentsModel->update($values['id'],$values);
      
        if ($attachId) {
            return $this->response->setJSON([
                'status' => true,
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
            ]);
        }
    }

    public function getTripAttachments()
    {
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $TripAttachmentsModel = new TripAttachmentsModel();

  
        
        $attachments = $TripAttachmentsModel->select('*')
                                        ->where('is_deleted', 0)
                                        ->where('trip_id',$obj['id'])
                                        ->findAll();
        return $this->response->setJSON([
            'status' => true,
            'data' => $attachments
        ]);
    }

    

    public function getPlanUsers(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);

        $plansUsersModal = new PlansUsersModal();
        $planId = $obj['planId'];
        
        $users = $plansUsersModal->getPlanUsers($planId);
        
            return $this->response->setJSON([
                'status' => true,
                'users' => $users,
            ]);
    
    }


    public function updateTripsUsers(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);

        $tripsUsersModal = new TripsUsersModal();

        $values = $obj['values'];
        
        $result = $tripsUsersModal->update($values['id'], $obj['values']);


        if($result){
            return $this->response->setJSON([
                'status' => true,
                'data' => 'updated',
            ]);
        }else{
            return $this->response->setJSON([
                'status' => false,
                'data' => 'error 232',
            ]);
        }
   
    
    }

    public function getFiltersCompanyUsers(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);

        
   

        $CompanyUsersModal = new CompanyUsersModal();
        $companies = $obj['companies'];
        $companiesIds = array_column($companies, 'id');

        
        $users = $CompanyUsersModal->getCompaniesUsers($companiesIds);
        // if ($trips) {
            return $this->response->setJSON([
                'status' => true,
                'data' => $users
            ]);
    
    }

    public function saveMileage(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $mileageModel = new MileageModel();
        $values = $obj['values'];
     

        $mileageId = $mileageModel->insert($values);

        
     
      
        if ($mileageId) {
            return $this->response->setJSON([
                'status' => true,
                'mileageId'=>$mileageId
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
            ]);
        }
    }

    public function updateMileageAccount(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $mileageModel = new MileageModel();
        $values = $obj['values'];
     

        $mileageId = $mileageModel->update($values['id'],$values);

       
      
        if ($mileageId) {
            return $this->response->setJSON([
                'status' => true,
                'mileageId'=>$mileageId
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
            ]);
        }
    }

    public function deleteMileageAccount(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $mileageModel = new MileageModel();
        $values = $obj['values'];
        $data = [
            'is_deleted' =>1,
        ];
        $mileageId = $mileageModel->update($values['id'], $data);

      
        if ($mileageId) {
            return $this->response->setJSON([
                'status' => true,
                'mileageId'=>$mileageId
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
            ]);
        }
    }

   

    public function getUserMileageAccount(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $mileageModel = new MileageModel();
     

        $results = $mileageModel->getByUserID($obj['id']);

       
      
            return $this->response->setJSON([
                'status' => true,
                'data'=>$results
            ]);
        
    }

    public function saveReminder(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $RemindersModel = new RemindersModel();
        $values = $obj['values'];
     

        $id = $RemindersModel->insert($values);

        
     
      
        if ($id) {
            return $this->response->setJSON([
                'status' => true,
                'id'=>$id
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
            ]);
        }
    }

    public function updateReminder(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $RemindersModel = new RemindersModel();
        $values = $obj['values'];
     

        $id = $RemindersModel->update($values['id'],$values);

       
      
        if ($id) {
            return $this->response->setJSON([
                'status' => true,
                'id'=>$id
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
            ]);
        }
    }

    public function deleteReminder(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $RemindersModel = new RemindersModel();
        $values = $obj['values'];
        $data = [
            'is_deleted' =>1,
        ];
        $result = $RemindersModel->update($values['id'], $data);


       
      
        if ($result) {
            return $this->response->setJSON([
                'status' => true,
                'id'=>$id
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
            ]);
        }
    }

    public function getCompanyReminders(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $RemindersModel = new RemindersModel();
        $values = $obj['values'];
     

        $results = $RemindersModel->getByCompanyId($values['id']);

       
      
            return $this->response->setJSON([
                'status' => true,
                'data'=>$results
            ]);
        
    }

    public function getTripCosts(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $id = $obj['id'];
     
        $tripsModal = new TripsModal();

        $data = $tripsModal->getTripCosts($id);
        return $this->response->setJSON([
            'status' => true,
            'data'=>$data,

        ]);
    }

    //////////////////////Notifications

    public function getAllNotifications(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $RemindersModel = new RemindersModel();

        $allReminders = $RemindersModel->getAllReminders();
        $redeemedReminders = $RemindersModel->getRedeemedReminders();
        $unredeemedReminders = $RemindersModel->getUnredeemedReminders();

        

      
            
        return $this->response->setJSON([
            'status' => true,
            'allReminders' => $allReminders,
            'redeemedReminders' => $redeemedReminders,
            'unredeemedReminders' => $unredeemedReminders,
        ]);
       
    }

    public function saveNotification(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $RemindersModel = new RemindersModel();
        $values = $obj['values'];
     

        $id = $RemindersModel->insert($values);

        
     
      
        if ($id) {
            return $this->response->setJSON([
                'status' => true,
                'id'=>$id
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
            ]);
        }
    }

    public function updateNotification(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $RemindersModel = new RemindersModel();
        $values = $obj['values'];
     

        $id = $RemindersModel->update($values['id'],$values);
      
        if ($id) {
            return $this->response->setJSON([
                'status' => true,
                'id'=>$id
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
            ]);
        }
    }

  

    public function deleteNotification(){
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);


        $RemindersModel = new RemindersModel();

        $values = $obj['values'];
        $data = [
            'is_deleted' =>1,
        ];
        $id = $RemindersModel->update($values['id'], $data);

      
        if ($id) {
            return $this->response->setJSON([
                'status' => true,
                'id'=>$id
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
            ]);
        }
    }

    // public function newTrip(){
    //     $json = file_get_contents('php://input');
    //     $obj = json_decode($json,true);

    //     $tripsModal = new TripsModal();
    //     $tripsUsersModal = new TripsUsersModal();

    //     $obj = $obj['values'];

    //     $result = $tripsModal->update($obj['id'],$obj);
    //     $users = $obj['tripUsers'];

    //     $usersIds = array_column($users,'user_id');

    //     if(empty($usersIds)){
    //         $tripsUsersModal->where('trip_id',$obj['id'])->delete();
    //     }else{
    //         $tripsUsersModal->where('trip_id',$obj['id'])->whereNotIn('user_id',$usersId)->delete();
    //     }

    //     foreach($users as $user){
    //         $existingRecord = $tripsUserModal->where('trip_id', $obj['id'])
    //                                             ->where('user_id',$user['user_id'])
    //                                             ->first();

    //         if(!$existingRecord){
    //             $data = [
    //                 'tripd_id'  => $obj['id'],
    //                 'user_id'   => $user['user_id'],
    //                 'is_travel' => 1
    //             ];
    //             $tripsUsersModal->insert($data);
    //         }
    //     }

    //     foreach($newUsers as $nUser){
    //         $existingRecord = $tripUserModal->where('trip_id',$obj['id']);
    //     }

    //     if($result){
    //         return $this->response->setJSON([
    //             'status' => true.
    //             'data' => $userIds,
    //         ]);
    //     }else{
    //         return $this->response->setJSON([
    //             'status' => false,
    //             'data' => 'Connection Error.',
    //         ]);
    //     }
    // }

    public function getByPlan()
    {
    $json   = $this->request->getJSON(true);
    $planId = $json['planId'] ?? null;

    if (!$planId) {
        return $this->response->setJSON([
            'status'  => false,
            'message' => 'Missing planId',
        ]);
    }

    $model = new UserConfirmationsModel();

    $confirmations = $model
        ->where('planId', $planId)
        ->where('isDeleted', 0)
        ->findAll();

    return $this->response->setJSON([
        'status' => true,
        'data'   => $confirmations,
    ]);
   }  
}
