<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Angular extends CI_Controller {
 
    public function index()
    {
        $this->load->helper(array('url'));
        $this->load->view('home_view');
    }

    public function get_noti() {
        $this->load->model(array('info'));
        $data = $this->info->getOldrecords();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function get_newnoti() {
        $this->load->model(array('info'));
        $data = $this->info->getNewrecords();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function get_newnotiLawyer() {
        $this->load->model(array('info'));
        $data = $this->info->getNewrecordsLawyer();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    

    public function setQues($query,$tag){

        $this->load->model(array('info'));
        $this->info->setQuery($query,$tag); 
        $this->getAssign();       
    }

    public function getAssign(){
        $this->load->model(array('info'));
        $data=$this->info->getAssign();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function bid(){
        $this->load->model(array('info'));
        $data=$this->info->getBid();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function bids(){
        $this->load->model(array('info'));
        $data=$this->info->getBids();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function bidAcc($lawyer,$assign){
        $this->load->model(array('info'));
        $this->info->bidAccept($lawyer,$assign);
        $this->bid();    
    }

    public function setOld($value){
        $this->load->model(array('info'));
        $this->info->setRecord($value);  
    }

    
    public function tagset(){
        $this->load->model(array('info'));
        $data=$this->info->tags();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function tagdata($tags){
        $this->load->model(array('info'));
        $this->info->tagSet($tags);
    }

    public function getOpenre(){
        $this->load->model(array('info'));
        $data=$this->info->lawyerget();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function assignDone(){
        $this->load->model(array('info'));
        $data=$this->info->bidplaced();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function bidIn($assign,$value){
        $this->load->model(array('info'));
        $this->info->bidInsert($assign,$value);
    }

}
