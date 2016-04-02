<?php
require_once "db.class.php";
require_once "function.class.php";
class lessons{
	
	function __construct(){
		$this->db = new db;
	}

	function get(){
		$re = $this->db->get("*","lessons");
		if(@$re){
			output($re);
		}else
			info("400");
	}
	
	function post(){
		session_start();
		if(@$_SESSION['lauthority']=="yes"){
			@$title = $_POST['title'];
			@$content = $_POST['content'];
			if(!$title=="" && !$content==""){
				$this->db->post($title,$content,"lessons","");
			}else 
				info("404");
		}else
			info("400");
	}

	function put(){
		session_start();
		//echo $_SESSION['authority'];
		if(@$_SESSION['lauthority']=="yes"){
			@$id = $_POST['id'];
			@$title = $_POST['title'];
			@$content = $_POST['content'];
			if(!$title=="" && !$content==""){
						$this->db->put($id,$title,$content,"lessons","");
			}else 
				info("404");	
		}else 
			info("400");
	}

	function del(){
		session_start();
		if(@$_SESSION['lauthority']=="yes"){
			@$id = $_POST['id'];
			if(is_numeric($id)){
				$this->db->del("lessons",$id);
			}else 
				info("400");
		}else
			info("400");
	}
}	