<?php

namespace App\Controllers;

use App\Models\NoticeModel;
use App\Models\AuthModel;
use App\Models\TaskModel;
use App\Models\TaskCommentModel;
use App\Models\EmployeeModel;
use App\Models\MeetingModel;

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

		if($role!="admin"){
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


	public function my_tasks(){
		$session = session();
		$role = $session->get("role");
		$allowedRoles = array("marketing","sales","hr","design");
		if(!in_array($role,$allowedRoles)){
			return redirect()->to(site_url());
		}

		$taskModel = new TaskModel();

		$tasks = $taskModel->findAll();
		$tasks = array_reverse($tasks);

		$data = array("title"=>"My Tasks","tasks"=>$tasks);

		$this->page_loader("my_tasks",$data);
	}

	public function task_details($slug){
		$session = session();
		$role = $session->get("role");
		$allowedRoles = array("marketing","sales","hr","design","admin");		
		if(isset($role)&&in_array($role,$allowedRoles)){
			$taskModel = new TaskModel();
			$taskData = $taskModel->where("slug",$slug)->first();
			$employeeModel = new EmployeeModel();
			$employees = $employeeModel->find(json_decode($taskData['staff'],TRUE));
			$taskCommentModel = new TaskCommentModel();
			$taskComments = $taskCommentModel->where("task",$taskData["id"])->findAll();
			$data = array(
				'title' => $taskData['title'],
				"taskData" => $taskData,
				"employees" => $employees,
				"task_comments" => $taskComments
			);
			$this->page_loader("task_details",$data);
		}else {
			return redirect()->to(site_url());
		}
	}

	public function add_new_meeting($success="",$error=""){
		$session = session();
		$role = $session->get("role");
		if ($role!="admin") {
			return redirect()->to(site_url());
		}
		$employeeModel = new EmployeeModel();
		$employees = $employeeModel->where("role!=","admin")->findAll();
		$data = array(
			"title" => "Add Meeting",
			"success" => $success,
			"error" => $error,
			"employees" => $employees
		);
		$this->page_loader("add_meeting",$data);
	}

	public function meeting_page($public_id){
		$session = session();
		$role = $session->get("role");
		if (!isset($role)) {
			return redirect()->to(site_url());
		}
		$meetingModel = new MeetingModel();
		$meetingData = $meetingModel->where("public_id",$public_id)->first();
		$data = array(
			"title" => "Meeting",
			"meetingData" => $meetingData
		);
		$this->page_loader("meeting_page",$data);
	}

	public function manage_meetings($success="",$error=""){
		$session = session();
		$role = $session->get("role");
		if ($role!="admin") {
			return redirect()->to(site_url());
		}
		$meetingModel = new MeetingModel();
		$meetingsFetched = $meetingModel->findAll();
		$data = array(
			"title" => "Manage Meetings",
			"success" => $success,
			"error" => $error,
			"meetings" => $meetingsFetched
		);
		$this->page_loader("manage_meetings",$data);
	}

	public function test_meeting(){
		$session = session();
		$role = $session->get("role");
		if (!isset($role)) {
			return redirect()->to(site_url());
		} else {
			$data = array("title"=>"Test Meeting");	
			$this->page_loader("test_meeting",$data);
		}
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

	public function edit_task($id,$success="",$error=""){
		$session = session();
		$role = $session->get("role");
		if ($role!="admin") {
			return redirect()->to(site_url("/"));
		} 
		$taskModel = new TaskModel();
		$taskData = $taskModel->find($id);
		$employeeModel = new EmployeeModel();
		$employees = $employeeModel->where("role!=","admin")->findAll();
		$data = array("title"=>"Edit Task","taskData"=>$taskData,"success"=>$success,"error"=>$error,"employees"=>$employees);
		$this->page_loader("edit_task",$data);
	}

	public function task_file_delete_api(){
		$session = session();
		$role = $session->get("role");
		if ($role!="admin") {
			return 'unauthorized';
		} 
		$fileName = $this->request->getPost("fileName");
		$fileFolderPath = './assets/task_files/';
		$fileLink = $fileFolderPath.$fileName;
		$fileListJson = $this->request->getPost("fileListJson");
		unlink($fileLink);
		$fileList = json_decode($fileListJson,TRUE);
		$key = array_search($fileName,$fileList);
		unset($fileList[$key]);
		$fileListJson = json_encode($fileList);
		$taskModel = new TaskModel();
		$taskModel 
		->where('id', $this->request->getPost("task_id"))
		->set(['files' => $fileListJson])
		->update();
		return 'done';
	}

}
