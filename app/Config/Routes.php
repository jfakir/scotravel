<?php

use CodeIgniter\Router\RouteCollection;
// Start Authentication
$routes->get('/', 'Auth::login');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
$routes->get('/signup', 'Auth::signup');
$routes->post('/signup', 'Auth::signup');
$routes->get('/verifyAccount', 'Auth::verifyAccount');
$routes->post('/verifyAccount', 'Auth::verifyAccount');
$routes->post('/resetPassword', 'Auth::resetPassword');
$routes->get('/resetPassword', 'Auth::resetPassword');
$routes->post('/updatePassword', 'Auth::updatePassword');
// End Authentication

// Start Trip
$routes->get('trips/upcoming', 'Trip::upcoming');
$routes->get('trips/past', 'Trip::past');
$routes->get('trips/manage', 'Trip::manage');
$routes->post('trips/manage', 'Trip::manage');
$routes->post('trips/getTripDetails', 'Trip::getTripDetails');
$routes->get('trips/trip', 'Trip::view');
$routes->get('trips/editTrip', 'Trip::editTrip');
$routes->post('trips/deleteTrip', 'Trip::deleteTrip');
$routes->post('trips/uploadAttachment', 'Trip::uploadAttachment');
$routes->post('trips/updateAttachment', 'Trip::updateAttachment');
$routes->get('trips/downloadAttachment', 'Trip::downloadAttachment');
$routes->post('trips/filterTrips', 'Trip::filterTrips');
$routes->post('trips/deleteAttachment', 'Trip::deleteAttachment');
$routes->post('trips/dismissOrganizer', 'Trip::dismissOrganizer');
$routes->post('trips/makeOrganizer', 'Trip::makeOrganizer');



// End Trip

// Start User
$routes->get('users/profile', 'Users::profile');
$routes->post('users/updatemyprofile', 'Users::profile');
$routes->get('users/view', 'Users::view');
$routes->get('users/manage', 'Users::manage');
$routes->get('users/user', 'Users::user');
$routes->post('users/save', 'Users::save');
$routes->post('users/delete', 'Users::delete');
$routes->get('users/edit', 'Users::edit');
$routes->post('users/saveMileageAccount', 'Users::saveMileageAccount');
$routes->post('users/deleteMileageAccount', 'Users::deleteMileageAccount');

// End User

// Start Tenant
$routes->get('tenants/view', 'Tenants::view');
$routes->get('tenants/manage', 'Tenants::manage');
$routes->get('tenants/tenant', 'Tenants::tenant');
$routes->post('tenants/getAllCompanies', 'Tenants::getAllCompanies');
$routes->post('tenants/getTenantUsers', 'Tenants::getTenantUsers');
$routes->post('tenants/getTenantsUsers', 'Tenants::getTenantsUsers');
$routes->post('tenants/delete', 'Tenants::delete');
$routes->post('tenants/save', 'Tenants::save');
$routes->get('tenants/edit', 'Tenants::edit');

$routes->post('tenants/dismissAdmin', 'Tenants::dismissAdmin');
$routes->post('tenants/makeAdmin', 'Tenants::makeAdmin');
$routes->post('tenants/removeUser', 'Tenants::removeUser');
$routes->post('tenants/searchUsersForCompany', 'Tenants::searchUsersForCompany');
$routes->post('tenants/addUserToCompany', 'Tenants::addUserToCompany');



// End Tenant

// Start Cities
$routes->post('cities/getAllCities', 'Cities::getAllCities');
// End Cities

// Start Lodging
$routes->get('lodgings/view', 'Lodging::view');
$routes->get('lodgings/manage', 'Lodging::manage');
// End Lodging

// Start Restaurant
$routes->get('restaurants/view', 'Restaurant::view');
$routes->get('restaurants/manage', 'Restaurant::manage');
// End Restaurant

// Start CarRenting
$routes->get('carrentings/view', 'CarRenting::view');
$routes->get('carrentings/manage', 'CarRenting::manage');
// End CarRenting

// Start Transportation
$routes->get('transportations/view', 'Transportation::view');
$routes->get('transportations/manage', 'Transportation::manage');
// End Transportation

// Start Activity
$routes->get('activities/view', 'Activity::view');
$routes->get('activities/manage', 'Activity::manage');
// End Activity

// Start Flight
$routes->get('flights/view', 'Flight::view');
$routes->get('flights/manage', 'Flight::manage');
$routes->post('flights/save', 'Flight::save');
// End Flight

// Start Layover
$routes->get('layovers/manage', 'Layover::manage');
// End Layover

//plans functions start
$routes->post('plan/save', 'Plans::save');
$routes->get('plan/edit', 'Plans::edit');
$routes->post('plan/deletePlan', 'Plans::deletePlan');
$routes->post('plan/getPlanTravelers', 'Plans::getPlanTravelers');
$routes->post('plan/addAttachment', 'Plans::addAttachment');
$routes->post('plan/updateAttachment', 'Plans::updateAttachment');
$routes->get('plan/getAttachments', 'Plans::getAttachments');
$routes->post('plan/deleteAttachment', 'Plans::deleteAttachment');


