<?php namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{

    protected $table = "users";

    protected $primaryKey = 'id';

    protected $allowedFields = ['fname', 'lname','email','role','password','code','status'];

    


}