<?php namespace App\Controllers;

class Authentication extends BaseController
{
	public function login()
	{

        $pageLoader = new \App\Controllers\PageLoader();

        
        $session = session();
		$role = $session->get("role");
		if(isset($role)){
			return redirect()->to(site_url()); 
		}
        
        $email_entered = $this->request->getPost("email");
        $password_entered = $this->request->getPost("password");
        $department = $this->request->getPost("role");
        
        if($email_entered==''||$password_entered==''){
            
            $pageLoader->login("Please Enter both email and password");

            exit();

        }

        $authModel = new \App\Models\AuthModel();

        $userData = $authModel->where("email",$email_entered)->where("role",$this->request->getPost("department"))->where("status","active")->first();

        if ($userData) {
            
            $password_correct = password_verify($password_entered,$userData["password"]);

            if ($password_correct) {
                
                $newdata = [
                    'id' => $userData['id'],
                    'first_name'  => $userData['fname'],
                    'last_name'  => $userData['lname'],
                    'email'     => $userData['email'],
                    'role' => $userData['role']
                ];

                $session = session();
            
                $session->set($newdata); 
                
                return redirect()->to(site_url()); 

            } else {

                $pageLoader->login("The Password is incorrect");

                exit();
                
            }
            
            
        } else {

            $pageLoader->login("The Email & Department is incorrect or your account is deactivated");

            exit();

        }
        

    }
    
    public function logout(){
        $session = session();
        $session->destroy();
        return redirect()->to(site_url()); 
    }

	//--------------------------------------------------------------------

}
