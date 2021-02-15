<?php namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{

    protected $table = "tasks";

    protected $primaryKey = 'id';

    protected $allowedFields = ['title', 'slug' ,'description','due_date','date','status','files','staff'];

    


}