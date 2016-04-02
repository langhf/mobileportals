<?php
require_once "db.class.php";
require_once "function.class.php";
class notice{
	
	function __construct(){
		$this->db = new db;
	}

	function get(){
		$uri = uri_filter();
		//$query = explode("=", $uri['query']);
		switch(@$uri['query']['id']){
			case '1':
				$re = $this->db->get("id,title","notice");
				break;
			case '2':
				$re = $this->db->get("*","notice");
				@$id = $_POST['id'];
				//@$tag = $_POST['tag'];
				$this->db->put($id,'','',"notice",array("","1"));
				ob_clean();
				break;
			default:
				exit(info("404"));
		}
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
			@$_POST['tag'] == ""?$tag = "all":$tag = $_POST['tag'];
			if(!$title=="" && !$content==""){
				$this->db->post($title,$content,"notice",$tag);
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
			@$_POST['tag'] == ""?$tag = "all":$tag = $_POST['tag'];
			if(!$title=="" && !$content==""){
						$this->db->put($id,$title,$content,"notice",array($tag,""));
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
				$this->db->del("notice",$id);
			}else 
				info("400");
		}else
			info("400");
	}
}