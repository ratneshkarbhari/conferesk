<?php namespace App\Controllers;

use App\Models\TaskModel;
use App\Controllers\PageLoader;

class Tasks extends BaseController
{

    public function create_task_exe(){
        
        $session = session();
        $role = $session->get("role");

        if ($role!="admin") {
            return redirect()->to(site_url());         
        }

        $users = $this->request->getPost("users");

        $pageLoader = new PageLoader();

        $taskFiles = array();


        $files = $this->request->getFilemULTIPLE('files');


        foreach ($files as $file) {

            if ($file->isValid()) {

                $fileRandomName = $file->getRandomName();

                $file->move('assets/task_files/', $fileRandomName);

                $taskFiles[] = $fileRandomName;
                
            }

        }

        $taskFilesJson = json_encode($taskFiles);

        $usersjSON = json_encode($users);


        $objToInsert = array(
            "title" => $this->request->getPost("title"),
            "slug" => url_title($this->request->getPost("slug"),"-",TRUE),
            "description" => $this->request->getPost("description"),
            "link" => $this->request->getPost("link"),
            "due_date" => $this->request->getPost("date"),
            "date" => date("d-m-Y"),
            "status" => "created",
            "files" => $taskFilesJson,
            "staff" => $usersjSON
        );

        $taskModel = new TaskModel();

        $created = $taskModel->insert($objToInsert);

        if ($created) {
            $pageLoader->add_task("Task Added successfully","");
        } else {
            $pageLoader->add_task("","Task not Added");
        }
        
    }

}