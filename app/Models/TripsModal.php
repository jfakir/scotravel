<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\TripsUsersModal;
use App\Models\CitiesModel;
use App\Models\CompanyModel;
use App\Models\TripAttachmentsModel;
use App\Models\PlanModel;


class TripsModal extends Model
{
    protected $table = 'trips';
    protected $allowedFields = ['id', 'name', 'destination_id','image_url','starting_date', 'ending_date','is_round_trip','company_id','is_deleted'];

    public function addTrip($data)
    {
        return $this->insert($data);
    }
    public function getAllTrips()
    {
        return $this->findBy(
            ['is_deleted' => 0],
            ['starting_date' => 'ASC']
        );
    }
    public function getTripCosts($id)
    {
        $PlanModel = new PlanModel();
       
        return $this->select('SUM(plans.cost) as total_cost,SUM(plans.extra_cost) as total_extra_cost,SUM(plans.mileage_used) as total_mileage_used,')
                    ->join('plans', 'plans.trip_id = trips.id AND plans.is_deleted = 0', 'left')
                    ->where('trips.id', $id)
                    ->findAll();
        
    }


    public function getTrips($userId,$fromDate,$toDate,$selectedCompanies,$selectedUsers)
    {

        if(is_array($selectedCompanies) && !empty($selectedCompanies )){
            $companiesIds = array_column($selectedCompanies, 'id');
        }
       
        if(is_array($selectedUsers) && !empty($selectedUsers)){
            $usersIds = array_column($selectedUsers, 'user_id');
        }

        $tripsUsersModal = new TripsUsersModal();
        $citiesModel = new CitiesModel();
        $CompanyModel = new CompanyModel();
        $TripAttachmentsModel = new TripAttachmentsModel();
        $PlanModel = new PlanModel();
       
         
        
        
      

        $sql = "SELECT 
        `trips`.*, 
        `cities`.`city` AS `destination_city`, 
        `companies`.`name` AS `company_name`,
        COUNT(DISTINCT `trip_attachments`.`id`) AS numberOfAttachments,
        SUM(`plans`.`cost`) AS total_cost,
        SUM(plans.`extra_cost`) AS total_extra_cost,
        SUM(`plans`.`mileage_used`) AS total_mileage_used,
        GROUP_CONCAT(DISTINCT `plans`.`plan_type` ORDER BY `plans`.`plan_type` ASC SEPARATOR ',') AS plan_types,
    (
        SELECT GROUP_CONCAT(CONCAT(`users`.`fname`, ' ', `users`.`lname`)  ORDER BY `users`.`fname` ASC, `users`.`lname` ASC SEPARATOR ',') 
        FROM `users`
         JOIN `trips_users` ON `trips_users`.`user_id` = `users`.id
        WHERE `trips_users`.`trip_id` = `trips`.`id` AND `trips_users`.`is_traveler`=1
     
    ) AS trip_users
        FROM 
            `trips`
        LEFT JOIN 
            `plans` ON `plans`.`trip_id` = `trips`.`id` AND `plans`.`is_deleted` = 0
        LEFT JOIN 
            `trip_attachments` ON `trip_attachments`.`trip_id` = `trips`.`id` AND `trip_attachments`.`is_deleted` = 0
        LEFT JOIN 
            `cities` ON `cities`.`id` = `trips`.`destination_id`
        LEFT JOIN 
            `companies` ON `companies`.`id` = `trips`.`company_id`
        LEFT JOIN 
            `trips_users` ON `trips_users`.`trip_id` = `trips`.`id`
        LEFT JOIN 
            `users` ON `trips_users`.`user_id` = `users`.`id`
        WHERE 
            `trips`.`is_deleted` = 0 AND (`trips`.`ending_date` >= CURDATE() OR `trips`.`ending_date`='0000-00-00' OR `trips`.`ending_date` IS NULL )";

        if ($fromDate != -1) {
            $sql .= " AND `trips`.`starting_date` >= '$fromDate'";
        }

        if ($toDate != -1) {
            $sql .= " AND `trips`.`starting_date` <='$toDate'";
        }

        if (is_array($selectedCompanies)) {
            $sql .= " AND `trips`.`company_id` IN (" . implode(',', $companiesIds) . ")";
        }
        

        if(is_array($selectedUsers) && !empty($selectedUsers)){
            $sql .= " AND `trips_users`.`user_id` IN (" . implode(',', $usersIds) . ") ";
            $sql .= "AND  `trips_users`.`is_traveler`=1";
        }

         
            // $sql .= " 
            // GROUP BY `trips`.`id`
            // ORDER BY 
            // CASE
            //     WHEN (`trips`.`starting_date` >= CURDATE() OR `trips`.`is_round_trip`=0) THEN `trips`.`starting_date`
            //     ELSE `trips`.`ending_date`
            // END ASC";

            $sql .= "
                    GROUP BY `trips`.`id`
                    ORDER BY 
                        CASE
                            WHEN (
                                SELECT `plan_type`
                                FROM `plans`
                                WHERE `plans`.`trip_id` = `trips`.`id` AND `plans`.`is_deleted` = 0 AND `plans`.`ending_date` >= CURDATE()
                                ORDER BY `plans`.`id` ASC
                                LIMIT 1
                            ) = 3 
                            THEN (
                                SELECT `ending_date`
                                FROM `plans`
                                WHERE `plans`.`trip_id` = `trips`.`id` AND `plans`.`is_deleted` = 0 AND `plans`.`ending_date` >= CURDATE()
                                ORDER BY `plans`.`id` ASC
                                LIMIT 1
                            )
                            ELSE (
                                CASE 
                                    WHEN (`trips`.`starting_date` >= CURDATE() OR `trips`.`is_round_trip` = 0) THEN `trips`.`starting_date`
                                    ELSE `trips`.`ending_date`
                                END
                            )
                        END ASC
                    ";

                                        
        
        $query = $this->db->query($sql);
        $currentTrips = $query->getResult();






    $pastTripsSql = "SELECT 
        `trips`.*, 
        `cities`.`city` AS `destination_city`, 
        `companies`.`name` AS `company_name`,
        COUNT(DISTINCT `trip_attachments`.`id`) AS numberOfAttachments,
        SUM(`plans`.`cost`) AS total_cost,
        SUM(plans.`extra_cost`) AS total_extra_cost,
        SUM(`plans`.`mileage_used`) AS total_mileage_used,
        GROUP_CONCAT(DISTINCT `plans`.`plan_type` ORDER BY `plans`.`plan_type` ASC SEPARATOR ',') AS plan_types,
    (
        SELECT GROUP_CONCAT(CONCAT(`users`.`fname`, ' ', `users`.`lname`)  ORDER BY `users`.`fname` ASC, `users`.`lname` ASC SEPARATOR ',') 
        FROM `users`
         JOIN `trips_users` ON `trips_users`.`user_id` = `users`.id
        WHERE `trips_users`.`trip_id` = `trips`.`id` AND `trips_users`.`is_traveler`=1
        ORDER BY `users`.`fname` ASC,`users`.`lname` ASC

    ) AS trip_users
        FROM 
            `trips`
        LEFT JOIN 
            `plans` ON `plans`.`trip_id` = `trips`.`id` AND `plans`.`is_deleted` = 0
        LEFT JOIN 
            `trip_attachments` ON `trip_attachments`.`trip_id` = `trips`.`id` AND `trip_attachments`.`is_deleted` = 0
        LEFT JOIN 
            `cities` ON `cities`.`id` = `trips`.`destination_id`
        LEFT JOIN 
            `companies` ON `companies`.`id` = `trips`.`company_id`
        LEFT JOIN 
            `trips_users` ON `trips_users`.`trip_id` = `trips`.`id`
        LEFT JOIN 
            `users` ON `trips_users`.`user_id` = `users`.`id`
        WHERE 
            `trips`.`is_deleted` = 0 AND `trips`.`ending_date` < CURDATE() AND `trips`.`ending_date` != '0000-00-00' AND `trips`.`ending_date` IS NOT NULL ";

        if ($fromDate != -1) {
            $pastTripsSql .= " AND `trips`.`starting_date` >= '$fromDate'";
        }

        if ($toDate != -1) {
            $pastTripsSql .= " AND `trips`.`starting_date` <='$toDate'";
        }

        if (is_array($selectedCompanies)) {
            $pastTripsSql .= " AND `trips`.`company_id` IN (" . implode(',', $companiesIds) . ")";

        }
        

        if(is_array($selectedUsers) && !empty($selectedUsers)){
            $pastTripsSql .= " AND `trips_users`.`user_id` IN (" . implode(',', $usersIds) . ") ";
            $pastTripsSql .= "AND  `trips_users`.`is_traveler`=1";

            
        }


            $pastTripsSql .= " GROUP BY `trips`.`id`
                ORDER BY `trips`.`starting_date` DESC";

        $pastTripsquery = $this->db->query($pastTripsSql);
        $pastTrips = $pastTripsquery->getResult();

        
        // $pastTrips = $this->select('trips.*, cities.city as destination_city,companies.name as company_name,COUNT(DISTINCT trip_attachments.id) as numberOfAttachments,')
        //                 ->join('trip_attachments', 'trip_attachments.trip_id = trips.id AND trip_attachments.is_deleted = 0', 'left')
        //                 ->join('cities', 'cities.id = trips.destination_id','left')
        //                 ->join('companies', 'companies.id = trips.company_id','left')
        //                 ->join('trips_users', 'trips_users.trip_id = trips.id', 'left') // Join trips_users
        //                 ->select('(SELECT CONCAT(users.fname, " ", users.lname) 
        //                         FROM users 
        //                         WHERE trips_users.user_id = users.id) AS trip_users', false)
        //                 ->where('trips.is_deleted', 0)
        //                 ->where('trips.ending_date <', date('Y-m-d'));

        //         if ($fromDate != -1) {
        //             $pastTrips->where('trips.starting_date >=', $fromDate);
        //         }
                
        //         if ($toDate != -1) {
        //             $pastTrips->where('trips.starting_date <=', $toDate);
        //         }

        //         if(is_array($selectedCompanies) && !empty($selectedCompanies )){
        //             $pastTrips->whereIn('trips.company_id', $companiesIds);
        //         }

                
        //         if(is_array($selectedUsers) && !empty($selectedUsers)){
        //             $pastTrips->join('trips_users', 'trips_users.trip_id = trips.id', 'left');
                    
        //             $pastTrips->whereIn('trips_users.user_id', $usersIds);
        //         }
            
    
        //         $pastTrips = $pastTrips->groupBy('trips.id') 
        //         ->orderBy('trips.starting_date', 'ASC') 
        //         ->findAll();


        return [$currentTrips,$pastTrips];
    }


