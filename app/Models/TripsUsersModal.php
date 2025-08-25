<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Usermodel;

class TripsUsersModal extends Model
{
    protected $table = 'trips_users';
    protected $allowedFields = ['id', 'trip_id', 'user_id','is_admin','is_traveler'];

    public function addRecord($data)
    {
        return $this->insert($data);
    }
    public function getAllRecords()
    {
        return $this->findAll();
    }

    public function getTripUsers($tripId){
        $userModel = new UserModel();

        $users = $userModel->select('*')
                ->join('trips_users', 'trips_users.user_id = users.id')
                ->where('trips_users.trip_id', $tripId)
                // ->where('trips_users.is_traveler', 1)
                ->orderBy('trips_users.is_traveler', 'DESC')
                ->orderBy('trips_users.is_admin', 'DESC')
                ->orderBy('users.fname', 'ASC')
                ->orderBy('users.lname', 'ASC')
                ->findAll();

        return $users;
    }


    //without orgznizer if is not a traveler
    public function getTripUsersOnlyTravelers($tripId){
        $userModel = new UserModel();

        $users = $userModel->select('*')
        ->join('trips_users', 'trips_users.user_id = users.id')
        ->where('trips_users.trip_id', $tripId)
        ->where('trips_users.is_traveler', 1)
        ->orderBy('users.fname', 'ASC')
        ->orderBy('users.lname', 'ASC')
        ->findAll();

        return $users;

    }

    public function getTripAdmins($tripId){

        // $users = $this->select('user_id')
        //         ->where('trip_id', $tripId)
        //         ->where('is_admin', 1)
        //         ->findAll();

        // return $users;

        $userModel = new UserModel();

        $users = $userModel->select('users.*,trips_users.user_id')
        ->join('trips_users', 'trips_users.user_id = users.id')
        ->where('trips_users.trip_id', $tripId)
        ->where('trips_users.is_admin', 1)
        ->orderBy('users.fname', 'ASC')
        ->orderBy('users.lname', 'ASC')
        ->findAll();

        return $users;
    }

    
}
