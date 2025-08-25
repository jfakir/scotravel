<?php

namespace App\Controllers;
use App\Models\AirportsModel;
use App\Models\CitiesModel;
use App\Models\AirlinesModel;
use App\Models\PlanModel;
use App\Models\PlansUsersModal;

class Layover extends BaseController
{
    public function view()
    {
        return view('layovers/view');
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

        return view('layovers/manage',$data);
    }

    
}
