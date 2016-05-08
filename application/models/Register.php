<?php
Class Register extends CI_Model
{
 function login($username, $password,$type,$tags)
 {
   $data = array(
                   'username'=>$username,
                    'password'=>$password,              
                    'type'=>$type   
                    );
                    $this->db->insert('users',$data);  
   return true;
 }
}
?>