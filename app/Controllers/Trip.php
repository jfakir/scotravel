<?php

namespace App\Controllers;
use App\Models\TripsModal;
use App\Models\TripsUsersModal;

use App\Models\PlanModel;

use App\Models\TripAttachmentsModel;
use App\Models\PlanAttachmentsModel;
use App\Models\PlansUsersModal;
use App\Models\Usermodel;
use App\Models\CompanyModel;
use App\Models\CitiesModel;
use App\Models\CompanyUsersModal;
use App\Models\RemindersModel;



helper(['session']);
class Trip extends BaseController
{
    public function upcoming()
    {
        if (!session()->has('user_id')) {
            return redirect('/');
        }

        $is_admin = false;
        if(session()->access_type==2){
            $is_admin = true;
        }
        $is_business = false;
        if(session()->account_type==2){
            $is_business = true;
        }
        $tripsModal = new TripsModal();
        $companyModel = new CompanyModel();
        $userModel = new UserModel();
        $RemindersModel = new RemindersModel();
        $CompanyUsersModal = new CompanyUsersModal();
        
        if($is_admin){
            $allUsers = $userModel->getAllUsers();
            $allCompanies = $companyModel->getAllCompanies(0);

            $allReminders = $RemindersModel->getAllReminders();
            $redeemedReminders = $RemindersModel->getRedeemedReminders();

            $unredeemedReminders = $RemindersModel->getUnredeemedReminders();


            if (session()->has('filterbyTenants') && !empty(session()->filterbyTenants)) {
                $filterbyTenants = session()->filterbyTenants;
            }else{
                $filterbyTenants = -1;
            }
    
            if (session()->has('filterbyTravelers') && !empty(session()->filterbyTravelers)) {
                $filterbyTravelers = session()->filterbyTravelers;
            }else{
                $filterbyTravelers = -1;
            }
            

        }else if($is_business){

            // $allUsers = [];
            $allCompanies = $companyModel->getAllCompanies(session()->user_id);
            $allCompaniesIds = [];
            foreach ($allCompanies as $item) {
                $allCompaniesIds[] = $item['id'];
            }
            $allUsers = $CompanyUsersModal->getCompaniesUsers($allCompaniesIds);

            
            
            if (session()->has('filterbyTenants') && !empty(session()->filterbyTenants)) {
                $filterbyTenants = session()->filterbyTenants;
            }else{
                $filterbyTenants = $allCompaniesIds;
            }

            if (session()->has('filterbyTravelers') && !empty(session()->filterbyTravelers)) {
                $filterbyTravelers = session()->filterbyTravelers;
            }else{
                $filterbyTravelers = -1;
                // $filterbyTravelers = [session()->user_id];
            }


            // print_r($allUsers);exit();
            // print_r($filterbyTravelers);exit();
            $allReminders = [];
            $redeemedReminders = [];
            $unredeemedReminders = [];
        }else{

            $allCompanies = [];
            $allUsers = [];
            
            $filterbyTenants = -1 ;
            $filterbyTravelers = [session()->user_id];

            $allReminders = [];
            $redeemedReminders = [];
            $unredeemedReminders = [];
        

        }   
        
       
        if (session()->has('filterFromDate') && !empty(session()->filterFromDate)) {
            $filterFromDate = session()->filterFromDate;
        }else{
            $filterFromDate = -1;
        }
        

        if (session()->has('filterToDate') && !empty(session()->filterToDate)) {
            $filterToDate = session()->filterToDate;
        }else{
            $filterToDate = -1 ;
        }

        

      
        $trips = $tripsModal->getTripsForWeb(-1,$filterFromDate,$filterToDate,$filterbyTenants,$filterbyTravelers);
        $data['allUsers'] = $allUsers;
        $data['allCompanies'] = $allCompanies;

        $data['filterFromDate'] = $filterFromDate;
        $data['filterToDate'] = $filterToDate;
        $data['filterbyTenants'] = $filterbyTenants;
        $data['filterbyTravelers'] = $filterbyTravelers;

        $data['allReminders'] = $allReminders;
        $data['redeemedReminders'] = $redeemedReminders;
        $data['unredeemedReminders'] = $unredeemedReminders;

        if(!$is_admin && $is_business){
            $data['businessAndNotAdmin'] = true;
        }else{
            $data['businessAndNotAdmin'] = false;
        }
        $data['trips'] = $trips[0];
        $data['page_title'] = "Upcoming Trips";
        return view('trips/upcoming', $data);
    }

