<?php namespace App\Models;

use CodeIgniter\Model;

class TaskCommentModel extends Model
{

    protected $table = "task_comments";

    protected $primaryKey = 'id';

    protected $allowedFields = ['body','task','user'];

    


}