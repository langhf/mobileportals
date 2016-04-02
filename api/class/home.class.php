<?php
require_once "db.class.php";
require_once "function.class.php";
class home{
	
	function __construct(){
		$this->db = new db;
	}

	function get(){
		$re = $this->db->get("*","home");
		if(@$re){
			output($re);
		}else
			info("400");
	}
	
	function post(){
		session_start();
		if(@$_SESSION['authority']=="yes"){
			@$title = $_POST['title'];
			@$content = $_POST['content'];
			if(!$title=="" && !$content==""){
				$this->db->post($title,$content,"home","");
			}else 
				info("404");
		}else
			info("400");
	}

	function put(){
		session_start();
		//echo $_SESSION['authority'];
		if(@$_SESSION['authority']=="yes"){
			@$id = $_POST['id'];
			@$title = $_POST['title'];
			@$content = $_POST['content'];
			if(!$title=="" && !$content==""){
						$this->db->put($id,$title,$content,"home","");
			}else 
				info("404");	
		}else 
			info("400");
	}

	function del(){
		session_start();
		if(@$_SESSION['authority']=="yes"){
			@$id = $_POST['id'];
			if(is_numeric($id)){
				$this->db->del("home",$id);
			}else 
				info("400");
		}else
			info("400");
	}
}