    public function past()
    {
        if (!session()->has('user_id')) {
            return redirect('/');
        }

        $is_admin = false;
        if(session()->access_type==2){
            $is_admin = true;
        }
        $is_business = false;
        if(session()->account_type==2){
            $is_business = true;
        }
        $tripsModal = new TripsModal();
        $companyModel = new CompanyModel();
        $userModel = new UserModel();
        $RemindersModel = new RemindersModel();
        $CompanyUsersModal = new CompanyUsersModal();
        
        if($is_admin){
            $allUsers = $userModel->getAllUsers();
            $allCompanies = $companyModel->getAllCompanies(0);

            $allReminders = $RemindersModel->getAllReminders();
            $redeemedReminders = $RemindersModel->getRedeemedReminders();

            $unredeemedReminders = $RemindersModel->getUnredeemedReminders();

            if (session()->has('filterbyTenants') && !empty(session()->filterbyTenants)) {
                $filterbyTenants = session()->filterbyTenants;
            }else{
                $filterbyTenants = -1;
            }
    
            if (session()->has('filterbyTravelers') && !empty(session()->filterbyTravelers)) {
                $filterbyTravelers = session()->filterbyTravelers;
            }else{
                $filterbyTravelers = -1;

            }

        }else if($is_business){
            // $allUsers = [];

            $allCompanies = $companyModel->getAllCompanies(session()->user_id);
            $allCompaniesIds = [];

            $allReminders = [];
            $redeemedReminders = [];
            $unredeemedReminders = [];


            foreach ($allCompanies as $item) {
                $allCompaniesIds[] = $item['id'];
            }
            $allUsers = $CompanyUsersModal->getCompaniesUsers($allCompaniesIds);

            if (session()->has('filterbyTenants') && !empty(session()->filterbyTenants)) {
                $filterbyTenants = session()->filterbyTenants;
            }else{
                $filterbyTenants = $allCompaniesIds;
            }

            if (session()->has('filterbyTravelers') && !empty(session()->filterbyTravelers)) {
                $filterbyTravelers = session()->filterbyTravelers;
            }else{
                $filterbyTravelers = -1;
                // $filterbyTravelers = [session()->user_id];

            }

        }else{
            $allUsers = [];
            $allCompanies = [];

            $allReminders = [];
            $redeemedReminders = [];
            $unredeemedReminders = [];

            
            $filterbyTenants = -1 ;
            $filterbyTravelers = [session()->user_id];
        

        }   
        
       
        if (session()->has('filterFromDate') && !empty(session()->filterFromDate)) {
            $filterFromDate = session()->filterFromDate;
        }else{
            $filterFromDate = -1;
        }
        

        if (session()->has('filterToDate') && !empty(session()->filterToDate)) {
            $filterToDate = session()->filterToDate;
        }else{
            $filterToDate = -1 ;
        }

        
        if(!$is_admin && $is_business){
            $data['businessAndNotAdmin'] = true;
        }else{
            $data['businessAndNotAdmin'] = false;
        }
      
        $trips = $tripsModal->getTripsForWeb(-1,$filterFromDate,$filterToDate,$filterbyTenants,$filterbyTravelers);
        $data['allUsers'] = $allUsers;
        $data['allCompanies'] = $allCompanies;

        $data['filterFromDate'] = $filterFromDate;
        $data['filterToDate'] = $filterToDate;
        $data['filterbyTenants'] = $filterbyTenants;
        $data['filterbyTravelers'] = $filterbyTravelers;

        $data['allReminders'] = $allReminders;
        $data['redeemedReminders'] = $redeemedReminders;
        $data['unredeemedReminders'] = $unredeemedReminders;

        $data['trips'] = $trips[1];
        $data['page_title'] = "Past Trips";
        return view('trips/past', $data);
    }

