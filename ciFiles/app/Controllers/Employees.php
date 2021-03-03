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

    public function deactivate_employee_exe(){
        
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

        $code = $this->request->getPost("code");
        $id = $this->request->getPost("id");

        $pageLoader = new PageLoader();
        $employeeModel = new EmployeeModel();

        $email = $this->request->getPost("email");
        $role = $this->request->getPost("department");

        $employeeExists = $employeeModel->where("email",$email)->where("role",$role)->first();
        
        if ($employeeExists&&$employeeExists["id"]!=$id) {
            
            $pageLoader->edit_employee($code,"","An Employee exists with the email you provided in the same department");
            
        } else {

            $prevEmployeeData = $employeeModel->find($id);

            if($this->request->getPost("password")!=''){
                $pwdToUpdate = password_hash($this->request->getPost("password"),PASSWORD_DEFAULT);
            }else {
                $pwdToUpdate = $prevEmployeeData["password"];
            }

            $objToInsert = array(
                "fname" => $this->request->getPost("fname"),
                "lname" => $this->request->getPost("lname"),
                "email" => $email,
                "password" => $pwdToUpdate,
                "role" => $this->request->getPost("department"),
                "code" => $prevEmployeeData["code"],
                "status" => $this->request->getPost("status")
            );

            $updated = $employeeModel->update($id,$objToInsert);

            if ($updated) {
                $pageLoader->edit_employee($code,"Employee updated","");
            } else {
                $pageLoader->edit_employee($code,"","Employee couldnt be updated");
            }
        }

    }

    public function update_profile_exe(){
        
        $session = session();

        $role = $session->get("role");

        if(!isset($role)){
            return redirect()->to(site_url());         
        }

        $code = $this->request->getPost("code");
        $id = $this->request->getPost("id");

        $pageLoader = new PageLoader();
        $employeeModel = new EmployeeModel();

        $email = $this->request->getPost("email");
        $role = $this->request->getPost("department");

        $employeeExists = $employeeModel->where("email",$email)->where("role",$role)->first();
        
        if ($employeeExists&&$employeeExists["id"]!=$id) {
            
            $pageLoader->edit_profile($code,"","An Employee exists with the email you provided in the same department");
            
        } else {

            $prevEmployeeData = $employeeModel->find($id);

            if($this->request->getPost("password")!=''){
                $pwdToUpdate = password_hash($this->request->getPost("password"),PASSWORD_DEFAULT);
            }else {
                $pwdToUpdate = $prevEmployeeData["password"];
            }

            $objToInsert = array(
                "id" => $id,
                "fname" => $this->request->getPost("fname"),
                "lname" => $this->request->getPost("lname"),
                "email" => $email,
                "password" => $pwdToUpdate,
                "role" => $this->request->getPost("department"),
                "code" => $prevEmployeeData["code"],
                "status" => $this->request->getPost("status")
            );

            $updated = $employeeModel->update($id,$objToInsert);

            if ($updated) {
                $session->set($objToInsert);
                $pageLoader->edit_profile("Profile updated","");
            } else {
                $pageLoader->edit_profile("","Profile couldnt be updated");
            }
        }

    }


}