<?php

namespace App\Models;

use CodeIgniter\Model;

class ForgetPasswordModel extends Model
{
    protected $table = 'forget_password';
    protected $allowedFields = ['user_id', 'token', 'requested_on', 'is_deleted'];

    public function addToken($data)
    {
        return $this->insert($data);
    }
    public function getToken($token)
    {
        $token = $this->where('token', $token)
            ->where('is_deleted', 0)
            ->first();
        return $token;
    }
    public function updateToken($tokenID, $data)
    {
        // Update user data
        $this->update($tokenID, $data);
        return true;
    }
}