    public function filterTrips()
    {
        if (!session()->has('user_id')) {
            return redirect('/');
        }


        // $tenants = explode(',', $tenants);
        if (null !== $this->request->getPost('tenants') && !empty($this->request->getPost('tenants'))) {
            $tenants = $this->request->getPost('tenants');
            // $tenants = array_map(function($id) {
            //     return ['id' => $id];
            // }, $tenants);
            session()->set('filterbyTenants', $tenants);
        } else {
            session()->remove('filterbyTenants');
        }
        
        if (null !== $this->request->getPost('travelers') && !empty($this->request->getPost('travelers'))) {
            $travelers = $this->request->getPost('travelers');
            // $travelers = array_map(function($user_id) {
            //     return ['user_id' => $user_id];
            // }, $travelers);
            session()->set('filterbyTravelers', $travelers);
        } else {
            session()->remove('filterbyTravelers');
        }
        
        if (null !== $this->request->getPost('fromDate') && !empty($this->request->getPost('fromDate'))) {
            $fromDate = $this->request->getPost('fromDate');
            $fromDate = date("Y-m-d", strtotime($fromDate));
            session()->set('filterFromDate', $fromDate);
        } else {
            session()->remove('filterFromDate');
        }
        
        if (null !== $this->request->getPost('toDate') && !empty($this->request->getPost('toDate'))) {
            $toDate = $this->request->getPost('toDate');
            $toDate = date("Y-m-d", strtotime($toDate));
            session()->set('filterToDate', $toDate);
        } else {
            session()->remove('filterToDate');
        }


      
        return $this->response->setJSON([
            'status' => true,
            'data' => 'Filters updated.',
        ]);

        // $tripsModal = new TripsModal();
        // $companyModel = new CompanyModel();
        // $userModel = new UserModel();
        
        // $allUsers = $userModel->getAllUsers();
        // $allCompanies = $companyModel->getAllCompanies(0);
        
        // $trips = $tripsModal->getTrips(-1,$fromDate,$toDate,$tenants,$travelers);
        // $data['allUsers'] = $allUsers;
        // $data['allCompanies'] = $allCompanies;
        // $data['trips'] = $trips[1];
        // $data['page_title'] = "Upcoming Trips";
        

        // echo view('trips/upcoming', $data);
       
    }

    

    public function view()
    {
        if (!session()->has('user_id')) {
            return redirect('/');
        }
        if ($this->request->getGet('id')) {


            $trip_id = $this->request->getGet('id');
            $trip_id = base64_decode((string)$trip_id);

            // exit();
            $PlanModel = new PlanModel();
            $tripsUsersModal = new TripsUsersModal();
            $tripAttachmentsModel = new TripAttachmentsModel();

            $tripsModal = new TripsModal();
            


            $plans = $PlanModel->getAllPlans($trip_id);
            // $users = $tripsUsersModal->getTripUsers($trip_id);
            $users = $tripsUsersModal->getTripUsersOnlyTravelers($trip_id);
            $attachments = $tripAttachmentsModel->getTripAttchments($trip_id);
            $costs = $tripsModal->getTripCosts($trip_id);
            $planUsers = $PlanModel->getPlanUsersWithConfirmations($trip_id);


            //getTripOrganizers query from tripsUsersModal

            $tripAdmins = $tripsUsersModal->getTripAdmins($trip_id);
            // print_r($tripAdmins);exit();
            $adminsIds = array_column($tripAdmins, 'user_id');
            // print_r($adminsIds);exit();

            if (in_array(session()->user_id, $adminsIds)||session()->access_type==2) {
                $isTripAdmin = true ;
            } else {
                $isTripAdmin = false ;
            }

            
            $data['plans'] = $plans;
            $data['users'] = $users;
            $data['attachments'] = $attachments;
            $data['costs'] = $costs;
            $data['isTripAdmin'] = $isTripAdmin;
            $data['planUsers'] = $planUsers;
                
            $trip_data = [
                'trip_users' => $users,
                'trip_id' => $trip_id,
            ];
            session()->set($trip_data);
            // print_r($result);exit();
            return view('trips/trip', $data);

        }

        
        return view('trips/trip');
    }

