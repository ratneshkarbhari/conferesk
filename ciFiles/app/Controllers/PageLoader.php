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

}
