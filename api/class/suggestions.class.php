<?php
require_once "db.class.php";
require_once "function.class.php";
class sug{
	
	function __construct(){
		$this->db = new db;
	}

	function get(){
		$re = $this->db->get("*","suggestions");
		if(@$re){
			output($re);
		}else
			info("400");
	}
	
	function post(){
		@$title = $_POST['title'];
		@$content = $_POST['content'];
		@$_POST['advisor']==""?$advisor="":$advisor = $_POST['advisor'];
		if(!$title=="" && !$content==""){
			$this->db->post($title,$content,"suggestions",$advisor);
		}else
			info("400"); 
	}	

	function put(){
			@$id = $_POST['id'];
			@$title = $_POST['title'];
			@$content = $_POST['content'];
			if(!$title=="" && !$content==""){
						$this->db->put($id,$title,$content,"suggestions","");
			}else 
				info("404");	
	}

	function del(){
		session_start();
		if(@$_SESSION['authority']=="yes"){
			@$id = $_POST['id'];
			if(is_numeric($id)){
				$this->db->del("suggestions",$id);
			}else 
				info("400");
		}else
			info("400");
	}
}