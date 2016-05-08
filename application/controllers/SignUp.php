<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class SignUp extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->model('register','',TRUE);
   $this->load->model('info','',TRUE);
 }
 
 function index()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');
 
   $this->form_validation->set_rules('username', 'Username', 'trim|required');
   $this->form_validation->set_rules('type', 'Type', 'trim|required');
   $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check');
 
   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.  User redirected to login page
     $this->load->view('signup_view');
   }
   else
   {
     //Go to private area
     redirect('login', 'refresh');
   }
 
 }
 
 function check($password)
 {
   $username = $this->input->post('username');
   $type = $this->input->post('type'); 
   

   
   $this->register->login($username, $password,$type);


   return TRUE;   
 }
}
?>