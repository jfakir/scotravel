<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['fname', 'lname', 'email', 'country_code', 'phone_code', 'phone', 'password', 'account_type','access_type', 'is_subscribed', 'is_verified', 'is_deleted'];

    public function addUser($data)
    {
        return $this->insert($data);
    }

    public function updateUser($userID, $userData)
    {
        $this->update($userID, $userData);
        return true;
    }

    public function get($id)
    {
        $data = $this->where('id', $id)
            ->first();
        return $data;
    }

    public function getByMail($email)
    {
        $data = $this->where('email', $email)
            ->first();
        return $data;
    }

    public function login($email, $password)
    {
        $user = $this->where('email', $email)
            ->where('is_deleted', 0) // Check if user is not deleted
            ->where('is_verified', 1) // Check if user is verified
            ->first();
        if ($user && password_verify($password, $user['password'])) {
            return [
                'status' => true,
                'user' => $user
            ];
        } else {
            return ['status' => false];
        }
    }

    public function checkEmailExists($email)
    {
        $count = $this->where('email', $email)
            ->where('is_deleted', 0)
            ->countAllResults();

        return ($count > 0); // Return true if the count is greater than 0, indicating that at least one record exists
    }
    public function checkPhoneExists($phone, $country_code, $phone_code)
    {
        $count = $this->where('phone', str_replace(' ', '', $phone))
            ->where('country_code', $country_code)
            ->where('phone_code', $phone_code)
            ->where('is_deleted', 0)
            ->countAllResults();
        return ($count > 0);
    }


    public function getAllUsers()
    {
        
        return $this->where('is_deleted', 0)->orderBy('fname', 'ASC')->orderBy('lname', 'ASC')->findAll();

    }
}
