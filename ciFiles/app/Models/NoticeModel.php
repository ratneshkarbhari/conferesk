<?php namespace App\Models;

use CodeIgniter\Model;

class NoticeModel extends Model
{

    protected $table = "notices";

    protected $primaryKey = 'id';

    protected $allowedFields = ['title', 'slug' ,'body','date','department','link'];

    


}