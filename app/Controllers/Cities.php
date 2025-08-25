<?php

namespace App\Controllers;
use App\Models\CitiesModel;

class Cities extends BaseController
{
    

    public function getAllCities()
    {
        // return view('flights/view');
        $citiesModel = new CitiesModel();
        
        $result = $citiesModel->get10Cities();
        // $result = $citiesModel->getAllCities();

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
}