//notifications  start
$routes->post('notification/save', 'Notification::save');
$routes->post('notification/delete', 'Notification::delete');


//notifications end

//////// mobile
$routes->post('mobile/signup', 'Mobile::signup');
$routes->post('mobile/login', 'Mobile::login');
$routes->post('mobile/updatename', 'Mobile::updatename');
$routes->post('mobile/changepassword', 'Mobile::changepassword');
$routes->post('mobile/changeUserPassword', 'Mobile::changeUserPassword');
$routes->post('mobile/forgetpassword', 'Mobile::forgetpassword');
$routes->post('mobile/deleteaccount', 'Mobile::deleteaccount');

$routes->post('mobile/getAllCities', 'Mobile::getAllCities');
$routes->post('mobile/getAllAirlines', 'Mobile::getAllAirlines');
$routes->post('mobile/getAllAirports', 'Mobile::getAllAirports');

//trips mobile
$routes->post('mobile/saveTrip', 'Mobile::saveTrip');
$routes->post('mobile/getTrips', 'Mobile::getTrips');
$routes->post('mobile/deleteTrip', 'Mobile::deleteTrip');
$routes->post('mobile/updateTrip', 'Mobile::updateTrip');
$routes->post('mobile/getTripAttachments', 'Mobile::getTripAttachments');
$routes->post('mobile/uploadTripAttachment', 'Mobile::uploadTripAttachment');
$routes->post('mobile/updateTripAttachment', 'Mobile::updateTripAttachment');
$routes->post('mobile/getTripCosts', 'Mobile::getTripCosts');



//plans
$routes->post('mobile/savePlan', 'Mobile::savePlan');
$routes->post('mobile/updatePlan', 'Mobile::updatePlan');
$routes->post('mobile/deletePlan', 'Mobile::deletePlan');
$routes->post('mobile/getTripPlansAndUsers', 'Mobile::getTripPlansAndUsers');
$routes->post('mobile/getTripUsers', 'Mobile::getTripUsers');
$routes->post('mobile/updateTripsUsers', 'Mobile::updateTripsUsers');
$routes->post('mobile/uploadPlanAttachment', 'Mobile::uploadPlanAttachment');
$routes->post('mobile/getPlanAttachments', 'Mobile::getPlanAttachments');
$routes->post('mobile/updatePlanAttachment', 'Mobile::updatePlanAttachment');
$routes->post('mobile/getPlanUsers', 'Mobile::getPlanUsers');
$routes->post('mobile/getByPlan', 'Mobile::getByPlan');



//companies
$routes->post('mobile/getAllCompanies', 'Mobile::getAllCompanies');
$routes->post('mobile/saveCompany', 'Mobile::saveCompany');
$routes->post('mobile/updateCompany', 'Mobile::updateCompany');
$routes->post('mobile/deleteCompany', 'Mobile::deleteCompany');
$routes->post('mobile/getCompanyUsers', 'Mobile::getCompanyUsers');
$routes->post('mobile/getAllUsersNotInCompany', 'Mobile::getAllUsersNotInCompany');
$routes->get('mobile/searchUsersForCompany', 'Mobile::searchUsersForCompany');
$routes->post('mobile/addUsersToCompany', 'Mobile::addUsersToCompany');
$routes->post('mobile/updateUserCompanyRecord', 'Mobile::updateUserCompanyRecord');
$routes->post('mobile/deleteUserCompanyRecord', 'Mobile::deleteUserCompanyRecord');
$routes->post('mobile/leaveCompany', 'Mobile::leaveCompany');


//users
$routes->post('mobile/getAllUsers', 'Mobile::getAllUsers');
$routes->post('mobile/saveUser', 'Mobile::saveUser');
$routes->post('mobile/updateUser', 'Mobile::updateUser');
$routes->post('mobile/deleteUser', 'Mobile::deleteUser');
$routes->post('mobile/getUserCompanies', 'Mobile::getUserCompanies');

$routes->post('mobile/updateUserCompanies', 'Mobile::updateUserCompanies');

//filters
$routes->post('mobile/getFiltersCompanyUsers', 'Mobile::getFiltersCompanyUsers');

//mileage
$routes->post('mobile/saveMileage', 'Mobile::saveMileage');
$routes->post('mobile/updateMileageAccount', 'Mobile::updateMileageAccount');
$routes->post('mobile/deleteMileageAccount', 'Mobile::deleteMileageAccount');
$routes->post('mobile/getUserMileageAccount', 'Mobile::getUserMileageAccount');


//reminders
$routes->post('mobile/saveReminder', 'Mobile::saveReminder');
$routes->post('mobile/updateReminder', 'Mobile::updateReminder');
$routes->post('mobile/deleteReminder', 'Mobile::deleteReminder');
$routes->post('mobile/getCompanyReminders', 'Mobile::getCompanyReminders');

//notifications
$routes->post('mobile/getAllNotifications', 'Mobile::getAllNotifications');
$routes->post('mobile/saveNotification', 'Mobile::saveNotification');
$routes->post('mobile/updateNotification', 'Mobile::updateNotification');
$routes->post('mobile/deleteNotification', 'Mobile::deleteNotification');


// Test
$routes->get('test', 'Test::test');