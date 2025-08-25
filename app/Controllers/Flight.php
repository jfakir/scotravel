<?php

namespace App\Controllers;
use App\Models\AirportsModel;
use App\Models\CitiesModel;
use App\Models\AirlinesModel;
use App\Models\PlanModel;
use App\Models\PlansUsersModal;

class Flight extends BaseController
{
    public function view()
    {
        return view('flights/view');
    }

    public function manage()
    {
        $airportsModel = new AirportsModel();
        $CitiesModel = new CitiesModel();
        $airlinesModel = new AirlinesModel();

        $airports = $airportsModel->getAllAirports();
        $allCities = $CitiesModel->get10Cities();
        $airlines = $airlinesModel->getAllAirlines();

        $data['allCities'] = $allCities;
        $data['travelers'] = session()->trip_users;
        $data['trip_id'] = session()->trip_id;
        $data['airports'] = $airports;
        $data['airlines'] = $airlines;

        return view('flights/manage',$data);
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $plansUsersModal = new PlansUsersModal();
            $PlanModel = new PlanModel();
        
            $postData = $this->request->getPost();
   
            $startingDate = new \DateTime($postData['starting_date']);
        $postData['starting_date'] = $startingDate->format('Y-m-d');

        $endingDate = new \DateTime($postData['ending_date']);
        $postData['ending_date'] = $endingDate->format('Y-m-d');

        // Convert starting_time and ending_time to 24-hour format
        $startingTime = new \DateTime($postData['starting_time']);
        $postData['starting_time'] = $startingTime->format('H:i');

        $endingTime = new \DateTime($postData['ending_time']);
        $postData['ending_time'] = $endingTime->format('H:i');

        if(isset($postData['travelers_id']) && !empty($postData['travelers_id'])){
            $users = $postData['travelers_id'];
            foreach ($users as $user) {
                    $data = [
                        'plan_id' => $planId ,
                        'user_id' => $user
                    ];
            
                    $plansUsersModal->insert($data);
            }
        }

            // $values = $obj['values'];
        
            // $timeZone  = $values['timezone'];
            // date_default_timezone_set($timeZone);

            $planId = $PlanModel->insert($postData);

            if ($planId) {
                return $this->response->setJSON([
                    'status' => true,
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
}
