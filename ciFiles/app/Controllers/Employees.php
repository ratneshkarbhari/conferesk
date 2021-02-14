<?php namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Controllers\PageLoader;

class Employees extends BaseController
{

    public function create_employee_exe(){
        
        $session = session();

        $role = $session->get("role");

        if($role!='admin'){
            return redirect()->to(site_url());         
        }

        $pageLoader = new PageLoader();
        $employeeModel = new EmployeeModel();

        $email = $this->request->getPost("email");
        $role = $this->request->getPost("department");

        $employeeExists = $employeeModel->where("email",$email)->where("role",$role)->first();
        
        if ($employeeExists) {
            
            $pageLoader->add_employee("","An Employee exists with the email you provided in the same department");
            
        } else {

            $objToInsert = array(
                "fname" => $this->request->getPost("fname"),
                "lname" => $this->request->getPost("lname"),
                "email" => $email,
                "password" => password_hash($this->request->getPost("password"),PASSWORD_DEFAULT),
                "role" => $role,
                "code" => uniqid(),
                "status" => "active"
            );
    
            $created = $employeeModel->insert($objToInsert);
    
            if ($created) {
                $pageLoader->add_employee("New Employee Added","");
            } else {
                $pageLoader->add_employee("","Employee couldnt be created");
            }
     
            
        }
        

        

    }

    public function delete_employee_exe(){
        
        $session = session();

        $role = $session->get("role");

        if($role!='admin'){
            return redirect()->to(site_url());         
        }

        $id = $this->request->getPost("id");

        $noticeModel = new NoticeModel();

        $deleted = $noticeModel->delete($id);

        $pageLoader = new PageLoader();

        if ($deleted) {
            
            $pageLoader->notices_mgt("Notice Deleted Successfully","");

        } else {

            $pageLoader->notices_mgt("","Notice Not deleted");
            
        }
        

    }

    public function update_employee_exe(){
        
        $session = session();

        $role = $session->get("role");

        if($role!='admin'){
            return redirect()->to(site_url());         
        }

        $id = $this->request->getPost("id");

        $pageLoader = new PageLoader();
        $noticeModel = new NoticeModel();

        if($this->request->getPost("slug")==''){
            $slug= url_title($this->request->getPost("title"),'-',TRUE);
        }else {
            $slug= url_title($this->request->getPost("slug"),'-',TRUE);
        }

        $objToInsert = array(
            "title" => $this->request->getPost("title"),
            "slug" => $slug,
            "date" => $this->request->getPost("date"),
            "body" => $this->request->getPost("body"),
            "department" => $this->request->getPost("department"),
            "link" => $this->request->getPost("link")
        );

        $updated = $noticeModel->update($id,$objToInsert);

        if ($updated) {
            $pageLoader->edit_notice($slug,"Notice Updated","");
        } else {
            $pageLoader->edit_notice($slug,"","Notice couldnt be updated");
        }
        

    }

}