<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Sign extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
 }
 
 function index()
 {
   $this->load->helper(array('form'));
   $this->load->view('header');
   $this->load->view('signup_view');
 }
 
}
 
?>