    public function manage()
    {
       

        if (!session()->has('user_id')) {
            return redirect('/');
        }
        if ($this->request->isAJAX()) {
          $tripId =  $this->request->getPost('tripId');
          $name =  $this->request->getPost('name');
          $image_url =  $this->request->getPost('image_url');
          $is_round_trip =  $this->request->getPost('is_round_trip');
          $destination =  $this->request->getPost('destination');
          $starting_date =  $this->request->getPost('starting_date');
          $ending_date =  $this->request->getPost('ending_date');
         
          $starting_date = date("Y-m-d", strtotime($starting_date));

          if(empty($ending_date)|| !isset($ending_date)){
            $ending_date = '0000-00-00';
          }else{
            $ending_date = date("Y-m-d", strtotime($ending_date));
          }

          $tenant_id =  $this->request->getPost('tenant_id');
          $travelers =  $this->request->getPost('travelers_id');

            $tripsModal = new TripsModal();
            $tripsUsersModal = new TripsUsersModal();
            // print_r($tripId);
            // echo($tripId);exit();
            $tripData = [
                'name' =>$name ,
                'destination_id' =>$destination,
                'company_id' =>$tenant_id,
                'image_url' =>$image_url,
                'starting_date' => $starting_date,
                'ending_date' => $ending_date,
                'is_round_trip' => $is_round_trip,
            ];

        
            // print_r($travelers);exit();
            if(isset($tripId) && !empty($tripId)){
                $result = $tripsModal->update($tripId, $tripData);

                if (empty($travelers)) {
                    $tripsUsersModal->where('trip_id', $tripId)->delete();
                } else {
                    // Delete records where user_id is not in the $userIds array
                    $tripsUsersModal->where('trip_id', $tripId)->whereNotIn('user_id', $travelers)->delete();
                }
                
                    // Insert new records from the $users array using ON DUPLICATE KEY UPDATE
                    foreach ($travelers as $userId) {
                    
                        $existingRecord = $tripsUsersModal->where('trip_id', $tripId)
                        ->where('user_id',$userId)
                        // ->where('is_traveler',1)
                        ->first();
            
                        if (!$existingRecord) {
                            $data = [
                                'trip_id' => $tripId,
                                'user_id' => $userId,
                                'is_traveler' => 1,
                            ];
                            $tripsUsersModal->insert($data);
                        }
                    }
            }else{
                $tripId = $tripsModal->addTrip($tripData);

                $created_by = session()->user_id;
                $tripsUsersData = [
                    'trip_id' =>$tripId,
                    'user_id' =>$created_by,
                    'is_admin' =>1,
                ];

                $result = $tripsUsersModal->addRecord($tripsUsersData);
            
                // $users = $obj['tripUsers'];
                // if(intval($obj['isSingleUserTrip'])==1){
                //     $data = [
                //         'is_traveler' => 1,
                //     ];
                //     $tripsUsersModal->update($result,$data);
                // }else{
                    foreach ($travelers as $user) {
                        // print_r($user);
                        if($created_by==$user){
                            $data = [
                                'is_traveler' => 1,
                            ];
                            $tripsUsersModal->update($result,$data);
                        }else{
                            $data = [
                                'trip_id' => $tripId ,
                                'user_id' => $user,
                                'is_traveler' => 1,
                            ];
                    
                            $tripsUsersModal->insert($data);
                        }
                    
                    }
                // }

            }


            
            


            if ($tripId) {
                return $this->response->setJSON([
                    'status' => true,
                    'tripId' => $tripId,
                    'data' => 'Trip successfully saved.',
                    'token' => csrf_hash()
                ]);
                // return $this->response->setJSON([
                //     'status' => true,
                //     'tripId' => $tripId,
                //     'data' => 'Trip successfully saved.',
                //     'token' => csrf_hash()
                //     'isSingleUserTrip' => $obj['isSingleUserTrip'],
                // ]);
            } else {
                return $this->response->setJSON([
                    'status' => false,
                    'data' => 'Connection Error',
                    'token' => csrf_hash()

                ]);
            }

            
        }else{
            $companyModel = new CompanyModel();
            $allCompanies = $companyModel->getAllCompanies(0);
            $CitiesModel = new CitiesModel();
            $allCities = $CitiesModel->get10Cities();
            // $allCities = $CitiesModel->getAllCities();
            $data['allCities'] = $allCities;
            $data['allCompanies'] = $allCompanies;
            return view('trips/manage', $data);
        }
    }