    public function getTripsForWeb($userId,$fromDate,$toDate,$selectedCompanies,$selectedUsers)
    {

        if(is_array($selectedCompanies) && !empty($selectedCompanies )){
            $selectedCompanies = array_map('intval', $selectedCompanies);
            $selectedCompaniesString = implode(',', $selectedCompanies);
        }

        
        if(is_array($selectedUsers) && !empty($selectedUsers)){
            $selectedUsers = array_map('intval', $selectedUsers);
            $usersIdsString = implode(',', $selectedUsers);
        }



        $tripsUsersModal = new TripsUsersModal();
        $citiesModel = new CitiesModel();
        $CompanyModel = new CompanyModel();
        $TripAttachmentsModel = new TripAttachmentsModel();
        $PlanModel = new PlanModel();
       
         
        
        
      

        $sql = "SELECT 
        `trips`.*, 
        `cities`.`city` AS `destination_city`, 
        `companies`.`name` AS `company_name`,
        COUNT(DISTINCT `trip_attachments`.`id`) AS numberOfAttachments,
        SUM(`plans`.`cost`) AS total_cost,
        SUM(plans.`extra_cost`) AS total_extra_cost,
        SUM(`plans`.`mileage_used`) AS total_mileage_used,
    (
        SELECT GROUP_CONCAT(CONCAT(`users`.`fname`, ' ', `users`.`lname`)  ORDER BY `users`.`fname` ASC, `users`.`lname` ASC SEPARATOR ',')
        FROM `users`
         JOIN `trips_users` ON `trips_users`.`user_id` = `users`.id
        WHERE `trips_users`.`trip_id` = `trips`.`id` AND `trips_users`.`is_traveler`=1
     
    ) AS trip_users,
    (
        SELECT GROUP_CONCAT(`user_id` SEPARATOR ',')
        FROM `trips_users`
        WHERE `trips_users`.`trip_id` = `trips`.`id` AND `trips_users`.`is_admin`=1
     
    ) AS trip_admins
        FROM 
            `trips`
        LEFT JOIN 
            `plans` ON `plans`.`trip_id` = `trips`.`id` AND `plans`.`is_deleted` = 0
        LEFT JOIN 
            `trip_attachments` ON `trip_attachments`.`trip_id` = `trips`.`id` AND `trip_attachments`.`is_deleted` = 0
        LEFT JOIN 
            `cities` ON `cities`.`id` = `trips`.`destination_id`
        LEFT JOIN 
            `companies` ON `companies`.`id` = `trips`.`company_id`
        LEFT JOIN 
            `trips_users` ON `trips_users`.`trip_id` = `trips`.`id`
        LEFT JOIN 
            `users` ON `trips_users`.`user_id` = `users`.`id`
        WHERE 
            `trips`.`is_deleted` = 0 AND (`trips`.`ending_date` >= CURDATE() OR `trips`.`ending_date`='0000-00-00' OR `trips`.`ending_date` IS NULL )";

        if ($fromDate != -1) {
            $sql .= " AND `trips`.`starting_date` >= '$fromDate'";
        }

        if ($toDate != -1) {
            $sql .= " AND `trips`.`starting_date` <='$toDate'";
        }

        if (is_array($selectedCompanies) && !empty($selectedCompanies )) {
            $sql .= " AND `trips`.`company_id` IN ( $selectedCompaniesString )";
        }
        

        if(is_array($selectedUsers) && !empty($selectedUsers)){
            $sql .= " AND `trips_users`.`user_id` IN ($usersIdsString) ";
            $sql .= "AND  `trips_users`.`is_traveler`=1";
        }

            $sql .= " GROUP BY `trips`.`id`
                ORDER BY `trips`.`starting_date` ASC";


        $query = $this->db->query($sql);
        $currentTrips = $query->getResult();






 $pastTripsSql = "SELECT 
        `trips`.*, 
        `cities`.`city` AS `destination_city`, 
        `companies`.`name` AS `company_name`,
        COUNT(DISTINCT `trip_attachments`.`id`) AS numberOfAttachments,
        SUM(`plans`.`cost`) AS total_cost,
        SUM(plans.`extra_cost`) AS total_extra_cost,
        SUM(`plans`.`mileage_used`) AS total_mileage_used,
    (
        SELECT GROUP_CONCAT(CONCAT(`users`.`fname`, ' ', `users`.`lname`)  ORDER BY `users`.`fname` ASC, `users`.`lname` ASC SEPARATOR ',') 
        FROM `users`
         JOIN `trips_users` ON `trips_users`.`user_id` = `users`.id
        WHERE `trips_users`.`trip_id` = `trips`.`id` AND `trips_users`.`is_traveler`=1
        ORDER BY `users`.`fname` ASC,`users`.`lname` ASC

    ) AS trip_users,
    (
        SELECT GROUP_CONCAT(`user_id` SEPARATOR ',')
        FROM `trips_users`
        WHERE `trips_users`.`trip_id` = `trips`.`id` AND `trips_users`.`is_admin`=1
     
    ) AS trip_admins
        FROM 
            `trips`
        LEFT JOIN 
            `plans` ON `plans`.`trip_id` = `trips`.`id` AND `plans`.`is_deleted` = 0
        LEFT JOIN 
            `trip_attachments` ON `trip_attachments`.`trip_id` = `trips`.`id` AND `trip_attachments`.`is_deleted` = 0
        LEFT JOIN 
            `cities` ON `cities`.`id` = `trips`.`destination_id`
        LEFT JOIN 
            `companies` ON `companies`.`id` = `trips`.`company_id`
        LEFT JOIN 
            `trips_users` ON `trips_users`.`trip_id` = `trips`.`id`
        LEFT JOIN 
            `users` ON `trips_users`.`user_id` = `users`.`id`
        WHERE 
            `trips`.`is_deleted` = 0 AND `trips`.`ending_date` < CURDATE()";

        if ($fromDate != -1) {
            $pastTripsSql .= " AND `trips`.`starting_date` >= '$fromDate'";
        }

        if ($toDate != -1) {
            $pastTripsSql .= " AND `trips`.`starting_date` <='$toDate'";
        }

        if (is_array($selectedCompanies) && !empty($selectedCompanies ) ) {
            $pastTripsSql .= " AND `trips`.`company_id` IN ( $selectedCompaniesString )";

        }
        

        if(is_array($selectedUsers) && !empty($selectedUsers)){
            $pastTripsSql .= " AND `trips_users`.`user_id` IN ( $usersIdsString ) ";
            $pastTripsSql .= "AND  `trips_users`.`is_traveler`=1";

            
        }


            $pastTripsSql .= " GROUP BY `trips`.`id`
                ORDER BY `trips`.`starting_date` DESC";

        $pastTripsquery = $this->db->query($pastTripsSql);
        $pastTrips = $pastTripsquery->getResult();

        


        return [$currentTrips,$pastTrips];
    }




}
