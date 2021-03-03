<?php namespace App\Models;

use CodeIgniter\Model;

class MeetingModel extends Model
{

    protected $table = "meetings";

    protected $primaryKey = 'id';

    protected $allowedFields = ['public_id', 'users_json', 'status','description'];

}