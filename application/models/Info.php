<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Info extends CI_Model {
    
    protected $table_name;
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table_name = 'tbl_users';
    }

    public function getOldrecords() {

       $session_data = $this->session->userdata('logged_in');
       $id=$session_data['id'];
       $this -> db -> select('notiCount as a' );
	   $this -> db -> from('users');	 
	   $this -> db -> where('id',$id);
	   $query = $this -> db -> get();

	 	
	   return $query->result();
	   
    }

     public function getNewrecords() {

       $session_data = $this->session->userdata('logged_in');
       $id=$session_data['id'];
       $this -> db -> select('count(assign.userid) as b');
        $this -> db -> from('bids');
       $this -> db -> where('assign.userid',$id);
        $this -> db -> join('assign','bids.assignid=assign.id');
        $this->db->order_by("assignid", "desc");
        $query=$this-> db ->get();
        return $query->result();
	 	
	   return $query->result();
	   
    }
    public function getNewrecordsLawyer() {

       $session_data = $this->session->userdata('logged_in');
       $id=$session_data['id'];
       $this -> db -> select('count(assign.final) as b');
        $this -> db -> from('lawyer');
        $this-> db ->where('lawyer.lawyerid',$id);
        $this -> db -> where('assign.final>',0);
        $this -> db -> join('assign','lawyer.tag=assign.tag');
        $this-> db ->order_by("assign.id", "desc");    
        $query=$this-> db ->get();
        return $query->result();
       
    }

    public function setQuery($query,$tag){

    	$session_data = $this->session->userdata('logged_in');
    	$id=$session_data['id'];
        $data = array(
                   'userid'=>$id,
                    'ques'=>$query,              
                    'tag'=>$tag,
                    'final'=>-1      
                    );
       	$this->db->insert('assign',$data);  
   		return true;
    }

    public function getAssign(){

    	$session_data = $this->session->userdata('logged_in');
    	$id=$session_data['id'];
    	$this -> db -> select('*');
    	$this -> db -> from('assign');
    	$this -> db -> where('userid',$id);
    	$this->db->order_by("id", "desc");
    	$query=$this-> db ->get();
    	return $query->result();
    }

    public function getBid(){

    	$session_data = $this->session->userdata('logged_in');
    	$id=$session_data['id'];
    	$this -> db -> select('assign.final,assign.ques,bids.lawyerid,bids.bid,assign.id,bids.date');
    	$this -> db -> from('bids');
        $this -> db -> where('assign.userid',$id);
    	$this -> db -> join('assign','bids.assignid=assign.id');
    	$this->db->order_by("assignid", "desc");
    	$query=$this-> db ->get();
    	return $query->result();
    }

    public function bidAccept($lawyer,$assign){
    	$session_data = $this->session->userdata('logged_in');
    	$id=$session_data['id'];
    	$data = array(
                   'final'=>$lawyer
                    );
    	$this->db->where('userid',$id);
    	$this->db->where('id',$assign);
		$this->db->update('assign',$data);
		return true;
    }

    public function setRecord($value)
    {
    	$session_data = $this->session->userdata('logged_in');
    	$id=$session_data['id'];
    	$data = array(
                   'notiCount'=>$value
                    );
    	$this->db->where('id',$id);
		$this->db->update('users',$data);
		return true;
    }

    public function tags()
    {
        $session_data = $this->session->userdata('logged_in');
        $id=$session_data['id'];
        $this -> db -> select('*' );
        $this -> db -> from('lawyer');     
        $this -> db -> where('lawyerid',$id);
        $query = $this -> db -> get();
        if($query -> num_rows() >0)
       {
         return true;
       }
       else
       {
         return false;
       }
    }

    public function tagSet($tags){
        $session_data = $this->session->userdata('logged_in');
        $id=$session_data['id'];
        $data=array(
                    'lawyerid'=>$id,
                    'tag'=>$tags
            );
         $this->db->insert('lawyer',$data);  
        
    }

    public function lawyerget(){

        $session_data = $this->session->userdata('logged_in');
        $id=$session_data['id'];
        $this -> db -> select('assign.final,assign.ques,lawyer.tag,assign.id,assign.userid');
        $this -> db -> from('lawyer');
        $this-> db ->where('lawyer.lawyerid',$id);
        $this -> db -> join('assign','lawyer.tag=assign.tag');
        $this-> db ->order_by("assign.id", "desc");    
        $query=$this-> db ->get();
        return $query->result();
    }

    public function bidPlaced(){
        $session_data = $this->session->userdata('logged_in');
        $id=$session_data['id'];
        $this -> db -> select('*' );
        $this -> db -> from('bids');     
        $this -> db -> where('lawyerid',$id);
        $query=$this-> db ->get();
        return $query->result();
    }

    public function bidInsert($assign,$value){
        $session_data = $this->session->userdata('logged_in');
        $id=$session_data['id'];
        $data=array(
                    'assignid'=>$assign,
                    'bid'=>$value,
                    'lawyerid'=>$id
            );
         $this->db->insert('bids',$data); 
    }

    public function getBids(){

        $session_data = $this->session->userdata('logged_in');
        $id=$session_data['id'];
        $this -> db -> select('assign.final,assign.ques,bids.lawyerid,bids.bid,assign.id,bids.date,assign.userid');
        $this -> db -> from('bids');
        $this-> db ->where('bids.lawyerid',$id);
        $this -> db -> join('assign','bids.assignid=assign.id');
        $this->db->order_by("assignid", "desc");
        $query=$this-> db ->get();
        return $query->result();
    }
}
