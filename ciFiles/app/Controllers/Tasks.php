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

        if($this->request->getPost("slug")==""){
            $slug = $this->request->getPost("title");
        }else {
            $slug = $this->request->getPost("slug");
        }

        $taskModel = new TaskModel();

        $slugExists = $taskModel->where("slug",$slug)->first();

        $pageLoader = new PageLoader();

        if ($slugExists) {
            
            $pageLoader->add_task("","Slug already exists");
            
        } else {
        
            $users = $this->request->getPost("users");


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
                "slug" => $slug,
                "description" => $this->request->getPost("description"),
                "link" => $this->request->getPost("link"),
                "due_date" => $this->request->getPost("date"),
                "date" => date("d-m-Y"),
                "status" => "created",
                "files" => $taskFilesJson,
                "staff" => $usersjSON
            );


            $created = $taskModel->insert($objToInsert);

            if ($created) {
                $pageLoader->add_task("Task Added successfully","");
            } else {
                $pageLoader->add_task("","Task not Added");
            }
        
        }
        
    }

    public function update_task_exe(){
        
        $session = session();
        $role = $session->get("role");

        if ($role!="admin") {
            return redirect()->to(site_url());         
        }

        if($this->request->getPost("slug")==""){
            $slug = $this->request->getPost("title");
        }else {
            $slug = $this->request->getPost("slug");
        }

        $taskModel = new TaskModel();


        $slugExists = $taskModel->where("slug",$slug)->first();

        $pageLoader = new PageLoader();

        $prevTaskData = $taskModel->find($this->request->getPost("id"));

        if ($slugExists&&($slugExists["id"]!=$prevTaskData["id"])) {
            
            $pageLoader->edit_task($prevTaskData["id"],"","Slug already exists");
            
        } else {
        
            $users = $this->request->getPost("users");

            $taskFiles = json_decode($prevTaskData["files"],TRUE);

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
                "slug" => $slug,
                "description" => $this->request->getPost("description"),
                "link" => $this->request->getPost("link"),
                "due_date" => $this->request->getPost("date"),
                "date" => date("d-m-Y"),
                "status" => "created",
                "files" => $taskFilesJson,
                "staff" => $usersjSON
            );


            $updated = $taskModel->update($prevTaskData['id'],$objToInsert);

            if ($updated) {
                $pageLoader->edit_task($prevTaskData["id"],"Task Updated successfully","");
            } else {
                $pageLoader->edit_task($prevTaskData["id"],"","Task not Updated");
            }
        
        }
        
    }

    public function delete_task_exe(){

        $session = session();
        $role = $session->get("role");

        if ($role!="admin") {
            return redirect()->to(site_url());         
        }

        $taskModel = new TaskModel();

        $id = $this->request->getPost("id");

        $deleted = $taskModel->delete($id);
        
        $pageLoader = new PageLoader();

        if ($deleted) {
            $pageLoader->tasks_mgt("Task Deleted Successfully","");        
        } else {
            $pageLoader->tasks_mgt("","Task not deleted");        
        }
        
    }

}