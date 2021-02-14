<?php

namespace App\Controllers;

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

	// Employees

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

	public function edit_employee($slug,$success="",$error=""){
		
		$session = session();

		$role = $session->get("role");

		if(!isset($role)){
			return redirect()->route('login');
		}

		$employeeModel = new \App\Models\EmployeeModel();

		$employee = $employeeModel->where("id",$id)->first();
		
		$data = array("title"=>"Edit Notice","success"=>$success,"error"=>$error,"notice"=>$notice);

		$this->page_loader("edit_notice",$data);
		
	}

}