    public function delete()
    {
        if (!session()->has('user_id')) {
            return redirect('/');
        }
    }

    public function getTripDetails()
    {
        return redirect()->to('/trips/manage');

        
        // $tripsModal = new TripsModal();
        // $userModel = new UserModel();
        

        // $id = $this->request->getPost('id');
      

        // $tripDetails = $tripsModal->select('*')
        //             ->where('is_deleted', 0)
        //             ->where('id',$id)
        //             ->findAll();


        // $tripsUsersModal = new TripsUsersModal();

        // $tripTravelers = $tripsUsersModal->select('*')
        //                 ->where('trip_id',$id)
        //                 ->findAll();

        // $allUsers = $userModel->getAllUsers();

                        
        // $data['tripDetails'] = $tripDetails;
        // $data['tripTravelers'] = $tripTravelers;
        // $data['allUsers'] = $allUsers;
        // return view('trips/manage', $data);

        // return $this->response->setJSON([
        //     'status' => true,
        //     'tripDetails' => $tripDetails,
        //     'tripTravelers' => $tripTravelers,
        //     'allUsers' => $allUsers,

        // ]);

    }

    public function editTrip(){
        $id = $this->request->getGet('id');
        $id = base64_decode((string)$id);

        $tripsModal = new TripsModal();
        $userModel = new UserModel();
        $companyModel = new CompanyModel();

        $CitiesModel = new CitiesModel();
        $CompanyUsersModal = new CompanyUsersModal();

      

        $tripDetails = $tripsModal->select('*')
                    ->where('is_deleted', 0)
                    ->where('id',$id)
                    ->findAll();


        $tripsUsersModal = new TripsUsersModal();

        $tripTravelers = $tripsUsersModal->select('*')
                        ->where('trip_id',$id)
                        ->where('is_traveler',1)
                        ->findAll();

        // print_r($tripTravelers);exit();

        $userIds = array_column($tripTravelers, 'user_id');

        if (!empty($userIds)) {
            $usersDetails = $userModel->select('id, fname, lname')
                                    ->whereIn('id', $userIds)
                                    ->findAll();
        } else {
            $usersDetails = []; 
        }
        $allUsers = $userModel->getAllUsers();
        $allCompanies = $companyModel->getAllCompanies(0);

        $allCities = $CitiesModel->get10Cities();

        $companyUsers = $CompanyUsersModal->getCompanyUsers($tripDetails[0]['company_id']);


        $data['tripDetails'] = $tripDetails;

        $data['tripTravelers'] = $usersDetails;
        $data['allUsers'] = $allUsers;
        $data['allCompanies'] = $allCompanies;
        $data['allCities'] = $allCities;

        $data['companyUsers'] = $companyUsers;

        return view('trips/manage', $data);
    }

