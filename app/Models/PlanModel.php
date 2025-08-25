<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\TripsUsersModal;
use App\Models\CitiesModel;
use App\Models\AirlinesModel;
use App\Models\AirportsModel;
use App\Models\PlanAttachmentsModel;
use App\Models\PlansUsersModal;
use App\Models\UserConfirmationsModel;


class PlanModel extends Model
{
    protected $table = 'plans';
    // protected $allowedFields = ['trip_id','name','starting_date','starting_time','is_deleted'];

    public function __construct() {
        parent::__construct();
        
        $columns = $this->getFieldNames('plans'); 
        
        $this->allowedFields = $columns;
    }

    public function addPlan($data)
    {
        return $this->insert($data);
    }
    public function getAllPlans($tripId)
    {

    
        // return $this->select('*')
        //             ->where('trip_id',$tripId)
        //             ->where('is_deleted', 0)
        //             ->orderBy('starting_date')
        //             ->orderBy('starting_time')
        //             ->findAll();
       
            $citiesModel = new CitiesModel();
            $airportsModel = new AirportsModel();
            $airlinesModel = new AirlinesModel();
            $planAttachmentsModel = new PlanAttachmentsModel();
            $plansUsersModal = new PlansUsersModal();
            $userConfirmations=new UserConfirmationsModel();

            // return $this->select('plans.*, cities.city as destination_city, COUNT(plan_attachments.id) as numberOfAttachments,COUNT(plans_users.user_id) as numberOfUsers')
            //             ->join('cities', 'cities.id = plans.city_id', 'left')
            //             ->join('plan_attachments', 'plan_attachments.plan_id = plans.id AND plan_attachments.is_deleted = 0', 'left')
            //             ->join('plans_users', 'plans_users.plan_id = plans.id', 'left')
            //             ->where('plans.trip_id', $tripId)
            //             ->where('plans.is_deleted', 0)
            //             ->groupBy('plans.id') // Group by plan ID to count attachments per plan
            //             ->orderBy('plans.starting_date')
            //             ->orderBy('plans.starting_time')
            //             ->findAll();
            return $this->select('plans.*, cities.city as destination_city,   SUM(plans.cost) as total_cost,SUM(plans.extra_cost) as total_extra_cost,SUM(plans.mileage_used) as total_mileage_used,
                        COUNT(DISTINCT plan_attachments.id) as numberOfAttachments,
                        COUNT(DISTINCT plans_users.user_id) as numberOfUsers')
            ->join('cities', 'cities.id = plans.city_id', 'left')
            ->join('plan_attachments', 'plan_attachments.plan_id = plans.id AND plan_attachments.is_deleted = 0', 'left')
            ->join('plans_users', 'plans_users.plan_id = plans.id', 'left')
            ->join('user_confirmations','user_confirmations.planId=plans.id','left')
            ->where('plans.trip_id', $tripId)
            ->where('plans.is_deleted', 0)
            ->groupBy('plans.id')
            ->orderBy('plans.starting_date')
            ->orderBy('plans.starting_time')
            ->findAll();





        
                
    }
    


    // public function getTrips($userId)
    // {
    //     $tripsUsersModal = new TripsUsersModal();
    //     $citiesModel = new CitiesModel();

    //     $trips = $tripsUsersModal->select('trips.*, cities.city as destination_city')
    //             ->join('trips', 'trips_users.trip_id = trips.id')
    //             ->join('cities', 'cities.id = trips.destination_id')
    //             ->where('trips_users.user_id', $userId)
    //             ->where('trips.is_deleted', 0)
    //             ->orderBy('trips.starting_date', 'ASC') 
    //             ->findAll();


    //     return $trips;
    // }

    // public function update($id, $data)
    // {
    //     $this->update($id, $data);
    //     return true;
    // }


    public function getPlanUsersWithConfirmations($planId){
        return $this->db->table('plans_users')
            ->select('plans_users.*, users.fname, users.lname, user_confirmations.confirmationNumber')
            ->join('users', 'users.id = plans_users.user_id')
            ->join('user_confirmations', 'user_confirmations.userId = plans_users.user_id AND user_confirmations.planId = plans_users.plan_id', 'left')
            ->where('plans_users.plan_id', $planId)
            ->get()
            ->getResult();
    }

}
