<?php

namespace App\Controllers;

use App\Models\NoticeModel;
use App\Models\AuthModel;
use App\Models\TaskModel;
use App\Models\EmployeeModel;

class PageLoader extends BaseController
{

	private function page_loader($view,$data){

		echo view("templates/header",$data);
		echo view("pages/".$view,$data);
		echo view("templates/footer",$data);

	}

	public function dashboard()
	{

		$session = session();

		$role = $session->get("role");

		if(!isset($role)){
			return redirect()->route('login');
		}

		$data = array("title"=>"Dashboard");
		
		$this->page_loader("dashboard",$data);

	}

	public function login($error = "")
	{

		$session = session();

		$role = $session->get("role");

		if(isset($role)){
			return redirect()->route('/');
		}

		$data = array("title"=>"Login","error"=>$error);
		
		$this->page_loader("login",$data);

	}

	public function notices_mgt($success="",$error=""){
		
		$session = session();

		$role = $session->get("role");

		if(!isset($role)){
			return redirect()->route('login');
		}		

        $noticeModel = new \App\Models\NoticeModel();

		$data = array("title"=>"Manage Notices","success"=>$success,"error"=>$error,"notices"=>$noticeModel->findAll());


		$this->page_loader("manage_notices",$data);

	}

	public function add_notice($success="",$error=""){
		
		$session = session();

		$role = $session->get("role");

		if(!isset($role)){
			return redirect()->route('login');
		}
		
		$data = array("title"=>"Add Notice","success"=>$success,"error"=>$error);

		$this->page_loader("add_notice",$data);
		
	}

	public function edit_notice($slug,$success="",$error=""){
		
		$session = session();

		$role = $session->get("role");

		if(!isset($role)){
			return redirect()->route('login');
		}

		$noticeModel = new \App\Models\NoticeModel();

		$notice = $noticeModel->where("slug",$slug)->first();
		
		$data = array("title"=>"Edit Notice","success"=>$success,"error"=>$error,"notice"=>$notice);

		$this->page_loader("edit_notice",$data);
		
	}

	// Employees Mgt.

	public function employee_mgt($success="",$error=""){
		
		$session = session();

		$role = $session->get("role");

		if(!isset($role)){
			return redirect()->route('login');
		}		

        $authModel = new \App\Models\AuthModel();

		$data = array("title"=>"Manage Employees","success"=>$success,"error"=>$error,"employees"=>$authModel->where("role!=","admin")->findAll());


		$this->page_loader("manage_employees",$data);

	}

	public function add_employee($success="",$error=""){
		
		$session = session();

		$role = $session->get("role");

		if(!isset($role)){
			return redirect()->route('login');
		}
		
		$data = array("title"=>"Add Employee","success"=>$success,"error"=>$error);

		$this->page_loader("add_employee",$data);
			
	}

	public function edit_employee($code,$success="",$error=""){
		
		$session = session();

		$role = $session->get("role");

		if(!isset($role)){
			return redirect()->route('login');
		}


		$employeeModel = new \App\Models\EmployeeModel();

		$employee = $employeeModel->where("code",$code)->first();
	
		$data = array("title"=>"Edit Employee","success"=>$success,"error"=>$error,"employee"=>$employee);

		$this->page_loader("edit_employee",$data);
		
	}

	// Employee PAges

	public function department_notices(){
		
		$session = session();
		$role = $session->get("role");
		$allowedRoles = array("marketing","sales","hr","design");
		if(!in_array($role,$allowedRoles)){
			return redirect()->to(site_url());
		}

		$noticeModel = new NoticeModel();

		$notices = $noticeModel->where("department",$_SESSION["role"])->orwhere("department","general")->findAll();

		$data = array("title"=>"My Notices","notices"=>$notices);

		$this->page_loader("my_notices",$data);

	}

	public function edit_profile($success="",$error=""){
		$session = session();
		$role = $session->get("role");
		$allowedRoles = array("marketing","sales","hr","design","admin");		
		if(isset($role)&&in_array($role,$allowedRoles)){
			$authModel = new AuthModel();
			$userData = $authModel->find($_SESSION["id"]);
			$data = array(
				"title" => "Edit Profile",
				"success" => $success,
				"error" => $error,
				"employee" => $userData
			);
			$this->page_loader("edit_profile",$data);
		}else {
			return redirect()->to(site_url());
		}
	}

	public function tasks_mgt($success="",$error=""){
		$session = session();
		$role = $session->get("role");
		if ($role!="admin") {
			return redirect()->to(site_url("/"));
		} 
		$taskModel = new TaskModel();
		$tasks = array();
		$tasks = $taskModel->findAll();
		$data = array("title"=>"Manage Tasks","success"=>$success,"error"=>$error,"tasks"=>$tasks);
		$this->page_loader("tasks_mgt",$data);
	}

	public function add_task($success="",$error=""){
		$session = session();
		$role = $session->get("role");
		if ($role!="admin") {
			return redirect()->to(site_url("/"));
		} 
		$employeeModel = new EmployeeModel();
		$employees = $employeeModel->where("role!=","admin")->findAll();
		$data = array("title"=>"Add Task","success"=>$success,"error"=>$error,"employees"=>$employees);
		$this->page_loader("add_task",$data);
	}

}
