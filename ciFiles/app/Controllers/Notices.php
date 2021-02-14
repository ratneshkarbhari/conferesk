<?php namespace App\Controllers;

use App\Models\NoticeModel;
use App\Controllers\AppPageLoader;

class Notices extends BaseController
{

    public function create_notice_exe(){
        
        $session = session();

        $role = $session->get("role");

        if($role!='admin'){
            return redirect()->to(site_url());         
        }

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

        $created = $noticeModel->insert($objToInsert);

        if ($created) {
            $pageLoader->add_notice("New Notice Added","");
        } else {
            $pageLoader->add_notice("","Notice couldnt be created");
        }
        

    }

    public function delete_notice_exe(){
        
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

    public function update_notice_exe(){
        
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