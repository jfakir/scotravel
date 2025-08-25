<?php 

namespace App\Models;

use CodeIgniter\Model;

class UserConfirmationsModel extends Model
{
    protected $table = 'user_confirmations';
    // protected $primaryKey = 'id';
    protected $allowedFields = ['id','userId', 'planId', 'confirmationNumber', 'isDeleted'];
    // public $timestamps = false;



}