    public function deleteTrip(){

        $id = $this->request->getPost('id');

        $tripsModal = new TripsModal();
        
        $data = [
            'is_deleted' =>1,
        ];
        $result = $tripsModal->update($id, $data);
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

    
    public function uploadAttachment(){
        if ($this->request->getFiles()) {
        $tripAttachmentsModel = new TripAttachmentsModel();

            // print_r($this->request->getFiles());
             $file = $this->request->getFiles()['attachment'] ;
            if ($file->isValid() && !$file->hasMoved()) {
                $ext = $file->getClientExtension();
                $name = $file->getClientName();

                // Insert file data into the database
                $allowedExtensions = ['pdf', 'png', 'jpg', 'jpeg'];

                if (in_array($ext, $allowedExtensions)) {
                    // Insert file data into the database
                    $data = [
                        'trip_id' => session()->trip_id,
                        'name' => $name,
                        'extension' => $ext,
                        'is_deleted' => 1, // Assuming default value
                    ];
                    $attachmentId = $tripAttachmentsModel->insert($data);

                    if ($attachmentId) {
                        // Move the uploaded file to the desired directory
                        $file->move(WRITEPATH . '../public/assets/trip_attachments', $attachmentId . '.' . $ext);
                        return $this->response->setJSON([
                            'status' => true,
                            'data' => 'File uploaded.',
                            'id' => $attachmentId,
                            'name' => $name,
                            'trip_id' => session()->trip_id
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
                        'data' => 'Invalid file type. Only PDF, PNG, JPG, and JPEG are allowed.',
                    ]);
                }
            }
            // }
        }
           
    }

    public function updateAttachment(){
        $tripAttachmentsModel = new TripAttachmentsModel();

        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');
        $trip_id = $this->request->getPost('trip_id');
    
        $data = [
            'name' => $name,
            'is_deleted' => 0, 
        ];

        $attachId = $tripAttachmentsModel->update($id,$data);
      
        if ($attachId) {
            return $this->response->setJSON([
                'status' => true,
                'trip_id' => $trip_id,
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
            ]);
        }
    }

    public function downloadAttachment()
    {
        $id = $this->request->getGet('id');
        $extension = $this->request->getGet('extension');
        $name = $this->request->getGet('name');

        

        $filePath = FCPATH . 'assets/trip_attachments/' . $id . '.' . $extension;

        // Debugging: print file path
        echo "File Path: " . $filePath . "<br>";

        if (file_exists($filePath)) {
            echo "File exists.<br>";

            // Clean the output buffer
            ob_clean();
            flush();

            // Set headers for download
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $name.'.'.$extension);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));

            // Read the file and output its contents
            readfile($filePath);
            exit();
        } else {
            echo "File does not exist.<br>";
        }
    }

    public function deleteAttachment(){
        $id = $this->request->getPost('id');

        $tripAttachmentsModel = new TripAttachmentsModel();


        
        $data = [
            'is_deleted' =>1,
        ];
        $result = $tripAttachmentsModel->update($id, $data);
        if ($result) {
            
            return $this->response->setJSON([
                'status' => true,
                'data' => 'Attachment deleted.',
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'data' => 'Connection Error.', 
            ]);
        }
    }

    public function makeOrganizer(){
        $id = $this->request->getPost('id');

        $tripsUsersModal = new TripsUsersModal();

        $data = [
            'is_admin' =>1,
        ];
     

        $result = $tripsUsersModal->update($id, $data);


        if ($result) {
            return $this->response->setJSON([
                'status' => true,
                'data' => $id, 

            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
            ]);
        }


    }

    public function dismissOrganizer(){
        $id = $this->request->getPost('id');

        $tripsUsersModal = new TripsUsersModal();

        $data = [
            'is_admin' =>0,
        ];
     

        $result = $tripsUsersModal->update($id, $data);


        if ($result) {
            return $this->response->setJSON([
                'status' => true,
                'data' => $id, 

            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
            ]);
        }

    }

}

