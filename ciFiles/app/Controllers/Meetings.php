<?php namespace App\Controllers;

use App\Models\MeetingModel;
use App\Controllers\PageLoader;

class Meetings extends BaseController
{
    public function create(){
        
        $session = session();
        $role = $session->get("role");

        if($role!='admin'){
            return redirect()->to(site_url());         
        }

        $public_id = $this->request->getPost('public_id');
        $users = $this->request->getPost("users");
        $description = $this->request->getPost("description");

        $meetingObj = array(
            'public_id' => $public_id,
            'users_json' => json_encode($users),
            'status' => 'created',
            'description' => $description 
        );

        $meetingModel = new MeetingModel();

        $created = $meetingModel->insert($meetingObj);

        return redirect()->to(site_url("manage-meetings"));

    }
}